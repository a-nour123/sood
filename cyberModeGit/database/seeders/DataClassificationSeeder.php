<?php

namespace Database\Seeders;

use App\Models\DataClassification;
use Illuminate\Database\Seeder;

class DataClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataClassification::create([
            "id" => 1,
            "name" => 'Public',
            "order" => 1
        ]);
        DataClassification::create([
            "id" => 2,
            "name" => 'Internal',
            "order" => 2
        ]);
        DataClassification::create([
            "id" => 3,
            "name" => 'Confidential',
            "order" => 3
        ]);
        DataClassification::create([
            "id" => 4,
            "name" => 'Restricted',
            "order" => 4
        ]);
    }
}
