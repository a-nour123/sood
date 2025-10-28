<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendCampaignEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $userId;
    protected $bodyContent;
    protected $survey;

    public function __construct($userId, $bodyContent, $survey)
    {
        $this->userId = $userId;
        $this->bodyContent = $bodyContent;
        $this->survey = $survey;
    }

    public function handle()
    {
        $email_to = $this->userId;
        $bodyContent = $this->bodyContent;
        $email_config = DB::table('email_config')->first();

        if (!$email_config) {
            // Handle the case where email configuration is not found
            $response = [
                'status' => false,
                'message' => __('error_occured'),
            ];
            return response()->json($response, 500);
        }

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try { 
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->SMTPDebug = false;
            $mail->Mailer = "smtp";
            $mail->SMTPAuth = false;
            $mail->Port = $email_config->smtp_port;
            $mail->Host = $email_config->smtp_server;
            $mail->Username = $email_config->smtp_username;
            $mail->Password =   base64_decode($email_config->smtp_password);
            $mail->SMTPSecure = $email_config->ssl_tls;
            $mail->isHTML(true);
            $mail->setFrom($email_config->smtp_from_username, $email_config->smtp_username);
            $mail->Body = $bodyContent;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false
                )
            );

            // ... (your existing code)

            foreach ($email_to as $recipient) {
                // Check if the email address is not empty before adding it as a recipient
                if (!empty($recipient)) {
                    $mail->addAddress($recipient);

                    if ($mail->send()) {
                        // Successful email sending to $recipient
                        $response[] = [
                            'status' => true,
                            'message' => __('success'),
                            'recipient' => $recipient,
                        ];
                    } else {
                        // Failed to send email to $recipient
                        $response[] = [
                            'status' => false,
                            'message' => __('error_occured'),
                            'recipient' => $recipient,
                        ];
                    }

                    // Clear recipients for the next iteration
                    $mail->ClearAllRecipients();
                }
            }

            // ... (the rest of your existing code)


        } catch (Exception $e) {
            // Dump the exception details for debugging
            $response = [
                'status' => false,
                'message' => __('error_occurred'),
                'exception' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ],
            ];
        }

        return response()->json($response, 500);
    }
}
