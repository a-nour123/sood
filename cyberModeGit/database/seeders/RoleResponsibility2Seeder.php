<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RoleResponsibility;
use Illuminate\Database\Seeder;

class RoleResponsibility2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permessionIds = Permission::pluck('id');
        foreach ($permessionIds as $permessionId) {
            RoleResponsibility::create([
                "role_id" => 1,
                "permission_id" => $permessionId
            ]);
        }

        $permessionIds = Permission::whereIn('name', ['list', 'view'])->pluck('id');
        foreach ($permessionIds as $permessionId) {
            RoleResponsibility::create([
                "role_id" => 2,
                "permission_id" => $permessionId
            ]);
        }
    }
}
