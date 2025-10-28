<?php

namespace App\Listeners;

use App\Events\IncidentCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Incident;
use App\Models\IncidentIra;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncidentCreatedListener
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
    public function handle(IncidentCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'incident_created')->first();
        if (!$action1) {
            // Handle the case when no matching action is found, e.g., log an error or return an appropriate response
            \Log::error('Action "incident_created" not found.');
            return;
        }
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $incident = $event->incident;
        $ira = IncidentIra::latest()->first();
        if ($ira) {
            if ($ira->type == 'user') {
                $users = $ira->users->pluck('id')->toArray();
            } else {
                $teams = $ira->teams->pluck('id');
            }
        }


        $roles = [
            'Responsible-Person' => $users ?? [],
            'Team-teams' => $teams ?? [],
        ];


        $link = ['link' => route('admin.incident.index')];

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