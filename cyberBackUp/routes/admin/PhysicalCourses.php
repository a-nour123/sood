<?php

use App\Http\Controllers\CertificateTemplateController;
use App\Http\Controllers\PhysicalCourses\CourseBrowseController;
use App\Http\Controllers\PhysicalCourses\CourseController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'physical-courses', 'as' => 'physical-courses.', 'middleware' => ['auth']], function () {

    // ===============================
    // Course Management Routes
    // ===============================

    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('physical-courses/courses/index-ajax', [CourseController::class, 'indexAjax'])->name('indexAjax');


        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('{course}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('{course}', [CourseController::class, 'destroy'])->name('destroy');

        Route::post('toggle-registration/{course}', [CourseController::class, 'toggleRegistration'])->name('toggleRegistration');
        Route::post('toggle-completion/{course}', [CourseController::class, 'toggleCompletion'])->name('toggleCompletion');

        // Course Requests Management
        Route::get('{course}/requests', [CourseController::class, 'showRequests'])->name('requests');
        Route::get('{course}/requests/ajax', [CourseController::class, 'joinRequestsAjax'])->name('requests.ajax');
        Route::post('requests/{request}/approve', [CourseController::class, 'approveRequest'])->name('requests.approve');
        Route::post('requests/{request}/cancel', [CourseController::class, 'cancelRequest'])->name('requests.cancel');

        Route::get('courses/available', [CourseController::class, 'getAvailableCourses'])->name('courses.available');
        Route::post('requests/{request}/transfer', [CourseController::class, 'transferRequest'])->name('requests.transfer');

        // Attendance Management
        Route::get('{course}/attendance', [CourseController::class, 'attendance'])->name('attendance');
        Route::post('{course}/attendance/save', [CourseController::class, 'storeAttendance'])->name('attendance.store');

        // Grades Management
        Route::get('{course}/grades', [CourseController::class, 'grades'])->name('grades');
        Route::post('{course}/grades/save', [CourseController::class, 'storeGrades'])->name('grades.store');

        // Reports
        Route::get('full-summary', [CourseController::class, 'fullSummary'])->name('reports.full-summary');
        Route::get('full-summary/ajax', [CourseController::class, 'fullSummaryAjax'])->name('reports.full-summary-ajax');
        Route::get('course-report/{course}', [CourseController::class, 'courseSummary'])->name('course.summary');


        // ===============================================
        // Admin Survey Routes
        // ===============================================

        // Survey Results
        Route::get('/survey/results/{type?}/{id?}', [CourseController::class, 'showCourseSurvey'])->name('survey.results');
        // survey ajax
        Route::get('/survey/ajax/{type?}/{id?}', [CourseController::class, 'surveyAjax'])->name('survey.ajax');
        // Survey Response Details
        Route::get('/survey/response/details/{responseId}/{type?}/{id?}', [CourseController::class, 'showSurveyResponseDetails'])
            ->name('survey.response.details');
        // Delete Survey Response (optional)
        Route::delete('/survey/response/delete/{responseId}', [CourseController::class, 'deleteSurveyResponse'])
            ->name('survey.response.delete');


    });

    // ===============================
    // Student Side (User Interface)
    // ===============================

    Route::prefix('student-courses')->name('student.courses.')->group(function () {
        Route::get('/', [CourseBrowseController::class, 'index'])->name('index');
        Route::post('{course}/register', [CourseBrowseController::class, 'register'])->name('register');
        Route::get('{course}', [CourseBrowseController::class, 'show'])->name('show');
    });


    // ===============================
    // Certificate generation Management
    // ===============================

    Route::prefix('certificates')->name('certificates.')->group(function () {

        // Main certificates page for a course
        Route::get('/courses/{course}/certificates', [CourseController::class, 'getCertificates'])
            ->name('courses.certificates');

        // AJAX endpoints for DataTables
        Route::get('courses/{course}/certificates/ajax', [CourseController::class, 'getCertificatesAjax'])
            ->name('courses.ajax');

        Route::get('courses/{course}/eligible-users/ajax', [CourseController::class, 'getEligibleUsersWithoutCertificatesAjax'])
            ->name('courses.eligible-users-ajax');

        // Generate certificate for a specific user
        Route::post('/courses/{course}/users/{user}/generate-certificate', [CourseController::class, 'generateCertificateForCourse'])
            ->name('courses.generate-certificate');

        // Generate single certificate (AJAX)
        Route::post('/courses/{course}/users/{user}/generate-single-certificate', [CourseController::class, 'generateSingleCertificate'])
            ->name('courses.generate-single-certificate');

        // Generate missing certificates for all eligible users
        Route::post('/courses/{course}/generate-missing-certificates', [CourseController::class, 'generateCertificatesForEligibleUsers'])
            ->name('courses.generate-missing-certificates');

        // Regenerate all certificates for a course
        Route::post('/courses/{course}/regenerate-certificates', [CourseController::class, 'regenerateAllCertificates'])
            ->name('courses.regenerate-certificates');

        // View certificate in browser
        Route::get('/courses/{course}/users/{user}/certificate/view', [CourseController::class, 'viewCertificate'])
            ->name('courses.view-certificate');

        // Download certificate for a user in a course
        Route::get('/courses/{course}/users/{user}/certificate/download', [CourseController::class, 'downloadCertificate'])
            ->name('courses.download-certificate');

        // Delete a specific certificate
        Route::delete('/courses/{course}/certificates/{certificate}', [CourseController::class, 'deleteCertificate'])
            ->name('courses.delete-certificate');

        // Send certificate notifications
        Route::post('/courses/{course}/send-notifications', [CourseController::class, 'sendCertificateNotifications'])
            ->name('courses.send-notifications');

        // Get certificate statistics
        Route::get('/courses/{course}/statistics', [CourseController::class, 'getCertificateStatistics'])
            ->name('courses.statistics');

        // User's own certificates
        Route::get('/my-certificates', [CourseController::class, 'myCertificates'])
            ->name('my-certificates');

        Route::get('user/certificates/ajax', [CourseController::class, 'listMyCertificatesAjax'])
            ->name('user.courses.ajax');

        // Download user's own certificate
        Route::get('/my-certificates/{certificate}/download', [CourseController::class, 'downloadMyCertificate'])
            ->name('my-certificates.download');
    });


    // ===============================
    // Certificate Templates Routes
    // ===============================

    Route::prefix('certificate-templates')->name('certificate-templates.')->group(function () {
        Route::get('/', [CertificateTemplateController::class, 'index'])->name('index');
        Route::get('/create', [CertificateTemplateController::class, 'create'])->name('create');
        Route::post('/', [CertificateTemplateController::class, 'store'])->name('store');
        Route::get('/{template}', [CertificateTemplateController::class, 'show'])->name('show');
        Route::get('/{template}/edit', [CertificateTemplateController::class, 'edit'])->name('edit');
        Route::put('/{template}', [CertificateTemplateController::class, 'update'])->name('update');
        Route::delete('/{template}', [CertificateTemplateController::class, 'destroy'])->name('destroy');

        // Additional Actions
        Route::post('/{template}/set-default', [CertificateTemplateController::class, 'setDefault'])->name('set-default');
        Route::post('/{template}/toggle-active', [CertificateTemplateController::class, 'toggleActive'])->name('toggle-active');

        // Preview and Configuration
        Route::get('/{template}/preview', [CertificateTemplateController::class, 'preview'])->name('preview');
        Route::get('/{template}/configuration', [CertificateTemplateController::class, 'getConfiguration'])->name('configuration');
        Route::post('/{template}/field-positions', [CertificateTemplateController::class, 'saveFieldPositions'])->name('save-field-positions');

        // Bulk Actions
        Route::post('/bulk-action', [CertificateTemplateController::class, 'bulkAction'])->name('bulk-action');

        // Export/Import
        Route::get('/export/templates', [CertificateTemplateController::class, 'exportTemplates'])->name('export');
        Route::post('/import/templates', [CertificateTemplateController::class, 'importTemplates'])->name('import');

        Route::get('{template}/design', [CertificateTemplateController::class, 'design'])
            ->name('design');

        Route::post('{template}/save-field-positions', [CertificateTemplateController::class, 'saveFieldPositions'])
            ->name('save-field-positions');

        Route::get('{template}/preview', [CertificateTemplateController::class, 'preview'])
            ->name('preview');
    });


    // ===============================================
    // User Survey Routes
    // ===============================================

    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/{survey}/{type}/{id}', [CourseBrowseController::class, 'showCourseSurvey'])->name('show');
        Route::post('/{survey}/{type}/{id}/submit', [CourseBrowseController::class, 'submitSurvey'])->name('submit');
    });

});



