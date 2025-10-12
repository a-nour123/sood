<?php
namespace App\Http\Traits;

use App\Models\Asset;
use App\Models\FrameworkControl;
use App\Models\Mitigation;
use App\Models\MitigationToControl;
use App\Models\Risk;
use Illuminate\Support\Facades\DB;
trait RiskAssetTrait
{

    /**
     * check type
     *
     * @return true
     */
  public function RiskAsset($type, $filter = [])
{
    $row = [];
    if ($type == 2) {

        if(request()->asset == 0){
            $assets=Asset::all();
            return $assets; 
        }else{
            return $this->RisksByAssetOnly(['asset' => request()->asset]);

        }
        // RisksByAsset with asset filter
    } elseif ($type == 1) {
        // AssetsByRisk with risk filter
        return $this->AssetsByRiskOly(['risk' => request()->risk]);
     } //elseif ($type == 2) {
    //     // Default case (e.g., RisksByAsset without additional filters)
    //     return $this->RisksByAsset($filter);
    // }
    elseif ($type == 3) {
        // Default case (e.g., RisksByAsset without additional filters)

        if(request()->risk == 0){
         
    $risks=Risk::all();
    return $risks;
        }else{
            return $this->AssetsByRiskOly(['risk' => request()->risk]);

        }
    }
}


public function RisksByAssetOnly($filters)
{
    $assets = Asset::where('id', $filters['asset'])->get();
    return $assets; 
}

public function AssetsByRiskOly($filters)
{
    $risks = Risk::where('id', $filters['risk'])->get();
    return $risks;
}

}
