<?php

namespace App\View\Components\Admin\Content\Exception;

use Illuminate\View\Component;

class ConfigForm extends Component
{
    public $id;
    public $title;
    public $exceptionSettings;
    public $departmentsManagers;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($id, $title, $exceptionSettings, $departmentsManagers)
    {
        $this->id = $id;
        $this->title = $title;
        $this->exceptionSettings = $exceptionSettings;
        $this->departmentsManagers = $departmentsManagers;
    }



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.exception.configure.config-form');
    }
}
