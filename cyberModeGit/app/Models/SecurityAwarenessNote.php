<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityAwarenessNote extends Model
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
     * Get security_awareness for this note.
     */
    public function security_awareness()
    {
        return $this->belongsTo(SecurityAwareness::class);
    }

    /**
     * Get security awarenesses creator for this note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
