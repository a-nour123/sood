<?php

namespace App\View\Components\Admin\Notification_setting;

use Illuminate\View\Component;

class SmsForm extends Component
{
    public $id;
    public $title;
    public $users;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $users)
    {
        $this->id = $id;
        $this->title = $title;
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.notification_setting.sms-form');
    }
}
