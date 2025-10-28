<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset\Form;

use Illuminate\View\Component;

class CreateView extends Component
{
    public $id;
    public $assetValues;
    public $locations;
    public $teams;
    public $tags;
    public $regions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $assetValues, $locations, $teams, $tags,$regions)
    {
        $this->id = $id;
        $this->assetValues = $assetValues;
        $this->locations = $locations;
        $this->teams = $teams;
        $this->tags = $tags;
        $this->regions = $regions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.asset_management.asset.form.create-view');
    }
}
