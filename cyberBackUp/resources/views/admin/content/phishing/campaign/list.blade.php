@extends('admin/layouts/contentLayoutMaster')

@section('title', __('phishing.Campaign'))

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

    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

    <style>
        .tab-pane.fade {
            display: none !important;
        }

        .tab-pane.fade.active.show {
            display: block !important;
        }

        .side-menu {
            background-color: #f4f4f4;
            padding: 10px;
            height: 100%;
            border-right: 1px solid #ddd;
        }

        .folders,
        .labels {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .folder-item,
        .label-item {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .folder-item:hover,
        .label-item:hover {
            background-color: #e9ecef;
        }

        .email-display {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .email-subject {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .email-details {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }

        .email-body {
            white-space: pre-wrap;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .nav-pills.campaign-type .nav-link label {
            border: 0px;
        }

        .nav-pills.campaign-type .nav-link input[type="radio"]:checked+label {
            background-color: transparent;
            color: #333;
            border-bottom: 1px solid #44225c;
        }

        .btn-group:hover .dropdown-menu {
            display: block;
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

                        @if (Route::currentRouteName() == 'admin.phishing.campaign.index')
                            <div class="col-sm-6 pe-0" style="text-align: end;">
                                <div class="action-content">
                                    @if (auth()->user()->hasPermission('campaign.create'))
                                        <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-new-senderProfile">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <a href="{{ route('admin.phishing.phishingNotification') }}"
                                            class=" btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>
                                        </a>
                                    @endif

                                    {{--  @if (auth()->user()->hasPermission('campaign.delete'))
                                        <a href="{{ route('admin.phishing.campaign.archivedcampaign') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa  fa-trash"></i>
                                    </a>
                                    @endif  --}}

                                    @if (auth()->user()->hasPermission('campaign.configuration'))
                                        <div class="btn-group dropdown dropdown-icon-wrapper me-1">
                                            <button type="button"
                                                class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="border-radius: 8px !important;
                                                width: 40px;
                                                text-align: center;
                                                color: #FFF !important;
                                                height: 30px;
                                                line-height: 19px;">
                                                <i class="fa fa-solid fa-gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end export-types  ">

                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start"><a
                                                            href="{{ route('admin.phishing.phishingcategory.getAll') }}">{{ __('locale.phishingcategory') }}</a></span>

                                                </span>
                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start"><a
                                                            href="{{ route('admin.phishing.groups.getAll') }}">{{ __('locale.employee_groups') }}</a></span>

                                                </span>
                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start"><a
                                                            href="{{ route('admin.phishing.domains.index') }}">{{ __('locale.verified_domains') }}</a></span>

                                                </span>

                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start"><a
                                                            href="{{ route('admin.phishing.campaign.Certificates') }}">{{ __('locale.certificates') }}</a></span>

                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    {{--  <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                        exportPermissionKey='asset.export'
                                        exportRouteKey='admin.asset_management.ajax.export'
                                        importRouteKey='admin.asset_management.import' />  --}}

                                    <a class="btn btn-primary" href="{{ route('admin.phishing.dashboard') }}"
                                        style="height: 30px;"> <i class="fa-solid fa-file-invoice"></i></a>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-6 pe-0" style="text-align: end;">
                                <div class="action-content">

                                    <a href="#" class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>

                                    {{--  <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>  --}}

                                    {{--  <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                        exportPermissionKey='asset.export'
                                        exportRouteKey='admin.asset_management.ajax.export'
                                        importRouteKey='admin.asset_management.import' />  --}}

                                    {{--  <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>  --}}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>



<section id="advanced-search-datatable">




    <div class="row">
        <div class="col-12">
            <div class="card p-3">

                @if (auth()->user()->hasPermission('campaign.list'))

                    <div class="row dashboard  widget-grid ">
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
                                            <h4 id="campaigns_count">{{ $campaigns_count }}</h4><span
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
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 id="campaigns_complete">{{ $campaigns_complete }}</h4><span
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
                                            <h4 id="campaigns_soon">{{ $campaigns_soon }}</h4><span
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
                                            <h4 id="campaigns_approve">{{ $campaigns_approve }}</h4><span
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
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 id="campaigns_pending">{{ $campaigns_pending }}</h4><span
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
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 id="campaigns_later">{{ $campaigns_later }}</h4><span
                                                class="f-light">{{ __('locale.ondemand_campaigns') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                @endif

                <hr>
                <ul class="nav nav-pills campaign-type mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <div class="nav-link">
                            <input type="radio" id="dsimulated_phishing_tab" name="campign_type"
                                value="simulated_phishing" checked>
                            <label for="dsimulated_phishing_tab">{{ __('locale.simulated_phishing') }} </label>
                        </div>
                    </li>
                    <li class="nav-item" role="presentation">
                        <div class="nav-link">
                            <input type="radio" id="security_awareness_tab" name="campign_type"
                                value="security_awareness">
                            <label for="security_awareness_tab">{{ __('locale.security_awareness') }} </label>
                        </div>
                    </li>
                    {{--  <li class="nav-item" role="presentation">
                        <div class="nav-link">
                            <input type="radio" id="simulated_phishing_and_security_awareness_tab" name="campign_type" value="simulated_phishing_and_security_awareness">
                            <label for="simulated_phishing_and_security_awareness_tab">Schedule Later</label>
                        </div>
                    </li>  --}}
                </ul>

                <div style="display: none" id="simulated_phishing">

                    <div class="card-datatable table-responsive">
                        <table class="dt-advanced-server-search-simulated table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('Campaign Name') }}</th>
                                    <th class="all">{{ __('Campaign type') }}</th>
                                    <th class="all">{{ __('Delivery Status') }}</th>
                                    <th class="all">{{ __('Scheduled Date') }}</th>
                                    <th class="all">{{ __('Scheduled Time') }}</th>
                                    <th class="all">{{ __('Next Delivery') }}</th>
                                    <th class="all">{{ __('status') }}</th>
                                    <th class="all">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('Campaign Name') }}</th>
                                    <th class="all">{{ __('Campaign type') }}</th>
                                    <th class="all">{{ __('Delivery Status') }}</th>
                                    <th class="all">{{ __('Scheduled Time') }}</th>
                                    <th class="all">{{ __('Scheduled Date') }}</th>
                                    <th class="all">{{ __('Next Delivery') }}</th>
                                    <th class="all">{{ __('status') }}</th>
                                    <th class="all">{{ __('Actions') }}</th>
                                </tr>
                            </tfoot> -->

                        </table>
                    </div>

                </div>
                <div style="display: none" id="security_awareness">

                    <div class="card-datatable table-responsive">
                        <table class="dt-advanced-server-search-security table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('Campaign Name') }}</th>
                                    <th class="all">{{ __('Campaign type') }}</th>
                                    <th class="all">{{ __('Delivery Status') }}</th>
                                    <th class="all">{{ __('Scheduled Date') }}</th>
                                    <th class="all">{{ __('Scheduled Time') }}</th>
                                    <th class="all">{{ __('Next Delivery') }}</th>
                                    <th class="all">{{ __('status') }}</th>
                                    <th class="all">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('Campaign Name') }}</th>
                                    <th class="all">{{ __('Campaign type') }}</th>
                                    <th class="all">{{ __('Delivery Status') }}</th>
                                    <th class="all">{{ __('Scheduled Time') }}</th>
                                    <th class="all">{{ __('Scheduled Date') }}</th>
                                    <th class="all">{{ __('Next Delivery') }}</th>
                                    <th class="all">{{ __('status') }}</th>
                                    <th class="all">{{ __('Actions') }}</th>
                                </tr>
                            </tfoot> -->

                        </table>
                    </div>

                </div>
                <div style="display: none" id="simulated_phishing_and_security_awareness">

                    <div class="card-datatable table-responsive">
                        <table class="dt-advanced-server-search-both table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('Campaign Name') }}</th>
                                    <th class="all">{{ __('Campaign type') }}</th>
                                    <th class="all">{{ __('Delivery Status') }}</th>
                                    <th class="all">{{ __('Scheduled Date') }}</th>
                                    <th class="all">{{ __('Scheduled Time') }}</th>
                                    <th class="all">{{ __('Next Delivery') }}</th>
                                    <th class="all">{{ __('status') }}</th>
                                    <th class="all">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('Campaign Name') }}</th>
                                    <th class="all">{{ __('Campaign type') }}</th>
                                    <th class="all">{{ __('Delivery Status') }}</th>
                                    <th class="all">{{ __('Scheduled Time') }}</th>
                                    <th class="all">{{ __('Scheduled Date') }}</th>
                                    <th class="all">{{ __('Next Delivery') }}</th>
                                    <th class="all">{{ __('status') }}</th>
                                    <th class="all">{{ __('Actions') }}</th>
                                </tr>
                            </tfoot> -->

                        </table>
                    </div>

                </div>


            </div>
        </div>
    </div>

</section>


<!-- Modal Employees Filter -->
<div class="modal fade bd-example-modal-xl" style="z-index: 999999999999999" tabindex="-1" role="dialog"
    aria-labelledby="addNewWebsiteModalLabel" aria-hidden="true" id="filter-employees-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewWebsiteModalLabel">Filter Selected Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <table class="table my-5">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col" class="all">{{ __('phishing.name') }}</th>
                            <th scope="col" class="all">{{ __('phishing.email') }}</th>
                            <th scope="col" class="all">{{ __('phishing.select') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal Email Template Data -->
<div class="modal fade" style="z-index: 99999999; top: 150px;" id="email-template-data-modal" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="email-tab" data-toggle="tab" href="#email" role="tab"
                            aria-controls="email" aria-selected="true">
                            <i class="fa fa-envelope"></i> {{ __('phishing.email') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="website-tab" data-toggle="tab" href="#website" role="tab"
                            aria-controls="website" aria-selected="false">
                            <i class="fa fa-globe"></i> {{ __('phishing.Website') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sender-profile-tab" data-toggle="tab" href="#sender-profile"
                            role="tab" aria-controls="sender-profile" aria-selected="false">
                            <i class="fa fa-id-card"></i>{{ __('phishing.Sender Profile') }}
                        </a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="" id="myTabContent">
                    <!-- Email Tab -->
                    <div class="tab-pane fade show active" id="email" role="tabpanel"
                        aria-labelledby="email-tab">
                        <div class="form-group">
                            <label for="phishingEmail">{{ __('phishing.Phishing Email') }}</label>
                            <input type="text" class="form-control" id="phishingEmail" readonly>
                        </div>
                        <div class="form-group">
                            <label for="emailSubject">{{ __('phishing.Email Subject') }}</label>
                            <input type="text" class="form-control" id="emailSubject" readonly>
                        </div>

                        <div class="form-group">
                            <label for="emailSubject" class="text-danger">Note: The below image is just a screenshot.
                                Click the screenshot to see the live email.</label>
                            <img src="path/to/image.png" id="openSimulatorModal" alt="Clickable Image"
                                style="cursor: pointer; width: 100%; height: 200px;" />
                        </div>
                    </div>

                    <!-- Website Tab -->
                    <div class="tab-pane fade" id="website" role="tabpanel" aria-labelledby="website-tab">
                        <div class="form-group my-3">
                            <label for="phishingWebsite">{{ __('phishing.Phishing Website') }}</label>
                            <input type="text" class="form-control" id="phishingWebsite" readonly>
                        </div>
                        <div class="form-group">
                            <label for="websiteURL">{{ __('phishing.Website URL') }}</label>
                            <input type="text" class="form-control" id="websiteURL" readonly>
                        </div>
                    </div>

                    <!-- Sender Profile Tab -->
                    <div class="tab-pane fade" id="sender-profile" role="tabpanel"
                        aria-labelledby="sender-profile-tab">
                        <div class="form-group my-3">
                            <label for="senderProfile">{{ __('phishing.Sender Profile') }}</label>
                            <input type="text" class="form-control" id="senderProfile" readonly>
                        </div>
                        <div class="form-group">
                            <label for="displayNameAddress">{{ __('phishing.Display Name and Address') }}</label>
                            <input type="text" class="form-control" id="displayNameAddress" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" disabled>{{ __('phishing.Update Bundle') }}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal For Mail simulation -->
<div class="modal fade" id="SimulatorModal" style="z-index: 99999999999;" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Inbox Simulator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="John">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Doe">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" class="form-control" id="emailAddress"
                                placeholder="john.doe@mybusiness.com">
                        </div>

                    </div>
                    <div class="row">
                        <!-- Side Menu -->
                        <div class="col-md-3">
                            <div class="side-menu">
                                <ul class="folders">
                                    <li class="folder-item">Inbox</li>
                                    <li class="folder-item">Starred</li>
                                    <li class="folder-item">Draft</li>
                                    <li class="folder-item">Sent Mail</li>
                                    <li class="folder-item">Spam</li>
                                    <li class="folder-item">Trash</li>
                                </ul>
                                <ul class="labels">
                                    <li class="label-item">Work</li>
                                    <li class="label-item">Business</li>
                                    <li class="label-item">Family</li>
                                    <li class="label-item">Friends</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="col-md-9">
                            <div class="email-display">
                                <h3 class="email-subject">test Freedom email subject</h3>
                                <div class="email-details">
                                    <span>pk ( ar@pksaudi[.]sa )</span>
                                    <span>to john[.]doe@mybusiness[.]com</span>
                                </div>
                                {{-- <textarea class="form-control" rows="10" id="email-subject"></textarea> --}}
                                <input type="hidden" id="email-template-id" />
                                <input type="hidden" id="email-website-url" />
                                <textarea class="form-control" placeholder="body" id="editor1" rows="10" required="required"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Email Website Filter -->
<div class="modal fade bd-example-modal-xl" style="z-index: 9999999999999999" tabindex="-1" role="dialog"
    aria-labelledby="addNewWebsiteModalLabel" aria-hidden="true" id="email-website-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewWebsiteModalLabel">Website</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <div class="form-group">
                    <img src="path/to/image.png" id="email-website-url-modal" alt="Clickable Image"
                        style="cursor: pointer; width: 100%; height: 200px;" />
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-campaign-form id="add-new-senderProfile" title="{{ __('locale.AddANewCampaign') }}" :emailtemplate="$emailtemplate"
    :employees="$employees" :courses="$courses" :levels="$levels" :levels="$levels" :trainingModules="$trainingModules" />

{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-campaign-form id="edit-regulator" title="{{ __('locale.EditCampaign') }}" :emailtemplate="$emailtemplate"
    :employees="$employees" :courses="$courses" :levels="$levels" :trainingModules="$trainingModules" />
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
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>



<script>
    var table = $('.dt-advanced-server-search-simulated').DataTable({
        lengthChange: true,
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.phishing.campaign.Datatable', ':type') }}'.replace(':type',
                'simulated_phishing'),
        },
        language: {
            // ... your language settings
        },
        columns: [{
                name: "index",
                data: "DT_RowIndex",
                sortable: false,
                searchable: false, // Set to false since this column is not searchable
                orderable: false
            },
            {
                name: "campaign_name",
                data: "campaign_name"
            },
            {
                name: "campaign_type", // Use the actual column name in your database
                data: "campaign_type",
                searchable: true
            },

            {
                name: "delivery_status", // Use the actual column name in your database
                data: "delivery_status",
                searchable: true
            },

            {
                name: "schedule_date_from", // Use the actual column name in your database
                data: "schedule_date_from",
                searchable: true
            },

            {
                name: "schedule_time_from", // Use the actual column name in your database
                data: "schedule_time_from",
                searchable: true
            },

            {
                name: "schedule_time_to", // Use the actual column name in your database
                data: "schedule_time_to",
                searchable: true
            },
            {
                name: "status", // Use the actual column name in your database
                data: "status",
                searchable: true
            },


            {
                name: "actions",
                data: "actions",
                searchable: false // Set to false since this column is not searchable
            }
        ],
    });
    var table = $('.dt-advanced-server-search-security').DataTable({
        lengthChange: true,
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.phishing.campaign.Datatable', ':type') }}'.replace(':type',
                'security_awareness'),
        },
        language: {
            // ... your language settings
        },
        columns: [{
                name: "index",
                data: "DT_RowIndex",
                sortable: false,
                searchable: false, // Set to false since this column is not searchable
                orderable: false
            },
            {
                name: "campaign_name",
                data: "campaign_name"
            },
            {
                name: "campaign_type", // Use the actual column name in your database
                data: "campaign_type",
                searchable: true
            },

            {
                name: "delivery_status", // Use the actual column name in your database
                data: "delivery_status",
                searchable: true
            },

            {
                name: "schedule_date_from", // Use the actual column name in your database
                data: "schedule_date_from",
                searchable: true
            },

            {
                name: "schedule_time_from", // Use the actual column name in your database
                data: "schedule_time_from",
                searchable: true
            },

            {
                name: "schedule_time_to", // Use the actual column name in your database
                data: "schedule_time_to",
                searchable: true
            },
            {
                name: "status", // Use the actual column name in your database
                data: "status",
                searchable: true
            },


            {
                name: "actions",
                data: "actions",
                searchable: false // Set to false since this column is not searchable
            }
        ],
    });
    var table = $('.dt-advanced-server-search-both').DataTable({
        lengthChange: true,
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.phishing.campaign.Datatable', ':type') }}'.replace(':type',
                'simulated_phishing_and_security_awareness'),
        },
        language: {
            // ... your language settings
        },
        columns: [{
                name: "id",
                data: "id",
                sortable: false,
                searchable: false, // Set to false since this column is not searchable
                orderable: false
            },
            {
                name: "campaign_name",
                data: "campaign_name"
            },
            {
                name: "campaign_type", // Use the actual column name in your database
                data: "campaign_type",
                searchable: true
            },

            {
                name: "delivery_status", // Use the actual column name in your database
                data: "delivery_status",
                searchable: true
            },

            {
                name: "schedule_date_from", // Use the actual column name in your database
                data: "schedule_date_from",
                searchable: true
            },

            {
                name: "schedule_time_from", // Use the actual column name in your database
                data: "schedule_time_from",
                searchable: true
            },

            {
                name: "schedule_time_to", // Use the actual column name in your database
                data: "schedule_time_to",
                searchable: true
            },
            {
                name: "status", // Use the actual column name in your database
                data: "status",
                searchable: true
            },


            {
                name: "actions",
                data: "actions",
                searchable: false // Set to false since this column is not searchable
            }
        ],
    });
</script>
@endsection

@section('page-script')
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

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>


<script src="{{ asset('new_d/js/form-wizard/campaign-form-wizard.js') }}"></script>
<script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>

{{--  <script src="{{ asset('new_d/js/bootstrap/bootstrap11.min.js')}}"></script>  --}}
<script src="{{ asset('new_d/js/modal.bundle.js') }}"></script>


<script>
    $(document).ready(function() {
        // Show the div corresponding to the initially selected radio button
        $('input[name="campign_type"]:checked').each(function() {
            var target = '#' + $(this).val(); // Get the id of the div to display
            $(target).show(); // Show the corresponding div
        });

        // Set up a listener for changes to the radio buttons
        $('input[name="campign_type"]').change(function() {
            // Hide all divs
            $('#simulated_phishing, #security_awareness, #simulated_phishing_and_security_awareness')
                .hide();

            // Get the id from the selected radio button's value
            var target = '#' + $(this).val();

            // Show the div corresponding to the selected radio button
            $(target).show();
        });
    });
</script>
<script>
    function updateWizardSteps(campaignType) {
        $('.stepper-five').hide();
        $('#form-step-five').hide();
        switch (campaignType) {
            case 'simulated_phishing':
                $('.stepper-one, .stepper-two, .stepper-three, .stepper-four').addClass('step').show();
                $('.stepper-five').hide().removeClass('step');

                $('#form-step-two').hide();
                $('#form-step-three').hide();
                $('#form-step-four').hide();
                $('#form-step-five').hide();

                break;
            case 'security_awareness':
                $('.stepper-one, .stepper-five, .stepper-four').addClass('step').show();
                $('.stepper-two, .stepper-three').hide().removeClass('step');

                $('#form-step-two').hide();
                $('#form-step-three').hide();
                $('#form-step-four').hide();
                $('#form-step-five').hide();

                break;
            case 'simulated_phishing_and_security_awareness':
                $('.stepper-one, .stepper-two, .stepper-three, .stepper-four, .stepper-five').addClass('step').show();
                $('#form-step-two').hide();
                $('#form-step-three').hide();
                $('#form-step-four').hide();
                $('#form-step-five').hide();

                break;
            default:
                console.error('Invalid campaign type');
        }

        $('.step-circle:visible span').each(function(index) {
            $(this).html(index + 1);
        });
    }

    $(document).on('change', '#type_of_campaign', function() {
        updateWizardSteps($(this).val());
    })

    $(document).ready(function() {
        // $('.selected_course').select2();
        // $('.selected_course_levels').select2();
        updateWizardSteps($('#type_of_campaign').val());
    });



    function moveSelected(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var selectedOptions = Array.from(fromList.selectedOptions);
        selectedOptions.forEach(option => {
            toList.appendChild(option);
        });

        listFilteredEmployee();
    }

    function moveAll(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var allOptions = Array.from(fromList.options);
        allOptions.forEach(option => {
            toList.appendChild(option);
        });
        listFilteredEmployee();
    }


    function resetMoveAll(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var allOptions = Array.from(fromList.options);
        allOptions.forEach(option => {
            toList.appendChild(option);
        });
    }

    function validateStep() {

        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });
        if (activeForm.length === 0) {
            console.log('No form is currently visible.');
            return;
        }

        var campaign_id = $('.form-campaign-id').val();
        var type_of_campaign = $('#type_of_campaign').val();


        if (campaign_id) {
            var formId = activeForm.attr('id');
            var formData = new FormData(activeForm[0]);
            formData.append('formStep', formId)
            formData.append('campaign_type', type_of_campaign)
            let checkedEmployees = $('input[type=checkbox][name="checkedEmployees[]"]:checked')
                .map(function() {
                    return $(this).val();
                }).get();

            if (checkedEmployees.length > 0) {
                checkedEmployees.forEach(function(employee) {
                    formData.append('checkedEmployees[]', employee);
                });
            }


            var campaign_id = $('.form-campaign-id').val();

            var url = "{{ route('admin.phishing.campaign.validateEditFirstStep', '') }}" + "/" + campaign_id;
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.stepThreeNow == true) {
                        console.log(data.sessionCampaign.delivery_type)
                        $('#phishingBundlesContainer').empty();
                        $('#training-module-section').css('display', 'none');
                        $('#simulated-phishing-case').css('display', 'none');

                        $('#campaignName').val(data.sessionCampaign.campaign_name);
                        $('#campaignType').val(data.sessionCampaign.campaign_type);
                        //    $('#training_frequency_data').val(data.sessionCampaign.training_frequency);
                        //$('select[name=training_frequency][value="' + data.sessionCampaign.training_frequency + '"]').prop('selected', true);
                        $('input[type=radio][name=delivery_type][value="' + data.sessionCampaign.delivery_type +
                                '"]')
                            .prop('checked', true);
                        $('#scheduleDays').val(data.sessionCampaign.schedule_date_from + '-' + data.sessionCampaign
                            .schedule_date_to);
                        $('#scheduleFromTime').val(data.sessionCampaign.schedule_time_from);
                        $('#scheduleToTime').val(data.sessionCampaign.schedule_time_to);
                        $('#expireAfter').val(data.sessionCampaign.expire_after);
                        $('input[type=radio][name=campaign_frequency][value="' + data.sessionCampaign
                            .campaign_frequency + '"]').prop('checked', true);

                        if (data.sessionCampaign.campaign_type == 'security_awareness') {
                            console.log(data.sessionCampaign.campaign_type)
                            $('#training-module-section').css('display', 'block');
                            $('#simulated-phishing-case').css('display', 'none');
                        } else {
                            console.log(data.sessionCampaign.campaign_type)
                            $('#training-module-section').css('display', 'none');
                            $('#simulated-phishing-case').css('display', 'block');
                        }
                        if (data.sessionCampaign.delivery_type === "setup") {
                            $('.schedual-data').show();
                        } else {
                            $('.schedual-data').hide();
                        }

                        if (data.sessionCampaign.email_templates) {
                            data.sessionCampaign.email_templates.forEach(templateId => {
                                let templateName = null;
                                let websiteName = null;
                                let senderProfileName = null;

                                let url = "{{ route('admin.phishing.emailTemplate.edit', ':id') }}"
                                    .replace(
                                        ':id', templateId);
                                fetch(url, {
                                        method: 'GET',
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        templateName = data.EmailTemplate.name;
                                        websiteName = data.EmailTemplate.website.name;
                                        senderProfileName = data.EmailTemplate.sender_profile.name;
                                        let phishingBundleHtml = `
                                    <div class="form-group row">
                                        <h4 class="col-sm-12 col-form-label">Phishing Bundle</h4>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phishingEmail" class="col-sm-2 col-form-label">Phishing Email</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="phishingEmail" disabled>
                                                <option selected>${templateName}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phishingWebsite" class="col-sm-2 col-form-label">Phishing Website</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="phishingWebsite" disabled>
                                                <option selected>${websiteName}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="senderProfile" class="col-sm-2 col-form-label">Sender Profile</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="senderProfile" disabled>
                                                <option selected>${senderProfileName}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-3">

                                `;
                                        // $('#simulated-phishing-case').css('display', 'block');
                                        $('#phishingBundlesContainer').append(phishingBundleHtml);

                                    }).catch(error => {
                                        console.log('Error:', error);
                                    });
                            });
                        }

                        // case of training module data founded
                        if (data.sessionCampaign.campaign_type == 'security_awareness' || data.sessionCampaign
                            .campaign_type == 'simulated_phishing_and_security_awareness') {
                            $('#training-module-section').empty();
                            $('#training-module-section').append(`
                            <div class="form-group row">
                                <label for="training frequency" class="col-sm-2 col-form-label">Days Until Due</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="" disabled name="">
                                        <option>${data.sessionCampaign.days_until_due}</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="my-3">

                        `)

                            data.sessionCampaign.training_modules.forEach(train_id => {
                                let url = "{{ route('admin.lms.trainingModules.show', ':id') }}".replace(
                                    ':id', train_id);
                                fetch(url, {
                                        method: 'GET',
                                    })
                                    .then(response => response.json())
                                    .then(trainData => {
                                        $('#training-module-section').append(`
                                     <div class="form-group row">
                                        <label for="training name" class="col-sm-2 col-form-label">Training Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="training-module-name" value="${trainData.training_module.name}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="level name" class="col-sm-2 col-form-label">Level Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="training-module-level-name" value="${trainData.training_module.level.title}" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="course name" class="col-sm-2 col-form-label">Course Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="training-module-course-name" value="${trainData.training_module.level.course.title}" disabled>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                `);
                                    }).catch(error => {
                                        console.log('Error:', error);
                                    });
                            });
                            // $('#training-module-section').css('display', 'block')
                            // $('#simulated-phishing-case').css('display','none');
                        }
                    }


                    if (data.createdSuccessfully == true) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        window.location.reload();
                    }

                    if (data.errors) {
                        $('.error').empty();
                        $.each(data.errors, function(key, value) {
                            $('.error-' + key).text(value[0]);
                        });

                    } else {
                        {{--  $('#nextbtn').attr("onclick", "validateEditStep();");  --}}
                        nextStep();
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                });

        } else {
            var formId = activeForm.attr('id');
            var formData = new FormData(activeForm[0]);
            formData.append('formStep', formId)

            let checkedEmployees = $('input[type=checkbox][name="checkedEmployees[]"]:checked')
                .map(function() {
                    return $(this).val();
                }).get();

            if (checkedEmployees.length > 0) {
                checkedEmployees.forEach(function(employee) {
                    formData.append('checkedEmployees[]', employee);
                });
            }

            fetch('{{ route('admin.phishing.campaign.validateFirstStep') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    if (data.stepThreeNow == true) {
                        $('#phishingBundlesContainer').empty();
                        $('#training-module-section').css('display', 'none');
                        $('#simulated-phishing-case').css('display', 'none');

                        $('#campaignName').val(data.sessionCampaign.campaign_name);
                        $('#campaignType').val(data.sessionCampaign.campaign_type);
                        //    $('#training_frequency_data').val(data.sessionCampaign.training_frequency);
                        //$('select[name=training_frequency][value="' + data.sessionCampaign.training_frequency + '"]').prop('selected', true);
                        $('input[type=radio][name=delivery_type][value="' + data.sessionCampaign.delivery_type +
                                '"]')
                            .prop('checked', true);
                        $('#scheduleDays').val(data.sessionCampaign.schedule_date_from + '-' + data.sessionCampaign
                            .schedule_date_to);
                        $('#scheduleFromTime').val(data.sessionCampaign.schedule_time_from);
                        $('#scheduleToTime').val(data.sessionCampaign.schedule_time_to);
                        $('#expireAfter').val(data.sessionCampaign.expire_after);
                        $('input[type=radio][name=campaign_frequency][value="' + data.sessionCampaign
                            .campaign_frequency + '"]').prop('checked', true);

                        if (data.sessionCampaign.campaign_type == 'security_awareness') {
                            $('#training-module-section').css('display', 'block');
                            $('#simulated-phishing-case').css('display', 'none');
                        } else {
                            $('#training-module-section').css('display', 'none');
                            $('#simulated-phishing-case').css('display', 'block');
                        }
                        if (data.sessionCampaign.delivery_type === "setup") {
                            $('.schedual-data').show();
                        } else {
                            $('.schedual-data').hide();
                        }

                        if (data.sessionCampaign.email_templates) {
                            data.sessionCampaign.email_templates.forEach(templateId => {
                                let templateName = null;
                                let websiteName = null;
                                let senderProfileName = null;

                                let url = "{{ route('admin.phishing.emailTemplate.edit', ':id') }}"
                                    .replace(
                                        ':id', templateId);
                                fetch(url, {
                                        method: 'GET',
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        templateName = data.EmailTemplate.name;
                                        websiteName = data.EmailTemplate.website.name;
                                        senderProfileName = data.EmailTemplate.sender_profile.name;
                                        let phishingBundleHtml = `
                                    <div class="form-group row">
                                        <h4 class="col-sm-12 col-form-label">Phishing Bundle</h4>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phishingEmail" class="col-sm-2 col-form-label">Phishing Email</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="phishingEmail" disabled>
                                                <option selected>${templateName}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phishingWebsite" class="col-sm-2 col-form-label">Phishing Website</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="phishingWebsite" disabled>
                                                <option selected>${websiteName}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="senderProfile" class="col-sm-2 col-form-label">Sender Profile</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="senderProfile" disabled>
                                                <option selected>${senderProfileName}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-3">

                                `;
                                        // $('#simulated-phishing-case').css('display', 'block');
                                        $('#phishingBundlesContainer').append(phishingBundleHtml);

                                    }).catch(error => {
                                        console.log('Error:', error);
                                    });
                            });
                        }

                        // case of training module data founded
                        if (data.sessionCampaign.campaign_type == 'security_awareness' || data.sessionCampaign
                            .campaign_type == 'simulated_phishing_and_security_awareness') {
                            $('#training-module-section').empty();
                            $('#training-module-section').append(`
                            <div class="form-group row">
                                <label for="training frequency" class="col-sm-2 col-form-label">Days Until Due</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="" disabled name="">
                                        <option>${data.sessionCampaign.days_until_due}</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="my-3">

                        `)

                            data.sessionCampaign.training_modules.forEach(train_id => {
                                let url = "{{ route('admin.lms.trainingModules.show', ':id') }}".replace(
                                    ':id', train_id);
                                fetch(url, {
                                        method: 'GET',
                                    })
                                    .then(response => response.json())
                                    .then(trainData => {
                                        $('#training-module-section').append(`
                                     <div class="form-group row">
                                        <label for="training name" class="col-sm-2 col-form-label">Training Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="training-module-name" value="${trainData.training_module.name}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="level name" class="col-sm-2 col-form-label">Level Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="training-module-level-name" value="${trainData.training_module.level.title}" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="course name" class="col-sm-2 col-form-label">Course Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="training-module-course-name" value="${trainData.training_module.level.course.title}" disabled>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                `);
                                    }).catch(error => {
                                        console.log('Error:', error);
                                    });
                            });
                            // $('#training-module-section').css('display', 'block')
                            // $('#simulated-phishing-case').css('display','none');
                        }
                    }

                    if (data.createdSuccessfully == true) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        window.location.reload();
                    }

                    if (data.errors) {
                        $('.error').empty();
                        $.each(data.errors, function(key, value) {
                            $('.error-' + key).text(value[0]);
                        });

                    } else {
                        nextStep();
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                });

        }



    }

    {{--  function validateEditStep() {



        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        if (activeForm.length === 0) {
            console.log('No form is currently visible.');
            return;
        }

        var formId = activeForm.attr('id');
        var formData = new FormData(activeForm[0]);
        formData.append('formStep', formId)

        let checkedEmployees = $('input[type=checkbox][name="checkedEmployees[]"]:checked')
            .map(function() {
                return $(this).val();
            }).get();

        if (checkedEmployees.length > 0) {
            checkedEmployees.forEach(function(employee) {
                formData.append('checkedEmployees[]', employee);
            });
        }


        var campaign_id = $('.form-campaign-id').val();
        var url = "{{ route('admin.phishing.campaign.validateEditFirstStep', '') }}" + "/" +campaign_id;
        fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {


                if (data.stepThreeNow == true) {
                    $('#phishingBundlesContainer').empty();
                    $('#training-module-section').css('display', 'none');
                    $('#simulated-phishing-case').css('display', 'none');

                    $('#campaignName').val(data.sessionCampaign.campaign_name);
                    $('#campaignType').val(data.sessionCampaign.campaign_type);
                    //    $('#training_frequency_data').val(data.sessionCampaign.training_frequency);
                    //$('select[name=training_frequency][value="' + data.sessionCampaign.training_frequency + '"]').prop('selected', true);
                    $('input[type=radio][name=delivery_type][value="' + data.sessionCampaign.delivery_type + '"]')
                        .prop('checked', true);
                    $('#scheduleDays').val(data.sessionCampaign.schedule_date_from + '-' + data.sessionCampaign
                        .schedule_date_to);
                    $('#scheduleFromTime').val(data.sessionCampaign.schedule_time_from);
                    $('#scheduleToTime').val(data.sessionCampaign.schedule_time_to);
                    $('#expireAfter').val(data.sessionCampaign.expire_after);
                    $('input[type=radio][name=campaign_frequency][value="' + data.sessionCampaign
                        .campaign_frequency + '"]').prop('checked', true);

                    if(data.sessionCampaign.campaign_type == 'security_awareness'){
                        console.log(data.sessionCampaign.campaign_type)
                        $('#training-module-section').css('display', 'block');
                        $('#simulated-phishing-case').css('display', 'none');
                    }else{
                        console.log(data.sessionCampaign.campaign_type)
                        $('#training-module-section').css('display', 'none');
                        $('#simulated-phishing-case').css('display', 'block');
                    }

                    if (data.sessionCampaign.email_templates) {
                        data.sessionCampaign.email_templates.forEach(templateId => {
                            let templateName = null;
                            let websiteName = null;
                            let senderProfileName = null;

                            let url = "{{ route('admin.phishing.emailTemplate.edit', ':id') }}".replace(
                                ':id', templateId);
                            fetch(url, {
                                    method: 'GET',
                                })
                                .then(response => response.json())
                                .then(data => {
                                    templateName = data.EmailTemplate.name;
                                    websiteName = data.EmailTemplate.website.name;
                                    senderProfileName = data.EmailTemplate.sender_profile.name;
                                    let phishingBundleHtml = `
                                <div class="form-group row">
                                    <h4 class="col-sm-12 col-form-label">Phishing Bundle</h4>
                                </div>

                                <div class="form-group row">
                                    <label for="phishingEmail" class="col-sm-2 col-form-label">Phishing Email</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="phishingEmail" disabled>
                                            <option selected>${templateName}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phishingWebsite" class="col-sm-2 col-form-label">Phishing Website</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="phishingWebsite" disabled>
                                            <option selected>${websiteName}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="senderProfile" class="col-sm-2 col-form-label">Sender Profile</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="senderProfile" disabled>
                                            <option selected>${senderProfileName}</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="my-3">

                            `;
                                    // $('#simulated-phishing-case').css('display', 'block');
                                    $('#phishingBundlesContainer').append(phishingBundleHtml);

                                }).catch(error => {
                                    console.log('Error:', error);
                                });
                        });
                    }

                    // case of training module data founded
                    if (data.sessionCampaign.campaign_type == 'security_awareness' || data.sessionCampaign
                        .campaign_type == 'simulated_phishing_and_security_awareness') {
                        $('#training-module-section').empty();
                        $('#training-module-section').append(`
                        <div class="form-group row">
                            <label for="training frequency" class="col-sm-2 col-form-label">Days Until Due</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="" disabled name="">
                                    <option>${data.sessionCampaign.days_until_due}</option>
                                </select>
                            </div>
                        </div>
                        <hr class="my-3">

                    `)

                        data.sessionCampaign.training_modules.forEach(train_id => {
                            let url = "{{ route('admin.lms.trainingModules.show', ':id') }}".replace(
                                ':id', train_id);
                            fetch(url, {
                                    method: 'GET',
                                })
                                .then(response => response.json())
                                .then(trainData => {
                                    $('#training-module-section').append(`
                                 <div class="form-group row">
                                    <label for="training name" class="col-sm-2 col-form-label">Training Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="training-module-name" value="${trainData.training_module.name}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="level name" class="col-sm-2 col-form-label">Level Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="training-module-level-name" value="${trainData.training_module.level.title}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="course name" class="col-sm-2 col-form-label">Course Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="training-module-course-name" value="${trainData.training_module.level.course.title}" disabled>
                                    </div>
                                </div>
                                <hr class="my-3">
                            `);
                                }).catch(error => {
                                    console.log('Error:', error);
                                });
                        });
                        // $('#training-module-section').css('display', 'block')
                        // $('#simulated-phishing-case').css('display','none');
                    }
                }

                if (data.createdSuccessfully == true) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    window.location.reload();
                }

                if (data.errors) {
                    $('.error').empty();
                    $.each(data.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });

                } else {

                    nextStep();
                }
            })
            .catch(error => {
                console.log('Error:', error);
            });
    }  --}}

    $(document).on('change', 'input[type=radio][name=delivery_type]', function() {
        if ($(this).val() == 'setup') {
            $('#block-of-setup').css('display', 'block')
        } else {
            $('#block-of-setup').css('display', 'none')
        }

        if ($(this).val() == 'later') {
            $('#campaign-frequency-section').css('display', 'none')
        } else {
            $('#campaign-frequency-section').css('display', 'block')
        }
    })

    $(document).on('change', 'input[type=radio][name=campaign_frequency]', function() {
        if ($(this).val() == 'oneOf') {
            $('#expire-after-section').css('display', 'none')
        } else {
            $('#expire-after-section').css('display', 'block')
        }
    })

    $(document).ready(function() {

        CKEDITOR.replace('editor1', {
            on: {
                contentDom: function(evt) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on('contextmenu', function(contextEvent) {
                        var path = evt.editor.elementPath();

                        if (!path.contains('table')) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5);
                }
            }
        });
    });

    // filter-employees
    $(document).on('click', '#filter-employees', function() {
        $('#filter-employees-modal').modal('show')
    })

    $(document).on('change', '.checkedEmployees', function() {
        if ($(this).is(':checked')) {
            $(this).attr('checked', true);
        } else {
            $(this).attr('checked', false);
        }
    })

    function listFilteredEmployee() {
        // let selectedEmployees = $('#selected_employees').val();
        // if (selectedEmployees.length == 0) {
        //     return
        // }

        let selectedEmployees = [];
        $('#selected_employees option').each(function() {
            selectedEmployees.push($(this).val());
        });

        $.ajax({
            type: 'POST',
            data: {
                selectedEmployees: selectedEmployees,
            },
            url: "{{ route('admin.phishing.campaign.employees') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#filter-employees-modal table tbody').html('');
                let employees = response.employees;
                let tbody = '';

                employees.forEach(function(employee) {
                    tbody += `
                        <tr>
                            <th>${employee.id}</th>
                            <th class="all">${employee.name}</th>
                            <th class="all">${employee.email}</th>
                            <th class="all">
                                <input type="checkbox" class="checkedEmployees" checked name="checkedEmployees[]" value="${employee.id}" />
                            </th>
                        </tr>
                    `;
                });
                $('#filter-employees-modal table tbody').append(tbody);
                $('#filter-employees-modal').modal('show')
            },
            error: function(error) {
                alert(error.error);
            }
        })
    }

    function openEmailTemplate(id) {
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.phishing.campaign.emailTemplateData', ':id') }}".replace(':id', id),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                console.log(response);
                $('#exampleModalLabel').text(response.EmailTemplate.name);
                // $('#exampleModalLabel').html(response.EmailTemplate.name);
                $('#phishingEmail').val(response.EmailTemplate.name);
                $('#emailSubject').val(response.EmailTemplate.subject);
                $('#phishingWebsite').val(response.EmailTemplate.website?.name);
                $('#websiteURL').val(response.EmailTemplate.website?.website_url);
                $('#senderProfile').val(response.EmailTemplate.sender_profile?.name);
                if (response.EmailTemplate.sender_profile.website_domain_id) {
                    $('#displayNameAddress').val(response.EmailTemplate.sender_profile?.from_address_name +
                        response.EmailTemplate.sender_profile?.domain?.name);
                } else {
                    $('#displayNameAddress').val(response.EmailTemplate.sender_profile?.from_address_name);
                }

                // image
                $('#openSimulatorModal').attr('src', response.EmailTemplate.website?.website_url);
                $('#email-template-id').val(response.EmailTemplate.id);
                $('#email-website-url').val(response.EmailTemplate.website?.website_url);


                // other simultion email modal
                // $('#email-subject').text(response.EmailTemplate.subject)
                CKEDITOR.instances.editor1.setData(response.EmailTemplate.body);


                $('#email-template-data-modal').modal('show')
            },
            error: function(error) {
                alert(error.error);
            }
        })
    }

    $(document).on('click', '#openSimulatorModal', function() {
        $('#SimulatorModal').modal('show');
    })

    CKEDITOR.instances['editor1'].on('contentDom', function() {
        var editor = this;
        editor.editable().on('click', function(event) {
            console.log('clicked')
            var element = event.data.getTarget();
            if (element.is('a')) {
                var href = element.getAttribute('href');
                var websiteUrl = $('#email-website-url').val();

                if (href && href.includes('{PhishWebsitePage}')) {
                    event.data.preventDefault();
                    $('#email-website-url-modal').attr('src', websiteUrl)
                    $('#email-website-modal').modal('show');
                } else {
                    window.open(href, '_blank');
                }
            }
        });
    });

    $(document).on('click', '.edit-regulator', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.phishing.campaign.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(response) {


                $('.form-campaign-id').val(id);
                $('.form-title').text('Edit Campaign');
                {{--  $('#nextbtn').attr("onclick", "validateEditStep();");  --}}

                var editForm = $("#msform #form-step-one");
                editForm.find('input[name="id"]').val(response.data.id);
                editForm.find('input[name="campaign_name"]').val(response.data.campaign_name);
                editForm.find('select[name="campaign_type"]').val(response.data.campaign_type).attr(
                    'disabled', true);
                editForm.append(
                    `<input type="hidden" name="campaign_type" value="${response.data.campaign_type}">`
                );

                editForm.find('input[name="training_frequency"]').val(response.data
                    .training_frequency);
                editForm.find('select[name="campaign_type"]')
                    .val(response.data.campaign_type)
                    .attr('disabled', true)
                    .trigger('change'); // 🔹 Trigger the event here



                // Check if response.employees is a JSON string and parse it
                if (typeof response.data.employees === 'string') {
                    response.data.employees = JSON.parse(response.data.employees);
                }

                // Convert employees to an array if it's not already
                if (!Array.isArray(response.data.employees)) {
                    response.data.employees = Object.values(response.data.employees);
                }

                if (Array.isArray(response.data.employees)) {
                    var employeesHtml = '';

                    // Iterate over each employee and build the HTML for checkboxes
                    response.data.employees.forEach(function(employee) {
                        $('#selected_employees').append('<option value="' + employee.id +
                            '" selected >' + employee.name + '</option>')

                        tbody = `
                        <tr>
                            <th>${employee.id}</th>
                            <th class="all">${employee.name}</th>
                            <th class="all">${employee.email}</th>
                            <th class="all">
                                <input type="checkbox" class="checkedEmployees" checked name="checkedEmployees[]" value="${employee.id}" />
                            </th>
                        </tr>
                    `;

                        $('#filter-employees-modal table tbody').append(tbody);
                    });


                }

                response.data.email_templates.forEach(function(template) {
                    // Use the template ID to find the corresponding checkbox and check it
                    $('#checkbox-' + template.id).prop('checked', true);
                });

                $("input[name='delivery_type'][value='" + response.data.delivery_type + "']").prop(
                    'checked', true);



                if (response.data.delivery_type === 'setup') {
                    $('#block-of-setup').show();
                    $('#schedule-date-from').val(response.data.schedule_date_from);
                    $('#schedule-date-to').val(response.data.schedule_date_to);
                    $('#schedule-time-from').val(response.data.schedule_time_from);
                    $('#schedule-time-to').val(response.data.schedule_time_to);
                } else {
                    $('#block-of-setup').hide();
                }


                $('.dtr-bs-modal').modal('hide');
                $('#add-new-senderProfile').modal('show');

            },
            error: function(response) {
                console.log('Error: ' + response.error);
            }
        })

    });

    $(document).on('click', '#add-new-senderProfile', function() {
        $('.form-title').text('Add Campaign');
        $('#nextbtn').attr("onclick", "validateStep();");
        $('#add-new-senderProfile').modal('show');
    });

    // Submit form for creating asset
    $('#add-new-senderProfile form').submit(function(e) {
        e.preventDefault();
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
                    $('#add-new-senderProfile').modal('hide');
                    // location.reload();
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $('#domains-parent-div').append(data.newSenderProfileTemplate);

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
        let url = "{{ route('admin.phishing.campaign.update', ':id') }}";
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
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
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



    function TrashSenderProfile(id) {
        let url = "{{ route('admin.phishing.campaign.trash', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    console.log('MAnnar kdsmkdmskdmskm kmdksmdksmkdms kmdksmdkskmds ')
                    // $('.dt-advanced-server-search').DataTable().ajax.reload();
                    // $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $('.dt-advanced-server-search-simulated').DataTable().ajax.reload()
                    $('.dt-advanced-server-search-security').DataTable().ajax.reload()
                    $('.dt-advanced-server-search-both').DataTable().ajax.reload()

                    $(`.domain-card[data-id="${id}"]`).remove();

                    $('#campaigns_count').html(data.campaigns_data.campaigns_count)
                    $('#campaigns_complete').html(data.campaigns_data.campaigns_complete)
                    $('#campaigns_soon').html(data.campaigns_data.campaigns_soon)
                    $('#campaigns_approve').html(data.campaigns_data.campaigns_approve)
                    $('#campaigns_pending').html(data.campaigns_data.campaigns_pending)
                    $('#campaigns_later').html(data.campaigns_data.campaigns_later)

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function ApproveCampaign(id) {
        let url = "{{ route('admin.phishing.campaign.approve', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.dt-advanced-server-search-simulated').DataTable().ajax.reload()
                    $('.dt-advanced-server-search-security').DataTable().ajax.reload()
                    $('.dt-advanced-server-search-both').DataTable().ajax.reload()
                    $(`.domain-card[data-id="${id}"]`).remove();

                    $('#campaigns_count').html(data.campaigns_data.campaigns_count)
                    $('#campaigns_complete').html(data.campaigns_data.campaigns_complete)
                    $('#campaigns_soon').html(data.campaigns_data.campaigns_soon)
                    $('#campaigns_approve').html(data.campaigns_data.campaigns_approve)
                    $('#campaigns_pending').html(data.campaigns_data.campaigns_pending)
                    $('#campaigns_later').html(data.campaigns_data.campaigns_later)

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function SendCampaignEmails(id) {
        let url = "{{ route('admin.phishing.campaign.sendLaterMail', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    // $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $('.dt-advanced-server-search-simulated').DataTable().ajax.reload()
                    $('.dt-advanced-server-search-security').DataTable().ajax.reload()
                    $('.dt-advanced-server-search-both').DataTable().ajax.reload()
                    $(`.domain-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }



    // Show delete alert modal
    function ShowModalDeleteDomain(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToTrashThisRecord') }}",
            {{--  text: '@lang('locale.YouWontBeAbleToRevertThis')',  --}}
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmTrash') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                TrashSenderProfile(id);
            }
        });
    }

    // Show delete alert modal
    function ShowModalApproveCampaign(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToApproveThisCampaign') }}",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.Confirm') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                ApproveCampaign(id);
            }
        });
    }

    function ShowModalSendMails(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToSendMail') }}",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.Confirm') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                SendCampaignEmails(id);
            }
        });
    }

    // Reset form
    function resetFormData(form) {
        // reset campaign data
        updateWizardSteps('simulated_phishing');
        $('.step').removeClass('done');
        // form.find('#selected_employees').empty();
        resetMoveAll('selected_employees', 'available_employees')
        form.find('select[name="campaign_type"]').attr('disabled', false);

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
        if ($(this).attr('id') != "filter-employees-modal") {
            resetFormData($(this).find('form'));
        }
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

    $(document).on('change', "input[name='type']", function() {
        console.log($(this).val())
        let typeValue = $("input[name='type']:checked").val();
        if (typeValue == 'own') {
            $('#website_domain_id_div').css('display', 'none');
            $('#website_from_address_name_div').removeClass('col-6').addClass('col-12');
            $('#website_domain_id').attr('required', false)
        } else {
            $('#website_domain_id_div').css('display', 'block');
            $('#website_from_address_name_div').removeClass('col-12').addClass('col-6');
            $('#website_domain_id').attr('required', true)
        }
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

    $(document).ready(function() {

        let labelColor, headingColor, borderColor;


        labelColor = config.colors_dark.textMuted;
        headingColor = config.colors_dark.headingColor;
        borderColor = config.colors_dark.borderColor;


        const chartProgressList = document.querySelectorAll('.chart-progress');
        if (chartProgressList) {
            chartProgressList.forEach(function(chartProgressEl) {
                const color = chartProgressEl.dataset.color,
                    series = chartProgressEl.dataset.series;
                const progress_variant = chartProgressEl.dataset.progress_variant;
                const optionsBundle = radialBarChart(color, series, progress_variant);
                console.log(color)
                const chart = new ApexCharts(chartProgressEl, optionsBundle);
                chart.render();
            });
        }


        // Radial bar chart functions
        function radialBarChart(color, value, show) {
            const radialBarChartOpt = {
                chart: {
                    height: show == 'true' ? 58 : 53,
                    width: show == 'true' ? 58 : 43,
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: show == 'true' ? '45%' : '33%'
                        },
                        dataLabels: {
                            show: show == 'true' ? true : false,
                            value: {
                                offsetY: -10,
                                fontSize: '14px',
                                fontWeight: 700,
                                color: '#333'
                            }
                        },
                        track: {
                            background: config.colors_label.secondary
                        }
                    }
                },
                stroke: {
                    lineCap: 'round'
                },
                colors: [color],
                grid: {
                    padding: {
                        top: show == 'true' ? -12 : -15,
                        bottom: show == 'true' ? -17 : -15,
                        left: show == 'true' ? -17 : -5,
                        right: -15
                    }
                },
                series: [value],
                labels: show == 'true' ? [''] : ['Progress']
            };
            return radialBarChartOpt;
        }
    });

    $(document).on('change', '.selected_course', function() {
        let course_id = $(this).val();
        $.ajax({
            url: "{{ route('admin.lms.courses.getCourseLevels') }}",
            type: "POST",
            data: {
                'course_id': course_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.Levels && Array.isArray(data.Levels)) {
                    $('.selected_course_levels').empty();

                    $('.selected_course_levels').append(`
                        <option value="">Select Level</option>
                    `);

                    data.Levels.forEach(element => {
                        $('.selected_course_levels').append(`
                            <option value="${element.id}"> ${element.title} </option>
                        `);
                    });
                } else {
                    showError(data.message || 'No levels found.');
                }
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    showError(response.responseJSON.errors);
                } else {
                    showError('An error occurred while fetching course levels.');
                }
            }
        });
    });


    $(document).on('change', '.selected_course_levels', function() {
        let level_id = $(this).val();
        console.log('Selected level_id:', level_id);

        $.ajax({
            url: "{{ route('admin.lms.levels.getLevelTrainingModules') }}",
            type: "POST",
            data: {
                'level_id': level_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Response data:', data);

                if (data.trainingModules && Array.isArray(data.trainingModules)) {
                    $('#course_level_training_module').empty();
                    data.trainingModules.forEach(element => {
                        $('#course_level_training_module').append(`
                            <div class="col-md-4 my-5">
                                <div class="card email-template-card">
                                    <div class="card-header pb-0 my-4">
                                        <span class="topleftcorner">Skill level: ${element.level.title}</span>
                                        <span class="topcorner">Est.: ${element.completion_time} Minutes</span>
                                        <span class="text-center">${element.title}</span>
                                    </div>
                                    <div class="training-card-body">
                                        <div class="overlay">
                                            <img src="${element.cover_image}" alt="Overlay" class="training-overlay-image">
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-container">
                                    <input type="checkbox" id="checkbox-training-module-${element.id}" class="btn-check" name="training_modules[]" value="${element.id}">
                                    <label class="btn btn-outline-primary w-100" for="checkbox-training-module-${element.id}">
                                        ${element.name}
                                    </label>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    showError(data.message || 'No training module found.');
                }
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    showError(response.responseJSON.errors);
                } else {
                    showError('An error occurred while fetching training levels.');
                }
            }
        });
    });
</script>
@endsection
