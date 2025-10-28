<?php

namespace Database\Seeders;

use App\Models\RiskLevel;
use Illuminate\Database\Seeder;

class UpdateRiskLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $risk1 = RiskLevel::find(1);
        $risk1->update([
            'value' => 0.0,
            'color'=>'#30db00'
        ]);
        $risk2 = RiskLevel::find(2);
        $risk2->update([
            'value' => 5.0,
            'color'=>'#f1b309'
        ]);
        $risk3 = RiskLevel::find(3);
        $risk3->update([
            'value' => 15.0,
            'color'=>'#6b75ff'
        ]);
        $risk4 = RiskLevel::find(4);
        $risk4->update([
            'value' => 20.0,
            'color'=>'#ff0000'
        ]);

    }
}
