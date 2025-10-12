<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentNoteFile extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get document for this note.
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    

    /**
     * Get document creator for this note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
