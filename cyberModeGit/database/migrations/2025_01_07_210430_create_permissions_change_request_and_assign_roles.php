<?php

use App\Models\Permission;
use App\Models\RoleResponsibility;
use App\Models\Subgroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsChangeRequestAndAssignRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Pluck all subgroup IDs
        $permissionSubGroups = Subgroup::pluck('id', 'name');
        $mainPermissions = ['change-request.', 'change-request-department.'];
        $createdPermissionIds = []; // Array to store the created permissions' IDs

        // Loop over the main permissions
        foreach ($mainPermissions as $mainPermission) {
            if ($mainPermission == 'change-request.') {
                $subGroupID = $permissionSubGroups['Change Request'] ?? null;

                if ($subGroupID) {
                    $permissions = [
                        [
                            "key" => $mainPermission . 'list',
                            "name" => 'list',
                            "subgroup_id" => $subGroupID,
                        ],
                    ];

                    // Create the permissions
                    foreach ($permissions as $permission) {
                        $createdPermission = Permission::create($permission);
                        $createdPermissionIds[] = $createdPermission->id;
                    }
                }
            }

            
        }

        // Assign the created permissions to role_id 1 (Admin)
        foreach ($createdPermissionIds as $permissionId) {
            RoleResponsibility::create([
                'role_id' => 1,  // Admin role
                'permission_id' => $permissionId,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions_change_request_and_assign_roles');
    }
}
