<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddedPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert into `permissions` table
        DB::table('permissions')->insert([
            [
                'key' => 'control.list_objectives',
                'name' => 'list requirements',
                'subgroup_id' => 2,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'control.add_objectives',
                'name' => 'add requirements',
                'subgroup_id' => 2,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'control.all',
                'name' => 'all',
                'subgroup_id' => 2,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'audits.all',
                'name' => 'all',
                'subgroup_id' => 9,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'riskmanagement.all',
                'name' => 'all',
                'subgroup_id' => 5,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'vulnerability_management.all',
                'name' => 'all',
                'subgroup_id' => 31,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'asset.all',
                'name' => 'all',
                'subgroup_id' => 10,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'security-awareness.all',
                'name' => 'all',
                'subgroup_id' => 37,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'key' => 'document.all',
                'name' => 'all',
                'subgroup_id' => 3,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        $permissions = ['control.list_objectives', 'control.add_objectives', 'control.all','audits.all','riskmanagement.all','vulnerability_management.all', 'asset.all','security-awareness.all','document.all'];
        // Insert into `role_responsibilities` table
        foreach ($permissions as $permission) {
            $permissionId = DB::table(table: 'permissions')->where('key', $permission)->value('id');
            DB::table('role_responsibilities')->insert([
                [
                    'role_id' => 1,
                    'permission_id' => $permissionId,
                ],
            ]);
        }
    }
}
