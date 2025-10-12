<?php

namespace App\Listeners;

use App\Events\TaskCommentCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Department;
use App\Models\User;
use App\Models\UserToTeam;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskCommentCreatedListener
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
    public function handle(TaskCommentCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'add_task_note')->first();

        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $taskComment = $event->comment;
        // getting the model of event
        $data = $taskComment->task ?? null;
        $team =  $taskComment?->task?->assignable_type ?? null;

        $teamIds = [];
        // dd($team);
        if ($team === "App\Models\Team") {
            $assignee = $data->assignable_id;
            $managersIdOwner = Department::where('id', $assignee)->pluck('manager_id')->unique()->toArray() ?? [];
        } else {
            $assignee = $data->assignable_id;
        }

        $roles = [
            'Assignee' => [$assignee ?? null],
            'creator' => [$data->created_by ?? null],
            'Team-teams' => [$assignee ?? null],
            'Employye-manager' => $managersIdOwner ?? null
        ];
 
        $link = ['link' => route('admin.task.assigned_to_me')];


        // to get the column in database appear in notification as string not int
        $data->note = $taskComment->note ?? null;
        $data->Title = $data->title ?? null;
        $data->Start_Date = optional($data->start_date)->format('Y-m-d') ?? null;
        $data->Due_Date = optional($data->due_date)->format('Y-m-d') ?? null;
        $data->Task_Priority = $data->priority ?? null;
        $data->Description = $data->description ?? null;
        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $data, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
