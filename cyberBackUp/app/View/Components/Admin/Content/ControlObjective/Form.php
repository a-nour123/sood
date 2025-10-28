<?php

namespace App\View\Components\Admin\Content\ControlObjective;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $frameworks;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $frameworks = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->frameworks = $frameworks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.control-objective.form');
    }
}
