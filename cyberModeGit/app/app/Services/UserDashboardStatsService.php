<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseRequest;
use App\Models\CourseCertificate;
use App\Models\CourseGrade;
use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDashboardStatsService
{
    /**
     * Get comprehensive dashboard statistics for the authenticated user
     */
    public function getUserDashboardStats()
    {
        $userId = Auth::id();

        return [
            'lms_stats' => $this->getLMSStats($userId),
            'physical_courses_stats' => $this->getPhysicalCoursesStats($userId),
            'overall_stats' => $this->getOverallStats($userId)
        ];
    }

    /**
     * Get LMS Training Module statistics
     */
    private function getLMSStats($userId)
    {
        // Get user's assigned training modules
        $user = User::with([
            'trainingModules' => function ($query) {
                $query->wherePivot('is_delivered', 1);
            }
        ])->find($userId);

        $assignedTrainingIds = $user->trainingModules->pluck('id')->toArray();

        // Get all accessible training modules (assigned + public)
        $accessibleModules = LMSTrainingModule::where(function ($query) use ($assignedTrainingIds) {
            $query->whereIn('id', $assignedTrainingIds)
                ->orWhere('training_type', 'public');
        })->get();

        // Calculate statistics
        $totalModules = $accessibleModules->count();
        $completedModules = 0;
        $failedModules = 0;
        $pendingModules = 0;
        $overdueModules = 0;
        $totalScore = 0;
        $scoreCount = 0;

        foreach ($accessibleModules as $module) {
            $userModule = $module->users()->where('user_id', $userId)->first();

            if (!$userModule) {
                $pendingModules++;
            } else {
                $pivot = $userModule->pivot;

                if ($pivot->passed == 1) {
                    $completedModules++;
                    $totalScore += $pivot->score;
                    $scoreCount++;
                } elseif ($pivot->passed == 0 && $pivot->count_of_entering_exam > 0) {
                    $failedModules++;
                    $totalScore += $pivot->score;
                    $scoreCount++;
                } else {
                    $pendingModules++;
                }

                // Check if overdue
                if (
                    $module->training_type == 'campaign' &&
                    $pivot->passed == 0 &&
                    now()->greaterThan($pivot->created_at->addDays($pivot->days_until_due))
                ) {
                    $overdueModules++;
                }
            }
        }

        // Get certificates count
        $certificatesCount = LMSTrainingModuleCertificate::where('user_id', $userId)->count();

        return [
            'total_modules' => $totalModules,
            'completed_modules' => $completedModules,
            'failed_modules' => $failedModules,
            'pending_modules' => $pendingModules,
            'overdue_modules' => $overdueModules,
            'completion_rate' => $totalModules > 0 ? round(($completedModules / $totalModules) * 100, 2) : 0,
            'average_score' => $scoreCount > 0 ? round($totalScore / $scoreCount, 2) : 0,
            'certificates_count' => $certificatesCount,
            'success_rate' => ($completedModules + $failedModules) > 0 ?
                round(($completedModules / ($completedModules + $failedModules)) * 100, 2) : 0
        ];
    }

    /**
     * Get Physical Courses statistics
     */
    private function getPhysicalCoursesStats($userId)
    {
        // Get all course requests by status
        $allRequests = CourseRequest::where('user_id', $userId)->get();
        $requestsByStatus = $allRequests->groupBy('status');

        // Get certificates count
        $certificatesCount = CourseCertificate::where('user_id', $userId)->count();

        // Get open courses available for registration
        $openCoursesCount = Course::where('open_registration', true)->count();

        // Calculate completed courses based on grades (student passed the course)
        $completedCourses = CourseGrade::where('user_id', $userId)
            ->with('course')
            ->get()
            ->filter(function ($grade) {
                return $grade->grade >= $grade->course->passing_grade;
            })
            ->count();

        return [
            'total_requests' => $allRequests->count(),
            'pending_requests' => $requestsByStatus->get('pending', collect())->count(),
            'approved_requests' => $requestsByStatus->get('approved', collect())->count(),
            'rejected_requests' => $requestsByStatus->get('canceled', collect())->count(),
            // 'completed_courses' => $requestsByStatus->get('completed', collect())->count(),
            'completed_courses' => $completedCourses,
            'certificates_count' => $certificatesCount,
            'open_courses_count' => $openCoursesCount,
            'approval_rate' => $allRequests->count() > 0 ?
                round(($requestsByStatus->get('approved', collect())->count() / $allRequests->count()) * 100, 2) : 0
        ];
    }

    /**
     * Get overall combined statistics
     */
    private function getOverallStats($userId)
    {
        $lmsStats = $this->getLMSStats($userId);
        $physicalStats = $this->getPhysicalCoursesStats($userId);

        return [
            'total_learning_activities' => $lmsStats['total_modules'] + $physicalStats['total_requests'],
            'total_completed' => $lmsStats['completed_modules'] + $physicalStats['completed_courses'],
            'total_certificates' => $lmsStats['certificates_count'] + $physicalStats['certificates_count'],
            'overall_completion_rate' => ($lmsStats['total_modules'] + $physicalStats['total_requests']) > 0 ?
                round((($lmsStats['completed_modules'] + $physicalStats['completed_courses']) /
                    ($lmsStats['total_modules'] + $physicalStats['total_requests'])) * 100, 2) : 0
        ];
    }

    /**
     * Get formatted dashboard data for views
     */
    public function getFormattedDashboardData()
    {
        $stats = $this->getUserDashboardStats();

        return [
            'cards' => [
                [
                    'title' => 'LMS Training Modules',
                    'total' => $stats['lms_stats']['total_modules'],
                    'completed' => $stats['lms_stats']['completed_modules'],
                    'pending' => $stats['lms_stats']['pending_modules'],
                    'failed' => $stats['lms_stats']['failed_modules'],
                    'overdue' => $stats['lms_stats']['overdue_modules'],
                    'completion_rate' => $stats['lms_stats']['completion_rate'],
                    'icon' => 'fas fa-graduation-cap',
                    'color' => 'primary'
                ],
                [
                    'title' => 'Physical Courses',
                    'total' => $stats['physical_courses_stats']['total_requests'],
                    'completed' => $stats['physical_courses_stats']['completed_courses'],
                    'pending' => $stats['physical_courses_stats']['pending_requests'],
                    'approved' => $stats['physical_courses_stats']['approved_requests'],
                    'rejected' => $stats['physical_courses_stats']['rejected_requests'],
                    'approval_rate' => $stats['physical_courses_stats']['approval_rate'],
                    'icon' => 'fas fa-chalkboard-teacher',
                    'color' => 'success'
                ],
                [
                    'title' => 'Certificates',
                    'lms_certificates' => $stats['lms_stats']['certificates_count'],
                    'physical_certificates' => $stats['physical_courses_stats']['certificates_count'],
                    'total_certificates' => $stats['overall_stats']['total_certificates'],
                    'icon' => 'fas fa-certificate',
                    'color' => 'warning'
                ],
                // [
                //     'title' => 'Overall Progress',
                //     'total_activities' => $stats['overall_stats']['total_learning_activities'],
                //     'total_completed' => $stats['overall_stats']['total_completed'],
                //     'completion_rate' => $stats['overall_stats']['overall_completion_rate'],
                //     'average_score' => $stats['lms_stats']['average_score'],
                //     'icon' => 'fas fa-chart-line',
                //     'color' => 'info'
                // ]
            ],
            'charts' => [
                'lms_progress' => [
                    'completed' => $stats['lms_stats']['completed_modules'],
                    'failed' => $stats['lms_stats']['failed_modules'],
                    'pending' => $stats['lms_stats']['pending_modules'],
                    'overdue' => $stats['lms_stats']['overdue_modules']
                ],
                'physical_courses' => [
                    'approved' => $stats['physical_courses_stats']['approved_requests'],
                    'pending' => $stats['physical_courses_stats']['pending_requests'],
                    'rejected' => $stats['physical_courses_stats']['rejected_requests'],
                    'completed' => $stats['physical_courses_stats']['completed_courses']
                ]
            ],
            'raw_stats' => $stats
        ];
    }
}
