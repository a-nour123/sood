<?php

namespace Database\Seeders;

use App\Models\RiskScoring;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RiskScoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $impactIds = [1, 2, 3, 4, 5];
        $likelhoodIds = [1, 2, 3, 4, 5];
        $calculatedRisks = [];
        // $calculatedRisks[$impactId][$likelhoodId]
        $calculatedRisks[1][1] = 0.7;
        $calculatedRisks[2][1] = 1;
        $calculatedRisks[3][1] = 1.3;
        $calculatedRisks[4][1] = 1.7;
        $calculatedRisks[5][1] = 2;

        $calculatedRisks[1][2] = 1.3;
        $calculatedRisks[2][2] = 2;
        $calculatedRisks[3][2] = 2.7;
        $calculatedRisks[4][2] = 3.3;
        $calculatedRisks[5][2] = 4;

        $calculatedRisks[1][3] = 2;
        $calculatedRisks[2][3] = 3;
        $calculatedRisks[3][3] = 4;
        $calculatedRisks[4][3] = 5;
        $calculatedRisks[5][3] = 6;

        $calculatedRisks[1][4] = 2.7;
        $calculatedRisks[2][4] = 4;
        $calculatedRisks[3][4] = 5.3;
        $calculatedRisks[4][4] = 6.7;
        $calculatedRisks[5][4] = 8;

        $calculatedRisks[1][5] = 3.3;
        $calculatedRisks[2][5] = 5;
        $calculatedRisks[3][5] = 6.7;
        $calculatedRisks[4][5] = 8.3;
        $calculatedRisks[5][5] = 10;


        // foreach ($impactIds as $impactId) {
        //     foreach ($likelhoodIds as $likelhoodId) {
        //         RiskScoring::create([
        //             'scoring_method' => 1, // For classic formula
        //             'calculated_risk' => $calculatedRisks[$impactId][$likelhoodId],
        //             'CLASSIC_likelihood' => $likelhoodId,
        //             'CLASSIC_impact' => $impactId
        //         ]);
        //     }
        // }
    }
}
