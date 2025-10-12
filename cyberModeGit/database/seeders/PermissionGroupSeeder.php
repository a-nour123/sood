<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PermissionGroup::create([
        //     "id" => 1,
        //     "name" => 'Governance',
        //     "description" => '',
        //     "order" => 1
        // ]);
        // PermissionGroup::create([
        //     "id" => 2,
        //     "name" => 'Risk Management',
        //     "description" => '',
        //     "order" => 2
        // ]);
        // PermissionGroup::create([
        //     "id" => 3,
        //     "name" => 'Compliance',
        //     "description" => '',
        //     "order" => 3
        // ]);
        // PermissionGroup::create([
        //     "id" => 4,
        //     "name" => 'Asset Management',
        //     "description" => '',
        //     "order" => 4
        // ]);
        // PermissionGroup::create([
        //     "id" => 5,
        //     "name" => 'Assessments',
        //     "description" => '',
        //     "order" => 5
        // ]);
        // PermissionGroup::create([
        //     "id" => 6,
        //     "name" => 'Configure',
        //     "description" => '',
        //     "order" => 6
        // ]);
        // PermissionGroup::create([
        //     "id" => 7,
        //     "name" => 'Hierarchy',
        //     "description" => '',
        //     "order" => 7
        // ]);
        // PermissionGroup::create([
        //     "id" => 8,
        //     "name" => 'Reporting',
        //     "description" => '',
        //     "order" => 8
        // ]);
        // PermissionGroup::create([
        //     "id" => 9,
        //     "name" => 'Task',
        //     "description" => '',
        //     "order" => 9
        // ]);
        // PermissionGroup::create([
        //     "id" => 10,
        //     "name" => 'Vulnerability Management',
        //     "description" => '',
        //     "order" => 10
        // ]);
        // PermissionGroup::create([
        //     "id" => 11,
        //     "name" => 'Change Request',
        //     "description" => '',
        //     "order" => 11
        // ]);
        // PermissionGroup::create([
        //     "id" => 12,
        //     "name" => 'KPI',
        //     "description" => '',
        //     "order" => 12
        // ]);
        // PermissionGroup::create([
        //     "id" => 13,
        //     "name" => 'Security Awareness Mgmt',
        //     "description" => '',
        //     "order" => 13
        // ]);
        // PermissionGroup::create([
        //     "id" => 14,
        //     "name" => 'Assessment',
        //     "description" => 'Assessment',
        //     "order" => 14
        // ]);
        // PermissionGroup::create([
        //     "id" => 15,
        //     "name" => 'Phishing',
        //     "description" => 'Phishing',
        //     "order" => 15
        // ]);

        // new logic

        PermissionGroup::create([
            "id" => 1,
            "name" => 'Governance',
            "description" => '',
            "order" => 1
        ]);
        PermissionGroup::create([
            "id" => 2,
            "name" => 'Risk Management',
            "description" => '',
            "order" => 2
        ]);
        PermissionGroup::create([
            "id" => 3,
            "name" => 'Compliance',
            "description" => '',
            "order" => 3
        ]);
        PermissionGroup::create([
            "id" => 4,
            "name" => 'Awareness',
            "description" => '',
            "order" => 4
        ]);
        PermissionGroup::create([
            "id" => 5,
            "name" => 'Configuration',
            "description" => '',
            "order" => 5
        ]);

        // LMS
        PermissionGroup::create([
            "id" => 6,
            "name" => 'LMS',
            "description" => 'Learning Management System',
            "order" => 6
        ]);

    }
}
