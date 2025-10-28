<?php

namespace App\Listeners;

use App\Events\ControlObjectiveCommentCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\FrameworkControlTestAudit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ControlObjectiveCommentCreatedListener
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
    public function handle(ControlObjectiveCommentCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'add_comment')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $comment = $event->comment;


        // Get the risk object from the event
        $ControlControlObjective = $comment->ControlControlObjective;

        $control =  $comment->ControlControlObjective->control;

        // Define the roles array for notification

        $Auditer = FrameworkControlTestAudit::where('framework_control_id', $control->id)->latest()->first()->tester ?? Null;


        $roles = [
            'Control-Owner' => [$control->control_owner ?? null],
            'Responsible_Person' => [$ControlControlObjective->responsible->id ?? null],
            'Control-Tester' => [$control->FrameworkControlTest->UserTester->id ?? null],
            'Auditer' => [$Auditer ?? null]
        ];

        $link = ['link' => route('admin.governance.control.list')];

        $control->Control_Owner = $control->User ? $control->User->name : null;
        $control->Control_Name = $control->short_name ? $control->short_name : null;
        $control->Control_Description = $control->description ? $control->description : null;
        $control->Objective = $ControlControlObjective->objective ? $ControlControlObjective->objective->name : null;
        $control->Responsible = $ControlControlObjective->responsible ? $ControlControlObjective->responsible->name : null;
        $control->Due_Date = $ControlControlObjective->due_date ?? null;
        $control->Comment = $ControlControlObjective->comment ?? null;
        $control->Creator = $comment->user->id ?? null;
        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $control, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
