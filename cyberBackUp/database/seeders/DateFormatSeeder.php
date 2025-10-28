<?php

namespace Database\Seeders;

use App\Models\DateFormat;
use Illuminate\Database\Seeder;

class DateFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DateFormat::create([
            "value" => 'DD MM YYYY'
        ]);
        DateFormat::create([
            "value" => 'DD-MM-YYYY'
        ]);
        DateFormat::create([
            "value" => 'DD.MM.YYYY'
        ]);
        DateFormat::create([
            "value" => 'DD/MM/YYYY'
        ]);
        DateFormat::create([
            "value" => 'MM DD YYYY'
        ]);
        DateFormat::create([
            "value" => 'MM-DD-YYYY'
        ]);
        DateFormat::create([
            "value" => 'MM.DD.YYYY'
        ]);
        DateFormat::create([
            "value" => 'MM/DD/YYYY'
        ]);
        DateFormat::create([
            "value" => 'YYYY DD MM'
        ]);
        DateFormat::create([
            "value" => 'YYYY MM DD'
        ]);
        DateFormat::create([
            "value" => 'YYYY-DD-MM'
        ]);
        DateFormat::create([
            "value" => 'YYYY-MM-DD'
        ]);
        DateFormat::create([
            "value" => 'YYYY.DD.MM'
        ]);
        DateFormat::create([
            "value" => 'YYYY.MM.DD'
        ]);
        DateFormat::create([
            "value" => 'YYYY/DD/MM'
        ]);
        DateFormat::create([
            "value" => 'YYYY/MM/DD'
        ]);
    }
}
