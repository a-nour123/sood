<?php

namespace Database\Seeders;

use App\Models\Likelihood;
use Illuminate\Database\Seeder;

class LikelihoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Likelihood::create([
            "id" =>  1,
            "name" => 'Remote'
        ]);
        Likelihood::create([
            "id" =>  2,
            "name" => 'Unlikely'
        ]);
        Likelihood::create([
            "id" =>  3,
            "name" => 'Credible'
        ]);
        Likelihood::create([
            "id" =>  4,
            "name" => 'Likely'
        ]);
        Likelihood::create([
            "id" =>  5,
            "name" => 'Almost Certain'
        ]);
    }
}
