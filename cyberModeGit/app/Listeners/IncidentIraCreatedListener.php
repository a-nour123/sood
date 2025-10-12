<?php

namespace App\Listeners;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncidentIraCreatedListener
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
    public function handle($event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'incident_ira_created')->first();
      
        if (!$action1) {
            // Handle the case when no matching action is found, e.g., log an error or return an appropriate response
            \Log::error('Action "incident_created" not found.');
            return;
        }
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $incident = $event->incident;
        $type = $event->type;
        $users = $event->users;
    
        if($type == 'user'){
            $users_data = $users;
        }else{
            $teams = $users;
        }

         $roles = [
            'Responsible-Person' => $users_data ?? [] ,
           'Team-teams' => $teams ?? [] ,
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
