<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $mainPermissions = [
            'framework.', 'control.', 'document.', '', 'riskmanagement.', '', '', '', 'audits.', 'asset.', '',
            'roles.', 'values.', 'logs.', 'hierarchy.', 'department.', 'job.', '', 'plan_mitigation.', 'perform_reviews.',
            'asset_group.', 'category.', 'user_management.','classic_risk_formula.', 'import_and_export.',
            'LDAP.','task.', 'about.', 'vulnerability_management.', 'general-setting.', 'services-description.',
            'change-request.', 'change-request-department.', 'KPI.', 'security-awareness.', 'domain.','domains.', 'templateAssessment.',
            'assessment.', 'assessmentResult.', 'control-objective.', 'awareness-survey.', 'email-setting.', 'exception.', 'frame-setting.',
            'regulator.', 'remidation.','campaign.','website.','template.','sender_profile.','Aduit_Document_Policy.','Document_Policy.',
            'incident.','third_party_profile.','third_party_request.','third_party_assessment.','risks.',
            'courses.','levels.','trainingModules.','exams.','language.','physicalCourses.'
        ];

        $permissionStatuses = ['list','create', 'update', 'delete', 'print', 'export'];

        $LMSAndPhishingPermissionStatuses = ['list','create', 'update', 'delete'];

        $permissionSubGroups  = Subgroup::pluck('id', 'name');


        // new logic

        foreach ($mainPermissions as $mainKey => $mainPermission) {
            if ($mainPermission == '') // neglect ['Compliance', 'Tests]
                continue;
            if ($mainPermission == 'hierarchy.') {
                $subGroupID = $permissionSubGroups['Hierarchy'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'department.') {
                $subGroupID = $permissionSubGroups['Department'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'job.') {
                $subGroupID = $permissionSubGroups['Job'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            } else if ($mainPermission == 'framework.') {
                $subGroupID = $permissionSubGroups['Frameworks'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }

            } else if ($mainPermission == 'regulator.') {
                $subGroupID = $permissionSubGroups['Regulator'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);

            } else if ($mainPermission == 'frame-setting.') {
                $subGroupID = $permissionSubGroups['FrameWork Setting'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'download',
                    "name" => 'download',
                    "subgroup_id" => $subGroupID
                ]);

            } else if ($mainPermission == 'control.') {
                $subGroupID = $permissionSubGroups['Controls'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'list_objectives',
                    "name" => 'list requirements',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'add_objectives',
                    "name" => 'add requirements',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'control-objective.') {
                $subGroupID = $permissionSubGroups['Control Requirements'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'print',
                    "name" => 'print',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'document.') {
                $subGroupID = $permissionSubGroups['Document'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'print',
                    "name" => 'print',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'download',
                    "name" => 'download',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'category.') {
                $subGroupID = $permissionSubGroups['Categories'];
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);

            } else if ($mainPermission == 'Document_Policy.') {
                $subGroupID = $permissionSubGroups['Policy_Clauses'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'Aduit_Document_Policy.') {
                $subGroupID = $permissionSubGroups['Aduit Policy'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'result',
                    "name" => 'result',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'KPI.') {
                $subGroupID = $permissionSubGroups['KPI'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Initiate assessment',
                    "name" => 'Initiate assessment',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'list_Kpi_Assessment',
                    "name" => 'List Kpi Assessment',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'reassign_Kpi_Assessment',
                    "name" => 'ReAssign Kpi Assessment',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'task.') {
                $subGroupID = $permissionSubGroups['Task'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'change-request.') { // change request
                $subGroupID = $permissionSubGroups['Change Request'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'change-request-department',
                    "name" => 'change-request-department',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'exception.') {
                $subGroupID = $permissionSubGroups['Exceptions'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'riskmanagement.') {
                $subGroupID = $permissionSubGroups['Risks Management'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'AbleToCommentRiskManagement',
                    "name" => 'AbleToCommentRiskManagement',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'AbleToCloseRisks',
                    "name" => 'AbleToCloseRisks',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Risk Dashboard',
                    "name" => 'Risk Dashboard',
                    "subgroup_id" =>$subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Risks and Controls',
                    "name" => 'Risks and Controls',
                    "subgroup_id" =>$subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Risks and Assets',
                    "name" => 'Risks and Assets',
                    "subgroup_id" =>$subGroupID
                ]);
            } else if ($mainPermission == 'plan_mitigation.') {
                $subGroupID = $permissionSubGroups['Plan Mitigation'];
                    Permission::create([
                        "key" => $mainPermission . 'create',
                        "name" => 'create',
                        "subgroup_id" => $subGroupID
                    ]);
                    Permission::create([
                        "key" => $mainPermission . 'accept',
                        "name" => 'accept',
                        "subgroup_id" => $subGroupID
                    ]);
            } else if ($mainPermission == 'perform_reviews.') { // Perform Reviews
                $subGroupID = $permissionSubGroups['Perform Reviews'];
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'classic_risk_formula.') {
                $subGroupID = $permissionSubGroups['Classic Risk Formula'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'templateAssessment.') {
                $subGroupID = $permissionSubGroups['Assessment Templates'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'edit',
                    "name" => 'edit',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'questionsAnswer',
                    "name" => 'questions Answer',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'questionsEdit',
                    "name" => 'questions Edit',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'questionsDelete',
                    "name" => 'questions Delete',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'assessment.') {
                $subGroupID = $permissionSubGroups['Assessments'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'showOption',
                    "name" => 'Show Option',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Edit',
                    "name" => 'Edit',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Delete',
                    "name" => 'Delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Send',
                    "name" => 'Send',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'assessmentResult.') {
                $subGroupID = $permissionSubGroups['Assessment Results'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'assessmentResult',
                    "name" => 'Assessment Result',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'action',
                    "name" => 'Assessment Action',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'incident.') {
                $subGroupID = $permissionSubGroups['Incident'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'vulnerability_management.') {
                $subGroupID = $permissionSubGroups['Vulnerability Management'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'asset.') {
                $subGroupID = $permissionSubGroups['Asset Management'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'asset_value',
                    "name" => 'asset_value',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'asset_group.') {
                $subGroupID = $permissionSubGroups['Asset Groups'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            } else if ($mainPermission == 'third_party_profile.') {
                $subGroupID = $permissionSubGroups['Third Party Profile'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'third_party_request.') {
                $subGroupID = $permissionSubGroups['Third Party Request'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'configuration',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'third_party_assessment.') {
                $subGroupID = $permissionSubGroups['Third Party Assessment'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'send',
                    "name" => 'Send',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'assessment_result',
                    "name" => 'Assessment Result',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'audits.') {
                $subGroupID = $permissionSubGroups['Audits'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'audit_plan',
                    "name" => 'audit_plan',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'audit_plan_dashboard',
                    "name" => 'audit_plan_dashboard',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'active_audit',
                    "name" => 'active_audit',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'result',
                    "name" => 'result',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'active_audit_dashboard',
                    "name" => 'active_audit_dashboard',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'past_audit',
                    "name" => 'past_audit',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'framewrok_control_compliance_status',
                    "name" => 'Framewrok control compliance status',
                    "subgroup_id" =>$subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'summary_of_results_for_evaluation_and_compliance',
                    "name" => 'Summary of results for evaluation and compliance',
                    "subgroup_id" =>$subGroupID
                ]);

            } else if ($mainPermission == 'remidation.') {
                $subGroupID = $permissionSubGroups['Remidation'];

                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'campaign.') { // phishing
                $subGroupID = $permissionSubGroups['Phishing Campaign'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'trash',
                    "name" => 'trash',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'restore',
                    "name" => 'restore',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'campaign_approve',
                    "name" => 'Campaign Approve',
                    "subgroup_id" => $subGroupID
                ]);

                Permission::create([
                    "key" => $mainPermission . 'configuration',
                    "name" => 'Campaign Configuration',
                    "subgroup_id" => $subGroupID
                ]);

            } else if ($mainPermission == 'website.') { // phishing
                $subGroupID = $permissionSubGroups['Phishing Website'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'trash',
                    "name" => 'trash',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'restore',
                    "name" => 'restore',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);

            } else if ($mainPermission == 'template.') { // phishing
                $subGroupID = $permissionSubGroups['Phishing Template'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'trash',
                    "name" => 'trash',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'restore',
                    "name" => 'restore',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);

            } else if ($mainPermission == 'sender_profile.') { // phishing
                $subGroupID = $permissionSubGroups['Phishing Sender Profile'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'trash',
                    "name" => 'trash',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'restore',
                    "name" => 'restore',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'domains.') { // phishing
                $subGroupID = $permissionSubGroups['Phishing Domains'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            } else if ($mainPermission == 'security-awareness.') { // Security Awareness
                $subGroupID = $permissionSubGroups['Security Awareness'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'print',
                    "name" => 'print',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'download',
                    "name" => 'download',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'all',
                    "name" => 'all',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'awareness-survey.') { // Awareness Survey
                $subGroupID = $permissionSubGroups['Awareness Survey'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'edit',
                    "name" => 'edit',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'add_questions',
                    "name" => 'add question',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'list_questions',
                    "name" => 'list questions',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'edit_questions',
                    "name" => 'Edit questions',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete_questions',
                    "name" => 'Delete questions',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'awareness-survey-info',
                    "name" => '	Awareness Survey',
                    "subgroup_id" =>$subGroupID
                ]);
            } else if ($mainPermission == 'user_management.') {
                $subGroupID = $permissionSubGroups['User Management'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            } else if ($mainPermission == 'roles.') {
                $subGroupID = $permissionSubGroups['Role Management'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            } else if ($mainPermission == 'email-setting.') {
                $subGroupID = $permissionSubGroups['Email Setting'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
            }  else if ($mainPermission == 'language.') {
                $subGroupID = $permissionSubGroups['Language'];

                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'LDAP.') { // LDAP
                $subGroupID = $permissionSubGroups['LDAP Setting'];

                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'test',
                    "name" => 'test',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
            }  else if ($mainPermission == 'logs.') {
                $subGroupID = $permissionSubGroups['Audit Trail'];
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => $subGroupID
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => $subGroupID
                ]);
            }
            // else if ($mainPermission == 'settings.') {
            //     $subGroupID = $permissionSubGroups['Settings'];
            //     foreach ($permissionStatuses as $key => $permissionStatus) {
            //         Permission::create([
            //             "key" => $mainPermission . $permissionStatus,
            //             "name" => $permissionStatus,
            //             "subgroup_id" => $subGroupID
            //         ]);
            //     }
            // }
            else if ($mainPermission == 'general-setting.') {
                $subGroupID = $permissionSubGroups['General Settings'];
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'services-description.') {
                $subGroupID = $permissionSubGroups['Services Description'];
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
            } else if ($mainPermission == 'about.') {
                $subGroupID = $permissionSubGroups['About'];

                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => $subGroupID
                ]);
            }
            //  else if ($mainPermission == 'reporting.') {
                // $subGroupID = $permissionSubGroups['Reporting'];

                // Permission::create([
                //     "key" => $mainPermission . 'Overview',
                //     "name" => 'Overview',
                //     "subgroup_id" =>$subGroupID
                // ]);

                // Permission::create([
                //     "key" => $mainPermission . 'Control Gap Analysis',
                //     "name" => 'Control Gap Analysis',
                //     "subgroup_id" =>$subGroupID
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'Likelihood And Impact',
                //     "name" => 'Likelihood And Impact',
                //     "subgroup_id" =>$subGroupID
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'All Open Risks Assigne To Me',
                //     "name" => 'All Open Risks Assigne To Me',
                //     "subgroup_id" =>$subGroupID
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'Dynamic Risk Report',
                //     "name" => 'Dynamic Risk Report',
                //     "subgroup_id" =>$subGroupID
                // ]);


                // Permission::create([
                //     "key" => $mainPermission . 'security-awareness-exam',
                //     "name" => 'Security awareness exam',
                //     "subgroup_id" =>$subGroupID
                // ]);

                // Permission::create([
                //     "key" => $mainPermission . 'objectives',
                //     "name" => 'Objectives',
                //     "subgroup_id" =>$subGroupID
                // ]);
            // }
            else if ($mainPermission == 'domain.') {
                $subGroupID = $permissionSubGroups['Domain'];
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            }
            // else if ($mainPermission == 'values.') {
            //     $subGroupID = $permissionSubGroups['Add And Remove Value'];
            //     foreach ($permissionStatuses as $key => $permissionStatus) {
            //         Permission::create([
            //             "key" => $mainPermission . $permissionStatus,
            //             "name" => $permissionStatus,
            //             "subgroup_id" => $subGroupID
            //         ]);
            //     }
            // }
            elseif ($mainPermission == 'courses.') {
                $subGroupID = $permissionSubGroups['LMS Courses'];
                foreach ($LMSAndPhishingPermissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus, //courses.list
                        "name" => $permissionStatus, // list
                        "subgroup_id" => $subGroupID // LMS Courses
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'getCourseLevels',
                    "name" => 'getCourseLevels',
                    "subgroup_id" => $subGroupID
                ]);
            } elseif ($mainPermission == 'levels.') {
                $subGroupID = $permissionSubGroups['LMS Levels'];
                foreach ($LMSAndPhishingPermissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'getLevelTrainingModules',
                    "name" => 'getLevelTrainingModules',
                    "subgroup_id" => $subGroupID
                ]);
            } elseif ($mainPermission == 'trainingModules.') {
                $subGroupID = $permissionSubGroups['LMS TrainingModules'];
                foreach ($LMSAndPhishingPermissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
                Permission::create([
                    "key" => $mainPermission . 'compliances',
                    "name" => 'compliances',
                    "subgroup_id" => $subGroupID
                ]);
            } elseif ($mainPermission == 'exams.') {
                $subGroupID = $permissionSubGroups['LMS Exams'];
                $examsPermissionStatuses =['list','getQuiz'];
                foreach ($examsPermissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $subGroupID
                    ]);
                }
            }
            // elseif ($mainPermission == 'physicalCourses.') {
            //     $subGroupID = $permissionSubGroups['Physical Courses'];
            //     $examsPermissionStatuses =[
            //         'list','create','update','delete','showRequests',
            //         'approveRequest','rejectRequest','transferRequest','attendance','storeAttendance','grade','storeGrade',
            //         'toggleRegistration','reports'
            //     ];
            //     foreach ($examsPermissionStatuses as $key => $permissionStatus) {
            //         $permission = Permission::create([
            //             'key' => $mainPermission . $permissionStatus,
            //             'name' => $permissionStatus,
            //             'subgroup_id' => $subGroupID
            //         ]);

            //         DB::table('role_responsibilities')->insert([
            //             'role_id' => 1,
            //             'permission_id' => $permission->id,
            //         ]);
            //     }
            // }




            // else if ($mainPermission == 'task.') { // Task
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 29
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 29
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 29
            //     ]);
            // } else if ($mainPermission == 'audits.') { // Audit
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 9
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 9
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 9
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'result',
            //         "name" => 'result',
            //         "subgroup_id" => 9
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 9
            //     ]);
            // } else if ($mainPermission == 'reporting.') { // Reporting
            //     Permission::create([
            //         "key" => $mainPermission . 'Overview',
            //         "name" => 'Overview',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Risk Dashboard',
            //         "name" => 'Risk Dashboard',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Control Gap Analysis',
            //         "name" => 'Control Gap Analysis',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Likelihood And Impact',
            //         "name" => 'Likelihood And Impact',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'All Open Risks Assigne To Me',
            //         "name" => 'All Open Risks Assigne To Me',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Dynamic Risk Report',
            //         "name" => 'Dynamic Risk Report',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Risks and Controls',
            //         "name" => 'Risks and Controls',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Risks and Assets',
            //         "name" => 'Risks and Assets',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'framewrok_control_compliance_status',
            //         "name" => 'Framewrok control compliance status',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'summary_of_results_for_evaluation_and_compliance',
            //         "name" => 'Summary of results for evaluation and compliance',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'security-awareness-exam',
            //         "name" => 'Security awareness exam',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'awareness-survey-info',
            //         "name" => '	Awareness Survey',
            //         "subgroup_id" => 28
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'objectives',
            //         "name" => 'Objectives',
            //         "subgroup_id" => 28
            //     ]);
            // } else if ($mainPermission == 'LDAP.') { // LDAP
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 27
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'test',
            //         "name" => 'test',
            //         "subgroup_id" => 27
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 27
            //     ]);
            // } else if ($mainPermission == 'plan_mitigation.') { // Plan Mitigation
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 19
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'accept',
            //         "name" => 'accept',
            //         "subgroup_id" => 19
            //     ]);
            // } else if ($mainPermission == 'perform_reviews.') { // Perform Reviews
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 20
            //     ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'AbleToReviewInsignificantRisks',
            //     //     "name" => 'AbleToReviewInsignificantRisks',
            //     //     "subgroup_id" => 20
            //     // ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'AbleToReviewLowRisks',
            //     //     "name" => 'AbleToReviewLowRisks',
            //     //     "subgroup_id" => 20
            //     // ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'AbleToReviewMediumRisks',
            //     //     "name" => 'AbleToReviewMediumRisks',
            //     //     "subgroup_id" => 20
            //     // ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'AbleToReviewHighRisks',
            //     //     "name" => 'AbleToReviewHighRisks',
            //     //     "subgroup_id" => 20
            //     // ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'AbleToReviewVeryHighRisks',
            //     //     "name" => 'AbleToReviewVeryHighRisks',
            //     //     "subgroup_id" => 20
            //     // ]);



            // } else if ($mainPermission == 'import_and_export.') {
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 26
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'import',
            //         "name" => 'import',
            //         "subgroup_id" => 26
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 26
            //     ]);
            // } else if ($mainPermission == 'about.') { // About
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 30
            //     ]);
            // } else if ($mainPermission == 'general-setting.') { // general setting
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 32
            //     ]);
            // } else if ($mainPermission == 'services-description.') { // services description
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 33
            //     ]);
            // } else if ($mainPermission == 'email-setting.') { // services description
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 44
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 44
            //     ]);
            // } else if ($mainPermission == 'frame-setting.') { // services description
            //     Permission::create([
            //         "key" => $mainPermission . 'download',
            //         "name" => 'download',
            //         "subgroup_id" => 46
            //     ]);
            // } else if ($mainPermission == 'change-request.') { // change request
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 34
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 34
            //     ]);
            // } else if ($mainPermission == 'change-request-department.') { // change request department
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 35
            //     ]);
            // } else if ($mainPermission == 'KPI.') { // KPI
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 36
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 36
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 36
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 36
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Initiate assessment',
            //         "name" => 'Initiate assessment',
            //         "subgroup_id" => 36
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 36
            //     ]);
            // } else if ($mainPermission == 'document.') { // document
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 3
            //     ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'view',
            //     //     "name" => 'view',
            //     //     "subgroup_id" => 3
            //     // ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 3
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'print',
            //         "name" => 'print',
            //         "subgroup_id" => 3
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 3
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'download',
            //         "name" => 'download',
            //         "subgroup_id" => 3
            //     ]);
            // } else if ($mainPermission == 'security-awareness.') { // Security Awareness
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 37
            //     ]);
            //     // Permission::create([
            //     //     "key" => $mainPermission . 'view',
            //     //     "name" => 'view',
            //     //     "subgroup_id" => 37
            //     // ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 37
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'print',
            //         "name" => 'print',
            //         "subgroup_id" => 37
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 37
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'download',
            //         "name" => 'download',
            //         "subgroup_id" => 37
            //     ]);
            // } else if ($mainPermission == 'awareness-survey.') { // Awareness Survey
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'edit',
            //         "name" => 'edit',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'add_questions',
            //         "name" => 'add question',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'list_questions',
            //         "name" => 'list questions',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'edit_questions',
            //         "name" => 'Edit questions',
            //         "subgroup_id" => 43
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete_questions',
            //         "name" => 'Delete questions',
            //         "subgroup_id" => 43
            //     ]);
            // } else if ($mainPermission == 'templateAssessment.') { // assessment question
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 39
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 39
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'edit',
            //         "name" => 'edit',
            //         "subgroup_id" => 39
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 39
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'questionsAnswer',
            //         "name" => 'questions Answer',
            //         "subgroup_id" => 39
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'questionsEdit',
            //         "name" => 'questions Edit',
            //         "subgroup_id" => 39
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'questionsDelete',
            //         "name" => 'questions Delete',
            //         "subgroup_id" => 39
            //     ]);
            // } else if ($mainPermission == 'assessment.') { // assessment question
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 40
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 40
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'showOption',
            //         "name" => 'Show Option',
            //         "subgroup_id" => 40
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Edit',
            //         "name" => 'Edit',
            //         "subgroup_id" => 40
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Delete',
            //         "name" => 'Delete',
            //         "subgroup_id" => 40
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'Send',
            //         "name" => 'Send',
            //         "subgroup_id" => 40
            //     ]);
            // } else if ($mainPermission == 'assessmentResult.') { // assessment Result
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 41
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'assessmentResult',
            //         "name" => 'Assessment Result',
            //         "subgroup_id" => 41
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'action',
            //         "name" => 'Assessment Action',
            //         "subgroup_id" => 41
            //     ]);
            // } else if ($mainPermission == 'control-objective.') { // Control Objective
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 42
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'view',
            //         "name" => 'view',
            //         "subgroup_id" => 42
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 42
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 42
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 42
            //     ]);

            //     Permission::create([
            //         "key" => $mainPermission . 'print',
            //         "name" => 'print',
            //         "subgroup_id" => 42
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 42
            //     ]);
            // } else if ($mainPermission == 'remidation.') { // remidation
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 48
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 48
            //     ]);
            // } else if ($mainPermission == 'regulator.') { // Control Objective
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 47
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 47
            //     ]);
            // } elseif ($mainPermission == 'campaign.') { // phishing
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'trash',
            //         "name" => 'trash',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'restore',
            //         "name" => 'restore',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 49
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'campaign_approve',
            //         "name" => 'Campaign Approve',
            //         "subgroup_id" => 49
            //     ]);
            // }elseif ($mainPermission == 'website.') { // phishing
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'view',
            //         "name" => 'view',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'trash',
            //         "name" => 'trash',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'restore',
            //         "name" => 'restore',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 50
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 50
            //     ]);

            // }elseif ($mainPermission == 'template.') { // phishing
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 51
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 51
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 51
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'trash',
            //         "name" => 'trash',
            //         "subgroup_id" => 51
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'restore',
            //         "name" => 'restore',
            //         "subgroup_id" => 51
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 51
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 51
            //     ]);

            // }elseif ($mainPermission == 'sender_profile.') { // phishing
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 52
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 52
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 52
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'trash',
            //         "name" => 'trash',
            //         "subgroup_id" => 52
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'restore',
            //         "name" => 'restore',
            //         "subgroup_id" => 52
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'delete',
            //         "name" => 'delete',
            //         "subgroup_id" => 52
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'export',
            //         "name" => 'export',
            //         "subgroup_id" => 52
            //     ]);

            // }
            // elseif ($mainPermission == 'exception.') { // exception
            //     Permission::create([
            //         "key" => $mainPermission . 'list',
            //         "name" => 'list',
            //         "subgroup_id" => 45
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'create',
            //         "name" => 'create',
            //         "subgroup_id" => 45
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'view',
            //         "name" => 'view',
            //         "subgroup_id" => 45
            //     ]);
            //     Permission::create([
            //         "key" => $mainPermission . 'update',
            //         "name" => 'update',
            //         "subgroup_id" => 45
            //     ]);
            // } else {
            //     foreach ($permissionStatuses as $key => $permissionStatus) {
            //         Permission::create([
            //             "key" => $mainPermission . $permissionStatus,
            //             "name" => $permissionStatus,
            //             "subgroup_id" => $mainKey + 1
            //         ]);
            //     }
            //     if ($mainKey == 4) { // Risk
            //         Permission::create([
            //             "key" => $mainPermission . 'AbleToCommentRiskManagement',
            //             "name" => 'AbleToCommentRiskManagement',
            //             "subgroup_id" => $mainKey + 1
            //         ]);
            //         Permission::create([
            //             "key" => $mainPermission . 'AbleToCloseRisks',
            //             "name" => 'AbleToCloseRisks',
            //             "subgroup_id" => $mainKey + 1
            //         ]);
            //     }
            // }
        }
    }
}
