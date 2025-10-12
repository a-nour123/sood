<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public $guarded = [];

    public function files()
    {
        return $this->hasMany(FileTask::class, 'task_id');
    }

    /**
     * Get the parent assignable model (user or team).
     */
    public function assignable()
    {
        return $this->morphTo();
    }

    public function action_by_user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get notes for this task.
     */
    public function notes()
    {
        return $this->hasMany(TaskNote::class)->with('user:id,name');
    }

    /**
     * Get notes for this task.
     */
    public function note_files()
    {
        return $this->hasMany(TaskNoteFile::class)->with('user:id,name');
    }
    public function TaskCat()
    {
        return $this->belongsTo(TaskCategory::class, 'category_task_id');
    }
}
