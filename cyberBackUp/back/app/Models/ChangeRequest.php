<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    use HasFactory;

    public $guarded = [];

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
