<?php

namespace Database\Seeders;

use App\Models\TestResult;
use Illuminate\Database\Seeder;

class TestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestResult::create([
            "id" => 1,
            "name" => 'Not Applicable',
            "background_class" => '#d0d0d0'
        ]);
        TestResult::create([
            "id" => 2,
            "name" => 'Not Implemented',
            "background_class" => '#FFA1A1'
        ]);
        TestResult::create([
            "id" => 3,
            "name" => 'Partially Implemented',
            "background_class" => '#ffe700'
        ]);
        TestResult::create([
            "id" => 4,
            "name" => 'Implemented',
            "background_class" => '#00d4bd'
        ]);
    }
}
