<?php

namespace App\Listeners;

use App\Events\ControlObjectiveCreated;
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
use App\Models\ControlControlObjective;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControlObjectiveCreatedListener
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
     * @param  \App\Events\ControlObjectiveCreated  $event
     * @return void
     */
    public function handle(ControlObjectiveCreated $event)
    {
        
              // Get the action ID for Risk_Add
              $action1 = Action::where('name','Objective_Add')->first();
              $actionId1 = $action1['id'];
              
              $action2 = Action::where('name', 'Objective_Notify_Before_Last_End_Date')->first();
              $actionId2 = $action2['id'];

              // Get the risk object from the event
              $ControlControlObjective = $event->ControlControlObjective;
              $control = $event->control;
              // Define the roles array for notification

            $Auditer=FrameworkControlTestAudit::where('framework_control_id',$control->id)->latest()->first()->tester ?? Null;

 
              $roles = [
                  'Control-Owner' => [$control->control_owner ?? null],
                  'Responsible_Person' => [$ControlControlObjective->responsible->id ?? null],
                  'Control-Tester' => [$control->FrameworkControlTest->UserTester->id ?? null],
                  'Auditer'=> [$Auditer ?? null]
              ];

              $link = ['link' => route('admin.governance.control.list')];

              // Set the properties of the risk object for notification message
              
            //   $control->control_owner=$control->owners ? $control->owners->name : null;

            $control->Control_Owner =$control->User ? $control->User->name : null;
            $control->Control_Name =$control->short_name ? $control->short_name : null;
            $control->Control_Description =$control->description ? $control->description : null;
            $control->Objective =$ControlControlObjective->objective ? $ControlControlObjective->objective->name : null;
            $control->Responsible =$ControlControlObjective->responsible ? $ControlControlObjective->responsible->name : null;
            $control->Due_Date =$ControlControlObjective->due_date;

            $modelId = $ControlControlObjective->id;
            $proccess = "create";
        
                $modelType = "objective";
                //   to get number od days
                $NumbersOfDays = DB::table('auto_notifies')
                    ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
                    ->where('actions.name', 'Objective_Notify_Before_Last_End_Date')
                    ->select('auto_notifies.date')
                    ->first();
        
                    if ($NumbersOfDays) {
                        // Decode the JSON string to an array of integers
                        $datesArray = json_decode($NumbersOfDays->date, true);
        
                        if (is_array($datesArray)) {
                            $DateNotify = $ControlControlObjective->due_date ? $ControlControlObjective->due_date : null;
                            $nextDateNotify = [];
        
                            foreach ($datesArray as $days) {
                                // Convert days to an integer and subtract from DateNotify
                                $numberOfDaysToSubtract = (int) $days;
        
                                $carbonDate = Carbon::parse($DateNotify);
                                $nextDate = $carbonDate->subDays($numberOfDaysToSubtract);
                                $nextDateNotify[] = $nextDate->format('Y-m-d');
                            }
        
                            // $nextDateNotifyArray now contains the results of subtracting each day from DateNotify.
                            // You can use this array as needed.
                        }
                    }
        
        
                // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
                if ($NumbersOfDays == null) {
                    $this->sendNotificationForAction($actionId1, $actionId2,$link, $control, $roles, $nextDateNotify = null, $modelId, $modelType,$proccess);
                } else if($NumbersOfDays !== null) {
                    $this->sendNotificationForAction($actionId1, $actionId2,$link, $control, $roles, $nextDateNotify , $modelId, $modelType,$proccess);
                }

    }
}
