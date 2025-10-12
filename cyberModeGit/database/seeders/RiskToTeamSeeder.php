<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\RiskToTeam;
class RiskToTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for($i=1;$i<20;$i++){
            RiskToTeam::create([
                 'risk_id'=>$i,
                 'team_id' => $i,
             ]);
        }
    }
}
