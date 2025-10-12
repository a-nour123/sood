<?php

namespace App\View\Components\Admin\Content\Hierarchy\Department;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $departments;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID, $departments)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->departments = $departments;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.hierarchy.department.search');
    }
}
