<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\RoleResponsibility;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;

class TenableWithVulnInfoAndHistory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissionGroups  = PermissionGroup::pluck('id', 'name');
 
        $configurationId = $permissionGroups['Configuration'];
        Subgroup::create([
            'name' => 'Tenable Authentication',
            'permission_group_id' => $configurationId,
        ]);
        $permissionSubGroups  = Subgroup::pluck('id', 'name');
        $mainPermissions = ['tenable_authentication.'];
        $createdPermissionIds = []; // Array to store the created permissions' IDs

        foreach ($mainPermissions as $mainPermission) {
            if ($mainPermission == 'tenable_authentication.') {
                $subGroupID = $permissionSubGroups['Tenable Authentication'];

                $permissions = [
                    [
                        "key" => $mainPermission . 'list',
                        "name" => 'list',
                        "subgroup_id" => $subGroupID,
                    ],
                    [
                        "key" => $mainPermission . 'create',
                        "name" => 'create',
                        "subgroup_id" => $subGroupID,
                    ],
                    [
                        "key" => $mainPermission . 'tenable_history',
                        "name" => 'tenable_history',
                        "subgroup_id" => $subGroupID,
                    ],
                    [
                        "key" => $mainPermission . 'Info_Vulnerability',
                        "name" => 'Info_Vulnerability',
                        "subgroup_id" => $subGroupID,
                    ],
                ];

                foreach ($permissions as $permission) {
                    $createdPermission = Permission::create($permission);
                    $createdPermissionIds[] = $createdPermission->id; // Store the created permission ID
                }
            }
        }

        // Assign only the created permissions to role_id 1 (e.g., Admin)
        foreach ($createdPermissionIds as $permissionId) {
            RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permissionId,
            ]);
        }
    }
}
