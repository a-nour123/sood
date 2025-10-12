<?php

namespace App\Http\Controllers\PhysicalCourses;

use App\Http\Controllers\Controller;
use App\Models\AwarenessSurvey;
use App\Models\Course;
use App\Models\CourseAttendance;
use App\Models\CourseCertificate;
use App\Models\CourseRequest;
use App\Services\SurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseBrowseController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('user.lms.training.modules.userDashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('physicalCourses.physical_courses')],
        ];

        $openCourses = Course::with('instructors', 'schedules')
            ->where('open_registration', true)
            ->get();

        $myRequests = CourseRequest::where('user_id', Auth::id())
            ->with('course.schedules')
            ->get()
            ->groupBy('status');

        $certificates = CourseCertificate::where('user_id', auth()->id())
            ->with('course')
            ->orderBy('issued_at', 'desc')
            ->count();

        return view('physicalCourses.student.index', [
            'openCourses' => $openCourses,
            'myRequests' => $myRequests,
            'breadcrumbs' => $breadcrumbs,
            'certificates' => $certificates
        ]);
    }

    public function register(Course $course)
    {
        $exists = CourseRequest::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already registered.');
        }

        CourseRequest::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Registration request sent.');
    }

    public function show(Course $course)
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.student.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.physical_courses')],
        ];

        $request = CourseRequest::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->firstOrFail();

        $attendances = CourseAttendance::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->pluck('attended', 'course_schedule_id');

        // $survey = AwarenessSurvey::with('survyQuestions')->where('is_for_lms_physicalCourse', true)
        //     ->first() ?: AwarenessSurvey::with('survyQuestions')->first();

        $survey = $course->survey ? $course->survey->load('survyQuestions') : AwarenessSurvey::with('survyQuestions')->first();
        return view('physicalCourses.student.show', compact('course', 'attendances', 'request', 'breadcrumbs', 'survey'));
    }

    // Survey Methods
    public function showCourseSurvey($surveyId, $type, $id)
    {
        try {
            return $this->surveyService->showSurvey($surveyId, $type, $id);
        } catch (\Exception $e) {
            return back()->with('error', 'Survey not found or access denied.');
        }
    }

    public function submitSurvey(Request $request, $surveyId, $type, $id)
    {
        try {
            $response = $this->surveyService->submitSurvey($request, $surveyId, $type, $id);
            // Check if the request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax()) {
                if ($response->getStatusCode() === 200) {
                    $responseData = json_decode($response->getContent(), true);

                    return response()->json([
                        'success' => true,
                        'message' => $request->has('save_draft') ?
                            __('physicalCourses.survey_draft_saved') :
                            __('physicalCourses.survey_submitted_successfully'),
                        'response_id' => $responseData['response_id'] ?? null,
                        'is_draft' => $request->has('save_draft'),
                        'redirect_url' => !$request->has('save_draft') ?
                            route('admin.physical-courses.student.courses.index') : null
                    ], 200);
                } else {
                    $errors = json_decode($response->getContent(), true);
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to submit survey',
                        'errors' => $errors['errors'] ?? ['error' => 'Failed to submit survey']
                    ], $response->getStatusCode());
                }
            } else {
                // Handle non-AJAX requests (fallback)
                if ($response->getStatusCode() === 200) {
                    if ($request->has('save_draft')) {
                        return back()->with('success', __('physicalCourses.survey_draft_saved'));
                    } else {
                        return redirect()->route('admin.physical-courses.student.courses.index')
                            ->with('success', __('physicalCourses.survey_submitted_successfully'));
                    }
                } else {
                    $errors = json_decode($response->getContent(), true);
                    return back()->withErrors($errors['errors'] ?? ['error' => 'Failed to submit survey']);
                }
            }
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit survey. Please try again.',
                    'error' => $e->getMessage()
                ], 500);
            } else {
                return back()->with('error', 'Failed to submit survey. Please try again.');
            }
        }
    }
}

