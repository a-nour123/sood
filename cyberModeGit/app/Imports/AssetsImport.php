<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetEnvironmentCategory;
use App\Models\AssetValueLevel;
use App\Models\Location;
use App\Models\OperatingSystem;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetsImport implements
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
            // Extract data from the row and perform necessary transformations
            $teamsString = $row[$this->columnsMapping['teams']] ?? null;
            $teamIds = $this->processTeams($teamsString);

            $startDate = $row[$this->columnsMapping['start_date']] ?? null;
            $formattedStartDate = $startDate ? $this->convertExcelDateToStandard($startDate) : null;
            $userManager = $row[$this->columnsMapping['asset_owner']] ?? null;

            // Find the asset owner or set to null if not found
            $assetOwner = null;
            if ($userManager) {
                $assetOwner = User::where('username',  $userManager)->pluck('id')->first();
            }

            $expirationDate = $row[$this->columnsMapping['expiration_date']] ?? null;
            $formattedExpirationDate = $expirationDate ? $this->convertExcelDateToStandard($expirationDate) : null;

            $valueName = $row[$this->columnsMapping['asset_value']] ?? null;
            $assetValueId = isset($valueName) && !empty($valueName)
                ? AssetValueLevel::firstOrCreate(['name' => $valueName])->id
                : null;


            $locationName = $row[$this->columnsMapping['location']] ?? null;
            $locationId = isset($locationName) && !empty($locationName)
                ? Location::firstOrCreate(['name' => $locationName])->id
                : null;
            $categoryName = $row[$this->columnsMapping['asset_category']] ?? null;

            $assetCategoryId = isset($categoryName) && !empty($categoryName)
                ? AssetCategory::firstOrCreate(
                    ['name' => $categoryName]  // Fixed: Proper array syntax
                )->id
                : null;
            $environmentCategoryName = $row[$this->columnsMapping['asset_environment_category']] ?? null;
            $assetEnvironmentCategoryId = isset($environmentCategoryName) && !empty($environmentCategoryName)
                ? AssetEnvironmentCategory::firstOrCreate(
                    ['name' => $environmentCategoryName]
                )->id
                : null;

            $osName = $row[$this->columnsMapping['os']] ?? null;

            $osId = isset($osName) && !empty($osName)
                ? OperatingSystem::firstOrCreate(['name' => $osName])->id
                : null;

            if (
                isset($this->columnsMapping['verified']) &&
                isset($row[$this->columnsMapping['verified']])
            ) {
                $verified = (strtolower($row[$this->columnsMapping['verified']]) === 'verified') ? 1 : 0;
            } else {
                $verified = 1
                ; // Default value when column doesn't exist
            }
            $physicalVirtual = null; // Default value

            // Check if the mapping exists and the column exists in the row
            if (
                !empty($this->columnsMapping['physical_virtual_type']) &&
                isset($row[$this->columnsMapping['physical_virtual_type']])
            ) {

                $typeValue = strtolower(trim($row[$this->columnsMapping['physical_virtual_type']]));

                if ($typeValue === 'physical') {
                    $physicalVirtual = 1;
                } elseif ($typeValue === 'virtual') {
                    $physicalVirtual = 0;
                }
                // else remains null
            }

            $assetName = $row[$this->columnsMapping['name']] ?? $row[$this->columnsMapping['ip']] ?? null;

            $existingAsset = Asset::where('name', $assetName)->first();



            // Check if an asset with the same name already exists
            if (!$existingAsset) {
                // Create a new Asset record in the database
                Asset::create([
                    'name' => $row[$this->columnsMapping['name']] ?? $row[$this->columnsMapping['ip']] ?? null,
                    'ip' => $row[$this->columnsMapping['ip']] ?? null,
                    'asset_value_id' => 1,
                    'verified' => $verified ?? 1,
                    'created' => date('Y-m-d'),
                    'details' => $row[$this->columnsMapping['details']] ?? null,
                    'start_date' => $formattedStartDate,
                    'expiration_date' => $formattedExpirationDate,
                    'teams' => implode(',', $teamIds) ?? null,
                    'url'  => $row[$this->columnsMapping['url']] ?? null,
                    'os_version'  => $row[$this->columnsMapping['os_version']] ?? null,
                    'physical_virtual_type'  => $physicalVirtual ?? null,
                    'asset_owner'  => $assetOwner ?? null,
                    // 'owner_email'  => $row[$this->columnsMapping['owner_email']] ?? null,
                    // 'owner_manager_email'  => $row[$this->columnsMapping['owner_manager_email']] ?? null,
                    'project_vlan'  => $row[$this->columnsMapping['project_vlan']] ?? null,
                    'vlan'  => $row[$this->columnsMapping['vlan']] ?? null,
                    'vendor_name'  => $row[$this->columnsMapping['vendor_name']] ?? null,
                    'model'  => $row[$this->columnsMapping['model']] ?? null,
                    'firmware'  => $row[$this->columnsMapping['firmware']] ?? null,
                    'city'  => $row[$this->columnsMapping['city']] ?? null,
                    'rack_location'  => $row[$this->columnsMapping['rack_location']] ?? null,
                    'mac_address'  => $row[$this->columnsMapping['mac_address']] ?? null,
                    'subnet_mask'  => $row[$this->columnsMapping['subnet_mask']] ?? null,
                    'asset_value_level_id'  => $assetValueId ?? null,
                    'location_id'  => $locationId ?? null,
                    'asset_category_id'  => $assetCategoryId ?? null,
                    'asset_environment_category_id'  => $assetEnvironmentCategoryId ?? null,
                    'os'  => $osId ?? null,
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
        // $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        // $verified = !empty($this->columnsMapping['verified']) ? $this->columnsMapping['verified'] : '(verified)';
        $assetOwner = empty($this->columnsMapping['asset_owner']) ? $this->columnsMapping['asset_owner'] : '';

        // Define validation rules for each column
        return [
            $this->columnsMapping['ip'] => ['required', 'ip', 'max:15'],
            // $name => ['required', 'max:200'],
            // $verified => ['required', 'in:verified,not verified,Verified,Not verified,Not Verified'],
            $this->columnsMapping['asset_value'] => ['nullable'],
            $this->columnsMapping['location'] => ['nullable', 'exists:locations,name'],
            $this->columnsMapping['asset_category'] => ['nullable'],
            $this->columnsMapping['asset_environment_category'] => ['nullable'],
            $this->columnsMapping['os'] => ['nullable', 'exists:operating_systems,name'],
            $this->columnsMapping['details'] => ['nullable', 'string', 'max:4000000000'],
            $this->columnsMapping['start_date'] => ['nullable'],
            $this->columnsMapping['expiration_date'] => ['nullable'],
            $this->columnsMapping['physical_virtual_type'] => ['nullable', 'in:physical,virtual,Physical,Virtual'],
            $this->columnsMapping['asset_owner'] => ['nullable'],
            $assetOwner => ['nullable'], // Ensure asset owner is nullable

            // $this->columnsMapping['owner_email'] => ['nullable', 'email'],
            // $this->columnsMapping['owner_manager_email'] => ['nullable', 'email'],
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
     * Convert Excel date to standard date format.
     *
     * @param  mixed  $excelDate
     * @return string|null
     */
    private function convertExcelDateToStandard($excelDate)
    {
        // If already a string and valid date, just return the formatted version
        if (!is_numeric($excelDate)) {
            $timestamp = strtotime($excelDate);
            return $timestamp ? date('Y-m-d', $timestamp) : null;
        }

        // Handle Excel serial number format
        $excelBaseDate = strtotime('1900-01-01');
        return date('Y-m-d', $excelBaseDate + ((int)$excelDate - 1) * 86400);
    }
}
