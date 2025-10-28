<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RoleResponsibility;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;

class PermissionForDocumentPolicySeeder extends Seeder
{
    public function run()
    {
        // Create Subgroup
        Subgroup::create([
            'name' => 'Policy',
            'permission_group_id' => 1, // Adjust the ID according to your setup
        ]);

        // Define main permissions
        $mainPermissions = ['Document_Policy.'];

        foreach ($mainPermissions as $mainPermission) {
            if ($mainPermission == '') {
                continue; // Skip empty permission names
            }

            // Create specific permissions under 'Document_Policy.'
            if ($mainPermission == 'Document_Policy.') {
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 46 // Adjust subgroup ID if needed
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 46 // Adjust subgroup ID if needed
                ]);

                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 46
                ]);

                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => 46
                ]);
            }
        }

        // Assign all permissions to role_id 1 (e.g., Admin)
        $allPermissionIds = Permission::pluck('id');
        foreach ($allPermissionIds as $permissionId) {
            RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permissionId
            ]);
        }

        // Assign specific permissions ('list' and 'view') to role_id 2 (e.g., User)
        $specificPermissionIds = Permission::whereIn('name', ['list', 'view'])->pluck('id');
        foreach ($specificPermissionIds as $permissionId) {
            RoleResponsibility::create([
                "role_id" => 2,
                "permission_id" => $permissionId
            ]);
        }
    }
}
