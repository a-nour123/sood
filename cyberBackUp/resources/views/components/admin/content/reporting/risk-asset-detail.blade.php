<div class="card">
    <?php
        $risks = $asset->risks;
        // $control_frameworks = get_mapping_control_frameworks($control->gr_id);
        // $risks = GetRiskOfControl($control);
        // dd($asset);
    ?>
    <div class="card-header">
        <div class="row">
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.AssetName') }} :</code>
                    {{ $asset->name ? $asset->name : '-' }}</p>
            </div>
           <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.AssetIp') }} :</code>
                    {{ $asset->ip ? $asset->ip : '-' }}</p>
            </div>
             <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.AssetOwnerEmail') }} :</code>
                    {{ $asset->owner_email ? $asset->owner_email : '-' }}</p>
            </div>
            {{-- <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('locale.HighestInherentRisk') }} :</code>
                    {{ $asset->id ? $asset->id : '-' }}</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('locale.AverageInherentRisk') }} :</code>
                    {{ $asset->id ? $asset->id : '-' }}</p>
            </div> --}}
            {{-- <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('locale.HighestResidualRisk') }} :</code>
                    {{ $asset->id ? $asset->id : '-' }}</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('locale.AverageResidualRisk') }} :</code>
                    {{ $asset->id ? $asset->id : '-' }}</p>
            </div> --}}
            
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.AssetSiteLocation') }} :</code>
                    {{ $asset->location_id ? $asset->location->name : '-' }}</p>
                </p>
            </div> 
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.AssetValue') }} :</code>
                    {{ $asset->asset_value_level_id ? $asset->assetValueLevel->name : '-' }}</p>
            </div>
            <div class="col-4 mt-1">
                <p class="card-text"><code>{{ __('report.AssetCategory') }} :</code>
                    {{ $asset->asset_category_id ? $asset->assetCategory->name : '-' }}</p>
            </div>
        </div>
    </div>
    <div class="card-body">
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
                            @if (count($risks)>0)
                                
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
                                    <td>{{ $risk->locationsOfRisk->pluck('name')->implode(', ') }}</td>
                                    <td>{{ $risk->teamsForRisk->pluck('name') ? $risk->teamsForRisk->pluck('name') : '-' }}
                                    </td>
                                    <td>
                                        <div class="risk-cell-holder" style="position:relative;">
                                            {{ $calculatedRisk }}
                                            <span class="risk-color"
                                            style="background-color:{{ riskScoringColor($calculatedRisk) }};position: absolute;width: 20px;height: 20px;right: 10px;top: 50%;transform: translateY(-50%);border-radius: 2px;border: 1px solid;"></span>
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
