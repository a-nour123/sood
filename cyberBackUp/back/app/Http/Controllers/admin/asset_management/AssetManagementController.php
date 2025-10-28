<?php

namespace App\Http\Controllers\admin\asset_management;

use App\Http\Controllers\Controller;
use App\Models\AssetValueCategory;
use App\Models\AssetValueQuestion;
use App\Models\HostRegion;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThreatGrouping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetManagementController extends Controller
{
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['name' => __('Asset Mgmt')],
          ['name' => __('locale.Automated Discovery')]];
        return view('admin.content.asset_management.index', compact('breadcrumbs'));
    }

    public function assetValueSettings()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link' =>  route('admin.asset_management.index'), 'name' => __('locale.asset_management')],
         ['name' => __('locale.AssetValueManagement')]];
        $categories = AssetValueCategory::all();
        return view('admin.content.asset_management.settings', compact('breadcrumbs', 'categories'));
    }
    
    public function configure(){

        $risk_groupings = RiskGrouping::all();
        $risk_functions = RiskFunction::all();
        $threat_groupings = ThreatGrouping::all();
        $host_regions = HostRegion::all();

        $addValueTables = [
            // TableName => Language key
            'asset_categories' => 'Asset_category',
            'asset_environment_categories' => 'Asset_environment_category',
            'asset_value_levels'=>'AssetValueLevels',
             'operating_systems' => 'OperatingSystems',
            'host_regions'=> 'host_regions',
        ];
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['link' =>  route('admin.asset_management.index'), 'name' => __('locale.asset_management')],
         ['name' => __('locale.Config')]];

        return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables','host_regions'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $exist_data = AssetValueQuestion::where('asset_value_category_id', $request->category_id)->get();
            foreach ($exist_data as $index => $data) {
                $data->update([
                    'question' => $request->questions[$index]
                ]);
            }

            DB::commit();
            $response = array(
                'status' => true,
                'message' => __('locale.AssetValueQuestionsWasUpdatedSuccessfully'),
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = array(
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
            );
            return response()->json($response, 502);
        }
    }
    public function store_answers(Request $request)
    {
        $result = [];
        foreach ($request->answer as $index => $answer) {
            $result[] = [
                'answer' => $answer,
                'value' => intval($request->answer_value[$index])
            ];
        }
        $jsonResult = json_encode($result);

        DB::beginTransaction();
        try {
            $exist_data = AssetValueQuestion::where('asset_value_category_id', $request->category_id)->get();
            foreach ($exist_data as $index => $data) {
                $data->update([
                    'answers' => $jsonResult
                ]);
            }
            DB::commit();
            $response = array(
                'status' => true,
                'message' => __('locale.AssetValueAnswersWasUpdatedSuccessfully'),
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = array(
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
            );
            return response()->json($response, 502);
        }
    }
}
