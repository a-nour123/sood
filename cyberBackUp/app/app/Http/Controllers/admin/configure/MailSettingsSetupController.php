<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Action;
use App\Models\ControlMailContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\EmailConfig;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use jamesiarmes\PhpEws\Client as EwsClient;
use jamesiarmes\PhpEws\Request\CreateItemType;
use jamesiarmes\PhpEws\ArrayType\ArrayOfRecipientsType;
use jamesiarmes\PhpEws\Enumeration\MessageDispositionType;
use Swift_TransportException;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class MailSettingsSetupController extends Controller
{

    public function index()
    {
        // Check if the user has the required permission
        if (!auth()->user()->hasPermission('email-setting.create')) {
            abort(403, 'Unauthorized action.');
        }

        // Assuming you want to edit a specific record, you need its ID
        $emailConfigId = 1; // Replace with the ID of the record you want to edit

        // Retrieve the specific EmailConfig record by its ID
        $emailSettings = EmailConfig::find($emailConfigId);

        return view("admin.content.configure.mail_settings.create", compact('emailSettings'));
    }

    public function store(Request $request)
    {
        try {
            $emailConfig = EmailConfig::find(1);

            if ($emailConfig) {

                // Perform a connection test
                $this->updateEmailConfiguration($emailConfig, $request);
                $this->testEmailConnection($emailConfig);

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => __('locale.ConnectionTestSuccess') . ' Connection to SMTP/Exchange server successful.',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => __('locale.ConnectionTestFailed') . ' ' . $th->getMessage(),
            ]);
        }
    }


    private function updateEmailConfiguration($emailConfig, $request)
    {

        // Update the attributes of the email_config
        $emailConfig->email_type = $request->input('email_type');
        $emailConfig->smtp_username = $request->input('smtp_username');

        if ($request->input('smtp_password')) {
            if (preg_match('/^[^\s].*/', $request->input('smtp_password'))) {
                $emailConfig->smtp_password = $request->input('smtp_password');
            }
        }


        $emailConfig->smtp_server = $request->input('smtp_server');
        $emailConfig->smtp_port = $request->input('smtp_port');
        $emailConfig->ssl_tls = $request->input('smtp_security');
        $emailConfig->smtp_auth = $request->input('smtp_auth');
        $emailConfig->smtp_from_username = $request->input('smtp_from_username');
        // Save the updated email_config
        $emailConfig->save();
    }




    private function testEmailConnection($emailConfig)
    {
        if ($emailConfig->email_type == "smtp") {
            $this->testSmtpConnection($emailConfig);
        } elseif ($emailConfig->email_type == "exchange") {
            $this->testExchangeConnection($emailConfig);
        }
    }

    private function testSmtpConnection($emailConfig)
    {

        try {

            $transport = new Swift_SmtpTransport($emailConfig->smtp_server, $emailConfig->smtp_port, $emailConfig->ssl_tls);
            $transport->setPassword(base64_decode($emailConfig->smtp_password));
            $transport->setUsername($emailConfig->smtp_username);


            $mailer = new Swift_Mailer($transport);


            $transport->setStreamOptions([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            // Attempt to connect to SMTP server
            $mailer->getTransport()->start();

            return true;
        } catch (\Swift_TransportException $e) {

            $errorMessage = $e->getMessage();

            // Log the error for later analysis
            error_log('SMTP Connection Error: ' . $errorMessage);

            // Check for specific authentication failure patterns in the error message and customize accordingly
            if (strpos($errorMessage, '535-5.7.8 Username and Password not accepted') !== false) {
                throw new \Exception('SMTP Authentication Failed: The provided username and password are not accepted by the SMTP server. Please double-check your email and password.');
            } elseif (strpos($errorMessage, '535 Incorrect authentication data') !== false) {
                throw new \Exception('SMTP Authentication Failed: The provided username and password are incorrect. Please double-check your email and password.');
            } elseif (strpos($errorMessage, 'Expected response code 220 but got an empty response') !== false) {
                throw new \Exception('SMTP Connection Failed: The SMTP server did not respond. Please check your server configuration.');
            } elseif (strpos($errorMessage, 'stream_socket_client(): unable to connect') !== false) {
                throw new \Exception('Connection could not be established. Please check your network and firewall settings.');
            } elseif (strpos($errorMessage, 'Expected response code 220 but got an empty response') !== false) {
                throw new \Exception('Connection failed. The SMTP server did not respond as expected.');
            } elseif (strpos($e->getMessage(), 'stream_socket_client(): php_network_getaddresses: getaddrinfo failed') !== false) {
                throw new \Exception('Connection failed. The host "' . $emailConfig->smtp_server . '" could not be resolved. Please check the SMTP server address.');
            } else {
                // If it's not a specific pattern, provide a general error message with additional details
                throw new \Exception('SMTP Connection Failed: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            // Catch any other exceptions and provide a general error message with additional details
            throw new \Exception('SMTP Connection Failed: ' . $e->getMessage());
        }
    }







    private function testExchangeConnection($emailConfig)
    {
        try {
            if ($this->connectToExchangeServer($emailConfig)) {
                return true;
            } else {
                throw new \Exception('Unable to connect to Exchange server.');
            }
        } catch (\Exception $e) {
            throw new \Exception('Exchange Connection Failed: ' . $e->getMessage());
        }
    }



    private function connectToExchangeServer($emailConfig)
    {
        $ews = new EwsClient(
            $emailConfig->smtp_server,
            $emailConfig->smtp_username,
            $emailConfig->smtp_password
        );

        // Configure the client as needed, e.g., set the version
        $ews->setVersion(EwsClient::VERSION_2016);

        $ews->setCurlOptions([
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        try {
            // dd( $ews->getClient());
            $ews->getClient()->getServerTimeZones();
            // Attempt to connect to the Exchange server
            // $ews->getClient()->options()->start('GetServerTimeZones');

            // If no exception is thrown, the connection was successful
            return true;
        } catch (\Exception $e) {
            // dd($e);
            // Handle the exception (e.g., log the error)
            return false;
        }
    }

    public function mailControl(Request $request)
    {
        // Validate the request
        $request->validate([
            'type' => 'required|string',
            'content' => 'required|string',
        ]);

        // Use updateOrCreate to either update the existing record or create a new one
        ControlMailContent::updateOrCreate(
            ['type' => $request->type], // Condition to find the existing record
            ['content' => $request->content, 'subject' => $request->subject] // Attributes to update or create
        );


        // Return a success response
        return response()->json(['success' => 'Data inserted successfully!']);
    }
    public function fetchMailControl(Request $request)
    {
        $type = $request->input('type');

        // Retrieve the mail content based on the type
        $mailContent = ControlMailContent::where('type', $type)->first();
        if ($mailContent) {
            return response()->json([
                'content' => $mailContent->content,
                'subject' => $mailContent->subject, // Assuming you have a 'subject' field
            ]);
        }

        return response()->json(['content' => '', 'subject' => ''], 404);
    }
}
