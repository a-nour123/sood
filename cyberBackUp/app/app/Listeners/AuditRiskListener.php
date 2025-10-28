<?php

namespace App\Listeners;

use App\Events\AuditRiskCreated;
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

class AuditRiskListener
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
     * @param  \App\Events\AuditRiskCreated  $event
     * @return void
     */
    public function handle(AuditRiskCreated $event)
    {

              // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Audit_Risk_Add')->first();
        $actionId1 = $action1['id'];
        
        // Get the risk object from the event
        $risk = $event->risk;
        $FrameworkControlTestResult = $event->FrameworkControlTestResultsToRisk;
        $frameworkControlTestAudits = $FrameworkControlTestResult->frameworkControlTestAudits;
        $frameworkControl=$frameworkControlTestAudits->FrameworkControl;

        // Define the roles array for notification
        $roles = [
            'creator' => $risk->owner_id ?? null,
            'Team-teams' => $risk->teamsForRisk->pluck('id') ?? null,
            'Stakeholder-teams' => $risk->additionalStakeholders->pluck('user_id') ?? null,
            'Control-Owner' => $frameworkControlTestAudits->FrameworkControl->control_owner ?? null,
            'Control-Tester' => $frameworkControlTestAudits->UserTester->id ?? null,
        ];
        
        // dd($roles);
        
        // Define teams in the desired format for notification message
        $teams = $risk->teamsForRisk;
        $teamsNames = '';
        if (!empty($teams)) {
            foreach ($teams as $team) {
                $teamsNames .= $team->name . ', ';
            }
            $teamsNames = rtrim($teamsNames, ', ');
            $teamsNames = '(' . $teamsNames . ')';
        }
        // Assign teamsNames to vulnerability "each variable MUST be assigned to model like this to show it in the message properly"
        $risk->teamsForRisk = $teamsNames;
        // Define additional stakeholders in the desired format for notification message
        $additionalStakeholderss = $risk->additionalStakeholders;
        $additionalStakeholdersNames = '';
        if (!empty($additionalStakeholderss)) {
            foreach ($additionalStakeholderss as $additionalStakeholder) {
                $addational=User::find($additionalStakeholder->user_id);
                $additionalStakeholdersNames .= $addational->name . ', ';
            }
            $additionalStakeholdersNames = rtrim($additionalStakeholdersNames, ', ');
            $additionalStakeholdersNames = '(' . $additionalStakeholdersNames . ')';
        }
        // Assign additionalStakeholdersNames to vulnerability "each variable MUST be assigned to model like this to show it in the message properly"
        $risk->additionalStakeholders = $additionalStakeholdersNames;

        // Define risk catalog mappings in the desired format for notification message
        $risk_catalog_mappings = explode(',', $risk->risk_catalog_mapping);
        $risk_catalog_mappings2 = [];
        $risk_catalog_mappings_Names = '';
        if (!empty($risk->risk_catalog_mapping)) {
            foreach ($risk_catalog_mappings as $risk_catalog_mappingsId) {
                array_push($risk_catalog_mappings2, $risk_catalog_mappingsId);
                $risk_catalog_mapping = RiskCatalog::find($risk_catalog_mappingsId);
                $risk_catalog_mappings_Names .= $risk_catalog_mapping->number . ', ';
            }
            $risk_catalog_mappings_Names = rtrim($risk_catalog_mappings_Names, ', ');
            $risk_catalog_mappings_Names = '(' . $risk_catalog_mappings_Names . ')';
        }
        $risk->risk_catalog_mapping = $risk_catalog_mappings_Names;
    
        // Define threat catalog mappings in the desired format for notification message
        $threat_catalog_mappings = explode(',', $risk->threat_catalog_mapping);
        $threat_catalog_mappings2 = [];
        $threat_catalog_mappings_Names = '';
        if (!empty($risk->threat_catalog_mapping)) {
            foreach ($threat_catalog_mappings as $threat_catalog_mappingsId) {
                array_push($threat_catalog_mappings2, $threat_catalog_mappingsId);
                $threat_catalog_mapping = ThreatCatalog::find($threat_catalog_mappingsId);
                $threat_catalog_mappings_Names .= $threat_catalog_mapping->number . ', ';
            }
            $threat_catalog_mappings_Names = rtrim($threat_catalog_mappings_Names, ', ');
            $threat_catalog_mappings_Names = '(' . $threat_catalog_mappings_Names . ')';
        }
        $risk->threat_catalog_mapping = $threat_catalog_mappings_Names;
    
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.risk_management.index')];

        // Set the properties of the risk object for notification message
        $risk->Source = $risk->source ? $risk->source->name : null;
        $risk->Category = $risk->category ? $risk->category->name : null;
        $risk->Regulation = $risk->framework ? $risk->framework->name : null;
        $risk->Additional_Stakeholder = $additionalStakeholdersNames;
        $risk->Owner = $risk->owner ? $risk->owner->name : null;
        $risk->Teams = $teamsNames;
        $risk->Owner_Risk = $risk->owner ? $risk->owner->name : null;
        $risk->Control_Owner =$frameworkControl->User ? $frameworkControl->User->name : null;
        $risk->Desired_Maturity =$frameworkControl->ControlDesiredMaturity ? $frameworkControl->ControlDesiredMaturity->name : null;
        $risk->Control_Priority =$frameworkControl->priority ? $frameworkControl->priority->name : null;
        $risk->Control_class =$frameworkControl->class ? $frameworkControl->class->name : null;
        $risk->Control_Maturity =$frameworkControl->ControlMaturity ? $frameworkControl->ControlMaturity->name : null;
        $risk->Control_Phase =$frameworkControl->ControlPhase ? $frameworkControl->ControlPhase->name : null;
        $risk->Control_Type =$frameworkControl->type ? $frameworkControl->type->name : null;
        $risk->Tester =$frameworkControlTestAudits->UserTester ? $frameworkControlTestAudits->UserTester->name : null;
        $risk->Test_Frequency =$frameworkControlTestAudits->test_frequency ? $frameworkControlTestAudits->test_frequency : null;
        $risk->Test_Name =$frameworkControlTestAudits->name ? $frameworkControlTestAudits->name : null;
        $risk->Test_Steps =$frameworkControlTestAudits->test_steps ? $frameworkControlTestAudits->test_steps : null;
        $risk->Approximate_Time =$frameworkControlTestAudits->approximate_time ? $frameworkControlTestAudits->approximate_time : null;
        $risk->Expected_Results =$frameworkControlTestAudits->expected_results ? $frameworkControlTestAudits->expected_results : null;

       
    // Call the function to handle different kinds of notifications
    $actionId2 = null;
    $nextDateNotify = null;
    $modelId = null;
    $modelType = null;
    $proccess = null;
    // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
    $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $risk, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
