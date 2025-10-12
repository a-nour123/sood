<?php

namespace Database\Seeders;

use App\Models\AssetValueQuestion;
use Illuminate\Database\Seeder;

class AssetValueQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetValueQuestion::create([
            'asset_value_category_id' => 1,
            'question' => 'Disclosure of information will result in loss of public / users confidence ',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 1,
            'question' => 'Disclosure of information will result in embarrassment ',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 1,
            'question' => 'Disclosure of information will have financial impact',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 1,
            'question' => 'Disclosure of information will have operational impact',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 1,
            'question' => 'Disclosure of information will have legal/regulatory impact',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);

        AssetValueQuestion::create([
            'asset_value_category_id' => 2,
            'question' => 'Unauthorized change / Modification will affect the public confidence',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
           AssetValueQuestion::create([
            'asset_value_category_id' => 2,
            'question' => 'Unauthorized change / Modification will result in embarrassment',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 2,
            'question' => 'Unauthorized change / Modification will have financial impact',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 2,
            'question' => 'Unauthorized change / Modification of information will have operational impact',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 2,
            'question' => 'Unauthorized changes / Modification will have legal/regulatory impact',
            'answers' => json_encode([
                ['answer' => 'yes', 'value' => 1],
                ['answer' => 'no', 'value' => 0]
            ]),
        ]);

        AssetValueQuestion::create([
            'asset_value_category_id' => 3,
            'question' => 'The Public / users confidence will be harmed if the asset is not available for how long',
            'answers' => json_encode([
                ['answer' => 'Loss of Availability for more than or equal to <1 hr will have an Extremely High effect', 'value' => 1],
                ['answer' => 'Loss of Availability for more than or equal to <8 hrs days  will have High effect', 'value' => 2],
                ['answer' => 'Loss of Availability for more than or equal to <24 hrs will have Medium effec', 'value' => 3],
                ['answer' => 'Loss of Availability for more than or equal <72 hrs will have an Low effect', 'value' => 4],
                ['answer' => 'Loss of Availability for more than or equal to >72 hrs Very Low effect', 'value' => 5],
            ]),
        ]);

        AssetValueQuestion::create([
            'asset_value_category_id' => 3,
            'question' => 'Embarrassment will be caused by the unavailability of the asset for how long',
            'answers' => json_encode([
                ['answer' => 'Loss of Availability for more than or equal to <1 hr will have an Extremely High effect', 'value' => 1],
                ['answer' => 'Loss of Availability for more than or equal to <8 hrs days  will have High effect', 'value' => 2],
                ['answer' => 'Loss of Availability for more than or equal to <24 hrs will have Medium effec', 'value' => 3],
                ['answer' => 'Loss of Availability for more than or equal <72 hrs will have an Low effect', 'value' => 4],
                ['answer' => 'Loss of Availability for more than or equal to >72 hrs Very Low effect', 'value' => 5],
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 3,
            'question' => 'Financial impact will be caused if the asset is not available for how long',
            'answers' => json_encode([
                ['answer' => 'Loss of Availability for more than or equal to <1 hr will have an Extremely High effect', 'value' => 1],
                ['answer' => 'Loss of Availability for more than or equal to <8 hrs days  will have High effect', 'value' => 2],
                ['answer' => 'Loss of Availability for more than or equal to <24 hrs will have Medium effec', 'value' => 3],
                ['answer' => 'Loss of Availability for more than or equal <72 hrs will have an Low effect', 'value' => 4],
                ['answer' => 'Loss of Availability for more than or equal to >72 hrs Very Low effect', 'value' => 5],
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 3,
            'question' => 'Operational impact will be caused if the asset is not available for how long',
            'answers' => json_encode([
                ['answer' => 'Loss of Availability for more than or equal to <1 hr will have an Extremely High effect', 'value' => 1],
                ['answer' => 'Loss of Availability for more than or equal to <8 hrs days  will have High effect', 'value' => 2],
                ['answer' => 'Loss of Availability for more than or equal to <24 hrs will have Medium effec', 'value' => 3],
                ['answer' => 'Loss of Availability for more than or equal <72 hrs will have an Low effect', 'value' => 4],
                ['answer' => 'Loss of Availability for more than or equal to >72 hrs Very Low effect', 'value' => 5],
            ]),
        ]);
        AssetValueQuestion::create([
            'asset_value_category_id' => 3,
            'question' => 'There will be legal/regulatory impact if the asset is not available for how long',
            'answers' => json_encode([
                ['answer' => 'Loss of Availability for more than or equal to <1 hr will have an Extremely High effect', 'value' => 1],
                ['answer' => 'Loss of Availability for more than or equal to <8 hrs days  will have High effect', 'value' => 2],
                ['answer' => 'Loss of Availability for more than or equal to <24 hrs will have Medium effec', 'value' => 3],
                ['answer' => 'Loss of Availability for more than or equal <72 hrs will have an Low effect', 'value' => 4],
                ['answer' => 'Loss of Availability for more than or equal to >72 hrs Very Low effect', 'value' => 5],
            ]),
        ]);

    }
}
