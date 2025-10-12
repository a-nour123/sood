@extends('admin/layouts/contentLayoutMaster')

@section('title', __('Exceptions'))

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
                                @if (auth()->user()->hasPermission('asset.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-exception">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.governance.exception.notificationsSettingsExceptions') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->role->name == 'Administrator')
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exception-config"> <i class="fa fa-solid fa-gear"></i>
                                    </button>
                                @endif

                                <a class="btn btn-primary"
                                    href="{{ route('admin.governance.exception.graphViewException') }}">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </a>

                                {{-- <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                    exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' />

                                <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>



<div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Statistics') }}</h4>
        </div>
    </div>


    <div class="card-body mt-2 dashboard_default module_summary">
        <div class="row dashboard  widget-grid justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 box-col-4">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 box-col-5">
                                <div class="d-flex">
                                    <div class="badge bg-light-dark badge-rounded font-primary me-2"> <i class="size-18"
                                            data-feather='layers'></i></div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.PolicyExceptions') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">{{ $policyExceptions->count() }}</h5>
                            </div>
                            <div class="col-sm-5 box-col-5 incom-chart">
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
                            <div class="col-sm-5 box-col-5">
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
                            <div class="col-sm-5 box-col-5 incom-chart">
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
    </div>
</div>



<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.exceptions') }}</h4>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="exceptionTab" role="tablist" style="margin-bottom: 2rem !important;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1"
                            role="tab" aria-controls="tab1" aria-selected="true"
                            style="border: none; ">{{ __('locale.PolicyExceptions') . '(' . $policyExceptions->count() . ')' }}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab"
                            aria-controls="tab2" aria-selected="false"
                            style="border: none;">{{ __('locale.ControlExceptions') . '(' . $controlExceptions->count() . ')' }}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab4-tab" data-bs-toggle="tab" href="#tab4" role="tab"
                            aria-controls="tab3" aria-selected="false"
                            style="border: none;">{{ __('locale.RiskExceptions') . '(' . $riskExceptions->count() . ')' }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab"
                            aria-controls="tab3" aria-selected="false"
                            style="border: none;">{{ __('locale.UnapprovedExceptions') . '(' . $unapprovedExceptions->count() . ')' }}</a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="exceptionTabContent">
                    <!-- Tab 1 -->
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                        aria-labelledby="tab1-tab">
                        <div class="card-datatable pd-4">
                            <table class="dt-advanced-server-search table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.#') }}</th>
                                        <th style="width: 15%;">{{ __('locale.Name') }}</th>
                                        <th>{{ __('locale.Requestor') }}</th>
                                        <th>{{ __('locale.Approver') }}</th>
                                        <th>{{ __('locale.SubmissionDate') }}</th>
                                        <th style="text-align: center;">{{ __('locale.ApprovalDate') }}</th>
                                        <th>{{ __('locale.RequestStatus') }}</th>
                                        <th style="text-align: center;">{{ __('locale.ExceptionDuration') }}</th>
                                        <th style="text-align: center;">{{ __('locale.EndsOn') }}</th>
                                        {{-- <th style="text-align: center;">{{ __('locale.NextReviewDate') }}</th> --}}
                                        {{-- <th style="width: 30%;">{{ __('locale.Description') }}</th> --}}
                                        <th>{{ __('locale.ExceptionStatus') }}</th>
                                        <th>{{ __('locale.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($policyExceptions as $key => $exception)
                                        @php

                                            if ($exception->approval_date == null) {
                                                $end_date = null;
                                            } else {
                                                // Create a DateTime object from the approval date
                                                $start_date = new DateTime($exception->approval_date);

                                                // Add the exception duration
                                                $end_date = (clone $start_date)->modify(
                                                    "+{$exception->request_duration} days",
                                                );

                                                // Format the end date as Y-m-d
                                                $end_date = $end_date->format('Y-m-d');
                                                $currentDate = (new DateTime())->format('Y-m-d'); // Outputs: 'Y-m-d' format, e.g., '2024-11-03'
                                                if ($end_date == $currentDate) {
                                                    DB::table('exceptions')
                                                        ->where('id', $exception->id)
                                                        ->update(['exception_status' => 0]);
                                                }

                                                // dd($currentDate);
                                            }

                                        @endphp
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td style="width: 15%;">{{ $exception->name }}</td>
                                            @php
                                                // Get the creator name
                                                $exception_creator = DB::table('exceptions')
                                                    ->select('exception_creator')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->exception_creator;
                                                $exception_creator_name = DB::table('users')
                                                    ->select('name')
                                                    ->where('id', $exception_creator)
                                                    ->get()
                                                    ->toArray()[0]->name;

                                                // Get the approver name
                                                $exception_approver = DB::table('exceptions')
                                                    ->select('policy_approver_id')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->policy_approver_id;
                                                if ($exception_approver) {
                                                    $exception_approver_name = DB::table('users')
                                                        ->select('name')
                                                        ->where('id', $exception_approver)
                                                        ->get()
                                                        ->toArray()[0]->name;
                                                } else {
                                                    $exception_approver_name = null;
                                                }
                                            @endphp
                                            <td>{{ $exception_creator_name }}</td>
                                            @if ($exception_approver_name)
                                                <td style="text-align: center;">{{ $exception_approver_name }}</td>
                                            @else
                                                <td style="text-align: center;"> - </td>
                                            @endif
                                            <td>{{ $exception->created_at->format('Y-m-d') }}</td>
                                            @if ($exception->approval_date)
                                                <td style="text-align: center;">{{ $exception->approval_date }}</td>
                                            @else
                                                <td style="text-align: center;"> - </td>
                                            @endif
                                            <td>
                                                @if ($exception->request_status == 0)
                                                    <span
                                                        class="badge rounded-pill badge-light-warning">{{ __('locale.Pending') }}</span>
                                                @elseif($exception->request_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Rejected') }}</span>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($exception->request_duration)
                                                    {{ $exception->request_duration }} Days
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($end_date)
                                                    {{ $end_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>


                                            {{-- <td style="text-align: center;">
                                                @if ($exception->next_review_date)
                                                    {{ $exception->next_review_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td> --}}
                                            {{-- <td>{!! $exception->description !!}</td> --}}
                                            <td>
                                                @if ($exception->exception_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Open') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Closed') }}</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="dropdown">
                                                    <a class="pe-1 dropdown-toggle hide-arrow text-primary"
                                                        href="#" role="button"
                                                        id="actionsDropdown{{ $exception->id }}"
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
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="actionsDropdown{{ $exception->id }}">
                                                        <!-- View Action -->
                                                        <li>
                                                            <a href="{{ route('admin.governance.exception.show', ['id' => $exception->id]) }}"
                                                                class="dropdown-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-eye me-50 font-small-4">
                                                                    <path
                                                                        d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                    </path>
                                                                    <circle cx="12" cy="12" r="3">
                                                                    </circle>
                                                                </svg>
                                                                {{ __('locale.View') }}
                                                            </a>
                                                        </li>

                                                        <!-- Edit Action -->
                                                        @if (
                                                            (auth()->user()->id == $exception->exception_creator && $exception->request_status == '0') ||
                                                                auth()->user()->id == $exception->policy_approver_id)
                                                            <li>
                                                                <a href="javascript:;" class="dropdown-item item-edit"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-exception"
                                                                    data-id="{{ $exception->id }}"
                                                                    data-type="policy">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-edit font-small-4">
                                                                        <path
                                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                        </path>
                                                                        <path
                                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                        </path>
                                                                    </svg>
                                                                    {{ __('locale.Edit') }}
                                                                </a>
                                                            </li>
                                                        @endif

                                                        <!-- Delete Action -->
                                                        {{-- Uncomment this section if needed
            <li>
                <a href="javascript:;" class="dropdown-item item-delete" onclick="showModalDeleteRisk({{ $exception->id }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    Delete
                </a>
            </li>
            --}}
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2 -->
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <div class="card-datatable pd-4">
                            <table class="dt-advanced-server-search table" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.#') }}</th>
                                        <th>{{ __('locale.Name') }}</th>
                                        <th>{{ __('locale.Requestor') }}</th>
                                        <th>{{ __('locale.Approver') }}</th>
                                        <th>{{ __('locale.SubmissionDate') }}</th>
                                        <th style="text-align: center;">{{ __('locale.ApprovalDate') }}</th>
                                        <th>{{ __('locale.RequestStatus') }}</th>
                                        <th style="text-align: center;">{{ __('locale.ExceptionDuration') }}</th>
                                        <th style="text-align: center;">{{ __('locale.EndsOn') }}</th>
                                        {{-- <th>{{ __('locale.NextReviewDate') }}</th> --}}
                                        {{-- <th style="width: 30%;">{{ __('locale.Description') }}</th> --}}
                                        <th>{{ __('locale.ExceptionStatus') }}</th>
                                        <th>{{ __('locale.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($controlExceptions as $key => $exception)
                                        @php

                                            if ($exception->approval_date == null) {
                                                $end_date = null;
                                            } else {
                                                // Create a DateTime object from the approval date
                                                $start_date = new DateTime($exception->approval_date);

                                                // Add the exception duration
                                                $end_date = (clone $start_date)->modify(
                                                    "+{$exception->request_duration} days",
                                                );

                                                // Format the end date as Y-m-d
                                                $end_date = $end_date->format('Y-m-d');
                                                $currentDate = (new DateTime())->format('Y-m-d'); // Outputs: 'Y-m-d' format, e.g., '2024-11-03'
                                                if ($end_date == $currentDate) {
                                                    DB::table('exceptions')
                                                        ->where('id', $exception->id)
                                                        ->update(['exception_status' => 0]);
                                                }

                                                // dd($currentDate);
                                            }

                                        @endphp
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $exception->name }}</td>
                                            @php
                                                $exception_creator = DB::table('exceptions')
                                                    ->select('exception_creator')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->exception_creator;
                                                $exception_creator_name = DB::table('users')
                                                    ->select('name')
                                                    ->where('id', $exception_creator)
                                                    ->get()
                                                    ->toArray()[0]->name;

                                                // Get the approver name
                                                $exception_approver = DB::table('exceptions')
                                                    ->select('control_approver_id')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->control_approver_id;
                                                if ($exception_approver) {
                                                    $exception_approver_name = DB::table('users')
                                                        ->select('name')
                                                        ->where('id', $exception_approver)
                                                        ->get()
                                                        ->toArray()[0]->name;
                                                } else {
                                                    $exception_approver_name = null;
                                                }
                                            @endphp
                                            <td>{{ $exception_creator_name }}</td>
                                            @if ($exception_approver_name)
                                                <td style="text-align: center;">{{ $exception_approver_name }}</td>
                                            @else
                                                <td style="text-align: center;"> - </td>
                                            @endif
                                            <td>{{ $exception->created_at->format('Y-m-d') }}</td>
                                            @if ($exception->approval_date)
                                                <td style="text-align: center;">{{ $exception->approval_date }}</td>
                                            @else
                                                <td style="text-align: center;"> - </td>
                                            @endif
                                            <td>
                                                @if ($exception->request_status == 0)
                                                    <span
                                                        class="badge rounded-pill badge-light-warning">{{ __('locale.Pending') }}</span>
                                                @elseif($exception->request_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Rejected') }}</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if ($exception->request_duration)
                                                    {{ $exception->request_duration }} Days
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($end_date)
                                                    {{ $end_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>

                                            {{-- <td style="text-align: center;">
                                                @if ($exception->next_review_date)
                                                    {{ $exception->next_review_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td> --}}
                                            {{-- <td>{!! $exception->description !!}</td> --}}
                                            <td>
                                                @if ($exception->exception_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Open') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Closed') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.governance.exception.show', ['id' => $exception->id]) }}"
                                                    class="item-show">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-eye me-50 font-small-4">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="3">
                                                        </circle>
                                                    </svg>
                                                </a>
                                                @if (
                                                    (auth()->user()->id == $exception->exception_creator && $exception->request_status == '0') ||
                                                        auth()->user()->id == $exception->control_approver_id)
                                                    <a style="margin-right: 6px;" class="item-edit"
                                                        data-bs-toggle="modal" data-type="control"
                                                        data-bs-target="#edit-exception"
                                                        data-id="{{ $exception->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-edit font-small-4">
                                                            <path
                                                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                            </path>
                                                            <path
                                                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                @endif
                                                {{-- <a href="javascript:;"
                                                    onclick="showModalDeleteRisk({{ $exception->id }})"
                                                    class="item-delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-trash-2 me-50 font-small-4">
                                                        <polyline points="3 6 5 6 21 6">
                                                        </polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10"
                                                            y2="17"></line>
                                                        <line x1="14" y1="11" x2="14"
                                                            y2="17"></line>
                                                    </svg>
                                                </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3 -->
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <div class="card-datatable pd-4">
                            <table class="dt-advanced-server-search table" id="myTable2">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.#') }}</th>
                                        <th>{{ __('locale.Name') }}</th>
                                        <th>{{ __('locale.ExceptionType') }}</th>
                                        <th>{{ __('locale.Requestor') }}</th>
                                        <th>{{ __('locale.ExceptionStatus') }}</th>
                                        <th>{{ __('locale.ExceptionDuration') }}</th>
                                        {{-- <th>{{ __('locale.NextReviewDate') }}</th> --}}
                                        <th style="width: 30%;">{{ __('locale.Description') }}</th>
                                        <th>{{ __('locale.RequestStaus') }}</th>
                                        {{-- <th>{{ __('locale.Actions') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unapprovedExceptions as $key => $exception)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $exception->name }}</td>
                                            <td>{{ $exception->type }}</td>
                                            @php
                                                $exception_creator = DB::table('exceptions')
                                                    ->select('exception_creator')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->exception_creator;

                                                $exception_creator_name = DB::table('users')
                                                    ->select('name')
                                                    ->where('id', $exception_creator)
                                                    ->get()
                                                    ->toArray()[0]->name;
                                            @endphp
                                            <td>{{ $exception_creator_name }}</td>
                                            <td>
                                                @if ($exception->exception_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Open') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Closed') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($exception->request_duration)
                                                    {{ $exception->request_duration }} Days
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>
                                            {{-- <td style="text-align: center;">
                                                @if ($exception->next_review_date)
                                                    {{ $exception->next_review_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td> --}}
                                            <td>{!! $exception->description !!}</td>
                                            <td>
                                                @if ($exception->request_status == '0')
                                                    <span
                                                        class="badge rounded-pill badge-light-warning">{{ __('locale.Pending') }}</span>
                                                @elseif ($exception->request_status == '2')
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.rejected') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 4 -->
                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                        <div class="card-datatable pd-4">
                            <table class="dt-advanced-server-search table" id="myTable4">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.#') }}</th>
                                        <th>{{ __('locale.Name') }}</th>
                                        <th>{{ __('locale.Requestor') }}</th>
                                        <th>{{ __('locale.Approver') }}</th>
                                        <th>{{ __('locale.SubmissionDate') }}</th>
                                        <th style="text-align: center;">{{ __('locale.ApprovalDate') }}</th>
                                        <th>{{ __('locale.RequestStatus') }}</th>
                                        <th style="text-align: center;">{{ __('locale.ExceptionDuration') }}</th>
                                        <th style="text-align: center;">{{ __('locale.EndsOn') }}</th>
                                        {{-- <th>{{ __('locale.NextReviewDate') }}</th> --}}
                                        {{-- <th style="width: 30%;">{{ __('locale.Description') }}</th> --}}
                                        <th>{{ __('locale.ExceptionStatus') }}</th>
                                        <th>{{ __('locale.Actions') }}</th>
                                        {{-- <th>{{ __('locale.Actions') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riskExceptions as $key => $exception)
                                        @php

                                            if ($exception->approval_date == null) {
                                                $end_date = null;
                                            } else {
                                                // Create a DateTime object from the approval date
                                                $start_date = new DateTime($exception->approval_date);

                                                // Add the exception duration
                                                $end_date = (clone $start_date)->modify(
                                                    "+{$exception->request_duration} days",
                                                );

                                                // Format the end date as Y-m-d
                                                $end_date = $end_date->format('Y-m-d');
                                                $currentDate = (new DateTime())->format('Y-m-d'); // Outputs: 'Y-m-d' format, e.g., '2024-11-03'
                                                if ($end_date == $currentDate) {
                                                    DB::table('exceptions')
                                                        ->where('id', $exception->id)
                                                        ->update(['exception_status' => 0]);
                                                }

                                                // dd($currentDate);
                                            }

                                        @endphp
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $exception->name }}</td>
                                            @php
                                                $exception_creator = DB::table('exceptions')
                                                    ->select('exception_creator')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->exception_creator;
                                                $exception_creator_name = DB::table('users')
                                                    ->select('name')
                                                    ->where('id', $exception_creator)
                                                    ->get()
                                                    ->toArray()[0]->name;

                                                // Get the approver name
                                                $exception_approver = DB::table('exceptions')
                                                    ->select('risk_approver_id')
                                                    ->where('id', $exception->id)
                                                    ->get()
                                                    ->toArray()[0]->risk_approver_id;
                                                // dd($exception_approver);
                                                if ($exception_approver) {
                                                    $exception_approver_name = DB::table('users')
                                                        ->select('name')
                                                        ->where('id', $exception_approver)
                                                        ->get()
                                                        ->toArray()[0]->name;
                                                } else {
                                                    $exception_approver_name = null;
                                                }
                                            @endphp
                                            <td>{{ $exception_creator_name }}</td>

                                            @if ($exception_approver_name)
                                                <td style="text-align: center;">{{ $exception_approver_name }}</td>
                                            @else
                                                <td style="text-align: center;"> - </td>
                                            @endif
                                            <td>{{ $exception->created_at->format('Y-m-d') }}</td>
                                            @if ($exception->approval_date)
                                                <td style="text-align: center;">{{ $exception->approval_date }}</td>
                                            @else
                                                <td style="text-align: center;"> - </td>
                                            @endif
                                            <td>
                                                @if ($exception->request_status == 0)
                                                    <span
                                                        class="badge rounded-pill badge-light-warning">{{ __('locale.Pending') }}</span>
                                                @elseif($exception->request_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Rejected') }}</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if ($exception->request_duration)
                                                    {{ $exception->request_duration }} Days
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                @if ($end_date)
                                                    {{ $end_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td>
                                            {{-- <td style="text-align: center;">
                                                @if ($exception->next_review_date)
                                                    {{ $exception->next_review_date }}
                                                @else
                                                    <p> - </p>
                                                @endif
                                            </td> --}}
                                            {{-- <td>{!! $exception->description !!}</td> --}}
                                            <td>
                                                @if ($exception->exception_status == 1)
                                                    <span
                                                        class="badge rounded-pill badge-light-success">{{ __('locale.Open') }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill badge-light-danger">{{ __('locale.Closed') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.governance.exception.show', ['id' => $exception->id]) }}"
                                                    class="item-show">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-eye me-50 font-small-4">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="3">
                                                        </circle>
                                                    </svg>
                                                </a>
                                                @if (
                                                    (auth()->user()->id == $exception->exception_creator && $exception->request_status == '0') ||
                                                        auth()->user()->id == $exception->risk_approver_id)
                                                    <a style="margin-right: 6px;" class="item-edit"
                                                        data-bs-toggle="modal" data-type="risk"
                                                        data-bs-target="#edit-exception"
                                                        data-id="{{ $exception->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-edit font-small-4">
                                                            <path
                                                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                            </path>
                                                            <path
                                                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                @endif

                                                {{-- <a href="javascript:;"
                                                                        onclick="showModalDeleteRisk({{ $exception->id }})"
                                                                        class="item-delete">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-trash-2 me-50 font-small-4">
                                                                            <polyline points="3 6 5 6 21 6">
                                                                            </polyline>
                                                                            <path
                                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                            </path>
                                                                            <line x1="10" y1="11" x2="10"
                                                                                y2="17"></line>
                                                                            <line x1="14" y1="11" x2="14"
                                                                                y2="17"></line>
                                                                        </svg>
                                                                    </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>




<div class="modal fade" id="edit-exception" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <div class="text-center mb-4">
                    <h2 class="modal-title" id="myExtraLargeModal">{{ __('locale.EditException') }}
                    </h2>
                </div>
                <form action={{ route('admin.governance.exception.store') }} method="POST"
                    class="modal-content pt-4 p-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" id="logged-in-user" value="{{ auth()->user()->id }}">

                    <div id="creator_section">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-6 mb-3">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.ExceptionName') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control dt-post"
                                        aria-label="{{ __('locale.ExceptionName') }}" />
                                    <span class="error error-name text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-6 mb-3">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.ExceptionStatus') }} <span
                                            class="text-danger">*</span></label>
                                    <select id="status" type="text" name="status"
                                        class="form-control dt-post"
                                        aria-label="{{ __('locale.ExceptionStatus') }}">
                                        {{-- <option value="">Select Status</option> --}}
                                        {{-- <option value="" selected> -- </option> --}}
                                        <option value="1">{{ __('locale.Open') }}</option>
                                        <option value="0">{{ __('locale.Closed') }}</option>
                                    </select>
                                    <span class="error error-status text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Policy --}}
                            <div class="col-12 mb-3" id="policy-select">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.Policy') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="policy" id="policy-select-element" class="form-control dt-post"
                                        aria-label="{{ __('locale.Policy') }}">
                                        <option value="" selected> -- </option>
                                        @foreach ($documents as $document)
                                            <option value="{{ $document->id }}">{{ $document->document_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error error-policy text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Risks --}}
                            <div class="col-12 mb-3" id="risk-select">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.Risk') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="risk" id="risk-select-element" class="form-control dt-post"
                                        aria-label="{{ __('locale.Risk') }}">
                                        <option value="" selected> -- </option>
                                        @foreach ($risks as $risk)
                                            <option value="{{ $risk->id }}">{{ $risk->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-risk text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Regulator --}}
                            <div class="col-4 mb-3">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.Regulator') }} <span
                                            class="text-danger"></span></label>
                                    <select name="regulator" id="regulator-select-element"
                                        class="form-control dt-post" aria-label="{{ __('locale.Regulator') }}">
                                        <option value="" selected> -- </option>
                                        @foreach ($regulators as $regulator)
                                            <option value="{{ $regulator->id }}">{{ $regulator->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-regulator text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Framework --}}
                            <div class="col-4 mb-3">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.Framework') }} <span
                                            class="text-danger">*</span></label>
                                    <select id="framework" name="framework" class="form-control dt-post"
                                        aria-label="{{ __('locale.Framework') }}">
                                        <option value="" selected> -- </option>
                                    </select>
                                    <span class="error error-framework text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Control --}}
                            <div class="col-4 mb-3" id="control-select">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.Control') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="control" id="control-select-element" class="form-control dt-post"
                                        aria-label="{{ __('locale.Control') }}">
                                        <option value="" selected> -- </option>
                                        @foreach ($controls as $control)
                                            <option value="{{ $control->id }}">{{ $control->short_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <span class="error error-control text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Additional Stakeholders --}}
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.AdditionalStakeholders') }} <span
                                            class="text-danger">*</span></label>
                                    <select id="stakeholder" name="stakeholder[]" class="form-select select2"
                                        multiple="multiple" aria-label="{{ __('locale.AdditionalStakeholders') }}">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-stakeholder text-danger my-2"></span>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.ExceptionDuration') }} <span
                                            class="text-danger">*</span></label>
                                    <span class="text-muted">({{ __('locale.Days') }})</span>
                                    <input id="request_duration" type="number" name="request_duration"
                                        class="form-control" aria-label="{{ __('locale.ExceptionDuration') }}"
                                        min="1" placeholder="Example : 1234">
                                    <span class="error error-request_duration text-danger my-2"></span>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12 mb-3" id="description">
                                <div class="mb-1">
                                    <label for="control_supplemental_guidance">{{ __('locale.Description') }}</label>
                                    {{--  <div id="control_supplemental_guidance"></div>  --}}
                                    <textarea name="description" id="editor2" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            {{-- justification --}}
                            <div class="col-12 mb-3" id="justification">
                                <div class="mb-1">
                                    <label
                                        for="control_supplemental_guidance">{{ __('locale.Justification') }}</label>
                                    <textarea name="justification" id="editor3" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="approver_section">
                        {{-- Request Status --}}
                        <div class="col-12 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.RequestStatus') }} <span
                                        class="text-danger">*</span></label>
                                <select id="request-status" type="text" name="request_status"
                                    class="form-control dt-post" aria-label="{{ __('locale.RequestStatus') }}">
                                    <option disabled hidden selected value="">{{ __('locale.Actions') }}
                                    </option>
                                    <option value="1">{{ __('locale.Approve') }}</option>
                                    <option value="2">{{ __('locale.Reject') }}</option>
                                </select>
                                <span class="error error-request_status text-danger my-2"></span>
                            </div>
                        </div>
                        {{-- Review Frequency --}}
                        {{-- <div id="review-section" style="display: none;">
                                <div class="col-12 mb-3">
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.ReviewFrequency') }} <span
                                                class="text-danger">*</span></label>
                                        <span class="text-muted">({{ __('locale.Days') }})</span>
                                        <input id="review_frequency" type="number" name="review_frequency"
                                            class="form-control" aria-label="{{ __('locale.ReviewFrequency') }}"
                                            min="1" placeholder="0">
                                        <span class="error error-reviewFrequency text-danger my-2"></span>
                                    </div>
                                </div> --}}

                        {{-- Next Review Date --}}

                        {{-- <div class="col-12 mb-3" style="display: none;">
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.NextReviewDate') }} <span
                                                class="text-danger">*</span></label>
                                        <input id="next_review_date" type="date" name="next_review_date"
                                            class="form-control" aria-label="{{ __('locale.NextReviewDate') }}"
                                            min="{{ date('Y-m-d') }}">
                                        <span class="error error-reviewDate text-danger my-2"></span>
                                    </div>
                                </div> --}}

                        {{-- reviewer --}}

                        {{-- <div class="col-12 mb-3">
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.Reviewer') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="reviewer" id="reviewer-select-element"
                                            class="form-control dt-post" aria-label="{{ __('locale.Reviewer') }}">
                                            <option value="" selected> -- </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-reviewer text-danger my-2"></span>
                                    </div>
                                </div> --}}

                        {{-- Comment --}}

                        <div class="col-12 mb-3" id="comment">
                            <div class="mb-1">
                                <label for="control_supplemental_guidance">{{ __('locale.Comment') }}</label>
                                <textarea name="comment" id="editor1" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="col-12 text-center mt-2">
                <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button>
            </div><br>
            </form>
        </div>
    </div>
</div>
</div>


<!-- Create Form -->
@if (auth()->user()->hasPermission('exception.create'))
    <x-exception-form id="add-new-exception" title="{{ __('locale.AddNewException') }}" :regulators="$regulators"
        :documents="$documents" :users="$users" :exceptionSettings="$exceptionSettings" :controls="$controls" :risks="$risks" />
@endif
<!--/ Create Form -->

<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('regulator.create'))  --}}
<x-exception-ConfigForm id="exception-config" title="{{ __('locale.ExceptionMgmt') }}" :exceptionSettings="$exceptionSettings"
    :departmentsManagers="$departmentsManagers" />
{{--  @endif  --}}
<!--/ Create Form -->
@endsection

@section('vendor-script')

<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script> --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('cdn/picker.js') }}"></script>
<script src="{{ asset('cdn/picker.date.js') }}"></script>

<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset('new_d/js/product-tab.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
@endsection

@section('page-script')


<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>

<script>
    $(document).ready(function() {
        $('select[name="regulator"]').on('change', function() {
            var regulatorId = $(this).val();

            var url = '{{ url('admin/governance/exception/get-frameworks') }}/' + regulatorId;

            // Make the AJAX request to fetch the frameworks
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    regulator_id: regulatorId
                },
                success: function(response) {
                    // Update the framework dropdown options
                    var frameworkDropdown = $('select[name="framework"]');
                    frameworkDropdown.empty();
                    frameworkDropdown.append('<option value="" selected> -- </option>');

                    $.each(response, function(index, framework) {
                        frameworkDropdown.append('<option value="' + framework.id +
                            '">' + framework.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching frameworks:', error);
                }
            });
        });
    });

    // Submit form for editing asset
    $('#edit-exception form').submit(function(e) {
        e.preventDefault();

        const id = $(this).find('input[name="id"]').val();
        console.log(id);

        let url = "{{ route('admin.governance.exception.update', ':id') }}";
        url = url.replace(':id', id);

        // Create a FormData object
        let formData = new FormData(this);

        let htmlCode = CKEDITOR.instances.editor1.getData();
        htmlCode = htmlCode.replace(/&nbsp;/g, '');
        htmlCode = htmlCode.replace(/(<br\s*\/?>\s*)+/g, '');

        formData.delete('body');
        formData.append('comment', htmlCode);

        $.ajax({
            url: url,
            type: "POST", // Laravel typically handles file uploads via POST
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set the content type to false as jQuery will tell the server it's a query string request
            success: function(data) {
                if (data.status) {

                    $('#edit-exception').modal('hide');
                    location.reload();
                } else {
                    // showError(data['errors']);
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                // Clear previous error messages
                $('.error').text('');

                // Display validation errors
                if (responseData.errors) {
                    $.each(responseData.errors, function(field, messages) {
                        // Assuming the field name is `name`, `status`, etc.
                        $('.error-' + field).text(messages[
                            0]); // Show only the first error message
                    });
                }

                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });


    // Pass PHP variables to JavaScript
    var policiesData = @json($documents);
    var controlsData = @json($controls);
    var risksData = @json($risks);
    var usersData = @json($users);
    var settings = @json($exceptionSettings);

    $(document).ready(function() {


        $('#policy-select-element1').select2({
            // placeholder: " -- ",
            allowClear: true // Allows the placeholder to be shown after clearing the selection
        });

        $('#risk-select-element1').select2({
            // placeholder: " -- ",
            allowClear: true // Allows the placeholder to be shown after clearing the selection
        });

        $('#regulator-select-element1').select2({
            // placeholder: " -- ",
            allowClear: true // Allows the placeholder to be shown after clearing the selection
        });

        $('#framework-select-element1').select2({
            // placeholder: " -- ",
            allowClear: true // Allows the placeholder to be shown after clearing the selection
        });

        $('#control-select-element1').select2({
            // placeholder: " -- ",
            allowClear: true // Allows the placeholder to be shown after clearing the selection
        });


        // controls part
        $('#control-select-element').change(function() {

            var controlId = $(this).val(); // Get selected control ID

            if (controlId) {
                console.log('controooool : ', controlId);
                var selectedcontrol = controlsData.find(control => control.id ==
                    controlId); // Find the selected control

                var approverSelect = $('#reviewer-select-element');
                approverSelect.empty();
                approverSelect.append('<option value="" selected> -- </option>');

                if (selectedcontrol) {
                    if (settings[0]['control_reviewer'] == 2) {

                        // If control_approver_status is 1, display all users
                        usersData.forEach(user => {
                            approverSelect.append('<option value="' + user.id + '">' + user
                                .name +
                                '</option>');
                        });
                    } else {
                        // If control_approver is 0, display only the owner
                        var owner = usersData.find(user => user.id == selectedcontrol.control_owner);
                        console.log(selectedcontrol);
                        console.log(owner);
                        if (owner) {
                            approverSelect.append('<option value="' + owner.id + '">' + owner.name +
                                '</option>');
                        }
                    }
                }
            }
        });

        // policies part
        $('#policy-select-element').change(function() {

            var policyId = $(this).val(); // Get selected policy ID

            if (policyId) {

                var selectedpolicy = policiesData.find(policy => policy.id ==
                    policyId); // Find the selected policy


                var reviewerSelect = $('#reviewer-select-element');
                reviewerSelect.empty();
                reviewerSelect.append('<option value="" selected> -- </option>');

                if (selectedpolicy) {
                    if (settings[0]['policy_reviewer'] == 2) {

                        // If policy_reviewer_status is 1, display all users
                        usersData.forEach(user => {
                            reviewerSelect.append('<option value="' + user.id + '">' + user
                                .name +
                                '</option>');
                        });
                    } else if (settings[0]['policy_reviewer'] == 1) {
                        // If policy_reviewer is 1, display only the owner
                        var owner = usersData.find(user => user.id == selectedpolicy.document_owner);
                        // console.log(selectedpolicy);
                        console.log('sdfsfdsfsfsfsdf  owner :', owner);
                        console.log(reviewerSelect); // Check if the element exists
                        if (owner) {
                            console.log('Appending owner:', owner.id, owner.name);
                            reviewerSelect.append('<option value="' + owner.id + '">' + owner.name +
                                '</option>');
                        }
                    }
                }
            }
        });

        // risks part
        $('#risk-select-element').change(function() {

            var riskId = $(this).val(); // Get selected risk ID

            if (riskId) {
                console.log('Riskkkkkk : ', riskId);

                var selectedrisk = risksData.find(risk => risk.id ==
                    riskId); // Find the selected risk


                var reviewerSelect = $('#reviewer-select-element');
                reviewerSelect.empty();
                reviewerSelect.append('<option value="" selected> -- </option>');

                if (selectedrisk) {
                    if (settings[0]['risk_reviewer'] == 2) {

                        // If risk_reviewer_status is 1, display all users
                        usersData.forEach(user => {
                            reviewerSelect.append('<option value="' + user.id + '">' + user
                                .name +
                                '</option>');
                        });
                    } else if (settings[0]['risk_reviewer'] == 1) {
                        // If risk_reviewer is 1, display only the owner
                        var owner = usersData.find(user => user.id == selectedrisk.owner_id);
                        // console.log(selectedrisk);
                        console.log('sdfsfdsfsfsfsdf  owner :', owner);
                        console.log(reviewerSelect); // Check if the element exists
                        if (owner) {
                            console.log('Appending owner:', owner.id, owner.name);
                            reviewerSelect.append('<option value="' + owner.id + '">' + owner.name +
                                '</option>');
                        }
                    }
                }
            }
        });

    });





    document.querySelector('#control-select select[name="control"]').addEventListener('change', function() {
        var approverSelectDiv = document.getElementById('control-approver-select');
        if (this.value) {
            approverSelectDiv.style.display = 'block';
        } else {
            approverSelectDiv.style.display = 'none';
        }
    });


    $(document).ready(function() {
        $('select[name="framework"]').on('change', function() {
            var frameworkId = $(this).val();

            var url = '{{ url('admin/governance/exception/get-controls-by-framework/') }}/' +
                frameworkId;

            // Make the AJAX request to fetch the frameworks
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    framework_id: frameworkId
                },
                success: function(response) {
                    // Update the framework dropdown options
                    var controlDropdown = $('select[name="control"]');
                    controlDropdown.empty();
                    controlDropdown.append('<option value="" selected> -- </option>');

                    $.each(response, function(index, control) {
                        controlDropdown.append('<option value="' + control.id +
                            '">' + control.short_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching controls:', error);
                }
            });
        });
    });

    $('#add-new-exception form').submit(function(e) {
        e.preventDefault();

        // Create a FormData object
        var formData = new FormData(this);

        let htmlCode = CKEDITOR.instances.editor4.getData();
        htmlCode = htmlCode.replace(/&nbsp;/g, '');
        htmlCode = htmlCode.replace(/(<br\s*\/?>\s*)+/g, '');

        formData.delete('body');
        formData.append('description', htmlCode);

        let justification = CKEDITOR.instances.editor5.getData();
        justification = justification.replace(/&nbsp;/g, '');
        justification = justification.replace(/(<br\s*\/?>\s*)+/g, '');

        formData.delete('body');
        formData.append('justification', justification);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(data) {
                if (data.status) {
                    // makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-exception').modal('hide');
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                // Clear previous error messages
                $('.error').text('');

                // Display validation errors
                if (responseData.errors) {
                    $.each(responseData.errors, function(field, messages) {
                        // Assuming the field name is `name`, `status`, etc.
                        $('.error-' + field).text(messages[
                            0]); // Show only the first error message
                    });
                }
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    $('#exception-config form').submit(function(e) {
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
                    // makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#exception-config').modal('hide');
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                // Clear previous error messages
                $('.error').text('');

                // Display validation errors
                if (responseData.errors) {
                    $.each(responseData.errors, function(field, messages) {
                        // Assuming the field name is `name`, `status`, etc.
                        $('.error-' + field).text(messages[
                            0]); // Show only the first error message
                    });
                }
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // function DeleteAsset(id) {
    //     let url = "{{ route('admin.asset_management.ajax.destroy', ':id') }}";
    //     url = url.replace(':id', id);
    //     $.ajax({
    //         url: url,
    //         type: "DELETE",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(data) {
    //             if (data.status) {
    //                 makeAlert('success', data.message, "{{ __('locale.Success') }}");
    //                 redrawDatatable();
    //             }
    //         },
    //         error: function(response, data) {
    //             responseData = response.responseJSON;
    //             makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    //         }
    //     });
    // }


    // Show delete alert modal
    // function ShowModalDeleteAsset(id) {
    //     $('.dtr-bs-modal').modal('hide');
    //     Swal.fire({
    //         title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
    //         text: '@lang('locale.YouWontBeAbleToRevertThis')',
    //         icon: 'question',
    //         showCancelButton: true,
    //         confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
    //         cancelButtonText: "{{ __('locale.Cancel') }}",
    //         customClass: {
    //             confirmButton: 'btn btn-relief-success ms-1',
    //             cancelButton: 'btn btn-outline-danger ms-1'
    //         },
    //         buttonsStyling: false
    //     }).then(function(result) {
    //         if (result.value) {
    //             DeleteAsset(id);
    //         }
    //     });
    // }


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

    // in creation mode
    document.addEventListener('DOMContentLoaded', function() {
        const policySelect = document.getElementById('policy-select-element1');
        const regulatorSelect = document.getElementById('regulator-select-element1');
        const frameworkSelect = document.getElementById('framework-select-element1');
        const controlSelect = document.getElementById('control-select-element1');
        const riskSelect1 = document.getElementById('risk-select-element1');

        // Initialize Select2 on the select elements
        $(policySelect).select2();
        $(regulatorSelect).select2();
        $(frameworkSelect).select2();
        $(controlSelect).select2();
        $(riskSelect1).select2();

        function toggleSelects() {
            // First, reset all selects to be enabled
            policySelect.disabled = false;
            regulatorSelect.disabled = false;
            frameworkSelect.disabled = false;
            controlSelect.disabled = false;
            riskSelect1.disabled = false;

            // Check if any specific select element has a value and disable others accordingly

            if (policySelect.value) {
                // If policySelect has a value, disable all other selects
                regulatorSelect.disabled = true;
                frameworkSelect.disabled = true;
                controlSelect.disabled = true;
                riskSelect1.disabled = true;
            } else if (regulatorSelect.value) {
                // If regulatorSelect has a value, disable policySelect and riskSelect1
                policySelect.disabled = true;
                riskSelect1.disabled = true;
            } else if (riskSelect1.value) {
                // If riskSelect1 has a value, disable policySelect, regulatorSelect, frameworkSelect, and controlSelect
                policySelect.disabled = true;
                regulatorSelect.disabled = true;
                frameworkSelect.disabled = true;
                controlSelect.disabled = true;
            }
        }

        // Use the on method to attach event listeners to the select elements
        $(policySelect).on('select2:select select2:unselect', toggleSelects);
        $(regulatorSelect).on('select2:select select2:unselect', toggleSelects);
        $(riskSelect1).on('select2:select select2:unselect', toggleSelects);
    });

    // To retrieve data in edit mode
    document.addEventListener('DOMContentLoaded', function() {


        const editButtons = document.querySelectorAll('.item-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const exceptionId = this.getAttribute('data-id');
                const type = this.getAttribute('data-type');
                console.log('Fetching data for exception ID:', exceptionId);

                // Populate the hidden id field
                document.querySelector('#edit-exception input[name="id"]').value = exceptionId;
                // Make an AJAX request to fetch the exception data
                // Construct the URL using the route
                const getExceptionDataRoute =
                    "{{ route('admin.governance.exception.getExceptionData', ['id' => ':id', 'type' => ':type']) }}";
                const url = getExceptionDataRoute.replace(':id', exceptionId).replace(':type',
                    type || '');

                fetch(url)
                    .then(response => {
                        console.log('Fetch response:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Exception data:', data);


                        $('#policy-select-element').val(data.policy_id).trigger('change');
                        $('#control-select-element').val(data.control_id).trigger('change');
                        $('#risk-select-element').val(data.risk_id).trigger('change');
                        $('#review_frequency').val(data.risk_id).trigger('change');

                        console.log(data);
                        document.getElementById('name').value = data.exception.name;
                        document.getElementById('request_duration').value = data.exception
                            .request_duration;
                        // Preselect stakeholders
                        const stakeholderSelect = $('#stakeholder');
                        let stakeholders = data.exception.stakeholder;

                        // Check if stakeholders is a JSON string and parse it to an array if necessary
                        if (typeof stakeholders === 'string') {
                            stakeholders = JSON.parse(stakeholders);
                        }

                        console.log(stakeholders); // This should log an array like [3, 5]
                        stakeholderSelect.val(stakeholders).trigger('change');

                        CKEDITOR.instances['editor2'].setData(data.exception.description);
                        CKEDITOR.instances['editor3'].setData(data.exception.justification);
                        CKEDITOR.instances['editor1'].setData(data.exception.comment);

                        const requestStatus = data.exception.request_status;
                        // Select the correct option in the dropdown
                        const requestStatusElement = document.getElementById(
                            'request-status');
                        if (requestStatusElement && requestStatus != 0) {
                            requestStatusElement.value = requestStatus;
                        }

                        // Check if the logged-in user is the exception_creator
                        const loggedInUserId = document.getElementById('logged-in-user')
                            .value;
                        const policySelect = document.getElementById(
                            'policy-select-element');
                        const regulatorSelect = document.getElementById(
                            'regulator-select-element');
                        const frameworkSelect = document.getElementById('framework');
                        const riskSelect = document.getElementById('risk-select-element');
                        const controlSelect = document.getElementById(
                            'control-select-element');
                        const exceptionName = document.getElementById(
                            'name');
                        const exceptionStatus = document.getElementById(
                            'status');
                        const reviewFrequency = document.getElementById(
                            'review_frequency');
                        const exceptionStakeholders = document.getElementById(
                            'stakeholder');
                        const description = document.getElementById(
                            'description');
                        const justification = document.getElementById(
                            'justification');

                        console.log(policySelect.value);


                        if (policySelect.value != "") {
                            riskSelect.disabled = true;
                            regulatorSelect.disabled = true;
                            frameworkSelect.disabled = true;
                            controlSelect.disabled = true;
                        }

                        if (riskSelect.value != "") {
                            policySelect.disabled = true;
                            regulatorSelect.disabled = true;
                            frameworkSelect.disabled = true;
                            controlSelect.disabled = true;
                        }

                        if (controlSelect.value != "") {
                            policySelect.disabled = true;
                            riskSelect.disabled = true;
                        }


                        if (loggedInUserId != data.exception.exception_creator) {
                            document.getElementById('approver_section').style.display =
                                'block';
                            document.getElementById('creator_section').style.display =
                                'none';
                            policySelect.disabled = true;
                            regulatorSelect.disabled = true;
                            frameworkSelect.disabled = true;
                            riskSelect.disabled = true;
                            controlSelect.disabled = true;
                            exceptionName.disabled = true;
                            exceptionStatus.disabled = true;
                            exceptionStakeholders.disabled = true;
                            description.style.display =
                                'none';
                            justification.style.display =
                                'none';
                            // reviewFrequency.value = data.exception.request_duration;

                        } else {
                            document.getElementById('approver_section').style.display =
                                'none';
                        }

                        // Show the modal
                        const modal = document.getElementById('edit-exception');
                        modal.show();
                    })
                    .catch(error => console.error('Error fetching exception data:', error));
            });
        });
    });

    // start disable policy and risk when select a regulator, vice versa
    const policySelect = document.getElementById('policy-select-element');
    const regulatorSelect = document.getElementById('regulator-select-element');
    const frameworkSelect = document.getElementById('framework');
    const controlSelect = document.getElementById('control-select-element');
    const riskSelect = document.getElementById('risk-select-element');

    function toggleSelects() {
        // First, reset all selects to be enabled
        policySelect.disabled = false;
        regulatorSelect.disabled = false;
        frameworkSelect.disabled = false;
        controlSelect.disabled = false;
        riskSelect.disabled = false;

        // Check if any specific select element has a value and disable others accordingly

        if (policySelect.value) {
            // If policySelect has a value, disable all other selects
            regulatorSelect.disabled = true;
            frameworkSelect.disabled = true;
            controlSelect.disabled = true;
            riskSelect.disabled = true;
        } else if (regulatorSelect.value) {
            // If regulatorSelect has a value, disable policySelect and riskSelect1
            policySelect.disabled = true;
            riskSelect.disabled = true;
        } else if (riskSelect.value) {
            // If riskSelect1 has a value, disable policySelect, regulatorSelect, frameworkSelect, and controlSelect
            policySelect.disabled = true;
            regulatorSelect.disabled = true;
            frameworkSelect.disabled = true;
            controlSelect.disabled = true;
        }
    }


    policySelect.addEventListener('change', toggleSelects);
    regulatorSelect.addEventListener('change', toggleSelects);
    riskSelect.addEventListener('change', toggleSelects);
    // end disable policy and risk when select a regulator, vice versa


    document.addEventListener('DOMContentLoaded', function() {
        const requestStatus = document.getElementById('request-status');
        const reviewSection = document.getElementById('review-section');

        function toggleReviewSection() {
            if (requestStatus.value === "1") { // If 'Approve' is selected
                reviewSection.style.display = 'block';
            } else if (requestStatus.value === "2") { // If 'Reject' is selected
                reviewSection.style.display = 'none';
                // document.getElementById('review_frequency').value = "";
                // document.getElementById('next_review_date').value = "";
                // document.getElementById('reviewer-select-element').value = "";
            }
        }

        // Initialize the display based on the current selection
        // toggleReviewSection();

        // Add event listener for changes in the request status
        // requestStatus.addEventListener('change', toggleReviewSection);
    });


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



    // Data values for control exceptions
    let controlTotal = approvedControlExceptions + rejectedControlExceptions + pendingControlExceptions;

    // Calculate exact percentages
    let controlApprovedPercentage = (approvedControlExceptions / controlTotal) * 100;
    let controlRejectedPercentage = (rejectedControlExceptions / controlTotal) * 100;
    let controlPendingPercentage = (pendingControlExceptions / controlTotal) * 100;

    // Round to 1 decimal place
    controlApprovedPercentage = Math.round(controlApprovedPercentage * 10) / 10;
    controlRejectedPercentage = Math.round(controlRejectedPercentage * 10) / 10;

    // Adjust pending to ensure total equals 100%
    controlPendingPercentage = Math.round((100 - controlApprovedPercentage - controlRejectedPercentage) * 10) / 10;

    // Control Chart
    var income = {
        series: [controlApprovedPercentage, controlRejectedPercentage,
            controlPendingPercentage
        ], // Use calculated percentages
        chart: {
            type: 'donut', // Use donut type for a round chart
            width: 280,
        },
        labels: [" {{ __('locale.Approved') }}", " {{ __('locale.Unapproved') }}",
            " {{ __('locale.Pending') }}"
        ],
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
                return val.toFixed(1) + '%'; // Keep 1 decimal place
            }
        },
        legend: {
            position: 'bottom'
        },
    };
    var IncomechrtchartEl = new ApexCharts(document.querySelector("#controlchart"), income);
    IncomechrtchartEl.render();


    // Data values for policy exceptions
    let policyTotal = approvedPolicyExceptions + rejectedPolicyExceptions + pendingPolicyExceptions;

    // Calculate exact percentages
    let policyApprovedPercentage = (approvedPolicyExceptions / policyTotal) * 100;
    let policyRejectedPercentage = (rejectedPolicyExceptions / policyTotal) * 100;
    let policyPendingPercentage = (pendingPolicyExceptions / policyTotal) * 100;

    // Round to 1 decimal place
    policyApprovedPercentage = Math.round(policyApprovedPercentage * 10) / 10;
    policyRejectedPercentage = Math.round(policyRejectedPercentage * 10) / 10;

    // Adjust pending to ensure total equals 100%
    policyPendingPercentage = Math.round((100 - policyApprovedPercentage - policyRejectedPercentage) * 10) / 10;


    // Policy Chart
    var income = {
        series: [policyApprovedPercentage, policyRejectedPercentage,
            policyPendingPercentage
        ], // Use calculated percentages
        chart: {
            type: 'donut', // Use donut type for a round chart
            width: 280,
        },
        labels: [" {{ __('locale.Approved') }}", " {{ __('locale.Unapproved') }}",
            " {{ __('locale.Pending') }}"
        ],
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
                return val.toFixed(1) + '%'; // Keep 1 decimal place
            }
        },
        legend: {
            position: 'bottom'
        },
    };
    var IncomechrtchartEl = new ApexCharts(document.querySelector("#policychart"), income);
    IncomechrtchartEl.render();


    // Data values for risk exceptions
    let total = approvedRiskExceptions + rejectedRiskExceptions + pendingRiskExceptions;

    // Calculate exact percentages
    let approvedPercentage = (approvedRiskExceptions / total) * 100;
    let rejectedPercentage = (rejectedRiskExceptions / total) * 100;
    let pendingPercentage = (pendingRiskExceptions / total) * 100;

    // Round to 1 decimal place
    approvedPercentage = Math.round(approvedPercentage * 10) / 10;
    rejectedPercentage = Math.round(rejectedPercentage * 10) / 10;

    // Adjust pending to ensure total equals 100%
    pendingPercentage = Math.round((100 - approvedPercentage - rejectedPercentage) * 10) / 10;


    // Risk Chart
    var income = {
        series: [approvedPercentage, rejectedPercentage, pendingPercentage], // Use calculated percentages
        chart: {
            type: 'donut', // Use donut type for a round chart
            width: 280,
        },
        labels: [" {{ __('locale.Approved') }}", " {{ __('locale.Unapproved') }}",
            " {{ __('locale.Pending') }}"
        ],
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
                return val.toFixed(1) + '%'; // Keep 1 decimal place
            }
        },
        legend: {
            position: 'bottom'
        },
    };
    var IncomechrtchartEl = new ApexCharts(document.querySelector("#riskchart"), income);
    IncomechrtchartEl.render();
</script>

{{-- To use datatable  --}}
<script>
       $('#myTable').DataTable({
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
        }
    });
    $('#myTable1').DataTable({
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
        }
    });

    $('#myTable2').DataTable({
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
        }
    });
    $('#myTable4').DataTable({
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
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the modal element by ID
        var modal = document.getElementById('add-new-exception');

        // Listen for the modal hide event
        modal.addEventListener('hide.bs.modal', function() {
            // Find the form inside the modal and reset it
            modal.querySelector('form').reset();

            // If using Select2, reset the selections
            $(modal).find('.select2').val(null).trigger('change');

        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the modal element by ID
        var modal = document.getElementById('edit-exception');

        // Listen for the modal hide event
        modal.addEventListener('hide.bs.modal', function() {
            // Find the form inside the modal and reset it
            modal.querySelector('form').reset();

            // If using Select2, reset the selections
            $(modal).find('.select2').val(null).trigger('change');

            // Reload the page when the modal is closed
            location.reload();
        });
    });
</script>

@endsection
