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

class SendNdaEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $userId;
    protected $bodyContent;
    protected $nda;
    protected $subject;

    public function __construct($userId, $bodyContent, $nda, $subject)
    {
        $this->userId = $userId;
        $this->bodyContent = $bodyContent;
        $this->nda = $nda;
        $this->subject = $subject;
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


            $header = '
            <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDD; padding-bottom:10px;">
                <tr>
                    <td style="text-align: center; vertical-align: middle;">
                        <h2 style="font-family: Arial, sans-serif; color: #333; margin: 0;">GRC Platform </h2>

                    </td>
                </tr>
            </table>';

            $subjectStyled = '
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                <tr>
                    <td style="text-align: center; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                        <br>
                        ' . $this->subject  . '
                    </td>
                </tr>
            </table>';


            $bodyStyled = '
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; padding: 20px;">
                        ' . $bodyContent . '
                    </td>
                </tr>
            </table>';


            $emailBody = '
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f8f8; padding: 20px;">
                <tr>
                    <td>
                        <table width="550" cellpadding="0" cellspacing="0" style="margin: 0 auto; background-color: #ffffff; border: 1px solid #DDD; padding: 20px;">
                            <tr>
                                <td>
                                    ' . $header . '
                                    ' . $subjectStyled . '
                                    ' . $bodyStyled . '
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';



            // Set the email body and subject
            $mail->Body = $emailBody;
            $mail->Subject = $this->subject;
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
