<?php

namespace App\View\Components\Admin\Content\Security_awareness;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $statuses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID, $statuses)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->statuses = $statuses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.security_awareness.search');
    }
}
