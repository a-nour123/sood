<?php

namespace App\View\Components\Admin\Content\Hierarchy\Department;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $departments;
    public $users;
    public $departmentColors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $departments, $users, $departmentColors)
    {
        $this->id = $id;
        $this->title = $title;
        $this->departments = $departments;
        $this->users = $users ?? [];
        $this->departmentColors = $departmentColors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.hierarchy.department.form');
    }
}
