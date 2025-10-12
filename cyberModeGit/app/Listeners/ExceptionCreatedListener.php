<?php

namespace App\Listeners;

use App\Events\ExceptionCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExceptionCreatedListener
{
    use NotificationHandlingTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */



    // public function handle(ExceptionCreated $event)
    // {
    //     // getting the action id of event
    //     $action1 = Action::where('name', 'exception_create')->first();
    //     $actionId1 = $action1['id'];
    //     // auto notify when update
    //     // $action2 = Action::where('name', 'eception_Notify_Before_Last_Review_Date')->first();
    //     // $actionId2 = $action2['id'];
    //     $action2=[];


    //     // getting the model of event
    //     $awarenessSurvey = $event->awarenessSurvey;

    //     $Teams = $awarenessSurvey->team ? explode(',', $awarenessSurvey->team) : [];
    //     $teams2 = [];
    //     $teamsNames = '';
    //     if (!empty($awarenessSurvey->team)) {
    //         foreach ($Teams as $teamId) {
    //             array_push($teams2, $teamId);
    //             $team = Team::find($teamId);
    //             $teamsNames .= $team->name . ', ';
    //         }
    //         $teamsNames = rtrim($teamsNames, ', ');
    //         $teamsNames = '(' . $teamsNames . ')';
    //     }

    //     $stakeholders = $awarenessSurvey->additional_stakeholder ? explode(',', $awarenessSurvey->additional_stakeholder) : [];
    //     $stakeholders2 = [];
    //     $stakeholdersNames = '';
    //     if (!empty($awarenessSurvey->additional_stakeholder)) {
    //         foreach ($stakeholders as $stakeholderId) {
    //             array_push($stakeholders2, $stakeholderId);
    //             $stakeholder = User::find($stakeholderId);
    //             $stakeholdersNames .= $stakeholder->name . ', ';
    //         }
    //         $stakeholdersNames = rtrim($stakeholdersNames, ', ');
    //         $stakeholdersNames = '(' . $stakeholdersNames . ')';
    //     }

    //     $roles = [
    //         'creator' => [$awarenessSurvey->created_by ?? null],
    //         'Team-teams' => $teams2 ?? null,
    //         'Stakeholder-teams' => $stakeholders2 ?? null,
    //     ];
    //     // dd($roles);
    //     // to get the column in database appear in notification as string not int
    //     $awarenessSurvey->Name = $awarenessSurvey->name ? $awarenessSurvey->name : null;
    //     $awarenessSurvey->Status = $awarenessSurvey->status ? $awarenessSurvey->status->name : null;
    //     $awarenessSurvey->Description = $awarenessSurvey->description ? $awarenessSurvey->description : null;
    //     $awarenessSurvey->Created_By = $awarenessSurvey->created_by_user ? $awarenessSurvey->created_by_user->name : null;
    //     $awarenessSurvey->Teams = $teamsNames ?? null;
    //     $awarenessSurvey->Additional_Stakeholder = $stakeholdersNames;
    //     $awarenessSurvey->Privacy = $awarenessSurvey->test_priv ? $awarenessSurvey->test_priv->title : null;
    //     $awarenessSurvey->Next_Review_Date = $awarenessSurvey->next_review_date ?? null;

    //     $modelId = $awarenessSurvey->id;
    //     $proccess = "create";

    //     $modelType = "survey";
    //     //   to get number od days
    //     $NumbersOfDays = DB::table('auto_notifies')
    //         ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
    //         ->where('actions.name', 'Survey_Notify_Before_Last_Review_Date')
    //         ->select('auto_notifies.date')
    //         ->first();

    //     if ($NumbersOfDays) {
    //         // Decode the JSON string to an array of integers
    //         $datesArray = json_decode($NumbersOfDays->date, true);

    //         if (is_array($datesArray)) {
    //             $DateNotify = $awarenessSurvey->next_review_date ? $awarenessSurvey->next_review_date : null;
    //             $nextDateNotify = [];

    //             foreach ($datesArray as $days) {
    //                 // Convert days to an integer and subtract from DateNotify
    //                 $numberOfDaysToSubtract = (int) $days;

    //                 $carbonDate = Carbon::parse($DateNotify);
    //                 $nextDate = $carbonDate->subDays($numberOfDaysToSubtract);
    //                 $nextDateNotify[] = $nextDate->format('Y-m-d');
    //             }

    //             // $nextDateNotifyArray now contains the results of subtracting each day from DateNotify.
    //             // You can use this array as needed.
    //         }
    //     }
    //     // dd($nextDateNotify);

    //     // defining the link we want the user to be redirected to after clicking the system notification
    //     $link = ['link' => route('admin.awarness_survey.index')];
    //     // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
    //     if ($NumbersOfDays == null) {
    //         $this->sendNotificationForAction($actionId1, $actionId2, $link, $awarenessSurvey, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
    //     } else if ($NumbersOfDays !== null) {
    //         $this->sendNotificationForAction($actionId1, $actionId2, $link, $awarenessSurvey, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
    //     }
    // }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ExceptionCreated $event)
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'exception_create')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $exception = $event->exception;

        // Define the roles array for notification
        $roles = [
            'Stakeholder' => [$exception->stakeholder ?? null],
            'policy_approver' => [$exception->policy_approver_id ?? null],
            'control_approver' => [$exception->control_approver_id ?? null],
            'risk_approver' => [$exception->risk_approver_id ?? null],
            //  'parent' => [$exception->parentDepartment->manager->id ?? null],
        ];
        $exception->Name = $exception->name;
        $exception->Creator = $exception->user->name;

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.hierarchy.department.index')];

        // Set the properties of the risk object for notification message

        $exception->Name = $exception->name;

        // parentDepartment
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // Call the function to handle different kinds of notifications

        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $exception, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
