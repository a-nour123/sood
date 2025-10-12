<?php

namespace App\Http\Controllers\admin\compliance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Framework;
use App\Models\Family;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControlMapping;
use App\Models\User;
use App\Models\Team;
use Validator;
use App\Http\Traits\ItemTeamTrait;

class TestComplianceController extends Controller
{
    use ItemTeamTrait;

    private $path='admin.content.compliance.define-test';
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['link' => "javascript:void(0)", 'name' => __('locale.Compliance')], 
         ['name' => __('locale.Define Tests')]];

        $testers=User::all();
        $controls=FrameworkControl::all();
        $frameworks=Framework::all();
        $families=Family::all();
        $teams=Team::all();

        return view($this->path.'.index',compact('frameworks','families','controls','testers','breadcrumbs','teams'));
        // return view('admin.content.compliance.index', compact('breadcrumbs'));
    }
     /**
     * store test into database
     *
     * @return array
     */
    public function store(Request $request){
        // validation rules
        $validator = Validator::make($request->all(), [
            'tester' => 'required|integer',
            'last_date' => 'required|after:today',
            'name' => 'required',
            'test_steps' => 'required',
            'approximate_time' => 'required|integer|min:0',
            'expected_results' => 'required',
            'framework_control_id' => 'required',
            'test_frequency' => 'required|integer|min:0',
            'additional_stakeholders' => 'required',
            'teams' => 'required'
        ]);
        // check or rules valid or not
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data=array(
                'status'=>0,
                'errors'=>$errors,
            );
            return response()->json($data,200);
         }else{
            // calc  next_date form last date * test_frequency
             $next_date=date('Y-m-d',strtotime($request->last_date) + $request->test_frequency*24*60*60);
             // add new test to database
           $frameworkControlTest= FrameworkControlTest::create([
                'tester' =>$request->tester ,
                'last_date' =>$request->last_date,
                'next_date' => $next_date,
                'name' =>$request->name ,
                'test_steps' =>$request->test_steps ,
                'approximate_time' =>$request->approximate_time ,
                'framework_control_id' =>$request->framework_control_id ,
                'expected_results' =>$request->expected_results ,
                'test_frequency' =>$request->test_frequency ,
                'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
              ]);

              $this->AddTeamsOfItem($frameworkControlTest->id,'test',$request->teams);
            $data=array(
                'status'=>1,
                'message'=>__('locale.save-information-successfully'),

            );
            $message = __('compliance.A Framework Control Test') . ' "' . ($frameworkControlTest->name ?? __('locale.[No Test Name]')) . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
            write_log($frameworkControlTest->id, auth()->id(), $message, 'test');
              return response()->json($data,200);
        }


    }

     /**
     * list all tests and pass it to datatable
     *
     * @return array
     */


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $frameworkControlTest= FrameworkControlTest::find($id);
        $teams=$this->GetTeamsOfItem($frameworkControlTest->id,'test');
        $data=array(
            'test'=>$frameworkControlTest,
            'teams'=>$teams,

        );
        return response()->json($data,200);

    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validation rules
        $validator = Validator::make($request->all(), [
            'tester' => 'required|integer',
            'last_date' => 'required|after:today',
            'name' => 'required',
            'test_steps' => 'required',
            'approximate_time' => 'required|integer|min:0',
            'expected_results' => 'required',
            'framework_control_id' => 'required',
            'test_frequency' => 'required|integer|min:0',
            'additional_stakeholders' => 'required',
            'teams' => 'required'
        ]);
        // check or rules valid or not
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data=array(
                'status'=>0,
                'errors'=>$errors,
            );
            return response()->json($data,200);
         }else{
            // calc  next_date form last date * test_frequency
             $next_date=date('Y-m-d',strtotime($request->last_date) + $request->test_frequency*24*60*60);
             // add new test to database
           $frameworkControlTest= FrameworkControlTest::where('id',$request->test_id)->update([
                'tester' =>$request->tester ,
                'last_date' =>$request->last_date,
                'next_date' => $next_date,
                'name' =>$request->name ,
                'test_steps' =>$request->test_steps ,
                'approximate_time' =>$request->approximate_time ,
                'framework_control_id' =>$request->framework_control_id ,
                'expected_results' =>$request->expected_results ,
                'test_frequency' =>$request->test_frequency ,
                'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
              ]);
              $this->UpdateTeamsOfItem($id,'test',$request->teams);
            $data=array(
                'status'=>1,
                'message'=>__('locale.save-information-successfully'),

            );
              return response()->json($data,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $frameworkControlTest= FrameworkControlTest::find($id);
        FrameworkControl::where('id', $frameworkControlTest->framework_control_id)->delete();
        return response()->json(true,200);
    }

    public function ajaxGetListTest(){
        $tests= FrameworkControlTest::with('FrameworkControl')->get()->map(function($test) {
            if ($test->FrameworkControl) {
                $controlName = $test->FrameworkControl->short_name;
                if ($test->FrameworkControl->Frameworks()->count()) {
                    $controlName .= ' (' . implode(', ', $test->FrameworkControl->Frameworks()->pluck('name')->toArray()) . ')';
                }
            } else {
                $controlName = "";
            }
            return (object)[
               'responsive_id' =>  $test->id,
               'select' =>  $test->id,
               'control' => $controlName,
               'framework' => $test->FrameworkControl->Frameworks->pluck('name'),
               'family' => $test->FrameworkControl->families->pluck('name'),
               'tester' => $test->UserTester->name,
               'test_frequency' => $test->test_frequency,
               'last_date' => $test->last_date,
               'next_date' => $test->next_date,
               'Actions'=>$test->id,
            ];
        });

        return response()->json($tests,200);
    }
    public function ajaxGetControlByFramework($id){
        $frameworkControls= Framework::find($id)->FrameworkControls;
        $html='<option value="">'.__('locale.select-option').'</option>';
        foreach($frameworkControls as $frameworkControl){
            $html.='<option value="'.$frameworkControl->short_name.'">'.$frameworkControl->short_name.'</option>';
        }
        return response()->json($html,200);
    }
}
