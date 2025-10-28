<?php

namespace App\Listeners;

use App\Events\EvidenceAchievementCreated;
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


class EvidenceAchievementCreatedListener
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
     * @param  \App\Events\EvidenceAchievementCreated  $event
     * @return void
     */
    public function handle(EvidenceAchievementCreated $event)
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Evidence_Achievement')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $controlAuditEvidence = $event->controlAuditEvidence;
        $roles = [
            'Control-Owner' => [$controlAuditEvidence->evidence->controlControlObjective->control->User->id ?? null],
            'Control-Tester' => [$controlAuditEvidence->evidence->controlControlObjective->control->FrameworkControlTest->UserTester->id ?? null],
            'Responsible-Person' => [$controlAuditEvidence->evidence->controlControlObjective->responsibleUser->id?? null]
        ];

        $link = ['link' => route('admin.compliance.audit.index')];

        // Set the properties of the risk object for notification message
        $controlAuditEvidence->Control_Name = $controlAuditEvidence->evidence->controlControlObjective->control->short_name ?? null;
        $controlAuditEvidence->Control_Owner = $controlAuditEvidence->evidence->controlControlObjective->control->User->username ?? null;
        $controlAuditEvidence->Control_Tester = $controlAuditEvidence->evidence->controlControlObjective->control->FrameworkControlTest->UserTester->idusername ?? null;
        $controlAuditEvidence->Evidence_status = $controlAuditEvidence->evidence_audit_status ?? null;
        // $controlAuditObjective->Objective_Audit_Name = $controlAuditObjective->controlObjective ?? null;
        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $controlAuditEvidence, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
