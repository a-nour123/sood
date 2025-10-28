<?php

namespace Database\Seeders;

use App\Models\ControlMaturity;
use Illuminate\Database\Seeder;

class ControlMaturitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlMaturity::create([
            "id" => 1,
            "name" => 'Not Performed'
        ]);
        ControlMaturity::create([
            "id" => 2,
            "name" => 'Performed'
        ]);
        ControlMaturity::create([
            "id" => 3,
            "name" => 'Documented'
        ]);
        ControlMaturity::create([
            "id" => 4,
            "name" => 'Managed'
        ]);
        ControlMaturity::create([
            "id" => 5,
            "name" => 'Reviewed'
        ]);
        ControlMaturity::create([
            "id" => 6,
            "name" => 'Optimizing'
        ]);
    }
}
