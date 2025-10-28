<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeederForAssessment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainPermissions = ['assessmentResult.'];

        foreach ($mainPermissions as $mainKey => $mainPermission) {
            if ($mainPermission == '') {
                continue; // Skip empty permission names
            }

            if ($mainPermission == 'assessmentResult.') {
                Permission::create([
                    "key" => $mainPermission . 'action',
                    "name" => 'Assessment Action',
                    "subgroup_id" => 41,
                ]);
            }

            // Add other conditions for different main permissions if needed
        }
    }
}
