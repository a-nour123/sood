<?php

namespace Database\Seeders;

use App\Models\UserToTeam;
use Illuminate\Database\Seeder;

class UserToTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 1
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 2
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 3
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 4
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 5
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 6
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 7
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 8
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 9
        ]);
        UserToTeam::create([
            "user_id" => 1,
            "team_id" => 10
        ]);
    }
}
