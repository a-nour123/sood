<?php

namespace App\Imports;

use App\Models\ControlControlObjective;
use App\Models\ControlObjective;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ControlObjectivesImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    public $columnsMapping;

    public function __construct($columnsMapping)
    {
        $this->columnsMapping = $columnsMapping;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $objectiveName = $row[$this->columnsMapping['name']] ?? null;
            
            if (!$objectiveName) {
                continue;
            }

            $existingObjective = ControlObjective::where('name', $objectiveName)->first();

            // Process framework IDs
            $frameworkIds = $this->getFrameworkIds($row);
            if (empty(array_filter($frameworkIds))) {
                continue;
            }

            // Process control IDs with proper validation
            $controlIds = $this->getValidControlIds($row, $frameworkIds);
            if ($controlIds->isEmpty()) {
                continue;
            }

            // Get descriptions
            $description = $this->getDescriptions($row);

            if ($existingObjective) {
                $this->updateExistingObjective($existingObjective, $frameworkIds, $controlIds, $description);
            } else {
                $this->createNewObjective($objectiveName, $frameworkIds, $controlIds, $description);
            }
        }
    }

    /**
     * Extract and validate framework IDs from the row
     */
    private function getFrameworkIds($row): array
    {
        $frameworkField = $row[$this->columnsMapping['framework_id']] ?? null;
        if (!$frameworkField) {
            return [];
        }

        $frameworkNames = collect(explode(',', $frameworkField))
            ->map(fn($name) => trim(str_replace(' ', '', $name)))
            ->filter()
            ->unique();

        $frameworkIds = [];
        foreach ($frameworkNames as $frameworkName) {
            $framework = Framework::whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $frameworkName . '%'])
                ->first();
            
            if ($framework) {
                $frameworkIds[$frameworkName] = $framework->id;
            }
        }

        return $frameworkIds;
    }

    /**
     * Extract and validate control IDs that exist in framework_controls table
     */
    private function getValidControlIds($row, array $frameworkIds): Collection
    {
        $controlField = $row[$this->columnsMapping['control_id']] ?? null;
        if (!$controlField) {
            return collect();
        }

        $controlIdentifiers = collect(explode(',', $controlField))
            ->map(fn($control) => trim(str_replace(' ', '', $control)))
            ->filter()
            ->unique();

        $validControlIds = collect();

        foreach ($controlIdentifiers as $controlIdentifier) {
            // First, check if the control exists in framework_controls
            $control = FrameworkControl::whereRaw("REPLACE(short_name, ' ', '') LIKE ?", ['%' . $controlIdentifier . '%'])
                ->first();

            if (!$control) {
                continue; // Skip if control doesn't exist
            }

            // Then verify it's mapped to at least one of the provided frameworks
            $isMappedToFramework = FrameworkControlMapping::where('framework_control_id', $control->id)
                ->whereIn('framework_id', array_filter($frameworkIds))
                ->exists();

            if ($isMappedToFramework) {
                $validControlIds->push($control->id);
            }
        }

        return $validControlIds->unique();
    }

    /**
     * Extract descriptions from the row
     */
    private function getDescriptions($row): array
    {
        $desEn = '';
        $desAr = '';

        foreach ($row as $key => $val) {
            if (stripos($key, 'description_en') !== false) {
                $desEn = $val;
            }
            if (stripos($key, 'description_ar') !== false) {
                $desAr = $val;
            }
        }

        return ['en' => $desEn, 'ar' => $desAr];
    }

    /**
     * Update existing objective
     */
    private function updateExistingObjective($existingObjective, $frameworkIds, $controlIds, $description): void
    {
        $newFrameworkIds = collect(array_filter(explode(',', $existingObjective->framework_id)))
            ->merge(array_values($frameworkIds))
            ->unique()
            ->implode(',');

        $newControlIds = collect(array_filter(explode(',', $existingObjective->control_id)))
            ->merge($controlIds)
            ->unique();

        $existingObjective->update([
            'framework_id' => $newFrameworkIds,
            'control_id' => $newControlIds->implode(','),
            'description' => $description,
        ]);

        // Only create relationships for valid control IDs
        foreach ($controlIds as $controlId) {
            ControlControlObjective::updateOrCreate(
                [
                    'control_id' => (int) $controlId,
                    'objective_id' => $existingObjective->id,
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(), // Only set on create
                ]
            );
        }
    }

    /**
     * Create new objective
     */
    private function createNewObjective($objectiveName, $frameworkIds, $controlIds, $description): void
    {
        $newObjective = ControlObjective::create([
            'name' => $objectiveName,
            'description' => $description,
            'framework_id' => implode(',', array_filter(array_values($frameworkIds))),
            'control_id' => $controlIds->implode(','),
            'created_at' => now(),
        ]);

        // Only create relationships for valid control IDs
        foreach ($controlIds as $controlId) {
            ControlControlObjective::create([
                'control_id' => (int) $controlId,
                'objective_id' => $newObjective->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function rules(): array
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        $descriptionEn = !empty($this->columnsMapping['description_en']) ? $this->columnsMapping['description_en'] : '(description_en)';
        $descriptionAr = !empty($this->columnsMapping['description_ar']) ? $this->columnsMapping['description_ar'] : '(description_ar)';
        $framework_id = !empty($this->columnsMapping['framework_id']) ? $this->columnsMapping['framework_id'] : '(framework_id)';
        $control_id = !empty($this->columnsMapping['control_id']) ? $this->columnsMapping['control_id'] : '(control_id)';

        return [
            $name => ['required', 'max:255'],
            $descriptionEn => ['nullable'],
            $descriptionAr => ['nullable'],
            $framework_id => ['required', 'max:500'],
            $control_id => ['required', 'max:500'],
        ];
    }
}