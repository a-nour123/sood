<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityAwarenessExamAnswer extends Model
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

    public function employee()
    {
        return $this->belongsTo(User::class, 'examinee');
    }
    public function employeeOut()
    {
        return $this->belongsTo(UserOutSideCyber::class, 'examinee_idOut');
    }
}
