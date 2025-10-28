<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddPermissionMappingControlComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups  = PermissionGroup::pluck('id', 'name');
        $governanceId = $permissionGroups['Compliance'];
        
        $subgroup= Subgroup::create([
            "name" => 'mapped_control_compliance',
            "permission_group_id" => $governanceId
        ]);
        $subId = $subgroup ? $subgroup->id : null;

        // Define all permissions to be inserted
        $permissions = [
            [
                'key' => 'mapped_control_compliance.list',
                'name' => 'list',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mapped_control_compliance.create',
                'name' => 'Create',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mapped_control_compliance.update',
                'name' => 'Update',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mapped_control_compliance.delete',
                'name' => 'Delete',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mapped_control_compliance.auditing',
                'name' => 'Auditing',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mapped_control_compliance.export',
                'name' => 'export',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
           
        ];

        // Insert permissions
        DB::table('permissions')->insert($permissions);

        // Get permission keys for role assignment
        $permissionKeys = array_column($permissions, 'key');

        // Insert into `role_responsibilities` table
        foreach ($permissionKeys as $permissionKey) {
            $permissionId = DB::table('permissions')->where('key', $permissionKey)->value('id');

            if ($permissionId) {
                DB::table('role_responsibilities')->insert([
                    'role_id' => 1,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }
}