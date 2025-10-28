<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\RiskCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RiskCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $tests = RiskCatalog::with('Risk_grouping', 'Risk_functions')->get()->map(function ($riskCatalog) {
            return (object)[
                'responsive_id' => $riskCatalog->id,
                'id' => $riskCatalog->id,
                'number' => $riskCatalog->number,
                'group_id' => $riskCatalog->Risk_grouping->name,
                'risk_function_id' => $riskCatalog->Risk_functions->name,
                'name' => $riskCatalog->name,
                'description' => $riskCatalog->description,
                // 'order' => $riskCatalog->order,
                'Actions' => $riskCatalog->id,
            ];
        });
        return response()->json($tests, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Extracting parameters from the URL-encoded string
            parse_str($request->request->get('data'), $requestData);
    
            // Log the extracted data for debugging
            Log::info('Extracted data:', $requestData);
    
            if ($request->ajax()) {
                $modelData = RiskCatalog::create([
                    'risk_grouping_id' => $requestData['risk_grouping_id'],
                    'risk_function_id' => $requestData['risk_function_id'],
                    'number' => $requestData['number'],
                    'name' => $requestData['name'],
                    'description' => $requestData['description'],
                    'order' => $requestData['order']
                ]);
                $message = __('locale.A Risk Catalog that name is') . ' "' . ($modelData->name ?? __('locale.[No Name]')) .  __('createdBy') . ' "' . auth()->user()->name . '".';
                write_log($modelData->id, auth()->id(), $message, 'Adding Risk Catalog');
                return $modelData;
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error during data insertion:', ['exception' => $e->getMessage()]);
            
            // Handle the error gracefully, return a response or redirect as needed
            // Example: return response()->json(['error' => 'Failed to insert data'], 500);
        }
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
            $riskcatalog = RiskCatalog::with('Risk_grouping', 'Risk_functions')->find($id);
            return $riskcatalog;
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
            $data =  array();
            parse_str($request->data, $data);
            $table_name = $request->table_name;
            $result = DB::table($table_name)->where('id', $id)->update(
                [
                    'risk_grouping_id' => $data['risk_grouping_id'],
                    'risk_function_id' => $data['risk_function_id'],
                    'number' => $data['number'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'order' => $data['order']
                ]
            );
            $message = __('locale.A Risk Catalog that name is') . ' "' . ($data['name'] ?? __('locale.[No Name]')) .  __('UpdatedBy') . ' "' . auth()->user()->name . '".';
            write_log($id, auth()->id(), $message, 'Adding Risk Catalog');
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
            DB::table($request->table_name)->where('id', $id)->delete();
            return "done";
        }
    }
}
