<?php

namespace App\Listeners;

use App\Events\JobCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Job;

class JobCreatedListener
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
     * @param  \App\Events\JobCreated  $event
     * @return void
     */
    public function handle(JobCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name','Job_Add')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $job = $event->job;

        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');
        
        // Define the roles array for notification
        $roles = [
        ];
        

    


        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.hierarchy.job.index')];
    


        
        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        // Call the function to handle different kinds of notifications

        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $job, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
