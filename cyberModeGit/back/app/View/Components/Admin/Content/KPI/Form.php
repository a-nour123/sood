<?php

namespace App\View\Components\Admin\Content\KPI;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $departments;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $departments)
    {
        $this->id = $id;
        $this->departments = $departments;
        $this->title = $title;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.KPI.form');
    }
}
