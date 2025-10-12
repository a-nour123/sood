<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::create([
            "id" => 1,
            "name" =>'Approve Risk'
        ]);
        Review::create([
            "id" => 2,
            "name" =>'Reject Risk and Close'
        ]);
    }
}
