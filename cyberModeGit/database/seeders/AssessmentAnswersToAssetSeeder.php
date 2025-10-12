<?php

namespace Database\Seeders;

use App\Models\AssessmentAnswersToAsset;
use Illuminate\Database\Seeder;

class AssessmentAnswersToAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssessmentAnswersToAsset::create([
            "assessment_answer_id" => 2,
            "asset_id" => 1
        ]);
        AssessmentAnswersToAsset::create([
            "assessment_answer_id" => 4,
            "asset_id" => 1
        ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 6,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 8,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 10,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 12,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 14,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 16,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 18,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 20,
        //     "asset_id" => 1
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 22,
        //     "asset_id" => 2
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 24,
        //     "asset_id" => 2
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 26,
        //     "asset_id" => 2
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 28,
        //     "asset_id" => 3
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 30,
        //     "asset_id" => 2
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 32,
        //     "asset_id" => 3
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 34,
        //     "asset_id" => 3
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 36,
        //     "asset_id" => 3
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 38,
        //     "asset_id" => 3
        // ]);
        // AssessmentAnswersToAsset::create([
        //     "assessment_answer_id" => 40,
        //     "asset_id" => 3
        // ]);
    }
}
