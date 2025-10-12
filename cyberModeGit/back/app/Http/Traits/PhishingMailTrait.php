<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;
 use Illuminate\Support\Facades\Mail;

trait PhishingMailTrait
{
    public function sendPhishingMail($email_from,$mailData,$email_to,$mailObject)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';

            $mail->isSMTP();
            $mail->SMTPDebug = false;
            $mail->Mailer = "smtp";
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Host = "192.168.1.192";
            $mail->Username = "sayed";
            $mail->Password =   "pk@12345";
            $mail->SMTPSecure = "tls";
            $mail->isHTML(true);
            $mail->addAddress($email_to);
            $mail->setFrom($email_from,"sayed");
            $mail->Subject = $mailData->subject;
            $mail->Body = $mailData->body;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                )
            );
            $mail->addCustomHeader('X-PHISHING', 'true');
            $mail->SMTPDebug = 2;

            if($mail->send($mailObject)) {
                $response = [
                    'status' => true,
                    'message' => __('success'),
                ];
            }else {
                $response = [
                    'status' => false,
                    'message' => __('error_occured'),
                ];
            }
            return $response;
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }
    }

//     public function sendPhishingMail2($email_from, $mailData, $email_to, $mailObject)
//     {
//         try {
//             $mail = new PHPMailer(true);
//             $mail->CharSet = 'UTF-8';
//             $mail->SMTPDebug = 0;                      //Enable verbose debug output
//             // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//             $mail->isSMTP();                                            //Send using SMTP
//             $mail->Host       = 'mail.pksaudi.com';                     //Set the SMTP server to send through
//             $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//             $mail->Username   = 'a.ali@pksaudi.com';                     //SMTP username
//             $mail->Password   = 'O}.tHt=+x9bA';                               //SMTP password
//             $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//             $mail->Port       = 465;
//             if($mailData->senderProfile['type']==='managed'){
//                 $domain = DB::table('phishing_domains')
//                 ->where('id', $mailData->senderProfile['website_domain_id'])
//                 ->value('name'); // Use value to directly get the column value as a string
//             $senderMail = $mailData->senderProfile['from_address_name'] . $domain;
//             }else{
//                 $senderMail=$mailData->senderProfile['from_address_name'];
//             }
//             $mail->setFrom($senderMail, $mailData->senderProfile['from_display_name']);
//             $mail->addAddress($email_to, '');     //Add a recipient
//             //$mail->addAddress('ellen@example.com');               //Name is optional
//             // $mail->addReplyTo('khalid@sales.com', 'Information');
//             //$mail->addCC('cc@example.com');
//             //$mail->addBCC('bcc@example.com');

//             //Attachments
//             //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//             //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//             //Content
//             $mail->isHTML(true);                                  //Set email format to HTML
//             $mail->Subject = $mailData->subject;
//             $mail->Body = $mailObject->render();
//             // $mail->AltBody = 'please confirm your data';
//  // Optional: Attachment logic
// //  if (!empty($mailData->mail_attachment)) {
// //      $attachmentPath = public_path($mailData->mail_attachment);
// //      if (file_exists($attachmentPath)) {
// //          $mail->addAttachment($attachmentPath);
// //          \Log::info('Attachment file Founded ' . $attachmentPath);
// //      } else {
// //          \Log::warning('Attachment file not found: ' . $attachmentPath);
// //          return [
// //              'status' => false,
// //              'message' => __('Attachment not found: ') . $attachmentPath,
// //          ];
// //      }
// //  }
//     return $mail->send(); // Returns true on success, false on failure

//             // echo 'Message has been sent';

//         } catch (\Exception $e) {
//             // \Log::error('Mail sending failed: ' . $e->getMessage());
//             dd('Mail sending failed: ' . $e->getMessage());
//             return false;
//         }
//     }

public function sendPhishingMail2($email_from, $mailData, $email_to, $mailObject)
{
    try {
        // Determine sender email based on type
        $senderMail = $mailData->senderProfile['type'] === 'managed'
            ? $mailData->senderProfile['from_address_name'] . '@' .
              DB::table('phishing_domains')
                  ->where('id', $mailData->senderProfile['website_domain_id'])
                  ->value('name')
            : $mailData->senderProfile['from_address_name'];

                 $htmlContent = $mailObject->render();

        Mail::html($htmlContent, function ($message) use ($email_to, $mailData, $senderMail) {
            $message->to($email_to)
                   ->subject($mailData->subject)
                   ->from($senderMail, $mailData->senderProfile['from_display_name']);
        });


        return true;

    } catch (\Exception $e) {
        dd($e);
        \Log::error('Mail sending failed: ' . $e->getMessage());
        return [
            'status' => false,
            'message' => $e->getMessage()
        ];
    }
}
}
