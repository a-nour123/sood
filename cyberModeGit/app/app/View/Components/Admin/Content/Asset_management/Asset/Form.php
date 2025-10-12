<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $assetValues;
    public $assetCategories;
    public $assetEnvironmentCategories;
    public $locations;
    public $teams;
    public $tags;
    public $operatingSystems;
    public $users;
    public $regions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $assetValues, $assetCategories, $assetEnvironmentCategories, $users, $locations, $teams, $tags, $operatingSystems,$regions)
    {
        $this->id = $id;
        $this->title = $title;
        $this->assetValues = $assetValues;
        $this->assetCategories = $assetCategories;
        $this->assetEnvironmentCategories = $assetEnvironmentCategories;
        $this->locations = $locations;
        $this->teams = $teams;
        $this->tags = $tags;
        $this->operatingSystems = $operatingSystems;
        $this->users = $users;
         $this->regions = $regions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.asset_management.asset.form');
    }
}
