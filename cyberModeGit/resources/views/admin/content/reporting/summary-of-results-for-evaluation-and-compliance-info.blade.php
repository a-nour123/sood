@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.summary_of_results_for_evaluation_and_compliance'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
@endsection

@section('content')
    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('report.Report') }}:
                                {{ __('report.summary_of_results_for_evaluation_and_compliance_to_the_basic_controls_of_cybersecurity') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row">

        <section id="apexchart">
            <div class="row">
                <!-- total framework control statuses Starts-->
                <div class="col-12">
                    <div class="card">
                        <div class="alert alert-primary" role="alert">
                            <div class="alert-body text-center">
                                {{ __('report.The_general_level_of_cybersecurity_assessment_of_the_entity') }}</div>
                        </div>
                        <div class="card-body pt-0 row align-items-center">
                            <div class="col-xl-6 col-12">
                                <div id="donut-chart-total"></div>
                            </div>
                            <div class="col-xl-6 col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th colspan="2">الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('locale.Not Applicable', [], 'en') }} -
                                                {{ __('locale.Not Applicable', [], 'ar') }}</td>
                                            <td>{{ $data['total']['Not Applicable'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('locale.Not Implemented', [], 'en') }} -
                                                {{ __('locale.Not Implemented', [], 'ar') }}</td>
                                            <td>{{ $data['total']['Not Implemented'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('locale.Partially Implemented', [], 'en') }} -
                                                {{ __('locale.Partially Implemented', [], 'ar') }}</td>
                                            <td>{{ $data['total']['Partially Implemented'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('locale.Implemented', [], 'en') }} -
                                                {{ __('locale.Implemented', [], 'ar') }}</td>
                                            <td>{{ $data['total']['Implemented'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- total framework control statuses Ends-->
                
                @foreach ($domainsArray as $domain)
                    <div class="col-12">
                        <div class="card">
                            <div class="alert alert-primary" role="alert">
                                <div class="alert-body text-center">{{ $domain['name'] }}</div>
                            </div>
                            <div class="card-body pt-0 row align-items-center">
                                <div class="col-xl-6 col-12">
                                    <div id="donut-chart-domain-{{ $domain['id'] }}"></div>
                                </div>
                                <div class="col-xl-6 col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th colspan="2">الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('locale.Not Applicable', [], 'en') }} -
                                                    {{ __('locale.Not Applicable', [], 'ar') }}</td>
                                                <td>{{ $domain['Not Applicable'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('locale.Not Implemented', [], 'en') }} -
                                                    {{ __('locale.Not Implemented', [], 'ar') }}</td>
                                                <td>{{ $domain['Not Implemented'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('locale.Partially Implemented', [], 'en') }} -
                                                    {{ __('locale.Partially Implemented', [], 'ar') }}</td>
                                                <td>{{ $domain['Partially Implemented'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('locale.Implemented', [], 'en') }} -
                                                    {{ __('locale.Implemented', [], 'ar') }}</td>
                                                <td>{{ $domain['Implemented'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    </div>


@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script>
        const statuses = [],
            data = [];

        // statuses['Not Applicable'] = {
        //     name: "{{ __('locale.Not Applicable', [], 'en') }} - {{ __('locale.Not Applicable', [], 'ar') }}",
        //     color: "{{ $statuses['Not Applicable'] }}"
        // };
        // statuses['Not Implemented'] = {
        //     name: "{{ __('locale.Not Implemented', [], 'en') }} - {{ __('locale.Not Implemented', [], 'ar') }}",
        //     color: "{{ $statuses['Not Implemented'] }}"
        // };
        // statuses['Partially Implemented'] = {
        //     name: "{{ __('locale.Partially Implemented', [], 'en') }} - {{ __('locale.Partially Implemented', [], 'ar') }}",
        //     color: "{{ $statuses['Partially Implemented'] }}"
        // };
        // statuses['Implemented'] = {
        //     name: "{{ __('locale.Implemented', [], 'en') }} - {{ __('locale.Implemented', [], 'ar') }}",
        //     color: "{{ $statuses['Implemented'] }}"
        // };

        statuses['Not Applicable'] = {
            name: "{{ __('locale.Not Applicable') }}",
            color: "{{ $statuses['Not Applicable'] }}"
        };
        statuses['Not Implemented'] = {
            name: "{{ __('locale.Not Implemented') }}",
            color: "{{ $statuses['Not Implemented'] }}"
        };
        statuses['Partially Implemented'] = {
            name: "{{ __('locale.Partially Implemented') }}",
            color: "{{ $statuses['Partially Implemented'] }}"
        };
        statuses['Implemented'] = {
            name: "{{ __('locale.Implemented') }}",
            color: "{{ $statuses['Implemented'] }}"
        };
        data['total'] = @json($data['total']);
        data['all'] = @json($data['all']);
        data['domains'] = @json($domainsArray);
    </script>
    <script src="{{ asset('ajax-files/reporting/chart-apex.js') }}"></script>
@endsection
