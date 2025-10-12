<?php

namespace App\View\Components\Admin\Content\Security_awareness;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $users;
    public $teams;
    public $statuses;
    public $privacies;
    public $type;
    public $owners;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $users, $teams, $statuses, $privacies, $type = 'create',$owners)
    {
        $this->id = $id;
        $this->title = $title;
        $this->users = $users;
        $this->teams = $teams;
        $this->statuses = $statuses;
        $this->privacies = $privacies;
        $this->type = $type;
        $this->owners = $owners;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.security_awareness.form');
    }
}
