<?php

namespace App\Listeners;

use App\Events\PolicyAdoptionStatusChanged;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PolicyAdoptionStatusChangedListener
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
    public function handle(PolicyAdoptionStatusChanged $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'policy_adoption_change_status')->first();
        $actionId1 = $action1['id'];

        // Access the variables from the event
        $policyAdoption = $event->policyAdoption;
        $policySignature = $event->policySignature;
        $userAction = $event->userAction;
        // Example usage
        $action = Action::where('name', 'policy_adoption_add')->first();
        $actionId = $action->id;

        // Convert IDs to arrays
        $ownerIds = $policySignature->owner_id ? explode(',', $policySignature->owner_id) : [];
        $reviewerIds = $policySignature->reviewer_id ? explode(',', $policySignature->reviewer_id) : [];
        $authorizedIds = $policySignature->authorized_person_id ? explode(',', $policySignature->authorized_person_id) : [];

        // Get user names from IDs
        $owners = User::whereIn('id', $ownerIds)->pluck('name')->toArray();
        $reviewers = User::whereIn('id', $reviewerIds)->pluck('name')->toArray();
        $authorizedPersons = User::whereIn('id', $authorizedIds)->pluck('name')->toArray();

        // Prepare roles for notifications
        $roles = [
            'owner' => $ownerIds,
            'creator' => [$policyAdoption->created_by ?? null],
            'reviewer' => $reviewerIds,
            'authorized_person' => $authorizedIds,
        ];

        $link = ['link' => route('admin.adoption_policies.index')];

        // Set properties for notification (names instead of IDs)
        $policyAdoption->category = $policyAdoption->category->name ?? null;
        $policyAdoption->created_by = $policyAdoption->user->name ?? null;
        $policyAdoption->owner = implode(', ', $owners);
        $policyAdoption->reviewer = implode(', ', $reviewers);
        $policyAdoption->authorized_person = implode(', ', $authorizedPersons);
        $policyAdoption->status= $userAction['status'] ?? null;
        $policyAdoption->status_by= auth()->user()->name;
        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $policyAdoption, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}