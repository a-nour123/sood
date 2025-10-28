@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Likelihood and Impact'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
    <style type="text/css">
        .highcharts-tooltip>span {
            max-height: 100px;
            overflow-y: auto;
            min-width: 100px;
            padding-right: 20px;
        }
    </style>
    <style type="text/css">
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 600px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f2f2f2;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endsection
@section('content')
    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>
@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
    {{-- <script src="{{ asset('js/scripts/highcharts/modules/boost.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts/modules/exporting.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts/modules/accessibility.js') }}"></script> --}}
    <script type="text/javascript">
        likelihood_impact_chart = new Highcharts.Chart({
            "title": {
                "text": "{{ __('report.LikelihoodImpact') }}"
            },
            "chart": {
                "renderTo": "container",
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
                max: {{ $counters['likelihood'] }},
                "gridLineWidth": 1
            },
            "yAxis": {
                "title": {
                    "text": "{{ __('report.Impact') }}"
                },
                "tickInterval": 1,
                "min": 0,
                max: {{ $counters['impact'] }},
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
            "series": @json($series),
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
@endsection
