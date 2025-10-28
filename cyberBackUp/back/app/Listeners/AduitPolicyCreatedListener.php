<?php

namespace App\Listeners;

use App\Events\AduitPolicyCreated;
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
use App\Models\ControlAuditPolicy;
use App\Models\Team;

class AduitPolicyCreatedListener
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
     * @param  \App\Events\AduitPolicyCreated  $event
     * @return void
     */
    public function handle(AduitPolicyCreated $event)
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name','Aduit_Policy_Add')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $controlAuditPolicy = $event->controlAuditPolicy;


        $Teams = explode(',', $controlAuditPolicy->document->team_ids);
        $teams2 = [];
        $teamsNames = '';
        if (!empty($controlAuditPolicy->document->team_ids)) {
            foreach ($Teams as $teamId) {
                array_push($teams2, $teamId);
                $team = Team::find($teamId);
                $teamsNames .= $team->name . ', ';
            }
            $teamsNames = rtrim($teamsNames, ', ');
            $teamsNames = '(' . $teamsNames . ')';
        }

        $stakeholders = explode(',', $controlAuditPolicy->document->additional_stakeholders);
        $stakeholders2 = [];
        $stakeholdersNames = '';
        if (!empty($controlAuditPolicy->document->additional_stakeholders)) {
            foreach ($stakeholders as $stakeholderId) {
                array_push($stakeholders2, $stakeholderId);
                $stakeholder = User::find($stakeholderId);
                $stakeholdersNames .= $stakeholder->name . ', ';
            }
            $stakeholdersNames = rtrim($stakeholdersNames, ', ');
            $stakeholdersNames = '(' . $stakeholdersNames . ')';
        }

        // reviewers
        $reviewer = explode(',', $controlAuditPolicy->document->document_reviewer);
        $reviewer2 = [];
        $reviewersNames = '';
        if (!empty($controlAuditPolicy->document->document_reviewer)) {
            foreach ($reviewer as $review) {
                array_push($reviewer2, $review);

                $reviewer_person = User::find($review);

                $reviewersNames .= $reviewer_person->name . ', ';
            }
            $reviewersNames = rtrim($reviewersNames, ', ');
            $reviewersNames = '(' . $reviewersNames . ')';
        }

        // Define the roles array for notification
        $roles = [
            'Control-Owner' => [$controlAuditPolicy->frameworkcontrol->FrameworkControl->control_owner ?? null],
            'Control-Tester' => [$controlAuditPolicy->frameworkcontrol->UserTester->id ?? null],
            'Document-Owner' => [$controlAuditPolicy->document->owned_by_user->id ?? null],
            'Document-Stakeholder' =>$stakeholders2 ?? null,
            'Document-Teams' => $teams2 ?? null,
            'Document-reviewers' => $reviewer2 ?? null ,
            'Creator' => [$controlAuditPolicy->document->created_by ?? null],
        ];
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.compliance.audit.index')];

        $controlAuditPolicy->Document_Audit_Status = $controlAuditPolicy->document_audit_status ? $controlAuditPolicy->document_audit_status : null;
        $controlAuditPolicy->Test_Tester = $controlAuditPolicy->frameworkcontrol ? $controlAuditPolicy->frameworkcontrol->UserTester->name : null;
        $controlAuditPolicy->Control_Owner = $controlAuditPolicy->frameworkcontrol ? $controlAuditPolicy->frameworkcontrol->FrameworkControl->owner->name : null;
        $controlAuditPolicy->Control_Name = $controlAuditPolicy->frameworkcontrol ? $controlAuditPolicy->frameworkcontrol->FrameworkControl->short_name : null;
        $controlAuditPolicy->Document_Name = $controlAuditPolicy->document ? $controlAuditPolicy->document->document_name : null;
        $controlAuditPolicy->Document_Owner = $controlAuditPolicy->document ? $controlAuditPolicy->document->owned_by_user->name : null;
        $controlAuditPolicy->Additional_Stakeholder_Document = $stakeholdersNames ?? null ;
        $controlAuditPolicy->Document_Teams = $teamsNames ?? null;
        $controlAuditPolicy->Document_Reviewer  = $reviewersNames ?? null;
        $controlAuditPolicy->Creator_Document  = $controlAuditPolicy->document ? $controlAuditPolicy->document->created_by_user->name : null;



        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $controlAuditPolicy, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
