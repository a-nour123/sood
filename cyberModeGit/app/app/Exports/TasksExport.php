<?php

namespace App\Exports;

use App\Models\Task;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class TasksExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;
    private $tasksType = '';

    public function __construct(string $tasksType)
    {
        if ($tasksType == 'created')
            $this->tasksType = 'created';
        else if ($tasksType == 'assigned')
            $this->tasksType = 'assigned';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $tasks = [];
        if ($this->tasksType == 'created') {
            $currentUser = auth()->user();
            $tasks = $currentUser->createdTasks()->with('assignable:id,name')->orderBy('due_date')->get();
        } else if ($this->tasksType == 'assigned') {
            $this->tasksType = 'assigned';
            $currentUser = auth()->user();
            $currentUserTasks = $currentUser->tasks()->with('assignable:id,name', 'action_by_user:id,name', 'created_by_user:id,name')->orderBy('due_date')->get();
            $teamIds = $currentUser->teams()->pluck('id')->toArray();
            $teamTasks = Task::where('assignable_type', 'App\Models\Team')->whereIn('assignable_id', $teamIds)->with('assignable:id,name', 'created_by_user:id,name', 'action_by_user:id,name')->orderBy('due_date')->get();
            $tasks = $currentUserTasks->merge($teamTasks);
        }

        return $tasks;
    }

    /**
     * @var Task $task
     */
    public function map($task): array
    {
        return [
            $this->counter++,
            $task->title,
            class_basename($task->assignable_type),
            class_basename($task->assignable_type) == 'User' && $task->assignable->id == auth()->id() ? __('locale.Me') : $task->assignable->name,
            $task->start_date->format('Y-m-d'),
            $task->due_date->format('Y-m-d'),
            __('locale.' . $task->priority),
            __('locale.' . $task->status),
            (($task->action_by_user->name) ?? '') ? ($task->created_by_user->id == auth()->id() ? __('locale.Me') : $task->created_by_user->name) : '', // Export 'Me' if action by is me
            strip_tags($task->description),
            $task->completed ? '✔' : '✘',
            $task->completed_date ? date('Y-m-d H:i', strtotime($task->completed_date)) : '',
            $task->accepted_date ? date('Y-m-d H:i', strtotime($task->accepted_date)) : '',
            $this->tasksType == 'created' ? __('locale.Me') : $task->created_by_user->name,
            $task->created_at->format('Y-m-d H:i'),
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.TaskTitle'),
            __('locale.AssigneeType'),
            __('locale.Assignee'),
            __('locale.StartDate'),
            __('locale.DueDate'),
            __('locale.TaskPriority'),
            __('locale.TaskStatus'),
            __('locale.ActionBy'),
            __('locale.Description'),
            __('locale.Completed'),
            __('locale.CompletedDate'),
            __('locale.AcceptedDate'),
            __('locale.CreatedBy'),
            __('locale.CreatedDate'),


        ];
    }
}
