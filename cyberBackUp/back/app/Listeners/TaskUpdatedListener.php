<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Models\Action;
use App\Models\Task;
use App\Models\UserToTeam;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Department;
use App\Models\User;

class TaskUpdatedListener
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
     * @param  \App\Events\TaskUpdated  $event
     * @return void
     */
    public function handle(TaskUpdated $event)
    {
        // getting the action id of event
        $action1 = Action::where('name', 'Task_Update')->first();
        $actionId1 = $action1['id'];
        $action2 = Action::where('name', 'Task_Notify_Before_Last_Due_Date')->first();
        $actionId2 = $action2['id'];
        // getting the model of event
        $data = $event->task ?? null;
        if ($data && $data->assignable_type === "App\Models\User") {
            $UserIds = User::where('id', $data->assignable_id)->pluck('id')->unique()->toArray();
            $roles = [
                'creator' => array_map('intval', [$data->created_by_user->id ?? null]),
                'Assignee' => array_map('intval', $UserIds ?? null),
            ];
        } else {
            $TeamIds = UserToTeam::where('team_id', $data['assignable_id'])
                ->pluck('team_id')
                ->unique()
                ->toArray();
            $UsersTeams = UserToTeam::where('team_id',  $data['assignable_id'])->pluck('user_id')->unique()->toArray();
            $managersId = User::whereIn('id', $UsersTeams)->pluck('department_id')->unique()->toArray();
            $managersIdOwner = Department::whereIn('id', $managersId)->pluck('manager_id')->unique()->toArray();
            $roles = [
                'Team-teams' => $TeamIds ?? null,
                'creator' => [$data->created_by_user->id ?? null],
                'Assignee' => [null],
                'Employye-manager' => [$managersIdOwner ?? null]

            ];
        }
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
        $data->Start_Date = optional($data->start_date)->format('Y-m-d H:i:s') ?? null;
        $data->Due_Date = optional($data->due_date)->format('Y-m-d H:i:s') ?? null;
        $data->Task_Priority = $data->priority ?? null;
        $data->Description = $data->description ?? null;
        $task = Task::latest()->first();
        $modelId = $task->id;
        $proccess = "update";
        $modelType = "task";
        //   to get number od days
        $NumbersOfDays = DB::table('auto_notifies')
            ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
            ->where('actions.name', 'Task_Notify_Before_Last_Due_Date')
            ->select('auto_notifies.date')
            ->first();

        if ($NumbersOfDays) {
            // Decode the JSON string to an array of integers
            $datesArray = json_decode($NumbersOfDays->date, true);

            if (is_array($datesArray)) {
                $DateNotify = $data->due_date     ? $data->due_date     : null;
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


        // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.task.assigned_to_me')];
        if ($NumbersOfDays == null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $data, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
        } else if ($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $data, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
        }
    }
}
