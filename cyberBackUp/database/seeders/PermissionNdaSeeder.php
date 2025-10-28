<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionNdaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups  = PermissionGroup::pluck('id', 'name');
        $governanceId = $permissionGroups['Governance'];
        
        $subgroup= Subgroup::create([
            "name" => 'nda',
            "permission_group_id" => $governanceId
        ]);
        $subId = $subgroup ? $subgroup->id : null;

        // Define all permissions to be inserted
        $permissions = [
            [
                'key' => 'nda.list',
                'name' => 'Create',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nda.create',
                'name' => 'Create',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nda.update',
                'name' => 'Update',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nda.delete',
                'name' => 'Delete',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nda.send',
                'name' => 'Send',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nda.view_result',
                'name' => 'view_result',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'key' => 'nda.all_result',
                'name' => 'all_result',
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