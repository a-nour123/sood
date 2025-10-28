<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\RoleResponsibility;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;

class AddCoursePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionGroup::create([
            "name" => 'Physical Courses',
            "description" => 'Physical Courses',
            "order" => 7
        ]);

        $mainPermission = 'physicalCourses.';
        $permissionGroups = PermissionGroup::pluck('id', 'name');
        $PhysicalCourseId = $permissionGroups['Physical Courses'];
        Subgroup::create([
            'name' => 'Physical Courses',
            'permission_group_id' => $PhysicalCourseId,
        ]);

        $permissionSubGroups = Subgroup::pluck('id', 'name');
        $subGroupID = $permissionSubGroups['Physical Courses'];


        $examsPermissionStatuses = [
            'list',
            'create',
            'update',
            'delete',
            'showRequests',
            'approveRequest',
            'rejectRequest',
            'transferRequest',
            'attendance',
            'storeAttendance',
            'grade',
            'storeGrade',
            'toggleRegistration',
            'reports'
        ];


        foreach ($examsPermissionStatuses as $key => $permissionStatus) {
            $permission = Permission::create([
                'key' => $mainPermission . $permissionStatus,
                'name' => $permissionStatus,
                'subgroup_id' => $subGroupID
            ]);

            RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permission->id
            ]);
        }



    }
}
