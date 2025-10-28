<?php

namespace App\Http\Controllers\admin\compliance;

use App\Http\Controllers\Controller;
use App\Models\ControlAuditPolicy;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Events\AduitPolicyCreated;

class AuditCompliancePolicyController extends Controller
{
    /**
     * Approve or reject the control audit policy
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function takeAuditPolicyAction(Request $request)
    {
        
        $controlAuditPolicy = ControlAuditPolicy::find($request->id);
        if ($controlAuditPolicy) {
            DB::beginTransaction();
            try {
                $controlAuditPolicy->update([
                    'document_audit_status' => $request->has('approved') && $request->approved == 'true' ? 'approved' : 'rejected',
                ]);

                $action_done = $request->has('approved') && $request->approved == 'true' ? 'approved' : 'rejected';
                $message = __('compliance.A Control Audit Policy') . ' "' . $controlAuditPolicy->id . '" ' . __('locale.was') . ' "' . $action_done . '" ' . trans('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($controlAuditPolicy->id, auth()->id(), $message, 'audit');
                DB::commit();
                event(new AduitPolicyCreated($controlAuditPolicy));

                $response = array(
                    'status' => true,
                    'message' => $request->has('approved') && $request->approved == 'true' ?  __('compliance.RelatedPolicyApprovedSuccessfully') :  __('compliance.RelatedPolicyRejectedSuccessfully'),
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
    public function downloadFile(Request $request)
    {
        $file = Document::where('id', $request->document_id)->first()->file ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name ?? '');

        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->name);
        } else {
            return redirect()->back();
        }
    }
}
