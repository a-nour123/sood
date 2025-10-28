<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HostRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['name' => 'Riyadh', 'description' => 'The capital city of Saudi Arabia.'],
            ['name' => 'Makkah', 'description' => 'Home to the holy city of Mecca.'],
            ['name' => 'Madinah', 'description' => 'Home to the Prophet\'s Mosque.'],
            ['name' => 'Eastern Province', 'description' => 'Known for its oil-rich region.'],
            ['name' => 'Asir', 'description' => 'A region with stunning mountains and scenery.'],
            ['name' => 'Tabuk', 'description' => 'A northern region known for historical landmarks.'],
            ['name' => 'Al-Qassim', 'description' => 'A region known for its agriculture.'],
            ['name' => 'Hail', 'description' => 'Known for its historical and archaeological sites.'],
            ['name' => 'Jazan', 'description' => 'A southern region with beautiful islands.'],
            ['name' => 'Najran', 'description' => 'A region rich in history and culture.'],
            ['name' => 'Al-Bahah', 'description' => 'A mountainous region with lush greenery.'],
            ['name' => 'Northern Borders', 'description' => 'A region bordering Iraq and Jordan.'],
        ];

        DB::table('host_regions')->insert($regions);
    }
}
