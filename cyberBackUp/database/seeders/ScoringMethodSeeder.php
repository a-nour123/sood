<?php

namespace Database\Seeders;

use App\Models\ScoringMethod;
use Illuminate\Database\Seeder;

class ScoringMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScoringMethod::create([
            "id" => 1,
            "name" => 'Classic'
        ]);
        // ScoringMethod::create([
        //     "id" => 2,
        //     "name" => 'CVSS'
        // ]);
        // ScoringMethod::create([
        //     "id" => 3,
        //     "name" => 'DREAD'
        // ]);
        // ScoringMethod::create([
        //     "id" => 4,
        //     "name" => 'OWASP'
        // ]);
        // ScoringMethod::create([
        //     "id" => 5,
        //     "name" => 'Custom'
        // ]);
        // ScoringMethod::create([
        //     "id" => 6,
        //     "name" => 'Contributing Risk'
        // ]);
    }
}
