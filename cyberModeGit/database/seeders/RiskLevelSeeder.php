<?php

namespace Database\Seeders;

use App\Models\RiskLevel;
use Illuminate\Database\Seeder;

class RiskLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // old Seeder

        // RiskLevel::create([
        //     "value" => '0.0',
        //     "name" => 'Low',
        //     "color" => '#fff',
        //     "display_name" => 'Low'
        // ]);
        // RiskLevel::create([
        //     "value" => '4.0',
        //     "name" => 'Medium',
        //     "color" => 'orange',
        //     "display_name" => 'Medium'
        // ]);
        // RiskLevel::create([
        //     "value" => '7.0',
        //     "name" => 'High',
        //     "color" => 'orangered',
        //     "display_name" => 'High'
        // ]);
        // RiskLevel::create([
        //     "value" => '10.1',
        //     "name" => 'Very High',
        //     "color" => 'red',
        //     "display_name" => 'Very High'
        // ]);

        // ------------------------------------------------

        // New seeder
        RiskLevel::create([
            "value" => '0.0',
            "name" => 'Low',
            "color" => '#ffffff',
            "display_name" => 'Low',
            'review_level_id' => 2
        ]);
        RiskLevel::create([
            "value" => '4.0',
            "name" => 'Medium',
            "color" => '#ffa500',
            "display_name" => 'Medium',
            'review_level_id' => 3
        ]);
        RiskLevel::create([
            "value" => '7.0',
            "name" => 'High',
            "color" => '#ff4500',
            "display_name" => 'High',
            'review_level_id' => 4
        ]);
        RiskLevel::create([
            "value" => '10.1',
            "name" => 'Very High',
            "color" => '#ff0000',
            "display_name" => 'Very High',
            'review_level_id' => 5
        ]);
    }
}
