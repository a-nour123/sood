<?php

namespace App\Jobs;

use App\Events\FinishTenableCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Asset;
use App\Models\AssetVulnerability;
use App\Models\TenableAuth;
use App\Models\TenableHistory;
use App\Models\Vulnerability;
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

class TenableImport implements ShouldQueue
{
    use NotificationHandlingTrait;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hostsAndVulnerabilities;
    protected $vulnerabilitiesData;
    protected $typeSource;
    protected $start;
    protected $end;
    protected $total;
    protected $history;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hostsAndVulnerabilities, $typeSource, $start, $end, $total,$history)
    {
        $this->hostsAndVulnerabilities = $hostsAndVulnerabilities;
        $this->typeSource = $typeSource;
        $this->start = $start;
        $this->end = $end;
        $this->total = $total;
        $this->history = $history;
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
print_r($this->total);        
if ($tenableAuth->total > $tenableAuth->offset) {
            $this->history->update([
                'start'=> $tenableAuth->offset,
                'total'=>  $tenableAuth->total
            ]);
            }

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
            $this->history->update([
                'status'=>  0,
                'start' => $this->history->total
            ]);
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
                    $vulnerabilityId = DB::table('vulnerabilities as v')
                        ->join('asset_vulnerabilities as av', 'v.id', '=', 'av.vulnerability_id')
                        ->where('v.plugin_id', $vulnerability['pluginID'])
                        ->where('v.port', $vulnerability['port'])
                        ->where('v.first_discovered', $first_discovered)
                        ->where('av.asset_id', $asset->id)
                        ->select('v.id')
                        ->first();
                    if ($vulnerabilityId) {
                        $vulnerabilityModel = Vulnerability::find($vulnerabilityId->id);
                    }

                    $vulnerabilityData = [
                        'name' => $vulnerability['pluginName'] ?? null,
                        'cve' => $vulnerability['cve'] ?? null,
                        'description' => $vulnerability['description'] ?? null,
                        'severity' => $severityName ?? null,
                        'recommendation' => $vulnerability['solution'] ?? null,
                        'plan' => $vulnerability['pluginInfo'] ?? null,
                        'tenable_status' => $this->typeSource ?? null,
                        'ip_address' => $vulnerability['ip'] ?? null,
                        // 'netbios_name' => $vulnerability['netbiosName'],
                        // 'dns_name' => $vulnerability['dnsName'] ?? null,
                        'plugin_id' => $vulnerability['pluginID'] ?? null,
                        'protocol' => $vulnerability['protocol'] ?? null,
                        'port' => $vulnerability['port' ?? null],
                        'exploit' => $vulnerability['exploitAvailable'] ?? null,
                        'synopsis' => $vulnerability['synopsis'] ?? null,
                        'last_observed' => $last_observed ?? null,
                        'plugin_publication_date' => $plugin_publication_date ?? null,
                        'plugin_modification_date' => $plugin_modification_date ?? null,

                        // Newly added fields
                        'family' => $vulnerability['family']['name'] ?? null,
                        'acr' => $vulnerability['acrScore'] ?? null,
                        'aes' => $vulnerability['assetExposureScore'] ?? null,
                        'repository' => $vulnerability['repository']['name'] ?? null,
                        'mac_address' => $vulnerability['macAddress'] ?? null,
                        'plugin_output' => $vulnerability['pluginText'] ?? null,
                        'steps_to_remediate' => $vulnerability['solution'] ?? null,
                        'see_also' => $vulnerability['seeAlso'] ?? null,
                        'risk_factor' => $vulnerability['riskFactor'] ?? null,
                        'stig_severity' => $vulnerability['stigSeverity'] ?? null,
                        'vuln_priority_rating' => $vulnerability['vprScore'] ?? null,
                        'cvss_v2' => $vulnerability['baseScore'] ?? null,
                        'cvss_v3' => $vulnerability['cvssV3BaseScore'] ?? null,
                        'cvss_v2_temporal_score' => $vulnerability['temporalScore'] ?? null,
                        'cvss_v3_temporal_score' => $vulnerability['cvssV3TemporalScore'] ?? null,
                        'cvss_v2_vector' => $vulnerability['cvssVector'] ?? null,
                        'cpe' => $vulnerability['cpe'] ?? null,
                        'bid' => $vulnerability['bid'] ?? null,
                        'cross_reference' => $vulnerability['xref'] ?? null,
                        'severity_end_of_life' => $vulnerability['vulnPubDate'] ?? null,
                        'patch_publication' => $vulnerability['patchPubDate'] ?? null,
                        'plus_modification' => $vulnerability['pluginModDate'] ?? null,
                        'exploit_ease' => $vulnerability['exploitEase'] ?? null,
                        'exploit_framework' => $vulnerability['exploitFrameworks'] ?? null,
                        'check_type' => $vulnerability['checkType'] ?? null,
                        'version' => $vulnerability['version'] ?? null,
                        'recast_risk_comment' => $vulnerability['recastRiskRuleComment'] ?? null,
                        'agent_id' => $vulnerability['hostUUID'] ?? null,
                        'service' => $vulnerability['operatingSystem'] ?? null,
                        'department' => $vulnerability['repository']['description'] ?? null,
                        'system' => $vulnerability['operatingSystem'] ?? null,
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
                        $vulnerabilityModel = Vulnerability::create($vulnerabilityData);
                    }

                    $vulnerabilityId = $vulnerabilityModel->id;
                    $asset->vulnerabilities()->syncWithoutDetaching([$vulnerabilityId]);
                    // Create a new TenableHistory record for vuln
                    TenableHistory::create([
                        'vuln_id' => $vulnerabilityId,
                        'asset_id' => $asset->id,
                        'severity' => $severityName,
                        'status' => $vulnerabilityModel->tenable_status,
                        'created_at' => now(),
                    ]);

		    print_r("added");
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
