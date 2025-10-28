<?php

namespace App\Exports;

use App\Models\FrameworkControl;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use App\Traits\LaravelExportPropertiesTrait;

class FrameworkControlsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait;
    
    private $counter = 1;

    public function collection()
    {
        return FrameworkControl::withCount('frameworkControls')
            ->with([
                'family_with_parent:id,name,parent_id',
                'parentFrameworkControl:id,short_name',
                'phase',
                'priority',
                'maturity',
                'type',
                'class',
                'ControlDesiredMaturity:id,name',
                'custom_test:framework_control_id,name,test_frequency,last_date,tester',
                'Frameworks:id,name'
            ])
            ->get()
            ->map(function ($control) {
                // Get raw description without triggering the accessor
                $rawDescription = $control->getRawOriginal('description');
                
                // Handle both JSON and plain string cases
                if (is_string($rawDescription)) {
                    $description = json_decode($rawDescription, true) ?? [];
                } else {
                    $description = $rawDescription;
                }
                
                $description_en = $description['en'] ?? '';
                $description_ar = $description['ar'] ?? '';

                $controlFrameworksNames = $control->Frameworks->pluck('name')->implode(', ');

                return (object)[
                    'short_name' => $control->short_name,
                    'long_name' => $control->long_name,
                    'description_en' => $description_en,
                    'description_ar' => $description_ar,
                    'control_number' => $control->control_number,
                    'frame_name' => $controlFrameworksNames,
                    'family_name' => $control->family_with_parent?->name,
                    'family_name_parent' => $control->family_with_parent?->parentFamily?->name,
                    'parent_control' => $control->parentFrameworkControl?->short_name ?? '',
                    'mitigation_percent' => $control->mitigation_percent,
                    'supplemental_guidance' => $control->supplemental_guidance,
                    'priority' => $control->priority->name ?? '',
                    'phase' => $control->phase->name ?? '',
                    'type' => $control->type->name ?? '',
                    'maturity' => $control->maturity->name ?? '',
                    'class' => $control->class->name ?? '',
                    'desired_maturity' => $control->ControlDesiredMaturity->name ?? '',
                    'control_status' => $control->control_status,
                    'owner' => $control->owner->name ?? '',
                    'tester' => $control->custom_test->UserTester->name ?? '',
                    'test_name' => $control->custom_test->name,
                    'test_frequency' => $control->custom_test->test_frequency,
                    'last_test_date' => $control->custom_test->last_date,
                ];
            });
    }

    public function map($control): array
    {
        return [
            $this->counter++,
            $control->short_name,
            $control->long_name,
            $control->description_en,
            $control->description_ar,
            $control->control_number,
            $control->frame_name,
            $control->family_name_parent,
            $control->family_name,
            $control->parent_control,
            $control->mitigation_percent,
            $control->supplemental_guidance,
            $control->priority,
            $control->phase,
            $control->type,
            $control->maturity,
            $control->class,
            $control->desired_maturity,
            $control->control_status,
            $control->owner,
            $control->tester,
            $control->test_name,
            $control->test_frequency,
            $control->last_test_date
        ];
    }

    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.ControlShortName'),
            __('locale.ControlLongName'),
            __('locale.DescriptionEnglish'),
            __('locale.DescriptionArabic'),
            __('locale.ControlNumber'),
            __('locale.Framework'),
            __('locale.Domain'),
            __('locale.sub_domain'),
            __('locale.ParentControlFramework'),
            __('locale.MitigationPercent'),
            __('locale.SupplementalGuidance'),
            __('locale.ControlPriority'),
            __('locale.ControlPhase'),
            __('locale.ControlType'),
            __('locale.ControlMaturity'),
            __('locale.ControlClass'),
            __('locale.ControlDesiredMaturity'),
            __('locale.ControlStatus'),
            __('locale.ControlOwner'),
            __('locale.Tester'),
            __('locale.TestName'),
            __('locale.TestFrequency') . "(" . __('locale.days') . ")",
            __('locale.LastTestDate')
        ];
    }
}