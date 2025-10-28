<?php

namespace Database\Seeders;

use App\Models\Regulation;
use Illuminate\Database\Seeder;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regulation::create([
            "id" => 1,
            "name" => 'PCI DSS 3.2'
        ]);
        Regulation::create([
            "id" => 2,
            "name" => 'Sarbanes-Oxley (SOX)'
        ]);
        Regulation::create([
            "id" => 3,
            "name" => 'HIPAA'
        ]);
        Regulation::create([
            "id" => 4,
            "name" => 'ISO 27001'
        ]);
    }
}
