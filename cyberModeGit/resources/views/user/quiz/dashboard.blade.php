@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.User Dashboard'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <style>
        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .progress-circle {
            position: relative;
            display: inline-block;
            width: 120px;
            height: 120px;
        }
        .chart-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .highcharts-figure {
            margin: 0;
        }
        .highcharts-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header with Breadcrumbs -->
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2">
                <div class="row breadcrumbs-top">
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
                                                        <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                                    @endif
                                                    {{ $breadcrumb['name'] }}
                                                    @if (isset($breadcrumb['link']))
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            @foreach ($dashboardData['cards'] as $index => $card)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <div class="card-icon text-{{ $card['color'] }}">
                                <i class="{{ $card['icon'] }}"></i>
                            </div>
                            <h5 class="card-title mb-3">{{ $card['title'] }}</h5>

                            @if($index == 0) {{-- LMS Training Modules --}}
                                <div class="stats-number text-{{ $card['color'] }}">
                                    {{ $card['total'] }}
                                </div>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-success">{{ __('locale.Completed') }}</small>
                                        <div class="fw-bold text-success">{{ $card['completed'] }}</div>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-warning">{{ __('locale.Pending') }}</small>
                                        <div class="fw-bold text-warning">{{ $card['pending'] }}</div>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-danger">{{ __('locale.Failed') }}</small>
                                        <div class="fw-bold text-danger">{{ $card['failed'] }}</div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $card['color'] }}" style="width: {{ $card['completion_rate'] }}%"></div>
                                </div>
                                <small class="text-muted">{{ $card['completion_rate'] }}% {{ __('locale.Completion Rate') }}</small>

                            @elseif($index == 1) {{-- Physical Courses --}}
                                <div class="stats-number text-{{ $card['color'] }}">
                                    {{ $card['total'] }}
                                </div>
                                <div class="row text-center">
                                    <div class="col-3">
                                        <small class="text-success">{{ __('locale.Completed') }}</small>
                                        <div class="fw-bold text-success">{{ $card['completed'] }}</div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-primary">{{ __('locale.Approved') }}</small>
                                        <div class="fw-bold text-primary">{{ $card['approved'] }}</div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-warning">{{ __('locale.Pending') }}</small>
                                        <div class="fw-bold text-warning">{{ $card['pending'] }}</div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-danger">{{ __('locale.Rejected') }}</small>
                                        <div class="fw-bold text-danger">{{ $card['rejected'] }}</div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $card['color'] }}" style="width: {{ $card['approval_rate'] }}%"></div>
                                </div>
                                <small class="text-muted">{{ $card['approval_rate'] }}% {{ __('locale.Approval Rate') }}</small>

                            @elseif($index == 2) {{-- Certificates --}}
                                <div class="stats-number text-{{ $card['color'] }}">
                                    {{ $card['total_certificates'] }}
                                </div>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <small class="text-primary">{{ __('locale.LMS Certificates') }}</small>
                                        <div class="fw-bold text-primary">{{ $card['lms_certificates'] }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-success">{{ __('locale.Physical Certificates') }}</small>
                                        <div class="fw-bold text-success">{{ $card['physical_certificates'] }}</div>
                                    </div>
                                </div>

                            @else {{-- Overall Progress --}}
                                <div class="stats-number text-{{ $card['color'] }}">
                                    {{ $card['total_activities'] }}
                                </div>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <small class="text-success">{{ __('locale.Completed') }}</small>
                                        <div class="fw-bold text-success">{{ $card['total_completed'] }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-primary">{{ __('locale.Average Score') }}</small>
                                        <div class="fw-bold text-primary">{{ $card['average_score'] }}%</div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $card['color'] }}" style="width: {{ $card['completion_rate'] }}%"></div>
                                </div>
                                <small class="text-muted">{{ $card['completion_rate'] }}% {{ __('locale.Overall Completion') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Additional Info Cards -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clock text-warning me-2"></i>
                            {{ __('locale.Overdue Modules') }}
                        </h5>
                        <div class="stats-number text-warning">
                            {{ $dashboardData['raw_stats']['lms_stats']['overdue_modules'] }}
                        </div>
                        <p class="text-muted mb-0">{{ __('locale.Modules past due date') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-door-open text-info me-2"></i>
                            {{ __('locale.Available Courses') }}
                        </h5>
                        <div class="stats-number text-info">
                            {{ $dashboardData['raw_stats']['physical_courses_stats']['open_courses_count'] }}
                        </div>
                        <p class="text-muted mb-0">{{ __('locale.Open for registration') }}</p>
                    </div>
                </div>
            </div>
        </div>

           <!-- Charts Row -->
        <div class="row">
            <!-- LMS Progress Chart -->
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <h4 class="mb-3">{{ __('locale.LMS Training Progress') }}</h4>
                    <div id="lmsChart"></div>
                </div>
            </div>

            <!-- Physical Courses Chart -->
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <h4 class="mb-3">{{ __('locale.Physical Courses Status') }}</h4>
                    <div id="physicalChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('page-script')
    <script>
        // Chart data from Laravel
        const lmsData = @json($dashboardData['charts']['lms_progress']);
        const physicalData = @json($dashboardData['charts']['physical_courses']);

        // Configure Highcharts global options
        Highcharts.setOptions({
            colors: ['#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14'],
            chart: {
                backgroundColor: 'transparent',
                style: {
                    fontFamily: 'inherit'
                }
            },
            title: {
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            legend: {
                itemStyle: {
                    fontSize: '12px'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                style: {
                    color: 'white'
                },
                borderRadius: 5,
                shadow: false
            }
        });

        // LMS Progress Pie Chart
        Highcharts.chart('lmsChart', {
            chart: {
                type: 'pie',
                height: 300
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f}%'
                    },
                    showInLegend: true,
                    size: '80%'
                }
            },
            series: [{
                name: 'Modules',
                colorByPoint: true,
                data: [
                    {
                        name: '{{ __("locale.Completed") }}',
                        y: lmsData.completed,
                        color: '#28a745'
                    },
                    {
                        name: '{{ __("locale.Pending") }}',
                        y: lmsData.pending,
                        color: '#ffc107'
                    },
                    {
                        name: '{{ __("locale.Failed") }}',
                        y: lmsData.failed,
                        color: '#dc3545'
                    },
                    {
                        name: '{{ __("locale.Overdue") }}',
                        y: lmsData.overdue,
                        color: '#6f42c1'
                    }
                ]
            }],
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b><br/>Percentage: <b>{point.percentage:.1f}%</b>'
            },
            exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                    }
                }
            }
        });

        // Physical Courses Column Chart
        Highcharts.chart('physicalChart', {
            chart: {
                type: 'column',
                height: 300
            },
            title: {
                text: null
            },
            xAxis: {
                categories: [
                    '{{ __("locale.Completed") }}',
                    '{{ __("locale.Approved") }}',
                    '{{ __("locale.Pending") }}',
                    '{{ __("locale.Rejected") }}'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '{{ __("locale.Number of Courses") }}'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px'
                        }
                    }
                }
            },
            series: [{
                name: '{{ __("locale.Courses") }}',
                data: [
                    {
                        y: physicalData.completed,
                        color: '#28a745'
                    },
                    {
                        y: physicalData.approved,
                        color: '#007bff'
                    },
                    {
                        y: physicalData.pending,
                        color: '#ffc107'
                    },
                    {
                        y: physicalData.rejected,
                        color: '#dc3545'
                    }
                ]
            }],
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                    }
                }
            }
        });

        // Responsive charts
        window.addEventListener('resize', function() {
            setTimeout(function() {
                Highcharts.charts.forEach(function(chart) {
                    if (chart) {
                        chart.reflow();
                    }
                });
            }, 100);
        });
    </script>
@endsection
