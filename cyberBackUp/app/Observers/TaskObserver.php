<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Team;
use Technovistalimited\Notific\Notific;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $taskAssignable = $task->assignable;
        $users = [];
        $message = '';
        if (class_basename($taskAssignable) == 'User') {
            $users = $taskAssignable->id;
            $message = ' create and assign task (' . $task->title . ') to you';
        } else if (class_basename($taskAssignable) == 'Team') {
            $users = $taskAssignable->users()->pluck('id')->toArray();
            $message = ' create and assign task (' . $task->title . ') to your team (' . $taskAssignable->name . ')';
        }
        Notific::notify(
            $users,
            'Employee ' . $task->created_by_user->name . $message,
            'notification',
            ['link' => route('admin.task.assigned_to_me')],
            date('d F Y')
        );
    }

    /**u
     * Listen to the User updating event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(Task $task)
    {
        if ($task->isDirty()) {
            $taskAssignable = $task->assignable;
            // Notify reassign
            if ($task->isDirty('assignable_id')) {
                // assignable_id has changed
                $old_assignable_id = $task->getOriginal('assignable_id');
                $old_assignable_type = $task->getOriginal('assignable_type');
                $users = [];
                $message = '';
                if (class_basename($taskAssignable) == 'User') {
                    $users = $taskAssignable->id;
                    $message = ' reassign task (' . $task->title . ') to you';
                } else if (class_basename($taskAssignable) == 'Team') {
                    $users = $taskAssignable->users()->pluck('id')->toArray();
                    $message = ' reassign task (' . $task->title . ') to your team (' . $taskAssignable->name . ')';
                }
                Notific::notify(
                    $users,
                    'Employee ' . $task->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.task.assigned_to_me')],
                    date('d F Y')
                );


                if ($old_assignable_type == 'App\Models\User') {
                    $users = $old_assignable_id;
                    $message = ' reassign task (' . $task->title . ') to another one';
                } else if ($old_assignable_type == 'App\Models\Team') {
                    $users = Team::find($old_assignable_id)->users()->pluck('id')->toArray();
                    $message = ' reassign task (' . $task->title . ') to another one';
                }

                Notific::notify(
                    $users,
                    'Employee ' . $task->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.task.assigned_to_me')],
                    date('d F Y')
                );
            }

            if ($task->isDirty('status')) { // Notify task status change
                $old_status = $task->getOriginal('status');
                $users = [];
                $message = '';


                $route = '';
                if (in_array($task->status, ['In Progress', 'Completed'])) { // assignee change
                    $route = route('admin.task.index');
                    $users = $task->created_by_user->id;
                    $message = ' update status of task (' . $task->title . ') from ' . $old_status . ' to ' . $task->status;
                } else if (in_array($task->status, ['Accepted', 'Closed'])) { // creator change
                    $route = route('admin.task.assigned_to_me');
                    if (class_basename($taskAssignable) == 'User') {
                        $users = $task->assignable_id;
                        $message = ' update status of task (' . $task->title . ') from ' . $old_status . ' to ' . $task->status;
                    } else if (class_basename($taskAssignable) == 'Team') {
                        $users = $taskAssignable->users()->where('id', '<>', $taskAssignable->id)->pluck('id')->toArray();
                        $users[] = $task->action_by_user->id;
                        $message = ' update status of task (' . $task->title . ') from ' . $old_status . ' to ' . $task->status;
                    }
                } else {
                    $route = route('admin.task.assigned_to_me');
                }

                Notific::notify(
                    $users,
                    'Employee ' . $task->action_by_user->name . $message,
                    'notification',
                    ['link' => $route],
                    date('d F Y')
                );
            }

            if ($task->isDirty(['title', 'description', 'priority', 'start_date', 'due_date'])) { // Notify update only
                $users = [];
                $message = '';
                if (class_basename($taskAssignable) == 'User') {
                    $users = $taskAssignable->id;
                    $message = ' update task (' . $task->title . ')';
                } else if (class_basename($taskAssignable) == 'Team') {
                    $users = $taskAssignable->users()->pluck('id')->toArray();
                    $message = ' update task (' . $task->title . ')';
                }
                Notific::notify(
                    $users,
                    'Employee ' . $task->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.task.assigned_to_me')],
                    date('d F Y')
                );
            }
        }
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
