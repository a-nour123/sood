<?php

namespace Database\Seeders;

use App\Models\ControlClass;
use Illuminate\Database\Seeder;

class ControlClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlClass::create([
            "id" => 1,
            "name" => 'Technical'
        ]);
        ControlClass::create([
            "id" => 2,
            "name" => 'Operational'
        ]);
        ControlClass::create([
            "id" => 3,
            "name" => 'Management'
        ]);
    }
}
