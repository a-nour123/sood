<?php

namespace App\Listeners;

use App\Events\ApproveComplianceAuditer;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApproveComplianceAuditerListener
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
    public function handle(ApproveComplianceAuditer $event)
    {
         // Getting the action ID of the event
         $action1 = Action::where('name', 'ApproveCompliance')->first();
         $actionId1 = $action1['id'];
         // Getting the model from the event
         $policy = $event->policy;
         $roles = [
             'Document-Owner' => [$policy->auditDocumentPolicy->document->owner->id ?? null],
             'Auditees' => [$policy->user_id ?? null],
             'Auditer' => [$policy->auditDocumentPolicy->owner_id ?? null],
         ];

         $policy->Document_Name = $policy->auditDocumentPolicy->document->document_name;
         $policy->Document_Owner = $policy->auditDocumentPolicy->document->owner->name;
         $policy->Auditer =$policy->auditDocumentPolicy->users->name;
         $policy->Auditee = $policy->user->name;

        
         // defining the link we want the user to be redirected to after clicking the system notification
         $link = ['link' => route('admin.governance.Aduit.document.policy')];
 
         $actionId2 = null;
         $nextDateNotify = null;
         $modelId = null;
         $modelType = null;
         $proccess = null;
         // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
         $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $policy, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
