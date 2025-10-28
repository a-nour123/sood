<?php

namespace App\Http\Controllers\admin\risk_management;

use App\Http\Controllers\Controller;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Risk;
use App\Models\RiskGrouping;
use App\Models\RiskLevel;
use App\Models\ScoringMethod;
use App\Models\ThreatGrouping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskStatisticsController extends Controller
{
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],  ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')], ['name' => __('locale.Reporting')]];

        $GetSeveritChartDetails = $this->GetSeverityChart();
        $getRisks = $this->getRisks();
        // Extract data from the response for use in the view
        $series = $getRisks['series'];
        $counters = $getRisks['counters'];
        $risksDepartement = $this->getRisksDepartement();
        // $getproisrtRisks = $this->getPriorRisks();


        $closedRiskReasonChartData = $this->closedRiskReasonChart();
        $closedRiskReasonChartDataType = $closedRiskReasonChartData['type'];
        $closedRiskReasonChartDataNumber = $closedRiskReasonChartData['number'];

        $openriskLocationsData = $this->openriskLocationsChart();
        $openriskLocationsDataType = $openriskLocationsData['type'];
        $openriskLocationsDataNumber = $openriskLocationsData['number'];

        $openRiskStatusData = $this->openRiskStatusChart();
        $openRiskStatusDataType = $openRiskStatusData['type'];
        $openRiskStatusDataNumber = $openRiskStatusData['number'];

        $openRiskSourceData = $this->openRiskSourceChart();
        $openRiskSourceDataType = $openRiskSourceData['type'];
        $openRiskSourceDataNumber = $openRiskSourceData['number'];

        $openRiskCategoryData = $this->openRiskCategoryChart();
        $openRiskCategoryDataType = $openRiskCategoryData['type'];
        $openRiskCategoryDataNumber = $openRiskCategoryData['number'];

        $openRiskTeamChartData = $this->openRiskTeamChart();
        $openRiskTeamChartDataType = $openRiskTeamChartData['type'];
        $openRiskTeamChartDataNumber = $openRiskTeamChartData['number'];

        $openRiskTechnologyChartData = $this->openRiskTechnologyChart();
        $openRiskTechnologyChartDataType = $openRiskTechnologyChartData['type'];
        $openRiskTechnologyChartDataNumber = $openRiskTechnologyChartData['number'];

        $openRiskOwnerChartData = $this->openRiskOwnerChart();
        $openRiskOwnerChartDataType = $openRiskOwnerChartData['type'];
        $openRiskOwnerChartDataNumber = $openRiskOwnerChartData['number'];

        $openRiskOwnersManagerChartData = $this->openRiskOwnersManagerChart();
        $openRiskOwnersManagerChartDataType = $openRiskOwnersManagerChartData['type'];
        $openRiskOwnersManagerChartDataNumber = $openRiskOwnersManagerChartData['number'];

        $openRiskScoringMethodChartData = $this->openRiskScoringMethodChart();
        $openRiskScoringMethodChartDataType = $openRiskScoringMethodChartData['type'];
        $openRiskScoringMethodChartDataNumber = $openRiskScoringMethodChartData['number'];

        $closedRiskReasonCharttData = $this->closedRiskReasonChart();
        $closedRiskReasonCharttDataType = $closedRiskReasonCharttData['type'];
        $closedRiskReasonCharttDataNumber = $closedRiskReasonCharttData['number'];

        return view(
            'admin.content.risk_management.riskstatistics',
            compact(
                'breadcrumbs',
                'risksDepartement',
                'getRisks',
                'series',
                'counters',
                'GetSeveritChartDetails',
                'closedRiskReasonChartDataType',
                'closedRiskReasonChartDataNumber',
                'openriskLocationsDataType',
                'openriskLocationsDataNumber',
                'openRiskStatusDataType',
                'openRiskStatusDataNumber',
                'openRiskSourceDataType',
                'openRiskSourceDataNumber',
                'openRiskCategoryDataType',
                'openRiskCategoryDataNumber',
                'openRiskTeamChartDataType',
                'openRiskTeamChartDataNumber',
                'openRiskTechnologyChartDataType',
                'openRiskTechnologyChartDataNumber',
                'openRiskOwnerChartDataType',
                'openRiskOwnerChartDataNumber',
                'openRiskOwnersManagerChartDataType',
                'openRiskOwnersManagerChartDataNumber',
                'openRiskScoringMethodChartDataType',
                'openRiskScoringMethodChartDataNumber',
                'closedRiskReasonCharttDataType',
                'closedRiskReasonCharttDataNumber',
                'breadcrumbs'
            )
        );
    }

    private function GetSeverityChart()
    {
        // Fetch risks, their residual risk scores, and corresponding risk levels
        $risks = DB::table('risks')
        ->select('risks.id', 'risks.subject', 'risks.status', 'rrsh.residual_risk')
        ->leftJoinSub(
            DB::table('residual_risk_scoring_histories')
                ->select('id', 'risk_id', 'residual_risk')
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                          ->from('residual_risk_scoring_histories')
                          ->groupBy('risk_id');
                }),
            'rrsh',
            'rrsh.risk_id',
            '=',
            'risks.id'
        )
        ->get();
    

        // Define risk level thresholds
        $riskLevels = DB::table('risk_levels')
            ->orderBy('value', 'asc') // Ensure the levels are sorted by value
            ->get();
         // Convert risk levels into an array of ranges
        $riskLevelRanges = [];
        $previousLevel = null;

        foreach ($riskLevels as $level) {
            if ($previousLevel) {
                $riskLevelRanges[] = [
                    'min' => (float) $previousLevel->value,
                    'max' => (float) $level->value,
                    'name' => $previousLevel->name,
                ];
            }
            $previousLevel = $level;
        }

        // Add the last range for the highest level
        if ($previousLevel) {
            $riskLevelRanges[] = [
                'min' => (float) $previousLevel->value,
                'max' => PHP_FLOAT_MAX, // Open-ended range for the highest level
                'name' => $previousLevel->name,
            ];
        }

        // Initialize status groups
        $statusGroups = [
            'Mitigation Planned' => [],
            'Opened' => [],
            'Closed' => [],
            'New' => [],
            'Mgmt Reviewed' => [],
            'Reopened' => []
        ];

        // Loop through each risk and calculate its risk level
        foreach ($risks as $risk) {
            $residualRisk = (float) ($risk->residual_risk ?? 0);

            // Find the corresponding risk level based on the residual risk value
            $riskLevel = 'Unknown'; // Default risk level
            foreach ($riskLevelRanges as $range) {
                if ($residualRisk >= $range['min'] && $residualRisk < $range['max']) {
                    $riskLevel = $range['name'];
                    break;
                }
            }

            // Add the risk level to the corresponding status group
            if (isset($statusGroups[$risk->status])) {
                $statusGroups[$risk->status][] = $riskLevel;
            }
        }

        // Prepare data for the chart (group by status and count risk levels)
        $chartData = [];
        foreach ($statusGroups as $status => $levels) {
            $chartData[$status] = array_count_values($levels); // Count occurrences of each risk level
        }
        // Return the chart data as JSON
        return response()->json($chartData);
    }



    public function sort_array($array, $sort)
    {
        // Create the sort array
        $sortArray = array();

        // For each risk in the array
        foreach ($array as $risk) {
            // For each key value pair in the risk
            foreach ($risk as $key => $value) {
                // If the key is not yet set in the sort array
                if (!isset($sortArray[$key])) {
                    // Create a new array at that key
                    $sortArray[$key] = array();
                }
                // Set the key to the value
                $sortArray[$key][] = $value;
            }
        }

        // Sort the array based on the sort value provided
        array_multisort($sortArray[$sort], SORT_ASC, $array);

        // Return the sorted array
        return $array;
    }
    public function get_pie_array($filter = null)
    {
        $stmt = "";

        switch ($filter) {
            case 'status':
                $field = "status";
                $stmt = "SELECT a.id, a.status FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id WHERE a.status != \"Closed\"  GROUP BY a.id ORDER BY a.status DESC";

                break;
            case 'location':
                $field = "name";
                $stmt = "SELECT a.id, b.name location FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `risk_to_locations` rtl ON a.id=rtl.risk_id LEFT JOIN `locations` b ON rtl.location_id=b.id  WHERE a.status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";

                break;
            case 'source':
                $field = "name";
                $stmt = "SELECT a.id, b.name FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `sources` b ON a.source_id = b.id WHERE status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";
                break;
            case 'category':
                $field = "name";
                $stmt = "SELECT a.id, b.name FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `categories` b ON a.category_id = b.id WHERE status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";
                break;
            case 'team':
                $field = "name";
                $stmt = "SELECT a.id, b.name team FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `teams` b ON rtt.team_id=b.id WHERE a.status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";

                break;
            case 'technology':
                $field = "name";
                $stmt = "SELECT a.id, b.name technology FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `risk_to_technologies` rttg ON a.id=rttg.risk_id LEFT JOIN `technologies` b ON rttg.technology_id=b.id WHERE status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";

                break;
            case 'owner':
                $field = "name";
                $stmt = "SELECT a.id, b.name FROM `risks` a LEFT JOIN `users` b ON a.owner_id = b.id WHERE status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";

                break;
            case 'manager':
                $field = "name";
                $stmt = "SELECT a.id, b.name 
                             FROM `risks` a 
                             LEFT JOIN `users` b ON a.owner_id = b.id 
                             WHERE a.status != 'Closed'  
                             GROUP BY a.id, b.name 
                             ORDER BY b.name DESC";


                break;
            case 'scoring_method':
                $field = "name";
                $stmt = "SELECT a.id, CASE WHEN b.scoring_method = 5 THEN 'Custom' WHEN b.scoring_method = 4 THEN 'OWASP' WHEN b.scoring_method = 3 THEN 'DREAD' WHEN b.scoring_method = 2 THEN 'CVSS' WHEN b.scoring_method = 1 THEN 'Classic' END AS name, COUNT(*) AS num FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `risk_scorings` b ON a.id = b.id WHERE a.status != \"Closed\"  GROUP BY a.id ORDER BY b.scoring_method DESC";

                break;
            case 'close_reason':
                $field = "name";
                $stmt = "SELECT a.close_reason, a.risk_id as id, b.name, MAX(closure_date) FROM `closures` a JOIN `close_reason` b ON a.close_reason = b.id JOIN `risks` c ON a.risk_id = c.id LEFT JOIN `risk_to_teams` rtt ON c.id=rtt.risk_id WHERE c.status = \"Closed\"  GROUP BY a.risk_id ORDER BY name DESC;";

                break;
            default:
                $stmt = "SELECT a.id, a.status, GROUP_CONCAT(DISTINCT b.name separator '; ') AS location, c.name AS source, d.name AS category, GROUP_CONCAT(DISTINCT e.name SEPARATOR ', ') AS team, GROUP_CONCAT(DISTINCT f.name SEPARATOR ', ') AS technology, g.name AS owner, h.name AS manager, CASE WHEN scoring_method = 5 THEN 'Custom' WHEN scoring_method = 4 THEN 'OWASP' WHEN scoring_method = 3 THEN 'DREAD' WHEN scoring_method = 2 THEN 'CVSS' WHEN scoring_method = 1 THEN 'Classic' END AS scoring_method FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `team` e ON rtt.team_id=e.value LEFT JOIN `risk_to_locations` rtl ON a.id=rtl.risk_id LEFT JOIN `location` b ON rtl.location_id=b.id LEFT JOIN `source` c ON a.source = c.value LEFT JOIN `category` d ON a.category = d.value LEFT JOIN risk_to_technology rttg ON a.id=rttg.risk_id LEFT JOIN `technology` f ON rttg.technology_id=f.value LEFT JOIN `user` g ON a.owner = g.value LEFT JOIN `user` h ON a.manager = h.value LEFT JOIN `risk_scoring` i ON a.id = i.id WHERE a.status != \"Closed\"  GROUP BY a.id; ";
                break;
        }

        // Store the list in the array
        $array = DB::select($stmt);

        return $array;
    }
    public function count_array_values($array, $sort)
    {
        global $lang;

        // Initialize the value and count
        $value = "";
        $value_count = 1;

        // Count the number of risks for each value
        foreach ($array as $risk) {
            // $risk = json_decode($risk);
            // Get the current value
            $current_value = $risk->$sort;
            if ($current_value == null) {
                $current_value = __('locale.Unassigned');
            }

            // If the value is not new
            if ($current_value == $value) {
                $value_count++;
            } else {
                // If the value is not empty
                if ($value != "") {
                    // Add the previous value to the array
                    $value_array[] = array($sort => $value, 'num' => $value_count);
                }

                // Set the new value and reset the count
                $value = $current_value;
                $value_count = 1;
            }
        }

        // Update the final value
        $value_array[] = array($sort => $value, 'num' => $value_count);

        // Create the data array
        foreach ($value_array as $row) {
            $data[] = array($row[$sort], (int) $row['num']);
        }

        return $data;
    }

    public function openRiskLevelChart()
    {

        // Get the risk levels
        $risk_levels = DB::select("SELECT * from `risk_levels` ORDER BY value DESC");
        $data = array();

        $veryhigh = $risk_levels[0]['value'];
        $high = $risk_levels[1]['value'];
        $medium = $risk_levels[2]['value'];
        $low = $risk_levels[3]['value'];

        $very_high_display_name = $risk_levels[0]['display_name'];
        $high_display_name = $risk_levels[1]['display_name'];
        $medium_display_name = $risk_levels[2]['display_name'];
        $low_display_name = $risk_levels[3]['display_name'];
        $insignificant_display_name = $lang['Insignificant'];

        // Include the team separation extra

        $separation_query_where = " AND " . get_user_teams_query("rsk");
        $separation_query_from = "LEFT JOIN `risk_to_additional_stakeholder` rtas ON `rsk`.`id` = `rtas`.`risk_id`";

        // Build the inner query that's querying the scores the user requested

        $inner_query = "
                SELECT
                    `scoring`.`calculated_risk` as score
                FROM `risk_scoring` scoring
                    JOIN `risks` rsk ON `scoring`.`id` = `rsk`.`id`
                    LEFT JOIN `risk_to_teams` rtt ON `rsk`.`id` = `rtt`.`risk_id`
                    {$separation_query_from}
                WHERE
                    `rsk`.`status` != 'Closed'

                    {$separation_query_where}
                GROUP BY
                    `rsk`.`id`
            ";

        // Assemble the final query
        $sql = "
            SELECT
                `score`,
                COUNT(*) AS num,
                CASE
                    WHEN `score` >= :veryhigh THEN :very_high_display_name
                    WHEN `score` < :veryhigh AND `score` >= :high THEN :high_display_name
                    WHEN `score` < :high AND `score` >= :medium THEN :medium_display_name
                    WHEN `score` < :medium AND `score` >= :low THEN :low_display_name
                    WHEN `score` < :low AND `score` >= 0 THEN :insignificant_display_name
                END AS level
            FROM
                ({$inner_query}) AS innr
            GROUP BY
                `level`
            ORDER BY
                `score` DESC;
        ";

        $array = DB::select($sql);

        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Initialize veryhigh, high, medium, low, and insignificant
            $veryhigh = false;
            $high = false;
            $medium = false;
            $low = false;
            $insignificant = false;

            // Create the data array
            foreach ($array as $row) {
                $data[] = array($row['level'], (int) $row['num']);
            }
        }
        return $data;
    }



    public function openriskLocationsChart()
    {

        // $array = $this->get_pie_array('location');
        $risks = Risk::with('locationsOfRisk:name')->select('id')->get()->toArray();
        $formattedRisks = [];

        foreach ($risks as $risk) {
            if (count($risk['locations_of_risk']) == 0) {
                array_push($formattedRisks, (object)[
                    'id' => $risk['id'],
                    'location' => null
                ]);
            } else {
                foreach ($risk['locations_of_risk'] as $location) {
                    array_push($formattedRisks, (object)[
                        'id' => $risk['id'],
                        'location' => $location['name']
                    ]);
                }
            }
        }

        $array = $formattedRisks;

        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "location";

            // Sort the array
            $array = $this->sort_array($array, $sort);
            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }
        $closedRiskReasonChartDataType = array();
        $closedRiskReasonDataNumper = array();
        foreach ($data as $item) {
            array_push($closedRiskReasonChartDataType, $item[0]);
            array_push($closedRiskReasonDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $closedRiskReasonChartDataType),
            'number' => implode(",", $closedRiskReasonDataNumper),

        );
    }

    public function openRiskStatusChart()
    {

        $array = $this->get_pie_array('status');
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "status";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }
        $openRiskStatusChartDataType = array();
        $openRiskStatusDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskStatusChartDataType, $item[0]);
            array_push($openRiskStatusDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskStatusChartDataType),
            'number' => implode(",", $openRiskStatusDataNumper),
        );
    }

    public function openRiskSourceChart()
    {
        $array = $this->get_pie_array('source');
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "name";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }

        $openRiskSourceChartDataType = array();
        $openRiskSourceChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskSourceChartDataType, $item[0]);
            array_push($openRiskSourceChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskSourceChartDataType),
            'number' => implode(",", $openRiskSourceChartDataNumper),
        );
    }

    public function openRiskCategoryChart()
    {

        $array = $this->get_pie_array('category');
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "name";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }

        $openRiskCategoryChartDataType = array();
        $openRiskCategoryChartNumper = array();
        foreach ($data as $item) {
            array_push($openRiskCategoryChartDataType, $item[0]);
            array_push($openRiskCategoryChartNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskCategoryChartDataType),
            'number' => implode(",", $openRiskCategoryChartNumper),
        );
    }

    public function openRiskTeamChart()
    {
        // $array = $this->get_pie_array('team');
        $risks = Risk::with('teamsForRisk:name')->select('id')->get()->toArray();
        $formattedRisks = [];

        foreach ($risks as $risk) {
            if (count($risk['teams_for_risk']) == 0) {
                array_push($formattedRisks, (object)[
                    'id' => $risk['id'],
                    'team' => null
                ]);
            } else {
                foreach ($risk['teams_for_risk'] as $team) {
                    array_push($formattedRisks, (object)[
                        'id' => $risk['id'],
                        'team' => $team['name']
                    ]);
                }
            }
        }

        $array = $formattedRisks;

        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "team";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }
        $openRiskTeamChartDataType = array();
        $openRiskTeamChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskTeamChartDataType, $item[0]);
            array_push($openRiskTeamChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskTeamChartDataType),
            'number' => implode(",", $openRiskTeamChartDataNumper),
        );
    }

    public function openRiskTechnologyChart()
    {
        // $array = $this->get_pie_array('technology');
        $risks = Risk::with('technologiesOfRisk:name')->select('id')->get()->toArray();
        $formattedRisks = [];

        foreach ($risks as $risk) {
            if (count($risk['technologies_of_risk']) == 0) {
                array_push($formattedRisks, (object)[
                    'id' => $risk['id'],
                    'technology' => null
                ]);
            } else {
                foreach ($risk['technologies_of_risk'] as $technology) {
                    array_push($formattedRisks, (object)[
                        'id' => $risk['id'],
                        'technology' => $technology['name']
                    ]);
                }
            }
        }

        $array = $formattedRisks;

        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "technology";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }
        $openRiskTechnologyChartDataType = array();
        $openRiskTechnologyChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskTechnologyChartDataType, $item[0]);
            array_push($openRiskTechnologyChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskTechnologyChartDataType),
            'number' => implode(",", $openRiskTechnologyChartDataNumper),
        );
    }

    public function openRiskOwnerChart()
    {
        $array = $this->get_pie_array('owner');
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "name";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }

        $openRiskOwnerChartDataType = array();
        $openRiskOwnerChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskOwnerChartDataType, $item[0]);
            array_push($openRiskOwnerChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskOwnerChartDataType),
            'number' => implode(",", $openRiskOwnerChartDataNumper),
        );
    }
    public function openRiskOwnersManagerChart()
    {
        $array = $this->get_pie_array('manager');
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "name";

            // Sort the array
            $array = $this->sort_array($array, $sort);
            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }
        $openRiskOwnersManagerChartDataType = array();
        $openRiskOwnersManagerChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskOwnersManagerChartDataType, $item[0]);
            array_push($openRiskOwnersManagerChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskOwnersManagerChartDataType),
            'number' => implode(",", $openRiskOwnersManagerChartDataNumper),
        );
    }

    public function openRiskScoringMethodChart()
    {

        $array = $this->get_pie_array('scoring_method');
        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Set the sort value
            $sort = "name";

            // Sort the array
            $array = $this->sort_array($array, $sort);

            // Count the array by status
            $data = $this->count_array_values($array, $sort);
        }
        $openRiskScoringMethodChartDataType = array();
        $openRiskScoringMethodChartDataNumper = array();
        foreach ($data as $item) {
            array_push($openRiskScoringMethodChartDataType, $item[0]);
            array_push($openRiskScoringMethodChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $openRiskScoringMethodChartDataType),
            'number' => implode(",", $openRiskScoringMethodChartDataNumper),
        );
    }

    public function closedRiskReasonChart()
    {
        // Query the database
        $array = DB::select(" SELECT name, COUNT(*) as num FROM (SELECT a.close_reason, b.name, MAX(closure_date) FROM `closures` a JOIN `close_reasons` b ON a.close_reason = b.id JOIN `risks` c ON a.risk_id = c.id LEFT JOIN risk_to_teams rtt ON c.id=rtt.risk_id WHERE c.status = \"Closed\"  GROUP BY a.risk_id ORDER BY b.name DESC) AS close GROUP BY name ORDER BY COUNT(*) DESC; ");


        // If the array is empty
        if (empty($array)) {
            $data[] = array("No Data Available", 0);
        }
        // Otherwise
        else {
            // Create the data array
            foreach ($array as $row) {
                $data[] = array($row->name, (int) $row->num);
            }
        }
        $closedRiskReasonChartDataType = array();
        $closedRiskReasonChartDataNumper = array();
        foreach ($data as $item) {
            array_push($closedRiskReasonChartDataType, $item[0]);
            array_push($closedRiskReasonChartDataNumper, $item[1]);
        }

        return array(
            'type' => implode(",", $closedRiskReasonChartDataType),
            'number' => implode(",", $closedRiskReasonChartDataNumper),
        );
    }

    public function getRisks()
    {
        // Query the database
        $risks = DB::select("SELECT a.calculated_risk, a.CLASSIC_likelihood, a.CLASSIC_impact, b.* FROM risk_scorings a JOIN risks b ON a.id = b.id WHERE b.status != 'Closed' AND a.scoring_method = 1 ORDER BY calculated_risk DESC");

        if (is_array($risks)) {
            foreach ($risks as &$row) {
                $row->subject = isset($row->subject);
                $row->assessment = isset($row->assessment);
                $row->notes = isset($row->notes);
            }
            unset($row);
        }

        $data = array();
        $point_groups = [];
        $tooltip_html = '';

        // Make group for each points
        foreach ($risks as $risk) {
            $calculate_risk = $risk->calculated_risk;

            if ($calculate_risk == 10) {
                $x = Likelihood::count();
                $y = Impact::count();
            } else {
                $x = $risk->CLASSIC_likelihood;
                $y = $risk->CLASSIC_impact;
            }
            $risk_id =  $risk->id;
            if (isset($point_groups[$x . "_" . $y])) {
                $point_groups[$x . "_" . $y]["risk_ids"][] = $risk_id;
            } else {
                $point_groups[$x . "_" . $y] = array(
                    "x" => $x,
                    "y" => $y,
                    "risk_ids" => array($risk_id)
                );
            }

            $tooltip_html .=  '<a href="' . route('admin.risk_management.show', ['id' => $risk->id]) . '" style="" ><b>' . $risk->subject . '</b></a><hr>';
        }

        // Make chart data from point groups
        foreach ($point_groups as $point_group) {
            $data[] = array(
                'x'             => intval($point_group['x']),
                'y'             => intval($point_group['y']),
                'risk_ids'      => implode(",", $point_group['risk_ids']),
                'marker'    => array(
                    'fillColor' => 'rgba(223, 83, 83)'
                ),
                'color'     => '<div style="width:100%; height:20px; border: solid 1px;border-color: #3f3f3f;"></div>'
            );
        }

        $series = [];
        for ($likelihood = 1; $likelihood <= Likelihood::count(); $likelihood++) {
            for ($impact = 1; $impact <= Impact::count(); $impact++) {
                $series[] = get_area_series_from_likelihood_impact($likelihood, $impact);
            }
        }

        $series[] = array(
            'type' => "scatter",
            'color' => "rgba(223, 83, 83)",
            'data' => $data,
            'enableMouseTracking' => true,
            'states' => [
                'hover' => [
                    'enabled' => false
                ]
            ],
            'stickyTracking' => false,
        );

        $counters = [
            'likelihood' => Likelihood::count(),
            'impact' => Impact::count()
        ];

        // Return data directly, not as a JSON response
        return [
            'series' => $series,
            'counters' => $counters,
            'tooltip_html' => $tooltip_html
        ];
    }


    /*************************************
     * GET TOOLTIP INFO OF THE HIGHCHART *
     *************************************/
    function get_tooltip(Request $request)
    {
        // Get risk ids by comma
        $risk_ids = $request->risk_ids;

        // Get risk ids in array
        $risk_ids = explode(",", $risk_ids);

        $tooltip_html = "";
        $riskCounter = count($risk_ids);
        foreach ($risk_ids as $index => $risk_id) {
            $risk = Risk::find($risk_id);

            // If risk by risk ID no exist, go to next risk ID
            if (!$risk) {
                continue;
            }

            if (!($riskCounter - 1 == $index))
                $tooltip_html .=  '<a href="' . route('admin.risk_management.show', ['id' => $risk->id]) . '" style="" ><b>' . $risk->subject . '</b></a><hr>';
            else
                $tooltip_html .=  '<a href="' . route('admin.risk_management.show', ['id' => $risk->id]) . '" style="" ><b>' . $risk->subject . '</b></a>';
        }

        $response = array(
            'status' => true,
            'reload' => false,
            'data' => $tooltip_html,
            'message' => '',
        );
        return response()->json($response, 200);
    }

    public function getRisksDepartement()
    {
        $risksDepartemnt = DB::table('risks')
            ->select('users.department_id', 'departments.name as department_name', DB::raw('count(risks.id) as total_risks'))
            ->leftJoin('users', 'users.id', '=', 'risks.owner_id')
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->groupBy('users.department_id', 'departments.name')
            ->get();

        // Format the data for Highcharts Donut chart
        $chartData = $risksDepartemnt->map(function ($item) {
            return [
                'name' => $item->department_name ?? "No Departement",
                'y' => $item->total_risks,
            ];
        });

        return [
            'risksDepartemnt' => $chartData, // Return the formatted data
        ];
    }

    // private function getPriorRisks() {
    //     // Initialize the $data array
    //     $data = [];

    //     // Fetch all risks with the necessary relationships
    //     $risks = Risk::with([
    //         'tags', 'riskScoring', 'locations', 'teams', 'technologies', 'additionalStakeholders',
    //         'category', 'control', 'framework', 'risksToAsset', 'risksToAssetGroup', 'source', 'submittedBy:id,name'
    //     ])->get(); // Retrieve all risks

    //     // Loop through all the risks to get the data for each
    //     foreach ($risks as $risk) {
    //         $riskData = [];

    //         // Set risk_scoring values for each risk
    //         $riskData['risk_scoring'] = [
    //             'CLASSIC_likelihood' => $risk->CLASSIC_likelihood,
    //             'CLASSIC_impact' => $risk->CLASSIC_impact,
    //             'calculated_risk' => $risk->calculated_risk,
    //             'scoring_method' => $risk->scoring_method
    //         ];

    //         // Fetch likelihood and impact data using the values from risk_scoring
    //         $likelihood = Likelihood::where('id', $riskData['risk_scoring']['CLASSIC_likelihood'])->first();
    //         $impact = Impact::where('id', $riskData['risk_scoring']['CLASSIC_impact'])->first();

    //         // Check if likelihood and impact records exist before calling toArray()
    //         $riskData['likelihood'] = $likelihood ? $likelihood->toArray() : [];
    //         $riskData['impact'] = $impact ? $impact->toArray() : [];

    //         // Fetch the scoring method data based on scoring_method ID
    //         $scoringMethod = ScoringMethod::where('id', $riskData['risk_scoring']['scoring_method'])->first();
    //         $riskData['scoring_method'] = $scoringMethod ? $scoringMethod->toArray() : [];

    //         // Calculate risk value data based on the calculated risk
    //         $riskData['calculated_risk_data'] = $this->getRiskValueData($riskData['risk_scoring']['calculated_risk']);

    //         // Add this risk data to the $data array
    //         $data['risks'][] = $riskData;
    //     }

    //     dd($data); // This will stop execution and show the content of $data
    // }


    // protected function getRiskValueData($calculated_risk)
    // {
    //     $riskLevel = RiskLevel::orderBy('value', 'desc')->where('value', '<=', $calculated_risk)->first();
    //     $data = [];

    //     if ($riskLevel->display_name != '')
    //         $data['name'] = $riskLevel->display_name;
    //     else if ($riskLevel->name != '')
    //         $data['name'] = $riskLevel->name;
    //     else
    //         $data['name'] = "Insignificant";

    //     if (!$riskLevel)
    //         $data['color'] = "white";
    //     else
    //         $data['color'] = $riskLevel['color'];

    //     return $data;
    // }



}
