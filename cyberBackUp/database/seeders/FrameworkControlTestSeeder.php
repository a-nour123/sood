<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\FrameworkControlTest;

class FrameworkControlTestSeeder extends Seeder
{
    protected $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentDate = date('Y-m-d');
        // NCA-ECC – 1: 2018
        if (in_array('NCA-ECC – 1: 2018', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "5",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-1-1",
                "framework_control_id" => "5"
            ]);
            FrameworkControlTest::create([
                "id" => "6",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-1-2",
                "framework_control_id" => "6"
            ]);
            FrameworkControlTest::create([
                "id" => "7",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-1-3",
                "framework_control_id" => "7"
            ]);
            FrameworkControlTest::create([
                "id" => "8",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-2-1",
                "framework_control_id" => "8"
            ]);
            FrameworkControlTest::create([
                "id" => "9",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-2-2",
                "framework_control_id" => "9"
            ]);
            FrameworkControlTest::create([
                "id" => "10",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-2-3",
                "framework_control_id" => "10"
            ]);
            FrameworkControlTest::create([
                "id" => "11",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-3-1",
                "framework_control_id" => "11"
            ]);
            FrameworkControlTest::create([
                "id" => "12",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-3-2",
                "framework_control_id" => "12"
            ]);
            FrameworkControlTest::create([
                "id" => "13",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-3-3",
                "framework_control_id" => "13"
            ]);
            FrameworkControlTest::create([
                "id" => "14",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-3-4",
                "framework_control_id" => "14"
            ]);
            FrameworkControlTest::create([
                "id" => "15",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-4-1",
                "framework_control_id" => "15"
            ]);
            FrameworkControlTest::create([
                "id" => "16",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-4-2",
                "framework_control_id" => "16"
            ]);
            FrameworkControlTest::create([
                "id" => "17",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-1",
                "framework_control_id" => "17"
            ]);
            FrameworkControlTest::create([
                "id" => "18",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-2",
                "framework_control_id" => "18"
            ]);
            FrameworkControlTest::create([
                "id" => "19",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-3",
                "framework_control_id" => "19"
            ]);
            FrameworkControlTest::create([
                "id" => "20",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-3-1",
                "framework_control_id" => "20"
            ]);
            FrameworkControlTest::create([
                "id" => "21",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-3-2",
                "framework_control_id" => "21"
            ]);
            FrameworkControlTest::create([
                "id" => "22",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-3-3",
                "framework_control_id" => "22"
            ]);
            FrameworkControlTest::create([
                "id" => "23",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-3-4",
                "framework_control_id" => "23"
            ]);
            FrameworkControlTest::create([
                "id" => "24",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-5-4",
                "framework_control_id" => "24"
            ]);
            FrameworkControlTest::create([
                "id" => "25",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-1",
                "framework_control_id" => "25"
            ]);
            FrameworkControlTest::create([
                "id" => "26",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-2",
                "framework_control_id" => "26"
            ]);
            FrameworkControlTest::create([
                "id" => "27",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-2-1",
                "framework_control_id" => "27"
            ]);
            FrameworkControlTest::create([
                "id" => "28",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-2-2",
                "framework_control_id" => "28"
            ]);
            FrameworkControlTest::create([
                "id" => "29",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-3",
                "framework_control_id" => "29"
            ]);
            FrameworkControlTest::create([
                "id" => "30",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-3-1",
                "framework_control_id" => "30"
            ]);
            FrameworkControlTest::create([
                "id" => "31",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-3-2",
                "framework_control_id" => "31"
            ]);
            FrameworkControlTest::create([
                "id" => "32",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-3-3",
                "framework_control_id" => "32"
            ]);
            FrameworkControlTest::create([
                "id" => "33",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-3-4",
                "framework_control_id" => "33"
            ]);
            FrameworkControlTest::create([
                "id" => "34",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-3-5",
                "framework_control_id" => "34"
            ]);
            FrameworkControlTest::create([
                "id" => "35",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-7-1",
                "framework_control_id" => "35"
            ]);
            FrameworkControlTest::create([
                "id" => "36",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-7-2",
                "framework_control_id" => "36"
            ]);
            FrameworkControlTest::create([
                "id" => "37",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-8-1",
                "framework_control_id" => "37"
            ]);
            FrameworkControlTest::create([
                "id" => "38",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-8-2",
                "framework_control_id" => "38"
            ]);
            FrameworkControlTest::create([
                "id" => "39",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-8-3",
                "framework_control_id" => "39"
            ]);
            FrameworkControlTest::create([
                "id" => "40",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-1",
                "framework_control_id" => "40"
            ]);
            FrameworkControlTest::create([
                "id" => "41",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-2",
                "framework_control_id" => "41"
            ]);
            FrameworkControlTest::create([
                "id" => "42",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-3",
                "framework_control_id" => "42"
            ]);
            FrameworkControlTest::create([
                "id" => "43",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-3-1",
                "framework_control_id" => "43"
            ]);
            FrameworkControlTest::create([
                "id" => "44",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-3-2",
                "framework_control_id" => "44"
            ]);
            FrameworkControlTest::create([
                "id" => "45",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-4",
                "framework_control_id" => "45"
            ]);
            FrameworkControlTest::create([
                "id" => "46",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-4-1",
                "framework_control_id" => "46"
            ]);
            FrameworkControlTest::create([
                "id" => "47",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-4-2",
                "framework_control_id" => "47"
            ]);
            FrameworkControlTest::create([
                "id" => "48",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-5",
                "framework_control_id" => "48"
            ]);
            FrameworkControlTest::create([
                "id" => "49",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-9-6",
                "framework_control_id" => "49"
            ]);
            FrameworkControlTest::create([
                "id" => "50",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-1",
                "framework_control_id" => "50"
            ]);
            FrameworkControlTest::create([
                "id" => "51",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-2",
                "framework_control_id" => "51"
            ]);
            FrameworkControlTest::create([
                "id" => "52",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-3",
                "framework_control_id" => "52"
            ]);
            FrameworkControlTest::create([
                "id" => "53",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-3-1",
                "framework_control_id" => "53"
            ]);
            FrameworkControlTest::create([
                "id" => "54",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-3-2",
                "framework_control_id" => "54"
            ]);
            FrameworkControlTest::create([
                "id" => "55",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-3-4",
                "framework_control_id" => "55"
            ]);
            FrameworkControlTest::create([
                "id" => "56",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-4",
                "framework_control_id" => "56"
            ]);
            FrameworkControlTest::create([
                "id" => "57",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-4-1",
                "framework_control_id" => "57"
            ]);
            FrameworkControlTest::create([
                "id" => "58",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-4-3",
                "framework_control_id" => "58"
            ]);
            FrameworkControlTest::create([
                "id" => "59",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-4-2",
                "framework_control_id" => "59"
            ]);
            FrameworkControlTest::create([
                "id" => "60",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-10-5",
                "framework_control_id" => "60"
            ]);
            FrameworkControlTest::create([
                "id" => "61",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-1-1",
                "framework_control_id" => "61"
            ]);
            FrameworkControlTest::create([
                "id" => "62",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-1-2",
                "framework_control_id" => "62"
            ]);
            FrameworkControlTest::create([
                "id" => "63",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-1-3",
                "framework_control_id" => "63"
            ]);
            FrameworkControlTest::create([
                "id" => "64",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-1-4",
                "framework_control_id" => "64"
            ]);
            FrameworkControlTest::create([
                "id" => "65",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-1-5",
                "framework_control_id" => "65"
            ]);
            FrameworkControlTest::create([
                "id" => "66",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-1-6",
                "framework_control_id" => "66"
            ]);
            FrameworkControlTest::create([
                "id" => "67",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-1",
                "framework_control_id" => "67"
            ]);
            FrameworkControlTest::create([
                "id" => "68",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-2",
                "framework_control_id" => "68"
            ]);
            FrameworkControlTest::create([
                "id" => "69",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-3",
                "framework_control_id" => "69"
            ]);
            FrameworkControlTest::create([
                "id" => "70",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-3-1",
                "framework_control_id" => "70"
            ]);
            FrameworkControlTest::create([
                "id" => "71",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-3-2",
                "framework_control_id" => "71"
            ]);
            FrameworkControlTest::create([
                "id" => "72",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-3-3",
                "framework_control_id" => "72"
            ]);
            FrameworkControlTest::create([
                "id" => "73",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-3-4",
                "framework_control_id" => "73"
            ]);
            FrameworkControlTest::create([
                "id" => "74",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-3-5",
                "framework_control_id" => "74"
            ]);
            FrameworkControlTest::create([
                "id" => "75",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-2-4",
                "framework_control_id" => "75"
            ]);
            FrameworkControlTest::create([
                "id" => "76",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "EEC 2-3-1",
                "framework_control_id" => "76"
            ]);
            FrameworkControlTest::create([
                "id" => "77",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-2",
                "framework_control_id" => "77"
            ]);
            FrameworkControlTest::create([
                "id" => "78",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-3",
                "framework_control_id" => "78"
            ]);
            FrameworkControlTest::create([
                "id" => "79",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-3-1",
                "framework_control_id" => "79"
            ]);
            FrameworkControlTest::create([
                "id" => "80",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-3-2",
                "framework_control_id" => "80"
            ]);
            FrameworkControlTest::create([
                "id" => "81",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-3-3",
                "framework_control_id" => "81"
            ]);
            FrameworkControlTest::create([
                "id" => "82",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-3-4",
                "framework_control_id" => "82"
            ]);
            FrameworkControlTest::create([
                "id" => "83",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-3-4",
                "framework_control_id" => "83"
            ]);
            FrameworkControlTest::create([
                "id" => "84",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-1",
                "framework_control_id" => "84"
            ]);
            FrameworkControlTest::create([
                "id" => "85",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-2",
                "framework_control_id" => "85"
            ]);
            FrameworkControlTest::create([
                "id" => "86",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-3",
                "framework_control_id" => "86"
            ]);
            FrameworkControlTest::create([
                "id" => "87",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-3-1",
                "framework_control_id" => "87"
            ]);
            FrameworkControlTest::create([
                "id" => "88",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-3-2",
                "framework_control_id" => "88"
            ]);
            FrameworkControlTest::create([
                "id" => "89",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-3-3",
                "framework_control_id" => "89"
            ]);
            FrameworkControlTest::create([
                "id" => "90",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-3-4",
                "framework_control_id" => "90"
            ]);
            FrameworkControlTest::create([
                "id" => "91",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-3-5",
                "framework_control_id" => "91"
            ]);
            FrameworkControlTest::create([
                "id" => "92",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-4-4",
                "framework_control_id" => "92"
            ]);
            FrameworkControlTest::create([
                "id" => "93",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-1",
                "framework_control_id" => "93"
            ]);
            FrameworkControlTest::create([
                "id" => "94",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-2",
                "framework_control_id" => "94"
            ]);
            FrameworkControlTest::create([
                "id" => "95",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3",
                "framework_control_id" => "95"
            ]);
            FrameworkControlTest::create([
                "id" => "96",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-1",
                "framework_control_id" => "96"
            ]);
            FrameworkControlTest::create([
                "id" => "97",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-2",
                "framework_control_id" => "97"
            ]);
            FrameworkControlTest::create([
                "id" => "98",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-3",
                "framework_control_id" => "98"
            ]);
            FrameworkControlTest::create([
                "id" => "99",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-4",
                "framework_control_id" => "99"
            ]);
            FrameworkControlTest::create([
                "id" => "100",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-5",
                "framework_control_id" => "100"
            ]);
            FrameworkControlTest::create([
                "id" => "101",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-6",
                "framework_control_id" => "101"
            ]);
            FrameworkControlTest::create([
                "id" => "102",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-7",
                "framework_control_id" => "102"
            ]);
            FrameworkControlTest::create([
                "id" => "103",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-3-8",
                "framework_control_id" => "103"
            ]);
            FrameworkControlTest::create([
                "id" => "104",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-5-4",
                "framework_control_id" => "104"
            ]);
            FrameworkControlTest::create([
                "id" => "105",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-1",
                "framework_control_id" => "105"
            ]);
            FrameworkControlTest::create([
                "id" => "106",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-2",
                "framework_control_id" => "106"
            ]);
            FrameworkControlTest::create([
                "id" => "107",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-3",
                "framework_control_id" => "107"
            ]);
            FrameworkControlTest::create([
                "id" => "108",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-3-1",
                "framework_control_id" => "108"
            ]);
            FrameworkControlTest::create([
                "id" => "109",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-3-2",
                "framework_control_id" => "109"
            ]);
            FrameworkControlTest::create([
                "id" => "110",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-3-3",
                "framework_control_id" => "110"
            ]);
            FrameworkControlTest::create([
                "id" => "111",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-3-4",
                "framework_control_id" => "111"
            ]);
            FrameworkControlTest::create([
                "id" => "112",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-6-4",
                "framework_control_id" => "112"
            ]);
            FrameworkControlTest::create([
                "id" => "113",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-1",
                "framework_control_id" => "113"
            ]);
            FrameworkControlTest::create([
                "id" => "114",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-2",
                "framework_control_id" => "114"
            ]);
            FrameworkControlTest::create([
                "id" => "115",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-3",
                "framework_control_id" => "115"
            ]);
            FrameworkControlTest::create([
                "id" => "116",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-3-1",
                "framework_control_id" => "116"
            ]);
            FrameworkControlTest::create([
                "id" => "117",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-3-2",
                "framework_control_id" => "117"
            ]);
            FrameworkControlTest::create([
                "id" => "118",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-3-3",
                "framework_control_id" => "118"
            ]);
            FrameworkControlTest::create([
                "id" => "119",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-7-4",
                "framework_control_id" => "119"
            ]);
            FrameworkControlTest::create([
                "id" => "120",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-1",
                "framework_control_id" => "120"
            ]);
            FrameworkControlTest::create([
                "id" => "121",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-2",
                "framework_control_id" => "121"
            ]);
            FrameworkControlTest::create([
                "id" => "122",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-3",
                "framework_control_id" => "122"
            ]);
            FrameworkControlTest::create([
                "id" => "123",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-3-1",
                "framework_control_id" => "123"
            ]);
            FrameworkControlTest::create([
                "id" => "124",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-3-2",
                "framework_control_id" => "124"
            ]);
            FrameworkControlTest::create([
                "id" => "125",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-3-3",
                "framework_control_id" => "125"
            ]);
            FrameworkControlTest::create([
                "id" => "126",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-8-4",
                "framework_control_id" => "126"
            ]);
            FrameworkControlTest::create([
                "id" => "127",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-1",
                "framework_control_id" => "127"
            ]);
            FrameworkControlTest::create([
                "id" => "128",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-2",
                "framework_control_id" => "128"
            ]);
            FrameworkControlTest::create([
                "id" => "129",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-3",
                "framework_control_id" => "129"
            ]);
            FrameworkControlTest::create([
                "id" => "130",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-3-1",
                "framework_control_id" => "130"
            ]);
            FrameworkControlTest::create([
                "id" => "131",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-3-2",
                "framework_control_id" => "131"
            ]);
            FrameworkControlTest::create([
                "id" => "132",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-3-3",
                "framework_control_id" => "132"
            ]);
            FrameworkControlTest::create([
                "id" => "133",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-9-4",
                "framework_control_id" => "133"
            ]);
            FrameworkControlTest::create([
                "id" => "134",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-1",
                "framework_control_id" => "134"
            ]);
            FrameworkControlTest::create([
                "id" => "135",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-2",
                "framework_control_id" => "135"
            ]);
            FrameworkControlTest::create([
                "id" => "136",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-3",
                "framework_control_id" => "136"
            ]);
            FrameworkControlTest::create([
                "id" => "137",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-3-1",
                "framework_control_id" => "137"
            ]);
            FrameworkControlTest::create([
                "id" => "138",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-3-2",
                "framework_control_id" => "138"
            ]);
            FrameworkControlTest::create([
                "id" => "139",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-3-3",
                "framework_control_id" => "139"
            ]);
            FrameworkControlTest::create([
                "id" => "140",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-3-4",
                "framework_control_id" => "140"
            ]);
            FrameworkControlTest::create([
                "id" => "141",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-3-5",
                "framework_control_id" => "141"
            ]);
            FrameworkControlTest::create([
                "id" => "142",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-10-4",
                "framework_control_id" => "142"
            ]);
            FrameworkControlTest::create([
                "id" => "143",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-11-1",
                "framework_control_id" => "143"
            ]);
            FrameworkControlTest::create([
                "id" => "144",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-11-2",
                "framework_control_id" => "144"
            ]);
            FrameworkControlTest::create([
                "id" => "145",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-11-3",
                "framework_control_id" => "145"
            ]);
            FrameworkControlTest::create([
                "id" => "146",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-11-3-1",
                "framework_control_id" => "146"
            ]);
            FrameworkControlTest::create([
                "id" => "147",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-11-3-2",
                "framework_control_id" => "147"
            ]);
            FrameworkControlTest::create([
                "id" => "148",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-11-4",
                "framework_control_id" => "148"
            ]);
            FrameworkControlTest::create([
                "id" => "149",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-1",
                "framework_control_id" => "149"
            ]);
            FrameworkControlTest::create([
                "id" => "150",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-2",
                "framework_control_id" => "150"
            ]);
            FrameworkControlTest::create([
                "id" => "151",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-3",
                "framework_control_id" => "151"
            ]);
            FrameworkControlTest::create([
                "id" => "152",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-3-1",
                "framework_control_id" => "152"
            ]);
            FrameworkControlTest::create([
                "id" => "153",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-3-2",
                "framework_control_id" => "153"
            ]);
            FrameworkControlTest::create([
                "id" => "154",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-3-3",
                "framework_control_id" => "154"
            ]);
            FrameworkControlTest::create([
                "id" => "155",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-3-4",
                "framework_control_id" => "155"
            ]);
            FrameworkControlTest::create([
                "id" => "156",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-3-5",
                "framework_control_id" => "156"
            ]);
            FrameworkControlTest::create([
                "id" => "157",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-12-4",
                "framework_control_id" => "157"
            ]);
            FrameworkControlTest::create([
                "id" => "158",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-1",
                "framework_control_id" => "158"
            ]);
            FrameworkControlTest::create([
                "id" => "159",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-2",
                "framework_control_id" => "159"
            ]);
            FrameworkControlTest::create([
                "id" => "160",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-3",
                "framework_control_id" => "160"
            ]);
            FrameworkControlTest::create([
                "id" => "161",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-3-1",
                "framework_control_id" => "161"
            ]);
            FrameworkControlTest::create([
                "id" => "162",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-3-2",
                "framework_control_id" => "162"
            ]);
            FrameworkControlTest::create([
                "id" => "163",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-3-3",
                "framework_control_id" => "163"
            ]);
            FrameworkControlTest::create([
                "id" => "164",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-3-4",
                "framework_control_id" => "164"
            ]);
            FrameworkControlTest::create([
                "id" => "165",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-3-5",
                "framework_control_id" => "165"
            ]);
            FrameworkControlTest::create([
                "id" => "166",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-13-4",
                "framework_control_id" => "166"
            ]);
            FrameworkControlTest::create([
                "id" => "167",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-1",
                "framework_control_id" => "167"
            ]);
            FrameworkControlTest::create([
                "id" => "168",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-2",
                "framework_control_id" => "168"
            ]);
            FrameworkControlTest::create([
                "id" => "169",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-3",
                "framework_control_id" => "169"
            ]);
            FrameworkControlTest::create([
                "id" => "170",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-3-1",
                "framework_control_id" => "170"
            ]);
            FrameworkControlTest::create([
                "id" => "171",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-3-2",
                "framework_control_id" => "171"
            ]);
            FrameworkControlTest::create([
                "id" => "172",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-3-3",
                "framework_control_id" => "172"
            ]);
            FrameworkControlTest::create([
                "id" => "173",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-3-4",
                "framework_control_id" => "173"
            ]);
            FrameworkControlTest::create([
                "id" => "174",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-3-5",
                "framework_control_id" => "174"
            ]);
            FrameworkControlTest::create([
                "id" => "175",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-14-4",
                "framework_control_id" => "175"
            ]);
            FrameworkControlTest::create([
                "id" => "176",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-1",
                "framework_control_id" => "176"
            ]);
            FrameworkControlTest::create([
                "id" => "177",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-2",
                "framework_control_id" => "177"
            ]);
            FrameworkControlTest::create([
                "id" => "178",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-3",
                "framework_control_id" => "178"
            ]);
            FrameworkControlTest::create([
                "id" => "179",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-3-1",
                "framework_control_id" => "179"
            ]);
            FrameworkControlTest::create([
                "id" => "180",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-3-2",
                "framework_control_id" => "180"
            ]);
            FrameworkControlTest::create([
                "id" => "181",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-3-3",
                "framework_control_id" => "181"
            ]);
            FrameworkControlTest::create([
                "id" => "182",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-3-4",
                "framework_control_id" => "182"
            ]);
            FrameworkControlTest::create([
                "id" => "183",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-3-5",
                "framework_control_id" => "183"
            ]);
            FrameworkControlTest::create([
                "id" => "184",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 2-15-4",
                "framework_control_id" => "184"
            ]);
            FrameworkControlTest::create([
                "id" => "185",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-1",
                "framework_control_id" => "185"
            ]);
            FrameworkControlTest::create([
                "id" => "186",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-2",
                "framework_control_id" => "186"
            ]);
            FrameworkControlTest::create([
                "id" => "187",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-3",
                "framework_control_id" => "187"
            ]);
            FrameworkControlTest::create([
                "id" => "188",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-3-1",
                "framework_control_id" => "188"
            ]);
            FrameworkControlTest::create([
                "id" => "189",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-3-2",
                "framework_control_id" => "189"
            ]);
            FrameworkControlTest::create([
                "id" => "190",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-3-3",
                "framework_control_id" => "190"
            ]);
            FrameworkControlTest::create([
                "id" => "191",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 3-1-4",
                "framework_control_id" => "191"
            ]);
            FrameworkControlTest::create([
                "id" => "192",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-1",
                "framework_control_id" => "192"
            ]);
            FrameworkControlTest::create([
                "id" => "193",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-2",
                "framework_control_id" => "193"
            ]);
            FrameworkControlTest::create([
                "id" => "194",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-2-1",
                "framework_control_id" => "194"
            ]);
            FrameworkControlTest::create([
                "id" => "195",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-2-2",
                "framework_control_id" => "195"
            ]);
            FrameworkControlTest::create([
                "id" => "196",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-2-3",
                "framework_control_id" => "196"
            ]);
            FrameworkControlTest::create([
                "id" => "197",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-3",
                "framework_control_id" => "197"
            ]);
            FrameworkControlTest::create([
                "id" => "198",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-3-1",
                "framework_control_id" => "198"
            ]);
            FrameworkControlTest::create([
                "id" => "199",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-3-2",
                "framework_control_id" => "199"
            ]);
            FrameworkControlTest::create([
                "id" => "200",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-1-4",
                "framework_control_id" => "200"
            ]);
            FrameworkControlTest::create([
                "id" => "201",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-1",
                "framework_control_id" => "201"
            ]);
            FrameworkControlTest::create([
                "id" => "202",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-2",
                "framework_control_id" => "202"
            ]);
            FrameworkControlTest::create([
                "id" => "203",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-3",
                "framework_control_id" => "203"
            ]);
            FrameworkControlTest::create([
                "id" => "204",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-3-1",
                "framework_control_id" => "204"
            ]);
            FrameworkControlTest::create([
                "id" => "205",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-3-2",
                "framework_control_id" => "205"
            ]);
            FrameworkControlTest::create([
                "id" => "206",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-3-3",
                "framework_control_id" => "206"
            ]);
            FrameworkControlTest::create([
                "id" => "207",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 4-2-4",
                "framework_control_id" => "207"
            ]);
            FrameworkControlTest::create([
                "id" => "208",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-1",
                "framework_control_id" => "208"
            ]);
            FrameworkControlTest::create([
                "id" => "209",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-2",
                "framework_control_id" => "209"
            ]);
            FrameworkControlTest::create([
                "id" => "210",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3",
                "framework_control_id" => "210"
            ]);
            FrameworkControlTest::create([
                "id" => "211",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-1",
                "framework_control_id" => "211"
            ]);
            FrameworkControlTest::create([
                "id" => "212",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-2",
                "framework_control_id" => "212"
            ]);
            FrameworkControlTest::create([
                "id" => "213",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-3",
                "framework_control_id" => "213"
            ]);
            FrameworkControlTest::create([
                "id" => "214",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-4",
                "framework_control_id" => "214"
            ]);
            FrameworkControlTest::create([
                "id" => "215",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-5",
                "framework_control_id" => "215"
            ]);
            FrameworkControlTest::create([
                "id" => "216",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-6",
                "framework_control_id" => "216"
            ]);
            FrameworkControlTest::create([
                "id" => "217",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-7",
                "framework_control_id" => "217"
            ]);
            FrameworkControlTest::create([
                "id" => "218",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-8",
                "framework_control_id" => "218"
            ]);
            FrameworkControlTest::create([
                "id" => "219",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-9",
                "framework_control_id" => "219"
            ]);
            FrameworkControlTest::create([
                "id" => "220",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-3-10",
                "framework_control_id" => "220"
            ]);
            FrameworkControlTest::create([
                "id" => "221",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 5-1-4",
                "framework_control_id" => "221"
            ]);
            FrameworkControlTest::create([
                "id" => "897",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ECC 1-6-4",
                "framework_control_id" => "897"
            ]);
        }
        // NCA-SMACC
        if (in_array('NCA-SMACC', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "222",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-1-1",
                "framework_control_id" => "222"
            ]);
            FrameworkControlTest::create([
                "id" => "223",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-1-1-1",
                "framework_control_id" => "223"
            ]);
            FrameworkControlTest::create([
                "id" => "224",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-2-1",
                "framework_control_id" => "224"
            ]);
            FrameworkControlTest::create([
                "id" => "225",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-2-1-1",
                "framework_control_id" => "225"
            ]);
            FrameworkControlTest::create([
                "id" => "226",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-2-1-2",
                "framework_control_id" => "226"
            ]);
            FrameworkControlTest::create([
                "id" => "227",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-2-1-3",
                "framework_control_id" => "227"
            ]);
            FrameworkControlTest::create([
                "id" => "228",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-3-1",
                "framework_control_id" => "228"
            ]);
            FrameworkControlTest::create([
                "id" => "229",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-3-1-1",
                "framework_control_id" => "229"
            ]);
            FrameworkControlTest::create([
                "id" => "230",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-3-1-2",
                "framework_control_id" => "230"
            ]);
            FrameworkControlTest::create([
                "id" => "231",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1",
                "framework_control_id" => "231"
            ]);
            FrameworkControlTest::create([
                "id" => "232",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-1",
                "framework_control_id" => "232"
            ]);
            FrameworkControlTest::create([
                "id" => "233",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-2",
                "framework_control_id" => "233"
            ]);
            FrameworkControlTest::create([
                "id" => "234",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-3",
                "framework_control_id" => "234"
            ]);
            FrameworkControlTest::create([
                "id" => "235",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-4",
                "framework_control_id" => "235"
            ]);
            FrameworkControlTest::create([
                "id" => "236",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-5",
                "framework_control_id" => "236"
            ]);
            FrameworkControlTest::create([
                "id" => "237",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-6",
                "framework_control_id" => "237"
            ]);
            FrameworkControlTest::create([
                "id" => "238",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-1-7",
                "framework_control_id" => "238"
            ]);
            FrameworkControlTest::create([
                "id" => "239",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 1-4-2",
                "framework_control_id" => "239"
            ]);
            FrameworkControlTest::create([
                "id" => "240",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-1-1",
                "framework_control_id" => "240"
            ]);
            FrameworkControlTest::create([
                "id" => "241",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-1-1",
                "framework_control_id" => "241"
            ]);
            FrameworkControlTest::create([
                "id" => "242",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1",
                "framework_control_id" => "242"
            ]);
            FrameworkControlTest::create([
                "id" => "243",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-1",
                "framework_control_id" => "243"
            ]);
            FrameworkControlTest::create([
                "id" => "244",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-2",
                "framework_control_id" => "244"
            ]);
            FrameworkControlTest::create([
                "id" => "245",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-3",
                "framework_control_id" => "245"
            ]);
            FrameworkControlTest::create([
                "id" => "246",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-4",
                "framework_control_id" => "246"
            ]);
            FrameworkControlTest::create([
                "id" => "247",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-5",
                "framework_control_id" => "247"
            ]);
            FrameworkControlTest::create([
                "id" => "248",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-6",
                "framework_control_id" => "248"
            ]);
            FrameworkControlTest::create([
                "id" => "249",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-7",
                "framework_control_id" => "249"
            ]);
            FrameworkControlTest::create([
                "id" => "250",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-8",
                "framework_control_id" => "250"
            ]);
            FrameworkControlTest::create([
                "id" => "251",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-1-9",
                "framework_control_id" => "251"
            ]);
            FrameworkControlTest::create([
                "id" => "252",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-2-2",
                "framework_control_id" => "252"
            ]);
            FrameworkControlTest::create([
                "id" => "253",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-3-1",
                "framework_control_id" => "253"
            ]);
            FrameworkControlTest::create([
                "id" => "254",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-3-1-1",
                "framework_control_id" => "254"
            ]);
            FrameworkControlTest::create([
                "id" => "255",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-3-1-2",
                "framework_control_id" => "255"
            ]);
            FrameworkControlTest::create([
                "id" => "256",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-3-1-3",
                "framework_control_id" => "256"
            ]);
            FrameworkControlTest::create([
                "id" => "257",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-3-1-4",
                "framework_control_id" => "257"
            ]);
            FrameworkControlTest::create([
                "id" => "258",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-4-1",
                "framework_control_id" => "258"
            ]);
            FrameworkControlTest::create([
                "id" => "259",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-4-1-1",
                "framework_control_id" => "259"
            ]);
            FrameworkControlTest::create([
                "id" => "260",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-4-1-2",
                "framework_control_id" => "260"
            ]);
            FrameworkControlTest::create([
                "id" => "261",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-5-1",
                "framework_control_id" => "261"
            ]);
            FrameworkControlTest::create([
                "id" => "262",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-5-1-1",
                "framework_control_id" => "262"
            ]);
            FrameworkControlTest::create([
                "id" => "263",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-6-1",
                "framework_control_id" => "263"
            ]);
            FrameworkControlTest::create([
                "id" => "264",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-6-1-1",
                "framework_control_id" => "264"
            ]);
            FrameworkControlTest::create([
                "id" => "265",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-6-1-2",
                "framework_control_id" => "265"
            ]);
            FrameworkControlTest::create([
                "id" => "266",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-6-1-3",
                "framework_control_id" => "266"
            ]);
            FrameworkControlTest::create([
                "id" => "267",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-6-1-4",
                "framework_control_id" => "267"
            ]);
            FrameworkControlTest::create([
                "id" => "268",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-7-1",
                "framework_control_id" => "268"
            ]);
            FrameworkControlTest::create([
                "id" => "269",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 2-7-1-1",
                "framework_control_id" => "269"
            ]);
            FrameworkControlTest::create([
                "id" => "270",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 3-1-1",
                "framework_control_id" => "270"
            ]);
            FrameworkControlTest::create([
                "id" => "271",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 3-1-2",
                "framework_control_id" => "271"
            ]);
            FrameworkControlTest::create([
                "id" => "272",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 3-1-2-1",
                "framework_control_id" => "272"
            ]);
            FrameworkControlTest::create([
                "id" => "273",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 3-1-2-2",
                "framework_control_id" => "273"
            ]);
            FrameworkControlTest::create([
                "id" => "274",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SMACC 3-1-2-3",
                "framework_control_id" => "274"
            ]);
        }
        // NCA-CCC – 1: 2020
        if (in_array('NCA-CCC – 1: 2020', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "507",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-١-م-١",
                "framework_control_id" => "507"
            ]);
            FrameworkControlTest::create([
                "id" => "508",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-١-م-١-١‏",
                "framework_control_id" => "508"
            ]);
            FrameworkControlTest::create([
                "id" => "509",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-١-ش۔١",
                "framework_control_id" => "509"
            ]);
            FrameworkControlTest::create([
                "id" => "510",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-١-ش۔١-١",
                "framework_control_id" => "510"
            ]);
            FrameworkControlTest::create([
                "id" => "511",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-م-١",
                "framework_control_id" => "511"
            ]);
            FrameworkControlTest::create([
                "id" => "512",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-م-١-١‏",
                "framework_control_id" => "512"
            ]);
            FrameworkControlTest::create([
                "id" => "513",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-م-١-٢",
                "framework_control_id" => "513"
            ]);
            FrameworkControlTest::create([
                "id" => "514",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-م-١-3",
                "framework_control_id" => "514"
            ]);
            FrameworkControlTest::create([
                "id" => "515",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-ش-١",
                "framework_control_id" => "515"
            ]);
            FrameworkControlTest::create([
                "id" => "516",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-ش-۔١-١‏",
                "framework_control_id" => "516"
            ]);
            FrameworkControlTest::create([
                "id" => "517",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-ش۔١۔٢",
                "framework_control_id" => "517"
            ]);
            FrameworkControlTest::create([
                "id" => "518",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٢-ش۔١۔3‏",
                "framework_control_id" => "518"
            ]);
            FrameworkControlTest::create([
                "id" => "519",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٣-م-١",
                "framework_control_id" => "519"
            ]);
            FrameworkControlTest::create([
                "id" => "520",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٣-م-١-١",
                "framework_control_id" => "520"
            ]);
            FrameworkControlTest::create([
                "id" => "521",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٣-ش۔١",
                "framework_control_id" => "521"
            ]);
            FrameworkControlTest::create([
                "id" => "522",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٣-ش-١-١",
                "framework_control_id" => "522"
            ]);
            FrameworkControlTest::create([
                "id" => "523",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-م-١",
                "framework_control_id" => "523"
            ]);
            FrameworkControlTest::create([
                "id" => "524",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-م-١-١",
                "framework_control_id" => "524"
            ]);
            FrameworkControlTest::create([
                "id" => "525",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-م-١۔٢",
                "framework_control_id" => "525"
            ]);
            FrameworkControlTest::create([
                "id" => "526",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-م-١۔3",
                "framework_control_id" => "526"
            ]);
            FrameworkControlTest::create([
                "id" => "527",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-م-2",
                "framework_control_id" => "527"
            ]);
            FrameworkControlTest::create([
                "id" => "528",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-م-2۔1",
                "framework_control_id" => "528"
            ]);
            FrameworkControlTest::create([
                "id" => "529",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-ش-١",
                "framework_control_id" => "529"
            ]);
            FrameworkControlTest::create([
                "id" => "530",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٤-ش-١-١",
                "framework_control_id" => "530"
            ]);
            FrameworkControlTest::create([
                "id" => "531",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-م-5-1",
                "framework_control_id" => "531"
            ]);
            FrameworkControlTest::create([
                "id" => "532",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٥-م-٢",
                "framework_control_id" => "532"
            ]);
            FrameworkControlTest::create([
                "id" => "533",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٥-م-۳",
                "framework_control_id" => "533"
            ]);
            FrameworkControlTest::create([
                "id" => "534",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٥-م-۳-١",
                "framework_control_id" => "534"
            ]);
            FrameworkControlTest::create([
                "id" => "535",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٥-م-۳-2",
                "framework_control_id" => "535"
            ]);
            FrameworkControlTest::create([
                "id" => "536",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ١-٥-م-4",
                "framework_control_id" => "536"
            ]);
            FrameworkControlTest::create([
                "id" => "537",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١-م-١",
                "framework_control_id" => "537"
            ]);
            FrameworkControlTest::create([
                "id" => "538",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١-م-١-١",
                "framework_control_id" => "538"
            ]);
            FrameworkControlTest::create([
                "id" => "539",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١-م-١-2",
                "framework_control_id" => "539"
            ]);
            FrameworkControlTest::create([
                "id" => "540",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١-ش۔١",
                "framework_control_id" => "540"
            ]);
            FrameworkControlTest::create([
                "id" => "541",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١-ش۔١-١‏",
                "framework_control_id" => "541"
            ]);
            FrameworkControlTest::create([
                "id" => "542",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١",
                "framework_control_id" => "542"
            ]);
            FrameworkControlTest::create([
                "id" => "543",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-١",
                "framework_control_id" => "543"
            ]);
            FrameworkControlTest::create([
                "id" => "544",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١۔٢",
                "framework_control_id" => "544"
            ]);
            FrameworkControlTest::create([
                "id" => "545",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-٣",
                "framework_control_id" => "545"
            ]);
            FrameworkControlTest::create([
                "id" => "546",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م۔١-٤",
                "framework_control_id" => "546"
            ]);
            FrameworkControlTest::create([
                "id" => "547",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-٥",
                "framework_control_id" => "547"
            ]);
            FrameworkControlTest::create([
                "id" => "548",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢۔٢-م-١-٦",
                "framework_control_id" => "548"
            ]);
            FrameworkControlTest::create([
                "id" => "549",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-٧",
                "framework_control_id" => "549"
            ]);
            FrameworkControlTest::create([
                "id" => "550",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-٨",
                "framework_control_id" => "550"
            ]);
            FrameworkControlTest::create([
                "id" => "551",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-٩",
                "framework_control_id" => "551"
            ]);
            FrameworkControlTest::create([
                "id" => "552",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-١٠",
                "framework_control_id" => "552"
            ]);
            FrameworkControlTest::create([
                "id" => "553",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-١١‏",
                "framework_control_id" => "553"
            ]);
            FrameworkControlTest::create([
                "id" => "554",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-م-١-١٢",
                "framework_control_id" => "554"
            ]);
            FrameworkControlTest::create([
                "id" => "555",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-ش۔١",
                "framework_control_id" => "555"
            ]);
            FrameworkControlTest::create([
                "id" => "556",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-ش۔١۔1",
                "framework_control_id" => "556"
            ]);
            FrameworkControlTest::create([
                "id" => "557",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-ش۔١۔٢‏",
                "framework_control_id" => "557"
            ]);
            FrameworkControlTest::create([
                "id" => "558",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-ش۔١-٣‏",
                "framework_control_id" => "558"
            ]);
            FrameworkControlTest::create([
                "id" => "559",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢۔٢-ش۔١-٤",
                "framework_control_id" => "559"
            ]);
            FrameworkControlTest::create([
                "id" => "560",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢-ش-١-٥",
                "framework_control_id" => "560"
            ]);
            FrameworkControlTest::create([
                "id" => "561",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ccc ٢-٣-م-١",
                "framework_control_id" => "561"
            ]);
            FrameworkControlTest::create([
                "id" => "562",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ccc ٢-٣-م-١-١",
                "framework_control_id" => "562"
            ]);
            FrameworkControlTest::create([
                "id" => "563",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-٢‏",
                "framework_control_id" => "563"
            ]);
            FrameworkControlTest::create([
                "id" => "564",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC  ٢-٣-م-١-٣‏",
                "framework_control_id" => "564"
            ]);
            FrameworkControlTest::create([
                "id" => "565",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-۔١-٤",
                "framework_control_id" => "565"
            ]);
            FrameworkControlTest::create([
                "id" => "566",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-٥",
                "framework_control_id" => "566"
            ]);
            FrameworkControlTest::create([
                "id" => "567",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-٦",
                "framework_control_id" => "567"
            ]);
            FrameworkControlTest::create([
                "id" => "568",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢۔٣-م-١-٧",
                "framework_control_id" => "568"
            ]);
            FrameworkControlTest::create([
                "id" => "569",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-٨",
                "framework_control_id" => "569"
            ]);
            FrameworkControlTest::create([
                "id" => "570",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-٩",
                "framework_control_id" => "570"
            ]);
            FrameworkControlTest::create([
                "id" => "571",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-10",
                "framework_control_id" => "571"
            ]);
            FrameworkControlTest::create([
                "id" => "572",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-١١",
                "framework_control_id" => "572"
            ]);
            FrameworkControlTest::create([
                "id" => "573",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-م-١-12",
                "framework_control_id" => "573"
            ]);
            FrameworkControlTest::create([
                "id" => "574",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-ش۔١",
                "framework_control_id" => "574"
            ]);
            FrameworkControlTest::create([
                "id" => "575",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٣-ش۔١-١",
                "framework_control_id" => "575"
            ]);
            FrameworkControlTest::create([
                "id" => "576",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١",
                "framework_control_id" => "576"
            ]);
            FrameworkControlTest::create([
                "id" => "577",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١-١",
                "framework_control_id" => "577"
            ]);
            FrameworkControlTest::create([
                "id" => "578",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١-٢",
                "framework_control_id" => "578"
            ]);
            FrameworkControlTest::create([
                "id" => "579",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١-٣",
                "framework_control_id" => "579"
            ]);
            FrameworkControlTest::create([
                "id" => "580",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١-٤",
                "framework_control_id" => "580"
            ]);
            FrameworkControlTest::create([
                "id" => "581",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١-٥",
                "framework_control_id" => "581"
            ]);
            FrameworkControlTest::create([
                "id" => "582",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-م-١-٦",
                "framework_control_id" => "582"
            ]);
            FrameworkControlTest::create([
                "id" => "583",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-ش-١",
                "framework_control_id" => "583"
            ]);
            FrameworkControlTest::create([
                "id" => "584",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٤-ش-1-١",
                "framework_control_id" => "584"
            ]);
            FrameworkControlTest::create([
                "id" => "585",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-م-١",
                "framework_control_id" => "585"
            ]);
            FrameworkControlTest::create([
                "id" => "586",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-م-١-١",
                "framework_control_id" => "586"
            ]);
            FrameworkControlTest::create([
                "id" => "587",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-م-١-٢",
                "framework_control_id" => "587"
            ]);
            FrameworkControlTest::create([
                "id" => "588",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-م-١-٣",
                "framework_control_id" => "588"
            ]);
            FrameworkControlTest::create([
                "id" => "589",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-م-١-4",
                "framework_control_id" => "589"
            ]);
            FrameworkControlTest::create([
                "id" => "590",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-ش-١",
                "framework_control_id" => "590"
            ]);
            FrameworkControlTest::create([
                "id" => "591",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٥-ش۔١-١",
                "framework_control_id" => "591"
            ]);
            FrameworkControlTest::create([
                "id" => "592",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-م-١",
                "framework_control_id" => "592"
            ]);
            FrameworkControlTest::create([
                "id" => "593",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-م-١-١",
                "framework_control_id" => "593"
            ]);
            FrameworkControlTest::create([
                "id" => "594",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-م-١-٢",
                "framework_control_id" => "594"
            ]);
            FrameworkControlTest::create([
                "id" => "595",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢۔٦-م-١-٣",
                "framework_control_id" => "595"
            ]);
            FrameworkControlTest::create([
                "id" => "596",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-م-۔١-٤",
                "framework_control_id" => "596"
            ]);
            FrameworkControlTest::create([
                "id" => "597",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-م-١-٥",
                "framework_control_id" => "597"
            ]);
            FrameworkControlTest::create([
                "id" => "598",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-ش-١",
                "framework_control_id" => "598"
            ]);
            FrameworkControlTest::create([
                "id" => "599",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-ش۔١-١‏",
                "framework_control_id" => "599"
            ]);
            FrameworkControlTest::create([
                "id" => "600",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٦-ش۔١۔٢",
                "framework_control_id" => "600"
            ]);
            FrameworkControlTest::create([
                "id" => "601",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٧-م-١",
                "framework_control_id" => "601"
            ]);
            FrameworkControlTest::create([
                "id" => "602",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٧-م-١-١",
                "framework_control_id" => "602"
            ]);
            FrameworkControlTest::create([
                "id" => "603",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٧-م-١۔٢",
                "framework_control_id" => "603"
            ]);
            FrameworkControlTest::create([
                "id" => "604",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٧-ش-١",
                "framework_control_id" => "604"
            ]);
            FrameworkControlTest::create([
                "id" => "605",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٧-ش۔١-١",
                "framework_control_id" => "605"
            ]);
            FrameworkControlTest::create([
                "id" => "606",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٧-ش۔١۔٢",
                "framework_control_id" => "606"
            ]);
            FrameworkControlTest::create([
                "id" => "607",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٨-م-١",
                "framework_control_id" => "607"
            ]);
            FrameworkControlTest::create([
                "id" => "608",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٨-م-١-١",
                "framework_control_id" => "608"
            ]);
            FrameworkControlTest::create([
                "id" => "609",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٨-م-١۔٢",
                "framework_control_id" => "609"
            ]);
            FrameworkControlTest::create([
                "id" => "610",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٩-م-١",
                "framework_control_id" => "610"
            ]);
            FrameworkControlTest::create([
                "id" => "611",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٩-م-١-١",
                "framework_control_id" => "611"
            ]);
            FrameworkControlTest::create([
                "id" => "612",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٩-م-١-٢",
                "framework_control_id" => "612"
            ]);
            FrameworkControlTest::create([
                "id" => "613",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٩-ش-١",
                "framework_control_id" => "613"
            ]);
            FrameworkControlTest::create([
                "id" => "614",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٩-ش-١-١",
                "framework_control_id" => "614"
            ]);
            FrameworkControlTest::create([
                "id" => "615",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٩-ش۔١۔٢",
                "framework_control_id" => "615"
            ]);
            FrameworkControlTest::create([
                "id" => "616",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٠-م-١",
                "framework_control_id" => "616"
            ]);
            FrameworkControlTest::create([
                "id" => "617",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٠-م-١-١",
                "framework_control_id" => "617"
            ]);
            FrameworkControlTest::create([
                "id" => "618",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-م-١",
                "framework_control_id" => "618"
            ]);
            FrameworkControlTest::create([
                "id" => "619",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-م-١-١",
                "framework_control_id" => "619"
            ]);
            FrameworkControlTest::create([
                "id" => "620",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-م-١-٢",
                "framework_control_id" => "620"
            ]);
            FrameworkControlTest::create([
                "id" => "621",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-م-١-٣",
                "framework_control_id" => "621"
            ]);
            FrameworkControlTest::create([
                "id" => "622",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-م-١-٤",
                "framework_control_id" => "622"
            ]);
            FrameworkControlTest::create([
                "id" => "623",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١۔م-١-٥",
                "framework_control_id" => "623"
            ]);
            FrameworkControlTest::create([
                "id" => "624",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١۔م-١-٦",
                "framework_control_id" => "624"
            ]);
            FrameworkControlTest::create([
                "id" => "625",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١۔م-١-٧",
                "framework_control_id" => "625"
            ]);
            FrameworkControlTest::create([
                "id" => "626",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١۔م-١-٨‏",
                "framework_control_id" => "626"
            ]);
            FrameworkControlTest::create([
                "id" => "627",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-ش-١",
                "framework_control_id" => "627"
            ]);
            FrameworkControlTest::create([
                "id" => "628",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-ش-١-١",
                "framework_control_id" => "628"
            ]);
            FrameworkControlTest::create([
                "id" => "629",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١١-ش۔١۔٢",
                "framework_control_id" => "629"
            ]);
            FrameworkControlTest::create([
                "id" => "630",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١",
                "framework_control_id" => "630"
            ]);
            FrameworkControlTest::create([
                "id" => "631",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-1",
                "framework_control_id" => "631"
            ]);
            FrameworkControlTest::create([
                "id" => "632",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-2",
                "framework_control_id" => "632"
            ]);
            FrameworkControlTest::create([
                "id" => "633",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-3",
                "framework_control_id" => "633"
            ]);
            FrameworkControlTest::create([
                "id" => "634",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-4",
                "framework_control_id" => "634"
            ]);
            FrameworkControlTest::create([
                "id" => "635",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-5",
                "framework_control_id" => "635"
            ]);
            FrameworkControlTest::create([
                "id" => "636",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-6",
                "framework_control_id" => "636"
            ]);
            FrameworkControlTest::create([
                "id" => "637",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-٢١-م-١-٧",
                "framework_control_id" => "637"
            ]);
            FrameworkControlTest::create([
                "id" => "638",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٢-م-١-8",
                "framework_control_id" => "638"
            ]);
            FrameworkControlTest::create([
                "id" => "639",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٣-م-1",
                "framework_control_id" => "639"
            ]);
            FrameworkControlTest::create([
                "id" => "640",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٣-م-١-١",
                "framework_control_id" => "640"
            ]);
            FrameworkControlTest::create([
                "id" => "641",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٣-م-١-٢",
                "framework_control_id" => "641"
            ]);
            FrameworkControlTest::create([
                "id" => "642",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٣-م-١-٣",
                "framework_control_id" => "642"
            ]);
            FrameworkControlTest::create([
                "id" => "643",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٤-م-١",
                "framework_control_id" => "643"
            ]);
            FrameworkControlTest::create([
                "id" => "644",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٤-م-١-١",
                "framework_control_id" => "644"
            ]);
            FrameworkControlTest::create([
                "id" => "645",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-١",
                "framework_control_id" => "645"
            ]);
            FrameworkControlTest::create([
                "id" => "646",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-٢",
                "framework_control_id" => "646"
            ]);
            FrameworkControlTest::create([
                "id" => "647",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-٣",
                "framework_control_id" => "647"
            ]);
            FrameworkControlTest::create([
                "id" => "648",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-٣-١",
                "framework_control_id" => "648"
            ]);
            FrameworkControlTest::create([
                "id" => "649",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-٣-2",
                "framework_control_id" => "649"
            ]);
            FrameworkControlTest::create([
                "id" => "650",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-٣-3",
                "framework_control_id" => "650"
            ]);
            FrameworkControlTest::create([
                "id" => "651",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-م-٤",
                "framework_control_id" => "651"
            ]);
            FrameworkControlTest::create([
                "id" => "652",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-ش-١",
                "framework_control_id" => "652"
            ]);
            FrameworkControlTest::create([
                "id" => "653",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-ش-٢",
                "framework_control_id" => "653"
            ]);
            FrameworkControlTest::create([
                "id" => "654",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-ش-3",
                "framework_control_id" => "654"
            ]);
            FrameworkControlTest::create([
                "id" => "655",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-ش-٣-١",
                "framework_control_id" => "655"
            ]);
            FrameworkControlTest::create([
                "id" => "656",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-ش-٣-٢",
                "framework_control_id" => "656"
            ]);
            FrameworkControlTest::create([
                "id" => "657",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٥-ش-٤",
                "framework_control_id" => "657"
            ]);
            FrameworkControlTest::create([
                "id" => "658",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٦-م-١",
                "framework_control_id" => "658"
            ]);
            FrameworkControlTest::create([
                "id" => "659",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٦-م-٢",
                "framework_control_id" => "659"
            ]);
            FrameworkControlTest::create([
                "id" => "660",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٦-م-٣",
                "framework_control_id" => "660"
            ]);
            FrameworkControlTest::create([
                "id" => "661",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٦-م-٣-١",
                "framework_control_id" => "661"
            ]);
            FrameworkControlTest::create([
                "id" => "662",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٦-م-٣-٢",
                "framework_control_id" => "662"
            ]);
            FrameworkControlTest::create([
                "id" => "663",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٦-م-4",
                "framework_control_id" => "663"
            ]);
            FrameworkControlTest::create([
                "id" => "664",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-١",
                "framework_control_id" => "664"
            ]);
            FrameworkControlTest::create([
                "id" => "665",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٢",
                "framework_control_id" => "665"
            ]);
            FrameworkControlTest::create([
                "id" => "666",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣",
                "framework_control_id" => "666"
            ]);
            FrameworkControlTest::create([
                "id" => "667",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣-١",
                "framework_control_id" => "667"
            ]);
            FrameworkControlTest::create([
                "id" => "668",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣-٢",
                "framework_control_id" => "668"
            ]);
            FrameworkControlTest::create([
                "id" => "669",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣-٣",
                "framework_control_id" => "669"
            ]);
            FrameworkControlTest::create([
                "id" => "670",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣-٤",
                "framework_control_id" => "670"
            ]);
            FrameworkControlTest::create([
                "id" => "671",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣-٥",
                "framework_control_id" => "671"
            ]);
            FrameworkControlTest::create([
                "id" => "672",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٣-٦",
                "framework_control_id" => "672"
            ]);
            FrameworkControlTest::create([
                "id" => "673",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٢-١٧-م-٤",
                "framework_control_id" => "673"
            ]);
            FrameworkControlTest::create([
                "id" => "674",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٣-١-م-١",
                "framework_control_id" => "674"
            ]);
            FrameworkControlTest::create([
                "id" => "675",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٣-١-م-١-١",
                "framework_control_id" => "675"
            ]);
            FrameworkControlTest::create([
                "id" => "676",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٣-١-م-١-٢",
                "framework_control_id" => "676"
            ]);
            FrameworkControlTest::create([
                "id" => "677",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٣-١-ش-١",
                "framework_control_id" => "677"
            ]);
            FrameworkControlTest::create([
                "id" => "678",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٣-١-ش-١-١",
                "framework_control_id" => "678"
            ]);
            FrameworkControlTest::create([
                "id" => "679",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٤-١-م-١",
                "framework_control_id" => "679"
            ]);
            FrameworkControlTest::create([
                "id" => "680",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٤-١-م-١-١",
                "framework_control_id" => "680"
            ]);
            FrameworkControlTest::create([
                "id" => "681",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٤-١-م-١-٢",
                "framework_control_id" => "681"
            ]);
            FrameworkControlTest::create([
                "id" => "682",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٤-١-م-١-٣",
                "framework_control_id" => "682"
            ]);
            FrameworkControlTest::create([
                "id" => "683",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CCC ٤-١-م-١-٤",
                "framework_control_id" => "683"
            ]);
        }
        // NCA-TCC
        if (in_array('NCA-TCC', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "275",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-1-1",
                "framework_control_id" => "275"
            ]);
            FrameworkControlTest::create([
                "id" => "276",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-1-1-1",
                "framework_control_id" => "276"
            ]);
            FrameworkControlTest::create([
                "id" => "277",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-2-1",
                "framework_control_id" => "277"
            ]);
            FrameworkControlTest::create([
                "id" => "278",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-2-1-1",
                "framework_control_id" => "278"
            ]);
            FrameworkControlTest::create([
                "id" => "279",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-2-1-2",
                "framework_control_id" => "279"
            ]);
            FrameworkControlTest::create([
                "id" => "280",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-2-1-3",
                "framework_control_id" => "280"
            ]);
            FrameworkControlTest::create([
                "id" => "281",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1",
                "framework_control_id" => "281"
            ]);
            FrameworkControlTest::create([
                "id" => "282",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-1",
                "framework_control_id" => "282"
            ]);
            FrameworkControlTest::create([
                "id" => "283",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-2",
                "framework_control_id" => "283"
            ]);
            FrameworkControlTest::create([
                "id" => "284",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-3",
                "framework_control_id" => "284"
            ]);
            FrameworkControlTest::create([
                "id" => "285",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-4",
                "framework_control_id" => "285"
            ]);
            FrameworkControlTest::create([
                "id" => "286",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-5",
                "framework_control_id" => "286"
            ]);
            FrameworkControlTest::create([
                "id" => "287",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-6",
                "framework_control_id" => "287"
            ]);
            FrameworkControlTest::create([
                "id" => "288",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-7",
                "framework_control_id" => "288"
            ]);
            FrameworkControlTest::create([
                "id" => "289",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-1-8",
                "framework_control_id" => "289"
            ]);
            FrameworkControlTest::create([
                "id" => "290",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 1-3-2",
                "framework_control_id" => "290"
            ]);
            FrameworkControlTest::create([
                "id" => "291",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-1-1",
                "framework_control_id" => "291"
            ]);
            FrameworkControlTest::create([
                "id" => "292",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-1-1-1",
                "framework_control_id" => "292"
            ]);
            FrameworkControlTest::create([
                "id" => "293",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-2-1",
                "framework_control_id" => "293"
            ]);
            FrameworkControlTest::create([
                "id" => "294",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-2-1-1",
                "framework_control_id" => "294"
            ]);
            FrameworkControlTest::create([
                "id" => "295",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-2-1-2",
                "framework_control_id" => "295"
            ]);
            FrameworkControlTest::create([
                "id" => "296",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-2-1-3",
                "framework_control_id" => "296"
            ]);
            FrameworkControlTest::create([
                "id" => "297",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-2-2",
                "framework_control_id" => "297"
            ]);
            FrameworkControlTest::create([
                "id" => "298",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-3-1",
                "framework_control_id" => "298"
            ]);
            FrameworkControlTest::create([
                "id" => "299",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-3-1-1",
                "framework_control_id" => "299"
            ]);
            FrameworkControlTest::create([
                "id" => "300",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-3-1-2",
                "framework_control_id" => "300"
            ]);
            FrameworkControlTest::create([
                "id" => "301",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-3-1-3",
                "framework_control_id" => "301"
            ]);
            FrameworkControlTest::create([
                "id" => "302",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-3-1-4",
                "framework_control_id" => "302"
            ]);
            FrameworkControlTest::create([
                "id" => "303",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-3-1-5",
                "framework_control_id" => "303"
            ]);
            FrameworkControlTest::create([
                "id" => "304",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-4-1",
                "framework_control_id" => "304"
            ]);
            FrameworkControlTest::create([
                "id" => "305",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-4-1-1",
                "framework_control_id" => "305"
            ]);
            FrameworkControlTest::create([
                "id" => "306",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-4-1-2",
                "framework_control_id" => "306"
            ]);
            FrameworkControlTest::create([
                "id" => "307",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-4-1-3",
                "framework_control_id" => "307"
            ]);
            FrameworkControlTest::create([
                "id" => "308",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-4-1-4",
                "framework_control_id" => "308"
            ]);
            FrameworkControlTest::create([
                "id" => "309",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-5-1",
                "framework_control_id" => "309"
            ]);
            FrameworkControlTest::create([
                "id" => "310",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-5-1-1",
                "framework_control_id" => "310"
            ]);
            FrameworkControlTest::create([
                "id" => "311",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-5-1-2",
                "framework_control_id" => "311"
            ]);
            FrameworkControlTest::create([
                "id" => "312",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-6-1",
                "framework_control_id" => "312"
            ]);
            FrameworkControlTest::create([
                "id" => "313",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-6-1-1",
                "framework_control_id" => "313"
            ]);
            FrameworkControlTest::create([
                "id" => "314",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-6-1-2",
                "framework_control_id" => "314"
            ]);
            FrameworkControlTest::create([
                "id" => "315",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-7-1",
                "framework_control_id" => "315"
            ]);
            FrameworkControlTest::create([
                "id" => "316",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-7-1-1",
                "framework_control_id" => "316"
            ]);
            FrameworkControlTest::create([
                "id" => "317",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-8-1",
                "framework_control_id" => "317"
            ]);
            FrameworkControlTest::create([
                "id" => "318",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-8-1-1",
                "framework_control_id" => "318"
            ]);
            FrameworkControlTest::create([
                "id" => "319",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-8-2",
                "framework_control_id" => "319"
            ]);
            FrameworkControlTest::create([
                "id" => "320",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-9-1",
                "framework_control_id" => "320"
            ]);
            FrameworkControlTest::create([
                "id" => "321",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-9-1-1",
                "framework_control_id" => "321"
            ]);
            FrameworkControlTest::create([
                "id" => "322",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-9-1-2",
                "framework_control_id" => "322"
            ]);
            FrameworkControlTest::create([
                "id" => "323",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-10-1",
                "framework_control_id" => "323"
            ]);
            FrameworkControlTest::create([
                "id" => "324",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-10-1-1",
                "framework_control_id" => "324"
            ]);
            FrameworkControlTest::create([
                "id" => "325",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-10-2",
                "framework_control_id" => "325"
            ]);
            FrameworkControlTest::create([
                "id" => "326",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-11-1",
                "framework_control_id" => "326"
            ]);
            FrameworkControlTest::create([
                "id" => "327",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-11-1-1",
                "framework_control_id" => "327"
            ]);
            FrameworkControlTest::create([
                "id" => "328",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-11-1-2",
                "framework_control_id" => "328"
            ]);
            FrameworkControlTest::create([
                "id" => "329",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-11-1-3",
                "framework_control_id" => "329"
            ]);
            FrameworkControlTest::create([
                "id" => "330",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-11-1-4",
                "framework_control_id" => "330"
            ]);
            FrameworkControlTest::create([
                "id" => "331",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-11-2",
                "framework_control_id" => "331"
            ]);
            FrameworkControlTest::create([
                "id" => "332",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-12-1",
                "framework_control_id" => "332"
            ]);
            FrameworkControlTest::create([
                "id" => "333",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-12-1-1",
                "framework_control_id" => "333"
            ]);
            FrameworkControlTest::create([
                "id" => "334",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-12-1-2",
                "framework_control_id" => "334"
            ]);
            FrameworkControlTest::create([
                "id" => "335",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 2-12-1-3",
                "framework_control_id" => "335"
            ]);
            FrameworkControlTest::create([
                "id" => "336",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 3-1-1",
                "framework_control_id" => "336"
            ]);
            FrameworkControlTest::create([
                "id" => "337",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "TCC 3-1-1-1",
                "framework_control_id" => "337"
            ]);
        }
        // NCA-CSCC – 1: 2019
        if (in_array('NCA-CSCC – 1: 2019', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "750",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-1-1",
                "framework_control_id" => "750"
            ]);
            FrameworkControlTest::create([
                "id" => "751",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-2-1",
                "framework_control_id" => "751"
            ]);
            FrameworkControlTest::create([
                "id" => "752",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-2-1-1",
                "framework_control_id" => "752"
            ]);
            FrameworkControlTest::create([
                "id" => "753",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-2-1-2",
                "framework_control_id" => "753"
            ]);
            FrameworkControlTest::create([
                "id" => "754",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-1",
                "framework_control_id" => "754"
            ]);
            FrameworkControlTest::create([
                "id" => "755",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-1-1",
                "framework_control_id" => "755"
            ]);
            FrameworkControlTest::create([
                "id" => "756",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-1-2",
                "framework_control_id" => "756"
            ]);
            FrameworkControlTest::create([
                "id" => "757",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-2",
                "framework_control_id" => "757"
            ]);
            FrameworkControlTest::create([
                "id" => "758",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-2-1",
                "framework_control_id" => "758"
            ]);
            FrameworkControlTest::create([
                "id" => "759",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-2-2",
                "framework_control_id" => "759"
            ]);
            FrameworkControlTest::create([
                "id" => "760",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-2-3",
                "framework_control_id" => "760"
            ]);
            FrameworkControlTest::create([
                "id" => "761",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-3-2-4",
                "framework_control_id" => "761"
            ]);
            FrameworkControlTest::create([
                "id" => "762",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-4-1",
                "framework_control_id" => "762"
            ]);
            FrameworkControlTest::create([
                "id" => "763",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-4-2",
                "framework_control_id" => "763"
            ]);
            FrameworkControlTest::create([
                "id" => "764",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-5-1",
                "framework_control_id" => "764"
            ]);
            FrameworkControlTest::create([
                "id" => "765",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-5-1-1",
                "framework_control_id" => "765"
            ]);
            FrameworkControlTest::create([
                "id" => "766",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 1-5-1-2",
                "framework_control_id" => "766"
            ]);
            FrameworkControlTest::create([
                "id" => "767",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-1-1",
                "framework_control_id" => "767"
            ]);
            FrameworkControlTest::create([
                "id" => "768",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-1-1-1",
                "framework_control_id" => "768"
            ]);
            FrameworkControlTest::create([
                "id" => "769",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-1-1-2",
                "framework_control_id" => "769"
            ]);
            FrameworkControlTest::create([
                "id" => "770",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1",
                "framework_control_id" => "770"
            ]);
            FrameworkControlTest::create([
                "id" => "771",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-1",
                "framework_control_id" => "771"
            ]);
            FrameworkControlTest::create([
                "id" => "772",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-2",
                "framework_control_id" => "772"
            ]);
            FrameworkControlTest::create([
                "id" => "773",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-3",
                "framework_control_id" => "773"
            ]);
            FrameworkControlTest::create([
                "id" => "774",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-4",
                "framework_control_id" => "774"
            ]);
            FrameworkControlTest::create([
                "id" => "775",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-5",
                "framework_control_id" => "775"
            ]);
            FrameworkControlTest::create([
                "id" => "776",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-6",
                "framework_control_id" => "776"
            ]);
            FrameworkControlTest::create([
                "id" => "777",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-7",
                "framework_control_id" => "777"
            ]);
            FrameworkControlTest::create([
                "id" => "778",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-1-8",
                "framework_control_id" => "778"
            ]);
            FrameworkControlTest::create([
                "id" => "779",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-2-2",
                "framework_control_id" => "779"
            ]);
            FrameworkControlTest::create([
                "id" => "780",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1",
                "framework_control_id" => "780"
            ]);
            FrameworkControlTest::create([
                "id" => "781",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-1",
                "framework_control_id" => "781"
            ]);
            FrameworkControlTest::create([
                "id" => "782",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-2",
                "framework_control_id" => "782"
            ]);
            FrameworkControlTest::create([
                "id" => "783",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-3",
                "framework_control_id" => "783"
            ]);
            FrameworkControlTest::create([
                "id" => "784",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-4",
                "framework_control_id" => "784"
            ]);
            FrameworkControlTest::create([
                "id" => "785",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-5",
                "framework_control_id" => "785"
            ]);
            FrameworkControlTest::create([
                "id" => "786",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-6",
                "framework_control_id" => "786"
            ]);
            FrameworkControlTest::create([
                "id" => "787",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-7",
                "framework_control_id" => "787"
            ]);
            FrameworkControlTest::create([
                "id" => "788",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-3-1-8",
                "framework_control_id" => "788"
            ]);
            FrameworkControlTest::create([
                "id" => "789",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1",
                "framework_control_id" => "789"
            ]);
            FrameworkControlTest::create([
                "id" => "790",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-1",
                "framework_control_id" => "790"
            ]);
            FrameworkControlTest::create([
                "id" => "791",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-2",
                "framework_control_id" => "791"
            ]);
            FrameworkControlTest::create([
                "id" => "792",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-3",
                "framework_control_id" => "792"
            ]);
            FrameworkControlTest::create([
                "id" => "793",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-4",
                "framework_control_id" => "793"
            ]);
            FrameworkControlTest::create([
                "id" => "794",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-5",
                "framework_control_id" => "794"
            ]);
            FrameworkControlTest::create([
                "id" => "795",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-6",
                "framework_control_id" => "795"
            ]);
            FrameworkControlTest::create([
                "id" => "796",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-7",
                "framework_control_id" => "796"
            ]);
            FrameworkControlTest::create([
                "id" => "797",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-8",
                "framework_control_id" => "797"
            ]);
            FrameworkControlTest::create([
                "id" => "798",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-4-1-9",
                "framework_control_id" => "798"
            ]);
            FrameworkControlTest::create([
                "id" => "799",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-5-1",
                "framework_control_id" => "799"
            ]);
            FrameworkControlTest::create([
                "id" => "800",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-5-1-1",
                "framework_control_id" => "800"
            ]);
            FrameworkControlTest::create([
                "id" => "801",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-5-1-2",
                "framework_control_id" => "801"
            ]);
            FrameworkControlTest::create([
                "id" => "802",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-6-1",
                "framework_control_id" => "802"
            ]);
            FrameworkControlTest::create([
                "id" => "803",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-6-1-1",
                "framework_control_id" => "803"
            ]);
            FrameworkControlTest::create([
                "id" => "804",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-6-1-2",
                "framework_control_id" => "804"
            ]);
            FrameworkControlTest::create([
                "id" => "805",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-6-1-3",
                "framework_control_id" => "805"
            ]);
            FrameworkControlTest::create([
                "id" => "806",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-6-1-4",
                "framework_control_id" => "806"
            ]);
            FrameworkControlTest::create([
                "id" => "807",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-6-1-5",
                "framework_control_id" => "807"
            ]);
            FrameworkControlTest::create([
                "id" => "808",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-7-1",
                "framework_control_id" => "808"
            ]);
            FrameworkControlTest::create([
                "id" => "809",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-7-1-1",
                "framework_control_id" => "809"
            ]);
            FrameworkControlTest::create([
                "id" => "810",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-7-1-2",
                "framework_control_id" => "810"
            ]);
            FrameworkControlTest::create([
                "id" => "811",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-7-1-3",
                "framework_control_id" => "811"
            ]);
            FrameworkControlTest::create([
                "id" => "812",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-8-1",
                "framework_control_id" => "812"
            ]);
            FrameworkControlTest::create([
                "id" => "813",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-8-1-1",
                "framework_control_id" => "813"
            ]);
            FrameworkControlTest::create([
                "id" => "814",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-8-1-2",
                "framework_control_id" => "814"
            ]);
            FrameworkControlTest::create([
                "id" => "815",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-8-1-3",
                "framework_control_id" => "815"
            ]);
            FrameworkControlTest::create([
                "id" => "816",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-8-2",
                "framework_control_id" => "816"
            ]);
            FrameworkControlTest::create([
                "id" => "817",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-9-1",
                "framework_control_id" => "817"
            ]);
            FrameworkControlTest::create([
                "id" => "818",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-9-1-1",
                "framework_control_id" => "818"
            ]);
            FrameworkControlTest::create([
                "id" => "819",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-9-1-2",
                "framework_control_id" => "819"
            ]);
            FrameworkControlTest::create([
                "id" => "820",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-9-1-3",
                "framework_control_id" => "820"
            ]);
            FrameworkControlTest::create([
                "id" => "821",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-9-2",
                "framework_control_id" => "821"
            ]);
            FrameworkControlTest::create([
                "id" => "822",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-10-1",
                "framework_control_id" => "822"
            ]);
            FrameworkControlTest::create([
                "id" => "823",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-10-1-1",
                "framework_control_id" => "823"
            ]);
            FrameworkControlTest::create([
                "id" => "824",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-10-1-2",
                "framework_control_id" => "824"
            ]);
            FrameworkControlTest::create([
                "id" => "825",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-10-2",
                "framework_control_id" => "825"
            ]);
            FrameworkControlTest::create([
                "id" => "826",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-1",
                "framework_control_id" => "826"
            ]);
            FrameworkControlTest::create([
                "id" => "827",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-1-1",
                "framework_control_id" => "827"
            ]);
            FrameworkControlTest::create([
                "id" => "828",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-1-2",
                "framework_control_id" => "828"
            ]);
            FrameworkControlTest::create([
                "id" => "829",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-1-3",
                "framework_control_id" => "829"
            ]);
            FrameworkControlTest::create([
                "id" => "830",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-1-4",
                "framework_control_id" => "830"
            ]);
            FrameworkControlTest::create([
                "id" => "831",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-1-5",
                "framework_control_id" => "831"
            ]);
            FrameworkControlTest::create([
                "id" => "832",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-11-2",
                "framework_control_id" => "832"
            ]);
            FrameworkControlTest::create([
                "id" => "833",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-12-1",
                "framework_control_id" => "833"
            ]);
            FrameworkControlTest::create([
                "id" => "834",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-12-1-1",
                "framework_control_id" => "834"
            ]);
            FrameworkControlTest::create([
                "id" => "835",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-12-1-2",
                "framework_control_id" => "835"
            ]);
            FrameworkControlTest::create([
                "id" => "836",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-12-2",
                "framework_control_id" => "836"
            ]);
            FrameworkControlTest::create([
                "id" => "837",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-1",
                "framework_control_id" => "837"
            ]);
            FrameworkControlTest::create([
                "id" => "838",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-2",
                "framework_control_id" => "838"
            ]);
            FrameworkControlTest::create([
                "id" => "839",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-3",
                "framework_control_id" => "839"
            ]);
            FrameworkControlTest::create([
                "id" => "840",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-3-1",
                "framework_control_id" => "840"
            ]);
            FrameworkControlTest::create([
                "id" => "841",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-3-2",
                "framework_control_id" => "841"
            ]);
            FrameworkControlTest::create([
                "id" => "842",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-3-3",
                "framework_control_id" => "842"
            ]);
            FrameworkControlTest::create([
                "id" => "843",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-3-4",
                "framework_control_id" => "843"
            ]);
            FrameworkControlTest::create([
                "id" => "844",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 2-13-4",
                "framework_control_id" => "844"
            ]);
            FrameworkControlTest::create([
                "id" => "845",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 3-1-1",
                "framework_control_id" => "845"
            ]);
            FrameworkControlTest::create([
                "id" => "846",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 3-1-1-1",
                "framework_control_id" => "846"
            ]);
            FrameworkControlTest::create([
                "id" => "847",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 3-1-1-2",
                "framework_control_id" => "847"
            ]);
            FrameworkControlTest::create([
                "id" => "848",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 3-1-1-3",
                "framework_control_id" => "848"
            ]);
            FrameworkControlTest::create([
                "id" => "849",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 3-1-1-4",
                "framework_control_id" => "849"
            ]);
            FrameworkControlTest::create([
                "id" => "850",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 4-1-1",
                "framework_control_id" => "850"
            ]);
            FrameworkControlTest::create([
                "id" => "851",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 4-1-1-1",
                "framework_control_id" => "851"
            ]);
            FrameworkControlTest::create([
                "id" => "852",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 4-1-1-2",
                "framework_control_id" => "852"
            ]);
            FrameworkControlTest::create([
                "id" => "853",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 4-2-1",
                "framework_control_id" => "853"
            ]);
            FrameworkControlTest::create([
                "id" => "854",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "CSCC 4-2-1-1",
                "framework_control_id" => "854"
            ]);
        }
        // NCA-OTCC-1:2022
        if (in_array('NCA-OTCC-1:2022', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "338",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-1-1",
                "framework_control_id" => "338"
            ]);
            FrameworkControlTest::create([
                "id" => "339",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-1-2",
                "framework_control_id" => "339"
            ]);
            FrameworkControlTest::create([
                "id" => "340",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-1-3",
                "framework_control_id" => "340"
            ]);
            FrameworkControlTest::create([
                "id" => "341",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-2-1",
                "framework_control_id" => "341"
            ]);
            FrameworkControlTest::create([
                "id" => "342",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-2-1-1",
                "framework_control_id" => "342"
            ]);
            FrameworkControlTest::create([
                "id" => "343",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-2-1-2",
                "framework_control_id" => "343"
            ]);
            FrameworkControlTest::create([
                "id" => "344",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1",
                "framework_control_id" => "344"
            ]);
            FrameworkControlTest::create([
                "id" => "345",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-1",
                "framework_control_id" => "345"
            ]);
            FrameworkControlTest::create([
                "id" => "346",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-2",
                "framework_control_id" => "346"
            ]);
            FrameworkControlTest::create([
                "id" => "347",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-3",
                "framework_control_id" => "347"
            ]);
            FrameworkControlTest::create([
                "id" => "348",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-4",
                "framework_control_id" => "348"
            ]);
            FrameworkControlTest::create([
                "id" => "349",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-5",
                "framework_control_id" => "349"
            ]);
            FrameworkControlTest::create([
                "id" => "350",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-6",
                "framework_control_id" => "350"
            ]);
            FrameworkControlTest::create([
                "id" => "351",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-3-1-7",
                "framework_control_id" => "351"
            ]);
            FrameworkControlTest::create([
                "id" => "352",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-4-1",
                "framework_control_id" => "352"
            ]);
            FrameworkControlTest::create([
                "id" => "353",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-4-1-1",
                "framework_control_id" => "353"
            ]);
            FrameworkControlTest::create([
                "id" => "354",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-4-1-2",
                "framework_control_id" => "354"
            ]);
            FrameworkControlTest::create([
                "id" => "355",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-4-1-3",
                "framework_control_id" => "355"
            ]);
            FrameworkControlTest::create([
                "id" => "356",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-4-1-4",
                "framework_control_id" => "356"
            ]);
            FrameworkControlTest::create([
                "id" => "357",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-4-2",
                "framework_control_id" => "357"
            ]);
            FrameworkControlTest::create([
                "id" => "358",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-1",
                "framework_control_id" => "358"
            ]);
            FrameworkControlTest::create([
                "id" => "359",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-2",
                "framework_control_id" => "359"
            ]);
            FrameworkControlTest::create([
                "id" => "360",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-3",
                "framework_control_id" => "360"
            ]);
            FrameworkControlTest::create([
                "id" => "361",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-3-1",
                "framework_control_id" => "361"
            ]);
            FrameworkControlTest::create([
                "id" => "362",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-3-2",
                "framework_control_id" => "362"
            ]);
            FrameworkControlTest::create([
                "id" => "363",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-3-3",
                "framework_control_id" => "363"
            ]);
            FrameworkControlTest::create([
                "id" => "364",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-3-4",
                "framework_control_id" => "364"
            ]);
            FrameworkControlTest::create([
                "id" => "365",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-3-5",
                "framework_control_id" => "365"
            ]);
            FrameworkControlTest::create([
                "id" => "366",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-5-4",
                "framework_control_id" => "366"
            ]);
            FrameworkControlTest::create([
                "id" => "367",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-6-1",
                "framework_control_id" => "367"
            ]);
            FrameworkControlTest::create([
                "id" => "368",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-6-2",
                "framework_control_id" => "368"
            ]);
            FrameworkControlTest::create([
                "id" => "369",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-7-1",
                "framework_control_id" => "369"
            ]);
            FrameworkControlTest::create([
                "id" => "370",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-7-2",
                "framework_control_id" => "370"
            ]);
            FrameworkControlTest::create([
                "id" => "371",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-8-1",
                "framework_control_id" => "371"
            ]);
            FrameworkControlTest::create([
                "id" => "372",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-8-2",
                "framework_control_id" => "372"
            ]);
            FrameworkControlTest::create([
                "id" => "373",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-8-2-1",
                "framework_control_id" => "373"
            ]);
            FrameworkControlTest::create([
                "id" => "374",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 1-8-2-2",
                "framework_control_id" => "374"
            ]);
            FrameworkControlTest::create([
                "id" => "375",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-1",
                "framework_control_id" => "375"
            ]);
            FrameworkControlTest::create([
                "id" => "376",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-1-1",
                "framework_control_id" => "376"
            ]);
            FrameworkControlTest::create([
                "id" => "377",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-1-2",
                "framework_control_id" => "377"
            ]);
            FrameworkControlTest::create([
                "id" => "378",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-1-3",
                "framework_control_id" => "378"
            ]);
            FrameworkControlTest::create([
                "id" => "379",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-1-4",
                "framework_control_id" => "379"
            ]);
            FrameworkControlTest::create([
                "id" => "380",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-1-5",
                "framework_control_id" => "380"
            ]);
            FrameworkControlTest::create([
                "id" => "381",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-1-2",
                "framework_control_id" => "381"
            ]);
            FrameworkControlTest::create([
                "id" => "382",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTTC 2-2-1",
                "framework_control_id" => "382"
            ]);
            FrameworkControlTest::create([
                "id" => "383",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-1",
                "framework_control_id" => "383"
            ]);
            FrameworkControlTest::create([
                "id" => "384",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-2",
                "framework_control_id" => "384"
            ]);
            FrameworkControlTest::create([
                "id" => "385",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-3",
                "framework_control_id" => "385"
            ]);
            FrameworkControlTest::create([
                "id" => "386",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-4",
                "framework_control_id" => "386"
            ]);
            FrameworkControlTest::create([
                "id" => "387",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-5",
                "framework_control_id" => "387"
            ]);
            FrameworkControlTest::create([
                "id" => "388",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-6",
                "framework_control_id" => "388"
            ]);
            FrameworkControlTest::create([
                "id" => "389",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-7",
                "framework_control_id" => "389"
            ]);
            FrameworkControlTest::create([
                "id" => "390",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-8",
                "framework_control_id" => "390"
            ]);
            FrameworkControlTest::create([
                "id" => "391",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-9",
                "framework_control_id" => "391"
            ]);
            FrameworkControlTest::create([
                "id" => "392",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-10",
                "framework_control_id" => "392"
            ]);
            FrameworkControlTest::create([
                "id" => "393",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-1-11",
                "framework_control_id" => "393"
            ]);
            FrameworkControlTest::create([
                "id" => "394",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-2-2",
                "framework_control_id" => "394"
            ]);
            FrameworkControlTest::create([
                "id" => "395",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1",
                "framework_control_id" => "395"
            ]);
            FrameworkControlTest::create([
                "id" => "396",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-1",
                "framework_control_id" => "396"
            ]);
            FrameworkControlTest::create([
                "id" => "397",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-2",
                "framework_control_id" => "397"
            ]);
            FrameworkControlTest::create([
                "id" => "398",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-3",
                "framework_control_id" => "398"
            ]);
            FrameworkControlTest::create([
                "id" => "399",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-4",
                "framework_control_id" => "399"
            ]);
            FrameworkControlTest::create([
                "id" => "400",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-5",
                "framework_control_id" => "400"
            ]);
            FrameworkControlTest::create([
                "id" => "401",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-6",
                "framework_control_id" => "401"
            ]);
            FrameworkControlTest::create([
                "id" => "402",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-7",
                "framework_control_id" => "402"
            ]);
            FrameworkControlTest::create([
                "id" => "403",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-8",
                "framework_control_id" => "403"
            ]);
            FrameworkControlTest::create([
                "id" => "404",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-9",
                "framework_control_id" => "404"
            ]);
            FrameworkControlTest::create([
                "id" => "405",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-10",
                "framework_control_id" => "405"
            ]);
            FrameworkControlTest::create([
                "id" => "406",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-11",
                "framework_control_id" => "406"
            ]);
            FrameworkControlTest::create([
                "id" => "407",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-12",
                "framework_control_id" => "407"
            ]);
            FrameworkControlTest::create([
                "id" => "408",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-1-13",
                "framework_control_id" => "408"
            ]);
            FrameworkControlTest::create([
                "id" => "409",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-3-2",
                "framework_control_id" => "409"
            ]);
            FrameworkControlTest::create([
                "id" => "410",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1",
                "framework_control_id" => "410"
            ]);
            FrameworkControlTest::create([
                "id" => "411",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-1",
                "framework_control_id" => "411"
            ]);
            FrameworkControlTest::create([
                "id" => "412",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-2",
                "framework_control_id" => "412"
            ]);
            FrameworkControlTest::create([
                "id" => "413",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-3",
                "framework_control_id" => "413"
            ]);
            FrameworkControlTest::create([
                "id" => "414",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-4",
                "framework_control_id" => "414"
            ]);
            FrameworkControlTest::create([
                "id" => "415",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-5",
                "framework_control_id" => "415"
            ]);
            FrameworkControlTest::create([
                "id" => "416",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-6",
                "framework_control_id" => "416"
            ]);
            FrameworkControlTest::create([
                "id" => "417",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-7",
                "framework_control_id" => "417"
            ]);
            FrameworkControlTest::create([
                "id" => "418",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-8",
                "framework_control_id" => "418"
            ]);
            FrameworkControlTest::create([
                "id" => "419",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-9",
                "framework_control_id" => "419"
            ]);
            FrameworkControlTest::create([
                "id" => "420",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-10",
                "framework_control_id" => "420"
            ]);
            FrameworkControlTest::create([
                "id" => "421",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-11",
                "framework_control_id" => "421"
            ]);
            FrameworkControlTest::create([
                "id" => "422",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-12",
                "framework_control_id" => "422"
            ]);
            FrameworkControlTest::create([
                "id" => "423",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-13",
                "framework_control_id" => "423"
            ]);
            FrameworkControlTest::create([
                "id" => "424",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-14",
                "framework_control_id" => "424"
            ]);
            FrameworkControlTest::create([
                "id" => "425",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-15",
                "framework_control_id" => "425"
            ]);
            FrameworkControlTest::create([
                "id" => "426",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-1-16",
                "framework_control_id" => "426"
            ]);
            FrameworkControlTest::create([
                "id" => "427",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-4-2",
                "framework_control_id" => "427"
            ]);
            FrameworkControlTest::create([
                "id" => "428",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-1",
                "framework_control_id" => "428"
            ]);
            FrameworkControlTest::create([
                "id" => "429",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-1-1",
                "framework_control_id" => "429"
            ]);
            FrameworkControlTest::create([
                "id" => "430",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-1-2",
                "framework_control_id" => "430"
            ]);
            FrameworkControlTest::create([
                "id" => "431",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-1-3",
                "framework_control_id" => "431"
            ]);
            FrameworkControlTest::create([
                "id" => "432",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-1-4",
                "framework_control_id" => "432"
            ]);
            FrameworkControlTest::create([
                "id" => "433",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-1-5",
                "framework_control_id" => "433"
            ]);
            FrameworkControlTest::create([
                "id" => "434",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-5-2",
                "framework_control_id" => "434"
            ]);
            FrameworkControlTest::create([
                "id" => "435",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-6-1",
                "framework_control_id" => "435"
            ]);
            FrameworkControlTest::create([
                "id" => "436",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-6-1-1",
                "framework_control_id" => "436"
            ]);
            FrameworkControlTest::create([
                "id" => "437",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-6-1-2",
                "framework_control_id" => "437"
            ]);
            FrameworkControlTest::create([
                "id" => "438",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-6-1-3",
                "framework_control_id" => "438"
            ]);
            FrameworkControlTest::create([
                "id" => "439",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-6-1-4",
                "framework_control_id" => "439"
            ]);
            FrameworkControlTest::create([
                "id" => "440",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-6-2",
                "framework_control_id" => "440"
            ]);
            FrameworkControlTest::create([
                "id" => "441",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-7-1",
                "framework_control_id" => "441"
            ]);
            FrameworkControlTest::create([
                "id" => "442",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-7-2",
                "framework_control_id" => "442"
            ]);
            FrameworkControlTest::create([
                "id" => "443",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-8-1",
                "framework_control_id" => "443"
            ]);
            FrameworkControlTest::create([
                "id" => "444",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-8-1-1",
                "framework_control_id" => "444"
            ]);
            FrameworkControlTest::create([
                "id" => "445",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-8-1-2",
                "framework_control_id" => "445"
            ]);
            FrameworkControlTest::create([
                "id" => "446",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-8-1-3",
                "framework_control_id" => "446"
            ]);
            FrameworkControlTest::create([
                "id" => "447",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-8-1-4",
                "framework_control_id" => "447"
            ]);
            FrameworkControlTest::create([
                "id" => "448",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-8-2",
                "framework_control_id" => "448"
            ]);
            FrameworkControlTest::create([
                "id" => "449",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-9-1",
                "framework_control_id" => "449"
            ]);
            FrameworkControlTest::create([
                "id" => "450",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-9-1-1",
                "framework_control_id" => "450"
            ]);
            FrameworkControlTest::create([
                "id" => "451",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-9-1-2",
                "framework_control_id" => "451"
            ]);
            FrameworkControlTest::create([
                "id" => "452",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-9-1-3",
                "framework_control_id" => "452"
            ]);
            FrameworkControlTest::create([
                "id" => "453",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-9-2",
                "framework_control_id" => "453"
            ]);
            FrameworkControlTest::create([
                "id" => "454",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-10-1",
                "framework_control_id" => "454"
            ]);
            FrameworkControlTest::create([
                "id" => "455",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-10-1-1",
                "framework_control_id" => "455"
            ]);
            FrameworkControlTest::create([
                "id" => "456",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-10-1-2",
                "framework_control_id" => "456"
            ]);
            FrameworkControlTest::create([
                "id" => "457",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-10-1-3",
                "framework_control_id" => "457"
            ]);
            FrameworkControlTest::create([
                "id" => "458",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-10-1-4",
                "framework_control_id" => "458"
            ]);
            FrameworkControlTest::create([
                "id" => "459",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-10-2",
                "framework_control_id" => "459"
            ]);
            FrameworkControlTest::create([
                "id" => "460",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1",
                "framework_control_id" => "460"
            ]);
            FrameworkControlTest::create([
                "id" => "461",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-1",
                "framework_control_id" => "461"
            ]);
            FrameworkControlTest::create([
                "id" => "462",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-2",
                "framework_control_id" => "462"
            ]);
            FrameworkControlTest::create([
                "id" => "463",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-3",
                "framework_control_id" => "463"
            ]);
            FrameworkControlTest::create([
                "id" => "464",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-4",
                "framework_control_id" => "464"
            ]);
            FrameworkControlTest::create([
                "id" => "465",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-5",
                "framework_control_id" => "465"
            ]);
            FrameworkControlTest::create([
                "id" => "466",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-6",
                "framework_control_id" => "466"
            ]);
            FrameworkControlTest::create([
                "id" => "467",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-7",
                "framework_control_id" => "467"
            ]);
            FrameworkControlTest::create([
                "id" => "468",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-8",
                "framework_control_id" => "468"
            ]);
            FrameworkControlTest::create([
                "id" => "469",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-9",
                "framework_control_id" => "469"
            ]);
            FrameworkControlTest::create([
                "id" => "470",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-1-10",
                "framework_control_id" => "470"
            ]);
            FrameworkControlTest::create([
                "id" => "471",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-11-2",
                "framework_control_id" => "471"
            ]);
            FrameworkControlTest::create([
                "id" => "472",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1",
                "framework_control_id" => "472"
            ]);
            FrameworkControlTest::create([
                "id" => "473",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-1",
                "framework_control_id" => "473"
            ]);
            FrameworkControlTest::create([
                "id" => "474",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-2",
                "framework_control_id" => "474"
            ]);
            FrameworkControlTest::create([
                "id" => "475",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-3",
                "framework_control_id" => "475"
            ]);
            FrameworkControlTest::create([
                "id" => "476",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-4",
                "framework_control_id" => "476"
            ]);
            FrameworkControlTest::create([
                "id" => "477",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-5",
                "framework_control_id" => "477"
            ]);
            FrameworkControlTest::create([
                "id" => "478",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-6",
                "framework_control_id" => "478"
            ]);
            FrameworkControlTest::create([
                "id" => "479",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-7",
                "framework_control_id" => "479"
            ]);
            FrameworkControlTest::create([
                "id" => "480",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-1-8",
                "framework_control_id" => "480"
            ]);
            FrameworkControlTest::create([
                "id" => "481",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-12-2",
                "framework_control_id" => "481"
            ]);
            FrameworkControlTest::create([
                "id" => "482",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1",
                "framework_control_id" => "482"
            ]);
            FrameworkControlTest::create([
                "id" => "483",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-1",
                "framework_control_id" => "483"
            ]);
            FrameworkControlTest::create([
                "id" => "484",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-2",
                "framework_control_id" => "484"
            ]);
            FrameworkControlTest::create([
                "id" => "485",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-3",
                "framework_control_id" => "485"
            ]);
            FrameworkControlTest::create([
                "id" => "486",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-4",
                "framework_control_id" => "486"
            ]);
            FrameworkControlTest::create([
                "id" => "487",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-5",
                "framework_control_id" => "487"
            ]);
            FrameworkControlTest::create([
                "id" => "488",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-6",
                "framework_control_id" => "488"
            ]);
            FrameworkControlTest::create([
                "id" => "489",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-7",
                "framework_control_id" => "489"
            ]);
            FrameworkControlTest::create([
                "id" => "490",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-8",
                "framework_control_id" => "490"
            ]);
            FrameworkControlTest::create([
                "id" => "491",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-1-9",
                "framework_control_id" => "491"
            ]);
            FrameworkControlTest::create([
                "id" => "492",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 2-13-2",
                "framework_control_id" => "492"
            ]);
            FrameworkControlTest::create([
                "id" => "493",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1",
                "framework_control_id" => "493"
            ]);
            FrameworkControlTest::create([
                "id" => "494",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1-1",
                "framework_control_id" => "494"
            ]);
            FrameworkControlTest::create([
                "id" => "495",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1-2",
                "framework_control_id" => "495"
            ]);
            FrameworkControlTest::create([
                "id" => "496",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1-3",
                "framework_control_id" => "496"
            ]);
            FrameworkControlTest::create([
                "id" => "497",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1-4",
                "framework_control_id" => "497"
            ]);
            FrameworkControlTest::create([
                "id" => "498",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1-5",
                "framework_control_id" => "498"
            ]);
            FrameworkControlTest::create([
                "id" => "499",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-1-6",
                "framework_control_id" => "499"
            ]);
            FrameworkControlTest::create([
                "id" => "500",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 3-1-2",
                "framework_control_id" => "500"
            ]);
            FrameworkControlTest::create([
                "id" => "501",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 4-1-1",
                "framework_control_id" => "501"
            ]);
            FrameworkControlTest::create([
                "id" => "502",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 4-1-1-1",
                "framework_control_id" => "502"
            ]);
            FrameworkControlTest::create([
                "id" => "503",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 4-1-1-2",
                "framework_control_id" => "503"
            ]);
            FrameworkControlTest::create([
                "id" => "504",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 4-1-1-3",
                "framework_control_id" => "504"
            ]);
            FrameworkControlTest::create([
                "id" => "505",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 4-1-1-4",
                "framework_control_id" => "505"
            ]);
            FrameworkControlTest::create([
                "id" => "506",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "OTCC 4-1-2",
                "framework_control_id" => "506"
            ]);
        }
        // NCA-DCC-1:2022
        if (in_array('NCA-DCC-1:2022', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "684",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-1-1",
                "framework_control_id" => "684"
            ]);
            FrameworkControlTest::create([
                "id" => "685",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-1-2",
                "framework_control_id" => "685"
            ]);
            FrameworkControlTest::create([
                "id" => "686",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-2-1",
                "framework_control_id" => "686"
            ]);
            FrameworkControlTest::create([
                "id" => "687",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-2-1-1",
                "framework_control_id" => "687"
            ]);
            FrameworkControlTest::create([
                "id" => "688",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-2-1-2",
                "framework_control_id" => "688"
            ]);
            FrameworkControlTest::create([
                "id" => "689",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1",
                "framework_control_id" => "689"
            ]);
            FrameworkControlTest::create([
                "id" => "690",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-1",
                "framework_control_id" => "690"
            ]);
            FrameworkControlTest::create([
                "id" => "691",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-2",
                "framework_control_id" => "691"
            ]);
            FrameworkControlTest::create([
                "id" => "692",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-3",
                "framework_control_id" => "692"
            ]);
            FrameworkControlTest::create([
                "id" => "693",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-4",
                "framework_control_id" => "693"
            ]);
            FrameworkControlTest::create([
                "id" => "694",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-5",
                "framework_control_id" => "694"
            ]);
            FrameworkControlTest::create([
                "id" => "695",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-6",
                "framework_control_id" => "695"
            ]);
            FrameworkControlTest::create([
                "id" => "696",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 1-3-1-7",
                "framework_control_id" => "696"
            ]);
            FrameworkControlTest::create([
                "id" => "697",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-1-1",
                "framework_control_id" => "697"
            ]);
            FrameworkControlTest::create([
                "id" => "698",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-1-1-1",
                "framework_control_id" => "698"
            ]);
            FrameworkControlTest::create([
                "id" => "699",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-1-1-2",
                "framework_control_id" => "699"
            ]);
            FrameworkControlTest::create([
                "id" => "700",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-1-2",
                "framework_control_id" => "700"
            ]);
            FrameworkControlTest::create([
                "id" => "701",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-1-3",
                "framework_control_id" => "701"
            ]);
            FrameworkControlTest::create([
                "id" => "702",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-2-1",
                "framework_control_id" => "702"
            ]);
            FrameworkControlTest::create([
                "id" => "703",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-2-1-1",
                "framework_control_id" => "703"
            ]);
            FrameworkControlTest::create([
                "id" => "704",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-2-1-2",
                "framework_control_id" => "704"
            ]);
            FrameworkControlTest::create([
                "id" => "705",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-2-1-3",
                "framework_control_id" => "705"
            ]);
            FrameworkControlTest::create([
                "id" => "706",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-2-1-4",
                "framework_control_id" => "706"
            ]);
            FrameworkControlTest::create([
                "id" => "707",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-3-1",
                "framework_control_id" => "707"
            ]);
            FrameworkControlTest::create([
                "id" => "708",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-3-1-1",
                "framework_control_id" => "708"
            ]);
            FrameworkControlTest::create([
                "id" => "709",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-3-1-2",
                "framework_control_id" => "709"
            ]);
            FrameworkControlTest::create([
                "id" => "710",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-4-1",
                "framework_control_id" => "710"
            ]);
            FrameworkControlTest::create([
                "id" => "711",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-4-1-1",
                "framework_control_id" => "711"
            ]);
            FrameworkControlTest::create([
                "id" => "712",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-4-1-2",
                "framework_control_id" => "712"
            ]);
            FrameworkControlTest::create([
                "id" => "713",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-4-1-3",
                "framework_control_id" => "713"
            ]);
            FrameworkControlTest::create([
                "id" => "714",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-4-1-4",
                "framework_control_id" => "714"
            ]);
            FrameworkControlTest::create([
                "id" => "715",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-5-1",
                "framework_control_id" => "715"
            ]);
            FrameworkControlTest::create([
                "id" => "716",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-5-1-1",
                "framework_control_id" => "716"
            ]);
            FrameworkControlTest::create([
                "id" => "717",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-5-1-2",
                "framework_control_id" => "717"
            ]);
            FrameworkControlTest::create([
                "id" => "718",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-1",
                "framework_control_id" => "718"
            ]);
            FrameworkControlTest::create([
                "id" => "719",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-1-1",
                "framework_control_id" => "719"
            ]);
            FrameworkControlTest::create([
                "id" => "720",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-1-2",
                "framework_control_id" => "720"
            ]);
            FrameworkControlTest::create([
                "id" => "721",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-1-3",
                "framework_control_id" => "721"
            ]);
            FrameworkControlTest::create([
                "id" => "722",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-1-4",
                "framework_control_id" => "722"
            ]);
            FrameworkControlTest::create([
                "id" => "723",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-1-5",
                "framework_control_id" => "723"
            ]);
            FrameworkControlTest::create([
                "id" => "724",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-6-2",
                "framework_control_id" => "724"
            ]);
            FrameworkControlTest::create([
                "id" => "725",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-1",
                "framework_control_id" => "725"
            ]);
            FrameworkControlTest::create([
                "id" => "726",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-2",
                "framework_control_id" => "726"
            ]);
            FrameworkControlTest::create([
                "id" => "727",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-2-1",
                "framework_control_id" => "727"
            ]);
            FrameworkControlTest::create([
                "id" => "728",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-2-2",
                "framework_control_id" => "728"
            ]);
            FrameworkControlTest::create([
                "id" => "729",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-2",
                "framework_control_id" => "729"
            ]);
            FrameworkControlTest::create([
                "id" => "730",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-3-2",
                "framework_control_id" => "730"
            ]);
            FrameworkControlTest::create([
                "id" => "731",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-3-4",
                "framework_control_id" => "731"
            ]);
            FrameworkControlTest::create([
                "id" => "732",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-3-5",
                "framework_control_id" => "732"
            ]);
            FrameworkControlTest::create([
                "id" => "733",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 2-7-4",
                "framework_control_id" => "733"
            ]);
            FrameworkControlTest::create([
                "id" => "734",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1",
                "framework_control_id" => "734"
            ]);
            FrameworkControlTest::create([
                "id" => "735",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1-1",
                "framework_control_id" => "735"
            ]);
            FrameworkControlTest::create([
                "id" => "736",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1-2",
                "framework_control_id" => "736"
            ]);
            FrameworkControlTest::create([
                "id" => "737",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1-3",
                "framework_control_id" => "737"
            ]);
            FrameworkControlTest::create([
                "id" => "738",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1-4",
                "framework_control_id" => "738"
            ]);
            FrameworkControlTest::create([
                "id" => "739",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1-5",
                "framework_control_id" => "739"
            ]);
            FrameworkControlTest::create([
                "id" => "740",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-1-6",
                "framework_control_id" => "740"
            ]);
            FrameworkControlTest::create([
                "id" => "741",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2",
                "framework_control_id" => "741"
            ]);
            FrameworkControlTest::create([
                "id" => "742",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-1",
                "framework_control_id" => "742"
            ]);
            FrameworkControlTest::create([
                "id" => "743",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-2",
                "framework_control_id" => "743"
            ]);
            FrameworkControlTest::create([
                "id" => "744",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-3",
                "framework_control_id" => "744"
            ]);
            FrameworkControlTest::create([
                "id" => "745",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-4",
                "framework_control_id" => "745"
            ]);
            FrameworkControlTest::create([
                "id" => "746",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-5",
                "framework_control_id" => "746"
            ]);
            FrameworkControlTest::create([
                "id" => "747",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-6",
                "framework_control_id" => "747"
            ]);
            FrameworkControlTest::create([
                "id" => "748",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-7",
                "framework_control_id" => "748"
            ]);
            FrameworkControlTest::create([
                "id" => "749",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "DCC 3-1-2-8",
                "framework_control_id" => "749"
            ]);
        }
        // SAMA
        if (in_array('SAMA', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "855",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-1",
                "framework_control_id" => "855"
            ]);
            FrameworkControlTest::create([
                "id" => "856",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-2",
                "framework_control_id" => "856"
            ]);
            FrameworkControlTest::create([
                "id" => "857",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-3",
                "framework_control_id" => "857"
            ]);
            FrameworkControlTest::create([
                "id" => "858",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-4",
                "framework_control_id" => "858"
            ]);
            FrameworkControlTest::create([
                "id" => "859",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-5",
                "framework_control_id" => "859"
            ]);
            FrameworkControlTest::create([
                "id" => "860",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-6",
                "framework_control_id" => "860"
            ]);
            FrameworkControlTest::create([
                "id" => "861",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-1-7",
                "framework_control_id" => "861"
            ]);
            FrameworkControlTest::create([
                "id" => "862",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-1",
                "framework_control_id" => "862"
            ]);
            FrameworkControlTest::create([
                "id" => "863",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-1-1",
                "framework_control_id" => "863"
            ]);
            FrameworkControlTest::create([
                "id" => "864",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-1-2",
                "framework_control_id" => "864"
            ]);
            FrameworkControlTest::create([
                "id" => "865",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-1-3",
                "framework_control_id" => "865"
            ]);
            FrameworkControlTest::create([
                "id" => "866",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-1-4",
                "framework_control_id" => "866"
            ]);
            FrameworkControlTest::create([
                "id" => "867",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-2",
                "framework_control_id" => "867"
            ]);
            FrameworkControlTest::create([
                "id" => "868",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-3",
                "framework_control_id" => "868"
            ]);
            FrameworkControlTest::create([
                "id" => "869",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-4",
                "framework_control_id" => "869"
            ]);
            FrameworkControlTest::create([
                "id" => "870",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-2-5",
                "framework_control_id" => "870"
            ]);
            FrameworkControlTest::create([
                "id" => "871",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-1",
                "framework_control_id" => "871"
            ]);
            FrameworkControlTest::create([
                "id" => "872",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-2",
                "framework_control_id" => "872"
            ]);
            FrameworkControlTest::create([
                "id" => "873",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-3",
                "framework_control_id" => "873"
            ]);
            FrameworkControlTest::create([
                "id" => "874",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-4",
                "framework_control_id" => "874"
            ]);
            FrameworkControlTest::create([
                "id" => "875",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-5",
                "framework_control_id" => "875"
            ]);
            FrameworkControlTest::create([
                "id" => "876",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-6",
                "framework_control_id" => "876"
            ]);
            FrameworkControlTest::create([
                "id" => "877",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-7",
                "framework_control_id" => "877"
            ]);
            FrameworkControlTest::create([
                "id" => "878",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-8",
                "framework_control_id" => "878"
            ]);
            FrameworkControlTest::create([
                "id" => "879",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-9",
                "framework_control_id" => "879"
            ]);
            FrameworkControlTest::create([
                "id" => "880",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-10",
                "framework_control_id" => "880"
            ]);
            FrameworkControlTest::create([
                "id" => "881",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-11",
                "framework_control_id" => "881"
            ]);
            FrameworkControlTest::create([
                "id" => "882",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-12",
                "framework_control_id" => "882"
            ]);
            FrameworkControlTest::create([
                "id" => "883",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-13",
                "framework_control_id" => "883"
            ]);
            FrameworkControlTest::create([
                "id" => "884",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-14",
                "framework_control_id" => "884"
            ]);
            FrameworkControlTest::create([
                "id" => "885",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-15",
                "framework_control_id" => "885"
            ]);
            FrameworkControlTest::create([
                "id" => "886",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-16",
                "framework_control_id" => "886"
            ]);
            FrameworkControlTest::create([
                "id" => "887",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-3-17",
                "framework_control_id" => "887"
            ]);
            FrameworkControlTest::create([
                "id" => "888",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-4-1",
                "framework_control_id" => "888"
            ]);
            FrameworkControlTest::create([
                "id" => "889",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-4-2",
                "framework_control_id" => "889"
            ]);
            FrameworkControlTest::create([
                "id" => "890",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "SAMA 3-4-3",
                "framework_control_id" => "890"
            ]);
        }
        // ISO-27001
        if (in_array('ISO-27001', SEEDING_FRAMEWORKS)) {
            FrameworkControlTest::create([
                "id" => "891",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.5.1.1",
                "framework_control_id" => "891"
            ]);
            FrameworkControlTest::create([
                "id" => "892",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.5.1.2",
                "framework_control_id" => "892"
            ]);
            FrameworkControlTest::create([
                "id" => "893",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.1.1",
                "framework_control_id" => "893"
            ]);
            FrameworkControlTest::create([
                "id" => "894",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.1.2",
                "framework_control_id" => "894"
            ]);
            FrameworkControlTest::create([
                "id" => "895",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.1.3",
                "framework_control_id" => "895"
            ]);
            FrameworkControlTest::create([
                "id" => "896",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.1.4",
                "framework_control_id" => "896"
            ]);
            FrameworkControlTest::create([
                "id" => "898",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.1.5",
                "framework_control_id" => "898"
            ]);
            FrameworkControlTest::create([
                "id" => "899",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.2.1",
                "framework_control_id" => "899"
            ]);
            FrameworkControlTest::create([
                "id" => "900",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.6.2.2",
                "framework_control_id" => "900"
            ]);
            FrameworkControlTest::create([
                "id" => "901",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.7.1.1",
                "framework_control_id" => "901"
            ]);
            FrameworkControlTest::create([
                "id" => "902",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.7.1.2",
                "framework_control_id" => "902"
            ]);
            FrameworkControlTest::create([
                "id" => "903",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.7.2.1",
                "framework_control_id" => "903"
            ]);
            FrameworkControlTest::create([
                "id" => "904",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.7.2.2",
                "framework_control_id" => "904"
            ]);
            FrameworkControlTest::create([
                "id" => "905",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.7.2.3",
                "framework_control_id" => "905"
            ]);
            FrameworkControlTest::create([
                "id" => "906",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.7.3.1",
                "framework_control_id" => "906"
            ]);
            FrameworkControlTest::create([
                "id" => "907",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.1.1",
                "framework_control_id" => "907"
            ]);
            FrameworkControlTest::create([
                "id" => "908",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.1.2",
                "framework_control_id" => "908"
            ]);
            FrameworkControlTest::create([
                "id" => "909",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.1.3",
                "framework_control_id" => "909"
            ]);
            FrameworkControlTest::create([
                "id" => "910",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.1.4",
                "framework_control_id" => "910"
            ]);
            FrameworkControlTest::create([
                "id" => "911",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.2.1",
                "framework_control_id" => "911"
            ]);
            FrameworkControlTest::create([
                "id" => "912",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.2.2",
                "framework_control_id" => "912"
            ]);
            FrameworkControlTest::create([
                "id" => "913",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.2.3",
                "framework_control_id" => "913"
            ]);
            FrameworkControlTest::create([
                "id" => "914",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.3.1",
                "framework_control_id" => "914"
            ]);
            FrameworkControlTest::create([
                "id" => "915",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.3.2",
                "framework_control_id" => "915"
            ]);
            FrameworkControlTest::create([
                "id" => "916",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.8.3.3",
                "framework_control_id" => "916"
            ]);
            FrameworkControlTest::create([
                "id" => "917",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.1.1",
                "framework_control_id" => "917"
            ]);
            FrameworkControlTest::create([
                "id" => "918",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.1.2",
                "framework_control_id" => "918"
            ]);
            FrameworkControlTest::create([
                "id" => "919",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.2.1",
                "framework_control_id" => "919"
            ]);
            FrameworkControlTest::create([
                "id" => "920",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.2.2",
                "framework_control_id" => "920"
            ]);
            FrameworkControlTest::create([
                "id" => "921",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.2.3",
                "framework_control_id" => "921"
            ]);
            FrameworkControlTest::create([
                "id" => "922",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.2.4",
                "framework_control_id" => "922"
            ]);
            FrameworkControlTest::create([
                "id" => "923",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.2.5",
                "framework_control_id" => "923"
            ]);
            FrameworkControlTest::create([
                "id" => "924",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.2.6",
                "framework_control_id" => "924"
            ]);
            FrameworkControlTest::create([
                "id" => "925",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.3.1",
                "framework_control_id" => "925"
            ]);
            FrameworkControlTest::create([
                "id" => "926",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.4.1",
                "framework_control_id" => "926"
            ]);
            FrameworkControlTest::create([
                "id" => "927",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.4.2",
                "framework_control_id" => "927"
            ]);
            FrameworkControlTest::create([
                "id" => "928",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.4.3",
                "framework_control_id" => "928"
            ]);
            FrameworkControlTest::create([
                "id" => "929",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.4.4",
                "framework_control_id" => "929"
            ]);
            FrameworkControlTest::create([
                "id" => "930",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.9.4.5",
                "framework_control_id" => "930"
            ]);
            FrameworkControlTest::create([
                "id" => "931",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.10.1.1",
                "framework_control_id" => "931"
            ]);
            FrameworkControlTest::create([
                "id" => "932",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.10.1.2",
                "framework_control_id" => "932"
            ]);
            FrameworkControlTest::create([
                "id" => "933",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.1.1",
                "framework_control_id" => "933"
            ]);
            FrameworkControlTest::create([
                "id" => "934",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.1.2",
                "framework_control_id" => "934"
            ]);
            FrameworkControlTest::create([
                "id" => "935",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.1.3",
                "framework_control_id" => "935"
            ]);
            FrameworkControlTest::create([
                "id" => "936",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.1.4",
                "framework_control_id" => "936"
            ]);
            FrameworkControlTest::create([
                "id" => "937",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.1.5",
                "framework_control_id" => "937"
            ]);
            FrameworkControlTest::create([
                "id" => "938",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.1.6",
                "framework_control_id" => "938"
            ]);
            FrameworkControlTest::create([
                "id" => "939",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.1",
                "framework_control_id" => "939"
            ]);
            FrameworkControlTest::create([
                "id" => "940",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.2",
                "framework_control_id" => "940"
            ]);
            FrameworkControlTest::create([
                "id" => "941",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.3",
                "framework_control_id" => "941"
            ]);
            FrameworkControlTest::create([
                "id" => "942",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.4",
                "framework_control_id" => "942"
            ]);
            FrameworkControlTest::create([
                "id" => "943",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.5",
                "framework_control_id" => "943"
            ]);
            FrameworkControlTest::create([
                "id" => "944",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.5",
                "framework_control_id" => "944"
            ]);
            FrameworkControlTest::create([
                "id" => "945",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.6",
                "framework_control_id" => "945"
            ]);
            FrameworkControlTest::create([
                "id" => "946",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.7",
                "framework_control_id" => "946"
            ]);
            FrameworkControlTest::create([
                "id" => "947",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.8",
                "framework_control_id" => "947"
            ]);
            FrameworkControlTest::create([
                "id" => "948",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.11.2.9",
                "framework_control_id" => "948"
            ]);
            FrameworkControlTest::create([
                "id" => "949",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.1.1",
                "framework_control_id" => "949"
            ]);
            FrameworkControlTest::create([
                "id" => "950",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.1.2",
                "framework_control_id" => "950"
            ]);
            FrameworkControlTest::create([
                "id" => "951",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.1.3",
                "framework_control_id" => "951"
            ]);
            FrameworkControlTest::create([
                "id" => "952",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.1.4",
                "framework_control_id" => "952"
            ]);
            FrameworkControlTest::create([
                "id" => "953",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.2.1",
                "framework_control_id" => "953"
            ]);
            FrameworkControlTest::create([
                "id" => "954",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.3.1",
                "framework_control_id" => "954"
            ]);
            FrameworkControlTest::create([
                "id" => "955",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.4.1",
                "framework_control_id" => "955"
            ]);
            FrameworkControlTest::create([
                "id" => "956",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.4.2",
                "framework_control_id" => "956"
            ]);
            FrameworkControlTest::create([
                "id" => "957",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.4.3",
                "framework_control_id" => "957"
            ]);
            FrameworkControlTest::create([
                "id" => "958",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.4.4",
                "framework_control_id" => "958"
            ]);
            FrameworkControlTest::create([
                "id" => "959",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.5.1",
                "framework_control_id" => "959"
            ]);
            FrameworkControlTest::create([
                "id" => "960",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.6.1",
                "framework_control_id" => "960"
            ]);
            FrameworkControlTest::create([
                "id" => "961",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.6.2",
                "framework_control_id" => "961"
            ]);
            FrameworkControlTest::create([
                "id" => "962",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.12.7.1",
                "framework_control_id" => "962"
            ]);
            FrameworkControlTest::create([
                "id" => "963",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.1.1",
                "framework_control_id" => "963"
            ]);
            FrameworkControlTest::create([
                "id" => "964",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.1.2",
                "framework_control_id" => "964"
            ]);
            FrameworkControlTest::create([
                "id" => "965",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.1.3",
                "framework_control_id" => "965"
            ]);
            FrameworkControlTest::create([
                "id" => "966",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.2.1",
                "framework_control_id" => "966"
            ]);
            FrameworkControlTest::create([
                "id" => "967",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.2.2",
                "framework_control_id" => "967"
            ]);
            FrameworkControlTest::create([
                "id" => "968",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.2.3",
                "framework_control_id" => "968"
            ]);
            FrameworkControlTest::create([
                "id" => "969",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.2.4",
                "framework_control_id" => "969"
            ]);
            FrameworkControlTest::create([
                "id" => "970",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.13.2.4",
                "framework_control_id" => "970"
            ]);
            FrameworkControlTest::create([
                "id" => "971",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.1.1",
                "framework_control_id" => "971"
            ]);
            FrameworkControlTest::create([
                "id" => "972",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.1.2",
                "framework_control_id" => "972"
            ]);
            FrameworkControlTest::create([
                "id" => "973",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.1.3",
                "framework_control_id" => "973"
            ]);
            FrameworkControlTest::create([
                "id" => "974",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.1",
                "framework_control_id" => "974"
            ]);
            FrameworkControlTest::create([
                "id" => "975",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.2",
                "framework_control_id" => "975"
            ]);
            FrameworkControlTest::create([
                "id" => "976",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.3",
                "framework_control_id" => "976"
            ]);
            FrameworkControlTest::create([
                "id" => "977",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.4",
                "framework_control_id" => "977"
            ]);
            FrameworkControlTest::create([
                "id" => "978",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.5",
                "framework_control_id" => "978"
            ]);
            FrameworkControlTest::create([
                "id" => "979",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.6",
                "framework_control_id" => "979"
            ]);
            FrameworkControlTest::create([
                "id" => "980",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.7",
                "framework_control_id" => "980"
            ]);
            FrameworkControlTest::create([
                "id" => "981",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.8",
                "framework_control_id" => "981"
            ]);
            FrameworkControlTest::create([
                "id" => "982",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.2.9",
                "framework_control_id" => "982"
            ]);
            FrameworkControlTest::create([
                "id" => "983",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.14.3.1",
                "framework_control_id" => "983"
            ]);
            FrameworkControlTest::create([
                "id" => "984",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.15.1.1",
                "framework_control_id" => "984"
            ]);
            FrameworkControlTest::create([
                "id" => "985",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.15.1.2",
                "framework_control_id" => "985"
            ]);
            FrameworkControlTest::create([
                "id" => "986",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.15.1.3",
                "framework_control_id" => "986"
            ]);
            FrameworkControlTest::create([
                "id" => "987",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.15.2.1",
                "framework_control_id" => "987"
            ]);
            FrameworkControlTest::create([
                "id" => "988",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.15.2.2",
                "framework_control_id" => "988"
            ]);
            FrameworkControlTest::create([
                "id" => "989",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.1",
                "framework_control_id" => "989"
            ]);
            FrameworkControlTest::create([
                "id" => "990",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.2",
                "framework_control_id" => "990"
            ]);
            FrameworkControlTest::create([
                "id" => "991",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.3",
                "framework_control_id" => "991"
            ]);
            FrameworkControlTest::create([
                "id" => "992",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.4",
                "framework_control_id" => "992"
            ]);
            FrameworkControlTest::create([
                "id" => "993",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.5",
                "framework_control_id" => "993"
            ]);
            FrameworkControlTest::create([
                "id" => "994",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.6",
                "framework_control_id" => "994"
            ]);
            FrameworkControlTest::create([
                "id" => "995",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.16.1.7",
                "framework_control_id" => "995"
            ]);
            FrameworkControlTest::create([
                "id" => "996",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.17.1.1",
                "framework_control_id" => "996"
            ]);
            FrameworkControlTest::create([
                "id" => "997",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.17.1.2",
                "framework_control_id" => "997"
            ]);
            FrameworkControlTest::create([
                "id" => "998",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.17.1.3",
                "framework_control_id" => "998"
            ]);
            FrameworkControlTest::create([
                "id" => "999",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.17.2.1",
                "framework_control_id" => "999"
            ]);
            FrameworkControlTest::create([
                "id" => "1000",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.1.1",
                "framework_control_id" => "1000"
            ]);
            FrameworkControlTest::create([
                "id" => "1001",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.1.2",
                "framework_control_id" => "1001"
            ]);
            FrameworkControlTest::create([
                "id" => "1002",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.1.3",
                "framework_control_id" => "1002"
            ]);
            FrameworkControlTest::create([
                "id" => "1003",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.1.4",
                "framework_control_id" => "1003"
            ]);
            FrameworkControlTest::create([
                "id" => "1004",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.1.5",
                "framework_control_id" => "1004"
            ]);
            FrameworkControlTest::create([
                "id" => "1005",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.2.1",
                "framework_control_id" => "1005"
            ]);
            FrameworkControlTest::create([
                "id" => "1006",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.2.2",
                "framework_control_id" => "1006"
            ]);
            FrameworkControlTest::create([
                "id" => "1007",
                "tester" => "1",
                "last_date" => $currentDate,
                "next_date" => $currentDate,
                "name" => "ISO A.18.2.3",
                "framework_control_id" => "1007"
            ]);
        }
    }
}
