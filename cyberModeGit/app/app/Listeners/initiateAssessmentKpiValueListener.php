<?php

namespace App\Listeners;

use App\Events\initiateAssessmentKpiValue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Framework;
use App\Models\Department;
use App\Models\NotifyAtDateModel;

class initiateAssessmentKpiValueListener
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
     * @param  \App\Events\initiateAssessmentKpiValue  $event
     * @return void
     */
    public function handle(initiateAssessmentKpiValue $event)
    {
        $action1 = Action::where('name','initiate_Assessment_value')->first();
        $actionId1 = $action1['id'];
          // Get the risk object from the event
          $assessment = $event->assessment;
          
          // Define the roles array for notification
          $roles = [
             'creator'=> [$assessment->kpi->created_by_user->id ?? null],
             'manager'=> [$assessment->action_by_user->id ?? null ]
          ];
        //   dd($roles);
 
          $assessment->Title = $assessment->kpi->title ?? null ;
          $assessment->Kpi_Creator = $assessment->kpi->created_by_user->name ?? null ;
          $assessment->Description = $assessment->kpi->description ?? null ;
          $assessment->Department_Name = $assessment->kpi->department->name ?? null ;
          $assessment->Department_Owner = $assessment->kpi->department->manager->name ?? null ;
          $assessment->assessment_value = $assessment->assessment_value ?? null ;

          
          // Define the link for redirection after clicking the system notification
          $link = ['link' => route('admin.KPI.index')];
  

          $assessmentId = $assessment->kpi->id ?? null ;

          NotifyAtDateModel::where('model_type','kpi')->where('model_id',$assessmentId)->delete();


          
          $actionId2=null;
          $nextDateNotify = null;
          $modelId=null;
          $modelType=null;
          $proccess=null;
          // Call the function to handle different kinds of notifications
  
          $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $assessment, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
