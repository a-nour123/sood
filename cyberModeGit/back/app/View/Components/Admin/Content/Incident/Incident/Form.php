<?php

namespace App\View\Components\Admin\Content\Incident\Incident;

use App\Models\PhishingDomains;
use App\Models\PhishingTemplate;
use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $events;
    public $directions;
    public $attacks;
    public $detects;






    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title,$events,$directions,$attacks,$detects )
    {
        $this->id = $id;
        $this->title = $title;
        $this->events = $events;
        $this->directions = $directions;
        $this->attacks = $attacks;
        $this->detects = $detects;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.incident.incident.form');
    }
}
