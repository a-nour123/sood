@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Audit'))

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
    <link rel="stylesheet" href="{{ asset('cdn/all.min.css') }}">

    <style>
        .card.domains span {
            background: #f2f2f2;
            margin: 5px;
            border: 1px solid #DDD;
            padding: 5px;
            border-radius: 15px;
        }

        .btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 8px;
        }

        .card.domains {
            {{--  display: flex;  --}} {{--  flex-flow: wrap;  --}}
        }

        /* .slide-table {
                                                                                                                                                                                                                                            display: none;
                                                                                                                                                                                                                                        } */

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

        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .button-icon {
            color: #007bff;
            /* Bootstrap primary color */
            font-size: 24px;
        }

        .button-icon:hover {
            color: #0056b3;
            /* Darker shade on hover */
        }

        .alert {
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 40vh;
            width: 100%;
        }

        .logo {
            margin-bottom: 20px;
            text-align: center;
        }

        .framework-name {
            font-size: 26px;
            color: #343a40;
            font-weight: bold;
        }

        .framework-description {
            font-size: 16px;
            line-height: 1.6;
            color: #6c757d !important;
        }

        .fa-history {
            color: #ff6347 !important;
            /* Tomato color */
        }

        .icon-current {
            color: #4caf50 !important;
            /* Green color */
        }

        .fa-arrow-left {
            color: #2196f3 !important;
            /* Blue color */
        }

        .fas {
            font-size: 21px !important;
        }

        < !-- Custom CSS for fluid modal -->.modal-dialog-fluid {
            max-width: 90% !important;
            ;
            /* Adjust this value as needed */
            width: auto;
        }

        @media (min-width: 768px) {
            .modal-dialog-fluid {
                max-width: 80% !important;
                ;
                /* Adjust this value as needed for larger screens */
            }
        }

        @media (min-width: 992px) {
            .modal-dialog-fluid {
                max-width: 70% !important;
                ;
                /* Adjust this value as needed for larger screens */
            }
        }

        @media (min-width: 1200px) {
            .modal-dialog-fluid {
                max-width: 60% !important;
                ;
                /* Adjust this value as needed for larger screens */
            }
        }


        .radial-progress-card h6 {
            font-size: 1.2rem;
        }

        .sale-details {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .f-light {
            font-size: 0.9rem;
        }

        .modern-card {
            border: none;
            /* No border for a clean look */
            border-radius: 12px;
            /* Rounded corners */
            background-color: #ffffff;
            /* White background */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Smooth transitions */
        }

        .modern-card:hover {
            transform: translateY(-5px);
            /* Lift effect on hover */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            /* Enhanced shadow on hover */
        }

        .status-box h6 {
            font-size: 1.15rem;
            /* Font size for status */
            font-weight: 600;
            /* Semi-bold */
            color: #4a4a4a;
            /* Dark gray color */
        }

        .count-text {
            font-size: 1.4rem;
            /* Larger font for count */
            font-weight: bold;
            /* Bold text for emphasis */
            color: #3b82f6;
            /* Blue color for count */
        }

        .percentage-text {
            font-size: 0.85rem;
            /* Smaller font for percentage */
            color: #6b7280;
            /* Gray color for less emphasis */
        }

        .total-controls {
            font-size: 0.9rem;
            /* Font size for total controls */
            color: #9ca3af;
            /* Lighter gray color */
            margin-top: 10px;
            /* Space above */
        }

        .radial-chart-wrap {
            margin-top: 15px;
            /* Spacing for the chart */
            display: flex;
            /* Flexbox for centering */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
        }

        .card-header.card-no-border.pb-0.d-flex {
            justify-content: space-between !important;
        }

        #showRequirementDetailsModal {
            z-index: 999999999999999999;
        }

        /* Animation for radial charts */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .radial-chart-wrap {
            animation: fadeIn 0.5s ease-in;
            /* Animation effect */
        }

        .widget-1 .widget-round.secondary {
            border-color: #e1cfcd !important;
        }

        /* Adjust margins and styling for modal form */
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
                        <div class="col-sm-6 pe-0" style="text-align: end;">

                            <div class="action-content">
                                @if (auth()->user()->hasPermission('audits.create'))
                                    <a href="{{ route('admin.governance.notificationsSettingsAduitSchedule') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif


                                <!--
                                <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a> -->
                                {{-- <a class="btn btn-primary"
                                    href="{{ route('admin.governance.framework.ajax.graphViewFramework', ['id' => $framework->id]) }}">
                                    <i class="fa-solid fa-file-invoice"></i> --}}
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>
</div>

@if (auth()->user()->hasPermission('audits.audit_plan_dashboard'))

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
                                        <h4>{{ __('locale.Compliance Audit') }}: {{ $framework->name }}</h4>
                                        <!-- Compliance Audit -->
                                        <!-- Dropdown trigger -->
                                        <div class="d-inline-flex position-relative">
                                            <a class="pe-1 dropdown-toggle hide-arrow text-primary"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-vertical font-small-4">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="5" r="1"></circle>
                                                    <circle cx="12" cy="19" r="1"></circle>
                                                </svg>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if (auth()->user()->hasPermission('audits.framewrok_control_compliance_status'))
                                                    <li>
                                                        <button class="dropdown-item open-modal"
                                                            data-id="{{ $framework->id }}"
                                                            onclick="navigateToStatusInfo({{ $framework->id }})">
                                                            {{ __('locale.Audit Summary') }} <!-- Audit Summary -->
                                                        </button>
                                                    </li>
                                                @endif
                                                @if (auth()->user()->hasPermission('audits.summary_of_results_for_evaluation_and_compliance'))
                                                    <li>
                                                        <button class="dropdown-item open-modal"
                                                            data-id="{{ $framework->id }}"
                                                            onclick="navigateToStatus({{ $framework->id }})">
                                                            {{ __('locale.Audit Details') }} <!-- Audit Details -->
                                                        </button>
                                                    </li>
                                                @endif
                                                <li><button class="dropdown-item frame-graph-details" href="#"
                                                        data-id="{{ $framework->id }}">{{ __('locale.Audit Comparison') }}</button>
                                                    <!-- Audit Comparison -->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Dropdown menu at the end of the card -->
                                    <div class="card-body py-lg-3">
                                        <ul class="user-list">
                                            <li>
                                                <div class="user-icon primary">
                                                    <div class="user-box"><i class="font-primary"
                                                            data-feather="user-plus"></i></div>
                                                </div>
                                                <div>
                                                    <h4 class="mb-1">{{ __('locale.Current') }} <!-- Current -->
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
                                                            {{ $currentAuditData['percentage'] ?? __('locale.No Audit') }}
                                                            <!-- No Audit -->
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
                                                            data-feather="user-minus"></i></div>
                                                </div>
                                                <div>
                                                    <h4 class="mb-1">{{ __('locale.Previous') }} <!-- Previous -->
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
                                                            {{ $previousAuditData['percentage'] ?? __('locale.No Audit') }}
                                                            <!-- No Audit -->
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


    <div class="col-12">
        <div class="card card-statistics">
            <div class="card-header">
                <h4 class="card-title">{{ __('locale.Compliance') }}</h4>
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


@endif
<!-- Modal -->
<div class="modal fade" id="frameworkModal" tabindex="-1" aria-labelledby="frameworkModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="frameworkModalLabel">Framework Details</h5>
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





<div class="row">
    <div class="col-12">
        <!-- Modal Definition -->
        <div class="modal fade" id="showDomainDetailsModal" tabindex="-1" role="dialog"
            aria-labelledby="domainDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content rounded-3 shadow-lg">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="domainDetailsModalLabel">{{ __('locale.DomainDetails') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="domainDetailsContent" style="background-color: #f9f9f9;">
                        <div class="status row status-row gx-4 mx-1">

                            <!-- Status cards will be injected here -->

                        </div>

                        <div class="row">
                            <div class="EvidenceRecDoc col-12 mb-4">
                                <!-- Evidence and document cards will be injected here -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="OpenClosed col-12 mb-4">
                                <!-- Open and closed cards will be injected here -->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('locale.SelectOptionsAndDomainDetails') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="mt-4">
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="familySelect"
                                                class="form-label">{{ __('locale.SelectFamily') }}</label>
                                            <select id="familySelect" class="form-select">
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="controlSelect"
                                                class="form-label">{{ __('locale.SelectControl') }}</label>
                                            <select id="controlSelect" class="form-select">
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="statusFilter"
                                                class="form-label">{{ __('locale.StatusFilter') }}</label>
                                            <select id="statusFilter" name="status" class="form-select">
                                                <option value="" selected>{{ __('locale.SelectOption') }}
                                                </option>
                                                <option value="Implemented">{{ __('locale.Implemented') }}</option>
                                                <option value="Not Implemented">{{ __('locale.NotImplemented') }}
                                                </option>
                                                <option value="Not Applicable">{{ __('locale.NotApplicable') }}
                                                </option>
                                                <option value="Partially Implemented">
                                                    {{ __('locale.PartiallyImplemented') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h5 class="mt-4">{{ __('locale.DomainDetailsTable') }}</h5>
                                    <table class="dt-advanced-server-search table" id="domainDetailsTableBody">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ __('locale.Control') }}</th>
                                                <th>{{ __('locale.SubDomain') }}</th>
                                                <th>{{ __('locale.Status') }}</th>
                                                <th>{{ __('locale.TotalRequirements') }}</th>
                                                <th>{{ __('locale.TotalEvidence') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>








        {{-- crate aduiter --}}
        <div class="modal fade" id="startNewAuditModal" tabindex="-1" aria-labelledby="startNewAuditModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="startNewAuditModalLabel">{{ __('locale.StartNewAudit') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="startAuditForm" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="audit_name" class="form-label">{{ __('locale.Audit Name') }}</label>
                                <input type="text" class="form-control" name="audit_name" id="audit_name"
                                    placeholder="Enter audit name">
                                <span class="error error-audit_name text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    {{ __('locale.Audit_type') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="audit_type" id="audit_type" required>
                                    <option value="1">{{ __('locale.Internal') }}</option>
                                    <option value="2">{{ __('locale.External') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    {{ __('locale.Audit_Function') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="audit_function" id="audit_function" required>
                                    <option value="1">{{ __('locale.New') }}</option>
                                    <option value="2">{{ __('locale.Archieved') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="regulator_id" class="form-label">{{ __('locale.Regulator') }}</label>
                                <select class="form-control" name="regulator_id" id="regulator_id">
                                    <option value="">{{ __('Select Regulator') }}</option>
                                    @foreach ($regulators as $regulator)
                                        <option value="{{ $regulator->id }}">{{ $regulator->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-regulator_id text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label for="framework_id" class="form-label">{{ __('locale.Framework') }}</label>
                                <select class="form-control" name="framework_id" id="framework_id">
                                    <option value="">{{ __('locale.Select Framework') }}</option>
                                </select>
                                <span class="error error-framework_id text-danger"></span>
                            </div>

                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.Auditor') }}</label>
                                <select class="select2 form-select" name="owner_id">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($enabledUsers as $owner)
                                        <option value="{{ $owner->id }}"
                                            data-manager="{{ json_encode($owner->manager) }}">
                                            {{ $owner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-owner_id text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.SelectAssistant') }}</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="responsibleType"
                                            id="selectUsers" value="users" checked>
                                        <label class="form-check-label"
                                            for="selectUsers">{{ __('locale.Users') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="responsibleType"
                                            id="selectTeams" value="teams">
                                        <label class="form-check-label"
                                            for="selectTeams">{{ __('locale.Teams') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" id="usersSelectContainer">
                                <label class="form-label">{{ __('locale.Assistant') }}</label>
                                <select class="select2 form-select" name="responsible[]" multiple="multiple">
                                    <option value="" disabled>{{ __('locale.select-option') }}</option>
                                    @foreach ($enabledUsers as $owner)
                                        <option value="{{ $owner->id }}"
                                            data-manager="{{ json_encode($owner->manager) }}">
                                            {{ $owner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-responsible text-danger"></span>
                            </div>

                            <div class="mb-3 d-none" id="teamsSelectContainer">
                                <label class="form-label">{{ __('locale.Team') }}</label>
                                <select name="responsible[]" class="form-select select2" multiple="multiple">
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-responsible text-danger"></span>
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="fp-default">{{ __('locale.StartDate') }}</label>
                                <input name="start_date" class="form-control flatpickr-date-time-compliance"
                                    placeholder="YYYY-MM-DD" />
                                <span class="error error-start_date text-danger"></span>
                            </div>
                            <div class="mb-0">
                                <label class="form-label" for="fp-default">{{ __('locale.Duedate') }}</label>
                                <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                    placeholder="YYYY-MM-DD" />
                                <span class="error error-due_date text-danger"></span>
                            </div>
                            <div class="mb-0">
                                <label for="">{{ __('locale.periodicalTime') }}
                                    ({{ __('locale.days') }})</label>
                                <input type="number" min="0" name="periodical_time" id="periodical_time"
                                    value="0" class="form-control">
                            </div>

                            <div class="mb-0">
                                <label for="">{{ __('locale.NextIntiateDate') }}</label>
                                <input type="text" name=" next_initiate_date" placeholder="YYYY-MM-DD "
                                    id="next_review" class="form-control" readonly>
                                <span class="error error- next_initiate_date"></span>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">{{ __('locale.Start') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- edit Aduite --}}
        <div class="modal fade" id="editAuditModal" tabindex="-1" aria-labelledby="editAuditModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAuditModalLabel">{{ __('locale.EditAudit') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editAuditForm" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="editAuditId">
                            <!-- Regulator Field -->
                            <div class="mb-3">
                                <label class="form-label">
                                    {{ __('locale.Audit_type') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="audit_type" id="edit_audit_type" required>
                                    <option value="1">{{ __('locale.Internal') }}</option>
                                    <option value="2">{{ __('locale.External') }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    {{ __('locale.Audit_Function') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="audit_function" id="edit_audit_function" required>
                                    <option value="1">{{ __('locale.New') }}</option>
                                    <option value="2">{{ __('locale.Archieve') }}</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_regulator_id"
                                    class="form-label">{{ __('locale.Regulator') }}</label>
                                <select class="form-control" name="regulator_id" id="edit_regulator_id" disabled>
                                    @foreach ($regulators as $regulator)
                                        <option value="{{ $regulator->id }}">
                                            {{ $regulator->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Framework Field -->
                            <div class="mb-3">
                                <label for="edit_framework_id"
                                    class="form-label">{{ __('locale.Framework') }}</label>
                                <select class="form-control" name="framework_id" id="edit_framework_id" disabled>

                                </select>
                            </div>
                            <!-- Owner Field -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.Auditor') }}</label>
                                <select class="select2 form-select" name="owner_id" id="edit_owner_id">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($enabledUsers as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="responsibleTypeEdithidden" id="responsibleTypeEdithidden">
                            <input type="hidden" name="responsibleEdit[]" id="responsiblePersonEdithidden">
                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.SelectAssistant') }}</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="responsible_type"
                                            id="edit_selectUsers" value="users">
                                        <label class="form-check-label"
                                            for="edit_selectUsers">{{ __('locale.Users') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="responsible_type"
                                            id="edit_selectTeams" value="teams">
                                        <label class="form-check-label"
                                            for="edit_selectTeams">{{ __('locale.Teams') }}</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Responsible Users Multi-Select -->
                            <div class="mb-3 d-none" id="edit_usersSelectContainer">
                                <label class="form-label">{{ __('locale.Assistant') }}</label>
                                <select id="edit_responsible_user" class="select2 form-select" multiple="multiple">
                                    @foreach ($enabledUsers as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Responsible Teams Multi-Select -->
                            <div class="mb-3 d-none" id="edit_teamsSelectContainer">
                                <label class="form-label">{{ __('locale.Team') }}</label>
                                <select id="edit_responsible_team" class="form-select select2" multiple="multiple">
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date Field -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.StartDate') }}</label>
                                <input name="start_date" id="edit_start_date"
                                    class="form-control flatpickr-date-time-compliance" placeholder="YYYY-MM-DD">
                                {{-- <span class="error error-start_date"></span> --}}
                            </div>
                            <!-- Due Date Field -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.Duedate') }}</label>
                                <input name="due_date" id="edit_due_date"
                                    class="form-control flatpickr-date-time-compliance" placeholder="YYYY-MM-DD">
                                {{-- <span class="error error-due_date"></span> --}}
                            </div>
                            <!-- Periodical Time Field -->
                            <div class="mb-3">
                                <label for="edit_periodical_time">{{ __('locale.periodicalTime') }}
                                    ({{ __('locale.days') }})</label>
                                <input type="number" min="0" id="edit_periodical_time"
                                    name="periodical_time" class="form-control">
                            </div>
                            <!-- Next Initiate Date Field -->
                            <div class="mb-3">
                                <label for="edit_next_review">{{ __('locale.NextIntiateDate') }}</label>
                                <input type="text" name="next_initiate_date" id="edit_next_review"
                                    class="form-control" placeholder="YYYY-MM-DD" readonly>
                                <span class="error error-next_initiate_date"></span>
                            </div>
                            <input type="hidden" name="test_number_initiated" id="edit_test_number_initiated">
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">{{ __('locale.UpdateAudit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->hasPermission('audits.audit_plan'))
            <div class="card p-3 pt-4 mt-3">

                <div class="buttons-actions" style="display: flex">

                    <a class="btn btn-primary f-primary" id="toggleTableBtn">{{ __('locale.Audit History') }} <span
                            class="ms-2"></span></a>
                    @if (auth()->user()->hasPermission('audits.create'))
                        {{-- <input type="hidden" name="audits_framework_id" value="{{ $framework->id }}"> --}}
                        <button type="button" class="btn btn-primary f-primary" id="startNewAuditBtn"
                            style="margin: 0 20px;">
                            {{ __('locale.Start New Audit') }}
                        </button>
                    @endif
                </div>
                <hr>
                <div class="fluid-container slide-table">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="regulatorsIdFilter">{{ __('locale.Regulator Filter') }}:</label><br>
                            <select id="regulatorsIdFilter" name="regulatorsIdFilter" class="form-select">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                                @foreach ($regulators as $regulator)
                                    <option value="{{ $regulator->name }}" data-id="{{ $regulator->id }}">
                                        {{ $regulator->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-4 mb-3">
                            <label for="frameworkIdFilter">{{ __('locale.Framework Filter') }}:</label><br>
                            <select id="frameworkIdFilter_id" name="frameworkIdFilter" class="form-select">
                                <option value="" selected>{{ __('locale.select-option') }}</option>

                            </select>
                        </div>
                    </div>
                    <h1>{{ __('locale.Audits') }}</h1>
                    <table id="dataTableREfresh" class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.ID') }}</th>
                                <th>{{ __('locale.Audit Name') }}</th>
                                <th>{{ __('locale.Audit_Type') }}</th>
                                <th>{{ __('locale.Audit_Function') }}</th>
                                <th>{{ __('locale.Regulator') }}</th>
                                <th>{{ __('locale.Framework') }}</th>
                                <th>{{ __('locale.Auditer') }}</th>
                                <th>{{ __('locale.Type Of Responsible') }}</th>
                                <th>{{ __('locale.Assistant') }}</th>
                                <th>{{ __('locale.Start Date') }}</th>
                                <th>{{ __('locale.Due Date') }}</th>
                                <th>{{ __('locale.Periodical Time') }}</th>
                                <th>{{ __('locale.Next Initiate Date') }}</th>
                                <th>{{ __('locale.Closed percentage') }}</th>
                                <th>{{ __('locale.Audit Number Initiated') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        @endif
    </div>
</div>


{{-- Requirement Details Modal --}}
<div class="modal fade" id="showRequirementDetailsModal" tabindex="-1" role="dialog"
    aria-labelledby="requirementDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">{{ __('compliance.Evidences') }}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle"
                        id="requirementDetailsTable">
                        <thead class="table-primary">
                            <tr>
                                <th>{{ __('compliance.AttachName') }}</th>
                                <th>{{ __('locale.CreatedBy') }}</th>
                                <th>{{ __('compliance.EvidenceFile') }}</th>
                                <th>{{ __('locale.Created At') }}</th>
                                <th>{{ __('locale.Updated At') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="sedationModal" class="modal fade modal-fullscreen" tabindex="-1" role="dialog">
    <!-- Modal content will be dynamically loaded here -->
</div>

<!-- Modal for showing unclosed controls -->
<div class="modal fade" id="controlsModalNotClosed" tabindex="-1" aria-labelledby="controlsModalNotClosedLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-custom-size" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="controlsModalNotClosedLabel">{{ __('locale.Unclosed Controls') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="controlsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('locale.Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table rows will be added dynamically -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="showFrameworkDetailsModal" tabindex="-1" role="dialog"
    aria-labelledby="frameworkDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="frameworkDetailsModalLabel">{{ __('locale.Framework Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="frameworkDetailsContent" style="background-color: #f2f2f2 !important;">
                <div class="row status-row mb-3">
                    <div class="status col-12 d-flex flex-wrap justify-content-around">
                        <!-- Status cards will be injected here -->
                    </div>
                </div>
                <div class="row">
                    <div class="OpenClosed col-12">
                        <!-- Open and closed cards will be injected here -->
                    </div>
                </div>
                <!-- Table Section -->
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('locale.FrameworkDetails') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label for="frameworkFamilySelect"
                                        class="form-label">{{ __('locale.Select Family') }}</label>
                                    <select id="frameworkFamilySelect" class="form-select">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="frameworkControlSelect"
                                        class="form-label">{{ __('locale.Select Control') }}</label>
                                    <select id="frameworkControlSelect" class="form-select">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="frameworkStatusFilter">{{ __('locale.Status Filter') }}:</label><br>
                                    <select id="frameworkStatusFilter" name="status" class="form-select">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                        <option value="Implemented">{{ __('locale.Implemented') }}</option>
                                        <option value="Not Implemented">{{ __('locale.Not Implemented') }}</option>
                                        <option value="Not Applicable">{{ __('locale.Not Applicable') }}</option>
                                        <option value="Partially Implemented">
                                            {{ __('locale.Partially Implemented') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                <table class="dt-advanced-server-search table" id="frameworkDetailsTableBody">
                                    <thead>
                                        <tr>
                                            <th>{{ __('locale.Control') }}</th>
                                            <th>{{ __('locale.Sub Domain') }}</th>
                                            <th>{{ __('locale.Status') }}</th>
                                            <th>{{ __('locale.Tester') }}</th>
                                            <th>{{ __('locale.Total Requirements') }}</th>
                                            <th>{{ __('locale.Total Approved Requirements') }}</th>
                                            <th>{{ __('locale.Total Evidence') }}</th>
                                            <th>{{ __('locale.Total Approved Evidence') }}</th>
                                            <th>{{ __('locale.Requirement') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="{{ asset('new_d/js/chart/chartist/chartist.js') }}"></script>
<script src="{{ asset('new_d/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>
<script src="{{ asset('cdn/d3_1.min.js') }}"></script>
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="{{ asset('cdn/chart.js') }}"></script>
<script src="{{ asset('cdn/jquery-ui.min.js') }}"></script>
<script src="{{ asset('cdn/feather-icons') }}"></script>
<script src="{{ asset('cdn/sedation-jquery-ui.min.js') }}"></script>




<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
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
    function showError(data) {
        $('.error').empty();
        $.each(data, function(key, value) {
            $('.error-' + key).empty();
            $('.error-' + key).append(value);
        });
    }

    // status [warning, success, error]
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }

    $('.multiple-select2').select2();

    $(document).ready(function() {
        $('#regulator_id, #regulatorsIdFilter').on('change', function() {
            // Get the regulator ID from the selected option
            var regulatorId = $(this).find(':selected').data('id');
            console.log(regulatorId); // Check if regulatorId is undefined

            // Alternative approach if the above still gives undefined
            if (typeof regulatorId === "undefined") {
                regulatorId = $(this).val(); // Sometimes it's just the value, not data
            }

            // Clear the framework dropdowns
            $('#framework_id').html('<option value="">{{ __('locale.Select Framework') }}</option>');
            $('#frameworkIdFilter_id').html(
                '<option value="">{{ __('locale.Select Framework') }}</option>');

            if (regulatorId) {
                $.ajax({
                    url: '{{ route('admin.audit.getFrameworksByRegulator', '') }}/' +
                        regulatorId,
                    type: 'GET',
                    success: function(data) {
                        $.each(data, function(key, framework) {
                            // Append to both framework dropdowns
                            $('#framework_id').append('<option value="' + framework
                                .id + '">' + framework.name + '</option>');
                            $('#frameworkIdFilter_id').append('<option value="' +
                                framework.id + '">' + framework.name +
                                '</option>');
                        });
                    }
                });
            }
        });
    });



    $(document).ready(function() {
        $('#startNewAuditBtn').on('click', function() {
            $('#startNewAuditModal').modal('show');
        });
    });

    $(document).ready(function() {
        $('#add-new-audit').on('click', function() {
            $('#startNewAuditModal').modal('show');
        });
    });



    $(document).ready(function() {
        $('#startAuditForm').on('submit', function(event) {
            event.preventDefault();

            // Clear previous error messages
            $('.error').text('');

            let isValid = true;

            // Validate required fields
            const auditName = $('#audit_name').val();
            const regulatorId = $('#regulator_id').val();
            const frameworkId = $('#framework_id').val();
            const ownerId = $('select[name="owner_id"]').val();
            const responsibleType = $('input[name="responsibleType"]:checked').val();
            const responsible = $('select[name="responsible[]"]').val();

            // Get the dates from the form
            const startDate = new Date($('input[name="start_date"]').val());
            const dueDate = new Date($('input[name="due_date"]').val());

            if (!startDate || startDate == 'Invalid Date') {
                console.log('Start date is invalid');
                $('.error-start_date').text('{{ __('locale.Start date is required') }}');
                isValid = false;
            }

            if (!dueDate || dueDate == 'Invalid Date') {
                console.log('Due date is invalid');
                $('.error-due_date').text('{{ __('locale.Due date is required') }}');
                isValid = false;
            }


            // Validate audit name
            if (!auditName) {
                $('.error-audit_name').text('{{ __('locale.Audit name is required') }}');
                isValid = false;
            }

            // Validate regulator
            if (!regulatorId) {
                $('.error-regulator_id').text('{{ __('locale.Regulator is required') }}');
                isValid = false;
            }

            // Validate framework
            if (!frameworkId) {
                $('.error-framework_id').text('{{ __('locale.Framework is required') }}');
                isValid = false;
            }

            // Validate owner
            if (!ownerId) {
                $('.error-owner_id').text('{{ __('locale.Owner is required') }}');
                isValid = false;
            }

            // Validate responsible (users or teams)
            if (!responsible || responsible.length === 0) {
                $('.error-responsible').text('{{ __('locale.Select at least one user or team') }}');
                isValid = false;
            }
            // Validate that due_date is after start_date
            if (dueDate <= startDate) {
                makeAlert('error', 'Due date must be after the start date.', 'Validation Error');
                return; // Stop execution and prevent the AJAX call
            }


            if (isValid) {
                // Proceed with checking for closed controls after form validation
                $.ajax({
                    url: `{{ route('admin.governance.fetch.controls.closed', '') }}/${frameworkId}`,
                    method: 'GET',
                    success: function(response) {
                        const notClosedCount = response.notClosedCount;
                        const allMappedControlsExist = response.allMappedControlsExist;
                        const controlsNotClosed = response.controlsNotClosed;

                        if (notClosedCount > 0) {
                            // SweetAlert for unclosed controls
                            Swal.fire({
                                title: 'Unclosed Controls Found',
                                text: 'There are some controls that are not closed. What would you like to do?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ignore and Continue',
                                cancelButtonText: 'Cancel Initiation',
                                showDenyButton: true,
                                denyButtonText: 'Show Controls'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Proceed if ignored
                                    handleMappedControls(allMappedControlsExist);
                                } else if (result.dismiss === Swal.DismissReason
                                    .cancel) {
                                    Swal.fire('Initiation Cancelled', '', 'info');
                                    $('#startNewAuditModal').modal('hide');
                                } else if (result.dismiss === Swal.DismissReason
                                    .deny) {
                                    // Show Controls Modal
                                    const controlsTableBody = $(
                                        '#controlsTable tbody');
                                    controlsTableBody.empty();

                                    controlsNotClosed.forEach(function(control,
                                        index) {
                                        controlsTableBody.append(
                                            `<tr><td>${index + 1}</td><td>${control.name}</td></tr>`
                                        );
                                    });

                                    $('#controlsModalNotClosed').modal('show');
                                }
                            });
                        } else {
                            // Proceed if no unclosed controls
                            handleMappedControls(allMappedControlsExist);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching controls:', error);
                    }
                });
            }
        });

        // Handle Mapped Controls Existence
        function handleMappedControls(allMappedControlsExist) {
            if (!allMappedControlsExist) {
                Swal.fire({
                    title: 'Incomplete Mapped Controls',
                    text: 'Some controls are mapped but not all are accounted for in the Audit. Would you like to complete them or cancel?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Complete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#startNewAuditModal').modal('show');
                    } else {
                        Swal.fire('Initiation Cancelled', '', 'info');
                    }
                });
            } else {
                $('#startNewAuditModal').modal('show');
            }

            // Proceed with form submission after handling mapped controls
            submitAuditForm();
        }

        // Submit Audit Form
        function submitAuditForm() {
            const formData = new FormData($('#startAuditForm')[0]);

            $.ajax({
                url: '{{ route('admin.audit.storeAduitResponsible.store') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        makeAlert('success', 'Audit started successfully', 'Success');
                        $('#startNewAuditModal').modal('hide');
                        var frameworkId = $('#framework_id').val();
                        submitCreateAudit(frameworkId);
                        $('#dataTableREfresh').DataTable().ajax.reload(); // Refresh the table data
                    } else {
                        for (const [key, value] of Object.entries(data.errors)) {
                            makeAlert('error', value[0], 'Validation Error');
                        }
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    });





    function submitCreateAudit(frameworkId) {
        let url = "{{ route('admin.governance.audit.getFrameworkTests') }}";
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                audits_framework_id: frameworkId
            },
            success: function(data) {
                if (data.status) {
                    var groupTestIdsString = data.data;
                    initiateAudit(groupTestIdsString, frameworkId); // Pass frameworkId to initiateAudit
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                // Display error alert if deletion fails
                let responseData = response.responseJSON;
                showError(responseData['errors']);
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function initiateAudit(id, frameworkId) { // Accept frameworkId
        // Show loading overlay
        $.blockUI({
            message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('Initiate Audit')]) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });

        // Call CreateAuditTest
        CreateAuditTest(id, frameworkId).then(() => {
            // Function completed successfully
            Swal.fire({
                icon: "success",
                title: "{{ __('governance.InitiateAudit') }}",
                text: "{{ __('governance.InitiateAuditSuccessfully') }}",
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        }).catch((error) => {
            // Handle any errors from CreateAuditTest function
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error initiating the audit'
            });
        }).finally(() => {
            // Hide loading overlay after function completes (whether success or failure)
            $.unblockUI();
            location.reload();
        });
    }


    function CreateAuditSellectAll() {
        var groupTestIds = $('input[name="audits[]"]:checked');
        if (groupTestIds.length <= 0) {
            makeAlert('error', "{{ __('governance.PleaseSelectOneTestAtLeast') }}", ' Error!');
        } else {
            var groupTestIdsString = '';
            groupTestIds.each(function() {
                if ($(this).is(':checked')) {
                    groupTestIdsString = $(this).val() + ',' + groupTestIdsString;
                }
            });
            showModalCreateAudit(groupTestIdsString);
        }
    }




    // create  Audit for list of tests

    function CreateAuditTest(id, frameworkId) { // Accept frameworkId as a parameter
        return new Promise((resolve, reject) => {
            let url = "{{ route('admin.governance.audit.store') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    framework_id: frameworkId // Send the framework ID
                },
                success: function(data) {
                    resolve(data); // Resolve the Promise with the data received
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(errorThrown); // Reject the Promise with the error message
                }
            });
        });
    }


    // Submit form for creating asset
    $('#add-new-regulator form').submit(function(e) {
        e.preventDefault();

        // Create a FormData object
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-regulator').modal('hide');
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // Submit form for editing asset
    $('#edit-regulator form').submit(function(e) {
        e.preventDefault();

        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.governance.regulator.update', ':id') }}";
        url = url.replace(':id', id);

        // Create a FormData object
        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: "POST", // Laravel typically handles file uploads via POST
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set the content type to false as jQuery will tell the server it's a query string request
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-regulator form').trigger("reset");
                    $('#edit-regulator').modal('hide');
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    $(document).on('click', '.new-frame-modal-btn', function() {
        var regulator_id = $(this).data('regulator');
        $('.regulator_id').val(regulator_id);
    });



    $(document).on('click', '.edit-regulator', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        const editForm = $("#edit-regulator form");

        // Start Assign asset data to modal
        editForm.find('input[name="id"]').val(id);
        editForm.find("input[name='name']").val(name);
        // End Assign asset data to modal
        $('.dtr-bs-modal').modal('hide');
        $('#edit-regulator').modal('show');
    });



    // Reset form
    function resetFormData(form) {
        $('.error').empty();
        form.trigger("reset")
        form.find('input:not([name="_token"])').val('');
        form.find('select.multiple-select2 option[selected]').attr('selected', false);
        form.find('select.select2 option').attr('selected', false);
        form.find("select.select2").each(function(index) {
            $(this).find('option').first().attr('selected', true);
        });
        form.find('select').trigger('change');
    }

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })

    $('.add_frame').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    if (data.reload)
                        location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }


        });

    });

    // Load subdomains of framework domain
    $(document).on('change', '.framework_domain_select', function() {
        const oldDomains = $(this).data("prev"),
            currentDomains = $(this).val();
        let deletedDomains = oldDomains.filter(x => !currentDomains.includes(x));
        let addedDomains = currentDomains.filter(x => !oldDomains.includes(x));
        const subDomainSelect = $(this).parents('.family-container').next().find('select');

        addedDomains.forEach(domain => {
            const subDomains = $(this).find(`[value="${domain}"]`).data('families');
            if (subDomains)
                subDomains.forEach(subDomains => {
                    subDomainSelect.append(
                        `<option data-parent="${domain}" value="${subDomains.id}">${subDomains.name}</option>`
                    );
                });
        });

        deletedDomains.forEach(domain => {
            subDomainSelect.find('option[data-parent="' + domain + '"]').remove();
        });

        subDomainSelect.trigger('change');
        $(this).data("prev", $(this).val());
    });
</script>

<script>
    /* Start change dates event */
    $("[name='due_date']").change(function() {
        const that = this;
        var last_review = $(this).val();
        var days = $(this).parent().parent().find("[name='periodical_time']").val();

        if (days != 0) {
            var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last_review;

            $.ajax({
                url: url,
                success: function(response) {
                    $(that).parent().parent().find("[name=' next_initiate_date']").val(response);
                }
            });

        } else {
            $(that).parent().parent().find("[name=' next_initiate_date']").val(last_review);

        }
    });

    $("[name='periodical_time']").change(function() {
        const that = this;
        var days = $(this).val();
        var last = $(this).parent().parent().find("[name='due_date']").val();
        var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last;

        $.ajax({
            url: url,
            success: function(response) {
                $(that).parent().parent().find("[name=' next_initiate_date']").val(response);

            }
        });
    });

    $("[name='periodical_time']").trigger('change');
    /* End change dates event */



    function makeAlert(status, message, title) {
        toastr[status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }
</script>
<script type="text/javascript">
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');


        var table = $('#dataTableREfresh').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.audit.auditer.ajaxTable') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                error: function(xhr, error, code) {
                    alert('Error: ' + xhr.responseText);
                }
            },
            language: {
                "sProcessing": "{{ __('locale.Processing') }}",
                "sSearch": "{{ __('locale.Search') }}",
                "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                "sInfo": "{{ __('locale.info') }}",
                "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                "sInfoPostFix": "",
                "sSearchPlaceholder": "",
                "sZeroRecords": "{{ __('locale.emptyTable') }}",
                "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                "oPaginate": {
                    "sFirst": "",
                    "sPrevious": "{{ __('locale.Previous') }}",
                    "sNext": "{{ __('locale.NextStep') }}",
                    "sLast": ""
                },
                "oAria": {
                    "sSortAscending": "{{ __('locale.sortAscending') }}",
                    "sSortDescending": "{{ __('locale.sortDescending') }}"
                }
            },
            columns: [{
                    data: 'auto_increment',
                    name: 'auto_increment'
                },
                {
                    data: 'audit_name',
                    name: 'audit_name'
                },
                {
                    data: 'audit_type',
                    name: 'audit_type'
                },
                {
                    data: 'audit_function',
                    name: 'audit_function'
                },
                {
                    data: 'regulator_name',
                    name: 'regulator_name'
                },
                {
                    data: 'framework_name',
                    name: 'framework_name'
                },
                {
                    data: 'owner_name',
                    name: 'owner_name'
                },
                {
                    data: 'responsible_type',
                    name: 'responsible_type',
                },
                {
                    data: 'responsible', // This column will show the correct value
                    name: 'responsible',
                    render: function(data, type, row) {
                        if (row.responsible_type === 'users') {
                            return row
                                .user_names; // Show user names if responsible_type is "users"
                        } else if (row.responsible_type === 'teams') {
                            return row
                                .team_names; // Show team names if responsible_type is "teams"
                        } else {
                            return ''; // Show nothing if no type matches
                        }
                    }
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'due_date',
                    name: 'due_date'
                },
                {
                    data: 'periodical_time',
                    name: 'periodical_time'
                },
                {
                    data: 'next_initiate_date',
                    name: 'next_initiate_date'
                },
                {
                    data: 'closed_status_percentage',
                    name: 'closed_status_percentage'
                },
                {
                    data: 'test_number_initiated',
                    name: 'test_number_initiated'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        // Filter by Regulator
        $('#regulatorsIdFilter').on('change', function() {
            var regulatorValue = $(this).val();
            table.column(2).search(regulatorValue)
                .draw(); // Adjust the column index based on your table structure
        });

        // Filter by Framework
        $('#frameworkIdFilter').on('change', function() {
            var frameworkValue = $(this).val();
            table.column(3).search(frameworkValue)
                .draw(); // Adjust the column index based on your table structure
        });

        $(document).ready(function() {
            function toggleResponsibleSelectionEdit() {
                if ($('#edit_selectUsers').is(':checked')) {
                    $('#edit_selectUsers').prop('checked', true);
                    $('#edit_selectTeams').prop('checked', false);
                    $('#edit_usersSelectContainer').removeClass('d-none');
                    $('#edit_teamsSelectContainer').addClass('d-none');

                    // Set the responsibleTypeEdit hidden input value
                    $('#responsibleTypeEdithidden').val('users');

                    // Set the responsiblePersonEdithidden hidden input value from the users select
                    var responsibleUsers = $('#edit_responsible_user').val();
                    $('#responsiblePersonEdithidden').val(responsibleUsers ? responsibleUsers.join(
                        ',') : '');
                } else if ($('#edit_selectTeams').is(':checked')) {
                    $('#edit_selectUsers').prop('checked', false);
                    $('#edit_selectTeams').prop('checked', true);
                    $('#edit_usersSelectContainer').addClass('d-none');
                    $('#edit_teamsSelectContainer').removeClass('d-none');

                    // Set the responsibleTypeEdit hidden input value
                    $('#responsibleTypeEdithidden').val('teams');

                    // Set the responsiblePersonEdithidden hidden input value from the teams select
                    var responsibleTeams = $('#edit_responsible_team').val();
                    $('#responsiblePersonEdithidden').val(responsibleTeams ? responsibleTeams.join(
                        ',') : '');
                }
            }


            // Ensure the function is called when the page loads
            toggleResponsibleSelectionEdit();

            // Event listener for radio buttons to toggle visibility and update hidden inputs
            $('input[name="responsible_type"]').on('change', function() {
                toggleResponsibleSelectionchange();
            });

            function toggleResponsibleSelectionchange() {
                // Clear previous selections and hide all containers
                $('#edit_usersSelectContainer').addClass('d-none');
                $('#edit_teamsSelectContainer').addClass('d-none');
                $('#responsibleTypeEdithidden').val('');
                $('#responsiblePersonEdithidden').val('');

                // Show relevant container based on selected radio button
                if ($('#edit_selectUsers').is(':checked')) {
                    $('#edit_usersSelectContainer').removeClass('d-none');
                    $('#responsibleTypeEdithidden').val('users');
                } else if ($('#edit_selectTeams').is(':checked')) {
                    $('#edit_teamsSelectContainer').removeClass('d-none');
                    $('#responsibleTypeEdithidden').val('teams');
                }
            }


            // Handle edit button click
            $('#dataTableREfresh').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                // Fetch existing data via AJAX
                $.ajax({
                    url: "{{ route('admin.governance.auditer.getEditData') }}",
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Populate the form fields with the fetched data
                        $('#editAuditId').val(response.id);
                        $('#edit_regulator_id').val(response.regulator_id).trigger(
                            'change');
                        $('#edit_owner_id').val(response.owner_id).trigger(
                            'change');

                        // Fetch frameworks based on regulator and preselect the current framework
                        if (response.regulator_id) {
                            $.ajax({
                                url: '{{ route('admin.audit.getFrameworksByRegulator', '') }}/' +
                                    response.regulator_id,
                                type: 'GET',
                                success: function(data) {
                                    // Clear the framework dropdown and add new options
                                    $('#edit_framework_id').html(
                                        '<option value="">{{ __('locale.Select Framework') }}</option>'
                                    );
                                    $.each(data, function(key,
                                        framework) {
                                        $('#edit_framework_id')
                                            .append(
                                                '<option value="' +
                                                framework.id +
                                                '">' + framework
                                                .name +
                                                '</option>');
                                    });
                                    // Set the existing framework as selected
                                    $('#edit_framework_id').val(response
                                        .framework_id).trigger(
                                        'change');
                                }
                            });
                        }

                        // Populate other fields as usual
                        if (response.responsible_type === 'users') {
                            $('#edit_selectUsers').prop('checked', true);
                            $('#edit_responsible_user').val(response.responsible)
                                .trigger('change');
                        } else if (response.responsible_type === 'teams') {
                            $('#edit_selectTeams').prop('checked', true);
                            $('#edit_responsible_team').val(response.responsible)
                                .trigger('change');
                        }

                        $('#edit_start_date').val(response.start_date);
                        $('#edit_due_date').val(response.due_date);
                        $('#edit_periodical_time').val(response.periodical_time);
                        $('#edit_next_review').val(response.next_initiate_date);
                        $('#edit_test_number_initiated').val(response
                            .test_number_initiated);

                        // Show the modal
                        $('#editAuditModal').modal('show');

                        // Toggle selection based on the responsible type
                        toggleResponsibleSelectionEdit();
                    },
                    error: function(response) {
                        console.error('Error fetching audit data:', response);
                        alert('An error occurred while fetching audit data.');
                    }
                });
            });



            $('#editAuditForm').on('submit', function(e) {
                e.preventDefault();

                // Manually update hidden input before submission
                toggleResponsibleSelectionEdit();

                var form = $(this);
                var formData = form.serialize();
                console.log('Form Data:', formData);

                // Send the update request via AJAX
                $.ajax({
                    url: "{{ route('admin.audit.updateAduitResponsible') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#editAuditModal').modal('hide');
                            makeAlert('success', 'Audit updated successfully',
                                'Success');
                            $('#dataTableREfresh').DataTable().ajax.reload();
                        } else {
                            makeAlert('error', response.message, 'Error');
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        var errorMessage = '';

                        // Loop through each error and add it to the errorMessage string
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });

                        // Display the error messages in a toast alert
                        makeAlert('error', errorMessage, 'Validation Error');
                    }
                });
            });


        });

        // Handle sedation button click
        $(document).on('click', '.export-audit-result-btn', function(e) {
            e.preventDefault();
            var auditId = $(this).data('audit-id');

            // Show loading indicator
            $.blockUI({
                message: '<div class="spinner-border text-primary" role="status"></div>' +
                    '<div class="mt-2">Preparing your export... (5 seconds)</div>',
                css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0',
                    width: 'auto',
                    left: '50%',
                    marginLeft: '-120px',
                    zIndex: 1100, // Ensure above the modal
                },
                overlayCSS: {
                    opacity: 0.5,
                    backgroundColor: '#000',
                    cursor: 'wait',
                    zIndex: 1099, // Ensure above modal backdrop
                },
            });

            // Set timeout to unblock after exactly 5 seconds
            var unblockTimer = setTimeout(function() {
                $.unblockUI();
            }, 5000);

            // Create and submit form immediately (but UI will block for 5 seconds)
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('admin.audit.exportAuditResult') }}";

            // Add CSRF token
            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            // Add audit ID
            var auditInput = document.createElement('input');
            auditInput.type = 'hidden';
            auditInput.name = 'audit_id';
            auditInput.value = auditId;
            form.appendChild(auditInput);

            // Submit the form
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            // Optional: Clear the unblock timer if download completes before 5 seconds
            // (This part is only needed if you want to unblock immediately when download starts)
            window.addEventListener('blur', function handler() {
                // Browser tab loses focus when download starts
                clearTimeout(unblockTimer);
                $.unblockUI();
                window.removeEventListener('blur', handler);
            });
        });


        // Handle sedation button click
        $(document).on('click', '.sedation-btn', function(e) {
            e.preventDefault();
            var frameworkId = $(this).data('framework-id');
            var testControlNumber = $(this).data('test-control-number');

            $.ajax({
                url: "{{ route('admin.audit.summaryOfResultsForEvaluationAndCompliancedetailsToSedation') }}",
                type: 'POST',
                data: {
                    framework_id: frameworkId,
                    test_number_initiated: testControlNumber,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#sedationModal').html(''); // Clear existing content
                    $('#sedationModal').html(response); // Inject the new content
                    $('#sedationModal').modal('show'); // Show the modal
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr
                        .responseText); // Log detailed error for debugging
                    alert(
                        'An error occurred while processing your request. Please try again.'
                    ); // Show a generic message to the user
                }
            });
        });
        $(document).on('click', '.details-btn', function(e) {
            e.preventDefault();
            var frameworkId = $(this).data('framework-id');
            var testControlNumber = $(this).data('test-control-number');

            $.ajax({
                url: "{{ route('admin.governance.summaryOfResultsForEvaluationAndCompliancedetailsToFramework') }}",
                type: 'POST',
                data: {
                    framework_id: frameworkId,
                    test_number_initiated: testControlNumber,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    cardsFrameworkDetails(response);
                    $('#showFrameworkDetailsModal').modal('show'); // Show the modal
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseText);
                    alert(
                        'An error occurred while processing your request. Please try again.'
                    );
                }
            });
        });


    });
    $(document).ready(function() {
        $("#toggleTableBtn").click(function() {
            $(".slide-table").slideToggle();
        });
    });

    $(document).ready(function() {
        // Function to toggle between Users and Teams
        function toggleResponsibleSelection() {
            if ($('#selectUsers').is(':checked')) {
                $('#usersSelectContainer').removeClass('d-none');
                $('#teamsSelectContainer').addClass('d-none');
            } else if ($('#selectTeams').is(':checked')) {
                $('#teamsSelectContainer').removeClass('d-none');
                $('#usersSelectContainer').addClass('d-none');
            }
        }


        // Event listeners for the radio buttons
        $('input[name="responsibleType"]').on('change', function() {
            toggleResponsibleSelection();
        });

        // Initialize the toggle state on page load
        toggleResponsibleSelection();

    });
</script>




<script>
    // Start change dates event
    $(document).ready(function() {
        // When due date changes
        $("[id='edit_due_date']").change(function() {
            const that = this;
            var last_review = $('#edit_due_date').val();
            var days = $('#edit_periodical_time').val();

            console.log("Due date changed:", last_review, "Periodical Time:", days);

            if (days != 0) {
                var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" +
                    last_review;

                $.ajax({
                    url: url,
                    success: function(response) {
                        console.log("AJAX response:", response);
                        $('#edit_next_review').val(response);
                    },
                    error: function(xhr) {
                        console.log("AJAX error:", xhr);
                    }
                });

            } else {
                $('#edit_next_review').val(last_review);
            }
        });

        // When periodical time changes
        $("[id='edit_periodical_time']").change(function() {
            const that = this;
            var days = $('#edit_periodical_time').val();
            var last = $('#edit_due_date').val();
            console.log("Periodical Time changed:", days, "Due Date:", last);

            if (last != '') {
                var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last;

                $.ajax({
                    url: url,
                    success: function(response) {
                        console.log("AJAX response:", response);
                        $('#edit_next_review').val(response);
                    },
                    error: function(xhr) {
                        console.log("AJAX error:", xhr);
                    }
                });
            }
        });

        // Trigger change on page load if necessary
        $("[id='edit_next_review']").trigger('change');
    });
    // End change dates event

    function makeAlert(status, message, title) {
        toastr[status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }
</script>

<script type="text/javascript">
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).on('click', '.showDomainDetails', function(e) {
            e.preventDefault();
            const domainId = $(this).data('id');

            var table = $('#domainDetailsTableBody').DataTable({
                processing: true,
                serverSide: true,
                destroy: true, // Allows reinitialization of DataTable
                ajax: {
                    url: "{{ route('admin.governance.domain.status') }}",
                    type: 'POST',
                    data: {
                        domain_id: domainId,
                        frame_id: frameworkId
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    error: function(xhr, error, code) {
                        alert('Error: ' + xhr.responseText);
                    }
                },
                language: {
                    "sProcessing": "{{ __('locale.Processing') }}",
                    "sSearch": "{{ __('locale.Search') }}",
                    "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                    "sInfo": "{{ __('locale.info') }}",
                    "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                    "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                    "sSearchPlaceholder": "",
                    "sZeroRecords": "{{ __('locale.emptyTable') }}",
                    "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                    "oPaginate": {
                        "sFirst": "",
                        "sPrevious": "{{ __('locale.Previous') }}",
                        "sNext": "{{ __('locale.NextStep') }}",
                        "sLast": ""
                    },
                    "oAria": {
                        "sSortAscending": "{{ __('locale.sortAscending') }}",
                        "sSortDescending": "{{ __('locale.sortDescending') }}"
                    }
                },
                columns: [{
                        data: 'control_name',
                        name: 'control_name'
                    }, // Index 0
                    {
                        data: 'sub_domain',
                        name: 'sub_domain'
                    }, // Index 1
                    {
                        data: 'status',
                        name: 'status'
                    }, // Index 2
                    {
                        data: 'total_requirements',
                        name: 'total_requirements',
                        title: '{{ __('locale.TotalRequirements') }}'
                    }, // Index 3
                    {
                        data: 'total_evidence',
                        name: 'total_evidence',
                        title: '{{ __('locale.TotalEvidence') }}'
                    } // Index 4
                ]
            });

            // Apply filters
            $('#familySelect').change(function() {
                table.column(1).search($(this).val()).draw(); // Filter by Family (Sub Domain)
            });

            $('#statusFilter').change(function() {
                table.column(2).search($(this).val()).draw(); // Filter by Status
            });

            $('#controlSelect').change(function() {
                table.column(0).search($(this).val()).draw(); // Filter by Control
            });
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).on('click', '.details-btn', function(e) {
            e.preventDefault();
            var frameworkId = $(this).data('framework-id');
            var testControlNumber = $(this).data('test-control-number');

            var table = $('#frameworkDetailsTableBody').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('admin.governance.frameworkControl.status') }}",
                    type: 'POST',
                    data: {
                        test_number: testControlNumber,
                        frame_id: frameworkId
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    error: function(xhr, error, code) {
                        alert('Error: ' + xhr.responseText);
                    }
                },
                language: {
                    "sProcessing": "{{ __('locale.Processing') }}",
                    "sSearch": "{{ __('locale.Search') }}",
                    "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                    "sInfo": "{{ __('locale.info') }}",
                    "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                    "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                    "sZeroRecords": "{{ __('locale.emptyTable') }}",
                    "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                    "oPaginate": {
                        "sPrevious": "{{ __('locale.Previous') }}",
                        "sNext": "{{ __('locale.NextStep') }}"
                    }
                },
                columns: [{
                        data: 'control_name',
                        name: 'control_name'
                    },
                    {
                        data: 'sub_domain',
                        name: 'sub_domain'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'tester',
                        name: 'tester'
                    },
                    {
                        data: 'total_requirements',
                        name: 'total_requirements',
                        title: '{{ __('locale.TotalRequirements') }}'
                    },
                    {
                        data: 'total_approved_requirements',
                        name: 'total_approved_requirements',
                        title: '{{ __('locale.TotalApprovedRequirements') }}'
                    },
                    {
                        data: 'total_evidence',
                        name: 'total_evidence',
                        title: '{{ __('locale.TotalEvidence') }}'
                    },
                    {
                        data: 'total_approved_evidence',
                        name: 'total_approved_evidence',
                        title: '{{ __('locale.TotalApprovedEvidence') }}'
                    },
                    {
                        title: '{{ __('locale.Requirement') }}',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="#" class="requirement-icon" 
                                data-framework-id="${row.frameworkId}" 
                                data-test-number="${row.testNumber}" 
                                data-control-id="${row.control_id}">
                                    <i class="fas fa-tasks"></i>
                                </a>`;
                        }
                    }

                ]
            });

            $('#frameworkFamilySelect').change(function() {
                table.column(1).search($(this).val()).draw();
            });

            $('#frameworkStatusFilter').change(function() {
                table.column(2).search($(this).val()).draw();
            });

            $('#frameworkControlSelect').change(function() {
                table.column(0).search($(this).val()).draw();
            });

            // Handle Click Event on Requirement Icon
            // Handle Click Event on Requirement Icon


        });
    });
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
                    text: "{{ __('locale.Status') }}",
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
                        text: 'Percentage (%)'
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
        $(document).on('click', '.requirement-icon', function(e) {
            e.preventDefault();

            var frameworkId = $(this).data('framework-id');
            var testNumber = $(this).data('test-number');
            var controlId = $(this).data('control-id');

            // Show modal
            $('#showRequirementDetailsModal').modal('show');

            // Show loading indicator in table body
            var tableBody = $('#requirementDetailsTable tbody');
            tableBody.html(`
                            <tr>
                                <td colspan="6" class="text-center">Loading...</td>
                            </tr>
                        `);

            // Fetch data via AJAX
            $.ajax({
                url: "{{ route('admin.governance.requirement.details') }}",
                type: "GET",
                data: {
                    framework_id: frameworkId,
                    test_number: testNumber,
                    control_id: controlId
                },
                success: function(response) {
                    tableBody.empty(); // Clear existing rows

                    if (response.details.length > 0) {
                        response.details.forEach(function(detail) {
                            tableBody.append(`
                                            <tr>
                                                <td>${detail.attach_name}</td>
                                                <td>${detail.created_by}</td>
                                                <td>
                                                    <a class="badge bg-secondary download-evidence-file cursor-pointer text-light" 
                                                    data-evidence-id="${detail.evidence_id}">
                                                    ${detail.evidence_file}
                                                    </a>
                                                </td>
                                                <td>${detail.compliance_created_at}</td>
                                                <td>${detail.compliance_updated_at}</td>
                                                <td>
                                                    ${(() => {
                                                        switch (detail.status) {
                                                            case 'no_action':
                                                                return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.no_action') }}</span>';
                                                            case 'not_relevant':
                                                                return '<span class="badge rounded-pill badge-light-secondary">{{ __('locale.not_relevant') }}</span>';
                                                            case 'rejected':
                                                                return '<span class="badge rounded-pill badge-light-warning">{{ __('locale.Partially Implemented') }}</span>';
                                                            case 'approved':
                                                                return '<span class="badge rounded-pill badge-light-success">{{ __('locale.approved') }}</span>';
                                                            default:
                                                                return '<span class="badge rounded-pill badge-light-info">{{ __('locale.No Action') }}</span>';
                                                        }
                                                    })()}
                                                </td>
                                            </tr>
                                        `);
                        });
                    } else {
                        tableBody.append(`
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No details available</td>
                                        </tr>
                                    `);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    tableBody.html(`
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">Failed to load requirement details. Please try again.</td>
                                    </tr>
                                `);
                }
            });
        });

        // Handle Evidence File Download
        // Event listener for clicking on evidence download
        $(document).on('click', '.download-evidence-file', function() {
            var evidenceId = $(this).data('evidence-id');
            viewEvidenceFile(evidenceId);
        });



        function viewEvidenceFile(evidenceId) {
            // Open the new view in a new tab to display the file
            var url = "{{ route('admin.compliance.ajax.download_evidence_file', '') }}" + "/" + evidenceId;
            window.open(url, '_blank', 'noopener,noreferrer');
        }


    });

    $(document).ready(function() {
        // Use event delegation for dynamically loaded elements
        $(document).on('click', '.frame-graph-details', function(e) {
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
                                text: 'Status Statistic',
                            },
                            xAxis: {
                                categories: labels,
                                title: {
                                    text: 'Test Name'
                                }
                            },
                            yAxis: {
                                min: 0,
                                max: 100,
                                title: {
                                    text: 'Percentage (%)'
                                },
                            },
                            tooltip: {
                                headerFormat: '<b>{point.x}</b>',
                                pointFormat: ': {point.y:.2f}%'
                            },
                            series: [{
                                    name: 'Implemented',
                                    color: '#44225c',
                                    data: implementedCounts
                                },
                                {
                                    name: 'Not Implemented',
                                    color: '#dc3545',
                                    data: notImplementedCounts
                                },
                                {
                                    name: 'Not Applicable',
                                    color: '#9e9e9e',
                                    data: notApplicableCounts
                                },
                                {
                                    name: 'Partially Implemented',
                                    color: '#ffc107',
                                    data: partiallyImplementedCounts
                                }
                            ]
                        });

                        // Show the modal
                        $('#frameworkModal').modal('show');

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

    $(document).on('click', '.details-btn', function(e) {
        e.preventDefault();
        var frameworkId = $(this).data('framework-id');
        var testControlNumber = $(this).data('test-control-number');

        $.ajax({
            url: "{{ route('admin.governance.summaryOfResultsForEvaluationAndCompliancedetailsToFramework') }}",
            type: 'POST',
            data: {
                framework_id: frameworkId,
                test_number_initiated: testControlNumber,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                cardsFrameworkDetails(response);
                $('#showFrameworkDetailsModal').modal('show'); // Show the modal
            },
            error: function(xhr) {
                console.error('An error occurred:', xhr.responseText);
                alert(
                    'An error occurred while processing your request. Please try again.'
                );
            }
        });
    });

    function cardsFrameworkDetails(response) {
        const statusContainer = $('#frameworkDetailsContent .status');
        const openClosedContainer = $('#frameworkDetailsContent .OpenClosed');
        const familySelect = $('#frameworkFamilySelect');
        const controlSelect = $('#frameworkControlSelect');

        // Clear previous content
        statusContainer.empty();
        openClosedContainer.empty();
        familySelect.empty();
        controlSelect.empty();

        // Populate Family Select
        familySelect.append('<option value="">{{ __('locale.select-option') }}</option>');
        response.familyNames.forEach(family => {
            familySelect.append(`<option value="${family}">${family}</option>`);
        });

        // Populate Control Select
        controlSelect.append('<option value="">{{ __('locale.select-option') }}</option>');
        Object.keys(response.controls).forEach(controlId => {
            const controlName = response.controls[controlId];
            controlSelect.append(`<option value="${controlId}">${controlId}</option>`);
        });

        // Create Status Cards
        response.countsByTestNumber.forEach(status => {
            const icon = status.status_name === 'Implemented' ? 'check-circle' :
                status.status_name === 'Not Implemented' ? 'x-circle' :
                status.status_name === 'Not Applicable' ? 'archive' :
                status.status_name === 'Partially Implemented' ? 'minus-circle' : 'eye';
            const color = status.status_name === 'Implemented' ? 'green' :
                status.status_name === 'Not Implemented' ? 'red' :
                status.status_name === 'Not Applicable' ? 'gray' :
                status.status_name === 'Partially Implemented' ? 'orange' : 'black';

            const statusCard =
                `<div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1" style="background-image:url('{{ asset('images/widget-bg.png') }}')">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:${color}" data-feather="${icon}"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:${color}">${status.count}</h4><span class="f-light" style="color:${color}"> ${status.status_name}</span>
                            </div>
                        </div>
                        <div class="font-secondary f-w-600"><i class="icon-arrow-up icon-rotate me-1"></i><span style="color:${color}">+(${status.percentage}%)</span></div>
                    </div>
                </div>
            </div>`;
            statusContainer.append(statusCard);
        });

        // Enhanced Overview Cards in the Same Row
        const overviewCards =
            `<div class="row">
    <!-- Open and Closed Controls Card -->
    <div class="col-4 mb-4">
        <div class="card border-light rounded shadow">
            <div class="card-header">
                <h5 class="mb-0">{{ __('locale.OpenClosedControls') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="bg-light-primary rounded p-3">
                            <h6>{{ __('locale.OpenControls') }}</h6>
                            <p>{{ __('locale.Count') }}: ${response.open_control_count} (${response.percentage_open_controls}%)</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light-success rounded p-3">
                            <h6>{{ __('locale.ClosedControls') }}</h6>
                            <p>{{ __('locale.Count') }}: ${response.closed_control_count} (${response.percentage_close_controls}%)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Requirements Overview Card -->
    <div class="col-4 mb-4">
        <div class="card border-light rounded shadow">
            <div class="card-header">
                <h5 class="mb-0">{{ __('locale.RequirementsOverview') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="bg-light-primary rounded p-3">
                            <h6>{{ __('locale.TotalRequirements') }}</h6>
                            <p>${response.total_requirements}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light-success rounded p-3">
                            <h6>{{ __('locale.ApprovedRequirements') }}</h6>
                            <p>${response.approved_requirements}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light-danger rounded p-3">
                            <h6>{{ __('locale.RejectedRequirements') }}</h6>
                            <p>${response.rejected_requirements}</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-4">
                        <div class="bg-light-warning rounded p-3">
                            <h6>{{ __('locale.NoActionRequirements') }}</h6>
                            <p>${response.no_action_requirements}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Evidences Overview Card -->
    <div class="col-4 mb-4">
        <div class="card border-light rounded shadow">
            <div class="card-header">
                <h5 class="mb-0">{{ __('locale.EvidencesOverview') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="bg-light-primary rounded p-3">
                            <h6>{{ __('locale.TotalEvidence') }}</h6>
                            <p>${response.total_evidences}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light-success rounded p-3">
                            <h6>{{ __('locale.ApprovedEvidence') }}</h6>
                            <p>${response.approved_evidences}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light-danger rounded p-3">
                            <h6>{{ __('locale.RejectedEvidence') }}</h6>
                            <p>${response.rejected_evidences}</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-4">
                        <div class="bg-light-warning rounded p-3">
                            <h6>{{ __('locale.NotRelevantEvidence') }}</h6>
                            <p>${response.not_relevant_evidences}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light-secondary rounded p-3">
                            <h6>{{ __('locale.NoActionEvidence') }}</h6>
                            <p>${response.not_action_evidences}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;

        openClosedContainer.append(overviewCards);

        // Re-initialize Feather icons
        feather.replace();
    }
</script>

<script>
    // Initialize Feather Icons
    feather.replace();
</script>

@endsection
