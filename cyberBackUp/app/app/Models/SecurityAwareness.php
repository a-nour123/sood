<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityAwareness extends Model
{
    use HasFactory;

    public $guarded = [];


    /**
     * Get notes for this document.
     */
    public function notes()
    {
        return $this->hasMany(SecurityAwarenessNote::class)->with('user:id,name');
    }

    /**
     * Get file for this document.
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function note_files()
    {
        return $this->hasMany(SecurityAwarenessNoteFile::class)->with('user:id,name');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function owned_by_user()
    {
        return $this->belongsTo(User::class, 'owner');
    }

    public function securityAwarenessStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'status');
    }

    public function Privacy()
    {
        return $this->belongsTo(Privacy::class, 'privacy');
    }

    /**
     * Get exam for the security awareness.
     */
    public function exam()
    {
        return $this->hasOne(SecurityAwarenessExam::class, 'security_awareness_id')->with('answers')->withCount('questions');
    }
    // public function examoutside()
    // {
    //     return $this->hasOne(SecurityAwarenessExam::class, 'security_awareness_id')->with('answers')->withCount('questions');
    // }
}
