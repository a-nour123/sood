<?php

namespace App\View\Components\Admin\Content\Reporting\Objective;

use Illuminate\View\Component;

class Search extends Component
{
    public $frameworks;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($frameworks)
    {
        $this->frameworks = $frameworks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.reporting.objective.search');
    }
}
