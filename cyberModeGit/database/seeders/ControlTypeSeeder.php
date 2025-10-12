<?php

namespace Database\Seeders;

use App\Models\ControlType;
use Illuminate\Database\Seeder;

class ControlTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlType::create([
            "id" => 1,
            "name" => 'Standalone'
        ]);
        ControlType::create([
            "id" => 2,
            "name" => 'Project'
        ]);
        ControlType::create([
            "id" => 3,
            "name" => 'Enterprise'
        ]);
    }
}
