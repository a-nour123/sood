<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssetValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $results = $model::all();
            return $results;
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
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $modelData = $model::create([
                'min_value' => $request->min_value,
                'max_value' => $request->max_value,
                'valuation_level_name' => $request->valuation_level_name
            ]);

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
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $table_name = $request->table_name;
            $min_value = $request->min_value;
            $max_value = $request->max_value;
            $valuation_level_name = $request->valuation_level_name;

            DB::table($table_name)->where('id', $id)->update(array('min_value' => $min_value, 'max_value' => $max_value, 'valuation_level_name' => $valuation_level_name));

            return "done";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::table($request->table_name)->where('id', $id)->delete();
            return "done";
        }
    }
}
