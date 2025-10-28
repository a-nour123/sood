<?php

use App\Http\Controllers\admin\audit_plan\AuditPlanController;
use App\Http\Controllers\admin\mapped_controls_compliance\MappedControlsComplianceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin governance routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'mapped_controls_compliance', // Prefix applied on all `governance` group routes
        'middleware' => [], // Middlewares applied on all `governance` group routes
        'as' => 'mapped_controls_compliance.'
    ],
    function () {
        Route::get('/index', [MappedControlsComplianceController::class, 'index'])->name('index');
        Route::get('control-mapping/getControlsByFramework/{frameworkId}', [MappedControlsComplianceController::class, 'getControlsByFramework'])->name('getControlsByFramework');
        Route::post('mapped_controls_compliance/getPoliciesByControl', [MappedControlsComplianceController::class, 'getPoliciesByControls'])->name('getPoliciesByControls');
        Route::post('control-mapping-compliance/ajaxTable', [MappedControlsComplianceController::class, 'ajaxTable'])->name('ajaxTable');
        Route::post('control-mapping-compliance/store', [MappedControlsComplianceController::class, 'store'])->name('store');
        Route::get('/mapped-controls-compliance/{id}/edit', [MappedControlsComplianceController::class, 'edit'])
            ->name('edit');
        Route::delete('mapped-controls-compliance/{mappedControlsCompliance}', [MappedControlsComplianceController::class, 'destroy'])
            ->name('destroy');

        Route::get('/mapped-controls-compliance/{id}/preview', [MappedControlsComplianceController::class, 'preview'])
            ->name('preview');

        Route::post('/mapped-controls-compliance/export', [MappedControlsComplianceController::class, 'exportResult'])
            ->name('exportResult');
        Route::get('/mapped-controls-compliance/{id}/fetchDataPreview', [MappedControlsComplianceController::class, 'fetchDataPreview'])
            ->name('fetchDataPreview');

        Route::post('control-mapping-compliance/preview/ajaxTable', [MappedControlsComplianceController::class, 'previewajaxTable'])->name('preview.ajaxTable');
        Route::post('control-mapping-compliance/preview/resultSend', [MappedControlsComplianceController::class, 'submitPolicyResult'])->name('preview.submitPolicyResult');
        Route::get('control-mapping-compliance/notification', [MappedControlsComplianceController::class, 'notification'])->name('notification');
Route::post('/policies/bulk-update', [MappedControlsComplianceController::class, 'bulkUpdate'])
     ->name('bulkUpdate');

    }
);