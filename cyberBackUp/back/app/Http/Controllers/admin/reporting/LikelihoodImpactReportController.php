<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\CustomRiskModelValue;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Risk;
use App\Models\RiskLevel;
use App\Models\RiskModel;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;

class LikelihoodImpactReportController extends Controller
{
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
            // dd($risk);
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

        // return $series;
        return view('admin.content.reporting.likelihoode-impact', compact('series', 'counters', 'tooltip_html'));
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
}
