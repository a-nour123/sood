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

class ControlObjectivesImport implements
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
            $objectiveName = $row[$this->columnsMapping['name']] ?? null;
            $existingObjective = ControlObjective::where('name', $objectiveName)->first();
    
            // Prepare the framework_id and split control_id
            $searchFrame = str_replace(' ', '', $row[$this->columnsMapping['framework_id']]);
            $searchControl = str_replace(' ', '', $row[$this->columnsMapping['control_id']]);
    
            $frameworkArray = explode(',', $searchFrame);
    
            // Array to store framework IDs
            $frameworkIds = [];
    
            // Loop through the array and query the database for each framework
            foreach ($frameworkArray as $frameworkName) {
                $searchFrame = str_replace(' ', '', $frameworkName);
    
                // Query to find the ID of the current framework
                $frameworkId = Framework::whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchFrame . '%'])->value('id');
    
                // Store the result in the array if found
                if ($frameworkId) {
                    $frameworkIds[$searchFrame] = $frameworkId;
                } else {
                    $frameworkIds[$searchFrame] = null; // Handle case where the ID is not found
                }
            }
    
            // Skip if no valid framework IDs are found
            if (empty(array_filter($frameworkIds))) {
                continue;
            }
    
            // Process the control IDs
            $controlIds = collect(explode(',', $searchControl))->map(function ($control) {
                return str_replace(' ', '', $control);
            });
    
            // Map control IDs to actual IDs and filter out invalid ones
            $controlIds = $controlIds->map(function ($control) use ($frameworkIds) {
                $controlId = FrameworkControl::whereRaw("REPLACE(short_name, ' ', '') LIKE ?", ['%' . $control . '%'])->value('id');
                if ($controlId) {
                    // Check if the control belongs to any framework
                    foreach ($frameworkIds as $frameworkId) {
                        if ($frameworkId && FrameworkControlMapping::where('framework_id', $frameworkId)->where('framework_control_id', $controlId)->exists()) {
                            return $controlId;
                        }
                    }
                }
                return null;
            })->filter()->unique();
    
            // Update or create the ControlObjective
            if ($existingObjective) {
                // If the control objective already exists, update the framework_id and control_id with concatenation
                $newFrameworkIds = collect(array_filter(explode(',', $existingObjective->framework_id)))->merge($frameworkIds)->unique()->implode(',');
                $newControlIds = collect(array_filter(explode(',', $existingObjective->control_id)))->merge($controlIds)->unique();
    
                $existingObjective->update([
                    'framework_id' => $newFrameworkIds,
                    'control_id' => $newControlIds->implode(','),
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                ]);
    
                foreach ($newControlIds as $controlId) {
                    // $controlOwner = FrameworkControl::where('id', $controlId)->value('control_owner');
                    ControlControlObjective::updateOrCreate(
                        [
                            'control_id' => (int) $controlId,
                            'objective_id' => $existingObjective->id,
                        ],
                        [
                            // 'responsible_type' => 'user',
                            // 'due_date' => Null,
                            // You can add other fields to set here if needed
                        ]
                    );
                }
            } else {
                // Create a new control objective record in the database
                $newObjective = ControlObjective::create([
                    'name' => $objectiveName,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'framework_id' => $frameworkIds ? implode(',', array_filter($frameworkIds)) : null,
                    'control_id' => $controlIds->implode(','),
                    'created_at' => now(),
                ]);
    
                foreach ($controlIds as $controlId) {
                     // $controlOwner = FrameworkControl::where('id', $controlId)->value('control_owner');
                    ControlControlObjective::create([
                        'control_id' => (int) $controlId,
                        'objective_id' => $newObjective->id,
                        'due_date' => now(),
                        // 'responsible_type' => "user",
                        // 'responsible_id' => $controlOwner,
                    ]);
                }
            }
        }
    }
    




    public function rules(): array /* WithValidation */
    {
        // Determine the column names or use defaults if not provided
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : '(name)';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : '(description)';
        $framework_id = !empty($this->columnsMapping['framework_id']) ? $this->columnsMapping['framework_id'] : '(framework_id)';
        $control_id = !empty($this->columnsMapping['control_id']) ? $this->columnsMapping['control_id'] : '(control_id)';
        return [
            $name => ['required', 'max:255'],
            $description => ['required', 'max:500'],
            $framework_id => ['required', 'max:500'],
            $control_id => ['required', 'max:500'],
        ];
    }
}
