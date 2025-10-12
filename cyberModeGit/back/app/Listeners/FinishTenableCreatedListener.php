<?php

namespace App\Listeners;

use App\Events\FinishTenableCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FinishTenableCreatedListener
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
     * @param  \App\Events\FinishTenableCreated  $event
     * @return void
     */
    public function handle(FinishTenableCreated $event)
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'FinishTenable')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $tenable = $event->tenable;
        $roles = [   
        ];

       //defining the link we want user to be redirected to after clicking the system notification
       $link = ['link' => route('admin.vulnerability_management.index')];
       $actionId2=null;
       $nextDateNotify = null;
       $modelId=null;
       $modelType=null;
       $proccess=null;
       // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
       $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $tenable, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
