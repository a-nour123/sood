<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;

class SubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissionGroups  = PermissionGroup::pluck('id', 'name');
        $governanceId = $permissionGroups['Governance'];
        $riskId = $permissionGroups['Risk Management'];
        $complianceId = $permissionGroups['Compliance'];
        $awarenessId = $permissionGroups['Awareness'];
        $configurationId = $permissionGroups['Configuration'];
        $LMSId = $permissionGroups['LMS'];



        // governanceId
        Subgroup::create([
            "name" => 'Hierarchy',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Department',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Job',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Regulator',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'FrameWork Setting',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Frameworks',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Controls',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Control Requirements',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Document',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            "name" => 'Categories',
            "permission_group_id" => $governanceId
        ]);
        Subgroup::create([
            'name' => 'Policy_Clauses',
            'permission_group_id' => $governanceId,
        ]);
        Subgroup::create([
            'name' => 'Aduit Policy',
            'permission_group_id' => $governanceId,
        ]);
        Subgroup::create([
            'name' => 'KPI',
            'permission_group_id' => $governanceId,
        ]);
        Subgroup::create([
            'name' => 'Task',
            'permission_group_id' => $governanceId,
        ]);
        Subgroup::create([
            'name' => 'Change Request',
            'permission_group_id' => $governanceId,
        ]);
        Subgroup::create([
            'name' => 'Exceptions',
            'permission_group_id' => $governanceId,
        ]);

        // riskId
        Subgroup::create([
            'name' => 'Risks Management',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Classic Risk Formula',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Plan Mitigation',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Perform Reviews',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Assessment Templates',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Assessments',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Assessment Results',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Incident',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Vulnerability Management',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Asset Management',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Asset Groups',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Third Party Profile',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Third Party Request',
            'permission_group_id' => $riskId,
        ]);
        Subgroup::create([
            'name' => 'Third Party Assessment',
            'permission_group_id' => $riskId,
        ]);

        // complianceId
        Subgroup::create([
            'name' => 'Audits',
            'permission_group_id' => $complianceId,
        ]);
        Subgroup::create([
            'name' => 'Remidation',
            'permission_group_id' => $complianceId,
        ]);

        // awarenessId
        Subgroup::create([
            'name' => 'Phishing Campaign',
            'permission_group_id' => $awarenessId,
        ]);
        Subgroup::create([
            'name' => 'Phishing Website',
            'permission_group_id' => $awarenessId,
        ]);
        Subgroup::create([
            'name' => 'Phishing Template',
            'permission_group_id' => $awarenessId,
        ]);
        Subgroup::create([
            'name' => 'Phishing Sender Profile',
            'permission_group_id' => $awarenessId,
        ]);
        Subgroup::create([
            'name' => 'Phishing Domains',
            'permission_group_id' => $awarenessId,
        ]);
        Subgroup::create([
            'name' => 'Security Awareness',
            'permission_group_id' => $awarenessId,
        ]);
        Subgroup::create([
            'name' => 'Awareness Survey',
            'permission_group_id' => $awarenessId,
        ]);

        // configurationId
        Subgroup::create([
            'name' => 'User Management',
            'permission_group_id' => $configurationId,
        ]);
        Subgroup::create([
            'name' => 'Role Management',
            'permission_group_id' => $configurationId,
        ]);
        Subgroup::create([
            'name' => 'Email Setting',
            'permission_group_id' => $configurationId,
        ]);
        Subgroup::create([
            'name' => 'Language',
            'permission_group_id' => $configurationId,
        ]);

        Subgroup::create([
            'name' => 'LDAP Setting',
            'permission_group_id' => $configurationId,
        ]);
        Subgroup::create([
            'name' => 'Audit Trail',
            'permission_group_id' => $configurationId,
        ]);
        // Subgroup::create([
        //     'name' => 'Settings',
        //     'permission_group_id' => $configurationId,
        // ]);
        Subgroup::create([
            'name' => 'General Settings',
            'permission_group_id' => $configurationId,
        ]);
        Subgroup::create([
            'name' => 'Services Description',
            'permission_group_id' => $configurationId,
        ]);
        Subgroup::create([
            'name' => 'About',
            'permission_group_id' => $configurationId,
        ]);
        // Subgroup::create([
        //     'name' => 'Reporting',
        //     'permission_group_id' => $configurationId,
        // ]);
        Subgroup::create([
            'name' => 'Domain',
            'permission_group_id' => $configurationId,
        ]);
        // Subgroup::create([
        //     'name' => 'Add And Remove Value',
        //     'permission_group_id' => $configurationId,
        // ]);

        // LMS
        Subgroup::create([
            'name' => 'LMS Courses',
            'permission_group_id' => $LMSId,
        ]);
        Subgroup::create([
            'name' => 'LMS Levels',
            'permission_group_id' => $LMSId,
        ]);
        Subgroup::create([
            'name' => 'LMS TrainingModules',
            'permission_group_id' => $LMSId,
        ]);
        Subgroup::create([
            'name' => 'LMS Exams',
            'permission_group_id' => $LMSId,
        ]);























        // Subgroup::create([
        //     'name' => 'Frameworks',
        //     'permission_group_id' => 1,   //1
        // ]);

        // Subgroup::create([
        //     'name' => 'Controls',
        //     'permission_group_id' => 1, //2
        // ]);

        // Subgroup::create([
        //     'name' => 'Document',
        //     'permission_group_id' => 1,  //3
        // ]);

        // Subgroup::create([
        //     'name' => 'Exception',
        //     'permission_group_id' => 1, //4
        // ]);

        // Subgroup::create([
        //     'name' => 'Risks',
        //     'permission_group_id' => 2, //5
        // ]);

        // Subgroup::create([
        //     'name' => 'Projects',
        //     'permission_group_id' => 2, //6
        // ]);

        // Subgroup::create([
        //     'name' => 'Compliance',
        //     'permission_group_id' => 3, //7
        // ]);

        // Subgroup::create([ // 11
        //     'name' => 'Tests',
        //     'permission_group_id' => 3, //8
        // ]);

        // Subgroup::create([
        //     'name' => 'Audits',
        //     'permission_group_id' => 3, //9
        // ]);
        // Subgroup::create([
        //     'name' => 'Assets',
        //     'permission_group_id' => 4, //10
        // ]);
        // Subgroup::create([
        //     'name' => 'Assessments',
        //     'permission_group_id' => 5, //11
        // ]);
        // Subgroup::create([
        //     'name' => 'RoleManagement',
        //     'permission_group_id' => 6, //12
        // ]);

        // Subgroup::create([
        //     'name' => 'Add Values',
        //     'permission_group_id' => 6, //13
        // ]);
        // Subgroup::create([
        //     'name' => 'Audit Logs',
        //     'permission_group_id' => 6, //14
        // ]);

        // Subgroup::create([
        //     "name" => 'Hierarchy',
        //     "permission_group_id" => 7 // 15
        // ]);
        // Subgroup::create([
        //     "name" => 'Department',
        //     "permission_group_id" => 7 // 16
        // ]);
        // Subgroup::create([
        //     "name" => 'Job',
        //     "permission_group_id" => 7 // 17
        // ]);
        // Subgroup::create([
        //     "name" => 'Employee',
        //     "permission_group_id" => 7 // 18
        // ]);

        // Subgroup::create([
        //     'name' => 'Plan Mitigation',
        //     'permission_group_id' => 2, // 19
        // ]);

        // Subgroup::create([
        //     'name' => 'Perform Reviews',
        //     'permission_group_id' => 2, // 20
        // ]);
        // Subgroup::create([
        //     'name' => 'AssetGroups',
        //     'permission_group_id' => 4, // 21
        // ]);
        // Subgroup::create([
        //     'name' => 'Categories',
        //     'permission_group_id' => 1, // 22
        // ]);
        // Subgroup::create([
        //     'name' => 'User Management',
        //     'permission_group_id' => 6, // 23
        // ]);
        // Subgroup::create([
        //     'name' => 'Settings',
        //     'permission_group_id' => 6, // 24
        // ]);
        // Subgroup::create([
        //     'name' => 'ClassicRiskFormula',
        //     'permission_group_id' => 6, // 25
        // ]);
        // Subgroup::create([
        //     'name' => 'Import And Export',
        //     'permission_group_id' => 6, // 26
        // ]);
        // Subgroup::create([
        //     'name' => 'LDAP',
        //     'permission_group_id' => 6, // 27
        // ]);
        // Subgroup::create([
        //     'name' => 'Reporting',
        //     'permission_group_id' => 8, // 28
        // ]);
        // Subgroup::create([
        //     'name' => 'Task',
        //     'permission_group_id' => 9, // 29
        // ]);
        // Subgroup::create([
        //     'name' => 'About',
        //     'permission_group_id' => 6, // 30
        // ]);
        // Subgroup::create([
        //     'name' => 'Vulnerability Management',
        //     'permission_group_id' => 10, // 31
        // ]);
        // Subgroup::create([
        //     'name' => 'General Setting',
        //     'permission_group_id' => 6, // 32
        // ]);
        // Subgroup::create([
        //     'name' => 'Services Description',
        //     'permission_group_id' => 6, // 33
        // ]);
        // Subgroup::create([
        //     'name' => 'Change Request',
        //     'permission_group_id' => 11, // 34
        // ]);
        // Subgroup::create([
        //     'name' => 'Change Request Department',
        //     'permission_group_id' => 6, // 35
        // ]);
        // Subgroup::create([
        //     'name' => 'KPI',
        //     'permission_group_id' => 12, // 36
        // ]);
        // Subgroup::create([
        //     "name" => 'Security Awareness',
        //     'permission_group_id' => 13, // 37
        // ]);
        // Subgroup::create([
        //     'name' => 'Domain',
        //     'permission_group_id' => 6, // 38
        // ]);


        // // assessments
        // Subgroup::create([
        //     'name' => 'Templates',
        //     'permission_group_id' => 14, // 39
        // ]);
        // Subgroup::create([
        //     'name' => 'Assessments',
        //     'permission_group_id' => 14, // 40
        // ]);
        // Subgroup::create([
        //     'name' => 'Assessment Results',
        //     'permission_group_id' => 14, // 41
        // ]);

        // Subgroup::create([
        //     'name' => 'Control Requirements',
        //     'permission_group_id' => 1, // 42

        // ]);
        // Subgroup::create([
        //     'name' => 'AwarenessSurvey',
        //     'permission_group_id' => 13, // 43

        // ]);
        // Subgroup::create([
        //     'name' => 'Email Setting',
        //     'permission_group_id' => 6, //44
        // ]);
        // Subgroup::create([
        //     'name' => 'Exceptions',
        //     'permission_group_id' => 1, //45
        // ]);
        // Subgroup::create([
        //     'name' => 'Frame Setting',
        //     'permission_group_id' => 1, //46
        // ]);
        // Subgroup::create([
        //     'name' => 'Regulator',
        //     'permission_group_id' => 1, //47
        // ]);
        // Subgroup::create([
        //     'name' => 'Remidation',
        //     'permission_group_id' => 3, //48
        // ]);
        // Subgroup::create([
        //     'name' => 'Campaign',
        //     'permission_group_id' => 15, //49
        // ]);
        // Subgroup::create([
        //     'name' => 'Website',
        //     'permission_group_id' => 15, //50
        // ]);
        // Subgroup::create([
        //     'name' => 'Template',
        //     'permission_group_id' => 15, //51
        // ]);
        // Subgroup::create([
        //     'name' => 'Sender Profile',
        //     'permission_group_id' => 15, //52
        // ]);
    }
}
