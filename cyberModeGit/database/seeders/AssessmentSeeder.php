<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Assessment::query()->truncate();
       // Assessment::factory(12)->create();
        Assessment::create([

            "name" => 'PCI DSS 3.2',
            "created" => '2018-01-09 08:15:13'
        ]);
        Assessment::create([

            "name" => 'NIST 800-171',
            "created" => '2018-01-09 08:15:13'
        ]);
        Assessment::create([

            "name" => 'HIPAA (April 2016)',
            "created" => '2016-03-04 05:21:27'
        ]);
        Assessment::create([

            "name" => 'Critical Security Controls',
            "created" => '2016-03-04 05:21:27'
        ]);


        // Assessment::create([
        //     "id" => 4,
        //     "name" => 'HIPAA (April 2016)',
        //     "created" => '2018-01-09 08:15:13'
        // ]);
    }
}
