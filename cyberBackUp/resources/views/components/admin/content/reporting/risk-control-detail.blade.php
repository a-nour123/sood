<div class="card">
    <?php
    $header_color = get_risk_color($control->calculated_risk);
    $control_frameworks = get_mapping_control_frameworks($control->gr_id);
    $risks = GetRiskOfControl($control);
    ?>
    <div class="card-header">
        <div class="row">
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.ControlNumber') }} :</code>
                    {{ $control->control_number ? $control->control_number : '-' }}</p>
            </div>
  			@php
                $family = json_decode($control->control_family_name);
                $name = $family->{app()->getLocale()} ?? '-';

            @endphp
            <div class="col-4 mt-1">
                <p class="card-text">
                    <code>{{ __('report.ControlFamily') }} :</code>
                    {{ $name }}
                </p>
            </div> 
           <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.ControlClass') }} :</code>
                    {{ $control->control_class_name ? $control->control_class_name : '-' }}</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.ControlPhase') }} :</code>
                    {{ $control->control_phase_name ? $control->control_phase_name : '-' }}</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.ControlPriority') }} :</code>
                    {{ $control->control_priority_name ? $control->control_priority_name : '-' }}</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.MitigationPercent') }} :</code>
                    {{ $control->mitigation_percent ? $control->mitigation_percent : '-' }} %</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.ControlOwner') }} :</code>
                    {{ $control->control_owner_name ? $control->control_owner_name : '-' }}</p>
            </div>
            <div class="col-8 mt-1">
                <p class="card-text"><code>{{ __('report.SupplementalGuidance') }} :</code>
                    {{ $control->supplemental_guidance ? $control->supplemental_guidance : '-' }}
                </p>
            </div>
        </div>
    </div>
    <div class="card-body">

        @if (count($control_frameworks))
        <div class="row">
            <div class="table-responsive" style="width: 50%;margin:auto">
                <div class="col-12 mt-1">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th>{{ __('report.Framework') }}</th>
                                <th>{{ __('report.Control') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($control_frameworks as $framework)
                            <tr>
                                <td>{{ $framework->framework_name }}</td>
                                <td>{{ $framework->short_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="table-responsive">
                <div class="col-12 mt-1">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>{{ __('locale.ID') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('locale.Subject') }}</th>
                                <th>{{ __('locale.SiteLocation') }}</th>
                                <th>{{ __('locale.Team') }}</th>
                                <th>{{ __('report.InherentRisk') }}</th>
                                <th>{{ __('locale.DaysOpen') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($risks) > 0)
                            @foreach ($risks as $risk)
                            <?php
                                    $calculatedRisk = $risk
                                        ->riskScoring()
                                        ->select('calculated_risk')
                                        ->first()->calculated_risk;
                                    ?>
                            <tr>
                                <td>{{ $risk->id }}</td>
                                <td>{{ $risk->status }}</td>
                                <td>{{ $risk->subject }}</td>
                                <td>{{ $risk->locationsOfRisk->pluck('name')->implode(',') }}</td>
                                <td>{{ $risk->teamsForRisk->pluck('name') ? $risk->teamsForRisk->pluck('name') : '-' }}
                                </td>
                                <td>
                                    <div class="risk-cell-holder" style="position:relative;">
                                        {{ $calculatedRisk }}
                                        <span class="risk-color" style="background-color:{{ riskScoringColor($calculatedRisk) }};position: absolute;width: 20px;height: 20px;right: 10px;top: 50%;transform: translateY(-50%);border-radius: 2px;border: 1px solid;"></span>
                                    </div>


                                </td>
                                @php
                                $closeDate = $risk->closure->closure_date ?? date('Y-m-d H:i:s');
                                @endphp
                                <td>
                                    {{-- {{ DateDiffRisk($risk->status, $risk->closure->closure_date, $risk->submission_date) }} --}}
                                    {{ DateDiffRisk($risk->status, $closeDate, $risk->submission_date) }}
                                    {{-- {{$closeDate}} --}}
                                </td>
                                {{-- <td>{{$row->id}}</td> --}}
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='6' class="text-center">{{ __('locale.NoDataAvailable') }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
