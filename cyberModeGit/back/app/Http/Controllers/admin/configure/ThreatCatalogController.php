<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\ThreatCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ThreatCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = ThreatCatalog::with('Threate_grouping')->get()->map(function ($Threat) {
            return (object)[
                'responsive_id' => $Threat->id,
                'id' => $Threat->id,
                'name' => $Threat->name,
                'threat_grouping_id' => $Threat->Threate_grouping->name ??'',
                'number' => $Threat->number,
                'description' => $Threat->description,
                // 'order' => $Threat->order,
                'Actions' => $Threat->id,
            ];
        });
        // dd($tests);
        return response()->json($tests, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $data =  array();
            parse_str($request->data, $data);
            $table_name = $request->table_name;
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $createdRecord = $model::create([
                'threat_grouping_id' => $data['threat_grouping_id'],
                'number' => $data['number'],
                'name' => $data['name'],
                'description' => $data['description'],
                'order' => $data['order']
            ]);
            $message = __('locale.A Threat Catalog that name is') . ' "' . ($createdRecord->name ?? __('locale.[No Name]')) .  __('UpdatedBy') . ' "' . auth()->user()->name . '".';
            write_log($createdRecord->id, auth()->id(), $message, 'Adding Threat Catalog');
            return $model;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $threat_groupings  = ThreatCatalog::with('Threate_grouping')->find($id);
            // dd($riskcatalog);
        }
        return $threat_groupings ;
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
            $data =  array();
            parse_str($request->data, $data);
            $table_name = $request->table_name;
            $result = DB::table($table_name)->where('id', $id)->update(
                [
                    'threat_grouping_id' => $data['threat_grouping_id'],
                    'number' => $data['number'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'order' => $data['order']
                ]
            );
            $message = __('locale.A Threat Catalog that name is') . ' "' . ($data['name'] ?? __('locale.[No Name]')) .  __('DeletedBy') . ' "' . auth()->user()->name . '".';
            write_log($id, auth()->id(), $message, 'Adding Threat Catalog');
            return $result;
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
            // dd($request);
            DB::table($request->table_name)->where('id', $id)->delete();
            return "done";
        }
    }
}
