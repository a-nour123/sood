<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\ServiceDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceDescriptionController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
         $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['name' => __('locale.ServicesDescription')]];

        $servicesdescription = ServiceDescription::all();
        $servicesdescriptionKey = ServiceDescription::pluck('id');
        // dd($servicesdescription->toArray());
        // Read about data from file
        $about = json_decode(Storage::get('about/content.text'));

        return view('admin.content.configure.service_description.edit', compact('breadcrumbs', 'servicesdescription', 'about', 'servicesdescriptionKey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('configure.ThereWasAProblemUpdatingTheServicesDescription') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                foreach ($request->all() as $key => $description) {
                    ServiceDescription::where('key', $key)->update([
                        'description' => $description
                    ]);
                }

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('configure.ServicesDescriptionWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
}
