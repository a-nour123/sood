<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRequest extends Model
{
    protected $fillable = ['course_id', 'user_id', 'status', 'transferred_to_course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transferredTo(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'transferred_to_course_id');
    }
}

