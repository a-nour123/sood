<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use DB;

class OverviewReportingController extends Controller
{
    private $path = "admin.content.reporting.";
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function overviewReport()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.Overview')]];
        $table = $this->createTable();
        $openClosedChartData = $this->openClosedChart();

        $openClosedChartType = $openClosedChartData['type'];
        $openClosedChartNumber = $openClosedChartData['number'];

        $openMitigationChartData=$this->openMitigationChart();

        $openMitigationChartType = $openMitigationChartData['type'];
        $openMitigationChartNumber = $openMitigationChartData['number'];

        $openReviewChartData=$this->openReviewChart();

        $openReviewChartType = $openReviewChartData['type'];
        $openReviewChartNumber = $openReviewChartData['number'];
        return view($this->path . 'overview', compact('breadcrumbs', 'table', 'openClosedChartType', 'openClosedChartNumber','openMitigationChartType','openMitigationChartNumber','openReviewChartType','openReviewChartNumber'));

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
            }else{
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


    function openReviewChart(){
        $array = DB::select("SELECT id, CASE WHEN mgmt_review IS NULL THEN 'Unreviewed' WHEN mgmt_review IS NOT NULL THEN 'Reviewed' END AS name FROM `risks` WHERE status != \"Closed\" ORDER BY name");
        // Set the defaults
        $current_type = "";
        $grouped_array = array();
        $counter = -1;
        $data=array();
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
}
