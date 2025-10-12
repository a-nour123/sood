<?php

namespace Database\Seeders;

use App\Models\CloseReason;
use Illuminate\Database\Seeder;

class CloseReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CloseReason::create([
            // "id" => 0, 1
            "name" => 'Rejected'
        ]);
        CloseReason::create([
            // "id" => 1, 2
            "name" => 'Fully Mitigated'
        ]);
        CloseReason::create([
            // "id" => 2, 3
            "name" => 'System Retired'
        ]);
        CloseReason::create([
            // "id" => 3, 4
            "name" => 'Cancelled'
        ]);
        CloseReason::create([
            // "id" => 4, 5
            "name" => 'Too Insignificant'
        ]);
    }
}
