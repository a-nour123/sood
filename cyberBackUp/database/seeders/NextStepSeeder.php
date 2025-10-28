<?php

namespace Database\Seeders;

use App\Models\NextStep;
use Illuminate\Database\Seeder;

class NextStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NextStep::create([
            "id" => 1,
            "name" => 'Accept Until Next Review'
        ]);
        // NextStep::create([
        //     "id" => 2,
        //     "name" => 'Consider for Project'
        // ]);
        NextStep::create([
            "id" => 3,
            "name" => 'Submit as a Production Issue'
        ]);
    }
}
