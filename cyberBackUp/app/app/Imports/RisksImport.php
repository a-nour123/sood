<?php

namespace App\Imports;

use App\Models\Risk;
use App\Models\RiskScoringMethod;
use App\Models\Likelihood;
use App\Models\Impact;
use App\Models\RiskCatalog;
use App\Models\ScoringMethod;
use App\Models\Source;
use App\Models\ThreatCatalog;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RisksImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation
{
    use Importable;

    /**
     * Mapping of columns from the import file to database columns.
     *
     * @var array
     */
    public $columnsMapping;

    /**
     * Constructor to set the columns mapping.
     *
     * @param array $columnsMapping
     */
    public function __construct($columnsMapping)
    {
        $this->columnsMapping = $columnsMapping;
    }

    /**
     * Collection method to process the rows of the imported Excel file.
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Ensure the key exists before accessing it
            $riskScoringMethod = isset($this->columnsMapping['risk_scoring_method_id']) && isset($row[$this->columnsMapping['risk_scoring_method_id']])
                ? ScoringMethod::where('name', $row[$this->columnsMapping['risk_scoring_method_id']])->first()
                : null;

            $likelihood = isset($this->columnsMapping['current_likelihood_id']) && isset($row[$this->columnsMapping['current_likelihood_id']])
                ? Likelihood::where('name', $row[$this->columnsMapping['current_likelihood_id']])->first()
                : null;

            $impact = isset($this->columnsMapping['current_impact_id']) && isset($row[$this->columnsMapping['current_impact_id']])
                ? Impact::where('name', $row[$this->columnsMapping['current_impact_id']])->first()
                : null;

            // Check if risk_catalog_mapping_id exists in the row
            $riskCatalogNames = isset($this->columnsMapping['risk_catalog_mapping_id']) && isset($row[$this->columnsMapping['risk_catalog_mapping_id']])
                ? explode(',', $row[$this->columnsMapping['risk_catalog_mapping_id']])  // Split the comma-separated names
                : [];

            // Retrieve RiskCatalog records using LIKE for each name
            $riskCatalogIds = RiskCatalog::where(function ($query) use ($riskCatalogNames) {
                foreach ($riskCatalogNames as $name) {
                    $query->orWhere('name', 'LIKE', '%' . $name . '%');  // Use LIKE to match each name
                }
            })->pluck('id')->toArray();

            $threatCatalog = isset($this->columnsMapping['threat_catalog_mapping_id']) && isset($row[$this->columnsMapping['threat_catalog_mapping_id']])
                ? ThreatCatalog::where('name', $row[$this->columnsMapping['threat_catalog_mapping_id']])->first()
                : null;

            $impactScope = isset($this->columnsMapping['risk_source_id']) && isset($row[$this->columnsMapping['risk_source_id']])
                ? Source::where('name', $row[$this->columnsMapping['risk_source_id']])->first()
                : null;
            // Get user or fallback to current authenticated user
            $submittedBy = isset($this->columnsMapping['submitted_by']) && isset($row[$this->columnsMapping['submitted_by']])
                ? optional(User::where('name', $row[$this->columnsMapping['submitted_by']])->first())->id
                : null;

            if ($submittedBy == null) {
                $submittedBy = auth()->user()->id;
            }

            // Prepare the request data
            $requestData = [
                'subject' => $row[$this->columnsMapping['subject']] ?? null,
                'status' => $row[$this->columnsMapping['status']] ?? 'New',
                'risk_scoring_method_id' => $riskScoringMethod ? $riskScoringMethod->id : null,
                'current_likelihood_id' => $likelihood ? $likelihood->id : null,
                'current_impact_id' => $impact ? $impact->id : null,
                'risk_source_id' => $impactScope ? $impactScope->id : null,
                'submitted_by' => $submittedBy,
                'submission_date' => $row[$this->columnsMapping['submission_date']] ?? now(),
            ];

            // Add risk_catalog_mapping_id if not null
            if ($riskCatalogIds) {
                $requestData['risk_catalog_mapping_id'] = $riskCatalogIds;
            }

            // Add threat_catalog_mapping_id if not null
            if ($threatCatalog) {
                $requestData['threat_catalog_mapping_id'] = $threatCatalog->id;
            }

            // Create the request object
            $request = new \Illuminate\Http\Request();
            $request->replace($requestData);

            // Call the store method in the controller
            app('App\Http\Controllers\Admin\risk_management\RiskManagementController')->store($request);
        }
    }


    /**
     * Validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        $subject = !empty($this->columnsMapping['subject']) ? $this->columnsMapping['subject'] : '(subject)';
        return [
            $subject => ['required'],
            'status' => ['nullable'],
            'risk_scoring_method_id' => ['nullable'],
            'current_likelihood_id' => ['nullable'],
            'current_impact_id' => ['nullable'],
            'risk_catalog_mapping_id' => ['nullable'],
            'threat_catalog_mapping_id' => ['nullable'],
            'submitted_by' => ['nullable'],
            'submission_date' => ['nullable', 'date'],
        ];
    }
}
