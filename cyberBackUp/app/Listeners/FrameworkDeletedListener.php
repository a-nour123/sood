<?php

namespace App\Listeners;

use App\Events\FrameworkDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Framework;
use App\Models\Family;

class FrameworkDeletedListener
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
     * @param  \App\Events\FrameworkDeleted  $event
     * @return void
     */
    public function handle(FrameworkDeleted $event)
    {
         // Get the action ID for Risk_Add
         $action1 = Action::where('name','Framework_Delete')->first();
         $actionId1 = $action1['id'];
 
         // Get the risk object from the event
         $framework = $event->framework;
     
         // Eager load the teamsForRisk relationship
         // $risk->load('teamsForRisk');
         
         // Define the roles array for notification
         $roles = [
         ];
         
         // Define the link for redirection after clicking the system notification
         $link = ['link' => route('admin.governance.index')];
         $framework->regulator = $framework->regulator->name ?? null;

         // $framework->control_domain= $framework->families ? $framework->families->framework_id : null;
         // dd($framework->control_domain);
 
         
         $actionId2=null;
         $nextDateNotify = null;
         $modelId=null;
         $modelType=null;
         $proccess=null;
         // Call the function to handle different kinds of notifications
 
         $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $framework, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
