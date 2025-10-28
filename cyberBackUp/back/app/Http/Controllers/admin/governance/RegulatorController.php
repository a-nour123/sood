<?php

namespace App\Http\Controllers\admin\governance;

use App\Http\Controllers\Controller;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThreatGrouping;
use Illuminate\Http\Request;




use App\Exports\AssetsExport;
use App\Models\Asset;
use App\Models\AssetValue;
use App\Models\Department;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Team;
use App\Models\Action;
use App\Models\User;
use App\Events\AssetCreated;
use App\Events\AssetUpdated;
use App\Events\AssetDeleted;
use App\Events\RegulatorCreated;
use App\Events\RegulatorUpdated;
use App\Models\AssetCategory;
use App\Models\AssetValueCategory;
use App\Models\AssetValueLevel;
use App\Imports\AssetsImport;
use App\Models\AssetEnvironmentCategory;
use App\Models\Family;
use App\Models\OperatingSystem;
use App\Models\Regulator;
use App\Traits\UpoladFileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class RegulatorController extends Controller
{
    use UpoladFileTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $regulators = Regulator::all();
        $families = Family::whereNull('parent_id')->select('id', 'name')->with('custom_families_framework:id,name,parent_id')->get();
        //Frameworks
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['name' => __('locale.Frameworks')]
        ];

        if (auth()->user()->hasPermission('regulator.list') || auth()->user()->hasPermission('framework.list') ) {
            return view('admin.content.governance.regulator_list', compact('breadcrumbs', 'regulators', 'families'));
        } else {
            abort(403, 'Unauthorized action.');
        }
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
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200', 'unique:regulators,name'],
            'logo' => ['required', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'] // File validation
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => __('governance.Regulators') . "<br>" . __('locale.Validation error'),
            ], 422);
        }

        DB::beginTransaction(); // Start database transaction
        try {

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                // $path = $this->storeFile($file, 'LMS/Courses');
                $path = $this->storeFileInStorage($file, 'public/regulators');
            }
            // Create the Regulator in the database
            $regulator = Regulator::create([
                'name' => $request->name,
                'logo' => $path,
            ]);

            // Commit the transaction after successful operation
            DB::commit();

            // Trigger the RegulatorCreated event
            event(new RegulatorCreated($regulator));

            return response()->json([
                'status' => true,
                'message' => __('locale.RegulatorWasAddedSuccessfully'),
            ], 200);
        } catch (\Throwable $th) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            return response()->json([
                'status' => false,
                'errors' => ['exception' => [$th->getMessage()]],
                'message' => __('locale.Error'),
            ], 502);
        }
    }




    public function storeFile($file, $publicPath, $oldStoredFileURL = null, $newStoredFileName = null)
    {
        // Start get file name
        if (!$newStoredFileName)
            $newStoredFileName = time() . '_' . $file->getClientOriginalName();

        // $newStoredFileName .= '.' . $file->getClientOriginalExtension();
        // End get file name


        // Start delete old stored file to server
        if ($oldStoredFileURL && file_exists($oldStoredFileURL))
            unlink($oldStoredFileURL);
        // End delete old stored file to server


        // Start store file to server
        $file->move(public_path($publicPath), $newStoredFileName);
        // End store file to server

        return $publicPath . '/' . $newStoredFileName;
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
    public function edit($id)
    {
        //
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
        $regulator = Regulator::find($id);
    
        if (!$regulator) {
            // Return 404 if regulator is not found
            return response()->json([
                'status' => false,
                'message' => __('locale.Error 404'),
            ], 404);
        }
    
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200', 'unique:regulators,name,' . $id], // Ensure the name is unique except for the current one
            'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'] // Optional file validation
        ]);
    
        // Check if there are validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => __('locale.ThereWasAProblemUpdatingTheRegulator') . "<br>" . __('locale.Validation error'),
            ], 422);
        }
    
        DB::beginTransaction();
    
        try {
            // Check if a logo file was uploaded
            $path = $regulator->logo; // Default to the current logo if no new logo is uploaded
    
            if ($request->hasFile('logo')) {
                // Delete the old logo if a new one is uploaded
                if ($path && Storage::exists($path)) {
                    Storage::delete($path);
                }
    
                // Upload the new logo file
                $file = $request->file('logo');
                $path = $this->storeFileInStorage($file, 'public/regulators'); // Adjust your storage method as needed
            }
    
            // Update regulator with the new data
            $regulator->update([
                'name' => $request->name,
                'logo' => $path,
            ]);
    
            // Fire the event for regulator update
            event(new RegulatorUpdated($regulator));
    
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => __('locale.RegulatorWasUpdatedSuccessfully'),
            ], 200);
    
        } catch (\Throwable $th) {
            // Rollback transaction on error
            DB::rollBack();
            
            // Return error message
            return response()->json([
                'status' => false,
                'errors' => ['exception' => [$th->getMessage()]],
                'message' => __('locale.Error'),
            ], 500);
        }
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
