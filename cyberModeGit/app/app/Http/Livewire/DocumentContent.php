<?php

namespace App\Http\Livewire;

use App\Models\ControlDesiredMaturity;
use App\Models\DocumentStatus;
use App\Models\DocumentTypes;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Privacy;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class DocumentContent extends Component
{
    use WithPagination;
    public $document_id;
    public function mount()
    {
        $this->document_id=$this->document_id??DocumentTypes::first()->id;
    }
    public function updateDocumentType()
    {
//        $this->document_id=$this->document_id;
        dd($this->document_id);
    }
    public function render()
    {
        //Documents
        $breadcrumbs = [['link' => route('admin.dashboard'),
            'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)",
            'name' => __('locale.Governance')], ['name' => __('locale.Documentation')]];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $documents = \App\Models\Document::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        // $owners=ControlOwner::all();
        $owners = User::all();

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $controls = FrameworkControl::all();
        $categoryList = DocumentTypes::with('documents')->where('id',$this->document_id)->get();

        $category2 = DocumentTypes::get();
        $status = DocumentStatus::all();
        $privacies = Privacy::all();

        $activeDocumentType = request()->query('doc_type');

        if (!DocumentTypes::where('id', $activeDocumentType)->exists())
            $activeDocumentType = null;

        if (!$activeDocumentType) {
            $activeDocumentType = $category2[0]->id ?? null;
        }

        return view('livewire.document-content', ['pageConfigs' => $pageConfigs], compact('breadcrumbs', 'controls',
            'testers', 'teams', 'documents', 'frameworks', 'owners', 'desiredMaturities',
            'categoryList', 'status', 'privacies','category2', 'activeDocumentType'));

    }
}
