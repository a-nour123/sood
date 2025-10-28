<?php

namespace App\Jobs;

use App\Exports\AssetsExport;
use App\Http\Traits\NotificationHandlingTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Storage;
use App\Models\Asset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\AssetsExportMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;

class ExportAssetsJob implements ShouldQueue
{
    use NotificationHandlingTrait;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $userEmail;
    protected $index;
    protected $chunkSize;
    protected $link;
    protected $region;

    public function __construct($type,$region=null, $userEmail, $index = 0, $chunkSize, $link)
    {
        $this->type = $type;
        $this->userEmail = $userEmail;
        $this->index = $index;
        $this->chunkSize = $chunkSize;
        $this->link = $link;
        $this->region = $region;
    }

    public function handle()
    {
        $isPdf = $this->type === 'pdf';
        $files = [];


        $regionId = $this->region;
        if($regionId){
            $query = Asset::with('assetCategory')
            ->whereHas('hostRegions', function ($q) use ($regionId) {
                $q->where('asset_host_region.host_region_id', $regionId); // Specify the table name
            })
            ->with(['hostRegions' => function ($q) use ($regionId) {
                $q->where('asset_host_region.host_region_id', $regionId); // Specify the table name
            }]);
        }else{
            $query = Asset::with('assetCategory');
        }


        $total = $query->count();


        // Get the current offset and chunk size
        $currentOffset = $this->index * $this->chunkSize;

        // Fetch the assets for the current chunk
        $assets = $query->skip($currentOffset)->take($this->chunkSize)->get();

        $export = new AssetsExport($assets);

        // Define the folder structure and file name
        $folderPath = 'exports/assets/';
        $filename = 'Assets_' . ($this->index + 1) . '.xlsx';
        $filePath = $folderPath . $filename;

        // Check if the folder exists, if not, create it
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath); // Create the exports/assets directory
        }

        if ($isPdf) {
            // Handle PDF export here if needed
        } else {
            $result = Excel::store($export, $filePath);
            if ($result) {
                Log::info("File created successfully: " . $filename);
            } else {
                Log::error("Failed to create file: " . $filename);
            }
        }

        $files[] = storage_path('app/' . $filePath);

        // Store the generated file paths in a shared cache
        $generatedFiles = Cache::get('exported_asset_files', []);
        $generatedFiles[] = $filePath;
        Cache::put('exported_asset_files', $generatedFiles);

        // Dispatch a new job if there are more assets to process
        if ($currentOffset + $this->chunkSize < $total) {
            dispatch(new ExportAssetsJob($this->type, $this->region,$this->userEmail, $this->index + 1, $this->chunkSize, $this->link));
        } else {
            // If this is the last job, create a single ZIP file for all Excel files
            $zipFilePath = $this->createZipArchive($generatedFiles);

            // Ensure $zipFilePath is a string
            if (is_string($zipFilePath)) {
                $filename = basename($zipFilePath);
                $downloadUrl = ["link" => rtrim($this->link, '/') . '/' . urlencode($filename)];
                $message = "The Asset File is ready. Click here to download.";
                $receivers = [$this->userEmail];

                $this->sendNotificationToArrayOfUsers($receivers, $message, $downloadUrl);
            } else {
                Log::error('Expected $zipFilePath to be a string, but received an array.');
            }
        }
    }



    protected function createZipArchive($files)
    {
        $baseFilename = 'AssetsExport';
        $extension = '.zip';
        $folderPath = 'exports/assets/'; // Folder structure where the zip will be stored
        $zipFilename = $baseFilename . $extension;
        $zipPath = storage_path('app/' . $folderPath . $zipFilename);
        $counter = 1;

        // Check if the folder exists, if not, create it
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath); // Create the exports/assets directory
        }

        // Check if the zip file already exists and create a unique filename if necessary
        while (file_exists($zipPath)) {
            $zipFilename = $baseFilename . '_' . $counter . $extension;
            $zipPath = storage_path('app/' . $folderPath . $zipFilename);
            $counter++;
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                // Ensure the file exists before attempting to add it to the ZIP
                $fullPath = storage_path('app/' . $file);
                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, basename($file));
                } else {
                    Log::warning("File does not exist: " . $fullPath);
                }
            }
            $zip->close();

            // Optionally delete the individual Excel files after zipping
            foreach ($files as $file) {
                $fullPath = storage_path('app/' . $file);
                if (file_exists($fullPath)) {
                    if (unlink($fullPath)) {
                        Log::info("Deleted file: " . $fullPath);
                    } else {
                        Log::error("Failed to delete file: " . $fullPath);
                    }
                } else {
                    Log::warning("File does not exist: " . $fullPath);
                }
            }

            // Clear the cache after zipping
            Cache::forget('exported_asset_files');

            Log::info("All files zipped successfully: " . $zipFilename);
        } else {
            Log::error("Failed to create ZIP file: " . $zipFilename);
        }

        return $zipPath;  // Return the path to the ZIP file as a string
    }



    protected function sendEmail($userEmail, $zipFilePath)
    {
        $email_to = $userEmail;
        $email_config = DB::table('email_config')->first();

        if (!$email_config) {
            $response = [
                'status' => false,
                'message' => __('Email configuration not found.'),
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
            $mail->SMTPAuth = true;
            $mail->Port = $email_config->smtp_port;
            $mail->Host = $email_config->smtp_server;
            $mail->Username = $email_config->smtp_username;
            $mail->Password =   base64_decode($email_config->smtp_password);
            $mail->SMTPSecure = $email_config->ssl_tls;
            $mail->isHTML(true);
            $mail->addAddress($email_to);
            $mail->setFrom($email_config->smtp_from_username,$email_config->smtp_username);
            $mail->Subject = "Export Completed: Your Assets Data is Ready";
            $mail->addAddress($email_to);

            // Build the email body content
            $mail->Body = "
            <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            color: #333;
                            padding: 20px;
                        }
                        .container {
                            background-color: #fff;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        }
                        .header {
                            font-size: 24px;
                            margin-bottom: 20px;
                            color: #007bff;
                        }
                        .content {
                            font-size: 16px;
                            line-height: 1.6;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 12px;
                            color: #777;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>Your Assets Export is Ready</div>
                        <div class='content'>
                            <p>Dear User,</p>
                            <p>Your requested assets export has been successfully processed. Please find the attached ZIP file containing all the exported assets.</p>
                            <p>If you have any questions or need further assistance, feel free to reply to this email.</p>
                            <p>Thank you for using our service!</p>
                        </div>
                        <div class='footer'>
                            <p>This email was sent from an automated system. Please do not reply directly to this email.</p>
                        </div>
                    </div>
                </body>
            </html>
            ";

            // Attach the ZIP file
            $mail->addAttachment($zipFilePath, 'AssetsExport.zip');

            // SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false
                )
            );

            // Send the email
            if ($mail->send()) {
                Log::info('Email sent successfully to ' . $userEmail);
                $response = [
                    'status' => true,
                    'message' => __('Email sent successfully.'),
                ];
            } else {
                Log::error('Email sending failed: ' . $mail->ErrorInfo);
                $response = [
                    'status' => false,
                    'message' => __('Email sending failed: ') . $mail->ErrorInfo,
                ];
            }
        } catch (Exception $e) {
            Log::error('Exception occurred while sending email: ' . $e->getMessage());
            $response = [
                'status' => false,
                'message' => __('Error occurred while sending email: ') . $e->getMessage(),
            ];
        }

        return response()->json($response, $response['status'] ? 200 : 500);
    }
}
