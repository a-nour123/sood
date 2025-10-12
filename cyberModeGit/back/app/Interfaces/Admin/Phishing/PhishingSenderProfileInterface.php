<?php


namespace App\Interfaces\Admin\Phishing;

use App\Http\Requests\admin\phishing\PhishingSenderProfileRequest;
use Illuminate\Http\Request;
interface PhishingSenderProfileInterface
{
    public function index();
    public function PhishingSenderProfileDatatable(Request $request);
    public function store(PhishingSenderProfileRequest $request);
    public function update($id,PhishingSenderProfileRequest $request);
    public function trash($domain);
    public function restore($id,Request $request);
    public function delete($id);
    public function getArchivedSenderProfile();
    public function archivedSenderProfileDatatable(Request $request);
}
