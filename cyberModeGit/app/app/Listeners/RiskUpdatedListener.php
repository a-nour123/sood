<?php

namespace App\Listeners;

use App\Events\RiskUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\RiskCreated;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\RiskCatalog;
use App\Models\ThreatCatalog;
class RiskUpdatedListener
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
     * @param  \App\Events\RiskUpdated  $event
     * @return void
     */
    public function handle(RiskUpdated $event)
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Risk_Update')->first();
        $actionId1 = $action1['id'];
        
        // Get the risk object from the event
        $risk = $event->risk;
    
        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');
        
        // Define the roles array for notification
        $roles = [
            'creator' => [$risk->owner_id ?? null],
            'Team-teams' => $risk->teamsForRisk->pluck('id') ?? null,
            'Stakeholder-teams' => $risk->additionalStakeholders->pluck('user_id') ?? null,

        ];
        
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
    



        $lastComment = $risk->comments->last(); // Retrieve the last comment from the collection

        if (!empty($lastComment)) {
            $commentsNames = '(' . $lastComment->comment . ')';
        } else {
            $commentsNames = ''; // Set the variable to empty if there are no comments
        }
        
        $risk->comments = $commentsNames;


        $id = $risk->id;
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.risk_management.show', ['id' => $id])];
    
        // Set the properties of the risk object for notification message
    
        $risk->Source = $risk->source ? $risk->source->name : null;
        $risk->Category = $risk->category ? $risk->category->name : null;
        $risk->Regulation = $risk->framework ? $risk->framework->name : null;
        $risk->Additional_Stakeholder = $additionalStakeholdersNames;
        $risk->Owner = $risk->owner ? $risk->owner->name : null;
        $risk->team = $teamsNames ?? null ;
        $risk->comments = $commentsNames ?? null;

        // Call the function to handle different kinds of notifications
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $risk, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);    }
}
