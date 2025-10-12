<?php

namespace App\Listeners;

use App\Events\AddAuditPolicy;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\AutoNotify;
use App\Models\CenterPolicy;
use App\Models\DocumentPolicy;
use App\Models\NotifyAtDateModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AddAuditPolicyListener
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


    public function handle(AddAuditPolicy $event)
    {
        // Getting the action ID of the event
        $action1 = Action::where('name', 'AddAduitPolicy')->first();
        $actionId1 = $action1['id'];


        $action2 = Action::where('name', 'AutoNotifyPolicyAuditBeforeDueDate')->first();
        $actionId2 = $action2['id'];

        // Getting the model from the event
        $auditDocumentPolicy = $event->auditDocumentPolicy;
        $policyDocumentIds = $event->policyDocumentIds;

        // Exploding the document_ids to get each document as an individual item
        $AuditeesId = explode(',', $auditDocumentPolicy->responsible);
        $AuditeesNames = User::WhereIn('id', $AuditeesId)->pluck('name')->toArray();
        $AuditeesNamesString = implode(', ', $AuditeesNames);


        $DocumentPolicesIds = DocumentPolicy::whereIn('id', $policyDocumentIds)->pluck('policy_id')->toArray();
        $policiesName = CenterPolicy::whereIn('id', $DocumentPolicesIds)->pluck('policy_name')->toArray();
        $policiesNameString = implode(', ', $policiesName);



        $roles = [
            'Document-Owner' => [$auditDocumentPolicy->document->owner->id ?? null],
            'Auditees' => $AuditeesId ?? null,
            'Auditer' => [$auditDocumentPolicy->owner_id ?? null],
        ];

        // to get the column in database appear in notification as string not int
        $auditDocumentPolicy->Policy_clause = $policiesNameString;
        $auditDocumentPolicy->Document_Name = $auditDocumentPolicy->document->document_name;
        $auditDocumentPolicy->Document_Owner = $auditDocumentPolicy->document->owner->name;
        $auditDocumentPolicy->Auditer = $auditDocumentPolicy->users->name;
        $auditDocumentPolicy->Auditees = $AuditeesNamesString;
        $auditDocumentPolicy->Start_Date = $auditDocumentPolicy->start_date;
        $auditDocumentPolicy->Due_Date = $auditDocumentPolicy->due_date;
        $auditDocumentPolicy->PeriodicalTime = $auditDocumentPolicy->periodical_time;
        $auditDocumentPolicy->Next_Intiate_Date = $auditDocumentPolicy->next_initiate_date;
        // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.governance.Aduit.document.policy')];
        $modelId = $auditDocumentPolicy->id;
        $proccess = "create";

        $modelType = "audit policy";
        //   to get number od days
        $NumbersOfDays = DB::table('auto_notifies')
            ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
            ->where('actions.name', 'AutoNotifyPolicyAuditBeforeDueDate')
            ->select('auto_notifies.date')
            ->first();

        if ($NumbersOfDays) {
            // Decode the JSON string to an array of integers
            $datesArray = json_decode($NumbersOfDays->date, true);

            if (is_array($datesArray)) {
                $DateNotify = $auditDocumentPolicy->Due_Date ? $auditDocumentPolicy->Due_Date : null;
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


        $actionOfAutoNotify = Action::where('name', 'AutoNotifyPolicyAuditEsclation')->first();
        $actionOfAutoNotifyId = $actionOfAutoNotify['id'];
        
        $systemNotificationSettingOfAutoNotify = AutoNotify::where('action_id', $actionOfAutoNotifyId)->first();
        if ($systemNotificationSettingOfAutoNotify && $systemNotificationSettingOfAutoNotify['status']) {
            $escalationDays = DB::table('auto_notifies')
                ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
                ->where('actions.name', 'AutoNotifyPolicyAuditEsclation')
                ->select('auto_notifies.date')
                ->first();
        
            if ($escalationDays) {
                // Decode the JSON string to an array of integers
                $escalationDatesArray = json_decode($escalationDays->date, true);
        
                if (is_array($escalationDatesArray)) {
                    $escalationDateNotify = $auditDocumentPolicy->Due_Date ? $auditDocumentPolicy->Due_Date : null;
                    $escalationNextDateNotify = [];
        
                    foreach ($escalationDatesArray as $days) {
                        // Convert days to an integer and add to Due_Date
                        $escalationDaysToAdd = (int) $days;
        
                        $carbonDate = Carbon::parse($escalationDateNotify);
                        $nextDate = $carbonDate->addDays($escalationDaysToAdd);
                        $escalationNextDateNotify[] = $nextDate->format('Y-m-d');
                    }
                }
            }
            
            NotifyAtDateModel::updateOrCreate(
                ['model_id' => $modelId, 'model_type' => "Audit_Policy_Skip_Due_Date"],
                [
                    'model' => json_encode($auditDocumentPolicy),
                    'roles' => json_encode([]),
                    'action_id' => $actionOfAutoNotifyId,
                    'link' => json_encode($link),
                    'notification_date' => json_encode($escalationNextDateNotify),
                    'model_type' => "Audit_Policy_Skip_Due_Date",
                    'model_id' => $modelId,
                    'proccess' => $proccess
                ]
            );
        }
        
        
        // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
        if ($NumbersOfDays == null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $auditDocumentPolicy, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
        } else if ($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $auditDocumentPolicy, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
        }
    }
}
