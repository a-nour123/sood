<?php

namespace Database\Seeders;

use App\Models\CustomRiskModelValue;
use Illuminate\Database\Seeder;

class CustomRiskModelValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomRiskModelValue::create([
            "impact_id" => 1,
            "likelihood_id" => 1,
            "value" =>  0.4
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 1,
            "likelihood_id" => 2,
            "value" =>  0.8
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 1,
            "likelihood_id" => 3,
            "value" =>  1.2
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 1,
            "likelihood_id" => 4,
            "value" =>  1.6
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 1,
            "likelihood_id" => 5,
            "value" =>  2.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 2,
            "likelihood_id" => 1,
            "value" =>  0.8
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 2,
            "likelihood_id" => 2,
            "value" =>  1.6
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 2,
            "likelihood_id" => 3,
            "value" =>  2.4
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 2,
            "likelihood_id" => 4,
            "value" =>  3.2
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 2,
            "likelihood_id" => 5,
            "value" =>  4.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 3,
            "likelihood_id" => 1,
            "value" =>  1.2
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 3,
            "likelihood_id" => 2,
            "value" =>  2.4
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 3,
            "likelihood_id" => 3,
            "value" =>  3.6
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 3,
            "likelihood_id" => 4,
            "value" =>  4.8
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 3,
            "likelihood_id" => 5,
            "value" =>  6.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 4,
            "likelihood_id" => 1,
            "value" =>  1.6
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 4,
            "likelihood_id" => 2,
            "value" =>  3.2
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 4,
            "likelihood_id" => 3,
            "value" =>  4.8
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 4,
            "likelihood_id" => 4,
            "value" =>  6.4
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 4,
            "likelihood_id" => 5,
            "value" =>  8.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 5,
            "likelihood_id" => 1,
            "value" =>  2.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 5,
            "likelihood_id" => 2,
            "value" =>  4.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 5,
            "likelihood_id" => 3,
            "value" =>  6.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 5,
            "likelihood_id" => 4,
            "value" =>  8.0
        ]);
        CustomRiskModelValue::create([
            "impact_id" => 5,
            "likelihood_id" => 5,
            "value" =>  10.0
        ]);
    }
}
