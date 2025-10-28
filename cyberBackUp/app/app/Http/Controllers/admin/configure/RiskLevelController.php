<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\RiskLevel;
use App\Models\RiskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiskLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table_name = $request->table_name;
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $results = $model::all();
            // $results = DB::table($table_name)->get();
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
                'name' => $request->name,
                'value' => $request->colorvalue,
            ]);
            $message = __('configure.A New Risk Level Added with name') . ' "' . $modelData->name . '" ' . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
            write_log($modelData->id, auth()->id(), $message, 'Creating Risk level');
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
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));

            $data = [
                'name' => $request->name,
                'value' => $request->colorvalue,
                'color' => $request->color
            ];
            // dd($data );

            $model::where('id', $value)->update($data);
            $message = __('configure.A Risk Level') . ' "' . $data['name'] . '" ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
            write_log(1, auth()->id(), $message, 'Updating Risk level');
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
        if ($request->ajax()) {
            // DB::table($request->table_name)->where('id', $value)->delete();
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            // dd($model);
            $level = RiskLevel::find($value);
            $model::where('id', $value)->delete();
            $message = __('configure.A Risk Level') . ' "' . $level->name . '" ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
            write_log($level->id, auth()->id(), $message, 'Deleting Color');
            return "done";
        }
    }
}
