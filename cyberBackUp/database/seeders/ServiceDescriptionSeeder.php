<?php

namespace Database\Seeders;

use App\Models\ServiceDescription;
use Illuminate\Database\Seeder;

class ServiceDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                "route" => "admin.governance.index",
                "name_key" => "Define Control Frameworks",
            ],
            [
                "route" => "admin.governance.control.list",
                "name_key" => "Define Controls",
            ],

            [
                "route" => "admin.governance.category",
                "name_key" => "Documentation",
            ],

            [
                "route" => "admin.risk_management.index",
                "name_key" => "Navbar Risk Management",
            ],

            [
                "route" => "admin.compliance.audit.index",
                "name_key" => "Active Audits",
            ],
            [
                "route" => "admin.compliance.past-audits",
                "name_key" => "Past Audits",
            ],
            
            [
                "route" => "admin.compliance.remidation-request",
                "name_key" => "Remidation Requests",
            ],
            [
                "route" => "admin.asset_management.index",
                "name_key" => "Assets",
            ],
            [
                "route" => "admin.asset_management.asset_group.index",
                "name_key" => "AssetGroups",
            ],

            [
                "route" => "admin.reporting.overviewReport",
                "name_key" => "Overview",
            ],
            [
                "route" => "admin.reporting.riskDashboardReport",
                "name_key" => "Risk Dashboard",
            ],
            [
                "route" => "admin.reporting.controlGapAnalysis",
                "name_key" => "Control Gap Analysis",
            ],
            [
                "route" => "admin.reporting.likelhoodImpactReport",
                "name_key" => "Likelihood And Impact",
            ],
            [
                "route" => "admin.reporting.MyopenRiskReport",
                "name_key" => "All Open Risks Assigned to Me",
            ],
            [
                "route" => "admin.reporting.dynamicRiskReport",
                "name_key" => "Dynamic Risk Report",
            ],
            [
                "route" => "admin.reporting.GetRiskByControl",
                "name_key" => "Risks and Controls",
            ],
            [
                "route" => "admin.reporting.GetRiskByAsset",
                "name_key" => "Risks and Assets",
            ],
            [
                "route" => "admin.reporting.framewrok_control_compliance_status",
                "name_key" => "framewrok_control_compliance_status",
            ],
            [
                "route" => "admin.reporting.summary_of_results_for_evaluation_and_compliance",
                "name_key" => "summary_of_results_for_evaluation_and_compliance",
            ],
            [
                "route" => "admin.reporting.security_awareness_exam",
                "name_key" => "SecurityAwarenessExam",
            ],
            [
                "route" => "admin.configure.user.index",
                "name_key" => "Navbar User Management",
            ],
            [
                "route" => "admin.configure.add_values",
                "name_key" => "Add and Remove Values",
            ],
            [
                "route" => "admin.configure.roles.index",
                "name_key" => "Navbar Role Management",
            ],
            [
                "route" => "admin.configure.riskmodels.show",
                "name_key" => "ClassicRiskFormula",
            ],
            [
                "route" => "admin.configure.logs.index",
                "name_key" => "Audit Trail",
            ],
            [
                "route" => "admin.configure.import.index",
                "name_key" => "Import/Export",
            ],
            [
                "route" => "admin.configure.extras.LDAP-Configuration",
                "name_key" => "LDAP Authentication",
            ],
            [
                "route" => "admin.configure.about.edit",
                "name_key" => "About",
            ],
            [
                "route" => "admin.configure.general_setting.edit",
                "name_key" => "GeneralSettings",
            ],

            [
                "route" => "admin.configure.service_description.edit",
                "name_key" => "ServicesDescription",
            ],
            [
                "route" => "admin.configure.change_request_department.edit",
                "name_key" => "ChangeRequestsResponsibleDepartment",
            ],

            [
                "route" => "admin.hierarchy.index",
                "name_key" => "Hierarchy",
            ],
            [
                "route" => "admin.hierarchy.org_chart",
                "name_key" => "Organization Chart",
            ],
            [
                "route" => "admin.hierarchy.department.index",
                "name_key" => "Department",
            ],
            [
                "route" => "admin.hierarchy.job.index",
                "name_key" => "Job",
            ],

            [
                "route" => "admin.task.index",
                "name_key" => "CreatedTasks",
            ],
            [
                "route" => "admin.task.assigned_to_me",
                "name_key" => "MyTasks",
            ],
            [
                "route" => "admin.vulnerability_management.index",
                "name_key" => "Navbar Vulnerability Management",
            ],
            [
                "route" => "admin.change_request.index",
                "name_key" => "ChangeRequest",
            ],
            [
                "route" => "admin.KPI.index",
                "name_key" => "KPI",
            ],
            [
                "route" => "admin.security_awareness.index",
                "name_key" => "SecurityAwareness",
            ],
        ];

        foreach ($services as $service) {
            ServiceDescription::create([
                'route' => $service['route'],
                'key' => str_replace('.', '_', $service['route']),
                'name_key' => $service['name_key'],
                // 'description' => '{\"ops\":[{\"insert\":\"' . (__('locale.' . $service['name_key'], [], 'en') . ' ' . __('locale.Description', [], 'en')) . '\\\\n\"}]}',
            ]);
        }
    }
}
