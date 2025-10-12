<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AssessmentResultAction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            "key" => 'assessmentResult.action',
            "name" => 'Assessment Action',
            "subgroup_id" => 41
        ]);

    }
}
