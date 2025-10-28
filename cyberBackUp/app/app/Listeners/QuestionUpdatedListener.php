<?php

namespace App\Listeners;

use App\Events\QuestionUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Question;
use App\Models\FrameworkControl;

class QuestionUpdatedListener
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
     * @param  \App\Events\QuestionUpdated  $event
     * @return void
     */
    public function handle(QuestionUpdated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Question_Update')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $question = $event->question;

        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');

        // Define the roles array for notification
        $roles = [
            'Control-Owner' => [$question->control->User->id ?? null ],
        ];
        // Define teams in the desired format for notification message

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.assessment.index')];

        // Set the properties of the risk object for notification message
        $question->Control = $question->control ? $question->control->short_name : null;
        $question->Question = $question->question ? $question->question : null;

         // Call the function to handle different kinds of notifications
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $question, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);    }
}
