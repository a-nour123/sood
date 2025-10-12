@extends('admin/layouts/contentLayoutMaster')

@section('title', __('incident.incident'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection


@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <style>
        #risk_addational_notes_submit {
            height: 93px;
        }

        .ql-spanblock:after {
            content: "<sb/>";
        }

        .spanblock {
            background-color: #f2f2f2;
            border: 1px solid #CCC;
            line-height: 19px;
            padding: 6px 10px;
            border-radius: 3px;
            margin: 15px 0;
        }

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

        #custom-tabs .fa-info {
            border: 1px solid #44225c7d;
            width: 27px;
            height: 27px;
            text-align: center;
            line-height: 24px;
            border-radius: 50%;
            padding: 0;
            font-size: 13px;
            margin: 5px;
        }

        .action-category .category-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
        }

        /* Items styling */
        .action-category .item {
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 8px !important;
        }

        .action-category .item:hover {
            background-color: #e9e9e9;
        }

        /* Icon styling */
        .action-category .item a {
            font-size: 1.5rem;
            color: #007bff;
            text-decoration: none;
        }

        .action-category .item a:hover {
            color: #0056b3;
        }

        /* Select box styling */
        .action-category .form-select {
            max-width: 200px;
        }

        /* Checkbox styling */
        .action-category .form-check-input {
            margin-right: 10px;
        }

        .action-hidden-step {
            display: none !important;
        }

        /* Visible state with !important */
        .action-visible-step {
            display: flex !important;
        }

        #incident-files .incident-file-item {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 6px 10px;
            margin-bottom: 6px;
            transition: box-shadow 0.2s;
        }

        #incident-files .incident-file-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            background: #f5f7fa;
        }

        #incident-files .incident-file-item a {
            flex: 1;
            color: #007bff;
            text-decoration: underline;
            font-weight: 500;
            word-break: break-all;
        }

        #incident-files .incident-file-item .btn-danger {
            margin-left: 10px;
            padding: 2px 8px;
            font-size: 0.9em;
        }

        #equation {
            background-color: #e2d8e8;
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
                        <div class="col-sm-6 pe-0" style="text-align: end;">

                            <div class="action-content">

                                {{--  @if (auth()->user()->hasPermission('riskmanagement.create'))  --}}
                                @if (auth()->user()->hasPermission('incident.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-incident">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.incident.notificationsSettingsIncident') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('incident.configuration'))
                                    <a class="btn btn-primary" href="{{ route('admin.incident.configure') }}"> <i
                                            class="fa fa-solid fa-gear"></i> </a>

                                    <a class="btn btn-primary waves-effect waves-float waves-light"
                                        href="{{ route('admin.incident.incident.statistics') }}">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </a>
                                @endif

                                {{--  <x-export-import name="{{ __('risk.Risk') }}" createPermissionKey='vulnerability_management.create'
                                exportPermissionKey='riskmanagement.export'
                                exportRouteKey='admin.risk_management.ajax.export'
                                importRouteKey='admin.risk_management.import' />


                            <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>  --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>
</div>





<x-incident-incident-form id="add-new-incident" title="{{ __('incident.AddNewIncident') }}" :events="$events"
    :directions="$directions" :attacks="$attacks" :detects="$detects" :pap="$pap" :tlp="$tlp" />


<div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('incident.Incident_management') }}</h4>
        </div>
    </div>

    <div class="card-body mt-2 dashboard_default module_summary">

        <div class="row mb-3 align-items-end g-3">

            {{-- Direction --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.direction_name') }}</label>
                <select id="filterDirection" class="form-select">
                    <option value="">{{ __('locale.select-option') }}</option>
                    @foreach ($directions as $direction)
                        <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Attack --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.attack_name') }}</label>
                <select id="filterAttack" class="form-select">
                    <option value="">{{ __('locale.select-option') }}</option>
                    @foreach ($attacks as $attack)
                        <option value="{{ $attack->id }}">{{ $attack->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Detect --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.detected_name') }}</label>
                <select id="filterDetect" class="form-select">
                    <option value="">{{ __('locale.select-option') }}</option>
                    @foreach ($detects as $detect)
                        <option value="{{ $detect->id }}">{{ $detect->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Playbook --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.play_book') }}</label>
                <select id="filterPlaybook" class="form-select">
                    <option value="">{{ __('locale.select-option') }}</option>
                    @foreach ($play_books as $play_book)
                        <option value="{{ $play_book->id }}">{{ $play_book->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.status') }}</label>
                <select id="filterStatus" class="form-select">
                    <option value="">{{ __('locale.select-option') }}</option>
                    <option value="open">{{ __('incident.open') }}</option>
                    <option value="progress">{{ __('incident.progress') }}</option>
                    <option value="closed">{{ __('incident.closed') }}</option>
                </select>
            </div>

            {{-- Date From --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.Created_at') }} ({{ __('From') }})</label>
                <input type="date" id="filterDateFrom" class="form-control">
            </div>

            {{-- Date To --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('incident.Created_at') }} ({{ __('To') }})</label>
                <input type="date" id="filterDateTo" class="form-control">
            </div>

            {{-- Export Button --}}
            <div class="col-md-3 text-end">
                <button id="exportBtn" class="btn btn-success w-100">
                    <i class="fa fa-file-excel"></i> {{ __('Export Excel') }}
                </button>
            </div>
        </div>


        {{-- 🔹 DataTable --}}
        <div class="table-responsive">
            <table id="dataTableREfresh" class="dt-advanced-server-search table">
                <thead>
                    <tr>
                        <th>{{ __('locale.ID') }}</th>
                        <th>{{ __('incident.summary') }}</th>
                        <th>{{ __('incident.occurrence_name') }}</th>
                        <th>{{ __('incident.direction_name') }}</th>
                        <th>{{ __('incident.attack_name') }}</th>
                        <th>{{ __('incident.detected_name') }}</th>
                        <th>{{ __('incident.Detected_on') }}</th>
                        <th>{{ __('incident.Tlp') }}</th>
                        <th>{{ __('incident.Pap') }}</th>
                        <th>{{ __('incident.total_score') }}</th>
                        <th>{{ __('incident.status') }}</th>
                        <th>{{ __('incident.created_at') }}</th>
                        <th>{{ __('incident.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>





<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal2"
    aria-hidden="true" id="update-incident-wizrd">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal2">{{ __('incident.Incident') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="page-body" style="min-height: auto;">
                <div class="row my-5">
                    <div class="col-xl-12">
                        <div class="card height-equal">
                            <div class="card-header pb-0">
                            </div>

                            <div class="card-body basic-wizard important-validation">
                                <div class="stepper-horizontal mb-2" id="stepper1">
                                    <div class="stepper-one stepper step editing active">
                                        <div class="step-circle"><span>1</span></div>
                                        <div class="step-title">{{ trans('incident.Detection') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>
                                    <div class="stepper-two step">
                                        <div class="step-circle"><span>2</span></div>
                                        <div class="step-title">{{ trans('incident.Association') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>
                                    <div class="stepper-three step">
                                        <div class="step-circle"><span>3</span></div>
                                        <div class="step-title">{{ trans('incident.incident_assessment') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>
                                    <div class="stepper-four step">
                                        <div class="step-circle"><span>4</span></div>
                                        <div class="step-title">{{ trans('incident.assignment') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>
                                    <div class="stepper-five step step-action-five">
                                        <div class="step-circle"><span>5</span></div>
                                        <div class="step-title">{{ trans('incident.PlayBook') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>

                                </div>
                                <hr class="mb-4">
                                <div id="msform">

                                    {{-- Step 1 --}}
                                    <form class="stepper-one row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-one">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <input type="hidden" name="incident_id">
                                                    <label class="form-label">{{ __('incident.summary') }}</label>
                                                    <input type="text" name="summary" class="form-control dt-post"
                                                        aria-label="{{ __('incident.summary') }}" readonly />
                                                    <span class="error error-summary "></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.details') }}</label>
                                                    <textarea type="text" name="details" class="form-control dt-post" aria-label="{{ __('incident.details') }}"
                                                        readonly></textarea>
                                                    <span class="error error-details "></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.Direction') }}</label>
                                                    <select class="select2 form-select" name="direction_id" disabled>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($directions as $direction)
                                                            <option value="{{ $direction->id }}">
                                                                {{ $direction->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-direction_id"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.Attack') }}</label>
                                                    <select class="select2 form-select" name="attack_id" disabled>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($attacks as $attack)
                                                            <option value="{{ $attack->id }}">{{ $attack->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-attack_id"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.Tlp') }}</label>
                                                    <select class="select2 form-select" name="tlp_id" required>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($tlp as $t)
                                                            <option value="{{ $t->id }}">{{ $t->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-tlp_id"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.Pap') }}</label>
                                                    <select class="select2 form-select" name="pap_id" required>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($pap as $p)
                                                            <option value="{{ $p->id }}">{{ $p->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-pap_id"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label
                                                        class="form-label">{{ __('incident.detected_name') }}</label>
                                                    <select class="select2 form-select" name="detected_id" disabled>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($detects as $detect)
                                                            <option value="{{ $detect->id }}">{{ $detect->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-detected_id"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.status') }}</label>
                                                    <select class="select2 form-select" name="status" required>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        <option value="open">{{ __('incident.open') }}</option>
                                                        <option value="progress">{{ __('incident.progress') }}
                                                        </option>
                                                        <option value="closed">{{ __('incident.closed') }}</option>

                                                    </select>
                                                    <span class="error error-status "></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.Files') }}</label>
                                                    <div id="incident-files"
                                                        style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 10px; min-height: 48px; background: #fafbfc; margin-bottom: 8px;">
                                                        <!-- Files will be rendered here -->
                                                    </div>
                                                    <input type="hidden" id="remove-file-ids" name="remove_file_ids"
                                                        value="">
                                                    <input type="file" id="incident-file-upload"
                                                        name="incident_files[]"
                                                        class="form-control form-control-sm mt-1" multiple
                                                        style="max-width: 100%;" />
                                                    <small id="text-under-files"
                                                        class="text-muted">{{ __('incident.UploadNewFiles') }}</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label
                                                        class="form-label">{{ __('incident.Detected_on') }}</label>
                                                    <input type="datetime-local" name="detected_on"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('incident.detected_on') }}" readonly />
                                                    <span class="error error-detected_on "></span>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

                                    {{-- Step 2 --}}
                                    <form class="stepper-two row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-two">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label
                                                        for="related-incident">{{ __('incident.related_incident') }}</label>
                                                    <select name="related_incidents[]" class="select2 form-select"
                                                        multiple id="related-incident">
                                                        @foreach ($incidents as $incident)
                                                            <option value="{{ $incident->id }}">
                                                                {{ $incident->summary }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label
                                                        for="related-risk">{{ __('incident.related_risk') }}</label>
                                                    <select name="related_risks[]" class="select2 form-select"
                                                        multiple id="related-risk">
                                                        @foreach ($risks as $risk)
                                                            <option value="{{ $risk->id }}">
                                                                {{ $risk->subject }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label for="affected-asset">{{ __('incident.affected_asset') }}
                                                    </label>
                                                    <select name="affected_assets[]" class="select2 form-select"
                                                        multiple id="affected-asset">
                                                        {{-- @foreach ($assets as $asset)
                                                            <option value="{{ $asset->id }}">{{ $asset->name }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label for=""> {{ __('incident.source_tag') }}</label>
                                                    <input type="text" name="source" class="form-control dt-post"
                                                        aria-label="{{ __('incident.source') }}" />
                                                    <span class="error error-source "></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label for=""> {{ __('incident.destination_tag') }}
                                                    </label>
                                                    <input type="text" name="destination"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('incident.destination') }}" />
                                                    <span class="error error-destination "></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label
                                                        for="other-assets">{{ __('incident.other_assets') }}</label>
                                                    <input type="text" name="other_assets" id="other_assets"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('incident.other_assets') }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label for="related-">{{ __('incident.affected_users') }}</label>
                                                    <select name="affected_users[]" class="select2 form-select"
                                                        multiple id="affected_users">
                                                        <option value="" selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{--  <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Documents</label>
                                                    <input type="file" name="documents"
                                                        class="form-control dt-post" multiple
                                                        aria-label="{{ __('incident.documents') }}" />
                                                    <span class="error error-documents "></span>
                                                </div>
                                            </div>  --}}
                                        </div>

                                    </form>

                                    {{-- Step 3 --}}
                                    <form class="stepper-three row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-three">

                                        <div class="col-md-12">
                                            <div class="row">
                                                <ul class="nav nav-pills" id="custom-tabs" role="tablist">
                                                    @foreach ($criteriaScores as $score)
                                                        <li class="col-md-4 mb-2" role="presentation">
                                                            <a class="@if ($loop->first) active @endif"
                                                                id="tab-{{ $score->id }}-tab"
                                                                data-bs-toggle="pill"
                                                                href="#tab-{{ $score->id }}" role="tab"
                                                                aria-controls="tab-{{ $score->id }}"
                                                                aria-selected="true">
                                                                <i class="fa fa-info"></i>
                                                                {{ $score->name }}
                                                            </a>
                                                        </li>
                                                        <div class="col-md-5 mb-2">
                                                            <select name="criteria_scores[{{ $score->id }}]"
                                                                class="form-select criteria-select"
                                                                id="affected-asset">
                                                                <option value="">{{ __('locale.None') }}
                                                                </option>
                                                                @foreach ($score->IncidentScores as $incidentScore)
                                                                    <option value="{{ $incidentScore->id }}"
                                                                        data-point="{{ $incidentScore->point }}"
                                                                        data-title="{{ $incidentScore->title }}">
                                                                        {{ $incidentScore->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    @endforeach
                                                </ul>
                                                <div class="col-md-12 mt-3">
                                                    <strong>Total Direct: </strong>
                                                    <span id="equation"></span> = <span id="total-score">0</span>
                                                </div>

                                                <!-- Tab Content -->
                                                <div class="tab-content" id="custom-tabs-content">
                                                    @foreach ($criteriaScores as $score)
                                                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                            id="tab-{{ $score->id }}" role="tabpanel"
                                                            aria-labelledby="tab-{{ $score->id }}-tab">
                                                            <table class="table table-bordered mt-4">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('incident.incident_impact') }}</th>
                                                                        <th>{{ __('incident.incident_score') }}</th>
                                                                        <th>{{ __('incident.details') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="score-details-{{ $score->id }}">
                                                                    @foreach ($score->IncidentScores as $score)
                                                                        <tr>
                                                                            <td>
                                                                                {{ $score->title }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $score->point }}
                                                                            </td>
                                                                            <td>
                                                                                ---
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    {{--  step 4  --}}
                                    <form class="stepper-four row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-four">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('incident.Case_type') }}</label>
                                                    <select class="select2 form-select" name="occurrence_id" required>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($events as $event)
                                                            <option value="{{ $event->id }}">{{ $event->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-occurrence_id"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('incident.Reperted_by') }}</label>
                                                    <select class="select2 form-select" name="reported_id" required>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                @if ($active_user == $user->id) selected @endif>
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('incident.Owned_by') }} </label>
                                                    <select class="select2 form-select" name="owned_id" disabled>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                @if ($active_user == $user->id) selected @endif>
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('incident.PlayBook') }}</label>
                                                    <select class="select2 form-select play_book_id"
                                                        name="play_book_id" required>
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($play_books as $play_book)
                                                            <option value="{{ $play_book->id }}">
                                                                {{ $play_book->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table playbook-users d-none">
                                                    <thead>
                                                        <th>{{ __('incident.CSRIT') }} </th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="badge badge-pill badge-primary">Primary</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>

                                    {{--  step 5  --}}
                                    <form class="stepper-five  row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-five">

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <ul class="nav nav-tabs mb-4" id="myActionTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="action-containments-tab"
                                                            data-bs-toggle="tab" data-bs-target="#action-containments"
                                                            type="button" role="tab"
                                                            aria-controls="action-containments"
                                                            aria-selected="true">{{ __('incident.Containments') }}</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="action-eradications-tab"
                                                            data-bs-toggle="tab" data-bs-target="#action-eradications"
                                                            type="button" role="tab"
                                                            aria-controls="action-eradications"
                                                            aria-selected="false">{{ __('incident.Eradications') }}</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="action-recoveries-tab"
                                                            data-bs-toggle="tab" data-bs-target="#action-recoveries"
                                                            type="button" role="tab"
                                                            aria-controls="action-recoveries"
                                                            aria-selected="false">{{ __('incident.Recoveries') }}</button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myActionTabContent">
                                                    <div class="tab-pane fade show active" id="action-containments"
                                                        role="tabpanel" aria-labelledby="action-containments-tab">
                                                        <div class="container">

                                                        </div>

                                                    </div>
                                                    <div class="tab-pane fade" id="action-eradications"
                                                        role="tabpanel" aria-labelledby="action-eradications-tab">
                                                        <div class="container">

                                                        </div>

                                                    </div>
                                                    <div class="tab-pane fade" id="action-recoveries" role="tabpanel"
                                                        aria-labelledby="action-recoveries-tab">
                                                        <div class="container">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                                <div class="wizard-footer d-flex gap-2 justify-content-end mt-3">
                                    <button class="btn alert-light-primary" id="backbtn"
                                        onclick="validateBackStep()">
                                        {{ __('locale.Back') }} </button>
                                    <button class="btn btn-primary" id="nextbtn" onclick="validateStep()">
                                        {{ __('locale.Next') }} </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6" style="display: none">
                        <div class="card height-equal">
                            <div class="card-header pb-0">
                                <h3>Student validation form</h3>
                                <p class="f-m-light mt-1">
                                    Please make sure fill all the filed before click on next button.</p>
                            </div>
                            <div class="card-body custom-input">
                                <form class="form-wizard" id="regForm" action="#" method="POST">
                                    <div class="tab">
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label for="name">Name</label>
                                                <input class="form-control" id="name" type="text"
                                                    placeholder="Enter your name" required="required">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="student-email-wizard">Email<span
                                                        class="txt-danger">*</span></label>
                                                <input class="form-control" id="student-email-wizard" type="email"
                                                    required="" placeholder="Cion@gmail.com">
                                            </div>
                                            <div class="col-12">
                                                <label class="col-sm-12 form-label"
                                                    for="password-wizard">Password<span
                                                        class="txt-danger">*</span></label>
                                                <input class="form-control" id="password-wizard" type="password"
                                                    placeholder="Enter password" required="">
                                            </div>
                                            <div class="col-12">
                                                <label class="col-sm-12 form-label" for="confirmpassowrd">Confirm
                                                    Password<span class="txt-danger">*</span></label>
                                                <input class="form-control" id="confirmpassowrd" type="password"
                                                    placeholder="Enter confirm password" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab">
                                        <div class="row g-3 avatar-upload">
                                            <div class="col-12">
                                                <div>
                                                    <div class="avatar-edit">
                                                        <input id="imageUpload" type="file"
                                                            accept=".png, .jpg, .jpeg">
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="image"></div>
                                                    </div>
                                                </div>
                                                <h3>Add Profile</h3>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="exampleFormControlInput1">Portfolio
                                                    URL</label>
                                                <input class="form-control" id="exampleFormControlInput1"
                                                    type="url" placeholder="https://Cion">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="projectDescription">Project
                                                    Description</label>
                                                <textarea class="form-control" id="projectDescription" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab">
                                        <h5 class="mb-2">Social Links </h5>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label class="form-label" for="twitterControlInput">Twitter</label>
                                                <input class="form-control" id="twitterControlInput" type="url"
                                                    placeholder="https://twitter.com">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="githubControlInput">Github</label>
                                                <input class="form-control" id="githubControlInput" type="url"
                                                    placeholder="https:/github.com">
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <input class="form-control" id="inputGroupFile04" type="file"
                                                        aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                    <button class="btn btn-outline-secondary"
                                                        id="inputGroupFileAddon04" type="button">Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected="">Positions</option>
                                                    <option value="1">Web Designer</option>
                                                    <option value="2">Software Engineer</option>
                                                    <option value="3">UI/UX Designer </option>
                                                    <option value="3">Web Developer</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="quationsTextarea">Why do you want to
                                                    take this position?</label>
                                                <textarea class="form-control" id="quationsTextarea" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-end pt-3">
                                            <button class="btn btn-secondary" id="prevBtn" type="button"
                                                onclick="nextPrev(-1)">Previous</button>
                                            <button class="btn btn-primary" id="nextBtn" type="button"
                                                onclick="nextPrev(1)">Next</button>
                                        </div>
                                    </div>
                                    <!-- Circles which indicates the steps of the form:-->
                                    <div class="text-center"><span class="step"></span><span
                                            class="step"></span><span class="step"></span><span
                                            class="step"></span></div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" aria-hidden="true" id="addEvidenceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ __('governance.AddEvidence') }}</h1>
                </div>
                <!-- Evidence form -->
                <form class="row addEvidenceToObjectiveForm" onsubmit="return false" enctype="multipart/form-data">
                    <input type="hidden" name="evidence_play_book_id">
                    <input type="hidden" name="evidence_incident_id">
                    <input type="hidden" name="evidence_action_id">
                    @csrf
                    <div class="col-12">
                        {{-- Evidence Description --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                            <input class="form-control" type="text" name="evidence_description">
                            <span class="error error-evidence_description"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- File Attachment --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.EvidenceFile') }}</label>
                            <input type="file" name="evidence_file" class="form-control dt-post"
                                aria-label="{{ __('locale.file') }}" />
                            <span class="error error-evidence_file "></span>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
                <!--/ Evidence form -->
            </div>
        </div>
    </div>
</div>

<div class="modal modal-slide-in sidebar-todo-modal fade" id="evidencesModal" role="dialog">
    <div class="modal-dialog sidebar-lg" style="width:1200px">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">{{ __('locale.Evidences') }}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                <div>
                    <h3 style="display: inline-block">{{ __('incident.Incident') }} :</h3>
                    <h3 style="display: inline-block" id="incidentName"> </h3>
                    <h3 style="display: inline-block"> / {{ __('incident.play_book') }} :</h3>
                    <h3 style="display: inline-block" id="playbookName"></h3>
                    <h3 style="display: inline-block"> / {{ __('incident.action') }} :</h3>
                    <h3 style="display: inline-block" id="actionName"></h3>

                </div>
                <br>
                <div id="evidencesList">

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" aria-hidden="true" id="viewEvidenceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ __('locale.ViewEvidence') }}</h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        {{-- Evidence Description --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                            <input class="form-control view_evidence_description" disabled>
                        </div>
                    </div>
                    <div class="col-12 view_evidence_file_container">
                        {{-- File Attachment --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.EvidenceFile') }}</label>
                            <a class="badge bg-secondary view_evidence_file cursor-pointer text-light"></a>
                        </div>
                    </div>

                    <div class="col-12">
                        {{-- Evidence Description --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.CreatedBy') }}</label>
                            <input class="form-control view_evidence_created_by" disabled>

                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Evidence Description --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.CreatedAt') }} </label>
                            <input class="form-control view_evidence_created_at" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" aria-hidden="true" id="editEvidenceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ __('governance.EditEvidence') }}</h1>
                </div>
                <!-- Evidence form -->
                <form class="row editEvidenceForm" onsubmit="return false" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" type="hidden" name="evidence_id">
                    <div class="col-12">
                        {{-- Evidence Description --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                            <input type="text" class="form-control" name="edited_evidence_description">
                            <span class="error error-edited_evidence_description"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- File Attachment --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.EvidenceFile') }}</label>

                            <input type="file" name="edited_evidence_file" class="form-control dt-post"
                                aria-label="{{ __('locale.file') }}" />
                            <span class="error error-edited_evidence_file "></span>
                        </div>
                        <div class="mb-1 last_uploaded_file_container" style="display: hidden;">
                            <label class="form-label">{{ __('locale.LastUploadedFile') }}</label>
                            <a class="badge bg-secondary last_uploaded_file cursor-pointer text-light"></a>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
                <!--/ Evidence form -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="incidentCommentsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ __('locale.Comments') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content p-0">
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div id="chat-container">
                        <section class="chat-app-window">
                            @if (auth()->user()->role->name == 'Administrator')
                                <div class="text-center mb-1">
                                    <a href="javascript:" class="btn btn-danger clearCommentsBtn"
                                        title="Clear Comments">
                                        {{ __('governance.ClearComments') }}
                                    </a>
                                </div>
                            @endif
                            <div class="active-chat">
                                <!-- User Chat messages -->
                                <div class="user-chats">
                                    <div class="chats">
                                    </div>
                                </div>
                                <!-- User Chat messages -->
                                <p class="my-0 mx-2 file-name"
                                    data-content="{{ __('locale.FileName', ['name' => '']) }}">
                                </p>
                                <!-- Submit Chat form -->
                                <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);"
                                    onsubmit="enterChat('#incidentCommentsModal');">
                                    @csrf
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="text" class="form-control message" name ="comment"
                                            placeholder="{{ __('locale.TypeYourComment') }}" />
                                        <span class="input-group-text" title="hhhh">
                                            <label for="attach-doc" class="attachment-icon form-label mb-0">
                                                <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                                <input name="comment_file" type="file" class="attach-doc"
                                                    id="attach-doc" hidden /> </label></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary send">
                                        {{-- <i data-feather="send" class="d-lg-none"></i> --}}
                                        <i data-feather="send"></i>
                                        {{-- <span class="d-none d-lg-block">Send</span> --}}
                                    </button>
                                </form>
                                <!--/ Submit Chat form -->
                            </div>
                            <!--/ Active Chat -->
                        </section>
                        <!--/ Main chat area -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="incidentLogsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ __('locale.Logs') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content p-0">
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">

                </div>
            </div>
        </div>
    </div>
</div>


{{-- modal of  statistic --}}
<div class="modal fade" id="incidentStatisticsModal" tabindex="-1" aria-labelledby="incidentStatisticsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incidentStatisticsModalLabel">Incident Statistics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="incidentStatsChart" style="width:100%; height:400px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('cdn/ckeditor.js') }}"></script>


<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>


<script src="{{ asset('new_d/js/form-wizard/form-wizard.js') }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>



{{-- Add Verification translation --}}
<script>
    let URLs = [],
        lang = [];
    lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
    lang['cancel'] = "{{ __('locale.Cancel') }}";
    lang['success'] = "{{ __('locale.Success') }}";
    lang['error'] = "{{ __('locale.Error') }}";
    lang['confirmDeleteMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.risk')]) }}";
    permission = [];
    permission['show'] = {{ auth()->user()->hasPermission('riskmanagement.list') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('riskmanagement.delete') ? 1 : 0 }};
    URLs['ajax_list'] = "{{ route('admin.risk_management.ajax.index') }}";
    URLs['show'] = "{{ route('admin.risk_management.show', ':id') }}";
    URLs['create'] = "{{ route('admin.risk_management.ajax.store') }}";
    URLs['delete'] = "{{ route('admin.risk_management.ajax.destroy', ':id') }}";
    customUserName = "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    userName = "{{ auth()->user()->name }}";
    user_id = {{ auth()->id() }},
</script>
<script src="{{ asset('ajax-files/risk_management/index.js') }}"></script>
<script src="{{ asset('cdn/highcharts.js') }}"></script>

<script>
    // Submit form for creating asset
    $('#add-new-incident form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-incident').modal('hide');
                    $('#dataTableREfresh').DataTable().ajax.reload();
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

    function showEditIncidentForm(incident_id) {
        var url = "{{ route('admin.incident.incident.ira_edit', '') }}" + "/" + incident_id;

        // Reset form state first (enable all elements)
        resetFormState();

        // AJAX request to fetch incident details by ID
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('.step-action-five').remove();
                $('#form-step-five').remove();
                $('#nextbtn').attr("onclick", "validateStep();");

                enableStepInputs();

                // Render files in the #incident-files-list div
                let files = response.incident.files || [];
                console.log("sdsdsd", files);
                let fileListHtml = '';
                files.forEach(function(file) {
                    console.log(file);
                    let url = `{{ route('admin.incident.file.download', ':id') }}`.replace(':id',
                        file.id);
                    fileListHtml += `<div class="incident-file-item mb-1" data-file-id="${file.id}">
                <a href="${url}" target="_blank">${file.display_name}</a>
                <button type="button" class="btn btn-sm btn-danger ms-2 remove-incident-file" data-file-id="${file.id}">{{ __('locale.Remove') }}</button>
            </div>`;
                });
                if (!files.length) fileListHtml =
                    '<div class="text-muted">{{ __('locale.NoFiles') }}</div>';
                $('#incident-files').html(fileListHtml);
                window.removeFileIds = [];

                // Remove file from UI and add to remove list
                $(document).off('click', '.remove-incident-file').on('click', '.remove-incident-file',
                    function() {
                        const fileId = $(this).data('file-id');
                        window.removeFileIds.push(fileId);
                        $(this).closest('.incident-file-item').remove();
                        $('#remove-file-ids').val(window.removeFileIds.join(','));
                    });

                // Populate the form fields with the incident data
                $('#form-step-one').find('input[name="summary"]').val(response.incident.incident.summary);
                $('#form-step-one').find('textarea[name="details"]').val(response.incident.incident
                    .details);
                $('#form-step-one').find('select[name="occurrence_id"]').val(response.incident.incident
                    .occurrence_id).trigger('change');
                $('#form-step-one').find('select[name="direction_id"]').val(response.incident.incident
                    .direction_id).trigger('change');
                $('#form-step-one').find('select[name="attack_id"]').val(response.incident.incident
                    .attack_id).trigger('change');
                $('#form-step-one').find('select[name="detected_id"]').val(response.incident.incident
                    .detected_id).trigger('change');
                $('#form-step-one').find('select[name="tlp_id"]').val(response.incident.incident
                    .tlp_level_id).trigger('change');
                $('#form-step-one').find('select[name="pap_id"]').val(response.incident.incident
                    .pap_level_id).trigger('change');
                $('#form-step-one').find('select[name="status"]').val(response.incident.incident.status)
                    .trigger('change');
                $('#form-step-one').find('input[name="detected_on"]').val(response.incident.incident
                    .detected_on);
                $('#form-step-four').find('input[name="owned_id"]').val(response.incident.incident
                    .created_by);
                $('#form-step-one').find('input[name="incident_id"]').val(response.incident.incident.id);
                $('#form-step-two').find('input[name="source"]').val(response.incident.incident.source);
                $('#form-step-two').find('input[name="destination"]').val(response.incident.incident
                    .destination);
                $('#form-step-two').find('input[name="other_assets"]').val(response.incident.incident
                    .other_assets);

                if (response.incident.affected_users) {
                    $('#affected_users').val(response.incident.affected_users).trigger('change');
                }

                // Populate Related Incidents (Multiple Select)
                if (response.incident.related_incidents) {
                    $('#related-incident').val(response.incident.related_incidents).trigger('change');
                }

                // Populate Related Risks (Multiple Select)
                if (response.incident.related_risks) {
                    $('#related-risk').val(response.incident.related_risks).trigger('change');
                }

                // Populate Affected Assets (Multiple Select)
                if (response.incident.affected_assets) {
                    const editForm = $("#update-incident-wizrd");
                    let assetSelect = editForm.find("select[name='affected_assets[]']");

                    // Check if Select2 is already initialized and destroy it
                    if (assetSelect.hasClass("select2-hidden-accessible")) {
                        assetSelect.select2('destroy');
                    }

                    // Clear all existing options
                    assetSelect.empty();

                    // Initialize Select2 FIRST
                    assetSelect.select2({
                        placeholder: '{{ __('locale.Enter asset name') }}',
                        minimumInputLength: 1,
                        ajax: {
                            url: '{{ route('admin.asset_management.ajax.assets') }}',
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(asset) {
                                        return {
                                            id: asset.id,
                                            text: asset.name
                                        };
                                    })
                                };
                            },
                            cache: true
                        }
                    });

                    // Now add the selected options programmatically
                    response.incident.affected_assets.forEach(function(asset) {
                        // Create a new option and append to Select2
                        var newOption = new Option(asset.name, asset.id, false, false);
                        assetSelect.append(newOption);
                    });

                    // Set the selected values
                    var selectedIds = response.incident.affected_assets.map(function(asset) {
                        return asset.id.toString();
                    });

                    assetSelect.val(selectedIds).trigger('change');
                }

                // Check if the form exists
                let formStepThree = $('#form-step-three');
                if (formStepThree.length) {
                    // Clear existing criteria scores (if needed)
                    formStepThree.find('select[name^="criteria_scores"]').val(null).trigger('change');

                    // Populate Criteria Scores (Dynamically)
                    if (response.incident.criteria_scores) {
                        $.each(response.incident.criteria_scores, function(criteriaId, scoreId) {
                            // Find the select field for the criteria score and set its value
                            let selectField = formStepThree.find('select[name="criteria_scores[' +
                                criteriaId + ']"]');
                            if (selectField.length) {
                                selectField.val(scoreId).trigger('change');
                            }
                        });
                        calculateTotal();
                    }
                }

                populateFormStepFour(response.incident.incident, response.play_books);

                // Disable form if status is 'closed'
                if (response.incident.incident.status === 'closed') {
                    disableFormForClosedStatus();
                }

                $('#update-incident-wizrd').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching incident data: ", error);
            }
        });
    }

    function disableFormForClosedStatus() {
        const modal = $('#update-incident-wizrd');
        // Enable everything first to avoid state conflicts
        resetFormState();
        // Disable interactive elements inside the wizard only
        modal.find('input, select, textarea, button, a, .fa-plus')
            .not('[data-dismiss="modal"]')
            .not('.wizard-footer button')
            .not('.btn-close')
            .not('.comment-incident-show')
            .not('.logs-incident-show')
            .not('.show-evidences')
            .not('.nav-link')
            .each(function() {
                const $el = $(this);

                // Skip buttons with text containing "not"
                if ($el.is('button')) {
                    const buttonText = $el.text().trim().toLowerCase();
                    if (buttonText.includes('not')) return;
                }

                // Disable and style
                $el.css({
                    'pointer-events': 'none',
                    'opacity': '0.6',
                    'cursor': 'not-allowed'
                });

                if ($el.is('input, select, textarea, button')) {
                    $el.prop('disabled', true)
                        .addClass('disabled')
                        .css('background-color', '#f9f9f9');
                }
            });

        // --- Handle other modals separately ---
        const modalComment = $('#incidentCommentsModal');
        modalComment.find('#chat-app-form').hide();
        modalComment.find('.clearCommentsBtn').hide();
    }

    // Reset everything
    function resetFormState() {
        const modal = $('#update-incident-wizrd');
        modal.find('input, select, textarea, button, a, .fa-plus')
            .prop('disabled', false)
            .removeClass('disabled')
            .css({
                'pointer-events': '',
                'background-color': '',
                'opacity': '',
                'cursor': ''
            });
        const modalComment = $('#incidentCommentsModal');
        modalComment.find('#chat-app-form').show();
        modalComment.find('.clearCommentsBtn').show();
        const evidencesModal = $('#evidencesModal');
        evidencesModal.find('.item-list, .evidence-title, .item-title').show();
        modal.css('opacity', '1');
    }





    // Also add event listener to reset form when modal is closed
    $(document).ready(function() {
        $('#update-incident-wizrd').on('hidden.bs.modal', function() {
            resetFormState();
        });
    });



    function showEditCsritIncidentForm(incident_id) {
        var url = "{{ route('admin.incident.incident.csrit_edit', '') }}" + "/" + incident_id;

        // Reset form state first (enable all elements)
        resetFormState();

        // AJAX request to fetch incident details by ID
        $.ajax({
            url: url, // Laravel route to fetch incident data
            type: 'GET',
            success: function(response) {
                $('.step-action-five').remove();
                $('#form-step-five').remove();

                $('#nextbtn').attr("onclick", "validateActionStep();");

                step = `<div class="stepper-five step step-action-five">
                            <div class="step-circle"><span>5</span></div>
                            <div class="step-title">{{ trans('incident.PlayBook') }}</div>
                            <div class="step-bar-left"></div>
                            <div class="step-bar-right"></div>
                        </div>`;
                form_step = `<form class="stepper-five row g-3 needs-validation custom-input" novalidate=""
                            id="form-step-five" style="display:none" >

                            <div class="row mt-3" >
                                <div class="col-12">
                                    <ul class="nav nav-tabs mb-4" id="myActionTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="action-containments-tab" data-bs-toggle="tab"
                                                data-bs-target="#action-containments" type="button" role="tab"
                                                aria-controls="action-containments" aria-selected="true">Containments</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="action-eradications-tab" data-bs-toggle="tab"
                                                data-bs-target="#action-eradications" type="button" role="tab"
                                                aria-controls="action-eradications" aria-selected="false">Eradications</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="action-recoveries-tab" data-bs-toggle="tab"
                                                data-bs-target="#action-recoveries" type="button" role="tab"
                                                aria-controls="action-recoveries" aria-selected="false">Recoveries</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myActionTabContent">
                                        <div class="tab-pane fade show active" id="action-containments" role="tabpanel"
                                            aria-labelledby="action-containments-tab">
                                            <div class="container">

                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="action-eradications" role="tabpanel"
                                            aria-labelledby="action-eradications-tab">
                                            <div class="container">

                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="action-recoveries" role="tabpanel"
                                            aria-labelledby="action-recoveries-tab">
                                            <div class="container">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>`;

                $('#stepper1').append(step)
                $('#msform').append(form_step)

                disableStepInputs();
                // Render files in the #incident-files-list div
                let files = response.incident.files || [];
                console.log("sdsdsd", files);
                let fileListHtml = '';
                files.forEach(function(file) {
                    console.log(file);
                    let url = `{{ route('admin.incident.file.download', ':id') }}`
                        .replace(
                            ':id', file.id);
                    fileListHtml += `<div class="incident-file-item mb-1" data-file-id="${file.id}">
                <a href="${url}" target="_blank">${file.display_name}</a>
             </div>`;
                });
                if (!files.length) fileListHtml =
                    '<div class="text-muted">{{ __('locale.NoFiles') }}</div>';
                $('#incident-files').html(fileListHtml);
                $('#incident-file-upload').hide();
                $('#text-under-files').hide();

                // Populate the form fields with the incident data
                $('#form-step-one').find('input[name="summary"]').val(response.incident.incident.summary);
                $('#form-step-one').find('textarea[name="details"]').val(response.incident.incident
                    .details);
                $('#form-step-one').find('select[name="occurrence_id"]').val(response.incident.incident
                        .occurrence_id)
                    .trigger('change');
                $('#form-step-one').find('select[name="direction_id"]').val(response.incident.incident
                    .direction_id).trigger(
                    'change');
                $('#form-step-one').find('select[name="attack_id"]').val(response.incident.incident
                    .attack_id).trigger(
                    'change');
                $('#form-step-one').find('select[name="detected_id"]').val(response.incident.incident
                    .detected_id).trigger(
                    'change');
                $('#form-step-one').find('select[name="status"]').val(response.incident.incident.status)
                    .trigger('change');
                $('#form-step-one').find('input[name="detected_on"]').val(response.incident.incident
                    .detected_on);
                $('#form-step-one').find('select[name="tlp_id"]').val(response.incident.incident
                    .tlp_level_id).trigger('change');
                $('#form-step-one').find('select[name="pap_id"]').val(response.incident.incident
                    .pap_level_id).trigger('change');
                $('#form-step-four').find('input[name="owned_id"]').val(response.incident.incident
                    .created_by);
                $('#form-step-one').find('input[name="incident_id"]').val(response.incident.incident.id);
                $('#form-step-two').find('input[name="source"]').val(response.incident.incident.source);
                $('#form-step-two').find('input[name="destination"]').val(response.incident.incident
                    .destination);
                $('#form-step-two').find('input[name="other_assets"]').val(response.incident.incident
                    .other_assets);

                if (response.incident.affected_users) {
                    $('#affected_users').val(response.incident.affected_users).trigger('change');
                }
                // Populate Related Incidents (Multiple Select)
                if (response.incident.related_incidents) {
                    $('#related-incident').val(response.incident.related_incidents).trigger('change');
                }

                // Populate Related Risks (Multiple Select)
                if (response.incident.related_risks) {
                    $('#related-risk').val(response.incident.related_risks).trigger('change');
                }

                // Populate Affected Assets (Multiple Select)
                if (response.incident.affected_assets) {
                    $('#affected-asset').val(response.incident.affected_assets).trigger('change');
                }

                // Check if the form exists
                let formStepThree = $('#form-step-three');
                if (formStepThree.length) {
                    // Clear existing criteria scores (if needed)
                    formStepThree.find('select[name^="criteria_scores"]').val(null).trigger('change');

                    // Populate Criteria Scores (Dynamically)
                    if (response.incident.criteria_scores) {
                        $.each(response.incident.criteria_scores, function(criteriaId, scoreId) {
                            // Find the select field for the criteria score and set its value
                            let selectField = formStepThree.find('select[name="criteria_scores[' +
                                criteriaId + ']"]');
                            if (selectField.length) {
                                selectField.val(scoreId).trigger('change');
                            }
                        });
                        calculateTotal();
                    }
                }

                populateFormStepFour(response.incident.incident, response.play_books);

                populateTab('action-containments', response.incident.groupedActions.containments, response
                    .incident.incident);
                populateTab('action-eradications', response.incident.groupedActions.eradications, response
                    .incident.incident);
                populateTab('action-recoveries', response.incident.groupedActions.recoveries, response
                    .incident.incident);

                // Disable form if status is 'closed'
                if (response.incident.incident.status === 'closed') {
                    disableFormForClosedStatus();
                }

                $('#update-incident-wizrd').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching incident data: ", error);
            }
        });
    }

    function populateTab(tabId, data, incident) {
        $("#" + tabId).empty();


        if (data === null || data === undefined) {
            return; // Exit early if data is invalid
        }

        // Check if data is an object (could be an object or array)
        if (typeof data !== 'object') {
            return; // Exit early if the data is not an object
        }

        // If data is an object but not an array, convert it to an array
        if (!Array.isArray(data)) {
            data = Object.values(data); // Convert object to array of values
        }

        // If data is still not an array, log an error and return
        if (!Array.isArray(data)) {
            return;
        }

        // Iterate over the data to create category sections
        data.forEach(function(item) {
            // Create the category section for each item
            var categoryHtml = `<div class="row mb-4 action-category ">
                                    <div class="col-md-12">
                                        <h4 class="category-title mb-3">${item.category}</h4>
                                    </div>
                                    <div class="col-md-12">`;


            item.actions.forEach(function(action, index) {
                categoryHtml += `
        <div id="evidence-actions" class="item d-flex align-items-center justify-content-between evidences-item-${action.id} mb-3">
            <div class="d-flex align-items-center">
                <a href="#" class="me-2 show-evidences ${action.has_evidences ? '' : 'd-none'}">
                    <span class="badge badge-success count-evidences" data-count="${action.evidence_count}">
                        ${action.evidence_count}
                    </span>
                    <i class="fa fa-list" onClick="showEvidencesList(${action.id}, ${incident.id}, ${incident.play_book_id})"></i>
                </a>
                <a id="add-evidences" href="#" class="me-2 add-evidences ${(action.status == 2 || (action.status == 1 && action.has_evidences)) ? '' : 'd-none'}">
                    <i class="fa fa-plus" onClick="showAddEvidenceForm(${action.id}, ${incident.id}, ${incident.play_book_id})"></i>
                </a>
                <select name="action_status[${action.id}]" class="form-select me-2 action_status" style="width: 150px;">
                    <option value="0" ${action.status == 0 ? 'selected' : ''}>@lang('locale.none')</option>
                    <option value="1" ${action.status == 1 ? 'selected' : ''}>@lang('locale.progress')</option>
                    <option value="2" ${action.status == 2 ? 'selected' : ''}>@lang('locale.Done')</option>
                </select>
                <input type="hidden" name="action_ids[]" value="${action.id}">
                <input type="hidden" name="incident_ids[${action.id}]" value="${incident.id}">
                <input type="hidden" name="playbook_ids[${action.id}]" value="${incident.play_book_id}">
                <label class="form-check-label" for="cat-action-${index + 1}" style="margin-bottom: -4px;">
                    ${action.title}
                </label>
            </div>
            <!-- Comment button aligned to the END -->
            <a class="comment-incident-show" href="javascript:void(0);" class="text-primary ms-2"
               onClick="openIncidentCommentsModal(${incident.play_book_id},${incident.id},${action.id})">
                <i class="fa fa-comments"></i>
            </a>
            <a class="logs-incident-show" href="javascript:void(0);" class="text-primary ms-2"
               onClick="openIncidentPlayBookModal(${incident.play_book_id},${incident.id},${action.id})">
    <i class="fa fa-file-alt"></i>
            </a>
        </div>`;
            });


            // Close the category section
            categoryHtml += `</div></div>`;

            // Append the category section to the tab
            $("#" + tabId).append(categoryHtml);
        });
    }

    $(document).on('change', '.action-category .item .action_status', function() {
        var selectedValue = $(this).val();
        var plusLink = $(this).parents('.item').find('.add-evidences');

        if (selectedValue == 2) {
            plusLink.removeClass('d-none');
        } else {
            plusLink.addClass('d-none');
        }

    });

    function populateFormStepFour(incidentData, playBooks) {

        // Step 4 - Occurrence ID (Event) - Select only the value
        var occurrenceSelect = $('#form-step-four').find('select[name="occurrence_id"]');
        occurrenceSelect.val(incidentData.occurrence_id).trigger('change'); // Set selected value

        // Reported By (Reported ID) - Select only the value
        var reportedSelect = $('#form-step-four').find('select[name="reported_id"]');
        reportedSelect.val(incidentData.reported_id).trigger('change'); // Set selected value

        // Owned By (Owned ID) - Select only the value
        var ownedSelect = $('#form-step-four').find('select[name="owned_id"]');
        ownedSelect.val(incidentData.created_by).trigger('change'); // Set selected value

        // Playbook (Playbook ID) - Select only the value
        var playbookSelect = $('#form-step-four').find('select[name="play_book_id"]');
        playbookSelect.val(incidentData.play_book_id).trigger('change'); // Set selected value

        // Handling Playbook Users (Table Display)
        if (incidentData.play_book_id && playBooks) {
            var selectedPlaybook = playBooks.find(playbook => playbook.id == incidentData.play_book_id);
            if (selectedPlaybook) {
                // Show the table for Playbook users
                $('#form-step-four').find('.playbook-users').removeClass('d-none');
                // Populate Playbook Users (You can add specific playbook users here)
                $('#form-step-four').find('.playbook-users tbody').html(`
                    <tr><td><span class="badge badge-pill badge-primary">Primary</span></td></tr>
                `);
            }
        } else {
            $('#form-step-four').find('.playbook-users').addClass('d-none');
        }
    }

    function disableStepInputs() {
        // Disable all input fields for Steps 1 to 4
        $('#form-step-one input, #form-step-one select, #form-step-one textarea').prop('disabled', true);
        $('#form-step-one').find('input[name="incident_id"]').prop('disabled', false);
        $('#form-step-one').find('select[name="status"]').prop('disabled', false);
        $('#form-step-two input, #form-step-two select, #form-step-two textarea').prop('disabled', true);
        $('#form-step-three input, #form-step-three select, #form-step-three textarea').prop('disabled', true);
        $('#form-step-four input, #form-step-four select, #form-step-four textarea').prop('disabled', true);
    }

    function enableStepInputs() {

        $('#form-step-two input, #form-step-two select, #form-step-two textarea').prop('disabled', false);
        $('#form-step-one').find('input[name="incident_id"]').prop('disabled', false);
        $('#form-step-one').find('select[name="status"]').prop('disabled', false);
        $('#form-step-three input, #form-step-three select, #form-step-three textarea').prop('disabled', false);
        $('#form-step-four input, #form-step-four select, #form-step-four textarea').prop('disabled', false);
    }

    $(document).on('change', '#form-step-four [name="play_book_id"]', function() {
        var play_book_id = $(this).val();

        if (!play_book_id) {
            $('.playbook-users').addClass('d-none');
            return;
        }

        var url = "{{ route('admin.incident.configure.getPlayBookUser', ':id') }}".replace(':id',
            play_book_id);

        // Show loading state
        $('.playbook-users tbody tr td').html('<span class="text-muted">Loading users...</span>');
        $('.playbook-users').removeClass('d-none');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                var dataList = response.responsible_data.responsibles;
                $('.playbook-users tbody tr td').empty();

                if (dataList && dataList.length > 0) {
                    $.each(dataList, function(index, item) {
                        $('.playbook-users tbody tr td').append(
                            `<span class="badge badge-pill badge-primary m-1">${item.name}</span>`
                        );
                    });
                } else {
                    $('.playbook-users tbody tr td').html(
                        '<span class="text-muted">No users found</span>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching playbook users: ", error);
                $('.playbook-users tbody tr td').html(
                    '<span class="text-danger">Error loading users</span>');
            }
        });
    });

    $(document).ready(function() {
        var table = $('#dataTableREfresh').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.incident.getData') }}",
                type: 'GET',
                data: function(d) {
                    d.direction_id = $('#filterDirection').val();
                    d.attack_id = $('#filterAttack').val();
                    d.detected_id = $('#filterDetect').val();
                    d.play_book_id = $('#filterPlaybook').val();
                    d.status = $('#filterStatus').val();
                    d.date_from = $('#filterDateFrom').val();
                    d.date_to = $('#filterDateTo').val();
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
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'summary',
                    name: 'summary'
                },
                {
                    data: 'occurrence_name',
                    name: 'occurrence.name'
                },
                {
                    data: 'direction_name',
                    name: 'direction.name'
                },
                {
                    data: 'attack_name',
                    name: 'attack.name'
                },
                {
                    data: 'detected_name',
                    name: 'detected.name'
                },
                {
                    data: 'detected_on',
                    name: 'detected_on'
                },
                {
                    data: 'tlp_data',
                    name: 'tlp.name',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data && data.name && data.color) {
                            return `<span style="display:inline-flex;align-items:center;gap:6px;">
                                    <span style="width:14px;height:14px;background-color:${data.color};
                                          display:inline-block;border-radius:3px;border:1px solid #ccc;"></span>
                                    <span>${data.name}</span>
                                </span>`;
                        }
                        return 'N/A';
                    }
                },
                {
                    data: 'pap_data',
                    name: 'pap.name',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data && data.name && data.color) {
                            return `<span style="display:inline-flex;align-items:center;gap:6px;">
                                    <span style="width:14px;height:14px;background-color:${data.color};
                                          display:inline-block;border-radius:3px;border:1px solid #ccc;"></span>
                                    <span>${data.name}</span>
                                </span>`;
                        }
                        return 'N/A';
                    }
                },
                {
                    data: 'total_score',
                    name: 'total_score',
                    render: function(data) {
                        if (data && typeof data === 'object') {
                            return `<span style="display:inline-flex;align-items:center;gap:6px;">
                                    <span style="width:14px;height:14px;background-color:${data.color};
                                          display:inline-block;border-radius:3px;border:1px solid #ccc;"></span>
                                    <span>${data.priority}</span>
                                </span>`;
                        }
                        return 'N/A';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        if (!data) return 'N/A';
                        let badgeClass = '';
                        let label = data;
                        switch (data.toLowerCase()) {
                            case 'open':
                                badgeClass = 'badge bg-warning text-dark';
                                label = '{{ __('incident.open') }}';
                                break;
                            case 'progress':
                                badgeClass = 'badge bg-primary';
                                label = '{{ __('incident.progress') }}';
                                break;
                            case 'closed':
                                badgeClass = 'badge bg-success';
                                label = '{{ __('incident.closed') }}';
                                break;
                            default:
                                badgeClass = 'badge bg-secondary';
                        }
                        return `<span class="${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // 🔹 Trigger filter when any filter changes
        $('#filterDirection, #filterAttack, #filterDetect, #filterPlaybook, #filterStatus, #filterDateFrom, #filterDateTo')
            .on('change keyup', function() {
                table.ajax.reload();
            });
    });

    $('#exportBtn').on('click', function() {
        var params = {
            direction_id: $('#filterDirection').val(),
            attack_id: $('#filterAttack').val(),
            detected_id: $('#filterDetect').val(),
            play_book_id: $('#filterPlaybook').val(),
            status: $('#filterStatus').val(),
            date_from: $('#filterDateFrom').val(),
            date_to: $('#filterDateTo').val(),
        };

        var queryString = $.param(params);
        window.location.href = "{{ route('admin.incident.export') }}?" + queryString;
    });


    function moveSelected(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var selectedOptions = Array.from(fromList.selectedOptions);
        selectedOptions.forEach(option => {
            toList.appendChild(option);
        });
    }

    function moveAll(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var allOptions = Array.from(fromList.options);
        allOptions.forEach(option => {
            toList.appendChild(option);
        });
    }

    function validateBackStep() {
        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        $('#form-step-five').addClass('action-hidden-step').removeClass('action-visible-step');

        backStep();
    }

    function validateStep() {
        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        if (activeForm.is('#form-step-four')) {

            let formData = new FormData();

            // Collect data from Step 2
            $('#form-step-one').serializeArray().forEach((field) => {
                formData.append(field.name, field.value);
            });

            $('#form-step-two').serializeArray().forEach((field) => {
                formData.append(field.name, field.value);
            });

            // Collect data from Step 3
            $('#form-step-three').serializeArray().forEach((field) => {
                formData.append(field.name, field.value);
            });

            // Collect data from Step 4
            $('#form-step-four').serializeArray().forEach((field) => {
                formData.append(field.name, field.value);
            });


            // Append files from the file input (if any)
            var fileInput = document.getElementById('incident-file-upload');
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    formData.append('file[]', fileInput.files[i]);
                }
            }

            // Append removed file IDs if any
            var removeFileIdsInput = document.getElementById('remove-file-ids');
            if (removeFileIdsInput && removeFileIdsInput.value) {
                formData.append('remove_file_ids', removeFileIdsInput.value);
            }

            $.ajax({
                url: "{{ route('admin.incident.ajax.iraStore') }}", // Laravel route to store data
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Ensure CSRF token is included
                },
                success: function(response) {
                    makeAlert('success', response.message, "{{ __('locale.Success') }}");
                    $('#update-incident-wizrd').modal('hide');
                    $('#dataTableREfresh').DataTable().ajax.reload();
                },
                error: function(error) {
                    // Handle error, e.g., show error messages
                    console.error(error);
                    alert('There was an error submitting the data.');
                }
            });

        }
        nextStep();
    }


    function validateActionStep() {
        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        if (activeForm.is('#form-step-one')) {
            $('#form-step-five').addClass('action-hidden-step').removeClass('action-visible-step');
        }
        if (activeForm.is('#form-step-two')) {
            $('#form-step-five').addClass('action-hidden-step').removeClass('action-visible-step');
        }
        if (activeForm.is('#form-step-three')) {
            $('#form-step-five').addClass('action-hidden-step').removeClass('action-visible-step');
        }
        if (activeForm.is('#form-step-four')) {
            $('#form-step-five').addClass('action-visible-step').removeClass('action-hidden-step');
        }

        if (activeForm.is('#form-step-five')) {

            // Create a FormData object to store all form data together
            let formData = new FormData();

            $('#form-step-five').serializeArray().forEach((field) => {
                formData.append(field.name, field.value);
            });

            // Send the AJAX request
            $.ajax({
                url: "{{ route('admin.incident.ajax.csritStore') }}", // Laravel route to store data
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Ensure CSRF token is included
                },
                success: function(response) {

                    makeAlert('success', response.message, "{{ __('locale.Success') }}");
                    $('#update-incident-wizrd').modal('hide');
                    $('#dataTableREfresh').DataTable().ajax.reload();
                },
                error: function(error) {
                    // Handle error, e.g., show error messages
                    console.error(error);
                    alert('There was an error submitting the data.');
                }
            });

        }


        nextStep();
    }

    //done
    function showAddEvidenceForm(action_id, incident_id, play_book_id) {
        $('[name="evidence_play_book_id"]').val(play_book_id);
        $('[name="evidence_incident_id"]').val(incident_id);
        $('[name="evidence_action_id"]').val(action_id);
        $('#addEvidenceModal').modal('show');
    }

    //done
    $('.addEvidenceToObjectiveForm').submit(function(e) {
        var formData = new FormData(document.querySelector('.addEvidenceToObjectiveForm'));
        e.preventDefault();
        $('.error').empty();
        var url = "{{ route('admin.incident.incident.storeEvidence') }}";
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                if (data.status) {

                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#addEvidenceModal').modal('hide');
                    $('[name="evidence_play_book_id"]').val();
                    $('[name="evidence_incident_id"]').val();
                    $('[name="evidence_action_id"]').val();
                    $('[name="evidence_description"]').val('');
                    $('[name="evidence_file"]').val('');
                    $('.evidences-item-' + data.data.actionId + ' .show-evidences').removeClass(
                        'd-none');
                    var evidences_count = $('.evidences-item-' + data.data.actionId +
                        ' .count-evidences').data('count');
                    evidences_count = evidences_count + 1;
                    $('.evidences-item-' + data.data.actionId + ' .count-evidences').text(
                        evidences_count);
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

    //done
    function showEvidencesList(action_id, incident_id, play_book_id) {

        var url =
            "{{ route('admin.incident.incident.getEvidences', ['action_id' => ':action_id', 'incident_id' => ':incident_id', 'play_book_id' => ':play_book_id']) }}";

        url = url.replace(':action_id', action_id)
            .replace(':incident_id', incident_id)
            .replace(':play_book_id', play_book_id);

        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},

            //   playbookId
            //   incidentId
            //  actionId

            success: function(response) {

                incident = response.data.incident;
                playBook = response.data.playBook;
                action = response.data.action;
                evidences = response.data.evidences;
                status = response.data.incident_status;
                canEditEvidences = 1;
                $('#evidencesList').empty();
                $('#incidentName').html(incident)
                $('#playbookName').html(playBook)
                $('#actionName').html(action)
                if (evidences.length) {
                    publishTableWithEvidences(evidences, canEditEvidences, status)
                } else {
                    html = '<h4 style="text-align:center; color:red">No Evidences Yet<h4>'
                    $('#evidencesList').html(html);
                }
                $('#evidencesModal').modal('show');
            }
        });
    }

    function publishTableWithEvidences(evidences, canEditEvidences = false, status) {
        // Check if 'evidences' is an array and not undefined
        if (!Array.isArray(evidences) || evidences.length === 0) {
            $('#evidencesList').html('<p>@lang('locale.NoEvidencesFound')</p>');
            return;
        }
        let table = '';
        table += "<table width=100% class='table'>";
        table += "<tbody><tr>";
        table += "<th>#</th>";
        table += "<th>@lang('locale.CreatedBy')</th>";
        table += "<th>@lang('locale.CreatedAt')</th>";
        table += "<th>@lang('locale.Actions')</th>";
        table += "</tr>";

        $.each(evidences, function(index, evidence) {
            const showEvidencesButton =
                '<a href="javascript:;" class="item-list" title="Show Evidence" style="margin: 0 5px;" onclick="showEvidenceData(' +
                evidence.id + ')">' +
                feather.icons["eye"].toSvg({
                    class: "me-1 font-small-4",
                }) +
                "</a> ";

            let editEvidenceButton = '';
            let deleteEvidenceButton = '';

            // Only show edit and delete if allowed AND status is not 'closed'
            if (canEditEvidences && status !== 'closed') {
                editEvidenceButton =
                    '<a href="javascript:;" class="item-edit" title="Edit Evidence" onClick="showEditEvidenceForm(' +
                    evidence.id + ')">' +
                    feather.icons["edit"].toSvg({
                        class: "me-50 font-small-4",
                    }) +
                    "</a> ";

                deleteEvidenceButton =
                    '<a href="javascript:;" class="item-edit" title="Delete Evidence" onClick="ShowModalDeleteEvidence(' +
                    evidence.id + ')">' +
                    feather.icons["trash-2"].toSvg({
                        class: "me-50 font-small-4",
                    }) +
                    "</a> ";
            }

            const date = new Date(evidence.created_at);
            date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000); // Convert to local timezone
            const dateFormatted = date.toISOString().split('T')[0];

            const row = '<tr><td>' + (index + 1) + '</td><td>' + evidence.created_by +
                '</td><td>' + dateFormatted +
                '</td><td>' + showEvidencesButton + editEvidenceButton + deleteEvidenceButton + '</td></tr>';

            table += row;
        });

        $('#evidencesList').html(table);
    }


    //done
    function showEvidenceData(evidenceId) {
        var url = "{{ route('admin.incident.incident.getEvidence', '') }}" + "/" + evidenceId;

        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                evidence = response;

                const date = new Date(evidence.created_at);

                date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);

                const dateFormatted = date.toISOString().split('T')[0];
                $('.view_evidence_description').val(evidence.description);
                $('.view_evidence_created_by').val(evidence.created_by);
                $('.view_evidence_created_at').val(dateFormatted);

                if (evidence.file_name) {
                    $('.view_evidence_file').html(evidence.file_name);
                    // Change the onclick event to open the file in a new view
                    $('.view_evidence_file').attr('onclick', 'viewEvidenceFile(' + evidence.id + ')');
                    $('.view_evidence_file_container').show();
                } else {
                    $('.view_evidence_file').html('');
                    $('.view_evidence_file').attr('onclick', '');
                    $('.view_evidence_file_container').hide();
                }

                $('#viewEvidenceModal').modal('show');
            }
        });
    }

    //done
    function viewEvidenceFile(evidenceId) {
        // Open the new view in a new tab to display the file
        var url = "{{ route('admin.incident.incident.evidence.view-file', '') }}" + "/" + evidenceId;
        window.open(url, '_blank', 'noopener,noreferrer');
    }

    //done
    function showEditEvidenceForm(evidenceId) {
        var url = "{{ route('admin.incident.incident.getEvidence', '') }}" + "/" +
            evidenceId;

        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                evidence = response
                $('[name="evidence_id"]').val(evidence.id);
                $('[name="edited_evidence_description"]').val(evidence.description)
                if (evidence.file_name) {
                    $('a.last_uploaded_file').html(evidence.file_name);
                    $('a.last_uploaded_file').attr('onclick', 'downloadEvidenceFile(' + evidence.id + ')');
                    $('.last_uploaded_file_container').show();
                } else {
                    $('a.last_uploaded_file').html('');
                    $('a.last_uploaded_file').attr('onclick', '');
                    $('.last_uploaded_file_container').hide();
                }
                $('#editEvidenceModal').modal('show');
            }
        });
    }

    //done
    $('.editEvidenceForm').submit(function(e) {
        var formData = new FormData(document.querySelector('.editEvidenceForm'));
        e.preventDefault();

        $('.error').empty();
        var url = "{{ route('admin.incident.incident.updateEvidence') }}";
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#editEvidenceModal').modal('hide');
                    $('[name="edited_evidence_description"]').val('');
                    $('[name="edited_evidence_file"]').val('');

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

    function downloadEvidenceFile(evidenceId) {
        var url = "{{ route('admin.incident.incident.downloadEvidenceFile', '') }}" + "/" +
            evidenceId;
        var link = document.createElement("a");
        link.href = url;
        link.style.display = "none";
        document.body.appendChild(link);

        link.click();

        // Cleanup
        document.body.removeChild(link);
    }

    // Function to delete an evidence via AJAX
    function DeleteEvidence(id) {
        // Construct the URL for deleting the evidence
        let url = "{{ route('admin.incident.incident.deleteEvidence', ':id') }}";
        url = url.replace(':id', id);

        // AJAX request to delete the evidence
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    // Display success alert and update evidences list
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");

                    actionId = data.actionId
                    playbookId = data.playbookId
                    incidentId = data.incidentId
                    canEditEvidences = 1;
                    $('#evidencesList').empty();
                    showEvidencesList(actionId, incidentId, playbookId);
                    $('.dtr-bs-modal').modal('hide');
                }
            },
            error: function(response, data) {
                // Display error alert if deletion fails
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // Function to show delete confirmation modal for an evidence
    function ShowModalDeleteEvidence(id) {
        // Display confirmation modal using SweetAlert
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
                // If confirmed, call the DeleteEvidence function
                DeleteEvidence(id);
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#submit-form').on('click', function(e) {
            e.preventDefault(); // Prevent default button behavior

            let form = $('#incidentForm');
            let formData = new FormData(form[0]);
            let submitBtn = $(this);

            submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );

            $.ajax({
                url: '{{ route('admin.incident.ajax.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        makeAlert('success', response.message,
                            "{{ __('locale.Success') }}");
                        form[0].reset(); // reset form
                        $('#add-new-incident').modal('hide');
                        $('#dataTableREfresh').DataTable().ajax.reload();
                    } else {
                        makeAlert('error', response.message, "{{ __('locale.Error') }}");
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || {};
                    form.find('.error').text('');
                    $.each(errors, function(key, value) {
                        form.find('.error-' + key).text(value[0]);
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html('{{ __('locale.Submit') }}');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize the Select2 with AJAX for searching assets
        function initAssetSelect2(selectElement) {
            selectElement.select2({
                placeholder: '{{ __('locale.Enter asset name') }}',
                minimumInputLength: 1, // Minimum characters required to trigger the search
                ajax: {
                    url: '{{ route('admin.asset_management.ajax.assets') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // The search term entered by the user
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(asset) {
                                return {
                                    id: asset.id,
                                    text: asset.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }

        // Initialize Select2 for the create modal
        initAssetSelect2($('.stepper-two select[name="affected_assets[]"]'));

        // Reset and reinitialize Select2 for each modal open
        $('#update-incident-wizrd').on('shown.bs.modal', function() {
            let modalSelect = $(this).find('select[name="affected_assets[]"]');
            modalSelect.select2('destroy'); // Destroy the previous instance
            initAssetSelect2(modalSelect); // Reinitialize Select2
        });

        // Call ShowModalEditAsset(id) with the appropriate id when needed
    });

    function calculateTotal() {
        let total = 0;
        let parts = [];
        const selects = document.querySelectorAll('.criteria-select');
        const totalScoreElement = document.getElementById('total-score');
        const equationElement = document.getElementById('equation');

        selects.forEach(function(select) {
            const option = select.options[select.selectedIndex];
            const point = parseInt(option?.getAttribute('data-point'), 10);
            const title = option?.getAttribute('data-title');

            if (!isNaN(point)) {
                total += point;
                parts.push(`${title} (${point})`);
            }
        });

        equationElement.textContent = parts.join(' + ');
        totalScoreElement.textContent = total;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.criteria-select');
        selects.forEach(function(select) {
            select.addEventListener('change', calculateTotal);
        });
        calculateTotal(); // initial load
    });


    function openIncidentPlayBookModal(playBookId, incidentId, actionId) {
        var url = "{{ route('admin.incident.showLogs', [':incidentId', ':playbookId', ':actionId']) }}"
            .replace(':incidentId', incidentId)
            .replace(':playbookId', playBookId)
            .replace(':actionId', actionId);

        // Show loading state
        $('#incidentLogsModal .modal-body').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading logs...</p>
        </div>
    `);

        const logsModal = new bootstrap.Modal(document.getElementById('incidentLogsModal'));
        logsModal.show();

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                // Clear previous content
                $('#incidentLogsModal .modal-body').empty();

                if (response.logs && response.logs.length > 0) {
                    // Create table structure
                    var html = `
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>old Action</th>
                                    <th>new Action</th>
                                    <th>Description</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                    // Append each log entry
                    response.logs.forEach(function(log) {
                        // Safe user data handling
                        var userName = 'Unknown User';
                        var userInitial = 'U';

                        if (log.user && log.user.name) {
                            userName = log.user.name;
                            userInitial = userName.charAt(0).toUpperCase();
                        }

                        // Safe date handling
                        var createdAt = 'Unknown Date';
                        if (log.created_at) {
                            createdAt = new Date(log.created_at).toLocaleString();
                        }

                        // Safe description handling
                        var description = log.description || 'No description';

                        html += `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">${userInitial}</span>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">${userName}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span >
                                    ${log.old_value || 'unknown'}
                                </span>
                            </td>
                            <td>
                                <span >
                                    ${log.new_value || 'unknown'}
                                </span>
                            </td>
                            <td>${description}</td>
                            <td>
                                <small class="text-muted">${createdAt}</small>
                            </td>
                        </tr>
                    `;
                    });

                    html += `
                            </tbody>
                        </table>
                    </div>
                `;

                    $('#incidentLogsModal .modal-body').html(html);
                } else {
                    // No logs found
                    $('#incidentLogsModal .modal-body').html(`
                    <div class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No logs found</h5>
                            <p class="text-muted">There are no logs available for this action.</p>
                        </div>
                    </div>
                `);
                }
            },
            error: function(xhr) {
                $('#incidentLogsModal .modal-body').html(`
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error loading logs. Please try again.
                </div>
            `);
                console.error('Error loading logs:', xhr);
            }
        });
    }

    function openIncidentCommentsModal(playBookId, incidentId, actionId) {
        var url = "{{ route('admin.incident.showComments', [':incidentId', ':playbookId', ':actionId']) }}"
            .replace(':incidentId', incidentId)
            .replace(':playbookId', playBookId)
            .replace(':actionId', actionId);

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                let comments = response.data;
                addMessageToChat(comments); // your custom renderer

                $('.clearCommentsBtn').attr(
                    'onclick',
                    `showModalClearComments(${incidentId}, ${playBookId}, ${actionId})`
                );

                const commentsModal = new bootstrap.Modal(document.getElementById('incidentCommentsModal'));
                commentsModal.show();

                document.getElementById('incidentCommentsModal').dataset.incidentId = incidentId;
                document.getElementById('incidentCommentsModal').dataset.playbookId = playBookId;
                document.getElementById('incidentCommentsModal').dataset.actionId = actionId;
            },
            error: function(xhr) {
                let responseData = xhr.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    }

    function addMessageToChat(comments) {
        // Reset chat content
        $('.chats').html('');

        comments.forEach(comment => {
            if (authUser.id != comment.user_id) {
                // Comment from other user
                if ($('.chat:last-child').length == 0) {
                    $('.chats').append(`
                        <div class="chat chat-left user${comment.user_id}">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <div class="avatar-content" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        title="${lang['user']}: ${comment.user_name}">
                                        ${comment.custom_user_name}
                                    </div>
                                </span>
                            </div>
                            <div class="chat-body"></div>
                        </div>
                    `);
                }

                if ($('.chat:last-child').hasClass('chat-left') && $('.chat:last-child').hasClass(
                        `user${comment.user_id}`)) {
                    $('.chat:last-child .chat-body').append(`
                        <div class="chat-content">
                            ${comment.comment ? `<p>${comment.comment}</p>` : ''} 
                            ${comment.file_display_name ? `<p class="cursor-pointer download-comment-file" data-comment-id="${comment.id}">
                                <u>${comment.file_display_name}</u>
                            </p>` : ''}
                            <p style="text-align: right"><small><b>${comment.created_at}</b></small></p>
                        </div>
                    `);
                } else {
                    $('.chats').append(`
                        <div class="chat chat-left user${comment.user_id}">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <div class="avatar-content" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        title="${lang['user']}: ${comment.user_name}">
                                        ${comment.custom_user_name}
                                    </div>
                                </span>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    ${comment.comment ? `<p>${comment.comment}</p>` : ''} 
                                    ${comment.file_display_name ? `<p class="cursor-pointer download-comment-file" data-comment-id="${comment.id}">
                                        <u>${comment.file_display_name}</u>
                                    </p>` : ''}
                                    <p style="text-align: right"><small><b>${comment.created_at}</b></small></p>
                                </div>
                            </div>
                        </div>
                    `);
                }
            } else {
                // Comment from me
                if ($('.chat:last-child').length == 0) {
                    $('.chats').append(`
                        <div class="chat">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <div class="avatar-content" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top"
                                        title="${lang['user']}: ${authUser.name}">
                                        ${authUser.initials}
                                    </div>
                                </span>
                            </div>
                            <div class="chat-body"></div>
                        </div>
                    `);
                }

                if ($('.chat:last-child').hasClass('chat-left')) {
                    $('.chats').append(`
                        <div class="chat">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <div class="avatar-content" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top"
                                        title="${lang['user']}: ${authUser.name}">
                                        ${authUser.initials}
                                    </div>
                                </span>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    ${comment.comment ? `<p>${comment.comment}</p>` : ''} 
                                    ${comment.file_display_name ? `<p class="cursor-pointer download-comment-file" data-comment-id="${comment.id}">
                                        <u>${comment.file_display_name}</u>
                                    </p>` : ''}
                                    <p style="text-align: right"><small><b>${comment.created_at}</b></small></p>
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    $('.chat:last-child .chat-body').append(`
                        <div class="chat-content">
                            ${comment.comment ? `<p>${comment.comment}</p>` : ''} 
                            ${comment.file_display_name ? `<p class="cursor-pointer download-comment-file" data-comment-id="${comment.id}">
                                <u>${comment.file_display_name}</u>
                            </p>` : ''}
                            <p style="text-align: right"><small><b>${comment.created_at}</b></small></p>
                        </div>
                    `);
                }
            }

            // Reset and scroll
            $('.message').val('');
            $('.user-chats').scrollTop($('.user-chats > .chats').height());
        });
    }

    function enterChat(modalSelector) {
        const url = "{{ route('admin.incident.sendComment') }}";
        const modal = document.querySelector(modalSelector);

        // collect dataset values
        const incidentId = modal.dataset.incidentId;
        const playbookId = modal.dataset.playbookId;
        const actionId = modal.dataset.actionId;

        // grab form inside modal
        const formElement = modal.querySelector("form");
        var formData = new FormData(formElement);

        // append identifiers
        formData.append("incident_id", incidentId);
        formData.append("playbook_id", playbookId);
        formData.append("action_id", actionId);

        const editForm = $(modalSelector);
        const message = editForm.find('.message').val();
        const attachDocumentSelector = '#attach-doc';

        if (/\S/.test(message) || ($(attachDocumentSelector).length && $(attachDocumentSelector).val())) {
            $.ajax({
                url: url,
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        makeAlert('success', response.message, lang['success']);

                        if ($('.chat:last-child').length == 0) {
                            $('.chats').append(`
                                <div class="chat">
                                    <div class="chat-avatar">
                                        <span class="avatar box-shadow-1 cursor-pointer bg-light-primary">
                                            <div class="avatar-content" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="${lang['user']} ${authUser.name}">
                                                ${authUser.initials}
                                            </div>
                                        </span>
                                    </div>
                                    <div class="chat-body"></div>
                                </div>
                            `);
                        }

                        if ($('.chat:last-child').hasClass('chat-left')) {
                            $('.chats').append(`
                                <div class="chat">
                                    <div class="chat-avatar">
                                        <span class="avatar box-shadow-1 cursor-pointer bg-light-primary">
                                            <div class="avatar-content" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top"
                                                title="${lang['user']} ${authUser.name}">
                                                ${authUser.initials}
                                            </div>
                                        </span>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                            ${message ? `<p>${message}</p>` : ''} 
                                            ${response.data.comment.file_display_name ? `
                                                <p class="cursor-pointer download-comment-file" data-comment-id="${response.data.comment.id}">
                                                    <u>${response.data.comment.file_display_name}</u>
                                                </p>` : ''}
                                            <p style="text-align: right">
                                                <small><b>${response.data.comment.formatted_created_at}</b></small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        } else {
                            $('.chat:last-child .chat-body').append(`
                                <div class="chat-content">
                                    ${message ? `<p>${message}</p>` : ''} 
                                    ${response.data.comment.file_display_name ? `
                                        <p class="cursor-pointer download-comment-file" data-comment-id="${response.data.comment.id}">
                                            <u>${response.data.comment.file_display_name}</u>
                                        </p>` : ''}
                                    <p style="text-align: right">
                                        <small><b>${response.data.comment.formatted_created_at}</b></small>
                                    </p>
                                </div>
                            `);
                        }

                        // reset inputs
                        $('.message').val('');
                        $('#attach-doc').val('');
                        $('.file-name').text('');

                        // scroll down
                        $('.user-chats').scrollTop($('.user-chats > .chats').height());
                    }
                },
                error: function(response) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                }
            });
        }
    }

    function showModalClearComments(incidentId, playBookId, actionId) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToClearComments') }}",
            text: "{{ __('locale.YouWontBeAbleToRevertThis') }}",
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
                clearComments(incidentId, playBookId, actionId);
            }
        });
    }

    function clearComments(incidentId, playBookId, actionId) {
        let url = "{{ route('admin.incident.clearComments', [':incidentId', ':playBookId', ':actionId']) }}"
            .replace(':incidentId', incidentId)
            .replace(':playBookId', playBookId)
            .replace(':actionId', actionId);

        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.chats').empty();
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    $('.chats').on('click', '.download-comment-file', function() {
        let commentId = $(this).data("comment-id");
        downloadCommentFile(commentId);
    });

    function downloadCommentFile(comment_id) {
        let url = "{{ route('admin.incident.downloadIncidentCommentFile', ':id') }}".replace(":id", comment_id);

        // Create and trigger download
        const link = document.createElement("a");
        link.href = url;
        link.target = "_blank"; // Open in new tab
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Handle change event for file to display file name
    $('.attach-doc').on('change', function() {
        const fileNamecontent = $(this).parents('.chat-app-form').prev();
        try {
            fileNamecontent.text(fileNamecontent.data('content').replace('()',
                `(${$(this)[0].files[0].name})`));
        } catch (error) {
            fileNamecontent.text('');
        }

    });


    window.lang = {
        user: "{{ __('locale.User') }}",

    };
    window.authUser = {
        id: {{ auth()->id() }},
        name: "{{ auth()->user()->name }}",
        initials: "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}"
    };


    let incidentChart = null;

    $('#incidentStatisticsModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var incidentId = button.data('incident-id');

        $.ajax({
            url: "{{ route('admin.incident.statistics', ':id') }}".replace(':id', incidentId),
            type: "GET",
            success: function(response) {
                let categories = Object.keys(response); // containments, eradications, recoveries
                let statusLabels = ['none', 'progress', 'done'];

                // Build datasets
                let seriesData = statusLabels.map(status => {
                    return {
                        name: status,
                        data: categories.map(cat => response[cat].status_counts[status] ||
                            0)
                    };
                });

                Highcharts.chart('incidentStatsChart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Incident Playbook Actions by Category'
                    },
                    xAxis: {
                        categories: categories,
                        title: {
                            text: 'Categories'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Number of Actions'
                        }
                    },
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom'
                    },
                    tooltip: {
                        shared: true,
                        headerFormat: '<b>{point.key}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/>'
                    },
                    plotOptions: {
                        column: {
                            grouping: true, // ✅ bars side-by-side
                            shadow: false
                        }
                    },
                    series: seriesData
                });
            }
        });
    });

    function deleteIncident(incidentId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This incident will be permanently deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.incident.destroy', ':id') }}".replace(':id', incidentId),
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire("Deleted!", "The incident has been deleted.", "success");

                        // reload table if using DataTables
                        if ($('#dataTableREfresh').length) {
                            $('#dataTableREfresh').DataTable().ajax.reload();
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to delete incident.", "error");
                    }
                });
            }
        });
    }

    $('#update-incident-wizrd').on('hidden.bs.modal', function() {
        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        // keep going back until form-step-one is active
        while (!activeForm.is('#form-step-one')) {
            backStep();

            // re-check after moving back
            activeForm = $('#msform form').filter(function() {
                return $(this).css('display') === 'flex';
            });
        }
    });
</script>


@endsection
