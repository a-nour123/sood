<?php

namespace App\Listeners;

use App\Events\EmployeeChangeStatus;
use App\Models\Action;
use App\Models\Task;
use App\Models\UserToTeam;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\NotificationHandlingTrait;

class EmployeeChangeStatusListener
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
     * @param  \App\Events\EmployeeChangeStatus  $event
     * @return void
     */
    public function handle(EmployeeChangeStatus $event)
    {
         // getting the action id of event
         $action1 = Action::where('name', 'Task_Employee_Change_Status')->first();
         $actionId1 = $action1['id'];
         // getting the model of event
         $data = $event->task ?? null;
         $roles = [
            'creator' => [$data->created_by_user->id ?? null],
        ];
         // to get the name of team or user depends on model name 
         if ($data['assignable_type'] == "App\Models\User") {
             $userId = (int) $data['assignable_id'];
             $UserName = DB::table('user_to_teams')
                 ->join('users', 'users.id', '=', 'user_to_teams.user_id')
                 ->where('user_to_teams.user_id', $userId)
                 ->value('users.name'); // Use the value method instead of pluck
             $data->Team = null;
             $data->Assignee = $UserName ?? null;
         } else {
             $teamId = (int) $data['assignable_id'];
             $teamsName = DB::table('user_to_teams')
                 ->join('teams', 'teams.id', '=', 'user_to_teams.team_id')
                 ->where('user_to_teams.team_id', $teamId)
                 ->value('teams.name'); // Use the value method instead of pluck
             $data->Team = $teamsName  ?? null;
             $data->Assignee = null;
         }
 
         // to get the column in database appear in notification as string not int
         $data->Title = $data->title ?? null;
         $data->Start_Date = optional($data->start_date)->format('Y-m-d') ?? null;
         $data->Due_Date = optional($data->due_date)->format('Y-m-d') ?? null;
         $data->Task_Priority = $data->priority ?? null;
         $data->Description = $data->description ?? null;
         $data->Status = $data->status ?? null;
         $data->Completed_Date = $data->completed_date ?? null;
         $data->Task_Tacker = $data->action_by_user->name ?? null;

         // defining the link we want the user to be redirected to after clicking the system notification
         $link = ['link' => route('admin.task.assigned_to_me')];
         $actionId2=null;
         $nextDateNotify = null;
         $modelId=null;
         $modelType=null;
         $proccess=null;
         // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
         $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $data, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
 
    }
}
