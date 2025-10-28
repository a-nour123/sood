<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemediationDetailsSeeder extends Seeder
{
    public function run()
    {
        $recordCount = 420;

        // Fetch existing control_test_ids
        $validControlTestIds = DB::table('framework_control_test_audits')->pluck('id')->toArray();

        for ($i = 0; $i < $recordCount; $i++) {
            // Ensure the random ID is valid
            $controlTestId = $validControlTestIds[array_rand($validControlTestIds)];

            DB::table('remediation_details')->insert([
                'responsible_user' => '1',
                'corrective_action_plan' => '<p>gfhfh</p>',
                'budgetary' => '634.00',
                'status' => '1',
                'due_date' => '2024-09-18',
                'comments' => 'fghfghfgh',
                'control_test_id' => $controlTestId, // Use a valid ID
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
