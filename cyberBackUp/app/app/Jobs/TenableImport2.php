<?php

namespace App\Jobs;

use App\Models\Asset;
use App\Models\TenableAuth;
use App\Models\Vulnerability;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Services\TenableService;

class TenableImport implements ShouldQueue
{
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
            return;
        }
        $tenableAuth->offset += 0; // Corrected syntax for typecasting
        $tenableAuth->end += 500; // Corrected syntax for typecasting
        $tenableAuth->total = $this->total; // Corrected syntax for typecasting
        $tenableAuth->save();

        // Insert hosts and vulnerabilities into the database
        foreach ($this->hostsAndVulnerabilities as $data) {
            try {
                // DB::beginTransaction(); // Begin transaction
                // Insert or update the host record

                // Insert or update the host record
                $asset = Asset::firstOrNew([
                    'ip' => $data['host']['ipAddress'],
                    'name' => $data['host']['name']
                ]);

                // If the asset was not found, set the IP and name attributes
                if (!$asset->exists) {
                    $asset->name = $data['host']['name'];
                    $asset->ip = $data['host']['ipAddress'];
                    $asset->save();
                }




                // Iterate over vulnerabilities data and insert/update each vulnerability
                foreach ($data['vulnerabilities'] as $vulnerability) {



                    $severityName = $vulnerability['severity']['name'];

                    // Convert Unix timestamps to formatted date strings
                    $first_discovered = Carbon::createFromTimestamp($vulnerability['firstSeen'])->toDateTimeString();
                    $last_observed = Carbon::createFromTimestamp($vulnerability['lastSeen'])->toDateTimeString();
                    $plugin_publication_date = Carbon::createFromTimestamp($vulnerability['pluginPubDate'])->toDateTimeString();
                    $plugin_modification_date = Carbon::createFromTimestamp($vulnerability['pluginModDate'])->toDateTimeString();

                    // Insert or update the vulnerability record
                    $vulnerabilityModel = Vulnerability::updateOrCreate(
                        [
                            'plugin_id' => $vulnerability['pluginID'],
                            'first_discovered' => $first_discovered
                        ],
                        [
                            'name' => $vulnerability['pluginName'],
                            'cve' => $vulnerability['cve'],
                            'description' => $vulnerability['description'],
                            'severity' => $severityName,
                            'recommendation' => $vulnerability['solution'],
                            'plan' => $vulnerability['pluginInfo'],
                            'tenable_status' => $this->typeSource,
                            'created_by' => 1,
                            'ip_address' => $vulnerability['ip'],
                            // 'netbios_name' => $vulnerability['netbiosName'],
                            // 'dns_name' => $vulnerability['dnsName'],
                            'plugin_id' => $vulnerability['pluginID'],
                            'protocol' => $vulnerability['protocol'],
                            'port' => $vulnerability['port'],
                            'exploit' => $vulnerability['exploitAvailable'],
                            'synopsis' => $vulnerability['synopsis'],
                            'first_discovered' => $first_discovered,
                            'last_observed' => $last_observed,
                            'plugin_publication_date' => $plugin_publication_date,
                            'plugin_modification_date' => $plugin_modification_date
                        ]
                    );


                    // Retrieve current status from the database
                    $currentStatus = $vulnerabilityModel->status;

                    // Only update the status if the current status is not 'Overdue'
                    if ($currentStatus !== 'Overdue') {
                        if ($this->typeSource == 'cumulative') {
                            $vulnerabilityModel->status = 'Open';
                        } else {
                            $vulnerabilityModel->status = 'Closed';
                        }
                    }

                    // Save the vulnerability model
                    $vulnerabilityModel->save();

                    $vulnerabilityId = $vulnerabilityModel->id;

                    // Check if the combination already exists in the pivot table
                    $exists = $asset->vulnerabilities()
                        ->wherePivot('vulnerability_id', $vulnerabilityId)
                        ->exists();


                    if (!$exists) {
                        $asset->vulnerabilities()->attach($vulnerabilityId);
                    }
                }
                DB::commit(); // Commit transaction

            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on exception
                dd($e);
            }
        }
        if ($tenableAuth->total > $tenableAuth->offset) {
            $tenableService = new TenableService();
            $tenableService->syncHostsAndVulnerabilities();
        } else {
            $tenableAuth->offset = 0;
            $tenableAuth->end = 499;
            $tenableAuth->total = 1;
            $tenableAuth->save();
        }
    }
}
