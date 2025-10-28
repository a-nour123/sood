<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\TranslationRequest;


class LanguageTranslationController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request, $language)
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link'=>route('admin.languages.index') , 'name' => __('locale.Languages')],
        ['name' => __('locale.translations')]];

        // Retrieve the available languages and groups
        $languages = $this->translation->allLanguages();
        $groups = $this->translation->getGroupsFor(config('app.locale'))->merge('single');

        // Check if 'group' is provided; if not, use the first available group
        $selectedGroup = $request->get('group') ?? $groups->first();

        // Filter translations based on the selected group
        $translations = $this->translation->filterTranslationsFor($language, $request->get('filter'));

        if ($selectedGroup) {
            if ($selectedGroup === 'single') {
                $translations = $translations->get('single');
                $translations = new Collection(['single' => $translations]);
            } else {
                $translations = $translations->get('group')->filter(function ($values, $group) use ($selectedGroup) {
                    return $group === $selectedGroup;
                });

                $translations = new Collection(['group' => $translations]);
            }
        }

        return view('admin.language.translation.languages.translations.index', compact('language','breadcrumbs','languages', 'groups', 'translations', 'selectedGroup'));
    }


    public function create(Request $request, $language)
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link'=>route('admin.languages.index') , 'name' => __('locale.Languages')],
        ['link'=> route('admin.languages.translations.index', $language) ,'name' => __('locale.translations')],
        ['name' => __('locale.add_translation')]];

        return view('admin.language.translation.languages.translations.create', compact('language','breadcrumbs'));
    }

    public function store(TranslationRequest $request, $language)
    {

        if ($request->filled('group')) {
            $namespace = $request->has('namespace') && $request->get('namespace') ? "{$request->get('namespace')}::" : '';
            $this->translation->addGroupTranslation($language, "{$namespace}{$request->get('group')}", $request->get('key'), $request->get('value') ?: '');
        } else {
            $this->translation->addSingleTranslation($language, 'single', $request->get('key'), $request->get('value') ?: '');
        }

        return redirect()
            ->route('admin.languages.translations.index', $language)
            ->with('success', __('translation::translation.translation_added'));
    }

    public function update(Request $request, $language)
    {
        if (! Str::contains($request->get('group'), 'single')) {
            $this->translation->addGroupTranslation($language, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        } else {
            $this->translation->addSingleTranslation($language, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        }

        return ['success' => true];
    }
}
