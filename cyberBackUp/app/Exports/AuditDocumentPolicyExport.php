<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use App\Models\AuditDocumentPolicy;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AuditDocumentPolicyExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $documentPolicyId;

    public function __construct($documentPolicyId)
    {
        $this->documentPolicyId = $documentPolicyId;
    }

    public function collection()
    {
        // Get the relevant policy document IDs
        $policyDocumentIds = DB::table('audit_document_policy_policy_document')
            ->where('audit_document_policy_id', $this->documentPolicyId)
            ->pluck('policy_document_id')
            ->toArray();
    
        // Fetch policies with conditions
        $policies = AuditDocumentPolicy::with([
            'policies.policy', // Eager load the policy relation to get policy_name
            'document',
            'users'
        ])
        ->where('audit_document_policies.id', $this->documentPolicyId)
        ->get();
    
        $exportData = [];
    
        foreach ($policies as $policy) {
            foreach ($policy->policies as $documentPolicy) {
                // Fetch the status from AuditDocumentPolicyStatus based on the conditions
                $statusRecord = DB::table('audit_document_policy_statuses')
                    ->where('aduit_id', $this->documentPolicyId)
                    ->where('document_policy_id', $documentPolicy->id)
                    ->where('user_id', auth()->user()->id)
                    ->first(); // Get the first matching status
    
                // Set the status value if available, otherwise leave empty
                $status = $statusRecord ? $statusRecord->pending_status : '';
    
                // Collecting the data for export
                $exportData[] = [
                    'Audit Id' => $this->documentPolicyId, // Column A: Audit Id
                    'document_policy_id' => $documentPolicy->id, // Column B: Document Policy ID
                    'Policy Clause' => $documentPolicy->policy->policy_name ?? 'N/A', // Column D: Policy Clause
                    'Document Name' => $policy->document->document_name ?? 'N/A', // Column E: Document Name
                    'User Email' => auth()->user()->email, // Column F: User Email
                    'Status' => $status, // Column G: Status (with retrieved or empty value)
                    'Comment' => '', // Column H: Comment (leave empty for user entry)
                ];
            }
        }
    
        return collect($exportData); // Return as a collection
    }
    

    // Define the headings for the Excel sheet in the new order
    public function headings(): array
    {
        return [

            'Audit Id', // column A
            'Document Policy ID', // column B
            '#', // column C: auto-incrementing column
            'Policy Clause', // column D
            'Document Name', // column E
            'Email', // column F
            'Status', // column G
            'Comment', // column H
        ];
    }

    // Map the collection to the desired format in the new order
    public function map($row): array
    {
        // Generate the auto-increment value
        static $counter = 1; // This will keep the increment across rows

        return [
            $row['Audit Id'], // Column A: Audit Id
            $row['document_policy_id'], // Column B: Document Policy ID
            $counter++, // Column C: Auto-incremented number
            $row['Policy Clause'], // Column D: Policy Clause
            $row['Document Name'], // Column E: Document Name
            $row['User Email'], // Column F: User Email
            $row['Status'], // Column G: Status
            $row['Comment'], // Column H: Comment
        ];
    }

    // Define events
    public function registerEvents(): array
    {
        $statusOptions = [
            'Not Implemented',
            'Implemented',
            'Partially Implemented',
            'Not Applicable'
        ];
    
        return [
            AfterSheet::class => function (AfterSheet $event) use ($statusOptions) {
                $row_count = 2; // Starting row for data (row 2)
                $column_count = 8; // Total columns now (A to H)
    
                // Set data validation (drop-down) for the Status column (column G)
                $drop_column = 'G';  // Status column is column G (7th column)
    
                // Create data validation for the Status column
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1(sprintf('"%s"', implode(',', $statusOptions)));
    
                // Loop through the collection and set status for each row
                foreach ($this->collection() as $index => $row) {
                    $status = $row['Status']; // Get the status value from the row data
    
                    // Clone validation to the specific row in the Status column (G)
                    $event->sheet->getCell($drop_column . ($index + 2))->setDataValidation(clone $validation);
    
                    // Set the default or fetched status value in the Excel sheet
                    if ($status) {
                        $event->sheet->setCellValue($drop_column . ($index + 2), $status); // Set fetched status
                    } else {
                        // Optionally set a default status if the status is not found
                        $event->sheet->setCellValue($drop_column . ($index + 2), 'Not Implemented');
                    }
                }
    
                // Set columns to auto size
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
    
                // Hide columns A (Audit Id) and B (Document Policy ID) if desired
                $event->sheet->getColumnDimension('A')->setVisible(false); //  hide Audit Id
                $event->sheet->getColumnDimension('B')->setVisible(false); // hide Document Policy ID
            },
        ];
    }
    
}
