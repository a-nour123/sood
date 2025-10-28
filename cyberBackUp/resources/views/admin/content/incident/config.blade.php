@extends('admin.layouts.contentLayoutMaster')

@section('title', __('incident.incident'))

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
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

    <style>
        .nav-success .nav-link,
        .nav-pills.nav-success .nav-link {
            border: 1px solid #014d41 !important;
            color: #014d41;
            margin-bottom: 10px;
        }

        #ver-pills-tabContent {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #ver-pills-tabContent .add-new-row {
            padding: 0 20px;
            height: 35px;
            line-height: 35px;
        }

        #ver-pills-tabContent .add-new-row svg {
            height: 35px;
        }

        #ver-pills-tabContent hr {
            color: #ddd
        }

        .Likelihood-class b {
            background: #014d41;
            padding: 3px 20px;
            border-radius: 10px;
            color: #FFF;
        }

        .impact-class b {
            background: #014d41;
            padding: 10px 4px;
            border-radius: 10px;
            color: #FFF;
        }

        #classic-risk-formula {
            padding: 30px;
        }

        .wrapper {
            text-align: center;
        }

        .tabs {
            font-size: 15px;
            padding: 0px;
            list-style: none;
            background-color: #fff !important;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.05);
            display: inline-block;
            border-radius: 50px;
            position: relative;
            margin-bottom: 30px;
        }

        .tabs a {
            text-decoration: none;
            color: #777;
            padding: 0 5px;
            display: inline-block;
            position: relative;
            z-index: 1;
            transition-duration: 0.3s;
            height: 35px;
            line-height: 40px
        }


        .tabs a i {
            margin-right: 5px;
        }



        .tabs a.active {
            color: #fff !important;
        }


        #OpenAddNewAction {
            z-index: 2000 !important;
        }

        swiper-slide.swiper-data {
            text-align: start !important;
            justify-content: start !important;
            width: auto !important;
            margin-right: .5rem !important;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #44225c;
        }
    </style>

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
                                                </svg>
                                            </a></li>
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

</div>






<div class="col-sm-12 col-xl-12">
    <div class="card height-equal pt-4">

        <div class="card-body">
            <input type="hidden" name="table_name_input" class="table_name_input">
            <div class="row">
                {{--  <option value="{{ $addValueTable }}"></option>  --}}
                <div class="col-12">
                    {{--  <div class="nav flex-column nav-pills nav-success" id="ver-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        @foreach ($addValueTables as $addValueTable => $addValueTableLangKey)
                            <a class="f-w-600 nav-link tables_name" data-table = "{{ $addValueTable }}"
                                id="ver-pills-home-tab" data-bs-toggle="pill" href="#ver-pills-home" role="tab"
                                aria-controls="ver-pills-home" aria-selected="true">
                                {{ __('incident.' . $addValueTableLangKey) }}
                            </a>
                        @endforeach

                    </div>  --}}
                    <div class="wrapper">
                        <nav class="tabs">

                            <swiper-container id="menuTopExist" class="mySwiper menu-top  start  p-0" navigation="true"
                                space-between="9" slides-per-view="9">
                                @foreach ($addValueTables as $addValueTable => $addValueTableLangKey)
                                    <swiper-slide class="swiper-data">
                                        {{--  <a class="{{ in_array(Route::currentRouteName(), $item->activeRoute ?? []) ? 'active' : '' }}" href="{{ $item->url }}">{{ __('locale.' . $item->name) }}</a>  --}}
                                        <a href="#" class="nav-link tables_name"
                                            data-table = "{{ $addValueTable }}" id="ver-pills-home-tab"
                                            data-bs-toggle="pill" href="#ver-pills-home">
                                            {{ __('incident.' . $addValueTableLangKey) }}</a>
                                    </swiper-slide>
                                @endforeach

                            </swiper-container>

                            {{--  @foreach ($addValueTables as $addValueTable => $addValueTableLangKey)
                                <a href="#" class="nav-link tables_name" data-table = "{{ $addValueTable }}"
                                    id="ver-pills-home-tab" data-bs-toggle="pill" href="#ver-pills-home">
                                    {{ __('incident.' . $addValueTableLangKey) }}</a>
                            @endforeach  --}}
                        </nav>
                    </div>

                </div>
                <div class="col-12">
                    <div class="tab-content" id="ver-pills-tabContent">
                        <section id="multiple-column-form">
                            {{-- Value added repeater --}}
                            <section class="form-control-repeater values-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">
                                                        {{-- Start repeated content --}}
                                                        <div data-repeater-item class="items-values basic-data">
                                                            <div class="row d-flex align-items-end">
                                                                <div class="col-md-6 col-12">
                                                                    <input type="text" class="form-control input-val"
                                                                        name="name"
                                                                        placeholder="{{ __('locale.Name') }} " />
                                                                </div>
                                                                <div class="col-md-5 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>
                                                        {{-- End repeated content --}}
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-icon btn-primary add-new-row"
                                                                type="button" data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>{{ __('locale.Add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>

                            {{-- Asset added repeater --}}
                            <section class="form-control-repeater assets-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">
                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row d-flex asset_val align-items-end">
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control min-input-val"
                                                                        name="min_value" placeholder="Min Value" />
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control max-input-val"
                                                                        name="max_value" placeholder="Max Value" />
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control level-input-val"
                                                                        name="valuation_level_name"
                                                                        placeholder="Name" />
                                                                </div>
                                                                <div class="col-md-3 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-icon btn-primary asset-add-new-row"
                                                                type="button" data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>{{ __('locale.Add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>

                            {{--  {{ fourmal incident }}  --}}

                            <div id="classic-risk-formula" class="text-center  incident-graph d-none">


                                <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                    data-bs-target="#add-update-score">
                                    <i class="fa fa-plus"></i>
                                </button>



                                <div class="fluid-container slide-table">
                                    <h2 class="text-start">{{ __('incident.Score') }} </h2>
                                    <table id="dataTableREfresh" class=" table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('incident.criteria') }}</th>
                                                <th>{{ __('incident.score') }} ({{ __('incident.point') }})</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <h2 class="text-start mt-3">{{ __('incident.Classify') }} </h2>
                                    <table id="dataTableREfreshClassify" class=" table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('incident.priority') }} </th>
                                                <th>{{ __('incident.value') }} </th>
                                                <th>{{ __('incident.description') }} </th>
                                                <th>{{ __('incident.color') }} </th>
                                                <th>{{ __('incident.sla') }} </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>



                            </div>


                            <div class="text-center  playbook-category d-none p-3">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="containments-tab" data-bs-toggle="tab"
                                            data-bs-target="#containments" type="button" role="tab"
                                            aria-controls="containments"
                                            aria-selected="true">{{ __('incident.Containments') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="eradications-tab" data-bs-toggle="tab"
                                            data-bs-target="#eradications" type="button" role="tab"
                                            aria-controls="eradications"
                                            aria-selected="false">{{ __('incident.Eradications') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="recoveries-tab" data-bs-toggle="tab"
                                            data-bs-target="#recoveries" type="button" role="tab"
                                            aria-controls="recoveries"
                                            aria-selected="false">{{ __('incident.Recoveries') }}</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="containments" role="tabpanel"
                                        aria-labelledby="containments-tab">
                                        <div class="playbook-category-section">
                                            <div class="playbook-category-type" data-table="containments">
                                                @foreach ($containments as $containment)
                                                    <div class="row d-flex align-items-end row-selected"
                                                        data-table="containments"
                                                        data-value="{{ $containment->id }}">
                                                        <div class="col-md-6 col-12">
                                                            <input type="hidden" class="table_name_input"
                                                                value="containments" />
                                                            <input type="text" name="name"
                                                                class="form-control input-val" placeholder="Name"
                                                                value="{{ $containment->name }}" />
                                                        </div>
                                                        <div class="col-md-5 col-12 text-start">
                                                            <button
                                                                class="btn btn-outline-danger text-nowrap px-1 delete-playbook-category-value"
                                                                type="button">
                                                                <span>{{ __('locale.Delete') }}</span>
                                                            </button>
                                                            <button
                                                                class="btn btn-outline-warning text-nowrap px-1 update-row-value"
                                                                type="button">
                                                                <span>{{ __('locale.Update') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-icon btn-primary add-new-category-row"
                                                        type="button" data-repeater-create>
                                                        <i data-feather="plus" class="me-25"></i>
                                                        <span>{{ __('locale.Add') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="eradications" role="tabpanel"
                                        aria-labelledby="eradications-tab">
                                        <div class="playbook-category-section">
                                            <div class="playbook-category-type" data-table="eradications">
                                                @foreach ($eradications as $eradication)
                                                    <div class="row d-flex align-items-end row-selected"
                                                        data-table="eradications"
                                                        data-value="{{ $eradication->id }}">
                                                        <div class="col-md-6 col-12">
                                                            <input type="hidden" class="table_name_input"
                                                                value="eradications" />
                                                            <input type="text" name="name"
                                                                class="form-control input-val" placeholder="Name"
                                                                value="{{ $eradication->name }}" />
                                                        </div>
                                                        <div class="col-md-5 col-12 text-start">
                                                            <button
                                                                class="btn btn-outline-danger text-nowrap px-1 delete-playbook-category-value"
                                                                type="button">
                                                                <span>{{ __('locale.Delete') }}</span>
                                                            </button>
                                                            <button
                                                                class="btn btn-outline-warning text-nowrap px-1 update-row-value"
                                                                type="button">
                                                                <span>{{ __('locale.Update') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-icon btn-primary add-new-category-row"
                                                        type="button" data-repeater-create>
                                                        <i data-feather="plus" class="me-25"></i>
                                                        <span>{{ __('locale.Add') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="recoveries" role="tabpanel"
                                        aria-labelledby="recoveries-tab">
                                        <div class="playbook-category-section">
                                            <div class="playbook-category-type" data-table="recoveries">
                                                @foreach ($recoveries as $recovery)
                                                    <div class="row d-flex align-items-end row-selected"
                                                        data-table="recoveries" data-value="{{ $recovery->id }}">
                                                        <div class="col-md-6 col-12">
                                                            <input type="hidden" class="table_name_input"
                                                                value="recoveries" />
                                                            <input type="text" name="name"
                                                                class="form-control input-val" placeholder="Name"
                                                                value="{{ $recovery->name }}" />
                                                        </div>
                                                        <div class="col-md-5 col-12 text-start">
                                                            <button
                                                                class="btn btn-outline-danger text-nowrap px-1 delete-playbook-category-value"
                                                                type="button">
                                                                <span>{{ __('locale.Delete') }}</span>
                                                            </button>
                                                            <button
                                                                class="btn btn-outline-warning text-nowrap px-1 update-row-value"
                                                                type="button">
                                                                <span>{{ __('locale.Update') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-icon btn-primary add-new-category-row"
                                                        type="button" data-repeater-create>
                                                        <i data-feather="plus" class="me-25"></i>
                                                        <span>{{ __('locale.Add') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center  play-book d-none p-3">

                                <button class="btn btn-primary viewPlaybookModal" type="button"
                                    data-bs-toggle="modal" data-bs-target="#addPlaybookModal">
                                    <i class="fa fa-plus"></i>{{ __('locale.Add') }} {{ __('incident.PlayBook') }}
                                </button>

                                <div class="fluid-container slide-table">

                                    <table id="dataTablePlayBook" class=" table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('locale.Name') }} </th>
                                                <th>{{ __('locale.Action') }} </th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>

                            <div class="text-center  ira d-none p-3">
                                <div class="card"
                                    style="width: 50%;margin:10px auto;box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15) !important;">
                                    <div class="card-body ">
                                        <form class="row addIRAToForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label ">{{ __('locale.Name') }}</label>
                                                    <input name="name" class="form-control" id="name"
                                                        value="{{ $ira->name ?? '' }}">
                                                    <span class="error error-name"></span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                {{-- Responsible Type --}}
                                                <div class="mb-1">
                                                    <label for="title"
                                                        class="form-label">{{ __('governance.ResponsibleType') }}</label>
                                                    <div class="demo-inline-spacing">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="responsible_type" id="user" value="user"
                                                                {{ ($ira->type ?? 'user') === 'user' ? 'checked' : '' }} />
                                                            <label class="form-check-label"
                                                                for="user">{{ __('locale.User') }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="responsible_type" id="team" value="team"
                                                                {{ ($ira->type ?? '') === 'team' ? 'checked' : '' }} />
                                                            <label class="form-check-label"
                                                                for="team">{{ __('locale.Team') }}</label>
                                                        </div>
                                                    </div>
                                                    <span class="error error-responsible_type"></span>
                                                </div>
                                            </div>

                                            <div
                                                class="col-12 responsible_user {{ ($ira->type ?? 'user') === 'user' ? '' : 'd-none' }}">
                                                <div class="mb-1">
                                                    <label class="form-label ">{{ __('locale.Responsible') }}
                                                        <small>({{ __('locale.Users') }})</small></label>
                                                    <select class="select2 form-select" multiple
                                                        name="responsible_ids[]">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ isset($ira) && $ira->users->contains($user->id) ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-responsible_id"></span>
                                                </div>
                                            </div>

                                            <div
                                                class="col-12 responsible_team {{ ($ira->type ?? '') === 'team' ? '' : 'd-none' }}">
                                                <div class="mb-1">
                                                    <label class="form-label ">{{ __('locale.Responsible') }}
                                                        <small>({{ __('locale.Teams') }})</small></label>
                                                    <select class="select2 form-select" multiple name="team_ids[]">
                                                        @foreach ($teams as $team)
                                                            <option value="{{ $team->id }}"
                                                                {{ isset($ira) && $ira->teams->contains($team->id) ? 'selected' : '' }}>
                                                                {{ $team->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-team_id"></span>
                                                </div>
                                            </div>

                                            <div class="col-12 text-center mt-2">
                                                <button type="button" class="btn btn-primary me-1 btn-submit-ira">
                                                    {{ __('locale.Submit') }}
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    {{ __('locale.Cancel') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Risk Level  added repeater --}}
                            <section class="form-control-repeater risklevel-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">
                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row d-flex align-items-end">
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control name-val" name="name"
                                                                        placeholder="Risk name" />
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control value-val" name="value"
                                                                        placeholder="Value" />
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <input type="color" name="color"
                                                                        class="form-control dt-post level-color-val" />
                                                                    <span class="error error-color "></span>
                                                                </div>
                                                                <div class="col-md-3 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    {{-- <div class="row">
                                                                <div class="col-12">
                                                                    <button class="btn btn-icon btn-primary risklevel-add-new-row" type="button"
                                                                        data-repeater-create>
                                                                        <i data-feather="plus" class="me-25"></i>
                                                                        <span>{{ __('locale.Add') }}</span>
                                                                    </button>
                                                                </div>
                                                            </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>


                            {{-- Incident impact added repeater --}}
                            <section class="form-control-repeater incidentImpact-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">

                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row d-flex align-items-end">

                                                                <div class="col-md-4 col-12">
                                                                    <input type="text" name="impact"
                                                                        class="form-control input-impact"
                                                                        placeholder="impact name" value="" />
                                                                </div>
                                                                {{--  <div class="col-md-2 col-12">
                                                                            <input type="number" name="impact_value" class="form-control input-impact_value"
                                                                            placeholder="impact_value name" value="1"  readonly/>
                                                                        </div>  --}}
                                                                <div class="col-md-4 col-12">
                                                                    <input type="text" name="likelihood"
                                                                        class="form-control input-likelihood"
                                                                        placeholder="likelihood name"
                                                                        value="" />
                                                                </div>
                                                                {{--  <div class="col-md-2 col-12">
                                                                            <input type="number" name="likelihood_value" class="form-control input-likelihood_value"
                                                                            placeholder="likelihood_value name" value="1"  readonly/>
                                                                        </div>  --}}
                                                                <div class="col-md-2 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button
                                                                class="btn btn-icon btn-primary incidentImapct-add-new-row"
                                                                type="button" data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>{{ __('locale.Add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>


                            {{-- Incident level added repeater --}}
                            <section class="form-control-repeater incidentLevel-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">

                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row d-flex align-items-end">

                                                                <div class="col-md-4 col-12">
                                                                    <input type="number" name="level"
                                                                        class="form-control input-level"
                                                                        placeholder="Value" value="" />
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <input type="color" name="color"
                                                                        class="form-control input-color"
                                                                        placeholder="color" value="" />
                                                                </div>

                                                                <div class="col-md-2 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button
                                                                class="btn btn-icon btn-primary incidentLevel-add-new-row"
                                                                type="button" data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>{{ __('locale.Add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>


                            {{-- asset value Level  added repeater --}}
                            <section class="form-control-repeater assetvaluelevel-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">
                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row d-flex align-items-end">
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control name-val" name="name"
                                                                        placeholder="name" />
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <input type="text"
                                                                        class="form-control value-val" name="level"
                                                                        placeholder="level" />
                                                                </div>

                                                                <div class="col-md-3 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    {{-- <div class="row">
                                                                <div class="col-12">
                                                                    <button class="btn btn-icon btn-primary risklevel-add-new-row" type="button"
                                                                        data-repeater-create>
                                                                        <i data-feather="plus" class="me-25"></i>
                                                                        <span>{{ __('locale.Add') }}</span>
                                                                    </button>
                                                                </div>
                                                            </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>
                            {{-- asset value Level  added repeater --}}
                            <section class="form-control-repeater resolutiondays-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">
                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row d-flex align-items-end">
                                                                <div class="col-md-3 col-12">
                                                                    <input type="number" class="form-control day-val"
                                                                        name="day" placeholder="Days" />
                                                                </div>

                                                                <div class="col-md-3 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    {{-- <div class="row">
                                                                <div class="col-12">
                                                                    <button class="btn btn-icon btn-primary risklevel-add-new-row" type="button"
                                                                        data-repeater-create>
                                                                        <i data-feather="plus" class="me-25"></i>
                                                                        <span>{{ __('locale.Add') }}</span>
                                                                    </button>
                                                                </div>
                                                            </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>

                            <!-- Advanced Search (Risk catalog) -->
                            <section id="row-grouping-datatable" class="rrow-goup d-none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">{{ __('configure.RiskCatalog') }}</h4>
                                                <div class="dt-action-buttons text-end">
                                                    <div class="dt-buttons d-inline-flex">
                                                        <button
                                                            class="dt-button  btn btn-primary  me-2 add-new-risk-catalog"
                                                            type="button" data-bs-toggle="modal"
                                                            data-bs-target="#add-new-test">
                                                            {{ __('configure.add-new-risk-catalog') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Search Form -->

                                            <div class="card-body mt-2">
                                                <form class="dt_adv_search" method="POST">
                                                    <div class="row g-1 mb-md-1">
                                                        <div class="col-md-4">
                                                            <label
                                                                class="form-label">{{ __('configure.Risk') }}</label>
                                                            <input type="text" class="form-control dt-input"
                                                                data-column="2" placeholder="Risk"
                                                                data-column-index="1" />
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label
                                                                class="form-label">{{ __('configure.RiskGrouping') }}</label>
                                                            <select class="form-control dt-input dt-select select2 "
                                                                name="risk_grouping_id" id="risk_grouping"
                                                                data-column="2" data-column-index="1">
                                                                <option value="">
                                                                    {{ __('locale.select-option') }}</option>
                                                                @foreach ($risk_groupings as $risk_grouping)
                                                                    <option value="{{ $risk_grouping->id }}">
                                                                        {{ $risk_grouping->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <hr class="my-0" />
                                            <div class="card-datatable">
                                                <table class="dt-row-grouping table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{ __('locale.ID') }}</th>
                                                            <th>{{ __('configure.Risk') }}</th>
                                                            <th>{{ __('configure.RiskGrouping') }}</th>
                                                            <th>{{ __('configure.RiskFunctions') }}</th>
                                                            <th>{{ __('configure.RiskEvent') }}</th>
                                                            <th>{{ __('locale.Description') }}</th>
                                                            <th>{{ __('locale.Actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{ __('locale.ID') }}</th>
                                                            <th>{{ __('configure.Risk') }}</th>
                                                            <th>{{ __('configure.RiskGrouping') }}</th>
                                                            <th>{{ __('configure.RiskFunctions') }}</th>
                                                            <th>{{ __('configure.RiskEvent') }}</th>
                                                            <th>{{ __('locale.Description') }}</th>
                                                            <th>{{ __('locale.Actions') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="modal modal-slide-in basic-select2 fade bootstrap-select"
                                                id="add-new-test">
                                                <div class="modal-dialog sidebar-sm">
                                                    <form class="add-new-record modal-content pt-0"
                                                        action="{{ route('admin.configure.risk-catalog.store') }}"
                                                        method="post">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close">×</button>
                                                        <div class="modal-header mb-1">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('configure.add-new-risk-catalog') }}</h5>
                                                        </div>
                                                        <div class="modal-body flex-grow-1">
                                                            <div class="mb-1">
                                                                <label
                                                                    class="form-label">{{ __('configure.RiskGrouping') }}</label>
                                                                <select class="form-control select2 risk_grouping_id "
                                                                    name="risk_grouping_id">
                                                                    <option value="">
                                                                        {{ __('locale.select-option') }}</option>
                                                                    @foreach ($risk_groupings as $risk_grouping)
                                                                        <option value="{{ $risk_grouping->id }}">
                                                                            {{ $risk_grouping->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-1">
                                                                <label
                                                                    class="form-label">{{ __('locale.Function') }}</label>
                                                                <select class="form-control risk_function_id select2 "
                                                                    name="risk_function_id">
                                                                    <option value="">
                                                                        {{ __('locale.select-option') }}</option>
                                                                    @foreach ($risk_functions as $risk_function)
                                                                        <option value="{{ $risk_function->id }}">
                                                                            {{ $risk_function->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class=" mb-1">
                                                                <label class="form-label"
                                                                    for="fp-default">{{ __('configure.Risk') }}</label>
                                                                <input name="name" type="text" id="fp-default"
                                                                    class="form-control name flatpickr-basic"
                                                                    placeholder="name" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label "
                                                                    for="basic-icon-default-post">order</label>
                                                                <input type="number" name="order"
                                                                    id="basic-icon-default-post"
                                                                    class="form-control order dt-post"
                                                                    aria-label="Web Developer" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label"
                                                                    for="normalMultiSelect1">{{ __('configure.RiskEvent') }}</label>
                                                                <input name="number" type="text"
                                                                    id="basic-icon-default-post"
                                                                    class="form-control number dt-post"
                                                                    aria-label="Web Developer" />
                                                            </div>

                                                            <div class="mb-1">
                                                                <label class="form-label"
                                                                    for="exampleFormControlTextarea1">{{ __('locale.Description') }}</label>
                                                                <textarea class="form-control description" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                                                            <button type="reset" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </section>

                            <!-- Advanced Search (Threat catalog) -->
                            <section id="row-threat-datatable" class="row-threat d-none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">{{ __('locale.ThreatCatalog') }}</h4>
                                                <div class="dt-action-buttons text-end">
                                                    <div class="dt-buttons d-inline-flex">
                                                        <button
                                                            class="dt-button  btn btn-primary  me-2 add-new-threat-catalog"
                                                            type="button" data-bs-toggle="modal"
                                                            data-bs-target="#add-new-threat">
                                                            {{ __('configure.add-new-threat-catalog') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Search Form -->

                                            <div class="card-body mt-2">
                                                <form class="dt_adv_search" method="POST">
                                                    <div class="row g-1 mb-md-1">
                                                        <div class="col-md-4">
                                                            <label
                                                                class="form-label">{{ __('configure.Risk') }}</label>
                                                            <input type="text" class="form-control dt-input"
                                                                data-column="2" placeholder="Risk"
                                                                data-column-index="1" />
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label
                                                                class="form-label">{{ __('configure.ThreatGrouping') }}</label>
                                                            <input type="text" class="form-control dt-input"
                                                                data-column="3" placeholder="Group Name"
                                                                data-column-index="2" />
                                                        </div>

                                                    </div>

                                                </form>
                                            </div>
                                            <hr class="my-0" />
                                            <div class="card-datatable">
                                                <table class="dt-threat-grouping table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{ __('locale.ID') }}</th>
                                                            <th>{{ __('configure.Risk') }}</th>
                                                            <th>{{ __('configure.ThreatGrouping') }}</th>
                                                            <th>{{ __('configure.RiskEvent') }}</th>
                                                            <th>{{ __('locale.Description') }}</th>
                                                            <th>{{ __('locale.Actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{ __('locale.ID') }}</th>
                                                            <th>{{ __('configure.Risk') }}</th>
                                                            <th>{{ __('configure.ThreatGrouping') }}</th>
                                                            <th>{{ __('configure.RiskEvent') }}</th>
                                                            <th>{{ __('locale.Description') }}</th>
                                                            <th>{{ __('locale.Actions') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="modal modal-slide-in basic-select2 fade bootstrap-select"
                                                id="add-new-threat">
                                                <div class="modal-dialog sidebar-sm">
                                                    <form class="add-new-record2 modal-content pt-0"
                                                        action="{{ route('admin.configure.threat-catalog.store') }}"
                                                        method="post">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close">×</button>
                                                        <div class="modal-header mb-1">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('configure.add-new-threat-catalog') }}</h5>
                                                        </div>
                                                        <div class="modal-body flex-grow-1">
                                                            <div class="mb-1">
                                                                <label
                                                                    class="form-label">{{ __('configure.ThreatGrouping') }}</label>
                                                                <select
                                                                    class="form-control dt-input dt-select select2 threat_grouping_id "
                                                                    data-column="1" data-column-index="0"
                                                                    name="threat_grouping_id">
                                                                    <option value="">
                                                                        {{ __('locale.select-option') }}
                                                                    </option>
                                                                    @foreach ($threat_groupings as $threat_grouping)
                                                                        <option value="{{ $threat_grouping->id }}">
                                                                            {{ $threat_grouping->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class=" mb-1">
                                                                <label class="form-label"
                                                                    for="fp-default">{{ __('configure.Risk') }}</label>
                                                                <input name="name" type="text" id="fp-default"
                                                                    class="form-control name flatpickr-basic"
                                                                    placeholder="name" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label "
                                                                    for="basic-icon-default-post">order</label>
                                                                <input type="number" name="order"
                                                                    id="basic-icon-default-post"
                                                                    class="form-control order dt-post"
                                                                    aria-label="Web Developer" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label"
                                                                    for="normalMultiSelect1">{{ __('configure.RiskEvent') }}</label>
                                                                <input name="number" type="text"
                                                                    id="basic-icon-default-post"
                                                                    class="form-control number dt-post"
                                                                    aria-label="Web Developer" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label"
                                                                    for="exampleFormControlTextarea1">{{ __('locale.Description') }}</label>
                                                                <textarea class="form-control description" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                                                            <button type="reset" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="form-control-repeater tlp-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">

                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row">
                                                                <div class="col-md-4 col-12">
                                                                    <input type="text" name="name"
                                                                        class="form-control input-val"
                                                                        placeholder="Name" value="" />
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <input type="text" name="description"
                                                                        class="form-control dt-post description-val"
                                                                        value="" placeholder="Description" />
                                                                    {{--  <span class="error error-color "></span>  --}}
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <input type="color" name="color"
                                                                        class="form-control dt-post color-val"
                                                                        value="" required />
                                                                    {{--  <span class="error error-color "></span>  --}}
                                                                </div>
                                                                <div class="col-md-3 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-icon btn-primary tlp-add-new-row"
                                                                type="button" data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>{{ __('locale.Add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>
                            <section class="form-control-repeater pap-added d-none">
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="invoice-repeater ">
                                                    <div data-repeater-list="values">

                                                        <div data-repeater-item class="items-values advanced-data">
                                                            <div class="row">
                                                                <div class="col-md-4 col-12">
                                                                    <input type="text" name="name"
                                                                        class="form-control input-val"
                                                                        placeholder="Name" value="" />
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <input type="text" name="description"
                                                                        class="form-control dt-post description-val"
                                                                        value="" placeholder="Description" />
                                                                    {{--  <span class="error error-color "></span>  --}}
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <input type="color" name="color"
                                                                        class="form-control dt-post color-val"
                                                                        value="" required />
                                                                    {{--  <span class="error error-color "></span>  --}}
                                                                </div>
                                                                <div class="col-md-3 col-12 ">
                                                                    <button
                                                                        class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                                        type="button">
                                                                        <span>{{ __('locale.Save') }}</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-icon btn-primary pap-add-new-row"
                                                                type="button" data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>{{ __('locale.Add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice repeater -->
                                </div>
                            </section>
                            <!--/ Advanced Search -->
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="add-update-score">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ __('incident.IncidentScore') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="page-body">
                <div class="row my-5">
                    <div class="col-xl-12">
                        <div class="card height-equal">
                            <div class="card-header pb-0">
                            </div>

                            <div class="card-body basic-wizard important-validation">
                                <div class="stepper-horizontal" id="stepper1">
                                    <div class="stepper-one stepper step editing active">
                                        <div class="step-circle"><span>1</span></div>
                                        <div class="step-title">{{ trans('incident.define_criteria') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>
                                    <div class="stepper-two step">
                                        <div class="step-circle"><span>2</span></div>
                                        <div class="step-title">{{ trans('incident.scoring_system') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>
                                    <div class="stepper-three step">
                                        <div class="step-circle"><span>3</span></div>
                                        <div class="step-title">{{ trans('incident.classify_incident') }}</div>
                                        <div class="step-bar-left"></div>
                                        <div class="step-bar-right"></div>
                                    </div>

                                </div>

                                <div id="msform">
                                    <hr>
                                    {{-- Step 1 --}}
                                    <form class="stepper-one row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-one">
                                        <div class="criterias-section mb-0 mt-2"
                                            data-count="{{ $criterias->count() }}">
                                            @foreach ($criterias as $criteria)
                                                <div class="row criterias-line">
                                                    <input type="hidden" name="criterias[{{ $loop->index }}][id]"
                                                        value="{{ $criteria->id }}">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-1">

                                                            <input
                                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                                type="text"
                                                                name="criterias[{{ $loop->index }}][name]"
                                                                value="{{ $criteria->name }}" id="name"
                                                                value="{{ old('name') }}" required
                                                                placeholder=" {{ __('locale.name') }}">
                                                            @if ($errors->has('name'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group mb-1">

                                                            <input
                                                                class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                                                type="text"
                                                                name="criterias[{{ $loop->index }}][description]"
                                                                value="{{ $criteria->description }}"
                                                                id="description" value="{{ old('description') }}"
                                                                placeholder=" {{ __('locale.description') }} "required>
                                                            @if ($errors->has('description'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('description') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 ">
                                                        <button
                                                            class="btn btn-danger pl-2 pr-2 mb-3 remove-criterias-option"
                                                            type="button"> <i class="fa fa-trash"></i></button>
                                                    </div>
                                                    <div class="col-12 ">
                                                        <hr class="mt-0">
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button class="btn btn-primary mt-0 mb-3 new-criterias"
                                                    type="button">
                                                    {{ __('locale.Add') }}
                                                </button>
                                                <hr>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Step 2 --}}
                                    <form class="stepper-two row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-two">
                                        <div id="criteria-container"></div>
                                    </form>

                                    {{-- Step 3 --}}
                                    <form class="stepper-three row g-3 needs-validation custom-input" novalidate=""
                                        id="form-step-three">
                                        <div id="step-three-container"></div>
                                    </form>




                                </div>

                                <div class="wizard-footer d-flex gap-2 justify-content-end mt-3">
                                    <button class="btn alert-light-primary" id="backbtn" onclick="backStep()">
                                        {{ __('locale.Back') }}</button>
                                    <button class="btn btn-primary" id="nextbtn" onclick="validateStep()">
                                        {{ __('locale.Next') }}</button>

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

<div class="modal fade" tabindex="-1" aria-hidden="true" id="addPlaybookModal">
    <div class="modal-dialog modal-dialog-centered modal-sm-custom" style="width: 30%">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title add-title">{{ __('incident.AddPlayBook') }}</h1>
                    <h1 class="role-title  edit-title d-none">{{ __('incident.EditPlayBook') }}</h1>
                </div>

                <form class="row addPlaybookToControlForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Name') }}</label>
                            <input name="playbook_name" class="form-control" id="playbook_name">
                            <input type="hidden" name="playbook_id" class="playbook_id">
                            <span class="error error-playbook_name"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Responsible Type --}}
                        <div class="mb-1 playbook-responsible">
                            <label for="title" class="form-label">{{ __('governance.ResponsibleType') }}</label>
                            <div class="demo-inline-spacing">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="responsible_type"
                                        id="playbook-user" value="user" checked />
                                    <label class="form-check-label" for="user">{{ __('locale.User') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="responsible_type"
                                        id="playbook-team" value="team" />
                                    <label class="form-check-label" for="team">{{ __('locale.Team') }}</label>
                                </div>
                            </div>
                            <span class="error error-responsible_type"></span>
                        </div>
                    </div>
                    <div class="col-12 responsible_user">

                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Responsible') }}
                                <small>({{ __('locale.Users') }})</small></label>
                            <select class="select2 form-select " multiple name="responsible_ids[]">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-responsible_id"></span>
                        </div>
                    </div>
                    <div class="col-12 responsible_team d-none">

                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Responsible') }}
                                <small>({{ __('locale.Teams') }})</small></label>
                            <select class="select2 form-select" multiple name="team_ids[]">
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-team_id"></span>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <button type="button" class="btn btn-primary me-1 btn-playbook btn-submit-playbook">
                            {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
                <!--/ Evidence form -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" aria-hidden="true" id="OpenAddNewAction">
    <div class="modal-dialog modal-dialog-centered modal-sm-custom" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title add-title">{{ __('incident.AddAction') }}</h1>

                </div>

                <form class="row addActionToControlForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        {{-- Responsible Type --}}
                        <div class="mb-1">
                            <input type="hidden" name="category" id="OpenAddNewAction-category">
                            <input type="hidden" name="playbook" id="OpenAddNewAction-playbook">
                            <div class="demo-inline-spacing">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="action_type"
                                        id="action_exist" value="exist" checked />
                                    <label class="form-check-label"
                                        for="action_exist">{{ __('incident.existingAction') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="action_type"
                                        id="action_new" value="new" />
                                    <label class="form-check-label"
                                        for="action_new">{{ __('incident.newAction') }}</label>
                                </div>
                            </div>
                            <span class="error error-action_type"></span>
                        </div>
                    </div>
                    <div class="col-12 action_type_exist">
                        <div class="mb-1">
                            <label class="form-label ">{{ __('incident.actions') }} </label>
                            <select class="select2 form-select" name="action_id">

                            </select>
                            <span class="error error-action_id"></span>
                        </div>
                    </div>
                    <div class="col-12 action_type_new d-none">
                        <div class="mb-1">
                            <label class="form-label ">{{ __('incident.NewAction') }}</label>
                            <input type="text" name="action_name" class="form-control" id="action_name">
                            <span class="error error-team_id"></span>
                        </div>
                    </div>


                    <div class="col-12 text-center mt-2">
                        <button type="button" class="btn btn-primary me-1 btn-submit-playbook-action">
                            {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeActionModal" aria-hidden="true" id="PlayBookActionModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeActionModal">{{ __('incident.PlayBookActions') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="page-body p-3">
                <div class="row my-5">
                    <div class="col-12">
                        <ul class="nav nav-tabs mb-4" id="myActionTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="action-containments-tab" data-bs-toggle="tab"
                                    data-bs-target="#action-containments" type="button" role="tab"
                                    aria-controls="action-containments"
                                    aria-selected="true">{{ __('incident.Containments') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="action-eradications-tab" data-bs-toggle="tab"
                                    data-bs-target="#action-eradications" type="button" role="tab"
                                    aria-controls="action-eradications"
                                    aria-selected="false">{{ __('incident.Eradications') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="action-recoveries-tab" data-bs-toggle="tab"
                                    data-bs-target="#action-recoveries" type="button" role="tab"
                                    aria-controls="action-recoveries"
                                    aria-selected="false">{{ __('incident.Recoveries') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myActionTabContent">
                            <div class="tab-pane fade show active" id="action-containments" role="tabpanel"
                                aria-labelledby="action-containments-tab">

                                <button class=" btn btn-primary  add-new-action mb-3" type="button"
                                    data-table="containments" data-playbook="">
                                    <i class="fa fa-plus"></i> {{ __('incident.addAction') }}
                                </button>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> {{ __('incident.actionTitle') }}</th>
                                            <th> {{ __('locale.Category') }}</th>
                                            <th>{{ __('locale.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="action-eradications" role="tabpanel"
                                aria-labelledby="action-eradications-tab">
                                <button class=" btn btn-primary  add-new-action mb-3" type="button"
                                    data-table="eradications" data-playbook="">
                                    <i class="fa fa-plus"></i> {{ __('incident.addAction') }}
                                </button>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> {{ __('incident.actionTitle') }}</th>
                                            <th> {{ __('locale.Category') }}</th>
                                            <th>{{ __('locale.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="action-recoveries" role="tabpanel"
                                aria-labelledby="action-recoveries-tab">
                                <button class=" btn btn-primary  add-new-action mb-3" type="button"
                                    data-table="recoveries" data-playbook="">
                                    <i class="fa fa-plus"></i> {{ __('incident.addAction') }}
                                </button>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> {{ __('incident.actionTitle') }}</th>
                                            <th> {{ __('locale.Category') }}</th>
                                            <th>{{ __('locale.Action') }}</th>
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


@endsection
@section('vendor-script')

<script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>

<script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
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

@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<!-- <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script> -->


<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>


<script src="{{ asset('new_d/js/form-wizard/form-wizard.js') }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>

<script>
    $(document).ready(function() {

        function toggleResponsibleType() {
            if ($('#user').is(':checked')) {
                $('.responsible_user').removeClass('d-none');
                $('.responsible_team').addClass('d-none');
            } else if ($('#team').is(':checked')) {
                $('.responsible_team').removeClass('d-none');
                $('.responsible_user').addClass('d-none');
            }
        }

        toggleResponsibleType();

        // Run on page load to show the correct dropdown


        function togglePlayBookResponsibleType() {
            if ($('#playbook-user').is(':checked')) {
                $('.responsible_user').removeClass('d-none');
                $('.responsible_team').addClass('d-none');
            } else if ($('#playbook-team').is(':checked')) {
                $('.responsible_team').removeClass('d-none');
                $('.responsible_user').addClass('d-none');
            }
        }

        // Run on page load to show the correct dropdown
        togglePlayBookResponsibleType();

        // Listen for changes on the radio buttons
        $('input[name="responsible_type"]').change(toggleResponsibleType);
        $('.playbook-responsible input[name="responsible_type"]').change(togglePlayBookResponsibleType);



        function toggleActionType() {
            if ($('#action_exist').is(':checked')) {
                $('.action_type_exist').removeClass('d-none');
                $('.action_type_new').addClass('d-none');
            } else if ($('#action_new').is(':checked')) {
                $('.action_type_new').removeClass('d-none');
                $('.action_type_exist').addClass('d-none');
            }
        }

        // Run on page load to show the correct dropdown
        toggleActionType();

        // Listen for changes on the radio buttons
        $('input[name="action_type"]').change(toggleActionType);

        $(document).on('click', '.viewPlaybookModal', function(e) {
            $('#addPlaybookModal .add-title').removeClass('d-none');
            $('#addPlaybookModal .edit-title').addClass('d-none');
            $('input[name="responsible_type"][value="user"]').prop('checked', true).trigger('change');

            $('#addPlaybookModal .select2').val(null).trigger('change');
            // Show/hide responsible sections based on the default radio button state
            $('.responsible_user').removeClass('d-none');
            $('.responsible_team').addClass('d-none');
            $('#addPlaybookModal .btn-playbook')
                .addClass('btn-submit-playbook')
                .removeClass('btn-update-playbook');
            let form = $('.addPlaybookToControlForm');
            form.trigger('reset');
        });

        $(document).on('click', '.btn-submit-playbook', function(e) {
            e.preventDefault(); // Prevent the button's default action

            let form = $('.addPlaybookToControlForm'); // Reference to the form element
            let formData = new FormData(form[0]); // Serialize form data with file support
            let baseRoute = "{{ route('admin.incident.configure.store_playbook') }}"; // Route URL

            $.ajax({
                url: baseRoute,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#dataTablePlayBook').DataTable().ajax.reload();
                        $('#addPlaybookModal').modal('hide'); // Hide the modal
                        form.trigger('reset'); // Clear the form

                    } else {
                        alert('An error occurred.');
                    }
                },
                error: function(xhr) {

                    $('.error').html('');

                    // Loop through each error and display it
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('.error-' + key).html(value[0]);
                    });
                }
            });
        });

        $(document).on('click', '.btn-submit-ira', function(e) {
            e.preventDefault(); // Prevent the button's default action

            let form = $('.addIRAToForm'); // Reference to the form element
            let formData = new FormData(form[0]); // Serialize form data with file support
            let baseRoute = "{{ route('admin.incident.configure.store_ira') }}"; // Route URL

            $.ajax({
                url: baseRoute,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status) {
                        makeAlert('success', response.message,
                            "{{ __('locale.Success') }}");

                    } else {
                        alert('An error occurred.');
                    }
                },
                error: function(xhr) {

                    $('.error').html('');

                    // Loop through each error and display it
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('.error-' + key).html(value[0]);
                    });
                }
            });
        });


        $(document).on('click', '.btn-update-playbook', function(e) {
            e.preventDefault(); // Prevent the button's default action

            let form = $('.addPlaybookToControlForm'); // Reference to the form element
            let formData = new FormData(form[0]); // Serialize form data with file support
            let baseRoute = "{{ route('admin.incident.configure.update_playbook') }}"; // Route URL

            $.ajax({
                url: baseRoute,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#dataTablePlayBook').DataTable().ajax.reload();
                        $('#addPlaybookModal').modal('hide'); // Hide the modal
                        form.trigger('reset'); // Clear the form

                    } else {
                        alert('An error occurred.');
                    }
                },
                error: function(xhr) {

                    $('.error').html('');

                    // Loop through each error and display it
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('.error-' + key).html(value[0]);
                    });
                }
            });
        });

        $('.add-new-category-row').click(function() {
            // Create the HTML for the new row
            let table_name = $(this).parents('.playbook-category-section').find(
                '.playbook-category-type').data('table');

            const newRow = `
                <div class="row d-flex align-items-end row-selected mb-3">
                    <div class="col-md-6 col-12">
                        <input type="text" name="name" class="form-control input-val" placeholder="Name" />
                    </div>
                    <div class="col-md-3 col-12 text-start">
                        <input type="hidden" class="table_name_input" value="${table_name}" />
                        <button class="btn btn-outline-danger text-nowrap px-1 save-category-item" type="button">
                            <span>{{ __('locale.Save') }}</span>
                        </button>
                    </div>
                </div>

            `;

            // Append the new row before the "Add" button row
            $(this).parents('.playbook-category-section').find('.playbook-category-type').append(
                newRow);
        });

        $(document).on('click', '.delete-playbook-category-value', function() {
            var _that = $(this).parents('.row-selected');
            var value = _that.data('value');
            var table_name = $(this).parents('.row-selected').data('table');
            console.log(table_name)

            let baseRoute = "{{ route('admin.configure.values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                },
                error: function(response) {
                    makeAlert('error', 'Error occure while deleting');
                }
            });

        });

        $(document).on('click', '.save-category-item', function() {
            var table_name = $(this).parents('.row-selected').find('.table_name_input').val();

            var name = $(this).parents('.row-selected').find('.input-val').val();
            var _that = $(this).parents('.row-selected');
            $.ajax({

                url: "{{ route('admin.configure.values.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name
                },
                success: function(response) {
                    var data = `
                                <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}" >
                                    <div class="col-md-6 col-12">
                                          <input type="hidden" class="table_name_input" value="${table_name}" />
                                        <input type="text" name="name" class="form-control input-val"
                                        placeholder="Name" value="${name}" />
                                    </div>
                                    <div class="col-md-5 col-12 text-start">
                                        <button class="btn btn-outline-danger text-nowrap px-1 delete-playbook-category-value"
                                            type="button">
                                            <span>{{ __('locale.Delete') }}</span>
                                        </button>
                                        <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                            <span>{{ __('locale.Update') }}</span>
                                        </button>
                                    </div>
                                </div>
                                <hr />
                            `;
                    _that.parents('.playbook-category-type').append(data);
                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!',
                        '👋 Created!');
                }
            });
        });
    });

    function ShowModalDeletePlayBook(id) {
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
                // If confirmed, call the DeletePlayBook function
                DeletePlayBook(id);
            }
        });
    }
    // Function to delete an objective via AJAX
    function DeletePlayBook(id) {

        // Construct the URL for deleting the objective
        let url = "{{ route('admin.incident.configure.delete_playbook', ':id') }}";
        url = url.replace(':id', id);

        // AJAX request to delete the objective
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#dataTablePlayBook').DataTable().ajax.reload();
                    $('.dtr-bs-modal').modal('hide');
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function showEditPlaybookForm(id) {
        var url = "{{ route('admin.incident.configure.edit_playbook', '') }}" + "/" +
            id;
        $('[name="playbook_id"]').val(id);
        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                if (response.success) {
                    $('#addPlaybookModal .add-title').addClass('d-none');
                    $('#addPlaybookModal .edit-title').removeClass('d-none');
                    // Populate the modal fields with the response data
                    $('#playbook_name').val(response.playbook.name);
                    $('input[name="responsible_type"][value="' + response.playbook.type + '"]').prop(
                        'checked', true);

                    // Show/hide responsible sections based on type
                    if (response.playbook.type === 'user') {
                        $('.responsible_user').removeClass('d-none');
                        $('.responsible_team').addClass('d-none');
                        $('select[name="responsible_ids[]"]').val(response.playbook.responsible_ids)
                            .trigger('change');
                    } else {
                        $('.responsible_user').addClass('d-none');
                        $('.responsible_team').removeClass('d-none');
                        $('select[name="team_ids[]"]').val(response.playbook.team_ids).trigger('change');
                    }
                    $('#addPlaybookModal .btn-playbook')
                        .removeClass('btn-submit-playbook')
                        .addClass('btn-update-playbook');
                    $('#addPlaybookModal').modal('show');
                } else {
                    alert(response.message); // Handle the error message if needed
                }
            }
        });
    }

    function showPlayBookActionForm(id) {
        var url = "{{ route('admin.incident.configure.getPlayBookActionData', '') }}" + "/" + id;
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {

                var playbookId = response.playbook_id;

                renderTable(response);

                $('.add-new-action').each(function() {
                    $(this).attr('data-playbook', playbookId);
                });

                $('#PlayBookActionModal').modal('show');
            }
        });
    }

    function showPlayBookActionFormTrigger(id) {

        var url = "{{ route('admin.incident.configure.getPlayBookActionData', '') }}" + "/" + id;

        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                renderTable(response);
            }
        });
    }

    function renderTable(response) {


        // Clear previous content
        $('#action-containments table tbody').html('');
        $('#action-eradications table tbody').html('');
        $('#action-recoveries table tbody').html('');

        // Populate Containments tab
        response.containments.forEach(action => {
            const options = `<option value="" disabled selected>@lang('locale.Choose')</option>` +
                response.containmentOptions.map(option =>
                    `<option value="${option.id}" ${option.id == action.pivot.category_id ? 'selected' : ''}>${option.name}</option>`
                ).join('');

            $('#action-containments table tbody').append(`
                           <tr>
                               <td> ${action.title}</td>
                               <td>
                                    <select class="select2 form-select playbook-category-select"  data-id="${action.id}" data-playbook="${response.playbook_id}">
                                       ${options}
                                   </select>
                               </td>
                                <td>
                                    <a href="#" class="delete-playbook-action btn btn-danger ms-2 "  data-id="${action.id}" data-playbook="${response.playbook_id}">  <i class="fa fa-trash" ></i></a>
                                </td>
                           </tr>
                       `);
        });


        // Populate Eradications tab
        response.eradications.forEach(action => {
            const options = `<option value="" disabled selected>@lang('locale.Choose')</option>` +
                response.eradicationOptions.map(option =>
                    `<option value="${option.id}" ${option.id == action.pivot.category_id ? 'selected' : ''}>${option.name}</option>`
                ).join('');

            $('#action-eradications table tbody').append(`
                           <tr>
                               <td> ${action.title}</td>
                               <td>
                                  <select class="select2 form-select playbook-category-select"  data-id="${action.id}" data-playbook="${response.playbook_id}">
                                       ${options}
                                   </select>
                               </td>
                                <td>
                                    <a href="#" class="delete-playbook-action btn btn-danger ms-2 "  data-id="${action.id}" data-playbook="${response.playbook_id}">  <i class="fa fa-trash" ></i></a>
                                </td>
                           </tr>
                       `);
        });

        // Populate Recoveries tab
        response.recoveries.forEach(action => {
            const options = `<option value="" disabled selected>@lang('locale.Choose')</option>` +
                response.recoveryOptions.map(option =>
                    `<option value="${option.id}" ${option.id == action.pivot.category_id ? 'selected' : ''}>${option.name}</option>`
                ).join('');

            $('#action-recoveries table tbody').append(`
                           <tr>
                               <td> ${action.title}</td>
                               <td>
                                  <select class="select2 form-select playbook-category-select"  data-id="${action.id}" data-playbook="${response.playbook_id}">
                                       ${options}
                                   </select>
                               </td>
                                <td>
                                    <a href="#" class="delete-playbook-action btn btn-danger ms-2 "  data-id="${action.id}" data-playbook="${response.playbook_id}">  <i class="fa fa-trash" ></i></a>
                                </td>
                           </tr>
                       `);
        });

    }

    $(document).on('click', '.add-new-action', function() {

        var category = $(this).data('table');
        var playBookId = $(this).attr('data-playbook');
        console.log(playBookId);
        $('#OpenAddNewAction #OpenAddNewAction-category').val(category);
        $('#OpenAddNewAction #OpenAddNewAction-playbook').val(playBookId);

        var url = "{{ route('admin.incident.configure.getActionData', '') }}";

        $.ajax({
            url: url,
            type: "GET",
            data: {
                category: category,
                playBookId: playBookId
            },
            success: function(response) {
                if (response.success) {
                    $('select[name="action_id"]').empty();
                    $('select[name="action_id"]').append(
                        '<option value="" disabled selected>{{ __('locale.Choose') }}</option>'
                    );
                    response.actions.forEach(function(action) {
                        $('select[name="action_id"]').append(`
                            <option value="${action.id}">${action.title.trim()}</option>
                        `);
                    });
                    $('input[name="action_type"]').trigger('change');
                } else {
                    console.error('Failed to load actions:', response);
                }
            }
        });
        $('#OpenAddNewAction').modal('show');
    });

    $(document).on('click', '.btn-submit-playbook-action', function(e) {
        e.preventDefault();

        let form = $('.addActionToControlForm');
        let formData = new FormData(form[0]);
        let baseRoute = "{{ route('admin.incident.configure.store_playbook_action') }}";

        $.ajax({
            url: baseRoute,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response)
                if (response.success) {
                    showPlayBookActionFormTrigger(response.playbook);
                    $('#OpenAddNewAction').modal('hide');
                    form.trigger('reset');
                } else {
                    alert('An error occurred.');
                }
            },
            error: function(xhr) {

                $('.error').html('');

                // Loop through each error and display it
                $.each(xhr.responseJSON.errors, function(key, value) {
                    $('.error-' + key).html(value[0]);
                });
            }
        });
    });

    $(document).on('click', '.delete-playbook-action', function() {
        var action = $(this).data('id');
        var playbook = $(this).data('playbook');
        ShowModalDeletePlayBookAction(action, playbook);
    });

    $(document).on('change', '.playbook-category-select', function() {
        var action = $(this).data('id');
        var playbook = $(this).data('playbook');

        let url = "{{ route('admin.incident.configure.update_playbook_action', [':id', ':playbook']) }}";
        url = url.replace(':id', action);
        url = url.replace(':playbook', playbook);
        let category_id = $(this).val();

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                category_id: category_id
            },

            success: function(response) {
                if (response.status) {
                    makeAlert('success', response.message, "{{ __('locale.success') }}");
                    showPlayBookActionFormTrigger(response.playbook);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    });

    function ShowModalDeletePlayBookAction(action, playbook) {
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
                // If confirmed, call the DeletePlayBookAction function
                DeletePlayBookAction(action, playbook);
            }
        });
    }
    // Function to delete an objective via AJAX
    function DeletePlayBookAction(action, playbook) {


        // Construct the URL for deleting the objective
        let url = "{{ route('admin.incident.configure.delete_playbook_action', [':id', ':playbook']) }}";
        url = url.replace(':id', action);
        url = url.replace(':playbook', playbook);

        // AJAX request to delete the objective
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showPlayBookActionFormTrigger(response.playbook);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }
</script>

<script>
    var index = $('.criterias-section').data('count');
    $(document).on('click', '.new-criterias', function() {
        $('.criterias-section').append(`
                <div class="row criterias-line">
                     <div class="col-md-3">
                        <div class="form-group mb-1">

                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text" name="criterias[${index}][name]"   value="{{ old('name') }}"
                            placeholder=" {{ __('locale.name') }}" required>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-1">

                            <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                            type="text" name="criterias[${index}][description]"  value="{{ old('description') }}"
                        placeholder=" {{ __('locale.description') }} "required>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                        </div>
                    </div>

                    <div class="col-md-1 ">
                        <button class="btn btn-danger pl-2 pr-2 mb-3 remove-criterias-option" type="button"> <i class="fa fa-trash"></i></button>
                    </div>
                    <div class="col-12 ">
                        <hr class="mt-0">
                    </div>
                </div>
    `);
        index++;
    });
    $(document).on('click', '.remove-criterias-option', function() {
        $(this).parents('.criterias-line').remove();
    });

    $(function() {

        $('#dataTableREfresh').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.incident.configure.getScoreData') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'criteria',
                    name: 'criteria',
                    orderable: false
                },
                {
                    data: 'score',
                    name: 'score',
                    orderable: false
                }
            ],
            searching: false,
            lengthChange: false,
            paging: false,
            info: false,

        });
        $('#dataTablePlayBook').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.incident.configure.getPlaybookData') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'name',
                    name: 'name',
                    orderable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false
                }
            ],
            {{--  searching: false,
            lengthChange: false,
            paging: false,
            info: false,  --}}

        });

        $('#dataTableREfreshClassify').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.incident.configure.getClassifyData') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'priority',
                    name: 'priority',
                    orderable: false
                },
                {
                    data: 'value',
                    name: 'value',
                    orderable: false
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false
                },
                {
                    data: 'color',
                    name: 'color',
                    orderable: false,
                    render: function(data, type, row) {
                        return `<span style="display: inline-block; width: 15px; height: 15px; border-radius: 50%; background-color: ${data};"></span>`;
                    }
                },
                {
                    data: 'sla',
                    name: 'sla',
                    orderable: false
                }
            ],
            searching: false,
            lengthChange: false,
            paging: false,
            info: false,

        });




    });
</script>
<script>
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

    function validateStep() {
        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        // Check if Step 1 is active
        if (activeForm.is('#form-step-one')) {
            // Perform validation for Step 1
            var isValid = true;
            var formData = {};

            activeForm.find('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.text-danger').text('This field is required.');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.text-danger').text('');
                    // Collect form data
                }
            });

            // If validation fails, stop here
            if (!isValid) return;


            activeForm.find('input').each(function() {
                formData[$(this).attr('name')] = $(this).val();
            });


            $.ajax({
                url: "{{ route('admin.incident.configure.store_criteria') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(response) {
                    if (response.success) {
                        populateStepTwo(response.criterias);
                        nextStep();
                    }
                },
                error: function(error) {
                    console.log('AJAX error:', error);
                }
            });
        } else if (activeForm.is('#form-step-two')) {
            var isValid = true;
            var stepTwoData = {};

            // Perform validation for Step 2
            activeForm.find('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.text-danger').text('This field is required.');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.text-danger').text('');
                }
            });

            // Custom validation for point uniqueness and maximum allowed score
            var validData = [];
            $('.criterion-item').each(function() {
                var isValid = true;
                var points = [];
                var pointInputs = $(this).find('input[name*="[point]"]');
                var maxAllowedValue = pointInputs
                    .length; // Set maximum allowed value as the count of point inputs
                var $errorContainer = $(this).find('.invaild-points');
                $errorContainer.text(''); // Clear previous error messages

                // Loop through each point input to validate
                pointInputs.each(function() {
                    var point = parseInt($(this).val());

                    // Check if the point value is not greater than the max allowed value
                    if (!isNaN(point) && (point < 1 || point > maxAllowedValue)) {
                        isValid = false;
                        validData.push(false);
                        $(this).addClass('is-invalid'); // Add invalid class for styling
                        $errorContainer.text(`(Point value must be between 1 and ${maxAllowedValue}.)`);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).siblings('.invaild-points').text('');
                    }

                    points.push(point);
                });

                // Check for duplicate points within this criterion
                var uniquePoints = [...new Set(points)];
                if (uniquePoints.length !== points.length) {
                    isValid = false;
                    validData.push(false);
                    $errorContainer.append('( Points within the same criterion must be unique. )');
                } else if (isValid) {
                    $errorContainer.text('');
                }
            });


            if (validData.includes(false)) {
                isValid = false;
            }


            if (!isValid) return;

            // Collect form data for Step 2
            activeForm.find('input').each(function() {
                stepTwoData[$(this).attr('name')] = $(this).val();
            });

            // Submit form data for Step 2
            $.ajax({
                url: "{{ route('admin.incident.configure.store_score') }}", // Adjust route as needed
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: stepTwoData,
                success: function(response) {
                    if (response.success) {
                        populateStepThree(response.criteriaScores, response.totalMaxScore, response
                            .classifies);
                        nextStep();
                    }
                },
                error: function(error) {
                    console.log('AJAX error:', error);
                }
            });
        } else if (activeForm.is('#form-step-three')) {

            var isValid = true;
            var stepThreeData = {};

            // Perform validation for Step 3
            activeForm.find('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.text-danger').text('This field is required.');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.text-danger').text('');
                }
            });


            var validData = [];
            var totalMaxScore = $('.total_score_class').val();

            $('.scoring-item').each(function() {
                var itemIsValid = true;
                var values = [];
                var valueInputs = $(this).find('input[name*="[value]"]');
                var $errorContainer = $(this).find('.invaild-value');
                $errorContainer.text(''); // Clear previous error messages

                // Validate each value input
                valueInputs.each(function() {
                    var value = parseInt($(this).val());

                    // Check if value is within the allowed range (1 to totalMaxScore)
                    if (!isNaN(value) && (value < 1 || value > totalMaxScore)) {
                        isValid = false;
                        itemIsValid = false;
                        validData.push(false);
                        $(this).addClass('is-invalid');
                        $errorContainer.text(`Value must be between 1 and ${totalMaxScore}.`);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).siblings('.invaild-value').text('');
                    }

                    values.push(value);
                });

                var uniqueValues = [...new Set(values)];
                if (uniqueValues.length !== values.length) {
                    isValid = false;
                    validData.push(false);
                    $errorContainer.append(' (Values within the same scoring item must be unique.)');
                    // Highlight duplicate values
                    valueInputs.each(function() {
                        const occurrences = values.filter(val => val === parseInt($(this).val()))
                            .length;
                        if (occurrences > 1) {
                            $(this).addClass('is-invalid');
                        }
                    });
                } else if (isValid) {
                    $errorContainer.text('');
                }


            });

            if (validData.includes(false)) {
                isValid = false;
            }

            if (!isValid) return;

            // Collect form data for Step 3
            activeForm.find('input, select').each(function() {
                stepThreeData[$(this).attr('name')] = $(this).val();
            });

            // Submit form data for Step 3
            $.ajax({
                url: "{{ route('admin.incident.configure.store_classify') }}", // Adjust this route as needed
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: stepThreeData,
                success: function(response) {

                    if (response.success) {
                        $('#dataTableREfresh').DataTable().ajax.reload();
                        $('#dataTableREfreshClassify').DataTable().ajax.reload();
                        $('#add-update-score').modal('hide');
                    }
                },
                error: function(error) {
                    console.log('AJAX error:', error);
                }
            });
        } else {
            nextStep();
        }
    }

    function populateStepTwo(criterias) {
        const $criteriaContainer = $("#criteria-container");
        $criteriaContainer.empty(); // Clear any existing content

        $.each(criterias, function(index, criteria) {
            // Create a div to hold each criterion
            const $criterionDiv = $(`
                <div class="criterion-item">
                    <div class="mb-3">
                        <h5>${criteria.name} <span style="color:red;" class="invaild-points"></span></h5>
                        <input type="hidden" name="criterias[${index}][id]" value="${criteria.id}">
                        <div class="points-container mt-2">
                            <div class="row"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary add-point" data-index="${index}">Add</button>
                    </div>
                    <hr>
                </div>
            `);

            // Container to hold points input fields
            const $pointsContainer = $criterionDiv.find(".points-container .row");

            // Function to add a point input row
            function addPointInput(scoreIndex = '', score = {
                title: '',
                point: ''
            }) {
                const $pointInput = $(`
                    <div class="col-md-12 mb-2 point-item">
                        <div class="row">
                            <div class="col-md-5">
                                 ${score.id ? `<input type="hidden" name="criterias[${index}][points][${scoreIndex}][id]" value="${score.id}">` : ''}
                                <input type="text" name="criterias[${index}][points][${scoreIndex}][title]"
                                       class="form-control" placeholder="Title" value="${score.title}" required>
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="criterias[${index}][points][${scoreIndex}][point]"
                                       class="form-control mb-1" value="${score.point}" min="1" placeholder="Point" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-point"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `);
                $pointsContainer.append($pointInput);
            }

            // Variable to track the next available score index
            let scoreCount = 0;

            // Add existing points
            $.each(criteria.incident_scores, function(scoreIndex, score) {
                addPointInput(scoreCount, score);
                scoreCount++; // Increment the index after adding each existing score
            });

            // Event listener to add new point inputs when "Add" is clicked
            $criterionDiv.on("click", ".add-point", function() {
                addPointInput(scoreCount); // Use the current scoreCount for the new point
                scoreCount++; // Increment the score count for the next new point
            });

            // Event listener to remove a point input when "Delete" is clicked
            $criterionDiv.on("click", ".remove-point", function() {
                $(this).closest(".point-item").remove();
                scoreCount--; // Decrement the score count when a point is removed
            });

            // Append the criterion div to the container
            $criteriaContainer.append($criterionDiv);
        });
    }

    function populateStepThree(criteriaScores, totalMaxScore, scoringData = []) {
        const $stepThreeContainer = $("#step-three-container"); // Ensure this container exists in your HTML
        $stepThreeContainer.empty(); // Clear any existing content

        // Display total score
        let totalScoreHtml =
            `<input type="hidden" class="total_score_class" value="${totalMaxScore}"> <p><strong>Total Score </strong> = `;
        criteriaScores.forEach((criteria, index) => {
            totalScoreHtml += `${criteria.max_score} (${criteria.name})`;
            if (index < criteriaScores.length - 1) totalScoreHtml += ' + ';
        });
        totalScoreHtml += ` = ${totalMaxScore} @lang('incident.points')</p><hr>`;
        $stepThreeContainer.append(totalScoreHtml);

        // Global variable to keep track of the index for scoring items
        let scoringIndex = scoringData.length > 0 ? scoringData.length :
            1; // Start from the length of existing data or 1

        // Function to generate scoring HTML with existing values or empty for new entries
        function createScoringItem(index, id = '', priority = '', value = '', color = '', sla = '', description = '') {
            return `
                <div class="scoring-item row mb-3">
                     ${id ? ` <input type="hidden" name="classifies[${index}][id]" value="${id}">` : ''}
                    <div class="col-md-3 mb-2"><input type="text" name="classifies[${index}][priority]" class="form-control" value="${priority}" placeholder="Priority" required></div>
                    <div class="col-md-3 mb-2"><input type="number" name="classifies[${index}][value]" class="form-control" value="${value}" placeholder="Value" required></div>
                    <div class="col-md-3 mb-2"><input type="color" name="classifies[${index}][color]" class="form-control" value="${color}" placeholder="Color" required></div>
                    <div class="col-md-3 mb-2"><input type="number" name="classifies[${index}][sla]" class="form-control" value="${sla}" placeholder="SLA" required></div>
                    <div class="col-md-9 mb-2"><input type="text" name="classifies[${index}][description]" class="form-control" value="${description}" placeholder="Description"></div>
                    <div class="col-md-3 mb-2"><button type="button" class="btn btn-danger btn-sm remove-item"><i class="fa fa-trash"></i></button></div>
                    <div class="col-12"><span style="color:red;" class="invaild-value"></span></div>
                    <div class="col-12"><hr></div>
                </div>`;
        }

        // Initial scoring input fields with existing data
        const $inputContainer = $('<div id="input-container"></div>');
        scoringData.forEach((item, index) => {
            const scoringHtml = createScoringItem(index, item.id, item.priority, item.value, item.color, item
                .sla, item.description);
            $inputContainer.append(scoringHtml);
        });

        // Append an empty item if there is no data
        if (scoringData.length === 0) {
            $inputContainer.append(createScoringItem(0));
        }
        $stepThreeContainer.append($inputContainer);

        // Add button for new scoring inputs
        $stepThreeContainer.append('<button type="button" class="btn btn-primary btn-sm" id="add-item">Add</button>');

        // Event listener for Add button to add new empty fields
        $("#add-item").on("click", function() {
            $inputContainer.append(createScoringItem(scoringIndex));
            scoringIndex++; // Increment the index for the next new item
        });

        // Event listener for Delete buttons within scoring items
        $stepThreeContainer.on("click", ".remove-item", function() {
            $(this).closest(".scoring-item").remove();
            // Optionally update the indices here if needed
            // e.g., renumbering the remaining scoring items (if you want sequential indices)
        });
    }
</script>
<script>
    var tabs = $('.tabs');
    var selector = $('.tabs').find('a').length;
    //var selector = $(".tabs").find(".selector");
    var activeItem = tabs.find('.active');
    var activeWidth = activeItem.innerWidth();
    $(".selector").css({
        "left": activeItem.position.left + "px",
        "width": activeWidth + "px"
    });

    $(".tabs").on("click", "a", function(e) {
        e.preventDefault();
        $('.tabs a').removeClass("active");
        $(this).addClass('active');
        var activeWidth = $(this).innerWidth();
        var itemPos = $(this).position();
        $(".selector").css({
            "left": itemPos.left + "px",
            "width": activeWidth + "px"
        });
    });


    function filterColumn(i, val) {
        $('.dt-row-grouping ').DataTable().column(i).search(val, false, true).draw();
    }

    function filterColumn2(i, val) {
        $('.dt-threat-grouping ').DataTable().column(i).search(val, false, true).draw();
    }

    function makeAlert($status, message, title) {
        // On load Toast
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }
</script>

<script>
    // when select item fill rows from db
    $('.tables_name').on('click', function() {
        var table_name = $(this).data('table');

        $('.table_name_input').val(table_name);

        if (table_name == 'asset_values') {
            $.ajax({
                url: "{{ route('admin.configure.asset_values.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.asset-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.assets-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                        $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row d-flex align-items-end asset_val row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-4">
                                    <input type="text" name="min_value" class="form-control min-input-val"
                                    placeholder="Min Value" value="${value.min_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="max_value" class="form-control max-input-val"
                                    placeholder="Max Value" value="${value.max_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="valuation_level_name" class="form-control level-input-val"
                                    placeholder="Name" value="${value.valuation_level_name}" />
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.assets-added').removeClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'risk_levels') {
            $.ajax({
                url: "{{ route('admin.configure.risklevel.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.risklevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').removeClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            /*data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder="Risk name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${value.value}" name="value" placeholder="Value" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.color}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;*/
                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder="Risk name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${value.value}" name="value" placeholder="Value" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.color}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.risklevel-added').removeClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'graph') {

            $('.risklevel-added').addClass('d-none');
            $('.incidentImpact-added').addClass('d-none');
            $('.incidentLevel-added').addClass('d-none');
            $('.values-added').addClass('d-none');
            $('.tlp-added').addClass('d-none');
                                    $('.pap-added').addClass('d-none');

            $('.incident-graph').removeClass('d-none');
            $('.ira').addClass('d-none');
            $('.playbook-category').addClass('d-none');
            $('.play-book').addClass('d-none');
            $('.advaced-data').html('');
            $('#row-grouping-datatable').addClass('d-none');

        } else if (table_name == 'ira') {

            $('.risklevel-added').addClass('d-none');
            $('.incidentImpact-added').addClass('d-none');
            $('.incidentLevel-added').addClass('d-none');
            $('.values-added').addClass('d-none');
            $('.tlp-added').addClass('d-none');
                                    $('.pap-added').addClass('d-none');

            $('.incident-graph').addClass('d-none');
            $('.ira').removeClass('d-none');
            $('.playbook-category').addClass('d-none');
            $('.play-book').addClass('d-none');
            $('.advaced-data').html('');
            $('#row-grouping-datatable').addClass('d-none');

        } else if (table_name == 'play_book_category') {

            $('.risklevel-added').addClass('d-none');
            $('.incidentImpact-added').addClass('d-none');
            $('.incidentLevel-added').addClass('d-none');
            $('.values-added').addClass('d-none');
            $('.tlp-added').addClass('d-none');
                                    $('.pap-added').addClass('d-none');

            $('.incident-graph').addClass('d-none');
            $('.ira').addClass('d-none');
            $('.playbook-category').removeClass('d-none');
            $('.play-book').addClass('d-none');
            $('.advaced-data').html('');
            $('#row-grouping-datatable').addClass('d-none');

        } else if (table_name == 'play_book') {

            $('.risklevel-added').addClass('d-none');
            $('.incidentImpact-added').addClass('d-none');
            $('.incidentLevel-added').addClass('d-none');
            $('.values-added').addClass('d-none');
            $('.tlp-added').addClass('d-none');
                                    $('.pap-added').addClass('d-none');

            $('.incident-graph').addClass('d-none');
            $('.ira').addClass('d-none');
            $('.playbook-category').addClass('d-none');
            $('.play-book').removeClass('d-none');
            $('.advaced-data').html('');
            $('#row-grouping-datatable').addClass('d-none');

        } else if (table_name == 'incident_impacts') {
            $.ajax({
                url: "{{ route('admin.incident.impacts.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.incidentImapct-add-new-row').css('display', 'block');
                        $('.incidentLevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').removeClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {

                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                    <div class="col-md-4 col-12">
                                    <input type="text" name="impact" class="form-control input-impact"
                                    placeholder="impact name" value="${value.impact}" />
                                </div>

                                <div class="col-md-4 col-12">
                                    <input type="text" name="likelihood" class="form-control input-likelihood"
                                    placeholder="likelihood name" value="${value.likelihood}" />
                                </div>

                                <div class="col-md-4 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.advanced-data').html('');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').removeClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'incident_levels') {
            $.ajax({
                url: "{{ route('admin.incident.levels.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.incidentImapct-add-new-row').css('display', 'block');
                        $('.incidentLevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').removeClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                                        $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {

                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                    <div class="col-md-4 col-12">
                                    <input type="number" name="level" class="form-control input-level"
                                    placeholder="value" value="${value.level}" />
                                </div>

                                <div class="col-md-4 col-12">
                                    <input type="color" name="color" class="form-control dt-post input-color" value="${value.color}"
                                        required />
                                    {{--  <span class="error error-color "></span>  --}}
                                </div>

                                <div class="col-md-4 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.advanced-data').html('');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                                        $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'resolution_days') {
            $.ajax({
                url: "{{ route('admin.configure.assetvaluelevel.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.risklevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                                        $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {

                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder=" name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${parseInt(value.level)}" name="level" placeholder="level"  readonly/>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.assetvaluelevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                                        $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'asset_value_levels') {
            $.ajax({
                url: "{{ route('admin.configure.assetvaluelevel.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.risklevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                                        $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {

                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder=" name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${parseInt(value.level)}" name="level" placeholder="level"  readonly/>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.assetvaluelevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').addClass('d-none');
                                                                        $('.pap-added').addClass('d-none');

                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'risk_catalogs') {
            // route to fetch data from table
            let url = "{{ route('admin.configure.risk-catalog.index') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {
                    $('.row-group').removeClass('d-none');
                    $('.values-added').addClass('d-none');
                    $('.row-threat').addClass('d-none');
                    $('.risklevel-added').addClass('d-none');
                    $('.incidentImpact-added').addClass('d-none');
                    $('.incidentLevel-added').addClass('d-none');
                    $('.assetvaluelevel-added').addClass('d-none');
                    $('.tlp-added').addClass('d-none');
                                                                    $('.pap-added').addClass('d-none');

                    $('.incident-graph').addClass('d-none');
                    $('.ira').addClass('d-none');
                    $('.playbook-category').addClass('d-none');
                    $('.play-book').addClass('d-none');
                    $('.advanced-data').html('');
                    $('.assets-added').addClass('d-none');
                    $('.basic-data').html('');
                    // after fetch data create datatable
                    createDatatable(data);
                    //   alert(1);
                },
                error: function() {
                    //
                }
            });


            function filterColumn(i, val) {

                $('.dt-row-grouping').DataTable().column(i).search(val, false, true).draw();

            }
        } else if (table_name == 'threat_catalogs') {

            // route to fetch data from table
            let url = "{{ route('admin.configure.threat-catalog.index') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {
                    $('.row-threat').removeClass('d-none');
                    $('.row-group').addClass('d-none');
                    $('.values-added').addClass('d-none');
                    $('.risklevel-added').addClass('d-none');
                    $('.incidentImpact-added').addClass('d-none');
                    $('.incidentLevel-added').addClass('d-none');
                    $('.assetvaluelevel-added').addClass('d-none');
                    $('.tlp-added').addClass('d-none');
                                                                    $('.pap-added').addClass('d-none');

                    $('.incident-graph').addClass('d-none');
                    $('.ira').addClass('d-none');
                    $('.playbook-category').addClass('d-none');
                    $('.play-book').addClass('d-none');
                    $('.advanced-data').html('');
                    $('.assets-added').addClass('d-none');
                    $('.basic-data').html('');
                    // after fetch data create datatable
                    createDatatable2(data);
                    //   alert(1);
                },
                error: function() {
                    //
                }
            });


            function filterColumn2(i, val) {

                $('.dt-threat-grouping').DataTable().column(i).search(val, false, true).draw();

            }
        } else if (table_name == 'tlp_levels') {
            $.ajax({
                url: "{{ route('admin.incident.tlp.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.add-new-row').css('display', 'none');
                        $('.tlp-add-new-row').css('display', 'block');
                        $('.pap-add-new-row').css('display', 'none');
                        $('.values-added').addClass('d-none');
                        $('.tlp-added').removeClass('d-none');
                                                                        $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.assets-added').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-4 col-12">
                                    <input type="text" name="name" class="form-control input-val"
                                    placeholder="Name" value="${value.name}" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="text" name="description" class="form-control dt-post description-val" value="${value.description}"
                                        required />
                                    <span class="error error-description "></span>
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.color}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>

                                <div class="col-md-4 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;

                            $('.advanced-data').append(data);
                        });

                    } else {
                        $('.tlp-added').removeClass('d-none');
                                                $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        // $('.assets-added').removeClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                        $('#row-threat-datatable').addClass('d-none');

                        $('.basic-data').html('');
                        $('.advanced-data').html('');
                    }
                },
                error: function(response) {

                }
            });

        } else if (table_name == 'pap_levels') {
            $.ajax({
                url: "{{ route('admin.incident.pap.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.add-new-row').css('display', 'none');
                        $('.tlp-add-new-row').css('display', 'none');
                        $('.pap-add-new-row').css('display', 'block');
                        $('.values-added').addClass('d-none');
                        $('.pap-added').removeClass('d-none');
                        $('.tlp-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.assets-added').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-4 col-12">
                                    <input type="text" name="name" class="form-control input-val"
                                    placeholder="Name" value="${value.name}" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="text" name="description" class="form-control dt-post description-val" value="${value.description}"
                                        required />
                                    <span class="error error-description "></span>
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.color}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>

                                <div class="col-md-4 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;

                            $('.advanced-data').append(data);
                        });

                    } else {
                        $('.pap-added').removeClass('d-none');
                        $('.tlp-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        // $('.assets-added').removeClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                        $('#row-threat-datatable').addClass('d-none');

                        $('.basic-data').html('');
                        $('.advanced-data').html('');
                    }
                },
                error: function(response) {

                }
            });

        } else
            $.ajax({
                url: "{{ route('admin.configure.values.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.add-new-row').css('display', 'block');
                        $('.tlp-added').addClass('d-none');
                        $('.pap-added').addClass('d-none');
                        $('.incident-graph').addClass('d-none');
                        $('.ira').addClass('d-none');
                        $('.playbook-category').addClass('d-none');
                        $('.play-book').addClass('d-none');
                        $('.values-added').removeClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.incidentImpact-added').addClass('d-none');
                        $('.incidentLevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.assets-added').addClass('d-none');
                        $('.basic-data:not(:first-of-type)').remove();
                        $('.basic-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-6 col-12">
                                    <input type="text" name="name" class="form-control input-val"
                                    placeholder="Name" value="${value.name}" />
                                </div>
                                <div class="col-md-5 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.basic-data').append(data);
                        });
                    } else {
                        $('.values-added').removeClass('d-none');
                        // $('.assets-added').removeClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                        $('#row-threat-datatable').addClass('d-none');
                        $('.basic-data').html('');
                        $('.advanced-data').html('');
                    }
                },
                error: function(response) {}
            });
    });

    // add new row (Hide add button)
    $('.add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    $('.asset-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    $('.incidentImapct-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });
    $('.incidentLevel-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });
    $('.tlp-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });
    $('.pap-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    
    $('.risklevel-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    //store item
    $(document).on('click', '.save-item', function() {
        {{--  var table_name = $('.tables_name').val();  --}}
        var table_name = $('.table_name_input').val();

        var _that = $(this).parents('.row-selected');
        if (table_name == 'asset_values') {

            var min_value = $(this).parents('.asset_val').find('.min-input-val').val();
            var max_value = $(this).parents('.asset_val').find('.max-input-val').val();
            var valuation_level_name = $(this).parents('.asset_val').find('.level-input-val').val();
            var _that = $(this).parents('.asset_val');

            $.ajax({
                url: "{{ route('admin.configure.asset_values.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    min_value: min_value,
                    max_value: max_value,
                    valuation_level_name: valuation_level_name
                },
                success: function(response) {
                    $('.asset-add-new-row').css('display', 'block');
                    var data = `
                    <div class="row d-flex align-items-end asset_val row-selected" data-table ="${table_name}" data-value="${response.id}" >

                        <div class="col-md-3 col-4">
                                    <input type="text" name="min_value" class="form-control input-val"
                                    placeholder="Name" value="${response.min_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="max_value" class="form-control input-val"
                                    placeholder="Name" value="${response.max_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="valuation_level_name" class="form-control input-val"
                                    placeholder="Name" value="${response.valuation_level_name}" />
                                </div>
                        <div class="col-md-3 col-12 ">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                type="button">
                                <span>{{ __('locale.Delete') }}</span>
                            </button>
                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                <span>{{ __('locale.Update') }}</span>
                            </button>
                        </div>
                    </div>
                    <hr />
                    `;
                    _that.parent().remove();
                    $('.advanced-data').append(data);
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');

                }
            });
        } else if (table_name == 'risk_levels') {

            var name = $(this).parents('.advanced-data').find('.name-val').val();
            var colorvalue = $(this).parents('.advanced-data').find('.value-val').val();
            var _that = $(this).parents('.advanced-data');

            $.ajax({
                url: "{{ route('admin.configure.risklevel.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    colorvalue: colorvalue,
                    name: name
                },
                success: function(response) {
                    $('.risklevel-add-new-row').css('display', 'block');

                    var data;
                    data = `
                  <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}"  >
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control name-val" name="name"  value="${response.name}" placeholder="Risk name" />
                      </div>
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control value-val" value="${response.value}" name="value" placeholder="Value" />
                      </div>
                      <div class="col-md-2 col-12">
                          <input type="color" name="color" class="form-control dt-post level-color-val" value="black" required />
                          <span class="error error-color "></span>
                      </div>
                      <div class="col-md-3 col-12 ">
                          <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                              type="button">
                              <span>{{ __('locale.Delete') }}</span>
                          </button>
                          <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                              <span>{{ __('locale.Update') }}</span>
                          </button>
                      </div>
                  </div>
                  <hr />
                  `;
                    $('.advanced-data').append(data);

                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'incident_impacts') {
            var impact = $(this).parents('.advanced-data').find('.input-impact').val();
            var likelihood = $(this).parents('.advanced-data').find('.input-likelihood').val();
            var _that = $(this).parents('.advanced-data');

            $.ajax({
                url: "{{ route('admin.incident.impacts.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    impact: impact,
                    likelihood: likelihood,
                },
                success: function(response) {
                    $('.incidentImapct-add-new-row').css('display', 'block');

                    var data;
                    data = `
                  <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}"  >

                       <div class="col-md-4 col-12">
                            <input type="text" name="impact" class="form-control input-impact"
                            placeholder="impact name" value="${response.impact}" />
                        </div>

                            <div class="col-md-4 col-12">
                            <input type="text" name="likelihood" class="form-control input-likelihood"
                            placeholder="likelihood name" value="${response.likelihood}" />
                        </div>


                        <div class="col-md-2 col-12 ">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                type="button">
                                <span>{{ __('locale.Delete') }}</span>
                            </button>
                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                <span>{{ __('locale.Update') }}</span>
                            </button>
                        </div>

                  </div>
                  <hr />
                  `;
                    $('.advanced-data').append(data);

                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'incident_levels') {
            var level = $(this).parents('.advanced-data').find('.input-level').val();
            var color = $(this).parents('.advanced-data').find('.input-color').val();
            var _that = $(this).parents('.advanced-data');

            $.ajax({
                url: "{{ route('admin.incident.levels.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    level: level,
                    color: color,
                },
                success: function(response) {
                    $('.incidentLevel-add-new-row').css('display', 'block');

                    var data;
                    data = `
                  <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}"  >

                       <div class="col-md-4 col-12">
                            <input type="number" name="level" class="form-control input-level"
                            placeholder="level" value="${response.level}" />
                        </div>

                           <div class="col-md-4 col-12">
                                <input type="color" name="color" class="form-control  input-color" value="${response.color}"
                                    required />

                            </div>


                        <div class="col-md-2 col-12 ">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                type="button">
                                <span>{{ __('locale.Delete') }}</span>
                            </button>
                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                <span>{{ __('locale.Update') }}</span>
                            </button>
                        </div>

                  </div>
                  <hr />
                  `;
                    $('.advanced-data').append(data);

                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'asset_value_levels') {

            var name = $(this).parents('.advanced-data').find('.name-val').val();
            var colorvalue = $(this).parents('.advanced-data').find('.value-val').val();
            var _that = $(this).parents('.advanced-data');

            $.ajax({
                url: "{{ route('admin.configure.assetvaluelevel.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    colorvalue: colorvalue,
                    name: name
                },
                success: function(response) {
                    $('.assetvaluelevel-add-new-row').css('display', 'block');

                    var data;
                    data = `
                  <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}"  >
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control name-val" name="name"  value="${response.name}" placeholder=" name" />
                      </div>
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control value-val" value="${response.level}" name="value" placeholder="Level" />
                      </div>

                      <div class="col-md-3 col-12 ">
                          <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                              type="button">
                              <span>{{ __('locale.Delete') }}</span>
                          </button>
                          <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                              <span>{{ __('locale.Update') }}</span>
                          </button>
                      </div>
                  </div>
                  <hr />
                  `;
                    $('.advanced-data').append(data);

                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'tlp_levels') {
            var name = $(this).parents('.advanced-data').find('.input-val').val();
            var color = $(this).parents('.advanced-data').find('.color-val').val();
            var description = $(this).parents('.advanced-data').find('.description-val').val();
            var _that = $(this).parents('.advanced-data');
            $.ajax({
                url: "{{ route('admin.incident.tlp.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    color: color,
                    description: description,

                },
                success: function(response) {
                    $('.tlp-add-new-row').css('display', 'block');
                    var data = `
                                    <div class="row  row-selected" data-table ="${table_name}" data-value="${response.incident.id}" >
                                        <div class="col-md-4 col-12">
                                            <input type="text" name="name" class="form-control input-val"
                                            placeholder="Name" value="${response.incident.name}" />
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <input type="text" name="description" placeholder="Description" class="form-control dt-post description-val" value="${response.incident.description}"
                                                 />
                                            <span class="error error-description "></span>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <input type="color" name="color" class="form-control dt-post color-val" value="${response.incident.color}"
                                                required />
                                            <span class="error error-color "></span>
                                        </div>
                                        <div class="col-md-4 col-12 ">
                                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                                type="button">
                                                <span>{{ __('locale.Delete') }}</span>
                                            </button>
                                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                                <span>{{ __('locale.Update') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                    <hr />
                                    `;
                    $('.advanced-data').append(data);
                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'pap_levels') {
            var name = $(this).parents('.advanced-data').find('.input-val').val();
            var color = $(this).parents('.advanced-data').find('.color-val').val();
            var description = $(this).parents('.advanced-data').find('.description-val').val();
            var _that = $(this).parents('.advanced-data');
            $.ajax({
                url: "{{ route('admin.incident.pap.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    color: color,
                    description: description,

                },
                success: function(response) {
                    $('.pap-add-new-row').css('display', 'block');
                    var data = `
                                    <div class="row row-selected" data-table ="${table_name}" data-value="${response.incident.id}" >
                                        <div class="col-md-4 col-12">
                                            <input type="text" name="name" class="form-control input-val"
                                            placeholder="Name" value="${response.incident.name}" />
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <input type="text" name="description" placeholder="Description" class="form-control dt-post description-val" value="${response.incident.description}"
                                                 />
                                            <span class="error error-description "></span>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <input type="color" name="color" class="form-control dt-post color-val" value="${response.incident.color}"
                                                required />
                                            <span class="error error-color "></span>
                                        </div>
                                        <div class="col-md-4 col-12 ">
                                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                                type="button">
                                                <span>{{ __('locale.Delete') }}</span>
                                            </button>
                                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                                <span>{{ __('locale.Update') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                    <hr />
                                    `;
                    $('.advanced-data').append(data);
                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else {
            {{--  var table_name = $('.tables_name').val();  --}}
            var table_name = $('.table_name_input').val();

            var name = $(this).parents('.basic-data').find('.input-val').val();
            var _that = $(this).parents('.basic-data');
            $.ajax({

                url: "{{ route('admin.configure.values.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name
                },
                success: function(response) {
                    $('.add-new-row').css('display', 'block');
                    var data = `
                    <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}" >
                        <div class="col-md-6 col-12">
                            <input type="text" name="name" class="form-control input-val"
                            placeholder="Name" value="${name}" />
                        </div>
                        <div class="col-md-5 col-12 ">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                type="button">
                                <span>{{ __('locale.Delete') }}</span>
                            </button>
                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                <span>{{ __('locale.Update') }}</span>
                            </button>
                        </div>
                    </div>
                    <hr />
                    `;
                    $('.basic-data').append(data);
                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        }
    });

    // update items from list
    $(document).on('click', '.update-row-value', function() {

        var _that = $(this).parents('.row-selected');
        var table_name = _that.data('table');
        var value = _that.data('value');
        if (table_name == 'asset_values') {
            // var name = _that.find('.input-val').val();
            var min_value = $(this).parents('.asset_val').find('.min-input-val').val();
            var max_value = $(this).parents('.asset_val').find('.max-input-val').val();
            var valuation_level_name = $(this).parents('.asset_val').find('.level-input-val').val();
            let baseRoute = "{{ route('admin.configure.asset_values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    min_value: min_value,
                    max_value: max_value,
                    valuation_level_name: valuation_level_name
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else if (table_name == 'risk_levels') {
            var name = $(this).parents('.row-selected').find('[name="name"]').val();
            var color = $(this).parents('.row-selected').find('[name="color"]').val();
            var colorvalue = $(this).parents('.row-selected').find('[name="value"]').val();

            let baseRoute = "{{ route('admin.configure.risklevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    colorvalue: colorvalue,
                    color: color
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else if (table_name == 'incident_impacts') {
            var impact = $(this).parents('.row-selected').find('[name="impact"]').val();
            var likelihood = $(this).parents('.row-selected').find('[name="likelihood"]').val();


            let baseRoute = "{{ route('admin.incident.impacts.update') }}";
            $.ajax({
                url: baseRoute,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    id: value,
                    impact: impact,
                    likelihood: likelihood
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });

        } else if (table_name == 'incident_levels') {
            var level = $(this).parents('.row-selected').find('[name="level"]').val();
            var color = $(this).parents('.row-selected').find('[name="color"]').val();

            let baseRoute = "{{ route('admin.incident.levels.update') }}";
            $.ajax({
                url: baseRoute,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    id: value,
                    level: level,
                    color: color
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });

        } else if (table_name == 'asset_value_levels') {
            var name = $(this).parents('.row-selected').find('[name="name"]').val();
            var color = $(this).parents('.row-selected').find('[name="color"]').val();
            var colorvalue = $(this).parents('.row-selected').find('[name="value"]').val();

            let baseRoute = "{{ route('admin.configure.assetvaluelevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    colorvalue: colorvalue,
                    color: color
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else if (table_name == 'tlp_levels') {
            var color = _that.find('.color-val').val();
            var name = _that.find('.input-val').val();
            var description = _that.find('.description-val').val();
            let baseRoute = "{{ route('admin.incident.tlp.update') }}";
            $.ajax({
                url: baseRoute,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: value,
                    name: name,
                    color: color,
                    description: description
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        }else if (table_name == 'pap_levels') {
            var color = _that.find('.color-val').val();
            var name = _that.find('.input-val').val();
            var description = _that.find('.description-val').val();
            let baseRoute = "{{ route('admin.incident.pap.update') }}";
            $.ajax({
                url: baseRoute,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: value,
                    name: name,
                    color: color,
                    description: description
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else {
            // var value2 = _that.data('value');
            var name = _that.find('.input-val').val();
            let baseRoute = "{{ route('admin.configure.values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        }
    });

    // delete item from list
    $(document).on('click', '.delete-row-value', function() {
        var _that = $(this).parents('.row-selected');
        var value = _that.data('value');
        {{--  var table_name = $('.tables_name').val();  --}}
        var table_name = $('.table_name_input').val();

        if (table_name == 'asset_values') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.configure.asset_values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'risk_levels') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.configure.risklevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'incident_impacts') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.incident.impacts.delete') }}";
            $.ajax({
                url: baseRoute,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    id: value
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'incident_levels') {
            let baseRoute = "{{ route('admin.incident.levels.delete') }}";
            $.ajax({
                url: baseRoute,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    id: value
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'tlp_levels') {
            let baseRoute = "{{ route('admin.incident.tlp.delete') }}";
            $.ajax({
                url: baseRoute,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    id: value
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        }else if (table_name == 'pap_levels') {
            let baseRoute = "{{ route('admin.incident.pap.delete') }}";
            $.ajax({
                url: baseRoute,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    id: value
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'asset_value_levels') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.configure.assetvaluelevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else {
            let baseRoute = "{{ route('admin.configure.values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                },
                error: function(response) {
                    makeAlert('error', 'Error occure while deleting');
                }
            });
        }
    });

    $('.add-new-risk-catalog').on('click', function() {
        $('.add-new-record').attr('action', "risk-catalog");
        $('.add-new-record').attr('method', "post");
        // $('#add-new-test').reset();
    });



    $(document).on('click', '.item-edit', function(e) {
        id = $(this).data('id');
        {{--  var table_name = $('.tables_name').val();  --}}
        var table_name = $('.table_name_input').val();


        $.ajax({
            url: "risk-catalog/" + id + "/edit",
            type: 'get',
            data: {
                table_name: table_name
            },
            success: function(response) {
                $('.add-new-record .name').val(response.name);
                $('.add-new-record .order').val(response.order);
                $('.add-new-record .number').val(response.number);
                $('.add-new-record .description').val(response.description);
                $('.add-new-record .risk_grouping_id').select2().val(response.risk_grouping_id)
                    .trigger("change");
                $('.add-new-record .risk_function_id').select2().val(response.risk_function_id)
                    .trigger("change");
                $('#add-new-test').modal('show');
                $('.add-new-record').attr('action', "risk-catalog/" + id);
                $('.add-new-record').attr('method', "put");
            }
        });
    });


    // risk group
    $('.add-new-record2').on('submit', function(e) {
        e.preventDefault();
        {{--  var table_name = $('.tables_name').val();  --}}
        var table_name = $('.table_name_input').val();

        data = $(this).serialize();
        method = $('.add-new-record2').attr('method');
        $.ajax({
            url: $(this).attr('action'),
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                table_name: table_name,
                data: data,
            },
            success: function(response) {
                location.reload();
                // $('#add-new-threat').modal('hide');
                // $('#add-new-test').modal('hide');
                // if (response == 'update') {
                //     $("#row-threat-datatable").load(location.href + " #row-threat-datatable>*",
                //         "");
                //     loadDatatable2();
                //     makeAlert('success', 'You have successfully Update Exist value!',
                //         '👋 Updated!');
                // } else {
                //     $("#row-threat-datatable").load(location.href + " #row-threat-datatable>*",
                //         "");
                //     loadDatatable2();
                //     makeAlert('success', 'You have successfully added new value!', '👋 Created!');

                // }
            }
        });
    });



    $(document).ready(function() {
        $('.tables_name:first').addClass('active').trigger('click');
    });
</script>
@endsection
