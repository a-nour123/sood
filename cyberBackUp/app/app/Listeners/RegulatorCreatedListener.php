<?php

namespace App\Listeners;

use App\Events\RegulatorCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegulatorCreatedListener
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
    public function handle(RegulatorCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name','Regulator_Add')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $regulator = $event->regulator;

        // Define the roles array for notification
        $roles = [];
        // Define teams in the desired format for notification message

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.governance.regulator.index')];

        // Set the properties of the risk object for notification message
        $regulator->name = $regulator->name;

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $regulator, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
