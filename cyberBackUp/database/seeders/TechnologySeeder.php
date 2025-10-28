<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Technology::create([
            "id" => 1,
            "name" => 'Todos'
        ]);
        Technology::create([
            "id" => 2,
            "name" => 'Anti-Virus'
        ]);
        Technology::create([
            "id" => 3,
            "name" => 'Backups'
        ]);
        Technology::create([
            "id" => 4,
            "name" => 'Blackberry'
        ]);
        Technology::create([
            "id" => 5,
            "name" => 'Citrix'
        ]);
        Technology::create([
            "id" => 6,
            "name" => 'Datacenter'
        ]);
        Technology::create([
            "id" => 7,
            "name" => 'Mail Routing'
        ]);
        Technology::create([
            "id" => 8,
            "name" => 'Live Collaboration'
        ]);
        Technology::create([
            "id" => 9,
            "name" => 'Mesajeria'
        ]);
        Technology::create([
            "id" => 10,
            "name" => 'Mobile'
        ]);
        Technology::create([
            "id" => 11,
            "name" => 'Network'
        ]);
        Technology::create([
            "id" => 12,
            "name" => 'Power'
        ]);
        Technology::create([
            "id" => 13,
            "name" => 'Remote Access'
        ]);
        Technology::create([
            "id" => 14,
            "name" => 'SAN'
        ]);
        Technology::create([
            "id" => 15,
            "name" => 'Telecom'
        ]);
        Technology::create([
            "id" => 16,
            "name" => 'Unix'
        ]);
        Technology::create([
            "id" => 17,
            "name" => 'VMWare'
        ]);
        Technology::create([
            "id" => 18,
            "name" => 'Web'
        ]);
        Technology::create([
            "id" => 19,
            "name" => 'Windows'
        ]);
    }
}
