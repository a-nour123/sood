<?php

namespace App\Listeners;

use App\Events\ControlObjectiveDeleted;
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

class ControlObjectiveDeletedListener
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
     * @param  \App\Events\ControlObjectiveDeleted  $event
     * @return void
     */
    public function handle(ControlObjectiveDeleted $event)
    {
         // Get the action ID for Risk_Add
         $action1 = Action::where('name','Objective_Edit')->first();
         $actionId1 = $action1['id'];
         $action2 = Action::where('name', 'Objective_Notify_Before_Last_End_Date')->first();
         $actionId2 = $action2['id'];
         // Get the risk object from the event
         $ControlControlObjective = $event->ControlControlObjective;
       
         // Define the roles array for notification
         $Auditer=FrameworkControlTestAudit::where('framework_control_id',$ControlControlObjective->control_id)->latest()->first()->tester ?? Null;

         $roles = [
             'Control-Owner' => [$ControlControlObjective->control->User->id ?? null],
             'Responsible_Person' => [$ControlControlObjective->responsible->id ?? null],
             'Control-Tester' => [$ControlControlObjective->control->FrameworkControlTest->UserTester->id ?? null],
             'Auditer'=> [$Auditer ?? null]

         ];

      
         $link = ['link' => route('admin.governance.control.list')];

         // Set the properties of the risk object for notification message
         
       //   $control->control_owner=$control->owners ? $control->owners->name : null;

       $ControlControlObjective->Control_Owner =$ControlControlObjective->control->User->name ? $ControlControlObjective->control->User->name : null;
       $ControlControlObjective->Control_Name =$ControlControlObjective->control->short_name ? $ControlControlObjective->control->short_name : null;
       $ControlControlObjective->Control_Description =$ControlControlObjective->control->description ? $ControlControlObjective->control->description : null;
       $ControlControlObjective->Objective =$ControlControlObjective->objective ? $ControlControlObjective->objective->name : null;
       $ControlControlObjective->Responsible =$ControlControlObjective->responsible ? $ControlControlObjective->responsible->name : null;
       $ControlControlObjective->Due_Date =$ControlControlObjective->due_date;

       $modelId = $ControlControlObjective->id;

       $proccess = "delete";
    
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
           $this->sendNotificationForAction($actionId1, $actionId2,$link, $ControlControlObjective, $roles, $nextDateNotify = null, $modelId, $modelType,$proccess);
       } else if($NumbersOfDays !== null) {
           $this->sendNotificationForAction($actionId1, $actionId2,$link, $ControlControlObjective, $roles, $nextDateNotify , $modelId, $modelType,$proccess);
       }
    }
}
