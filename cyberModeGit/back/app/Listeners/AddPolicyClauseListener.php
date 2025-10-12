<?php

namespace App\Listeners;

use App\Events\AddPolicyClause;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddPolicyClauseListener
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


    public function handle(AddPolicyClause $event)
    {
        // getting the action id of event
        $action1 = Action::where('name', 'addpolicyClause')->first();
        $actionId1 = $action1['id'];
        // Getting the model from the event
        $document = $event->document;
        $policy = $event->policy;

        $roles = [
            'Document-Owner' => [$document->document_owner ?? null],
        ];
        // to get the column in database appear in notification as string not int
        $policy->Policy_clause = $policy->policy_name;
        $policy->Document_Name = $document->document_name;
        $policy->Document_Owner = $document->owned_by_user->name;
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
