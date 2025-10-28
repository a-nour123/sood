<?php

namespace App\Http\Controllers\admin\compliance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
// use phpDocumentor\Reflection\Types\This;
use App\Models\ComplianceFile;
use Illuminate\Support\Facades\File;

class FilesComplianceController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Files = ComplianceFile::where(['ref_type' => 'test_audit', 'ref_id' => $request->id])->get()->map(function ($File) {
            return (object)[
                'path' =>  asset('/uploads/compliance/' . $File->unique_name),
                'unique_name' =>  $File->unique_name,
                'name' =>  $File->name,
                'size' => $File->size,

            ];
        });
        return response()->json($Files, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $fileName = $this->saveFiles($file, $request->id, 'test_audit');
        return response()->json($fileName, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $filename = $request->get('filename');
        
        // Sanitize filename
        $filename = basename($filename);
    
        $path = public_path('uploads/compliance/' . $filename);
    
        // Ensure the path is within the intended directory
        if (!str_starts_with($path, public_path('uploads/compliance'))) {
            return response()->json('Invalid file path.', 400);
        }
    
        if (File::exists($path)) {
            File::delete($path);
    
            ComplianceFile::where([
                'ref_id' => $id,
                'ref_type' => 'test_audit',
                'unique_name' => $filename
            ])->delete();
    
            return response()->json('File deleted successfully.', 200);
        } else {
            return response()->json('File not found.', 404);
        }
    }
}
