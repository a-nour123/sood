<?php

namespace App\Http\Controllers\admin\security_awareness;

use App\Exports\SecurityAwarenessesExport;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DocumentNoteFile;
use App\Models\DocumentStatus;
use App\Models\File;
use App\Models\Job;
use App\Models\Privacy;
use App\Models\SecurityAwareness;
use App\Models\SecurityAwarenessNote;
use App\Models\SecurityAwarenessNoteFile;
use App\Models\Team;
use App\Models\User;
use App\Models\Action;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\SecurityAwarenesAdd;
use App\Events\SecurityAwarenesDeleted;
use App\Events\SecurityAwarenesUpdate;

class SecurityAwarenessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '<>', auth()->id())->select('id', 'name')->get();
        $teams = Team::select('id', 'name')->get();
        $statuses = DocumentStatus::all();
        $privacies = Privacy::all();

        $departmentManagersIds = Department::pluck('manager_id')->toArray();
        $owners = User::whereIn('id', $departmentManagersIds)->get();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $editOwners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $editOwners = User::whereIn('id', $departmentManagersIds)->get();
        }
        $breadcrumbs = [[
            'link' => route('admin.dashboard'),'name' => __('locale.Dashboard')],
             ['name' => __('locale.SecurityAwareness')]];

        return view(
            'admin.content.security_awareness.index',
            compact('breadcrumbs', 'users', 'teams', 'statuses', 'privacies', 'owners', 'editOwners')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => ['required', 'max:512', 'unique:security_awarenesses,title'],
            'description' => ['required', 'max:500'],
            'team_ids' => ['nullable', 'array'],
            'team_ids.*' => ['exists:teams,id'],
            'additional_stakeholders' => ['nullable', 'array'],
            'additional_stakeholders.*' => ['exists:users,id'],
            'status' => ['nullable', 'exists:document_statuses,id'],
            'file' => ['required', 'file', 'mimes:mp4,pdf'],
            'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
            'review_frequency' => ['required', 'integer'],
            'owner' => ['nullable', 'exists:users,id'],
        ];

        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($request->status == 2) {
            $rules['reviewer'] = ['required', 'exists:users,id'];
        } else {
            $rules['reviewer'] = ['nullable', 'exists:users,id'];
        }

        if ($request->status == 3) {
            $rules['privacy'] = ['required', 'exists:privacies,id'];
            $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
        } else {
            $rules['privacy'] = ['nullable', 'exists:privacies,id'];
            $rules['approval_date'] = ['nullable', 'date'];
        }

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwareness')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            $owner = null;
            if (auth()->user()->role_id == 1) { // current user is administrator
                $owner = $request->owner ?? auth()->id();
            } else {
                $owner = auth()->id();
            }

            $securityAwareness = null;
            try {
                $securityAwareness = SecurityAwareness::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'team_ids' => implode(',', $request->team_ids ?? []),
                    'additional_stakeholders' => implode(',', $request->additional_stakeholders ?? []),
                    'privacy' => $request->privacy,
                    'status' => $request->status ?? 1,
                    'last_review_date' => date('Y-m-d', strtotime($request->last_review_date)),
                    'review_frequency' => $request->review_frequency,
                    'next_review_date' => date(
                        'Y-m-d',
                        strtotime($request->last_review_date) + $request->review_frequency * 24 * 60 * 60
                    ),
                    'approval_date' => $request->approval_date,
                    'owner' => $owner,
                    'reviewer' => $request->reviewer,
                    'created_by' => auth()->id(),
                    'opened' => $request->opened ?? 0,
                ]);

                if ($request->hasFile('file')) {
                    $fileId = null;
                    /////////////////
                    if ($request->file('file')->isValid()) {
                        $path = $request->file('file')->store('security_awareness/' . $securityAwareness->id);
                        $fileId = File::create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'unique_name' => $path
                        ]);
                    } else {
                        Storage::deleteDirectory('security_awareness/' . $securityAwareness->id);
                        $response = array(
                            'status' => false,
                            'errors' => ['file' => ['There were problems uploading the files']],
                            'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwareness')
                                . "<br>" . __('locale.Validation error'),
                        );
                    }

                    $securityAwareness->update([
                        'file_id' => $fileId->id
                    ]);
                }

                DB::commit();
                event(new SecurityAwarenesAdd($securityAwareness));
                $message = __('securityAwareness.A New Security Awareness Added by name') . ' "' . ($securityAwareness->title ?? __('locale.[No Name]')) . '" ' . __('securityAwareness.and the Description of it is') . ' "' . ($securityAwareness->description ?? __('locale.[No Description]')) . '". ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($securityAwareness->id, auth()->id(), $message, 'Creating securityAwareness');
                $response = array(
                    'status' => true,
                    'message' => __('securityAwareness.SecurityAwarenessWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
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
        $securityAwarenesses = SecurityAwareness::find($id);

        if ($securityAwarenesses) {
            $data['id'] = $securityAwarenesses->id;
            $data['title'] = $securityAwarenesses->title;
            $data['description'] = $securityAwarenesses->description;
            $data['teams'] = Team::whereIn(
                'id',
                ($securityAwarenesses->team_ids) ? explode(',', $securityAwarenesses->team_ids) : []
            )->pluck('name')->toArray();
            $data['additional_stakeholders'] = User::whereIn(
                'id',
                ($securityAwarenesses->additional_stakeholders) ? explode(
                    ',',
                    $securityAwarenesses->additional_stakeholders
                ) : []
            )->pluck('name')->toArray();
            $data['privacy'] = $securityAwarenesses->Privacy->title ?? '';
            $data['status'] = $securityAwarenesses->status;
            $data['file_id'] = $securityAwarenesses->file_id;
            $data['last_review_date'] = $securityAwarenesses->last_review_date;
            $data['review_frequency'] = $securityAwarenesses->review_frequency;
            $data['next_review_date'] = $securityAwarenesses->next_review_date;
            $data['approval_date'] = $securityAwarenesses->approval_date;
            $data['owner'] = User::where('id', $securityAwarenesses->owner)->pluck('name')->first();
            $data['reviewer'] = User::where('id', $securityAwarenesses->reviewer)->pluck('name')->first() ?? '';
            $data['opened'] = $securityAwarenesses->opened;

            $notes = $securityAwarenesses->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $securityAwarenesses->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);

            $response = array(
                'status' => true,
                // 'data' => $data,
                'data' => mb_convert_encoding($data, "UTF-8", "auto")
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Get specified resource data for previewing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxPreview($id)
    {
        $currentUserId = auth()->id();
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness) {

            try {
                $file = $securityAwareness->file;

                $exists = Storage::disk('local')->exists('public/' . $file->unique_name ?? '');

                if (!$exists) {
                    Storage::copy($file->unique_name, 'public/' . $file->unique_name);
                }

                $data['title'] = $securityAwareness->title;
                $file = $securityAwareness->file;
                $data['file_name'] = $file->name;
                $data['file_extension'] = pathinfo($file->name, PATHINFO_EXTENSION);
                $data['file_path'] = asset('storage/' . $file->unique_name);
                $data['banner_path'] = pathinfo($file->name, PATHINFO_EXTENSION) == 'pdf' ?
                    null : asset('images/banner/security_awareness/banner-1.jpeg');
                $data['takeExam'] = (!is_null($securityAwareness->exam) &&
                    ($currentUserId != $securityAwareness->owner) &&
                    $securityAwareness->status == 3 /*Approved*/  &&
                    !$securityAwareness->exam->answers()->where('examinee', auth()->id())->exists()
                ) ? true : false;
                $data['showExamResult'] = (!is_null($securityAwareness->exam) &&
                    ($currentUserId != $securityAwareness->owner) &&
                    $securityAwareness->status == 3 /*Approved*/ &&
                    $securityAwareness->exam->answers()->where('examinee', auth()->id())->exists()
                ) ? true : false;

                $response = array(
                    'status' => true,
                    // 'data' => $data,
                    'data' => $data
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                $response = array(
                    'status' => false,
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
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
     * Get for edit the specified resource in storage.
     *
     *  * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetEdit(Request $request, $id)
    {
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness->owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness) {
            $data['id'] = $securityAwareness->id;
            $data['title'] = $securityAwareness->title;
            $data['description'] = $securityAwareness->description;
            $data['team_ids'] = ($securityAwareness->team_ids) ? explode(',', $securityAwareness->team_ids) : [];
            $data['additional_stakeholders'] = ($securityAwareness->additional_stakeholders) ? explode(
                ',',
                $securityAwareness->additional_stakeholders
            ) : [];
            $data['privacy'] = $securityAwareness->privacy;
            $data['status'] = $securityAwareness->status;
            $data['file_id'] = $securityAwareness->file_id;
            $data['last_review_date'] = $securityAwareness->last_review_date;
            $data['review_frequency'] = $securityAwareness->review_frequency;
            $data['next_review_date'] = $securityAwareness->next_review_date;
            $data['approval_date'] = $securityAwareness->approval_date;
            $data['owner'] = $securityAwareness->owner;
            $data['reviewer'] = $securityAwareness->reviewer;
            $data['opened'] = $securityAwareness->opened ? true : false;

            $notes = $securityAwareness->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $securityAwareness->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);

            $response = array(
                'status' => true,
                // 'data' => $data,
                'data' => mb_convert_encoding($data, "UTF-8", "auto")
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
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
        // to get the old result to use it in write log
        $securityAwarenessoldData = SecurityAwareness::find($id);
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness->owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness) {
            $rules = [
                'title' => ['required', 'max:512', 'unique:security_awarenesses,title,' . $securityAwareness->id],
                'description' => ['required', 'max:500'],
                'team_ids' => ['nullable', 'array'],
                'team_ids.*' => ['exists:teams,id'],
                'additional_stakeholders' => ['nullable', 'array'],
                'additional_stakeholders.*' => ['exists:users,id'],
                'status' => ['nullable', 'exists:document_statuses,id'],
                'file' => ['nullable', 'file'],
                'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
                'review_frequency' => ['required', 'integer'],
                'owner' => ['nullable', 'exists:users,id'],
            ];

            // [1 => Draft],[2=> InReview, [3 => Approved]
            if ($request->status == 2) {
                $rules['reviewer'] = ['required', 'exists:users,id'];
            } else {
                $rules['reviewer'] = ['nullable', 'exists:users,id'];
            }

            if ($request->status == 3) {
                $rules['privacy'] = ['required', 'exists:privacies,id'];
                $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
            } else {
                $rules['privacy'] = ['nullable', 'exists:privacies,id'];
                $rules['approval_date'] = ['nullable', 'date'];
            }

            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('securityAwareness.ThereWasAProblemUpdatingTheSecurityAwareness')
                        . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                $uploadfilePath = null;

                try {
                    $securityAwareness->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'team_ids' => implode(',', $request->team_ids ?? []),
                        'additional_stakeholders' => implode(',', $request->additional_stakeholders ?? []),
                        'privacy' => $request->privacy,
                        'status' => $request->status ?? 1,
                        // 'file_id' => $request->file_id,
                        'last_review_date' => date('Y-m-d', strtotime($request->last_review_date)),
                        'review_frequency' => $request->review_frequency,
                        'next_review_date' => date(
                            'Y-m-d',
                            strtotime($request->last_review_date) + $request->review_frequency * 24 * 60 * 60
                        ),
                        'approval_date' => $request->approval_date,
                        'reviewer' => $request->reviewer,
                        'opened' => $request->opened ?? 0
                    ]);

                    // File upload Start
                    if ($request->hasFile('file')) {
                        if ($request->file('file')->isValid()) {
                            // Get old file path to delete
                            
                            $oldFileUniqueName = $securityAwareness->file->unique_name;

                            // Upload New file
                            $path = $request->file('file')->store('security_awareness/' . $securityAwareness->id);
                            $uploadfilePath = $path;

                            // Update New file data
                            $securityAwareness->file()->update([
                                'name' => $request->file->getClientOriginalName(),
                                'unique_name' => $path
                            ]);

                            // Delete old file
                            if ($oldFileUniqueName) {
                                Storage::delete($oldFileUniqueName);
                            }
                        } else {
                            DB::rollBack();
                            if ($uploadfilePath)
                                Storage::delete($uploadfilePath);

                            $response = array(
                                'status' => false,
                                'errors' => ['file' => ['There were problems uploading the files']],
                                'message' => __('securityAwareness.ThereWasAProblemUpdatingTheDocument')
                                    . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                    // File upload End

                    DB::commit();
                    event(new SecurityAwarenesUpdate($securityAwareness));


                    $response = array(
                        'status' => true,
                        'message' => __('securityAwareness.SecurityAwarenessWasUpdatedSuccessfully'),
                    );
                    if (
                        ($securityAwarenessoldData->title ?? null) != ($securityAwareness->title ?? null) &&
                        ($securityAwarenessoldData->description ?? null) != ($securityAwareness->description ?? null)
                    ) {
                        $message = __('securityAwareness.A security Awareness that name is') . ' "' . ($securityAwarenessoldData->title ?? __('locale.[No Name]')) . '" ' .
                            __('securityAwareness.changed to') . ' "' . ($securityAwareness->title ?? __('locale.[No Name]')) . '". ' .
                            __('securityAwareness.And the description changed from') . ' "' . ($securityAwarenessoldData->description ?? __('locale.[No Description]')) . '" ' .
                            __('securityAwareness.to') . ' "' . ($securityAwareness->description ?? __('locale.[No Description]')) . '". ' .
                            __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    } elseif (($securityAwarenessoldData->title ?? null) != ($securityAwareness->title ?? null)) {
                        $message = __('securityAwareness.A security Awareness that name is') . ' "' . ($securityAwarenessoldData->title ?? __('locale.[No Name]')) . '" ' .
                            __('securityAwareness.changed to') . ' "' . ($securityAwareness->title ?? __('locale.[No Name]')) . '". ' .
                            __('securityAwareness.Which the description of it') . ' "' . ($securityAwarenessoldData->description ?? __('locale.[No Description]')) . '". ' .
                            __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    } elseif (($securityAwarenessoldData->description ?? null) != ($securityAwareness->description ?? null)) {
                        $message = __('securityAwareness.A security Awareness that name is') . ' "' . ($securityAwarenessoldData->title ?? __('locale.[No Name]')) . '" ' .
                            __('securityAwareness.The Description Changed from') . ' "' . ($securityAwarenessoldData->description ?? __('locale.[No Description]')) . '" ' .
                            __('locale.to') . ' "' . ($securityAwareness->description ?? __('locale.[No Description]')) . '". ' .
                            __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    } else {
                        $message = __('securityAwareness.A security Awareness that name is') . ' "' . ($securityAwarenessoldData->title ?? __('locale.[No Name]')) . '" ' .
                            __('securityAwareness.That Description of it is') . ' "' . ($securityAwarenessoldData->description ?? __('locale.[No Description]')) . '". ' .
                            __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    }


                    write_log($securityAwareness->id, auth()->id(), $message, 'Updating securityAwareness');

                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    Storage::delete($uploadfilePath);
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage()
                        'message' => __('locale.Error'),
                    );
                    return response()->json($response, 502);
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
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness->owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness) {
            DB::beginTransaction();
            $securityAwarenessId = $securityAwareness->id;
            try {
                // Remove file
                File::where('id', $securityAwareness->file_id)->delete();

                // Remove the security awareness
                $securityAwareness->delete();

                Storage::deleteDirectory('security_awareness/' . $securityAwarenessId);
                DB::commit();
                event(new SecurityAwarenesDeleted($securityAwareness));
                $message = __('securityAwareness.A security Awareness with name') . ' "' . ($securityAwarenessId->name ?? __('locale.[No Name]')) . '" ' .
                    __('securityAwareness.and the Description of it is') . ' "' . ($securityAwarenessId->description ?? __('locale.[No Description]')) . '" ' .
                    __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log(1, auth()->id(), $message, 'deleting security Awareness');

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('securityAwareness.SecurityAwarenessWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('securityAwareness.ThereWasAProblemDeletingTheSecurityAwareness')
                        . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('securityAwareness.ThereWasAProblemDeletingTheSecurityAwareness');
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
        $currentUserId = auth()->id();
        $statuses = [];
        $statuses[1] = "Draft";
        $statuses[2] = "InReview";
        $statuses[3] = "Approved";

        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['title', 'description', 'status'],
            'relationships' => [],
            'other_global_filters' => ['created_at'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'exam'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        $conditions = [];
        // if (!auth()->user()->hasPermission('security-awareness.all')) {
        //     if(isDepartmentManager()){
        //         $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
        //         $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        //         $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
        //          $awarenessesIds = SecurityAwareness::whereIn('control_owner', $departmentMembersIds)->pluck('id')->toArray();
        //     $testControlsIds =  FrameworkControlTest::whereIn('tester', $departmentMembersIds)->pluck('framework_control_id')->toarray();
        //     $departmentTeams = [];
        //     foreach($departmentMembers as $departmentMember){
        //         $departmentTeams = array_merge($departmentTeams,$departmentMember->teams->pluck('id')->toArray());
        //     }
        //     $objectivesControlsIds =  ControlControlObjective::whereIn('responsible_id', $departmentMembersIds)->orWhereIn('responsible_team_id',$departmentTeams)->pluck('control_id')->toarray();
        //     $controlsIds = array_unique(array_merge($ownedControlsIds,$testControlsIds,$objectivesControlsIds));
        //     } else{
        //     $ownedControlsIds = FrameworkControl::where('control_owner', auth()->id())->pluck('id')->toArray();
        //     $testControlsIds =  FrameworkControlTest::where('tester', auth()->id())->pluck('framework_control_id')->toarray();
        //     $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
        //     $objectivesControlsIds =  ControlControlObjective::where('responsible_id', auth()->id())->orWhereIn('responsible_team_id',$loggedUserTeams)->pluck('control_id')->toarray();
        //     $controlsIds = array_unique(array_merge($ownedControlsIds,$testControlsIds,$objectivesControlsIds));
        // }
        // $customConditions['whereIn']['id'] =  $controlsIds;
        // }

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            SecurityAwareness::class,
            $dataTableDetails,
            $customFilterFields,
            $conditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'security_awarenesses',
            [
                'id',
                'title',
                'description',
                'status',
                'privacy',
                'owner',
                'status',
                'created_at',
                'opened',
                'created_by',
                'reviewer',
                'team_ids',
                'additional_stakeholders'
            ]
        );

        // Getting records with apply global search */
        $securityAwarenesses = getDatatableFilterRecords(
            SecurityAwareness::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $conditions
        );

        // Filter if current user is adminstator, owner, creator or has ability to view security awarenesses depending on security awarenesses status and privacy
        if (!auth()->user()->hasPermission('security-awareness.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $securityAwarenesses = $securityAwarenesses->filter(function ($securityAwareness) use ($departmentMembersIds) {
                    foreach ($departmentMembersIds as $departmentmemberId) {
                        if (($departmentmemberId == $securityAwareness->owner) ||
                            ($departmentmemberId == $securityAwareness->created_by && $securityAwareness->opened) ||
                            ($this->getUserHaveAbilityToViewSecurityAwareness(
                                $securityAwareness,
                                $departmentmemberId
                            ) && $securityAwareness->opened)
                        ) {
                            return true;
                        }
                    }
                    return false;
                })->values();
            } else {
                $securityAwarenesses = $securityAwarenesses->filter(function ($securityAwareness) use ($currentUserId) {
                    return ($currentUserId == $securityAwareness->owner) ||
                        ($currentUserId == $securityAwareness->created_by && $securityAwareness->opened) ||
                        ($this->getUserHaveAbilityToViewSecurityAwareness(
                            $securityAwareness,
                            $currentUserId
                        ) && $securityAwareness->opened);
                })->values();
            }
        }

        // Custom securityAwarenesses response data as needs
        $data_arr = [];
        foreach ($securityAwarenesses as $securityAwareness) {
            $data_arr[] = array(
                'responsive_id' =>  $securityAwareness->id,
                'title' => $securityAwareness->title,
                'description' => $securityAwareness->description,
                'status' => $statuses[$securityAwareness->status] .
                    ($securityAwareness->status == 3 ? ($securityAwareness->Privacy ? " (" . $securityAwareness->Privacy->title . ")" ?? '' : '') : ''),
                'created_at' => $securityAwareness->created_at->format('Y-m-d H:i'),
                'deletable' => ($currentUserId == $securityAwareness->owner) ? true : false,
                'editable' => ($currentUserId == $securityAwareness->owner) ? true : false,
                'createExam' => (is_null($securityAwareness->exam) && ($currentUserId == $securityAwareness->owner)
                ) ? true : false,
                'showExam' => (!is_null($securityAwareness->exam) && ($currentUserId == $securityAwareness->owner)
                ) ? true : false,
                'takeExam' => (!is_null($securityAwareness->exam) &&
                    ($currentUserId != $securityAwareness->owner) &&
                    $securityAwareness->status == 3 /*Approved*/  &&
                    !$securityAwareness->exam->answers()->where('examinee', auth()->id())->exists()
                ) ? true : false,
                'showExamResult' => (!is_null($securityAwareness->exam) &&
                    ($currentUserId != $securityAwareness->owner) &&
                    $securityAwareness->status == 3 /*Approved*/ &&
                    $securityAwareness->exam->answers()->where('examinee', auth()->id())->exists()
                ) ? true : false,
                'generateUrl' => ($currentUserId == $securityAwareness->owner  &&
                $securityAwareness->status == 3 &&  $securityAwareness->privacy == 2 /*Approved*/) ? true : false,
                'Actions' => $securityAwareness->id
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(
            intval($dataTableDetails['draw']),
            $totalRecords,
            $totalRecordswithFilter,
            $data_arr
        );

        return response()->json($response, 200);
    }

    //note
    public function send_note(Request $request)
    {
        $rules = [
            'security_awareness_id' => ['required', 'exists:security_awarenesses,id'],
            'note' => ['required', 'string'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwarenessNote')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {
                $note = SecurityAwarenessNote::create([
                    'user_id' => auth()->id(),
                    'security_awareness_id' => $request->security_awareness_id,
                    'note' => $request->note,
                ]);

                $note = SecurityAwarenessNote::find($note->id);

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' => __('securityAwareness.SecurityAwarenessNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $note,
                        'security_awareness' => $note->security_awareness
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function send_note_file(Request $request)
    {
        $rules = [
            'note_file' => ['file'],
            'security_awareness_id' => ['required', 'exists:security_awarenesses,id'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwarenessNote')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {

                $fileName = '';
                $path = '';
                // File upload Start
                if ($request->hasFile('note_file')) {
                    $note_file = $request->file('note_file');
                    $path = '';
                    if ($note_file->isValid()) {
                        $path = $note_file->store('security_awareness/' . $request->security_awareness_id . '/notes');
                        $fileName = pathinfo($note_file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                    } else {
                        if ($path)
                            Storage::delete($path);
                        $response = array(
                            'status' => false,
                            'errors' => ['note_file' => ['There were problems uploading the files']],
                            'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwarenessNote')
                                . "<br>" . __('locale.Validation error'),
                        );

                        return response()->json($response, 422);
                    }
                }

                $securityAwarenessNoteFile = SecurityAwarenessNoteFile::create([
                    'user_id' => auth()->id(),
                    'security_awareness_id' => $request->security_awareness_id,
                    'display_name' => $fileName,
                    'unique_name' => $path
                ]);
                // File upload End

                DB::commit();
                $securityAwarenessNoteFile = SecurityAwarenessNoteFile::find($securityAwarenessNoteFile->id);

                $response = array(
                    'status' => true,
                    'message' => __('securityAwareness.SecurityAwarenessNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $securityAwarenessNoteFile,
                        'security_awareness' => $securityAwarenessNoteFile->security_awareness
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                if ($path)
                    Storage::delete($path);
                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    public function downloadNoteFile(Request $request)
    {
        $file = SecurityAwareness::where('id', $request->security_awareness_id)->first()->note_files()->where('id', $request->id)->first() ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name);
        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->display_name);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $file = SecurityAwareness::where('id', $request->security_awareness_id)->first()->file ?? null;

        $exists = Storage::disk('local')->exists($file->unique_name ?? '');

        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->name);
        } else {
            return redirect()->route('admin.security_awareness.index');
        }
    }

    /**
     * Download the specified resource from storage to preview.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fileToPreview(Request $request)
    {
        $file = SecurityAwareness::where('id', $request->security_awareness_id)->first()->file ?? null;

        $exists = Storage::disk('local')->exists($file->unique_name ?? '');

        File::link($file, public_path('temp/security_awareness'));
    }

    protected function getUserHaveAbilityToViewSecurityAwareness($securityAwareness, $currentUserId)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($securityAwareness->status == 3 /*Approved*/ && $securityAwareness->privacy == 2 /*public*/) {
            return true;
        } else if (
            ($securityAwareness->status == 2 /*InReview*/) ||
            ($securityAwareness->status == 3 /*Approved*/ && $securityAwareness->privacy == 1 /*private*/)
        ) {
            if (
                $currentUserId == $securityAwareness->reviewer // current user is reviewer
            ) {
                return true;
            }

            // Get users from stockholders
            $additionalStakeholders = explode(',', $securityAwareness->additional_stakeholders);

            if (in_array($currentUserId, $additionalStakeholders)) {
                return true;
            }
            unset($additionalStakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $securityAwareness->team_ids))->get();
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

    public function removeTempFile($securityAwareness_id)
    {
        return Storage::deleteDirectory('public/security_awareness/' . $securityAwareness_id);
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
            return Excel::download(new SecurityAwarenessesExport, 'Security_awarenesses.xlsx');
        else
            return 'Security_awarenesses.pdf';
    }

    public function notificationsSettings()
    {

        //defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.security_awareness.index'), 'name' => __('locale.SecurityAwareness')],
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [7, 8, 9];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [71];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            7 => ['Title', 'Created_By', 'Description', 'Additional_Stakeholders', 'Status', 'Teams'],
            8 => ['Title', 'Created_By', 'Description', 'Additional_Stakeholders', 'Status', 'Teams', 'Reviewer'],
            9 => ['Title', 'Created_By', 'Description', 'Additional_Stakeholders', 'Status', 'Teams', 'Reviewer'],
            71 => ['Title', 'Created_By', 'Description', 'Additional_Stakeholders', 'Status', 'Teams', 'Reviewer','Next_Review_Date'],

        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            7 => ['creator' => __('locale.SecurtyAwarenessCreator'), 'Team-teams' => __('locale.TeamsOfSecurtyAwareness'), 'Stakeholder-teams' => __('locale.StakeholdersOfSecurtyAwareness')],
            8 => ['creator' => __('locale.SecurtyAwarenessCreator'), 'Team-teams' => __('locale.TeamsOfSecurtyAwareness'), 'Stakeholder-teams' => __('locale.StakeholdersOfSecurtyAwareness'), 'reviewers-teams' => __('locale.ReviewersOfSecurtyAwareness')],
            9 => ['creator' => __('locale.SecurtyAwarenessCreator'), 'Team-teams' => __('locale.TeamsOfSecurtyAwareness'), 'Stakeholder-teams' => __('locale.StakeholdersOfSecurtyAwareness'), 'reviewers-teams' => __('locale.ReviewersOfSecurtyAwareness')],
            71 => ['creator' => __('locale.SecurtyAwarenessCreator'), 'Team-teams' => __('locale.TeamsOfSecurtyAwareness'), 'Stakeholder-teams' => __('locale.StakeholdersOfSecurtyAwareness'), 'reviewers-teams' => __('locale.ReviewersOfSecurtyAwareness')],
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
}
