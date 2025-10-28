<?php

namespace App\Http\Controllers\admin\import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Map columns from an Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapColumns(Request $request)
    {
        // Validate the incoming request for the 'import_file' field
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'mimes:xlsx,xls,ods,csv,txt', 'max:5000'],
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            // Prepare response with validation errors
            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            try {
                // Get the heading row from the Excel file
                $headingRow = Excel::toArray([], $request->import_file)[0][0];
                // Remove null values from the $headingRow array
                $headingRow = array_values(array_filter($headingRow, function ($value) {
                    return $value !== null;
                }));
       
                // Prepare success response with the heading row data
                $response = [
                    'status' => true,
                    'data' => $headingRow
                ];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                // Handle exceptions and prepare error response
                $response = [
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                ];
                return response()->json($response, 502);
            }
        }
    }
}
