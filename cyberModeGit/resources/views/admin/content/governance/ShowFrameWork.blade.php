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
    <link rel="stylesheet" href="{{ asset('cdn/font-awesome-all.min.css') }}">

    
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
    <link rel="stylesheet" href="{{ asset('cdn/font-awesome-all.min.css') }}">

    
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


        /*start edit select modal  */
        .modal {
            overflow-y: auto !important;
        }

        .select2-container {
            z-index: 1055 !important;
        }

        .modal-body {
             overflow-y: auto;
        }

        /*end  edit select modal  */
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
                                @if (auth()->user()->hasPermission('audit.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-regulator">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.governance.notificationsSettingsAduitSchedule') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                <!-- <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a> -->

                                <x-export-import name=" {{ __('locale.Framework') }}"
                                    createPermissionKey='framework.create' exportPermissionKey='framework.export'
                                    exportRouteKey='admin.governance.framework.ajax.export'
                                    importRouteKey='will-added-TODO' />


                                <a class="btn btn-primary"
                                    href="{{ route('admin.governance.framework.ajax.graphViewFramework', ['id' => $framework->id]) }}">
                                    <i class="fa-solid fa-file-invoice"></i>
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




<div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- Compliance Audit Card -->
            <!-- Status card takes 5 columns -->





            <div class="col-md-4 align-self-center">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header card-no-border pb-0">
                                <div class="header-top">
                                    <h3>{{ __('locale.ComplianceAudit') }}</h3> <!-- Translated 'Compliance Audit' -->
                                    <div class="dropdown icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="icon-more-alt"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                                            <a class="dropdown-item" href="#">{{ __('locale.Weekly') }}</a>
                                            <!-- Translated 'Weekly' -->
                                            <a class="dropdown-item" href="#">{{ __('locale.Monthly') }}</a>
                                            <!-- Translated 'Monthly' -->
                                            <a class="dropdown-item" href="#">{{ __('locale.Yearly') }}</a>
                                            <!-- Translated 'Yearly' -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-lg-3">
                                <ul class="user-list">
                                    <li>
                                        <div class="user-icon success">
                                            <div class="user-box"><i class="font-success"
                                                    data-feather="check-circle"></i></div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ __('locale.Current') }}
                                                <!-- Translated 'Current' -->
                                                <span
                                                    class="{{ $currentAuditData['percentage'] > $previousAuditData['percentage'] ? 'text-primary' : 'text-danger' }} d-flex align-items-center"
                                                    style="font-size: 1.5rem;">
                                                    @if ($currentAuditData['percentage'] > $previousAuditData['percentage'])
                                                        <i data-feather="arrow-up" class="icon-rotate me-1"></i>
                                                    @elseif ($currentAuditData['percentage'] < $previousAuditData['percentage'])
                                                        <i data-feather="arrow-down" class="icon-rotate me-1"></i>
                                                    @else
                                                        <i data-feather="arrow-right" class="icon-rotate me-1"></i>
                                                    @endif
                                                </span>
                                            </h5>
                                            <span class="font-primary d-flex align-items-center">
                                                <i class="icon-arrow-up icon-rotate me-1"></i>
                                                <span class="f-w-600">{{ $currentAuditData['percentage'] }} %</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="user-icon success">
                                            <div class="user-box"><i class="font-success"
                                                    data-feather="settings"></i></div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ __('locale.Previous') }}
                                                <!-- Translated 'Previous' -->
                                                <span
                                                    class="{{ $previousAuditData['percentage'] > $currentAuditData['percentage'] ? 'text-primary' : 'text-danger' }} d-flex align-items-center"
                                                    style="font-size: 1.5rem;">
                                                    @if ($previousAuditData['percentage'] > $currentAuditData['percentage'])
                                                        <i data-feather="arrow-up" class="icon-rotate me-1"></i>
                                                    @elseif ($previousAuditData['percentage'] < $currentAuditData['percentage'])
                                                        <i data-feather="arrow-down" class="icon-rotate me-1"></i>
                                                    @else
                                                        <i data-feather="arrow-right" class="icon-rotate me-1"></i>
                                                    @endif
                                                </span>
                                            </h5>
                                            <span class="font-danger d-flex align-items-center">
                                                <i class="icon-arrow-down icon-rotate me-1"></i>
                                                <span class="f-w-600">{{ $previousAuditData['percentage'] }} %</span>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-8">
                <div class="card p-4 mb-4 border-light rounded shadow">
                    <div class="card-body">
                        <h3 class="mb-2" style="font-size: 24px; color: #444;">{{ $framework->name }}</h3>
                        <p class="text-start" style="color: #666;">{{ $framework->description }}</p>
                        @if (auth()->user()->hasPermission('framework.create'))
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editFrameworkModal"
                                onclick="populateEditForm('{{ $framework->id }}')">
                                {{ __('locale.Edit') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- Edit Framework Modal -->
<div class="modal fade bd-example-modal-lg" id="editFrameworkModal" tabindex="-1" role="dialog"
    aria-labelledby="editFrameworkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editFrameworkModalLabel">{{ __('locale.EditFramework') }}</h4>
                <!-- Translated 'Edit Framework' -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.governance.framework.update', 'id') }}" method="POST"
                    id="editFrameworkForm">
                    @csrf
                    <!-- Hidden Input for Framework ID -->
                    <input type="hidden" name="id" id="edit-framework-id">

                    <!-- Framework Name -->
                    <div class="mb-3">
                        <label for="edit-framework-name" class="form-label">{{ __('locale.FrameworkName') }}</label>
                        <!-- Translated 'Framework Name' -->
                        <input type="text" class="form-control" id="edit-framework-name" name="name" required>
                    </div>

                    <!-- Families Selection -->
                    <div class="mb-3">
                        <label for="edit-framework-families"
                            class="form-label">{{ __('locale.ControlDomain') }}</label>
                        <!-- Translated 'Control Domain' -->
                        <select class="select2 form-select framework_domain_select" id="edit-framework-families"
                            data-prev="[]" multiple name="family[]" required>
                            <!-- Families will be populated dynamically -->
                        </select>
                    </div>

                    <!-- Sub-families Selection -->
                    <div class="mb-3">
                        <label for="edit-framework-subfamilies"
                            class="form-label">{{ __('locale.ControlSubDomain') }}</label>
                        <!-- Translated 'Control Sub Domain' -->
                        <select class="select2 form-select framework_subdomain_select" id="edit-framework-subfamilies"
                            multiple name="sub_family[]" required>
                            <!-- Sub-families will be populated dynamically -->
                        </select>
                    </div>

                    <!-- Framework Description -->
                    <div class="mb-3">
                        <label for="edit-framework-description"
                            class="form-label">{{ __('locale.Description') }}</label>
                        <!-- Translated 'Description' -->
                        <textarea class="form-control" id="edit-framework-description" name="description" rows="3" required></textarea>
                    </div>
                    @php
                        // Fetch the required data
                        $controlIds = DB::table('framework_control_mappings')
                            ->where('framework_id', $framework->id)
                            ->value('framework_control_id');

                        // Fetch the control owner
                        $controlOwner = DB::table('framework_controls')
                            ->where('id', $controlIds)
                            ->value('control_owner');

                        // Prepare values for the Blade view
                        $selectedOwner = $controlOwner; // Assuming $controlOwner is the ID of the selected owner
                    @endphp

                    <div class="mb-1">
                        <label class="form-label" for="owner">{{ __('locale.ControlOwner') }}</label>
                        <!-- Translated 'Control Owner' -->
                        <select class="select2 form-select" id="task-assigned" name="owner">
                            <option value="">{{ __('locale.selectOwner') }}</option>
                            <!-- Translated 'Select Owner' -->
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}" @if (!$owner->enabled) disabled @endif
                                    @if ($owner->id == $selectedOwner) selected @endif>
                                    {{ $owner->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button> <!-- Translated 'Close' -->
                        <button type="submit" class="btn btn-primary">{{ __('locale.SaveChanges') }}</button>
                        <!-- Translated 'Save Changes' -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


















<div class="row">
    <div class="col-12">
        <div class="row">
            @foreach ($response['domains'] as $index => $family)
                @php
                    $total = $family['total'];
                    $implemented = $family['Implemented'];
                    $implementedPercentage = $total > 0 ? number_format(($implemented / $total) * 100, 2) : '0.00';
                    $color = '';
                    if ($implementedPercentage < 50) {
                        $color = '#ffa1a1';
                    } elseif ($implementedPercentage >= 50 && $implementedPercentage <= 80) {
                        $color = '#ffe700';
                    } else {
                        $color = '#00d4bd';
                    }
                @endphp
                <div class="col-xxl-3 col-xl-4 col-md-6 box-col-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card course-box widget-course">
                                <div class="card-body">
                                    <div class="course-widget">
                                        <div class="chart-progress me-3" data-color="{{ $color }}"
                                            data-series="{{ $implementedPercentage }}" data-progress_variant="true">
                                        </div>
                                        <div>
                                            <h5 class="mb-0" style="font-weight: 700">{{ $family['name'] }}</h5>
                                            <a class="btn btn-light f-light showDomainDetails"
                                                style="display: inline-flex;" data-bs-toggle="modal"
                                                data-id="{{ $family['id'] }}" data-frame="{{ $framework->id }}"
                                                data-index="{{ $index }}"
                                                data-bs-target="#showDomainDetailsModal">
                                                View Details
                                                <span class="ms-2"><i class="fa-solid fa-right-long"></i></span>
                                            </a>
                                        </div>
                                        <ul class="square-group">
                                            <li class="square-1 warning"></li>
                                            <li class="square-1 primary"></li>
                                            <li class="square-2 warning1"></li>
                                            <li class="square-3 danger"></li>
                                            <li class="square-4 light"></li>
                                            <li class="square-5 warning"></li>
                                            <li class="square-6 success"></li>
                                            <li class="square-7 success"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal Definition -->
        <div class="modal fade" id="showDomainDetailsModal" tabindex="-1" role="dialog"
            aria-labelledby="domainDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content rounded-3 shadow-lg">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="domainDetailsModalLabel">Domain Details</h5>
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
                                <h5>Select Options and Domain Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mt-4">
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="familySelect" class="form-label">Select Family</label>
                                            <select id="familySelect" class="form-select">
                                                <option value="">Select a family</option>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="controlSelect" class="form-label">Select Control</label>
                                            <select id="controlSelect" class="form-select">
                                                <option value="">Select a control</option>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="statusFilter" class="form-label">Status Filter</label>
                                            <select id="statusFilter" name="status" class="form-select">
                                                <option value="" selected>Select an option</option>
                                                <option value="Implemented">Implemented</option>
                                                <option value="Not Implemented">Not Implemented</option>
                                                <option value="Not Applicable">Not Applicable</option>
                                                <option value="Partially Implemented">Partially Implemented</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h5 class="mt-4">Domain Details Table</h5>
                                    <table class="dt-advanced-server-search table" id="domainDetailsTableBody">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Control</th>
                                                <th>Sub Domain</th>
                                                <th>Status</th>
                                                <th>Total Requirements</th>
                                                <th>Total Evidence</th>
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
                                <label for="regulator_id" class="form-label">{{ __('locale.Regulator') }}</label>
                                <select class="form-control" name="regulator_id" id="regulator_id" disabled>
                                    @foreach ($allregulators as $name => $id)
                                        <option value="{{ $id }}"
                                            {{ $id == $regulatorFramework ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="regulator_id" value="{{ $regulatorFramework }}">
                            </div>

                            <div class="mb-3">
                                <label for="framework_id" class="form-label">{{ __('locale.Framework') }}</label>
                                <select class="form-control" name="framework_id" id="framework_id" disabled>
                                    @foreach ($frameworksname as $name => $id)
                                        <option value="{{ $id }}"
                                            {{ $id == $framework->id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="framework_id" id="frameWorkId"
                                    value="{{ $framework->id }}">
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
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.SelectResponsible') }}</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="responsibleType"
                                            id="selectUsers" value="users" checked>
                                        <label class="form-check-label" for="selectUsers">
                                            {{ __('locale.Users') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="responsibleType"
                                            id="selectTeams" value="teams">
                                        <label class="form-check-label" for="selectTeams">
                                            {{ __('locale.Teams') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Multi-Select Users (Visible by default) -->
                            <div class="mb-3" id="usersSelectContainer">
                                <label class="form-label">{{ __('locale.Responsible') }}</label>
                                <select class="select2 form-select" name="responsible[]" multiple="multiple">
                                    <option value="" disabled>{{ __('locale.select-option') }}</option>
                                    @foreach ($enabledUsers as $owner)
                                        <option value="{{ $owner->id }}"
                                            data-manager="{{ json_encode($owner->manager) }}">
                                            {{ $owner->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Multi-Select Teams (Hidden by default) -->
                            <div class="mb-3 d-none" id="teamsSelectContainer">
                                <label class="form-label">{{ __('locale.Team') }}</label>
                                <select name="responsible[]" class="form-select select2" multiple="multiple">
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-0">
                                <label class="form-label" for="fp-default">{{ __('locale.StartDate') }}</label>
                                <input name="start_date" class="form-control flatpickr-date-time-compliance"
                                    placeholder="YYYY-MM-DD" />
                                <span class="error error-start_date"></span>
                            </div>
                            <div class="mb-0">
                                <label class="form-label" for="fp-default">{{ __('locale.Duedate') }}</label>
                                <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                    placeholder="YYYY-MM-DD" />
                                <span class="error error-due_date "></span>
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

                            <input type="hidden" value="{{ $testNumberIntiated }}" name="test_number_initiated">
                            <button type="submit" class="btn btn-primary mt-3">Start Audit</button>
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
                                <label for="edit_regulator_id"
                                    class="form-label">{{ __('locale.Regulator') }}</label>
                                <select class="form-control" name="regulator_id" id="edit_regulator_id" disabled>
                                    @foreach ($allregulators as $name => $id)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Framework Field -->
                            <div class="mb-3">
                                <label for="edit_framework_id"
                                    class="form-label">{{ __('locale.Framework') }}</label>
                                <select class="form-control" name="framework_id" id="edit_framework_id" disabled>
                                    @foreach ($frameworksname as $name => $id)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
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
                                <label class="form-label">{{ __('locale.SelectResponsible') }}</label>
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
                                <label class="form-label">{{ __('locale.Responsible') }}</label>
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
                                <span class="error error-start_date"></span>
                            </div>
                            <!-- Due Date Field -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('locale.Duedate') }}</label>
                                <input name="due_date" id="edit_due_date"
                                    class="form-control flatpickr-date-time-compliance" placeholder="YYYY-MM-DD">
                                <span class="error error-due_date"></span>
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





        <div class="card p-3 pt-4 mt-3">
            <div class="buttons-actions" style="display: flex">

                <a class="btn btn-primary f-primary" id="toggleTableBtn">Audit History <span
                        class="ms-2"></span></a>
                {{-- @if (auth()->user()->hasPermission('audits.create'))
                    <input type="hidden" name="audits_framework_id" value="{{ $framework->id }}">
                    <button type="button" class="btn btn-primary f-primary" id="startNewAuditBtn"
                        style="margin: 0 20px;">
                        Start New Audit
                    </button>
                @endif --}}
            </div>
            <hr>
            <div class="fluid-container slide-table">
                <h1>{{ __('locale.Audits') }}</h1>
                <table id="dataTableREfresh" class="dt-advanced-server-search table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.ID') }}</th>
                            <th>{{ __('locale.Regulator') }}</th>
                            <th>{{ __('locale.Framework') }}</th>
                            <th>{{ __('locale.Auditor') }}</th>
                            <th>{{ __('locale.TypeOfResponsible') }}</th>
                            <th>{{ __('locale.Assistant') }}</th>
                            <th>{{ __('locale.StartDate') }}</th>
                            <th>{{ __('locale.DueDate') }}</th>
                            <th>{{ __('locale.PeriodicalTime') }}</th>
                            <th>{{ __('locale.NextInitiateDate') }}</th>
                            <th>{{ __('locale.ClosedPercentage') }}</th>
                            <th>{{ __('locale.AuditNumberInitiated') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Sedation Modal -->
<!-- Sedation Modal -->
{{-- <div id="sedationModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
    aria-labelledby="sedationModalLabel">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sedationModalLabel">{{ __('locale.EditAudit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal content goes here -->
                <p>Content related to sedation goes here...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Add any additional buttons here -->
            </div>
        </div>
    </div>
</div> --}}
<div id="sedationModal" class="modal fade modal-fullscreen" tabindex="-1" role="dialog">
    <!-- Modal content will be dynamically loaded here -->
</div>

<!-- Modal for showing unclosed controls -->
<div class="modal fade" id="controlsModalNotClosed" tabindex="-1" aria-labelledby="controlsModalNotClosedLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-custom-size" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="controlsModalNotClosedLabel">{{ __('locale.UnclosedControls') }}</h5>
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
                <h5 class="modal-title" id="frameworkDetailsModalLabel">{{ __('locale.FrameworkDetails') }}</h5>
                <!-- Updated title -->
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
                        <h5>{{ __('locale.SelectOptionsAndFrameworkDetails') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label for="frameworkFamilySelect"
                                        class="form-label">{{ __('locale.SelectFamily') }}</label>
                                    <select id="frameworkFamilySelect" class="form-select">
                                        <option value="">{{ __('locale.SelectFamilyOption') }}</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="frameworkControlSelect"
                                        class="form-label">{{ __('locale.SelectControl') }}</label>
                                    <select id="frameworkControlSelect" class="form-select">
                                        <option value="">{{ __('locale.SelectControlOption') }}</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="frameworkStatusFilter">{{ __('locale.StatusFilter') }}:</label><br>
                                    <select id="frameworkStatusFilter" name="status" class="form-select">
                                        <option value="" selected>{{ __('locale.SelectOption') }}</option>
                                        <option value="Implemented">{{ __('locale.Implemented') }}</option>
                                        <option value="Not Implemented">{{ __('locale.NotImplemented') }}</option>
                                        <option value="Not Applicable">{{ __('locale.NotApplicable') }}</option>
                                        <option value="Partially Implemented">{{ __('locale.PartiallyImplemented') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>{{ __('locale.FrameworkDetailsTable') }}</h5>
                            </div>
                            <div class="card-body">
                                <table class="dt-advanced-server-search table" id="frameworkDetailsTableBody">
                                    <thead>
                                        <tr>
                                            <th>{{ __('locale.Control') }}</th>
                                            <th>{{ __('locale.SubDomain') }}</th>
                                            <th>{{ __('locale.Status') }}</th>
                                            <th>{{ __('locale.Tester') }}</th>
                                            <th>{{ __('locale.TotalRequirements') }}</th>
                                            <th>{{ __('locale.TotalApprovedRequirements') }}</th>
                                            <th>{{ __('locale.TotalEvidence') }}</th>
                                            <th>{{ __('locale.TotalApprovedEvidence') }}</th>
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






<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('regulator.create'))  --}}
<x-regulator-form id="add-new-regulator" title="{{ __('locale.AddANewRegulator') }}" />
{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-regulator-form id="edit-regulator" title="{{ __('locale.EditRegulator') }}" />
{{--  @endif   --}}
<!--/ Update Form -->








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
<script src="{{ asset('cdn/apexcharts') }}"></script>
<script src="{{ asset('cdn/npm-chart.js') }}"></script>
<script src="{{ asset('cdn/feather.min.js') }}"></script>
<script src="{{ asset('cdn/1.11.2-jquery-ui.min.js') }}"></script>
<script>
    const verifiedTranslation = "{{ __('locale.Verified') }}",
        UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}",
        customDay = "{{ trans_choice('locale.custom_days', 1) }}",
        customDays = "{{ trans_choice('locale.custom_days', 3) }}",
        {{--  assetInQuery = "{{ $assetInQuery }}";  --}}

    var permission = [],
        lang = [],
        URLs = [];
    permission['edit'] = {{ auth()->user()->hasPermission('asset.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('asset.delete') ? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.asset')]) }}";

    URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.index') }}";
</script>

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

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
        $('#startNewAuditBtn').on('click', function() {
            var frameworkId = $('input[name="audits_framework_id"]').val();

            $.ajax({
                url: '{{ route('admin.governance.fetch.controls.closed', '') }}/' +
                    frameworkId,
                method: 'GET',
                success: function(response) {
                    var notClosedCount = response.notClosedCount;
                    var allMappedControlsExist = response.allMappedControlsExist;
                    var controlsNotClosed = response.controlsNotClosed;

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
                                // Proceed to check mapped controls existence if user chooses to continue
                                if (!allMappedControlsExist) {
                                    // SweetAlert for incomplete mapped controls
                                    Swal.fire({
                                        title: 'Incomplete Mapped Controls',
                                        text: 'Some controls are mapped but not all are accounted for in the Audit. Would you like to complete them or cancel?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Complete',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Open the modal if the user chooses to complete
                                            $('#startNewAuditModal').modal(
                                                'show');
                                        } else if (result.isDismissed) {
                                            // Cancel initiation if the user cancels
                                            Swal.fire(
                                                'Initiation Cancelled',
                                                '', 'info');
                                        }
                                    });
                                } else {
                                    // Open the modal directly if all mapped controls exist
                                    $('#startNewAuditModal').modal('show');
                                }
                            } else if (result.dismiss === Swal.DismissReason
                                .cancel) {
                                // Cancel initiation if the user clicks 'Cancel Initiation'
                                Swal.fire('Initiation Cancelled', '', 'info');
                            } else if (result.dismiss === Swal.DismissReason.deny) {
                                // Show controls if the user clicks 'Show Controls'
                                var controlsTableBody = $('#controlsTable tbody');
                                controlsTableBody.empty(); // Clear existing rows

                                // Loop through controls and append rows
                                controlsNotClosed.forEach(function(control, index) {
                                    controlsTableBody.append(
                                        '<tr><td>' + (index + 1) +
                                        '</td><td>' + control
                                        .name + '</td></tr>'
                                    );
                                });

                                // Show the controls modal
                                $('#controlsModalNotClosed').modal('show');
                            }
                        });
                    } else {
                        // Check mapped controls existence directly if no unclosed controls
                        if (!allMappedControlsExist) {
                            // SweetAlert for incomplete mapped controls
                            Swal.fire({
                                title: 'Incomplete Mapped Controls',
                                text: 'Some controls are mapped but not all are accounted for in the Audit. Would you like to complete them or cancel?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Complete',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Open the modal if the user chooses to complete
                                    $('#startNewAuditModal').modal('show');
                                } else if (result.isDismissed) {
                                    // Cancel initiation if the user cancels
                                    Swal.fire('Initiation Cancelled', '', 'info');
                                }
                            });
                        } else {
                            // Open the modal directly if no unclosed controls and all mapped controls exist
                            $('#startNewAuditModal').modal('show');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching controls:', error);
                }
            });
        });
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
                    initiateAudit(groupTestIdsString);
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

    function initiateAudit(id) {
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
        CreateAuditTest(id).then(() => {
            // Function completed successfully
            Swal.fire({
                icon: "success",
                title: "{{ __('locale.InitiateAudit') }}",
                text: "{{ __('locale.InitiateAuditSuccessfully') }}",
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
                text: "{{ __('locale.There was an error initiating the audit') }}",
            });
        }).finally(() => {
            // Hide loading overlay after function completes (whether success or failure)
            $.unblockUI();
            // location.reload();
        });
    }


    function CreateAuditSellectAll() {
        var groupTestIds = $('input[name="audits[]"]:checked');
        if (groupTestIds.length <= 0) {
            makeAlert('error', "{{ __('locale.PleaseSelectOneTestAtLeast') }}", ' Error!');
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

    function CreateAuditTest(id) {
        return new Promise((resolve, reject) => {
            let url = "{{ route('admin.governance.audit.store') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
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

    function DeleteAsset(id) {
        let url = "{{ route('admin.asset_management.ajax.destroy', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    redrawDatatable();
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

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

    // Show delete alert modal
    function ShowModalDeleteAsset(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
            text: '@lang('locale.YouWontBeAbleToRevertThis')',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                DeleteAsset(id);
            }
        });
    }

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
        var frameworkId =
            {{ $framework->id }}; // Assuming you have $framework->id available in your Blade view

        var table = $('#dataTableREfresh').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.governance.auditer.data') }}",
                type: 'POST',
                data: {
                    framework_id: frameworkId
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
                        $('#edit_framework_id').val(response.framework_id).trigger(
                            'change');
                        $('#edit_owner_id').val(response.owner_id).trigger(
                            'change');

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
            openClosedContainer.empty(); // Clear the OpenClosed container
            familySelect.empty();
            controlSelect.empty();

            // Populate Family Select
            familySelect.append('<option value="">{{ __('locale.select_family') }}</option>');
            response.familyNames.forEach(family => {
                familySelect.append(`<option value="${family}">${family}</option>`);
            });

            // Populate Control Select
            controlSelect.append('<option value="">{{ __('locale.Control') }}</option>');
            Object.keys(response.controls).forEach(controlId => {
                const controlName = response.controls[controlId];
                controlSelect.append(
                    `<option value="${controlId}">${controlId}</option>`
                ); // Updated to use controlName
            });

            // Existing code for creating status cards...
            response.countsByTestNumber.forEach(status => {
                const icon = status.status_name === 'Implemented' ? 'check-circle' :
                    status.status_name === 'Not Implemented' ? 'x-circle' :
                    status.status_name === 'Not Applicable' ? 'archive' :
                    status.status_name === 'Partially Implemented' ? 'minus-circle' :
                    'eye'; // Default icon for Partially Implemented
                const color = status.status_name === 'Implemented' ? 'green' :
                    status.status_name === 'Not Implemented' ? 'red' :
                    status.status_name === 'Not Applicable' ? 'gray' :
                    status.status_name === 'Partially Implemented' ? 'orange' :
                    'black';

                const statusCard =
                    `

               <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1" style="background-image:url('{{ asset('images/widget-bg.png') }}')" >
                  <div class="card-body">
                    <div class="widget-content">
                      <div class="widget-round secondary">
                        <div class="bg-round">

                          <i style="font-size:20px ; color:${color}" data-feather="${icon}"></i>
                        </div>
                      </div>
                      <div>
                        <h4 style="color:${color}">${status.count}</h4><span class="f-light" style="color:${color}"> ${status.status_name}</span>
                      </div>
                    </div>
                    <div class="font-secondary f-w-600"> <i class="icon-arrow-up icon-rotate me-1"></i><span style="color:${color}">+(${status.percentage}%)</span></div>
                  </div>
                </div>
              </div>




        `;
                statusContainer.append(statusCard);
            });

            // Requirement and evidence cards
            const openClosedCard =
                `<div class="col-xxl-3 col-sm-4">
            <div class="card p-4 mb-4 border-light rounded shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="badge bg-light-primary badge-rounded font-primary me-2">
                            <i class="font-primary me-2" data-feather="lock"></i>
                        </div>
                        <h3 class="mb-0">{{ __('locale.Open & Closed Controls') }}</h3>
                    </div>

                    <p>{{ __('locale.OpenControlCount') }}: ${response.open_control_count} (${response.percentage_open_controls}%)</p>
                    <p>{{ __('locale.ClosedControlCount') }}: ${response.closed_control_count} (${response.percentage_close_controls}%) </p>
                 </div>
            </div>
        </div>`;

            // Append the open and closed card to the openClosedContainer
            openClosedContainer.append(openClosedCard);

            // Re-initialize Feather icons
            feather.replace();
        }


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
    $(document).ready(function() {
        console.log('dsds');

        init();

        function init() {
            $(".droppable-area1, .droppable-area2").sortable({
                connectWith: ".connected-sortable",
                stack: '.connected-sortable ul'
            }).disableSelection();
        }
        console.log('dsds');
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



<script>
    let filteredDomainDetailsChart = null;

    function cardsDetails(response) {
        const statusContainer = $('#domainDetailsContent .status');
        const evidenceRecDocContainer = $('#domainDetailsContent .EvidenceRecDoc');
        const openClosedContainer = $('#domainDetailsContent .OpenClosed');
        const familySelect = $('#familySelect');
        const controlSelect = $('#controlSelect');

        // Clear previous content
        statusContainer.empty();
        evidenceRecDocContainer.empty();
        openClosedContainer.empty();
        familySelect.empty();
        controlSelect.empty();

        // Populate Family Select
        familySelect.append('<option value="">Select a family</option>');
        response.familyNames.forEach(family => {
            familySelect.append(`<option value="${family}">${family}</option>`);
        });

        // Populate Control Select
        controlSelect.append('<option value="">Select a control</option>');
        Object.keys(response.controls).forEach(controlId => {
            const controlName = response.controls[controlId];
            controlSelect.append(`<option value="${controlId}">${controlId}</option>`);
        });

        // Existing code for creating status cards...
        response.countsByTestNumber.forEach(status => {
            const icon = status.status_name === 'Implemented' ? 'check-circle' :
                status.status_name === 'Not Implemented' ? 'x-circle' :
                status.status_name === 'Not Applicable' ? 'archive' :
                status.status_name === 'Partially Implemented' ? 'minus-circle' :
                'eye'; // Default icon for Partially Implemented
            const color = status.status_name === 'Implemented' ? 'green' :
                status.status_name === 'Not Implemented' ? 'red' :
                status.status_name === 'Not Applicable' ? 'gray' :
                status.status_name === 'Partially Implemented' ? 'orange' :
                'black';

            const statusCard =
                `

               <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1" style="background-image:url('{{ asset('images/widget-bg.png') }}')" >
                  <div class="card-body">
                    <div class="widget-content">
                      <div class="widget-round secondary">
                        <div class="bg-round">

                          <i style="font-size:20px ; color:${color}" data-feather="${icon}"></i>
                        </div>
                      </div>
                      <div>
                        <h4 style="color:${color}">${status.count}</h4><span class="f-light" style="color:${color}"> ${status.status_name}</span>
                      </div>
                    </div>
                    <div class="font-secondary f-w-600"> <i class="icon-arrow-up icon-rotate me-1"></i><span style="color:${color}">+(${status.percentage}%)</span></div>
                  </div>
                </div>
              </div>




        `;
            statusContainer.append(statusCard);
        });

        // Existing code for creating requirement and evidence cards...
        const reqEvidenceDocOpenClosedRow =
            `<div class="row mb-3">
        <div class="col-xxl-3 col-sm-4">
            <div class="card p-4 mb-4 border-light rounded shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="badge bg-light-primary badge-rounded font-primary me-2">
                            <i class="font-primary me-2" data-feather="clipboard"></i>
                        </div>
                        <h3 class="mb-0">Requirements</h3>
                    </div>
                    <p>Total Requirements: ${response.total_requirements}</p>
                    <p>Controls with Requirements: ${response.controls_with_requirements}</p>
                    <p>Controls without Requirements: ${response.controls_without_requirements}</p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4">
            <div class="card p-4 mb-4 border-light rounded shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="badge bg-light-primary badge-rounded font-primary me-2">
                            <i class="font-primary me-2" data-feather="file-text"></i>
                        </div>
                        <h3 class="mb-0">Evidence</h3>
                    </div>
                    <p>Total Evidence: ${response.total_evidences}</p>
                    <p>Controls with Evidence: ${response.controls_with_evidence}</p>
                    <p>Controls without Evidence: ${response.controls_without_evidence}</p>
                </div>
            </div>
        </div>`;
        evidenceRecDocContainer.append(reqEvidenceDocOpenClosedRow);

        // Re-initialize Feather icons
        feather.replace();
    }


    // Event listener for the showDomainDetails button
    $(document).on('click', '.showDomainDetails', function(e) {
        e.preventDefault();
        const domainId = $(this).data('id');
        const frameworkId = $(this).data('frame');

        // AJAX request to fetch domain details
        $.ajax({
            url: '{{ route('admin.governance.getDomainReqAndEveDetails') }}',
            type: 'GET',
            data: {
                domain_id: domainId,
                framework_id: frameworkId
            },
            success: function(response) {
                cardsDetails(response);
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    });
</script>


<script type="text/javascript">
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).on('click', '.showDomainDetails', function(e) {
            e.preventDefault();
            const domainId = $(this).data('id');
            var frameworkId = {{ $framework->id }};

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
                        name: 'status',
                        render: function(data, type, row) {
                            // Map status to locale translations
                            if (data === 'Implemented') {
                                return "{{ __('locale.Implemented') }}";
                            } else if (data === 'Not Implemented') {
                                return "{{ __('locale.NotImplemented') }}";
                            } else if (data === 'Not Applicable') {
                                return "{{ __('locale.NotApplicable') }}";
                            } else if (data === 'Partially Implemented') {
                                return "{{ __('locale.PartiallyImplemented') }}";
                            } else {
                                return data;
                            }
                        }
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
        });
    });
</script>

<script>
    $(document).ready(function() {
        window.populateEditForm = function(id) {
            // Clear previous selections
            $('#edit-framework-families').empty();
            $('#edit-framework-subfamilies').empty();

            // Send AJAX request to fetch framework details
            $.ajax({
                url: '{{ route('admin.governance.framework.details') }}', // Correct route
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    // Populate the modal with the framework name and description
                    $('#edit-framework-id').val(id);
                    $('#edit-framework-name').val(response.name);
                    $('#edit-framework-description').val(response.description);

                    // Populate Families Select
                    response.families.forEach(function(family) {
                        var option = $('<option></option>').attr('value', family.id)
                            .text(family.name);
                        if (family.selected) {
                            option.attr('selected', 'selected');
                        }
                        $('#edit-framework-families').append(option);
                    });

                    // Populate Sub-families Select
                    response.subfamilies.forEach(function(subfamily) {
                        var option = $('<option></option>').attr('value', subfamily.id)
                            .text(subfamily.name);
                        if (subfamily.selected) {
                            option.attr('selected', 'selected');
                        }
                        $('#edit-framework-subfamilies').append(option);
                    });

                    // Re-initialize select2 after populating options
                    $('#edit-framework-families').trigger('change');
                    $('#edit-framework-subfamilies').trigger('change');
                },
                error: function(xhr) {
                    alert('An error occurred while fetching framework details.');
                }
            });
        };

        $('#editFrameworkForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var form = $(this);
            var formData = new FormData(form[0]); // Collect form data

            // Append the id of the framework
            var frameworkId = $('#edit-framework-id').val();
            formData.append('id', frameworkId);

            $.ajax({
                url: form.attr('action'), // The form's action URL
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Let the browser set the content type
                success: function(response) {
                    if (response.status) {
                        // Show a success message
                        makeAlert('success', response.message, 'Success');
                        if (response.reload) {
                            location.reload();
                        }
                    } else {
                        // Show an error message from the response
                        makeAlert('error', response.message, 'Error');
                    }
                },
                error: function(xhr) {
                    // Handle validation errors or other issues
                    let errorMessage = 'An unexpected error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 422) {
                        // Validation error messages
                        errorMessage = Object.values(xhr.responseJSON.errors)
                            .flat()
                            .join('<br>');
                    }
                    makeAlert('error', errorMessage, 'Error');
                },
            });
        });

    });
</script>











<script src="{{ asset('cdn/npm-chart.js') }}"></script>
<script src="{{ asset('cdn/feather.min.js') }}"></script>
 <script>
    // Initialize Feather Icons
    feather.replace();
</script>

@endsection
