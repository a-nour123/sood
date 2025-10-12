<?php

namespace App\Listeners;

use App\Events\DocumentCommentCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentCommentCreatedListener
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
    public function handle(DocumentCommentCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'add_document_note')->first();

        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $documentComment = $event->comment;
        // getting the model of event
        $document = $documentComment->document ?? null;
       
        $Teams = explode(',', $document->team_ids);
        $teams2 = [];
        $teamsNames = '';
        if (!empty($document->team_ids)) {
            foreach ($Teams as $teamId) {
                array_push($teams2, $teamId);
                $team = Team::find($teamId);
                $teamsNames .= $team->name . ', ';
            }
            $teamsNames = rtrim($teamsNames, ', ');
            $teamsNames = '(' . $teamsNames . ')';
        }

        $stakeholders = explode(',', $document->additional_stakeholders);
        $stakeholders2 = [];
        $stakeholdersNames = '';
        if (!empty($document->additional_stakeholders)) {
            foreach ($stakeholders as $stakeholderId) {
                array_push($stakeholders2, $stakeholderId);
                $stakeholder = User::find($stakeholderId);
                $stakeholdersNames .= $stakeholder->name . ', ';
            }
            $stakeholdersNames = rtrim($stakeholdersNames, ', ');
            $stakeholdersNames = '(' . $stakeholdersNames . ')';
        }

        $control_ids = explode(',', $document->control_ids);
        $control_ids2 = [];
        $control_idsNames = '';

        if (!empty($document->control_ids)) {
            foreach ($control_ids as $controlId) {
                array_push($control_ids2, $controlId);
                $control = FrameworkControl::find($controlId);

                if ($control) {
                    $control_idsNames .= $control->short_name . ', ';
                }
            }

            $control_idsNames = rtrim($control_idsNames, ', ');
            $control_idsNames = '(' . $control_idsNames . ')';
        }

        $frame_ids = explode(',', $document->framework_ids);
        $frame_ids2 = [];
        $frame_idsNames = '';

        if (!empty($document->framework_ids)) {
            foreach ($frame_ids as $frameId) {
                array_push($frame_ids2, $frameId);
                $frame = Framework::find($frameId);

                if ($frame) {
                    $frame_idsNames .= $frame->name . ', ';
                }
            }

            $frame_idsNames = rtrim($frame_idsNames, ', ');
            $frame_idsNames = '(' . $frame_idsNames . ')';
        }

        
        $control_ids = explode(',', $document->control_ids);
        $controlOwners = [];

        if (!empty($document->control_ids)) {
            foreach ($control_ids as $controlId) {
                $control = FrameworkControl::find($controlId);

                if ($control) {
                    $controlOwners[] = $control->control_owner;
                }
            }
        }

        // Remove duplicate user IDs
        $controlOwners = array_unique($controlOwners);

        // Now $controlOwners contains unique user IDs associated with the control_owner column

        // Fetch only the user IDs
        $userIds = User::whereIn('id', $controlOwners)->pluck('id')->toArray();

        
        $roles = [
            'Document-Owner' => [$document->document_owner ?? null],
            'Team-teams' => $teams2 ?? null,
            'Stakeholder-teams' => $stakeholders2 ?? null,
            'Document-Creator' => [$document->created_by_user->id ?? null],
            'Control-Owner' => $userIds ?? null,
        ];
        $link = ['link' => route('admin.governance.category')];

        // to get the column in database appear in notification as string not int
        $document->note = $documentComment->note ?? null;
        $document->Document_Type = $document->documentTypes->first()->name ?? null;
        $document->Status = $document->status->first()->name ?? null;
        $document->Document_Name = $document->document_name ?? null;
        $document->Last_Review_Date = $document->last_review_date ?? null;
        $document->Next_Review_Date = $document->next_review_date ?? null;
        $document->Approval_Date = $document->approval_date ?? null;
        $document->Controls = $control_idsNames ?? null;
        $document->Teams = $teamsNames ?? null;
        $document->Stakeholders = $control_idsNames ?? null;
        $document->Frameworks = $frame_idsNames ?? null;
        $document->Reviewer = $document->owner->name ?? null;
        $document->Created_By = $document->created_by_user->name ?? null;
        // handling di // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $document, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
