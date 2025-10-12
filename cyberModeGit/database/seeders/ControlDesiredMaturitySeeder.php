<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControlDesiredMaturity;
class ControlDesiredMaturitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlDesiredMaturity::create([
            "id" => 1,
            "name" => 'Not Performed'
        ]);
        ControlDesiredMaturity::create([
            "id" => 2,
            "name" => 'Performed'
        ]);
        ControlDesiredMaturity::create([
            "id" => 3,
            "name" => 'Documented'
        ]);
        ControlDesiredMaturity::create([
            "id" => 4,
            "name" => 'Managed'
        ]);
        ControlDesiredMaturity::create([
            "id" => 5,
            "name" => 'Reviewed'
        ]);
        ControlDesiredMaturity::create([
            "id" => 6,
            "name" => 'Optimizing'
        ]);
    }
}
