<?php

namespace App\Http\Controllers\PhysicalCourses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseRequest;
use App\Models\CourseSchedule;
use App\Models\CourseMaterial;
use App\Models\CourseAttendance;
use App\Models\CourseGrade;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\AwarenessSurvey;
use App\Models\CertificateTemplate;
use App\Models\CourseCertificate;
use App\Models\SurveyResponse;
use App\Services\SurveyService;
use App\Traits\CertificateGenerationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    use CertificateGenerationTrait;
    protected $surveyService;
    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('physicalCourses.list')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('physicalCourses.physical_courses')],
        ];

        $courses = Course::with(['instructors', 'requests', 'schedules'])->latest()->get();
        $statistics = $this->calculateStatistics($courses);
        return view('physicalCourses.index', compact('courses', 'breadcrumbs', 'statistics'));
    }

    public function indexAjax(Request $request)
    {
        $courses = Course::with(['instructors', 'requests', 'schedules'])->latest();

        return datatables()->eloquent($courses)
            ->addIndexColumn()
            ->addColumn('open_registration', function ($course) {
                return view('physicalCourses.columns.open_registration', compact('course'))->render();
            })
            ->addColumn('requests', function ($course) {
                $pending = $course->requests->where('status', 'pending')->count();
                if (!auth()->user()->hasPermission('physicalCourses.showRequests')) {
                    return '<a href="#" class="btn btn-sm btn-warning" disabled>' . $pending . ' Pending</a>';
                }
                return '<a href="' . route('admin.physical-courses.courses.requests', $course->id) . '" class="btn btn-sm btn-warning">' . $pending . ' Pending</a>';
            })
            ->addColumn('instructors', function ($course) {
                return $course->instructors->map(fn($ins) => '<span class="badge bg-info">' . $ins->name . '</span>')->implode(' ');
            })
            ->addColumn('registered', fn($course) => $course->requests->count())
            ->addColumn('course_complete', function ($course) {
                return $course->course_complete ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>';
            })
            ->addColumn('passing_grade', fn($course) => $course->passing_grade)
            ->addColumn('available_seats', fn($course) => $course->max_seats - $course->requests->where('status', 'approved')->count())
            ->addColumn('next_session', function ($course) {
                $nextSession = $course->schedules->where('session_date', '>=', now()->toDateString())->sortBy('session_date')->first();
                return $nextSession ? ($nextSession->session_date . ' - ' . $nextSession->session_time) : '<span class="text-muted">No upcoming</span>';
            })
            ->addColumn('attendance', function ($course) {
                if (!auth()->user()->hasPermission('physicalCourses.attendance')) {
                    return '<a href="#" class="btn btn-sm btn-primary" disabled>Manage</a>';
                }
                return '<a href="' . route('admin.physical-courses.courses.attendance', $course->id) . '" class="btn btn-sm btn-primary">Manage</a>';
            })
            ->addColumn('grades', function ($course) {
                if (!auth()->user()->hasPermission('physicalCourses.grade')) {
                    return '<a href="#" class="btn btn-sm btn-success" disabled>Grades</a>';
                }
                return '<a href="' . route('admin.physical-courses.courses.grades', $course->id) . '" class="btn btn-sm btn-success">Grades</a>';
            })
            ->addColumn('actions', function ($course) {
                return view('physicalCourses.columns.actions', compact('course'))->render();
            })
            ->rawColumns(['open_registration', 'requests', 'instructors', 'next_session', 'attendance', 'grades', 'actions', 'course_complete', 'passing_grade'])
            ->make(true);
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('physicalCourses.create')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.create_physical_course')],
        ];

        $instructors = User::all();
        $certificate_templates = CertificateTemplate::where('is_active', true)->get();
        $surveys = AwarenessSurvey::get();
        return view('physicalCourses.create', compact('instructors', 'breadcrumbs', 'certificate_templates','surveys'));
    }

    public function store(StoreCourseRequest $request)
    {
        DB::beginTransaction();

        try {
            $coverPath = $request->hasFile('cover_picture')
                ? $request->file('cover_picture')->store('covers', 'public')
                : null;

            $course = Course::create([
                'name' => $request->name,
                'description' => $request->description,
                'grade' => $request->grade,
                'max_seats' => $request->max_seats,
                'passing_grade' => $request->passing_grade,
                'cover_picture' => $coverPath,
                'certificate_template_id' => $request->certificate_template_id,
                'survey_id' => $request->survey_id,
            ]);

            $course->instructors()->sync($request->instructors);

            foreach ($request->schedule as $session) {
                $course->schedules()->create([
                    'session_date' => $session['date'],
                    'session_time' => $session['time'],
                ]);
            }

            if ($request->hasFile('materials')) {
                foreach ($request->file('materials') as $file) {
                    $path = $file->store('materials', 'public');
                    $course->materials()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create course'], 500);
        }
    }

    public function edit(Course $course)
    {
        if (!auth()->user()->hasPermission('physicalCourses.update')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.edit_physical_course')],
        ];

        $instructors = User::all();
        $certificate_templates = CertificateTemplate::where('is_active', true)->get();
        $surveys = AwarenessSurvey::get();
        $course->load('schedules', 'instructors', 'materials');
        return view('physicalCourses.edit', compact('course', 'instructors', 'breadcrumbs', 'certificate_templates','surveys'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('cover_picture')) {
                if ($course->cover_picture) {
                    Storage::disk('public')->delete($course->cover_picture);
                }
                $course->cover_picture = $request->file('cover_picture')->store('covers', 'public');
            }


            $course->update($request->only(['name', 'description', 'grade', 'max_seats', 'passing_grade', 'certificate_template_id', 'survey_id']));

            $course->instructors()->sync($request->instructors);

            $course->schedules()->delete();
            foreach ($request->schedule as $session) {
                $course->schedules()->create([
                    'session_date' => $session['date'],
                    'session_time' => $session['time'],
                ]);
            }

            if ($request->hasFile('materials')) {
                foreach ($request->file('materials') as $file) {
                    $path = $file->store('materials', 'public');
                    $course->materials()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to Update course'], 500);
        }
    }

    public function destroy(Course $course)
    {
        try {
            if ($course->cover_picture) {
                Storage::disk('public')->delete($course->cover_picture);
            }

            foreach ($course->materials as $material) {
                Storage::disk('public')->delete($material->file_path);
            }
            $course->delete();
            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete course: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showRequests(Course $course)
    {
        if (!auth()->user()->hasPermission('physicalCourses.showRequests')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.requests')],
        ];

        $requests = $course->requests()->latest()->get();
        $courses = Course::where('id', '!=', $course->id)->where('open_registration', true)->get();
        return view('physicalCourses.requests', compact('course', 'requests', 'courses', 'breadcrumbs'));
    }

    public function joinRequestsAjax(Course $course)
    {
        $requests = $course->requests()->with('user')->latest();
        $remainingSeats = $course->max_seats - $course->requests()->where('status', 'approved')->count();
        return DataTables::eloquent($requests)
            ->addIndexColumn()
            ->addColumn('user_name', fn($req) => $req->user ? $req->user->name : '-')
            ->addColumn('status', function ($req) {
                switch ($req->status) {
                    case 'approved':
                        $badgeClass = 'success';
                        break;
                    case 'canceled':
                        $badgeClass = 'danger';
                        break;
                    case 'transferred':
                        $badgeClass = 'info';
                        break;
                    default:
                        $badgeClass = 'warning';
                }
                return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($req->status) . '</span>';
            })
            ->addColumn('actions', function ($req) use ($remainingSeats) {
                if ($req->status === 'pending') {
                    return view('physicalCourses.columns.request-actions', compact('req', 'remainingSeats'))->render();
                }
                return '<span class="text-muted">No Actions</span>';
            })
            ->editColumn('created_at', fn($req) => $req->created_at->format('Y-m-d H:i'))
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function approveRequest($id)
    {
        $request = CourseRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return response()->json(['message' => 'Request approved successfully']);
    }

    public function cancelRequest($id)
    {
        $request = CourseRequest::findOrFail($id);
        $request->status = 'canceled';
        $request->save();

        return response()->json(['message' => 'Request canceled successfully']);
    }

    public function getAvailableCourses()
    {
        $courses = Course::where('open_registration', true)
            ->select('id', 'name', 'max_seats')
            ->get()
            ->filter(function ($course) {
                $approvedCount = $course->requests()
                    ->where('status', 'approved')
                    ->count();
                return $approvedCount < $course->max_seats;
            })
            ->values();
        return response()->json($courses);
    }

    public function transferRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:course_requests,id',
            'new_course_id' => 'required|exists:courses,id'
        ]);

        $req = CourseRequest::findOrFail($request->request_id);

        if ($req->status === 'transferred') {
            return response()->json([
                'message' => __('physicalCourses.request_already_transferred')
            ], 400);
        }

        $req->update([
            'status' => 'transferred',
            'transferred_to_course_id' => $request->new_course_id,
        ]);

        CourseRequest::create([
            'course_id' => $request->new_course_id,
            'user_id' => $req->user_id,
            'status' => 'approved',
        ]);

        return response()->json([
            'message' => __('physicalCourses.request_transferred_successfully')
        ]);
    }

    public function attendance(Course $course)
    {
        if (!auth()->user()->hasPermission('physicalCourses.attendance')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.attendance')],
        ];

        $approvedUsers = $course->requests()
            ->where('status', 'approved')
            ->with('user')
            ->get()
            ->pluck('user');

        $sessions = $course->schedules()->with('attendances')->get();
        return view('physicalCourses.attendance', compact('course', 'sessions', 'approvedUsers', 'breadcrumbs'));
    }

    public function storeAttendance(Request $request, Course $course)
    {
        $sessionId = $request->input('session_id');
        $attendedUserIds = $request->input('attendances', []);
        $approvedUsers = $course->requests()
            ->where('status', 'approved')
            ->pluck('user_id');

        foreach ($approvedUsers as $userId) {
            $attended = in_array($userId, $attendedUserIds);
            CourseAttendance::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'course_schedule_id' => $sessionId,
                    'user_id' => $userId,
                ],
                [
                    'attended' => $attended,
                ]
            );
        }

        return back()->with('success', 'Attendance saved');
    }

    public function grades(Course $course)
    {
        if (!auth()->user()->hasPermission('physicalCourses.grade')) {
            abort(403, 'Unauthorized action.');
        }
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.grades')],
        ];

        $approvedUsers = $course->requests()
            ->where('status', 'approved')
            ->with('user')
            ->get()
            ->pluck('user');

        $users = $course->requests()->where('status', 'approved')->with('user')->get();
        return view('physicalCourses.grades', compact('course', 'users', 'approvedUsers', 'breadcrumbs'));
    }

    public function storeGrades(Request $request, Course $course)
    {
        foreach ($request->grades as $user_id => $value) {
            CourseGrade::updateOrCreate(
                ['course_id' => $course->id, 'user_id' => $user_id],
                ['grade' => $value]
            );
        }

        return back()->with('success', 'Grades saved');
    }

    public function toggleRegistration(Course $course)
    {
        try {
            $course->update([
                'open_registration' => !$course->open_registration
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registration status updated successfully',
                'open_registration' => $course->open_registration
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update registration status'
            ], 500);
        }
    }

    public function toggleCompletion(Course $course)
    {
        try {
            $course->update([
                'course_complete' => !$course->course_complete
            ]);

            // If course is marked as complete, generate certificates for users
            if ($course->course_complete) {
                $this->generateCertificatesForEligibleUsers($course);
            }

            return response()->json([
                'success' => true,
                'message' => 'Completion status updated successfully',
                'course_complete' => $course->course_complete
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fullSummary()
    {
        if (!auth()->user()->hasPermission('physicalCourses.reports')) {
            abort(403, 'Unauthorized action.');
        }
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.full_summary')],
        ];

        $courses = Course::with([
            'instructors',
            'materials',
            'schedules.attendances',
            'requests.user',
            'grades',
        ])->get();

        $statistics = $this->calculateStatistics($courses);
        return view('physicalCourses.reports.full_summary', compact('courses', 'breadcrumbs', 'statistics'));
    }

    private function calculateStatistics($courses)
    {
        $totalCourses = $courses->count();
        $totalStudents = 0;
        $totalInstructors = 0;
        $totalSessions = 0;
        $totalGrades = 0;
        $passedStudents = 0;
        $instructorIds = collect();

        foreach ($courses as $course) {
            // Count unique students per course
            $courseStudents = $course->requests->where('status', 'approved')->count();
            $totalStudents += $courseStudents;

            // Count unique instructors
            $instructorIds = $instructorIds->merge($course->instructors->pluck('id'));

            // Count sessions
            $courseSessions = $course->schedules->count();
            $totalSessions += $courseSessions;

            // Calculate grades and success rate
            $courseGrades = $course->grades;
            if ($courseGrades->count() > 0) {
                $totalGrades += $courseGrades->avg('grade');
                $passedStudents += $courseGrades->where('grade', '>=', $course->passing_grade)->count();
            }
        }

        $totalInstructors = $instructorIds->unique()->count();
        $successRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 2) : 0;

        return [
            'total_courses' => $totalCourses,
            'total_students' => $totalStudents,
            'total_instructors' => $totalInstructors,
            'total_sessions' => $totalSessions,
            'success_rate' => $successRate,
            'active_courses' => $courses->where('open_registration', true)->count(),
        ];
    }

    public function fullSummaryAjax()
    {
        $courses = Course::with([
            'instructors',
            'materials',
            'schedules.attendances',
            'requests',
            'grades',
        ])->get();

        return DataTables::of($courses)
            ->addIndexColumn()
            ->addColumn('instructors', fn($c) => $c->instructors->pluck('name')->implode(', '))
            ->addColumn('sessions', fn($c) => $c->schedules->count())
            ->addColumn('students', fn($c) => $c->requests->count())
            ->addColumn('total_attendance', function ($c) {
                return $c->schedules->sum(fn($s) => $s->attendances->where('attended', true)->count());
            })
            ->addColumn('avg_grade', fn($c) => number_format($c->grades->avg('grade') ?? 0, 2) . '/' . $c->grade)
            ->addColumn('success_percent', function ($c) {
                $grades = $c->grades;
                $success = $grades->filter(fn($g) => $g->grade >= $c->passing_grade)->count();
                return $grades->count() > 0 ? round(($success / $grades->count()) * 100, 2) . '%' : '0%';
            })
            ->addColumn('registration', fn($c) => $c->open_registration ? '<span class="badge bg-success">Open</span>' : '<span class="badge bg-secondary">Closed</span>')
            ->addColumn('actions', fn($c) => '<a href="' . route('admin.physical-courses.courses.course.summary', $c->id) . '" class="btn btn-sm btn-primary">View</a>')
            ->rawColumns(['registration', 'actions'])
            ->make(true);
    }


    public function courseSummary(Course $course)
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.reports.full-summary'), 'name' => __('physicalCourses.full_summary')],
            ['name' => __('physicalCourses.full_summary')],
        ];
        $course->load(['instructors', 'materials', 'schedules.attendances', 'grades', 'requests.user']);
        return view('physicalCourses.reports.show', compact('course', 'breadcrumbs'));
    }


    // ================ Certificate Management ==================
    /**
     * Display certificates page for a course
     */
    public function getCertificates(Course $course)
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.certificates')],
        ];

        $certificates = CourseCertificate::where('course_id', $course->id)
            ->with('user')
            ->orderBy('issued_at', 'desc')
            ->get();

        $eligibleUsers = $this->getEligibleUsers($course);

        return view('physicalCourses.certificate.index', compact('course', 'certificates', 'breadcrumbs', 'eligibleUsers'));
    }

    /**
     * Get certificates data for DataTables (AJAX)
     */
    public function getCertificatesAjax(Course $course)
    {
        return $this->listCertificatesAjax($course);
    }


    public function listMyCertificatesAjax()
    {
        return $this->listuserCertificatesAjax();
    }

    /**
     * Get eligible users without certificates for DataTables (AJAX)
     */
    public function getEligibleUsersWithoutCertificatesAjax(Course $course)
    {
        return $this->listEligibleUsersWithoutCertificatesAjax($course);
    }

    /**
     * Generate certificate for a specific user
     */
    public function generateCertificateForCourse(Course $course, User $user)
    {
        return $this->generateCertificate($course, $user);
    }

    /**
     * Generate single certificate (AJAX endpoint)
     */
    public function generateSingleCertificate(Course $course, User $user)
    {
        return $this->generateSingleCertificateForCourse($course, $user);
    }

    /**
     * Generate certificates for all eligible users who don't have certificates yet
     */
    public function generateCertificatesForEligibleUsers(Course $course)
    {
        try {
            $certificatesGenerated = $this->generateCourseCertificatesForEligibleUsers($course);

            return back()->with('success', "Generated {$certificatesGenerated} certificates successfully.");
        } catch (\Exception $e) {
            \Log::error('Generate certificates for eligible users failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate certificates: ' . $e->getMessage());
        }
    }

    /**
     * Regenerate all certificates for a course
     */
    public function regenerateAllCertificates(Course $course)
    {
        return $this->regenerateAllCertificatesForCourse($course);
    }

    /**
     * View certificate in browser
     */
    public function viewCertificate(Course $course, User $user)
    {
        return $this->viewCourseCertificate($course, $user);
    }

    /**
     * Download certificate for a user
     */
    public function downloadCertificate(Course $course, User $user)
    {
        return $this->downloadCourseCertificate($course, $user);
    }

    /**
     * Delete a specific certificate
     */
    public function deleteCertificate(Request $request, Course $course, CourseCertificate $certificate)
    {
        try {
            // Ensure the certificate belongs to the course
            if ($certificate->course_id !== $course->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate does not belong to this course'
                ], 400);
            }

            // Delete file if exists
            if (\Storage::exists('public/' . $certificate->certificate_file)) {
                \Storage::delete('public/' . $certificate->certificate_file);
            }

            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Certificate deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get certificate statistics for a course
     */
    public function getCertificateStatistics(Course $course)
    {
        $statistics = $this->getCourseCertificateStatistics($course);

        return response()->json([
            'success' => true,
            'statistics' => $statistics
        ]);
    }

    /**
     * Display user's own certificates
     */
    public function myCertificates()
    {
        $certificates = CourseCertificate::where('user_id', auth()->id())
            ->with('course')
            ->orderBy('issued_at', 'desc')
            ->get();

        $courses = auth()->user()->courses;
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.student.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.certificates')],
        ];

        return view('physicalCourses.student.certificates', compact('certificates', 'courses', 'breadcrumbs'));
    }

    /**
     * Download user's own certificate
     */
    public function downloadMyCertificate(CourseCertificate $certificate)
    {
        return $this->downloadMyCourseCertificate($certificate);
    }


    // ================ Survey Management ==================
    /**
     * Show course survey Results
     */
    public function showCourseSurvey($type, $id)
    {
        try {
            return $this->surveyService->showResults($type, $id);
        } catch (\Exception $e) {
            return back()->with('error', 'Survey not found or access denied.');
        }
    }

    /**
     * *survy ajax
     *
     *  */

    public function surveyAjax($type, $id)
    {
        try {
            return $this->surveyService->getSurveyAjax($type, $id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Survey not found or access denied.'], 404);
        }
    }

    /**
     * showSurveyResponseDetails
     */
    public function showSurveyResponseDetails($responseId,$type, $id)
    {
        try {
            return $this->surveyService->showSurveyResponseDetails($responseId, $type, $id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Survey response not found'
            ], 404);
        }
    }

    /**
     * Delete survey response (optional - for admin users)
     */
    public function deleteSurveyResponse(Request $request, $responseId)
    {
        try {
            $response = SurveyResponse::findOrFail($responseId);
            $response->questionAnswers()->delete();
            $response->delete();
            return response()->json([
                'success' => true,
                'message' => 'Survey response deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete survey response: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete survey response'
            ], 500);
        }
    }




}
