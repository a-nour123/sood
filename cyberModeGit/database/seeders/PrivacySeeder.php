<?php

namespace Database\Seeders;

use App\Models\Privacy;
use Illuminate\Database\Seeder;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Privacy::create([
            "title" => 'Private',
         ]);
        Privacy::create([
            "title" => 'Public',
         ]);

    }
}
