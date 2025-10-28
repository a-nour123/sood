<?php

namespace App\Http\Controllers\admin\assessment;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\ContactQuestionnaireAnswer;
use App\Models\File;
use App\Models\FrameworkControl;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Questionnaire;
use App\Models\QuestionnaireRisk;
use App\Models\Risk;
use App\Models\RiskToAdditionalStakeholder;
use App\Models\RiskToLocation;
use App\Models\RiskToTeam;
use App\Models\RiskToTechnology;
use App\Models\ScoringMethod;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use App\Traits\AssetTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuestionnaireResultController extends Controller
{
    use AssetTrait;
    public function index()
    {
        if (!auth()->user()->hasPermission('assessmentResult.list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.content.assessment.questionnaire_results.index');
    }

    public function data()
    {
        $results = ContactQuestionnaireAnswer::query()->with(['contact', 'questionnaire'])
            ->select(
                [
                    'contact_questionnaire_answers.id', 'contact_questionnaire_answers.status', 'contact_questionnaire_answers.percentage_complete', 'contact_questionnaire_answers.created_at', 'contact_questionnaire_answers.contact_id', 'contact_questionnaire_answers.questionnaire_id', 'contact_questionnaire_answers.approved_status',
                    DB::raw("(
                    CASE
                        WHEN approved_status='no' THEN 'No'
                        WHEN approved_status='yes' THEN 'Yes'
                    END

                    ) as approved_status "
                    )
                ]
            );


            return DataTables::eloquent($results)
            ->addIndexColumn()
            ->addColumn('name', function ($raw) {
                // Use regular PHP condition here
                if (auth()->user()->hasPermission('assessmentResult.assessmentResult')) {
                    return '<a href="' . route('admin.questionnaire-results.view', encrypt($raw->id)) . '">' . $raw->questionnaire->name . '</a>';
                } else {
                    return $raw->questionnaire->name;
                }
            })
            ->skipTotalRecords()
            ->rawColumns(['name'])
            ->toJson();

    }

    public function show($id)
    {
        try {
            $id = decrypt($id);
            $questionnaireAnswers = ContactQuestionnaireAnswer::query()->with(['contact', 'results.answer', 'results.question.answers', 'asset'])->findOrFail($id);
            $questionnaire = Questionnaire::query()->where('id', $questionnaireAnswers->questionnaire_id)->with('assessment.questions.answers', 'pendingRisks', 'rejectedRisks', 'addedRisks')->first();
            $risk_Questioneres=Risk::where('questionnaire_id',$id)->get();

            $data['likelihoods'] = Likelihood::query()->select(['id', 'name'])->get();
            $data['impacts'] = Impact::query()->select(['id', 'name'])->get();
            $data['enabledUsers'] = User::query()->where('enabled', true)->get();
            $data['assetGroups'] = AssetGroup::all();
            $data['assets'] = Asset::select('id', 'name')->orderBy('id')->get();
            $data['tags'] = Tag::all();
            $data['migration_controls'] = FrameworkControl::query()->get(['id', 'short_name as name']);
            $data['riskScoringMethods'] = ScoringMethod::all();


            return view('admin.content.assessment.questionnaire_results.show', compact('questionnaireAnswers', 'questionnaire', 'data','risk_Questioneres','id'));

        } catch (\Exception $exception) {
            abort(403);
        }
    }

    public function changeStatus($id, $status = null)
    {
        $result = ContactQuestionnaireAnswer::query()->findOrFail($id);
        if ($result) {
            $result->update(['approved_status' => $status]);
        }

        return redirect()->back();

    }

    public function changeRiskStatus(Request $request)
    {
        $questionnaire_risk = QuestionnaireRisk::query()->findOrFail($request->questionnaire_risk_id);
        if ($request->action_type == 'reject_risk') {
            $questionnaire_risk->update([
                'status' => 'rejected'
            ]);
            
            $response = [
                'status' => true,
                'alert' => false, // Set this to true if you want to show an alert for rejection
                'message' => __('locale.RiskRejectedSuccess', ["subject" => $request->subject]),
            ];

            return response()->json($response);
         }



        $risk = [];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'risk_subject' => ['required'],
            'reference_id' => ['nullable', 'max:20'],
            'framework_id' => ['nullable', 'exists:frameworks,id'],
            'control_id' => ['nullable', 'exists:framework_controls,id'],
            'location_id' => ['nullable', 'array'],
            'location_id.*' => ['exists:locations,id'],
            'assets_ids' => ['nullable', 'array'],
            'assets_ids.*' => ['exists:assets,id'],
            'risk_source_id' => ['nullable', 'exists:sources,id'],
            'risk_scoring_method_id' => ['nullable', 'exists:scoring_methods,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'owner_id' => ['nullable', 'exists:users,id'],
            'owner_manager_id' => ['nullable', 'exists:users,id'],
            'assessment' => ['nullable'],
            'notes' => ['nullable'],
            'review_date' => ['nullable'],
            'mitigation_id' => ['nullable', 'exists:mitigations,id'],
            'mgmt_review' => ['nullable'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'close_id' => ['nullable'],
            'risk_catalog_mapping_id' => ['nullable', 'array'],
            'risk_catalog_mapping_id.*' => ['exists:risk_catalogs,id'],
            'threat_catalog_mapping_id' => ['nullable', 'array'],
            'threat_catalog_mapping_id.*' => ['exists:threat_catalogs,id'],
            'template_group_id' => ['nullable'],
            'tags_ids' => ['nullable', 'array'],
            'tags_ids.*' => ['exists:tags,id'],
            'team_id' => ['nullable', 'array'],
            'team_id.*' => ['exists:teams,id'],
            'technology_id' => ['nullable', 'exists:technologies,id'],
            'additional_stakeholder_id' => ['nullable', 'array'],
            'additional_stakeholder_id.*' => ['exists:users,id'],
            'current_likelihood_id' => ['nullable', 'exists:likelihoods,id'],
            'current_impact_id' => ['nullable', 'exists:impacts,id'],
            'risk_assessment' => ['nullable', 'string'],
            'additional_notes' => ['nullable', 'string'],
            'supporting_documentation' => ['nullable', 'array'],
            'supporting_documentation.*' => ['nullable', 'file'],
            'questionnaire_id' => ['nullable'],
        ]);


        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
           
            // Limit the subject's length
            $alert = false;
            $maxlength = Setting::where('name', 'maximum_risk_subject_length')->first()['value'];
            if (strlen($request->subject) > $maxlength) {
                $alert = __('locale.RiskSubjectTruncated', ['limit' => $maxlength]);
                $request->subject = substr($request->subject, 0, $maxlength);
            }
            DB::beginTransaction();
            try {
                 // Start submitting basic risk data
                $risk = Risk::create([
                    'status' => 'New',
                    'subject' => $request->risk_subject,
                    'questionnaire_id' => $request->ass_id,
                    'reference_id' => $request->reference_id,
                    'regulation' => $request->framework_id,
                    'control_id' => $request->framework_controls_ids, // control_number
                    'source_id' => $request->risk_scoring_method_id,
                    'category_id' => $request->category_id,
                    'owner_id' => $request->owner_id,
                    'manager_id' => $request->owner_manager_id,
                    'assessment' => $request->risk_assessment, // try_encrypt customization_extra
                    'notes' => $request->additional_notes, // try_encrypt customization_extra
                    'project_id' => $request->project_id,
                    'submitted_by' => auth()->id() ?? 1, // now to test without login
                    'risk_catalog_mapping' => $request->has('risk_catalog_mapping_id') ? implode(",", $request->risk_catalog_mapping_id) : "",
                    'threat_catalog_mapping' => $request->has('threat_catalog_mapping_id') ? implode(",", $request->threat_catalog_mapping_id) : "",
                    'template_group_id' => $request->template_group_id ?? 0, // customization_extra
                ]);

                // Save locations
                foreach ($request->location_id ?? [] as $location_id) {
                    RiskToLocation::create([
                        'risk_id' => $risk->id,
                        'location_id' => $location_id,
                    ]);
                }
                // Save teams
                foreach ($request->team_id ?? [] as $team_id) {
                    RiskToTeam::create([
                        'risk_id' => $risk->id,
                        'team_id' => $team_id,
                    ]);
                }
                // Save technologies
                foreach ($request->technology_id ?? [] as $technology_id) {
                    RiskToTechnology::create([
                        'risk_id' => $risk->id,
                        'technology_id' => $technology_id,
                    ]);
                }
                // Save additional stakeholders
                foreach ($request->additional_stakeholder_id ?? [] as $additional_stakeholder_id) {
                    RiskToAdditionalStakeholder::create([
                        'risk_id' => $risk->id,
                        'user_id' => $additional_stakeholder_id,
                    ]);
                }
                // End submitting basic risk data

                // Start Submit risk scoring
                $riskScoringMethodId = $request->risk_scoring_method_id;
                if (!$riskScoringMethodId) { // If the scoring method is not passed (If the scoring method is invalid then go with the defaults)
                    submit_risk_scoring($risk->id);
                } else { // If the scoring method is passed (If there's a valid scoring method use the provided values)
                    submit_risk_scoring($risk->id, $riskScoringMethodId, $request->likelihood_id, $request->impact_id);
                }
                // End Submit risk scoring

                // Start Process the data from the Affected Assets widget
                if ($request->has('assets_ids')) {
                    $this->processSelectedAssetsAssetGroupsOfType($risk->id, $request->assets_ids, 'risk');
                }
                // End Process the data from the Affected Assets widget
 
                // Store tags for risk
                $allAssetTags = Tag::whereIn('id', $request->tags_ids ?? [])->get();
                $risk->tags()->saveMany($allAssetTags);

                // File upload Start
                if ($request->hasFile('supporting_documentation')) {
                    foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                        if ($supporting_documentation->isValid()) {
                            $path = $supporting_documentation->store('risk/' . $risk->id);
                            $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                            $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                            File::create([
                                'risk_id' => $risk->id,
                                'view_type' => 1,
                                'name' => $fileName,
                                'unique_name' => $path,
                                'type' => $supporting_documentation->getClientMimeType(),
                                'size' => $supporting_documentation->getSize(),
                                'user' => auth()->id()
                            ]);
                        } else {
                            DB::rollBack();
                            Storage::deleteDirectory('risk/' . $risk->id);
                            $response = array(
                                'status' => false,
                                'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                'message' => __('locale.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                }
                // File upload End

                $questionnaire_risk->update([
                    'status' => 'added'
                ]);
                DB::commit();
                $response = [
                    'status' => true,
                    'alert' => false, // Set this to true if you want to show an alert for rejection
                    'message' => __('locale.RiskSubmitedSuccess', ["subject" => $request->subject]),
                ];
    
                return response()->json($response);
                 // return redirect()->back()->with('success', 'Risk has been added !');
            } catch (\Throwable $th) {
                DB::rollBack();
                Storage::deleteDirectory('risk/' . $risk->id);

                return redirect()->back()->with('error', 'Risk has an error !');


            }
        }


    }

}

