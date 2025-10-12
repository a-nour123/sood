<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RoleResponsibility;
use Illuminate\Database\Seeder;

class KpiAssessmentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define main permissions
        $mainPermissions = ['KPI.'];

        foreach ($mainPermissions as $mainPermission) {
            if ($mainPermission == '') {
                continue; // Skip empty permission names
            }

            // Create specific permissions under 'KPI.'
            if ($mainPermission == 'KPI.') {
                Permission::create([
                    "key" => $mainPermission . 'list_Kpi_Assessment',
                    "name" => 'List Kpi Assessment',
                    "subgroup_id" => 36
                ]);

                Permission::create([
                    "key" => $mainPermission . 'reassign_Kpi_Assessment',
                    "name" => 'ReAssign Kpi Assessment',
                    "subgroup_id" => 36
                ]);
            }
        }

        // Assign all permissions to role_id 1 (e.g., Admin)
        $allPermissionIds = Permission::pluck('id')->toArray();
        foreach ($allPermissionIds as $permissionId) {
            RoleResponsibility::create([
                "role_id" => 1, // Admin role_id
                "permission_id" => $permissionId
            ]);
        }

    }
}
