<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\Phishing\PhishingCampaignInterface;
use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\LMSUserTrainingModule;
use App\Models\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;
class PhishingCampaignController extends Controller
{
    protected $PhishingCampaignInterface;

    public function __construct(PhishingCampaignInterface $PhishingCampaignInterface)
    {
        $this->PhishingCampaignInterface = $PhishingCampaignInterface;
    }

    public function index()
    {
        return $this->PhishingCampaignInterface->index();
    }

    public function Certificates()
    {
        return $this->PhishingCampaignInterface->Certificates();
    }

    public function listCertificatesAjax()
    {
        return $this->PhishingCampaignInterface->listCertificatesAjax();
    }

    public function viewCertificate(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        return $this->PhishingCampaignInterface->viewCertificate($lMSTrainingModule, $user);
    }

    public function downloadCertificate(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        return $this->PhishingCampaignInterface->downloadCertificate($lMSTrainingModule, $user);
    }

    public function deleteCertificate(Request $request, LMSTrainingModule $lMSTrainingModule, LMSTrainingModuleCertificate $certificate)
    {
        return $this->PhishingCampaignInterface->deleteCertificate($request, $lMSTrainingModule, $certificate);
    }

    public function validateEditFirstStep(Request $request, $campaign)
    {
        return $this->PhishingCampaignInterface->validateEditFirstStep($request, $campaign);
    }

    public function validateFirstStep(Request $request)
    {
        return $this->PhishingCampaignInterface->validateFirstStep($request);
    }

    public function PhishingCampaignDatatable($type)
    {

        return $this->PhishingCampaignInterface->PhishingCampaignDatatable($type);
    }

    public function edit($id)
    {
        return $this->PhishingCampaignInterface->edit($id);
    }

    public function getCampaignEmployees(Request $request)
    {
        return $this->PhishingCampaignInterface->getCampaignEmployees($request);
    }

    public function getEmailTemplateData($id)
    {
        return $this->PhishingCampaignInterface->getEmailTemplateData($id);
    }

    public function update($id, Request $request)
    {
        return $this->PhishingCampaignInterface->update($id, $request);
    }

    public function getArchivedcampaign()
    {
        return $this->PhishingCampaignInterface->getArchivedcampaign();
    }

    public function trash($campaign)
    {
        return $this->PhishingCampaignInterface->trash($campaign);
    }

    public function approve($campaign)
    {
        return $this->PhishingCampaignInterface->approve($campaign);
    }
    public function sendLaterMail($campaign)
    {
        return $this->PhishingCampaignInterface->sendLaterMail($campaign);
    }


    public function archivedCampaignDatatable()
    {
        return $this->PhishingCampaignInterface->archivedCampaignDatatable();
    }


    public function restore($id, Request $request)
    {
        return $this->PhishingCampaignInterface->restore($id, $request);
    }
    public function delete($id)
    {
        return $this->PhishingCampaignInterface->delete($id);
    }

    public function sendTestEmail($campaingId)
    {
        return $this->PhishingCampaignInterface->sendTestEmail($campaingId);
    }

    public function mailOpened(Request $request)
    {
        return $this->PhishingCampaignInterface->mailOpened($request);
    }

    public function clickOnLink(Request $request, $id)
    {
        return $this->PhishingCampaignInterface->clickOnLink($request, $id);
    }

    public function mailFormSubmited(Request $request)
    {
        return $this->PhishingCampaignInterface->mailFormSubmited($request);
    }
    public function mailAttachmentDownloaded(Request $request)
    {
        return $this->PhishingCampaignInterface->mailAttachmentDownloaded($request);
    }

    public function getCampaignData($id)
    {
        return $this->PhishingCampaignInterface->getCampaignData($id);
    }
    public function updateSecurityAwareness($id)
    {
        return $this->PhishingCampaignInterface->updateSecurityAwareness($id);
    }
    public function testmail()
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'mail.pksaudi.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'a.ali@pksaudi.com';                     //SMTP username
            $mail->Password = 'O}.tHt=+x9bA';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('khalid@sales.com', 'Khalid Mohamed');
            $mail->addAddress('a.ali@pksaudi.com', 'Ali Ali');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('khalid@sales.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Weekly Meeting Schedule';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function getEmployeeOfTrainingCampaign($id)
    {
        return $this->PhishingCampaignInterface->getEmployeeOfTrainingCampaign($id);
    }


    public function getPhisedEmployeeDataTable()
    {
        return $this->PhishingCampaignInterface->getPhisedEmployeeDataTable();
    }

    public function getTrainingEmployeeDataTable()
    {
        return $this->PhishingCampaignInterface->getTrainingEmployeeDataTable();
    }






    public function getActiveTrainingCampaignData(Request $request)
    {
        return $this->PhishingCampaignInterface->getActiveTrainingCampaignData($request);
    }

    public function getArchivedTrainingCampaignData(Request $request)
    {
        return $this->PhishingCampaignInterface->getArchivedTrainingCampaignData($request);
    }

    public function getActivePhishingDataTable(Request $request)
    {
        return $this->PhishingCampaignInterface->getActivePhishingDataTable($request);
    }
    public function getArchivedPhishingDataTable(Request $request)
    {
        return $this->PhishingCampaignInterface->getArchivedPhishingDataTable($request);
    }

    public function getEmployeePhishingDataTable($id)
    {
        return $this->PhishingCampaignInterface->getEmployeePhishingDataTable($id);
    }
    public function getEmployeeTrainingCampaignData($id)
    {
        return $this->PhishingCampaignInterface->getEmployeeTrainingCampaignData($id);
    }

    public function phishingNotification(Request $request)
    {
        return $this->PhishingCampaignInterface->phishingNotification($request);
    }



}
