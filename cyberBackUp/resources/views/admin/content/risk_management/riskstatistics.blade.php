@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Overview'))


@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <style>
        canvas {
            height: 350px !important;
            margin: 10px
        }
    </style>
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                                style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                    </use>
                                                </svg></a></li>
                                        @foreach ($breadcrumbs as $breadcrumb)
                                            <li class="breadcrumb-item">
                                                @if (isset($breadcrumb['link']))
                                                    <a
                                                        href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                                @endif
                                                {{ $breadcrumb['name'] }}
                                                @if (isset($breadcrumb['link']))
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endisset
                        </div>
                        <div class="col-sm-6 pe-0" style="text-align: end;">


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>

<section id="highcharts-chart">
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.ClosedRisks') }}</h4>
                </div>
                <div class="card-body">
                    <div id="ClosedRisks" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.SiteLocation') }}</h4>
                </div>
                <div class="card-body">
                    <div id="SiteLocation" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Status') }}</h4>
                </div>
                <div class="card-body">
                    <div id="StatusChart" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.ImpactScope') }}</h4>
                </div>
                <div class="card-body">
                    <div id="RiskSource" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Category') }}</h4>
                </div>
                <div class="card-body">
                    <div id="CategoryChart" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Team') }}</h4>
                </div>
                <div class="card-body">
                    <div id="TeamChart" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Technology') }}</h4>
                </div>
                <div class="card-body">
                    <div id="TechnologyChart" class="highchart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Owners') }}</h4>
                </div>
                <div class="card-body">
                    <div id="ManagerChart" class="highchart-container"></div>
                </div>
            </div>
        </div>


    </div>
</section>
<section id="highcharts-chart">
    <div id="SeverityChart"></div>
</section>
<section id="highcharts-chart">
    <div class="card-header">
        <h5 class="card-title">{{ __('report.LikelihoodImpact') }}</h5>
    </div>
    <div class="card-body">
        <div id="container-likehood-impact"></div>
    </div>
</section>
<section id="highcharts-chart">
    <div class="card-header">
        <h5 class="card-title">{{ __('report.DepartementRisks') }}</h5>
    </div>
    <div class="card-body">
        <!-- Highcharts Donut Chart Container -->
        <div id="container-risks-departement" style="width: 100%; height: 400px;"></div>
    </div>
</section>


@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('ajax-files/general-functions.js') }}"></script>
<script src="{{ asset('cdn/highcharts.js') }}"></script>

<script>
    $(window).on('load', function() {
        'use strict';

        // Function to draw Highcharts
        function drawingChart(containerId, types, numbers) {
            Highcharts.chart(containerId, {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                series: [{
                    name: 'Data',
                    colorByPoint: true,
                    data: types.map(function(type, index) {
                        return {
                            name: type,
                            y: parseInt(numbers[index]),
                            color: GetColors(
                                index) // Optional: Color generator function
                        };
                    })
                }]
            });
        }

        // Data for each chart (can be dynamic based on your backend data)
        let closedRiskReasonChartDataType = "{{ $closedRiskReasonChartDataType }}".split(',');
        let closedRiskReasonDataNumper = "{{ $closedRiskReasonChartDataNumber }}".split(',');
        drawingChart("ClosedRisks", closedRiskReasonChartDataType, closedRiskReasonDataNumper);

        let openriskLocationsDataType = "{{ $openriskLocationsDataType }}".split(',');
        let openriskLocationsDataNumber = "{{ $openriskLocationsDataNumber }}".split(',');
        drawingChart("SiteLocation", openriskLocationsDataType, openriskLocationsDataNumber);

        let openRiskStatusDataType = "{{ $openRiskStatusDataType }}".split(',');
        let openRiskStatusDataNumber = "{{ $openRiskStatusDataNumber }}".split(',');
        drawingChart("StatusChart", openRiskStatusDataType, openRiskStatusDataNumber);

        let openRiskSourceDataType = "{{ $openRiskSourceDataType }}".split(',');
        let openRiskSourceDataNumber = "{{ $openRiskSourceDataNumber }}".split(',');
        drawingChart("RiskSource", openRiskSourceDataType, openRiskSourceDataNumber);

        let openRiskCategoryDataType = "{{ $openRiskCategoryDataType }}".split(',');
        let openRiskCategoryDataNumber = "{{ $openRiskCategoryDataNumber }}".split(',');
        drawingChart("CategoryChart", openRiskCategoryDataType, openRiskCategoryDataNumber);

        let openRiskTeamChartDataType = "{{ $openRiskTeamChartDataType }}".split(',');
        let openRiskTeamChartDataNumber = "{{ $openRiskTeamChartDataNumber }}".split(',');
        drawingChart("TeamChart", openRiskTeamChartDataType, openRiskTeamChartDataNumber);

        let openRiskTechnologyChartDataType = "{{ $openRiskTechnologyChartDataType }}".split(',');
        let openRiskTechnologyChartDataNumber = "{{ $openRiskTechnologyChartDataNumber }}".split(',');
        drawingChart("TechnologyChart", openRiskTechnologyChartDataType, openRiskTechnologyChartDataNumber);

        let openRiskOwnersManagerChartDataType = "{{ $openRiskOwnersManagerChartDataType }}".split(',');
        let openRiskOwnersManagerChartDataNumber = "{{ $openRiskOwnersManagerChartDataNumber }}".split(',');
        drawingChart("ManagerChart", openRiskOwnersManagerChartDataType, openRiskOwnersManagerChartDataNumber);

        let openRiskScoringMethodChartDataType = "{{ $openRiskScoringMethodChartDataType }}".split(',');
        let openRiskScoringMethodChartDataNumber = "{{ $openRiskScoringMethodChartDataNumber }}".split(',');
        drawingChart("RiskScoringMethod", openRiskScoringMethodChartDataType,
            openRiskScoringMethodChartDataNumber);

        let closedRiskReasonCharttDataType = "{{ $closedRiskReasonCharttDataType }}".split(',');
        let closedRiskReasonCharttDataNumber = "{{ $closedRiskReasonCharttDataNumber }}".split(',');
        drawingChart("ReasonChart", closedRiskReasonCharttDataType, closedRiskReasonCharttDataNumber);

        // Optional: Function to generate colors dynamically for the chart
        function GetColors(index) {
            const colors = [
                '#78B3CE', '#C9E6F0', '#FBF8EF', '#F96E2A', '#3C552D',
                '#CA7373', '#D7B26D', '#EEE2B5', '#074173', '#1679AB', '#5DEBD7', '#C5FF95', '#161A30',
                '#31304D'
            ];
            return colors[index % colors.length]; // Cycle through colors if needed
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Pass PHP variable $GetSeveritChartDetails into JavaScript
        var chartData = {!! json_encode($GetSeveritChartDetails) !!};
        console.log(chartData);

        // Initialize series data
        const seriesData = [];
        const categories = ['Low', 'Medium', 'High', 'Very High']; // Risk levels for the x-axis

        // Prepare data for each status
        const statuses = Object.keys(chartData.original); // e.g., ['Mitigation Planned', 'Opened', ...]

        statuses.forEach(status => {
            const riskLevelsCount = chartData.original[status];
            const data = [];

            // Prepare data for each risk level (Low, Medium, High, Very High)
            categories.forEach(level => {
                data.push(riskLevelsCount[level] || 0); // If no data for a risk level, set to 0
            });

            // Add the status data to the series
            seriesData.push({
                name: status,
                data: data
            });
        });

        // Create the Highcharts chart
        Highcharts.chart('SeverityChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: "{{ __('locale.Risk Status by Severity') }}"
            },
            xAxis: {
                categories: categories, // Risk levels (Low, Medium, High, Very High)
                title: {
                    text: "{{ __('locale.Risk Levels') }}"
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: "{{ __('locale.Number of Risks') }}"
                }
            },
            series: seriesData
        });
    });
</script>
<script type="text/javascript">
    likelihood_impact_chart = new Highcharts.Chart({
        "title": {
            "text": "{{ __('report.LikelihoodImpact') }}"
        },
        "chart": {
            "renderTo": "container-likehood-impact", // Use the correct ID
            "type": "scatter",
            "zoomType": "none"
        },
        "credits": {
            "enabled": false
        },
        "xAxis": {
            "title": {
                "text": "{{ __('report.Likelihood') }}"
            },
            "tickInterval": 1,
            "min": 0,
            "max": {{ $counters['likelihood'] }},
            "gridLineWidth": 1
        },
        "yAxis": {
            "title": {
                "text": "{{ __('report.Impact') }}"
            },
            "tickInterval": 1,
            "min": 0,
            "max": {{ $counters['impact'] }},
        },
        "legend": {
            "enabled": false
        },
        "plotOptions": {
            "scatter": {
                "marker": {
                    "radius": 5,
                    "states": {
                        "hover": {
                            "enabled": true,
                            "lineColor": "rgb(100, 100, 100)"
                        }
                    }
                }
            }
        },
        "series": @json($getRisks['series']),
    });

    likelihood_impact_chart.update({
        tooltip: {
            headerFormat: '',
            useHTML: true,
            style: {
                pointerEvents: 'auto'
            },
            hideDelay: 2500,
            formatter: function() {
                var point = this.point;
                var test = get_tooltip_html(point);
                return test;
            }
        }
    });

    function get_tooltip_html(point) {
        var test = $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.reporting.likelhoodImpactReportTooltip') }}",
            async: false,
            data: {
                "risk_ids": point.risk_ids,
            },
            success: function(response) {
                return response.data;
            },
            error: function(xhr, status, error) {
                if (!retryCSRF(xhr, this)) {}
            }
        });
        return test.responseJSON.data;
    };
</script>
<script type="text/javascript">
    Highcharts.chart('container-risks-departement', {
        chart: {
            type: 'pie', // Donut chart is a type of pie chart
            innerSize: '50%', // Makes it a donut
        },
        title: {
            text: '{{ __('report.RisksDepartemnt') }}'
        },
        series: [{
            name: 'Risks',
            data: @json($risksDepartement['risksDepartemnt']) // Pass the data for the donut chart
        }],
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{point.name}: <b>{point.y}</b>'
        }
    });
</script>
@endsection
