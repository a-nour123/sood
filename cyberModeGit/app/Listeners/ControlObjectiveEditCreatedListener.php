<?php

namespace App\Listeners;

use App\Events\ControlObjectiveEditCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\AutoNotify;
use App\Models\User;
use App\Models\Framework;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;
use App\Models\ControlControlObjective;
use App\Models\NotifyAtDateModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControlObjectiveEditCreatedListener
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
     * @param  \App\Events\ControlObjectiveEditCreated  $event
     * @return void
     */
    public function handle(ControlObjectiveEditCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Objective_Edit')->first();
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

        // Set the properties of the ControlControlObjective object for notification
        $ControlControlObjective->Control_Owner = optional($ControlControlObjective->control->User)->name ?? 'N/A';
        $ControlControlObjective->Control_Name = optional($ControlControlObjective->control)->short_name ?? 'N/A';
        $ControlControlObjective->Control_Description = optional($ControlControlObjective->control)->description ?? 'N/A';
        $ControlControlObjective->Objective = optional($ControlControlObjective->objective)->name ?? 'N/A';
        $ControlControlObjective->Responsible = optional($ControlControlObjective->responsible)->name ?? 'N/A';
        $ControlControlObjective->Due_Date = $ControlControlObjective->due_date ?? 'N/A';


        $modelId = $ControlControlObjective->id;
        $proccess = "update";

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


        $actionOfAutoNotify = Action::where('name', 'ObjectiveNotifyEsclation')->first();
        $actionOfAutoNotifyId = $actionOfAutoNotify['id'];

        $systemNotificationSettingOfAutoNotify = AutoNotify::where('action_id', $actionOfAutoNotifyId)->first();
        if ($systemNotificationSettingOfAutoNotify && $systemNotificationSettingOfAutoNotify['status']) {
            $escalationDays = DB::table('auto_notifies')
                ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
                ->where('actions.name', 'ObjectiveNotifyEsclation')
                ->select('auto_notifies.date')
                ->first();

            if ($escalationDays) {
                // Decode the JSON string to an array of integers
                $escalationDatesArray = json_decode($escalationDays->date, true);

                if (is_array($escalationDatesArray)) {
                    $escalationDateNotify = $ControlControlObjective->Due_Date ? $ControlControlObjective->Due_Date : null;
                    $escalationNextDateNotify = [];

                    foreach ($escalationDatesArray as $days) {
                        // Convert days to an integer and add to Due_Date
                        $escalationDaysToAdd = (int) $days;

                        $carbonDate = Carbon::parse($escalationDateNotify);
                        $nextDate = $carbonDate->addDays($escalationDaysToAdd);
                        $escalationNextDateNotify[] = $nextDate->format('Y-m-d');
                    }
                }
            }

            NotifyAtDateModel::updateOrCreate(
                ['model_id' => $modelId, 'model_type' => "esclationObjectiveNotify"],
                [
                    'model' => json_encode($ControlControlObjective),
                    'roles' => json_encode($roles),
                    'action_id' => $actionOfAutoNotifyId,
                    'link' => json_encode($link),
                    'notification_date' => json_encode($escalationNextDateNotify),
                    'model_type' => "esclationObjectiveNotify",
                    'model_id' => $modelId,
                    'proccess' => $proccess
                ]
            );
        }


        // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
        if ($NumbersOfDays == null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $ControlControlObjective, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
        } else if ($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $ControlControlObjective, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
        }
    }
}
