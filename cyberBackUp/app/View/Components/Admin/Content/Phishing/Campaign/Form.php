<?php

namespace App\View\Components\Admin\Content\Phishing\Campaign;

use App\Models\PhishingDomains;
use App\Models\PhishingTemplate;
use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $emailtemplate;
    public $employees;
    public $courses;
    public $levels;
    public $trainingModules;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title,$emailtemplate,$employees,$courses,$levels,$trainingModules)
    {
        $this->id = $id;
        $this->title = $title;
        $this->emailtemplate = $emailtemplate;
        $this->employees = $employees;
        $this->courses = $courses;
        $this->levels = $levels;
        $this->trainingModules = $trainingModules;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.phishing.campaign.form');
    }
}
