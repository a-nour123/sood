<?php


namespace App\Interfaces\Admin\LMS;

use Illuminate\Http\Request;
interface LMSLevelInterface
{
    public function index();
    public function store(Request $request,$id);
    public function update($id,Request $request);
    public function show($id,Request $request);
    public function trash($level);
    public function restore($id,Request $request);
    public function delete($id);
    public function getProfiles($id);
    public function getProfilesDataTable($id);
    public function getArchivedDomains();
    public function getLevelTrainingModules(Request $request);

}
