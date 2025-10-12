<?php

namespace App\View\Components\Admin\Content\Phishing\SenderProfile;

use App\Models\PhishingDomains;
use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $domains;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->domains = PhishingDomains::withoutTrashed()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.phishing.senderProfile.form');
    }
}
