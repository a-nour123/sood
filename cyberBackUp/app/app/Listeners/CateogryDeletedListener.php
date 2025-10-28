<?php

namespace App\Listeners;

use App\Events\CateogryDeleted;
use App\Http\Traits\NotificationTeamTrait;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\DocumentTypes;

class CateogryDeletedListener
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
     * @param  \App\Events\CateogryDeleted  $event
     * @return void
     */
    public function handle(CateogryDeleted $event)
    {
        // getting the action id of event
        $action1 = Action::where('name', 'Cateogry_Delete')->first();
        $actionId1 = $action1['id'];
 
        // getting the model of event
        $doc = $event->doc;
        $roles = [];
        // to get the column in database appear in notification as string not int
        $doc->Name = $doc->name;
        // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.governance.category')];

    // Call the function to handle different kinds of notifications
    $actionId2 = null;
    $nextDateNotify = null;
    $modelId = null;
    $modelType = null;
    $proccess = null;
    // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
    $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $doc, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
