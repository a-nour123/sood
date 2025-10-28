<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\SecurityAwareness;
use Illuminate\Http\Request;

class SecurityAwarenessExamController extends Controller
{

    /**
     * Display security awareness exam view report
     *
     * @return String
     */
    public function securityAwarenessExam()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.SecurityAwarenessExam')]];

        $securityAwarenesses = SecurityAwareness::has('exam')->get();

        return view('admin.content.reporting.security-awareness-exam', compact('breadcrumbs', 'securityAwarenesses'));
    }

    /**
     * Get security awareness exam info
     *
     * @return String
     */
    public function securityAwarenessExamInfo(Request $request)
    {
        $securityAwarenesses = SecurityAwareness::select('id')->with('exam')->find($request->security_awareness_id);
        if ($securityAwarenesses) {
            $data = [];
            $data['pass'] = 0;
            $data['fail'] = 0;
            $data['questions'] = $securityAwarenesses->exam->questions_count;
            $data['employees'] = [];
            $data['answers_founded'] = count($securityAwarenesses->exam->answers) > 0 ? true : false;
            foreach ($securityAwarenesses->exam->answers as $answer) {
                $employee = $answer->employee;
                $employeeOut = $answer->employeeOut;
            
                array_push(
                    $data['employees'],
                    [
                        'name' => $employee ? $employee->name : ($employeeOut ? $employeeOut->username : null),
                        'Type' => $employee ? 'Inside Cyber Mode' : ($employeeOut ? 'Outside Cyber Mode' : null),
                        'result' => $answer->success_answers . "/" . $data['questions'] . " (" . (($answer->success_answers / $data['questions']) * 100) . "%)",
                        'result_class' => ($answer->success_answers >= $answer->fail_answers) ? 'success' : 'danger',
                        'created_at' => $answer->created_at->format('Y-m-d H:i')
                    ]
                );
            
                if ($answer->success_answers >= $answer->fail_answers)
                    $data['pass']++;
                else
                    $data['fail']++;
            }

            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }
}
