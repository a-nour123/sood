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

class ClosedVulnerabilitiesImport implements
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
            $PluginId = $row[$this->columnsMapping['plugin_id']] ?? null;
            $port = $row[$this->columnsMapping['port']] ?? null;
            $vulnerabilityIp = $row[$this->columnsMapping['ip_address']] ?? null;
            $vulnerabilityFirstDiscoveredTime = ($this->columnsMapping['first_discovered'] && $row[$this->columnsMapping['first_discovered']]) ? $this->convertToTimestamp($row[$this->columnsMapping['first_discovered']]) : null;
            $existingVulnerability = Vulnerability::where('plugin_id', $PluginId)
                ->where('port', $port)
                ->where('ip_address', $vulnerabilityIp)
                ->where('first_discovered', $vulnerabilityFirstDiscoveredTime)
                ->first();
            // Check if a vulnerability with the same name already exists
            if ($existingVulnerability) {
                //update vulnerability status
                $existingVulnerability->update([
                    'status' => 'Closed'
                ]);
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
        $ipAddress = !empty($this->columnsMapping['ip_address']) ? $this->columnsMapping['ip_address'] : '(ip_address)';
        $pluginId = !empty($this->columnsMapping['plugin_id']) ? $this->columnsMapping['plugin_id'] : '(plugin_id)';
        $port = !empty($this->columnsMapping['port']) ? $this->columnsMapping['port'] : '(port)';
        $firstDiscovered = !empty($this->columnsMapping['first_discovered']) ? $this->columnsMapping['first_discovered'] : '(first_discovered)';

        return [
            $pluginId => ['required', 'max:255'],
            $ipAddress => ['required', 'ip', 'max:15'],
            $port => ['required'],
            $firstDiscovered => ['required',],

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
