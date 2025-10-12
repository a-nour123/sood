<?php

use App\Http\Controllers\admin\LMS\LMSCourseController;
use App\Http\Controllers\admin\LMS\LMSLevelController;
use App\Http\Controllers\admin\LMS\LMSTrainingModuleController;
use App\Models\LMSLevel;
use App\Models\LMSTrainingModule;
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

Route::group(['prefix' => 'phishing/LMS', 'as' => 'lms.'], function () {

    // LMS Courses => Author : Khaled
    Route::get('courses', [LMSCourseController::class, 'index'])->name("courses.index");
    Route::post('courses/store', [LMSCourseController::class, 'store'])->name("courses.store");
    Route::get('courses/show/{id}', [LMSCourseController::class, 'show'])->name("courses.show");
    Route::post('courses/update/{id}', [LMSCourseController::class, 'update'])->name("courses.update");
    Route::post('course-trash/{id}', [LMSCourseController::class, 'trash'])->name('courses.trash');
    Route::post('course-levels', [LMSCourseController::class, 'getCourseLevels'])->name("courses.getCourseLevels");
    Route::delete('course-delete/{id}', [LMSCourseController::class, 'delete'])->name('courses.delete');


    // Notification
    Route::get('/course-notification', [LMSCourseController::class, 'courseNotificationsSettings'])->name('courseNotificationsSettings');


    // LMS Levels => Author : Khaled
    Route::get('levels', [LMSLevelController::class, 'index'])->name("levels.index");
    Route::post('levels/store/{id}', [LMSLevelController::class, 'store'])->name("levels.store");
    Route::get('levels/show/{id}', [LMSLevelController::class, 'show'])->name("levels.show");
    Route::post('levels/update/{id}', [LMSLevelController::class, 'update'])->name("levels.update");
    Route::post('level-trash/{id}', [LMSLevelController::class, 'trash'])->name('levels.trash');
    Route::post('level-getLevelTrainingModules', [LMSLevelController::class, 'getLevelTrainingModules'])->name('levels.getLevelTrainingModules');
    Route::delete('level-delete/{id}', [LMSLevelController::class, 'delete'])->name('levels.delete');

    // LMS Training Modules => Author : Khaled
    Route::get('trainingModules', [LMSTrainingModuleController::class, 'index'])->name("trainingModules.index");
    Route::post('trainingModules/store', [LMSTrainingModuleController::class, 'store'])->name("trainingModules.store");
    Route::get('trainingModules/show/{id}', [LMSTrainingModuleController::class, 'show'])->name("trainingModules.show");
    Route::get('trainingModules/edit/{id}', [LMSTrainingModuleController::class, 'edit'])->name("trainingModules.edit");
    Route::post('trainingModules/update/{id}', [LMSTrainingModuleController::class, 'update'])->name("trainingModules.update");
    Route::post('trainingModule-trash/{id}', [LMSTrainingModuleController::class, 'trash'])->name('trainingModules.trash');
    Route::delete('trainingModule-delete/{id}', [LMSTrainingModuleController::class, 'delete'])->name('trainingModules.delete');
    Route::get('trainingModule-getCompliances/{id}', [LMSTrainingModuleController::class, 'getCompliances'])->name('trainingModules.compliances');
    Route::get('/training/preview/{id}', [LMSTrainingModuleController::class, 'preview'])->name('trainingModules.preview');



    Route::post('uploadSingleVideo', [LMSTrainingModuleController::class, 'uploadSingleVideo'])->name("trainingModules.uploadSingleVideo");


    // Route::get('/quiz/{id}', [QuizController::class, 'showQuestion'])->name('quiz.question');
    // Route::post('/quiz/submit', [QuizController::class, 'submitAnswer'])->name('quiz.submit');

    Route::get('/quiz/{id}', function ($id) {
        $quiz = LMSTrainingModule::with('statements', 'questions')->find($id);
        $contents = collect()
            ->merge($quiz->questions)
            ->merge($quiz->statements)
            ->sortBy('page_number');

        $pages = [];
        // foreach ($quiz->questions as $question) {
        //     $pages[$question->page_number]['questions'][] = $question;
        // }

        // foreach ($quiz->statements as $statement) {
        //     $pages[$statement->page_number]['statements'][] = $statement;
        // }

        foreach ($quiz->questions as $question) {
            $pages[$question->page_number] = ['type' => 'question', 'content' => $question];
        }

        foreach ($quiz->statements as $statement) {
            if (!isset($pages[$statement->page_number])) {
                $pages[$statement->page_number] = ['type' => 'statement', 'content' => $statement];
            }
        }

        ksort($pages);
        return view('admin.content.LMS.quiz', compact('pages', 'contents'));
    });

    Route::post('/quiz/submit', function () {
        // $response = Response::create([
        //     'user_id' => auth()->id(),
        //     'question_id' => $request->question_id,
        //     'option_id' => $request->option_id,
        // ]);

        // $option = Option::find($request->option_id);
        // $correct = $option->is_correct;

        // // Update progress
        // $progress = Progress::firstOrCreate(['user_id' => auth()->id()]);
        // $progress->current_step += 1;
        // $progress->save();

        // return response()->json(['correct' => $correct]);
    })->name('quiz.submit');


    // ===============================================
    // Admin Survey Routes
    // ===============================================

    // Survey Results
  
    Route::get('/survey/results/{type?}/{id?}', [LMSTrainingModuleController::class, 'showCourseSurvey'])->name('survey.results');
    // survey ajax
    Route::get('/survey/ajax/{type?}/{id?}', [LMSTrainingModuleController::class, 'surveyAjax'])->name('survey.ajax');
    // Survey Response Details
    Route::get('/survey/response/details/{responseId}/{type?}/{id?}', [LMSTrainingModuleController::class, 'showSurveyResponseDetails'])
        ->name('survey.response.details');
    // Delete Survey Response (optional)
    Route::delete('/survey/response/delete/{responseId}', [LMSTrainingModuleController::class, 'deleteSurveyResponse'])
        ->name('survey.response.delete');

});


