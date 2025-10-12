<?php

namespace App\Listeners;

use App\Events\ObjectiveAchievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\FrameworkControlTestResult;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;
use App\Models\Risk;
use App\Models\RiskCatalog;
use App\Models\ThreatCatalog;
use App\Models\FrameworkControlTestComment;
use App\Models\ControlAuditObjective;

class ObjectiveAchievementListener
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
     * @param  \App\Events\ObjectiveAchievement  $event
     * @return void
     */
    public function handle(ObjectiveAchievement $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Objective_Achievement')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $controlAuditObjective = $event->controlAuditObjective;

        $roles = [
            'Control-Owner' => [$controlAuditObjective->controlControlObjective->control->control_owner ?? null],
            'Control-Tester' => [$controlAuditObjective->controlControlObjective->control->FrameworkControlTest->UserTester->name ?? null],
            'Responsible-Person' => [$controlAuditObjective->controlControlObjective->responsibleUser->id ?? null]
        ];

        $link = ['link' => route('admin.compliance.audit.index')];

        // Set the properties of the risk object for notification message
        $controlAuditObjective->Control_Name = $controlAuditObjective->controlControlObjective->control->short_name ?? null;
        $controlAuditObjective->Control_Owner = $controlAuditObjective->controlControlObjective->control->User->name ?? null;
        $controlAuditObjective->Control_Tester = $controlAuditObjective->controlControlObjective->control->FrameworkControlTest->UserTester->name ?? null;
        $controlAuditObjective->Objective_Audit_status = $controlAuditObjective->objective_audit_status ?? null;
        $controlAuditObjective->Control_Objective_Name = $controlAuditObjective->controlControlObjective->objectivestest->name ?? null;
        // $controlAuditObjective->Objective_Audit_Name = $controlAuditObjective->controlObjective ?? null;

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $controlAuditObjective, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
