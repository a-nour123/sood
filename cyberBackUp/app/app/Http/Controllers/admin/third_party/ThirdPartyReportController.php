<?php

namespace App\Http\Controllers\admin\third_party;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Assessment,
    AssessmentAnswer,
    Question,
    ThirdPartyContactQuestionnaire,
    ThirdPartyContactQuestionnaireAnswerResult,
    ThirdPartyProfileContact,
    ThirdPartyQuestionnaire,
    ThirdPartyQuestionnaireQuestion,
    ThirdPartyRequest,
    ThirdPartyContactQuestionnaireAnswer,
    ThirdPartyProfile,
    ThirdPartyQuestionnaireRisk,
};

class ThirdPartyReportController extends Controller
{
    public function index(Request $request)
    {
        $thirdPartyProfiles = ThirdPartyProfile::all();
        $thirdPartyRequests = ThirdPartyRequest::all();
        $thirdPartyAssessments = ThirdPartyQuestionnaire::all();
        $thirdPartyDepartments = ThirdPartyRequest::with('department:id,name')->get();
        $departments = $thirdPartyDepartments->pluck('department')->unique()->values();


        // $evaluatedThirdParty = ThirdPartyQuestionnaire::all()->pluck('request_id')->filter()
        //     ->unique()
        //     ->values()
        //     ->count();

        $evaluatedThirdParty = ThirdPartyProfile::query()
            ->join('third_party_requests as request', 'request.third_party_profile_id', '=', 'third_party_profiles.id')
            ->join('third_party_questionnaires as questionnaire', 'questionnaire.request_id', '=', 'request.id')
            ->select('third_party_profiles.id')
            ->distinct() // Ensures unique results
            ->get();

        $profile_labels = $thirdPartyProfiles->pluck('third_party_name');

        foreach ($thirdPartyProfiles as $profile) {
            $relatedRequests[] = ThirdPartyRequest::where('third_party_profile_id', $profile->id)->value('id');
            $relatedAssessments[] = ThirdPartyQuestionnaire::where('request_id', $relatedRequests)->value('id');
        }

        // dd($departments->toArray());
        // dd(array_filter(array_unique($relatedRequests)));

        $data = [
            'profiles' => $thirdPartyProfiles,
            'requests' => $thirdPartyRequests,
            'assessments' => $thirdPartyAssessments,
            'evaluatedThirdParty' => $evaluatedThirdParty->count(),
            'notEvaluatedThirdParty' => $thirdPartyProfiles->count() - $evaluatedThirdParty->count(),
            'profile_labels' => $profile_labels,
            'departments' => $departments
        ];
        // dd($evaluatedThirdParty);

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.third_party.reports'), 'name' => __('locale.ThirdPartyManagment')],
            ['link' => route('admin.third_party.profiles'), 'name' => __('locale.ThirdPartyProfiles')],  
            ['name' => __('third_party.Reports')]
        ];
        return view('admin.content.third_party.reports', compact('breadcrumbs', 'data'));
    }

    public function getProfileCharts(Request $request, $profile_id)
    {
        if ($request->ajax()) {
            $relatedRequests = ThirdPartyRequest::where('third_party_profile_id', $profile_id)->get();

            $relatedAssessments = $relatedRequests->map(function ($request) {
                return ThirdPartyQuestionnaire::where('request_id', $request->id)->get();
            })->collapse();

            $assessmentIds = $relatedAssessments->pluck('id');

            $groupedAssessments = ThirdPartyContactQuestionnaireAnswer::whereIn('questionnaire_id', $assessmentIds)
                ->get()
                ->groupBy('approved_status');

            // Remove null values
            $pendingAssessment = $groupedAssessments->get(null, collect())->pluck('id')->filter()->values();
            $acceptedAssessment = $groupedAssessments->get('yes', collect())->pluck('id')->filter()->values();
            $rejectedAssessment = $groupedAssessments->get('no', collect())->pluck('id')->filter()->values();
            $remedatedAssessment = $groupedAssessments->get('remeidation', collect())->pluck('id')->filter()->values();

            $data = [
                'requests' => $relatedRequests->count(),
                'assessments' => $relatedAssessments->count(),
                'pendingAssessments' => $pendingAssessment->count(),
                'acceptedAssessments' => $acceptedAssessment->count(),
                'rejectedAssessments' => $rejectedAssessment->count(),
                'remedatedAssessments' => $remedatedAssessment->count(),
            ];

            // dd($data);

            return response()->json(['message' => 'data returned successfully', 'data' => $data], 200);
        }
    }

    public function getDepartmentsCharts(Request $request, $department_id)
    {
        if ($request->ajax()) {
            $relatedRequests = ThirdPartyRequest::where('department_id', $department_id)->get();

            // Group data by profile names
            $profileData = $relatedRequests->map(function ($request) {
                $profileName = ThirdPartyProfile::where('id', $request->third_party_profile_id)->value('third_party_name');
                $assessments = ThirdPartyQuestionnaire::where('request_id', $request->id)->get();

                $assessmentIds = $assessments->pluck('id');

                $groupedAssessments = ThirdPartyContactQuestionnaireAnswer::whereIn('questionnaire_id', $assessmentIds)
                    ->get()
                    ->groupBy('approved_status');

                return [
                    'profile' => $profileName,
                    'requests' => 1, // Count each request
                    'assessments' => $assessments->count(),
                    'pendingAssessments' => $groupedAssessments->get(null, collect())->count(),
                    'acceptedAssessments' => $groupedAssessments->get('yes', collect())->count(),
                    'rejectedAssessments' => $groupedAssessments->get('no', collect())->count(),
                    'remedatedAssessments' => $groupedAssessments->get('remeidation', collect())->count(),
                ];
            });

            // Group the data by profile name and aggregate the counts
            $aggregatedProfileData = $profileData->groupBy('profile')->map(function ($group) {
                return [
                    'profile' => $group->first()['profile'], // Take the profile name from the first item
                    'requests' => $group->sum('requests'),
                    'assessments' => $group->sum('assessments'),
                    'pendingAssessments' => $group->sum('pendingAssessments'),
                    'acceptedAssessments' => $group->sum('acceptedAssessments'),
                    'rejectedAssessments' => $group->sum('rejectedAssessments'),
                    'remedatedAssessments' => $group->sum('remedatedAssessments'),
                ];
            });

            // Convert the collection to an array
            $aggregatedProfileData = $aggregatedProfileData->values()->all();

            // Structure the response using aggregatedProfileData
            $data = [
                'profiles' => collect($aggregatedProfileData)->pluck('profile'), // Profile names for the X-axis
                'requests' => collect($aggregatedProfileData)->pluck('requests'),
                'assessments' => collect($aggregatedProfileData)->pluck('assessments'),
                'pendingAssessments' => collect($aggregatedProfileData)->pluck('pendingAssessments'),
                'acceptedAssessments' => collect($aggregatedProfileData)->pluck('acceptedAssessments'),
                'rejectedAssessments' => collect($aggregatedProfileData)->pluck('rejectedAssessments'),
                'remedatedAssessments' => collect($aggregatedProfileData)->pluck('remedatedAssessments'),
            ];

            // dd($data);

            return response()->json(['message' => 'Data returned successfully', 'data' => $data], 200);
        }
    }

}
