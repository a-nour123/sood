<?php

namespace App\Observers;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\LMSCourse;

class LMSCourseObserver
{
    use NotificationHandlingTrait;

    /**
     * Handle the LMSCourse "created" event.
     *
     * @param  \App\Models\LMSCourse  $lMSCourse
     * @return void
     */
    public function created(LMSCourse $lMSCourse)
    {
        // Get the action ID for Add Course
        $action1 = Action::where('id', 125)->first();
        $actionId1 = $action1['id'];

        // Define the roles array for notification
        $roles = [
            'Title' => [$lMSCourse->title ?? null],
            'Description' => [$lMSCourse->description ?? null],
        ];

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.lms.courses.index')];

        // Set the properties of the Course object for notification message
        $lMSCourse->Title = $lMSCourse->title;
        $lMSCourse->Description = $lMSCourse->description;

        // parentDepartment ??
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $lMSCourse, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }

    /**
     * Handle the LMSCourse "updated" event.
     *
     * @param  \App\Models\LMSCourse  $lMSCourse
     * @return void
     */
    public function updated(LMSCourse $lMSCourse)
    {
        // Get the action ID for Add Course
        $action1 = Action::where('id', 126)->first();
        $actionId1 = $action1['id'];

        // Define the roles array for notification
        $roles = [
            'Title' => [$lMSCourse->title ?? null],
            'Description' => [$lMSCourse->description ?? null],
        ];

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.lms.courses.index')];

        // Set the properties of the Course object for notification message
        $lMSCourse->Title = $lMSCourse->title;
        $lMSCourse->Description = $lMSCourse->description;

        // parentDepartment ??
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $lMSCourse, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }

    /**
     * Handle the LMSCourse "deleted" event.
     *
     * @param  \App\Models\LMSCourse  $lMSCourse
     * @return void
     */
    public function deleted(LMSCourse $lMSCourse)
    {
        //
    }

    /**
     * Handle the LMSCourse "restored" event.
     *
     * @param  \App\Models\LMSCourse  $lMSCourse
     * @return void
     */
    public function restored(LMSCourse $lMSCourse)
    {
        //
    }

    /**
     * Handle the LMSCourse "force deleted" event.
     *
     * @param  \App\Models\LMSCourse  $lMSCourse
     * @return void
     */
    public function forceDeleted(LMSCourse $lMSCourse)
    {
        //
    }
}
