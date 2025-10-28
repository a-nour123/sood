<?php

namespace App\Exports;

use App\Models\ControlObjective;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Traits\LaravelExportPropertiesTrait;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class ControlObjectivesExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait;

    private $frameworks;
    private $controls;
    private $counter = 1;

    public function __construct()
    {
        // Load all frameworks and controls into memory
        $this->frameworks = Framework::pluck('name', 'id')->mapWithKeys(function ($name, $id) {
            return [str_replace(' ', '', $id) => $name];
        });

        $this->controls = FrameworkControl::pluck('short_name', 'id')->mapWithKeys(function ($shortName, $id) {
            return [str_replace(' ', '', $id) => $shortName];
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ControlObjective::get();
    }

    /**
     * @var ControlObjective $controlObjective
     */
    public function map($controlObjective): array
    {
        $frameworkArray = explode(',', str_replace(' ', '', $controlObjective->framework_id));
        $controlsArray = explode(',', str_replace(' ', '', $controlObjective->control_id));

        // Map framework and control names based on the IDs
        $frameworkNames = array_map(function ($id) {
            return $this->frameworks[$id] ?? $id; // If not found, use the ID itself
        }, $frameworkArray);

        $controlsNames = array_map(function ($id) {
            return $this->controls[$id] ?? $id; // If not found, use the ID itself
        }, $controlsArray);

        // Convert arrays to comma-separated strings
        $frameworkNamesString = implode(', ', $frameworkNames);
        $controlsNamesString = implode(', ', $controlsNames);

        return [
            $this->counter++,
            $controlObjective->name,
            $controlObjective->description,
            $frameworkNamesString,
            $controlsNamesString,
            $controlObjective->created_at->format('Y-m-d H:i')
        ];
    }

    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.Description'),
            __('locale.Framework'),
            __('locale.Controls'),
            __('locale.CreatedDate')
        ];
    }
}
