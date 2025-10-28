<?php

use App\Http\Controllers\admin\policyAdoption\PolicyAdoptionController;
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
Route::group(
    [
        'prefix' => 'adoption_policies',
        'as' => 'adoption_policies.'
    ],
    function () {
        Route::get('/policies/adopt/index', [PolicyAdoptionController::class, 'index'])->name('index');
        Route::post('/policies/adopt/GetData', [PolicyAdoptionController::class, 'GetData'])->name('GetData');
        Route::post('/policies/adopt/store', [PolicyAdoptionController::class, 'store'])->name('store');
        Route::post('/policies/adopt/store', [PolicyAdoptionController::class, 'store'])->name('store');
        Route::delete('/adoption_policies/{policyAdoption}', [PolicyAdoptionController::class, 'destroy'])
            ->name('delete');

        Route::get('/adoption_policies/{policyAdoption}/edit', [PolicyAdoptionController::class, 'edit'])
            ->name('edit');

        Route::post('/adoption_policies/config', [PolicyAdoptionController::class, 'saveConfig'])
            ->name('config');
        Route::get('/policies/adopt/{id}', [PolicyAdoptionController::class, 'show'])->name('show');
        Route::post('/policies/adopt/update', [PolicyAdoptionController::class, 'update'])->name('update'); // update
        Route::get('/adoption_policies/preview/{id}/{type}', [PolicyAdoptionController::class, 'getPolicyAdoptionPreview'])->name('getPolicyAdoptionPreview');

        Route::post('/adoption-policies/update-status', [PolicyAdoptionController::class, 'updateStatus'])
            ->name('updateStatus');
        Route::get('/notificationsSettingsPolicyAdoption', [PolicyAdoptionController::class, 'notificationsSettingsPolicyAdoption'])->name('notificationsSettingsPolicyAdoption');
    }
);
