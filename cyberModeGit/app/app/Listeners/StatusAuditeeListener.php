<?php

namespace App\Listeners;

use App\Events\StatusAuditee;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StatusAuditeeListener
{
    use NotificationHandlingTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StatusAuditee $event)
    {
         // Getting the action ID of the event
         $action1 = Action::where('name', 'ChangeStatus')->first();
         $actionId1 = $action1['id'];
         // Getting the model from the event
         $status = $event->status;

         $roles = [
             'Document-Owner' => [$status->auditDocumentPolicy->document->owner->id ?? null],
             'Auditees' => [$status->user->id ?? null],
             'Auditer' => [$status->auditDocumentPolicy->owner_id ?? null],
         ];
 
         $status->Status = $status->status;
         $status->Policy_clause = $status->documentPolicy->policy->policy_name;
         $status->Document_Name = $status->auditDocumentPolicy->document->document_name;
         $status->Document_Owner = $status->auditDocumentPolicy->document->owner->name;
         $status->Auditer =$status->auditDocumentPolicy->users->name;
         $status->Auditee = $status->user->name;

        
         // defining the link we want the user to be redirected to after clicking the system notification
         $link = ['link' => route('admin.governance.Aduit.document.policy')];
 
         $actionId2 = null;
         $nextDateNotify = null;
         $modelId = null;
         $modelType = null;
         $proccess = null;
         // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
         $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $status, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
