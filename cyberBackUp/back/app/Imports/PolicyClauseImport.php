<?php

namespace App\Imports;

use App\Models\CenterPolicy;
use App\Models\ControlControlObjective;
use App\Models\ControlObjective;
use App\Models\Document;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PolicyClauseImport implements
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


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Clean and normalize the policy name and document names
            $policyName = $row[$this->columnsMapping['policy_name']] ?? null;
            $documentNames = $row[$this->columnsMapping['document_ids']] ?? null;
    
            // Split document names if there are multiple, and clean them
            $documentNamesArray = explode(',', $documentNames);
    
            // Prepare an array to store the found document IDs
            $documentIds = [];
    
            // Loop through each document name to find the corresponding ID
            foreach ($documentNamesArray as $documentName) {
                // Trim and clean document name
                $cleanedDocumentName = trim($documentName);
                $document = Document::where('document_name', $cleanedDocumentName)->first();
    
                if ($document) {
                    // If the document is found, add its ID to the array
                    $documentIds[] = $document->id;
                }
            }
    
            // Check if the policy already exists
            $centerPolicy = CenterPolicy::where('policy_name', $policyName)->first();
    
            if ($centerPolicy) {
                // If the policy exists, merge existing and new document IDs
                $existingDocumentIds = explode(',', $centerPolicy->document_ids);
                $allDocumentIds = array_unique(array_merge($existingDocumentIds, $documentIds));
    
                // Update the policy's document_ids
                $centerPolicy->document_ids = implode(',', $allDocumentIds);
                $centerPolicy->save();
            } else {
                // If the policy doesn't exist, create a new entry
                $centerPolicy = CenterPolicy::create([
                    'policy_name' => $policyName,
                    'document_ids' => implode(',', $documentIds),
                ]);
            }
    
            // Insert into pivot table (assuming it is named 'document_policy')
            foreach ($documentIds as $documentId) {
                // Use the attach method to avoid duplicates in the pivot table
                $centerPolicy->documents()->syncWithoutDetaching([$documentId]);
            }
        }
    }
    


    public function rules(): array
    {

        $policy_name = $this->columnsMapping['policy_name'] ?? 'policy_name';
        $document_ids = $this->columnsMapping['document_ids'] ?? 'document_ids';
        return [
            $policy_name => ['required', 'max:255'],
            $document_ids => ['required', 'max:500'],
        ];
    }
}
