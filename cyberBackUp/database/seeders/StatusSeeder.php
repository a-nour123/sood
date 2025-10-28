<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            "id" => 1,
            "name" => 'New'
        ]);
        Status::create([
            "id" => 2,
            "name" => 'Mitigation Planned'
        ]);
        Status::create([
            "id" => 3,
            "name" => 'Mgmt Reviewed'
        ]);
        Status::create([
            "id" => 4,
            "name" => 'Closed'
        ]);
        Status::create([
            "id" => 5,
            "name" => 'Reopened'
        ]);
        Status::create([
            "id" => 6,
            "name" => 'Untreated'
        ]);
        Status::create([
            "id" => 7,
            "name" => 'Treated'
        ]);
    }
}
