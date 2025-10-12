<?php

namespace App\Listeners;

use App\Events\ControlDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Framework;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;

class ControlDeletedListener
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
     * @param  \App\Events\ControlDeleted  $event
     * @return void
     */
    public function handle(ControlDeleted $event)
    {
          // Get the action ID for Risk_Add
          $action1 = Action::where('name','Control_Delete')->first();
          $actionId1 = $action1['id'];
          
          // Get the risk object from the event
          $frameworkControl = $event->frameworkControl;
          $getTester = $event->getTester;
          

        
          // Define the roles array for notification

          $roles = [
              'Control-Owner' => [$frameworkControl->control_owner ?? null],
              'Control-Tester' => [$getTester->UserTester->id ?? null]
          ];
       
          $link = ['link' => route('admin.governance.control.list')];

 
    // Call the function to handle different kinds of notifications
    $actionId2 = null;
    $nextDateNotify = null;
    $modelId = null;
    $modelType = null;
    $proccess = null;
    // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
    $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $frameworkControl, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
