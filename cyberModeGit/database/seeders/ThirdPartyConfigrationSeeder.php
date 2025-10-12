<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThirdPartyConfigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classifications =
            [
                [
                    'id' => 1,
                    'name' => 'Cybersecurity',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'IT services',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'Consultations',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'name' => 'Computer & Hardware',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'name' => 'Contracting',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

        $services =
            [
                [
                    'id' => 1,
                    'name' => 'Cloud',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'Application',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'SOC',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'name' => 'Consultations',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'name' => 'Human Resources',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 6,
                    'name' => 'Professional Services',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 7,
                    'name' => 'Legal Services',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

        $evaluations =
            [
                [
                    'id' => 1,
                    'name' => 'Is the third party critically important in providing the required service to management?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'Is there an alternative plan to provide services in case the third-party ceases operations?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'Could there be financial losses that might affect the organization in case of service interruption?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'name' => 'Is the third party capable of a rapid response in emergency situations?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'name' => "Could a service disruption affect the company's core operations?",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 6,
                    'name' => 'Can the service be replaced by another third party without significantly impacting business continuity?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 7,
                    'name' => 'Is there a clear mechanism for communication with the third-party during crises?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 8,
                    'name' => 'Does the third party have a successful track record in handling service disruptions?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

        // Insert classifications
        DB::table('third_party_classifications')->insert($classifications);
        // Insert services
        DB::table('third_party_services')->insert($services);
        // Insert evaluations
        DB::table('third_party_evaluations')->insert($evaluations);
    }
}
