<?php

namespace App\Listeners;

use App\Events\AssessmentDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Traits\NotificationTeamTrait;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Assessment;
class AssessmentDeletedListener
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
     * @param  \App\Events\AssessmentDeleted  $event
     * @return void
     */
    public function handle(AssessmentDeleted $event)
    {
        // getting the action id of event
       $action1 = Action::where('name', 'Assessment_Delete')->first();
       $actionId1 = $action1['id'];

       // getting the model of event
       $assessment = $event->assessment;
        $roles = [];
       // to get the column in database appear in notification as string not int
       $assessment->Name = $assessment->name;
       // defining the link we want the user to be redirected to after clicking the system notification
       $link = ['link' => route('admin.assessment.index')];

       $actionId2=null;
       $nextDateNotify = null;
       $modelId=null;
       $modelType=null;
       $proccess=null;
       // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
       $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $assessment, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
