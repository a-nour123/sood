@extends('admin/layouts/contentLayoutMaster')

@section('title', __('Phishing.domains'))

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">

@endsection


@section('page-style')
<link rel="stylesheet" href="{{ asset('cdn/buttons.dataTables.min.css') }}">

<style>
    .page-wrapper.compact-small .page-body-wrapper .page-body {
        margin-left: 0 !important;
    }
    .page-wrapper .page-body-wrapper .page-body{
        padding: 0 !important
    }

    button.dt-button, div.dt-button, a.dt-button, input.dt-button{
        background-color: #7ae3ee !important;
        color: white !important;
    }

    .text-center{
        text-align: center;
    }

    .highcharts-credits{
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



    <!-- Modal Email Template Data -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myExtraLargeModal" aria-hidden="true" id="campaign-employees-data-modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myExtraLargeModal">Campaign Employees</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <!-- <div class="modal fade" style="z-index: 99999999; top: 150px;" id="campaign-employees-data-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"       aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document"> -->
        <div class="modal-content">

            <!-- <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Campaign Employees</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->

            <div class="modal-body">
                <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-employee" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-datatable table-responsive">
                                    <table class="employee-dt-advanced-server-search table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="all">Name </th>
                                                <th class="all">Email</th>
                                                <th class="all">Mail Delivered</th>
                                                <th class="all">Mail Opened</th>
                                                <th class="all">Download File</th>
                                                <th class="all">Submit Data</th>
                                                <th class="all">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    </div>



    <!-- Modal Training data -->
    <div class="modal fade" style="z-index: 99999999; top: 150px;" id="training-employees-data-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"       aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Campaign Employees</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-training-employee" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-datatable table-responsive">
                                    <table class="training-employee-dt-advanced-server-search table">
                                        <thead>
                                            <tr>
                                                <th class="all">Email</th>
                                                <th class="all">Name </th>
                                                <th class="all">Training Name</th>
                                                <th class="all">Date Assigned</th>
                                                <th class="all">Score</th>
                                                <th class="all">Completed</th>
                                                <th class="all">OverDue</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>


    <!-- Modal Details Employee Data Table -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myExtraLargeModal" aria-hidden="true" id="details-employees-data-modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <!-- <div class="modal-header">
          <h4 class="modal-title" id="myExtraLargeModal">Campaign Employees</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->
    <!-- <div class="modal fade" style="z-index: 99999999; top: 150px;" id="details-employees-data-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"       aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document"> -->
        <div class="modal-content">

            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" class="employee-name">Campaign Employees</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="col-xxl-12 col-xl-12 col-md-12 box-col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="employee-campaign-tab" data-bs-toggle="tab" data-bs-target="#employee-campaign" type="button" role="tab" aria-controls="employee-campaign" aria-selected="true"> Phishing Campaigns </button>
                        </li> --}}

                         <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="employee-training-tab" data-bs-toggle="tab" data-bs-target="#employee-training" type="button" role="tab" aria-controls="employee-training" aria-selected="false"> Training Assignments</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content my-3" id="myTabContent">
                    {{-- Employee Training Information --}}
                    <div class="tab-pane fade show" id="employee-campaign" role="tabpanel" aria-labelledby="employee-campaign-tab">
                        <div class="card invoice-card">
                            <div class="card-header pb-0">
                              <h3 class="my-3">Employee Campaigns</h3>
                            </div>
                            <div class="card-body transaction-card">
                              <div class="table-responsive theme-scrollbar">
                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-employee-details-phishing" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>
                                <table class="display employee-details-phishing-dt-advanced-server-search" id="recent-order-employee-details-phishing" style="width:100%">
                                  <thead>
                                    <tr>
                                        <th class="text-center">CAMPAIGN NAME</th>
                                        <th class="text-center">Mail Template</th>
                                        <th class="text-center">Mail Opened</th>
                                        <th class="text-center">Link Clicked</th>
                                        <th class="text-center">File Downloaded</th>
                                        <th class="text-center">Data Submitted</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>

                    {{-- Employee Training Information --}}
                    <div class="tab-pane fade show active" id="employee-training" role="tabpanel" aria-labelledby="employee-training-tab">
                        <div class="card invoice-card">
                            <div class="card-header pb-0">
                              <h3 class="my-3">Employee Training Campaigns</h3>
                            </div>
                            <div class="card-body transaction-card">
                              <div class="table-responsive theme-scrollbar">

                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-employee-details-training" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>

                                <table class="display employee-details-training-dt-advanced-server-search" id="recent-order-employee-details-training" style="width:100%">
                                  <thead>
                                    <tr>
                                        <th class="text-center">CAMPAIGN NAME</th>
                                        <th class="text-center">TRAINING NAME</th>
                                        <th class="text-center">SCORE</th>
                                        <th class="text-center"> COMPLETED</th>
                                        <th class="text-center"> OVERDUE</th>
                                        <th class="text-center"> PASSED</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
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




                <div class="col-xxl-12 col-xl-12 col-md-12 box-col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> Phishing Statistics </button>
                        </li> --}}

                         <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"> Training Information</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee" type="button" role="tab" aria-controls="employee" aria-selected="false"> Employee Information</button>
                        </li>
                    </ul>
                </div>


                <div class="tab-content my-3" id="myTabContent">
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="card">
                            <div class="card-header pb-0">
                              <h3 class="m-0">Phishing Emails Delivered (Past Year)</h3>
                            </div>
                            <div class="card-body row p-2">
                                <div id="chart-container"></div>
                            </div>
                        </div>

                        {{-- campaign chart --}}
                        <div class="card">
                            <div class="card-header pb-0">
                              <h3 class="m-0">Campaigns Statistic</h3>
                            </div>
                            <div class="card-body row p-2">
                              <div class="col-lg-12">
                                <div id="campaign-chart-container"></div>
                              </div>
                            </div>
                        </div>

                        {{-- Groups chart --}}
                        <div class="card">
                            <div class="card-header pb-0">
                              <h3 class="m-0">Groups Statistic</h3>
                            </div>
                            <div class="card-body row p-2">
                              <div class="col-lg-12">
                                <div id="groups-chart-container"></div>
                              </div>
                            </div>
                        </div>


                        {{-- Employees chart --}}
                        <div class="card">
                            <div class="card-header pb-0">
                              <h3 class="m-0">Employees Statistic</h3>
                            </div>
                            <div class="card-body row p-2">
                              <div class="col-lg-12">
                                <div id="employees-chart-container"></div>
                              </div>
                            </div>
                        </div>



                        <div class="card invoice-card">
                            <div class="card-header pb-0">
                              <h3 class="my-3">Active Campaigns</h3>
                            </div>
                            <div class="card-body transaction-card">
                              <div class="table-responsive theme-scrollbar">
                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-active-phishing" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>
                                <table class="display active-phishing-dt-advanced-server-search" id="recent-order-active-phishing" style="width:100%">
                                  <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">CAMPAIGN NAME</th>
                                        <th class="text-center">STATUS </th>
                                        <th class="text-center">CAMPAIGN TYPE</th>
                                        <th class="text-center">SCEDULE DATE</th>
                                        <th class="text-center"> EMAIL DELIVERED</th>
                                        <th class="text-center"> EMAIL OPENED</th>
                                        <th class="text-center"> EMAIL DOWNLOAD FILE</th>
                                        <th class="text-center"> EMAIL SUBMIT DATA</th>
                                        <th class="text-center"> ACTIONS</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    {{-- @foreach ($activeCampaigns as $campaign)
                                        <tr style="cursor: pointer"  onclick="openCampaignEmployees({{$campaign->id}})">
                                            <td class="text-center">{{ $campaign->campaign_name }}</td>
                                            <td class="text-center text-warning">{{ $campaign->status }}</td>
                                            <td class="text-center">{{ $campaign->schedule_date_from }} - {{ $campaign->schedule_date_to }}</td>
                                            <td class="text-center">{{ $campaign->deliverd_email_templates_count }}</td>
                                            <td class="text-center">{{ $campaign->opend_count }}</td>
                                            <td class="text-center">{{ $campaign->submited_count }}</td>
                                            <td class="text-center">{{ $campaign->downloaded_count }}</td>
                                            <td class="text-center">actions</td>
                                        </tr>
                                    @endforeach --}}

                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>

                        <div class="card invoice-card">
                        </div>
                    </div>

                    {{-- Training Information --}}
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header pb-0">
                              <h3 class="m-0">Trainings Assigned (Past Year)</h3>
                            </div>
                            <div class="card-body row p-2">
                              <div class="col-lg-12">
                                <div id="training-chart-container"></div>
                              </div>
                            </div>
                        </div>

                        {{-- Active Training Campaigns --}}
                        <div class="card invoice-card">
                            <div class="card-header pb-0">
                              <h3 class="my-3">Active Training Campaigns</h3>
                            </div>
                            <div class="card-body transaction-card">
                              <div class="table-responsive theme-scrollbar">

                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-active-training" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>

                                <table class="display active-training-dt-advanced-server-search" id="recent-order-active-training" style="width:100%">
                                  <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">CAMPAIGN NAME</th>
                                        <th class="text-center">STATUS </th>
                                        <th class="text-center">CAMPAIGN TYPE</th>
                                        <th class="text-center">SCHEDULED DATE</th>
                                        <th class="text-center"> EMPLOYEE COUNT</th>
                                        <th class="text-center"> ASSSIGNED</th>
                                        <th class="text-center"> COMPLETED</th>
                                        <th class="text-center"> OVERDUE</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>

                        {{-- Archived Training Campaigns --}}
                        <div class="card invoice-card">
                            <div class="card-header pb-0">
                              <h3 class="my-3">Archived Training Campaigns</h3>
                            </div>
                            <div class="card-body transaction-card">
                              <div class="table-responsive theme-scrollbar">

                                <div class="row align-items-center text-center text-md-left">
                                    <div class="col-lg-12 mt-lg-0 mt-3">
                                        <div id="dt-btns-archived-training" class="tableAdminOption">
                                        </div>
                                    </div>
                                </div>

                                <table class="display archived-training-dt-advanced-server-search" id="recent-order-archived-training" style="width:100%">
                                  <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">CAMPAIGN NAME</th>
                                        <th class="text-center">STATUS </th>
                                        <th class="text-center">CAMPAIGN TYPE</th>
                                        <th class="text-center">SCHEDULED DATE</th>
                                        <th class="text-center"> EMPLOYEE COUNT</th>
                                        <th class="text-center"> ASSSIGNED</th>
                                        <th class="text-center"> COMPLETED</th>
                                        <th class="text-center"> OVERDUE</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>


                    </div>

                    {{-- Employee Information --}}
                    <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                        <div class="card invoice-card">
                            <div class="card-header pb-0">
                              <h3 class="my-3">Employee Statistics</h3>
                            </div>
                            <div class="card-body transaction-card">
                                <div class="table-responsive theme-scrollbar">

                                    <div class="row align-items-center text-center text-md-left">
                                        <div class="col-lg-12 mt-lg-0 mt-3">
                                            <div id="dt-btns-employee-statistics" class="tableAdminOption">
                                            </div>
                                        </div>
                                    </div>

                                    <table class="display employee-statistics-dt-advanced-server-search" id="recent-order-employee-statistics" style="width:100%">
                                      <thead>
                                        <tr>
                                            <th class="text-center"> ID</th>
                                            <th class="text-center"> EMAIL</th>
                                            <th class="text-center"> NAME</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
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
@endsection

@section('page-script')
{{--  <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>  --}}
<script src="{{ asset('js/scripts/config.js') }}"></script>
<script src="{{ asset('new_d/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('new_d/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
{{-- DataTable Buttons Excel - Pdf - Print -.... --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ************************************* Phishing charts *************************************
        Highcharts.chart('chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ' Campaign Mails Statistic'
            },
            xAxis: {
                categories: {!! $labels->toJson(JSON_UNESCAPED_UNICODE) !!},
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Mail Statistic'
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
                    name: 'opened count',
                    color: 'green',
                    data: {!! $opened_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'form submited count',
                    color: 'red',
                    data: {!! $submited_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                },

                {
                    name: 'file downloaded count',
                    color: 'yellow',
                    data: {!! $downloaded_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                },
            ]
        })

        // #-2 Campaign chart
        Highcharts.chart('campaign-chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ' Campaign Mails And Employee Statistic',
                style: {
                    marginBottom: '120px',
                }
            },
            xAxis: {
                categories: {!! $campaig_labels->toJson(JSON_UNESCAPED_UNICODE) !!},
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Campaign Mails And Employee Statistic'
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
                    name: 'Deliverd email',
                    color: '#33bcbc',
                    data: {!! $deliverd_email_templates_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Deliverd employees',
                    color: '#0dcaf0',
                    data: {!! $deliverd_employees_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Not Deliverd email',
                    color: '#6c757d',
                    data: {!! $not_deliverd_email_templates_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Not Deliverd employees',
                    color: '#9560dd',
                    data: {!! $not_deliverd_employees_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },
            ]
        })

        // #-3 Groups chart
        Highcharts.chart('groups-chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Groups Statistic',
                style: {
                    marginBottom: '120px',
                }
            },
            xAxis: {
                categories: {!! $phish_groups_labels->toJson(JSON_UNESCAPED_UNICODE) !!},
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Groups Statistic'
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
                    name: 'Employee',
                    color: '#33bcbc',
                    data: {!! $phish_groups_employee_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Campaigns',
                    color: '#0dcaf0',
                    data: {!! $phish_groups_campaign_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Deliverd email',
                    color: '#6c757d',
                    data: {!! $phish_groups_deliverd_email_templates_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Deliverd employees',
                    color: '#9560dd',
                    data: {!! $phish_groups_deliverd_employees_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Not Deliverd email',
                    color: 'orange',
                    data: {!! $phish_groups_not_deliverd_email_templates_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Not Deliverd employees',
                    color: 'yellow',
                    data: {!! $phish_groups_not_deliverd_employees_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Mail opened',
                    color: 'pink',
                    data: {!! $phish_groups_opened_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },


                {
                    name: 'Form submited',
                    color: 'red',
                    data: {!! $phish_groups_submited_data_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },
                {
                    name: 'File download',
                    color: 'brown',
                    data: {!! $phish_groups_downloaded_file_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },
            ]
        })

        // #-4 Employees chart
        Highcharts.chart('employees-chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Employees Statistic',
                style: {
                    marginBottom: '120px',
                }
            },
            xAxis: {
                categories: {!! $employees_labels->toJson(JSON_UNESCAPED_UNICODE) !!},
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Employees Statistic'
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
                    name: 'Campaigns',
                    color: '#0dcaf0',
                    data: {!! $employees_campaigns_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Mail opened',
                    color: 'pink',
                    data: {!! $employee_opened_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Form submited',
                    color: 'red',
                    data: {!! $employee_submited_data_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                },
                {
                    name: 'File download',
                    color: 'brown',
                    data: {!! $employee_downloaded_file_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
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
                    data: {!! $training_total_failed_users->toJson(JSON_UNESCAPED_UNICODE) !!}
                },

                {
                    name: 'Training Over Due Employee',
                    color: 'red',
                    data: {!! $training_total_overdue_users->toJson(JSON_UNESCAPED_UNICODE) !!}

                },
            ]
        })
    });


    // ************************************* Phishing Modal *************************************
    function openCampaignEmployees(id){
        console.log('campaign id is ' + id)
        getCampaignEmployeesDataTable(id);
        $('#campaign-employees-data-modal').modal('show')
    }

    function getCampaignEmployeesDataTable(campaign_id) {
        if ($.fn.DataTable.isDataTable('.employee-dt-advanced-server-search')) {
            $('.employee-dt-advanced-server-search').DataTable().destroy();
        }

        var table = $('.employee-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    // csvHtml5: "csvHtml5",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getCampaignData', ':id') }}".replace(':id', campaign_id),
            },
            columns: [
                { name: "id", data: "id", sortable: false, searchable: false, orderable: false },
                { name: "name", data: "name" },
                { name: "email", data: "email", searchable: true },
                { name: "delivered", data: "delivered", searchable: true },
                { name: "count_of_opened", data: "count_of_opened", searchable: true },
                { name: "count_of_submited", data: "count_of_submited", searchable: true },
                { name: "count_of_downloaded", data: "count_of_downloaded", searchable: true },
                { name: "actions", data: "actions", searchable: false }
            ],
            "initComplete": function (settings, json) {
                table.buttons().container().appendTo('#dt-btns-employee');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });
    }


    // ************************************* Training Modal *************************************
    function openTrainingEmployees(id){
        console.log('campaign id is ' + id)
        getTrainingEmployeesDataTable(id);
        $('#training-employees-data-modal').modal('show')
    }

    function getTrainingEmployeesDataTable(campaign_id) {
        if ($.fn.DataTable.isDataTable('.training-employee-dt-advanced-server-search')) {
            $('.training-employee-dt-advanced-server-search').DataTable().destroy();
        }

        var table = $('.training-employee-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    // csvHtml5: "csvHtml5",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getEmployeeOfTrainingCampaign', ':id') }}".replace(':id', campaign_id),
            },
            columns: [

                { name: "user_email", data: "user_email",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "user_name", data: "user_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "training_name", data: "training_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "date_assigned", data: "date_assigned", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "score", data: "score", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "completed", data: "completed", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "overdue", data: "overdue", sortable: true, searchable: true, orderable: true,className: "text-center"},


            ],
            "initComplete": function (settings, json) {
                table.buttons().container().appendTo('#dt-btns-training-employee');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });
    }


    // ************************************* Employee Details Modal *************************************
    function openDetailsForEmployee(id){
        console.log('employee id is ' + id)
        getDetailsEmployeeDataTable(id);
        $('#details-employees-data-modal').modal('show')
    }

    function getDetailsEmployeeDataTable(employee_id) {
        if ($.fn.DataTable.isDataTable('.employee-details-phishing-dt-advanced-server-search')) {
            $('.employee-details-phishing-dt-advanced-server-search').DataTable().destroy();
        }

        if ($.fn.DataTable.isDataTable('.employee-details-training-dt-advanced-server-search')) {
            $('.employee-details-training-dt-advanced-server-search').DataTable().destroy();
        }

        // Phishing
        var employeePhishingTable = $('.employee-details-phishing-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getEmployeePhishingDataTable',':id') }}".replace(':id',employee_id),
            },
            columns: [
                { name: "campaign_name", data: "campaign_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "template_name", data: "template_name", sortable: true, searchable: true, orderable: true,className: "text-center"},

                { name: "is_opened", data: "is_opened", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "is_link_clicked", data: "is_link_clicked", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "is_file_downloaded", data: "is_file_downloaded", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "is_data_submitted", data: "is_data_submitted", sortable: true, searchable: true, orderable: true,className: "text-center"},
            ],
            "initComplete": function (settings, json) {
                employeePhishingTable.buttons().container().appendTo('#dt-btns-employee-details-phishing');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });

        // Training
        var employeeTrainingTable = $('.employee-details-training-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getEmployeeTrainingCampaignData',':id') }}".replace(':id',employee_id),
            },
            columns: [
                { name: "campaign_name", data: "campaign_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "training_name", data: "training_name", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "score", data: "score", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "completed", data: "completed", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "overdue", data: "overdue", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "passed", data: "passed", sortable: true, searchable: true, orderable: true,className: "text-center"},
            ],
            "initComplete": function (settings, json) {
                employeeTrainingTable.buttons().container().appendTo('#dt-btns-employee-details-training');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });


    }




    $(document).ready(function(){

        // ************************************* Phishing Data Tables *************************************
        var activePhishingTable = $('.active-phishing-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getActivePhishingDataTable') }}",
            },
            columns: [
                { name: "id", data: "id", sortable: false, searchable: false, orderable: false,className: "text-center"},
                { name: "campaign_name", data: "campaign_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "status", data: "status", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "campaign_type", data: "campaign_type", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "schedule_date", data: "schedule_date", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "deliverd_email_templates_count", data: "deliverd_email_templates_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "opend_count", data: "opend_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "downloaded_count", data: "downloaded_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "submited_count", data: "submited_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
            ],
            "initComplete": function (settings, json) {
                activePhishingTable.buttons().container().appendTo('#dt-btns-active-phishing');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });

        $('.active-phishing-dt-advanced-server-search tbody').on('click', 'tr', function () {
            var data = activePhishingTable.row(this).data();
            if (data) {
                openCampaignEmployees(data.id);
            }
        });

        var archivedPhishingTable = $('.archived-phishing-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getArchivedPhishingDataTable') }}",
            },
            columns: [
                { name: "id", data: "id", sortable: false, searchable: false, orderable: false,className: "text-center"},
                { name: "campaign_name", data: "campaign_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "status", data: "status", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "campaign_type", data: "campaign_type", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "schedule_date", data: "schedule_date", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "deliverd_email_templates_count", data: "deliverd_email_templates_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "opend_count", data: "opend_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "downloaded_count", data: "downloaded_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "submited_count", data: "submited_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
            ],
            "initComplete": function (settings, json) {
                archivedPhishingTable.buttons().container().appendTo('#dt-btns-archived-phishing');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });

        $('.archived-phishing-dt-advanced-server-search tbody').on('click', 'tr', function () {
            var data = archivedPhishingTable.row(this).data();
            if (data) {
                openCampaignEmployees(data.id);
            }
        });


        // ************************************* Training Data Tables *************************************
        var activeTable = $('.active-training-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getActiveTrainingCampaignData') }}",
            },
            columns: [
                { name: "id", data: "id", sortable: false, searchable: false, orderable: false,className: "text-center"},
                { name: "campaign_name", data: "campaign_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "status", data: "status", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "campaign_type", data: "campaign_type", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "schedule_date", data: "schedule_date", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "employee_count", data: "employee_count", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "assigned", data: "assigned", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "completed", data: "completed", sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "overdue", data: "overdue", sortable: true, searchable: true, orderable: true,className: "text-center"},
            ],
            "initComplete": function (settings, json) {
                activeTable.buttons().container().appendTo('#dt-btns-active-training');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });

        $('.active-training-dt-advanced-server-search tbody').on('click', 'tr', function () {
            var data = activeTable.row(this).data();
            if (data) {
                openTrainingEmployees(data.id);
            }
        });

        var archivedTable = $('.archived-training-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getArchivedTrainingCampaignData') }}",
            },
            columns: [
                { name: "id", data: "id", sortable: false, searchable: false, orderable: false,className: "text-center"},
                { name: "campaign_name", data: "campaign_name",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "status", data: "status",sortable: true, searchable: true, orderable: true,className: "text-center" },
                { name: "campaign_type", data: "campaign_type",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "schedule_date", data: "schedule_date",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "employee_count", data: "employee_count",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "assigned", data: "assigned",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "completed", data: "completed",sortable: true, searchable: true, orderable: true,className: "text-center"},
                { name: "overdue", data: "overdue",sortable: true, searchable: true, orderable: true,className: "text-center"},
            ],
            "initComplete": function (settings, json) {
                archivedTable.buttons().container().appendTo('#dt-btns-archived-training');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });

        $('.archived-training-dt-advanced-server-search tbody').on('click', 'tr', function () {
            var data = archivedTable.row(this).data();
            if (data) {
                openTrainingEmployees(data.id);
            }
        });

        // ************************************* Employee Statistics Data Tables *************************************
        var employeeStatisticTable = $('.employee-statistics-dt-advanced-server-search').DataTable({
            "language": {
                buttons: {
                    excelHtml5: "Excel",
                    print: "Print",
                    pageLength: "Show",
                    //pdfHtml5: "pdfHtml5",
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                // 'csvHtml5',
                //'pdfHtml5',
                'print',
                'pageLength'
            ],
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.phishing.campaign.getTrainingEmployee') }}",
            },
            columns: [
                { name: "id", data: "user_id", searchable: true,className:'text-center' },
                { name: "email", data: "email", searchable: true,className:'text-center' },
                { name: "name", data: "name",searchable: true,className:'text-center' },
                // { name: "average_percentage", data: "average_percentage",searchable: true,className:'text-center'},
            ],
            "initComplete": function (settings, json) {
                employeeStatisticTable.buttons().container().appendTo('#dt-btns-employee-statistics');
                $('.buttons-excel, .buttons-print, .buttons-collection').addClass('no-transition custom-btn');
                $('.tableAdminOption span, button.dt-button').tooltip();
            }
        });

        $('.employee-statistics-dt-advanced-server-search tbody').on('click', 'tr', function () {
            var data = employeeStatisticTable.row(this).data();
            if (data) {
                openDetailsForEmployee(data.user_id);
            }
        });

    })

</script>
@endsection
