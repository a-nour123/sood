<?php

namespace App\Listeners;

use App\Events\DepartementMovingToAnother;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Department;

class DepartementMovingToAnotherListener
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
     * @param  \App\Events\DepartementMovingToAnother  $event
     * @return void
     */
    public function handle(DepartementMovingToAnother $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Departement_Moving')->first();
        $actionId1 = $action1['id'];
        $newDepartment = $event->newDepartment;
        $department = $event->department;
        $employeeIds = [];
        foreach ($newDepartment->employees as $employee) {
            // Collect the IDs of each employee
            $employeeIds[] = $employee->id;
        }
        
        $roles = [
            'MainManager' => isset($newDepartment->manager) && isset($newDepartment->manager->id) ? [$newDepartment->manager->id] : [],
            'NewManager' => isset($department->manager) && isset($department->manager->id) ? [$department->manager->id] : [],
            'ParentManager' => isset($department->parentDepartment) && isset($department->parentDepartment->manager) && isset($department->parentDepartment->manager->id) ? [$department->parentDepartment->manager->id] : [],
            'Employee' => $employeeIds, // Use the array of employee IDs
        ];
 

        // Define teams in the desired format for notification message

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.hierarchy.index')];
        // Set the properties of the risk object for notification message

        $department->New_Manager = $newDepartment->parentDepartment && $newDepartment->parentDepartment->manager ? $newDepartment->parentDepartment->manager->name : $newDepartment->manager->name;
        // dd($department->New_Manager);

        $department->Main_Manager = $newDepartment->manager ? $newDepartment->manager->name : null;
        // dd($department->Old_Manager);

        $department->Parent_Manager = $newDepartment->parentDepartment && $newDepartment->parentDepartment->parentDepartment && $newDepartment->parentDepartment->parentDepartment->manager ? $newDepartment->parentDepartment->parentDepartment->manager->name : $newDepartment->manager->name;
        // dd($department->Parent_Manager);

        $department->Name_Departement = $newDepartment->name ? $newDepartment->name : null;
        // dd($department->Name_Departement);

        $department->Name_Departement_Belongs = $newDepartment->parentDepartment && $newDepartment->parentDepartment->name ? $newDepartment->parentDepartment->name : $newDepartment->name;
        // dd($department->Name_Departement_Belongs);


        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        // Call the function to handle different kinds of notifications

        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $department, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
