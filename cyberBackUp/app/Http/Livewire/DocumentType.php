<?php

namespace App\Http\Livewire;
use App\Models\DocumentStatus;
use App\Models\Privacy;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Framework;
class DocumentType extends Component
{
    use WithPagination;

    public $item;

    public string $search = '';

    public array $selected = [];

    public array $paginationOptions;

    protected $queryString = [
        'search' => [
            'except' => '',
        ],
    ];

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetSelected()
    {
        $this->selected = [];
    }
    public function mount()
    {
        $this->sortBy            = 'id';
        $this->sortDirection     = 'desc';
        $this->perPage           = 2;
        $this->orderable         = (new Framework())->orderable;
    }

    public function render()
    {
        $query = Framework::where('name','like','%'.$this->search.'%');
        $pagesCount=round($query->get()->count()/$this->perPage);

        $frameworks = $query->paginate($this->perPage);
        $testers = User::all();
        $teams = Team::all();
        $status = DocumentStatus::all();
        $privacies = Privacy::all();
        return view('livewire.document-type', compact('frameworks',
            'query','testers','teams','status','privacies','pagesCount'));
    }

}
