<?php
namespace App\Http\Controllers\admin\LMS;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\LMS\LMSCourseInterface;
use Illuminate\Http\Request;

class LMSCourseController extends Controller
{
    protected $LMSCourseInterface;

    public function __construct(LMSCourseInterface $LMSCourseInterface)
    {
        $this->LMSCourseInterface = $LMSCourseInterface;
    }
    public function index()
    {
        return $this->LMSCourseInterface->index();
    }
    public function store(Request $request)
    {
        return $this->LMSCourseInterface->store($request);
    }
    public function update($id,Request $request)
    {
        return $this->LMSCourseInterface->update($id,$request);
    }

    public function show($id,Request $request)
    {
        return $this->LMSCourseInterface->show($id,$request);
    }

    public function trash($course)
    {
        return $this->LMSCourseInterface->trash($course);
    }
    public function restore($id,Request $request)
    {
        return $this->LMSCourseInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->LMSCourseInterface->delete($id);
    }
    public function getProfiles($id)
    {
        return $this->LMSCourseInterface->getProfiles($id);
    }

    public function getProfilesDataTable($id)
    {
        return $this->LMSCourseInterface->getProfilesDataTable($id);
    }

    public function getArchivedDomains()
    {
        return $this->LMSCourseInterface->getArchivedDomains();
    }

    public function getCourseLevels(Request $request)
    {
        return $this->LMSCourseInterface->getCourseLevels($request);
    }

    public function courseNotificationsSettings()
    {
        return $this->LMSCourseInterface->courseNotificationsSettings();
    }

}
