<?php

namespace App\Http\Controllers\admin\compliance;

use App\Http\Controllers\Controller;
use App\Models\FrameworkControlTestComment;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Events\AuditCommentCreated;
use Carbon\Carbon;
class CommentComplianceController extends Controller
{


    /**
     * Store a add comment created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AddCommentAudit(Request $request)
    {
        // validation rules
        $validator = Validator::make($request->all(), [
            'test_audit_id' => 'required|integer',
            'comment' => 'required'
        ]);
        $data=array();

        // check  rules valid or not
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data=array(
                'status'=>0,
                'errors'=>$errors
            );
            return response()->json($data,200);
         }else{

           $FrameworkControlTestComment= FrameworkControlTestComment::create([
                'test_audit_id'=> $request->test_audit_id,
                'date'=>  Carbon::now(),
                'user'=> auth()->user()->id,
                'comment'=>$request->comment,
            ]);

            $html='<div class="d-flex align-items-start mt-4">';
            // $html.='<div class="avatar me-75">';
            // $html.='<img src="'.asset('images/portrait/small/avatar-s-9.jpg').'" width="38" height="38" alt="Avatar">';
            // $html.='</div>';
            $html.='<div class="author-info">';
            $html.=' <h6 class="fw-bolder mb-1">'.$FrameworkControlTestComment->UserCommented->name.'</h6>';
            $html.=' <p class="card-text">'.ViewDate($FrameworkControlTestComment->date).'</p>';
            $html.='<p class="card-text">'.$FrameworkControlTestComment->comment;
            $html.='</p>';
            $html.='</div>';
            $html.='</div>';
            $data=array(
                'status'=>1,
                'html'=>$html
            );

            $message = __('compliance.An Audit with name') . ' "' . ($FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->short_name ?? __('locale.[No Aduit Name]')) . '" '
            . __('compliance.added comment to it') . ' "' . ($FrameworkControlTestComment->comment ?? __('locale.[No Comment]')) . '" '
            . __('locale.CreatedBy') . ' "' . ($FrameworkControlTestComment->UserCommented->name ?? __('locale.[No User Name]')) . '".';
                    write_log($FrameworkControlTestComment->id, auth()->id(), $message, 'audit');
            DB::commit();
            event(new AuditCommentCreated($FrameworkControlTestComment));

              return response()->json($data,200);
        }

    }








}
