<?php

namespace App\View\Components\Admin\Content\ControlObjective;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $users;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
     }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.control-objective.search');
    }
}
