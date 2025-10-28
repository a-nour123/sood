<?php

use App\Http\Controllers\admin\assessment\AnswerController;
use App\Http\Controllers\admin\assessment\AssessmentController;
use App\Http\Controllers\admin\assessment\QuestionController;
use App\Http\Controllers\admin\assessment\QuestionnairController;
use App\Http\Controllers\admin\assessment\QuestionnaireController;
use App\Http\Controllers\admin\assessment\QuestionnaireResultController;
use App\Http\Controllers\admin\Nda\NdaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin assessment routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Assessments
Route::group([
    'prefix' => 'nda',
    'middleware' => [],
    'as' => 'nda.'
], function () {
    Route::resource('/', NdaController::class)->parameters(['' => 'nda']);
    Route::post('/getData', [NdaController::class, 'getData'])->name('getData');
    Route::get('/users/list', [NdaController::class, 'listUsers'])->name('users.list');
    Route::post('/nda/send', [NdaController::class, 'send'])->name('send');
    Route::get('/email-data/{id}', [NdaController::class, 'getEmailNdaData'])->name('getEmailNdaData');

    Route::group(
        [
            'prefix' => 'receiver', // Prefix applied on all `department` group routes
            'middleware' => [], // Middlewares applied on all `department` group routes
            'as' => 'receiver.'
        ],
        function () {
            Route::get('/receiver-index', [NdaController::class, 'receiverIndex'])->name('index');
            Route::post('/receiver-getData', [NdaController::class, 'receiverGetData'])->name('receiverGetData');
            Route::post('/receiver-nda', [NdaController::class, 'reciversNdaData'])->name('reciversNdaData');
            Route::post('/receiver-review', [NdaController::class, 'reviewStore'])->name('review.store');
            Route::get('/{id}/results', [NdaController::class, 'getNdaResults'])->name('results');
            Route::get('/nda/preview/{id}', [NdaController::class, 'getNdaPreview'])->name('getNdaPreview');
        }
    );
});

Route::get('/export/data/{id}', [NdaController::class, 'exportPdf'])->name('export.data');