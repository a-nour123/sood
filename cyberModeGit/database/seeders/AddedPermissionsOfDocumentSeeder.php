<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddedPermissionsOfDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $subgroup = Subgroup::where('name', 'Document')->latest()->first();
        // $subId = $subgroup ? $subgroup->id : null;

        // if (!$subId) {
        //     $this->command->error('Subgroup "Document" not found.');
        //     return;
        // }

        // // Define all permissions to be inserted
        // $permissions = [
        //     [
        //         'key' => 'document.changeContent',
        //         'name' => 'change content',
        //         'subgroup_id' => $subId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'key' => 'document.createContent',
        //         'name' => 'create content',
        //         'subgroup_id' => $subId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'key' => 'document.deleteContent',
        //         'name' => 'delete content',
        //         'subgroup_id' => $subId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'key' => 'document.updateContent',
        //         'name' => 'update content',
        //         'subgroup_id' => $subId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'key' => 'document.acceptContent',
        //         'name' => 'update content',
        //         'subgroup_id' => $subId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]
        // ];

        // // Insert permissions
        // DB::table('permissions')->insert($permissions);

        // // Get permission keys for role assignment
        // $permissionKeys = array_column($permissions, 'key');

        // // Insert into `role_responsibilities` table
        // foreach ($permissionKeys as $permissionKey) {
        //     $permissionId = DB::table('permissions')->where('key', $permissionKey)->value('id');

        //     if ($permissionId) {
        //         DB::table('role_responsibilities')->insert([
        //             'role_id' => 1,
        //             'permission_id' => $permissionId,
        //         ]);
        //     }
        // }

        // Action::insert([
        //     ['id' => 134, 'name' => 'add_content'],
        //     ['id' => 135, 'name' => 'update_content'],
        //     ['id' => 136, 'name' => 'delete_content'],
        //     ['id' => 137, 'name' => 'accept_content'],
        //     ['id' => 138, 'name' => 'AutoNotifyPolicyAuditBeforeDueDate'],
        //     ['id' => 139, 'name' => 'AutoNotifyPolicyAuditEsclation'],
        //     ['id' => 140, 'name' => 'ObjectiveNotifyEsclation'],
        //     ['id' => 141, 'name' => 'add_comment'],

        // ]);
    }
}