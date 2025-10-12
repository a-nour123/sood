@extends('admin/layouts/contentLayoutMaster')

@section('title', __('third_party.Reports'))

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />


@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <style>
        .page-wrapper.compact-small .page-body-wrapper .page-body {
            margin-left: 0 !important;
        }

        .page-wrapper .page-body-wrapper .page-body {
            padding: 0 !important
        }

        .highcharts-credits {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-12 ps-0">
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

    <div class="page-wrapper" id="pageWrapper">

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid"></div>
                <!-- Container-fluid starts-->
                <div class="container-fluid dashboard_default">
                    <div class="row widget-grid">

                        <div class="row dashboard  widget-grid ">
                            <div class="col-md-12 col-lg-6">
                                <div class="row">
                                    <!-- Total profiles section -->
                                    <div class=" col-md-12 ">
                                        <div class="card widget-1">
                                            <div class="card-body">
                                                <div class="widget-content">
                                                    <div class="widget-round success">
                                                        <div class="bg-round">
                                                            <i class="size-18" data-feather='users'></i>
                                                            <svg class="half-circle svg-fill">
                                                                <use
                                                                    href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                                </use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4>{{ $data['profiles']->count() }}</h4>
                                                        <span
                                                            class="f-light">{{ __('third_party.Total profiles') }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <!-- Total BUM requests section -->
                                    <div class="col-md-12">
                                        <div class="card widget-1">
                                            <div class="card-body">
                                                <div class="widget-content">
                                                    <div class="widget-round success">
                                                        <div class="bg-round">
                                                            <i class="size-18" data-feather='file'></i>
                                                            <svg class="half-circle svg-fill">
                                                                <use
                                                                    href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                                </use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4>{{ $data['requests']->count() }}</h4>
                                                        <span
                                                            class="f-light">{{ __('third_party.Total PUM requests') }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total assessments section -->
                                    <div class="col-md-12">
                                        <div class="card widget-1">
                                            <div class="card-body">
                                                <div class="widget-content">
                                                    <div class="widget-round success">
                                                        <div class="bg-round">
                                                            <i class="size-18" data-feather='info'></i>
                                                            <svg class="half-circle svg-fill">
                                                                <use
                                                                    href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                                </use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4>{{ $data['assessments']->count() }}</h4>
                                                        <span
                                                            class="f-light">{{ __('third_party.Total assessments') }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- third_party evaluation section -->
                            <div class="col-lg-6 col-12">
                                <div class="card widget-1">
                                    {{-- <div class="card-header">
                                        <h4 class="card-title">{{ __('third_party.Evaluated third-party') }}</h4>
                                    </div> --}}
                                    <div class="card-body">

                                        <div id="third_party-chart-container"></div>

                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- profiles-chart -->
                        <div class="card pt-4">
                            <select class="form-select select2" id="thirdPartyProfile">
                                <option disabled selected value="">{{ __('third_party.Select') }}
                                </option>
                                @foreach ($data['profiles'] as $profile)
                                    <option value="{{ $profile->id }}">{{ $profile->third_party_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="card-body row p-2 d-flex justify-content-center">
                                <div class="col-lg-12">
                                    <div id="profiles-chart-container"></div>
                                </div>
                            </div>
                        </div>

                        <!-- departments-chart -->
                        <div class="card pt-4">
                            <select class="form-select select2" id="thirdPartyDepartment">
                                <option disabled selected value="">{{ __('third_party.Select') }}
                                </option>
                                @foreach ($data['departments'] as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="card-body row p-2 d-flex justify-content-center">
                                <div class="col-lg-12">
                                    <div id="departments-chart-container"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('vendor-script')

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            displayProfileCharts([]);
            displayDepartmentsCharts([]);
            mainChart();
        });

        // function of making alert
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $("#thirdPartyProfile").on("change", function() {
            var profileId = $(this).val();

            $.ajax({
                type: "GET",
                url: '{{ route('admin.third_party.getProfileCharts', ':profileId') }}'.replace(
                    ':profileId', profileId),
                success: function(response) {
                    // Pass response.data to the displayProfileCharts function
                    displayProfileCharts(response.data);
                }
            });
        });

        function displayProfileCharts(data = {}) {
            Highcharts.chart('profiles-chart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '{{ __("third_party.Third Party Profiles Statistic") }}'
                },
                xAxis: {
                    categories: [
                        '{{ __("third_party.Requests") }}',
                        '{{ __("third_party.Assessments") }}',
                        '{{ __("third_party.Pending Assessments") }}',
                        '{{ __("third_party.Accepted Assessments") }}',
                        '{{ __("third_party.Rejected Assessments") }}',
                        '{{ __("third_party.Remediated Assessments") }}'
                    ]
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '{{ __("third_party.Third Party Profiles Statistic") }}'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: 'gray'
                        }
                    }
                },
                legend: {
                    enabled: false // Disable legend since we have individual labels
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br>',
                    pointFormat: 'Value: {point.y}'
                },
                plotOptions: {
                    column: {
                        pointWidth: 25, // Set the column width in pixels
                        dataLabels: {
                            enabled: true, // Enable data labels
                            format: '{y}', // Display the value at the top of each column
                            style: {
                                color: 'black',
                                fontWeight: 'bold'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Statistics',
                    data: [{
                            y: data.requests || 0,
                            color: 'black',
                            name: '{{ __("third_party.Requests") }}'
                        },
                        {
                            y: data.assessments || 0,
                            color: 'blue',
                            name: '{{ __("third_party.Assessments") }}'
                        },
                        {
                            y: data.pendingAssessments || 0,
                            color: 'orange',
                            name: '{{ __("third_party.Pending Assessments") }}'
                        },
                        {
                            y: data.acceptedAssessments || 0,
                            color: 'green',
                            name: '{{ __("third_party.Accepted Assessments") }} '
                        },
                        {
                            y: data.rejectedAssessments || 0,
                            color: 'red',
                            name: '{{ __("third_party.Rejected Assessments") }}'
                        },
                        {
                            y: data.remedatedAssessments || 0,
                            color: 'purple',
                            name: '{{ __("third_party.Remediated Assessments") }}'
                        }
                    ]
                }]
            });
        }


        $("#thirdPartyDepartment").on("change", function() {
            var departmentId = $(this).val();

            $.ajax({
                type: "GET",
                url: '{{ route('admin.third_party.getDepartmentsCharts', ':departmentId') }}'.replace(
                    ':departmentId', departmentId),
                success: function(response) {
                    console.log(response.data);
                    // Pass response.data to the displayProfileCharts function
                    displayDepartmentsCharts(response.data);
                }
            });
        });

        function displayDepartmentsCharts(data = {}) {
            Highcharts.chart('departments-chart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '{{ __("third_party.Third Party Departments Statistic") }}'
                },
                xAxis: {
                    categories: data.profiles || [], // Profile names from JSON response
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '{{ __("third_party.Statistics") }}'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    formatter: function() {
                        return `<b>${this.series.name}</b><br>${this.x}: ${this.y}`;
                    }
                },
                plotOptions: {
                    column: {
                        stacking: null,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                        color: 'black',
                        name: '{{ __("third_party.Requests") }}',
                        data: data.requests || []
                    },
                    {
                        color: 'blue',
                        name: '{{ __("third_party.Assessments") }}',
                        data: data.assessments || []
                    },
                    {
                        color: 'orange',
                        name: '{{ __("third_party.Pending Assessments") }}',
                        data: data.pendingAssessments || []
                    },
                    {
                        color: 'green',
                        name: '{{ __("third_party.Accepted Assessments") }} ',
                        data: data.acceptedAssessments || []
                    },
                    {
                        color: 'red',
                        name: '{{ __("third_party.Rejected Assessments") }}',
                        data: data.rejectedAssessments || []
                    },
                    {
                        color: 'purple',
                        name: '{{ __("third_party.Remediated Assessments") }}',
                        data: data.remedatedAssessments || []
                    }
                ]
            });
        }

        function mainChart() {
            const evaluatedThirdParty = {{ $data['evaluatedThirdParty'] }};
            const notEvaluatedThirdParty = {{ $data['notEvaluatedThirdParty'] }};

            Highcharts.chart('third_party-chart-container', {
                chart: {
                    type: 'pie',
                    backgroundColor: null, // Optional, remove background
                    height: '285', // Adjust height for better appearance
                    width: 600 // Set a specific width in pixels
                },
                title: {
                    text: '{{ __("third_party.Evaluation third-party") }}'
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%'],
                        size: '110%',
                        innerSize: '60%', // For donut effect
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        }
                    }
                },
                series: [{
                    name: '{{ __("third_party.Evaluation third-party") }}',
                    data: [{
                            name: '{{ __("third_party.Evaluated") }}',
                            y: evaluatedThirdParty,
                            color: '#28a745'
                        },
                        {
                            name: '{{ __("third_party.Not Evaluated") }}',
                            y: notEvaluatedThirdParty,
                            color: '#dc3545'
                        }
                    ]
                }],
                exporting: {
                    enabled: true
                },
                credits: {
                    enabled: false // Optional, remove credits
                }
            });

        }
    </script>
@endsection
