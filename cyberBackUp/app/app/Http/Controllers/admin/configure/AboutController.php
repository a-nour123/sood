<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
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
         ['name' => __('locale.About')]];

        if (!Storage::exists('about/content.text')) {
            $data['vision'] = '';
            $data['message'] = '';
            $data['mission'] = '';
            $data['objectives'] = '';
            $data['responsibilities'] = '';

            // Store temporary about data to file
            Storage::put('about/content.text', json_encode($data));
        }
        // Read about data from file
        $about = json_decode(Storage::get('about/content.text'));
        // dd($about);

        return view('admin.content.configure.about.edit', compact('breadcrumbs', 'about'));
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
            'vision' => ['nullable', 'string'],
            'message' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string']
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('configure.ThereWasAProblemUpdatingTheAboutData') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                $data['vision'] = $request->vision;
                $data['message'] = $request->message;
                $data['mission'] = $request->mission;
                $data['objectives'] = $request->objectives;
                $data['responsibilities'] = $request->responsibilities;

                if (!Storage::exists('about/content.text')) {
                    Storage::put('about/content.text', '');
                }

                // Store about data to file
                Storage::put('about/content.text', json_encode($data));;

                $response = array(
                    'status' => true,
                    'message' => __('locale.AboutDataWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
}
