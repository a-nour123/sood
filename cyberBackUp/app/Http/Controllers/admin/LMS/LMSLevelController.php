<?php
namespace App\Http\Controllers\admin\LMS;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\LMS\LMSLevelInterface;
use Illuminate\Http\Request;

class LMSLevelController extends Controller
{
    protected $LMSLevelInterface;

    public function __construct(LMSLevelInterface $LMSLevelInterface)
    {
        $this->LMSLevelInterface = $LMSLevelInterface;
    }
    public function index()
    {
        return $this->LMSLevelInterface->index();
    }
    public function store(Request $request,$id)
    {
        return $this->LMSLevelInterface->store($request,$id);
    }
    public function update($id,Request $request)
    {
        return $this->LMSLevelInterface->update($id,$request);
    }

    public function show($id,Request $request)
    {
        return $this->LMSLevelInterface->show($id,$request);
    }

    public function trash($level)
    {
        return $this->LMSLevelInterface->trash($level);
    }
    public function restore($id,Request $request)
    {
        return $this->LMSLevelInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->LMSLevelInterface->delete($id);
    }
    public function getProfiles($id)
    {
        return $this->LMSLevelInterface->getProfiles($id);
    }

    public function getProfilesDataTable($id)
    {
        return $this->LMSLevelInterface->getProfilesDataTable($id);
    }

    public function getArchivedDomains()
    {
        return $this->LMSLevelInterface->getArchivedDomains();
    }
    public function getLevelTrainingModules(Request $request)
    {
        return $this->LMSLevelInterface->getLevelTrainingModules($request);
    }
}
