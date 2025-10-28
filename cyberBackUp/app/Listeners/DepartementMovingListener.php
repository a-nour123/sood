<?php

namespace App\Listeners;

use App\Events\DepartementMoving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Department;

class DepartementMovingListener
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
     * @param  \App\Events\DepartementMoving  $event
     * @return void
     */
    public function handle(DepartementMoving $event)
    {
         // // Get the action ID for Risk_Add
        // $action = Action::where('name','Departement_Moving')->first();
        // $actionId = $action['id'];
        
        // // Get the risk object from the event
        // $department = $event->department;
        // $newDepartment = $event->newDepartment;
        // dd($newDepartment);

        //  // Eager load the teamsForRisk relationship
        // // $risk->load('teamsForRisk');
        
        // // Define the roles array for notification
        // $roles = [
        //     'manager' => [$department->manager_id],
        // ];
        
        // // Define teams in the desired format for notification message
       

    


        // // Define the link for redirection after clicking the system notification
        // $link = ['link' => route('admin.risk_management.index')];
    
        // // Set the properties of the risk object for notification message
    
        // $department->Manager = $department->manager_id ? $department->manager->name : null;
        // $department->Parent_Departement = $department->parent_id ? $department->parentDepartment->name : null;

        // // parentDepartment

        
        // // Call the function to handle different kinds of notifications
        // $this->sendNotificationForAction($actionId, $link, $department, $roles);
    }
}
