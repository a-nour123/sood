<?php

namespace Database\Seeders;

use App\Models\ControlPriority;
use Illuminate\Database\Seeder;

class ControlPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlPriority::create([
            "id" => 1,
            "name" => 'P0'
        ]);
        ControlPriority::create([
            "id" => 2,
            "name" => 'P1'
        ]);
        ControlPriority::create([
            "id" => 3,
            "name" => 'P2'
        ]);
        ControlPriority::create([
            "id" => 4,
            "name" => 'P3'
        ]);
    }
}
