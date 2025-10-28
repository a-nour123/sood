<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class NotificationControlComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::insert([
            ['id' => 149, 'name' => 'control_docuemt_add_update'],
            ['id' => 150, 'name' => 'control_docuemt_delete'],
            ['id' => 151, 'name' => 'control_docuemt_status_action'],
            ['id' => 152, 'name' => 'add_incident_comment'],
        ]);
    }
}