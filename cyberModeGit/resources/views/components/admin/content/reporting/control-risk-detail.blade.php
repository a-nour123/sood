<div class="row">
    <div class="card">
        <?php
        $risk_id = convert_id($risk->id);
        $status = $risk->status;
        $subject = $risk->subject;
        $calculated_risk = $risk->calculated_risk;
        $color = get_risk_color($calculated_risk);

        $controls = GetControlOfRisk($risk);
        ?>
        <div class="card-header">
            <div class="col-4 mt-1 text-center">
                <p class="card-text"><code>{{ __('report.RiskId') }} :</code>
                    {{ $risk_id ? $risk_id : '-' }}</p>
            </div>
            <div class="col-4 mt-1 text-center">
                <p class="card-text"><code>{{ __('locale.Subject') }} :</code>
                    {{ $subject ? $subject : '-' }}</p>
            </div>
            <div class="col-4 mt-1 text-center">
                <p class="card-text"><code>{{ __('report.InherentRisk') }} :</code>
                    {{ $calculated_risk ? $calculated_risk : '-' }}</p>
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
                                    <th>{{ __('report.ControlShortName') }}</th>
                                    <th>{{ __('report.ControlFamily') }}</th>
                                    <th>{{ __('report.Framework') }}</th>
                                    <th>{{ __('report.ControlNumber') }}</th>

                                    <th>{{ __('report.ControlOwner') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (count($controls) > 0)
                                    @foreach ($controls as $control)
                                        <?php
                                        
                                        ?>
                                        <tr>
                                            <td>{{ $control->id }}</td>
                                            <td>{{ $control->short_name }}</td>
                                            <td>{{ $control->Family->name }}</td>
                                            <td>{{ $control->Frameworks->pluck('name') }}</td>
                                            <td>{{ $control->control_number }}</td>

                                            <td>{{ $control->control_owner }}</td>


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

</div>
