<?php

namespace App\Exports;

use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Risk;
use App\Models\RiskLevel;
use App\Models\ScoringMethod;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class RisksExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $risks = Risk::with(['riskScoring', 'source', 'submittedBy:id,name'])->get()->map(function ($risk) {
            $data = [];
            $data['calculated_risk'] = $risk->riskScoring->calculated_risk;

            $data['residual_risk'] = "0.0";
            if ($data['calculated_risk'] && $data['calculated_risk'] != "0.0")
                $data['residual_risk'] = get_residual_risk($risk->id);

            $data['riskCatalogs'] = $risk->riskCatalogs();
            $data['threatCatalogs'] = $risk->threatCatalog();

            // dd($risk->toArray());
            return (object)[
                'responsive_id' =>  $risk->id,
                'status' => $risk->status,
                'subject' => $risk->subject,
                'calculated_risk' => ($data['calculated_risk']) . ' (' . ($this->getRiskValueData($data['calculated_risk'])['name']) . ')',
                'residual_risk' => ($data['residual_risk']) . ' (' . ($this->getRiskValueData($data['residual_risk'])['name']) . ')',


                // 'mitigation_planned' => 'No',
                // 'management_review' => 'No',
                'likelihood' => Likelihood::where('id', $risk->riskScoring->CLASSIC_likelihood)->first()->name ?? '',
                'impact' => Impact::where('id', $risk->riskScoring->CLASSIC_impact)->first()->name ?? '',
                'risk_scoring_method' => ScoringMethod::where('id', $risk->riskScoring->scoring_method)->first()->name ?? '',
                'riskCatalogs' => $risk->riskCatalogs(),
                'threatCatalogs' => $risk->threatCatalog(),
                'source' => $risk->source->name ?? '',
                'submitted_by' => $risk->submittedBy->name,
                'created_at' => $risk->created_at->format('Y-m-d H:i')
            ];
        });

        return $risks;
    }

    /**
     * @var Risk $job
     */
    public function map($risk): array
    {
        $riskCatalogsNames = array_map(function ($riskCatalog) {
            return $riskCatalog['name'];
        }, $risk->riskCatalogs);

        if (count($riskCatalogsNames))
            // $riskCatalogsNames =  "(" . implode('), (', $riskCatalogsNames) . ")";
            $riskCatalogsNames =  implode(', ', $riskCatalogsNames);
        else
            $riskCatalogsNames = '';

        $threatCatalogsNames = array_map(function ($threatCatalog) {
            return $threatCatalog['name'];
        }, $risk->threatCatalogs);

        if (count($threatCatalogsNames))
            // $threatCatalogsNames =  "(" . implode('), (', $threatCatalogsNames) . ")";
            $threatCatalogsNames =  implode(', ', $threatCatalogsNames);
        else
            $threatCatalogsNames = '';

        return [
            $this->counter++,
            $risk->status,
            $risk->subject,
            $risk->calculated_risk,
            $risk->residual_risk,
            $risk->risk_scoring_method,
            $risk->likelihood,
            $risk->impact,
            $riskCatalogsNames,
            $threatCatalogsNames,
            $risk->source,
            $risk->submitted_by,
            $risk->created_at,
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Status'),
            __('locale.Subject'),
            __('locale.InherentRisk'),
            __('locale.ResidualRisk'),
            __('locale.RiskScoringMethod'),
            __('locale.CurrentLikelihood'),
            __('locale.CurrentImpact'),
            __('locale.RiskMapping'),
            __('locale.ThreatMapping'),
            __('locale.ImpactScope'),
            __('locale.SubmittedBy'),
            __('locale.SubmissionDate'),
        ];
    }

    /**
     * Return a risk level data.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getRiskValueData($calculated_risk)
    {
        $riskLevel = RiskLevel::orderBy('value', 'desc')->where('value', '<=', $calculated_risk)->first();
        $data = [];

        if ($riskLevel->display_name != '')
            $data['name'] = $riskLevel->display_name;
        else if ($riskLevel->name != '')
            $data['name'] = $riskLevel->name;
        else
            $data['name'] = "Insignificant";

        if (!$riskLevel)
            $data['color'] = "white";
        else
            $data['color'] = $riskLevel['color'];

        return $data;
    }
}
