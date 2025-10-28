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
    protected $index;
    protected $chunkSize;
    protected $link;
    protected $currentUser;
    protected $tenable_status;
    protected $severity;
    protected $region;
    protected $assetgroup;
    protected $firstObserved;
    protected $lastObserved;
    protected $cve;
    protected $exploit;
    protected $owner_email;
    protected $ip;
    public function __construct($type, $tenable_status = null, $severity = null, $region, $index = 0, $chunkSize, $link, $currentUser, $assetgroup, $firstObserved = null, $lastObserved = null, $cve = null, $exploit = null, $owner_email = null, $ip = null)
    {
        $this->type = $type;
        $this->index = $index;
        $this->chunkSize = $chunkSize;
        $this->link = $link;
        $this->currentUser = $currentUser;
        $this->tenable_status = $tenable_status;
        $this->severity = $severity;
        $this->region = $region;
        $this->assetgroup = $assetgroup;
        $this->firstObserved = $firstObserved;
        $this->lastObserved = $lastObserved;
        $this->cve = $cve;
        $this->exploit = $exploit;
        $this->owner_email = $owner_email;
        $this->ip = $ip;
    }

    public function handle()
    {
        $isPdf = $this->type === 'pdf';
        $files = [];

        // Fetch IDs filtered by region if provided
        $vulnerabilityRegionIds = Vulnerability::when($this->region, function ($query) {
            $query->whereHas('assets.hostRegions', function ($q) {
                $q->where('host_regions.id', $this->region)
                    ->where('severity', '!=', 'Info');
            });
        })
            ->pluck('id')
            ->toArray();

        // Non-admin user
        if ($this->currentUser->role_id != 1) {
            $teamIds = $this->currentUser->teams()->pluck('id')->toArray();
            $vulnerabilitiesFromTeamIds = TeamVulnerability::whereIn('team_id', $teamIds)
                ->pluck('vulnerability_id')
                ->toArray();

            $vulnerabilitiesFromCurrentUserIds = Vulnerability::query()
                ->when($this->tenable_status !== null, fn($q) => $q->where('tenable_status', $this->tenable_status))
                ->when($this->severity, fn($q) => $q->where('severity', $this->severity))
                ->when($this->firstObserved && $this->lastObserved, fn($q) => $q->whereBetween('last_observed', [$this->firstObserved, $this->lastObserved]))
                ->when($this->owner_email, fn($q) => $q->whereHas('assets', fn($q) => $q->where('owner_email', $this->owner_email)))
                ->when($this->ip, fn($q) => $q->whereHas('assets', fn($q) => $q->where('ip', $this->ip)))
                ->when($this->cve, fn($q) => $q->where('cve', $this->cve))
                ->when($this->exploit, fn($q) => $q->where('exploit', $this->exploit))
                ->when($vulnerabilityRegionIds, fn($q) => $q->whereIn('id', $vulnerabilityRegionIds))
                ->pluck('id')
                ->toArray();

            $allVulnerabilitiesId = array_merge($vulnerabilitiesFromTeamIds, $vulnerabilitiesFromCurrentUserIds);

            $query = Vulnerability::with(['teams:name', 'assets','assets.hostRegions','assets.assetGroups'])
                ->when($allVulnerabilitiesId, fn($q) => $q->whereIn('id', $allVulnerabilitiesId))
                ->when($this->assetgroup, function ($q) {
                    $q->whereHas('assets.assetGroups', fn($sub) => $sub->where('asset_groups.id', $this->assetgroup));
                });
        } else { // Admin
            $query = Vulnerability::query()
                ->when($this->tenable_status !== null, fn($q) => $q->where('tenable_status', $this->tenable_status))
                ->when($this->severity !== null, fn($q) => $q->where('severity', $this->severity))
                ->when($this->firstObserved && $this->lastObserved, fn($q) => $q->whereBetween('last_observed', [$this->firstObserved, $this->lastObserved]))
                ->when($this->cve, fn($q) => $q->where('cve', $this->cve))
                ->when($this->exploit, fn($q) => $q->where('exploit', $this->exploit))
                ->when($this->owner_email, fn($q) => $q->whereHas('assets', fn($a) => $a->where('owner_email', $this->owner_email)))
                ->when($this->ip, fn($q) => $q->whereHas('assets', fn($q) => $q->where('ip', $this->ip)))
                ->when($vulnerabilityRegionIds, fn($q) => $q->whereIn('id', $vulnerabilityRegionIds))
                ->when($this->assetgroup, fn($q) => $q->whereHas('assets.assetGroups', fn($sub) => $sub->where('asset_groups.id', $this->assetgroup)))
                ->with(['teams:name', 'assets','assets.hostRegions','assets.assetGroups']);
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
            dispatch(new ExportVulnJob($this->type, $this->tenable_status, $this->severity, $this->region, $this->index + 1, $this->chunkSize, $this->link, $this->currentUser, $this->assetgroup));
        } else {
            // If this is the last job, create a single ZIP file for all Excel files
            $zipFilePath = $this->createZipArchive($generatedFiles);

            // Ensure $zipFilePath is a string
            if (is_string($zipFilePath)) {
                $filename = basename($zipFilePath);

                $downloadUrl = ["link" => rtrim($this->link, '/') . '/' . urlencode($filename)];
                $message = "The Vuln File is ready. Click here to download.";
                $receivers = [$this->currentUser->id];
                $this->sendNotificationToArrayOfUsers($receivers, $message, $downloadUrl);
                // Send email with the ZIP file attached
                // $this->sendEmail($this->currentUser->id, $zipFilePath);
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
            $mail->SMTPAuth = false;
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