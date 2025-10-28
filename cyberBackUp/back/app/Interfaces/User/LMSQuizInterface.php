<?php


namespace App\Interfaces\User;

use Illuminate\Http\Request;
interface LMSQuizInterface
{
    public function index();
    public function getQuiz($id);
    public function storeAnswer(Request $request);
    public function submitQuiz(Request $request);
}
