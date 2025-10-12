<?php

namespace App\Listeners;

use App\Events\ControlObjectivesMainCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\ControlObjective;

class ControlObjectivesMainCreatedListener
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
     * @param  \App\Events\ControlObjectivesMainCreated  $event
     * @return void
     */
    public function handle(ControlObjectivesMainCreated $event)
    {
        
        // Get the action ID for Risk_Add
        $action1 = Action::where('name','Control_Objectives_Add')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $ControlObjective = $event->ControlObjective;

    
        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');
        
        // Define the roles array for notification
        $roles = [
        ];
        
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.control_objectives.index')];

        $ControlObjective->Name= $ControlObjective->name ? $ControlObjective->name : null;
        $ControlObjective->Description= $ControlObjective->description ? $ControlObjective->description : null;


        
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $ControlObjective, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
