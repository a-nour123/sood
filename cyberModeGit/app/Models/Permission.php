<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $guarded = [];


    public function permissionGroups()
    {
        return $this->belongsToMany(PermissionGroup::class, 'permission_to_permission_groups', 'permission_group_id');
    }
    public function subGroup()
    {
        return $this->belongsToMany(Subgroup::class, 'subgroup_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_responsibilities');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_to_users', 'permission_id');
    }
}
