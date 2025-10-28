<?php


namespace App\Interfaces\Admin\LMS;

use Illuminate\Http\Request;
interface LMSCourseInterface
{
    public function index();
    public function store(Request $request);
    public function update($id,Request $request);
    public function show($id,Request $request);
    public function trash($course);
    public function restore($id,Request $request);
    public function delete($id);
    public function getProfiles($id);
    public function getProfilesDataTable($id);
    public function getArchivedDomains();
    public function getCourseLevels(Request $request);
    public function courseNotificationsSettings();

}
