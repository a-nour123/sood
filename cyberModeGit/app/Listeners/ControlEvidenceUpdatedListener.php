<?php

namespace App\Listeners;

use App\Events\ControlEvidenceUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\ControlControlObjective;
use App\Models\Evidence;
use App\Models\FrameworkControlTestAudit;

class ControlEvidenceUpdatedListener
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
     * @param  \App\Events\ControlEvidenceUpdated  $event
     * @return void
     */
    public function handle(ControlEvidenceUpdated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Evidence_Update')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $evidence = $event->evidence;

        $Auditer = FrameworkControlTestAudit::where('framework_control_id', $evidence->controlControlObjective->control['id'])->latest()->first()->tester ?? Null;
        // Define the roles array for notification

        $roles = [
            'Evidence-Creator' => [$evidence->creator_id ?? null],
            'Control-Owner' => [$evidence->controlControlObjective->control->User->id ?? null],
            'Responsible_Person' => [$evidence->controlControlObjective->responsibleUser->id ?? null],
            'Control-Tester' => [$evidence->controlControlObjective->control->FrameworkControlTest->UserTester->id ?? null],
            'Auditer' => [$Auditer ?? null]

        ];

        $link = ['link' => route('admin.governance.control.list')];

        // Set the properties of the risk object for notification message

        //   $control->control_owner=$control->owners ? $control->owners->name : null;

        $evidence->Evidence_Creator = $evidence->creator ? $evidence->creator->name : null;
        $evidence->Control_Objective = $evidence->controlControlObjective ? $evidence->controlControlObjective->objective->name : null;
        $evidence->Control_Objective_Responsible = $evidence->controlControlObjective ? $evidence->controlControlObjective->responsible->name : null;
        $evidence->Control_Name = $evidence->controlControlObjective ? $evidence->controlControlObjective->control->short_name : null;

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $evidence, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
