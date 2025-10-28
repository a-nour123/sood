<?php

namespace App\Observers;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\LMSTrainingModule;

class LMSTrainingModuleObserver
{
    use NotificationHandlingTrait;

    /**
     * Handle the LMSTrainingModule "created" event.
     *
     * @param  \App\Models\LMSTrainingModule  $lMSTrainingModule
     * @return void
     */
    public function created(LMSTrainingModule $lMSTrainingModule)
    {
        // Get the action ID for Add Training module
        $action1 = Action::where('id', 127)->first();
        $actionId1 = $action1['id'];

        // Define the roles array for notification
        $roles = [
            'Name' => [$lMSTrainingModule->title ?? null],
            'Score' => [$lMSTrainingModule->score ?? null],
            'Order' => [$lMSTrainingModule->order ?? null],
            'Completion_time' => [$lMSTrainingModule->completion_time ?? null],

            'Course_name' => [$lMSTrainingModule->level->course->title ?? null],
            'Course_level' => [$lMSTrainingModule->level->title ?? null],
        ];

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.lms.trainingModules.index')];

        // Set the properties of the Training module object for notification message
        $lMSTrainingModule->Name = $lMSTrainingModule->name;
        $lMSTrainingModule->Score = $lMSTrainingModule->passing_score;
        $lMSTrainingModule->Order = $lMSTrainingModule->order;
        $lMSTrainingModule->Completion_time = $lMSTrainingModule->completion_time;

        $lMSTrainingModule->Course_name = $lMSTrainingModule->level->course->title;
        $lMSTrainingModule->Course_level = $lMSTrainingModule->level->title;

        // parentDepartment ??
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $lMSTrainingModule, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }

    /**
     * Handle the LMSTrainingModule "updated" event.
     *
     * @param  \App\Models\LMSTrainingModule  $lMSTrainingModule
     * @return void
     */
    public function updated(LMSTrainingModule $lMSTrainingModule)
    {
        // Get the action ID for Add Training module
        $action1 = Action::where('id', 128)->first();
        $actionId1 = $action1['id'];

        // Define the roles array for notification
        $roles = [
            'Name' => [$lMSTrainingModule->title ?? null],
            'Score' => [$lMSTrainingModule->score ?? null],
            'Order' => [$lMSTrainingModule->order ?? null],
            'Completion_time' => [$lMSTrainingModule->completion_time ?? null],

            'Course_name' => [$lMSTrainingModule->level->course->title ?? null],
            'Course_level' => [$lMSTrainingModule->level->title ?? null],
        ];

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.lms.trainingModules.index')];

        // Set the properties of the Training module object for notification message
        $lMSTrainingModule->Name = $lMSTrainingModule->name;
        $lMSTrainingModule->Score = $lMSTrainingModule->passing_score;
        $lMSTrainingModule->Order = $lMSTrainingModule->order;
        $lMSTrainingModule->Completion_time = $lMSTrainingModule->completion_time;

        $lMSTrainingModule->Course_name = $lMSTrainingModule->level->course->title;
        $lMSTrainingModule->Course_level = $lMSTrainingModule->level->title;

        // parentDepartment ??
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $lMSTrainingModule, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }

    /**
     * Handle the LMSTrainingModule "deleted" event.
     *
     * @param  \App\Models\LMSTrainingModule  $lMSTrainingModule
     * @return void
     */
    public function deleted(LMSTrainingModule $lMSTrainingModule)
    {
        //
    }

    /**
     * Handle the LMSTrainingModule "restored" event.
     *
     * @param  \App\Models\LMSTrainingModule  $lMSTrainingModule
     * @return void
     */
    public function restored(LMSTrainingModule $lMSTrainingModule)
    {
        //
    }

    /**
     * Handle the LMSTrainingModule "force deleted" event.
     *
     * @param  \App\Models\LMSTrainingModule  $lMSTrainingModule
     * @return void
     */
    public function forceDeleted(LMSTrainingModule $lMSTrainingModule)
    {
        //
    }
}
