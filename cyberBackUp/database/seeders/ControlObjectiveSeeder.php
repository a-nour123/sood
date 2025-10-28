<?php

namespace Database\Seeders;

use App\Models\ControlObjective;
use Illuminate\Database\Seeder;

class ControlObjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlObjective::factory()->count(30)->create();
    }
}
