<?php

namespace App\Listeners;

use App\Events\SurveyUpdated;
use App\Models\User;
use App\Models\Team;
use App\Http\Traits\NotificationTeamTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SurveyUpdatedListener
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
   * @param  \App\Events\SurveyUpdated  $event
   * @return void
   */
  public function handle(SurveyUpdated $event)
  {

    // getting the action id of event
    $action1 = Action::where('name', 'survey_update')->first();
    $actionId1 = $action1['id'];

    $action2 = Action::where('name', 'Survey_Notify_Before_Last_Review_Date')->first();
    $actionId2 = $action2['id'];


    // getting the model of event
    $awarenessSurvey = $event->awarenessSurvey;

    $Teams = $awarenessSurvey->team ? explode(',', $awarenessSurvey->team) : [];
    $teams2 = [];
    $teamsNames = '';
    if (!empty($awarenessSurvey->team)) {
      foreach ($Teams as $teamId) {
        array_push($teams2, $teamId);
        $team = Team::find($teamId);
        $teamsNames .= $team->name . ', ';
      }
      $teamsNames = rtrim($teamsNames, ', ');
      $teamsNames = '(' . $teamsNames . ')';
    }

    $stakeholders = $awarenessSurvey->additional_stakeholder ? explode(',', $awarenessSurvey->additional_stakeholder) : [];
    $stakeholders2 = [];
    $stakeholdersNames = '';
    if (!empty($awarenessSurvey->additional_stakeholder)) {
      foreach ($stakeholders as $stakeholderId) {
        array_push($stakeholders2, $stakeholderId);
        $stakeholder = User::find($stakeholderId);
        $stakeholdersNames .= $stakeholder->name . ', ';
      }
      $stakeholdersNames = rtrim($stakeholdersNames, ', ');
      $stakeholdersNames = '(' . $stakeholdersNames . ')';
    }

    // reviewers
    $reviewer = explode(',', $awarenessSurvey->reviewer);
    $reviewer2 = [];
    $reviewersNames = '';
    if (!empty($awarenessSurvey->reviewer)) {
      foreach ($reviewer as $review) {
        array_push($reviewer2, $review);

        $reviewer_person = User::find($review);

        $reviewersNames .= $reviewer_person->name . ', ';
      }
      $reviewersNames = rtrim($reviewersNames, ', ');
      $reviewersNames = '(' . $reviewersNames . ')';
    }

    $roles = [
      'creator' => [$awarenessSurvey->created_by ?? null],
      'Team-teams' => $teams2 ?? null,
      'Stakeholder-teams' => $stakeholders2 ?? null,
      'reviewers-teams' => $reviewer2 ?? null,
    ];


    // to get the column in database appear in notification as string not int
    $awarenessSurvey->Name = $awarenessSurvey->name ? $awarenessSurvey->name : null;
    $awarenessSurvey->Status = $awarenessSurvey->status ? $awarenessSurvey->status->name : null;
    $awarenessSurvey->Description = $awarenessSurvey->description ? $awarenessSurvey->description : null;
    $awarenessSurvey->Created_By =  $awarenessSurvey->created_by_user ? $awarenessSurvey->created_by_user->name : null;
    $awarenessSurvey->Teams = $teamsNames ?? null;
    $awarenessSurvey->Additional_Stakeholder = $stakeholdersNames ?? null;
    $awarenessSurvey->Privacy = $awarenessSurvey->test_priv ? $awarenessSurvey->test_priv->title : null;
    $awarenessSurvey->Reviewer = $reviewersNames ?? null;
    $modelId = $awarenessSurvey->id;
    $proccess = "update";
    $modelType = "survey";
    //   to get number od days
    $NumbersOfDays = DB::table('auto_notifies')
      ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
      ->where('actions.name', 'Survey_Notify_Before_Last_Review_Date')
      ->select('auto_notifies.date')
      ->first();

    if ($NumbersOfDays) {
      // Decode the JSON string to an array of integers
      $datesArray = json_decode($NumbersOfDays->date, true);

      if (is_array($datesArray)) {
        $DateNotify = $awarenessSurvey->next_review_date ? $awarenessSurvey->next_review_date : null;
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
    // defining the link we want the user to be redirected to after clicking the system notification
    $link = ['link' => route('admin.awarness_survey.index')];
    // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
    if ($NumbersOfDays == null) {
      $this->sendNotificationForAction($actionId1, $actionId2, $link, $awarenessSurvey, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
    } else if ($NumbersOfDays !== null) {
      $this->sendNotificationForAction($actionId1, $actionId2, $link, $awarenessSurvey, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
    }
  }
}
