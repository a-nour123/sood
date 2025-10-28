<?php

namespace App\Imports;

use App\Models\Family;
use App\Models\Framework;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FrameworksImport implements
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


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $departmentName = $row[$this->columnsMapping['name']] ?? null;
    
            // Retrieve or create the framework
            $framework = Framework::firstOrCreate([
                'name' => $departmentName,
            ], [
                'description' => $row[$this->columnsMapping['description']] ?? null,
                'icon' => 'fa-ban',
            ]);
    
            // Extract data from the row and perform necessary transformations
            $domainsString = $row[$this->columnsMapping['domain']] ?? null;
            $domainIds = $this->processFamilies($domainsString, null);
    
            $subDomainsString = $row[$this->columnsMapping['sub_domain']] ?? null;
            $subDomainIds = $this->processFamilies($subDomainsString, $domainIds);
    
            // Insert into framework_families table for domains
            foreach ($domainIds as $domainId) {
                DB::table('framework_families')->updateOrInsert(
                    ['framework_id' => $framework->id, 'family_id' => $domainId],
                    ['parent_family_id' => null] // Domains have no parent_family_id
                );
            }
    
            // Insert into framework_families table for sub-domains
            foreach ($subDomainIds as $subDomainId) {
                $parentDomainId = Family::where('id', $subDomainId)->pluck('parent_id')->first();
                if (in_array($parentDomainId, $domainIds)) {
                    DB::table('framework_families')->updateOrInsert(
                        ['framework_id' => $framework->id, 'family_id' => $subDomainId],
                        ['parent_family_id' => $parentDomainId]
                    );
                }
            }
        }
    }




    public function rules(): array /* WithValidation */
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : '(description)';
        $domain = !empty($this->columnsMapping['domain']) ? $this->columnsMapping['domain'] : '(domain)';
        $subDomain = !empty($this->columnsMapping['sub_domain']) ? $this->columnsMapping['sub_domain'] : '(sub_domain)';
        return [
            $name => ['required', 'max:100', 'unique:departments,name'],
            $description => ['required', 'string'],
            $domain => ['required', 'string'],
            $subDomain => ['required', 'string'],

        ];
    }

    private function processFamilies($familiesString, $parentDomainIds)
    {
        $familiesNames = explode(',', $familiesString);
        $familyIds = [];

        // Ensure $parentDomainIds is a single value or use the first item if it's an array
        $parentDomainId = is_array($parentDomainIds) ? ($parentDomainIds[0] ?? null) : $parentDomainIds;

        // Retrieve the current highest order value from the families table
        $lastOrder = Family::max('order') ?? 0; // Default to 0 if no orders exist

        foreach ($familiesNames as $familyName) {
            $familyName = trim($familyName);

            // Check if the family exists, if not create it
            $family = Family::firstOrCreate(
                ['name' => $familyName],
                ['parent_id' => $parentDomainId, 'order' => ++$lastOrder] // Increment order value
            );

            $familyIds[] = $family->id;
        }

        return array_unique($familyIds);
    }
}
