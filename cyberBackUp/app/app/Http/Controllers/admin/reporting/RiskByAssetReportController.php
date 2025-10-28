<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;

use App\Http\Traits\RiskAssetTrait;
use App\Models\Asset;
use App\Models\Risk;

class RiskByAssetReportController extends Controller
{
    use RiskAssetTrait;

    private $path = "admin.content.reporting.";
    
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function GetRiskByAsset()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.risk_management.index'),'name' => __('locale.Risk Management')],
            ['name' => __('locale.Risks and Assets')],
        ];
    
        $types = [
            '2' => __('report.RisksByAsset'),
            '3' => __('report.AssetsByRisk')
        ];
    
        $currentType = request()->type ? request()->type : 0;
    
        // Set default values for $rows, $assets, and $risks
        $rows = $this->RiskAsset($currentType) ?? [];
        $assets = Asset::all();
        $risks = Risk::all();
        $currentAsset = 0;
        $currentRisk = 0;
    
        return view($this->path . 'risk-assets', compact('breadcrumbs', 'types', 'rows', 'currentType', 'assets', 'risks', 'currentAsset', 'currentRisk'));
    }


}
