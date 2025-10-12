<?php

namespace App\View\Components\Admin\Content\Reporting;

use Illuminate\View\Component;

class RiskAssetDetail extends Component
{
    public $asset;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($asset)
    {
        $this->asset = $asset;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.reporting.risk-asset-detail');
    }
}
