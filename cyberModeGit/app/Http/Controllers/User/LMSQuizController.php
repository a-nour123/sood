<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\User\LMSQuizInterface;
use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\User;
use Illuminate\Http\Request;

class LMSQuizController extends Controller
{
    protected $LMSQuizInterface;

    public function __construct(LMSQuizInterface $LMSQuizInterface)
    {
        $this->LMSQuizInterface = $LMSQuizInterface;
    }

    public function index()
    {
        return $this->LMSQuizInterface->index();
    }

    public function getQuiz($id)
    {
        return $this->LMSQuizInterface->getQuiz($id);
    }

    public function storeAnswer(Request $request)
    {
        return $this->LMSQuizInterface->storeAnswer($request);
    }

    public function submitQuiz(Request $request)
    {
        return $this->LMSQuizInterface->submitQuiz($request);
    }

    public function myCertificates()
    {
        return $this->LMSQuizInterface->myCertificates();
    }

    public function listCertificatesAjax()
    {
        return $this->LMSQuizInterface->listCertificatesAjax();
    }

    public function viewCertificate(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        return $this->LMSQuizInterface->viewCertificate($lMSTrainingModule, $user);
    }

    public function downloadCertificate(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        return $this->LMSQuizInterface->downloadCertificate($lMSTrainingModule, $user);
    }

    public function deleteCertificate(Request $request, LMSTrainingModule $lMSTrainingModule, LMSTrainingModuleCertificate $certificate)
    {
        return $this->LMSQuizInterface->deleteCertificate($request, $lMSTrainingModule, $certificate);
    }


    public function userDashboard()
    {
        return $this->LMSQuizInterface->userDashboard();
    }

    public function showTrainingSurvey($survey, $type, $id)
    {
        return $this->LMSQuizInterface->showTrainingSurvey($survey, $type, $id);
    }
    public function submitSurvey(Request $request, $survey, $type, $id)
    {
        return $this->LMSQuizInterface->submitSurvey($request, $survey, $type, $id);
    }
}
