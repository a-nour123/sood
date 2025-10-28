<?php

namespace App\Http\Controllers\admin\configure;

use App\Events\ChangeRequestDepartementCreated;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangeRequestDepartmentController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['name' => __('locale.ChangeRequestsResponsibleDepartment')]];

        $changeRequestsResponsibleDepartmentId = get_setting("change_requests_responsible_department_id");
        $departments = Department::select('id', 'name')->get();

        return view('admin.content.configure.change_request_department.edit', compact('breadcrumbs', 'changeRequestsResponsibleDepartmentId', 'departments'));
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
            'department' => ['required', 'exists:departments,id'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('configure.ThereWasAProblemUpdatingTheChangeRequestsResponsibleDepartment') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {

                Setting::where('name', 'change_requests_responsible_department_id')->update(
                    ['value' => $request->department]
                );
                $responsible_department=$request->department;

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('configure.ChangeRequestsResponsibleDepartmentWasUpdatedSuccessfully'),
                );

                event(new ChangeRequestDepartementCreated($responsible_department));

                $message = __('configure.An Employee responsible of department Changed by') . ' "' . auth()->user()->name . '".';
                write_log(1, auth()->id(), $message, 'updating');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
}
