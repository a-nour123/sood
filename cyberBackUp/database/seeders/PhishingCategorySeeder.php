<?php

namespace Database\Seeders;

use App\Models\PhishingCategory;
use Illuminate\Database\Seeder;

class PhishingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhishingCategory::create([
            "id" => 1,
            "name" => 'HR'
        ]);
        PhishingCategory::create([
            "id" => 2,
            "name" => 'Sales'
        ]);
        PhishingCategory::create([
            "id" => 3,
            "name" => 'IT'
        ]);
        PhishingCategory::create([
            "id" => 4,
            "name" => 'PRO'
        ]);
    }
}
