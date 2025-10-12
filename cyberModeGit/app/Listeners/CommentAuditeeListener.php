<?php

namespace App\Listeners;

use App\Events\CommentAuditee;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentAuditeeListener
{
    use NotificationHandlingTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentAuditee $event)
    {
         // Getting the action ID of the event
         $action1 = Action::where('name', 'addCommentForComplianceDocument')->first();
         $actionId1 = $action1['id'];
         // Getting the model from the event
         $comment = $event->comment;

         $roles = [
             'Document-Owner' => [$comment->auditDocumentPolicy->document->owner->id ?? null],
             'Auditees' => [$comment->user->id ?? null],
             'Auditer' => [$comment->auditDocumentPolicy->owner_id ?? null],
         ];
 
         $comment->Comment = $comment->comment;
         $comment->Policy_clause = $comment->documentPolicy->policy->policy_name;
         $comment->Document_Name = $comment->auditDocumentPolicy->document->document_name;
         $comment->Document_Owner = $comment->auditDocumentPolicy->document->owner->name;
         $comment->Auditer =$comment->auditDocumentPolicy->users->name;
         $comment->Auditee = $comment->user->name;

        
         // defining the link we want the user to be redirected to after clicking the system notification
         $link = ['link' => route('admin.governance.Aduit.document.policy')];
 
         $actionId2 = null;
         $nextDateNotify = null;
         $modelId = null;
         $modelType = null;
         $proccess = null;
         // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
         $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $comment, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
