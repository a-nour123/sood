<?php

namespace App\Listeners;

use App\Events\IncidentCommentCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Incident;
use App\Models\IncidentPlayBookAction;
use App\Models\Playbook;
use App\Models\PlayBookAction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncidentCommentCreatedListener
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
    public function handle(IncidentCommentCreated $event)
    {
        // Get the action ID for add_incident_comment
        $action1 = Action::where('name', 'add_incident_comment')->first();
        $actionId1 = $action1['id'];

        // Get the incident comment object from the event
        $incidentComment = $event->comment;

        // Get incident data without relation
        $incident = Incident::find($incidentComment->incident_id);
        
        // Get playbook users and teams without relations
        $userIds = [];
        $teamIds = [];
        
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

        // Set comment data
        $incidentComment->comment = $incidentComment->comment ?? null;
        $incidentComment->Name = $incident->summary ?? null;

        // Get creator name without relation
        $creatorName = null;
        if ($incident && $incident->created_by) {
            $creator = User::find($incident->created_by);
            $creatorName = $creator->name ?? null;
        }
        $incidentComment->created_by = $creatorName;

        // Get playbook action data without relations
        $playBookCategory = null;
        $playBookTitle = null;
//dd($incidentComment);        
        if ($incidentComment->action_id) {
            $incidentPlayBookAction = IncidentPlayBookAction::find($incidentComment->action_id);
//dd($incidentPlayBookAction);            
            if ($incidentPlayBookAction && $incidentPlayBookAction->play_book_action_id) {
                $playBookAction = PlayBookAction::find($incidentPlayBookAction->play_book_action_id);
  //dd($playBookAction);              
                if ($playBookAction) {
                    $playBookCategory = $playBookAction->category_type ?? null;
                    $playBookTitle = $playBookAction->title ?? null;
                }
            }
        }

        $incidentComment->play_book_category = $playBookCategory;
        $incidentComment->play_book_title = $playBookTitle;

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        
        // handling different kinds of notifications using "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction(
            $actionId1, 
            $actionId2, 
            $link, 
            $incidentComment, 
            $roles, 
            $nextDateNotify, 
            $modelId, 
            $modelType, 
            $proccess
        );
    }
}
