<?php

namespace Database\Seeders;

use App\Models\PhishingGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class PhishingGroupUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::take(20)->get();
        PhishingGroup::each(function ($group) use ($users) {
            $group->users()->attach(
                $users->random(2)->pluck('id')->toArray()
            );
        });
    }
}
