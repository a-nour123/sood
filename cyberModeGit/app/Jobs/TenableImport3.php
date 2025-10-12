<?php

namespace App\Jobs;

use App\Models\Asset;
use App\Models\AssetVulnerability;
use App\Models\TenableAuth;
use App\Models\Vulnerability;
use App\Services\TenableService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TenableImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hostsAndVulnerabilities;
    protected $vulnerabilitiesData;
    protected $typeSource;
    protected $user_id;
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
        $tenableAuth->offset += 500; // Increment offset
        $tenableAuth->end += 500; // Increment end
        $tenableAuth->total = $this->total; // Update total
        $tenableAuth->save();

        // Insert hosts and vulnerabilities into the database
        foreach ($this->hostsAndVulnerabilities as $data) { //500

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

                $existingVulnerabilityIds = Vulnerability::where([
                    'plugin_id' => $vulnerability['pluginID'],
                    'first_discovered' => $first_discovered
                ])->pluck('id');

                $vulnerabilityModel = null;
                if ($existingVulnerabilityIds->isNotEmpty()) {
                    // Check if there is an asset vulnerability link for any of the existing vulnerabilities
                    $vulnerabilityId = AssetVulnerability::where('asset_id', $asset->id)
                        ->whereIn('vulnerability_id', $existingVulnerabilityIds)
                        ->pluck('vulnerability_id')
                        ->first();
                    if ($vulnerabilityId) {
                        $vulnerabilityModel = Vulnerability::find($vulnerabilityId);
                    }
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
                    // 'netbios_name' => $vulnerability['netbiosName'],
                    // 'dns_name' => $vulnerability['dnsName'],
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
                            $vulnerabilityModel->update(['status' => 'Open']);
                        } else {
                            $vulnerabilityModel->update(['status' => 'Closed']);
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
                    $vulnerabilityData['status'] = $status;

                    // Insert a new vulnerability
                    $vulnerabilityModel = Vulnerability::create($vulnerabilityData);
                }

                $vulnerabilityId = $vulnerabilityModel->id;
                $asset->vulnerabilities()->syncWithoutDetaching([$vulnerabilityId]);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
            }
        }

        if ($tenableAuth->total > $tenableAuth->offset) {
            $tenableService = new TenableService();
            $tenableService->syncHostsAndVulnerabilities();
        } else {
            $tenableAuth->offset = 0;
            $tenableAuth->end = 500;
            $tenableAuth->total = 1;
            $tenableAuth->save();
        }
    }
}
