<?php

namespace App\Listeners;

use App\Events\DepartementMovingEmployee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Department;

class DepartementMovingEmployeeListener
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
     * @param  \App\Events\DepartementMovingEmployee  $event
     * @return void
     */
    public function handle(DepartementMovingEmployee $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Departement_Moving_Employee')->first();
        $actionId1 = $action1['id'];
        $department = $event->department;
        $userbeforeUpdate = $event->userbeforeUpdate;
        $user = $event->user;
        //    dd($department);
        // Eager load the teamsForRisk relationship

        // Define the roles array for notification
        $roles = [
            'MainManager' => isset($userbeforeUpdate->department->manager->id) ? [$userbeforeUpdate->department->manager->id] : [],
            'NewManager' => isset($user->department->manager->id) ? [$user->department->manager->id] : [],
            'ParentManager' => isset($userbeforeUpdate->department->parentDepartment) ? [$userbeforeUpdate->department->parentDepartment->manager->id] : (isset($userbeforeUpdate->department->manager->id) ? [$userbeforeUpdate->department->manager->id] : []),
            'NewParentManager' => isset($user->department->parentDepartment) ? [$user->department->parentDepartment->manager->id] : (isset($user->department->manager->id) ? [$user->department->manager->id] : []),
            'Employee' => isset($user->id) ? [$user->id] : [],
        ];

        // Define teams in the desired format for notification message

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.hierarchy.index')];
        // Set the properties of the risk object for notification message

        $department->New_Manager = $user->department->manager ? $user->department->manager->name : null;
        //    dd($department->New_Manager);
        $department->Main_Manager = $userbeforeUpdate->department->manager ? $userbeforeUpdate->department->manager->name : null;
        //    dd($department->Old_Manager);

        $department->Name_Departement = isset($userbeforeUpdate->department->name) ? $userbeforeUpdate->department->name : null;
        // dd($department->Name_Departement);

        $department->Parent_Manager = isset($userbeforeUpdate->department->parentDepartment->manager->name) ? $userbeforeUpdate->department->parentDepartment->manager->name : $userbeforeUpdate->department->manager->name;
        // dd($department->New_Parent_Manager);

        $department->New_Parent_Manager = isset($user->department->parentDepartment->manager->name) ? $user->department->parentDepartment->manager->name : $user->department->manager->name;
        // dd($department->New_Parent_Manager);

        $department->Name_Departement_Belongs = isset($user->department->name) ? $user->department->name : null;
        // dd($department->Name_Departement_Belongs);

        $department->Employee_Name = $user->name ? $user->name : null;
        // dd($department->Employee_Name);



        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        // Call the function to handle different kinds of notifications

        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $department, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
