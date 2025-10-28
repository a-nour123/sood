<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Project::create([
                'name' => 'Project ' . $i,
                'due_date' => '',
                'consultant' => '',
                'business_owner' => '',
                'data_classification' => '',
                'order' => '',
                'status' => '',
            ]);
        }
    }
}
