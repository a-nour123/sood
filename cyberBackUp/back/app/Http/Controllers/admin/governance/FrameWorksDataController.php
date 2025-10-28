<?php

namespace App\Http\Controllers\admin\governance;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ControlClass;
use App\Models\ControlDesiredMaturity;
use App\Models\ControlMaturity;
use App\Models\ControlPhase;
use App\Models\ControlPriority;
use App\Models\ControlType;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Team;
use App\Models\User;
use App\Events\FrameworkDeleted;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use Yajra\DataTables\Facades\DataTables;
use Session;

class FrameWorksDataController extends Controller
{
    public function index()
    {
        //Frameworks
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            ['name' => __('locale.Regulators')],
            ['name' => __('governance.Define Control Frameworks')]
        ];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $frameworks = Framework::with('FrameworkControls', 'families')->get();
        $families = Family::whereNull('parent_id')->select('id', 'name')
            ->with('custom_families_framework:id,name,parent_id')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        $owners = User::all();
        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->with('Frameworks')->get();

        $categoryList = Framework::with(['only_families', 'only_sub_families'])->orderBy('id', 'asc')
            ->take(1)->get();

        Session::put('frame_current_id_dtb', $categoryList[0]->id ?? null);

        $sidebarCategory = Framework::select('id', 'name', 'icon')
            ->orderBy('id', 'asc')->paginate(5);

        $checkCount = Framework::select('id', 'name', 'icon')->count();

        foreach ($categoryList as $framework) {
            $tempDomainsId = [];
            foreach ($framework->only_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_families = $tempDomainsId;

            $tempDomainsId = [];
            foreach ($framework->only_sub_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_sub_families = $tempDomainsId;
        }
        $group = array();

        return view(
            'admin.content.governance.new_index',
            ['pageConfigs' => $pageConfigs],
            compact(
                'teams',
                'testers',
                'group',
                'frameworks',
                'breadcrumbs',
                'categoryList',
                'families',
                'priorities',
                'owners',
                'phases',
                'types',
                'maturities',
                'classes',
                'owners',
                'desiredMaturities',
                'parentControls',
                'sidebarCategory',
                'checkCount'
            )
        );
    }

    public function NexFramePage(Request $request)
    {
        $perPage = 5;
        $currentPage = $request->page ?? 1;

        // Retrieve frameworks for the current page
        $sidebarCategory = Framework::select('id', 'name', 'icon')
            ->skip($perPage * ($currentPage - 1))
            ->take($perPage)
            ->get();

        $data = '';
        $checkCount = $sidebarCategory->count();

        foreach ($sidebarCategory as $item) {
            $data .= "<button class='list-group-item list-group-item-action tablinks sideNavBtn' id='item$item->id' style=' display: flex'>
                        <span class=' fa  $item->icon ' style=' padding: 0 6px;  font-size: 20px;  color: #44225c; '></span>
                        <div class='mb-1'>
                           " . $item->name . "
                        </div>
                    </button>";
        }

        // Calculate the total number of frameworks
        $totalFrameworks = Framework::select('id', 'name', 'icon')->count();

        // Calculate the last page based on the total number of frameworks and the desired per page count
        $lastPage = ceil($totalFrameworks / $perPage);

        return [$data, $lastPage, $checkCount];
    }


    public function PrevFramePage(Request $request)
    {
        $sidebarCategory = Framework::select('id', 'name', 'icon')
            ->skip(5 * ($request->page - 1))
            ->take(5)->get();
        $data = '';
        foreach ($sidebarCategory as $item) {
            $data .= "<button class='list-group-item list-group-item-action tablinks sideNavBtn' id='item$item->id'  style=' display: flex'>
                        <span class=' fa  $item->icon '
                              style=' padding: 0 6px;  font-size: 20px;  color: #44225c; '></span>

                        <div class='mb-1'>

                           " . $item->name . "
                               </div>
                    </button>";
        }
        $lastPage = Framework::select('id', 'name', 'icon')->count();
        $lastPage = $lastPage > 0 ? $lastPage / 5 : 0;
        return [$data, round($lastPage)];
    }

    public function frameDetails(Request $request)
    {
        $id = (int)substr($request->id, 4);

        $frame = Framework::with(['only_families', 'only_sub_families'])->where('id', $id)->first();

        //Put Frame id To Be used on Datatables

        Session::put('frame_current_id_dtb', $id);

        $updateUrl = route('admin.governance.framework.update', $id);

        $copyUrl = route('admin.governance.framework.copy', $id);

        //Edit Inputs
        $framework_domain_select = '';
        $framework_subdomain_select = '';

        $families = Family::whereNull('parent_id')->select('id', 'name')
            ->with('custom_families_framework:id,name,parent_id')->get();
        foreach ($families as $family) {
            if (in_array($family->id, $frame->only_families->pluck('id')->toArray())) {
                $framework_domain_select .= "   <option  selected data-families='" .
                    json_encode($family->custom_families_framework) . "' value='" .
                    $family->id . "'> " .
                    $family->name . "</option>";
            } else {
                $framework_domain_select .= "   <option   data-families='" .
                    json_encode($family->custom_families_framework) . "' value='" .
                    $family->id . "'> " .
                    $family->name . "</option>";
            }
        }

        $subfamilies = Family::whereNotNull('parent_id')->select('id', 'name')
            ->with('custom_families_framework:id,name,parent_id')->get();

        foreach ($subfamilies as $family) {
            //sub domains

            if (in_array($family->id, $frame->only_sub_families->pluck('id')->toArray())) {
                $framework_subdomain_select .= "   <option selected  value='" .
                    $family->id . "'> " .
                    $family->name . "</option>";
            } else {
                $framework_subdomain_select .= "   <option  value='" .
                    $family->id . "'> " .
                    $family->name . "</option>";
            }
        }
        $framework_subdomain_json = json_encode($frame->only_sub_families);

        $iconsArray = Helper::getIcons();

        $IconsSelect = "";

        foreach ($iconsArray as $icon) {
            if ($icon['key'] == $frame->icon) {
                $IconsSelect .= "   <option selected value='" . $icon['key'] . "'> " . $icon['value'] . "</option>";
            } else {
                $IconsSelect .= "   <option  value='" . $icon['key'] . "'> " . $icon['value'] . "</option>";
            }
        }

        $description = $frame->description;
        $addControlUrl = route('admin.governance.control.store', $id);

        return [
            $frame->name,
            $frame->description,
            $updateUrl,
            $copyUrl,
            $framework_domain_select,
            $framework_subdomain_select,
            $framework_subdomain_json,
            $IconsSelect,
            $description,
            $addControlUrl
        ];
    }

    public function deleteFrame(Request $request)
    {
        $framework = Framework::find($request->id);
        if ($framework->FrameworkControls->isEmpty()) {
            //Delete Related Mapping Controls
            DB::table('framework_control_mappings')->where('framework_id', $request->id)->delete();
            $framework->delete();
            DB::commit();
            event(new FrameworkDeleted($framework));
            $message = __('governance.A Framework that name is') . ' "' . ($framework->name ?? __('locale.[No Name]')) . '" '
                . __('governance.and the Description of it is') . ' "' . ($framework->description ?? __('locale.[No Description]')) . '". '
                . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log($framework->id, auth()->id(), $message, 'Deleting framework');
        } else {
            return response()->json('frame can not deleted because it is related with controls', 400);
        }
    }

    public function FrameFamiliesTable(Request $request)
    {
        if (request()->ajax()) {
            return DataTables::of(DB::table('framework_families')
                ->where('framework_id', session('frame_current_id_dtb'))
                ->whereNull('parent_family_id')
                ->select('*'))

                ->addColumn('families', function ($item) {
                    $families = "";
                    $parentfamily = Family::where('id', $item->family_id)->first();
                    if ($parentfamily) {
                        $families .= "<td>" . $parentfamily->name . "</td>";
                    }
                    return $families;
                })
                ->addColumn('sub_families', function ($item) {
                    $subFamilies = "";
                    $subfamilyIds = DB::table('framework_families')->select("*")
                        ->where('framework_id', session('frame_current_id_dtb'))
                        ->whereNotNull('parent_family_id')
                        ->where('parent_family_id', $item->family_id)->pluck('family_id');
                    $subs = Family::whereIn('id', $subfamilyIds)->get();
                    foreach ($subs as $sub) {
                        $subFamilies .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                            $sub->name . '</span>';
                    }

                    return $subFamilies;
                })
                ->rawColumns(['families', 'sub_families'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
