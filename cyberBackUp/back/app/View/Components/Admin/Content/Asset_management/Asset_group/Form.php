<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset_group;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    // public $assets;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.asset_management.asset_group.form');
    }
}
