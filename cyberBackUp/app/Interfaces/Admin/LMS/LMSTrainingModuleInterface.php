<?php


namespace App\Interfaces\Admin\LMS;

use Illuminate\Http\Request;
interface LMSTrainingModuleInterface
{
    public function index();
    public function store(Request $request);
    public function uploadSingleVideo(Request $request);
    public function update($id,Request $request);
    public function show($id,Request $request);
    public function edit($id,Request $request);
    public function trash($level);
    public function restore($id,Request $request);
    public function delete($id);
    public function getProfiles($id);
    public function getProfilesDataTable($id);
    public function getArchivedDomains();
    public function getCompliances($id);
    public function preview($id);
    public function showCourseSurvey($type, $id);
    public function surveyAjax($type, $id);
    public function showSurveyResponseDetails($responseId, $type, $id);
    public function deleteSurveyResponse($responseId);
}
