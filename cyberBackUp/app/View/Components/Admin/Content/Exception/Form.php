<?php

namespace App\View\Components\Admin\Content\Exception;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $regulators;
    public $documents;
    public $users;
    public $exceptionSettings;
    public $controls;
    public $risks;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($id, $title, $regulators, $documents, $users, $exceptionSettings, $controls,  $risks)
    {
        $this->id = $id;
        $this->title = $title;
        $this->regulators = $regulators;
        $this->documents = $documents;
        $this->users = $users;
        $this->exceptionSettings = $exceptionSettings;
        $this->controls = $controls;
        $this->risks = $risks;
    }



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.exception.form', ['regulators' => $this->regulators]);
    }
}
