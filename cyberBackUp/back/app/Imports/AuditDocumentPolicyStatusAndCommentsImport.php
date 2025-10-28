<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\AuditDocumentPolicyStatus;
use App\Models\AuditDocumentPolicyComment;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\AuditDocumentPolicy; // Import your model for AuditDocumentPolicy

class AuditDocumentPolicyStatusAndCommentsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    protected $failures = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $rowIndex => $row) { // Include row index
            Log::info('Importing row:', $row->toArray());

            // Retrieve each field
            $auditId = $row['audit_id'] ?? null;
            $documentPolicyId = $row['document_policy_id'] ?? null;
            $status = $row['status'] ?? null;
            $comment = $row['comment'] ?? null;
            $userEmail = $row['email'] ?? null;

            // Skip rows with any missing required data
            if (empty($auditId) || empty($documentPolicyId) || empty($status) || empty($userEmail)) {
                $this->failures[] = [
                    'row' => $rowIndex + 2, // +2 to account for heading row and 0-indexing
                    'errors' => ['Missing required fields: ' . json_encode($row->toArray())]
                ];
                Log::warning("Skipping row due to missing required fields: ", $row->toArray());
                continue;
            }

            // Get user by email for user_id
            $user = User::where('email', $userEmail)->first();

            if (!$user) {
                $this->failures[] = [
                    'row' => $rowIndex + 2,
                    'errors' => ['User not found for email: ' . $userEmail]
                ];
                Log::warning("User not found for email: $userEmail. Skipping row.");
                continue; // If the user doesn't exist, skip this row
            }
            // Assume $auditId is already defined somewhere in your code
            $audit = AuditDocumentPolicy::find($auditId); // Fetch the audit using the ID

            if ($audit) {
                $auditName = $audit->name; // Get the name of the audit
            } else {
                $auditName = 'Unknown Audit'; // Fallback if not found
            }

            // Check if the user is responsible for the audit
            if (!$this->isUserResponsibleForAudit($auditId, $user->id)) {
                $this->failures[] = [
                    'row' => $rowIndex + 2,
                    'errors' => ['User is not Auditee for audit : ' . $auditName]
                ];
                Log::warning("User {$user->id} is not responsible for audit ID: $auditId. Skipping row.");
                continue;
            }

            // Update or create status
            AuditDocumentPolicyStatus::updateOrCreate(
                [
                    'aduit_id' => $auditId,
                    'document_policy_id' => $documentPolicyId,
                    'user_id' => $user->id,
                ],
                [
                    'pending_status' => $status,
                ]
            );

            // Create or update comment if there is a value
            if (!empty($comment)) {
                AuditDocumentPolicyComment::create(
                    [
                        'aduit_id' => $auditId,
                        'document_policy_id' => $documentPolicyId,
                        'user_id' => $user->id,
                        'comment' => $comment,
                        'replier_id' => null, // Adjust this if necessary
                    ]
                );
            }
        }
    }

    public function rules(): array
    {
        return [
            'audit_id' => 'required|numeric',
            'document_policy_id' => 'required|numeric',
            'status' => 'required|string|in:Implemented,Not Implemented,Partially Implemented,Not Applicable',
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Validation failure on row ' . $failure->row() . ': ' . json_encode($failure->errors()));
            $this->failures[] = [
                'row' => $failure->row(),
                'errors' => $failure->errors()
            ];
        }
    }

    public function getFailures(): array
    {
        return $this->failures;
    }

    protected function isUserResponsibleForAudit($auditId, $userId)
    {
        // Fetch the audit document policy to check the responsible users
        $auditPolicy = AuditDocumentPolicy::find($auditId);

        if ($auditPolicy) {
            // Split the responsible users by comma and check if the user ID exists in the array
            $responsibleUsers = explode(',', $auditPolicy->responsible);
            return in_array($userId, $responsibleUsers);
        }

        // If audit policy not found, consider the user not responsible
        return false;
    }
}
