<?php

namespace App\Listeners;

use App\Events\DeletePolicyClause;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeletePolicyClauseListener
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


    public function handle(DeletePolicyClause $event)
    {
        // getting the action id of event
        $action1 = Action::where('name', 'deletepolicyClause')->first();
        $actionId1 = $action1['id'];
        // Getting the model from the event
        $document = $event->document;
        $policy = $event->policy;

        $roles = [
            'Document-Owner' => [$document->document_owner ?? null],
        ];

        // Define variables for policy name and document name
        $policyName = $policy->policy_name ?? null;
        $documentName = $document->document_name ?? null;
        $documentOwner = $document->owned_by_user->name ?? null;

        // Prepare policy object with new variables
        $policy->Policy_clause = $policyName;
        $policy->Document_Name = $documentName;
        $policy->Document_Owner = $documentOwner;

        // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.governance.category')];
        // dd($action1,$link ,$policy, $roles, $action1);

        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;

        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $policy, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
