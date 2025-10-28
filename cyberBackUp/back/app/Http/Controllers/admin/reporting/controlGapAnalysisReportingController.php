<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use DB;
use Illuminate\Http\Request;

class controlGapAnalysisReportingController extends Controller
{
    private $path = "admin.content.reporting.";
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function controlGapAnalysis()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.Control Gap Analysis')]];
        $frameworks = Framework::all();
        return view($this->path . 'control-gap-analysis',
            compact('breadcrumbs', 'frameworks'));
    }

    public function displayGapAnalysisTable()
    {

        $framework_id = Request('frameworks');
        $frameworkControls = FrameworkControlMapping::where('framework_id', $framework_id)->pluck('framework_control_id')->toArray();
        $FrameworkControlAtMaturitys = FrameworkControl::whereIn('id', $frameworkControls)->whereColumn('control_maturity', '=', 'desired_maturity')->get();
        $FrameworkControlBelowMaturitys = FrameworkControl::whereIn('id', $frameworkControls)->whereColumn('control_maturity', '<', 'desired_maturity')->get();
        $FrameworkControlAboveMaturitys = FrameworkControl::whereIn('id', $frameworkControls)->whereColumn('control_maturity', '>', 'desired_maturity')->get();
        return array(
            'BelowMaturity' => $this->GenerateGapAnalysisTable($FrameworkControlBelowMaturitys),
            'AtMaturity' => $this->GenerateGapAnalysisTable($FrameworkControlAtMaturitys),
            'AboveMaturity' => $this->GenerateGapAnalysisTable($FrameworkControlAboveMaturitys),
            'chartData' => $this->display_control_maturity_spider_chart($framework_id),
        );
    }

    public function GenerateGapAnalysisTable($Controls)
    {
        $table = '<table class="table">
            <thead class="table-dark">
              <tr>
                <th>' . __('report.ControlNumber') . '</th>
                <th>' . __('report.ControlShortName') . '</th>
                <th>' . __('report.ControlPhase') . '</th>
                <th>' . __('report.ControlFamily') . '</th>
                <th>' . __('report.CurrentControlMaturity') . '</th>
                <th>' . __('report.DesiredControlMaturity') . '</th>
              </tr>
            </thead>
            <tbody>
           ';
    
        if ($Controls) {
            foreach ($Controls as $Control) {
                $table .= '<tr>';
                $table .= '<td>' . htmlspecialchars($Control->control_number) . '</td>';
                $table .= '<td>' . htmlspecialchars($Control->short_name) . '</td>';
                $table .= '<td>' . ($Control->ControlPhase ? htmlspecialchars($Control->ControlPhase->name) : __('locale.NoDataAvailable')) . '</td>';
                $table .= '<td>' . ($Control->Family ? htmlspecialchars($Control->Family->name) : __('locale.NoDataAvailable')) . '</td>';
                $table .= '<td>' . ($Control->ControlMaturity ? htmlspecialchars($Control->ControlMaturity->name) : __('locale.NoDataAvailable')) . '</td>';
                $table .= '<td>' . ($Control->ControlDesiredMaturity ? htmlspecialchars($Control->ControlDesiredMaturity->name) : __('locale.NoDataAvailable')) . '</td>';
                $table .= '</tr>';
            }
        } else {
            $table .= '<tr>';
            $table .= '<td class="card-text text-center" colspan="6">' . __('locale.NoDataAvailable') . '</td>';
            $table .= '</tr>';
        }
    
        $table .= ' </tbody>
        </table>';
    
        return $table;
    }
    

    public function get_control_gaps($framework_id = null, $maturity = "all_maturity", $order_field = false, $order_dir = false)
    {
        $sql = "SELECT t1.control_number, t1.short_name, t2.name as control_class_name, t3.name as control_phase_name, t5.name as family_short_name, t7.name as control_maturity_name, t8.name as desired_maturity_name
            FROM `framework_controls` t1
            LEFT JOIN `control_classes` t2 on t1.control_class=t2.id
            LEFT JOIN `control_phases` t3 on t1.control_phase=t3.id
            LEFT JOIN `families` t5 on t1.family=t5.id
            LEFT JOIN `control_maturities` t7 on t1.control_maturity=t7.id
            LEFT JOIN `control_desired_maturities` t8 on t1.desired_maturity=t8.id
            LEFT JOIN `framework_control_mappings` m on t1.id=m.framework_control_id ";
        // Change the query based on the requested maturity
        switch ($maturity) {
            case "below_maturity":
                $sql .= " WHERE t1.deleted=0 AND t1.control_maturity < t1.desired_maturity AND m.framework_id=" . $framework_id;
                break;
            case "at_maturity":
                $sql .= " WHERE t1.deleted=0 AND t1.control_maturity = t1.desired_maturity AND m.framework_id=" . $framework_id;
                break;
            case "above_maturity":
                $sql .= " WHERE t1.deleted=0 AND t1.control_maturity > t1.desired_maturity AND m.framework_id=" . $framework_id;
                break;
            default:
                $sql .= " WHERE t1.deleted=0 AND m.framework_id=" . $framework_id;
                break;
        }

        switch ($order_field) {
            case "control_number";
                $sql .= " ORDER BY control_number " . $order_dir;
                break;
            case "control_family";
                $sql .= " ORDER BY t5.name " . $order_dir;
                break;
            case "control_phase";
                $sql .= " ORDER BY t3.name " . $order_dir;
                break;
            case "control_current_maturity";
                $sql .= " ORDER BY t7.name " . $order_dir;
                break;
            case "control_desired_maturity";
                $sql .= " ORDER BY t8.name " . $order_dir;
                break;
        }
        $sql .= ";";
        $data = DB::select($sql);
        return $data;

    }

    public function display_control_maturity_spider_chart($framework_id)
    {

        // Get the control gap information for this framework
        $control_gaps = $this->get_control_gaps($framework_id, "all_maturity", "control_family", "asc");

        // Create an empty current category
        $current_category = "";

        // Create an empty categories array
        $categories = array();

        // Create an empty categories count array
        $categories_count = array();

        // Create an empty categories current maturity sum array
        $categories_current_maturity_sum = array();

        // Create an empty categories desired maturity sum array
        $categories_desired_maturity_sum = array();

        // Get the list of control gaps
        foreach ($control_gaps as $value) {
            // Escaping it here as it's used later both as key and value and wanted to make sure that they match
            // $value->family_short_name = $value->family_short_name;

            // Get the numeric value for the current control maturity
            switch ($value->control_maturity_name) {
                case "Not Performed":
                    $current_control_maturity = 0;
                    break;
                case "Performed":
                    $current_control_maturity = 1;
                    break;
                case "Documented":
                    $current_control_maturity = 2;
                    break;
                case "Managed":
                    $current_control_maturity = 3;
                    break;
                case "Reviewed":
                    $current_control_maturity = 4;
                    break;
                case "Optimizing":
                    $current_control_maturity = 5;
                    break;
            }
            $desired_control_maturity = 0; // Default value

            // Get the numeric value for the desired control maturity
            switch ($value->desired_maturity_name) {
                case "Not Performed":
                    $desired_control_maturity = 0;
                    break;
                case "Performed":
                    $desired_control_maturity = 1;
                    break;
                case "Documented":
                    $desired_control_maturity = 2;
                    break;
                case "Managed":
                    $desired_control_maturity = 3;
                    break;
                case "Reviewed":
                    $desired_control_maturity = 4;
                    break;
                case "Optimizing":
                    $desired_control_maturity = 5;
                    break;
            }

            // If this is not the current category
            if ($value->family_short_name != $current_category) {
                // Add the family to the category array
                $categories[] = $value->family_short_name;

                // Set the count for this family to one
                $categories_count[$value->family_short_name] = 1;

                // Put the first value in the categories current maturity sum array
                $categories_current_maturity_sum[$value->family_short_name] = $current_control_maturity;

                // Put the first value in the categories desired maturity sum array
                $categories_desired_maturity_sum[$value->family_short_name] = $desired_control_maturity;

                // Set the new current category
                $current_category = $value->family_short_name;
            }
            // If the category hasn't changed
            else {
                // Increment the count
                $categories_count[$value->family_short_name] = $categories_count[$value->family_short_name] + 1;
                // Increment the current maturity sum
                $categories_current_maturity_sum[$value->family_short_name] = $categories_current_maturity_sum[$value->family_short_name] + $current_control_maturity;
                // Increment the desired maturity sum
                $categories_desired_maturity_sum[$value->family_short_name] = $categories_desired_maturity_sum[$value->family_short_name] + $desired_control_maturity;
            }
        }

        // // Create the empty data arrays
        $categories_current_maturity_average = array();
        $categories_desired_maturity_average = array();
        $current_maturity_average = null;
        $desired_maturity_average = null;
        // For each category
        foreach ($categories as $key => $value) {
            // Averaage = sum / value
            $current_maturity_average = $categories_current_maturity_sum[$value] / $categories_count[$value];
            $desired_maturity_average = $categories_desired_maturity_sum[$value] / $categories_count[$value];
            $categories_current_maturity_average[] = round($current_maturity_average, 1);
            $categories_desired_maturity_average[] = round($desired_maturity_average, 1);
        }

        return array(
            'labels'=>$categories,
            'dataset1'=>$categories_current_maturity_average,
            'dataset2'=>$categories_desired_maturity_average,
        );



    }

}
