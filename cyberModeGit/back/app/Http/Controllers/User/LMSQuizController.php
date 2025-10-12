<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\User\LMSQuizInterface;
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
}
