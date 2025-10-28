<?php

use App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController;
use App\Http\Controllers\admin\security_awareness\SurveyQuestionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin security-awareness routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Route::group(['prefix' => 'awarness-survey', 'middleware' => 'auth'], function() {
//     RRoute::get('GetDataSurveyQuestion/{id}', [SurveyQuestionController::class, 'GetDataSurveyQuestion'])->name('GetDataSurveyQuestion');
// });

Route::group([
    'prefix' => 'awarness-survey',
    'middleware' => 'auth',
    'as' => 'awarness_survey.'
], function () {
    Route::get('/survey', [Security_awareness_surveyController::class, 'index'])
        ->name('index');

    Route::post('/survey-data', [Security_awareness_surveyController::class, 'getDataSurvey'])
        ->name('getDataSurvey');
    // to questions
    Route::resource('SurveyQuestion', SurveyQuestionController::class);
    // to delete survey
    Route::get('surveyDelete/{id}', [Security_awareness_surveyController::class, 'surveyDelete'])
        ->name('awarness-survey.surveyDelete');
    // to edit survey 
    Route::get('EditSurvey/{id}', [Security_awareness_surveyController::class, 'editmodal'])
        ->name('editmodal');
    // send mail of survey 
    Route::POSt('SendSurveyMail/{id}', [Security_awareness_surveyController::class, 'sendMail'])
        ->name('awarness-survey.sendMail');
    // to get mail contain data survey
    Route::get('GetSurveyEmail/{id}', [Security_awareness_surveyController::class, 'GetDataEmail'])
        ->name('awarness-survey.GetDataEmail');
    // to edit or store survey 
    Route::resource('surveyManagement', Security_awareness_surveyController::class);
    // to get questions of survey
    Route::get('Question/{id}', [SurveyQuestionController::class, 'GetDataSurveyQuestion'])->name('GetDataSurveyQuestion');
    // to delet question of survey 
    Route::get('SurveyquestionDelete/{id}', [SurveyQuestionController::class, 'questionDelete'])->name('questionDelete');
    // to Edit  questions of survey
    Route::get('questionEdit/{id}', [SurveyQuestionController::class, 'questionEdit'])->name('questionEdit');
    // route of all answers
    Route::resource('AnswersQuestionsSurvey',  AnswerQuestionSurveyController::class);
    // the bar of answer questions 
    // Route::post('/checkbox-submit', [AnswerQuestionSurveyController::class, 'checkboxSubmit'])->name('checkbox.submit');
    //get the eaxam of survey
    Route::get('GetExam/{id}', [AnswerQuestionSurveyController::class, 'GetExam'])->name('GetExam');
    Route::get('GetSurveyFromMail/{id}', [AnswerQuestionSurveyController::class, 'GetSurveyFromMail'])->name('GetSurveyFromMail');
    //to get notification setting 
    Route::get('notifications-settings', [Security_awareness_surveyController::class, 'notificationsSettingsawareness'])
        ->name('notificationsSettingsawareness');
    Route::post('/export', [Security_awareness_surveyController::class, 'ajaxExport'])->name('export');
});
Route::group(['prefix' => 'awarness-survey', 'as' => 'awarness_survey.'], function () {
    Route::get('Examoutside/{id}', [AnswerQuestionSurveyController::class, 'Examoutside'])->name('Examoutside')->withoutMiddleware('auth');
    // the bar of answer questions 
    Route::post('/checkbox-submit', [AnswerQuestionSurveyController::class, 'checkboxSubmit'])->name('checkbox.submit')->withoutMiddleware('auth');
    Route::post('/svaeoutside', [AnswerQuestionSurveyController::class, 'SaveOutSideAnswer'])->name('svaeoutside')->withoutMiddleware('auth');
});