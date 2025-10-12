<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\Risk;
use DB;

class riskDashboardReportingController extends Controller
{
    private $path = "admin.content.reporting.";
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function riskDashboardReport()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.Risk Dashboard')]];
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
            $this->path . 'risk-dashboard',
            compact(
                'breadcrumbs',
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
                'closedRiskReasonCharttDataNumber'
            )
        );

        // return $this->closedRiskReasonChart();
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
                $stmt = "SELECT a.id, b.name FROM `risks` a LEFT JOIN `risk_to_teams` rtt ON a.id=rtt.risk_id LEFT JOIN `users` b ON a.manager_id = b.id WHERE status != \"Closed\"  GROUP BY a.id ORDER BY b.name DESC";

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
}
