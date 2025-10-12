<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait AssetTrait
{
    /**********************************************************
     * FUNCTION: PROCESS SELECTED ASSETS ASSET GROUPS OF TYPE *
     * Processing the data coming from the widget used        *
     * for selecting assets and asset groups.                 *
     * $typeId: Id of the item we want to associate the      *
     * assets and asset groups with                           *
     * $assetsAndAssetGroups: data from the widget. Can          *
     * contain asset/asset group ids                          *
     **********************************************************/
    public function processSelectedAssetsAssetGroupsOfType($typeId, $assetsAndAssetGroups, $type)
    {
        $model = $groupModel = 'App\\Models\\';

        switch ($type) {
            case 'risk':

                $model .= 'RisksToAsset';
                $groupModel .= 'RisksToAssetGroup';
                $foreignId = 'risk_id';
                $forced_asset_verification_state = null;
                break;
            case 'assessment_answer':
                $model .= 'AssessmentAnswersToAsset';
                $groupModel .= 'AssessmentAnswersToAssetGroup';
                $foreignId = 'assessment_answer_id';
                $forced_asset_verification_state = true;
                break;
                // case 'questionnaire_risk':
                //     $model = 'questionnaire_risk_to_assets';
                //     $groupModel = 'questionnaire_risk_to_asset_groups';
                //     $foreignId = 'questionnaire_id';
                //     $forced_asset_verification_state = true;
                //     break;
                // case 'questionnaire_answer':
                //     if (!assessments_extra() || !assessments_extra("questionnaire_answers_to_assets") || !assessments_extra("questionnaire_answers_to_asset_groups")) {
                //         return;
                //     }
                //     $model = 'questionnaire_answers_to_assets';
                //     $groupModel = 'questionnaire_answers_to_asset_groups';
                //     $foreignId = 'questionnaire_answer_id';
                //     $forced_asset_verification_state = true;
                //     break;

            default:
                return;
        }

        // Clear any current assets for this type
        $model::where($foreignId, $typeId)->delete();
        $groupModel::where($foreignId, $typeId)->delete();

        // For each asset or group
        foreach ($assetsAndAssetGroups as $value) {
            // Trim whitespaces
            $value = trim($value);

            // Selected an existing asset or group
            if (preg_match('/^([\d]+)_(group|asset)$/', $value, $matches)) {
                list(, $id, $type) = $matches;
            } else {
                //Invalid input
                continue;
            }

            if ($type == 'asset') {
                // Add the new asset for this type
                $model::create([
                    $foreignId => $typeId,
                    'asset_id' => $id
                ]);
            } elseif ($type == 'group') {
                // Add the new group for this type
                $groupModel::create([
                    $foreignId => $typeId,
                    'asset_group_id' => $id
                ]);
            }
        }
    }
}
