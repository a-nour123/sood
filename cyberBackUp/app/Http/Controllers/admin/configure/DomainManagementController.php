<?php

namespace App\Http\Controllers\admin\configure;

use App\Exports\DomainsExport;
use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Rules\ValidateDomainOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DomainManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subDomains = Family::whereNotNull('parent_id')->get();
        $domains = Family::whereNull('parent_id')->get();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.regulator.index'), 'name' => __('locale.Frameworks')],
            ['name' => __('configure.Domains Management')]
        ];

        return view('admin.content.configure.domain_management.index', compact('breadcrumbs', 'domains', 'subDomains'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => ['required', 'max:1000'],
            'name_ar' => ['required', 'max:1000'],
            'parent_id' => ['nullable', 'exists:families,id'], // the parent domain for this domain
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('configure.ThereWasAProblemAddingTheDomain') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            $order = null;
            if (!is_null($request->parent_id)) {
                $order = Family::find($request->parent_id)->familiesOlny->max('order') + 1;
            } else {
                $order = (Family::whereNull('parent_id')->max('order')) + 1;
            }

            DB::beginTransaction();
            try {
                $family = Family::create([
                    'name' => ['en' => $request->name_en, 'ar' =>  $request->name_ar],
                    'parent_id' => $request->parent_id,
                    'order' => $order,
                ]);

                DB::commit();
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('configure.DomainWasAddedSuccessfully'),
                );

                $message = __('configure.A New Domain Added with name') . ' "' . ($family->name ?? __('locale.[No Domain Name]')) . '" '
                    . __('configure.and domain parent is') . ' "' . ($family->parentFamily->name ?? __('locale.[No Parent Name]')) . '" '
                    . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($family->id, auth()->id(), $message, 'Creating');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    'message' => $th->getMessage(),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Get specified resource data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $domain = Family::with('families')->find($id);

        if ($domain) {
            $name = $domain->getRawOriginal('name');
            $decodedName = is_array($name) ? $name : json_decode($name, true);

            $data = $domain->toArray();
            $data['name_en'] = $decodedName['en'] ?? '';
            $data['name_ar'] = $decodedName['ar'] ?? '';

            return response()->json([
                'status' => true,
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => __('locale.Error 404'),
        ], 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $domain = Family::find($id);
        if ($domain) {
            $validator = Validator::make($request->all(), [
                'name_en' => ['required', 'max:1000'],
                'name_ar' => ['required', 'max:1000'],
                'order' => ['required', 'integer', 'min:1', 'digits_between:1,4', new ValidateDomainOrder($id, $request->parent_id)],
                'parent_id' => ['nullable', 'exists:families,id'], // the parent domain for this domain
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('configure.ThereWasAProblemUpdatingTheDomain') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $domain->update([
                        'name' => ['en' => $request->name_en, 'ar' =>  $request->name_ar],
                        'order' => $request->order,
                        'parent_id' => $request->parent_id,
                    ]);

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('configure.DomainWasUpdatedSuccessfully'),
                    );
                    $message = __('configure.Domain updated with name') . ' "' . ($domain->name ?? __('locale.[No Domain Name]')) . '" '
                        . __('configure.and with domain parent is') . ' "' . ($domain->parentFamily->name ?? __('locale.[No Parent Name]')) . '" '
                        . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                    write_log($domain->id, auth()->id(), $message, 'updating');
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return $th->getMessage();
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domain = Family::find($id);
        if ($domain) {
            DB::beginTransaction();
            try {
                $domain->delete();

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' => __('configure.DomainWasDeletedSuccessfully'),
                );
                $message = __('configure.Domain with name') . ' "' . ($domain->name ?? __('locale.[No Domain Name]')) . '" '
                    . __('configure.and with domain parent is') . ' "' . ($domain->parentFamily->name ?? __('locale.[No Parent Name]')) . '" '
                    . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($domain->id, auth()->id(), $message, 'deleting');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('configure.ThereWasAProblemDeletingTheEmployee') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('configure.ThereWasAProblemDeletingTheEmployee');
                }
                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['name'],
            'relationships' => ['parentFamily', 'familiesOlny'],
            'other_global_filters' => [],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'parentFamily:id,name',
            'familiesOlny:name,parent_id',
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            Family::class,
            $dataTableDetails,
            $customFilterFields
        );

        $mainTableColumns = getTableColumnsSelect(
            'families',
            [
                'id',
                'name',
                'order',
                'parent_id'
            ]
        );

        // Getting records with apply global search */
        $domains = getDatatableFilterRecords(
            Family::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom domains response data as needs
        $data_arr = [];
        foreach ($domains as $domain) {
            $data_arr[] = array(
                'id' =>  $domain->id,
                'name' => $domain->name,
                'order' => $domain->order,
                'parentFamily' => ($domain->parentFamily) ? ($domain->parentFamily)->name : '',
                'familiesOlny' => $domain->familiesOlny()->pluck('name'),
                'Actions' => $domain->id
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new DomainsExport, 'Domains.xlsx');
        else
            return 'Domains.pdf';
    }
}