<?php // Code within app\Helpers\Helper.php

use App\Models\AuditLog;
use App\Models\Closure;
use App\Models\ControlControlObjective;
use App\Models\CustomRiskModelValue;
use App\Models\Department;
use App\Models\Document;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlTestAudit;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\MgmtReview;
use App\Models\Mitigation;
use App\Models\MitigationToControl;
use App\Models\ResidualRiskScoringHistory;
use App\Models\ReviewLevel;
use App\Models\Risk;
use App\Models\RiskLevel;
use App\Models\RiskScoring;
use App\Models\RiskScoringHistory;
use App\Models\Setting;
use App\Models\Team;
use App\Models\AwarenessSurvey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

if (!function_exists('showBOLB')) {
    function showBOLB($value)
    {
        return chunk_split($value);
    }
}
// function to select  option+
if (!function_exists('option_select')) {
    function option_select($current, $item_id)
    {
        if ($current == $item_id) {
            return 'selected';
        }
    }
}

// get notification type
if (!function_exists('notification_type')) {
    function notification_type($type)
    {
        if ($type == 0) {
            return 'notification-unread';
        }
    }
}
/************************
 * FUNCTION: CONVERT ID *
 ************************/
if (!function_exists('convert_id')) {
    function convert_id($id)
    {
        // Add 1000 to any id to make it at least 4 digits
        $id = (int)$id + 1000;

        return $id;
    }
}
// get notification type
if (!function_exists('notification_meta')) {
    function notification_meta($meta, $key)
    {
        if ($meta) {
            return isset($meta[$key]) ? $meta[$key] : null;
        } else {
            return null;
        }
    }
}

if (!function_exists('GetRiskOfControl')) {
    function GetRiskOfControl($row)
    {
        $mitigationIDs = MitigationToControl::where('control_id', $row->control_id)->get()->pluck('mitigation_id')->toArray();
        $riskIDs = Mitigation::whereIn('id', $mitigationIDs)->get()->pluck('risk_id')->toArray();
        $risks = Risk::whereIn('id', $riskIDs)->get();
        return $risks;
    }
}

if (!function_exists('GetControlOfRisk')) {
    function GetControlOfRisk($row)
    {
        $mitigationIDs = Mitigation::where('risk_id', $row['id'])->get()->pluck('id')->toArray();
        $controlIDs = MitigationToControl::whereIn('mitigation_id', $mitigationIDs)->get()->pluck('control_id')->toArray();
        $controls = FrameworkControl::whereIn('id', $controlIDs)->get();
        return $controls;
    }
}
if (!function_exists('riskScoringColor')) {
    function riskScoringColor($riskScoring)
    {
        $riskLevel = RiskLevel::orderBy('value', 'desc')
                        ->where('value', '<=', $riskScoring)
                        ->first();

        return $riskLevel ? $riskLevel->color : '#000000'; // default color if not found
    }
}

if (!function_exists('DateDiffRisk')) {
    function DateDiffRisk($status, $closure, $submission)
    {

        $closure_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $closure);
        $submission_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $submission);

        if ($status != 'Closed') {
            $now = Carbon::now();
            $different_days = $now->diffInDays($submission_date);
        } else {
            $different_days = $closure_date->diffInDays($submission_date);
        }
        return $different_days;
    }
}
/********************************************
 * FUNCTION: GET MAPPING CONTROL FRAMEWORKS *
 ********************************************/
if (!function_exists('get_mapping_control_frameworks')) {
    function get_mapping_control_frameworks($control_id)
    {
        // Open the database connection
        $sql = "SELECT fcm.*,fc.*,fm.name framework_name, fm.description framework_description
        FROM `framework_control_mappings` fcm
            LEFT JOIN `frameworks` fm ON fcm.framework_id = fm.id
            LEFT JOIN `framework_controls` fc  ON fcm.framework_control_id=fc.id
            WHERE fcm.framework_control_id=" . $control_id . ";";
        $frameworks = DB::select($sql);
        return $frameworks;
    }
}

// function to select multi option
if (!function_exists('optionMultiSelect')) {
    function optionMultiSelect($current, $groupSelect)
    {
        if (in_array($current, $groupSelect)) {
            return 'selected';
        }
    }
}

if (!function_exists('in_list')) {
    function in_list($item, $list)
    {
        if (in_array($item, $list)) {
            return 'selected';
        }
    }
}

if (!function_exists('option_radio')) {
    function option_radio($current, $item_id)
    {
        if ($current === $item_id) {
            return 'checked';
        }
    }
}
if (!function_exists('ViewDate')) {
    function ViewDate($date = null)
    {
        if ($date != null && $date != '0000-00-00') {
            $date = date_create($date);
            return date_format($date, "Y-m-d");
        } else {
            return '';
        }
    }
}
if (!function_exists('ViewTime')) {
    function ViewTime($date = null)
    {
        if ($date != null && $date != '0000-00-00') {
            $date = date_create($date);
            return date_format($date, "g:i a");
        } else {
            return '';
        }
    }
}
if (!function_exists('showValue')) {
    function showValue($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return '';
        }
    }
}

if (!function_exists('getLdapValue')) {
    function getLdapValue($key)
    {
        $setting = Setting::where('name', $key)->first();
        if (isset($setting->value)) {
            return $setting->value;
        } else {
            return '';
        }
    }
}

if (!function_exists('getRiskColor')) {
    function getRiskColor($riskLevels, $riskValue)
    {
        for ($i = count($riskLevels) - 1; $i >= 0; $i--) {
            if ($riskValue >= $riskLevels[$i]['value']) {
                return $riskLevels[$i]['color'];
            }
        }
    }
}
if (!function_exists('getIncidentColor')) {
    function getIncidentColor($incidentLevel, $value)
    {

        for ($i = count($incidentLevel) - 1; $i >= 0; $i--) {

            if ($value >= $incidentLevel[$i]['level']) {
                return $incidentLevel[$i]['color'];
            }
        }
    }
}
/****************************
 * FUNCTION: GENERATE TOKEN *
 ****************************/
function generate_token($size)
{
    $token = "";
    $values = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    $values_count = count($values);

    for ($i = 0; $i < $size; $i++) {
        // If the random int function exists (PHP 7)
        if (function_exists('random_int')) {
            // Generate the token using the random_int function
            $token .= $values[random_int(0, $values_count - 1)];
        } else {
            $token .= $values[array_rand($values)];
        }
    }

    return $token;
}

/*********************************************************************************
 * FUNCTION: GET FORMATTED DATE/DATETIME                                         *
 *                                                                               *
 * Use it only on dates got from the database, as strtotime is not suited to be  *
 * used on user input since it can't handle all the date formats we support.     *
 *                                                                               *
 * On user input use the `get_standard_date_from_default_format` function before *
 * writing into the database                                                     *
 *********************************************************************************/
function format_date($date, $default = "")
{
    // If the date is not 0000-00-00
    if ($date && $date != "0000-00-00" && $date != "0000-00-00 00:00:00") {
        // Set it to the proper format
        return strtotime($date) ? date(get_default_date_format(), strtotime($date)) : "";
    } else {
        return $default;
    }
}

function format_datetime($date, $default = "", $timeformat = "H:i:s")
{
    // If the date is not 0000-00-00
    if ($date && $date != "0000-00-00" && $date != "0000-00-00 00:00:00") {
        // Set it to the proper format
        return strtotime($date) ? date(get_default_datetime_format($timeformat), strtotime($date)) : "";
    } else {
        return $default;
    }
}

/*******************************************************
 * FUNCTION: CONVERT DEFAULT DATE FORMAT TO PHP FORMAT *
 *******************************************************/
function get_default_date_format()
{
    $default_date_format = get_setting("default_date_format");
    $php_date_format = str_ireplace("YYYY", "Y", $default_date_format);
    $php_date_format = str_ireplace("MM", "m", $php_date_format);
    $php_date_format = str_ireplace("DD", "d", $php_date_format);
    return $php_date_format;
}

/************************************************************
 * FUNCTION: CONVERT DEFAULT DATE TIME FORMAT TO PHP FORMAT *
 ************************************************************/
function get_default_datetime_format($time_format = "H:i:s")
{
    $format = get_default_date_format();

    return $format . " " . $time_format;
}

/*************************
 * FUNCTION: GET SETTING *
 *************************/
function get_setting($setting, $default = false)
{
    $setting = Setting::where('name', $setting)->first();

    // Check if setting exists
    if ($setting) {
        return $setting->value;
    } else {
        return $default;
    }
}

/*************************
 * FUNCTION: GET RISK LEVELS *
 *************************/
function getRiskLevels()
{

    $response = array(
        'status' => true,
        'data' =>
        [
            "risk_levels" => RiskLevel::get()->toArray(),
        ],
        // 'data' => [
        //     "risk_levels" => [
        //         [
        //             "value" => "1.0",
        //             "name" => "Low",
        //             "color" => "#003cff"
        //         ],
        //         [
        //             "value" => "4.0",
        //             "name" => "Medium",
        //             "color" => "#30d156"
        //         ],
        //         [
        //             "value" => "7.0",
        //             "name" => "High",
        //             "color" => "#2ee5e8"
        //         ],
        //         [
        //             "value" => "9.0",
        //             "name" => "Very High",
        //             "color" => "#ff0000"
        //         ]
        //     ]
        // ],
        'message' => __('locale.Success'),
    );

    return response()->json($response, 200);
}

/***********************
 * FUNCTION: WRITE LOG *
 ***********************/
function write_log($risk_id, $user_id, $message, $log_type = "risk")
{
    $current_time = date("Y-m-d H:i:s");

    return AuditLog::create([
        'risk_id' => $risk_id,
        'user_id' => $user_id,
        'message' => $message,
        'log_type' => $log_type,
        'timestamp' => $current_time,
    ]);
}

/****************************
 * FUNCTION: CALCULATE RISK *
 ****************************/
function calculate_risk($CLASSIC_impact, $CLASSIC_likelihood)
{
    $countOfImpacts = Impact::count();
    $countOfLikelihoods = Likelihood::count();
    $max_risk = '';
    $risk = '';
    if ($countOfImpacts > 0 && $countOfLikelihoods > 0 && $CLASSIC_impact && $CLASSIC_likelihood) { // If the impact or likelihood are passed

        // Get risk_model
        $settingRiskModelvalue = get_setting("risk_model");

        // Pick the risk formula
        if ($settingRiskModelvalue == 1) {
            // $max_risk = 35;
            $max_risk = ($countOfLikelihoods * $countOfImpacts) + (2 * $countOfImpacts);
            $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + (2 * $CLASSIC_impact);
        } else if ($settingRiskModelvalue == 2) {
            // $max_risk = 30;
            $max_risk = ($countOfLikelihoods * $countOfImpacts) + $countOfImpacts;
            $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + $CLASSIC_impact;
        } else if ($settingRiskModelvalue == 3) {
            // $max_risk = 25;
            // $max_risk = $countOfLikelihoods * $countOfImpacts;
            $max_risk = 10;
            $risk = $CLASSIC_likelihood * $CLASSIC_impact;
        } else if ($settingRiskModelvalue == 4) {
            // $max_risk = 30;
            $max_risk = $countOfLikelihoods * $countOfImpacts + $countOfLikelihoods;
            $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + $CLASSIC_likelihood;
        } else if ($settingRiskModelvalue == 5) {
            // $max_risk = 35;
            $max_risk = ($countOfLikelihoods * $countOfImpacts) + (2 * $countOfLikelihoods);
            $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + (2 * $CLASSIC_likelihood);
        } else if ($settingRiskModelvalue == 6) {
            $max_risk = 10;
            $risk = CustomRiskModelValue::select('value')->where('impact_id', '=', $CLASSIC_impact)->where('likelihood_id', '=', $CLASSIC_likelihood)->get();

            // $risk = get_stored_risk_score($impact, $likelihood);
        }
        // This puts it on a 1 to 10 scale similar to CVSS
        $risk = round($risk * (10 / $max_risk), 1);
    } else { // If the impact or likelihood are not passed
        $risk = Setting::select('value')->where('name', 'default_risk_score')->first()['value'];
    }

    return $risk ? $risk : 0;
}

/*********************************
 * FUNCTION: SUBMIT RISK SCORING *
 *********************************/
function submit_risk_scoring($riskId, $riskScoringMethodId = "1", $CLASSIC_likelihood = "", $CLASSIC_impact = "", $AccessVector = "N", $AccessComplexity = "L", $Authentication = "N", $ConfImpact = "C", $IntegImpact = "C", $AvailImpact = "C", $Exploitability = "ND", $RemediationLevel = "ND", $ReportConfidence = "ND", $CollateralDamagePotential = "ND", $TargetDistribution = "ND", $ConfidentialityRequirement = "ND", $IntegrityRequirement = "ND", $AvailabilityRequirement = "ND", $DREADDamage = "10", $DREADReproducibility = "10", $DREADExploitability = "10", $DREADAffectedUsers = "10", $DREADDiscoverability = "10", $OWASPSkill = "10", $OWASPMotive = "10", $OWASPOpportunity = "10", $OWASPSize = "10", $OWASPDiscovery = "10", $OWASPExploit = "10", $OWASPAwareness = "10", $OWASPIntrusionDetection = "10", $OWASPLossOfConfidentiality = "10", $OWASPLossOfIntegrity = "10", $OWASPLossOfAvailability = "10", $OWASPLossOfAccountability = "10", $OWASPFinancialDamage = "10", $OWASPReputationDamage = "10", $OWASPNonCompliance = "10", $OWASPPrivacyViolation = "10", $custom = "10", $ContributingLikelihood = "", $ContributingImpacts = [])
{
    $calculatedRiskValue = '';
    if ($riskScoringMethodId == 1) { // If the scoring method is Classic (1)

        // Calculate the risk via classic method
        $calculatedRiskValue = calculate_risk($CLASSIC_impact, $CLASSIC_likelihood);

        // Set default impact value
        if (!$CLASSIC_impact) {
            $CLASSIC_impact = Impact::count();
        }

        // Set default likelihood value
        if (!$CLASSIC_likelihood) {
            $CLASSIC_likelihood = Likelihood::count();
        }

        // Add risk scoring
        RiskScoring::create([
            'id' => $riskId,
            'scoring_method' => $riskScoringMethodId,
            'calculated_risk' => $calculatedRiskValue,
            'CLASSIC_likelihood' => $CLASSIC_likelihood,
            'CLASSIC_impact' => $CLASSIC_impact,
        ]);
    }

    // Add risk scoring history
    add_risk_scoring_history($riskId, $calculatedRiskValue);

    // Add residual risk scoring history
    $residualRisk = get_residual_risk($riskId);
    add_residual_risk_scoring_history($riskId, $residualRisk);

    return true;
}

/**************************************
 * FUNCTION: add_risk_scoring_history *
 **************************************/
function add_risk_scoring_history($riskId, $calculatedRisk)
{
    $riskScoringHistory = RiskScoringHistory::where('risk_id', $riskId)->orderBy('last_update', 'DESC')->first();

    // Check if row exists
    if ($riskScoringHistory && $riskScoringHistory->calculated_risk == $calculatedRisk) {
        return;
    } else { // There is no entry like that, adding new one

        $lastUpdate = date('Y-m-d H:i:s');

        RiskScoringHistory::create([
            'risk_id' => $riskId,
            'calculated_risk' => $calculatedRisk,
            'last_update' => $lastUpdate,
        ]);
    }
}

/******************************************
 * FUNCTION: GET RESIDUAL RISK BY RISK ID *
 ******************************************/
function get_residual_risk($riskId)
{
    $risk = DB::select("SELECT t2.calculated_risk, GREATEST(IFNULL(t3.mitigation_percent, 0), IFNULL(MAX(t4.mitigation_percent), 0)) AS mitigation_percent
        FROM risks t1
            LEFT JOIN risk_scorings t2 ON t1.id=t2.id
            LEFT JOIN mitigations t3 ON t1.id=t3.risk_id
            LEFT JOIN mitigation_to_controls mtc ON t3.id=mtc.mitigation_id
            LEFT JOIN framework_controls t4 ON mtc.control_id=t4.id AND t4.deleted=0
        WHERE t1.id=?
        GROUP BY t1.id;", [$riskId])[0];

    $risk = json_decode(json_encode($risk), true);

    $risk['calculated_risk'] = empty($risk['calculated_risk']) ? 0 : $risk['calculated_risk'];
    $risk['mitigation_percent'] = empty($risk['mitigation_percent']) ? 0 : $risk['mitigation_percent'];

    $residual_risk = round($risk['calculated_risk'] * (100 - $risk['mitigation_percent']) / 100, 2);

    return $residual_risk ? $residual_risk : "0.0";
}

/**********************************************
 * FUNCTION: add_residual_risk_scoring_history *
 ***********************************************/
function add_residual_risk_scoring_history($riskId, $residualRisk)
{
    $residualRiskScoringHistory = ResidualRiskScoringHistory::where('risk_id', $riskId)->orderBy('last_update', 'DESC')->first();

    // Check if row exists
    if ($residualRiskScoringHistory && $residualRiskScoringHistory->residual_risk == $residualRisk) {
        return;
    } else { // There is no entry like that, adding new one

        $lastUpdate = date('Y-m-d H:i:s');

        ResidualRiskScoringHistory::create([
            'risk_id' => $riskId,
            'residual_risk' => $residualRisk,
            'last_update' => $lastUpdate,
        ]);
    }
}

/****************************
 * FUNCTION: GET RISK COLOR *
 ****************************/
function get_risk_color($calculated_risk)
{
    $riskLevel = RiskLevel::where('value', '<=', $calculated_risk)->orderBy('value', 'DESC')->first();

    if (!$riskLevel) {
        return "white";
    } else {
        return $riskLevel['color'];
    }
}

/*********************************
 * FUNCTION: GET RISK LEVEL NAME *
 *********************************/
function get_risk_level_name($calculated_risk)
{
    $riskLevel = RiskLevel::orderBy('value', 'desc')->where('value', '<=', $calculated_risk)->select('name', 'display_name')->first();

    if ($riskLevel->display_name != '') {
        return $riskLevel->display_name;
    } else if ($riskLevel->name != '') {
        return $riskLevel->name;
    } else {
        return "Insignificant";
    }
}

/**************************************
 * FUNCTION: GET CALCULATE RISK BY ID *
 **************************************/
function get_calculated_risk_by_id($risk_id)
{
    $risk = Risk::find($risk_id);

    if ($risk && $risk->riskScoring->calculated_risk) {
        return $risk->riskScoring->calculated_risk;
    } else {
        return 0;
    }
}

/****************************************************************************
 * FUNCTION: GET STANDARD DATE FROM STRING FORMATTED BY DEFAULT DATE FORMAT *
 ****************************************************************************/
function get_standard_date_from_default_format($formatted_date, $time = false)
{
    // Return 0000-00-00 if formatted date is invalid or unset
    if (!$formatted_date || strpos($formatted_date, "0000") !== false) {
        return "0000-00-00";
    }

    // If time is requested
    if ($time) {
        // Get default date format
        $format = get_default_datetime_format("H:i:s");

        // Convert date string to Y-m-d H:i:s date
        $d = DateTime::createFromFormat($format, $formatted_date);
        $standard_date = $d ? $d->format('Y-m-d H:i:s') : "";
    } else {
        // Get default date format
        $format = get_default_date_format();

        // Convert date string to Y-m-d date
        $d = DateTime::createFromFormat($format, $formatted_date);
        $standard_date = $d ? $d->format('Y-m-d') : "";
    }

    return $standard_date;
}

// /**********************************
//  * FUNCTION: GET AUDIT TRAIL *
//  **********************************/
// function get_audit_trail($id = NULL, $days = 7, $log_type=NULL)
// {
//     global $escaper;

//     // If the ID is greater than 1000 or NULL
//     if ($id > 1000 || $id === NULL)
//     {
//         $logs = get_audit_trail($id, $days, $log_type);

//         foreach ($logs as $log)
//         {
//             $date = date(get_default_datetime_format("g:i A T"), strtotime($log['timestamp']));

//             echo "<p>" . $escaper->escapeHtml($date) . " > " . $escaper->escapeHtml($log['message']) . "</p>\n";
//         }

//         // Return true
//         return true;
//     }
//     // Otherwise this is not a valid ID
//     else
//     {
//         // Return false
//         return false;
//     }
// }

/*****************************
 * FUNCTION: GET AUDIT TRAIL *
 *****************************/
function get_audit_trail($id = null, $days = 7, $log_type = null)
{
    $log = [];
    $query = "
            SELECT t1.timestamp, t1.message, t1.log_type, t1.user_id, t2.name user_fullname
            FROM audit_logs t1
                LEFT JOIN users t2 ON t1.user_id=t2.id
        ";

    // If the ID isn't null
    if ($id) {
        // If log_type is NULL, shows all logs
        if ($log_type === null) {
            $query .= " WHERE risk_id=:risk_id AND (`timestamp` > CURDATE()-INTERVAL :days DAY) ORDER BY timestamp DESC;";
            $logs = DB::select($query, ['risk_id' => $id, 'days' => $days]);
        } else {
            if (is_array($log_type)) {
                $log_type_array = $log_type;
            } else {
                $log_type_array = array($log_type);
            }

            $query .= " WHERE risk_id=:risk_id AND (`timestamp` > CURDATE()-INTERVAL :days DAY) AND FIND_IN_SET(log_type, :log_type)  ORDER BY timestamp DESC;";
            $log_type_str = implode(",", $log_type_array);
            $logs = DB::select($query, ['risk_id' => $id, 'days' => $days, 'log_type' => $log_type_str]);
        }
    } // If the ID is NULL
    else if ($id === null) {
        // If log_type is NULL, shows all logs
        if ($log_type === null) {
            $query .= " WHERE (`timestamp` > CURDATE()-INTERVAL :days DAY) ORDER BY timestamp DESC; ";
            $logs = DB::select($query, ['days' => $days]);
        } else {
            if (is_array($log_type)) {
                $log_type_array = $log_type;
            } else {
                $log_type_array = array($log_type);
            }
            $query .= " WHERE (`timestamp` > CURDATE()-INTERVAL :days DAY) AND FIND_IN_SET(log_type, :log_type) ORDER BY timestamp DESC; ";

            $log_type_str = implode(",", $log_type_array);
            $logs = DB::select($query, ['days' => $days, 'log_type' => $log_type_str]);
        }
    }

    // Return true
    return json_decode(json_encode($logs), true);
}

/**********************************
 * FUNCTION: GET MITIGATION BY ID *
 **********************************/
function get_mitigation_by_id($risk_id)
{
    // Query the database
    $query =
        "SELECT t1.*,
            GROUP_CONCAT(DISTINCT mtc.control_id) mitigation_controls,
            t1.risk_id AS id,
            t1.id AS mitigation_id,
            t2.name AS planning_strategy_name,
            t3.name AS mitigation_effort_name,
            t4.min_value AS mitigation_min_cost, t4.max_value AS mitigation_max_cost,
            t5.name AS mitigation_owner_name,
            GROUP_CONCAT(DISTINCT t6.id) AS mitigation_team,
            GROUP_CONCAT(DISTINCT t6.name) AS mitigation_team_name,
            t7.name AS submitted_by_name
        FROM mitigations t1
            LEFT JOIN `mitigation_to_controls` mtc ON t1.id=mtc.mitigation_id
            LEFT JOIN planning_strategies t2 ON t1.planning_strategy=t2.id
            LEFT JOIN mitigation_efforts t3 ON t1.mitigation_effort=t3.id
            LEFT JOIN asset_values t4 ON t1.mitigation_cost=t4.id
            LEFT JOIN users t5 ON t1.mitigation_owner=t5.id
            LEFT JOIN mitigation_to_teams mtt ON t1.id=mtt.mitigation_id
            LEFT JOIN teams t6 ON mtt.team_id=t6.id
            LEFT JOIN users t7 ON t1.submitted_by=t7.id
        WHERE t1.risk_id=:risk_id
        GROUP BY t1.id
        -- LIMIT 1
        ;
    ";

    $mitigation = DB::select($query, ['risk_id' => $risk_id]);

    return $mitigation;
}

/*****************************************
 * FUNCTION: GET DEFAULT ASSET VALUATION *
 *****************************************/
function get_default_asset_valuation()
{
    // Query the database
    $query = "SELECT value FROM `settings` WHERE name='default_asset_valuation'";

    $value = DB::select($query);

    // Return the value
    return $value[0]->value;
}

/***********************************
 * FUNCTION: GET ASSET VALUE BY ID *
 ***********************************/
function get_asset_value_by_id($id = "", $export = false)
{
    $default_asset_valuation = get_default_asset_valuation();

    // Query the database
    $query = "SELECT * FROM `asset_values`";
    $asset_values = DB::select($query);

    $value = "";
    foreach ($asset_values as $asset_value) {
        if ($asset_value->id == $id) {
            $value = $asset_value;
            break;
        }
    }

    // If a value exists
    if (empty($value)) {
        $id = $default_asset_valuation;

        foreach ($asset_values as $asset_value) {
            if ($asset_value->id == $id) {
                $value = $asset_value;
                break;
            }
        }
    }

    if (!empty($value)) {
        if ($value->min_value === $value->max_value) {
            $asset_value = get_setting("currency") . number_format($value->min_value);
        } else {
            $asset_value = get_setting("currency") . number_format($value->min_value) . " to " . get_setting("currency") . number_format($value->max_value);
        }

        if (!$export && !empty($value->valuation_level_name)) {
            $asset_value .= " ($value->valuation_level_name)";
        }
    } else {
        $asset_value = "Undefined";
    }

    // Return the asset value
    return $asset_value;
}

/***************************************
 * FUNCTION: GET NAMEs BY MULTI VALUES *
 ***************************************/
function get_names_by_multi_values($table, $values, $return_array = true, $impolode_separator = ", ", $use_id = true)
{

    if (is_array($values)) {
        $values = implode(",", $values);
    }

    // Query the database
    $query = "SELECT name FROM $table WHERE FIND_IN_SET(" . ($use_id ? "id" : "value") . ", :values);";
    $array = DB::select($query, ['values' => $values]);

    // If we get a value back from the query
    if ($array) {
        // Return that value
        return $return_array ? $array : implode($impolode_separator, $array);
    } // Otherwise, return an empty string/array
    else {
        return $return_array ? [] : "";
    }
}

/*********************************************************
 * FUNCTION: GET ACCEPTED MITIGATION BY USER AND RISK ID *
 *********************************************************/
function get_accpeted_mitigation($risk_id)
{
    // Query the database
    $query = "SELECT t1.user_id, t1.risk_id, t1.created_at, t2.username FROM `mitigation_accept_users` t1 LEFT JOIN `users` t2 ON t1.user_id=t2.id WHERE t1.risk_id=:risk_id AND t1.user_id=:user_id;";

    $infos = DB::select($query, ['risk_id' => $risk_id, 'user_id' => auth()->id()]);

    return $infos;
}

/**************************************
 * FUNCTION: GET ACCEPTED MITIGATIONS *
 **************************************/
function get_accpeted_mitigations($risk_id)
{
    // Query the database
    $query = "SELECT t1.user_id, t1.risk_id, t1.created_at, t2.username, t2.name FROM `mitigation_accept_users` t1 LEFT JOIN `users` t2 ON t1.user_id=t2.id WHERE t1.risk_id=:risk_id;";

    $infos = DB::select($query, ['risk_id' => $risk_id]);

    return $infos;
}

/**************************************
 * FUNCTION: VIEW ACCEPTED MITIGATIONS *
 ***************************************/
function get_accepted_mitigations($risk_id, $currentUser = false)
{
    $data = [];
    $infos = $currentUser ? get_accpeted_mitigation($risk_id) : get_accpeted_mitigations($risk_id);

    foreach ($infos as $info) {
        $data[] = array(
            'name' => isset($info->name) ? $info->name : "Unknown User",
            'date' => isset($info->created_at) ? date(get_default_date_format(), strtotime($info->created_at)) : "",
            'time' => $info->created_at ? date("H:i", strtotime($info->created_at)) : "",
        );
    }

    return $data;
}

/***************************
 * FUNCTION: VALIDATE DATE *
 ***************************/
function validate_date($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**********************************
 * FUNCTION: GET NEXT REVIEW DATE *
 **********************************/
function next_review($risk_level, $id, $next_review, $html = true, $review_levels = array(), $submission_date = false, $return_standard_format = false)
{
    // If the next_review is null
    if ($next_review == null) {
        // The risk has not been reviewed yet
        $text = __('locale.UNREVIEWED');
    } // If the risk has been reviewed
    else {
        // If the review used the default date
        if ($next_review != "0000-00-00") {
            // Get the last review for this risk
            if ($submission_date === false) {
                $last_review = get_last_review($id);
            } else {
                $last_review = $submission_date;
            }

            /* Start old logic */
            /*
            // Get the review levels
            if (!$review_levels) {
            $review_levels = get_review_levels();
            }

            $very_high_display_name = get_risk_level_display_name('Very High');
            $high_display_name      = get_risk_level_display_name('High');
            $medium_display_name    = get_risk_level_display_name('Medium');
            $low_display_name       = get_risk_level_display_name('Low');
            $insignificant_display_name = get_risk_level_display_name('Insignificant');

            // If very high risk
            if ($risk_level === $very_high_display_name) {
            // Get days to review very high risks
            $days = $review_levels[0]['value'];
            }
            // If high risk
            else if ($risk_level == $high_display_name) {
            // Get days to review high risks
            $days = $review_levels[1]['value'];
            }
            // If medium risk
            else if ($risk_level == $medium_display_name) {
            // Get days to review medium risks
            $days = $review_levels[2]['value'];
            }
            // If low risk
            else if ($risk_level == $low_display_name) {
            // Get days to review low risks
            $days = $review_levels[3]['value'];
            }
            // If insignificant risk
            //            else if ($color == "white")
            else {
            // Get days to review insignificant risks
            $days = $review_levels[4]['value'];
            }
             */
            /* End old logic */

            /* Start new logic */
            $riskLevelData = RiskLevel::where('name', $risk_level)->first();
            if ($riskLevelData) {
                // Get days to review very high risks
                $days = ReviewLevel::where('id', $riskLevelData->review_level_id)->pluck('value')->first();
            } else {
                // Get days to review insignificant risks
                $days = ReviewLevel::pluck('value')->first();
            }
            /* End new logic */

            // Next review date
            $last_review = new DateTime($last_review);
            $next_review = $last_review->add(new DateInterval('P' . $days . 'D'));
        } // A custom next review date was used
        else if ($next_review == __('locale.PASTDUE')) {
        } else {
            $next_review = new DateTime($next_review);
        }
        // If the next review date is after today
        if ($next_review != __('locale.PASTDUE') && (strtotime($next_review->format('Y-m-d')) + 24 * 3600) > time()) {
            $date_format = $return_standard_format ? 'Y-m-d' : get_default_date_format();

            $text = $next_review->format($date_format);
        } else {
            $text = __('locale.PASTDUE');
        }
    }

    // If we want to include the HTML code
    if ($html == true) {
        // Convert the database ID to a risk ID
        $risk_id = $id + 1000;

        // Add the href tag to make it HTML
        $html = "<a href=\"../management/view.php?id=" . $risk_id . "&type=2&action=editreview\">" . $text . "</a>";

        // Return the HTML code
        return $html;
    } // Otherwise just return the text
    else {
        return $text;
    }
}

/******************************
 * FUNCTION: GET REVIEW BY ID *
 ******************************/
function get_review_by_id($risk_id)
{
    $mgmtReview = MgmtReview::where('risk_id', $risk_id)->orderBy('submission_date', 'DESC')->first();

    // If the mgmtReview is empty
    if (empty($mgmtReview)) {
        return false;
    } else {
        return $mgmtReview->toArray();
    }
}

/**********************************
 * FUNCTION: GET LAST REVIEW DATE *
 **********************************/
function get_last_review($risk_id)
{
    $submissionDate = MgmtReview::where('risk_id', $risk_id)->orderBy('submission_date', 'DESC')->pluck('submission_date')->first();

    // If the array is empty
    if (!$submissionDate) {
        return "";
    } else {
        return $submissionDate;
    }
}

/*******************************
 * FUNCTION: GET REVIEW LEVELS *
 *******************************/
function get_review_levels()
{
    $reviewLevel = ReviewLevel::groupBy('id')->orderBy('value')->get()->toArray();

    return $reviewLevel;
}

/*****************************************
 * FUNCTION: GET RISK LEVEL DISPLAY NAME *
 *****************************************/
function get_risk_level_display_name($name)
{
    // Get the risk levels
    $riskLevelDisplayName = RiskLevel::where('name', $name)->pluck('display_name')->first();

    if ($name == "Insignificant" || !$name) {
        return "Insignificant";
    } else {
        return isset($riskLevelDisplayName) ? $riskLevelDisplayName : null;
    }
}

/************************************
 * FUNCTION: GET PROJECT BY RISK ID *
 ************************************/
function get_project_by_risk_id($risk_id)
{
    $project = Risk::find($risk_id)->project ?? null;
    if ($project) {
        return $project->toArray();
    } else {
        return [];
    }
}

/**************************
 * FUNCTION: GET REVIEWS *
 **************************/
function get_reviews($risk_id, $template_group_id = "")
{
    $mgmtReview = MgmtReview::where('risk_id', $risk_id)->orderBy('submission_date', 'DESC')->get();

    // If the mgmtReview is empty
    if (empty($mgmtReview)) {
        return [];
    } else {
        return $mgmtReview->toArray();
    }
}

/**
 * Get next review date by risk scoring
 *
 * @param mixed $risk_id
 */
function get_next_review_default($risk_id)
{
    $risk = Risk::with('riskScoring')->find($risk_id);

    if ($risk) {
        if (get_setting('next_review_date_uses') == "ResidualRisk") {
            $next_review = next_review_by_score(get_residual_risk($risk_id));
        } // If next_review_date_uses setting is Inherent Risk.
        else {
            $next_review = next_review_by_score($risk->riskScoring->calculated_risk);
        }
    } else {
        $next_review = "0000-00-00";
    }

    return $next_review;
}

/**************************************
 * FUNCTION: NEXT REVIEW BY SCORE *
 **********************************/
function next_review_by_score($calculated_risk)
{
    // Get risk level name by score
    $risk_level = get_risk_level_name($calculated_risk);

    /* Start new logic */
    $riskLevelData = RiskLevel::where('name', $risk_level)->first();
    if ($riskLevelData) {
        // Get days to review very high risks
        $days = ReviewLevel::where('id', $riskLevelData->review_level_id)->pluck('value')->first();
    } else {
        // Get days to review insignificant risks
        $days = ReviewLevel::pluck('value')->first();
    }
    /* End new logic */

    // Next review date
    $today = new DateTime('NOW');
    $next_review = $today->add(new DateInterval('P' . $days . 'D'));
    $default_date_format = get_default_date_format();
    $next_review = $next_review->format($default_date_format);

    // Return the next review date
    return $next_review;
}

/***********************************
 * FUNCTION: TEAM SEPARATION EXTRA *
 ***********************************/
function team_separation_extra()
{
    if (isset($GLOBALS['separation_extra'])) {
        return $GLOBALS['separation_extra'];
    }

    $setting = get_setting('team_separation');

    // If the setting is not empty
    if (!empty($setting)) {
        // If the setting is true or "true" or 1
        if ($setting === true || $setting === "true" || $setting === 1 || $setting === "1") {
            // The extra is enabled
            $GLOBALS['separation_extra'] = true;
        } else $GLOBALS['separation_extra'] = false;
    } else $GLOBALS['separation_extra'] = false;

    return $GLOBALS['separation_extra'];
}

/******************************
 * FUNCTION: ENCRYPTION EXTRA *
 ******************************/
function encryption_extra()
{
    if (isset($GLOBALS['encryption_extra'])) {
        return $GLOBALS['encryption_extra'];
    }

    $setting = get_setting('encryption');

    // If the setting is not empty
    if (!empty($setting)) {
        // If the setting is true or "true" or 1
        if ($setting === true || $setting === "true" || $setting === 1 || $setting === "1") {
            // The extra is enabled
            $GLOBALS['encryption_extra'] = true;
        } else $GLOBALS['encryption_extra'] = false;
    } else $GLOBALS['encryption_extra'] = false;

    return $GLOBALS['encryption_extra'];
}


/*************************************************************
 * FUNCTION: GET AREA DATA FROM LIKELIHOOD AND IMPACT VALUES *
 *************************************************************/
function get_area_series_from_likelihood_impact($likelihood, $impact)
{
    $likelihood = (int)$likelihood;
    $impact = (int)$impact;

    $risk_score = calculate_risk($impact, $likelihood);

    $data = array(
        [
            "x" => $likelihood - 1,
            "y" => $impact - 1,
            "risk" => calculate_risk($impact - 1, $likelihood - 1),
        ],
        [
            "x" => $likelihood - 1,
            "y" => $impact,
            "risk" => calculate_risk($impact, $likelihood - 1),
        ],
        [
            "x" => $likelihood,
            "y" => $impact,
            "risk" => calculate_risk($impact, $likelihood),
        ],
        [
            "x" => $likelihood,
            "y" => $impact - 1,
            "risk" => calculate_risk($impact - 1, $likelihood),
        ],
        [
            "x" => $likelihood - 1,
            "y" => $impact - 1,
        ],
    );
    $color = get_risk_color($risk_score);

    $area_series = array(
        'type' => 'area',
        'color' => convert_color_code($color) . "ff",
        'data' => $data,
        'enableMouseTracking' => false,
        'states' => [
            'hover' => [
                'enabled' => false
            ]
        ],
        'stickyTracking' => false,
    );

    return $area_series;
}

function convert_color_code($color_name)
{
    // standard 147 HTML color names
    $colors = array(
        'aliceblue' => 'F0F8FF',
        'antiquewhite' => 'FAEBD7',
        'aqua' => '00FFFF',
        'aquamarine' => '7FFFD4',
        'azure' => 'F0FFFF',
        'beige' => 'F5F5DC',
        'bisque' => 'FFE4C4',
        'black' => '000000',
        'blanchedalmond ' => 'FFEBCD',
        'blue' => '0000FF',
        'blueviolet' => '8A2BE2',
        'brown' => 'A52A2A',
        'burlywood' => 'DEB887',
        'cadetblue' => '5F9EA0',
        'chartreuse' => '7FFF00',
        'chocolate' => 'D2691E',
        'coral' => 'FF7F50',
        'cornflowerblue' => '6495ED',
        'cornsilk' => 'FFF8DC',
        'crimson' => 'DC143C',
        'cyan' => '00FFFF',
        'darkblue' => '00008B',
        'darkcyan' => '008B8B',
        'darkgoldenrod' => 'B8860B',
        'darkgray' => 'A9A9A9',
        'darkgreen' => '006400',
        'darkgrey' => 'A9A9A9',
        'darkkhaki' => 'BDB76B',
        'darkmagenta' => '8B008B',
        'darkolivegreen' => '556B2F',
        'darkorange' => 'FF8C00',
        'darkorchid' => '9932CC',
        'darkred' => '8B0000',
        'darksalmon' => 'E9967A',
        'darkseagreen' => '8FBC8F',
        'darkslateblue' => '483D8B',
        'darkslategray' => '2F4F4F',
        'darkslategrey' => '2F4F4F',
        'darkturquoise' => '00CED1',
        'darkviolet' => '9400D3',
        'deeppink' => 'FF1493',
        'deepskyblue' => '00BFFF',
        'dimgray' => '696969',
        'dimgrey' => '696969',
        'dodgerblue' => '1E90FF',
        'firebrick' => 'B22222',
        'floralwhite' => 'FFFAF0',
        'forestgreen' => '228B22',
        'fuchsia' => 'FF00FF',
        'gainsboro' => 'DCDCDC',
        'ghostwhite' => 'F8F8FF',
        'gold' => 'FFD700',
        'goldenrod' => 'DAA520',
        'gray' => '808080',
        'green' => '008000',
        'greenyellow' => 'ADFF2F',
        'grey' => '808080',
        'honeydew' => 'F0FFF0',
        'hotpink' => 'FF69B4',
        'indianred' => 'CD5C5C',
        'indigo' => '4B0082',
        'ivory' => 'FFFFF0',
        'khaki' => 'F0E68C',
        'lavender' => 'E6E6FA',
        'lavenderblush' => 'FFF0F5',
        'lawngreen' => '7CFC00',
        'lemonchiffon' => 'FFFACD',
        'lightblue' => 'ADD8E6',
        'lightcoral' => 'F08080',
        'lightcyan' => 'E0FFFF',
        'lightgoldenrodyellow' => 'FAFAD2',
        'lightgray' => 'D3D3D3',
        'lightgreen' => '90EE90',
        'lightgrey' => 'D3D3D3',
        'lightpink' => 'FFB6C1',
        'lightsalmon' => 'FFA07A',
        'lightseagreen' => '20B2AA',
        'lightskyblue' => '87CEFA',
        'lightslategray' => '778899',
        'lightslategrey' => '778899',
        'lightsteelblue' => 'B0C4DE',
        'lightyellow' => 'FFFFE0',
        'lime' => '00FF00',
        'limegreen' => '32CD32',
        'linen' => 'FAF0E6',
        'magenta' => 'FF00FF',
        'maroon' => '800000',
        'mediumaquamarine' => '66CDAA',
        'mediumblue' => '0000CD',
        'mediumorchid' => 'BA55D3',
        'mediumpurple' => '9370D0',
        'mediumseagreen' => '3CB371',
        'mediumslateblue' => '7B68EE',
        'mediumspringgreen' => '00FA9A',
        'mediumturquoise' => '48D1CC',
        'mediumvioletred' => 'C71585',
        'midnightblue' => '191970',
        'mintcream' => 'F5FFFA',
        'mistyrose' => 'FFE4E1',
        'moccasin' => 'FFE4B5',
        'navajowhite' => 'FFDEAD',
        'navy' => '000080',
        'oldlace' => 'FDF5E6',
        'olive' => '808000',
        'olivedrab' => '6B8E23',
        'orange' => 'FFA500',
        'orangered' => 'FF4500',
        'orchid' => 'DA70D6',
        'palegoldenrod' => 'EEE8AA',
        'palegreen' => '98FB98',
        'paleturquoise' => 'AFEEEE',
        'palevioletred' => 'DB7093',
        'papayawhip' => 'FFEFD5',
        'peachpuff' => 'FFDAB9',
        'peru' => 'CD853F',
        'pink' => 'FFC0CB',
        'plum' => 'DDA0DD',
        'powderblue' => 'B0E0E6',
        'purple' => '800080',
        'red' => 'FF0000',
        'rosybrown' => 'BC8F8F',
        'royalblue' => '4169E1',
        'saddlebrown' => '8B4513',
        'salmon' => 'FA8072',
        'sandybrown' => 'F4A460',
        'seagreen' => '2E8B57',
        'seashell' => 'FFF5EE',
        'sienna' => 'A0522D',
        'silver' => 'C0C0C0',
        'skyblue' => '87CEEB',
        'slateblue' => '6A5ACD',
        'slategray' => '708090',
        'slategrey' => '708090',
        'snow' => 'FFFAFA',
        'springgreen' => '00FF7F',
        'steelblue' => '4682B4',
        'tan' => 'D2B48C',
        'teal' => '008080',
        'thistle' => 'D8BFD8',
        'tomato' => 'FF6347',
        'turquoise' => '40E0D0',
        'violet' => 'EE82EE',
        'wheat' => 'F5DEB3',
        'white' => 'FFFFFF',
        'whitesmoke' => 'F5F5F5',
        'yellow' => 'FFFF00',
        'yellowgreen' => '9ACD32'
    );

    $color_name = strtolower($color_name);
    if (isset($colors[$color_name])) {
        return ('#' . $colors[$color_name]);
    } else {
        return ($color_name);
    }
}


/************************
 * FUNCTION: CLOSE RISK *
 ************************/
function close_risk($risk_id, $user_id, $status, $close_reason, $note, $closure_date = false)
{
    $risk = Risk::find($risk_id);

    // Get current datetime for last_update
    $current_datetime = date('Y-m-d H:i:s');

    $data = [
        'risk_id' => $risk_id,
        'user_id' => $user_id,
        'close_reason' => $close_reason,
        'note' => $note,
    ];

    // Add the closure
    if ($closure_date !== false) {
        $data['closure_date'] = $closure_date;
    }

    // Get the new mitigation id
    $close_id = Closure::create($data);

    // Update the risk status and last_update
    $risk->update([
        'status' => $status,
        // 'last_update' => $current_datetime,
        'close_id' => $close_id,
    ]);

    // Audit log
    $message = "Risk ID \"" . ($risk->id + 1000) . "\" was marked as closed by username \"" . (auth()->user()->name) . "\".";
    write_log($risk->id, auth()->id(), $message);

    return true;
}

function getFirstChartacterOfEachWord($text, $limit = 10)
{
    if (!$text)
        return '';

    $words = preg_split('/\s+/u', $text); // Split by whitespace characters (handles multibyte characters)
    $acronym = "";

    $counter = 0;
    foreach ($words as $w) {
        $firstChar = mb_substr($w, 0, 1, 'UTF-8'); // Get the first character of the word
        if (preg_match('/\p{L}/u', $firstChar)) { // Check if it's a letter
            $acronym .= $firstChar . '.'; // Append the first character
            $counter++;
            if ($counter == $limit) {
                break;
            }
        }
    }

    if ($acronym && $acronym[strlen($acronym) - 1] == '.') {
        $acronym = substr_replace($acronym, "", -1); // Remove trailing dot
    }

    return $acronym;
}

if (!function_exists('GetTeamsName')) {
    function GetTeamsName($teams)
    {
        $teamsId = explode(',', $teams);
        return Team::whereIn('id', $teamsId)->pluck('name');
    }
}

/*************************************************************
 * FUNCTION: GET mapped routes with it's permission key *
 *************************************************************/
function getRoutesToPermission()
{
    $routesToPermission = [
        // 'RouteName' => 'permission_key',

        // 'admin.dashboard' => '',

        // Asset Management
        'admin.asset_management.index' => 'asset.list',
        'admin.asset_management.ajax.index' => 'asset.list',
        'admin.asset_management.ajax.store' => 'asset.create',
        'admin.asset_management.ajax.show' => 'asset.list',
        'admin.asset_management.ajax.edit' => 'asset.update',
        'admin.asset_management.ajax.update' => 'asset.update',
        'admin.asset_management.ajax.destroy' => 'asset.delete',
        'admin.asset_management.ajax.export' => 'asset.export',
        // '' => 'asset.print',

        'admin.asset_management.asset_group.index' => 'asset_group.list',
        'admin.asset_management.ajax.asset_group.index' => 'asset_group.list',
        'admin.asset_management.ajax.asset_group.store' => 'asset_group.create',
        'admin.asset_management.ajax.asset_group.show' => 'asset_group.list',
        'admin.asset_management.ajax.asset_group.edit' => 'asset_group.update',
        'admin.asset_management.ajax.asset_group.update' => 'asset_group.update',
        'admin.asset_management.ajax.asset_group.destroy' => 'asset_group.delete',
        'admin.asset_management.ajax.asset_group.export' => 'asset_group.export',
        // '' => 'asset_group.print',

        // Compliance
        'admin.compliance.test.index' => 'tests.list',
        'admin.compliance.test.create' => 'tests.create',
        'admin.compliance.test.store' => 'tests.create',
        'admin.compliance.test.show' => 'tests.list',
        'admin.compliance.test.edit' => 'tests.update',
        'admin.compliance.test.update' => 'tests.update',
        'admin.compliance.test.destroy' => 'tests.delete',
        // '' => 'tests.print',
        // '' => 'tests.export',

        'admin.compliance.ajax.get-list-test' => 'tests.list',


        'admin.compliance.ajax.get-control-framework' => 'audits.list',
        'admin.compliance.ajax.get-control-family' => 'audits.list',
        'admin.compliance.audit.index' => 'audits.list',
        'admin.compliance.audit.create' => 'audits.create',
        'admin.compliance.audit.store' => 'audits.create',
        'admin.compliance.audit.show' => 'audits.list',
        'admin.compliance.audit.edit' => 'audits.result',
        'admin.compliance.audit.update' => 'audits.result',
        'admin.compliance.audit.destroy' => 'audits.delete',
        'admin.compliance.audit.ajax.active.export' => 'audits.export',
        'admin.compliance.audit.ajax.past.export' => 'audits.export',
        // '' => 'audits.print',

        'admin.compliance.audit-file.index' => 'audits.list',
        'admin.compliance.audit-file.create' => 'audits.create',
        'admin.compliance.audit-file.store' => 'audits.create',
        'admin.compliance.audit-file.show' => 'audits.list',
        'admin.compliance.audit-file.edit' => 'audits.update',
        'admin.compliance.audit-file.update' => 'audits.update',
        'admin.compliance.audit-file.destroy' => 'audits.delete',
        'admin.compliance.past-audits' => 'audits.list',
        'admin.compliance.ajax.get-audits' => 'audits.list',
        'admin.compliance.ajax.get-past-audits' => 'audits.list',
        'admin.compliance.ajax.risk-to-result' => 'audits.result',
        'admin.compliance.ajax.get-logs-audits' => 'audits.list',
        'admin.compliance.ajax.add-comment' => 'audits.list',
        'admin.compliance.remidation-request' => 'remidation.list',
        'admin.audit.frame.index' => 'audits.audit_plan',
        // Configure
        // 'admin.configure.index' => 'settings.list',
        // '' => 'settings.list',
        // '' => 'settings.create',
        // '' => 'settings.update',
        // '' => 'settings.delete',
        // '' => 'settings.print',
        // '' => 'settings.export',
        // 'admin.configure.add_values' => 'values.list',
        // 'admin.configure.userprofile.index' => '', // For all roles
        // 'admin.configure.userprofile.security' => '', // For all roles
        // 'admin.configure.change.password' => '', // For all roles

        // 'admin.configure.values.index' => 'values.list',
        // 'admin.configure.values.create' => 'values.create',
        // 'admin.configure.values.store' => 'values.create',
        // 'admin.configure.values.show' => 'values.list',
        // 'admin.configure.values.edit' => 'values.update',
        // 'admin.configure.values.update' => 'values.update',
        // 'admin.configure.values.destroy' => 'values.delete',
        'admin.configure.about.edit' => 'about.update',
        'admin.configure.about.ajax.update' => 'about.update',
        'admin.configure.general_setting.edit' => 'general-setting.update',
        'admin.configure.general_setting.ajax.update' => 'general-setting.update',
        'admin.configure.mail_settings' => 'email-setting.list',
        'admin.configure.mail_settings.store' => 'email-setting.create',
        'admin.governance.run-seeder' => 'frame-setting.list',
        'admin.governance.run-seeder.create' => 'frame-setting.download',

        // '' => 'values.export',
        // '' => 'values.print',

        // 'admin.configure.asset_values.index' => 'values.list',
        // 'admin.configure.asset_values.create' => 'values.create',
        // 'admin.configure.asset_values.store' => 'values.create',
        // 'admin.configure.asset_values.show' => 'values.list',
        // 'admin.configure.asset_values.edit' => 'values.update',
        // 'admin.configure.asset_values.update' => 'values.update',
        // 'admin.configure.asset_values.destroy' => 'values.delete',
        // 'admin.configure.risklevel.index' => 'values.list',
        // 'admin.configure.risklevel.create' => 'values.create',
        // 'admin.configure.risklevel.store' => 'values.create',
        // 'admin.configure.risklevel.show' => 'values.list',
        // 'admin.configure.risklevel.edit' => 'values.update',
        // 'admin.configure.risklevel.update' => 'values.update',
        // 'admin.configure.risklevel.destroy' => 'values.delete',
        'admin.configure.riskmodels.show' => 'classic_risk_formula.list',
        'admin.configure.riskmodels.update' => 'classic_risk_formula.update',
        'admin.configure.impact.create' => 'classic_risk_formula.create',
        'admin.configure.impact.delete' => 'classic_risk_formula.delete',
        'admin.configure.likelihood.create' => 'classic_risk_formula.create',

        'admin.configure.import.index' => 'import_and_export.list',
        'admin.configure.file-import' => 'import_and_export.import',
        'admin.configure.file-export' => 'import_and_export.export',
        'admin.configure.Impactorlikelhood.delete' => 'classic_risk_formula.delete',
        // 'admin.configure.risk-catalog.index' => 'values.list',
        // 'admin.configure.risk-catalog.create' => 'values.create',
        // 'admin.configure.risk-catalog.store' => 'values.create',
        // 'admin.configure.risk-catalog.show' => 'values.list',
        // 'admin.configure.risk-catalog.edit' => 'values.update',
        // 'admin.configure.risk-catalog.update' => 'values.update',
        // 'admin.configure.risk-catalog.destroy' => 'values.delete',
        // 'admin.configure.threat-catalog.index' => 'values.list',
        // 'admin.configure.threat-catalog.create' => 'values.create',
        // 'admin.configure.threat-catalog.store' => 'values.create',
        // 'admin.configure.threat-catalog.show' => 'values.list',
        // 'admin.configure.threat-catalog.edit' => 'values.update',
        // 'admin.configure.threat-catalog.update' => 'values.update',
        // 'admin.configure.threat-catalog.destroy' => 'values.delete',

        'admin.configure.file-download' => 'logs.export',

        'admin.configure.getlogs' => 'logs.list',

        // '' => 'user_management.print',
        // '' => 'user_management.export',

        // '' => 'classic_risk_formula.list',
        // '' => 'classic_risk_formula.print',
        // '' => 'classic_risk_formula.export',

        // 'admin.configure.storename' => '',
        'admin.configure.updateimpact' => 'classic_risk_formula.update',
        'admin.configure.updatelikelhood' => 'classic_risk_formula.update',
        'admin.configure.user.index' => 'user_management.list',
        'admin.configure.user.create' => 'user_management.create',
        'admin.configure.user.store' => 'user_management.create',
        'admin.configure.user.show' => 'user_management.list',
        'admin.configure.user.edit' => 'user_management.update',
        'admin.configure.user.update' => 'user_management.update',
        'admin.configure.user.destroy' => 'user_management.delete',
        'admin.configure.user.ajax.get-users' => 'user_management.list',
        'admin.configure.user.check-user-ldap' => 'user_management.create',
        'admin.configure.user.ajax.account-status' => 'user_management.update',
        'admin.configure.user.ajax.export' => 'user_management.export',


        // '' => 'logs.list',
        // '' => 'logs.create',
        // '' => 'logs.update',
        // '' => 'logs.delete',
        // '' => 'logs.print',
        'admin.configure.logs.index' => 'logs.list',

        'admin.configure.roles.index' => 'roles.list',
        'admin.configure.roles.role.store' => 'roles.create',
        'admin.configure.roles.ajax.show' => 'roles.list',
        'admin.configure.roles.ajax.update' => 'roles.update',
        'admin.configure.roles.ajax.destroy' => 'roles.delete',
        // '' => 'roles.print',
        // '' => 'roles.export',

        // 'admin.configure.permissions.index' => '', // For all roles
        // 'admin.configure.permissions.all' => '',
        'admin.configure.extras.LDAP-Configuration' => 'LDAP.list',
        'admin.configure.extras.LDAP-Configuration.save' => 'LDAP.update',
        'admin.configure.extras.LDAP-test-connection' => 'LDAP.test',


        // Governance
        // 'admin.governance.todo' => '',
        'admin.governance.index' => 'framework.list',
        'admin.governance.category' => 'document.list',
        'admin.governance.framework.store' => 'framework.create',
        'admin.governance.framework.update' => 'framework.update',
        'admin.governance.framework.destroy' => 'framework.delete',
        'admin.governance.framework.show' => 'framework.list',
        'admin.governance.framework.ajax.graphViewFramework' => 'framework.list',

        'admin.governance.control.store' => 'control.create',
        'admin.governance.control.list' => 'control.list',
        'admin.governance.ajax.get-list-control' => 'control.list',
        'admin.governance.control.store2' => 'control.create',
        'admin.governance.control.destroy' => 'control.delete',
        'admin.governance.ajax.get-list_control-map' => 'framework.list',
        // 'admin.governance.audit.store' => '',
        'admin.governance.category.store' => 'category.create',
        'admin.governance.category.update' => 'category.update',
        'admin.governance.category.destroy' => 'category.delete',
        'admin.governance.document.store' => 'document.create',
        'admin.governance.ajax.get-list-document' => 'document.list',
        'admin.governance.ajax.show_document' => 'document.list',
        // 'admin.governance.ajax.edit_document' => 'document.update',
        // 'admin.governance.document.update' => 'document.update',
        // 'admin.governance.document.destroy' => 'document.delete',
        'admin.governance.document.download' => 'document.download',
        // 'admin.governance.framecontrol.list' => 'document.update',
        // 'admin.governance.nextreview' => 'document.update',
        'admin.governance.framework.ajax.export' => 'framework.export',
        // '' => 'framework.print',

        // '' => 'control.list',
        // '' => 'control.print',
        // '' => 'control.export',

        // '' => 'category.list',
        // '' => 'category.print',
        // '' => 'category.export',

        // '' => 'document.list',
        // '' => 'document.print',
        // '' => 'document.export',

        // Reporting
        'admin.reporting.overviewReport' => 'reporting.Overview',
        'admin.reporting.riskDashboardReport' => 'reporting.Risk Dashboard',
        // 'admin.reporting.controlGapAnalysis' => 'reporting.Control Gap Analysis',
        // 'admin.reporting.displayGapAnalysisTable' => 'reporting.Control Gap Analysis',
        'admin.reporting.likelhoodImpactReport' => 'reporting.Likelihood And Impact',
        'admin.reporting.likelhoodImpactReportTooltip' => 'reporting.Likelihood And Impact',
        'admin.reporting.MyopenRiskReport' => 'reporting.All Open Risks Assigne To Me',
        'admin.reporting.MyopenRiskReport.ajax.index' => 'reporting.All Open Risks Assigne To Me',
        'admin.reporting.dynamicRiskReport' => 'reporting.Dynamic Risk Report',
        'admin.reporting.ajax.getDynamicRisks' => 'reporting.Dynamic Risk Report',
        'admin.reporting.GetRiskByControl' => 'riskmanagement.Risks and Controls',
        'admin.reporting.GetRiskByAsset' => 'riskmanagement.Risks and Assets',
        "admin.reporting.framewrok_control_compliance_status" => 'audits.framewrok_control_compliance_status',
        "admin.reporting.framewrok_control_compliance_status_info" => 'audits.framewrok_control_compliance_status',
        "admin.reporting.summary_of_results_for_evaluation_and_compliance" => 'audits.summary_of_results_for_evaluation_and_compliance',
        "admin.reporting.summary_of_results_for_evaluation_and_compliance_info" => 'audits.summary_of_results_for_evaluation_and_compliance',
        "admin.reporting.security_awareness_exam" => 'reporting.security-awareness-exam',
        "admin.reporting.security_awareness_exam_info" => 'reporting.security-awareness-exam',
        "admin.reporting.awareness_survey_info" => 'awareness-survey.awareness-survey-info',
        "admin.reporting.aawareness_survey_detail" => 'reporting.awareness-survey-detail/{id}',



        // Risk Management
        'admin.risk_management.index' => 'riskmanagement.list',
        'admin.risk_management.show' => 'riskmanagement.list',
        'admin.risk_management.ajax.download_file' => 'riskmanagement.list',
        'admin.risk_management.ajax.delete_file' => 'riskmanagement.update',
        'admin.risk_management.ajax.accept_reject_mitigation' => 'plan_mitigation.accept',
        'admin.risk_management.ajax.update_risk_mitigation' => 'plan_mitigation.create',
        'admin.risk_management.ajax.statistics.risk' => 'riskmanagement.Risk Dashboard',
        'admin.risk_management.ajax.add_risk_review' => 'perform_reviews.create',

        'admin.risk_management.ajax.risk_close_reason' => 'riskmanagement.AbleToCloseRisks',
        'admin.risk_management.ajax.risk_reopen' => 'riskmanagement.update',
        'admin.risk_management.ajax.risk_Change_Status' => 'riskmanagement.update',
        'admin.risk_management.ajax.reset_risk_mitigations' => 'riskmanagement.update',
        'admin.risk_management.ajax.reset_risk_reviews' => 'riskmanagement.update',
        'admin.risk_management.ajax.index' => 'riskmanagement.list',
        'admin.risk_management.ajax.store' => 'riskmanagement.create',
        'admin.risk_management.ajax.get_risk_levels' => 'riskmanagement.list',
        'admin.risk_management.ajax.residual_scoring_history' => 'riskmanagement.list',
        'admin.risk_management.ajax.get_scoring_histories' => 'riskmanagement.list',
        'admin.risk_management.ajax.update_subject' => 'riskmanagement.update',
        'admin.risk_management.ajax.update_risk_scoring' => 'riskmanagement.update',
        'admin.risk_management.ajax.add_comment' => 'riskmanagement.AbleToCommentRiskManagement',
        'admin.risk_management.ajax.update' => 'riskmanagement.update',
        'admin.risk_management.ajax.destroy' => 'riskmanagement.delete',
        'admin.risk_management.ajax.export' => 'riskmanagement.export',
        // '' => 'riskmanagement.print',

        // Hierarchy
        'admin.hierarchy.index' => 'hierarchy.list',
        'admin.hierarchy.org_chart' => 'hierarchy.list',
        'admin.hierarchy.ajax.index' => 'hierarchy.list',
        'admin.hierarchy.ajax.drag_and_drop' => 'hierarchy.update',

        'admin.hierarchy.job.index' => 'job.list',
        'admin.hierarchy.job.ajax.index' => 'job.list',
        'admin.hierarchy.job.ajax.store' => 'job.create',
        'admin.hierarchy.job.ajax.show' => 'job.list',
        'admin.hierarchy.job.ajax.edit' => 'job.update',
        'admin.hierarchy.job.ajax.update' => 'job.update',
        'admin.hierarchy.job.ajax.destroy' => 'job.delete',
        'admin.hierarchy.job.ajax.export' => 'job.export',
        // '' => 'job.print',

        'admin.hierarchy.department.index' => 'department.list',
        'admin.hierarchy.department.ajax.index' => 'department.list',
        'admin.hierarchy.department.ajax.store' => 'department.create',
        'admin.hierarchy.department.ajax.show' => 'department.list',
        'admin.hierarchy.department.ajax.edit' => 'department.update',
        'admin.hierarchy.department.ajax.update' => 'department.update',
        'admin.hierarchy.department.ajax.destroy' => 'department.delete',
        'admin.hierarchy.department.ajax.export' => 'department.export',
        // '' => 'department.print',

        'admin.change_request.ajax.export' => 'change-request.export',

        'admin.task.index' => 'task.create',
        'admin.task.assigned_to_me' => 'task.list',
        // 'admin.task.assigned_to_team' => 'task.list',
        'admin.task.calendar' => 'task.list',
        // 'admin.task.ajax.download_file' => 'task.list', // All
        'admin.task.ajax.store' => 'task.create',
        'admin.task.ajax.delete_file' => 'task.create',
        'admin.task.ajax.show' => 'task.list',
        'admin.task.ajax.edit' => 'task.create',
        'admin.task.ajax.update' => 'task.create',
        // 'admin.task.ajax.change_complete_status' => 'task.list', // All
        'admin.task.ajax.assignee_update_status' => 'task.list',
        'admin.task.ajax.destroy' => 'task.create',
        'admin.task.ajax.created.export' => 'task.export',
        'admin.task.ajax.assigned.export' => 'task.export',

        'phishing.domains.index' => 'domains.list',
        'phishing.domains.store' => 'domains.create',
        'phishing.domains.show' => 'domains.show',
        'phishing.domains.edit' => 'domains.edit',
        'phishing.domains.update' => 'domains.update',
        'phishing.domains.delete' => 'domains.delete',

        'admin.configure.general_setting.edit' => 'general-setting.update',
        'admin.configure.general_setting.ajax.update' => 'general-setting.update',

        'admin.vulnerability_management.index' => 'vulnerability_management.list',
        'admin.vulnerability_management.ajax.index' => 'vulnerability_management.list',
        'admin.vulnerability_management.ajax.store' => 'vulnerability_management.create',
        'admin.vulnerability_management.ajax.show' => 'vulnerability_management.list',
        'admin.vulnerability_management.ajax.edit' => 'vulnerability_management.update',
        'admin.vulnerability_management.ajax.update' => 'vulnerability_management.update',
        'admin.vulnerability_management.ajax.destroy' => 'vulnerability_management.delete',
        'admin.vulnerability_management.ajax.export' => 'vulnerability_management.export',

        'admin.configure.service_description.edit' => 'services-description.update',
        'admin.configure.service_description.ajax.update' => 'services-description.update',

        'admin.configure.change_request_department.edit' => 'change-request.change-request-department',
        'admin.configure.change_request_department.ajax.update' => 'change-request.change-request-department',

        'admin.configure.domain_management.index' => 'domain.list',
        'admin.configure.domain_management.ajax.index' => 'domain.list',
        'admin.configure.domain_management.ajax.store' => 'domain.create',
        'admin.configure.domain_management.ajax.edit' => 'domain.update',
        'admin.configure.domain_management.ajax.update' => 'domain.update',
        'admin.configure.domain_management.ajax.destroy' => 'domain.delete',
        'admin.configure.domain_management.ajax.export' => 'domain.export',

        'admin.KPI.index' => 'KPI.list',
        'admin.KPI.ajax.index' => 'KPI.list',
        'admin.KPI.ajax.store' => 'KPI.create',
        'admin.KPI.ajax.edit' => 'KPI.update',
        'admin.KPI.ajax.update' => 'KPI.update',
        'admin.KPI.ajax.destroy' => 'KPI.delete',
        'admin.KPI.ajax.export' => 'KPI.export',
        'admin.KPI.ajax.assessment.initiate' => 'KPI.Initiate assessment',
        'admin.KPI.ajax.assessment.list' => 'KPI.list',

        'admin.security_awareness.ajax.store' => 'security-awareness.create',
        'admin.security_awareness.ajax.export' => 'security-awareness.export',

        'admin.control_objectives.index' => 'control-objective.list',
        'admin.control_objectives.ajax.index' => 'control-objective.list',
        'admin.control_objectives.ajax.store' => 'control-objective.create',
        'admin.control_objectives.ajax.show' => 'control-objective.list',
        'admin.control_objectives.ajax.edit' => 'control-objective.update',
        'admin.control_objectives.ajax.update' => 'control-objective.update',
        'admin.control_objectives.ajax.destroy' => 'control-objective.delete',
        'admin.control_objectives.ajax.export' => 'control-objective.export',
        'admin.control_objectives.ajax.import' => 'control-objective.create',
        'admin.control_objectives.ajax.import.template' => 'control-objective.create',


        'admin.incident.index' => 'incident.list',
        'admin.languages.index' => 'language.create',


        // 'admin.phishing.campaign.index' => 'campaign.list',
        // 'admin.phishing.campaign.Datatable' => 'campaign.list',
        // 'admin.phishing.campaign.trash' => 'campaign.trash',
        // 'admin.phishing.campaign.approve' => 'campaign.campaign_approve',
        // 'admin.phishing.campaign.archivedcampaign' => 'campaign.trash',
        // 'admin.phishing.campaign.restore' => 'campaign.restore',
        // 'admin.phishing.campaign.delete' => 'campaign.delete',
        // 'admin.phishing.campaign.edit' => 'campaign.update',


        // 'admin.phishing.website.getAll' => 'website.list',
        // 'admin.phishing.website.trash' => 'website.trash',
        // 'admin.phishing.website.archivedwebsite' => 'website.trash',
        // 'admin.phishing.website.restore' => 'website.restore',
        // 'admin.phishing.website.delete' => 'website.delete',
        // 'admin.phishing.website.edit' => 'website.update',

        // 'admin.phishing.emailTemplate.index' => 'template.list',
        // 'admin.phishing.emailTemplate.trash' => 'template.trash',
        // 'admin.phishing.emailTemplate.archivedtemplate' => 'template.trash',
        // 'admin.phishing.emailTemplate.restore' => 'template.restore',
        // 'admin.phishing.emailTemplate.delete' => 'template.delete',
        // 'admin.phishing.emailTemplate.edit' => 'template.update',

        'admin.phishing.senderProfile.index' => 'sender_profile.list',
        'admin.phishing.senderProfile.trash' => 'sender_profile.trash',
        'admin.phishing.senderProfile.archivedtemplate' => 'sender_profile.trash',
        'admin.phishing.senderProfile.restore' => 'sender_profile.restore',
        'admin.phishing.senderProfile.delete' => 'sender_profile.delete',
        'admin.phishing.senderProfile.edit' => 'sender_profile.update',



        // ******************* LMS Permissions ***********************
        // Courses
        'admin.lms.courses.index' => 'courses.list',
        'admin.lms.courses.store' => 'courses.create',
        'admin.lms.courses.show' => 'courses.list',
        'admin.lms.courses.update' => 'courses.update',
        // 'admin.lms.courses.trash' => 'courses.trash',
        'admin.lms.courses.delete' => 'courses.delete',
        // 'admin.lms.courses.getCourseLevels' => 'courses.getCourseLevels',

        // Levels
        'admin.lms.levels.index' => 'levels.list',
        'admin.lms.levels.store' => 'levels.create',
        'admin.lms.levels.show' => 'levels.list',
        'admin.lms.levels.update' => 'levels.update',
        // 'admin.lms.levels.trash' => 'levels.trash',
        'admin.lms.levels.delete' => 'levels.delete',
        // 'admin.lms.levels.getLevelTrainingModules' => 'levels.getLevelTrainingModules',

        // Training
        'admin.lms.trainingModules.index' => 'trainingModules.list',
        'admin.lms.trainingModules.store' => 'trainingModules.create',
        'admin.lms.trainingModules.show' => 'trainingModules.list',
        'admin.lms.trainingModules.update' => 'trainingModules.update',
        // 'admin.lms.trainingModules.trash' => 'trainingModules.trash',
        'admin.lms.trainingModules.delete' => 'trainingModules.delete',
        // 'admin.lms.trainingModules.compliances' => 'trainingModules.compliances',

        // Exams
        'user.lms.training.modules.index' => 'exams.list',
        'user.lms.training.modules.getQuiz' => 'exams.getQuiz',
        // 'user.lms.training.modules.storeAnswer' => 'exams.storeAnswer',
        // 'user.lms.training.modules.submitQuiz' => 'exams.submitQuiz',
    ];

    return $routesToPermission;
}

if (!function_exists('getSystemSetting')) {
    function getSystemSetting($key, $default = '')
    {
        $setting = Setting::where('name', $key)->first();
        if (isset($setting->value)) {
            return $setting->value;
        } else {
            return $default ? $default : '';
        }
    }
}

// This function will have all key added for service desscription all these as added in `service_descriptions` table in `route` column
if (!function_exists('getServicesDescrptionKey')) {
    function getServicesDescrptionKey($value)
    {
        $servicesKey = [
            "admin.governance.index",
            "admin.governance.control.list",
            "admin.governance.category",
            "admin.risk_management.index",
            "admin.compliance.audit.index",
            "admin.compliance.past-audits",
            "admin.asset_management.index",
            "admin.asset_management.asset_group.index",
            "admin.reporting.overviewReport",
            "admin.reporting.riskDashboardReport",
            "admin.reporting.controlGapAnalysis",
            "admin.reporting.likelhoodImpactReport",
            "admin.reporting.MyopenRiskReport",
            "admin.reporting.dynamicRiskReport",
            "admin.reporting.GetRiskByControl",
            "admin.reporting.GetRiskByAsset",
            "admin.reporting.framewrok_control_compliance_status",
            "admin.reporting.summary_of_results_for_evaluation_and_compliance",
            "admin.reporting.security_awareness_exam",
            "admin.reporting.awareness_survey_info",
            "admin.configure.user.index",
            "admin.configure.add_values",
            "admin.configure.roles.index",
            "admin.configure.riskmodels.show",
            "admin.configure.logs.index",
            "admin.configure.import.index",
            "admin.configure.extras.LDAP-Configuration",
            "admin.configure.about.edit",
            "admin.configure.general_setting.edit",
            "admin.configure.service_description.edit",
            "admin.configure.change_request_department.edit",
            "admin.hierarchy.index",
            "admin.hierarchy.org_chart",
            "admin.hierarchy.department.index",
            "admin.hierarchy.job.index",
            "admin.task.index",
            "admin.task.assigned_to_me",
            "admin.vulnerability_management.index",
            "admin.change_request.index",
            "admin.KPI.index",
            "admin.security_awareness.index",
            "admin.awarness_survey.index",
            "admin.configure.mail_settings"
        ];

        if (array_search($value, $servicesKey) !== false)
            return true;
        else
            return false;
    }
}

// Get department id that responsible for change requests
function change_requests_responsible_department_id()
{
    return get_setting("change_requests_responsible_department_id");
}

// Get manager id that responsible for change requests
function change_requests_responsible_department_manager_id()
{
    $changeRequestsResponsibleDepartmentId = change_requests_responsible_department_id();
    if ($changeRequestsResponsibleDepartmentId) {
        $department = Department::find($changeRequestsResponsibleDepartmentId);

        return $department->manager_id ?? null;
    } else {
        return null;
    }
}

function isDepartmentManager()
{
    $managerIds = Department::pluck('manager_id')->toArray();
    return array_search(auth()->id(), $managerIds) === false ? false : true;
}

function getControlDocuments($controlID)
{
    return Document::whereRaw('FIND_IN_SET("' . $controlID . '",control_ids)')->pluck('id')->toArray(); // Get documents related to control
}

/**
 * Return a listing of prepared datatable fields
 * @param \Illuminate\Http\Request $request
 * @param \Array  &$dataTableDetails
 * @param \Array $customFilterFields
 *
 * @return \Array
 * KEYS:
 * draw
 * paginationDetails => ['start, length]
 * order => [column, dir]
 * search => [global, any custom fields...]
 */
function prepareDatatableRequestFields($request, array &$dataTableDetails, array $customFilterFields)
{
    /* Start reading datatable data for filtering */
    $dataTableDetails['draw'] = $request->draw;

    $dataTableDetails['paginationDetails'] = [
        'start' => $request->start, // Number of items will skipped
        'length' => $request->length, // Rows display per page
    ];

    $dataTableDetails['order'] = [
        "column" => $request->columns[$request->order[0]['column']]['data'], // Column name via index
        "dir" => $request->order[0]['dir']
    ];

    $dataTableDetails['search'] = [
        'global' => $request->search['value'] // Global search value
    ];

    $customFilterFieldRelationships = [];
    $singleRelationIsArray = false;
    foreach ($customFilterFields['relationships'] as $customFilterFieldRelationship) {
        if (is_array($customFilterFieldRelationship)) {
            $singleRelationIsArray = true;
            foreach ($customFilterFieldRelationship as $column => $relationshipName) {

                $customFilterFieldRelationships[] = $relationshipName;
            }
        }
    }

    if ($singleRelationIsArray) {
        $customFilterFields['relationships'] = $customFilterFieldRelationships;
    }

    foreach ($request->columns as $column) {
        if (
            in_array($column['data'], $customFilterFields['normal']) /* Get custom normal search filter*/ ||
            in_array($column['data'], $customFilterFields['relationships']) /* Get custom normal search filter */
        )
            $dataTableDetails['search'][$column['data']] = $column['search']['value'];
    }
}

/**
 * Add custom filter conditions for only passed filter fields content
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @param \Array $dataTableDetails
 * @param \Array $customFilterFields
 *
 */
function setCustomFiltersOnQuery(Illuminate\Database\Eloquent\Builder $query, array $dataTableDetails, array $customFilterFields)
{
    ## Add custom filter conditions (columns in the same main table)
    foreach ($customFilterFields['normal'] as $customFilterNormalField) {
        $query->when(!is_null($dataTableDetails['search'][$customFilterNormalField]), function ($q) use ($dataTableDetails, $customFilterNormalField) {
            return $q->where($customFilterNormalField, 'like', '%' . $dataTableDetails['search'][$customFilterNormalField] . '%');
        });
    }
    ## Add custom filter conditions (columns in other tables with relationships)
    foreach ($customFilterFields['relationships'] as $customFilterRelationshipsField) {
        $customFilterRelationshipsFieldColumn = 'name';
        if (is_array($customFilterRelationshipsField)) {
            foreach ($customFilterRelationshipsField as $column => $relationshipName) {
                $customFilterRelationshipsField = $customFilterRelationshipsField[$column];
                $customFilterRelationshipsFieldColumn = $column;
            }
        }

        $query->when(!is_null($dataTableDetails['search'][$customFilterRelationshipsField]), function ($nestedQuery1) use ($dataTableDetails, $customFilterRelationshipsField, $customFilterRelationshipsFieldColumn) {
            $nestedQuery1->whereHas($customFilterRelationshipsField, function (Builder $nestedQuery2) use ($dataTableDetails, $customFilterRelationshipsField, $customFilterRelationshipsFieldColumn) {
                $nestedQuery2->where($customFilterRelationshipsFieldColumn, 'like', '%' . $dataTableDetails['search'][$customFilterRelationshipsField] . '%');
            });
        });
    }
}

/**
 * Add like with all columns in table if global search passed
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @param \Array $dataTableDetails
 * @param \Array $customFilterFields
 *
 */
function setGlobalFiltersOnQuery(Illuminate\Database\Eloquent\Builder $query, array $dataTableDetails, array $customFilterFields, $anotherGlobalConditions = [])
{
    $query->when(!is_null($dataTableDetails['search']['global']) || count($anotherGlobalConditions), function ($q) use ($dataTableDetails, $customFilterFields, $anotherGlobalConditions) {
        return $q->where(function ($nestedQuery1) use ($dataTableDetails, $customFilterFields, $anotherGlobalConditions) {

            ## Add another global filter
            if (count($anotherGlobalConditions)) {
                foreach ($anotherGlobalConditions as $conditionReference => $conditionReferenceConditions) {
                    foreach ($conditionReferenceConditions as $column => $value) {
                        $nestedQuery1->$conditionReference($column, $value);
                    }
                }
            }

            ## Add custom filter conditions (columns in the same main table)
            foreach ($customFilterFields['normal'] as $customFilterRelationshipsField) {
                // May be where in first time
                $nestedQuery1->orWhere($customFilterRelationshipsField, 'like', '%' . $dataTableDetails['search']['global'] . '%');
            }
            ## Add custom filter conditions (columns in the same main table) other global filters
            foreach ($customFilterFields['other_global_filters'] as $customFilterRelationshipsField) {
                // May be where in first time
                $nestedQuery1->orWhere($customFilterRelationshipsField, 'like', '%' . $dataTableDetails['search']['global'] . '%');
            }

            ## Add custom filter conditions (columns in other tables with relationships)
            foreach ($customFilterFields['relationships'] as $customFilterRelationshipsField) {
                $customFilterRelationshipsFieldColumn = 'name';
                if (is_array($customFilterRelationshipsField)) {
                    foreach ($customFilterRelationshipsField as $column => $relationshipName) {
                        $customFilterRelationshipsField = $customFilterRelationshipsField[$column];
                        $customFilterRelationshipsFieldColumn = $column;
                    }
                }

                $nestedQuery1->orWhere(function ($nestedQuery2) use ($dataTableDetails, $customFilterRelationshipsField, $customFilterRelationshipsFieldColumn) {
                    $nestedQuery2->whereHas($customFilterRelationshipsField, function (Builder $nestedQuery3) use ($dataTableDetails, $customFilterRelationshipsFieldColumn) {
                        $nestedQuery3->where($customFilterRelationshipsFieldColumn, 'like', '%' . $dataTableDetails['search']['global'] . '%');
                    });
                });
            }
            return $nestedQuery1;
        });
    });
}

/**
 * Add custom filter conditions for only passed filter fields content
 * @param \String $Model
 * @param \Array $dataTableDetails
 * @param \Array $customFilterFields
 * @param \Array $conditions
 *
 */
function getDatatableFilterTotalRecordsCount(string $Model, array $dataTableDetails, array $customFilterFields, array $conditions = [], $anotherGlobalConditions = [])
{
    $records = $Model::select('count(*) as allcount');

    // Add predefined conditions
    if (count($conditions)) {
        if (isSequentialArray($conditions)) {
            foreach ($conditions as $index => $conditionRow) {
                if ($conditionRow['groupOfConditions'] === false) {
                    unset($conditionRow['groupOfConditions']);
                    foreach ($conditionRow as $conditionReference => $conditionReferenceConditions) {
                        foreach ($conditionReferenceConditions as $column => $value) {
                            $records->$conditionReference($column, $value);
                        }
                    }
                } else {
                    unset($conditionRow['groupOfConditions']);
                    $groupConditionReference = array_keys($conditionRow)[0];
                    $groupConditionReferenceConditions = $conditionRow[$groupConditionReference];
                    $records->when(count($groupConditionReferenceConditions ?? []), function ($q) use ($groupConditionReferenceConditions, $groupConditionReference) {
                        $q->$groupConditionReference(function ($q1) use ($groupConditionReferenceConditions) {
                            foreach ($groupConditionReferenceConditions as $groupConditionReferenceCondition) {
                                foreach ($groupConditionReferenceCondition as $groupConditionReferenceConditionReference => $groupConditionReferenceConditionReferenceConditions) {
                                    $q1->$groupConditionReferenceConditionReference(
                                        $groupConditionReferenceConditionReferenceConditions['column'],
                                        $groupConditionReferenceConditionReferenceConditions['operator'] ?? '=',
                                        $groupConditionReferenceConditionReferenceConditions['value'],
                                    );
                                }
                            }
                        });
                        return $q;
                    });
                }
            }
        } else
            foreach ($conditions as $conditionReference => $conditionReferenceConditions) {
                foreach ($conditionReferenceConditions as $column => $value) {
                    $records->$conditionReference($column, $value);
                }
            }
    }

    ## Add custom filter conditions for only passed filter fields content (columns in the same main table Or columns in other tables with relationships)
    setCustomFiltersOnQuery($records, $dataTableDetails, $customFilterFields);
    $totalRecords = $records->count(); // Getting total records count without apply global search

    // Add like with all columns in table if global search passed
    setGlobalFiltersOnQuery($records, $dataTableDetails, $customFilterFields, $anotherGlobalConditions);
    $totalRecordswithGlobalFilter = $records->count(); // Getting total records count with apply global search

    return [
        $totalRecords,
        $totalRecordswithGlobalFilter,
    ];
}

/**
 * Add custom filter conditions for only passed filter fields content
 * @param \String $Model
 * @param \Array $dataTableDetails
 * @param \Array $customFilterFields
 * @param \Array $conditions
 *
 */
function getDatatableFilterRecords(string $Model, array $dataTableDetails, array $customFilterFields, $relationshipsWithColumns, $mainTableColumns, array $conditions = [], array $relationshipsCount = [], $anotherGlobalConditions = [])
{
    $records = $Model::with($relationshipsWithColumns)->orderBy($dataTableDetails['order']['column'], $dataTableDetails['order']['dir'])
        ->select(DB::raw($mainTableColumns))->withCount($relationshipsCount);

    // Add predefined conditions
    if (count($conditions)) {
        if (isSequentialArray($conditions)) {
            foreach ($conditions as $index => $conditionRow) {
                if ($conditionRow['groupOfConditions'] === false) {
                    unset($conditionRow['groupOfConditions']);
                    foreach ($conditionRow as $conditionReference => $conditionReferenceConditions) {
                        foreach ($conditionReferenceConditions as $column => $value) {
                            $records->$conditionReference($column, $value);
                        }
                    }
                } else {
                    unset($conditionRow['groupOfConditions']);
                    $groupConditionReference = array_keys($conditionRow)[0];
                    $groupConditionReferenceConditions = $conditionRow[$groupConditionReference];
                    $records->when(count($groupConditionReferenceConditions ?? []), function ($q) use ($groupConditionReferenceConditions, $groupConditionReference) {
                        $q->$groupConditionReference(function ($q1) use ($groupConditionReferenceConditions) {
                            foreach ($groupConditionReferenceConditions as $groupConditionReferenceCondition) {
                                foreach ($groupConditionReferenceCondition as $groupConditionReferenceConditionReference => $groupConditionReferenceConditionReferenceConditions) {
                                    $q1->$groupConditionReferenceConditionReference(
                                        $groupConditionReferenceConditionReferenceConditions['column'],
                                        $groupConditionReferenceConditionReferenceConditions['operator'],
                                        $groupConditionReferenceConditionReferenceConditions['value'],
                                    );
                                }
                            }
                        });
                        return $q;
                    });
                }
            }
        } else
            foreach ($conditions as $conditionReference => $conditionReferenceConditions) {
                foreach ($conditionReferenceConditions as $column => $value) {
                    $records->$conditionReference($column, $value);
                }
            }
    }

    // Add like with all columns in table if global search passed
    setGlobalFiltersOnQuery($records, $dataTableDetails, $customFilterFields, $anotherGlobalConditions);

    ## Add custom filter conditions for only passed filter fields content (columns in the same main table Or columns in other tables with relationships)
    setCustomFiltersOnQuery($records, $dataTableDetails, $customFilterFields);

    return $records->skip($dataTableDetails['paginationDetails']['start'])
        ->take($dataTableDetails['paginationDetails']['length'])
        ->get();
}

/**
 * Get custom response for datatable ajax request
 * @param \Int $draw
 * @param \Int $totalRecords
 * @param \Int $totalRecordswithFilter
 * @param \Array $data_arr
 *
 */
function getDatatableAjaxResponse(int $draw, int $totalRecords, int $totalRecordswithFilter, array $data_arr)
{
    return array(
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );
}

/**
 * Get custom select for table columns
 * @param \String $table
 * @param \Array $columns array contsins columns or contain '*' to get all columns
 *
 */
function getTableColumnsSelect(string $table, array $columns)
{
    $selectStatement = $table . '.' . array_shift($columns);

    foreach ($columns as $coumn) {
        $selectStatement .= ', ' . $table . '.' . $coumn;
    }

    return $selectStatement;
}

function isSequentialArray(array &$arr)
{
    $idx = 0;
    foreach ($arr as $key => $val) {
        if ($key !== $idx)
            return FALSE;
        $idx++;
    }
    return TRUE;
}

if (!function_exists('makeEncrypted')) {
    function makeEncrypted($text)
    {
        if ($text) {
            return encrypt($text);
        }
    }
}


function isControlOwner()
{
    return false;
    $ownersIds = FrameworkControl::pluck('control_owner')->toArray();
    return array_search(auth()->id(), $ownersIds) === false ? false : true;
}

function isControlTester()
{
    return false;
    $testersIds = FrameworkControlTestAudit::pluck('tester')->toArray();
    return array_search(auth()->id(), $testersIds) === false ? false : true;
}
function isObjectiveResponsible()
{
    return true;
    $objectives = ControlControlObjective::all();
    $responsiblesIds =  $objectives->pluck('responsible_id')->toArray();
    $isObjectiveResponsible = array_search(auth()->id(), $responsiblesIds) === false ? false : true;
    if ($isObjectiveResponsible) {
        return $isObjectiveResponsible;
    } else {
        $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();;
        $responsibleTeamsIds =  $objectives->pluck('responsible_team_id')->toArray();
        return  array_intersect($loggedUserTeams, $responsibleTeamsIds);
    }
}
function checkUsersCount($count)
{
    $existCount =  User::count();
    if ($existCount >= $count) {
        return false;
    } else {
        return true;
    }
}