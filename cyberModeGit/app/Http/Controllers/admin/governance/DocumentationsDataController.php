<?php

namespace App\Http\Controllers\admin\governance;

use App\Events\AddAuditPolicy;
use App\Events\AddPolicyCenter;
use App\Events\AddPolicyClause;
use App\Events\ApproveComplianceAuditer;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ControlDesiredMaturity;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\DocumentTypes;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Privacy;
use App\Models\Team;
use App\Models\User;
use App\Models\Action;
use Yajra\DataTables\Facades\DataTables;
use App\Events\CateogryDeleted;
use App\Events\CommentAuditee;
use App\Events\CommentAuditer;
use App\Events\DeletePolicyCenter;
use App\Events\DeletePolicyClause;
use App\Events\DocumentContentChangedAccepted;
use App\Events\DocumentContentChangedCreated;
use App\Events\DocumentContentChangedDeleted;
use App\Events\DocumentContentChangedUpdated;
use App\Events\StatusAuditee;
use App\Events\StatusAuditerApprove;
use App\Events\StatusAuditerReject;
use App\Events\UpdateAuditPolicy;
use App\Events\UpdatePolicyCenter;
use App\Exports\AuditDocumentPolicyExport;
use App\Exports\PolicyClauseExport;
use App\Http\Livewire\DocumentType;
use App\Imports\AuditDocumentPolicyStatusAndCommentsImport;
use App\Imports\PolicyClauseImport;
use App\Models\AuditDocumentPolicy;
use App\Models\AuditDocumentPolicyComment;
use App\Models\AuditDocumentPolicyFile;
use App\Models\AuditDocumentPolicyStatus;
use App\Models\AuditDocumentTotalStatus;
use App\Models\AuditLog;
use App\Models\CenterPolicy;
use App\Models\DocumentContentChange;
use App\Models\DocumentPolicy;
use App\Models\File;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;

class DocumentationsDataController extends Controller
{
    public function index()
    {
        //Documents
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            ['name' => __('locale.Documentation')]
        ];


        $documents = \App\Models\Document::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        // $owners=ControlOwner::all();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $controls = FrameworkControl::all();
        $categoryList = DocumentTypes::with('documents')->orderBy('id', 'asc')->get();

        Session::put('doc_current_id_dtb', $categoryList[0]->id ?? null);

        $category2 = DocumentTypes::orderBy('id', 'asc')->get();

        $status = DocumentStatus::all();
        $privacies = Privacy::all();

        $activeDocumentType = request()->query('doc_type');

        if (!DocumentTypes::where('id', $activeDocumentType)->exists())
            $activeDocumentType = null;

        if (!$activeDocumentType) {
            $activeDocumentType = $category2[0]->id ?? null;
        }
        $checkCount = DocumentTypes::count();
        $documntationStatistic = $this->GetDocumntationStatistic();
        $auditees = User::where('id', '!=', auth()->user()->id)->get();
        $auditers = User::all();
        return view('admin.content.governance.category', compact(
            'breadcrumbs',
            'controls',
            'testers',
            'teams',
            'documents',
            'frameworks',
            'owners',
            'desiredMaturities',
            'categoryList',
            'status',
            'privacies',
            'category2',
            'activeDocumentType',
            'checkCount',
            'documntationStatistic',
            'auditees',
            'auditers'
        ));
    }

    public function GetDocumntationStatistic()
    {
        // Total count of all documents
        $documentCountAll = Document::count();
        // Get counts for statuses 1, 2, 3
        $statusCounts = Document::select('document_status', \DB::raw('COUNT(*) as count'))
            ->whereIn('document_status', [1, 2, 3])
            ->groupBy('document_status')
            ->get()
            ->pluck('count', 'document_status')
            ->toArray();

        // Ensure all statuses are present, even if zero
        $statusCounts = [
            1 => $statusCounts[1] ?? 0, // Draft
            2 => $statusCounts[2] ?? 0, // InReview
            3 => $statusCounts[3] ?? 0, // Approved
        ];

        // Map for category type names
        $categoryTypeNames = [
            1 => 'Standard',
            2 => 'Policy',
            3 => 'procedures',
            4 => 'Others',
        ];

        // Get DocumentType data and map to categories
        $chartData = DocumentTypes::with(['documents' => function ($query) {
            $query->select('document_type', \DB::raw('COUNT(*) as count'))
                ->groupBy('document_type');
        }])
            ->select('id', 'type_category')
            ->get();

        // Group by category_name and calculate totals
        $groupedData = [];
        $totalDocuments = 0;

        foreach ($chartData as $item) {
            $categoryId = $item->type_category ?? 4; // Default to "Others" if null
            $categoryName = $categoryTypeNames[$categoryId] ?? 'Others';
            $documentCount = $item->documents->sum('count');

            // Add to total document count
            $totalDocuments += $documentCount;

            // Group by category_name
            if (!isset($groupedData[$categoryName])) {
                $groupedData[$categoryName] = 0;
            }
            $groupedData[$categoryName] += $documentCount;
        }
        // Get documents where last_review_date is within the next 10 days
        $inReview10Days = Document::whereBetween('last_review_date', [now(), now()->addDays(10)])
            ->count();
        // Prepare data with category names and percentages
        $formattedData = collect($groupedData)->map(function ($documentCount, $categoryName) use ($totalDocuments) {
            $percentage = $totalDocuments > 0 ? round(($documentCount / $totalDocuments) * 100, 2) : 0;

            return [
                'category_name' => $categoryName,
                'document_count' => $documentCount,
                'percentage' => $percentage,
            ];
        })->values();

        // Debug and return results
        return [
            'documentCount' => $documentCountAll,
            'statusCounts' => [
                'Draft' => $statusCounts[1],
                'InReview' => $statusCounts[2],
                'Approved' => $statusCounts[3],
                'inReview10Days' =>  $inReview10Days,
            ],
            'chartData' => $formattedData, // Return the grouped data
        ];
    }






    public function policyCenter()
    {
        // Check if the user has the required permission
        if (!auth()->user()->hasPermission('Document_Policy.list')) {
            abort(403, 'Unauthorized action.');
        }
        //Documents
        $breadcrumbs = [[
            'link' => route('admin.dashboard'),
            'name' => __('locale.Dashboard')
        ], [
            'link' => route('admin.governance.category'),
            'name' => __('locale.Documentation')
        ], ['name' => __('locale.PolicyCenter')]];
        $documentsTypes = DocumentTypes::whereIn('type_category', [1, 2])->pluck('id')->toArray();
        $documents = Document::whereIn('document_type', $documentsTypes)->select('id', 'document_name')->get();

        return view('admin.content.governance.policyCenter',  compact(
            'breadcrumbs',
            'documents'
        ));
    }


    public function storePolicy(Request $request)
    {
        // Custom validation for unique policy names
        $validator = Validator::make($request->all(), [
            'policy_name_en' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Better way to check JSON column uniqueness
                    $exists = CenterPolicy::whereRaw('JSON_EXTRACT(policy_name, "$.en") = ?', [$value])
                        ->exists();

                    if ($exists) {
                        $fail(__('validation.unique', ['attribute' => 'English policy name']));
                    }
                }
            ],
            'policy_name_ar' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = CenterPolicy::whereRaw('JSON_EXTRACT(policy_name, "$.ar") = ?', [$value])
                        ->exists();

                    if ($exists) {
                        $fail(__('validation.unique', ['attribute' => 'Arabic policy name']));
                    }
                }
            ],
            'document_id' => 'required|array',
            'document_id.*' => 'exists:documents,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => __('governance.ThereWasAProblemAddingThePolicy') . "<br>" . __('locale.ValidationError'),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $policy = CenterPolicy::create([
                'policy_name' => [
                    'en' => $request->policy_name_en,
                    'ar' => $request->policy_name_ar
                ],
                'document_ids' => implode(',', $request->document_id),
            ]);

            foreach ($request->document_id as $documentId) {
                $policyDoc = DocumentPolicy::create([
                    'policy_id' => $policy->id,
                    'document_id' => $documentId,
                ]);

                $lastAudit = AuditDocumentPolicy::where('document_id', $documentId)->latest()->first();
                if ($lastAudit) {
                    DB::table('audit_document_policy_policy_document')->insert([
                        'audit_document_policy_id' => $lastAudit->id,
                        'policy_document_id' => $policyDoc->id,
                    ]);
                }
            }

            DB::commit();
            event(new AddPolicyCenter($policy));

            return response()->json([
                'status' => true,
                'reload' => true,
                'message' => __('governance.PolicyWasAddedSuccessfully'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
            ], 502);
        }
    }


    public function GetDataPolicy(Request $request)
    {
        if ($request->ajax()) {
            $policies = CenterPolicy::select('id', 'policy_name', 'document_ids');

            return DataTables::of($policies)
                ->editColumn('document_ids', function ($policy) {
                    // Get document names from IDs and return as a comma-separated string
                    $documentIds = explode(',', $policy->document_ids);
                    $documentNames = Document::whereIn('id', $documentIds)->pluck('document_name')->toArray();
                    return implode(', ', $documentNames);
                })
                ->addColumn('action', function ($policy) {
                    $actions = '';

                    // Check if the user has permission to update or delete
                    if (auth()->user()->hasPermission('Document_Policy.update') || auth()->user()->hasPermission('Document_Policy.delete')) {
                        // Start the dropdown structure
                        $dropdown = '
                        <div class="dropdown">
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">';

                        // Check if the user has the required permission to update
                        if (auth()->user()->hasPermission('Document_Policy.update')) {
                            $dropdown .= '<li><a class="dropdown-item edit-policy" href="#" data-id="' . $policy->id . '">Edit</a></li>';
                        }

                        // Check if the user has the required permission to delete
                        if (auth()->user()->hasPermission('Document_Policy.delete')) {
                            $dropdown .= '<li><a class="dropdown-item delete-policy" href="#" data-id="' . $policy->id . '">Delete</a></li>';
                        }

                        $dropdown .= '
                            </ul>
                        </div>';

                        $actions = $dropdown;
                    } else {
                        // Display alternative text if the user has no permissions
                        $actions = '---';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Breadcrumbs for navigation
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Survey')]
        ];

        return view('admin.content.governance.policyCenter', compact('breadcrumbs'));
    }

    /**
     * Get a specific policy by ID.
     */
    public function getPolicy(Request $request, $id)
    {
        // Find the policy by ID
        $policy = CenterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found.'], 404);
        }

        // Fetch document names for the selected document IDs
        $documentIds = explode(',', $policy->document_ids);
        $documentNames = Document::whereIn('id', $documentIds)->pluck('document_name')->toArray();

        return response()->json([
            'policy_name' => $policy->getRawOriginal('policy_name'),
            'document_ids' => $policy->document_ids, // IDs as a string for easy handling
            'document_names' => implode(', ', $documentNames) // Optional: return names as well
        ]);
    }


    /**
     * Edit a specific policy by ID.
     */

    public function editPolicy(Request $request, $id)
    {
        // Find the policy first
        $policy = CenterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'policy_name_en' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = CenterPolicy::where('id', '!=', $id)
                        ->where(function ($query) use ($value) {
                            $query->whereRaw('JSON_EXTRACT(policy_name, "$.en") = ?', [$value]);
                        })
                        ->exists();
                    if ($exists) {
                        $fail(__('validation.unique', ['attribute' => 'English policy name']));
                    }
                }
            ],
            'policy_name_ar' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = CenterPolicy::where('id', '!=', $id)
                        ->where(function ($query) use ($value) {
                            $query->whereRaw('JSON_EXTRACT(policy_name, "$.ar") = ?', [$value]);
                        })
                        ->exists();
                    if ($exists) {
                        $fail(__('validation.unique', ['attribute' => 'Arabic policy name']));
                    }
                }
            ],
            'document_id' => 'required|array',
            'document_id.*' => 'exists:documents,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => __('governance.ThereWasAProblemUpdatingThePolicy') . "<br>" . __('locale.ValidationError'),
            ], 422);
        }

        // Find the policy by ID
        $policy = CenterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found.'], 404);
        }

        // Get the current document policies associated with this policy
        $currentDocumentPolicies = DocumentPolicy::where('policy_id', $policy->id)->pluck('document_id')->toArray();

        // Find the document IDs that need to be removed
        $documentIdsToRemove = array_diff($currentDocumentPolicies, $request->document_id);

        // Check if the document IDs to remove are being used in the 'auditdocumentpolicystatus' table
        $documentsInAuditStatus = AuditDocumentTotalStatus::whereIn('document_id', $documentIdsToRemove)
            ->pluck('document_id')
            ->toArray();

        // If any of the documents to be removed are in use in the 'auditdocumentpolicystatus' table, return an error
        if (!empty($documentsInAuditStatus)) {
            // Get the document names for the IDs in use
            $documentNames = Document::whereIn('id', $documentsInAuditStatus)
                ->pluck('document_name') // Assuming 'name' is the column holding document names
                ->toArray();

            $responseMessage = 'The following documents are in use in audit and user take action on it so that cannot be removed: ' . implode(', ', $documentNames);
            return response()->json(['status' => false, 'message' =>  $responseMessage]);
        }

        // Proceed with deletion of the document policies that are no longer associated
        if (!empty($documentIdsToRemove)) {
            DocumentPolicy::where('policy_id', $policy->id)
                ->whereIn('document_id', $documentIdsToRemove)
                ->delete();
        }

        // Optionally, you can also add new document policies that are in the request but not in the current ones
        $documentIdsToAdd = array_diff($request->document_id, $currentDocumentPolicies);
        foreach ($documentIdsToAdd as $documentId) {
            DocumentPolicy::create([
                'policy_id' => $policy->id,
                'document_id' => $documentId,
            ]);
        }

        // Save the policy name and associated documents
        $policy->policy_name = [
            'en' => $request->policy_name_en,
            'ar' => $request->policy_name_ar
        ];
        $policy->document_ids = implode(',', $request->document_id); // Convert array to comma-separated string
        $policy->save();

        event(new UpdatePolicyCenter($policy));

        return response()->json(['status' => true, 'message' => 'Policy updated successfully.']);
    }



    /**
     * Delete a specific policy by ID.
     */
    public function deletePolicy(Request $request, $id)
    {
        $policy = CenterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found.'], 404);
        }

        // Find the document IDs associated with the policy by ID
        $documentIds = DocumentPolicy::where('policy_id', $id)->pluck('document_id')->toArray();

        // Check which document IDs exist in the audit table
        $existingIds = DB::table('audit_document_policy_policy_document')
            ->whereIn('policy_document_id', $documentIds) // Use $documentIds here
            ->pluck('policy_document_id') // Assuming this is the correct column name in the audit table
            ->toArray();

        // Fetch document names based on existing document IDs
        $documentNames = Document::whereIn('id', $existingIds)->pluck('document_name')->toArray();

        // Convert the array of document names into a comma-separated string
        $documentNamesString = implode(', ', $documentNames);

        if (!empty($existingIds)) {
            return response()->json([
                'message' => "Cannot delete the policy; it is referenced in the audit of the following documents: $documentNamesString. You can't remove the assignments to these documents."
            ], 400);
        }

        // Delete the policy and trigger the event
        $policy->delete();
        event(new DeletePolicyCenter($policy));

        return response()->json(['status' => true, 'message' => 'Policy deleted successfully.']);
    }


    public function fetchPolicies(Request $request)
    {
        // dd($request->all());
        $documentId = $request->input('document_id');
        // Get the policy IDs associated with the given document ID
        $documentPolicyIds = DocumentPolicy::where('document_id', $documentId)->pluck('policy_id')->toArray();

        // Get policies that are not in the $documentPolicyIds
        $policies = CenterPolicy::select('id', 'policy_name')
            ->whereNotIn('id', $documentPolicyIds)
            ->get();
        return response()->json(['policies' => $policies]);
    }

    public function storePolicyDocument(Request $request)
    {
        // Custom validation for unique policy names
        $validator = Validator::make($request->all(), [
            'new_policy_name_en' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = CenterPolicy::where('policy_name->en', $value)->exists();
                    if ($exists) {
                        $fail(__('validation.unique', ['attribute' => 'English policy name']));
                    }
                }
            ],
            'new_policy_name_ar' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = CenterPolicy::where('policy_name->ar', $value)->exists();
                    if ($exists) {
                        $fail(__('validation.unique', ['attribute' => 'Arabic policy name']));
                    }
                }
            ],
            'document_id' => 'required|integer|exists:documents,id',
            'policy_id' => 'nullable|integer|exists:center_policies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => __('governance.ThereWasAProblemAddingThePolicy') . "<br>" . __('locale.ValidationError'),
            ], 422);
        }

        $validated = $validator->validated();
        $policy_id = null;
        $policy = null;

        // If new policy name is provided, create a new policy
        if ($request->filled('new_policy_name_en') && $request->filled('new_policy_name_ar')) {
            $policy = CenterPolicy::create([
                'policy_name' => [
                    'en' => $validated['new_policy_name_en'],
                    'ar' => $validated['new_policy_name_ar']
                ],
                'document_ids' => $validated['document_id'],
            ]);
            $policy_id = $policy->id;
        } elseif (!empty($validated['policy_id'])) {
            // Find the existing policy by ID
            $policy = CenterPolicy::find($validated['policy_id']);
            if ($policy) {
                // Get existing document_ids, if any
                $existingDocumentIds = $policy->document_ids ? explode(',', $policy->document_ids) : [];
                // Merge new document_id with existing ones
                $mergedDocumentIds = array_unique(array_merge($existingDocumentIds, [(string)$validated['document_id']]));
                // Update the document_ids field with merged data
                $policy->update([
                    'document_ids' => implode(',', $mergedDocumentIds),
                ]);
                $policy_id = $policy->id;
            }
        }

        // Find the document
        $document = Document::find($validated['document_id']);

        if ($document && $policy_id) {
            // Attach the policy (new or existing) to the document with timestamps
            $document->policies()->attach($policy_id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            event(new AddPolicyClause($document, $policy));

            // Return success response with policy name and ID
            return response()->json([
                'success' => true,
                'policy_name' => $policy ? $policy->policy_name : CenterPolicy::find($policy_id)->policy_name,
                'policy_id' => $policy_id,
                'document_id' => $validated['document_id'],
            ]);
        }
        // If the document was not found
        return response()->json([
            'success' => false,
            'message' => 'Document not found',
        ], 404);
    }


    public function deletePolicyDocument($id)
    {
        // Find the policy document by ID
        $policyDocument = DocumentPolicy::find($id);

        // Check if the policy document exists
        if (!$policyDocument) {
            return response()->json(['success' => false, 'message' => 'Policy document not found.'], 404);
        }
        // Check if the policy document exists in the audit table
        $existsInAudit = DB::table('audit_document_policy_policy_document')
            ->where('policy_document_id', $id) // Assuming the column in the audit table is named `document_policy_id`
            ->exists();

        if ($existsInAudit) {
            return response()->json(['message' => 'Cannot delete the policy ; it is referenced in the audit.'], 400);
        }
        // Find the associated policy
        $policy = CenterPolicy::find($policyDocument->policy_id);

        // Check if the policy exists
        if (!$policy) {
            return response()->json(['success' => false, 'message' => 'Policy not found.'], 404);
        }

        // Get the document ID from the policy document
        $document_id = $policyDocument->document_id; // The document ID is already in the policyDocument

        // Get existing document_ids
        $existingDocumentIds = $policy->document_ids ? explode(',', $policy->document_ids) : [];

        // Remove the document_id from the list
        if (($key = array_search($document_id, $existingDocumentIds)) !== false) {
            unset($existingDocumentIds[$key]); // Remove the document_id from the array
        }
        $document = Document::find($document_id);

        // Update the document_ids column
        $policy->update([
            'document_ids' => implode(',', $existingDocumentIds), // Save the updated document_ids as a comma-separated string
        ]);


        // Delete the policy document
        $policyDocument->delete(); // Correctly call the delete method
        event(new DeletePolicyClause($document, $policy));

        return response()->json(['success' => true, 'message' => 'Policy deleted successfully.']);
    }


    public function fetchDocumentPolicies($documentId)
    {
        // Fetch policies associated with the document and join with center_policies to get policy_name
        $policies = DocumentPolicy::where('document_id', $documentId)
            ->join('center_policies', 'center_policies.id', '=', 'document_policies.policy_id')
            ->select('document_policies.*', 'center_policies.policy_name as name')
            ->get();
        // Return policies as JSON
        return response()->json($policies);
    }



    public function AduitPolicyDocument()
    {
        if (!auth()->user()->hasPermission('Aduit_Document_Policy.list')) {
            abort(403, 'Unauthorized action.');
        }
        //Documents
        $breadcrumbs = [[
            'link' => route('admin.dashboard'),
            'name' => __('locale.Dashboard')
        ], [
            'link' => route('admin.governance.category'),
            'name' => __('locale.Documentation')
        ], ['name' => __('locale.AduitPolicyDocument')]];

        // $documents = \App\Models\Document::all();
        $documentTypes = DocumentTypes::whereIn('type_category', [1, 2])->select('id', 'name')->get();
        $auditees = User::where('id', '!=', auth()->user()->id) // Exclude the authenticated user
            ->get();
        $auditers = User::all();

        // $documentPolicy=DocumentPolicy::all();
        // $policies=CenterPolicy::select('policy_name','id')->get();

        return view('admin.content.governance.AduitPolicyDocument',  compact(
            'breadcrumbs',
            'auditees',
            'auditers',
            // 'documentPolicy',
            // 'policies',  
            // 'documents',
            'documentTypes'
        ));
    }

    public function getDocumentsByType(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
        ]);

        // Get the documents based on the document type ID
        $documents = Document::where('document_type', $request->document_type_id)->get(['id', 'document_name']);

        // Return the documents as a JSON response
        return response()->json(['documents' => $documents]);
    }

    public function AduitPolicyDocumentPast()
    {
        if (!auth()->user()->hasPermission('Aduit_Document_Policy.list')) {
            abort(403, 'Unauthorized action.');
        }
        //Documents
        $breadcrumbs = [[
            'link' => route('admin.dashboard'),
            'name' => __('locale.Dashboard')
        ], [
            'link' => route('admin.governance.category'),
            'name' => __('locale.Documentation')
        ], ['name' => __('locale.AduitPolicyDocumentPast')]];

        $documents = \App\Models\Document::all();

        $auditees = User::where('id', '!=', auth()->user()->id) // Exclude the authenticated user
            ->get();
        $auditers = User::all();

        // $documentPolicy=DocumentPolicy::all();
        // $policies=CenterPolicy::select('policy_name','id')->get();

        return view('admin.content.governance.PastAduitPolicyDocument',  compact(
            'breadcrumbs',
            'auditees',
            'auditers',
            // 'documentPolicy',
            // 'policies',  
            'documents',
        ));
    }
    public function getRelatedPolicies($documentId)
    {
        // Eager load the policy relationship to get the name
        $policies = DocumentPolicy::with('policy')->where('document_id', $documentId)->get();
        return response()->json($policies);
    }


    public function storeAduitDocumentPolicy(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'aduit_name' => 'required|string|max:255',
            'document_id' => 'required|exists:documents,id',
            'owner_id' => 'required|exists:users,id',
            'responsible' => 'required|array',
            'responsible.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'periodical_time' => 'integer|min:0',
            'next_initiate_date' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $allPolicies = DocumentPolicy::where('document_id', $request->document_id)->pluck('id')->toArray();

        if (empty($allPolicies)) {
            return response()->json(['errors' => 'The document does not contain policies to audit.'], 404);
        }
        // Use a database transaction
        DB::beginTransaction();
        try {
            // Check if we are updating an existing record
            if ($request->has('id') && $request->input('id')) {
                $auditDocumentPolicy = AuditDocumentPolicy::find($request->input('id'));
                if (!$auditDocumentPolicy) {
                    return response()->json(['error' => 'AuditDocumentPolicy not found.'], 404);
                }
                // Retrieve the old responsible users
                $oldResponsibles = explode(',', $auditDocumentPolicy->responsible);
                $newResponsibles = $request->input('responsible');

                // Determine removed responsibles
                $removedResponsibles = array_diff($oldResponsibles, $newResponsibles);

                // Check if any removed responsible has associated records
                foreach ($removedResponsibles as $userId) {

                    $hasActions = AuditDocumentPolicyComment::where('aduit_id', $auditDocumentPolicy->id)
                        ->where('user_id', $userId)
                        ->exists() ||
                        AuditDocumentPolicyFile::where('aduit_id', $auditDocumentPolicy->id)
                        ->where('uploaded_by', $userId)
                        ->exists() ||
                        AuditDocumentPolicyStatus::where('aduit_id', $auditDocumentPolicy->id)
                        ->where('user_id', $userId)
                        ->exists();

                    if ($hasActions) {
                        $user = User::find($userId);
                        return response()->json(['errors' => __('locale.User :name has taken action on this audit and cannot be removed.', ['name' => $user->name])], 404);
                    }
                }
                $auditDocumentPolicy->update($request->only([
                    'aduit_name',
                    'document_id',
                    'owner_id',
                    'start_date',
                    'due_date',
                    'periodical_time',
                    'next_initiate_date',
                    'requires_file',
                    'document_type'
                ]));

                // Implode the responsible IDs into a string and save
                $responsibles = implode(',', $request->input('responsible'));
                $auditDocumentPolicy->responsible = $responsibles;
                $auditDocumentPolicy->save(); // Save to update the responsible field

                $policyDocumentIds = $allPolicies;
                // Sync the selected policy document IDs to the pivot table
                $auditDocumentPolicy->policies()->sync($allPolicies);

                // Commit the transaction
                DB::commit();
                event(new UpdateAuditPolicy($auditDocumentPolicy, $policyDocumentIds));
            } else {

                AuditDocumentPolicy::where('document_id', $request->document_id)->update([
                    'enable_audit' => 0
                ]);

                // Creating a new record
                $auditDocumentPolicy = AuditDocumentPolicy::create($request->only([
                    'aduit_name',
                    'document_id',
                    'owner_id',
                    'start_date',
                    'due_date',
                    'periodical_time',
                    'next_initiate_date',
                    'requires_file',
                    'document_type',
                ]));
                // Implode the responsible IDs into a string and save
                $responsibles = implode(',', $request->input('responsible'));
                $auditDocumentPolicy->responsible = $responsibles;
                $auditDocumentPolicy->save(); // Save to update the responsible field

                $policyDocumentIds = $allPolicies;
                // Sync the selected policy document IDs to the pivot table
                $auditDocumentPolicy->policies()->sync($allPolicies);


                // Commit the transaction
                DB::commit();
                event(new AddAuditPolicy($auditDocumentPolicy, $policyDocumentIds));
            }



            return response()->json(['success' => true, 'auditDocumentPolicy' => $auditDocumentPolicy], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if something failed
            DB::rollBack();
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
    public function checkAuditDocumentPolicy(Request $request)
    {
        $exists = AuditDocumentPolicy::where('document_id', $request->document_id)
            ->where('enable_audit', 1)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function getAuditDocumentPolicies(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;
            $type = $request->input('type'); // Get the selected type

            // Fetch policies where the user is either in the responsible list or is the owner
            $aduitDocumentpolicies = AuditDocumentPolicy::with('policies.policy', 'documentType')
                ->select([
                    'id',
                    'aduit_name',
                    'document_id',
                    'owner_id',
                    'responsible',
                    'start_date',
                    'due_date',
                    'periodical_time',
                    'next_initiate_date',
                    'enable_audit',
                    'requires_file',
                    'document_type',
                ])->where(function ($query) use ($type) {
                    // Apply additional filter based on type
                    if ($type === 'past') {
                        $query->where('enable_audit', 0);
                    } elseif ($type === 'active') {
                        $query->where('enable_audit', 1);
                    }
                })
                ->where(function ($query) use ($userId) {
                    // Filter by owner_id or if the user is in the responsible field
                    if (auth()->user()->role_id != 1) { // Not an admin
                        $query->where('owner_id', $userId)
                            ->orWhereRaw('FIND_IN_SET(?, responsible)', [$userId]);
                    }
                });

            return DataTables::of($aduitDocumentpolicies)
                ->editColumn('responsible', function ($policy) {
                    // Get document names from IDs and return as a comma-separated string
                    $responsibleIds = explode(',', $policy->responsible);
                    $responsibleNames = User::whereIn('id', $responsibleIds)->pluck('name')->toArray();
                    return implode(', ', $responsibleNames);
                })
                ->editColumn('document_id', function ($policy) {
                    // Optionally fetch the document name instead of just the ID
                    return $policy->document ? $policy->document->document_name : 'N/A'; // Replace 'name' with the actual field in the Document model
                })
                ->editColumn('document_type', function ($policy) {
                    // Optionally fetch the document name instead of just the ID
                    return $policy->documentType ? $policy->documentType->name : 'N/A'; // Replace 'name' with the actual field in the Document model
                })
                ->editColumn('owner_id', function ($policy) {
                    // Optionally fetch the owner's name instead of just the ID
                    return $policy->users ? $policy->users->name : 'N/A'; // Replace 'name' with the actual field in the User model
                })
                ->editColumn('policy_name', function ($policy) {
                    // Get policy names from the associated DocumentPolicy instances
                    $policyNames = $policy->policies->map(function ($docPolicy) {
                        return $docPolicy->policy->policy_name ?? 'N/A'; // Accessing the CenterPolicy through DocumentPolicy
                    });

                    return $policyNames->filter(function ($name) {
                        return $name !== 'N/A'; // Optionally filter out 'N/A'
                    })->implode(', ') ?: 'N/A'; // Return 'N/A' if no valid names found
                })
                ->addColumn('action', function ($policy) use ($type) {
                    // Get responsible user IDs as an array
                    $responsibleIds = explode(',', $policy->responsible);

                    // Determine if the current user is the owner or responsible
                    $isOwner = auth()->user()->id == $policy->owner_id;
                    $isResponsible = in_array(auth()->user()->id, $responsibleIds);

                    // Check if the user is an admin
                    $isAdmin = auth()->user()->role_id == 1;

                    // Parse the due date and current date
                    $dueDate = Carbon::parse($policy->due_date)->format('Y-m-d');
                    $today = Carbon::now()->format('Y-m-d');

                    // Initialize buttons array
                    $buttons = [];

                    // Define the dropdown button HTML
                    $dropdownButton = '
                        <div class="dropdown">
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </a>
                            <div class="dropdown-menu">
                    ';

                    // If the user is an admin, show all relevant buttons
                    if ($isAdmin) {
                        if ($dueDate > $today) {
                            $buttons['edit'] = '<a class="dropdown-item edit-policy" data-id="' . $policy->id . '" href="#">' . __('locale.Edit') . '</a>';
                        }
                        if ($isResponsible) {
                            $buttons['view'] = '<a class="dropdown-item" href="' . route('admin.governance.showdetailsAduit', ['id' => $policy->id]) . '">' . __('locale.View') . '</a>';
                        }
                        if ($type != "past") {
                            $buttons['clone'] = '<a class="dropdown-item clone-policy" data-id="' . $policy->id . '" href="#">' . __('locale.Clone') . '</a>';
                        }
                        $buttons['statics'] = '<a class="dropdown-item" href="' . route('admin.governance.showAuditStatistics', ['id' => $policy->id]) . '">' . __('locale.Statistics') . '</a>';
                    } else {
                        // If the user is both owner and responsible
                        if ($isOwner && $isResponsible) {
                            if ($dueDate > $today && $policy->enable_audit == 1) {
                                $buttons['edit'] = '<a class="dropdown-item edit-policy" data-id="' . $policy->id . '" href="#">' . __('locale.Edit') . '</a>';
                            } else {
                                $buttons['statics'] = '<a class="dropdown-item" href="' . route('admin.governance.showAuditStatistics', ['id' => $policy->id]) . '">' . __('locale.Statistics') . '</a>';
                            }
                        }
                        // Only allow viewing if the user is responsible
                        if ($isResponsible) {
                            $buttons['view'] = '<a class="dropdown-item" href="' . route('admin.governance.showdetailsAduit', ['id' => $policy->id]) . '">' . __('locale.View') . '</a>';
                        }
                        // If the user is the owner
                        if ($isOwner) {
                            $buttons['statics'] = '<a class="dropdown-item" href="' . route('admin.governance.showAuditStatistics', ['id' => $policy->id]) . '">' . __('locale.Statistics') . '</a>';
                        }
                    }

                    // Add the buttons to the dropdown
                    foreach ($buttons as $button) {
                        $dropdownButton .= $button;
                    }

                    // Close the dropdown
                    $dropdownButton .= '
                            </div>
                        </div>
                    ';

                    // If no buttons were added, return a placeholder
                    if (empty($buttons)) {
                        return '----';
                    }

                    // Return the dropdown button
                    return $dropdownButton;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function getAuditDocumentPolicyById($id)
    {
        // Check if the user has the required permission
        if (!auth()->user()->hasPermission('Aduit_Document_Policy.list')) {
            abort(403, 'Unauthorized action.');
        }
        $policy = AuditDocumentPolicy::with(['document', 'users', 'policies'])->find($id);

        // Prepare the response
        return response()->json([
            'aduit_name' => $policy->aduit_name,
            'document_id' => $policy->document_id,
            'policy_document_id' => $policy->policies->pluck('policy_id')->toArray(), // Assuming `policy_id` is the field in your policy model
            'owner_id' => $policy->owner_id,
            'responsible' => explode(',', $policy->responsible), // Split the responsible field into an array
            'start_date' => $policy->start_date, // Include start_date in the response
            'due_date' => $policy->due_date,
            'periodical_time' => $policy->periodical_time,
            'next_initiate_date' => $policy->next_initiate_date,
            'requires_file' => $policy->requires_file,
            'document_type' => $policy->document_type,
        ]);
    }

    public function showdetailsAduit($id)
    {
        if (!auth()->user()->hasPermission('Aduit_Document_Policy.result')) {
            abort(403, 'Unauthorized action.');
        }
        // Fetch the audit document policy
        $auditDocumentPolicy = AuditDocumentPolicy::where('id', $id)->first();
        $statustotal = AuditDocumentTotalStatus::where('audit_id', $id)->where('user_id', auth()->user()->id)->value('total_status') ?? Null;

        // use this to check if this user sent his result or not 
        $checkSendResult = AuditDocumentPolicyStatus::where('aduit_id', $id)->where('user_id', auth()->user()->id)->first()->status ?? Null;

        // Check if the responsible column contains the authenticated user
        $responsibleIds = explode(',', $auditDocumentPolicy->responsible); // Convert responsible string to array
        $startDate = Carbon::parse($auditDocumentPolicy->start_date)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');
        // Check if the authenticated user is in the responsible list

        if (in_array(auth()->user()->id, $responsibleIds) && $startDate > $today) {
            // Return 403 Forbidden if the aduit not start
            abort(403, 'The Aduit Not Start Soon.');
        }
        if (!in_array(auth()->user()->id, $responsibleIds)) {
            // Return 403 Forbidden if the user is not responsible
            abort(403, 'You are not authorized to access this page.');
        }

        // Breadcrumbs
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            [
                'link' => route('admin.governance.Aduit.document.policy'),
                'name' => __('locale.AuditPolicy')
            ],
            [
                'name' => __('locale.AuditDocument')
            ]
        ];


        return view('admin.content.governance.AduitPolicyResult', compact('breadcrumbs', 'id', 'auditDocumentPolicy', 'statustotal', 'checkSendResult'));
    }

    public function GetDataAduit(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('aduitId'); // Get the AduitId from the request

            // Get the relevant policy document IDs
            $policyDocumentIds = DB::table('audit_document_policy_policy_document')
                ->where('audit_document_policy_id', $id)
                ->pluck('policy_document_id')
                ->toArray();

            // Fetch policies with conditions
            $policies = AuditDocumentPolicy::with([
                'policies' => function ($query) use ($policyDocumentIds, $id) {
                    $query->whereIn('document_policies.id', $policyDocumentIds)
                        ->with([
                            'auditComments' => function ($query) use ($id) {
                                $query->where('aduit_id', $id)->where('user_id', auth()->user()->id);
                            },
                            'auditFiles' => function ($query) use ($id) {
                                $query->where('aduit_id', $id)->where('uploaded_by', auth()->user()->id);
                            },
                            'auditStatuses' => function ($query) use ($id) {
                                $query->where('aduit_id', $id)->where('user_id', auth()->user()->id);
                            },
                        ]);
                },
                'document',
                'users'
            ])
                ->where('audit_document_policies.id', $id)
                ->get();

            // Flatten policies: convert each policy into an individual row
            $flattenedPolicies = collect();
            foreach ($policies as $policyArray) {
                foreach ($policyArray->policies as $policy) {
                    $flattenedPolicies->push($policy);
                }
            }

            return DataTables::of($flattenedPolicies)
                ->addColumn('policy_clause', function ($policy) {
                    return $policy->policy->policy_name ?? '-';
                })
                ->addColumn('status', function ($policy) {
                    $auditStatus = $policy->auditStatuses->where('user_id', auth()->user()->id)->first();
                    return $auditStatus->status ?? 'No Status';
                })
                ->addColumn('pending_status', function ($policy) {
                    $auditStatus = $policy->auditStatuses->where('user_id', auth()->user()->id)->first();
                    return $auditStatus->pending_status ?? 'No Status';
                })
                ->addColumn('auditer_status', function ($policy) {
                    $auditStatus = $policy->auditStatuses->where('user_id', auth()->user()->id)->first();
                    return $auditStatus->auditer_status ?? 'No Status';
                })
                ->addColumn('action', function ($policy) use ($policies) { // Access policies here
                    $policyId = $policies[0]->id; // Getting the ID from the first policy
                    $documentPolicyId = $policy->id; // Accessing the policy_document_id from the pivot
                    // Get the status to pass it
                    $auditStatus = $policy->auditStatuses->where('user_id', auth()->user()->id)->first();
                    $status = $auditStatus->pending_status ?? 'No Status';
                    $enabled = $policies[0]->enable_audit;
                    $output = '
                            <div class="dropdown">
                                <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu">
                                    <a href="javascript:;" class="dropdown-item add-comment" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '">
                                        ' . __('locale.Add Comment') . '
                                    </a>
                                    <a href="javascript:;" class="dropdown-item upload-file" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '">
                                        ' . __('locale.Add Evidence') . '
                                    </a>';

                    if ($enabled == 1) {
                        $output .= '<a href="javascript:;" class="dropdown-item edit-status" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '" data-status="' . $status . '">
                                ' . __('locale.Edit Status') . '
                            </a>';
                    }

                    $output .= '
                                </div>
                            </div>';

                    return $output;
                })
                ->rawColumns(['action']) // Call rawColumns only once
                ->make(true);
        }

        // Breadcrumbs for navigation
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Survey')]
        ];

        return view('admin.content.governance.policyCenter', compact('breadcrumbs'));
    }


    public function GetComments($id, Request $request)
    {
        // Get document policy ID if needed
        $documentPolicyId = $request->input('document_policy_id');


        // Fetch comments based on the policy ID and optional document policy ID
        $comments = AuditDocumentPolicyComment::with('user', 'replier') // Eager load user and replier
            ->where('aduit_id', $id)
            ->where('document_policy_id', $documentPolicyId)
            ->where('user_id', auth()->user()->id)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'name' => $comment->replier_id ? $comment->replier->name : $comment->user->name, // Use replier's name if available
                    'created_at' => $comment->created_at
                ];
            });


        return response()->json($comments);
    }


    public function GetCommentsForAduiter($id, Request $request)
    {
        // Get document policy ID and user ID from the request
        $documentPolicyId = $request->input('document_policy_id');
        $userId = $request->input('userId');

        // Fetch comments based on the policy ID and optional document policy ID
        $comments = AuditDocumentPolicyComment::with('user', 'replier') // Eager load user and replier
            ->where('aduit_id', $id)
            ->where('document_policy_id', $documentPolicyId)
            ->where('user_id', $userId)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'name' => $comment->replier_id ? $comment->replier->name : $comment->user->name, // Use replier's name if available
                    'created_at' => $comment->created_at
                ];
            });

        return response()->json($comments);
    }



    public function indexFiles($id, Request $request)
    {
        if ($request->input('userId')) {
            // Get document policy ID from the request
            $documentPolicyId = $request->input('document_policy_id');
            // Fetch files related to the policy by ID and user ID
            $files = AuditDocumentPolicyFile::where('aduit_id', $id)->where('document_policy_id', $documentPolicyId)
                ->where('uploaded_by', $request->input('userId'))
                ->with('user') // Assuming there's a relationship with the user
                ->get(['file_name', 'file_path', 'created_at', 'evidenc_name', 'description']); // Fetch necessary columns including created_at   
        } else {
            // Get document policy ID from the request
            $documentPolicyId = $request->input('document_policy_id');
            // Fetch files related to the policy by ID and user ID
            $files = AuditDocumentPolicyFile::where('aduit_id', $id)->where('document_policy_id', $documentPolicyId)
                ->where('uploaded_by', auth()->user()->id)
                ->with('user') // Assuming there's a relationship with the user
                ->get(['file_name', 'file_path', 'created_at', 'evidenc_name', 'description']); // Fetch necessary columns including created_at
        }

        return response()->json(['files' => $files]);
    }



    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = AuditDocumentPolicyComment::create([
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'aduit_id' => $id,
            'document_policy_id' => $request->document_policy_id,
            'replier_id' => NUll
        ]);
        event(new CommentAuditee($comment));

        // Include the user information if needed
        $comment->user = auth()->user();

        return response()->json(['message' => 'Comment added successfully.', 'comment' => $comment]);
    }
    public function storeFile(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            // 'evidenc_name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        // Initialize file data
        $filePath = null;
        $fileName = null;

        // Check if the file is present
        if ($request->hasFile('file')) {
            // Store the file in the specified folder and get the path
            $filePath = $request->file('file')->store('document_policy_attach');

            // Extract only the file name from the full path
            $fileName = basename($filePath);
        }

        // Create a new record in the database
        $file = AuditDocumentPolicyFile::create([
            'file_path' => $fileName, // Save file name or null if no file
            'file_name' => $fileName ? $request->file('file')->getClientOriginalName() : null, // Save original file name or null
            // 'evidenc_name' => $request->evidenc_name, // Save the evidence name
            'description' => $request->description, // Save the description
            'uploaded_by' => auth()->id(),
            'aduit_id' => $id,
            'document_policy_id' => $request->document_policy_id,
        ]);

        return response()->json(['message' => 'Data saved successfully.', 'file' => $file]);
    }



    public function download($filePath)
    {

        // Construct the full path to the file in storage
        $fullPath = 'document_policy_attach/' . $filePath;

        // Check if the file exists
        if (!Storage::exists($fullPath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Return the file as a response with the appropriate headers
        return Storage::download($fullPath);
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'document_policy_id' => 'required|integer',
        ]);

        $id = intval($id);
        // Fetch the policy associated with the provided ID
        $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);

        if ($auditDocumentPolicy->requires_file == 1 && in_array($request->status, ['Partially Implemented', 'Implemented'])) {

            // Check if evidence has been uploaded for this audit and document policy
            $uploadedEvidence = AuditDocumentPolicyFile::where('aduit_id', $id) // Correct typo 'audit_id'
                ->where('document_policy_id', $request->document_policy_id)
                ->first();

            // If no evidence is found, return an error response
            if (!$uploadedEvidence) {
                return response()->json([
                    'message' => 'error_evidence_required',
                    'status' => $request->status
                ], 422);
            }
        }


        // Proceed with creating or updating the AuditDocumentPolicyStatus
        $status = AuditDocumentPolicyStatus::updateOrCreate(
            [
                'aduit_id' => $id,
                'document_policy_id' => $request->document_policy_id,
                'user_id' => auth()->id()
            ],
            [
                'pending_status' => $request->status,
            ]
        );

        // Trigger the StatusAuditee event
        event(new StatusAuditee($status));

        // Return a successful response
        return response()->json([
            'message' => 'Status updated successfully.',
            'status' => $status
        ]);
    }


    public function sendResultAudit(Request $request)
    {
        $id = $request->input('id'); // Audit Document Policy ID
        // Start a DB transaction
        DB::beginTransaction();

        try {
            // Count the number of associated policy documents for the given audit document policy ID
            $policyDocumentCount = DB::table('audit_document_policy_policy_document')
                ->where('audit_document_policy_id', $id)
                ->count();

            // Check if the user has a status for the given audit document policy ID
            $existingStatusCount = AuditDocumentPolicyStatus::where('user_id', auth()->user()->id)
                ->where('aduit_id', $id)
                ->count();


            $documentPolicyIds = DB::table('audit_document_policy_policy_document')
                ->where('audit_document_policy_id', $id)
                ->pluck('policy_document_id')
                ->toArray();


            // Fetch the policy associated with the provided ID
            $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);

            // Iterate over the document policy IDs to check each status
            $existingPolicies = AuditDocumentPolicyStatus::where('aduit_id', $id)
                ->where('user_id', auth()->user()->id)
                ->whereIn('document_policy_id', $documentPolicyIds)
                ->get();
            foreach ($existingPolicies as $existingPolicy) {
                // If the status is 'Partially Implemented' or 'Implemented', check if evidence has been uploaded
                if ($auditDocumentPolicy->requires_file == 1 && in_array($existingPolicy->pending_status, ['Partially Implemented', 'Implemented'])) {
                    // Check if evidence has been uploaded for this document policy
                    $uploadedEvidence = AuditDocumentPolicyFile::where('aduit_id', $id) // Correct typo 'audit_id'
                        ->where('document_policy_id', $existingPolicy->document_policy_id)
                        ->first();

                    // If no evidence is found, return an error response with the policy clause name
                    if (!$uploadedEvidence) {
                        $documentPolicy = DocumentPolicy::find($existingPolicy->document_policy_id);
                        return response()->json([
                            'message' => 'error_evidence_required_for_' . $documentPolicy->policy->policy_name ?? Null,
                        ], 422);
                    }
                }
            }

            // If the number of statuses matches the number of policy documents, update the status
            if ($existingStatusCount >= $policyDocumentCount) {
                // Iterate over the document policy IDs to update records
                foreach ($existingPolicies as $existingPolicy) {
                    // Update existing record's status to the 'pending' status
                    $existingPolicy->update(['status' => $existingPolicy->pending_status]);
                }

                // Commit the transaction if everything goes well
                DB::commit();

                // use this to check if this user sent his result or not
                $checkSendResult = AuditDocumentPolicyStatus::where('aduit_id', $id)->where('user_id', auth()->user()->id)->first()->value('status') ?? Null;                // Respond with success message and the status value
                return response()->json([
                    'message' => 'Result sent successfully!',
                    'checkSendResult' => $checkSendResult
                ]);
            } else {
                // If counts don't match, throw an exception to trigger the rollback
                throw new \Exception('Cannot perform this action, all status does not take action.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Return error message
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }




    public function showAuditStatistics($id)
    {

        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            [
                'link' => route('admin.governance.Aduit.document.policy'),
                'name' => __('locale.AuditPolicy')
            ],
            [
                'name' => __('locale.Audit Document')
            ]
        ];
        $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);

        // Check if the responsible field is not null and convert to an array
        $responsibleArray = !is_null($auditDocumentPolicy->responsible)
            ? explode(',', $auditDocumentPolicy->responsible)
            : [];

        // Authorization check

        if (auth()->user()->role_id != 1 && $auditDocumentPolicy->owner_id !== auth()->user()->id) {
            abort(403, 'You are not authorized to access this page.');
        }
        if (!auth()->user()->hasPermission('Aduit_Document_Policy.result')) {
            abort(403, 'Unauthorized action.');
        }
        // Fetch relevant policy document IDs
        $policyDocumentIds = DB::table('audit_document_policy_policy_document')
            ->where('audit_document_policy_id', $id)
            ->pluck('policy_document_id')
            ->toArray();

        // Fetch all users who are responsible
        $users = User::whereIn('id', $responsibleArray)->get()->keyBy('id');

        // Group users by ldap_region (not necessary for the final output but can be useful)
        $groupedUsers = $users->groupBy('ldap_region');

        // Fetch document IDs related to the policy documents
        $documentPolicyIds = DocumentPolicy::whereIn('id', $policyDocumentIds)->pluck('document_id')->toArray();

        // Fetch document names
        $documentNames = Document::whereIn('id', $documentPolicyIds)->pluck('document_name', 'id')->toArray();

        // Create an array to hold the final result
        $resultArray = [];

        // Create a unique key array to track seen combinations
        $seen = [];
        // Iterate through each user and document to build the desired output
        foreach ($users as $user) {
            foreach ($documentPolicyIds as $policyDocumentId) {
                // Ensure the policyDocumentId exists in the documentNames array
                if (array_key_exists($policyDocumentId, $documentNames)) {
                    // Create a unique key based on user_id and policy_document_id
                    $uniqueKey = $user->id . '-' . $policyDocumentId;

                    // Fetch the total status for the current user, audit ID, and document ID
                    $totalStatus = AuditDocumentTotalStatus::where('user_id', $user->id)
                        ->where('audit_id', $id) // Assuming 'audit_id' is the same as $id
                        ->where('document_id', $policyDocumentId)
                        ->value('total_status'); // Get the total_status directly
                    // Check if this combination has already been added
                    if (!isset($seen[$uniqueKey])) {
                        $resultArray[] = [
                            'audit_name' => $auditDocumentPolicy->aduit_name,
                            'user_id' => $user->id,
                            'audit_document_policy_id' => $id,
                            'document_id' => $policyDocumentId,
                            'policy_document_id' => $policyDocumentIds,
                            'user_name' => $user->name,
                            'document_name' => $documentNames[$policyDocumentId],
                            'ldap_region' => $user->ldap_region, // Add the user's region
                            'total_status' => $totalStatus ?? 'No Action' // Set default if no status found
                        ];

                        // Mark this combination as seen
                        $seen[$uniqueKey] = true;
                    }
                }
            }

            $regions = User::whereNotNull('ldap_region')
                ->select('ldap_region')
                ->distinct()
                ->pluck('ldap_region');
        }
        $departments = Department::select('id', 'name')->get();
        // Return the view with policies, responsibleArray, groupedUsers, and chartData
        return view('admin.content.governance.AuditPolicyStatic', compact('resultArray', 'id', 'responsibleArray', 'groupedUsers', 'regions', 'departments', 'breadcrumbs'));
    }

    public function showdetailsAduitForAduiter($id, $user_id, $document_id, Request $request)
    {

        if (!auth()->user()->hasPermission('Aduit_Document_Policy.result')) {
            abort(403, 'Unauthorized action.');
        }


        $policyDocumentIds = $request->input('policy_document_id'); // This will be an array
        // Fetch the audit document policy
        $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);
        $statustotal = AuditDocumentTotalStatus::where('audit_id', $id)->where('user_id', $user_id)->where('document_id', $document_id)->value('total_status') ?? Null;
        if (auth()->user()->role_id != 1 && auth()->user()->id != $auditDocumentPolicy->owner_id) {
            abort(403, 'Unauthorized action.');
        }
        // Breadcrumbs
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            [
                'link' => route('admin.governance.Aduit.document.policy'),
                'name' => __('locale.AuditPolicy')
            ],
            [
                'name' => __('locale.Audit Document')
            ]
        ];

        return view('admin.content.governance.AduitPolicyResultForAduiter', compact('breadcrumbs', 'statustotal', 'id', 'user_id', 'document_id', 'auditDocumentPolicy', 'policyDocumentIds'));
    }
    public function GetDataAduitForAuditer(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('aduitId'); // Get the AduitId from the request
            $userId = $request->input('userId'); // Get the AduitId from the request
            $documentId = $request->input('documentId'); // Get the AduitId from the request
            // Get the relevant policy document IDs
            $policyDocumentIds = DB::table('audit_document_policy_policy_document')
                ->where('audit_document_policy_id', $id)
                ->pluck('policy_document_id')
                ->toArray();

            // Fetch policies with conditions
            $policies = AuditDocumentPolicy::with([
                'policies' => function ($query) use ($policyDocumentIds, $id, $userId) {
                    $query->whereIn('document_policies.id', $policyDocumentIds)
                        ->with([
                            'auditComments' => function ($query) use ($id, $userId) {
                                $query->where('aduit_id', $id)->where('user_id', $userId);
                            },
                            'auditFiles' => function ($query) use ($id, $userId) {
                                $query->where('aduit_id', $id)->where('uploaded_by', $userId);
                            },
                            'auditStatuses' => function ($query) use ($id, $userId) {
                                $query->where('aduit_id', $id)->where('user_id', $userId);
                            },
                        ]);
                },
                'document',
                'users'
            ])
                ->where('audit_document_policies.id', $id)
                ->get();

            // Flatten policies: convert each policy into an individual row
            $flattenedPolicies = collect();
            foreach ($policies as $policyArray) {
                foreach ($policyArray->policies as $policy) {
                    $flattenedPolicies->push($policy);
                }
            }

            return DataTables::of($flattenedPolicies)
                ->addColumn('policy_clause', function ($policy) {
                    return $policy->policy->policy_name ?? '-';
                })
                ->addColumn('status', function ($policy) use ($userId) { // Pass $userId here
                    $auditStatus = $policy->auditStatuses->where('user_id', $userId)->first();
                    return $auditStatus->status ?? 'No Status';
                })
                ->addColumn('auditer_status', function ($policy) use ($userId) {
                    $auditStatus = $policy->auditStatuses->where('user_id', $userId)->first();
                    return $auditStatus ? $auditStatus->auditer_status : 'Not Action';
                })
                ->addColumn('action', function ($policy) use ($policies, $userId) {
                    $policyId = $policies[0]->id; // Getting the ID from the first policy
                    $documentPolicyId = $policy->id; // Accessing the policy_document_id from the pivot

                    // Get the status to pass it
                    $auditStatus = $policy->auditStatuses->where('user_id', $userId)->first();
                    $status = $auditStatus->status ?? 'No Status';
                    $statusAuditer = $auditStatus->auditer_status ?? 'No Status';
                    $enabled = $policies[0]->enable_audit;

                    $output = '
                        <div class="dropdown">
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </a>
                            <div class="dropdown-menu">
                                <a href="javascript:;" class="dropdown-item add-comment" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '">
                                    ' . __('locale.Comment') . '
                                </a>
                                <a href="javascript:;" class="dropdown-item upload-file" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '">
                                    ' . __('locale.Evidence') . '
                                </a>';

                    if ($enabled == 1) {
                        $output .= '
                                <a href="javascript:;" class="dropdown-item edit-status-auditer" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '" data-status="' . $statusAuditer . '" data-user-id="' . $userId . '">
                                    ' . __('locale.Approve') . '
                                </a>
                                <a href="javascript:;" class="dropdown-item edit-status-auditer-auditee" data-id="' . $policyId . '" data-document-policy-id="' . $documentPolicyId . '" data-status="' . $statusAuditer . '" data-user-id="' . $userId . '">
                                    ' . __('locale.Reject') . '
                                </a>';
                    }

                    $output .= '
                            </div>
                        </div>';

                    return $output;
                })
                ->rawColumns(['action']) // Call rawColumns only once
                ->make(true);
        }

        // Breadcrumbs for navigation
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Survey')]
        ];

        return view('admin.content.governance.policyCenter', compact('breadcrumbs'));
    }

    public function storeCommentForAuditer(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        $comment = AuditDocumentPolicyComment::create([
            'comment' => $request->comment,
            'user_id' =>  $request->userId,
            'aduit_id' => $id,
            'document_policy_id' => $request->document_policy_id,
            'replier_id' => auth()->id(),
        ]);
        event(new CommentAuditer($comment));

        // Include the user information if needed
        $comment->user = auth()->user();

        return response()->json(['message' => 'Comment added successfully.', 'comment' => $comment]);
    }

    public function approveAll(Request $request)
    {
        $aduitId = $request->input('aduit_id');
        $userId = $request->input('user_id');
        $documentPolicyIds = DB::table('audit_document_policy_policy_document')
            ->where('audit_document_policy_id', $aduitId)
            ->pluck('policy_document_id')
            ->toArray();

        // Ensure IDs are integers
        $documentPolicyIds = array_map('intval', $documentPolicyIds);

        // Fetch the statuses of the document policies
        $existingPolicies = AuditDocumentPolicyStatus::where('aduit_id', $aduitId)
            ->whereIn('document_policy_id', $documentPolicyIds)
            ->where('user_id', $userId)
            ->get();

        // Initialize an array to track the IDs of the policies that were updated
        $updatedPolicies = [];

        // Iterate over the document policy IDs to update or create records
        foreach ($documentPolicyIds as $documentPolicyId) {
            $policy = $existingPolicies->firstWhere('document_policy_id', $documentPolicyId);

            if ($policy) {
                // Update existing record
                $policy->update(['auditer_status' => $policy->status, 'updated_by' => $userId]);
                $updatedPolicies[] = $documentPolicyId; // Track updated policy ID
            } else {
                // Create a new record with auditer_status as NULL
                $status = AuditDocumentPolicyStatus::create([
                    'aduit_id' => $aduitId,
                    'document_policy_id' => $documentPolicyId,
                    'auditer_status' => null, // Set status to NULL
                    'status' => null, // Set status to NULL
                    'user_id' => $userId,
                ]);
            }
        }
        // Check for policies without actions
        $policiesWithoutActions = array_diff($documentPolicyIds, $updatedPolicies);

        // Get policies with null status
        $policiesWithNullStatus = AuditDocumentPolicyStatus::where('aduit_id', $aduitId)
            ->whereIn('document_policy_id', $documentPolicyIds)
            ->whereNull('status')
            ->pluck('document_policy_id')
            ->toArray();
        // Combine both lists
        $combinedPolicies = array_merge($policiesWithoutActions, $policiesWithNullStatus);
        // Create an array to hold the data
        $approveAll = [
            'aduit_id' => intval($aduitId),
            'user_id' => intval($userId),
            'document_policy_ids' => $documentPolicyIds,
        ];

        if (!empty($combinedPolicies)) {

            $policeClauseId = DocumentPolicy::whereIn('id', $combinedPolicies)->pluck('policy_id')->toArray();
            $policeClauseName = CenterPolicy::whereIn('id', $policeClauseId)->pluck('policy_name')->toArray();
            $policiesList = implode(', ', $policeClauseName);
            event(new ApproveComplianceAuditer($policy));

            return response()->json([
                'message' => 'Some policies do not have an action associated with them: ' . $policiesList,
                'policies_without_actions' => $policiesList,
            ]);
        }
        event(new ApproveComplianceAuditer($policy));


        return response()->json(['message' => 'All policies processed successfully.']);
    }


    public function updateStatusReject(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'document_policy_id' => 'required|integer',
        ]);

        $status = AuditDocumentPolicyStatus::updateOrCreate(
            [
                'aduit_id' => $id,
                'document_policy_id' => $request->document_policy_id,
                'user_id' => $request->user_id,
            ],
            [
                'auditer_status' => $request->status,
            ]
        );
        event(new StatusAuditerReject($status));

        return response()->json(['message' => 'Status updated successfully.', 'status' => $status]);
    }

    public function updateStatusApproved(Request $request, $id)
    {
        $request->validate([
            'document_policy_id' => 'required|integer',
            'user_id' => 'required|integer', // Ensure user_id is also validated
        ]);

        // Fetch the current status to use it
        $currentStatus = AuditDocumentPolicyStatus::where('aduit_id', $id)
            ->where('document_policy_id', $request->document_policy_id)
            ->where('user_id', $request->user_id)
            ->value('status'); // Get the status value
        // Use updateOrCreate to either update the existing record or create a new one
        $status = AuditDocumentPolicyStatus::updateOrCreate(
            [
                'aduit_id' => $id,
                'document_policy_id' => $request->document_policy_id,
                'user_id' => $request->user_id,
            ],
            [
                'auditer_status' => $currentStatus ?? null, // Set auditer_status to currentStatus or null if it doesn't exist
            ]
        );
        event(new StatusAuditerApprove($status));

        return response()->json(['message' => 'Status updated successfully.', 'status' => $status]);
    }

    public function getChartData(Request $request)
    {
        $region = $request->input('region');
        $type = $request->input('type'); // Get the selected type
        $department = $request->input('department'); // Get the selected department
        $id = $request->input('id'); // Get the audit ID from the request
        $policies = [];

        if ($region && $type == 1) {
            $policies = $this->GetChartForPoliceClause($id, $region);
        } elseif ($region && $type == 2) {
            $policies = $this->GetChartForDepartement($id, $region);
        } elseif ($region) {
            $policies = $this->GetChartForOnlyRegion($id, $region);
        }
        // dd($policies);
        return response()->json(['policies' => $policies]);
    }

    private function GetChartForPoliceClause($id, $region)
    {
        // Fetch user IDs by selected region
        $users = User::where('ldap_region', $region)->pluck('id')->toArray();
        $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);

        // Convert responsible field to an array if it's not null
        $responsibleArray = !is_null($auditDocumentPolicy->responsible)
            ? explode(',', $auditDocumentPolicy->responsible)
            : [];

        // Find common IDs in both arrays
        $commonIds = array_intersect($users, $responsibleArray);

        // Fetch relevant policy document IDs
        $policyDocumentIds = DB::table('audit_document_policy_policy_document')
            ->where('audit_document_policy_id', $id)
            ->pluck('policy_document_id')
            ->toArray();

        // Fetch policies with conditions
        $policies = AuditDocumentPolicy::with([
            'policies' => function ($query) use ($policyDocumentIds, $id, $commonIds) {
                $query->whereIn('document_policies.id', $policyDocumentIds)
                    ->with([
                        'auditComments' => function ($query) use ($id) {
                            $query->where('aduit_id', $id);
                        },
                        'auditFiles' => function ($query) use ($id) {
                            $query->where('aduit_id', $id);
                        },
                        'auditStatuses' => function ($query) use ($id, $commonIds) {
                            $query->where('aduit_id', $id)->whereIn('user_id', $commonIds);
                        },
                    ]);
            },
            'document',
            'users'
        ])
            ->where('audit_document_policies.id', $id)
            ->get();

        // Initialize chart data array
        $chartData = [];
        foreach ($policies as $policy) {
            foreach ($policy->policies as $policyDetail) {
                $policyName = $policyDetail->policy->policy_name;

                // Initialize counters for status
                $statusCounts = [
                    'Not Implemented' => 0,
                    'Not Applicable' => 0,
                    'Partially Implemented' => 0,
                    'Implemented' => 0,
                    'No Action' => 0,
                ];

                // Group statuses by user
                $statusesByUser = $policyDetail->auditStatuses->groupBy('user_id');

                // Loop through users only in the selected region
                foreach ($commonIds as $userId) {
                    // Check if the user has any statuses for this policy
                    if (isset($statusesByUser[$userId])) {
                        $statuses = $statusesByUser[$userId];
                        foreach ($statuses as $status) {
                            // Check for null status
                            if (is_null($status->status)) {
                                $statusCounts['No Action']++; // Increment No Action for null statuses
                            } elseif (array_key_exists($status->status, $statusCounts)) {
                                $statusCounts[$status->status]++; // Increment the count for known statuses
                            } else {
                                // Optional: Handle unknown status values
                            }
                        }
                    } else {
                        // If no statuses are found for this user, increment No Action
                        $statusCounts['No Action']++;
                    }
                }

                // Calculate total statuses for percentage calculation
                $totalStatuses = array_sum($statusCounts);

                if ($totalStatuses > 0) {
                    // Calculate percentages based on the total statuses
                    $percentages = [
                        'Not Implemented' => ($statusCounts['Not Implemented'] / $totalStatuses) * 100,
                        'Not Applicable' => ($statusCounts['Not Applicable'] / $totalStatuses) * 100,
                        'Partially Implemented' => ($statusCounts['Partially Implemented'] / $totalStatuses) * 100,
                        'Implemented' => ($statusCounts['Implemented'] / $totalStatuses) * 100,
                        'No Action' => ($statusCounts['No Action'] / $totalStatuses) * 100,
                    ];

                    $chartData[$policyName] = [
                        'labels' => ['Not Implemented', 'Not Applicable', 'Partially Implemented', 'Implemented', 'No Action'],
                        'data' => [
                            $percentages['Not Implemented'],
                            $percentages['Not Applicable'],
                            $percentages['Partially Implemented'],
                            $percentages['Implemented'],
                            $percentages['No Action'],
                        ],
                        'userNames' => $this->getUserNamesForPolicy($statusesByUser, $commonIds), // Get user names
                    ];
                }
            }
        }

        return array_values(array_map(function ($name, $data) {
            return [
                'policy_name' => $name,
                'labels' => $data['labels'],
                'data' => $data['data'],
                'userNames' => $data['userNames'],
            ];
        }, array_keys($chartData), $chartData));
    }



    private function GetChartForDepartement($id, $region)
    {
        // Fetch user IDs and their departments by selected region
        $responsibleArray = AuditDocumentPolicy::findOrFail($id)->responsible;

        // Convert responsible field to an array if it's not null
        $responsibleArray = !is_null($responsibleArray)
            ? explode(',', $responsibleArray)
            : [];

        // Fetch only users whose IDs are in the responsibleArray
        $users = User::where('ldap_region', $region)->whereIn('id', $responsibleArray)->with('department')->get();

        // Find common IDs in both arrays
        $commonIds = $users->pluck('id')->toArray();

        // Fetch policies and their statuses for the specified audit and users
        $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);
        $policies = AuditDocumentTotalStatus::where('audit_id', $id)
            ->where('document_id', $auditDocumentPolicy->document_id)
            ->whereIn('user_id', $commonIds)
            ->with('users.department') // Eager load department relationship
            ->get();

        // Collect user IDs from policies for quick lookup
        $policyUserIds = $policies->pluck('user_id')->toArray();

        // Identify users in commonIds but not in policies
        $missingUserIds = array_diff($commonIds, $policyUserIds);

        // Create "Not Implemented" policies for missing users
        foreach ($missingUserIds as $missingUserId) {
            $missingPolicy = new AuditDocumentTotalStatus([
                'user_id' => $missingUserId,
                'total_status' => 'Not Implemented',
                'audit_id' => $id,
                'document_id' => $auditDocumentPolicy->document_id,
            ]);
            $policies->push($missingPolicy); // Add to collection
        }

        // The policy name is shared across all departments
        $policyName = $policies->isNotEmpty() ? $policies[0]->documents->document_name : 'Unknown Policy';

        // Initialize an array to hold user statuses by department
        $departmentStatusCounts = [];

        // Loop through users to initialize department status counts
        foreach ($users as $user) {
            $departmentName = $user->department->name ?? 'Unassigned';
            $departmentStatusCounts[$departmentName] = [
                'Not Implemented' => 0,
                'Not Applicable' => 0,
                'Partially Implemented' => 0,
                'Implemented' => 0,
            ];
        }

        // Loop through policies to update status counts
        foreach ($policies as $policy) {
            $status = $policy->total_status;

            // Get the user's department
            $departmentName = $policy->users->department->name ?? 'Unassigned';

            // Increment the corresponding status count for the department
            if (isset($departmentStatusCounts[$departmentName][$status])) {
                $departmentStatusCounts[$departmentName][$status]++;
            }
        }

        // Prepare the result data for all departments under the same policy name
        $departments = [];

        foreach ($departmentStatusCounts as $department => $statusCounts) {
            $totalCount = array_sum($statusCounts);

            // Determine overall status based on counts
            $overallStatus = 'Partially Implemented'; // Default for mixed status case
            if ($totalCount > 0) {
                if ($statusCounts['Implemented'] === $totalCount) {
                    $overallStatus = 'Implemented';
                } elseif ($statusCounts['Not Applicable'] === $totalCount) {
                    $overallStatus = 'Not Applicable';
                } elseif ($statusCounts['Partially Implemented'] === $totalCount) {
                    $overallStatus = 'Partially Implemented';
                } elseif ($statusCounts['Not Implemented'] === $totalCount) {
                    $overallStatus = 'Not Implemented';
                }
            }

            // Store each department's data
            $departments[] = [
                'department_name' => $department,
                'labels' => ['Overall Status'],
                'data' => [$overallStatus],
                'status_counts' => $statusCounts,
            ];
        }

        // Return the result in a single array for the policy
        return [
            'policy_name' => $policyName,
            'departments' => $departments,
        ];
    }



    private function GetChartForOnlyRegion($id, $region)
    {
        // Fetch user IDs by selected region
        $users = User::where('ldap_region', $region)->pluck('id')->toArray();
        $auditDocumentPolicy = AuditDocumentPolicy::findOrFail($id);

        // Convert responsible field to an array if it's not null
        $responsibleArray = !is_null($auditDocumentPolicy->responsible)
            ? explode(',', $auditDocumentPolicy->responsible)
            : [];

        // Find common IDs in both arrays
        $commonIds = array_intersect($users, $responsibleArray);

        // Fetch policies and their statuses for the specified audit and users
        $policies = AuditDocumentTotalStatus::where('audit_id', $id)
            ->where('document_id', $auditDocumentPolicy->document_id)
            ->whereIn('user_id', $commonIds)
            ->get();

        // Initialize chart data array
        $chartData = [];

        // Initialize an array to hold user statuses
        $userStatuses = array_fill_keys($commonIds, 'No Action');

        // Loop through policies and update user statuses
        foreach ($policies as $policy) {
            $userId = $policy->user_id; // Get user ID for the current policy
            $status = $policy->total_status;

            // Update the user status
            $userStatuses[$userId] = $status; // This will overwrite 'No Action' if status is found
        }

        // Initialize status counts
        $statusCounts = [
            'Not Implemented' => 0,
            'Not Applicable' => 0,
            'Partially Implemented' => 0,
            'Implemented' => 0,
            'No Action' => 0,
        ];

        // Count statuses based on userStatuses
        foreach ($userStatuses as $status) {
            $statusCounts[$status]++;
        }

        // Calculate total statuses for percentage calculation
        $totalCount = array_sum($statusCounts);

        if ($totalCount > 0) {
            // Calculate percentages based on the total statuses
            $percentages = [
                'Not Implemented' => ($statusCounts['Not Implemented'] / $totalCount) * 100,
                'Not Applicable' => ($statusCounts['Not Applicable'] / $totalCount) * 100,
                'Partially Implemented' => ($statusCounts['Partially Implemented'] / $totalCount) * 100,
                'Implemented' => ($statusCounts['Implemented'] / $totalCount) * 100,
                'No Action' => ($statusCounts['No Action'] / $totalCount) * 100,
            ];

            $chartData[$auditDocumentPolicy->document->document_name] = [
                'labels' => ['Not Implemented', 'Not Applicable', 'Partially Implemented', 'Implemented', 'No Action'],
                'data' => [
                    $percentages['Not Implemented'],
                    $percentages['Not Applicable'],
                    $percentages['Partially Implemented'],
                    $percentages['Implemented'],
                    $percentages['No Action'],
                ],
            ];
        }

        return array_values(array_map(function ($name, $data) {
            return [
                'policy_name' => $name,
                'labels' => $data['labels'],
                'data' => $data['data'],
            ];
        }, array_keys($chartData), $chartData));
    }

    private function getUserNamesForPolicy($statusesByUser, $commonIds)
    {
        $userNamesByStatus = [
            'Not Implemented' => [],
            'Not Applicable' => [],
            'Partially Implemented' => [],
            'Implemented' => [],
            'No Action' => []
        ];

        foreach ($commonIds as $userId) {
            $userName = User::find($userId)->name; // Adjust based on your User model
            $status = $statusesByUser[$userId] ?? null;

            if ($status) {
                foreach ($status as $userStatus) {
                    if (is_null($userStatus->status)) {
                        $userNamesByStatus['No Action'][] = $userName; // Group as No Action for null statuses
                    } else {
                        $userNamesByStatus[$userStatus->status][] = $userName; // Group by known status
                    }
                }
            } else {
                $userNamesByStatus['No Action'][] = $userName; // Indicate no action
            }
        }

        return $userNamesByStatus;
    }
    public function calcTotalStatus(Request $request)
    {
        $aduitId = $request->input('aduit_id');
        $userId = $request->input('user_id');
        $documentPolicyIds = json_decode($request->input('documentPolicyId'), true);

        // Ensure IDs are integers
        $documentPolicyIds = array_map('intval', $documentPolicyIds);

        // Fetch the statuses of the document policies
        $existingPolicies = AuditDocumentPolicyStatus::where('aduit_id', $aduitId)
            ->whereIn('document_policy_id', $documentPolicyIds)
            ->where('user_id', $userId)
            ->get();

        // Collect existing policy IDs
        $existingPolicyIds = $existingPolicies->pluck('document_policy_id')->toArray();

        // Identify missing document policy IDs
        $missingPolicyIds = array_diff($documentPolicyIds, $existingPolicyIds);

        // Create missing records with 'Not Implemented' status
        foreach ($missingPolicyIds as $policyId) {
            AuditDocumentPolicyStatus::create([
                'aduit_id' => $aduitId,
                'document_policy_id' => $policyId,
                'user_id' => $userId,
                'auditer_status' => 'Not Implemented',
            ]);
        }

        // Re-fetch existing policies to include newly created ones
        $existingPolicies = AuditDocumentPolicyStatus::where('aduit_id', $aduitId)
            ->whereIn('document_policy_id', $documentPolicyIds)
            ->where('user_id', $userId)
            ->get();

        // Initialize flags for each status type
        $hasImplemented = false;
        $hasNotImplemented = false;
        $hasPartiallyImplemented = false;
        $hasNotApplicable = false;
        // Loop through existing policies to check the statuses
        foreach ($existingPolicies as $policy) {
            switch ($policy->auditer_status) {
                case 'Implemented':
                    $hasImplemented = true;
                    break;
                case 'Not Implemented':
                    $hasNotImplemented = true;
                    break;
                case 'Partially Implemented':
                    $hasPartiallyImplemented = true;
                    break;
                case 'Not Applicable':
                    $hasNotApplicable = true;
                    break;
            }
        }
        // Determine the total status based on flags
        if ($hasImplemented && !$hasNotImplemented && !$hasPartiallyImplemented) {
            $totalStatus = 'Implemented';
        } elseif ($hasNotImplemented && !$hasImplemented && !$hasPartiallyImplemented) {
            $totalStatus = 'Not Implemented';
        } elseif ($hasPartiallyImplemented && !$hasImplemented && !$hasNotImplemented) {
            $totalStatus = 'Partially Implemented';
        } elseif ($hasNotApplicable && !$hasPartiallyImplemented && !$hasImplemented && !$hasNotImplemented) {
            $totalStatus = 'Not Applicable';
        } else {
            $totalStatus = 'Partially Implemented'; // Mixed statuses
        }

        // Use a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Create or update AuditDocumentTotalStatus entry
            $auditDocumentTotalStatus = AuditDocumentTotalStatus::updateOrCreate(
                [
                    'audit_id' => $aduitId,
                    'document_id' => $request->documentId,
                    'user_id' => $userId,
                ],
                [
                    'total_status' => $totalStatus,
                ]
            );

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json([
                'message' => 'Total status calculated successfully!',
                'data' => $auditDocumentTotalStatus,
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if something failed
            DB::rollBack();

            // Return an error response
            return response()->json([
                'message' => 'Error calculating total status: ' . $e->getMessage(),
            ], 500);
        }
    }













    public function NexDocPage(Request $request)
    {
        $page = max(1, $request->get('page', 1)); // Ensure page is at least 1
        $sidebarCategory = DocumentTypes::skip(5 * ($page - 1))->take(5)->get();
        $checkCount = $sidebarCategory->count();

        $data = '';
        foreach ($sidebarCategory as $item) {
            $data .= "<button class='list-group-item list-group-item-action tablinks sideNavBtn' id='item$item->id'>
                        <div class='mb-1'>$item->name</div>
                      </button>";
        }

        $lastPage = ceil(DocumentTypes::count() / 5);

        return [$data, $lastPage, $checkCount];
    }


    public function PrevDocPage(Request $request)
    {
        $sidebarCategory = DocumentTypes::skip(5 * ($request->page - 1))
            ->take(5)->get();
        $data = '';
        foreach ($sidebarCategory as $item) {
            $data .= "<button class='list-group-item list-group-item-action tablinks sideNavBtn' id='item$item->id'  style=' display: flex'>

                        <div class='mb-1'>

                           " . $item->name . "
                               </div>
                    </button>";
        }
        $lastPage = Framework::select('id', 'name', 'icon')->count();
        $lastPage = $lastPage > 0 ? $lastPage / 5 : 0;
        return [$data, round($lastPage)];
    }

    public function docDetails(Request $request)
    {
        $id = (int)substr($request->id, 4);

        $doc = DocumentTypes::find($id);

        // Put Doc id to be used on Datatables
        Session::put('doc_current_id_dtb', $id);

        $editUrl = route('admin.governance.category.update', $id);
        $addDocUrl = route('admin.governance.document.store', $id);

        $iconsArray = Helper::getIcons();
        $IconsSelect = "";
        foreach ($iconsArray as $icon) {
            if ($icon['key'] == $doc->icon) {
                $IconsSelect .= "   <option selected value='" . $icon['key'] . "'> " . $icon['value'] . "</option>";
            } else {
                $IconsSelect .= "   <option  value='" . $icon['key'] . "'> " . $icon['value'] . "</option>";
            }
        }

        $docName = $doc->name;
        $doctype = $doc->type_category;

        // Handle type_category value to show name instead of number
        $typeCategoryName = $this->getTypeCategoryName($doctype);
        // Generate type_category options with selected value
        $typeCategoryOptions = '';
        $typeCategories = [
            1 => __('locale.Standard'),
            2 => __('locale.Policy'),
            3 => __('locale.procedures'),
            4 => __('locale.Others')
        ];

        foreach ($typeCategories as $key => $value) {
            $selected = ($key == $doc->type_category) ? 'selected' : '';
            $typeCategoryOptions .= "<option value='$key' $selected> $value </option>";
        }
        return [
            $doc->name,
            $editUrl,
            $addDocUrl,
            $docName,
            $IconsSelect,
            $typeCategoryName, // Return the name instead of the number
            $typeCategoryOptions, // Return the options with selected category
        ];
    }

    // Method to map type_category number to name
    protected function getTypeCategoryName($typeCategory)
    {
        switch ($typeCategory) {
            case 1:
                return __('locale.Standard');
            case 2:
                return __('locale.Policy');
            case 3:
                return __('locale.procedures');
            case 4:
                return __('locale.Others');
            default:
                return __('locale.Unknown'); // Return a default value if no match
        }
    }


    public function deleteDoc(Request $request)
    {
        try {
            $doc = DocumentTypes::find($request->id);

            if ($doc) {
                // Check for related data
                $relatedData = $doc->hasRelations(); // Get relations with count

                if (!empty($relatedData)) {
                    $relatedMessages = [];
                    foreach ($relatedData as $relation => $count) {
                        // Format each relation with details
                        $relatedMessages[] = __('locale.RelationExists', [
                            'relation' => ucfirst($relation),
                            'count' => $count
                        ]);
                    }

                    // Return response indicating that deletion cannot proceed due to related data
                    $response = [
                        'status' => false,
                        'message' => __('locale.CannotDeleteDueToRelations') . "<br>" . implode('<br>', $relatedMessages),
                    ];

                    return response()->json($response, 400);
                }

                // If no related data, proceed with deletion
                $doc->delete();

                // Fire the CategoryDeleted event
                event(new CateogryDeleted($doc));

                // Return success response
                $response = [
                    'status' => true,
                    'message' => __('locale.DocumentDeletedSuccessfully'),
                ];
                return response()->json($response, 200);
            } else {
                // If the document is not found
                return response()->json([
                    'status' => false,
                    'message' => __('locale.Error404DocumentNotFound'),
                ], 404);
            }
        } catch (\Exception $e) {
            // Catch any exceptions and return an error response
            return response()->json([
                'status' => false,
                'message' => __('locale.Error') . ': ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Return a listing of the resource after some manipulation depending on current user
     * if is admin all data returned
     * else returned data will depending on vulnerability creator or current user team.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {

        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['document_name'],
            'relationships' => [],
            'other_global_filters' => ['creation_date'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            // 'assets:name',
            // 'teams:name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */


        $conditions = [];
        if (!auth()->user()->hasPermission('document.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                $ownedDocumentsIds =  Document::whereIn('document_owner', $departmentMembersIds)->pluck('id')->toarray();
                $reviewedDocumentsIds =  Document::whereIn('document_reviewer', $departmentMembersIds)->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toarray();
                if (!empty($departmentTeams)) {
                    $teamsDocumentsIds = Document::where(function ($query) use ($departmentTeams) {
                        foreach ($departmentTeams as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, team_ids)");
                        }
                    })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
                } else {
                    $teamsDocumentsIds = [];
                }
                $stakesDocumentsIds = Document::where(function ($query) use ($departmentMembersIds) {
                    foreach ($departmentMembersIds as $memberId) {
                        $query->orWhereRaw("FIND_IN_SET($memberId, additional_stakeholders)");
                    }
                })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
            } else {
                $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
                $ownedDocumentsIds =  Document::where('document_owner', auth()->id())->pluck('id')->toarray();
                $reviewedDocumentsIds =  Document::where('document_reviewer', auth()->id())->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toarray();
                if (!empty($loggedUserTeams)) {
                    $teamsDocumentsIds = Document::where(function ($query) use ($loggedUserTeams) {
                        foreach ($loggedUserTeams as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, team_ids)");
                        }
                    })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
                } else {
                    $teamsDocumentsIds = [];
                }

                $loggedUserId = auth()->id();
                $stakesDocumentsIds = Document::where(function ($query) use ($loggedUserId) {
                    $query->orWhereRaw("FIND_IN_SET($loggedUserId, additional_stakeholders)");
                })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
            }
            $publicDocuments = Document::where('privacy', 2)->where('document_status', 3)->pluck('id')->toarray();
            $documentsIds = array_unique(array_merge($ownedDocumentsIds, $reviewedDocumentsIds, $stakesDocumentsIds, $teamsDocumentsIds));
            $conditions = [
                'where' => [
                    'document_type' => $request->input('categoryId'),
                ],
                'whereIn' => [
                    'id' => $documentsIds,
                ],
            ];
        } else {
            $conditions = [
                'where' => [
                    'document_type' => $request->input('categoryId'),
                ]
            ];
        }
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            // 'assets:name',
            // 'teams:name'
        ];

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            Document::class,
            $dataTableDetails,
            $customFilterFields,
            $conditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'documents',
            [
                'id',
                'document_type',
                'privacy',
                'document_name',
                'parent',
                'document_status',
                'file_id',
                'creation_date',
                'last_review_date',
                'review_frequency',
                'next_review_date',
                'approval_date',
                'control_ids',
                'framework_ids',
                'document_owner',
                'document_reviewer',
                'created_by',
                'additional_stakeholders',
                'approver',
                'team_ids'
            ]
        );


        // Getting records with apply global search */
        $documents = getDatatableFilterRecords(
            Document::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $conditions
        );

        // Custom vulnerabilities response data as needs
        $data_arr = [];
        foreach ($documents as $document) {
            $frames = Framework::whereIn('id', explode(',', $document->framework_ids))->get();
            $frames_txt = '';
            foreach ($frames as $frame) {
                $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                    $frame->name . '</span>';
            }
            $framework_name =  $frames_txt;

            $frames = FrameworkControl::whereIn('id', explode(',', $document->control_ids))->get();
            $frames_txt = '';
            foreach ($frames as $frame) {
                $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                    $frame->short_name . '</span>';
            }
            $controls = $frames_txt;

            $statuses = [];
            $statuses[1] = "Draft";
            $statuses[2] = "InReview";
            $statuses[3] = "Approved";
            $status = $statuses[$document->document_status];

            $currentUserId = auth()->id();
            $returnedString = '';

            $returnedString .= '<a  href="javascript:;" onclick="showDocument(' . $document->id . ')"
            class="item-edit dropdown-item ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye me-50 font-small-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>' . __('locale.View') . '</a>';
            if (auth()->user()->hasPermission('document.download') && $document->file_id)
                $returnedString .= '<span class="tem-edit dropdown-item supporting_documentation"
                data-document-id="' . $document->id . '">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-download me-50 font-small-4">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                ' . __('locale.download') . '
            </span>';
            if ($currentUserId == $document->document_owner || auth()->user()->role_id == 1)
                $returnedString .= '<a  href="javascript:;" onclick="editDocument(' . $document->id . ')" class="item-edit dropdown-item "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>' . __('locale.Edit') . '</a>';
            if ($currentUserId == $document->document_owner || auth()->user()->role_id == 1)
                $returnedString .= '<a href="javascript:void(0);" onclick="logDocument(' . $document->id . ')" class="item-edit dropdown-item">' .
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text me-50 font-small-4">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>' .
                    __('locale.Logs') .
                    '</a>';

            // Policy (using a shield icon)
            if (auth()->user()->hasPermission('Document_Policy.create'))
                $returnedString .= '<a href="javascript:;" onclick="openAddPolicyModal(' . $document->id . ')" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield me-50 font-small-4">
                    <path d="M12 22s8-4.5 8-10V5l-8-3-8 3v7c0 5.5 8 10 8 10z"></path>
                </svg>' . __('locale.Policy') . '</a>';


            // Audit (using file-text icon for audit/document-like representation)
            if (auth()->user()->hasPermission('Aduit_Document_Policy.create'))
                $returnedString .= '<a href="javascript:;" onclick="openAddAuditPolicyModal(' . $document->id . ', ' . $document->document_type . ')" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text me-50 font-small-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <line x1="10" y1="9" x2="8" y2="9"></line>
                </svg>' . __('locale.Audit') . '</a>';
            if (auth()->user()->hasPermission('document.changeContent'))
                $returnedString .= '<a href="' . route('admin.governance.changeContent', ['id' => $document->id]) . '" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-edit me-50 font-small-4">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        ' . __('locale.Change Content') . '
                    </a>';
            if ($currentUserId == $document->document_owner || auth()->user()->role_id == 1)
                $returnedString .= '<a  href="javascript:;" onclick="deleteDocument(' . $document->id . ')" class="dropdown-item  btn-flat-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>' . __('locale.Delete') . '</a>';
            if ($returnedString == '') {
                $returnedString = '------';
                // return $returnedString;
            } else
                $returnedString = '<div class="d-inline-flex">
            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4" style="height: 20px !important;
            width: 40px !important;">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="12" cy="5" r="1"></circle>
            <circle cx="12" cy="19" r="1"></circle>
        </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-end">'
                    . $returnedString .
                    '</div>
            </div>';

            $data_arr[] = array(
                'id' =>  $document->id,
                'document_name' => $document->document_name,
                'framework_name' => $framework_name,
                'control' => $controls,
                'status' => $status,
                'approval_date' => $document->approval_date,
                'next_review_date' => $document->next_review_date,
                'creation_date' => $document->creation_date,
                'actions' => $returnedString
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    public function DocTable(Request $request)
    {

        if (request()->ajax()) {
            $currentUserId = auth()->id();
            return DataTables::of(Document::where('document_type', session('doc_current_id_dtb'))->where(function ($query)  use ($currentUserId) {
                // $this->getUserHaveAbilityToViewDocument($query, $currentUserId);
                $query->where('document_owner', '=', $currentUserId)
                    ->orWhere('created_by', '=', $currentUserId);
            })
                ->select('*'))

                ->addColumn('responsive_id', function ($item) {
                    return $item->id;
                })
                ->addColumn('framework_name', function ($item) {
                    $frames = Framework::whereIn('id', explode(',', $item->framework_ids))->get();
                    $frames_txt = '';
                    foreach ($frames as $frame) {
                        $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                            $frame->name . '</span>';
                    }
                    return $frames_txt;
                })
                ->addColumn('control', function ($item) {
                    $frames = FrameworkControl::whereIn('id', explode(',', $item->control_ids))->get();
                    $frames_txt = '';
                    foreach ($frames as $frame) {
                        $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                            $frame->short_name . '</span>';
                    }
                    return $frames_txt;
                })
                ->editColumn('status', function ($item) {
                    $statuses = [];
                    $statuses[1] = "Draft";
                    $statuses[2] = "InReview";
                    $statuses[3] = "Approved";
                    return $statuses[$item->document_status];
                })
                ->addColumn('actions', function ($item) {
                    $currentUserId = auth()->id();
                    $returnedString = '';

                    $returnedString .= '<a  href="javascript:;" onclick="showDocument(' . $item->id . ')"
                  class="item-edit dropdown-item ">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye me-50 font-small-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>View</a>';
                    if (auth()->user()->hasPermission('document.download'))
                        $returnedString .= '<span class="tem-edit dropdown-item supporting_documentation"
                    data-document-id="' . $item->id . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>download</span>';

                    if ($currentUserId == $item->document_owner)
                        $returnedString .= '<a  href="javascript:;" onclick="editDocument(' . $item->id . ')" class="item-edit dropdown-item "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>Edit</a>';
                    if ($currentUserId == $item->document_owner)
                        $returnedString .= '<a  href="javascript:;" onclick="deleteDocument(' . $item->id . ')" class="dropdown-item  btn-flat-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>Delete</a>';
                    if ($returnedString == '') {
                        $returnedString = '------';
                        return $returnedString;
                    } else
                        return '<div class="d-inline-flex">
                    <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                    :
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">'
                            . $returnedString .
                            '</div>
                    </div>';
                })
                ->rawColumns(['responsive_id', 'framework_name', 'control', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    protected function getUserHaveAbilityToViewDocument($document, $currentUserId)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($document->document_status == 3 /*Approved*/ && $document->privacy == 2 /*public*/) {
            return true;
        } else if (($document->document_status == 2 /*InReview*/) || ($document->document_privacy == 3 /*Approved*/ && $document->privacy == 1 /*private*/)) {
            if (
                $currentUserId == $document->document_reviewer // current user is reviewer
            ) {
                return true;
            }

            // Get users from stockholders
            $additionalStakeholders = explode(',', $document->additional_stakeholders);

            if (in_array($currentUserId, $additionalStakeholders)) {
                return true;
            }
            unset($additionalStakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $document->team_ids))->get();
            foreach ($teams as $team) {
                foreach ($team->users as $user) {
                    array_push($usersInTeams, $user->id);
                }
            }
            unset($teams);
            if (in_array($currentUserId, $usersInTeams)) {
                return true;
            }

            return false;
        }
    }


    public function notificationsSettingspolicyCenter()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Polices_Compliance')],
            ['link' => route('admin.governance.policyCenter'), 'name' => __('PolicyCenter')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [116, 117, 118];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            116 => ['Document_Name', 'Policy_clause', 'Document_Owner'],
            117 => ['Document_Name', 'Policy_clause', 'Document_Owner'],
            118 => ['Document_Name', 'Policy_clause', 'Document_Owner'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            116 => ['Document-Owner' => __('governance.DocumentOwner')],
            117 => ['Document-Owner' => __('governance.DocumentOwner')],
            118 => ['Document-Owner' => __('governance.DocumentOwner')],
        ];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
            ]);

        $actionsWithSettingsAuto = [];
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }

    public function notificationsSettingsAuditPolicy()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Polices_Compliance')],
            ['link' => route('admin.governance.Aduit.document.policy'), 'name' => __('Aduit Policy')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [119, 120, 106, 107, 108, 109, 110, 111];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [138, 139];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            119 => ['Document_Name', 'Policy_clause', 'Document_Owner', 'Auditer', 'Auditees', 'Start_Date', 'Due_Date', 'PeriodicalTime', 'Next_Intiate_Date'],
            120 =>  ['Document_Name', 'Policy_clause', 'Document_Owner', 'Auditer', 'Auditees', 'Start_Date', 'Due_Date', 'PeriodicalTime', 'Next_Intiate_Date'],
            106 =>  ['Document_Name', 'Document_Owner', 'Auditer', 'Auditee', 'Policy_clause', 'Comment'],
            107 =>  ['Document_Name', 'Document_Owner', 'Auditer', 'Auditee', 'Policy_clause', 'Status'],
            108 =>  ['Document_Name', 'Document_Owner', 'Auditer', 'Auditee', 'Policy_clause', 'Comment'],
            109 =>  ['Document_Name', 'Document_Owner', 'Auditer', 'Auditee', 'Policy_clause', 'Status'],
            110 =>  ['Document_Name', 'Document_Owner', 'Auditer', 'Auditee', 'Policy_clause', 'Status'],
            111 =>  ['Document_Name', 'Document_Owner', 'Auditer', 'Auditee', 'Policy_clause', 'Status'],
            138 => ['Document_Name', 'Policy_clause', 'Document_Owner', 'Auditer', 'Auditees', 'Start_Date', 'Due_Date', 'PeriodicalTime', 'Next_Intiate_Date'],
            139 => ['Document_Name', 'Policy_clause', 'Document_Owner', 'Auditer', 'Auditees', 'Start_Date', 'Due_Date', 'PeriodicalTime', 'Next_Intiate_Date'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            119 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            120 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            106 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            107 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            108 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            109 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            110 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            111 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            138 => ['Document-Owner' => __('governance.DocumentOwner'), 'Auditer' => __('locale.Auditer'), 'Auditees' => __('locale.Auditees')],
            139 => [],
        ];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
            ]);

        $actionsWithSettingsAuto = Action::whereIn('actions.id', $moduleActionsIdsAutoNotify)
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.policyCenter'), 'name' => __('locale.PolicyClause')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'policy_name_en', 'rules' => ['required'], 'example' => 'Policy Clause 1'],
            ['name' => 'policy_name_ar', 'rules' => ['required'], 'example' => 'البند الاول'],
            // Column: 'description'
            ['name' => 'document_ids', 'rules' => ['required'], 'example' => '...,أدوار ومسؤوليات الأمن السيبراني'],


        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.governance.policyClause.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }
    public function GetDataDocumentLogs(Request $request)
    {
        if ($request->ajax()) {
            $logs = AuditLog::with('user') // assuming a user() relationship exists
                ->where('risk_id', $request->id)
                ->whereIn('log_type', [
                    'Updating Document',
                    'Creating Document',
                    'Deleting Document',
                    'Document content updated',
                ])
                ->orderBy('timestamp', 'desc') // <-- sort newest first
                ->select('user_id', 'log_type', 'message', 'timestamp');

            return DataTables::of($logs)
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '—';
                })
                ->make(true);
        }
    }

    public function changeContent($id)
    {
        if (!auth()->user()->hasPermission('document.changeContent')) {
            abort(403, __('locale.YouDoNotHavePermissionToAccessThisPage'));
        }
        $document = Document::findOrFail($id); // Throws 404 if not found
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            ['name' => __('locale.DocumentationChangeContent')],
            ['name' =>  $document->document_name]

        ];
        return view('admin.content.governance.change-content', compact('document', 'breadcrumbs'));
    }
    public function changeContentDocument(Request $request)
    {
        if ($request->ajax()) {
            $documentId = $request->document_id;

            $query = DocumentContentChange::query()
                ->where('document_id', $documentId)
                ->select([
                    '*',
                    DB::raw("REPLACE(REPLACE(old_content, '&nbsp;', ' '), '<[^>]+>', '') as old_content"),
                    DB::raw("REPLACE(REPLACE(new_content, '&nbsp;', ' '), '<[^>]+>', '') as new_content")
                ])
                ->with('changedByUser');

            return DataTables::of($query)
                ->addColumn('file', function ($row) {
                    if ($row->file_path) {
                        $fileName = basename($row->file_path);
                        $downloadUrl = route('admin.governance.downloadFileDocumentcontent', ['id' => $row->id]);

                        return '<a href="' . $downloadUrl . '" download="' . $fileName . '" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download"></i>
                    </a>';
                    }
                    return '<span class="text-muted">No file</span>';
                })
                ->addColumn('actions', function ($row) {
                    $oldContent = is_string($row->old_content) ? htmlspecialchars($row->old_content, ENT_QUOTES) : '';
                    $newContent = is_string($row->new_content) ? htmlspecialchars($row->new_content, ENT_QUOTES) : '';

                    $dropdownItems = '';

                    if (auth()->user()->hasPermission('document.updateContent')) {
                        $dropdownItems .= '
                    <a class="dropdown-item edit-content d-flex align-items-center" 
                        data-id="' . $row->id . '" 
                        data-old-content="' . $oldContent . '"
                        data-new-content="' . $newContent . '"
                        data-file-path="' . ($row->file_path ?? '') . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Edit
                    </a>';
                    }

                    if (auth()->user()->hasPermission('document.deleteContent')) {
                        $dropdownItems .= '
                    <a class="dropdown-item delete-content d-flex align-items-center" data-id="' . $row->id . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m5 0V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                        Delete
                    </a>';
                    }

                    $dropdownItems .= '
                <a class="dropdown-item accept-content d-flex align-items-center" data-id="' . $row->id . '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle me-2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    Accept
                </a>';

                    return '
                <div class="dropdown">
                    <span class="cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="12" cy="5" r="1"></circle>
                            <circle cx="12" cy="19" r="1"></circle>
                        </svg>
                    </span>
                    <div class="dropdown-menu dropdown-menu-end shadow">'
                        . $dropdownItems .
                        '</div>
                </div>';
                })
                ->rawColumns(['file', 'actions'])
                ->make(true);
        }
    }

    public function creatDocumentContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_id' => 'required|exists:documents,id',
            'content' => 'required|string',
            'file' => 'nullable|file|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => __('locale.PleaseFixValidationErrors'),
            ], 422);
        }

        $document = Document::findOrFail($request->document_id);
        $oldContent = $document->content ?? '';
        $newContent = $request->input('content');

        $data = [
            'document_id' => $document->id,
            'old_content' => $oldContent,
            'new_content' => $newContent,
            'changed_by' => auth()->id(),
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('docs_content/' . $document->id, $fileName);
            $data['file_path'] = $filePath;
            $data['file_name'] = $fileName;
        }

        DocumentContentChange::create($data);

        event(new DocumentContentChangedCreated($document));

        return response()->json([
            'status' => true,
            'reload' => true,
            'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.PolicyClause')]),
        ]);
    }

    public function updateDocumentContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:document_content_changes,id',
            'new_content' => 'required|string',
            'file' => 'nullable|file|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => __('locale.PleaseFixValidationErrors'),
            ], 422);
        }

        try {
            $documentContent = DocumentContentChange::findOrFail($request->id);
            $document = Document::findOrFail($documentContent->document_id);

            $updateData = [
                'new_content' => $request->new_content,
                'old_content' => $document->content,
                'changed_by' => auth()->id(),
            ];

            // Handle file removal if requested
            if ($request->has('remove_file') && $documentContent->file_path) {
                Storage::delete($documentContent->file_path);
                $updateData['file_path'] = null;
                $updateData['file_name'] = null;
            }

            // Handle new file upload
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($documentContent->file_path) {
                    Storage::delete($documentContent->file_path);
                }

                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('docs_content/' . $document->id, $fileName);
                $updateData['file_path'] = $filePath;
                $updateData['file_name'] = $fileName;
            }

            $documentContent->update($updateData);
            event(new DocumentContentChangedUpdated($document));

            return response()->json([
                'status' => true,
                'reload' => true,
                'message' => __('locale.ItemWasUpdatedSuccessfully', ['item' => __('locale.DocumentContent')]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('locale.ErrorUpdatingItem', ['item' => __('locale.DocumentContent')]),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteDocumentContent(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:document_content_changes,id',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => __('locale.PleaseFixValidationErrors'),
            ], 422);
        }

        try {
            // Find the record
            $documentContent = DocumentContentChange::findOrFail($request->id);
            $document = Document::findOrFail($documentContent->document_id);
            if ($documentContent->file_path) {
                Storage::delete($documentContent->file_path);
            }
            // Delete the record
            $documentContent->delete();

            event(new DocumentContentChangedDeleted($document));

            return response()->json([
                'status' => true,
                'reload' => true,
                'message' => __('locale.ItemWasDeletedSuccessfully', ['item' => __('locale.DocumentContent')]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('locale.ErrorDeletingItem', ['item' => __('locale.DocumentContent')]),
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function acceptDocumentContent(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:document_content_changes,id',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => __('locale.PleaseFixValidationErrors'),
            ], 422);
        }

        try {
            // Find the record
            $documentContent = DocumentContentChange::findOrFail($request->id);
            $document = Document::findOrFail($documentContent->document_id);

            // Handle file if exists in the content change
            if ($documentContent->file_path) {
                $oldPath = $documentContent->file_path;
                $fileName = $documentContent->file_name;
                Storage::deleteDirectory('docs/' . $document->id);

                // Generate new path in the document's folder
                $newPath = 'docs/' . $document->id . '/' . $fileName;

                // Copy the file to the new location
                Storage::copy($oldPath, $newPath);

                if ($document->file_id) {
                    // Update the existing file record
                    $file = File::findOrFail($document->file_id);
                    $file->update([
                        'name' => $fileName,
                        'unique_name' => $newPath,
                    ]);
                } else {
                    Storage::deleteDirectory('docs/' . $document->id);
                    // Create new file record
                    $fileId = File::create([
                        'name' => $fileName,
                        'unique_name' => $newPath,
                    ]);
                    $document->update([
                        'file_id' => $fileId->id
                    ]);
                }
            }

            // Update the document content
            $document->update([
                'content' => $documentContent->new_content,
            ]);

            // Update the document content change record
            $documentContent->update([
                'status' => 'accepted',
                'changed_by' => auth()->id(),
            ]);

            // Strip HTML tags for cleaner comparison
            $oldContent = str_replace('&nbsp;', ' ', strip_tags($document->content));
            $newContent = str_replace('&nbsp;', ' ', strip_tags($documentContent->new_content));

            // Create a meaningful log message
            $logMessage = __('locale.DocumentContentChanged', [
                'user' => auth()->user()->name,
                'document' => $document->title,
                'old_content' => $oldContent,
                'new_content' => $newContent,
            ]);

            event(new DocumentContentChangedAccepted($document));

            // Write the log
            write_log($document->id, auth()->id(), $logMessage, 'Document content updated');

            return response()->json([
                'status' => true,
                'reload' => true,
                'message' => __('locale.DocumentContentUpdatedSuccessfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('locale.ErrorUpdatingDocumentContent'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function downloadFileDocumentcontent($id)
    {
        $contentChange = DocumentContentChange::findOrFail($id);

        if (!$contentChange->file_path) {
            abort(404);
        }

        // Get the full filesystem path
        $filePath = storage_path('app/' . $contentChange->file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Get the original filename
        $fileName = $contentChange->file_name ?? basename($contentChange->file_path);

        // Return the file as a download response
        return response()->download($filePath, $fileName);
    }
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
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Assets')])
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
                    'policy_name_en',
                    'policy_name_ar',
                    'document_ids',
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
                (new PolicyClauseImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In Policy Clause") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.PolicyClause')]),
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Assets')]),
                ];
                return response()->json($response, 502);
            }
        }
    }

    public function ajaxExportPolicyClause(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new PolicyClauseExport, 'policy clause.xlsx');
        else
            return 'policy clause.pdf';
    }

    public function auditDocumentPoliciesexport(Request $request)
    {
        $documentPolicyId = $request->input('document_policy_id');

        if ($request->type != 'pdf')
            return Excel::download(new AuditDocumentPolicyExport($documentPolicyId), 'Audit Policy.xlsx');
        else
            return 'Audit Policy.pdf';
    }

    public function importStatusAndCommentToAudit(Request $request)
    {
        $file = $request->file('file');
        if (!$file || !$file->isValid()) {
            return response()->json(['error' => 'Invalid file upload.'], 422);
        }

        $fileExtension = $file->getClientOriginalExtension();
        if (!in_array($fileExtension, ['xlsx', 'xls', 'csv'])) {
            return response()->json(['error' => 'Invalid file type. Please upload an Excel file.'], 422);
        }

        try {
            // Process the Excel file
            $import = new AuditDocumentPolicyStatusAndCommentsImport();
            $import->import($file);

            // Check for failures
            if ($import->getFailures()) {
                return response()->json([
                    'error' => 'Validation errors occurred.',
                    'failures' => $import->getFailures()
                ], 422);
            }

            return response()->json(['success' => 'File successfully imported and data saved!']);
        } catch (\Exception $e) {
            \Log::error('Import error: ' . $e->getMessage());
            return response()->json(['error' => 'Error importing file: ' . $e->getMessage()], 500);
        }
    }
}