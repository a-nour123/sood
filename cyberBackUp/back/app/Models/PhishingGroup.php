<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhishingGroup extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'phishing_groups';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'phishing_group_users');
    }
}
