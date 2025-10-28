<?php

namespace App\Http\Controllers\admin\governance;

use App\Exports\FrameworkControlsExport;
use App\Http\Controllers\Controller;
use App\Imports\FrameworkControlsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class FrameworkControlController extends Controller
{
    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworkControlsExport, 'Controls.xlsx');
        else
            return 'Controls.pdf';
    }

    // This function is used to open the import form and send the required data for it
    // This function is used to open the import form and send the required data for it
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Controls')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required'], 'example' => 'Framework Control1'],

            // Column: 'description'
            ['name' => 'description_en', 'rules' => ['Can be empty'], 'example' => 'some description'],
            ['name' => 'description_ar', 'rules' => ['Can be empty'], 'example' => 'ادخل وصف باللغة العربية'],

            // Column: 'control_number'
            ['name' => 'control_number', 'rules' => ['Can be empty'], 'example' => 'control number'],

            // Column: 'supplemental_guidance'
            ['name' => 'supplemental_guidance', 'rules' => ['Can be empty'], 'example' => 'some supplemental guidance'],

            // Column: 'test_frequency'
            ['name' => 'test_frequency', 'rules' => ['must be integer', 'number of days'], 'example' => '5'],

            // Column: 'framework'
            ['name' => 'framework', 'rules' => ['required', 'must exist in frameworks table'], 'example' => 'framework1'],

            // Column: 'parent_id'
            ['name' => 'parent_id', 'rules' => ['Can be empty', 'must exist in framework_controls table'], 'example' => 'framework control1'],

            // Column: 'tester'
            ['name' => 'tester', 'rules' => ['required', 'must exist in users table'], 'example' => 'Ahmed Muhammed'],

            // Column: 'owner'
            ['name' => 'owner', 'rules' => ['can be empty', 'must exist in users table'], 'example' => 'Ahmed Muhammed'],

            // Column: 'domain' - Updated to match your actual column names
            ['name' => 'sub_domain_en', 'rules' => ['required'], 'example' => 'Cybersecurity Awareness and Training Program'],
            ['name' => 'sub_domain_ar', 'rules' => ['required'], 'example' => 'برنامج التوعية والتدريب على الأمن السيبراني'],

            // Column: 'mitigation_percent'
            ['name' => 'mitigation_percent', 'rules' => ['Can be empty', 'must be integer'], 'example' => '5'],

            // Column: 'approximate_time'
            ['name' => 'approximate_time', 'rules' => ['Can be empty', 'must be integer', 'number of minutes'], 'example' => '30'],

            // Column: 'test_steps'
            ['name' => 'test_steps', 'rules' => ['Can be empty'], 'example' => 'some test steps'],

            // Column: 'expected_results'
            ['name' => 'expected_results', 'rules' => ['Can be empty'], 'example' => 'some expected results'],

            // Column: 'control_priority'
            ['name' => 'control_priority', 'rules' => ['Can be empty', 'must exist in control_priorities table'], 'example' => 'control priority1'],

            // Column: 'control_phase'
            ['name' => 'control_phase', 'rules' => ['Can be empty', 'must exist in control_phases table'], 'example' => 'control phase1'],

            // Column: 'control_class'
            ['name' => 'control_class', 'rules' => ['Can be empty', 'must exist in control_classes table'], 'example' => 'control class1'],

            // Column: 'control_type'
            ['name' => 'control_type', 'rules' => ['Can be empty', 'must exist in control_types table'], 'example' => 'control type1'],

            // Column: 'control_maturity'
            ['name' => 'control_maturity', 'rules' => ['Can be empty', 'must exist in control_maturities table'], 'example' => 'control maturity1'],

            // Column: 'control_desired_maturity'
            ['name' => 'control_desired_maturity', 'rules' => ['Can be empty', 'must exist in control_desired_maturities table'], 'example' => 'control desired priority1'],
        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.governance.control.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "FramworkControlsImport" class to import its data
    public function importData(Request $request)
    {
        // Validate the incoming request for the 'import_file' field
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'file', 'max:5000'],
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            // Prepare response with validation errors
            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Controls')])
                    . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = [
                    'name',
                    'description_en',
                    'description_ar',
                    'control_number',
                    'supplemental_guidance',
                    'test_frequency',
                    'parent_id',
                    'framework',
                    'sub_domain_en',
                    'sub_domain_ar',
                    'tester',
                    'owner',
                    'mitigation_percent',
                    'approximate_time',
                    'test_steps',
                    'expected_results',
                    'control_priority',
                    'control_phase',
                    'control_class',
                    'control_type',
                    'control_maturity',
                    'control_desired_maturity'
                ];

                foreach ($columns as $column) {
                    if ($request->has($column)) {
                        $inputValue = $request->input($column);
                        $cleanedColumn = str_replace(
                            ["/", "(", ")", "'", "#", "*", "+", "%", "&", "$", "=", "<", ">", "?", "؟", ":", ";", '"', ".", "^", ",", "@", "-", " "],
                            ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '_at_', '_', '_'],
                            strtolower($inputValue)
                        );

                        $cleanedColumn = str_replace(
                            ["__"],
                            ['_'],
                            $cleanedColumn
                        );
                        $cleanedColumn = preg_replace('/(\w+)_\b/', '$1', $cleanedColumn);
                        $snakeCaseColumn = Str::snake($cleanedColumn);
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }
                // Extract values and filter out null values
                $values = array_values(array_filter($columnsMapping, function ($value) {
                    if ($value != null && $value != '') {
                        return $value;
                    }
                }));

                // Check for duplicate values
                if (count($values) !== count(array_unique($values))) {
                    $response = [
                        'status' => false,
                        'message' => __('locale.YouCantUseTheSameFileColumnForMoreThanOneDatabaseColumn'),
                    ];
                    return response()->json($response, 422);
                }

                // Import data using the specified columns mapping
                (new FrameworkControlsImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In FrameWork Control") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);

                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Controls')]),
                ];
                return response()->json($response, 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Rollback the transaction in case of an exception
                DB::rollBack();

                // Handle validation exceptions and prepare error response
                $failures = $e->failures();
                $errors = [];
                foreach ($failures as $failure) {
                    if (!array_key_exists($failure->row(), $errors)) {
                        $errors[$failure->row()] = [];
                    }
                    $errors[$failure->row()][] = [
                        'attribute' => $failure->attribute(),
                        'value' =>  $failure->values()[$failure->attribute()] ?? '',
                        'error' => $failure->errors()[0]
                    ];
                }

                $response = [
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Controls')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
}