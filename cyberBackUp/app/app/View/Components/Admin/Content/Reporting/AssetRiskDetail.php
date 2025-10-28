<?php

namespace App\View\Components\Admin\Content\Reporting;

use Illuminate\View\Component;

class AssetRiskDetail extends Component
{
    public $risk;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($risk)
    {
        $this->risk = $risk;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.reporting.asset-risk-detail');
    }
}
