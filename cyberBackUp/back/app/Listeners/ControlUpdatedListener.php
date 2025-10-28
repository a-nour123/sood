<?php

namespace App\Listeners;

use App\Events\ControlUpdated;
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
class ControlUpdatedListener
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
     * @param  \App\Events\ControlUpdated  $event
     * @return void
     */
    public function handle(ControlUpdated $event)
    {
          // Get the action ID for Risk_Add
          $action1 = Action::where('name','Control_Update')->first();
          $actionId1 = $action1['id'];
          
          // Get the risk object from the event
          $frameworkControlTest = $event->frameworkControlTest;
          $updatedFrames = $event->updatedFrames;

        
          // Define the roles array for notification

          $roles = [
              'Control-Owner' => [$updatedFrames->control_owner ?? null],
              'Control-Tester' => [$frameworkControlTest->UserTester->id ?? null]
          ];
 
       
          $link = ['link' => route('admin.governance.control.list')];

          // Set the properties of the risk object for notification message
          
        //   $control->control_owner=$control->owners ? $control->owners->name : null;

        $updatedFrames->Control_Owner =$updatedFrames->User ? $updatedFrames->User->name : null;
        $updatedFrames->Desired_Maturity =$updatedFrames->ControlDesiredMaturity ? $updatedFrames->ControlDesiredMaturity->name : null;
        $updatedFrames->Control_Priority =$updatedFrames->priority ? $updatedFrames->priority->name : null;
        $updatedFrames->Control_class =$updatedFrames->class ? $updatedFrames->class->name : null;
        $updatedFrames->Control_Maturity =$updatedFrames->ControlMaturity ? $updatedFrames->ControlMaturity->name : null;

        $updatedFrames->Control_Phase =$updatedFrames->ControlPhase ? $updatedFrames->ControlPhase->name : null;
        $updatedFrames->Control_Type =$updatedFrames->type ? $updatedFrames->type->name : null;
        $updatedFrames->Tester =$frameworkControlTest->UserTester ? $frameworkControlTest->UserTester->name : null;
        $updatedFrames->Test_Frequency =$frameworkControlTest->test_frequency ? $frameworkControlTest->test_frequency : null;
        $updatedFrames->Test_Name =$frameworkControlTest->name ? $frameworkControlTest->name : null;
        $updatedFrames->Test_Steps =$frameworkControlTest->test_steps ? $frameworkControlTest->test_steps : null;
        $updatedFrames->Approximate_Time =$frameworkControlTest->approximate_time ? $frameworkControlTest->approximate_time : null;
        $updatedFrames->Expected_Results =$frameworkControlTest->expected_results ? $frameworkControlTest->expected_results : null;

          // Call the function to handle different kinds of notifications
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $updatedFrames, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);    }
}
