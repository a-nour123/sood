<?php

namespace App\Listeners;

use App\Events\ChangeRequestDepartementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Department;
use App\Models\User;
use App\Models\Framework;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChangeRequestDepartementCreatedListener
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
     * @param  \App\Events\ChangeRequestDepartementCreated  $event
     * @return void
     */
    public function handle(ChangeRequestDepartementCreated $event)
    {
        $action1 = Action::where('name', 'change_Resbonsible_Manger')->first();
        $actionId1 = $action1['id'];
 
        // getting the model of event
        $responsible_department = $event->responsible_department;
        $departementName = Department::where('id', $responsible_department)->pluck('name')->first();
        $departementManagerName = Department::where('id', $responsible_department)->pluck('manager_id')->first();
        $departement= Department::where('id',$responsible_department)->first('manager_id');


        $roles = [
            'Departement-Owner' => [$departement->manager->id ?? null],
        ];
        // to get the column in database appear in notification as string not int
        $newDepartment = new Department();
        $newDepartment->Departement_Name = $departementName ?? null;
        $newDepartment->Departement_Manager = $departement->manager->name ?? null;
        // defining the link we want the user to be redirected to after clicking the system notification

        $link = ['link' => route('admin.configure.change_request_department.edit')];

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
    // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
    $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $newDepartment, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
