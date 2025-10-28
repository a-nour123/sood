<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Category;
use App\Models\Framework;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Location;
use App\Models\Risk;
use App\Models\RiskGrouping;
use App\Models\RiskLevel;
use App\Models\ScoringMethod;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Team;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Models\User;
use Illuminate\Http\Request;

class AllOpenrisksReportController extends Controller
{
    public function index()
    {
        $riskGroupings = RiskGrouping::with('RiskCatalogs:id,number,name,risk_grouping_id')->get();
        $threatGroupings = ThreatGrouping::with('ThreatCatalogs:id,number,name,threat_grouping_id')->get();
        $categories = Category::all();
        $locations = Location::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        $assets = Asset::select('id', 'name')->orderBy('id')->get();
        $assetGroups = AssetGroup::all();
        $technologies = Technology::all();
        $teams = Team::all();
        $enabledUsers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        $tags = Tag::all();
        $riskSources = Source::all();
        $riskScoringMethods = ScoringMethod::all();
        $riskLikelihoods = Likelihood::all();
        $impacts = Impact::all();

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')],
        ['name' => __('locale.Submit Risk')]];
        return view('admin.content.reporting.all-open-risks', compact('breadcrumbs', 'riskGroupings', 'threatGroupings', 'locations', 'frameworks', 'assets', 'assetGroups', 'categories', 'technologies', 'teams', 'enabledUsers', 'riskSources', 'riskScoringMethods', 'riskLikelihoods', 'impacts', 'tags'));
    }

    public function ajaxGetList()
    {
        $risks = Risk::where([
            ['status', '<>', "Closed"],
        ])
            ->where(function ($q) {
                $q->where('owner_id', auth()->id())->orWhere('manager_id', auth()->id());
            })
            ->get()->map(function ($risk) {
                $calculatedRisk = $risk->riskScoring()->select('calculated_risk')->first()->calculated_risk;
                return (object)[
                    'responsive_id' =>  $risk->id,
                    'status' => $risk->status,
                    'subject' => $risk->subject,
                    'inherent_risk_current' => [$calculatedRisk, $this->riskScoringColor($calculatedRisk)],
                    // 'mitigation_planned' => 'No',
                    // 'management_review' => 'No',
                    'created_at' => $risk->created_at->format(get_default_date_format()),
                    'Actions' => $risk->id,
                ];
            });
        return response()->json($risks, 200);
    }
    protected function riskScoringColor($riskScoring)
    {
        return RiskLevel::orderBy('value', 'desc')->where('value', '<=', $riskScoring)->first()->color;
    }
    function getRiskLevels()
    {
        return getRiskLevels();
    }
    protected function getRiskValueData($calculated_risk)
    {
        $riskLevel = RiskLevel::orderBy('value', 'desc')->where('value', '<=', $calculated_risk)->first();
        $data = [];

        if ($riskLevel->display_name != '')
            $data['name'] = $riskLevel->display_name;
        else if ($riskLevel->name != '')
            $data['name'] = $riskLevel->name;
        else
            $data['name'] = "Insignificant";

        if (!$riskLevel)
            $data['color'] = "white";
        else
            $data['color'] = $riskLevel['color'];

        return $data;
    }
}
