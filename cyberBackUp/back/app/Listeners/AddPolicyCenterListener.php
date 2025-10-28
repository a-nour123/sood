<?php

namespace App\Listeners;

use App\Events\AddPolicyCenter;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Document;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddPolicyCenterListener
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


    public function handle(AddPolicyCenter $event)
    {
        // Getting the action ID of the event
        $action1 = Action::where('name', 'addpolicyCenter')->first();
        $actionId1 = $action1['id'];

        // Getting the model from the event
        $policy = $event->policy;

        // Exploding the document_ids to get each document as an individual item
        $documentIds = explode(',', $policy->document_ids);

        // Optionally, you can trim each ID to remove any extra spaces
        $documentIds = array_map('trim', $documentIds);
        $documentOwnerId = Document::whereIn('id', $documentIds)->pluck('document_owner')->toArray();
        $documentOwnerNames = User::whereIn('id', $documentOwnerId)->pluck('name')->toArray();
        $documentOwnersNamesString = implode(', ', $documentOwnerNames);

        // Fetch document names based on document IDs
        $documentNames = Document::whereIn('id', $documentIds)->pluck('document_name')->toArray();

        // Convert the array of document names into a comma-separated string
        $documentNamesString = implode(', ', $documentNames);

        // For debugging purposes, you can use dd() to check the result
        $roles = [
            'Document-Owner' => $documentOwnerId ?? null,
        ];

        // to get the column in database appear in notification as string not int
        $policy->Policy_clause = $policy->policy_name;
        $policy->Document_Name =$documentNamesString;
        $policy->Document_Owner = $documentOwnersNamesString;
        // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.governance.category')];
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $policy, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
