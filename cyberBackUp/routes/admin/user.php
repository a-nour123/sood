<?php

use App\Http\Controllers\User\LMSQuizController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin Phishing routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'LMS/training_modules', 'as' => 'lms.training.modules.'], function () {
    Route::get('index', [LMSQuizController::class, 'index'])->name("index");
    Route::get('getQuiz/{id}', [LMSQuizController::class, 'getQuiz'])->name("getQuiz");
    Route::post('/store-answer', [LMSQuizController::class, 'storeAnswer'])->name('storeAnswer');
    Route::get('submitQuiz', [LMSQuizController::class, 'submitQuiz'])->name("submitQuiz");

    Route::get('Certificates', [LMSQuizController::class, 'myCertificates'])->name("Certificates");
    Route::get('listCertificatesAjax', [LMSQuizController::class, 'listCertificatesAjax'])->name("listCertificatesAjax");
    Route::get('{lMSTrainingModule}/users/{user}/certificate/view', [LMSQuizController::class, 'viewCertificate'])
        ->name('view-certificate');
    Route::get('{lMSTrainingModule}/users/{user}/certificate/download', [LMSQuizController::class, 'downloadCertificate'])
        ->name('download-certificate');
    Route::delete('{lMSTrainingModule}/certificates/{certificate}', [LMSQuizController::class, 'deleteCertificate'])
        ->name('delete-certificate');


    Route::get('user-dashboard', [LMSQuizController::class, 'userDashboard'])->name("userDashboard");

    // ===============================================
    // User Survey Routes
    // ===============================================

    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/{survey}/{type}/{id}', [LMSQuizController::class, 'showTrainingSurvey'])->name('show');
        Route::post('/{survey}/{type}/{id}/submit', [LMSQuizController::class, 'submitSurvey'])->name('submit');
    });

});
