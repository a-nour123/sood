<?php

namespace App\Listeners;

use App\Events\ControlDocumentComplianceDeleted;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ControlDocumentComplianceDeletedListener
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
    public function handle(ControlDocumentComplianceDeleted $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'control_docuemt_delete')->first();
        $actionId1 = $action1['id'];

        $compliance = $event->compliance;

        // Define the roles array for notification
        $reviewerId = explode(',', $compliance->reviewer_id);
        $reviewers = User::whereIn('id', $reviewerId)->pluck('name')->toArray();
        $reviewersName = implode(',', $reviewers);
        $roles = [
            'reviewer' => $reviewerId ?? null,
        ];

        $link = ['link' => route('admin.mapped_controls_compliance.index')];

        $compliance->name = $compliance->name ?? null;
        $compliance->description = $compliance->description ?? null;
        $compliance->framework = $compliance->framework->name ?? null;
        $compliance->regulator = $compliance->regulator->name ?? null;
        $compliance->reviewer = $reviewersName ?? null;
        $compliance->StartDate = $compliance->start_date ?? null;
        $compliance->Duedate = $compliance->due_date ?? null;
        $compliance->periodicalTime = $compliance->periodical_date ?? null;
        $compliance->NextIntiateDate = $compliance->next_initiate_date ?? null;
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;

        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2, $link, $compliance, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
    }
}