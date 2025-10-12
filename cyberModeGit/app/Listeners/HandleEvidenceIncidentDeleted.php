<?php

namespace App\Listeners;

use App\Events\EvidenceIncidentDeleted;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Incident;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleEvidenceIncidentDeleted
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
     * @param  \App\Events\EvidenceIncidentDeleted  $event
     * @return void
     */
    public function handle(EvidenceIncidentDeleted $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'evidence_incident_deleted')->first();

        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $evidence = $event->evidence;

        // Get incident data without relation
        $incident = Incident::find($evidence->playBookAction->incident_id);

        // Get playbook users and teams without relations
        $userIds = [];
        $teamIds = [];
        $userIraIds = [];
        $teamIraIds = [];
        
        if ($incident && $incident->play_book_id) {
            // For now, I'll keep your existing code but with null checks
            $userIds = $incident->playbookUsers->pluck('id')->toArray() ?? [];
            $teamIds = $incident->playbookTeams->pluck('id')->toArray() ?? [];
        }

        if ($incident->type) {
            $userIraIds = $incident->incidentUsers->pluck('id')->toArray() ?? [];
            $teamIraIds = $incident->incidentTeams->pluck('id')->toArray() ?? [];
        }
        $roles = [
            'incident_creator' => [$incident->created_by ?? null],
            'play_book_user' => $userIds ?? null,
            'Team-teams' => $teamIds ?? null,
            'Team-ira' => $userIraIds ?? null,
            'ira_users' => $teamIraIds ?? null,
        ];


        $link = ['link' => route('admin.incident.index')];

        $incident->summary = $incident->summary ?? null;
        $incident->status = $incident->status ?? null;
        $incident->category_title = $evidence->playBookAction->playBookAction->title ?? null;
        $incident->category_type = $evidence->playBookAction->playBookAction->category_type ?? null;

        // Set the properties of the risk object for notification message

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $incident, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}