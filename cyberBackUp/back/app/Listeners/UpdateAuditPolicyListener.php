<?php

namespace App\Listeners;

use App\Events\UpdateAuditPolicy;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\CenterPolicy;
use App\Models\DocumentPolicy;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAuditPolicyListener
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


    public function handle(UpdateAuditPolicy $event)
    {
        // Getting the action ID of the event
        $action1 = Action::where('name', 'UpdateAduitPolicy')->first();
        $actionId1 = $action1['id'];

        // Getting the model from the event
        $auditDocumentPolicy = $event->auditDocumentPolicy;
        $policyDocumentIds = $event->policyDocumentIds;

        // Exploding the document_ids to get each document as an individual item
        $AuditeesId = explode(',', $auditDocumentPolicy->responsible);
        $AuditeesNames = User::WhereIn('id', $AuditeesId)->pluck('name')->toArray();
        $AuditeesNamesString = implode(', ', $AuditeesNames);


        $DocumentPolicesIds = DocumentPolicy::whereIn('id', $policyDocumentIds)->pluck('policy_id')->toArray();
        $policiesName = CenterPolicy::whereIn('id', $DocumentPolicesIds)->pluck('policy_name')->toArray();
        $policiesNameString = implode(', ', $policiesName);



        $roles = [
            'Document-Owner' => [$auditDocumentPolicy->document->owner->id ?? null],
            'Auditees' => $AuditeesId ?? null,
            'Auditer' => [$auditDocumentPolicy->owner_id ?? null],
        ];

        // to get the column in database appear in notification as string not int
        $auditDocumentPolicy->Policy_clause = $policiesNameString;
        $auditDocumentPolicy->Document_Name = $auditDocumentPolicy->document->document_name;
        $auditDocumentPolicy->Document_Owner = $auditDocumentPolicy->document->owner->name;
        $auditDocumentPolicy->Auditer = $auditDocumentPolicy->users->name;
        $auditDocumentPolicy->Auditees = $AuditeesNamesString;
        $auditDocumentPolicy->Start_Date = $auditDocumentPolicy->start_date;
        $auditDocumentPolicy->Due_Date = $auditDocumentPolicy->due_date;
        $auditDocumentPolicy->PeriodicalTime = $auditDocumentPolicy->periodical_time;
        $auditDocumentPolicy->Next_Intiate_Date = $auditDocumentPolicy->next_initiate_date;
        // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.governance.Aduit.document.policy')];

        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $auditDocumentPolicy, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
