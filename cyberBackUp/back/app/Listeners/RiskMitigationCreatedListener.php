<?php

namespace App\Listeners;

use App\Events\RiskMitigationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Risk;
use App\Models\Mitigation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RiskMitigationCreatedListener
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
     * @param  \App\Events\RiskMitigationCreated  $event
     * @return void
     */
    public function handle(RiskMitigationCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Risk_Mitigation')->first();
        $actionId1 = $action1['id'];
        $action2 = Action::where('name', 'Risk_Review_Notify_Before_Last_End_Date')->first();
        $actionId2 = $action2['id'];

        // Get the risk object from the event
        $risk = $event->risk;
        $mitigation = $event->mitigation;


        // Define the roles array for notification
        $roles = [
            'creator' => [$risk->owner_id] ?? null,
            'Team-teams' => $mitigation->teams->pluck('id') ?? null,
            'Stakeholder-teams' => $risk->additionalStakeholders->pluck('user_id') ?? null,
            'mit_owner'=>[$mitigation->mitigation_owner] ?? null,
        ];

        
        // Define teams in the desired format for notification message
        $teams = $mitigation->teams;
        $teamsNames = '';
        if (!empty($teams)) {
            foreach ($teams as $team) {
                $teamsNames .= $team->name . ', ';
            }
            $teamsNames = rtrim($teamsNames, ', ');
            $teamsNames = '(' . $teamsNames . ')';
        }
        // Assign teamsNames to vulnerability "each variable MUST be assigned to model like this to show it in the message properly"
        $mitigation->teams = $teamsNames;

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


        $id = $risk->id ?? $mitigation->risk_id;
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.risk_management.show', ['id' => $id])];

        // Set the properties of the risk object for notification message
        $risk->Additional_Stakeholder = $additionalStakeholdersNames;
        $risk->Owner = $risk->owner ? $risk->owner->name : null;
        $risk->Team = $teamsNames;

        $mitigation->planning_strategy=$mitigation->planningStrategies ? $mitigation->planningStrategies->name : null;
        $mitigation->mitigation_effort=$mitigation->mitigationEfforts ? $mitigation->mitigationEfforts->name : null;
        $risk->Plan=$mitigation->planningStrategies ? $mitigation->planningStrategies->name : null;
        $risk->Effort=$mitigation->mitigationEfforts ? $mitigation->mitigationEfforts->name : null;

        $risk->Current_Solution=$mitigation->current_solution ? $mitigation->current_solution : null;
        $risk->Mitigation_Coast=$mitigation->mitigation_cost ? $mitigation->mitigation_cost : null;
   
 
        $risk->Security_Requirements=$mitigation->security_requirements ? $mitigation->security_requirements : null;
        $risk->Security_Recommendations=$mitigation->security_recommendations ? $mitigation->security_recommendations : null;
     
        $risk->Planning_Date=$mitigation->planning_date ? $mitigation->planning_date : null;
        $risk->Mitigation_Percent=$mitigation->mitigation_percent ? $mitigation->mitigation_percent : null;

        $modelId = $risk->id ?? $mitigation->risk_id;
        $proccess = "create";

        $modelType = "MitigationRisk";
        //   to get number od days
        $NumbersOfDays = DB::table('auto_notifies')
            ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
            ->where('actions.name', 'Risk_Review_Notify_Before_Last_End_Date')
            ->select('auto_notifies.date')
            ->first();

            if ($NumbersOfDays) {
                // Decode the JSON string to an array of integers
                $datesArray = json_decode($NumbersOfDays->date, true);

                if (is_array($datesArray)) {
                    $DateNotify = $mitigation->planning_date ? $mitigation->planning_date : null;
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
        // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
        if ($NumbersOfDays == null) {
            $this->sendNotificationForAction($actionId1, $actionId2,$link, $risk, $roles, $nextDateNotify = null, $modelId, $modelType,$proccess);
        } else if($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2,$link, $risk, $roles, $nextDateNotify , $modelId, $modelType,$proccess);
        }
        }
}
