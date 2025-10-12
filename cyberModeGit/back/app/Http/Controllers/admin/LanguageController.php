<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\LanguageRequest;

class LanguageController extends Controller
{

    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request)
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['name' => __('locale.Languages')]];

        $languages = $this->translation->allLanguages();
        return view('admin.language.translation.languages.index', compact('languages','breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link'=>route('admin.languages.index') , 'name' => __('locale.Languages')],
        ['name' => __('locale.add_language')]];
        return view('admin.language.translation.languages.create',compact('breadcrumbs'));
    }

    public function store(LanguageRequest $request)
    {
        $this->translation->addLanguage($request->locale, $request->name);

        return redirect()
            ->route('admin.languages.index')
            ->with('success', __('translation::translation.language_added'));
    }
}
