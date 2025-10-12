<?php

namespace App\View\Components\Admin\Content\Configure\Domain_management;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $domains;
    public $subDomains;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID, $domains, $subDomains)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->domains = $domains;
        $this->subDomains = $subDomains;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.configure.domain_management.search');
    }
}
