<!-- Risk Modal -->
<div class="wizardModal modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ $title }}</h1>
                </div>
            </div>
            <div class="card-body basic-wizard important-validation">
                <div class="stepper-horizontal" id="stepper1">
                    <!-- Step 1 -->
                    <div class="stepper-1 step active">
                        <div class="step-circle"><span>1</span></div>
                        <div class="step-title">{{ __('risk.Identification') }}</div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"></div>
                    </div>
                    <!-- Step 2 -->
                    <div class="stepper-2 step">
                        <div class="step-circle"><span>2</span></div>
                        <div class="step-title">{{ __('risk.RiskAnalysis') }}</div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"></div>
                    </div>
                    <!-- Step 3 -->
                    <div class="stepper-3 step">
                        <div class="step-circle"><span>3</span></div>
                        <div class="step-title">{{ __('risk.RiskEvaulationAndTreatment') }}</div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"></div>
                    </div>
                    <!-- Step 4 -->
                    <div class="stepper-4 step">
                        <div class="step-circle"><span>4</span></div>
                        <div class="step-title">{{ __('risk.RiskReview') }}</div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"></div>
                    </div>
                </div>

                <form class="wizard-fields row" id="wizard-form"
                    action="{{ route('admin.risk_management.ajax.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="msform">
                        <div class="tab" id="step1-content">
                            <div class="wizard-fields row">
                                <!-- First Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Subject Field -->
                                    <div class="mb-1">
                                        <label class="form-label" for="subject">{{ __('locale.Subject') }}</label>
                                        <input type="text" name="subject" id="subject" class="form-control"
                                            required />
                                        <div class="invalid-feedback">{{ __('locale.Required') }}.</div>
                                    </div>
                                </div>

                                <!-- Second Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Risk Mapping -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.RiskMapping') }}</label>
                                        <select name="risk_catalog_mapping_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($riskGroupings as $riskGrouping)
                                                <optgroup label="{{ $riskGrouping->name }}">
                                                    @foreach ($riskGrouping->RiskCatalogs as $riskCatalog)
                                                        <option value="{{ $riskCatalog->id }}">
                                                            {{ $riskCatalog->number . ' - ' . $riskCatalog->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_catalog_mapping_id"></span>
                                    </div>
                                </div>

                                <!-- First Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Threat Mapping -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.ThreatMapping') }}</label>
                                        <select name="threat_catalog_mapping_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($threatGroupings as $threatGrouping)
                                                <optgroup label="{{ $threatGrouping->name }}">
                                                    @foreach ($threatGrouping->ThreatCatalogs as $ThreatCatalog)
                                                        <option value="{{ $ThreatCatalog->id }}">
                                                            {{ $ThreatCatalog->number . ' - ' . $ThreatCatalog->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <span class="error error-threat_catalog_mapping_id"></span>
                                    </div>
                                </div>

                                <!-- Second Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Category Field -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.Category') }}</label>
                                        <select class="select2 form-select" name="category_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-category_id"></span>
                                    </div>
                                </div>

                                <!-- First Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Site Location -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.SiteLocation') }}</label>
                                        <select class="form-select multiple-select2" name="location_id[]"
                                            multiple="multiple">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-location_id"></span>
                                    </div>
                                </div>

                                <!-- Second Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Additional Stakeholders -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.AdditionalStakeholders') }}</label>
                                        <select name="additional_stakeholder_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($enabledUsers as $additionalStakeholder)
                                                <option value="{{ $additionalStakeholder->id }}">
                                                    {{ $additionalStakeholder->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-additional_stakeholder_id"></span>
                                    </div>
                                </div>

                                <!-- First Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Owner -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.Owner') }}</label>
                                        <select class="select2 form-select" name="owner_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-owner_id"></span>
                                    </div>
                                </div>

                                <!-- Second Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Owner's Manager -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.OwnersManager') }}</label>
                                        <select class="select2 form-select" name="owner_manager_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                        </select>
                                        <span class="error error-owners_manager_id"></span>
                                    </div>
                                </div>

                                <!-- First Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Tags -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.Tags') }}</label>
                                        <select name="tags[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-tags"></span>
                                    </div>
                                </div>

                                <!-- Second Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- Team -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.Team') }}</label>
                                        <select name="team_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-team_id"></span>
                                    </div>
                                </div>

                                <!-- First Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- External Reference Id -->
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.ExternalReferenceId') }}</label>
                                        <input type="text" name="reference_id" class="form-control dt-post"
                                            aria-label="{{ __('report.ExternalReferenceId') }}" />
                                        <span class="error error-reference_id"></span>
                                    </div>
                                </div>

                                <!-- Second Column (6) -->
                                <div class="col-12 col-md-6 mb-2">
                                    <!-- You can add additional form fields here if needed -->
                                </div>
                            </div>
                        </div>



                        <!-- Step 2 Content -->
                        <div class="tab" id="step2-content" style="display: none;">
                            <div class="wizard-fields row">
                                <!-- Left column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Control Regulation --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('report.ControlRegulation') }}</label>
                                        <select class="select2 form-select" name="framework_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                            @foreach ($frameworks as $framework)
                                                <option value="{{ $framework->id }}"
                                                    data-controls="{{ json_encode($framework->FrameworkControls) }}">
                                                    {{ $framework->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-framework_id"></span>
                                    </div>
                                </div>

                                <!-- Right column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Control Number --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('report.ControlNumber') }}</label>
                                        <select class="select2 form-select" name="control_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                        </select>
                                        <span class="error error-control_id"></span>
                                    </div>

                                </div>

                                <!-- Left column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Affected Assets --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('report.AffectedAssets') }}</label>
                                        <select name="affected_asset_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @if (count($assetGroups))
                                                <optgroup label="{{ __('risk.AssetGroups') }}">
                                                    @foreach ($assetGroups as $assetGroup)
                                                        <option value="{{ $assetGroup->id }}_group">
                                                            {{ $assetGroup->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                            <optgroup label="{{ __('locale.Standards') }} {{ __('report.Assets') }}">
                                                @foreach ($assets as $asset)
                                                    <option value="{{ $asset->id }}_asset">{{ $asset->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <span class="error error-affected_asset_id"></span>
                                    </div>
                                </div>

                                <!-- Right column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Technology --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.Technology') }}</label>
                                        <select name="technology_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($technologies as $technology)
                                                <option value="{{ $technology->id }}">{{ $technology->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-technology_id"></span>
                                    </div>
                                </div>

                                <!-- Left column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Risk Source --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.ImpactScope') }}</label>
                                        <select class="select2 form-select" name="risk_source_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                            @foreach ($riskSources as $riskSource)
                                                <option value="{{ $riskSource->id }}">{{ $riskSource->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_source_id"></span>
                                    </div>
                                </div>

                                <!-- Right column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Current Impact --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.CurrentImpact') }}</label>
                                        <select class="select2 form-select" name="current_impact_id">
                                            <option value="" disabled hidden selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($impacts as $impact)
                                                <option value="{{ $impact->id }}">{{ $impact->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-current_impact_id"></span>
                                    </div>
                                </div>

                                <!-- Left column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Current Likelihood --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.CurrentLikelihood') }}</label>
                                        <select class="select2 form-select" name="current_likelihood_id">
                                            <option value="" disabled hidden selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($riskLikelihoods as $riskLikelihood)
                                                <option value="{{ $riskLikelihood->id }}">{{ $riskLikelihood->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-current_likelihood_id"></span>
                                    </div>
                                </div>

                                <!-- Right column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Risk Scoring Method --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.RiskScoringMethod') }}</label>
                                        <select class="select2 form-select" name="risk_scoring_method_id">
                                            <option value="" disabled hidden>{{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($riskScoringMethods as $riskScoringMethod)
                                                <option value="{{ $riskScoringMethod->id }}">
                                                    {{ $riskScoringMethod->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_scoring_method_id"></span>
                                    </div>
                                </div>

                                <!-- Left column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Risk Assessment --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('risk.ResponsiblePart') }}</label>
                                        <textarea class="form-control" name="risk_assessment" rows="3"></textarea>
                                        <span class="error error-risk_assessment"></span>
                                    </div>
                                </div>

                                <!-- Right column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Additional Notes --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __("locale.KRI'S") }}</label>
                                        <div id="risk_addational_notes_submit"></div>
                                    </div>
                                </div>

                                <!-- Left column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Supporting Documentation --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('report.SupportingDocumentation') }}</label>
                                        <input type="file" multiple name="supporting_documentation[]"
                                            class="form-control dt-post"
                                            aria-label="{{ __('locale.SupportingDocumentation') }}" />
                                        <span class="error error-supporting_documentation"></span>
                                    </div>
                                </div>

                                <!-- Right column (6) -->
                                <div class="col-12 col-md-6 mb-3">

                                    {{-- Risk Description --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.Description') }}</label>
                                        <textarea class="form-control" name="risk_description" rows="3"></textarea>
                                        <span class="error error-risk_description"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Step 3 Content (Risk Evaluation and Treatment) -->
                        <div class="tab" id="step3-content" style="display: none;">
                            <div class="wizard-fields">
                                <!-- Plan a Mitigation Option -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.SelectOption') }}</label>
                                            <select id="planMitigationOption" class="form-select" name="mitigation_option">
                                                <option class="step-3-option" selected value="NoMitigation"
                                                    name="NoMitigation">
                                                    {{ __('locale.No Mitigation') }}
                                                </option>
                                                <option class="step-3-option" value="PlanAMitigation"
                                                    name="PlanAMitigation">
                                                    {{ __('locale.Plan A Mitigation') }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- First Row -->
                                <div id="planMitigationInputs" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 col-md-6">

                                            {{-- Mitigation Planning Date --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.MitigationPlanning') }}</label>
                                                <input name="planned_mitigation_date"
                                                    class="form-control flatpickr-date-time-compliance" />
                                                <span class="error error-planned_mitigation_date "></span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            {{-- Mitigation Effort --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.MitigationEffort') }}</label>
                                                <select class="select2 form-select" name="mitigation_effort">
                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                    @foreach ($mitigationEfforts as $mitigationEffort)
                                                        <option value="{{ $mitigationEffort->id }}">
                                                            {{ $mitigationEffort->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-mitigation_effort"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            {{-- Planning Strategy --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.PlanningStrategy') }}</label>
                                                <select class="select2 form-select" name="planning_strategy">
                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                    @foreach ($planningStrategies as $planningStrategy)
                                                        <option value="{{ $planningStrategy->id }}">
                                                            {{ $planningStrategy->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-planning_strategy"></span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            {{-- Mitigation Owner --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.MitigationOwner') }}</label>
                                                <select class="select2 form-select" name="mitigation_owner_id">
                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                    @foreach ($enabledUsers as $owner)
                                                        <option value="{{ $owner->id }}">
                                                            {{ $owner->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-mitigation_owner_id"></span>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Third Row -->
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            {{-- Mitigation Cost --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.MitigationCost') }}</label>
                                                <select name="mitigation_cost" id="mitigation_cost"
                                                    class="form-control">
                                                    @foreach ($mitigationCosts as $mitigationCost)
                                                        <option value="{{ $mitigationCost->id }}">
                                                            {{ $mitigationCost->name }}
                                                            @php
                                                                $valuation_level_name = '';
                                                                if (!empty($mitigationCost->valuation_level_name)) {
                                                                    $valuation_level_name =
                                                                        ' (' .
                                                                        $mitigationCost->valuation_level_name .
                                                                        ')';
                                                                }

                                                                if (
                                                                    $mitigationCost->min_value ===
                                                                    $mitigationCost->max_value
                                                                ) {
                                                                    echo get_setting('currency') .
                                                                        number_format($mitigationCost->min_value) .
                                                                        $valuation_level_name;
                                                                } else {
                                                                    echo get_setting('currency') .
                                                                        number_format($mitigationCost->min_value) .
                                                                        ' to ' .
                                                                        get_setting('currency') .
                                                                        number_format($mitigationCost->max_value) .
                                                                        $valuation_level_name;
                                                                }
                                                            @endphp
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-mitigation_cost"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            {{-- Mitigation Percent --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.MitigationPercent') }}</label>
                                                <input type="number" min="0" max="100" class="form-control" name="mitigation_percent">
                                                <span class="error error-mitigation_percent"></span>
                                                
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Fourth Row -->
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            {{-- Mitigation Team --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.MitigationTeam') }}</label>
                                                <select name="mitigation_team_id[]"
                                                    class="form-select multiple-select2" multiple="multiple">
                                                    @foreach ($teams as $team)
                                                        <option value="{{ $team->id }}">
                                                            {{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-mitigation_team_id"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            {{-- Current Solution --}}
                                            <div class="mb-1">
                                                <label class="text-label">{{ __('risk.CurrentSolution') }}</label>
                                                <div id="risk_current_solution"></div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Fifth Row -->
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            {{-- Mitigation Controls --}}
                                            <div class="mb-1">
                                                <label
                                                    class="text-label">{{ __('locale.MitigationControls') }}</label>
                                                <select name="mitigation_control_id[]"
                                                    class="form-select multiple-select2" multiple="multiple">
                                                    @foreach ($frameworks as $framework)
                                                        @foreach ($framework->FrameworkControls as $control)
                                                            <option value="{{ $control->id }}">
                                                                {{ $control->short_name }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                                <span class="error error-mitigation_control_id"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sixth Row -->
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            {{-- Security Recommendations --}}
                                            <div class="mb-1">
                                                <label
                                                    class="text-label">{{ __('risk.SecurityRecommendations') }}</label>
                                                <textarea class="form-control" name="security_recommendations" rows="3"></textarea>
                                                <span class="error error-security_recommendations "></span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            {{-- Security Requirements --}}
                                            <div class="mb-1">
                                                <label
                                                    class="text-label">{{ __('risk.SecurityRequirements') }}</label>
                                                <textarea class="form-control" name="security_requirements" rows="3"></textarea>
                                                <span class="error error-security_requirements "></span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- Step 4 Content (Risk Evaluation and Treatment) -->
                        <div class="tab" id="step4-content" style="display: none;">
                            <div class="wizard-fields row">
                                <!-- Perform a Review Option -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.SelectOption') }}</label>
                                            <select id="performReviewOption" name="review_option" class="form-select">
                                                <option class="step-3-option" selected value="NoReview">
                                                    {{ __('locale.No Review') }}
                                                </option>
                                                <option class="step-3-option" value="PerformAReview">
                                                    {{ __('locale.Perform a Review') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="planReviewInputs" style="display: none;">

                                    {{-- Review --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Review') }}</label>
                                        <select class="select2 form-select" name="review">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($reviews as $review)
                                                <option value="{{ $review->id }}">
                                                    {{ $review->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-review"></span>
                                    </div>
                                    {{-- Next Step --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.NextStep') }}</label>
                                        <select class="select2 form-select" name="next_step">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($nextSteps as $nextStep)
                                                <option value="{{ $nextStep->id }}">
                                                    {{ $nextStep->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-next_step"></span>
                                    </div>
                                    {{-- Project Name --}}
                                    <div class="mb-1 d-none" id="project-container">
                                        <label class="text-label">{{ __('locale.ProjectName') }}</label>
                                        <select class="select2 form-select" name="project">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">
                                                    {{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-project"></span>
                                    </div>
                                    <div class="mb-1 mt-1">
                                        <label class="text-label">{{ __('locale.NextReviewDate') }}</label>
                                        <input name="next_review_date"
                                            class="form-control flatpickr-date-time-compliance" />
                                        <span class="error error-next_review_date "></span>
                                    </div>
                                    {{-- Comment --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Comment') }}</label>
                                        <textarea class="form-control" name="comments" rows="3"></textarea>
                                        <span class="error error-comments "></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Wizard Navigation -->
                <div class="wizard-footer d-flex gap-2 justify-content-end m-3">
                    <button class="btn alert-light-primary" id="backbtn" onclick="backStep()">{{ __('locale.Back') }}</button>
                    <button class="btn btn-primary" id="nextbtn" onclick="validateStep()">{{ __('locale.Next') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
