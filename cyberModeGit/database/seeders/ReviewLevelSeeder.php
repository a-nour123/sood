<?php

namespace Database\Seeders;

use App\Models\ReviewLevel;
use Illuminate\Database\Seeder;

class ReviewLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Old seeder

        // ReviewLevel::create([
        //     "id" => 1,
        //     "value" => 90,
        //     "name" => 'Very High'
        // ]);
        // ReviewLevel::create([
        //     "id" => 2,
        //     "value" => 90,
        //     "name" => 'High'
        // ]);
        // ReviewLevel::create([
        //     "id" => 3,
        //     "value" => 180,
        //     "name" => 'Medium'
        // ]);
        // ReviewLevel::create([
        //     "id" => 4,
        //     "value" => 360,
        //     "name" => 'Low'
        // ]);
        // ReviewLevel::create([
        //     "id" => 5,
        //     "value" => 360,
        //     "name" => 'Insignificant'
        // ]);

        // ------------------------------------------------

        //  New seeder
        ReviewLevel::create([
            "id" => 1,
            "value" => 360,
            "name" => 'Insignificant'
        ]);
        ReviewLevel::create([
            "id" => 2,
            "value" => 360,
            "name" => 'Low'
        ]);
        ReviewLevel::create([
            "id" => 3,
            "value" => 180,
            "name" => 'Medium'
        ]);
        ReviewLevel::create([
            "id" => 4,
            "value" => 90,
            "name" => 'High'
        ]);
        ReviewLevel::create([
            "id" => 5,
            "value" => 90,
            "name" => 'Very High'
        ]);
    }
}
