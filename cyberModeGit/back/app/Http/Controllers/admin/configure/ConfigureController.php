<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigureController extends Controller
{
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['name' => __('locale.Settings')]];
        return view('admin.content.configure.index', compact('breadcrumbs'));
    }
}
