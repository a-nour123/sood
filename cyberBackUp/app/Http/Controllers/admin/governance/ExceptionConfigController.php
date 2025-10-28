<?php

namespace App\Http\Controllers\admin\governance;

use App\Http\Controllers\Controller;
use App\Models\ExceptionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ExceptionConfigController extends Controller
{

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'policy_approver' => ['required'],
            'policy_approver_id' => ['required_if:policy_approver,1'],
            'control_approver' => ['required'],
            'control_approver_id' => ['required_if:control_approver,1'],
            'risk_approver' => ['required'],
            'risk_approver_id' => ['required_if:risk_approver,1'],
            // 'policy_reviewer' => ['required'],
            // 'risk_reviewer' => ['required'],
            // 'control_reviewer' => ['required'], 
        ]);

        // Check if there is any validation error
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => 'Data required',
            ];
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                // Check if a record exists
                $exceptionSetting = ExceptionSetting::first(); // Modify the condition according to your requirement

                if ($exceptionSetting) {
                    // Update the existing record
                    $exceptionSetting->update([
                        'policy_approver' => $request->policy_approver,
                        // 'policy_reviewer' => $request->policy_reviewer,
                        'control_approver' => $request->control_approver,
                        // 'control_reviewer' => $request->control_reviewer,
                        'risk_approver' => $request->risk_approver,
                        // 'risk_reviewer' => $request->risk_reviewer,
                        'policy_approver_id' => $request->policy_approver_id,
                        'control_approver_id' => $request->control_approver_id,
                        'risk_approver_id' => $request->risk_approver_id,
                    ]);
                } else {
                    // Create a new record
                    ExceptionSetting::create([
                        'policy_approver' => $request->policy_approver,
                        // 'policy_reviewer' => $request->policy_reviewer,
                        'control_approver' => $request->control_approver,
                        // 'control_reviewer' => $request->control_reviewer,
                        'risk_approver' => $request->risk_approver,
                        // 'risk_reviewer' => $request->risk_reviewer,
                        'policy_approver_id' => $request->policy_approver_id,
                        'control_approver_id' => $request->control_approver_id,
                        'risk_approver_id' => $request->risk_approver_id,
                    ]);
                }

                DB::commit();

                // Redirect with success message
                // return redirect()->route('admin.governance.exception.index')
                //     ->with('success', __('locale.ConfigurationWasAddedSuccessfully'));

                $response = array(
                    'status' => true,
                    'message' => __('locale.ConfigurationWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                $response = [
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                ];
                return response()->json($response, 502);
            }
        }
    }

}
