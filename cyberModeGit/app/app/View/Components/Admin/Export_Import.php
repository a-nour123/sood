<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Export_Import extends Component
{
    public $name;
    public $createPermissionKey;
    public $createOtherCondition;
    public $exportPermissionKey;
    public $exportRouteKey;
    public $importRouteKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $createPermissionKey, $exportPermissionKey, $exportRouteKey, $importRouteKey, $createOtherCondition = true)
    {
        $this->name = $name;
        $this->createPermissionKey = $createPermissionKey;
        $this->exportPermissionKey = $exportPermissionKey;
        $this->exportRouteKey = $exportRouteKey;
        $this->importRouteKey = $importRouteKey;
        $this->createOtherCondition = $createOtherCondition;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.export_import');
    }
}
