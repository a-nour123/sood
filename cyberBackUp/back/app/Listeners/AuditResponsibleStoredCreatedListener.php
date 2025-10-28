<?php

namespace App\Listeners;

use App\Events\AuditResponsibleStoredCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AuditResponsibleStoredCreatedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(AuditResponsibleStoredCreated $event)
    {
        $action1 = Action::where('name', 'create_Schedule_aduit')->first();
        $actionId1 = $action1['id'];
        $action2 = Action::where('name', 'notify_DueDate_aduit')->first();
        $actionId2 = $action2['id'];
        $audit = $event->audit;
        if ($audit->responsible_type == "teams") {
            $Teams = $audit->responsible ? explode(',', $audit->responsible) : [];
            $teams2 = [];
            $teamsNames = '';
            if (!empty($audit->responsible)) {
                foreach ($Teams as $teamId) {
                    array_push($teams2, $teamId);
                    $team = Team::find($teamId);
                    $teamsNames .= $team->name . ', ';
                }
                $teamsNames = rtrim($teamsNames, ', ');
                $teamsNames = '(' . $teamsNames . ')';
            }
        } else {
            $Teams = $audit->responsible ? explode(',', $audit->responsible) : [];
            $teams2 = [];
            $teamsNames = '';
            if (!empty($audit->responsible)) {
                foreach ($Teams as $teamId) {
                    array_push($teams2, $teamId);
                    $team = User::find($teamId);
                    $teamsNames .= $team->name . ', ';
                }
                $teamsNames = rtrim($teamsNames, ', ');
                $teamsNames = '(' . $teamsNames . ')';
            }
        }
        $roles = [
            'auditor' => [$audit->owner_id ?? null],
            'assistants' => $teams2 ?? null,
        ];

        $link = ['link' => route('admin.compliance.audit.index')];
 
        // Set the properties of the risk object for notification message
        $audit->Assistant = $teamsNames ?: null;
        $audit->Regulator = $audit->regulatoraduit->name ?? null;
        $audit->Framework = $audit->frameworkaduit->name ?? null;
        $audit->Auditor = $audit->owner->name ?? null;
        $audit->AssistantType = $audit->responsible_type ?? null;
        $audit->StartDate = $audit->start_date ?? null;
        $audit->Duedate = $audit->due_date ?? null;
        $audit->periodicalTime = $audit->periodical_time ?? null;
        $audit->NextIntiateDate = $audit->next_initiate_date ?? null;

         $modelId = $audit->id;
        $proccess = "create";
        $modelType = "audit";
        //   to get number od days
        $NumbersOfDays = DB::table('auto_notifies')
          ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
          ->where('actions.name', 'notify_DueDate_aduit')
          ->select('auto_notifies.date')
          ->first();
 
        if ($NumbersOfDays) {
          // Decode the JSON string to an array of integers
          $datesArray = json_decode($NumbersOfDays->date, true);
    
          if (is_array($datesArray)) {
            $DateNotify = $audit->due_date ? $audit->due_date : null;
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
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $audit, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
        } else if ($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $audit, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
        }
    }
}
