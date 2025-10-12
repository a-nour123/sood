<?php

namespace App\View\Components\Admin\Content\Hierarchy\Job;

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
    public function __construct($id, $createModalID, $users)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.hierarchy.job.search');
    }
}
