<?php

namespace App\Jobs;

use App\Exports\AssetsExport;
use App\Exports\VulnerabilitiesExport;
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
use App\Models\TeamVulnerability;
use App\Models\User;
use App\Models\Vulnerability;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;

class ExportVulnJob implements ShouldQueue
{
    use NotificationHandlingTrait;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $userEmail;
    protected $index;
    protected $chunkSize;
    protected $link;
    protected $currentUser;
    protected $tenable_status;
    protected $severity;
    protected $region;
    protected $assetgroup;

    public function __construct($type, $tenable_status = null, $severity = null, $region, $userEmail, $index = 0, $chunkSize, $link, $currentUser, $assetgroup)
    {
        $this->type = $type;
        $this->userEmail = $userEmail;
        $this->index = $index;
        $this->chunkSize = $chunkSize;
        $this->link = $link;
        $this->currentUser = $currentUser;
        $this->tenable_status = $tenable_status;
        $this->severity = $severity;
        $this->region = $region;
        $this->assetgroup = $assetgroup;
    }

    public function handle()
    {
        $isPdf = $this->type === 'pdf';
        $files = [];

        $filterregion = $this->region;
        if ($this->currentUser->role_id != 1) {
            $teamIds = $this->currentUser->teams()->pluck('id')->toArray();
            $vulnerabilitiesFromTeamIds = TeamVulnerability::whereIn('team_id', $teamIds)->pluck('vulnerability_id')->toArray();

            $vulnerabilityRegionIds = Vulnerability::select('id')
                ->whereHas('assets.hostRegions', function ($query) use ($filterregion) {
                    $query->where('host_regions.id', $filterregion)->where('severity', '!=', 'Info');
                })
                ->pluck('id')
                ->toArray();

            $vulnerabilitiesFromCurrentUserIds = Vulnerability::where('created_by', auth()->id())
                ->when($this->tenable_status !== null, function ($query) {
                    return $query->where('tenable_status', $this->tenable_status);
                })
                ->when($this->severity !== null, function ($query) {
                    return $query->where('severity', $this->severity);
                })->whereIn('id', $vulnerabilityRegionIds)
                ->pluck('id')
                ->toArray();




            $allVulnerabilitiesId = array_merge($vulnerabilitiesFromTeamIds, $vulnerabilitiesFromCurrentUserIds);
            // Add a filter for asset group if $this->assetgroup is provided
            $query = Vulnerability::with(['teams:name', 'assets:name'])
                ->whereIn('id', $allVulnerabilitiesId)
                ->when($this->assetgroup !== null, function ($query) {
                    $query->whereHas('assets.assetGroups', function ($subQuery) {
                        $subQuery->where('asset_groups.id', $this->assetgroup);
                    });
                });

            unset($vulnerabilitiesFromTeamIds, $vulnerabilitiesFromCurrentUserIds, $allVulnerabilitiesId);
        } else {

            $vulnerabilityRegionIds = Vulnerability::select('id')
                ->whereHas('assets.hostRegions', function ($query) use ($filterregion) {
                    $query->where('host_regions.id', $filterregion)->where('severity', '!=', 'Info');
                })
                ->pluck('id')
                ->toArray();

                $query = Vulnerability::when($this->tenable_status !== null, function ($query) {
                    return $query->where('tenable_status', $this->tenable_status);
                })
                ->when($this->severity !== null, function ($query) {
                    return $query->where('severity', $this->severity);
                })
                ->whereIn('id', $vulnerabilityRegionIds)
                ->when($this->assetgroup !== null, function ($query) {
                    $query->whereHas('assets.assetGroups', function ($subQuery) {
                        $subQuery->where('asset_groups.id', $this->assetgroup);
                    });
                })
                ->with('teams:name', 'assets:name');
        }

        // Get the total count of vulns
        $total = $query->count();

        // Get the current offset and chunk size
        $currentOffset = $this->index * $this->chunkSize;

        // Fetch the vulns for the current chunk
        $vuln = $query->skip($currentOffset)->take($this->chunkSize)->get();
        $export = new VulnerabilitiesExport($vuln);

        // Define the folder structure and file name
        $folderPath = 'exports/vulns/';
        $filename = 'Vulns_' . ($this->index + 1) . '.xlsx';
        $filePath = $folderPath . $filename;

        // Check if the folder exists, if not, create it
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath); // Create the exports/vulns directory
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
        $generatedFiles = Cache::get('exported_vuln_files', []);
        $generatedFiles[] = $filePath;
        Cache::put('exported_vuln_files', $generatedFiles);

        // Dispatch a new job if there are more vulns to process
        if ($currentOffset + $this->chunkSize < $total) {
            dispatch(new ExportVulnJob($this->type, $this->tenable_status, $this->severity, $this->region, $this->userEmail, $this->index + 1, $this->chunkSize, $this->link, $this->currentUser, $this->assetgroup));
        } else {
            // If this is the last job, create a single ZIP file for all Excel files
            $zipFilePath = $this->createZipArchive($generatedFiles);

            // Ensure $zipFilePath is a string
            if (is_string($zipFilePath)) {
                $filename = basename($zipFilePath);

                $downloadUrl = ["link" => rtrim($this->link, '/') . '/' . urlencode($filename)];
                $message = "The Vuln File is ready. Click here to download.";
                $receivers = [$this->userEmail];
                $this->sendNotificationToArrayOfUsers($receivers, $message, $downloadUrl);
                // Send email with the ZIP file attached
                // $this->sendEmail($this->userEmail, $zipFilePath);
            } else {
                Log::error('Expected $zipFilePath to be a string, but received an array.');
            }
        }
    }



    protected function createZipArchive($files)
    {
        $baseFilename = 'VulnsExport';
        $extension = '.zip';
        $folderPath = 'exports/vulns/'; // Folder structure where the zip will be stored
        $zipFilename = $baseFilename . $extension;
        $zipPath = storage_path('app/' . $folderPath . $zipFilename);
        $counter = 1;

        // Check if the folder exists, if not, create it
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath); // Create the exports/vulns directory
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
            Cache::forget('exported_vuln_files');

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
            $mail->setFrom($email_config->smtp_from_username, $email_config->smtp_username);
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
                            <p>Your requested vulns export has been successfully processed. Please find the attached ZIP file containing all the exported vulns.</p>
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
