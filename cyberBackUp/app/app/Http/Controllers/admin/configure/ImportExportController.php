<?php

namespace App\Http\Controllers\admin\configure;

use App\Exports\ExportData;
use App\Http\Controllers\Controller;
use App\Imports\ImportData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Exporter\Exporter;

class ImportExportController extends Controller
{
    public function view()
    {
        return view('admin.content.configure.ImportExport');
    }
    public function fileImport(Request $request)
    {
        if (session()->has('table')) {
            session()->forget('table');
        }
        session()->put('table', $request->table_name);
        Excel::import(new ImportData, $request->file('file')->store('temp'));
        return redirect()->back()->with('success', 'Data have been imported');
    }
    public function fileExport(Request $request)
    {
        if (session()->has('table')) {
            session()->forget('table');
        }
        session()->put('table', $request->table_name);

        return Excel::download(new ExportData,  $request->table_name . '.xlsx');
    }
}
