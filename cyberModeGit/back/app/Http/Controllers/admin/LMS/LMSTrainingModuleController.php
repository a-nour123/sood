<?php
namespace App\Http\Controllers\admin\LMS;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\LMS\LMSTrainingModuleInterface;
use Illuminate\Http\Request;

class LMSTrainingModuleController extends Controller
{
    protected $LMSTrainingModuleInterface;

    public function __construct(LMSTrainingModuleInterface $LMSTrainingModuleInterface)
    {
        $this->LMSTrainingModuleInterface = $LMSTrainingModuleInterface;
    }

    public function index()
    {
        return $this->LMSTrainingModuleInterface->index();
    }
    public function store(Request $request)
    {
        return $this->LMSTrainingModuleInterface->store($request);
    }

    public function uploadSingleVideo(Request $request)
    {
        return $this->LMSTrainingModuleInterface->uploadSingleVideo($request);
    }



    public function update($id,Request $request)
    {
        return $this->LMSTrainingModuleInterface->update($id,$request);
    }

    public function show($id,Request $request)
    {
        return $this->LMSTrainingModuleInterface->show($id,$request);
    }

    public function edit($id,Request $request)
    {
        return $this->LMSTrainingModuleInterface->edit($id,$request);
    }

    public function trash($level)
    {
        return $this->LMSTrainingModuleInterface->trash($level);
    }
    public function restore($id,Request $request)
    {
        return $this->LMSTrainingModuleInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->LMSTrainingModuleInterface->delete($id);
    }
    public function getProfiles($id)
    {
        return $this->LMSTrainingModuleInterface->getProfiles($id);
    }

    public function getProfilesDataTable($id)
    {
        return $this->LMSTrainingModuleInterface->getProfilesDataTable($id);
    }

    public function getArchivedDomains()
    {
        return $this->LMSTrainingModuleInterface->getArchivedDomains();
    }

    public function getCompliances($id)
    {
        return $this->LMSTrainingModuleInterface->getCompliances($id);
    }
}
