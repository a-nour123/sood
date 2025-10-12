<?php

namespace App\Listeners;

use App\Events\QuestionnaireDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Question;
use App\Models\FrameworkControl;
use App\Models\Questionnaire;

class QuestionnaireDeletedListener
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
     * @param  \App\Events\QuestionnaireDeleted  $event
     * @return void
     */
    public function handle(QuestionnaireDeleted $event)
    {
       
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Questionnaire_Delete')->first();
        $actionId1 = $action1['id'];
        
        // Get the risk object from the event
        $questionnaire = $event->questionnaire;
        $contacts = $event->contacts;

         // Eager load the teamsForRisk relationship
        $questionnaireIds = $contacts->pluck('id')->toArray();
 
         $roles = [
            'Questionnaire-contact' => $questionnaireIds ?? null ,
        ];

          // Define teams in the desired format for notification message
        
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.questionnaires.index')];
    
        // Set the properties of the risk object for notification message
        $questionnaire->Name = $questionnaire->name ? $questionnaire->name : null;
        $questionnaire->Instructions = $questionnaire->instructions ? $questionnaire->instructions : null;
        $questionnaire->Assessment = $questionnaire->assessment ? $questionnaire->assessment->name : null;
        $questionnaire->Answer_Percentage = $questionnaire->answer_percentage ? $questionnaire->answer_percentage : null;
 
        // Call the function to handle different kinds of notifications
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $questionnaire, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);    }
}
