<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\CustomRiskModelValue;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\RiskLevel;
use App\Models\RiskModel;
use App\Models\RiskScoring;
use App\Models\RiskScoringHistory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class RiskformulaController extends Controller
{
    public function showRiskData()
    {
        $riskmodels = RiskModel::all();
        $risklevels = RiskLevel::orderBy('value')->get();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')],['name' => __('locale.RiskCalculation')]];

        // dd($risklevels);
        $impacts = Impact::orderBy('id', 'DESC')->get();
        $likelihoods = Likelihood::orderBy('id')->get();
        $currentRiskModel = Setting::where('name', '=', 'risk_model')->first()->value;

        $customrRiskScringsData = [];
        foreach ($impacts as $impact) {
            $customrRiskScringsData[$impact->id] = [
                array('id' => $impact->id, 'name' => $impact->name)
            ];

            foreach ($likelihoods as $likelihood) {
                array_push($customrRiskScringsData[$impact->id], $this->calculateRisk($impact->id, $likelihood->id));
            }
        }

        // dd($customrRiskScringsData);
        return view('admin.content.configure.RiskCalculate', compact('riskmodels', 'risklevels','breadcrumbs','customrRiskScringsData', 'likelihoods', 'currentRiskModel'));
    }

    public function updateRiskCalculate(Request $request)
    {
        // dd($request->all());
        // $riskmodels = RiskModel::all();
        $settingriskmodel = Setting::where('name', '=', 'risk_model')->first();

        // If the ris model is not changed ignore update
        if ($settingriskmodel->value == $request->value) {
            return redirect()->route('admin.configure.riskmodels.show');
        }

        $settingriskmodel->update(['value' => $request->value]);
        $riskscorings =   RiskScoring::select(['id', 'calculated_risk', 'CLASSIC_likelihood', 'CLASSIC_impact'])->where('scoring_method', '=', 1)->get();
        foreach ($riskscorings as $riskscoring) {
            $likelihood = $riskscoring->CLASSIC_likelihood;
            $impact = $riskscoring->CLASSIC_impact;

            $count_of_impacts = Impact::count();
            $count_of_likelihoods = Likelihood::count();
            $settingriskmodelvalue = '';
            $max_risk = '';
            $risk = '';
            if ($count_of_impacts > 0 && $count_of_likelihoods > 0 && in_array($impact, range(1, $count_of_impacts)) && in_array($likelihood, range(1, $count_of_likelihoods))) {
                $settingriskmodelvalue = $settingriskmodel['value'];
                // Pick the risk formula
                if ($settingriskmodelvalue == 1) {
                    // $max_risk = 35;
                    $max_risk = ($count_of_likelihoods * $count_of_impacts) + (2 * $count_of_impacts);
                    $risk = ($likelihood * $impact) + (2 * $impact);
                } else if ($settingriskmodelvalue == 2) {
                    // $max_risk = 30;
                    $max_risk = ($count_of_likelihoods * $count_of_impacts) + $count_of_impacts;
                    $risk = ($likelihood * $impact) + $impact;
                } else if ($settingriskmodelvalue == 3) {
                    // $max_risk = 25;
                    $max_risk = $count_of_likelihoods * $count_of_impacts;
                    $risk = $likelihood * $impact;
                } else if ($settingriskmodelvalue == 4) {
                    // $max_risk = 30;
                    $max_risk = $count_of_likelihoods * $count_of_impacts + $count_of_likelihoods;
                    $risk = ($likelihood * $impact) + $likelihood;
                } else if ($settingriskmodelvalue == 5) {
                    // $max_risk = 35;
                    $max_risk = ($count_of_likelihoods * $count_of_impacts) + (2 * $count_of_likelihoods);
                    $risk = ($likelihood * $impact) + (2 * $likelihood);
                } else if ($settingriskmodelvalue == 6) {
                    $max_risk = 10;
                    $risk = CustomRiskModelValue::select('value')->where('impact_id', '=', $impact)->where('likelihood_id', '=', $likelihood)->get();

                    // $risk = get_stored_risk_score($impact, $likelihood);
                }
                // This puts it on a 1 to 10 scale similar to CVSS
                $risk = round($risk * (10 / $max_risk), 1);
            }
            // If the impact or likelihood were not specified risk is 10

            else {
                $risk = Setting::select('value')->where('name', '=', 'default_risk_score')->first()['value'];
            }
            if (!$risk) {
                $risk = 0;
            }

            // Update the value in the DB
            RiskScoring::where('id', '=', $riskscoring->id)->first()->update(['calculated_risk' => $risk]);
            // $riskscoringhistory = RiskScoringHistory::select('calculated_risk')->where('risk_id', '=', $riskscoring->id)->orderBy('last_update', 'DESC')->limit(1)->get();
            // if (!$riskscoringhistory && $riskscoringhistory[0] != $risk) {
            //     $last_update = date('Y-m-d H:i:s');
            //     // There is no entry like that, adding new one
            //     RiskScoringHistory::create([
            //         'risk_id' => $riskscoring->id,
            //         'calculated_risk' => $risk,
            //         'last_update' => $last_update
            //     ]);
            // }
            // //////
            // $risk_id = $riskscoring['id'] + 1000;
            // $risk_residual_id = (int)$risk_id - 1000;


            // // Add residual risk scoring history
            // $residual_risk = get_residual_risk($risk['id'] + 1000);
            // add_residual_risk_scoring_history($risk['id'], $residual_risk);
        }
        //    // Calculate the risk via classic method
        //    $calculated_risk = calculate_risk($impact, $likelihood);

        //    // If the calculated risk is different than what is in the DB
        //    if ($calculated_risk != $risk['calculated_risk'])
        //    {

        //    }
        // dd("hgfdfghjk")/;
        return redirect()->route('admin.configure.riskmodels.show');
        // return view('admin.content.configure.RiskCalculate', compact('riskmodels'));
    }

    public function Add_Impact()
    {
        $old_likelihood_value = Likelihood::count();
        $old_impact_value =  Impact::count();

        $value = Impact::max('id') + 1;
        $impact = Impact::create([
            'id' => $value,
            'name' => "Impact " . $value
        ]);

        $new_likelihood_value = Likelihood::count();
        $new_impact_value =  Impact::count();

        $impact_value = $new_impact_value * ($new_impact_value / $old_impact_value);

        foreach (RiskScoring::all() as $riskscoring) {
            $riskscoring->update([
                'CLASSIC_impact' => round($riskscoring->CLASSIC_impact * ($new_impact_value / $old_impact_value)),
                'CLASSIC_likelihood' => round($riskscoring->CLASSIC_likelihood * ($new_likelihood_value / $old_likelihood_value))
            ]);
        }

        return redirect()->back();
    }
    public function Add_Likelhood()
    {
        $old_likelihood_value = Likelihood::count();
        $old_impact_value =  Impact::count();

        $value = Likelihood::max('id') + 1;
        $likelihood = Likelihood::create([
            'id' => $value,
            'name' => "Likelihood " . $value
        ]);

        $new_likelihood_value = Likelihood::count();
        $new_impact_value =  Impact::count();
        $impact_value = $new_impact_value * ($new_impact_value / $old_impact_value);
        foreach (RiskScoring::all() as $riskscoring) {
            $riskscoring->update([
                'CLASSIC_impact' => round($riskscoring->CLASSIC_impact * ($new_impact_value / $old_impact_value)),
                'CLASSIC_likelihood' => round($riskscoring->CLASSIC_likelihood * ($new_likelihood_value / $old_likelihood_value))
            ]);
        }

        return redirect()->back();
    }
    public function delete_Impactorlikelhood(Request $request, $type)
    {
        $impactOrlikelhood = '';
        if ($type == 'impact') {
            $impactOrlikelhood = Impact::orderBy('id', 'desc')->first();
        } else if ($type == 'likelihood') {
            $impactOrlikelhood = Likelihood::orderBy('id', 'desc')->first();
        }
        try {
            if ($impactOrlikelhood && $impactOrlikelhood->id > 1) {
                $old_likelihood_value = Likelihood::count();
                $old_impact_value =  Impact::count();

                // Delete a impact value
                $impactOrlikelhood->delete();

                $new_likelihood_value =  Likelihood::count();
                $new_impact_value =  Impact::count();

                $impactOrlikelhood_value = $new_impact_value * ($new_impact_value / $old_impact_value);
                foreach (RiskScoring::all() as $riskscoring) {
                    $riskscoring->update([
                        'CLASSIC_impact' => round($riskscoring->CLASSIC_impact * ($new_impact_value / $old_impact_value)),
                        'CLASSIC_likelihood' => round($riskscoring->CLASSIC_likelihood * ($new_likelihood_value / $old_likelihood_value))
                    ]);
                }
            }
        } catch (\Throwable $th) {
        //     throw $th;
        }

        return redirect()->back();
    }


    protected function calculateRisk($CLASSIC_impact, $CLASSIC_likelihood)
    {
        $settingriskmodel = Setting::where('name', '=', 'risk_model')->first();
        $countOfImpacts = Impact::count();
        $countOfLikelihoods = Likelihood::count();
        $settingriskmodelvalue = '';
        $max_risk = '';
        $risk = '';
        if ($countOfImpacts > 0 && $countOfLikelihoods > 0 && $CLASSIC_impact && $CLASSIC_likelihood) {  // If the impact or likelihood are passed
            $settingriskmodelvalue = $settingriskmodel['value'];
            // Pick the risk formula
            if ($settingriskmodelvalue == 1) {
                // $max_risk = 35;
                $max_risk = ($countOfLikelihoods * $countOfImpacts) + (2 * $countOfImpacts);
                $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + (2 * $CLASSIC_impact);
            } else if ($settingriskmodelvalue == 2) {
                // $max_risk = 30;
                $max_risk = ($countOfLikelihoods * $countOfImpacts) + $countOfImpacts;
                $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + $CLASSIC_impact;
            } else if ($settingriskmodelvalue == 3) {
                // $max_risk = 25;
                $max_risk = $countOfLikelihoods * $countOfImpacts;
                $risk = $CLASSIC_likelihood * $CLASSIC_impact;
            } else if ($settingriskmodelvalue == 4) {
                // $max_risk = 30;
                $max_risk = $countOfLikelihoods * $countOfImpacts + $countOfLikelihoods;
                $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + $CLASSIC_likelihood;
            } else if ($settingriskmodelvalue == 5) {
                // $max_risk = 35;
                $max_risk = ($countOfLikelihoods * $countOfImpacts) + (2 * $countOfLikelihoods);
                $risk = ($CLASSIC_likelihood * $CLASSIC_impact) + (2 * $CLASSIC_likelihood);
            } else if ($settingriskmodelvalue == 6) {
                $max_risk = 10;
                $risk = CustomRiskModelValue::select('value')->where('impact_id', '=', $CLASSIC_impact)->where('likelihood_id', '=', $CLASSIC_likelihood)->get();

                // $risk = get_stored_risk_score($impact, $likelihood);
            }
            // This puts it on a 1 to 10 scale similar to CVSS
            $risk = round($risk * (10 / $max_risk), 1);
        } else { // If the impact or likelihood are not passed
            $risk = Setting::select('value')->where('name', 'default_risk_score')->first()['value'];
        }

        return $risk ? $risk : 0;
    }

    public function updateimpact(Request $request,$id){
      $impact=Impact::find($id);
      $impact->update([
        "name"=>$request->name
      ]);
      return $impact->name;
    }
    public function updatelikelhood(Request $request,$id){
        $likelihood=Likelihood::find($id);
        $likelihood->update([
          "name"=>$request->name
        ]);
        return $likelihood->name;
      }


}
