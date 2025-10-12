<?php

namespace App\Listeners;

use App\Events\initiateAssessmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Framework;
use App\Models\Department;

class initiateAssessmentCreatedListener
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
     * @param  \App\Events\initiateAssessmentCreated  $event
     * @return void
     */
    public function handle(initiateAssessmentCreated $event)
    {
         // Get the action ID for Risk_Add

         $action1 = Action::where('name','initiate_Assessment')->first();
         $actionId1 = $action1['id'];
 
         // Get the risk object from the event
         $KPI = $event->KPI;
         // Eager load the teamsForRisk relationship
         // $risk->load('teamsForRisk');
         
         // Define the roles array for notification
         $roles = [
            'creator'=> [$KPI->created_by_user->id ?? null],
            'manager'=> [$KPI->department->manager->id ?? null ]
         ];

         $KPI->Title = $KPI->title ?? null ;
         $KPI->Description = $KPI->description ?? null ;
         $KPI->Department_Name = $KPI->department->name ?? null ;
         $KPI->Department_Owner = $KPI->department->manager->name ?? null ;

         // Define the link for redirection after clicking the system notification
         $link = ['link' => route('admin.KPI.index')];
 
         // $framework->control_domain= $framework->families ? $framework->families->framework_id : null;
         // dd($framework->control_domain);
 
         
         $actionId2=null;
         $nextDateNotify = null;
         $modelId=null;
         $modelType=null;
         $proccess=null;
         // Call the function to handle different kinds of notifications
 
         $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $KPI, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
