<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\MitigationToControl;
class MitigationToControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=1;$i<21;$i++){
            MitigationToControl::create([
                 'mitigation_id'=>$i,
                 'control_id' => $i,
                 'validation_details' => $this->faker->word,
                 'validation_owner' => 1,
                 'validation_mitigation_percent' => $this->faker->numberBetween($min = 1, $max = 99),
             ]);
        }
    }
}
