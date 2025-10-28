<?php

use App\Http\Controllers\admin\incident\IncidentConfigureController;
use App\Http\Controllers\admin\incident\IncidentController;
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

Route::group(['prefix' => 'incident', 'as' => 'incident.'], function () {


    // incident
    Route::get('/', [IncidentController::class, 'index'])->name('index');
    Route::get('incident-file/{id}', [IncidentController::class, 'downloadAttachment'])->name('file.download');
    Route::get('/incidents-export', [IncidentController::class, 'export'])->name('export');
    Route::get('admin/incidents/statistics/filter', [IncidentController::class, 'filterStatistics'])
        ->name('statistics.filter');

    // incident configure
    Route::get('/configure', [IncidentConfigureController::class, 'index'])->name('configure');

    Route::post('/incident-impacts', [IncidentConfigureController::class, 'store_impacts'])->name('impacts.store');
    Route::put('/incident-impacts', [IncidentConfigureController::class, 'update_impacts'])->name('impacts.update');
    Route::delete('/incident-impacts', [IncidentConfigureController::class, 'delete_impacts'])->name('impacts.delete');
    Route::get('/incident-impacts', [IncidentConfigureController::class, 'impacts'])->name('impacts.index');

    Route::post('/incident-levels', [IncidentConfigureController::class, 'store_levels'])->name('levels.store');
    Route::put('/incident-levels', [IncidentConfigureController::class, 'update_levels'])->name('levels.update');
    Route::delete('/incident-levels', [IncidentConfigureController::class, 'delete_levels'])->name('levels.delete');
    Route::get('/incident-levels', [IncidentConfigureController::class, 'levels'])->name('levels.index');

    Route::post('/incident_criterias', [IncidentConfigureController::class, 'store_criteria'])->name('configure.store_criteria');
    Route::post('/incident_scores', [IncidentConfigureController::class, 'store_score'])->name('configure.store_score');
    Route::post('/incident_classifies', [IncidentConfigureController::class, 'store_classify'])->name('configure.store_classify');

    Route::get('/get-score-data', [IncidentConfigureController::class, 'getScoreData'])->name('configure.getScoreData');
    Route::get('/get-classify-data', [IncidentConfigureController::class, 'getClassifyData'])->name('configure.getClassifyData');

    Route::get('/get-playbook-data', [IncidentConfigureController::class, 'getPlaybookData'])->name('configure.getPlaybookData');
    Route::post('/playbook', [IncidentConfigureController::class, 'store_playbook'])->name('configure.store_playbook');
    Route::post('/playbook-update', [IncidentConfigureController::class, 'update_playbook'])->name('configure.update_playbook');
    Route::delete('/playbook/{id}', [IncidentConfigureController::class, 'delete_playbook'])->name('configure.delete_playbook');
    Route::get('/playbook/{id}', [IncidentConfigureController::class, 'edit_playbook'])->name('configure.edit_playbook');
    Route::get('/get-playbook-users/{id}', [IncidentConfigureController::class, 'getPlayBookUser'])->name('configure.getPlayBookUser');


    Route::get('/get-playbook-actions-data/{id}', [IncidentConfigureController::class, 'getPlayBookActionData'])->name('configure.getPlayBookActionData');
    Route::get('/get-actions-data', [IncidentConfigureController::class, 'getActionData'])->name('configure.getActionData');
    Route::post('/playbook-action', [IncidentConfigureController::class, 'store_playbook_action'])->name('configure.store_playbook_action');
    Route::delete('/playbook-action/{id}/{playbook}', [IncidentConfigureController::class, 'delete_playbook_action'])->name('configure.delete_playbook_action');
    Route::post('/playbook-action-update/{id}/{playbook}', [IncidentConfigureController::class, 'update_playbook_action'])->name('configure.update_playbook_action');

    Route::post('/ira', [IncidentConfigureController::class, 'store_ira'])->name('configure.store_ira');
    Route::get('/incident-tlp', [IncidentConfigureController::class, 'tlpGetData'])->name('tlp.index');
    Route::post('/incident-tlp/store', [IncidentConfigureController::class, 'storeTlp'])->name('tlp.store');
    Route::post('/incident-tlp/update', [IncidentConfigureController::class, 'updateTlp'])->name('tlp.update');
    Route::post('/incident-tlp/delete', [IncidentConfigureController::class, 'delete_tlp'])->name('tlp.delete');


    // 
    Route::get('/incident-pap', [IncidentConfigureController::class, 'papGetData'])->name('pap.index');
    Route::post('/incident-pap/store', [IncidentConfigureController::class, 'storePap'])->name('pap.store');
    Route::post('/incident-pap/update', [IncidentConfigureController::class, 'updatePap'])->name('pap.update');
    Route::post('/incident-pap/delete', [IncidentConfigureController::class, 'delete_pap'])->name('pap.delete');


    Route::get('/incident/get-data', [IncidentController::class, 'getData'])->name('getData');
    Route::post('/incident/ajax-store', [IncidentController::class, 'store'])->name('ajax.store');
    Route::post('/incident-ira/ajax-store', [IncidentController::class, 'iraStore'])->name('ajax.iraStore');
    Route::post('/incident-csrit/ajax-store', [IncidentController::class, 'csritStore'])->name('ajax.csritStore');

    Route::get('/incident/notification', [IncidentController::class, 'notificationsSettingsIncident'])->name('notificationsSettingsIncident');

    Route::get('/incident-ira/{id}', [IncidentController::class, 'editIraIncident'])->name('incident.ira_edit');
    Route::get('/incident-csrit/{id}', [IncidentController::class, 'editCsritIncident'])->name('incident.csrit_edit');



    Route::post('/incident-store-evidence', [IncidentController::class, 'storeEvidence'])->name('incident.storeEvidence');
    Route::get('/incident-get-evidences/{action_id}/{incident_id}/{play_book_id}', [IncidentController::class, 'getEvidences'])->name('incident.getEvidences');
    Route::get('/incident-get-evidence/{id}', [IncidentController::class, 'getEvidence'])->name('incident.getEvidence');
    Route::get('/incident-download-evidence-file/{id}', [IncidentController::class, 'downloadEvidenceFile'])->name('incident.downloadEvidenceFile');
    Route::post('/incident-update-evidence', [IncidentController::class, 'updateEvidence'])->name('incident.updateEvidence');
    Route::delete('/incident-delete-evidence/{id}', [IncidentController::class, 'deleteEvidence'])->name('incident.deleteEvidence');
    Route::get('/incident-evidence/view-file/{id}', [IncidentController::class, 'viewEvidenceFile'])->name('incident.evidence.view-file');

    Route::get('/incident/statistics', [IncidentController::class, 'statistics'])->name('incident.statistics');
    Route::get('/comments/{incidentId}/{playbookId}/{actionId}', [IncidentController::class, 'showIncidentComments'])
        ->name('showComments');
            Route::get('/logs/{incidentId}/{playbookId}/{actionId}', [IncidentController::class, 'showLogs'])
        ->name('showLogs');
        

    Route::post('/comments/add', [IncidentController::class, 'sendIncidentComment'])
        ->name('sendComment');

    Route::get('/comments/file/{comment_id}', [IncidentController::class, 'downloadIncidentCommentFile'])
        ->name('downloadIncidentCommentFile');
    Route::delete(
        'incident/{incidentId}/{playBookId}/{actionId}/clear-comments',
        [IncidentController::class, 'clearComments']
    )->name('clearComments');
    Route::get('/incidents/statistics/{incident}', [IncidentController::class, 'getStatistics'])
        ->name('statistics');
    Route::delete('/incidents/{id}', [IncidentController::class, 'destroy'])
        ->name('destroy');
});