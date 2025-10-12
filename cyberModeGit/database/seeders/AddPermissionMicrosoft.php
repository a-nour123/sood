<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\RoleResponsibility;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;

class AddPermissionMicrosoft extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            $mainPermission = 'microsoft.';
            $permissionGroups  = PermissionGroup::pluck('id', 'name');
            $configurationId = $permissionGroups['Configuration'];
             Subgroup::create([
            'name' => 'Microsoft Setting',
            'permission_group_id' => $configurationId,
            ]);
            $permissionSubGroups  = Subgroup::pluck('id', 'name');
           $subGroupID = $permissionSubGroups['Microsoft Setting'];


              $permission1 =   Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
               $permission2 =  Permission::create([
                    "key" => $mainPermission . 'test',
                    "name" => 'test',
                    "subgroup_id" => $subGroupID
                ]);
                $permission3 = Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);

                  RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permission1->id
            ]);
             RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permission2->id
            ]);
             RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permission3->id
            ]);
    }
}
