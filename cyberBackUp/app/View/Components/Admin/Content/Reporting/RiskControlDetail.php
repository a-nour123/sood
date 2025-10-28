<?php

namespace App\View\Components\Admin\Content\Reporting;

use Illuminate\View\Component;

class RiskControlDetail extends Component
{
    public $control;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($control)
    {
        $this->control = $control;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.reporting.risk-control-detail');
    }
}
