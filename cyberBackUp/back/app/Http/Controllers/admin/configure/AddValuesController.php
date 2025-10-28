<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThreatCatalog;
use App\Models\ThreatGrouping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ShowAddValue()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['name' => __('locale.Preparatorydata')]];
        $risk_groupings = RiskGrouping::all();
        $risk_functions = RiskFunction::all();
        $threat_groupings = ThreatGrouping::all();

        $addValueTables = [
            // TableName => Language key
            'department_colors' => 'DepartmentColor',
            'risk_levels' => 'RiskLevels',
            'asset_value_levels'=>'AssetValueLevels',
            'reviews' => 'Review',
            'asset_categories' => 'Asset_category',
            'asset_environment_categories' => 'Asset_environment_category',
            'next_steps' => 'NextStep',
            'categories' => 'RiskCategory',
            'teams' => 'Team',
            'technologies' => 'Technology',
            'locations' => 'SiteLocation',
            'planning_strategies' => 'RiskPlanningStrategy',
            'close_reason' => 'CloseReason',
            'control_phases' => 'ControlPhase',
            'control_priorities' => 'ControlPriority',
            'control_classes' => 'ControlClass',
            'control_types' => 'ControlType',
            'control_maturities' => 'ControlMaturity',
            'mitigation_efforts' => 'MitigationEffort',
            'risk_groupings' => 'RiskGrouping',
            'risk_functions' => 'RiskFunctions',
            'test_statuses' => 'AuditStatus',
            'threat_groupings' => 'ThreatGroupings',
            'risk_catalogs' => 'RiskCatalog',
            'threat_catalogs' => 'ThreatCatalog',
            // 'asset_values' => 'Asset Valuation',
            'operating_systems' => 'OperatingSystems',
            'sources'=>'RiskSource',
            'third_party_services' => 'ThirdPartyServices',
            'third_party_classifications' => 'ThirdPartyClassifications',
            'third_party_evaluations' => 'ThirdPartyEvaluation'
        ];

        return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $results = $model::all();
            return $results;
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->name;
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $data = [
                'name' => $name
            ];

            if ($request->has('color')) {
                $data['value'] = $request->color;
            }

            $modelData = $model::create($data);
            $modelName = class_basename($model);

            $message = __('locale.A New') . ' ' . ($modelName ?? __('locale.[No Model Name]')) . ' ' . __('locale.Added with name') . ' "' . ($modelData->name ?? '[No Name]') . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log($modelData->id, auth()->id(), $message, 'Creating');
            return $modelData;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $value)
    {
        if ($request->ajax()) {
            // dd($request);
            $table_name = $request->table_name;
            $name = $request->name;
            // DB::table($table_name)->where('id', $value)->update(array('name' => $name));
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));

            $data = [
                'name' => $name
            ];

            if ($request->has('color')) {
                $data['value'] = $request->color;
            }
            // dd($data);

            $model::where('id', $value)->update($data);
            $modelName = class_basename($model);
            $message = __('locale.') . ($modelName ?? __('locale.[No Model Name]')) . ' "' . ($data['name'] ?? '[No Name]') . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'Updating');
            return "done";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $value)
    {
        // dump($value);
        // dd($request->table_name);
        if ($request->ajax()) {
            // DB::table($request->table_name)->where('id', $value)->delete();
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            // dd($model);
            $model::where('id', $value)->delete();
            $modelName = class_basename($model);
            $message = __('locale.') . ($modelName ?? __('locale.[No Model Name]')) . ' ' . __('locale.Deleted item from it') . ' ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'deleting');
            return "done";
        }
    }
}
