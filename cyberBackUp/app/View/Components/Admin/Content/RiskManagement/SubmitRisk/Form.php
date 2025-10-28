<?php

namespace App\View\Components\Admin\Content\RiskManagement\SubmitRisk;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $riskGroupings;
    public $threatGroupings;
    public $locations;
    public $frameworks;
    public $assets;
    public $assetGroups;
    public $categories;
    public $technologies;
    public $teams;
    public $enabledUsers;
    public $riskSources;
    public $riskScoringMethods;
    public $riskLikelihoods;
    public $impacts;
    public $tags;
    public $owners;
    public $planningStrategies;
    public $mitigationEfforts;
    public $mitigationCosts;
    public $reviews;
    public $nextSteps;
    public $projects;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id, $title, $riskGroupings, $threatGroupings, $locations, $frameworks, 
        $assets, $assetGroups, $categories, $technologies, $teams, $enabledUsers, 
        $riskSources, $riskScoringMethods, $riskLikelihoods, $impacts, $tags, 
        $owners, $planningStrategies, $mitigationEfforts, $mitigationCosts,
        $reviews, $nextSteps, $projects
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->riskGroupings = $riskGroupings;
        $this->threatGroupings = $threatGroupings;
        $this->locations = $locations;
        $this->frameworks = $frameworks;
        $this->assets = $assets;
        $this->assetGroups = $assetGroups;
        $this->categories = $categories;
        $this->technologies = $technologies;
        $this->teams = $teams;
        $this->enabledUsers = $enabledUsers;
        $this->riskSources = $riskSources;
        $this->riskScoringMethods = $riskScoringMethods;
        $this->riskLikelihoods = $riskLikelihoods;
        $this->impacts = $impacts;
        $this->tags = $tags;
        $this->owners = $owners;
        $this->planningStrategies = $planningStrategies;
        $this->mitigationEfforts = $mitigationEfforts;
        $this->mitigationCosts = $mitigationCosts;
        $this->reviews = $reviews;
        $this->nextSteps = $nextSteps;
        $this->projects = $projects;
        
        
    }
    

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.risk-management.submit-risk.form');
    }
}
