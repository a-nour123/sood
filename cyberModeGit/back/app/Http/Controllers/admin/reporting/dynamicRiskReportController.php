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
use App\Models\ScoringMethod;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Team;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Models\User;
use App\Models\RiskLevel;
use App\Models\ThreatCatalog;
use App\Traits\AssetTrait;
use Illuminate\Support\Facades\DB;

class dynamicRiskReportController extends Controller
{
    use AssetTrait;
    private $path = "admin.content.reporting.";
    /**
     * Display a view for dynamic Risk Report
     *
     * @return String
     */
    public function dynamicRiskReport()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.DynamicRiskReport')]];
        return view($this->path . 'dynamic-risk', compact('breadcrumbs'));
    }
    /**
     * Return a listing of risks
     *
     * @return \Illuminate\Http\Response
     */
    public function GetListRisk()
    {
        $risks = Risk::with(['source', 'closure', 'submittedBy', 'category']) // Add more relationships as needed
            ->get()
            ->map(function ($risk) {
                $calculatedRisk = $risk->riskScoring()->select('calculated_risk')->first()->calculated_risk;
    
                return (object) [
                    'responsive_id' => $risk->id,
                    'status' => $risk->status,
                    'subject' => $risk->subject,
                    'inherent_risk_current' => [$calculatedRisk, $this->riskScoringColor($calculatedRisk)],
                    'created_at' => $risk->created_at->format(get_default_date_format()),
                    'closure_date' => $risk->closure ? $risk->closure->closure_date : null,
                    'risk_catalog_mapping' => $this->threatCatalogsMappings($risk),
                    'threat_catalog_mapping' => $this->getThreatCatalogs($risk),
                    'submitted_by' => $risk->submittedBy->username,
                    'source_id' => $risk->source ? $risk->source->name : null,
                    'category_id' => $risk->category ? $risk->category->name : null,
                    'Actions' => $risk->id,
                ];
            });
    
        return response()->json($risks, 200);
    }
    
    
    // Custom method to retrieve threat catalogs based on the mapping
    protected function getThreatCatalogs($risk)
    {
        $threatCatalogIds = explode(',', $risk->threat_catalog_mapping);
        $threatCatalogs = ThreatCatalog::whereIn('id', $threatCatalogIds)
            ->select(DB::raw('CONCAT(number, " - ", name) as concatenated_value'))
            ->pluck('concatenated_value')
            ->toArray();
    
        return $threatCatalogs;
    }
    

    protected function threatCatalogsMappings($risk)
    {
        $threatCatalogMappingIds = explode(',', $risk->risk_catalog_mapping);
        $threatCatalogsMappings = DB::table('risk_catalogs')->whereIn('id', $threatCatalogMappingIds)
            ->select(DB::raw('CONCAT(number, " - ", name) as concatenated_value'))
            ->pluck('concatenated_value')
            ->toArray();
    
        return $threatCatalogsMappings;
    }

    // // to view only name or number 
    //     // Custom method to retrieve threat catalogs based on the mapping
    //  protected function getThreatCatalogs($risk)
    //     {
    //         $threatCatalogIds = explode(',', $risk->threat_catalog_mapping);
    //         $threatCatalogs = ThreatCatalog::whereIn('id', $threatCatalogIds)->pluck('number')->toArray();
        
    //         return $threatCatalogs;
    //     }
    //     protected function threatCatalogsMappings($risk)
    // {
    //     $threatCatalogMappingIds = explode(',', $risk->risk_catalog_mapping);
    //     $threatCatalogsMappings = DB::table('risk_catalogs')->whereIn('id', $threatCatalogMappingIds)->pluck('number')->toArray();
    
    //     return $threatCatalogsMappings;
    // } 
    
    
    

protected function riskScoringColor($riskScoring)
{
    $riskLevel = RiskLevel::orderBy('value', 'desc')->where('value', '<=', $riskScoring)->first();
    return $riskLevel ? $riskLevel->color : null;
}

}
