<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create([
            'name' => 'CEO',
            'code' => '#00001',
            'description' => 'This job for CEO'
        ]);

        Job::create([
            'name' => 'Department manager',
            'code' => '#00003',
            'description' => 'This job for department manager'
        ]);
        
        for ($i = 1; $i <= 10; $i++) {
            Job::create([
                'name' => 'Job' . $i,
                'code' => '#' . $i . $i . $i . $i . $i,
                'description' => 'Job description' . $i,
            ]);
        }
    }
}
