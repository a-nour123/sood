<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset_group;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $assetGroups;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID, $assetGroups)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->assetGroups = $assetGroups;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.asset_management.asset_group.search');
    }
}
