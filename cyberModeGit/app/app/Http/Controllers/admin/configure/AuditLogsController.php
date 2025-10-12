<?php

namespace App\Http\Controllers\admin\configure;

use App\Exports\AuditExport;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\FrameworkControlTest;
use App\Models\test;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class AuditLogsController extends Controller
{
    private $path = 'admin.content.configure.Auditlogs';

    public function index()
    {
        // dd(AuditLog::first()->user);

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['name' => __('Audit Trail')]];

        $auditlogs = get_audit_trail();

        return view($this->path, compact('breadcrumbs','auditlogs'));
        // return view('admin.content.compliance.index', compact('breadcrumbs'));
    }
    public function getlogs()
    {
        $tests = AuditLog::with('user')->get()->map(function ($test) {
            return (object)[
                'responsive_id' =>  $test->id,
                'id' => $test->id,
                'description' => $test->description,
                'subject_id' => $test->subject_id,
                'subject_type' => $test->subject_type,
                'user_id' => $test->user->name ?? '',
                'properties' => $test->properties,
                'host' => $test->host,
                'created_at' => $test->created_at ? $test->created_at->toDateTimeString() : null,
                'updated_at' => $test->updated_at ? $test->updated_at->toDateTimeString() : null,

                // 'Actions' => $test->id,
            ];
        });

        // dd($tests);
        return response()->json($tests, 200);
    }



    public function create()
    {
        return view('admin.content.configure.test');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $testmonial = new Test();

        $testmonial->name = $request->name;


        $testmonial->save();
        return redirect()->back();
    }

    public function downloadExcel()
{

        return Excel::download(new AuditExport, 'Audit.xlsx');
}
    // public function downloadExcel()
    // {
    //     $data =get_audit_trail();
    //     // dd($data);
    //     return Excel::create('laravelcode', function($excel) use ($data) {
    //         $excel->sheet('mySheet', function($sheet) use ($data)
    //         {
    //             $sheet->fromArray($data);
    //         });
    //     })->download();
    // }


}
