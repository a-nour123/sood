@extends('admin/layouts/contentLayoutMaster')

@section('title', __('incident.incident'))

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

    </style>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.dashboard') }}" style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                    </use>
                                                </svg>
                                            </a>
                                        </li>
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

    <!-- Date Filter Section -->
    <div class="row mb-4 align-items-end">
        <div class="col-md-3">
            <label class="form-label">{{ __('incident.Detected_on') }} ({{ __('From') }})</label>
            <input type="date" id="filterDateFrom" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ __('incident.Detected_on') }} ({{ __('To') }})</label>
            <input type="date" id="filterDateTo" class="form-control">
        </div>
        <div class="col-md-3">
            <button id="filterBtn" class="btn btn-primary w-100 mt-2">
                <i class="fa fa-search"></i> {{ __('incident.Search') }}
            </button>
            <button id="resetBtn" class="btn btn-outline-secondary w-100 mt-2">
                <i class="fa fa-refresh"></i> {{ __('incident.Reset') }}
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row dashboard widget-grid">
        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round primary">
                            <div class="bg-round">
                                <i class="size-18" data-feather='info'></i>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 data-counter="overall">{{ $incident_count }}</h4>
                            <span class="f-light">{{ __('incident.overall_incident') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round secondary">
                            <div class="bg-round">
                                <i class="size-18" data-feather='circle'></i>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 data-counter="open">{{ $open_incident_count }}</h4>
                            <span class="f-light">{{ __('incident.open_incident') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round warning">
                            <div class="bg-round">
                                <i style="font-size:20px; color:#f8aa4b" data-feather="loader"></i>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 data-counter="progress">{{ $progress_incident_count }}</h4>
                            <span class="f-light">{{ __('incident.progress_incident') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round success">
                            <div class="bg-round">
                                <i style="font-size:20px; color:green" data-feather="check-circle"></i>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 data-counter="closed">{{ $closed_incident_count }}</h4>
                            <span class="f-light">{{ __('incident.closed_incident') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Section -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.ScoreClassify')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-classification-container"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.Status_Over_Time')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-status-over-time"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution Charts Section -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.Attack_Type_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-attack-type"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.Direction_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-direction"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- PlayBook Chart Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.play_book_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-play-book"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Charts Section -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.TLP_Level_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-tlp-level"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.PAP_Level_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-pap-level"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- More Charts Section -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.Detection_Method_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-detection-method"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('incident.Occurrence_Type_Distribution')</h5>
                </div>
                <div class="card-body">
                    <div id="chart-occurrence-type"></div>
                </div>
            </div>
        </div>
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
    <script src="{{ asset('cdn/d3.min.js') }}"></script>
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
    <script src="{{ asset('cdn/npm-chart.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts/modules/exporting.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize all charts with default data
            renderCharts({
                classificationData: @json($classificationData),
                attackData: @json($attackData),
                directionData: @json($directionData),
                statusOverTimeData: @json($statusOverTimeData),
                tlpData: @json($tlpData),
                papData: @json($papData),
                detectionData: @json($detectionData),
                occurrenceData: @json($occurrenceData),
                playBookData: @json($playBookData) // Added playBookData
            });

            // Filter button click handler
            $('#filterBtn').click(function() {
                let from = $('#filterDateFrom').val();
                let to = $('#filterDateTo').val();

                // Show loading state
                $('#filterBtn').html('<i class="fa fa-spinner fa-spin"></i> {{ __('incident.Loading') }}')
                    .prop('disabled', true);

                $.ajax({
                    url: "{{ route('admin.incident.statistics.filter') }}",
                    data: {
                        from: from,
                        to: to
                    },
                    success: function(res) {
                        updateCounters(res);
                        renderCharts(res);
                        $('#filterBtn').html(
                                '<i class="fa fa-search"></i> {{ __('incident.Search') }}')
                            .prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading data:', error);
                        alert('Error loading data. Please try again.');
                        $('#filterBtn').html(
                                '<i class="fa fa-search"></i> {{ __('incident.Search') }}')
                            .prop('disabled', false);
                    }
                });
            });

            // Reset button click handler
            $('#resetBtn').click(function() {
                $('#filterDateFrom').val('');
                $('#filterDateTo').val('');

                // Reload the page to show default data
                location.reload();
            });

            function updateCounters(data) {
                $('[data-counter="overall"]').text(data.incident_count);
                $('[data-counter="open"]').text(data.open_incident_count);
                $('[data-counter="progress"]').text(data.progress_incident_count);
                $('[data-counter="closed"]').text(data.closed_incident_count);
            }

            function renderCharts(data) {
                // Common export settings for all charts
                const exportOptions = {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'viewFullscreen',
                                'printChart',
                                'separator',
                                'downloadPNG',
                                'downloadJPEG',
                                'downloadPDF',
                                'downloadSVG',
                                'separator',
                                'downloadCSV',
                                'downloadXLS'
                            ]
                        }
                    }
                };

                // Common chart options
                const chartTheme = {
                    colors: ['#5b73e8', '#34c38f', '#f1b44c', '#f46a6a', '#50a5f1', '#6f42c1', '#e83e8c',
                        '#fd7e14'
                    ],
                    chart: {
                        backgroundColor: 'transparent',
                        style: {
                            fontFamily: 'Inter, sans-serif'
                        }
                    },
                    title: {
                        style: {
                            color: '#495057',
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        style: {
                            color: '#6c757d'
                        }
                    }
                };

                // Apply theme
                Highcharts.setOptions(chartTheme);
                // Chart 1: Classification by Status - Stacked Column Chart
                Highcharts.chart('chart-classification-container', {
                    chart: {
                        type: 'column',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.ScoreClassify')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.Classification_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    xAxis: {
                        categories: data.classificationData.categories,
                        crosshair: true,
                        gridLineWidth: 1,
                        lineWidth: 0,
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: '500'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '@lang('incident.NumberOfIncident')',
                            style: {
                                color: '#6c757d',
                                fontSize: '12px'
                            }
                        },
                        gridLineColor: '#f8f9fa',
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: '#495057',
                                fontSize: '11px'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '11px'
                            }
                        }
                    },
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        backgroundColor: 'transparent',
                        borderWidth: 0,
                        shadow: false,
                        itemStyle: {
                            fontSize: '12px',
                            fontWeight: '500'
                        },
                        itemHoverStyle: {
                            color: '#5b73e8'
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '<span style="color:{point.color}">●</span> {series.name}: <b>{point.y}</b><br/>',
                        footerFormat: 'Total: <b>{point.total}</b>',
                        shared: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        borderColor: '#e9ecef',
                        borderRadius: 6,
                        style: {
                            fontSize: '12px'
                        }
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            borderWidth: 0,
                            borderRadius: 3,
                            dataLabels: {
                                enabled: false // Disable data labels if they're causing issues
                            },
                            states: {
                                hover: {
                                    brightness: 0.1
                                }
                            }
                        }
                    },
                    series: data.classificationData.series,
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 2: Attack Type Distribution - Donut Chart
                Highcharts.chart('chart-attack-type', {
                    chart: {
                        type: 'pie',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.Attack_Type_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.Attack_Type_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    tooltip: {
                        pointFormat: '<b>{point.name}</b>: {point.y} incidents ({point.percentage:.1f}%)'
                    },
                    plotOptions: {
                        pie: {
                            innerSize: '50%',
                            depth: 45,
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                                distance: 20,
                                filter: {
                                    property: 'percentage',
                                    operator: '>',
                                    value: 4
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Incidents',
                        colorByPoint: true,
                        data: data.attackData
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 3: Direction Distribution - 3D Pie Chart
                Highcharts.chart('chart-direction', {
                    chart: {
                        type: 'pie',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20],
                        options3d: {
                            enabled: true,
                            alpha: 45
                        }
                    },
                    title: {
                        text: '@lang('incident.Direction_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.Direction_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    plotOptions: {
                        pie: {
                            innerSize: 100,
                            depth: 45,
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.y}',
                                style: {
                                    color: Highcharts.color('#495057').brighten(-0.5).get()
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Incidents',
                        colorByPoint: true,
                        data: data.directionData
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 4: Status Over Time - Area Chart
                Highcharts.chart('chart-status-over-time', {
                    chart: {
                        type: 'column',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.Status_Over_Time')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.Status_Over_Time_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    xAxis: {
                        categories: data.statusOverTimeData.categories,
                        crosshair: true,
                        gridLineWidth: 1
                    },
                    yAxis: {
                        title: {
                            text: '@lang('incident.NumberOfIncident')',
                            style: {
                                color: '#6c757d'
                            }
                        },
                        gridLineColor: '#f8f9fa'
                    },
                    tooltip: {
                        shared: true,
                        valueSuffix: ' incidents'
                    },
                    plotOptions: {
                        areaspline: {
                            fillOpacity: 0.5,
                            marker: {
                                enabled: false
                            },
                            lineWidth: 2
                        }
                    },
                    series: data.statusOverTimeData.series,
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 5: PlayBook Distribution - Bar Chart
                Highcharts.chart('chart-play-book', {
                    chart: {
                        type: 'bar',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.play_book_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.play_book_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    xAxis: {
                        categories: data.playBookData.map(item => item
                        .name), // Fixed: playBookData (lowercase)
                        title: {
                            text: null
                        },
                        gridLineWidth: 0,
                        lineWidth: 0,
                        labels: {
                            style: {
                                fontSize: '11px'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '@lang('incident.NumberOfIncident')',
                            align: 'high',
                            style: {
                                color: '#6c757d'
                            }
                        },
                        labels: {
                            overflow: 'justify'
                        },
                        gridLineColor: '#f8f9fa'
                    },
                    tooltip: {
                        headerFormat: '<b>{point.key}</b><br/>',
                        pointFormat: 'Incidents: <b>{point.y}</b>',
                        valueSuffix: ' incidents'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 3,
                            dataLabels: {
                                enabled: true,
                                format: '{y}',
                                style: {
                                    color: '#ffffff',
                                    textOutline: 'none',
                                    fontWeight: 'bold'
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Incidents',
                        colorByPoint: true,
                        data: data.playBookData // Fixed: playBookData (lowercase)
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 6: TLP Level Distribution - Bar Chart
                Highcharts.chart('chart-tlp-level', {
                    chart: {
                        type: 'bar',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.TLP_Level_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.TLP_Level_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    xAxis: {
                        categories: data.tlpData.map(item => item.name),
                        title: {
                            text: null
                        },
                        gridLineWidth: 0,
                        lineWidth: 0
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '@lang('incident.NumberOfIncident')',
                            align: 'high',
                            style: {
                                color: '#6c757d'
                            }
                        },
                        labels: {
                            overflow: 'justify'
                        },
                        gridLineColor: '#f8f9fa'
                    },
                    tooltip: {
                        valueSuffix: ' incidents'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 3,
                            dataLabels: {
                                enabled: true,
                                format: '{y}',
                                style: {
                                    color: '#ffffff',
                                    textOutline: 'none',
                                    fontWeight: 'bold'
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Incidents',
                        colorByPoint: true,
                        data: data.tlpData
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 7: PAP Level Distribution - Regular Pie Chart
                Highcharts.chart('chart-pap-level', {
                    chart: {
                        type: 'pie',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.PAP_Level_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.PAP_Level_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    tooltip: {
                        pointFormat: '<b>{point.name}</b>: {point.y} incidents ({point.percentage:.1f}%)'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y}',
                                distance: -30,
                                style: {
                                    color: '#ffffff',
                                    fontWeight: 'bold',
                                    textOutline: 'none'
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Incidents',
                        colorByPoint: true,
                        data: data.papData
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 8: Detection Method Distribution - Regular Pie Chart
                Highcharts.chart('chart-detection-method', {
                    chart: {
                        type: 'pie',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.Detection_Method_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.Detection_Method_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    tooltip: {
                        pointFormat: '<b>{point.name}</b>: {point.y} incidents ({point.percentage:.1f}%)'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                                distance: 20
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Incidents',
                        colorByPoint: true,
                        data: data.detectionData.data || data.detectionData
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });

                // Chart 9: Occurrence Type Distribution - Regular Column Chart
                Highcharts.chart('chart-occurrence-type', {
                    chart: {
                        type: 'column',
                        backgroundColor: '#ffffff',
                        borderRadius: 8,
                        spacing: [20, 20, 20, 20]
                    },
                    title: {
                        text: '@lang('incident.Occurrence_Type_Distribution')',
                        align: 'left',
                        style: {
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    subtitle: {
                        text: '@lang('incident.Occurrence_Type_Subtitle')',
                        align: 'left',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -45,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '@lang('incident.NumberOfIncident')',
                            style: {
                                color: '#6c757d'
                            }
                        },
                        gridLineColor: '#f8f9fa'
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        pointFormat: 'Incidents: <b>{point.y}</b>'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            borderRadius: 3,
                            colorByPoint: true
                        }
                    },
                    series: [{
                        name: 'Occurrence Types',
                        data: data.occurrenceData.map(item => [item.name, item.y || item.value])
                    }],
                    exporting: exportOptions,
                    credits: {
                        enabled: false
                    }
                });
            }
        });
    </script>

@endsection
