<?php

namespace App\View\Components\Admin\Content\Change_request;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $type = 'create')
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.change_request.form');
    }
}
