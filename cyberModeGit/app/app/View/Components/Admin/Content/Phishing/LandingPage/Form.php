<?php

namespace App\View\Components\Admin\Content\Phishing\LandingPage;

use App\Models\PhishingCategory;
use App\Models\PhishingDomains;
use App\Models\PhishingWebsitePage;
use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $name;
    public $domains;
    public $websites;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->domains = PhishingDomains::withoutTrashed()->get();
        $this->websites = PhishingWebsitePage::withoutTrashed()->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.admin.content.phishing.landingpage.form');
    }
}
