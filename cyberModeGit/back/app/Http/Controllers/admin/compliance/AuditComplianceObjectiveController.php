<?php

namespace App\Http\Controllers\admin\compliance;

use App\Events\EvidenceAchievementCreated;
use App\Http\Controllers\Controller;
use App\Models\ControlAuditEvidence;
use App\Models\ControlAuditObjective;
use App\Models\Document;
use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Events\ObjectiveAchievement;
class AuditComplianceObjectiveController extends Controller
{
    /**
     * Approve or reject the control audit policy
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function takeAuditObjectiveAction(Request $request)
    {
        $controlAuditObjective = ControlAuditObjective::find($request->id);
        $controlAuditEvidences = ControlAuditEvidence::with('evidence')
            ->where('framework_control_test_audit_id', $controlAuditObjective->framework_control_test_audit_id)
            ->whereHas('evidence', function ($query) use ($controlAuditObjective) {
                $query->where('control_control_objective_id', $controlAuditObjective->control_control_objective_id);
            })
            ->get();
        if ($controlAuditObjective) {
            if ($request->has('approved') && $request->approved == 'true') {
                foreach ($controlAuditEvidences as $evidence) {
                    if ($evidence->evidence_audit_status == 'rejected') {
                        $response = array(
                            'status' => false,
                            'message' =>   __('locale.CantApproveRequirementAsItHasRejectedEvidences'),
                        );
                        return response()->json($response, 422);
                    }
                }
            }
            DB::beginTransaction();
            try {
                $controlAuditObjective->update([
                    'objective_audit_status' => $request->has('approved') && $request->approved == 'true' ? 'approved' : 'rejected',
                ]);

                $action_done = $request->has('approved') && $request->approved == 'true' ? 'approved' : 'rejected';
                $message = __('compliance.A Control Audit Requirement') . ' "' . ($controlAuditObjective->id ?? __('locale.[No ID]')) . '" ' . __('locale.was') . ' "' . ($action_done ?? __('locale.[No Action]')) . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($controlAuditObjective->id, auth()->id(), $message, 'audit');
                DB::commit();
                event(new ObjectiveAchievement($controlAuditObjective));

                $response = array(
                    'status' => true,
                    'message' => $request->has('approved') && $request->approved == 'true' ?  __('compliance.RequirementApprovedSuccessfully') :  __('compliance.RequirementRejectedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
                );
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
     * View Evidences of Objective
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewObjectiveEvidences(Request $request)
    {
        try {
            $controlAuditEvidences = ControlAuditEvidence::with('evidence')
            ->where('framework_control_test_audit_id', $request->test_id)
            ->whereHas('evidence', function ($query) use ($request) {
                $query->where('control_control_objective_id', $request->objective_id);
            })
            ->get();
            $editable = $request->editable;
            $html = view('admin.content.compliance.active-audit.evidences', compact('controlAuditEvidences', 'editable'))->render();
            $response = array(
                'status' => true,
                'html' => $html,
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = array(
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
                // 'message' => $th->getMessage(),
            );
        }
    }

    /**
     * Approve or reject the control audit policy
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function takeAuditEvidenceAction(Request $request)
    {
        $controlAuditEvidence = ControlAuditEvidence::with('evidence')->find($request->id);
        $controlAuditEvidenceobjective = ControlAuditObjective::where('framework_control_test_audit_id', $controlAuditEvidence->framework_control_test_audit_id)->where('control_control_objective_id', $controlAuditEvidence->evidence->control_control_objective_id)->first();
        if ($controlAuditEvidence) {
            DB::beginTransaction();
            try {
                if ($request->has('not_relevant') && $request->not_relevant == 'true') {
                    $status = 'not_relevant';
                    $responseMessage = __('locale.EvidenceMadeNotRelevantSuccessfully');
                } else {
                    $status = $request->has('approved') && $request->approved == 'true' ? 'approved' : 'rejected';
                    $responseMessage = $request->has('approved') && $request->approved == 'true' ?  __('locale.EvidenceApprovedSuccessfully') :  __('locale.EvidenceRejectedSuccessfully');
                }
                $controlAuditEvidence->update([
                    'evidence_audit_status' => $status
                ]);
                $controlAuditEvidenceobjective->update([
                    'objective_audit_status' => 'no_action'
                ]);

                $action_done = $status;
                $message = __('compliance.A Control Audit Evidence') . ' "' . $controlAuditEvidence->id . '" ' . __('locale.was') . ' "' . $action_done . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name) . '".';
                write_log($controlAuditEvidence->id, auth()->id(), $message, 'audit');
                DB::commit();
                event(new EvidenceAchievementCreated($controlAuditEvidence));

                $response = array(
                    'status' => true,
                    'message' => $responseMessage,
                    'objectiveId' => $controlAuditEvidenceobjective->id
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
                );
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
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadEvidenceFile($evidenceId)
    {
        try {
            $evidence = Evidence::where('id', $evidenceId)->first();
            $exists = Storage::disk('local')->exists($evidence->file_unique_name);
            if ($evidence->file_unique_name && $exists) {
                $filePath = storage_path('app/' . $evidence->file_unique_name);
                $fileName = $evidence->file_name;
                return response()->download($filePath, $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.ErrorFileNotFound'),
                ], 502);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => [],
                // 'message' => __('locale.Error'),
                'message' => $th->getMessage(),

            ], 502);
        }
    }
}
