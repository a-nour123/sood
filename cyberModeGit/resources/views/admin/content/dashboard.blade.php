@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Dashboard'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">

    <style>
        .feather {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        #arrowContainer {
            margin-top: 20px;
        }

        #arrowDetails {
            font-size: 1.2em;
        }

        #arrowDetails span {
            margin-right: 10px;
        }

        #frameworkAuditChart {
            height: 500px !important;
        }

        .card {
            border: none;
            /* Remove default border */
            transition: transform 0.2s;
            /* Smooth hover effect */
        }


        .widget-1 {
            background-image: none !important;
        }

        .card-title {
            font-size: 1.25rem;
            /* Increase font size */
            color: #333;
            /* Darker color for the title */
        }

        .card-text {
            font-size: 1rem;
            /* Increase font size */
            color: #555;
            /* Slightly lighter color for text */
        }

        .card-body {
            padding: 2rem;
            /* Increase padding for more spacing */
            background-color: #f8f9fa;
            /* Light background color */
            border-radius: 10px;
            /* Rounded corners */
        }

        .card i {
            font-size: 2rem;
            /* Increase icon size */
            color: #007bff;
            /* Color for the icon */
        }

        .card-footer {
            background-color: #e9ecef;
            /* Footer background color */
            border-top: 1px solid #dee2e6;
            /* Border for footer */
            padding: 0.5rem 1rem;
            /* Footer padding */
            text-align: center;
            /* Center the footer text */
            border-radius: 0 0 10px 10px;
            /* Rounded bottom corners */
        }

        #AllstandardTable_filter,
        .dataTables_info,
        #AllstandardTable_paginate {
            display: none;
        }

        canvas {
            height: 200px !important;
            margin: auto;
        }
    </style>
@endsection
@section('content')

    <section>

        <div class="dashboard_default">
            @if (auth()->user()->hasPermission('audits.audit_plan_dashboard'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.Frameworks Compliance Status') }}</h3>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($auditData as $data)
                                @php
                                    $framework = $data['framework'];
                                    $currentAuditData = $data['currentAuditData'];
                                    $previousAuditData = $data['previousAuditData'];
                                @endphp

                                <!-- Compliance Audit Card -->
                                <div class="col-md-4 align-self-center">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div
                                                    class="card-header card-no-border pb-0 d-flex justify-content-between align-items-center">
                                                    <h4>{{ $framework->name }}</h4>
                                                    <!-- Dropdown trigger -->
                                                    <div class="d-inline-flex position-relative">
                                                        <a class="pe-1 dropdown-toggle hide-arrow text-primary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-vertical font-small-4">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if (auth()->user()->hasPermission('audits.framewrok_control_compliance_status'))
                                                                <li>
                                                                    <button class="dropdown-item"
                                                                        data-id="{{ $framework->id }}"
                                                                        onclick="navigateToStatusInfo({{ $framework->id }})">
                                                                        {{ __('locale.audit_summary') }}
                                                                    </button>
                                                                </li>
                                                            @endif
                                                            @if (auth()->user()->hasPermission('audits.summary_of_results_for_evaluation_and_compliance'))
                                                                <li>
                                                                    <button class="dropdown-item"
                                                                        data-id="{{ $framework->id }}"
                                                                        onclick="navigateToStatus({{ $framework->id }})">
                                                                        {{ __('locale.audit_details') }}
                                                                    </button>
                                                                </li>
                                                            @endif
                                                            <li><button class="frame-graph-details dropdown-item"
                                                                    href="#"
                                                                    data-id="{{ $framework->id }}">{{ __('locale.audit_comparison') }}</button>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <!-- Dropdown menu at the end of the card -->
                                                <div class="card-body py-lg-3">
                                                    <ul class="user-list">
                                                        <li>
                                                            <div class="user-icon success">
                                                                <div class="user-box"><i class="font-success"
                                                                        data-feather="check-circle"></i></div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mb-1">{{ __('locale.current') }}
                                                                    <span
                                                                        class="{{ $currentAuditData && isset($currentAuditData['percentage']) && $currentAuditData['percentage'] > ($previousAuditData['percentage'] ?? 0) ? 'text-primary' : 'text-danger' }} d-flex align-items-center"
                                                                        style="font-size: 1.5rem;">
                                                                        @if ($currentAuditData && isset($currentAuditData['percentage']))
                                                                            @if ($currentAuditData['percentage'] > ($previousAuditData['percentage'] ?? 0))
                                                                                <i data-feather="arrow-up"
                                                                                    class="icon-rotate me-1"></i>
                                                                            @elseif ($currentAuditData['percentage'] < ($previousAuditData['percentage'] ?? 0))
                                                                                <i data-feather="arrow-down"
                                                                                    class="icon-rotate me-1"></i>
                                                                            @else
                                                                                <i data-feather="arrow-right"
                                                                                    class="icon-rotate me-1"></i>
                                                                            @endif
                                                                        @else
                                                                            <i data-feather="arrow-right"
                                                                                class="icon-rotate me-1"></i>
                                                                        @endif
                                                                    </span>
                                                                </h4>
                                                                <span class="font-primary d-flex align-items-center">
                                                                    <span>
                                                                        {{ $currentAuditData['percentage'] ?? __('locale.no_audit') }}
                                                                        @if (isset($currentAuditData['percentage']))
                                                                            %
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="user-icon success">
                                                                <div class="user-box"><i class="font-success"
                                                                        data-feather="settings"></i></div>
                                                            </div>

                                                            <div>
                                                                <h4 class="mb-1">{{ __('locale.previous') }}
                                                                    <span
                                                                        class="{{ $previousAuditData && isset($previousAuditData['percentage']) && $previousAuditData['percentage'] > ($currentAuditData['percentage'] ?? 0) ? 'text-primary' : 'text-danger' }} d-flex align-items-center"
                                                                        style="font-size: 1.5rem;">
                                                                        @if ($previousAuditData && isset($previousAuditData['percentage']))
                                                                            @if ($previousAuditData['percentage'] > ($currentAuditData['percentage'] ?? 0))
                                                                                <i data-feather="arrow-up"
                                                                                    class="icon-rotate me-1"></i>
                                                                            @elseif ($previousAuditData['percentage'] < ($currentAuditData['percentage'] ?? 0))
                                                                                <i data-feather="arrow-down"
                                                                                    class="icon-rotate me-1"></i>
                                                                            @else
                                                                                <i data-feather="arrow-right"
                                                                                    class="icon-rotate me-1"></i>
                                                                            @endif
                                                                        @else
                                                                            <i data-feather="arrow-right"
                                                                                class="icon-rotate me-1"></i>
                                                                        @endif
                                                                    </span>
                                                                </h4>
                                                                <span class="font-danger d-flex align-items-center">
                                                                    <span class="f-w-600">
                                                                        {{ $previousAuditData['percentage'] ?? __('locale.no_audit') }}
                                                                        @if (isset($previousAuditData['percentage']))
                                                                            %
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('locale.Compliance') }} </h4>
                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="statusChart-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasPermission('Aduit_Document_Policy.result'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.PolicystandardsCompliance') }}</h3>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-sm-6 box-col-8e order-xl-1 order-md-2">
                        <div class="card invoice-card">
                            <div class="card-header">
                                <h3>@lang('locale.NumberOfAllStandards'):
                                    <span>{{ $documentComplianceAllStandards['totaldocument'] }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-0 manageorder">
                                <div class="table-responsive" style="overflow: hidden;">
                                    <table class="table display" id="AllstandardTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('locale.Status')</th>
                                                <th>@lang('locale.NumberOfStandards')</th>
                                                <th>@lang('locale.Percentage')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($documentComplianceAllStandards['total_counts'] as $status => $count)
                                                @php
                                                    // Determine the icon and color based on the status name
                                                    if ($status === 'Implemented') {
                                                        $icon = 'check-circle'; // Font Awesome icon name
                                                        $color = 'green';
                                                    } elseif ($status === 'Not Implemented') {
                                                        $icon = 'times-circle'; // Use 'times-circle' for Font Awesome (instead of 'x-circle')
                                                        $color = 'red';
                                                    } elseif ($status === 'Not Applicable') {
                                                        $icon = 'archive'; // Icon for 'Not Applicable'
                                                        $color = 'gray';
                                                    } elseif ($status === 'Partially Implemented') {
                                                        $icon = 'minus-circle'; // Icon for 'Partially Implemented'
                                                        $color = 'orange';
                                                    } else {
                                                        $icon = 'eye'; // Fallback icon
                                                        $color = 'black';
                                                    }
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <div style="display: flex; align-items: center;">
                                                            <i class="fas fa-{{ $icon }} me-2"
                                                                style="color: {{ $color }}; font-size: 1.5em;"></i>
                                                            <span class="f-light"
                                                                style="color: {{ $color }};">{{ $status }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $count }}</td>
                                                    <td>{{ number_format($documentComplianceAllStandards['percentages'][$status], 2) }}%
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 box-col-4 order-xl-1">
                        <div class="card product-chart">
                            <div class="card-header pb-0">
                                <div class="header-top">
                                    <h3 class="m-0">@lang('locale.Status')</h3>
                                    <div class="card-header-right">
                                        <!-- Additional options if needed -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div id="compliance-audit-document-all-standards"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif




            @if (auth()->user()->hasPermission('Aduit_Document_Policy.result'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-statistics">
                            <div class="card-header" id="auditHeaderPolicy" style="cursor: pointer;">
                                <h4 class="card-title">{{ __('locale.ComplianceDocument') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="audiPolicytModal" tabindex="-1" aria-labelledby="audiPolicytModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 1200px; width: 100%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="audiPolicytModalLabel">{{ __('locale.AuditsResult') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row" id="auditsData">
                                    <!-- Audit data will be filled here by AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if (auth()->user()->hasPermission('incident.list'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.Incident') }}</h3>
                </div>
                <div class="row dashboard  widget-grid ">
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
                                        <h4>{{ $incident_count }}</h4><span
                                            class="f-light">{{ __('incident.overall_incident') }}</span>
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
                                        <h4>{{ $open_incident_count }}</h4><span
                                            class="f-light">{{ __('incident.open_incident') }}</span>
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
                                        <h4>{{ $progress_incident_count }}</h4><span
                                            class="f-light">{{ __('incident.progress_incident') }}</span>
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
                                        <h4>{{ $closed_incident_count }}</h4><span
                                            class="f-light">{{ __('incident.closed_incident') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard  widget-grid mb-5">
                    <div id="chart-incident-container"></div>
                </div>
            @endif

            @if (auth()->user()->hasPermission('riskmanagement.list'))
                <section id="chartjs-chart">
                    <div class="card-header mb-3">
                        <h3 class="card-title">Risk Info</h3>
                    </div>
                    <div class="row">

                        <div class="col-lg-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('locale.OpenVsClosed') }}</h4>
                                </div>
                                <div class="card-body">
                                    <canvas class="OpenVsClosed chartjs" data-height="275"></canvas>





                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('report.MitigationPlannedVsUnplanned') }}</h4>
                                </div>
                                <div class="card-body">
                                    <canvas class="PlannedVsUnplanned chartjs" data-height="275"></canvas>





                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('report.ReviewedVsUnreviewed') }}</h4>
                                </div>
                                <div class="card-body">
                                    <canvas class="ReviewedVsUnreviewed chartjs" data-height="275"></canvas>





                                </div>
                            </div>
                        </div>



                    </div>
                </section>
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                {!! $table !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasPermission('vulnerability_management.list'))
                <div class="card-header mb-3">
                    <h4 class="card-title">{{ __('locale.Vulnerability_Summary') }}</h4>
                </div>

                <div class="row dashboard widget-grid mb-5 status-row mb-3">
                    <!-- Overview Vulnerabilities -->
                    <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                        <div class="card widget-1"
                            style="background-image:url('images/widget-bg.png'); position: relative;">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i style="font-size:20px; color:rgb(46, 46, 45)"
                                                data-feather="minus-circle"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 style="color:rgb(46, 46, 45)">{{ $vulns['overview'] ?? 0 }}</h4>
                                        <span class="f-light"
                                            style="color:rgb(46, 46, 45)">{{ __('locale.overview_vulnerabilities') }}</span>
                                    </div>
                                </div>
                                <div class="font-secondary f-w-600">
                                    <i class="icon-arrow-up icon-rotate me-1"></i>
                                    <span
                                        style="color:rgb(46, 46, 45)">+({{ $vulns['overview_percentage'] ?? 0 }}%)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Closed Vulnerabilities -->
                    <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                        <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i style="font-size:20px; color:green" data-feather="check-circle"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 style="color:green">{{ $vulns['closedVulnerability']['count'] ?? 0 }}</h4>
                                        <span class="f-light"
                                            style="color:green">{{ __('locale.closed_vulnerabilities') }}</span>
                                    </div>
                                </div>
                                <div class="font-secondary f-w-600">
                                    <i class="icon-arrow-up icon-rotate me-1"></i>
                                    <span
                                        style="color:green">+({{ $vulns['closedVulnerability']['percentage'] ?? 0 }}%)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Open Vulnerabilities -->
                    <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                        <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i style="font-size:20px; color:red" data-feather="x-circle"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 style="color:red">{{ $vulns['openVulnerability']['count'] ?? 0 }}</h4>
                                        <span class="f-light"
                                            style="color:red">{{ __('locale.open_vulnerabilities') }}</span>
                                    </div>
                                </div>
                                <div class="font-secondary f-w-600">
                                    <i class="icon-arrow-up icon-rotate me-1"></i>
                                    <span
                                        style="color:red">+({{ $vulns['openVulnerability']['percentage'] ?? 0 }}%)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In Progress Vulnerabilities -->
                    <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                        <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i style="font-size:20px; color:rgb(165, 165, 192)"
                                                data-feather="archive"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 style="color:rgb(165, 165, 192)">
                                            {{ $vulns['progressVulnerability']['count'] ?? 0 }}</h4>
                                        <span class="f-light"
                                            style="color:rgb(165, 165, 192)">{{ __('locale.in_progress_vulnerabilities') }}</span>
                                    </div>
                                </div>
                                <div class="font-secondary f-w-600">
                                    <i class="icon-arrow-up icon-rotate me-1"></i>
                                    <span
                                        style="color:rgb(165, 165, 192)">+({{ $vulns['progressVulnerability']['percentage'] ?? 0 }}%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



            @if (auth()->user()->hasPermission('campaign.list'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.Phishing') }}</h3>
                </div>
                <div class="row dashboard  widget-grid ">
                    <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round warning">
                                        <div class="bg-round">
                                            <i class="size-18" data-feather='circle'></i>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $campaigns_count }}</h4><span
                                            class="f-light">{{ __('locale.overall_campaigns') }}</span>
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
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
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
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
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
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $campaigns_approve }}</h4><span
                                            class="f-light">{{ __('locale.approved_campaigns') }}</span>
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
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $campaigns_pending }}</h4><span
                                            class="f-light">{{ __('locale.pending_campaigns') }}</span>
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
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $campaigns_later }}</h4><span
                                            class="f-light">{{ __('locale.ondemand_campaigns') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard  widget-grid mb-5">
                    <div id="chart-campaign-container"></div>

                </div>
            @endif

            {{-- single card --}}
            {{--  <div class="row dashboard  widget-grid">
                @if (auth()->user()->hasPermission('framework.list'))
                    <div class="col-xl-4 col-lg-6 col-sm-12 box-col-4">
                        <div class="card total-earning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-7 box-col-7">
                                        <div class="d-flex">
                                            <div class="badge bg-light-primary badge-rounded font-primary me-2"> <i
                                                    class="size-18" data-feather='layers'></i></div>
                                            <div class="flex-grow-1">
                                                <h3>{{ __('locale.Frameworks') }}</h3>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">{{ $Frameworks['count'] }}</h5>

                                    </div>
                                    <div class="col-sm-5 box-col-5">
                                        <div id="expensesChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->hasPermission('asset.list'))
                    <div class="col-xl-4 col-lg-6 col-sm-12 box-col-4">
                        <div class="card total-earning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-7 box-col-7">
                                        <div class="d-flex">
                                            <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                                <i class="size-18" data-feather='file'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h3>{{ __('locale.Assets') }}</h3>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">{{ $Assets['count'] }}</h5>

                                    </div>
                                    <div class="col-sm-5 box-col-5">
                                        <div id="totalLikesAreaChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->hasPermission('asset_group.list'))
                    <div class="col-xl-4 col-lg-12 col-sm-12 box-col-4">
                        <div class="card total-earning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-7 box-col-7">
                                        <div class="d-flex">
                                            <div class="badge bg-light-secondary badge-rounded font-primary me-2">
                                                <i class="size-18" data-feather='cpu'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h3>{{ __('locale.AssetGroups') }}</h3>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">{{ $Assets['Groupcount'] }}</h5>

                                    </div>
                                    <div class="col-sm-5 box-col-5 incom-chart">
                                        <div id="Incomechrt"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->hasPermission('user_management.list'))
                    <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i class="size-18" data-feather='users'></i>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $Teams['count'] }}</h4><span
                                            class="f-light">{{ __('locale.Teams') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->hasPermission('department.list'))
                    <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round primary">
                                        <div class="bg-round">
                                            <i class="size-18" data-feather='clipboard'></i>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $Departments['count'] }}</h4><span
                                            class="f-light">{{ __('locale.Departments') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->hasPermission('job.list'))
                    <div class="col-sm-6 col-xl-4 col-lg-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round warning">
                                        <div class="bg-round">
                                            <i class="size-18" data-feather='circle'></i>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $Jobs['count'] }}</h4><span class="f-light">{{ __('locale.Jobs') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

            </div>  --}}

            {{--  exception.list  --}}
            @php
                use App\Models\Exception;

                $policyExceptions = Exception::where('type', 'policy')->get();
                $controlExceptions = Exception::where('type', 'control')->get();
                $riskExceptions = Exception::where('type', 'risk')->get();
                $unapprovedExceptions = Exception::where('request_status', '!=', '1')->get();
                $approvedRiskExceptions = Exception::where('request_status', '=', '1')->where('type', 'risk')->get();
                $rejectedRiskExceptions = Exception::where('request_status', '=', '2')->where('type', 'risk')->get();
                $pendingRiskExceptions = Exception::where('request_status', '=', '0')->where('type', 'risk')->get();
                $approvedControlExceptions = Exception::where('request_status', '=', '1')
                    ->where('type', 'control')
                    ->get();
                $rejectedControlExceptions = Exception::where('request_status', '=', '2')
                    ->where('type', 'control')
                    ->get();
                $pendingControlExceptions = Exception::where('request_status', '=', '0')
                    ->where('type', 'control')
                    ->get();
                $approvedPolicyExceptions = Exception::where('request_status', '=', '1')
                    ->where('type', 'policy')
                    ->get();
                $rejectedPolicyExceptions = Exception::where('request_status', '=', '2')
                    ->where('type', 'policy')
                    ->get();
                $pendingPolicyExceptions = Exception::where('request_status', '=', '0')->where('type', 'policy')->get();
                // dd($policyExceptions);
            @endphp
            @if (auth()->user()->hasPermission('user_management.list'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.exceptions') }}</h3>
                </div>

                <div class="row dashboard  widget-grid">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 box-col-4">
                        <div class="summary card  total-earning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 box-col-3">
                                        <div class="d-flex">
                                            <div class="badge bg-light-primary badge-rounded font-primary me-2"> <i
                                                    class="size-18" data-feather='layers'></i></div>
                                            <div class="flex-grow-1">
                                                <h3>{{ __('locale.PolicyExceptions') }}</h3>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">{{ $policyExceptions->count() }}</h5>
                                    </div>
                                    <div class="col-sm-5 box-col-5">
                                        <div id="policychart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 box-col-4">
                        <div class="summary card  total-earning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 box-col-3">
                                        <div class="d-flex">
                                            <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                                <i class="size-18" data-feather='file'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h3>{{ __('locale.ControlExceptions') }}</h3>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">{{ $controlExceptions->count() }}</h5>

                                    </div>
                                    <div class="col-sm-5 box-col-5">
                                        <div id="controlchart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 box-col-4">
                        <div class="summary card  total-earning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5 box-col-5">
                                        <div class="d-flex">
                                            <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                                <i class="size-18" data-feather='alert-triangle'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h3>{{ __('locale.RiskExceptions') }}</h3>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">{{ $riskExceptions->count() }}</h5>

                                    </div>
                                    <div class="col-sm-5 box-col-5 incom-chart">
                                        <div id="riskchart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



            @if (auth()->user()->hasPermission('user_management.list'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.Users') }}</h3>
                </div>
                <div class="row dashboard  widget-grid ">
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
                                        <h4>{{ $Users['count'] }}</h4><span
                                            class="f-light">{{ __('locale.Users') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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
                                        <h4>{{ $Users['active'] }}</h4><span
                                            class="f-light">{{ __('locale.UsersActive') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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
                                        <h4>{{ $Users['deactive'] }}</h4><span
                                            class="f-light">{{ __('locale.UsersDeactivate') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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
                                        <h4>{{ $Users['grc'] }}</h4><span
                                            class="f-light">{{ __('locale.GrcUsers') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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
                                        <h4>{{ $Users['ldap'] }}</h4><span
                                            class="f-light">{{ __('locale.LdapUsers') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            @endif

            @if (auth()->user()->hasPermission('document.list'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.Documentation') }}</h3>
                </div>
                <div class="row dashboard  widget-grid ">
                    <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body">
                                <a href="{{ route('admin.governance.category') }}">
                                    <div class="widget-content">
                                        <div class="widget-round success">
                                            <div class="bg-round">
                                                <i class="size-18" data-feather='file'></i>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>{{ $Documents['count'] }}</h4><span
                                                class="f-light">{{ __('locale.Documents') }}</span>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                    @foreach ($Documents['DocumentTypes'] as $DocumentType)
                        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <a
                                        href="{{ route('admin.governance.category') }}?doc_type={{ $DocumentType->id }}">
                                        <div class="widget-content">
                                            <div class="widget-round warning">
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
                                                <h4>{{ $DocumentType->documents->count() }}</h4><span
                                                    class="f-light">{{ $DocumentType->name . ' ' . __('locale.Type') }}</span>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>
            @endif


            <!-- third_party statics section -->
            @if (auth()->user()->hasPermission('third_party_profile.list'))
                <div class="card-header mb-3">
                    <h3 class="card-title">{{ __('locale.ThirdPartyManagment') }}</h3>
                </div>
                <div class="row dashboard  widget-grid ">
                    <div class="col-sm-6 col-xl-6 col-lg-6 box-col-6">
                        <div class="row">
                            <!-- Total profiles section -->
                            <div class="col-sm-6 col-xl-12 col-lg-6 box-col-6">
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
                                                <h4>{{ $thirdPartyData['totalProfiles'] }}</h4>
                                                <span class="f-light">{{ __('third_party.Total profiles') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!-- Total PUM requests section -->
                            <div class="col-sm-6 col-xl-12 col-lg-6 box-col-6">
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
                                                <h4>{{ $thirdPartyData['totalRequests'] }}</h4>
                                                <span class="f-light">{{ __('third_party.Total PUM requests') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Total assessments section -->
                            <div class="col-sm-6 col-xl-12 col-lg-6 box-col-6">
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
                                                <h4>{{ $thirdPartyData['totalAssessments'] }}</h4>
                                                <span class="f-light">{{ __('third_party.Total assessments') }}</span>
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
            @endif




            {{--  @if (auth()->user()->hasPermission('riskmanagement.list'))
                    <div class="col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('locale.RiskManagement') }}</h4>

                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                        <div class=" item d-flex flex-row">
                                            <div class="avatar bg-light-danger me-2">
                                                <div class="avatar-content">
                                                    <i data-feather='compass'></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0">{{ $Risks['count'] }}</h4>
                                                <p class="card-text font-small-3 mb-0">{{ __('locale.RisksCount') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                        <div class=" item d-flex flex-row">
                                            <div class="avatar bg-light-danger me-2">
                                                <div class="avatar-content">
                                                    <i data-feather='compass'></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0">{{ $Risks['Open'] }}</h4>
                                                <p class="card-text font-small-3 mb-0">{{ __('locale.RisksOpen') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                        <div class=" item d-flex flex-row">
                                            <div class="avatar bg-light-danger me-2">
                                                <div class="avatar-content">
                                                    <i data-feather='compass'></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0">{{ $Risks['Close'] }}</h4>
                                                <p class="card-text font-small-3 mb-0">{{ __('locale.RisksClose') }}</p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                @endif  --}}
            {{--  @if (auth()->user()->hasPermission('audits.list'))
                    <div class="col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('locale.Compliance') }}</h4>

                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                        <div class=" item d-flex flex-row">
                                            <div class="avatar bg-light-info me-2">
                                                <div class="avatar-content">
                                                    <i data-feather='shield'></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0">{{ $Audits['count'] }}</h4>
                                                <p class="card-text font-small-3 mb-0">{{ __('locale.Audits') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                        <div class=" item d-flex flex-row">
                                            <div class="avatar bg-light-info me-2">
                                                <div class="avatar-content">
                                                    <i data-feather='shield'></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0">{{ $Audits['active'] }}</h4>
                                                <p class="card-text font-small-3 mb-0">{{ __('locale.ActiveAudits') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                        <div class=" item d-flex flex-row">
                                            <div class="avatar bg-light-info me-2">
                                                <div class="avatar-content">
                                                    <i data-feather='shield'></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0">{{ $Audits['past'] }}</h4>
                                                <p class="card-text font-small-3 mb-0">{{ __('locale.PastAudits') }}</p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                @endif  --}}



        </div>

        {{-- table card --}}
        {{--  <div class="row" id="table-bordered">
                @php
                    $icons = [
                        'fas fa-tools',
                        'fas fa-chart-line',
                        'fas fa-cogs',
                        'fas fa-star',
                        'fas fa-check-circle',
                        'fas fa-lightbulb',
                        'fas fa-laptop-code',
                        'fas fa-clipboard-list',
                        'fas fa-users',
                        'fas fa-flag-checkered',
                        'fas fa-lock',
                        'fas fa-sitemap',
                        'fas fa-project-diagram',
                        'fas fa-bolt',
                        'fas fa-shield-alt',
                        'fas fa-globe',
                        'fas fa-exclamation-circle',
                        'fas fa-database',
                        'fas fa-puzzle-piece',
                        'fas fa-network-wired',
                        'fas fa-laptop',
                        'fas fa-heart',
                        'fas fa-mobile-alt',
                        'fas fa-paper-plane',
                        'fas fa-search',
                        'fas fa-sync-alt',
                    ];
                @endphp  --}}
        {{--

                @if (auth()->user()->hasPermission('framework.list'))
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-1">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('locale.Count Controls Of Framework') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($frameworkWithPercentage as $framework)
                                            @php
                                                $randomIcon = $icons[array_rand($icons)];
                                            @endphp
                                            <div class="col-md-4 col-sm-6 col-12 mb-3">
                                                <div class="card border shadow-sm">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title">
                                                            <i class="{{ $randomIcon }}"></i> {{ $framework['name'] }}
                                                        </h5>
                                                        <p class="card-text">
                                                            Implementation Percentage:
                                                            <strong>{{ json_decode($framework['percentage'], true) ?? '0.00' }}%</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif  --}}



        {{--  @if (auth()->user()->hasPermission('control.list'))
                    <div class="col-6">
                        <div class="card p-1">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('locale.Count Audits Of Control') }}</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="dt-advanced-search audit-table">
                                    <thead>
                                        <tr>
                                            <th>#/th>
                                            <th>{{ __('locale.Control') }}</th>
                                            <th>{{ __('locale.Count Audits Of Control') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Controls['all'] as $Control)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @php
                                                        $controlName = $Control->short_name;
                                                        if ($Control->Frameworks()->count()) {
                                                            $controlName .=
                                                                ' (' .
                                                                implode(
                                                                    ', ',
                                                                    $Control->Frameworks()->pluck('name')->toArray(),
                                                                ) .
                                                                ')';
                                                        }
                                                    @endphp
                                                    {{ $controlName }}
                                                </td>
                                                <td>
                                                    {{ $Control->frameworkControlTestAudits->count() }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('locale.Control') }}</th>
                                            <th>{{ __('locale.Count Audits Of Control') }}</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>  --}}


        <div class="modal fade" id="frameworkComprasionModal" tabindex="-1"
            aria-labelledby="frameworkComprasionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="frameworkComprasionModalLabel">Framework Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                                <div id="noAuditMessageForFrame" style="display: none; color: red;">
                                    {{ __('locale.No audits for this framework.') }}</div>
                                <!-- Message for no audits -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="statusChartForFrame-container" style="display: none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>





@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset('new_d/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>


    {{--  <script src="{{ asset('new_d/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/datatable.custom.js') }}"></script>  --}}
    {{--  <script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js') }}"></script>  --}}
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset('cdn/d3.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset('cdn/chart_1.js') }}"></script>
    <script src="{{ asset('cdn/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('cdn/feather-icons') }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>


@endsection

@section('page-script')

    <script src="{{ asset('ajax-files/general-functions.js') }}"></script>
    <script>
        // PlannedVsUnplanned Chart
        // --------------------------------------------------------------------
        let typesPlannedVsUnplanned = '{{ $openMitigationChartType }}'.split(',');
        let numbersPlannedVsUnplanned = '{{ $openMitigationChartNumber }}'.split(',');
        drawingChart('PlannedVsUnplanned', typesPlannedVsUnplanned, numbersPlannedVsUnplanned);

        // ReviewedVsUnreviewed Chart
        // --------------------------------------------------------------------
        let typesReviewedVsUnreviewed = '{{ $openReviewChartType }}'.split(',');
        let numbersReviewedVsUnreviewed = '{{ $openReviewChartNumber }}'.split(',');
        drawingChart('ReviewedVsUnreviewed', typesReviewedVsUnreviewed, numbersReviewedVsUnreviewed);

        // OpenVsClosed Chart
        // --------------------------------------------------------------------
        let typesOpenVsClosed = '{{ $openClosedChartType }}'.split(',');
        let numbersOpenVsClosed = '{{ $openClosedChartNumber }}'.split(',');
        drawingChart('OpenVsClosed', typesOpenVsClosed, numbersOpenVsClosed);

        function drawingChart(className, types, numbers) {
            var ctx = $('.' + className);
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: types,
                    datasets: [{
                        label: '# of Tomatoes',
                        data: numbers,
                        backgroundColor: GetColors(),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {

            Highcharts.chart('chart-campaign-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ' Campaign Mails Statistic'
                },
                xAxis: {
                    categories: {!! $email_labels->toJson(JSON_UNESCAPED_UNICODE) !!},
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
                        name: 'Opened',
                        color: 'green',
                        data: {!! $opened_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}
                    },

                    {
                        name: 'Form submited',
                        color: 'red',
                        data: {!! $submited_data_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },

                    {
                        name: 'Attachment downloaded',
                        color: 'yellow',
                        data: {!! $downloaded_file_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },
                    {{--  {
                        name: 'Attachment ssss',
                        color: 'blue',
                        data: {!! $clicked_link_in_mails_count->toJson(JSON_UNESCAPED_UNICODE) !!}

                    },  --}}
                ]
            })



            Highcharts.chart('chart-incident-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '@lang('incident.ScoreClassify') '
                },
                xAxis: {
                    categories: {!! json_encode($chartData['categories'], JSON_UNESCAPED_UNICODE) !!}, // Passing categories dynamically
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '@lang('incident.NumberOfIncident')'
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
                series: {!! json_encode($chartData['series'], JSON_UNESCAPED_UNICODE) !!}
            })




            $('.audit-table').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                autoWidth: true,
                searching: true,
                columnDefs: [{
                        title: '#',
                        className: 'index',
                        orderable: false,
                        responsivePriority: 0,
                        targets: 0
                    }

                ],
                buttons: [{
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                }],
                orderCellsTop: true,
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                },
                responsive: {
                    details: {

                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !== '' ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                },
            });
        });
    </script>
    <script>
        // Risk
        var approvedRiskExceptions = {{ $approvedRiskExceptions->count() }};
        var rejectedRiskExceptions = {{ $rejectedRiskExceptions->count() }};
        var pendingRiskExceptions = {{ $pendingRiskExceptions->count() }};

        // Control
        var approvedControlExceptions = {{ $approvedControlExceptions->count() }};
        var rejectedControlExceptions = {{ $rejectedControlExceptions->count() }};
        var pendingControlExceptions = {{ $pendingControlExceptions->count() }};

        // Policy
        var approvedPolicyExceptions = {{ $approvedPolicyExceptions->count() }};
        var rejectedPolicyExceptions = {{ $rejectedPolicyExceptions->count() }};
        var pendingPolicyExceptions = {{ $pendingPolicyExceptions->count() }};


        // Control Chart
        var income = {
            series: [approvedControlExceptions, rejectedControlExceptions, pendingControlExceptions],
            chart: {
                type: 'donut', // Use donut type for a round chart
                width: 280,
            },
            labels: ['Approved', 'Unapproved', 'Pending'],
            colors: ['#28a745', '#dc3545', '#6c757d'], // Green for approved, red for unapproved
            plotOptions: {
                pie: {
                    donut: {
                        size: '0%', // Adjust the size of the donut hole
                    },
                    dataLabels: {
                        enabled: false
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return (Math.round(val * 10) / 10).toFixed(1) + '%'; // Round to 1 decimal place
                }
            },
            legend: {
                position: 'bottom'
            },
        };
        var IncomechrtchartEl = new ApexCharts(document.querySelector("#controlchart"), income);
        IncomechrtchartEl.render();


        // Policy Chart
        var income = {
            series: [approvedPolicyExceptions, rejectedPolicyExceptions, pendingPolicyExceptions],
            chart: {
                type: 'donut', // Use donut type for a round chart
                width: 280,
            },
            labels: ['Approved', 'Unapproved', 'Pending'],
            colors: ['#28a745', '#dc3545', '#6c757d'], // Green for approved, red for unapproved
            plotOptions: {
                pie: {
                    donut: {
                        size: '25%', // Adjust the size of the donut hole
                    },
                    dataLabels: {
                        enabled: false
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return (Math.round(val * 10) / 10).toFixed(1) + '%'; // Round to 1 decimal place
                }
            },
            legend: {
                position: 'bottom'
            },
        };
        var IncomechrtchartEl = new ApexCharts(document.querySelector("#policychart"), income);
        IncomechrtchartEl.render();

        // Risk Chart
        var income = {
            series: [approvedRiskExceptions, rejectedRiskExceptions, pendingRiskExceptions],
            chart: {
                type: 'donut', // Use donut type for a round chart
                width: 280,
            },
            labels: ['Approved', 'Unapproved', 'Pending'],
            colors: ['#28a745', '#dc3545', '#6c757d'], // Green for approved, red for unapproved, grey for pending
            plotOptions: {
                pie: {
                    donut: {
                        size: '0%', // Adjust the size of the donut hole
                    },
                    dataLabels: {

                        enabled: false, // Disable data labels on the donut

                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return (Math.round(val * 10) / 10).toFixed(1) + '%'; // Round to 1 decimal place
                }
            },
            legend: {
                position: 'bottom'
            },
        };
        var IncomechrtchartEl = new ApexCharts(document.querySelector("#riskchart"), income);
        IncomechrtchartEl.render();
    </script>
    <script>
        $(document).ready(function() {
            // Use event delegation for dynamically loaded elements
            $(document).on('click', '.frame-graph-details, .open-modal', function(e) {
                var frameworkId = $(this).data('id'); // Get the framework ID

                // Make the AJAX call
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.dashboard.GetFrameworkAuditGraph') }}",
                    data: {
                        framework_id: frameworkId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    cache: false,
                    success: function(response) {
                        console.log(response);

                        // Clear previous chart data
                        $('#statusChartForFrame-container').empty();

                        if (response.groupedByTestNumber.length > 0) {
                            const labels = [];
                            const implementedCounts = [];
                            const notImplementedCounts = [];
                            const notApplicableCounts = [];
                            const partiallyImplementedCounts = [];
                            const arrows = [];

                            let previousCounts = {
                                implemented: 0,
                                notImplemented: 0,
                                notApplicable: 0,
                                partiallyImplemented: 0
                            };

                            response.groupedByTestNumber.forEach(function(item) {
                                labels.push("Test Name: " + item.test_number);

                                const totalCount = item.statuses.reduce((sum, status) =>
                                    sum + status.count, 0);

                                let implementedCount = 0;
                                let notImplementedCount = 0;
                                let notApplicableCount = 0;
                                let partiallyImplementedCount = 0;

                                item.statuses.forEach(function(status) {
                                    if (status.status_name === "Implemented") {
                                        implementedCount = (status.count /
                                                totalCount) *
                                            100; // Calculate percentage
                                    } else if (status.status_name ===
                                        "Not Implemented") {
                                        notImplementedCount = (status.count /
                                                totalCount) *
                                            100; // Calculate percentage
                                    } else if (status.status_name ===
                                        "Not Applicable") {
                                        notApplicableCount = (status.count /
                                                totalCount) *
                                            100; // Calculate percentage
                                    } else if (status.status_name ===
                                        "Partially Implemented") {
                                        partiallyImplementedCount = (status
                                                .count / totalCount) *
                                            100; // Calculate percentage
                                    }
                                });

                                implementedCounts.push(implementedCount);
                                notImplementedCounts.push(notImplementedCount);
                                notApplicableCounts.push(notApplicableCount);
                                partiallyImplementedCounts.push(
                                    partiallyImplementedCount);
                            });

                            // Show the chart container and hide the no audit message
                            $('#statusChartForFrame-container').show();
                            $('#noAuditMessageForFrame').hide();

                            // Highcharts configuration
                            Highcharts.chart('statusChartForFrame-container', {
                                chart: {
                                    type: 'column'
                                },
                                title: {

                                    text: '{{ __('locale.Status Statistic') }}',
                                },
                                xAxis: {
                                    categories: labels,
                                    title: {
                                        text: '{{ __('locale.Test Name') }}'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    max: 100,
                                    title: {
                                        text: '{{ __('locale.Percentage') }}(%)'
                                    },
                                },
                                tooltip: {
                                    headerFormat: '<b>{point.x}</b>',
                                    pointFormat: ': {point.y:.2f}%'
                                },
                                series: [{
                                        name: '{{ __('locale.Implemented') }}',
                                        color: '#44225c',
                                        data: implementedCounts
                                    },
                                    {
                                        name: '{{ __('locale.NotImplemented') }}',
                                        color: '#dc3545',
                                        data: notImplementedCounts
                                    },
                                    {
                                        name: '{{ __('locale.NotApplicable') }}',
                                        color: '#9e9e9e',
                                        data: notApplicableCounts
                                    },
                                    {
                                        name: '{{ __('locale.PartiallyImplemented') }}',
                                        color: '#ffc107',
                                        data: partiallyImplementedCounts
                                    }
                                ]
                            });

                            // Show the modal
                            $('#frameworkComprasionModal').modal('show');

                        } else {
                            // Hide the chart and show the no audit message
                            $('#statusChartForFrame-container').hide();
                            $('#noAuditMessageForFrame').show();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, val) {
                                console.log(key, val);
                            });
                        } else {
                            console.log("An unexpected error occurred:", xhr);
                        }
                    }
                });
            });
        });
    </script>
    <script>
        function navigateToStatus(frameworkId) {
            // Construct the URL with the framework ID
            var url = "{{ route('admin.reporting.framewrok_control_compliance_status') }}" + "?framework_id=" +
                frameworkId;

            // Navigate to the constructed URL
            window.location.href = url;
        }
    </script>
    <script>
        function navigateToStatusInfo(frameworkId) {
            // Construct the URL with the framework ID
            var url = "{{ route('admin.reporting.summary_of_results_for_evaluation_and_compliance') }}" +
                "?framework_id=" + frameworkId;

            // Navigate to the constructed URL
            window.location.href = url;
        }
    </script>
    <script>
        $(document).ready(function() {
            var responseData = @json($groupedByFramework);
            var groupedByFramework = responseData.original.groupedByFramework; // Access the correct path
            if (groupedByFramework.length > 0) {
                const labels = [];
                const implementedCounts = [];
                const notImplementedCounts = [];
                const notApplicableCounts = [];
                const partiallyImplementedCounts = [];

                groupedByFramework.forEach(function(item) {
                    labels.push(item.framework_name);

                    // Initialize counts for the current framework
                    let implementedCount = 0;
                    let notImplementedCount = 0;
                    let notApplicableCount = 0;
                    let partiallyImplementedCount = 0;

                    // Extract counts for each status from the item
                    item.statuses.forEach(function(status) {
                        switch (status.status_name) {
                            case "Implemented":
                                implementedCount = parseFloat(status.percentage);
                                break;
                            case "Not Implemented":
                                notImplementedCount = parseFloat(status.percentage);
                                break;
                            case "Not Applicable":
                                notApplicableCount = parseFloat(status.percentage);
                                break;
                            case "Partially Implemented":
                                partiallyImplementedCount = parseFloat(status.percentage);
                                break;
                        }
                    });

                    implementedCounts.push(implementedCount);
                    notImplementedCounts.push(notImplementedCount);
                    notApplicableCounts.push(notApplicableCount);
                    partiallyImplementedCounts.push(partiallyImplementedCount);
                });

                // Highcharts configuration
                Highcharts.chart('statusChart-container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '{{ __('locale.Status Statistic') }}',
                        style: {
                            marginBottom: '120px',
                        }
                    },
                    xAxis: {
                        categories: labels,
                        title: {
                            text: '{{ __('locale.Framework') }}'
                        }
                    },
                    yAxis: {
                        min: 0,
                        max: 100, // Set maximum to 100 for percentage
                        title: {
                            text: '{{ __('locale.Percentage') }}(%)'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions
                                    .title.style.color) || 'gray'
                            }
                        }
                    },
                    legend: {
                        align: 'right',
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
                        pointFormat: ': {point.y:.2f}%'
                    },
                    plotOptions: {
                        column: {
                            stacking: null, // Set stacking to null for clustered bars
                            dataLabels: {
                                enabled: true,
                                formatter: function() {
                                    return this.y.toFixed(2) + '%'; // Return only the percentage
                                }
                            }
                        }
                    },
                    series: [{
                            name: '{{ __('locale.Implemented') }}',
                            color: '#44225c',
                            data: implementedCounts
                        },
                        {
                            name: '{{ __('locale.Not Implemented') }}',
                            color: '#dc3545',
                            data: notImplementedCounts
                        },
                        {
                            name: '{{ __('locale.Not Applicable') }}',
                            color: '#9e9e9e',
                            data: notApplicableCounts
                        },
                        {
                            name: '{{ __('locale.Partially Implemented') }}',
                            color: '#ffc107',
                            data: partiallyImplementedCounts
                        }
                    ]
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            let loaded = false; // To prevent multiple AJAX calls

            $('#auditHeaderPolicy').on('click', function() {
                // Show the modal when header is clicked
                $('#audiPolicytModal').modal('show');

                if (!loaded) { // Only make the AJAX call if not already loaded
                    loaded = true; // Prevent further AJAX calls

                    $.ajax({
                        url: '{{ route('document.compliance.auditpolicy.result') }}', // Your route for fetching audit data
                        method: 'GET',
                        success: function(data) {
                            const auditsDiv = $('#auditsData');
                            auditsDiv.empty(); // Clear previous data

                            // Check if data is empty
                            if ($.isEmptyObject(data)) {
                                auditsDiv.append(`
                        <div class="col-12 text-center">
                            <p class="font-small-3 mb-0">{{ __('locale.NoDataAvailable') }}</p>
                        </div>
                    `);
                            } else {
                                // Define status colors
                                const statusColors = {
                                    'Implemented': 'bg-success',
                                    'Partially Implemented': 'bg-warning',
                                    'Not Implemented': 'bg-danger',
                                    'Not Applicable': 'bg-secondary',
                                    'No Action': 'bg-info' // Change this to your desired color class
                                };

                                // Iterate over the audit data
                                // Iterate over the audit data
                                $.each(data, function(documentName, documentData) {
                                    // Assuming documentData.regions is an array of objects with 'region' and 'overall_status'
                                    const regionsArray = documentData.regions.map(
                                        region => {
                                            return {
                                                region: region
                                                    .region, // Adjust based on the actual structure
                                                overall_status: region
                                                    .overall_status
                                            };
                                        });

                                    auditsDiv.append(`
                                <div class="col-6 mb-3">
                                    <h5>${documentName}</h5>
                                    <ul class="list-group mt-3">
                                        ${regionsArray.map(region => `
                                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                                            ${region.region}
                                                                                            <span class="badge ${statusColors[region.overall_status] || 'bg-light'} rounded-pill">
                                                                                                ${region.overall_status}
                                                                                            </span>
                                                                                        </li>
                                                                                    `).join('')}
                                    </ul>
                                </div>
                            `);
                                });

                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching audit data:', xhr);
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var responseData = @json($documentComplianceAllStandards);
            var totalCounts = responseData.total_counts;
            var percentages = responseData.percentages;

            if (totalCounts) {
                const data = [{
                        name: 'Implemented',
                        y: percentages.Implemented
                    },
                    {
                        name: 'Partially Implemented',
                        y: percentages['Partially Implemented']
                    }, // Added missing comma here
                    {
                        name: 'Not Implemented',
                        y: percentages['Not Implemented']
                    },
                    {
                        name: 'Not Applicable',
                        y: percentages['Not Applicable']
                    },
                ];

                const options = {
                    chart: {
                        type: 'pie',
                        height: 270
                    },
                    labels: data.map(item => item.name),
                    series: data.map(item => item.y),
                    colors: ['#44225c', '#ffc107', '#dc3545', '#9e9e9e'],
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " %";
                            }
                        }
                    },
                    title: {
                        text: '' // Uncommented the title
                    }
                };

                const chart = new ApexCharts(document.querySelector("#compliance-audit-document-all-standards"),
                    options);
                chart.render();
            }
        });
    </script>

    <script>
        // third party chart
        $(document).ready(function() {
            const evaluatedThirdParty = {{ $thirdPartyData['evaluatedThirdParty'] }};
            const notEvaluatedThirdParty = {{ $thirdPartyData['notEvaluatedThirdParty'] }};

            Highcharts.chart('third_party-chart-container', {
                chart: {
                    type: 'pie',
                    backgroundColor: null, // Optional, remove background
                    height: '285', // Adjust height for better appearance
                    width: 600 // Set a specific width in pixels
                },
                title: {
                    text: '{{ __('third_party.Evaluation third-party') }}'
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
                    name: '{{ __('third_party.Evaluation third-party') }}',
                    data: [{
                            name: '{{ __('third_party.Evaluated') }}',
                            y: evaluatedThirdParty,
                            color: '#28a745'
                        },
                        {
                            name: '{{ __('third_party.Not Evaluated') }}',
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

        });
    </script>


@endsection
