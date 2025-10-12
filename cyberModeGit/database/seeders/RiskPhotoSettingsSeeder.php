<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class RiskPhotoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data into the settings table
        Setting::create([
            "value" => "images/ico/risk_photo.png",
            "name" => 'risk_photo'
        ]);
    }
}
