<?php

namespace App\View\Components\Admin\Content\KPI\Assessment;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $kpis;
    public $departments;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID, $kpis, $departments)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->kpis = $kpis;
        $this->departments = $departments;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.KPI.Assessment.search');
    }
}
