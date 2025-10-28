<?php

namespace App\Listeners;

use App\Events\MitigationAcceptUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\NotifyAtDateModel;
use App\Models\Team;
use App\Models\User;

class MitigationAcceptUserCreatedListener
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
     * @param  \App\Events\MitigationAcceptUserCreated  $event
     * @return void
     */
    public function handle(MitigationAcceptUserCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Mitigation_accept')->first();
        $actionId1 = $action1['id'];
        
        // Get the risk object from the event
        $MitigationAcceptUser = $event->MitigationAcceptUser;
        // Define the roles array for notification
        $roles = [
            'creator' => [$MitigationAcceptUser->risk->owner_id ?? null],
            'Mitigation_Acceptor'=>[$MitigationAcceptUser->user_id ?? null ]
        ];
        $id = $MitigationAcceptUser->risk_id;
        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.risk_management.show', ['id' => $id])];

        $MitigationAcceptUser->Risk_Name = $MitigationAcceptUser->risk->subject ?? null ;
        $MitigationAcceptUser->Mitigation_Acceptor = $MitigationAcceptUser->user->name ?? null ;


        if ($MitigationAcceptUser->Mitigation_Acceptor !== null) {
            NotifyAtDateModel::where('model_type', 'MitigationRisk')
                ->where('model_id', $id)
                ->delete();
        }
        // Call the function to handle different kinds of notifications
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $MitigationAcceptUser, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
