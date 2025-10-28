<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $guarded = [];

    public $timestamps = false;

    public function permissions()
    {
        return $this->hasMany(RoleResponsibility::class);
    }
    public function rolePermissions()
    {
        return $this->belongsToMany(Permission::class, 'role_responsibilities');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
