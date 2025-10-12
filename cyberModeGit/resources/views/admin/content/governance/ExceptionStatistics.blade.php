@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Framework'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <style>
        .card.domains span {
            background: #f2f2f2;
            margin: 5px;
            border: 1px solid #DDD;
            padding: 5px;
            border-radius: 15px;
        }

        .card.domains {
            {{--  display: flex;  --}} {{--  flex-flow: wrap;  --}}
        }

        .slide-table {
            display: none;
        }

        .apexcharts-canvas {
            margin: auto !important
        }

        .node circle {
            fill: #fff;
            stroke: steelblue;
            stroke-width: 3px;
        }



        .link {
            fill: none;
            stroke: #ccc;
            stroke-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            --bs-table-accent-bg: white !important;
        }

        #sedationModal .modal-dialog.modal-fullscreen {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
        }

        #sedationModal .modal-content {
            height: 100%;
            border-radius: 0;
        }

        #sedationModal .modal-body {
            overflow-y: auto;
            height: calc(100% - 56px);
            /* Adjust based on header and footer height */
        }

        #sedationModal .modal-header,
        #sedationModal .modal-footer {
            padding: 15px;
        }

        .modal-custom-size {
            max-width: 60%;
            /* Adjust this value as needed */
        }

        #chartContainerWrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
            /* Adjust the height as needed */
        }

        #chartContainer {
            width: 100%;
            height: auto;
            /* Ensure the SVG scales properly */
        }

        .charts-row {
            display: flex;
            justify-content: space-between;
            /* Distributes space between the charts */
            align-items: stretch;
            /* Aligns charts equally in height */
        }

        .charts-row>div {
            margin: 10px;
            /* Optional: adds space between charts */
        }

        .crm_dashboard .customer-chart ul li.d-flex .flex-grow-1 span {
            font-size: 16px;
            font-weight: 700;
        }

        /* Adjust margins and styling for modal form */
    </style>
    <style>
        .incom-chart {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            /* Adjust as needed to give vertical space */
        }
    </style>
@endsection
@section('content')
    {{-- @php $totalStatus=$allStatus['Implemented']+$allStatus['Not Implemented']+$allStatus['Not Applicable']+$allStatus['Partially Implemented']   @endphp --}}
    {{-- <input type="hidden" id="id" value="{{ $id }}"> --}}
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
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid" style="margin-left: 10px;">
        <div class="row col-12">
            <div class="col-md-4">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round success">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#tag') }}"> </use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ count($allExceptions) }}</h4><span class="text-success">{{ __('locale.OverallExceptions') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round primary">
                                <div class="bg-round">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle" style="font-size:20px; color:green"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ count($openExceptions) }}</h4><span class="text-success">{{ __('locale.Opened') }}</span>
                            </div>
                        </div>
                        @if(count($allExceptions) > 0)
                        <div class="font-success f-w-600"><i
                                class="icon-arrow-up icon-rotate me-1"></i><span>{{ number_format((count($openExceptions) / count($allExceptions)) * 100, 2) }}%</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle" style="font-size:20px; color:red"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ count($closedExceptions) }}</h4><span class="text-danger">
                                    {{ __('locale.Closed') }}</span>
                            </div>
                        </div>
                        @if(count($allExceptions) > 0)
                        <div class="font-danger f-w-600"><i
                                class="icon-arrow-up icon-rotate me-1 font-danger"></i><span>{{ number_format((count($closedExceptions) / count($allExceptions)) * 100, 2) }}%</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header pb-0">
                    <h3 class="m-0"> {{ __('locale.RisksSeverityStatistics') }}</h3>
                </div>
                <div class="card-body row p-2">
                    <div class="col-lg-12">
                        <div id="severityChart-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-header pb-0">
                    <h3 class="m-0"> {{ __('locale.ExceptionsByDepartment') }}</h3>
                </div>
                <div class="incom-chart">
                    <div id="departmentchart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header pb-0">
            <h3 class="m-0">{{ __('locale.UpcomingExceptionEndDate') }}</h3>
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('locale.#') }}</th>
                    <th style="font-weight: bold; font-size: 14px;">{{ __('locale.ExceptionName') }}</th>
                    <th style="font-weight: bold; font-size: 14px;">{{ __('locale.Department') }}</th>
                    <th style="font-weight: bold; font-size: 14px;">{{ __('locale.Category') }}</th>
                    <th style="font-weight: bold; font-size: 14px;">{{ __('locale.ExceptionDuration') }}</th>
                    <th style="font-weight: bold; font-size: 14px;">{{ __('locale.ApprovalDate') }}</th>
                    <th style="font-weight: bold; font-size: 14px;">{{ __('locale.EndsOn') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exceptionsWithEndDate as $key => $exception)
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <td style="width: 15%;">{{ $exception->name }}</td>
                        <td style="width: 15%;">{{ $exception->department_name }}</td>
                        <td>{{ $exception->type }}</td>
                        <td>{{ $exception->request_duration }} Days</td>
                        <td>{{ $exception->approval_date }}</td>
                        <td>{{ $exception->end_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table><br>
    </div>


@endsection

@section('vendor-script')
    <script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.5.0/d3.min.js"></script>
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>

    <script src="{{ asset('new_d/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js') }}"></script>

    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const severityCounts = @json($severityCounts);

            // Highcharts configuration for severity chart
            Highcharts.chart('severityChart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '{{ __('locale.SeverityLevels') }}',
                    style: {
                        marginBottom: '120px',
                    }
                },
                xAxis: {
                    categories: ['{{ __('locale.Low') }}', '{{ __('locale.Medium') }}', '{{ __('locale.High') }}', '{{ __('locale.VeryHigh') }}'],
                    title: {
                        // text: '{{ __('locale.SeverityLevels') }}'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Risk Count'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b>',
                    pointFormat: ': {point.y}%'
                },
                plotOptions: {
                    column: {
                        stacking: null, // Set stacking to null for clustered bars
                        pointWidth: 80, // Adjust this value to make columns thicker
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    name: 'Count',
                    data: [{
                            y: severityCounts.low,
                            color: '#28a745'
                        }, // Low - Green
                        {
                            y: severityCounts.medium,
                            color: '#ffc107'
                        }, // Medium - Yellow
                        {
                            y: severityCounts.high,
                            color: '#fd7e14'
                        }, // High - Orange
                        {
                            y: severityCounts.very_high,
                            color: '#dc3545'
                        } // Very High - Red
                    ],
                    colorByPoint: true // Each bar will have a different color
                }],
            });
        });
    </script>

    <script>
        var departmentData = @json($departmentExceptionsCount);

        var labels = departmentData.map(function(item) {
            return item.department_name;
        });

        var series = departmentData.map(function(item) {
            return item.exception_count;
        });

        var options = {
            series: series,
            chart: {
                type: 'donut',
                width: 380,
            },
            labels: labels,
            colors: ['#28a745', '#dc3545', '#6c757d', '#ffc107'], // Customize colors if needed
            plotOptions: {
                pie: {
                    donut: {
                        size: '40%', // Adjust the size of the hole
                    },
                    dataLabels: {
                        enabled: false, // Disable data labels on the donut slices
                    },
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.globals.series[opts.seriesIndex]; // Display the count in the slice
                },
            },
            legend: {
                position: 'bottom'
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + " exceptions"; // Add 'exceptions' text to tooltip
                    },
                },
            }
        };

        var chart = new ApexCharts(document.querySelector("#departmentchart"), options);
        chart.render();
    </script>

    <script src="{{ asset('cdn/chart.js') }}"></script>

@endsection
