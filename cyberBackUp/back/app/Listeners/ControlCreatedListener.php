<?php

namespace App\Listeners;

use App\Events\ControlCreated;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ControlCreatedListener
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
     * @param  \App\Events\ControlCreated  $event
     * @return void
     */
    public function handle(ControlCreated $event)
    {

              // Get the action ID for Risk_Add
              $action1 = Action::where('name','Control_Add')->first();
              $actionId1 = $action1['id'];
              // Get the risk object from the event
              $frameworkControlTest = $event->frameworkControlTest;
              $control = $event->control;
              

            
              // Define the roles array for notification

              $roles = [
                  'Control-Owner' => [$control->control_owner ?? null],
                  'Control-Tester' => [$frameworkControlTest->UserTester->id ?? null]
              ];
           
              $link = ['link' => route('admin.governance.control.list')];

              // Set the properties of the risk object for notification message
              
            //   $control->control_owner=$control->owners ? $control->owners->name : null;

            $control->Control_Owner =$control->User ? $control->User->name : null;
            $control->Desired_Maturity =$control->ControlDesiredMaturity ? $control->ControlDesiredMaturity->name : null;
            $control->Control_Priority =$control->priority ? $control->priority->name : null;
            $control->Control_class =$control->class ? $control->class->name : null;
            $control->Control_Maturity =$control->ControlMaturity ? $control->ControlMaturity->name : null;

            $control->Control_Phase =$control->ControlPhase ? $control->ControlPhase->name : null;
            $control->Control_Type =$control->type ? $control->type->name : null;
            $control->Tester =$frameworkControlTest->UserTester ? $frameworkControlTest->UserTester->name : null;
            $control->Test_Frequency =$frameworkControlTest->test_frequency ? $frameworkControlTest->test_frequency : null;
            $control->Test_Name =$frameworkControlTest->name ? $frameworkControlTest->name : null;
            $control->Test_Steps =$frameworkControlTest->test_steps ? $frameworkControlTest->test_steps : null;
            $control->Approximate_Time =$frameworkControlTest->approximate_time ? $frameworkControlTest->approximate_time : null;
            $control->Expected_Results =$frameworkControlTest->expected_results ? $frameworkControlTest->expected_results : null;

            $actionId2=null;
            $nextDateNotify = null;
            $modelId=null;
            $modelType=null;
            $proccess=null;

              // Call the function to handle different kinds of notifications
              $this->sendNotificationForAction($actionId1, $actionId2,$link, $control, $roles, $nextDateNotify, $modelId, $modelType,$proccess);
            }
}
