@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Overview'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <style>
        canvas {
            height: 350px !important;
            margin: 10px
        }

    </style>
@endsection
@section('content')
    <section id="chartjs-chart">
        <div class="row">

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.ClosedRisks') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="ClosedRisks chartjs"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.SiteLocation') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="SiteLocation chartjs"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.Status') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="StatusChart chartjs"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.ImpactScope') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="RiskSource chartjs"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.Category') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="CategoryChart chartjs"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.Team') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="TeamChart chartjs"></canvas>





                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.Technology') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="TechnologyChart chartjs"></canvas>





                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.OwnersManager') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="ManagerChart chartjs"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.RiskScoringMethod') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="RiskScoringMethod chartjs"></canvas>





                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.Reason') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="ReasonChart chartjs"></canvas>





                    </div>
                </div>
            </div>




        </div>
    </section>


@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('ajax-files/general-functions.js') }}"></script>
    <script>
        $(window).on('load', function() {
            'use strict';




            // closed Risk Reason Chart
            // --------------------------------------------------------------------
            let closedRiskReasonChartDataType = "{{ $closedRiskReasonChartDataType }}".split(',');
            let closedRiskReasonDataNumper = "{{ $closedRiskReasonChartDataNumber }}".split(',');
            drawingChart("ClosedRisks", closedRiskReasonChartDataType, closedRiskReasonDataNumper);

            // open risk Locations Chart
            // --------------------------------------------------------------------
            let openriskLocationsDataType = "{{ $openriskLocationsDataType }}".split(',');
            let openriskLocationsDataNumber = "{{ $openriskLocationsDataNumber }}".split(',');
            drawingChart("SiteLocation", openriskLocationsDataType, openriskLocationsDataNumber);

            // open Risk Status Chart
            // --------------------------------------------------------------------
            let openRiskStatusDataType = "{{ $openRiskStatusDataType }}".split(',');
            let openRiskStatusDataNumber = "{{ $openRiskStatusDataNumber }}".split(',');
            drawingChart("StatusChart", openRiskStatusDataType, openRiskStatusDataNumber);


            // open Risk Source Chart
            // --------------------------------------------------------------------
            let openRiskSourceDataType = "{{ $openRiskSourceDataType }}".split(',');
            let openRiskSourceDataNumber = "{{ $openRiskSourceDataNumber }}".split(',');
            drawingChart("RiskSource", openRiskSourceDataType, openRiskSourceDataNumber);

            // open Risk Category Chart
            // --------------------------------------------------------------------
            let openRiskCategoryDataType = "{{ $openRiskCategoryDataType }}".split(',');
            let openRiskCategoryDataNumber = "{{ $openRiskCategoryDataNumber }}".split(',');
            drawingChart("CategoryChart", openRiskCategoryDataType, openRiskCategoryDataNumber);

            // open Risk Category Chart
            // --------------------------------------------------------------------
            let openRiskTeamChartDataType = "{{ $openRiskTeamChartDataType }}".split(',');
            let openRiskTeamChartDataNumber = "{{ $openRiskTeamChartDataNumber }}".split(',');
            drawingChart("TeamChart", openRiskTeamChartDataType, openRiskTeamChartDataNumber);

            // open Risk Category Chart
            // --------------------------------------------------------------------
            let openRiskTechnologyChartDataType = "{{ $openRiskTechnologyChartDataType }}".split(',');
            let openRiskTechnologyChartDataNumber = "{{ $openRiskTechnologyChartDataNumber }}".split(',');
            drawingChart("TechnologyChart", openRiskTechnologyChartDataType, openRiskTechnologyChartDataNumber);


            // open Risk Category Chart
            // --------------------------------------------------------------------
            let openRiskOwnersManagerChartDataType = "{{ $openRiskOwnersManagerChartDataType }}".split(',');
            let openRiskOwnersManagerChartDataNumber = "{{ $openRiskOwnersManagerChartDataNumber }}".split(',');
            drawingChart("ManagerChart", openRiskOwnersManagerChartDataType, openRiskOwnersManagerChartDataNumber);

            // open Risk Category Chart
            // --------------------------------------------------------------------
            let openRiskScoringMethodChartDataType = "{{ $openRiskScoringMethodChartDataType }}".split(',');
            let openRiskScoringMethodChartDataNumber = "{{ $openRiskScoringMethodChartDataNumber }}".split(',');
            drawingChart("RiskScoringMethod", openRiskScoringMethodChartDataType,
                openRiskScoringMethodChartDataNumber);

            // open Risk Category Chart
            // --------------------------------------------------------------------
            let closedRiskReasonCharttDataType = "{{ $closedRiskReasonCharttDataType }}".split(',');
            let closedRiskReasonCharttDataNumber = "{{ $closedRiskReasonCharttDataNumber }}".split(',');
            drawingChart("ReasonChart", closedRiskReasonCharttDataType, closedRiskReasonCharttDataNumber);

            function drawingChart(className, types, numbers) {
                var ctx = $('.' + className);
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: types,
                        datasets: [{
                            label: '# of Tomatoes',
                            data: numbers,
                            backgroundColor:GetColors() ,

                            borderWidth: 1
                        }]
                    },
                    options: {
                        //cutoutPercentage: 40,
                        responsive: true,

                    }
                });
            }



        });
    </script>
@endsection
