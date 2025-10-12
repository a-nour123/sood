@extends('admin/layouts/contentLayoutMaster')

@section('title', __('Phishing.dashboard'))

@section('vendor-style')
@endsection

@section('page-style')
    <style>
        .page-wrapper.compact-small .page-body-wrapper .page-body {
            margin-left: 0 !important;
        }

        .page-wrapper .page-body-wrapper .page-body {
            padding: 0 !important
        }

        .highcharts-credits{
            display: none;
        }
        .dashboard_default .transaction-card table tr:hover td {
    color: #44225c !important;
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

    {{-- Dashboard --}}

    <div class="page-wrapper" id="pageWrapper">

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid"></div>
                <!-- Container-fluid starts-->
                <div class="container-fluid dashboard_default">
                    <div class="row widget-grid">
                        <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6 row">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='circle'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $campaigns_count }}</h4><span
                                                class="f-light">{{ __('phishing.overall_Campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='circle'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $campaigns_complete }}</h4><span
                                                class="f-light">{{ __('locale.completed_campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='circle'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $campaigns_soon }}</h4><span
                                                class="f-light">{{ __('locale.schedualed_campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='circle'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $campaigns_approve }}</h4><span
                                                class="f-light">{{ __('phishing.approved_campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='circle'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $campaigns_pending }}</h4><span
                                                class="f-light">{{ __('phishing.pending_campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='circle'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $campaigns_later }}</h4><span
                                            class="f-light">{{ __('phishing.ondemand_campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12 col-xl-12 col-md-12 box-col-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">{{ __('phishing.Yearly_Phishing_Overview') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile" type="button" role="tab"
                                        aria-controls="profile" aria-selected="false">{{ __('phishing.Yearly_Training_Overview') }}
                                        </button>
                                </li>
                            </ul>
                        </div>



                        <div class="tab-content my-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h3 class="m-0">{{ __('phishing.Phishing_Emails_Delivered') }} (Past Year)</h3>
                                    </div>
                                    <div class="card-body row p-2">
                                        <div class="col-lg-4">
                                            <h1 class="my-5 text-secondary mx-5">Total :- {{ $mailTemplates }}</h1>
                                            <p class="text-secondary">A yearly aggregation of all phishing emails
                                                delivered across all campaigns. Metrics are updated nightly.</p>
                                            <a class="btn btn-primary my-5"
                                                href="{{ route('admin.phishing.reporting') }}">{{ __('phishing.Phishing_Detailed_Reporting') }}</a>
                                        </div>
                                        <div class="col-lg-8">
                                            <div id="chart-container"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card invoice-card">
                                    <div class="card-header pb-0">
                                        <h3 class="my-3">{{ __('phishing.Employee_Phish_Risk') }} (Top 5)</h3>
                                    </div>
                                    <div class="card-body transaction-card">
                                        <div class="table-responsive theme-scrollbar">
                                            <table class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('phishing.Employee_Email') }}</th>
                                                        <th>{{ __('phishing.Full_Name') }}</th>
                                                        <th>{{ __('phishing.Risk_Score') }} </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($top_phished_employees as $employee)
                                                        <tr>
                                                            <td>{{ $employee->email }}</td>
                                                            <td>{{ $employee->name }}</td>
                                                            @if ($employee->average_percentage >= 0 && $employee->average_percentage <= 33)
                                                                <td class="text-success">
                                                                    {{ $employee->average_percentage }} <span
                                                                        class="text-secondary">%</span> (<span
                                                                        class="text-success">{{ __('phishing.Low_Risk') }}</span>)</td>
                                                            @elseif($employee->average_percentage > 33 && $employee->average_percentage <= 67)
                                                                <td class="text-warning">
                                                                    {{ $employee->average_percentage }} <span
                                                                        class="text-secondary">%</span> (<span
                                                                        class="text-warning">{{ __('phishing.Medium_Risk') }}</span>)</td>
                                                            @else
                                                                <td class="text-danger">
                                                                    {{ $employee->average_percentage }} <span
                                                                        class="text-secondary">%</span> (<span
                                                                        class="text-danger">{{ __('phishing.High_Risk') }}</span>)</td>
                                                            @endif
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h3 class="m-0">{{ __('phishing.Trainings_Assigned') }} (Past Year)</h3>
                                    </div>
                                    <div class="card-body row p-2">
                                        <div class="col-lg-4">
                                            <h1 class="my-5 text-secondary mx-5"> Total :-{{ $trainings }}</h1>
                                            <p class="text-secondary">A yearly aggregation of all training assignments
                                                across all campaigns. Metrics are updated nightly.</p>
                                            <a class="btn btn-warning my-5"
                                                href="{{ route('admin.phishing.training-reporting') }}">{{ __('phishing.Training_Detailed_Reporting') }}</a>
                                        </div>
                                        <div class="col-lg-8">
                                            <div id="training-chart-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-xl-8">
                            <div class="card invoice-card">
                                <div class="card-header pb-0">
                                    <h3 class="my-3">Employee Phish Risk (Top 5)</h3>
                                </div>
                                <div class="card-body transaction-card">
                                    <div class="table-responsive theme-scrollbar">
                                        <table class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Employee Email</th>
                                                    <th>Full Name</th>
                                                    <th>Risk Score </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($top_phished_employees as $employee)
                                                    <tr>
                                                        <td>{{ $employee->email }}</td>
                                                        <td>{{ $employee->name }}</td>
                                                        @if ($employee->average_percentage >= 0 && $employee->average_percentage <= 33)
                                                            <td class="text-success">
                                                                {{ $employee->average_percentage }} <span
                                                                    class="text-secondary">%</span> (<span
                                                                    class="text-success">Low Risk</span>)</td>
                                                        @elseif($employee->average_percentage >= 34 && $employee->average_percentage <= 67)
                                                            <td class="text-warning">
                                                                {{ $employee->average_percentage }} <span
                                                                    class="text-secondary">%</span> (<span
                                                                    class="text-warning">Medium Risk</span>)</td>
                                                        @else
                                                            <td class="text-danger">
                                                                {{ $employee->average_percentage }} <span
                                                                    class="text-secondary">%</span> (<span
                                                                    class="text-danger">High Risk</span>)</td>
                                                        @endif
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('page-script')
    {{--  <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>  --}}
    <script src="{{ asset('js/scripts/config.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // #-1 Mail chart
            Highcharts.chart('chart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '@lang("phishing.Campaign Mails Statistic") '
                },
                xAxis: {
                    categories: {!! $email_labels->toJson(JSON_UNESCAPED_UNICODE) !!},
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '@lang("phishing.Mail Statistic")'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'gray'
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
                    pointFormat: ': {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: null,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [

                    {
                        name: 'Employee delivered',
                        color: 'blue',
                        data: {!! $employee_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                    },

                    {
                        name: 'Opened',
                        color: 'green',
                        data: {!! $opened_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                    },

                    {
                        name: 'Clicked link',
                        color: 'Black',
                        data: {!! $clicked_link_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },

                    {
                        name: 'Form submited',
                        color: 'red',
                        data: {!! $submited_data_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },

                    {
                        name: 'File downloaded',
                        color: 'yellow',
                        data: {!! $downloaded_file_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },
                ]
            })

            // ************************************* Training charts *************************************
            Highcharts.chart('training-chart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Training Employee Statistic'
                },
                xAxis: {
                    categories: {!! $training_labels->toJson(JSON_UNESCAPED_UNICODE) !!},
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Training Employee Statistic'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'gray'
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
                    pointFormat: ': {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: null,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [

                    {
                        name: 'Training Employee Delivered',
                        color: 'blue',
                        data: {!! $training_total_recieved_users->toJson(JSON_UNESCAPED_UNICODE) !!}
                    },

                    {
                        name: 'Training Passed Employee',
                        color: 'green',
                        data: {!! $training_total_passed_users->toJson(JSON_UNESCAPED_UNICODE) !!}
                    },

                    {
                        name: 'Training Failed Employee',
                        color: 'black',
                        data: {!!  $training_total_failed_users->toJson(JSON_UNESCAPED_UNICODE) !!}
                    },

                    {
                        name: 'Training Over Due Employee',
                        color: 'red',
                        data: {!!  $training_total_overdue_users->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },

                ]
            })


        });
    </script>
@endsection
