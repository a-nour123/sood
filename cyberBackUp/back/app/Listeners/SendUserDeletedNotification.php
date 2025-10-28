<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserDeletedNotification
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
     * @param  \App\Events\UserDeleted  $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name','UserDelete')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $user = $event->user;

        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');
        
        // Define the roles array for notification
        $roles = [
           'User' => [$user->id ?? null],
        ];
        
         // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.configure.index')];
       $user->UserName=$user->username;

        
        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        // Call the function to handle different kinds of notifications

        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $user, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
