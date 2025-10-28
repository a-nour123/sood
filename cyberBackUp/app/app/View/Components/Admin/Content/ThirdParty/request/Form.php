<?php

namespace App\View\Components\Admin\Content\ThirdParty\request;

use App\Models\PhishingDomains;
use App\Models\PhishingTemplate;
use Illuminate\View\Component;

class Form extends Component
{
    public $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
         // dd($this->data);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.content.third_party.requests.create', [
            'data' => $this->data, // Pass the data to the view here
        ]);
        }
}
