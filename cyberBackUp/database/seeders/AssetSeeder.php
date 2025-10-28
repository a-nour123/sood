<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        for ($i = 1; $i <= 20; $i++) {
            $asset = Asset::create([
                "id" => $i,
                "ip" => '127.0.0.' . $i,
                "name" => 'Asset' . $i,
                "asset_value_id" => $this->faker->numberBetween($min = 1, $max = 10),
                "location_id" => $i,
                "teams" => '1,4',
                "details" => 'Details asset ' . $i,
                "created" => '2019-07-01 08:32:43',
                "verified" => 1,
                'start_date' => '2022-07-' . sprintf('%02d', ($i % 10 + 1)),
                'expiration_date' => '2022-07-' . sprintf('%02d', ($i % 10 + 2)),
                'alert_period' => '30',
            ]);

            if ($i == 1) {
                $asset->tags()->saveMany(Tag::whereIn('id', [1, 2, 3, 4, 5])->get());
            } else {
                $asset->tags()->saveMany(Tag::whereIn('id', [$i])->get());
            }
        }
        // $asset = Asset::create([
        //     "id" => 1,
        //     "ip" => '127.0.0.1',
        //     "name" => 'System',
        //     "asset_value_id" => 5,
        //     "location_id" => 1,
        //     "teams" => '1,4',
        //     "details" => 'details asset 1',
        //     "created" => '2019-07-01 08:32:43',
        //     "verified" => 1
        // ]);
        // $asset->tags()->saveMany(Tag::whereIn('id', [1, 3, 5, 7, 9])->get());
        // $asset = Asset::create([
        //     "id" => 2,
        //     "ip" => '127.0.0.2',
        //     "name" => 'Network',
        //     "asset_value_id" => 5,
        //     "location_id" => 1,
        //     "teams" => '2,5',
        //     "details" => 'details asset 2',
        //     "created" => '2019-07-01 08:32:43',
        //     "verified" => 1
        // ]);
        // $asset->tags()->saveMany(Tag::whereIn('id', [2, 4, 6, 8, 10])->get());
        // $asset = Asset::create([
        //     "id" => 3,
        //     "ip" => '127.0.0.3',
        //     "name" => 'Application',
        //     "asset_value_id" => 5,
        //     "location_id" => 1,
        //     "teams" => '3,6',
        //     "details" => 'details asset 3',
        //     "created" => '2019-07-01 08:32:43',
        //     "verified" => 1
        // ]);
        // $asset->tags()->saveMany(Tag::whereIn('id', [3, 6])->get());
    }
}
