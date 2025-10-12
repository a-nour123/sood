<?php

namespace Database\Seeders;

use App\Models\MitigationEffort;
use Illuminate\Database\Seeder;

class MitigationEffortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MitigationEffort::create([
            "id" => 1,
            "name" => 'Insignificante'
        ]);
        MitigationEffort::create([
            "id" => 2,
            "name" => 'Menor'
        ]);
        MitigationEffort::create([
            "id" => 3,
            "name" => 'Considerable'
        ]);
        MitigationEffort::create([
            "id" => 4,
            "name" => 'Significante'
        ]);
        MitigationEffort::create([
            "id" => 5,
            "name" => 'Excepcional'
        ]);
    }
}
