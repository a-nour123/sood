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
use Illuminate\Support\Facades\Log;

class FrameworkControlsImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation
{
    use Importable;

    public $columnsMapping;
    public $failedRows = [];

    public function __construct($columnsMapping)
    {
        $this->columnsMapping = $columnsMapping;
    }

    public function collection(Collection $rows)
    {
        $this->failedRows = [];

        foreach ($rows as $index => $row) {
            try {
                $rowNumber = $index + 2;
                $controlName = $row[$this->columnsMapping['name']] ?? 'Unknown';
                
                $frameworkName = $row[$this->columnsMapping['framework']] ?? null;
                $frameworkId = Framework::where('name', $frameworkName)->pluck('id')->first();

                if (!$frameworkId) {
                    $this->failedRows[] = [
                        'row' => $rowNumber,
                        'control' => $controlName,
                        'reason' => "Framework '$frameworkName' not found"
                    ];
                    Log::warning("Framework not found", ['framework' => $frameworkName, 'row' => $rowNumber]);
                    continue;
                }

                $parentName = $row[$this->columnsMapping['parent_id']] ?? null;
                $parent = FrameworkControl::where('short_name', $parentName)->first();

                if ($parent) {
                    $parentId = $parent->id;
                    $familyId = $parent->family;
                } else {
                    $parentId = null;
                    // Get both English and Arabic sub-domain names
                    $familyNameEn = $row[$this->columnsMapping['sub_domain_en']] ?? null;
                    $familyNameAr = $row[$this->columnsMapping['sub_domain_ar']] ?? null;
                    
                    $familyId = $this->getFamilyIdByName($familyNameEn, $familyNameAr);
                }

                if (!$familyId) {
                    $this->failedRows[] = [
                        'row' => $rowNumber,
                        'control' => $controlName,
                        'reason' => "Sub-domain not found. English: '$familyNameEn', Arabic: '$familyNameAr'"
                    ];
                    Log::warning("Family not found", [
                        'family_en' => $familyNameEn, 
                        'family_ar' => $familyNameAr, 
                        'row' => $rowNumber
                    ]);
                    continue;
                }

                // Process other fields...
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

                $desAr = $row[$this->columnsMapping['description_ar']] ?? '';
                $desEn = $row[$this->columnsMapping['description_en']] ?? '';
                $description = ['en' => $desEn, 'ar' => $desAr];

                // Prepare FrameworkControl data
                $frameworkControlData = [
                    'short_name' => $row[$this->columnsMapping['name']] ?? null,
                    'long_name' => $row[$this->columnsMapping['name']] ?? null,
                    'description' => $description,
                    'control_number' => $row[$this->columnsMapping['control_number']] ?? null,
                    'supplemental_guidance' => $row[$this->columnsMapping['supplemental_guidance']] ?? null,
                    'mitigation_percent' => $row[$this->columnsMapping['mitigation_percent']] ?? null,
                    'parent_id'  => $parentId,
                    'family'  => $familyId,
                    'control_priority'  => $controlPriorityId,
                    'control_phase'  => $controlPhaseId,
                    'control_class'  => $controlClassId,
                    'control_type'  => $controlTypeId,
                    'control_maturity'  => $controlMaturityId,
                    'desired_maturity'  => $controlDesiredMaturityId,
                    'control_owner' => $ownerId ?? auth()->id(),
                ];

                // Find or create FrameworkControl
                $existingFrameworkControl = FrameworkControl::where('short_name', $frameworkControlData['short_name'])
                    ->orWhere('control_number', $frameworkControlData['control_number'])
                    ->first();

                if ($existingFrameworkControl) {
                    $existingFrameworkControl->update($frameworkControlData);
                    $frameworkControl = $existingFrameworkControl;
                } else {
                    $frameworkControl = FrameworkControl::create($frameworkControlData);
                }

                // Handle FrameworkControlTest with proper tester validation
                $this->handleFrameworkControlTest($row, $frameworkControl, $rowNumber, $controlName);

                // Handle framework relationship
                if ($frameworkId && !$frameworkControl->Frameworks()->where('framework_id', $frameworkId)->exists()) {
                    $frameworkControl->Frameworks()->attach($frameworkId);
                }

                Log::info("Successfully imported control", [
                    'row' => $rowNumber,
                    'control' => $controlName,
                    'control_id' => $frameworkControl->id,
                    'family_id' => $familyId
                ]);

            } catch (\Exception $e) {
                $this->failedRows[] = [
                    'row' => $rowNumber,
                    'control' => $controlName,
                    'reason' => "System error: " . $e->getMessage()
                ];
                Log::error("Error importing framework control row", [
                    'row' => $rowNumber,
                    'control' => $controlName,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                continue;
            }
        }
    }

    /**
     * Get family ID by searching in both English and Arabic names
     */
    private function getFamilyIdByName($familyNameEn, $familyNameAr)
    {
        // Try English name first
        if ($familyNameEn) {
            $family = Family::whereRaw('JSON_EXTRACT(name, "$.en") = ?', [$familyNameEn])
                ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.en"))) = LOWER(?)', [$familyNameEn])
                ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(name, "$.en")) LIKE ?', ["%{$familyNameEn}%"])
                ->first();
            
            if ($family) {
                return $family->id;
            }
        }

        // Try Arabic name if English not found
        if ($familyNameAr) {
            $family = Family::whereRaw('JSON_EXTRACT(name, "$.ar") = ?', [$familyNameAr])
                ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.ar"))) = LOWER(?)', [$familyNameAr])
                ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(name, "$.ar")) LIKE ?', ["%{$familyNameAr}%"])
                ->first();
            
            if ($family) {
                return $family->id;
            }
        }

        return null;
    }

    /**
     * Handle FrameworkControlTest creation with proper tester validation
     */
    private function handleFrameworkControlTest($row, $frameworkControl, $rowNumber, $controlName)
    {
        $testerName = $row[$this->columnsMapping['tester']] ?? null;
        $testerId = null;

        if ($testerName) {
            $testerId = User::where('name', $testerName)->pluck('id')->first();
            if (!$testerId) {
                $this->failedRows[] = [
                    'row' => $rowNumber,
                    'control' => $controlName,
                    'reason' => "Tester '$testerName' not found in users table"
                ];
                Log::warning("Tester not found", [
                    'tester' => $testerName,
                    'row' => $rowNumber,
                    'control' => $controlName
                ]);
                return;
            }
        } else {
            $testerId = auth()->id();
        }

        $frameworkControlTestData = [
            'name' => $row[$this->columnsMapping['name']] ?? null,
            'test_steps' => $row[$this->columnsMapping['test_steps']] ?? null,
            'approximate_time' => $row[$this->columnsMapping['approximate_time']] ?? null,
            'framework_control_id' => $frameworkControl->id,
            'expected_results' => $row[$this->columnsMapping['expected_results']] ?? null,
            'test_frequency' => $row[$this->columnsMapping['test_frequency']] ?? 0,
            'tester' => $testerId,
        ];

        $existingFrameworkControlTest = FrameworkControlTest::where('framework_control_id', $frameworkControl->id)
            ->where('name', $frameworkControlTestData['name'])
            ->first();

        if ($existingFrameworkControlTest) {
            $existingFrameworkControlTest->update($frameworkControlTestData);
        } else {
            FrameworkControlTest::create($frameworkControlTestData);
        }
    }

    public function getFailedRows()
    {
        return $this->failedRows;
    }

    public function getImportSummary()
    {
        return [
            'total_rows' => count($this->failedRows),
            'successful' => count($this->failedRows) - count($this->failedRows),
            'failed' => count($this->failedRows),
            'failed_rows' => $this->failedRows
        ];
    }

    public function rules(): array
    {
        $rules = [];

        // Required fields
        if (array_key_exists('name', $this->columnsMapping) && !empty($this->columnsMapping['name'])) {
            $rules[$this->columnsMapping['name']] = ['required', 'max:1000'];
        } else {
            $rules['name_placeholder'] = ['required'];
        }

        if (array_key_exists('framework', $this->columnsMapping) && !empty($this->columnsMapping['framework'])) {
            $rules[$this->columnsMapping['framework']] = ['required', 'exists:frameworks,name'];
        } else {
            $rules['framework_placeholder'] = ['required'];
        }

        // Sub-domain validation - at least one of them should be provided
        if (array_key_exists('sub_domain_en', $this->columnsMapping) && !empty($this->columnsMapping['sub_domain_en'])) {
            $rules[$this->columnsMapping['sub_domain_en']] = ['required'];
        } else {
            $rules['sub_domain_en_placeholder'] = ['required'];
        }

        if (array_key_exists('sub_domain_ar', $this->columnsMapping) && !empty($this->columnsMapping['sub_domain_ar'])) {
            $rules[$this->columnsMapping['sub_domain_ar']] = ['required'];
        } else {
            $rules['sub_domain_ar_placeholder'] = ['required'];
        }

        // Tester validation
        if (array_key_exists('tester', $this->columnsMapping) && !empty($this->columnsMapping['tester'])) {
            $rules[$this->columnsMapping['tester']] = ['required', 'exists:users,name'];
        } else {
            $rules['tester_placeholder'] = ['required'];
        }

        // Optional fields
        $optionalFields = [
            'owner' => 'exists:users,name',
            'test_frequency' => 'integer',
            'mitigation_percent' => 'integer',
            'approximate_time' => 'integer',
            'control_priority' => 'exists:control_priorities,name',
            'control_phase' => 'exists:control_phases,name',
            'control_class' => 'exists:control_classes,name',
            'control_type' => 'exists:control_types,name',
            'control_maturity' => 'exists:control_maturities,name',
            'control_desired_maturity' => 'exists:control_maturities,name',
            'parent_id' => 'exists:framework_controls,short_name'
        ];

        foreach ($optionalFields as $field => $rule) {
            if (array_key_exists($field, $this->columnsMapping) && !empty($this->columnsMapping[$field])) {
                $rules[$this->columnsMapping[$field]] = ['nullable', $rule];
            }
        }

        return $rules;
    }

    public function customValidationMessages()
    {
        return [
            'tester.exists' => 'The selected tester does not exist in the users table.',
            'framework.exists' => 'The selected framework does not exist.',
            'sub_domain_en.required' => 'The English sub-domain field is required.',
            'sub_domain_ar.required' => 'The Arabic sub-domain field is required.',
            'tester.required' => 'The tester field is required.',
        ];
    }
}