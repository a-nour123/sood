<?php

namespace App\View\Components\Admin\Content\RiskManagement\SubmitRisk;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $statuses;
    
    public function __construct($id, $createModalID, $statuses = null)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->statuses = $statuses ?? []; // Default to an empty array
    }

    public function render()
    {
        return view('components.admin.content.risk-management.submit-risk.search');
    }
}
