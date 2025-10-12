<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

define('MAIN_PASSWORD', '12345678');


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Job
         *      [1 TO 13]
         * Department
         *      [1 TO 25] => [1 To 10] under branches
         *      [11 TO 25] under branch (child department)
         * User
         *      Admin [1]
         *      Departments Manager [2 TO 26]
         *      Normal Employee Manager [27 TO 36]
         *      Normal Employee [37 TO 61]
         * */

        User::create([
            "id" => 1,
            "enabled" => 1,
            "lockout" => 0,
            "type" => 'grc',
            "username" => 'admin',
            "name" => 'Admin',
            "email" => 'admin@gmail.com',
            "salt" => 'qCJpnAe5S6k61Pqh3SFG',
            "password" => Hash::make(MAIN_PASSWORD),
            "last_login" => '2022-01-17 09:00:33',
            "last_password_change_date" => '2017-01-08 09:58:20',
            "role_id" => 1,
            "lang" => NULL,
            // 'department_id' =>1,
            "admin" => 1,
            "multi_factor" => 1,
            "change_password" => 0,
            'ldap_region'=> "Riyadh",
            "custom_display_settings" =>
            '[\"id\",\"subject\",\"calculated_risk\",\"submission_date\",\"mitigation_planned\",\"management_review\"]',
            // "manager_id" => 1,
            "custom_plan_mitigation_display_settings" => '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}',
            "custom_perform_reviews_display_settings" => '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n',
            "custom_reviewregularly_display_settings" => '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}',
            // 'job_id' => 1,
        ]);

        // Only seed if mode isn't production
        if (defined('SEEDING_MODE') && SEEDING_MODE !== 'production') {
            // Departments Manager ids[2 TO 26], Department ids [1 TO 25]
            for ($i = 1; $i <= 20; $i++) {
                $department = Department::find($i);

                $departmentManager = User::create([
                    "username" => 'department' . $i . 'manager',
                    "name" => 'مدير ' . $department->name,
                    "email" => 'department' . $i . 'manager@mail.com',
                    "password" => Hash::make(MAIN_PASSWORD),
                    "role_id" => 1,
                    'department_id' => $i,
                    'job_id' => 2,
                    'ldap_region'=> "Riyadh",
                    'manager_id' => ($i <= 10) ? 1 : (($i % 10) ? ($i % 10) : 10),
                ]);

                Department::where('id', $i)->update([
                    'manager_id' => $departmentManager->id
                ]);
            }

            // Normal Employee ids[37 TO 61] , Department ids [1 TO 25]
            for ($i = 1; $i <= 20; $i++) {
                User::create([
                    "username" => 'department' . $i . 'employee1',
                    "name" => 'Department' . $i . ' Employee1',
                    "email" => 'employee' . $i . '@mail.com',
                    "password" => Hash::make(MAIN_PASSWORD),
                    "role_id" => 1,
                    'job_id' => random_int(3, 12),
                    'ldap_region'=> "Riyadh",
                    'department_id' => $i,
                    'manager_id' => (($i % 2) == 0 && ($i % 2) != 0 && ($i % 2) <= 20) ?
                        ($i % 2) : Department::where('id', $i)->first()->manager->id
                ]);
            }
        }
    }
}
