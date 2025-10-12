<?php

namespace App\View\Components\Admin\Content\Phishing\Group;

use App\Models\Department;
use App\Models\PhishingDomains;
use Illuminate\View\Component;

class UsersForm extends Component
{
    public $id;
    public $title;
    public $departments;
    public $departmentTree;
    public $idValue ;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title,$idValue)
    {
        $this->id = $id;
        $this->title = $title;
        $this->idValue = $idValue;
        $this->departments = Department::with(['employees','color'])->get();
     //   $this->departmentTree = $this->buildTree( $this->departments);


    }
    // private function buildTree($departments, $parentId = null)
    // {
    //     $branch = [];
    //     foreach ($departments as $department) {
    //         if ($department->parent_id == $parentId) {

    //             $children = $this->buildTree($departments, $department->id);
    //             dd($children);
    //             if ($children) {
    //                 $department->children = $children;
    //             }
    //             $branch[] = $department;
    //         }
    //     }
    //     return $branch;
    // }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.phishing.groups.usersform');
    }
}
