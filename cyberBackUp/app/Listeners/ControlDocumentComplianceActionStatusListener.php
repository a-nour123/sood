<?php

namespace App\Listeners;

use App\Events\ControlDocumentComplianceActionStatus;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\ControlComplianceDocument;
use App\Models\Document;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\MappedControlsCompliance;
use App\Models\User;
use Dompdf\Frame;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ControlDocumentComplianceActionStatusListener
{
    use NotificationHandlingTrait;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ControlDocumentComplianceActionStatus $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'control_docuemt_status_action')->first();
        $actionId1 = $action1['id'];

        $rowData = $event->compliance;
        $control = FrameworkControl::findOrfail($rowData['control_id']);
        $document = Document::findOrfail($rowData['policy_id']);
        $controlDocument=ControlComplianceDocument::where('id',$rowData['row_id'])->first();
        
        $compliance = MappedControlsCompliance::findOrfail($controlDocument->mapped_controls_compliance_id);

        // Define the roles array for notification
        $reviewerId = explode(',', $compliance->reviewer_id);
        $reviewers = User::whereIn('id', $reviewerId)->pluck('name')->toArray();
        $reviewersName = implode(',', $reviewers);
        $roles = [
            'reviewer' => $reviewerId ?? null,
            'Control-Owner' => [$control->control_owner ?? null],
            'document-Owner' => [$document->document_owner ?? null],
        ];
 
        $link = ['link' => route('admin.mapped_controls_compliance.index')];

        // Set the properties of the risk object for notification message

        $compliance->name = $compliance->name ?? null;
        $compliance->description = $compliance->description ?? null;
        $compliance->framework = $compliance->framework->name ?? null;
        $compliance->regulator = $compliance->regulator->name ?? null;
        $compliance->reviewer = $reviewersName ?? null;
        $compliance->StartDate = $compliance->start_date ?? null;
        $compliance->Duedate = $compliance->due_date ?? null;
        $compliance->periodicalTime = $compliance->periodical_date ?? null;
        $compliance->NextIntiateDate = $compliance->next_initiate_date ?? null;
        $compliance->control = $control->short_name ?? null;
        $compliance->document = $document->document_name ?? null;
        $compliance->status = $rowData['action'] ?? null;
        $compliance->notes = $rowData['note'] ?? null;
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;

        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2, $link, $compliance, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
    }
}