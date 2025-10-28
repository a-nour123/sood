<?php

namespace App\Imports;

use App\Models\ControlClass;
use App\Models\ControlMaturity;
use App\Models\ControlPhase;
use App\Models\ControlPriority;
use App\Models\ControlType;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlTest;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FrameworkControlsImport implements
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
            $frameworkName = $row[$this->columnsMapping['framework']] ?? null;
            $frameworkId = Framework::where('name', $frameworkName)->pluck('id')->first();

            $parentName = $row[$this->columnsMapping['parent_id']] ?? null;
            $parent = FrameworkControl::where('short_name', $parentName)->first();

            if ($parent) {
                $parentId = $parent->id;
                $familyId = $parent->family;
            } else {
                $parentId = null;
                $familyName = $row[$this->columnsMapping['sub_domain']] ?? null;
                $familyId = Family::where('name', $familyName)->pluck('id')->first();
            }

            $priorityName = $row[$this->columnsMapping['control_priority']] ?? null;
            $controlPriorityId = ControlPriority::where('name', $priorityName)->pluck('id')->first();

            $phaseName = $row[$this->columnsMapping['control_phase']] ?? null;
            $controlPhaseId = ControlPhase::where('name', $phaseName)->pluck('id')->first();

            $className = $row[$this->columnsMapping['control_class']] ?? null;
            $controlClassId = ControlClass::where('name', $className)->pluck('id')->first();

            $typeName = $row[$this->columnsMapping['control_type']] ?? null;
            $controlTypeId = ControlType::where('name', $typeName)->pluck('id')->first();

            $maturityName = $row[$this->columnsMapping['control_maturity']] ?? null;
            $controlMaturityId = ControlMaturity::where('name', $maturityName)->pluck('id')->first();

            $desiredMaturityName = $row[$this->columnsMapping['control_desired_maturity']] ?? null;
            $controlDesiredMaturityId = ControlMaturity::where('name', $desiredMaturityName)->pluck('id')->first();

            $ownerName = $row[$this->columnsMapping['owner']] ?? null;
            $ownerId = User::where('name', $ownerName)->pluck('id')->first();

            // Check if a department with the same name already exists
            if ($familyId) {
                // Prepare the data for FrameworkControl
                $frameworkControlData = [
                    'short_name' => $row[$this->columnsMapping['name']] ?? null,
                    'long_name' => $row[$this->columnsMapping['name']] ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'control_number' => $row[$this->columnsMapping['control_number']] ?? null,
                    'supplemental_guidance' => $row[$this->columnsMapping['supplemental_guidance']] ?? null,
                    'mitigation_percent' => $row[$this->columnsMapping['mitigation_percent']] ?? null,
                    'parent_id'  => $parentId ?? null,
                    'family'  => $familyId ?? null,
                    'control_priority'  => $controlPriorityId ?? null,
                    'control_phase'  => $controlPhaseId ?? null,
                    'control_class'  => $controlClassId ?? null,
                    'control_type'  => $controlTypeId ?? null,
                    'control_maturity'  => $controlMaturityId ?? null,
                    'desired_maturity'  => $controlDesiredMaturityId ?? null,
                    'control_owner' => $ownerId ?? auth()->id(),
                ];

                // Check if FrameworkControl already exists based on short_name and control_number
                $existingFrameworkControl = FrameworkControl::where('short_name', $frameworkControlData['short_name'])
                    ->orWhere('control_number', $frameworkControlData['control_number'])
                    ->first();

                if ($existingFrameworkControl) {
                    // Update existing FrameworkControl
                    $existingFrameworkControl->update($frameworkControlData);
                    $frameworkControl = $existingFrameworkControl;
                } else {
                    // Create new FrameworkControl
                    $frameworkControl = FrameworkControl::create($frameworkControlData);
                }

                $testerName = $row[$this->columnsMapping['tester']] ?? null;
                $testerId = User::where('name', $testerName)->pluck('id')->first();

                // Prepare the data for FrameworkControlTest
                $frameworkControlTestData = [
                    'tester' => $testerId ?? null,
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'test_steps' => $row[$this->columnsMapping['test_steps']] ?? null,
                    'approximate_time' => $row[$this->columnsMapping['approximate_time']] ?? null,
                    'framework_control_id' => $frameworkControl->id,
                    'expected_results' => $row[$this->columnsMapping['expected_results']] ?? null,
                    'test_frequency' => $row[$this->columnsMapping['test_frequency']] ?? 0,
                ];

                // Check if FrameworkControlTest already exists
                $existingFrameworkControlTest = FrameworkControlTest::where('framework_control_id', $frameworkControl->id)
                    ->where('name', $frameworkControlTestData['name'])
                    ->first();

                if ($existingFrameworkControlTest) {
                    // Update existing FrameworkControlTest
                    $existingFrameworkControlTest->update($frameworkControlTestData);
                } else {
                    // Create new FrameworkControlTest
                    FrameworkControlTest::create($frameworkControlTestData);
                }

                // Handle framework relationship (many-to-many)
                if ($frameworkId && !$frameworkControl->Frameworks()->where('framework_id', $frameworkId)->exists()) {
                    $frameworkControl->Frameworks()->attach($frameworkId);
                }
            }
        }
    }

    public function rules(): array
    {
        // Define the rules array
        $rules = [];
        // Ensure 'name' is required, not empty, and has a maximum length of 1000 characters
        // if (!empty($this->columnsMapping['name'])) {
        //     $rules[$this->columnsMapping['name']] = ['required', 'max:1000'];
        // }
        // Ensure 'description' is required, not empty, and has a maximum length (assuming max length is 1000)
        if (array_key_exists('name', $this->columnsMapping) && !empty($this->columnsMapping['name'])) {
            $rules[$this->columnsMapping['name']] = ['required', 'max:1000'];
        } else {
            // If description is required but is not provided, set a rule with a placeholder key
            $rules['name_placeholder'] = ['required'];
        }
        // Ensure 'description' is required, not empty, and has a maximum length (assuming max length is 1000)
        if (array_key_exists('description', $this->columnsMapping) && !empty($this->columnsMapping['description'])) {
            $rules[$this->columnsMapping['description']] = ['required', 'max:1000'];
        } else {
            // If description is required but is not provided, set a rule with a placeholder key
            $rules['description_placeholder'] = ['required'];
        }

        // Ensure 'framework' is required, not empty, and exists in the frameworks table
        if (array_key_exists('framework', $this->columnsMapping) && !empty($this->columnsMapping['framework'])) {
            $rules[$this->columnsMapping['framework']] = ['required', 'exists:frameworks,name'];
        } else {
            // If framework is required but is not provided, set a rule with a placeholder key
            $rules['framework_placeholder'] = ['required'];
        }

        // Ensure 'sub_domain' is required, not empty, and exists in the families table
        if (array_key_exists('sub_domain', $this->columnsMapping) && !empty($this->columnsMapping['sub_domain'])) {
            $rules[$this->columnsMapping['sub_domain']] = ['required', 'exists:families,name'];
        } else {
            // If tester is required but is not provided, set a rule with a placeholder key
            $rules['sub_domain_placeholder'] = ['required'];
        }
        if (array_key_exists('tester', $this->columnsMapping) && !empty($this->columnsMapping['sub_domain'])) {
            $rules[$this->columnsMapping['tester']] = ['required', 'exists:users,name'];
        } else {
            // If tester is required but is not provided, set a rule with a placeholder key
            $rules['tester_placeholder'] = ['required'];
        }

        // 'control' validation, assuming control is mapped to 'parent_id' and is required
        if (!empty($this->columnsMapping['parent_id'])) {
            $rules[$this->columnsMapping['parent_id']] = ['required', 'exists:framework_controls,short_name'];
        }

        // Optional fields that might not always be required
        if (!empty($this->columnsMapping['test_frequency'])) {
            $rules[$this->columnsMapping['test_frequency']] = ['nullable', 'integer'];
        }

        if (!empty($this->columnsMapping['tester'])) {
            $rules[$this->columnsMapping['tester']] = ['nullable', 'exists:users,name'];
        }

        if (!empty($this->columnsMapping['owner'])) {
            $rules[$this->columnsMapping['owner']] = ['nullable', 'exists:users,name'];
        }

        if (!empty($this->columnsMapping['mitigation_percent'])) {
            $rules[$this->columnsMapping['mitigation_percent']] = ['nullable', 'integer'];
        }

        if (!empty($this->columnsMapping['approximate_time'])) {
            $rules[$this->columnsMapping['approximate_time']] = ['nullable', 'integer'];
        }

        if (!empty($this->columnsMapping['control_priority'])) {
            $rules[$this->columnsMapping['control_priority']] = ['nullable', 'exists:control_priorities,name'];
        }

        if (!empty($this->columnsMapping['control_phase'])) {
            $rules[$this->columnsMapping['control_phase']] = ['nullable', 'exists:control_phases,name'];
        }

        if (!empty($this->columnsMapping['control_class'])) {
            $rules[$this->columnsMapping['control_class']] = ['nullable', 'exists:control_classes,name'];
        }

        if (!empty($this->columnsMapping['control_type'])) {
            $rules[$this->columnsMapping['control_type']] = ['nullable', 'exists:control_types,name'];
        }

        if (!empty($this->columnsMapping['control_maturity'])) {
            $rules[$this->columnsMapping['control_maturity']] = ['nullable', 'exists:control_maturities,name'];
        }

        if (!empty($this->columnsMapping['control_desired_maturity'])) {
            $rules[$this->columnsMapping['control_desired_maturity']] = ['nullable', 'exists:control_desired_maturities,name'];
        }

        return $rules;
    }






    private function processFamilies($familiesString)
    {
        // Split the comma-separated team names
        $familiesNames = explode(',', $familiesString);
        // Initialize an array to store team IDs
        $familieIds = [];

        // Loop through each team name
        foreach ($familiesNames as $familyName) {
            // Trim the team name to remove any leading or trailing whitespace
            $familyName = trim($familyName);

            // Attempt to find the team by name in the 'teams' table
            $team = Family::where('name', $familyName)->first();

            // If the team exists, add its ID to the array
            if ($team) {
                $familieIds[] = $team->id;
            }
        }

        return array_unique($familieIds);
    }
}
