<?php

namespace App\Listeners;

use App\Events\AuditResultCreated;
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
use App\Models\ControlControlObjective;
use App\Models\NotifyAtDateModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuditResultCreatedListener
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
     * @param  \App\Events\AuditResultCreated  $event
     * @return void
     */
    public function handle(AuditResultCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Audit_Main_Add')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $FrameworkControlTestResult = $event->FrameworkControlTestResult;
        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');

        // Define the roles array for notification
        $roles = [
            'Control-Owner' => [$FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->control_owner],
            'Control-Tester' => [$FrameworkControlTestResult->FrameworkControlTestAudit->UserTester->id],
        ];

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.compliance.audit.index')];

        $FrameworkControlTestResult->Summary = $FrameworkControlTestResult->summary ? $FrameworkControlTestResult->summary : null;
        $FrameworkControlTestResult->Test_Date = $FrameworkControlTestResult->test_date ? $FrameworkControlTestResult->test_date : null;
        $FrameworkControlTestResult->Test_Name = $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->name : null;
        $FrameworkControlTestResult->Test_Tester = $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->UserTester->name : null;
        $FrameworkControlTestResult->Test_Result = $FrameworkControlTestResult->testResult ? $FrameworkControlTestResult->testResult->name : null;
        $FrameworkControlTestResult->Control_Owner = $FrameworkControlTestResult->FrameworkControlTestAudit &&
            $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl &&
            $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->owner
            ? $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->owner->name
            : null;

        $FrameworkControlTestResult->Control_Name = $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->short_name : null;
        $FrameworkControlTestResult->Submission_Date = $FrameworkControlTestResult->submission_date ? $FrameworkControlTestResult->submission_date : null;
        $FrameworkControlTestResult->Aduit_Status =  $FrameworkControlTestResult->FrameworkControlTestAudit->TestStatus->name ?? null;
        // dd($FrameworkControlTestResult->FrameworkControlTestAudit->TestStatus->id);
        if ($FrameworkControlTestResult->FrameworkControlTestAudit->TestStatus->id == 5) {
            NotifyAtDateModel::where('model_type', 'controlAduit')
                ->where('model_id', $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->id)
                ->delete();
        }

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $FrameworkControlTestResult, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
