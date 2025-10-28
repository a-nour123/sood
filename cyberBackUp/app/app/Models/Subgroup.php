<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgroup extends Model
{
    use HasFactory;
    public $guarded = [];
    public function permissionGroup(){
        return $this->belongsToMany(PermissionGroup::class, 'permission_group_id');
    }
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'subgroup_id');
    }
}
