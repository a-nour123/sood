<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Document;
use App\Models\DocumentTypes;
use App\Models\Risk;
use App\Models\FrameworkControlTestAudit;
use App\Models\AssetGroup;
use App\Models\AuditDocumentPolicy;
use App\Models\AuditDocumentTotalStatus;
use App\Models\AuditResponsible;
use App\Models\ControlAuditPolicy;
use App\Models\Department;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTest;
use App\Models\Incident;
use App\Models\Job;
use App\Models\PhishingCampaign;
use App\Models\PhishingTemplate;
use App\Models\Team;
use App\Models\IncidentClassify;
use App\Models\IncidentCriteriaScore;
use App\Models\Permission;
use App\Models\RoleResponsibility;
use App\Models\Subgroup;
use App\Models\ThirdPartyProfile;
use App\Models\ThirdPartyQuestionnaire;
use App\Models\ThirdPartyRequest;
use App\Models\User;
use App\Models\Vulnerability;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $path = "admin.content.dashboard";

    public function user_check()
    {

        // phpinfo();

        // $user = User::find(1);
        // $user->update([
        //     'enabled'=>1
        // ]);
        // Artisan::call('config:clear'); // Clear the cached configuration
        // Artisan::call('config:cache'); // Cache the updated configuration
        // Artisan::call('route:clear'); // Cache the updated configuration
        // Artisan::call('optimize:clear'); // Cache the updated configuration


        // $this->setEnvKey('APP_URL', 'https://www.advancedcontrols.sa/grc_v3/public');

        // // Reload the .env variables to reflect the changes in config
        // Artisan::call('config:clear'); // Clear the cached configuration
        // Artisan::call('config:cache'); // Cache the updated configuration

        // dd(config('app.url'));

        // $frame = Framework::find(1);

        // foreach($frame->FrameworkControls as $control){
        //     $audit = FrameworkControlTest::where('framework_control_id' ,$control->id)->get();
        //     foreach($audit as $au){
        //         ControlAuditPolicy::where('framework_control_test_audit_id',$au->id)->delete();
        //     }
        //     FrameworkControlTestAudit::where('framework_control_id' ,$control->id)->delete();
        // }
        // AuditResponsible::where('framework_id',$frame->id)->delete();
        //  // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('settings')->truncate();


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Artisan::call('db:seed', [
            '--class' => 'SettingSeeder',
            '--force' => true,
        ]);

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // // Truncate the table
        // DB::table('permission_groups')->truncate();
        // DB::table('subgroups')->truncate();
        // DB::table('permissions')->truncate();
        // DB::table('permission_to_permission_groups')->truncate();
        // DB::table('role_responsibilities')->truncate();

        // // Re-enable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Artisan::call('db:seed', [
        //     '--class' => 'PermissionGroupSeeder',
        //     '--force' => true,
        // ]);
        // Artisan::call('db:seed', [
        //     '--class' => 'SubGroupSeeder',
        //     '--force' => true,
        // ]);
        // Artisan::call('db:seed', [
        //     '--class' => 'PermissionSeeder',
        //     '--force' => true,
        // ]);
        // Artisan::call('db:seed', [
        //     '--class' => 'PermissionToPermissionGroupSeeder',
        //     '--force' => true,
        // ]);
        // Artisan::call('db:seed', [
        //     '--class' => 'RoleResponsibilitySeeder',
        //     '--force' => true,
        // ]);


        dd('done 33');
    }
    private function setEnvKey($key, $value)
    {
        $envFile = base_path('.env');
        $lines = file($envFile, FILE_IGNORE_NEW_LINES); // Read lines without trimming spaces or empty lines

        $updated = false;

        foreach ($lines as &$line) {
            // Skip empty lines
            if (trim($line) === '') {
                continue;
            }

            // Check if the line starts with the key (ignoring spaces before the key)
            $trimmedLine = trim($line);
            if (strpos($trimmedLine, $key . '=') === 0) {
                $prefix = substr($line, 0, strpos($line, $key)); // Preserve spaces before the key
                $line = $prefix . $key . '=' . $value; // Update the line, preserving formatting
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            // Add the new key-value pair at the end of the file
            $lines[] = $key . '=' . $value;
        }

        // Write back to the file without altering empty lines or formatting
        file_put_contents($envFile, implode(PHP_EOL, $lines) . PHP_EOL);
    }
    public function dashboard()
    {
        $frameworksSelect = Framework::select('id', 'name')->get();
        $breadcrumbs = [['name' => __('locale.Dashboard')]];
        $Frameworks = $this->FrameworksStatistics(); // Get Framework statistics
        $frameworkWithPercentage = array_map(function ($framework) {
            return [
                'name' => $framework['name'], // Return the framework name
                'percentage' => $this->getControlImplementationPercentage($framework['id']) // Calculate the percentage
            ];
        }, $Frameworks['all']->toArray()); // Convert the frameworks collection to an array
        $Controls = $this->ControlsStatistics();
        $Documents = $this->DocumentStatistics();
        $Risks = $this->RiskStatistics();
        $Audits = $this->AuditStatistics();
        $Assets = $this->AssetStatistics();
        $Teams = $this->TeamStatistics();
        $Users = $this->UserStatistics();
        $Departments = $this->DepartmentStatistics();
        $Jobs = $this->JobStatistics();
        $auditData =  $this->getAllStatusForAllFrameworks();
        $groupedByFramework = Helper::GetAllFrameworksAuditGraph();

        $documentComplianceAllStandards = $this->documentComplianceAllStandardsAudit();
        //  $documentCompliance= $this->documentComplianceAudit();
        $table = $this->createTable();
        $openClosedChartData = $this->openClosedChart();


        $campaigns_count = PhishingCampaign::where("campaign_type", '!=', "security_awareness")
            ->withoutTrashed()->count();
        $campaigns_approve = PhishingCampaign::where("campaign_type", '!=', "security_awareness")
            ->withoutTrashed()->where('approve', 1)->count();
        $campaigns_pending = PhishingCampaign::where("campaign_type", '!=', "security_awareness")
            ->where('approve', 0)
            ->withoutTrashed()->count();
        $campaigns_complete = PhishingCampaign::where("campaign_type", '!=', "security_awareness")
            ->withoutTrashed()->where('delivery_type', 'immediatly')->where('approve', 1)->count();
        $campaigns_later = PhishingCampaign::where("campaign_type", '!=', "security_awareness")
            ->withoutTrashed()->where('delivery_type', 'later')->where('approve', 1)->count();
        $now = Carbon::now();
        $campaigns_soon = PhishingCampaign::withoutTrashed()
            ->where('delivery_type', 'setup')
            ->where("campaign_type", '!=', "security_awareness")
            ->where(function ($query) use ($now) {
                $query->where('schedule_date_from', '>', $now->toDateString())
                    ->orWhere(function ($query) use ($now) {
                        $query->where('schedule_date_from', '=', $now->toDateString())
                            ->where('schedule_time_from', '>', $now->toTimeString());
                    });
            })
            ->count();

        $mail_statistic = PhishingCampaign::withoutTrashed()
            ->with(['emailTemplates' => function ($query) {
                $query->withCount([
                    'openedMails',         // Counting opened mails
                    'submitedDataInMails', // Counting mails with submitted data
                    'downloadedFileInMails', // Counting mails with downloaded files
                    'mailTracking',        // Counting mail tracking entries
                    'clickedOnLink'
                ]);
            }])->where("campaign_type", '!=', "security_awareness")
            ->get()
            ->map(function ($campaign) {
                // Aggregate counts from emailTemplates for each campaign and default to 0 if null
                $campaign->opened_mails_count = $campaign->emailTemplates->sum('opened_mails_count') ?? 0;
                $campaign->submitted_data_in_mails_count = $campaign->emailTemplates->sum('submited_data_in_mails_count') ?? 0;
                $campaign->downloaded_file_in_mails_count = $campaign->emailTemplates->sum('downloaded_file_in_mails_count') ?? 0;
                $campaign->mail_tracking_count = $campaign->emailTemplates->sum('mail_tracking_count') ?? 0;
                // $campaign->clicked_link_count = $campaign->emailTemplates->sum('clicked_on_link_count') ?? 0;


                return $campaign;
            });

        // Ensure the pluck calls do not contain null values by setting defaults
        $email_labels = $mail_statistic->pluck('campaign_name');
        $opened_mails_count = $mail_statistic->pluck('opened_mails_count')->map(fn($count) => $count ?? 0);
        $submited_data_in_mails_count = $mail_statistic->pluck('submitted_data_in_mails_count')->map(fn($count) => $count ?? 0);
        $downloaded_file_in_mails_count = $mail_statistic->pluck('downloaded_file_in_mails_count')->map(fn($count) => $count ?? 0);

        // $clicked_link_in_mails_count = $mail_statistic->pluck('clicked_on_link_count')->map(fn($count) => $count ?? 0);

        $openClosedChartType = $openClosedChartData['type'];
        $openClosedChartNumber = $openClosedChartData['number'];

        $openMitigationChartData = $this->openMitigationChart();

        $openMitigationChartType = $openMitigationChartData['type'];
        $openMitigationChartNumber = $openMitigationChartData['number'];

        $openReviewChartData = $this->openReviewChart();

        $openReviewChartType = $openReviewChartData['type'];
        $openReviewChartNumber = $openReviewChartData['number'];
        $vulns = $this->GetStaticsVuln();

        $incident_count = Incident::count();
        $open_incident_count = Incident::where('status', 'open')->count();
        $progress_incident_count = Incident::where('status', 'progress')->count();
        $closed_incident_count = Incident::where('status', 'closed')->count();


        $priorityData = [];

        // Fetch all incidents
        $incidents = Incident::all();

        foreach ($incidents as $incident) {
            // Calculate the total score for the incident
            $totalScore = $this->calculateTotalScore($incident);

            // Find the matching classification based on the total score
            $classify = IncidentClassify::where('value', '>=', $totalScore)
                ->orderBy('value', 'asc')
                ->first();

            if ($classify) {
                // Initialize the classification if it doesn't exist
                if (!isset($priorityData[$classify->id])) {
                    $priorityData[$classify->id] = [
                        'open' => 0,
                        'progress' => 0,
                        'closed' => 0,
                        'colors' => [
                            'open' => $classify->color,     // Color for Open status
                            'progress' => $classify->color, // Color for Progress status
                            'closed' => $classify->color,   // Color for Closed status
                        ],
                    ];
                }

                // Increment the status count for the classification
                $priorityData[$classify->id][$incident->status]++;
            }
        }

        $chartData = [
            'categories' => ['Open', 'Progress', 'Closed'],  // Categories are the statuses
            'series' => []
        ];


        foreach ($priorityData as $priority => $counts) {
            $classify = IncidentClassify::find($priority);  // Fetch the classification by ID
            if ($classify) {
                $chartData['series'][] = [
                    'name' =>  $classify->priority,  // Add classification name to series
                    'color' => $classify->color,
                    'data' => [
                        [
                            'y' => $counts['open'],      // 'y' for "Open" status
                            'color' => $counts['open'] > 0 ? $classify->color : '#808080', // Color for "Open" status
                        ],
                        [
                            'y' => $counts['progress'],  // 'y' for "Progress" status
                            'color' => $counts['progress'] > 0 ? $classify->color : '#808080', // Color for "Progress" status
                        ],
                        [
                            'y' => $counts['closed'],    // 'y' for "Closed" status
                            'color' => $counts['closed'] > 0 ? $classify->color : '#808080', // Color for "Closed" status
                        ],
                    ],
                ];
            } else {

                $chartData['series'][] = [
                    'name' => $priority . ' (Unknown)',
                    'data' => [
                        [
                            'y' => $counts['open'],      // 'y' for "Open" status
                            'color' => '#808080',        // Default color for unknown classifications
                        ],
                        [
                            'y' => $counts['progress'],  // 'y' for "Progress" status
                            'color' => '#808080',        // Default color for unknown classifications
                        ],
                        [
                            'y' => $counts['closed'],    // 'y' for "Closed" status
                            'color' => '#808080',        // Default color for unknown classifications
                        ],
                    ],

                ];
            }
        }

        $thirdPartyData = $this->getThirdPartyStatics();

        return view(
            $this->path,
            compact(
                'breadcrumbs',
                'chartData',
                'incident_count',
                'open_incident_count',
                'progress_incident_count',
                'closed_incident_count',
                'Frameworks',
                'Controls',
                'vulns',
                'Documents',
                'Risks',
                'Audits',
                'Assets',
                'Teams',
                'Users',
                'Departments',
                'Jobs',
                'frameworksSelect',
                'frameworkWithPercentage',
                'auditData',
                'groupedByFramework',
                'documentComplianceAllStandards',

                'campaigns_count',
                'campaigns_later',
                'campaigns_approve',
                'campaigns_pending',
                'campaigns_complete',
                'campaigns_soon',
                'email_labels',
                'opened_mails_count',
                'submited_data_in_mails_count',
                'downloaded_file_in_mails_count',
                // 'clicked_link_in_mails_count',
                'table',
                'openClosedChartType',
                'openClosedChartNumber',
                'openMitigationChartType',
                'openMitigationChartNumber',
                'openReviewChartType',
                'openReviewChartNumber',
                'thirdPartyData'

            )
        );
    }
    function openReviewChart()
    {
        $array = DB::select("SELECT id, CASE WHEN mgmt_review IS NULL THEN 'Unreviewed' WHEN mgmt_review IS NOT NULL THEN 'Reviewed' END AS name FROM `risks` WHERE status != \"Closed\" ORDER BY name");
        // Set the defaults
        $current_type = "";
        $grouped_array = array();
        $counter = -1;
        $data = array();
        foreach ($array as $row) {
            // If the row name is not the current row
            if ($row->name != $current_type) {
                // Increment the counter
                $counter = $counter + 1;

                // Add the value to the grouped array
                $grouped_array[$counter]['name'] = $row->name;
                $grouped_array[$counter]['num'] = 1;

                // Set the current type
                $current_type = $row->name;
            } else {
                if (!isset($grouped_array[$counter]['num'])) {
                    $grouped_array[$counter]['num'] = 0;
                }

                // Add the value to the grouped array
                $grouped_array[$counter]['name'] = $row->name;
                $grouped_array[$counter]['num'] = $grouped_array[$counter]['num'] + 1;
            }
        }

        $array = $grouped_array;

        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Create the data array
            foreach ($array as $row) {
                $data[] = array($row['name'], (int) $row['num']);

                if ($row['name'] == "Reviewed") {
                    $color_array[] = "green";
                } else if ($row['name'] == "Unreviewed") {
                    $color_array[] = "red";
                }
            }
        }

        $openReviewChartDataType = array();
        $openReviewChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openReviewChartDataType, $item[0]);
            array_push($openReviewChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openReviewChartDataType),
            'number' => implode(",", $openReviewChartDataNumper),

        );
    }
    public function createTable()
    {
        $table = "";

        // Get the opened risks array by month
        $opened_risks = $this->getOpenedRisksArray();
        $open_date = $opened_risks[0];
        $open_count = $opened_risks[1];

        // Get the closed risks array by month
        $closed_risks = $this->getClosedRisksArray();
        $close_date = $closed_risks[0];
        $close_count = $closed_risks[1];

        $table .= '<table class="table">';
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th></th>";

        // For each of the past 12 months
        for ($i = 12; $i >= 0; $i--) {
            // Get the month
            $month = date('Y M', strtotime("first day of -$i month"));

            $table .= "<th>" . $month . "</th>";
        }
        $table .= "</tr>";
        $table .= "</thead>";

        $table .= "<tbody>";
        $table .= "<tr >";
        $table .= "<td >" . __('report.OpenedRisks') . "</td>";

        // For each of the past 12 months
        for ($i = 12; $i >= 0; $i--) {
            // Get the month
            $month = date('Y-m', strtotime("first day of -$i month"));

            // Search the open risks array
            $key = array_search($month, $open_date);

            // If no result was found or the key is null
            if ($key === false || is_null($key)) {
                // Set the value to 0
                $open[$i] = 0;
            }
            // Otherwise, use the value found
            else {
                $open[$i] = $open_count[$key];
            }

            $table .= "<td >" . $open[$i] . "</td>";
        }

        $table .= "</tr>";
        $table .= "<tr >";
        $table .= "<td >" . __('locale.ClosedRisks') . "</td>";

        // For each of the past 12 months
        for ($i = 12; $i >= 0; $i--) {
            // Get the month
            $month = date('Y-m', strtotime("first day of -$i month"));

            // Search the closed risks array
            $key = array_search($month, $close_date);

            // If no result was found or the key is null
            if ($key === false || is_null($key)) {
                // Set the value to 0
                $close[$i] = 0;
            }
            // Otherwise, use the value found
            else {
                $close[$i] = $close_count[$key];
            }

            $table .= "<td >" . $close[$i] . "</td>";
        }

        $table .= "</tr>";
        $table .= "<tr >";
        $table .= "<td >" . __('locale.RiskTrend') . "</td>";

        // For each of the past 12 months
        for ($i = 12; $i >= 0; $i--) {
            // Subtract the open number from the closed number
            $total[$i] = $open[$i] - $close[$i];

            // If the total is positive
            if ($total[$i] > 0) {
                // Display it in red
                $total_string = "<font color=\"red\">+" . $total[$i] . "</font>";
            }
            // If the total is negative
            else if ($total[$i] < 0) {
                // Display it in green
                $total_string = "<font color=\"green\">" . $total[$i] . "</font>";
            }
            // Otherwise the total is 0
            else {
                $total_string = $total[$i];
            }

            $table .= "<td >" . $total_string . "</td>";
        }

        // Reverse the total array
        $total = array_reverse($total);

        // Get the number of open risks
        $open_risks_today = $this->getOpenRisks();

        // Start the total open risks array with the open risks today
        $total_open_risks[] = $open_risks_today;

        // For each of the past 12 months
        for ($i = 1; $i <= 12; $i++) {
            $total_open_risks[$i] = $total_open_risks[$i - 1] - $total[$i - 1];
        }

        // Reverse the total open risks array
        $total_open_risks = array_reverse($total_open_risks);

        $table .= "</tr>";
        $table .= "<tr >";
        $table .= "<td >" . __('locale.CurrentOpenRisks') . "</td>";

        // For each of the past 12 months
        for ($i = 0; $i <= 12; $i++) {
            // Get the total number of risks
            $total = $total_open_risks[$i];
            $table .= "<td >" . $total . "</td>";
        }
        $table .= "</tr>";
        $table .= "</tbody>";
        $table .= "</table>";
        return $table;
    }
    public function openMitigationChart()
    {
        // Query the database
        $array = DB::select("SELECT id, CASE WHEN mitigation_id IS NULL THEN 'Unplanned' WHEN mitigation_id IS NOT NULL THEN 'Planned' END AS name FROM `risks` WHERE status != \"Closed\" ORDER BY name");
        // Set the defaults
        $current_type = "";
        $grouped_array = array();
        $counter = -1;
        $data = array();

        foreach ($array as $row) {
            // If the row name is not the current row
            if ($row->name != $current_type) {
                // Increment the counter
                $counter = $counter + 1;
                // Add the value to the grouped array
                $grouped_array[$counter]['name'] = $row->name;
                $grouped_array[$counter]['num'] = 1;

                // Set the current type
                $current_type = $row->name;
            } else {
                if (!isset($grouped_array[$counter]['num'])) {
                    $grouped_array[$counter]['num'] = 0;
                }
                // Add the value to the grouped array
                $grouped_array[$counter]['name'] = $row->name;
                $grouped_array[$counter]['num'] = $grouped_array[$counter]['num'] + 1;
            }
        }

        $array = $grouped_array;

        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Create the data array
            foreach ($array as $row) {
                $data[] = array($row['name'], (int) $row['num']);

                if ($row['name'] == "Planned") {
                    $color_array[] = "green";
                } else if ($row['name'] == "Unplanned") {
                    $color_array[] = "red";
                }
            }
        }

        $openMitigationChartDataType = array();
        $openMitigationChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openMitigationChartDataType, $item[0]);
            array_push($openMitigationChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openMitigationChartDataType),
            'number' => implode(",", $openMitigationChartDataNumper),

        );
    }
    public function getOpenedRisksArray()
    {
        $array = DB::select("SELECT id, submission_date FROM risks ORDER BY submission_date;");
        // Set the defaults
        $counter = -1;
        $current_date = "";
        $open_date = array();
        $open_count = array();
        $open_total = array();

        // For each row
        foreach ($array as $key => $row) {

            $date = date('Y-m', strtotime($row->submission_date));

            // If the date is different from the current date
            if ($current_date != $date) {
                // Increment the counter
                $counter = $counter + 1;

                // Set the current date
                $current_date = $date;

                // Add the date
                $open_date[$counter] = $current_date;

                // Set the open count to 1
                $open_count[$counter] = 1;

                // If this is the first entry
                if ($counter == 0) {
                    // Set the open total to 1
                    $open_total[$counter] = 1;
                }
                // Otherwise, add the value of this row to the previous value
                else {
                    $open_total[$counter] = $open_total[$counter - 1] + 1;
                }
            }
            // Otherwise, if the date is the same
            else {
                // Increment the open count
                $open_count[$counter] = $open_count[$counter] + 1;

                // Update the open total
                $open_total[$counter] = $open_total[$counter] + 1;
            }
        }

        // Return the open date array
        return array($open_date, $open_count);
    }

    public function getClosedRisksArray()
    {
        $array = DB::select("
            SELECT t1.id, IFNULL(t2.closure_date, NOW()) closure_date, t1.status
            FROM `risks` t1 LEFT JOIN `closures` t2 ON t1.close_id=t2.id
            WHERE t1.status='Closed'
            ORDER BY IFNULL(t2.closure_date, NOW());
        ");

        // Set the defaults
        $counter = -1;
        $current_date = "";
        $close_date = array();
        $close_count = array();
        $close_total = array();

        // For each row
        foreach ($array as $key => $row) {

            // Set the date to the month
            // $date = date('Y-m', strtotime($row['closure_date']));
            $date = date('Y-m', strtotime($row->closure_date));

            // If the date is different from the current date
            if ($current_date != $date) {
                // Increment the counter
                $counter = $counter + 1;

                // Set the current date
                $current_date = $date;

                // Add the date
                $close_date[$counter] = $current_date;

                // Set the close count to 1
                $close_count[$counter] = 1;

                // If this is the first entry
                if ($counter == 0) {
                    // Set the close total to 1
                    $close_total[$counter] = 1;
                }
                // Otherwise, add the value of this row to the previous value
                else {
                    $close_total[$counter] = $close_total[$counter - 1] + 1;
                }
            }
            // Otherwise, if the date is the same
            else {
                // Increment the closed count
                $close_count[$counter] = $close_count[$counter] + 1;

                // Update the close total
                $close_total[$counter] = $close_total[$counter] + 1;
            }
        }

        // Return the close date array
        return array($close_date, $close_count);
    }
    public function getOpenRisks()
    {
        $sql = "
            SELECT
                `rsk`.`id`
            FROM
                `risks` rsk
                LEFT JOIN `risk_to_teams` rtt ON `rsk`.`id`=`rtt`.`risk_id`
            WHERE
                `rsk`.`status` != 'Closed'
            GROUP BY
                `rsk`.`id`;";
        // Query the database
        $array = DB::select($sql);
        return count($array);
    }
    public function openClosedChart()
    {
        // Query the database
        $array = DB::select("SELECT id, CASE WHEN status = \"Closed\" THEN 'Closed' WHEN status != \"Closed\" THEN 'Open' END AS name FROM `risks` ORDER BY name");
        // Set the defaults
        $current_type = "";
        $grouped_array = array();
        $counter = -1;
        foreach ($array as $row) {
            // If the row name is not the current row
            if ($row->name != $current_type) {
                // Increment the counter
                $counter = $counter + 1;

                // Add the value to the grouped array
                $grouped_array[$counter]['name'] = $row->name;
                $grouped_array[$counter]['num'] = 1;

                // Set the current type
                $current_type = $row->name;
            } else {
                if (!isset($grouped_array[$counter]['num'])) {
                    $grouped_array[$counter]['num'] = 0;
                }

                // Add the value to the grouped array
                $grouped_array[$counter]['name'] = $row->name;
                $grouped_array[$counter]['num'] = $grouped_array[$counter]['num'] + 1;
            }
        }
        $array = $grouped_array;
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Create the data array
            foreach ($array as $row) {
                $data[] = array($row['name'], (int) $row['num']);

                if ($row['name'] == "Closed") {
                    $color_array[] = "green";
                } else if ($row['name'] == "Open") {
                    $color_array[] = "red";
                }
            }
        }
        $openClosedChartDataType = array();
        $openClosedChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openClosedChartDataType, $item[0]);
            array_push($openClosedChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openClosedChartDataType),
            'number' => implode(",", $openClosedChartDataNumper),

        );
    }


    private function calculateTotalScore($incident)
    {
        // Fetch data directly from the `incident_criteria_scores` and `incident_scores` tables
        $criteriaScores = DB::table('incident_criteria_scores as ics')
            ->join('incident_scores as is', 'ics.incident_score_id', '=', 'is.id')
            ->where('ics.incident_id', $incident->id)
            ->sum('is.point');


        return $criteriaScores;
    }



    public function FrameworksStatistics()
    {
        return array(
            'count' => Framework::count(),
            'all' => Framework::get()
        );
    }
    public function ControlsStatistics()
    {
        return array(
            'count' => FrameworkControl::count(),
            'active' => FrameworkControl::Where('status', 1)->get()->count(),
            'close' => FrameworkControl::Where('status', 0)->get()->count(),
            'all' => FrameworkControl::limit(5)->get()
        );
    }
    public function DocumentStatistics()
    {
        return array(
            'count' => Document::count(),
            'DocumentTypes' => DocumentTypes::limit(5)->get()

        );
    }
    public function RiskStatistics()
    {
        return array(
            'count' => Risk::count(),
            'Open' => Risk::Where('status', '!=', 'Closed')->get()->count(),
            'Close' => Risk::Where('status', 'Closed')->get()->count(),

        );
    }
    public function AuditStatistics()
    {
        return array(
            'count' => FrameworkControlTestAudit::count(),
            'active' => FrameworkControlTestAudit::where('status', '!=', 5)->get()->count(),
            'past' => FrameworkControlTestAudit::where('status', 5)->get()->count(),
        );
    }
    public function AssetStatistics()
    {
        return array(
            'count' => Asset::count(),
            'Groupcount' => AssetGroup::count(),
        );
    }
    public function TeamStatistics()
    {
        return array(
            'count' => Team::count(),
        );
    }
    public function UserStatistics()
    {
        return array(
            'count' => User::count(),
            'active' => User::where('enabled', 1)->get()->count(),
            'deactive' => User::where('enabled', 0)->get()->count(),
            'ldap' => User::where('type', 'ldap')->get()->count(),
            'grc' => User::where('type', 'grc')->get()->count(),
        );
    }
    public function DepartmentStatistics()
    {
        return array(
            'count' => Department::count(),
        );
    }
    public function JobStatistics()
    {
        return array(
            'count' => Job::count(),
        );
    }
    private function getControlImplementationPercentage($frameworkId)
    {
        $controlIds = FrameworkControl::select('framework_controls.*')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->pluck('id')
            ->toArray();

        $numcontrolIds = count($controlIds);
        $existingIds = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->distinct()
            ->pluck('framework_control_id')
            ->toArray();

        $nonExistingIds = array_diff($controlIds, $existingIds);
        $childIds = FrameworkControl::whereIn('parent_id', $nonExistingIds)
            ->selectRaw('MIN(id) as first_child_id')
            ->groupBy('parent_id')
            ->pluck('first_child_id')
            ->toArray();

        $latestAuditTestNumber = FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) AS first_test_number")
            ->orderBy('created_at', 'desc') // Order by latest date
            ->distinct()
            ->first();

        // Wrap the latest test number in an array if a record is found
        $auditsTestNumbers = $latestAuditTestNumber ? [$latestAuditTestNumber->first_test_number] : [];

        $encounteredTestNumbers = [];
        $countsByTestNumber = [];

        foreach ($auditsTestNumbers as $testNumber) {
            if (!in_array($testNumber, $encounteredTestNumbers)) {
                $encounteredTestNumbers[] = $testNumber;
                $auditCountAll = 0;

                if (in_array($testNumber, $auditsTestNumbers)) {
                    $childStatus = "Implemented";
                    $auditCountAll += FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->orWhereIn('framework_control_id', $childIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->count();
                }

                // Add percentage to countsByTestNumber
                $countsByTestNumber[] = [
                    'percentage' => number_format(($auditCountAll * 100) / $numcontrolIds, 2)
                ];
            }
        }

        // Return only the first percentage (if available) or 0.00
        return count($countsByTestNumber) > 0 ? $countsByTestNumber[0]['percentage'] : '0.00';
    }

    public function GetFrameworkAuditGraph(Request $request)
    {
        $frameworkId = $request->input('framework_id');
        $testNumbers = AuditResponsible::where('framework_id', $frameworkId)->pluck('test_number_initiated')->toArray();

        // Get control IDs associated with the framework
        $controlIds = FrameworkControl::select('framework_controls.*')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->pluck('id')
            ->toArray();

        $numcontrolIds = count($controlIds);

        // Get existing control IDs in FrameworkControlTestAudit
        $existingIds = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->distinct()
            ->pluck('framework_control_id')
            ->toArray();

        // Get non-existing control IDs (those not found in FrameworkControlTestAudit)
        $nonExistingIds = array_diff($controlIds, $existingIds);

        // Get the first child control ID for each non-existing parent control ID
        $childIds = FrameworkControl::whereIn('parent_id', $nonExistingIds)
            ->selectRaw('MIN(id) as first_child_id')
            ->groupBy('parent_id')
            ->pluck('first_child_id')
            ->toArray();

        // Define the statuses you want to include in the result
        $statuses = ["Implemented", "Partially Implemented", "Not Implemented", "Not Applicable"];

        $groupedByTestNumber = []; // Initialize array to group results by test number

        // Loop through each testNumber and calculate the counts and percentages
        foreach ($testNumbers as $testNumber) {
            $statusCounts = []; // Initialize array for each test number's statuses
            foreach ($statuses as $status) {
                $auditName = AuditResponsible::where('test_number_initiated', $testNumber)
                    ->where('framework_id', $frameworkId)
                    ->value('audit_name');
                // Get count for testNumber and status
                $auditCountAll = FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                    ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                    ->where(function ($query) use ($status) {
                        $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $status);
                    })
                    ->orWhereIn('framework_control_id', $childIds)
                    ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                    ->where(function ($query) use ($status) {
                        $query->Where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $status);
                    })
                    ->count();

                // Add the result to the $statusCounts array for the current test number
                $statusCounts[] = [
                    'status_name' => $status,
                    'count' => $auditCountAll,
                    'percentage' => $numcontrolIds > 0 ? number_format($auditCountAll * 100 / $numcontrolIds, 2) : 0,
                    'total_controls' => $numcontrolIds
                ];
            }

            // Add the test number and its statuses to the $groupedByTestNumber array
            $groupedByTestNumber[] = [
                'test_number' => $auditName, // Use audit name instead of test number
                'statuses' => $statusCounts
            ];
        }

        // Encode the results into JSON and return them
        return response()->json(['groupedByTestNumber' => $groupedByTestNumber]);
    }
    private function getAllStatusForAllFrameworks()
    {
        // Fetch all frameworks
        $frameworks = Framework::all();
        $auditData = [];

        foreach ($frameworks as $framework) {
            // Get test numbers for the current and previous audits
            $controlId = FrameworkControlMapping::where('framework_id', $framework->id)->latest()->first()->framework_control_id ?? Null;
            $testNumbers = FrameworkControlTestAudit::where('framework_control_id', $controlId)
                ->select(DB::raw("DISTINCT JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) as test_number"))
                ->orderBy('test_number', 'desc')
                ->limit(2) // Limit to two (current and previous)
                ->pluck('test_number')
                ->toArray();
            $currentTestNumber = $testNumbers[0] ?? null;
            $previousTestNumber = $testNumbers[1] ?? null;

            $auditData[$framework->id] = [
                'framework' => $framework,
                'currentAuditData' => $currentTestNumber ? $this->getAllStatusForAduit($currentTestNumber, $framework->id) : null,
                'previousAuditData' => $previousTestNumber ? $this->getAllStatusForAduit($previousTestNumber, $framework->id) : null,
            ];
        }

        return $auditData;
    }
    private function getAllStatusForAduit($testNumber, $frameworkId)
    {
        // Step 1: Fetch all relevant control IDs along with their children (if any)
        $controls = FrameworkControl::select('framework_controls.id', 'framework_controls.parent_id')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->with('frameworkControls')  // Assuming 'frameworkControls' is the relationship for children
            ->get();

        $parentWithChildren = [];
        $parentWithoutChildren = [];

        // Step 2: Classify controls as having children or not
        foreach ($controls as $control) {
            if ($control->frameworkControls->isNotEmpty()) {
                // Replace with first child
                $firstChildId = $control->frameworkControls->first()->id;
                $parentWithChildren[] = $firstChildId;
            } else {
                $parentWithoutChildren[] = $control->id; // Otherwise, add parent as without children
            }
        }

        // Step 3: Query to get the implemented count for controls with children
        $auditCountChildren = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithChildren)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) = ?", [$testNumber])
            ->whereRaw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented') = 'Implemented'")
            ->count();

        // Step 4: Query to get the implemented count for controls without children
        $auditCountParents = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithoutChildren)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) = ?", [$testNumber])
            ->whereRaw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented') = 'Implemented'")
            ->count();
        // Step 5: Calculate totals
        $totalControls = count($parentWithChildren) + count($parentWithoutChildren);
        $totalImplemented = $auditCountChildren + $auditCountParents;
        $percentage = $totalControls > 0 ? number_format($totalImplemented * 100 / $totalControls, 2) : 0;

        // Return the result with separate and combined counts
        return [
            'test_number' => $testNumber ?? 0,
            'status_name' => 'Implemented',
            'child_count' => $auditCountChildren ?? 0,
            'parent_count' => $auditCountParents ?? 0,
            'total_count' => $totalImplemented ?? 0,
            'percentage' => $percentage,
            'total_controls' => $totalControls ?? 0,
        ];
    }

    public function documentComplianceAudit()
    {
        // Step 1: Get all document IDs that exist in the AuditDocumentPolicy with enable_audit = 1
        $enabledDocumentIds = AuditDocumentPolicy::where('enable_audit', 1)
            ->pluck('document_id')
            ->toArray();

        // Step 2: Fetch only the documents that exist in AuditDocumentPolicy with enable_audit = 1
        $documents = Document::whereIn('id', $enabledDocumentIds)
            ->select('id', 'document_name')
            ->get();

        // Get all unique regions from the User model
        $regions = User::distinct()->pluck('ldap_region')->toArray();

        // Initialize an empty array to hold the results
        $auditData = [];

        // Initialize a set to track regions with relevant users
        $regionsWithUsers = [];

        // Loop through each document
        foreach ($documents as $document) {
            // Loop through each region
            foreach ($regions as $region) {
                // Fetch user IDs for the current region
                $users = User::where('ldap_region', $region)->pluck('id')->toArray();

                // Fetch the audits where document_id matches and enable_audit is 1
                $audits = AuditDocumentPolicy::where('document_id', $document->id)
                    ->where('enable_audit', 1)
                    ->get();

                // Initialize status counts
                $statusCounts = [
                    'Implemented' => 0,
                    'Partially Implemented' => 0,
                    'Not Implemented' => 0,
                    'Not Applicable' => 0,
                    'No Action' => 0,
                ];

                // Loop through each audit
                foreach ($audits as $audit) {
                    // Get responsible IDs from the comma-separated string and convert to an array
                    $responsibleIds = explode(',', $audit->responsible);

                    // Retrieve the responsible users directly
                    $responsibles = User::whereIn('id', $responsibleIds)->pluck('id')->toArray();

                    // Find common IDs in both arrays (users in the region and responsible users)
                    $commonIds = array_intersect($users, $responsibles);

                    // If there are common IDs, we track the region
                    if (!empty($commonIds)) {
                        $regionsWithUsers[$region] = true;

                        // Fetch policies and their statuses for the specified audit and users
                        $policies = AuditDocumentTotalStatus::where('audit_id', $audit->id)
                            ->where('document_id', $audit->document_id)
                            ->whereIn('user_id', $commonIds)
                            ->get();

                        // Initialize user statuses
                        $userStatuses = array_fill_keys($commonIds, 'Not Implemented'); // Default to 'Not Implemented'

                        // Loop through policies and update user statuses
                        foreach ($policies as $policy) {
                            $status = $policy->total_status;

                            // Treat 'No Action' as 'Not Implemented'
                            if ($status === 'No Action') {
                                $status = 'Not Implemented';
                            }

                            // Update the user status
                            $userStatuses[$policy->user_id] = $status;
                        }

                        // Count statuses based on userStatuses
                        foreach ($userStatuses as $status) {
                            $statusCounts[$status]++;
                        }
                    }
                }

                // Calculate overall status based on counts
                $overallStatus = $this->determineOverallStatus($statusCounts);

                // Prepare the data to include region and total status under the document name
                if (!empty($commonIds)) {
                    $auditData[$document->document_name]['regions'][] = [
                        'region' => $region ?? "No Region",
                        'overall_status' => $overallStatus
                    ];
                }
            }
        }

        // Filter out regions that don't have any common users
        $filteredAuditData = array_filter($auditData, function ($data) {
            return !empty($data['regions']);
        });

        // Return the audit data as JSON response
        return response()->json($filteredAuditData);
    }
    private function documentComplianceAllStandardsAudit()
    {
        // Fetch all documents
        $documents = Document::select('id', 'document_name')->get();

        // Initialize total status counts
        $totalStatusCounts = [
            'Implemented' => 0,
            'Partially Implemented' => 0,
            'Not Implemented' => 0,
            'Not Applicable' => 0,
        ];

        $totalDocument = count($documents);

        // Loop through each document
        foreach ($documents as $document) {
            // Fetch audits for the document with enable_audit = 1
            $audits = AuditDocumentPolicy::where('document_id', $document->id)
                ->where('enable_audit', 1)
                ->get();

            // Temporary status counts for this document
            $documentStatusCounts = [
                'Implemented' => 0,
                'Partially Implemented' => 0,
                'Not Implemented' => 0,
                'Not Applicable' => 0,
            ];

            // Track if any status was found
            $statusFound = false;

            // Loop through each audit
            foreach ($audits as $audit) {
                // Fetch responsible IDs
                $responsibleIds = explode(',', $audit->responsible);
                $responsibles = User::whereIn('id', $responsibleIds)->pluck('id')->toArray();

                // Loop through each responsible user for this document
                foreach ($responsibles as $userId) {
                    // Fetch the policy status for the user; default to 'Not Implemented' if not found
                    $policyStatus = AuditDocumentTotalStatus::where('audit_id', $audit->id)
                        ->where('document_id', $audit->document_id)
                        ->where('user_id', $userId)
                        ->value('total_status');

                    // Increment the corresponding status count if found
                    if ($policyStatus) {
                        $documentStatusCounts[$policyStatus]++;
                        $statusFound = true; // Mark that we found a status
                    }
                }
            }

            // If no statuses were found, consider it 'Not Implemented'
            if (!$statusFound) {
                $documentStatusCounts['Not Implemented']++;
            }

            // Determine the overall status for the document based on all user statuses
            $overallStatus = $this->determineOverallStatus($documentStatusCounts);

            // Add document's overall status to total status counts
            $totalStatusCounts[$overallStatus]++;
        }

        // Calculate percentages based on total status counts
        $percentageCounts = [];
        foreach ($totalStatusCounts as $status => $count) {
            $percentageCounts[$status] = $totalDocument > 0 ? ($count / $totalDocument) * 100 : 0;
        }

        // Prepare final data array
        $documentComplianceAllStandards = [
            'total_counts' => $totalStatusCounts,
            'percentages' => $percentageCounts,
            'totaldocument' => $totalDocument,
        ];
        return $documentComplianceAllStandards;
    }


    private function determineOverallStatus(array $statusCounts)
    {
        $totalCount = array_sum($statusCounts);

        if ($totalCount === 0) {
            return 'No Action'; // Default case if there are no statuses
        }

        // Determine overall status based on counts
        if ($statusCounts['Implemented'] === $totalCount) {
            return 'Implemented';
        } elseif ($statusCounts['Partially Implemented'] === $totalCount) {
            return 'Partially Implemented';
        } elseif ($statusCounts['Not Implemented'] === $totalCount) {
            return 'Not Implemented';
        } elseif ($statusCounts['Not Applicable'] === $totalCount) {
            return 'Not Applicable';
        }

        return 'Partially Implemented'; // Default for mixed status case
    }
    private function GetStaticsVuln()
    {
        // Retrieve the vulnerability counts for each status
        $vuln = Vulnerability::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status'); // Key by 'status' for direct access

        // Total count of all vulnerabilities
        $totalVulns = Vulnerability::count();

        // Prepare the vulnerability information array with percentages
        $openVuln = $vuln->get('Open')->count ?? 0;
        $closedVuln = $vuln->get('Closed')->count ?? 0;
        $progressVuln = $vuln->get('In Progress')->count ?? 0;

        return [
            'openVulnerability' => [
                'count' => $openVuln,
                'percentage' => $totalVulns > 0 ? round(($openVuln / $totalVulns) * 100, 2) : 0,
            ],
            'closedVulnerability' => [
                'count' => $closedVuln,
                'percentage' => $totalVulns > 0 ? round(($closedVuln / $totalVulns) * 100, 2) : 0,
            ],
            'progressVulnerability' => [
                'count' => $progressVuln,
                'percentage' => $totalVulns > 0 ? round(($progressVuln / $totalVulns) * 100, 2) : 0,
            ],
            'overview' => $totalVulns,
        ];
    }

    private function getThirdPartyStatics()
    {
        $thirdPartyProfiles = ThirdPartyProfile::pluck('id');
        $thirdPartyRequests = ThirdPartyRequest::pluck('id');
        $thirdPartyAssessments = ThirdPartyQuestionnaire::pluck('id');

        $evaluatedThirdParty = ThirdPartyProfile::query()
            ->join('third_party_requests as request', 'request.third_party_profile_id', '=', 'third_party_profiles.id')
            ->join('third_party_questionnaires as questionnaire', 'questionnaire.request_id', '=', 'request.id')
            ->select('third_party_profiles.id')
            ->distinct() // Ensures unique results
            ->get();

        $data = [
            'totalProfiles' => $thirdPartyProfiles->count(),
            'totalRequests' => $thirdPartyRequests->count(),
            'totalAssessments' => $thirdPartyAssessments->count(),
            'evaluatedThirdParty' => $evaluatedThirdParty->count(),
            'notEvaluatedThirdParty' => $thirdPartyProfiles->count() - $evaluatedThirdParty->count(),
        ];

        return $data;
    }
}
