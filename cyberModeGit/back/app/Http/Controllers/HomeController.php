<?php

namespace App\Http\Controllers;

use App\Http\Traits\LdapTrait;
use App\Models\Risk;
use App\Models\RiskLevel;
use Notific;
use Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    use LdapTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Storage::exists('about/content.text')) {
            $data['vision'] = '';
            $data['message'] = '';
            $data['mission'] = '';
            $data['objectives'] = '';
            $data['responsibilities'] = '';

            // Store temporary about data to file
            Storage::put('about/content.text', json_encode($data));
        }
        // // Read about data from file
        $about = json_decode(Storage::get('about/content.text'));
        return view('auth.login', compact('about'));
    }
    /**
     * test route.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        $risks = Risk::get()->map(function ($risk) {
            $calculatedRisk = $risk->riskScoring()->select('calculated_risk')->first()->calculated_risk;
            return (object) [
                'responsive_id' => $risk->id,
                'status' => $risk->status,
                'subject' => $risk->subject,
                'inherent_risk_current' => [$calculatedRisk, $this->riskScoringColor($calculatedRisk)],
                // 'mitigation_planned' => 'No',
                // 'management_review' => 'No',
                'created_at' => $risk->created_at->format(get_default_date_format()),
                'closure_date' => ($risk->closure) ? $risk->closure->closure_date : '',
                'Actions' => $risk->id,
            ];
        });
        return view('test', compact('risks'));
    }

    protected function riskScoringColor($riskScoring)
    {
        return RiskLevel::orderBy('value', 'desc')->where('value', '<=', $riskScoring)->first()->color;
    }
}
