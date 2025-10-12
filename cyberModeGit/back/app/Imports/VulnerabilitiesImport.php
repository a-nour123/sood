<?php

namespace App\Imports;

use App\Models\Vulnerability;
use App\Models\Asset;
use App\Models\Team;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class VulnerabilitiesImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation
{
    use Importable;

    /**
     * Mapping of columns from the import file to database columns.
     *
     * @var array
     */
    public $columnsMapping;

    /**
     * Constructor to set the columns mapping.
     *
     * @param array $columnsMapping
     */
    public function __construct($columnsMapping)
    {
        $this->columnsMapping = $columnsMapping;
    }

    /**
     * Process each row of the collection during the import.
     *
     * @param  \Illuminate\Support\Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $PluginId = $row[$this->columnsMapping['plugin_id']] ?? 'Not Val';
            $vulnerabilityIp = $row[$this->columnsMapping['ip_address']] ?? 'Not Val';
            $port = $row[$this->columnsMapping['port']] ?? 'Not Val';
            
            $vulnerabilityFirstDiscoveredTime = ($this->columnsMapping['first_discovered'] && $row[$this->columnsMapping['first_discovered']]) ? $this->convertToTimestamp($row[$this->columnsMapping['first_discovered']]) : null;
            $existingVulnerability = Vulnerability::where('plugin_id', $PluginId)
                ->where('port', $port)
            ->where('ip_address', $vulnerabilityIp)
                ->where('first_discovered', $vulnerabilityFirstDiscoveredTime)
                ->first();
            // Check if an vulnerability with the same name already exists
            if (!$existingVulnerability) {

                // Extract data from the row and perform necessary transformations
                $teamsString = $row[$this->columnsMapping['teams']] ?? null;
                $teamIds = $this->processTeams($teamsString);


                if ($vulnerabilityIp) {
                    $assets = Asset::where('ip', $vulnerabilityIp)->get();

                    if ($assets->isEmpty()) {
                        $assets[] = Asset::create([
                            'name' => $vulnerabilityIp,
                            'ip' => $vulnerabilityIp,
                            'verified' => 'verified',
                            'created' => date('Y-m-d H:i:s'),
                        ]);
                    }
                } else {
                    $assets = [];
                }

                $vulnerabilitySeverity = $row[$this->columnsMapping['severity']] ? $this->handleSeverity($row[$this->columnsMapping['severity']]) : null;
                $vulnerabilityStatus = ($this->columnsMapping['status'] && $row[$this->columnsMapping['status']]) ? ucwords($row[$this->columnsMapping['status']]) : null;
                $vulnerabilityExploit = ($this->columnsMapping['status'] && $row[$this->columnsMapping['exploit']]) ? strtolower($row[$this->columnsMapping['status']]) : null;

                // Create a new Vulnerability record in the database
                $vulnerability =  Vulnerability::create([
                        'plugin_id' => $row[$this->columnsMapping['plugin_id']] ?? null,
                    'name' => $row[$this->columnsMapping['plugin_name']] ?? null,
                    'ip_address' => $row[$this->columnsMapping['ip_address']] ?? null,
                    'cve' => $row[$this->columnsMapping['cve']] ?? null,
                    'severity' => $vulnerabilitySeverity ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'recommendation' => $row[$this->columnsMapping['solution']] ?? null,
                    'plan' => $row[$this->columnsMapping['plugin_output']] ?? null,
                    'status' => $vulnerabilityStatus ?? 'Open',
                    'dns_name' => $row[$this->columnsMapping['dns_name']] ?? null,
                    'netbios_name' => $row[$this->columnsMapping['netbios_name']] ?? null,
                    'plugin_id' => $row[$this->columnsMapping['plugin_id']] ?? null,
                    'protocol' => $row[$this->columnsMapping['protocol']] ?? null,
                    'port' => $row[$this->columnsMapping['port']],
                    'exploit' => $vulnerabilityExploit ?? 'no',
                    'synopsis' => $row[$this->columnsMapping['synopsis']] ?? null,
                    'first_discovered' => $vulnerabilityFirstDiscoveredTime,
                    'last_observed' => ($this->columnsMapping['plugin_publication_date'] && $row[$this->columnsMapping['last_observed']]) ? $this->convertToTimestamp($row[$this->columnsMapping['last_observed']]) : null,
                    'plugin_publication_date' => ($this->columnsMapping['plugin_publication_date'] && $row[$this->columnsMapping['plugin_publication_date']]) ? $this->convertToTimestamp($row[$this->columnsMapping['plugin_publication_date']]) : null,
                    'plugin_modification_date' => ($this->columnsMapping['plugin_publication_date'] && $row[$this->columnsMapping['plugin_modification_date']]) ? $this->convertToTimestamp($row[$this->columnsMapping['plugin_modification_date']]) : null,
                    'created_by' => auth()->id(),
                ]);

                // Store vulnerability teams
                if (!empty($teamIds)) {
                    $allVulnerabilityTeams = Team::whereIn('id', $teamIds ?? [])->get();
                    $vulnerability->teams()->saveMany($allVulnerabilityTeams);
                }
                if (!empty($assets)) {
                    // Store vulnerability assets
                    $vulnerability->assets()->saveMany($assets);
                }
            }
        }
    }

    /**
     * Define validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        // Determine the column names or use defaults if not provided
        $plugin_name = !empty($this->columnsMapping['plugin_name']) ? $this->columnsMapping['plugin_name'] : '(plugin_name)';
        $ipAddress = !empty($this->columnsMapping['ip_address']) ? $this->columnsMapping['ip_address'] : '(ip_address)';
        $cve = !empty($this->columnsMapping['cve']) ? $this->columnsMapping['cve'] : '(cve)';
        $teams = !empty($this->columnsMapping['teams']) ? $this->columnsMapping['teams'] : '(teams)';
        $severity = !empty($this->columnsMapping['severity']) ? $this->columnsMapping['severity'] : '(severity)';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : '(description)';
        $solution = !empty($this->columnsMapping['solution']) ? $this->columnsMapping['solution'] : '(solution)';
        $pluginOutput = !empty($this->columnsMapping['plugin_output']) ? $this->columnsMapping['plugin_output'] : '(plugin_output)';
        $status = !empty($this->columnsMapping['status']) ? $this->columnsMapping['status'] : '(status)';
        $exploit = !empty($this->columnsMapping['exploit']) ? $this->columnsMapping['exploit'] : '(exploit)';

        return [
            $plugin_name => ['required', 'max:255'],
            $ipAddress => ['nullable', 'ip', 'max:15'],
            $cve  => ['nullable', 'max:255'],
            $teams => ['nullable', 'string'],
            $severity => ['required', 'in:Critical,High,Medium,Low,Informational,Info,info'],
            $description => ['nullable', 'string'],
            $solution => ['nullable', 'string'],
            $pluginOutput => ['nullable', 'string'],
            $status => ['nullable', 'in:Open,In Progress,Closed,Overdue'],
            $exploit => ['nullable', 'in:yes,No,yes,no'],
        ];
    }


    /**
     * Specify the batch size for importing.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 1000; // Adjust the batch size according to your needs
    }

    /**
     * Process 'teams' data as needed.
     *
     * @param  string  $teamsString
     * @return array
     */
    private function processTeams($teamsString)
    {
        // Split the comma-separated team names
        $teamNames = explode(',', $teamsString);
        // Initialize an array to store team IDs
        $teamIds = [];

        // Loop through each team name
        foreach ($teamNames as $teamName) {
            // Trim the team name to remove any leading or trailing whitespace
            $teamName = trim($teamName);

            // Attempt to find the team by name in the 'teams' table
            $team = Team::where('name', $teamName)->first();

            // If the team exists, add its ID to the array
            if ($team) {
                $teamIds[] = $team->id;
            }
        }

        return array_unique($teamIds);
    }

    /**
     * Process 'teams' data as needed.
     *
     * @param  string  $teamsString
     * @return array
     */
    // private function processAssets($assetssString)
    // {
    //     // Split the comma-separated asset names
    //     $assetsNames = explode(',', $assetssString);
    //     // Initialize an array to store asset IDs
    //     $assetIds = [];

    //     // Loop through each asset name
    //     foreach ($assetsNames as $assetName) {
    //         // Trim the asset name to remove any leading or trailing whitespace
    //         $assetName = trim($assetName);

    //         // Attempt to find the asset by name in the 'assets' table
    //         $asset = Asset::where('name', $assetName)->first();

    //         // If the asset exists, add its ID to the array
    //         if ($asset) {
    //             $assetIds[] = $asset->id;
    //         }
    //     }

    //     return array_unique($assetIds);
    // }

    private function handleSeverity($severity)
    {
        if ($severity == 'Info' || $severity == 'info') {
            $severity = 'Informational';
        }
        return ucwords($severity);
    }

    function convertToTimestamp($dateString)
    {
        // Parse the date string using Carbon
        $carbonDate = Carbon::parse($dateString);

        // Format the Carbon date as a timestamp
        $timestamp = $carbonDate->toDateTimeString(); // Outputs YYYY-MM-DD HH:MM:SS

        return $timestamp;
    }
}
