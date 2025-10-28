<?php

namespace App\Listeners;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleCommentObjectiveCreated
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
    public function handle($event)
    {
        // Get the action ID for 'AddComment'
        $action1 = Action::where('name', 'AddComment')->first();
        $actionId1 = $action1 ? $action1->id : null;

        // Get the comment and controlControlObjective from the event
        $comment = $event->comment;
        $controlControlObjective = $event->controlControlObjective;

        // Define the roles array for notification
        $roles = [
            'Control-Owner' => [$controlControlObjective->control && $controlControlObjective->control->User ? $controlControlObjective->control->User->id : null],
            'Responsible_Person' => [$controlControlObjective->responsible_id ?? null],
            'Control-Tester' => [$controlControlObjective->control && $controlControlObjective->control->FrameworkControlTest && $controlControlObjective->control->FrameworkControlTest->UserTester ? $controlControlObjective->control->FrameworkControlTest->UserTester->id : null],
            'Sender' => [$comment->user ? $comment->user->id : null],
        ];
        
        // Prepare the link for the notification
        $link = ['link' => route('admin.governance.control.list')];
        
        // Set the properties of the comment object for the notification message, using null if the related data does not exist
        $comment->Control_Owner = $controlControlObjective->control && $controlControlObjective->control->User ? $controlControlObjective->control->User->name : null;
        $comment->Control_Name = $controlControlObjective->control ? $controlControlObjective->control->short_name : null;
        $comment->Objective = $controlControlObjective->objective ? $controlControlObjective->objective->name : null;
        $comment->Responsible = $controlControlObjective->responsible ? $controlControlObjective->responsible->name : null;
        $comment->Sender = $comment->user ? $comment->user->name : null;
        $comment->comment = $comment->comment ?? null;
        

        // Send notification
        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $comment, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
