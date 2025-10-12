<?php

namespace App\Jobs;

use App\Events\FinishTenableCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Asset;
use App\Models\AssetVulnerability;
use App\Models\TenableAuth;
use App\Models\Vulnerability;
use App\Models\VulnerabilityInfo;
use App\Services\TenableService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class TenableImportInfoVuln implements ShouldQueue
{
    use NotificationHandlingTrait;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hostsAndVulnerabilities;
    protected $vulnerabilitiesData;
    protected $typeSource;
    protected $start;
    protected $end;
    protected $total;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hostsAndVulnerabilities, $typeSource, $start, $end, $total)
    {
        $this->hostsAndVulnerabilities = $hostsAndVulnerabilities;
        $this->typeSource = $typeSource;
        $this->start = $start;
        $this->end = $end;
        $this->total = $total;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $tenableAuth = TenableAuth::first();

        if ($tenableAuth->offset >= $tenableAuth->total) {
            $this->HandelNotification();
            return;
        }
        $tenableAuth->offset += 500; // Increment offset
        $tenableAuth->end += 500; // Increment end
        $tenableAuth->total = $this->total; // Update total
        $tenableAuth->save();

        // Process data in chunks
        $this->processInChunks($this->hostsAndVulnerabilities);

        if ($tenableAuth->total > $tenableAuth->offset) {
            $tenableService = new TenableService();
            $tenableService->syncHostsAndVulnerabilities();
        } else {
            $tenableAuth->offset = 0;
            $tenableAuth->end = 500;
            $tenableAuth->total = 1; // Reset total to null when all records are fetched
            $tenableAuth->save();
            $this->HandelNotification();
        }
    }

    protected function processInChunks($data)
    {
        $chunkSize = 1; // Define your preferred chunk size

        // Chunk the data and process each chunk
        collect($data)->chunk($chunkSize)->each(function ($chunk) {
            foreach ($chunk as $data) {
                try {
                     DB::beginTransaction(); // Begin transaction

                    // Insert or update the host record
                    $asset = Asset::firstOrCreate(
                        ['ip' => $data['host']['ipAddress'], 'name' => $data['host']['name']],
                        ['name' => $data['host']['name'], 'ip' => $data['host']['ipAddress']]
                    );

                    // Iterate over vulnerabilities data and insert/update each vulnerability
                    $vulnerability = $data['vulnerabilities'][0];
                    // Convert Unix timestamps to formatted date strings
                    $first_discovered = Carbon::createFromTimestamp($vulnerability['firstSeen'])->toDateTimeString();
                    $last_observed = Carbon::createFromTimestamp($vulnerability['lastSeen'])->toDateTimeString();
                    $plugin_publication_date = Carbon::createFromTimestamp($vulnerability['pluginPubDate'])->toDateTimeString();
                    $plugin_modification_date = Carbon::createFromTimestamp($vulnerability['pluginModDate'])->toDateTimeString();
                    $severityName = $vulnerability['severity']['name'];

                    $vulnerabilityModel = null;
                    $vulnerabilityId = DB::table('vulnerability_infos as v')
                        ->join('asset_vulnerability_infos as av', 'v.id', '=', 'av.vulnerability_id')
                        ->where('v.plugin_id', $vulnerability['pluginID'])
                        ->where('v.port', $vulnerability['port'])
                        ->where('v.first_discovered', $first_discovered)
                        ->where('av.asset_id', $asset->id)
                        ->select('v.id')
                        ->first();
                    if ($vulnerabilityId) {
                        $vulnerabilityModel = VulnerabilityInfo::find($vulnerabilityId->id);
                    }

                    $vulnerabilityData = [
                        'name' => $vulnerability['pluginName'],
                        'cve' => $vulnerability['cve'],
                        'description' => $vulnerability['description'],
                        'severity' => $severityName,
                        'recommendation' => $vulnerability['solution'],
                        'plan' => $vulnerability['pluginInfo'],
                        'tenable_status' => $this->typeSource,
                        'ip_address' => $vulnerability['ip'],
                        'netbios_name' => isset($vulnerability['netbiosName']) ? $vulnerability['netbiosName'] : null,
                        'dnsName' => isset($vulnerability['dnsName']) ? $vulnerability['dnsName'] : null,
                         'plugin_id' => $vulnerability['pluginID'],
                        'protocol' => $vulnerability['protocol'],
                        'port' => $vulnerability['port'],
                        'exploit' => $vulnerability['exploitAvailable'],
                        'synopsis' => $vulnerability['synopsis'],
                        'last_observed' => $last_observed,
                        'plugin_publication_date' => $plugin_publication_date,
                        'plugin_modification_date' => $plugin_modification_date
                    ];

                    if ($vulnerabilityModel) {
                        // Update the existing vulnerability
                        $vulnerabilityModel->update($vulnerabilityData);
                        // Retrieve current status from the database
                        $currentStatus = $vulnerabilityModel->status;
                        // Only update the status if the current status is not 'Overdue'
                        if ($currentStatus !== 'Overdue') {
                            if ($this->typeSource == 'cumulative') {
                                $vulnerabilityModel->update(['tenable_status' => 'Open']);
                            } else {
                                $vulnerabilityModel->update(['tenable_status' => 'Closed']);
                            }
                        }
                    } else {

                        $status = null;
                        if ($this->typeSource == 'cumulative') {
                            $status = 'Open';
                        } else {
                            $status = 'Closed';
                        }

                        $vulnerabilityData['first_discovered'] = $first_discovered;
                        $vulnerabilityData['created_by'] = 1;
                        $vulnerabilityData['tenable_status'] = $status;

                        // Insert a new vulnerability
                        $vulnerabilityModel = VulnerabilityInfo::create($vulnerabilityData);
                    }

                    $vulnerabilityId = $vulnerabilityModel->id;
                    $asset->vulnerabilitiesInfo()->syncWithoutDetaching([$vulnerabilityId]);

                    DB::commit(); // Commit transaction

                } catch (RequestException $e) {
                    // Handle request timeout gracefully
                    Log::error('Request Timeout: ' . $e->getMessage());
                    // Retry the job after a delay, with exponential backoff
                    $this->release(2 * $this->attempts());
                } catch (\Exception $e) {
                    // Other exceptions
                    Log::error('Exception occurred: ' . $e->getMessage());
                    // Rollback transaction if needed
                    DB::rollBack();
                }
            }
        });
    }
    public function HandelNotification()
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'FinishTenable')->first();
        $actionId1 = $action1['id'];

        // Get the vuln 
        $tenable = [];
        $roles = [];

        //defining the link we want user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.vulnerability_management.index')];
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $tenable, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
