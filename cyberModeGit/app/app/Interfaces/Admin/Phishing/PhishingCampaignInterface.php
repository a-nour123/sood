<?php


namespace App\Interfaces\Admin\Phishing;

use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\LMSUserTrainingModule;
use App\Models\User;
use Illuminate\Http\Request;

interface PhishingCampaignInterface
{
    public function index();
    public function Certificates();
    public function listCertificatesAjax();
    public function viewCertificate(LMSTrainingModule $lMSTrainingModule, User $user);
    public function downloadCertificate(LMSTrainingModule $lMSTrainingModule, User $user);
    public function deleteCertificate(Request $request,LMSTrainingModule $lMSTrainingModule, LMSTrainingModuleCertificate $certificate);
    public function PhishingCampaignDatatable($type);
    public function validateFirstStep(Request $request);
    public function validateEditFirstStep(Request $request, $campaign);
    public function edit($id);
    public function getCampaignEmployees(Request $request);
    public function getEmailTemplateData($id);
    public function update($id, Request $request);
    public function trash($campaign);
    public function approve($campaign);
    public function sendLaterMail($campaign);

    public function archivedCampaignDatatable();

    public function getArchivedcampaign();
    public function restore($id, Request $request);
    public function delete($id);
    public function sendTestEmail($campaingId);
    public function mailOpened(Request $request);
    public function clickOnLink(Request $request, $id);
    public function mailFormSubmited(Request $request);
    public function mailAttachmentDownloaded(Request $request);
    public function getCampaignData($id);
    public function updateSecurityAwareness($id);


    public function getEmployeeOfTrainingCampaign($id);
    public function getPhisedEmployeeDataTable();
    public function getTrainingEmployeeDataTable();
    public function getActiveTrainingCampaignData(Request $request);
    public function getArchivedTrainingCampaignData(Request $request);
    public function getActivePhishingDataTable(Request $request);
    public function getArchivedPhishingDataTable(Request $request);
    public function getEmployeePhishingDataTable($id);
    public function getEmployeeTrainingCampaignData($id);
    public function phishingNotification(Request $request);

}
