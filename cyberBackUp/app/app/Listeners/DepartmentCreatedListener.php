<?php

namespace App\Listeners;

use App\Events\DepartmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Department;

class DepartmentCreatedListener
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
     * @param  \App\Events\DepartmentCreated  $event
     * @return void
     */
    public function handle(DepartmentCreated $event)
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1= Action::where('name','Departement_Add')->first();
        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $department = $event->department;

        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');

        // Define the roles array for notification
        $roles = [
            'manager' => [$department->manager_id ?? null],
            'parent' => [$department->parentDepartment->manager->id ?? null],
        ];


        // Define teams in the desired format for notification message





        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.hierarchy.department.index')];

        // Set the properties of the risk object for notification message

        $department->Manager = $department->manager_id ? $department->manager->name : null;
        $department->Parent_Departement = $department->parent_id ? $department->parentDepartment->name : null;

        // parentDepartment
        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        // Call the function to handle different kinds of notifications

        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $department, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
