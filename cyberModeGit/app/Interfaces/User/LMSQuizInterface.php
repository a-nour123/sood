<?php


namespace App\Interfaces\User;

use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\User;
use Illuminate\Http\Request;
interface LMSQuizInterface
{
    public function index();
    public function getQuiz($id);
    public function storeAnswer(Request $request);
    public function submitQuiz(Request $request);
    public function myCertificates();
    public function listCertificatesAjax();
    public function viewCertificate(LMSTrainingModule $lMSTrainingModule, User $user);
    public function downloadCertificate(LMSTrainingModule $lMSTrainingModule, User $user);
    public function deleteCertificate(Request $request, LMSTrainingModule $lMSTrainingModule, LMSTrainingModuleCertificate $certificate);
    public function userDashboard();
    public function showTrainingSurvey($survey, $type, $id);
    public function submitSurvey(Request $request, $survey, $type, $id);

}
