<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\PermissionGroup;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionAdoptionPolicySeeder extends Seeder
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

        $subgroup = Subgroup::create([
            "name" => 'policy_adoptions',
            "permission_group_id" => $governanceId
        ]);
        $subId = $subgroup ? $subgroup->id : null;

        // Define all permissions to be inserted
        $permissions = [
            [
                'key' => 'policy_adoptions.list',
                'name' => 'List',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'policy_adoptions.create',
                'name' => 'Create',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'policy_adoptions.update',
                'name' => 'Update',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'policy_adoptions.delete',
                'name' => 'Delete',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'policy_adoptions.preview_result',
                'name' => 'preview_result',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'policy_adoptions.configuration',
                'name' => 'configuration',
                'subgroup_id' => $subId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'policy_adoptions.print',
                'name' => 'print',
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

        Action::insert([
            ['id' => 145, 'name' => 'policy_adoption_add'],
            ['id' => 146, 'name' => 'policy_adoption_update'],
            ['id' => 147, 'name' => 'policy_adoption_delete'],
            ['id' => 148, 'name' => 'policy_adoption_change_status'],
           
        ]);
    }
}