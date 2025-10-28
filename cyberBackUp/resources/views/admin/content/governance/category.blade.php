@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.DocumentProgram'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/dragula.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">


    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">

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
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>



@endsection


@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-todo.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <!-- Page css files -->

    <style>
        html .navbar-floating.footer-static .app-content .content-area-wrapper,
        html .navbar-floating.footer-static .app-content .kanban-wrapper {
            height: auto !important;
        }

        #documentation-chart {
            /* box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); */
            /* border-radius: 10px; */
        }

        .widget-1 {
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        #view_type_sorting {
            font-family: "FontAwesome";
            font-size: 14px;
        }

        #view_type_sorting::before {
            vertical-align: middle;
        }

        .tab button:hover {
            background-color: #bee9f7;
        }

        .tab button.active {
            background-color: #6398a8;
        }

        .gov_btn {
            border-color: #50785f;
            background-color: #50785f;
            color: #fff !important;
            /* padding: 7px; */
            border: 1px solid transparent;
            padding: 0.786rem 1.5rem;
            line-height: 1;
            border-radius: 0.358rem;
            font-weight: 500;
            font-size: 1rem;
        }

        .gov_btn_edit {
            border-color: #5388B4 !important;
            background-color: #5388B4 !important;
            color: #fff !important;
            border: 1px solid transparent;
            padding: 0.786rem 1.5rem;
            line-height: 1;
            border-radius: 0.358rem;
            font-weight: 500;
            font-size: 1rem;
        }

        .gov_btn_map {
            border-color: #6c757d !important;
            background-color: #6c757d !important;
            color: #fff !important;
            border: 1px solid transparent;
            padding: 0.786rem 1.5rem;
            line-height: 1;
            border-radius: 0.358rem;
            font-weight: 500;
            font-size: 1rem;
        }

        .gov_check {
            padding: 0.786rem 0.7rem;
            line-height: 1;
            font-weight: 500;
            font-size: 1.2rem;
        }

        .gov_err {

            color: red;
        }

        .bg-success {
            --bs-bg-opacity: 1;
            background-color: rgb(83 161 118 / 65%) !important;
            background-color: rgb(83 161 118 / 65%) !important;
        }

        .bg-danger {
            --bs-bg-opacity: 1;
            background-color: rgb(234 84 85 / 85%) !important;
        }

        .frame .card-title {
            display: inline-block;
            color: #000;
            font-size: 1rem !important;
        }

        .frame .card-desc {
            display: inline-block;
            color: #6e6c6c;
        }

        .card-body .btn {
            margin-right: 5px;

        }

        .card-body form {
            margin-bottom: 0;

        }

        .todo-application .content-area-wrapper .content-right .todo-task-list-wrapper .todo-task-list li:not(:first-child) {
            border-top: 0 !important;
        }

        .todo-application .content-area-wrapper .content-right .todo-task-list-wrapper .todo-task-list .pagination li {
            padding: 0;
        }

        .card2 {
            padding: 0.893rem 1.5rem;
            margin-top: 0px;
        }

        .row.data-table {
            padding: 0.893rem 1.5rem;

        }

        .tab button {
            margin: 0;
        }

        .form-select {
            display: inline-block;
        }

        .dataTables_filter {
            float: right !important;
        }

        .dataTables_filter input {
            display: inline-block !important;
            width: auto !important;
        }

        .multiple-select2 {
            z-index: 99999999;
        }

        #privacy2 {
            display: none
        }

        #approval_date2 {
            display: none
        }

        #reviewer {
            display: none
        }

        #todo-task-table {
            overflow: hidden;
            /* Prevent horizontal scrolling */
        }



        /* .ps--active-x, */
        .ps__rail-x {
            display: none !important;
        }

        .card {
            width: 99%;
        }

        #todo-task-table_wrapper .dataTables_scrollBody {
            overflow-x: hidden !important;
        }

        .list-group i {
            margin-right: 0px !important;
        }

        .todo-task-list.media-list {
            background: #f2f2f2 !important;
        }

        .classframe .card-desc {
            display: inline-block;
            color: #6e6c6c;
        }

        .classframe .card-title {
            display: inline-block;
            color: #000;
            font-size: 1rem !important;
        }

        .modal-actions {
            margin-top: 20px;
            text-align: right;
        }


        .statistics-container {
            display: flex;
            gap: 1.5rem;
        }

        .status-cards {
            display: flex;
            gap: 1rem;
            flex: 9;
        }

        .status-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            flex: 1;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 18px;
            line-height: 45px;
            text-align: center;
            margin-bottom: 12px;
        }

        .card-icon.total {
            background: #44235c;
            color: white;
        }

        .card-icon.draft {
            background: #3b82f6;
            color: white;
        }

        .card-icon.review {
            background: #fbbf24;
            color: white;
        }

        .card-icon.approved {
            background: #22c55e;
            color: white;
        }

        .card-content {
            flex: 1;
        }

        .card-title {
            font-size: 0.875rem;
            color: #797979;
            margin: 0 0 0.5rem 0;
        }

        .card-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .card-trend {
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .card-trend.up {
            color: #22c55e;
        }

        .card-trend.down {
            color: #ef4444;
        }

         .carousel-wrapper {
            position: relative;
            width: 100%;
        }

        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding: 0 50px;
        }

        .carousel-container {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 10px 0;
        }

        .carousel-container::-webkit-scrollbar {
            display: none;
        }

        .tab {
            flex: 0 0 auto;
            min-width: 120px;
            padding: 10px 20px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-weight: 500;
        }

        .tab:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd;
        }

        .tab.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: none;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .carousel-button:hover {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .carousel-button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .carousel-button:disabled:hover {
            background-color: rgba(255, 255, 255, 0.95);
            color: inherit;
        }

        .carousel-button.prev {
            left: 0;
        }

        .carousel-button.next {
            right: 0;
        }

        /* RTL Support */
        [dir="rtl"] .carousel-button.prev {
            left: auto;
            right: 0;
        }

        [dir="rtl"] .carousel-button.next {
            right: auto;
            left: 0;
        }

        [dir="rtl"] .carousel-button.prev i {
            transform: scaleX(-1);
        }

        [dir="rtl"] .carousel-button.next i {
            transform: scaleX(-1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .carousel {
                padding: 0 40px;
            }

            .carousel-button {
                width: 35px;
                height: 35px;
            }

            .tab {
                min-width: 100px;
                padding: 8px 16px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .carousel {
                padding: 0 35px;
            }

            .carousel-button {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }

            .tab {
                min-width: 90px;
                padding: 6px 12px;
                font-size: 13px;
            }
        }

        input {
            margin-bottom: 40px;
        }

        .temlates-num {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f6f7;
            color: #44225c;
        }

        input {
            margin-bottom: 40px;
        }

        .input-simple {
            font-size: 16px;
            line-height: 1.5;
            border: none;
            background: #FFFFFF;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20'><path fill='%23838D99' d='M13.22 14.63a8 8 0 1 1 1.41-1.41l4.29 4.29a1 1 0 1 1-1.41 1.41l-4.29-4.29zm-.66-2.07a6 6 0 1 0-8.49-8.49 6 6 0 0 0 8.49 8.49z'></path></svg>");
            background-repeat: no-repeat;
            background-position: 10px 10px;
            background-size: 20px 20px;
            border: 1px solid #dfdfdf;
            width: 250px;
            padding: .5em 1em .5em 2.5em;
            border-radius: 4%;
        }

        .input-simple::placeholder {
            color: #838D99;
        }

        .input-simple:focus {
            outline: none;
            border: 1px solid #dfdfdf;
        }

        .input-simple::placeholder {
            color: black;
        }

        /* Style the CKEditor container */
        .cke_contents {
            border: 1px solid #ced4da !important;
            /* Bootstrap's default input border color */
            border-radius: 0.25rem !important;
            /* Bootstrap's default border radius */
        }

        /* Style when editor is focused */
        .cke_focus {
            outline: 0 !important;
        }

        /* Style the editor's outer container */
        .cke_top,
        .cke_bottom {
            border-color: #ced4da !important;
            background: #f8f9fa !important;
            /* Light gray background */
        }
    </style>
@endsection





@section('content')
    <div class="content-header row ">
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
    <div div class="my-2">
        <div class="row px-2">
            <div class="col-9 px-0">
                <div class="statistics-container card p-4" style="height: 100% !important;">
                    <!-- Document Status Cards -->
                    <div class="status-cards">
                        <!-- Total Documents -->
                        <div class="status-card">
                            <div class="card-icon total">
                                <i class="fa fa-file-text"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title fs-6 mb-1" style="color: #898989 !important;">Total Documents
                                </h3>
                                <div class="card-number fw-bolder">{{ $documntationStatistic['documentCount'] ?? 0 }}
                                </div>
                                {{-- <div class="card-trend down">
                                    <i class="fa fa-long-arrow-down"></i>
                                    12% decrease from last month
                                </div> --}}
                            </div>
                        </div>

                        <!-- Draft Documents -->
                        <div class="status-card">
                            <div class="card-icon draft">
                                <i class="fa fa-file"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title fs-6 mb-1">Draft Documents</h3>
                                <div class="card-number fw-bolder">
                                    {{ $documntationStatistic['statusCounts']['Draft'] ?? 0 }}</div>
                                {{-- <div class="card-trend up">
                                    <i class="fa fa-long-arrow-up"></i>
                                    12% increase from last month
                                </div> --}}
                            </div>
                        </div>

                        <!-- In Review Documents -->
                        <div class="status-card">
                            <div class="card-icon review">
                                <i class="fa fa-refresh"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title fs-6 mb-1">In Review Documents</h3>
                                <div class="card-number fw-bolder">
                                    {{ $documntationStatistic['statusCounts']['InReview'] ?? 0 }}
                                </div>
                                {{-- <div class="card-trend up">
                                    <i class="fa fa-long-arrow-up"></i>
                                    12% increase from last month
                                </div> --}}
                            </div>
                        </div>

                        <!-- Approved Documents -->
                        <div class="status-card">
                            <div class="card-icon approved">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title fs-6 mb-1">Approved Documents</h3>
                                <div class="card-number fw-bolder">
                                    {{ $documntationStatistic['statusCounts']['Approved'] ?? 0 }}
                                </div>
                                {{-- <div class="card-trend up">
                                    <i class="fa fa-long-arrow-up"></i>
                                    12% increase from last month
                                </div> --}}
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="col-3 px-0">
                <div class="statistics-container card mb-0">
                    <!-- Documentation Categories Chart -->
                    <div class="" style="height: 220px !important">
                        <div id="documentation-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="card card-top p-4 m-5">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="mb-0 h3 d-flex align-items-center gap-2">
                    <p class="fs-4 mb-0">{{ __('Templates') }} : </p>
                    <p class="fs-4 mb-0" id="template-count">{{ $category2->count() }}</p>
                </div>
                <div class="search-container">
                    <input class="input-simple search-task" type="text"
                        placeholder="{{ __('Search by Template name') }}">
                </div>
            </div>
            @if (auth()->user()->hasPermission('category.create'))
                <button id="add-new-template" class="btn btn-primary" type="button" data-bs-toggle="modal"
                    data-bs-target="#new-frame-modal">
                    <i class="fas fa-plus me-2"></i> {{ __('New Category') }}
                </button>
            @endif
        </div>

        <!-- Start Carousel Tabs -->
        <div class="carousel-wrapper">
            <div class="carousel">
                <div class="carousel-container">
                    @foreach ($category2 as $category)
                        <button class="tab sideNavBtn{{ $loop->first ? ' active' : '' }}"
                            data-tab="{{ $category->id }}" data-name="{{ $category->name }}"
                            data-type="{{ $category->type_category }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            <button class="carousel-button prev" aria-label="{{ __('Previous') }}">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="carousel-button next" aria-label="{{ __('Next') }}">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>



    <div class="card card-top m-5">
        <div class="card mb-0">
            <div class="card-body"
                style="display: flex !important; justify-content: space-between !important; align-items: center !important;">
                <div class="frame">
                    <h4 class="card-title mb-0">{{ __('locale.Name') }}: </h4>
                    <h5 class="card-desc DocName"></h5>
                </div>
                <div class="frame">
                    <h4 class="card-title mb-0">{{ __('locale.Type') }}: </h4>
                    <h5 class="card-desc DocType"></h5>
                </div>
                <div class="action-content" style="display: inherit !important; align-items: center !important;">
                    @if (auth()->user()->hasPermission('policy_adoptions.create'))
                        <button type="button" class="card-link btn m-0 btn-sm approvePolicy"
                            data-bs-target="#approve-modal" data-bs-toggle="modal" title="اعتماد السياسات">
                            <i class="fas fa-check-circle" style="font-size: 30px; color: #198754;"></i>
                        </button>
                    @endif

                    @if (auth()->user()->hasPermission('category.update'))
                        <button type="button" class="card-link btn m-0 btn-sm updateItem"
                            data-bs-target="#edit-modal" data-bs-toggle="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"
                                style="width: 30px; color: #44225c; height: 30px;">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                    @endif
                    @if (auth()->user()->hasPermission('category.create'))
                        <button class="card-link btn   px-0 mx-4 deleteItem">
                            <i class="fa-solid fa-trash-can" style="color:#ba1717; font-size: 28px;"></i>
                        </button>
                    @endif

                    @if (auth()->user()->hasPermission('document.create'))

                        <button id="add-new-template" class="btn btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#add_document">
                            <i class="fas fa-plus me-2"></i> New Document
                        </button>


                    @endif
                    @if (auth()->user()->hasPermission('category.create'))
                        <a href="{{ route('admin.governance.notificationsSettingsDocumentation') }}"
                            class="btn btn-primary" target="_self" id="notif" class="btn btn-primary"
                            target="_self">
                            <i class="fa fa-regular fa-bell"></i>
                        </a>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div div class="card card-top p-4 m-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.Document') }}</h4>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-datatable table-responsive mx-1">

                    <table class="table DocTable">
                        <thead>
                            <tr>
                                <th class="all">{{ __('locale.Name') }}</th>
                                <th class="all">{{ __('governance.Frameworks') }}</th>
                                <th class="all">{{ __('governance.Controls') }}</th>
                                <th class="all">{{ __('locale.CreationDate') }}</th>
                                <th class="all">{{ __('locale.ApprovalDate') }}</th>
                                <th class="all">{{ __('locale.NextReviewDate') }}</th>
                                <th class="all">{{ __('locale.Status') }}</th>
                                <th class="all">{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true"
                    id="add_document" aria-labelledby="addControlLabel">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myExtraLargeModal">{{ __('locale.AddANewDocument') }}
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form class=" form-add_document todo-modal needs-validation" novalidate method="POST"
                                action="{{ route('admin.governance.document.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <div class="action-tags">
                                        <div class="mb-1">
                                            <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                            <input type="text" name="name" class=" form-control" required />
                                            <span class="error error-name "></span>
                                        </div>

                                        <div class="mb-1">
                                            <label class="form-label">{{ __('governance.Frameworks') }}</label>
                                            <select class="select2 form-select" _id="framework"
                                                name="framework_ids[]" multiple>
                                                @foreach ($frameworks as $framework)
                                                    <option class="option"
                                                        data-controls="{{ json_encode($framework->FrameworkControls) }}"
                                                        value="{{ $framework->id }}"
                                                        data-available_text="{{ $framework->id }}">
                                                        {{ $framework->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error error-framework_ids"></span>
                                        </div>

                                        <div class="mb-1">
                                            <label class="form-label">{{ __('governance.Controls') }}</label>
                                            <select class="select2 form-select" name="control_ids[]"
                                                _id="controls_id" multiple="multiple">
                                            </select>
                                            <span class="error error-control_ids"></span>
                                        </div>

                                        <!-- //AdditionalStakeholders -->
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                                            <select name="additional_stakeholders[]" class="select2 form-select"
                                                _id="additional_stakeholders" multiple>
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                @foreach ($testers as $tester)
                                                    <option @if (!$tester->enabled) disabled @endif
                                                        value="{{ $tester->id }}">{{ $tester->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <span class="error error-additional_stakeholders"></span>
                                        </div>

                                        <!-- //owner -->

                                        @if (auth()->user()->role_id == 1)
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="owner">{{ __('locale.DocumentOwner') }}</label>
                                                <select class="select2 form-select" _id="task-assigned"
                                                    name="owner">
                                                    <option value="">{{ __('locale.select-option') }}
                                                    </option>
                                                    @foreach ($owners as $owner)
                                                        <option @if (!$owner->enabled) disabled @endif
                                                            value="{{ $owner->id }}">{{ $owner->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-owner"></span>
                                            </div>
                                        @endif

                                        <div class="mb-1">
                                            <label class="form-label" for="teams">{{ __('locale.Teams') }}</label>

                                            <select _id="teams" name="team_ids[]" class="select2 form-select"
                                                multiple>
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                @foreach ($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="error error-team_ids"></span>
                                        </div>

                                        <div class="mb-1">
                                            <label for="">{{ __('locale.CreationDate') }}</label>
                                            <input type="text" name="creation_date" value="<?php echo date('Y-m-d'); ?>"
                                                id="creation_date" class="form-control js-datepicker">
                                            <span class="error error-creation_date"></span>
                                        </div>

                                        <div class="mb-1">
                                            <label for="">{{ __('locale.LastReview') }}</label>
                                            <input type="text" data-i="0" name="last_review_date"
                                                value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD "
                                                id="last_review" class="form-control js-datepicker">
                                            <span class="error error-last_review_date"></span>
                                        </div>

                                        <div class="mb-1">
                                            <label for="">{{ __('locale.ReviewFrequency') }}
                                                ({{ __('locale.days') }})</label>
                                            <input type="number" min="0" name="review_frequency"
                                                id="review_frequency" value="0" class="form-control">
                                            <span class="error error-review_frequency"></span>
                                        </div>

                                        <div class="mb-1">
                                            <label for="">{{ __('locale.NextReviewDate') }}</label>
                                            <input type="text" data-i="0"disabled name="next_review_date"
                                                placeholder="YYYY-MM-DD " id="next_review" class="form-control">
                                            <span class="error error-next_review_date"></span>
                                        </div>

                                        <input type="hidden" name="category_id" id="store_category_id"
                                            value="">
                                        <div class="mb-1">
                                            <label for="">{{ __('locale.Status') }}</label>
                                            <div class="parent_documents_container">
                                                <select name="status" _id="status" class="form-select select2 "
                                                    onchange="changePrivacy(this.value)">
                                                    <option value="" selected disabled hidden>
                                                        {{ __('locale.select-option') }}</option>
                                                    @foreach ($status as $sta)
                                                        <option value="{{ $sta->id }}">{{ $sta->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-status"></span>
                                            </div>
                                        </div>

                                        <div class="mb-1" id="approval_date">
                                            <label for="">{{ __('locale.ApprovalDate') }}</label>
                                            <input type="text" data-i="0" name="approval_date"
                                                placeholder="YYYY-MM-DD " class="form-control js-datepicker">
                                            <span class="error error-approval_date"></span>
                                        </div>


                                        <!-- //owner -->
                                        <div class="mb-1" id="reviewer">
                                            <label class="form-label"
                                                for="reviewer">{{ __('locale.Reviewer') }}</label>
                                            <select class="select2 form-select" name="reviewer">
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                @foreach ($testers as $tester)
                                                    <option @if (!$tester->enabled) disabled @endif
                                                        value="{{ $tester->id }}">{{ $tester->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="error error-reviewer"></span>
                                        </div>

                                        <div class="mb-1" id="privacy">
                                            <label for="">{{ __('locale.Privacy') }}</label>
                                            <div class="parent_documents_container">
                                                <select name="privacy" class="form-select select2 ">
                                                    @foreach ($privacies as $priv)
                                                        <option value="{{ $priv->id }}">{{ $priv->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-privacy"></span>
                                            </div>
                                        </div>

                                        <div class="mb-1 version_name">
                                            <label class="text-label">{{ __('locale.Version') }}</label>
                                            :
                                            <input type="text" name="version_name" class="form-control dt-post"
                                                aria-label="{{ __('locale.Version') }}" />
                                            <span class="error error-version_name "></span>
                                        </div>

                                        <div class="mb-1 supporting_documentation_container">
                                            <label class="text-label">{{ __('locale.File') }}</label>
                                            :
                                            <input type="file" name="file" class="form-control dt-post"
                                                aria-label="{{ __('locale.File') }}" />
                                            <span class="error error-file "></span>
                                        </div>
                                        <div class="mb-1" id="content-create">
                                            <label for="">{{ __('locale.Content') }}</label>
                                            <div class="content_documents_container">
                                                <!-- Replace Quill with CKEditor textarea -->
                                                <textarea name="content" id="content_editor" class="form-control"></textarea>
                                                <span class="error error-content"></span>
                                            </div>
                                        </div>

                                        <div class="my-1">
                                            <button type="submit"
                                                class="btn btn-primary add-todo-item me-1">{{ __('locale.Add') }}</button>
                                            <button type="button" class="btn btn-outline-secondary add-todo-item "
                                                data-bs-dismiss="modal">
                                                {{ __('locale.Cancel') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Start update document --}}
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myExtraLargeModal" aria-hidden="true" id="edit_contModal"">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" data-title="{{ __('locale.EditDocument') }}">
                                    {{ __('locale.EditDocument') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-content p-0">
                                {{-- Update document --}}
                                <form id="form-update_control" class="todo-modal" novalidate method="POST"
                                    action="{{ route('admin.governance.document.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                        <div class="action-tags">

                                            <input type="hidden" name="id">
                                            {{-- Name --}}
                                            <div class="mb-1">
                                                <label for="title"
                                                    class="form-label">{{ __('locale.Name') }}</label>
                                                <input type="text" name="name" class=" form-control"
                                                    placeholder="Name" required />
                                                <span class="error error-name"></span>
                                            </div>

                                            {{-- Frameworks --}}
                                            <div class="mb-1">
                                                <label class="form-label">{{ __('governance.Frameworks') }}</label>
                                                <select class="select2 form-select" __id="framework"
                                                    name="framework_ids[]" multiple>
                                                    @foreach ($frameworks as $framework)
                                                        <option class="option" value="{{ $framework->id }}"
                                                            data-controls="{{ json_encode($framework->FrameworkControls) }}"
                                                            data-available_text="{{ $framework->id }}">
                                                            {{ $framework->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-framework_ids"></span>
                                            </div>

                                            {{-- Controls --}}
                                            <div class="mb-1">
                                                <label class="form-label">{{ __('governance.Controls') }}</label>
                                                <select class="select2 form-select" name="control_ids[]"
                                                    __id="controls_id" multiple="multiple">
                                                </select>
                                                <span class="error error-control_ids"></span>
                                            </div>

                                            {{-- Additional Stakeholders --}}
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                                                <select name="additional_stakeholders[]" class="select2 form-select"
                                                    __id="additional_stakeholders" multiple>
                                                    @foreach ($testers as $tester)
                                                        <option @if (!$tester->enabled) disabled @endif
                                                            value="{{ $tester->id }}">{{ $tester->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-additional_stakeholders"></span>
                                            </div>

                                            {{-- Owner --}}
                                            @if (auth()->user()->role_id == 1)
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="owner">{{ __('locale.DocumentOwner') }}</label>
                                                    <select class="select2 form-select" __id="task-assigned"
                                                        name="owner">
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($owners as $owner)
                                                            <option @if (!$owner->enabled) disabled @endif
                                                                value="{{ $owner->id }}">{{ $owner->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-owner"></span>
                                                </div>
                                            @endif

                                            {{-- Teams --}}
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="teams">{{ __('locale.Teams') }}</label>
                                                <select __id="teams" name="team_ids[]" class="select2 form-select"
                                                    multiple>
                                                    @foreach ($teams as $team)
                                                        <option value="{{ $team->id }}">{{ $team->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-teams"></span>
                                            </div>

                                            {{-- Creation Date --}}
                                            <div class="mb-1">
                                                <label for="">{{ __('locale.CreationDate') }}</label>
                                                <input type="text" disabled name="creation_date"
                                                    __id="creation_date" class="form-control">
                                                <span class="error error-creation_date"></span>
                                            </div>

                                            {{-- Last Review --}}
                                            <div class="mb-1">
                                                <label for="">{{ __('locale.LastReview') }}</label>
                                                <input type="text" data-i="0" name="last_review_date"
                                                    value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD "
                                                    __id="last_review" class="form-control js-datepicker">
                                                <span class="error error-last_review_date"></span>
                                            </div>

                                            {{-- Review Frequency --}}
                                            <div class="mb-1">
                                                <label for="">{{ __('locale.ReviewFrequency') }}
                                                    ({{ __('locale.days') }})
                                                </label>
                                                <input type="number" min="0" name="review_frequency"
                                                    __id="review_frequency" value="0" class="form-control">
                                                <span class="error error-review_frequency"></span>
                                            </div>

                                            {{-- Next Review Date --}}
                                            <div class="mb-1">
                                                <label for="">{{ __('locale.NextReviewDate') }}</label>
                                                <input type="text" data-i="0" disabled name="next_review_date"
                                                    placeholder="YYYY-MM-DD " __id="next_review"
                                                    class="form-control">
                                                <span class="error error-next_review_date"></span>
                                            </div>

                                            {{-- Status --}}
                                            <div class="mb-1">
                                                <label for="">{{ __('locale.Status') }}</label>
                                                <div class="parent_documents_container">
                                                    <select name="status" __id="status"
                                                        class="form-select select2 "
                                                        onchange="changePrivacy2(this.value)">
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($status as $sta)
                                                            <option value="{{ $sta->id }}">{{ $sta->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-status"></span>
                                                </div>
                                            </div>

                                            {{-- Reviewer --}}
                                            <div class="mb-1" id="reviewer_update">
                                                <label class="form-label"
                                                    for="reviewer">{{ __('locale.Reviewer') }}</label>
                                                <select class="select2 form-select" name="reviewer">
                                                    <option value="" disabled hidden selected>
                                                        {{ __('locale.select-option') }}
                                                    </option>
                                                    @foreach ($testers as $tester)
                                                        <option @if (!$tester->enabled) disabled @endif
                                                            value="{{ $tester->id }}">{{ $tester->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-reviewer"></span>
                                            </div>

                                            {{-- Approval Date --}}
                                            <div class="mb-1" id="approval_date_update">
                                                <label for="">{{ __('locale.ApprovalDate') }}</label>
                                                <input type="text" data-i="0" name="approval_date"
                                                    placeholder="YYYY-MM-DD " class="form-control js-datepicker">
                                                <span class="error error-approval_date"></span>
                                            </div>

                                            {{-- privacy --}}
                                            <div class="mb-1" id="privacy_update">
                                                <label for="">{{ __('locale.Privacy') }}</label>
                                                <div class="parent_documents_container">
                                                    <select name="privacy" class="form-select select2 ">
                                                        <option value="" disabled hidden selected>
                                                            {{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($privacies as $priv)
                                                            <option value="{{ $priv->id }}">{{ $priv->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-privacy"></span>
                                                </div>
                                            </div>
                                            <div class="mb-1 version_name">
                                                <label class="text-label">{{ __('locale.Version') }}</label>
                                                :
                                                <input type="text" name="version_name"
                                                    class="form-control dt-post"
                                                    aria-label="{{ __('locale.Version') }}" />
                                                <span class="error error-version_name "></span>
                                            </div>
                                            {{-- File --}}
                                            <div class="mb-1 supporting_documentation_container">
                                                <label class="text-label">{{ __('locale.File') }}</label>
                                                :
                                                <input type="file" name="file" class="form-control dt-post"
                                                    aria-label="{{ __('locale.File') }}" />
                                                <span class="error error-file"></span>
                                            </div>

                                            <div class="mb-1" id="content-update">
                                                <label for="">{{ __('locale.Content') }}</label>
                                                <div class="content_documents_container">
                                                    <!-- Replace Quill with CKEditor textarea -->
                                                    <textarea name="content" id="content_update_editor" class="form-control"></textarea>
                                                    <span class="error error-content"></span>
                                                </div>
                                            </div>

                                            {{-- Submit button --}}
                                            <div class="my-1">
                                                <button type="submit"
                                                    class="btn btn-primary   add-todo-item me-1">{{ __('locale.Update') }}</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary add-todo-item "
                                                    data-bs-dismiss="modal">
                                                    {{ __('locale.Cancel') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="border-bottom mx-1 my-1">
                                </div>

                                <div id="chat-container">
                                    <!-- Main chat area -->
                                    <section class="chat-app-window">
                                        <!-- To load Conversation -->
                                        <div class="start-chat-area">
                                            <h4 class="sidebar-toggle start-chat-text mx-1">
                                                {{ __('locale.DocumentNotes') }}</h4>
                                        </div>
                                        <!--/ To load Conversation -->

                                        <!-- Active Chat -->
                                        <div class="active-chat">
                                            <!-- Chat Header -->
                                            <div class="chat-navbar">
                                                <header class="chat-header d-none">
                                                    <div class="d-flex align-items-center">
                                                        <div class="sidebar-toggle d-block d-lg-none me-1">
                                                            <i data-feather="menu" class="font-medium-5"></i>
                                                        </div>
                                                        <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                            <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}"
                                                                alt="avatar" height="36" width="36" />
                                                            <span class="avatar-status-busy"></span>
                                                        </div>
                                                        <h6 class="mb-0">Kristopher Candy</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i data-feather="phone-call"
                                                            class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                                        <i data-feather="video"
                                                            class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                                        <i data-feather="search"
                                                            class="cursor-pointer d-sm-block d-none font-medium-2"></i>
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i data-feather="more-vertical"
                                                                    id="chat-header-actions"
                                                                    class="font-medium-2"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="chat-header-actions">
                                                                <a class="dropdown-item" href="#">View
                                                                    Contact</a>
                                                                <a class="dropdown-item" href="#">Mute
                                                                    Notifications</a>
                                                                <a class="dropdown-item" href="#">Block
                                                                    Contact</a>
                                                                <a class="dropdown-item" href="#">Clear Chat</a>
                                                                <a class="dropdown-item" href="#">Report</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </header>
                                            </div>
                                            <!--/ Chat Header -->

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
                                            <form class="chat-app-form" id="chat-app-form"
                                                action="javascript:void(0);" onsubmit="enterChat('#edit_contModal');">
                                                @csrf
                                                <input type="hidden" name="document_id" />
                                                <div class="input-group input-group-merge me-1 form-send-message">
                                                    <input type="text" class="form-control message"
                                                        placeholder="{{ __('locale.TypeYourNote') }}" />
                                                    <span class="input-group-text" title="hhhh">
                                                        <label for="attach-doc"
                                                            class="attachment-icon form-label mb-0">
                                                            <i data-feather="file"
                                                                class="cursor-pointer text-secondary"></i>
                                                            <input name="note_file" type="file" class="attach-doc"
                                                                id="attach-doc" hidden /> </label></span>
                                                </div>
                                                <button type="button" class="btn btn-primary send"
                                                    onclick="enterChat('#edit_contModal');">
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
                {{-- End update document --}}

                {{-- Start show document --}}
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myExtraLargeModal" aria-hidden="true" id="show_contModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" data-title="{{ __('locale.EditDocument') }}">
                                    {{ __('locale.EditDocument') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-content p-0">
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <div class="action-tags">

                                        <input type="hidden" name="id">
                                        {{-- Name --}}
                                        <div class="mb-1">
                                            <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                            <input type="text" name="name" class=" form-control"
                                                placeholder="Name" disabled />
                                        </div>

                                        {{-- Frameworks --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('governance.Frameworks') }}</label>
                                            <select class="select2 form-select" __id="framework"
                                                name="framework_ids[]" multiple disabled>
                                            </select>
                                        </div>

                                        {{-- Controls --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('governance.Controls') }}</label>
                                            <select class="select2 form-select" name="control_ids[]"
                                                __id="controls_id" multiple="multiple" disabled>
                                            </select>
                                        </div>

                                        {{-- Additional Stakeholders --}}
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                                            <select name="additional_stakeholders[]" class="select2 form-select"
                                                __id="additional_stakeholders" multiple disabled>
                                            </select>
                                        </div>

                                        {{-- Owner --}}
                                        @if (auth()->user()->role_id == 1)
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="owner">{{ __('locale.DocumentOwner') }}</label>
                                                <select class="select2 form-select" __id="task-assigned"
                                                    name="owner" disabled>
                                                    <option value="" disabled hidden selected>
                                                        {{ __('locale.select-option') }}
                                                    </option>
                                                </select>
                                            </div>
                                        @endif

                                        {{-- Teams --}}
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="teams">{{ __('locale.Teams') }}</label>
                                            <select __id="teams" name="team_ids[]" class="select2 form-select"
                                                multiple disabled>
                                            </select>
                                        </div>

                                        {{-- Creation Date --}}
                                        <div class="mb-1">
                                            <label for="">{{ __('locale.CreationDate') }}</label>
                                            <input type="text" disabled name="creation_date" __id="creation_date"
                                                class="form-control" disabled>
                                        </div>

                                        {{-- Last Review --}}
                                        <div class="mb-1">
                                            <label for="">{{ __('locale.LastReview') }}</label>
                                            <input type="text" data-i="0" name="last_review_date" disabled
                                                value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD "
                                                __id="last_review" class="form-control">
                                        </div>

                                        {{-- Review Frequency --}}
                                        <div class="mb-1">
                                            <label for="">{{ __('locale.ReviewFrequency') }}
                                                ({{ __('locale.days') }})
                                            </label>
                                            <input type="number" min="0" name="review_frequency"
                                                __id="review_frequency" value="0" class="form-control" disabled>
                                        </div>

                                        {{-- Next Review Date --}}
                                        <div class="mb-1">
                                            <label for="">{{ __('locale.NextReviewDate') }}</label>
                                            <input type="text" data-i="0" disabled name="next_review_date"
                                                placeholder="YYYY-MM-DD " __id="next_review" class="form-control"
                                                disabled>
                                        </div>

                                        {{-- Status --}}
                                        <div class="mb-1">
                                            <label for="">{{ __('locale.Status') }}</label>
                                            <div class="parent_documents_container">
                                                <select name="status" __id="status" class="form-select select2 "
                                                    onchange="changePrivacy3(this.value)" disabled>
                                                    <option value="" disabled hidden selected>
                                                        {{ __('locale.select-option') }}
                                                    </option>
                                                    @foreach ($status as $sta)
                                                        <option value="{{ $sta->id }}">{{ $sta->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-status"></span>
                                            </div>
                                        </div>

                                        {{-- Reviewer --}}
                                        <div class="mb-1" id="reviewer_show">
                                            <label class="form-label"
                                                for="reviewer">{{ __('locale.Reviewer') }}</label>
                                            <select class="select2 form-select" name="reviewer" disabled>
                                                <option value="" disabled hidden selected>
                                                    {{ __('locale.select-option') }}
                                                </option>
                                            </select>
                                            <span class="error error-reviewer"></span>
                                        </div>

                                        {{-- Approval Date --}}
                                        <div class="mb-1" id="approval_date_show">
                                            <label for="">{{ __('locale.ApprovalDate') }}</label>
                                            <input type="text" data-i="0" name="approval_date"
                                                placeholder="YYYY-MM-DD " class="form-control" disabled>
                                            <span class="error error-approval_date"></span>
                                        </div>

                                        {{-- privacy --}}
                                        <div class="mb-1" id="privacy_show">
                                            <label for="">{{ __('locale.Privacy') }}</label>
                                            <div class="parent_documents_container">
                                                <select name="privacy" class="form-select select2" disabled>
                                                    <option value="" disabled hidden selected>
                                                        {{ __('locale.select-option') }}
                                                    </option>
                                                    @foreach ($privacies as $priv)
                                                        <option value="{{ $priv->id }}">{{ $priv->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="error error-privacy"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 version_name">
                                            <label class="text-label">{{ __('locale.Version') }}</label>
                                            :
                                            <input type="text" disabled name="version_name"
                                                class="form-control dt-post"
                                                aria-label="{{ __('locale.Version') }}" />
                                            <span class="error error-version_name "></span>
                                        </div>
                                        <div class="mb-1" id="content-update">
                                            <label for="">{{ __('locale.Content') }}</label>
                                            <div class="content_documents_container">
                                                <!-- Replace Quill with CKEditor textarea -->
                                                <textarea name="content" id="content_show_editor" class="form-control"></textarea>
                                                <span class="error error-content"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom mx-1 my-1">
                                    </div>

                                    {{-- chat container --}}
                                    <div>
                                        <!-- Main chat area -->
                                        <section class="chat-app-window">
                                            <!-- To load Conversation -->
                                            <div class="start-chat-area">
                                                <h4 class="sidebar-toggle start-chat-text mx-1">
                                                    {{ __('locale.DocumentNotes') }}
                                                </h4>
                                            </div>
                                            <!--/ To load Conversation -->

                                            <!-- Active Chat -->
                                            <div class="active-chat">
                                                <!-- Chat Header -->
                                                <div class="chat-navbar">
                                                    <header class="chat-header d-none">
                                                        <div class="d-flex align-items-center">
                                                            <div class="sidebar-toggle d-block d-lg-none me-1">
                                                                <i data-feather="menu" class="font-medium-5"></i>
                                                            </div>
                                                            <div
                                                                class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                                <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}"
                                                                    alt="avatar" height="36" width="36" />
                                                                <span class="avatar-status-busy"></span>
                                                            </div>
                                                            <h6 class="mb-0">Kristopher Candy</h6>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i data-feather="phone-call"
                                                                class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                                            <i data-feather="video"
                                                                class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                                            <i data-feather="search"
                                                                class="cursor-pointer d-sm-block d-none font-medium-2"></i>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="more-vertical"
                                                                        class="font-medium-2"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="chat-header-actions">
                                                                    <a class="dropdown-item" href="#">View
                                                                        Contact</a>
                                                                    <a class="dropdown-item" href="#">Mute
                                                                        Notifications</a>
                                                                    <a class="dropdown-item" href="#">Block
                                                                        Contact</a>
                                                                    <a class="dropdown-item" href="#">Clear
                                                                        Chat</a>
                                                                    <a class="dropdown-item" href="#">Report</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </header>
                                                </div>
                                                <!--/ Chat Header -->

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
                                                <form class="chat-app-form" _id="chat-app-form"
                                                    action="javascript:void(0);"
                                                    onsubmit="enterChat('#show_contModal');">
                                                    @csrf
                                                    <input type="hidden" name="document_id" />
                                                    <div class="input-group input-group-merge me-1 form-send-message">
                                                        <input type="text" class="form-control message"
                                                            placeholder="{{ __('locale.TypeYourNote') }}" />
                                                        <span class="input-group-text" title="hhhh">
                                                            <label for="attach-doc2"
                                                                class="attachment-icon form-label mb-0">
                                                                <i data-feather="file"
                                                                    class="cursor-pointer text-secondary"></i>
                                                                <input name="note_file" type="file"
                                                                    class="attach-doc" id="attach-doc2" hidden />
                                                            </label></span>
                                                    </div>
                                                    <button type="button" class="btn btn-primary send"
                                                        onclick="enterChat('#show_contModal');">
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
                    {{-- End show document --}}

                    <!-- collapseAuditTrail end -->
                    <form class="d-none" id="download-file-form" method="post"
                        action="{{ route('admin.governance.ajax.download_file') }}">
                        @csrf
                        {{-- <input type="hidden" name="id"> --}}
                        <input type="hidden" name="document_id">
                    </form>
                </div>

                <!-- add category start -->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myExtraLargeModal" aria-hidden="true" id="new-frame-modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myExtraLargeModal">{{ __('locale.AddNewCategory') }}
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="add_frame" class="add_frame todo-modal needs-validation" novalidate
                                method="POST" action="{{ route('admin.governance.category.store') }}">
                                @csrf
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <div class="action-tags">
                                        <div class="mb-1">
                                            <label for="title"
                                                class="form-label">{{ __('locale.Title') }}</label>
                                            <input type="text" name="name" class=" form-control"
                                                placeholder="Title" required />
                                            <span class="error error-name "></span>
                                        </div>
                                        <input type="hidden" id="view_type_sorting" name="icon" value="none">
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.Type') }}</label>
                                            <select class="select2 form-select" id="type_category"
                                                name="type_category">
                                                <option class="option" value="" selected>
                                                    {{ __('locale.select-option') }}
                                                </option>
                                                <option class="option" value="1">
                                                    {{ __('locale.Standard') }}
                                                </option>
                                                <option class="option" value="2">{{ __('locale.Policy') }}
                                                </option>
                                                <option class="option" value="3">
                                                    {{ __('locale.procedures') }}
                                                </option>
                                                <option class="option" value="4">{{ __('locale.Others') }}
                                                </option>
                                            </select>
                                            <span class="error error-type_category"></span>
                                        </div>
                                    </div>
                                    <div class="my-1">
                                        <button type="submit"
                                            class="btn btn-primary   add-todo-item me-1">{{ __('locale.Add') }}</button>
                                        <button type="button" class="btn btn-outline-secondary add-todo-item "
                                            data-bs-dismiss="modal">
                                            {{ __('locale.Cancel') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Policy Modal -->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myExtraLargeModal" aria-hidden="true" id="add_Policy">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <input type="hidden" name="document_id" id="document_id" value="">

                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('locale.Add') }} {{ __('locale.Policy') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <table id="policyTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Policy Name</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Existing policies will be listed here -->
                                    </tbody>
                                </table>

                                <!-- Add Policy Modal -->
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                    id="addPolicyModal" tabindex="-1" aria-labelledby="addPolicyModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addPolicyModalLabel">
                                                    {{ __('locale.Add Policy') }}</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form id="form-add_policy">
                                                @csrf
                                                <input type="hidden" name="document_id" id="inner_document_id"
                                                    value="">
                                                <div class="modal-body">
                                                    <div class="form-group mb-2">
                                                        <input type="checkbox" id="toggleNewPolicy"
                                                            onchange="togglePolicyInput()">
                                                        <label
                                                            for="toggleNewPolicy">{{ __('locale.AddNewPolicy') }}</label>
                                                    </div>

                                                    <div class="form-group" id="selectPolicyGroup">
                                                        <label for="policy_id"
                                                            class="form-label">{{ __('locale.SelectPolicy') }}</label>
                                                        <select class="form-select" id="policy_id" name="policy_id"
                                                            required>
                                                            <option value="" disabled selected>
                                                                {{ __('locale.Select a policy') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group d-none" id="inputPolicyGroupEn">
                                                        <label for="new_policy_name"
                                                            class="form-label">{{ __('locale.New Policy Name English') }}</label>
                                                        <input type="text" class="form-control"
                                                            id="new_policy_name_en" name="new_policy_name_en"
                                                            placeholder="{{ __('locale.Enter policy name english') }}">
                                                    </div>
                                                    <div class="form-group d-none" id="inputPolicyGroupAr">
                                                        <label for="new_policy_name"
                                                            class="form-label">{{ __('locale.New Policy Name Arabic') }}</label>
                                                        <input type="text" class="form-control"
                                                            id="new_policy_name_ar" name="new_policy_name_ar"
                                                            placeholder="{{ __('locale.Enter policy name arabic') }}">
                                                    </div>
                                                </div>

                                                <div class="modal-footer justify-content-between">
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ __('locale.Add') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addPolicyModal" onclick="setDocumentId()">Add
                                        Policy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade EditModal" id="edit-modal" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content p-0">

                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <form id="form-edit" class="form-edit todo-modal needs-validation" novalidate
                                method="POST" action="{{ route('admin.governance.category.update') }}">
                                @csrf

                                <div class="modal-header align-items-center mb-1">
                                    <h5 class="modal-title">{{ __('locale.Update') }}
                                        {{ __('locale.Category') }}
                                    </h5>
                                    <div
                                        class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"
                                            stroke-width="3"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="category_id" id="edit-category-id" value="">

                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <div class="action-tags">
                                        <div class="mb-1">
                                            <label for="title"
                                                class="form-label">{{ __('locale.Name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                id="edit-name" required>
                                            <span class="error error-name"></span>
                                        </div>
                                        <div class="mb-1">
                                            <label for="type_category"
                                                class="form-label">{{ __('locale.Type') }}</label>
                                            <select class="select2 form-select TypeCategorySelect"
                                                id="type_category" name="type_category">
                                                <option value="" selected>{{ __('locale.select-option') }}
                                                </option>
                                                <option value="1">{{ __('locale.Standard') }}</option>
                                                <option value="2">{{ __('locale.Policy') }}</option>
                                                <option value="3">{{ __('locale.procedures') }}</option>
                                                <option value="4">{{ __('locale.Others') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="my-1">
                                        <button type="submit"
                                            class="btn btn-primary update-btn me-1">{{ __('locale.Update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="AddNewAduitDocumentPolicy" tabindex="-1"
                    aria-labelledby="startNewAuditModalLabel">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="startNewAuditModalLabel">
                                    {{ __('locale.StartNewAudit') }}</h5>
                                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="startAuditForm" method="POST">
                                    @csrf

                                    <!-- Audit Name -->
                                    <div class="mb-3">
                                        <label for="aduit_name"
                                            class="form-label">{{ __('locale.AuditName') }}</label>
                                        <input type="text" name="aduit_name" id="aduit_name"
                                            class="form-control" placeholder="{{ __('locale.EnterAuditName') }}">
                                        <span class="error error-aduit_name text-danger"></span>
                                    </div>

                                    <!-- Document Type & Document ID -->
                                    <input type="hidden" name="document_type" id="document_type">
                                    <input type="hidden" name="document_id" id="document_id">

                                    <div class="row mb-3">
                                        <!-- Auditer -->
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('locale.Auditer') }}</label>
                                            <select class="select2 form-select" name="owner_id" id="owner_id">
                                                <option value="" selected>{{ __('locale.select-option') }}
                                                </option>
                                                @foreach ($auditers as $auditer)
                                                    <option @if (!$auditer->enabled) disabled @endif
                                                        value="{{ $auditer->id }}">{{ $auditer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Auditees -->
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('locale.Auditees') }}</label>
                                            <select class="select2 form-select" id="responsible"
                                                name="responsible[]" multiple>
                                                <option value="" disabled>{{ __('locale.select-option') }}
                                                </option>
                                                @foreach ($auditees as $auditee)
                                                    <option @if (!$auditee->enabled) disabled @endif
                                                        value="{{ $auditee->id }}">{{ $auditee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="error error-responsible text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Start Date -->
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="start_date">{{ __('locale.StartDate') }}</label>
                                            <input name="start_date" class="form-control js-datepicker"
                                                id="start_date" type="text" placeholder="YYYY-MM-DD" />
                                            <span class="error error-start_date text-danger"></span>
                                        </div>

                                        <!-- Due Date -->
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="due_date">{{ __('locale.DueDate') }}</label>
                                            <input name="due_date" class="form-control js-datepicker"
                                                id="due_date" type="text" placeholder="YYYY-MM-DD" />
                                            <span class="error error-due_date text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Periodical Time -->
                                        <div class="col-md-6">
                                            <label for="periodical_time">{{ __('locale.PeriodicalTime') }}
                                                ({{ __('locale.days') }})</label>
                                            <input type="number" min="0" name="periodical_time"
                                                id="periodical_time" value="0" class="form-control">
                                        </div>

                                        <!-- Next Initiate Date -->
                                        <div class="col-md-6">
                                            <label
                                                for="next_initiate_date">{{ __('locale.NextIntiateDate') }}</label>
                                            <input type="text" name="next_initiate_date"
                                                id="next_initiate_date" class="form-control" readonly>
                                            <span class="error error-next_initiate_date text-danger"></span>
                                        </div>
                                    </div>

                                    <!-- Requires File Evidence -->
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <input type="checkbox" name="requires_file" id="requires_file"
                                                value="1" />
                                            {{ __('locale.RequiresFileEvidence') }}
                                        </label>
                                        <span class="error error-requires_file text-danger"></span>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid gap-2">
                                        <button type="submit"
                                            class="btn btn-primary mt-3">{{ __('locale.StartAudit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="documentLog" tabindex="-1" aria-labelledby="documentLogModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentLogModalLabel">Document Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="logs-table" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('locale.Date') }} </th>
                                                <th>{{ __('locale.User') }}</th>
                                                <th>{{ __('locale.Action') }}</th>
                                                <th>{{ __('locale.Details') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Policy Adoption Modal --}}
                <div class="modal fade" id="approve-modal" tabindex="-1" aria-labelledby="approveModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- Added modal-xl -->
                        <form id="policyAdoptionForm">
                            @csrf
                            {{-- Hidden input for category_id --}}
                            <input type="hidden" name="category_id" id="category_id" value="">


                            <div class="modal-content shadow-lg border-0 rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approveModalLabel">
                                        {{ __('locale.Policy Adoption') }}</h5>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">

                                    {{-- Name --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('locale.Name') }}</label>
                                        <textarea  name="name" id="name" class="form-control"></textarea>
                                    </div>

                                    <div class="mb-1" id="introduction_content-create">
                                        <label for="">{{ __('locale.Introduction_Content_En') }}</label>
                                        <div class="introduction_content_container">
                                            <!-- Replace Quill with CKEditor textarea -->
                                            <textarea name="introduction_content_en" id="introduction_content_editor_en" class="form-control"></textarea>
                                            <span class="error error-content"></span>
                                        </div>
                                    </div>
                                    <div class="mb-1" id="introduction_content-create">
                                        <label for="">{{ __('locale.Introduction_Content_Ar') }}</label>
                                        <div class="introduction_content_container">
                                            <!-- Replace Quill with CKEditor textarea -->
                                            <textarea name="introduction_content_ar" id="introduction_content_editor_ar" class="form-control"></textarea>
                                            <span class="error error-content"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                                    <button type="submit"
                                        class="btn btn-success">{{ __('locale.Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Right Sidebar starts -->




@endsection


@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script> --}}
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset('cdn/picker.js') }}"></script>
    <script src="{{ asset('cdn/picker.date.js') }}"></script>
    <script src="{{ asset('cdn/highcharts.js') }}"></script>


@endsection

@section('page-script')

    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        const activeDocumentType = "{{ $activeDocumentType }}";

        var permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('document.update') ? 1 : 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('document.delete') ? 1 : 0 }};
        permission['download'] = {{ auth()->user()->hasPermission('document.download') ? 1 : 0 }};
        permission['Document_Policy_delete'] = {{ auth()->user()->hasPermission('Document_Policy.delete') ? 1 : 0 }};

        $('.select2 form-select').select2();
        //datepicker start

        var $input = $('.js-datepicker').pickadate({
            format: 'yyyy-mm-dd',
            firstDay: 1,
            formatSubmit: 'yyyy-mm-dd',
            // hiddenName: true,
            editable: true,
            // today: 'Today',
            today: '',
        });
    </script>

    <script>
        /* Start Category */
        // Submit form for creating category
        $('#new-frame-modal form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#new-frame-modal').modal('hide');
                        if (data.reload)
                            location.reload();
                        else {
                            $("#advanced-search-datatable").load(location.href +
                                " #advanced-search-datatable>*", "");
                            loadDatatable();
                        }
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

        // Submit form for deleting category
        $(".category_del").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "DELETE",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        if (data.reload)
                            location.reload();
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });

        });

        // Submit form for updating category
        $('.form-edit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
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
        CKEDITOR.replace('content_editor');
        CKEDITOR.replace('content_update_editor');
        CKEDITOR.replace('content_show_editor');
        CKEDITOR.replace('introduction_content_editor_en');
        CKEDITOR.replace('introduction_content_editor_ar');

        /* Start Document */
        // Submit form for creating document

        $('.form-add_document').on('submit', function(e) {
            e.preventDefault();
            const modal = $(this).parents('.add_document');

            // Update the textarea with CKEditor content before submission
            var editorContent = CKEDITOR.instances['content_editor'].getData();
            $('#content_editor').val(editorContent);

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        if (data.reload)
                            location.reload();
                        modal.modal('hide');

                        // Optional: Clear the editor after successful submission
                        CKEDITOR.instances['content_editor'].setData('');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

        // show document
        function showDocument(data) {
            var url = "{{ route('admin.governance.ajax.show_document', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    if (response.status) {
                        const showModal = $("#show_contModal");

                        const modalTitle = $('#show_contModal .modal-title');

                        let title =
                            `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light mx-1">${response.data.document_status_name}</button>`;
                        modalTitle.html(modalTitle.data('title') + title);

                        // Start Assign task data to modal
                        showModal.find('input[name="id"]').val(response.data.id);

                        // Set name
                        showModal.find("input[name='name']").val(response.data.document_name);
                        showModal.find("input[name='version_name']").val(response.data.version_name);

                        // Set frameworks
                        const framworkContainer = showModal.find(`select[name='framework_ids[]']`);
                        framworkContainer.find('option').remove();
                        response.data.frameworks.forEach(frameworkName => {
                            framworkContainer.append(`<option selected>${frameworkName}</option>`);
                        });

                        // Set controls
                        const controlContainer = showModal.find(`select[name='control_ids[]']`);
                        controlContainer.find('option').remove();
                        response.data.controls.forEach(controlName => {
                            controlContainer.append(`<option selected>${controlName}</option>`);
                        });

                        // Set additional_stakeholders
                        const additionalStakeholderContainer = showModal.find(
                            `select[name='additional_stakeholders[]']`);
                        additionalStakeholderContainer.find('option').remove();
                        response.data.additional_stakeholders.forEach(additionalStakeholderName => {
                            additionalStakeholderContainer.append(
                                `<option selected>${additionalStakeholderName}</option>`);
                        });

                        // Set document owner
                        const documentOwnerContainer = showModal.find(`select[name='owner']`);
                        documentOwnerContainer.find('option').remove();
                        documentOwnerContainer.append(
                            `<option selected>${response.data.document_owner}</option>`);

                        // Set team
                        const teamContainer = showModal.find(`select[name='team_ids[]']`);
                        teamContainer.find('option').remove();
                        response.data.teams.forEach(teamName => {
                            teamContainer.append(`<option selected>${teamName}</option>`);
                        });

                        // Set creation date
                        showModal.find("input[name='creation_date']").val(response.data.creation_date);

                        // Set last review date
                        showModal.find("input[name='last_review_date']").val(response.data.last_review_date);

                        // Set review frequency
                        showModal.find("input[name='review_frequency']").val(response.data.review_frequency);

                        // Set next review date
                        showModal.find("input[name='next_review_date']").val(response.data.next_review_date);

                        // Set approval date
                        showModal.find("input[name='approval_date']").val(response.data.approval_date)
                            .flatpickr({
                                dateFormat: 'Y-m-d',
                                defaultDate: response.data.approval_date,
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (instance.isMobile) {
                                        $(instance.mobileInput).attr('step', null);
                                    }
                                }
                            });

                        // Set status
                        showModal.find("select[name='status'] option").attr('disabled', false);
                        if (!response.data.document_status) {
                            showModal.find("select[name='status'] option").attr('selected', false).trigger(
                                'change');
                            showModal.find("select[name='status'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            showModal.find(
                                `select[name='status'] option[value='${response.data.document_status}']`).attr(
                                'selected', true).trigger('change');
                        // showModal.find("select[name='status'] option").attr('disabled', true);

                        // Set document reviewer
                        const documentReviewerContainer = showModal.find(`select[name='reviewer']`);
                        documentReviewerContainer.find('option').remove();
                        documentReviewerContainer.append(
                            `<option selected>${response.data.document_reviewer}</option>`);

                        // Set privacy
                        if (!response.data.privacy) {
                            showModal.find("select[name='privacy'] option").attr('selected', false).trigger(
                                'change');
                            showModal.find("select[name='privacy'] option").first().attr('selected', true)
                                .trigger('change');
                        } else {
                            showModal.find(`select[name='privacy'] option[value='${response.data.privacy}']`)
                                .attr('selected', true).trigger('change');
                        }

                        if (response.data.content) {
                            var editor = CKEDITOR.instances['content_show_editor'];
                            if (editor) {
                                editor.setData(response.data.content);
                            }
                        }

                        addMessageToChat(response.data);

                        $('#show_contModal').modal('show');

                        $('button').on('click', function(e) {
                            e.stopPropagation();
                            // picker[$(e.target).data('i')].open();
                        });
                    }
                },
                error: function(response, data) {
                    let responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                }

            });
        };

        // edit document
        function editDocument(data) {
            var url = "{{ route('admin.governance.ajax.edit_document', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    if (response.status) {
                        const editForm = $("#form-update_control");

                        const modalTitle = $('#edit_contModal .modal-title');

                        let title =
                            `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light mx-1">${response.data.document_status_name}</button>`;
                        modalTitle.html(modalTitle.data('title') + title);

                        // Start Assign task data to modal
                        editForm.find('input[name="id"]').val(response.data.id);

                        // Set name
                        editForm.find("input[name='name']").val(response.data.document_name);
                        editForm.find("input[name='version_name']").val(response.data.version_name);

                        // Set frameworks
                        response.data.framework_ids.forEach(frameworkId => {
                            editForm.find(
                                    `select[name='framework_ids[]'] option[value='${frameworkId}']`)
                                .attr('selected', true).trigger('change');
                        });

                        // Set controls
                        response.data.control_ids.forEach(controlId => {
                            editForm.find(`select[name='control_ids[]'] option[value='${controlId}']`)
                                .attr('selected', true).trigger('change');
                            editForm.find(`select[name='control_ids[]'] option[value='${controlId}']`);
                        });

                        // Set additional_stakeholders
                        response.data.additional_stakeholders.forEach(additionalStakeholderId => {
                            editForm.find(
                                `select[name='additional_stakeholders[]'] option[value='${additionalStakeholderId}']`
                            ).attr('selected', true).trigger('change');
                        });

                        // Set document owner
                        if (!response.data.document_owner) {
                            editForm.find("select[name='owner'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='owner'] option").first().attr('selected', true).trigger(
                                'change');
                        } else
                            editForm.find(
                                `select[name='owner'] option[value='${response.data.document_owner}']`).attr(
                                'selected', true).trigger('change');

                        // Set team
                        response.data.team_ids.forEach(teamId => {
                            editForm.find(`select[name='team_ids[]'] option[value='${teamId}']`).attr(
                                'selected', true).trigger('change');
                        });

                        // Set creation date
                        editForm.find("input[name='creation_date']").val(response.data.creation_date);

                        // Set last review date
                        editForm.find("input[name='last_review_date']").val(response.data.last_review_date)
                            .flatpickr({
                                dateFormat: 'Y-m-d',
                                defaultDate: response.data.last_review_date,
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (instance.isMobile) {
                                        $(instance.mobileInput).attr('step', null);
                                    }
                                }
                            });

                        // Set review frequency
                        editForm.find("input[name='review_frequency']").val(response.data.review_frequency);

                        // Set next review date
                        editForm.find("input[name='next_review_date']").val(response.data.next_review_date);

                        // Set approval date
                        editForm.find("input[name='approval_date']").val(response.data.approval_date)
                            .flatpickr({
                                dateFormat: 'Y-m-d',
                                defaultDate: response.data.approval_date,
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (instance.isMobile) {
                                        $(instance.mobileInput).attr('step', null);
                                    }
                                }
                            });

                        // Set parent
                        // if(!response.data.parent){
                        //     editForm.find("select[name='parent'] option").attr('selected', false).trigger('change');
                        //     editForm.find("select[name='parent'] option").first().attr('selected', true).trigger('change');
                        // }
                        // else
                        //     editForm.find(`select[name='parent'] option[value='${response.data.parent}']`).attr('selected', true).trigger('change');

                        // Set status
                        if (!response.data.document_status) {
                            editForm.find("select[name='status'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='status'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            editForm.find(
                                `select[name='status'] option[value='${response.data.document_status}']`).attr(
                                'selected', true).trigger('change');

                        // Set reviewer
                        if (!response.data.document_reviewer) {
                            editForm.find("select[name='reviewer'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='reviewer'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            editForm.find(
                                `select[name='reviewer'] option[value='${response.data.document_reviewer}']`)
                            .attr('selected', true).trigger('change');

                        // Set privacy
                        if (!response.data.privacy) {
                            editForm.find("select[name='privacy'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='privacy'] option").first().attr('selected', true)
                                .trigger('change');
                        } else {
                            editForm.find(`select[name='privacy'] option[value='${response.data.privacy}']`)
                                .attr('selected', true).trigger('change');
                        }

                        if (response.data.content) {
                            var editor = CKEDITOR.instances['content_update_editor'];
                            if (editor) {
                                editor.setData(response.data.content);
                            }
                        }

                        addMessageToChat(response.data);

                        $('#edit_contModal').modal('show');

                        $('button').on('click', function(e) {
                            e.stopPropagation();
                            // picker[$(e.target).data('i')].open();
                        });
                    }
                },
                error: function(response, data) {
                    let responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                }

            });
        };

        const editForm = $("#form-update_control"),
            editFormModal = $('#edit_contModal');

        editForm.submit(function(e) {
            e.preventDefault();

            // Update textarea with editor content
            var editor = CKEDITOR.instances['content_update_editor'];
            if (editor) {
                $('#content_update_editor').val(editor.getData());
            }

            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        editFormModal.modal('hide');
                        if (data.reload) location.reload();
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    let responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

        // delete document
        function deleteDocument(id) {
            let url = "{{ route('admin.governance.document.destroy', ':id') }}";
            url = url.replace(':id', id);

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
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.status) {
                                makeAlert('success', data.message, "{{ __('locale.Success') }}");
                                if (data.reload) {
                                    location.reload();
                                }
                            }
                        },
                        error: function(response) {
                            const responseData = response.responseJSON;
                            makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                        }
                    });
                }
            });
        }

        /* End Document */

        /* Start change status event */
        $('#privacy').hide();
        $('#approval_date').hide();
        $('#reviewer').hide();

        $('#privacy_update').hide();
        $('#approval_date_update').hide();
        $('#reviewer_update').hide();

        $('#privacy_show').hide();
        $('#approval_date_show').hide();
        $('#reviewer_show').hide();

        function changePrivacy(status_id) {
            if (status_id == 3) {
                $('#privacy').show();
                $('#approval_date').show();
                $('#reviewer').hide();
            } else if (status_id == 2) {
                $('#privacy').hide();
                $('#approval_date').hide();
                $('#reviewer').show();
            } else {
                $('#privacy').hide();
                $('#approval_date').hide();
                $('#reviewer').hide();
            }
        }

        function changePrivacy2(status_id) {
            if (status_id == 3) {
                $('#privacy_update').show();
                $('#approval_date_update').show();
                $('#reviewer_update').hide();
            } else if (status_id == 2) {
                $('#privacy_update').hide();
                $('#approval_date_update').hide();
                $('#reviewer_update').show();
            } else {
                $('#privacy_update').hide();
                $('#approval_date_update').hide();
                $('#reviewer_update').hide();
            }
        }

        function changePrivacy3(status_id) {
            if (status_id == 3) {
                $('#privacy_show').show();
                $('#approval_date_show').show();
                $('#reviewer_show').hide();
            } else if (status_id == 2) {
                $('#privacy_show').hide();
                $('#approval_date_show').hide();
                $('#reviewer_show').show();
            } else {
                $('#privacy_show').hide();
                $('#approval_date_show').hide();
                $('#reviewer_show').hide();
            }
        }
        /* End change status event */

        // // mapping using ajax
        $('.userinfo').click(function() {

            var userid = $(this).data('id');
            var url = "{{ route('admin.governance.ajax.get-list-map', '') }}" + "/" + userid;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    $('#empModal').modal('show');
                    $('#form-modal-map').html(response);

                }
            });
        });

        // unmap
        // // mapping using ajax
        function unmap(data) {

            var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: unmap_url,
                type: "GET",
                data: {},
                success: function(response) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                }
            });
        };


        $('.multiple-select2').select2();


        // function to show error validation
        function showError(data) {
            $('.error').empty().css('display', 'none');
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
                $('.error-' + key).css('display', 'inline-block');
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

        /* Start downlaod file */
        function downloadDoc(data) {
            var unmap_url = "{{ route('admin.governance.document.download', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: unmap_url,
                type: "GET",
                data: {},
                success: function(response) {}
            });
        };
        /* End downlaod file */
    </script>
    <script>
        // Load controls of framework
        $('[name="framework_ids[]"]').change(function() {
            $(this).parents('form').find("select[name='control_ids[]'] option").remove();
            const frameworks = $(this).find('option:selected');

            $.each(frameworks, function(indexInArray, framework) {
                $(framework).data('controls').forEach(frameworkControl => {
                    $(this).parents('form').find("select[name='control_ids[]']").append(
                        `<option value="${frameworkControl.id}">${frameworkControl.short_name}</option>`
                    );
                });
            });
        });

        // link last review with next review

        /* Start change dates event */
        $("[name='last_review_date']").change(function() {
            const that = this;
            var last_review = $(this).val();
            var days = $(this).parent().parent().find("[name='review_frequency']").val();

            if (days != 0) {
                var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last_review;

                $.ajax({
                    url: url,
                    success: function(response) {
                        $(that).parent().parent().find("[name='next_review_date']").val(response);
                    }
                });

            } else {
                $(that).parent().parent().find("[name='next_review_date']").val(last_review);

            }
        });

        $("[name='review_frequency']").change(function() {
            const that = this;
            var days = $(this).val();
            var last = $(this).parent().parent().find("[name='last_review_date']").val();
            var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last;

            $.ajax({
                url: url,
                success: function(response) {
                    $(that).parent().parent().find("[name='next_review_date']").val(response);

                }
            });
        });

        $("[name='review_frequency']").trigger('change');
        /* End change dates event */

        /* Start reset modal */
        function resetFormData(form) {
            $('.error').empty();
            form.trigger("reset")
            form.find('input:not([name="_token"])').val('');
            var editor = CKEDITOR.instances['content_editor'];
            if (editor) {
                editor.setData(''); // This clears the CKEditor content
            }
            form.find('select.multiple-select2 option[selected]').attr('selected', false);
            form.find('select.select2 form-select option[selected]').attr('selected', false);
            form.find('select.select2 option').attr('selected', false);
            form.find('select.select2 form-select option').attr('selected', false);
            form.find('select').trigger('change');
        }

        $('.modal').on('hidden.bs.modal', function() {
            if ($(this).is($('#edit_contModal')) || $(this).is($('#add_document1')))
                resetFormData($(this).find('form'));
        });

        $('.modal').on('hidden.bs.modal', function() {
            resetFormData($(this).find('form'));
        })
        /* End reset modal */
        // Open the Add Policy Modal and fetch existing policies
        function openAddPolicyModal(documentId) {
            document.querySelector('#add_Policy input[name="document_id"]').value = documentId;
            clearPolicyTable();
            fetchDocumentPolicies(documentId);
            const addPolicyModal = new bootstrap.Modal(document.getElementById('add_Policy'));
            addPolicyModal.show();
        }

        function logDocument(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Destroy existing DataTable if already initialized
            if ($.fn.DataTable.isDataTable('#logs-table')) {
                $('#logs-table').DataTable().destroy();
            }

            // Initialize DataTable
            $('#logs-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                ajax: {
                    url: '{{ route('admin.governance.GetDataDocumentLogs') }}',
                    type: 'GET',
                    data: {
                        id: id
                    }
                },
                columns: [{
                        data: 'timestamp',
                        name: 'timestamp',
                        title: '{{ __('locale.Date') }}'
                    },
                    {
                        data: 'user', // Assume there's a relationship or user name column
                        name: 'user',
                        title: '{{ __('locale.User') }}',
                        defaultContent: '—'
                    },
                    {
                        data: 'log_type',
                        name: 'log_type',
                        title: '{{ __('locale.Action') }}'
                    },
                    {
                        data: 'message',
                        name: 'message',
                        title: '{{ __('locale.Details') }}'
                    }
                ]
            });

            $('#documentLog').modal('show');
        }



        function openAddAuditPolicyModal(documentId, typeCategory) {
            document.querySelector('#AddNewAduitDocumentPolicy input[name="document_id"]').value = documentId;
            document.querySelector('#AddNewAduitDocumentPolicy input[name="document_type"]').value = typeCategory;

            const AddNewAduitDocumentPolicy = new bootstrap.Modal(document.getElementById('AddNewAduitDocumentPolicy'));
            AddNewAduitDocumentPolicy.show();
        }

        $(document).ready(function() {
            $('.select2').select2(); // Initialize select2 for all select elements

            function submitAuditForm(formId, modalId, tableReload = true) {
                $(formId).on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Serialize form data
                    var documentId = $(this).find('[name="document_id"]').val(); // Extract document ID
                    var auditPolicyId = $('[name="id"]').val(); // Get the value of audit_policy_id
                    console.log("Audit Policy ID:", auditPolicyId); // Log for debugging

                    // If audit_policy_id has a value, proceed directly to update
                    if (auditPolicyId) {
                        processAuditForm(formId, formData, modalId, tableReload);
                        return; // Skip further checks
                    }

                    // Perform the check for existing audits
                    $.ajax({
                        url: '{{ route('admin.governance.checkAuditDocumentPolicy') }}', // Route for checking
                        method: 'POST',
                        data: {
                            document_id: documentId,
                            _token: '{{ csrf_token() }}' // Add CSRF token for security
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Show SweetAlert2 confirmation dialog
                                Swal.fire({
                                    title: 'Audit in Progress',
                                    text: 'There is already an audit in progress for this document. Do you want to proceed?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, proceed',
                                    cancelButtonText: 'Cancel',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Proceed with form submission
                                        processAuditForm(formId, formData, modalId,
                                            tableReload);
                                    }
                                });
                            } else {
                                // No existing audit, proceed directly
                                processAuditForm(formId, formData, modalId, tableReload);
                            }
                        },
                        error: function(xhr) {
                            // Check if there's a response JSON and if it contains an error message
                            var errorMessage =
                                'Error checking audit document policy. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = xhr.responseJSON
                                    .errors; // Use the actual error message from the response
                            }

                            makeAlert('error', errorMessage, 'Error');
                        }

                    });
                });
            }

            function processAuditForm(formId, formData, modalId, tableReload) {
                $.ajax({
                    url: '{{ route('admin.governance.storeAduitDocumentPolicy') }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $.blockUI({
                            message: '<div class="d-flex justify-content-center align-items-center">' +
                                '<p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('Initiate Audit')]) }}</p>' +
                                '<div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                    },
                    complete: function() {
                        $.unblockUI(); // Unblock the UI after request completes
                    },
                    success: function(response) {
                        makeAlert('success', 'Audit Document Policy saved successfully!', 'Success');

                        // Reset form and modal fields only on success
                        if (tableReload) $('#AduitDocumentpoliciesTable').DataTable().ajax.reload();
                        $(formId)[0].reset();
                        $('.select2').val(null).trigger('change');
                        $(modalId).modal('hide'); // Hide the modal after success
                    },
                    error: function(xhr) {
                        $.unblockUI();
                        $(modalId).modal('show'); // Reopen modal on error

                        $(formId).find('.text-danger').text(''); // Clear previous error messages
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(formId).find(`.error-${key}`).text(value[0]);
                            });
                        } else {
                            // Check if there's a response JSON and if it contains an error message
                            var errorMessage =
                                'Error checking audit document policy. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = xhr.responseJSON
                                    .errors; // Use the actual error message from the response
                            }

                            makeAlert('error', errorMessage, 'Error');
                        }
                    },
                });
            }

            // Initialize form submission for Add New Audit
            submitAuditForm('#startAuditForm', '#AddNewAduitDocumentPolicy');

        });

        $('#AddNewAduitDocumentPolicy').on('hidden.bs.modal', function() {
            // Reset the form inside the modal
            $('#startAuditForm')[0].reset();

            // Reset select2 dropdowns
            $('.select2').val(null).trigger('change');

            // Uncheck the checkboxes
            $('[name="requires_file"]').prop('checked', false);

        });

        function clearPolicyTable() {
            const policyTableBody = document.querySelector('#policyTable tbody');
            policyTableBody.innerHTML = '';
        }

        function fetchDocumentPolicies(documentId) {
            const url = "{{ route('admin.governance.document.policies', ':documentId') }}".replace(':documentId',
                documentId);
            fetch(url)
                .then(response => response.json())
                .then(policies => {
                    populatePolicyTable(policies);
                })
                .catch(error => {
                    console.error('Error fetching policies:', error);
                    showAlert('error', 'Failed to fetch policies.');
                });
        }

        function populatePolicyTable(policies) {
            const policyTableBody = document.querySelector('#policyTable tbody');
            policyTableBody.innerHTML = ''; // Clear the table before populating

            if (policies.length > 0) {
                // Get current locale from Laravel (set in a JS variable or meta tag)
                let locale = document.documentElement.lang || 'en';
                // If you have a JS variable for locale, use it instead
                if (typeof window.appLocale !== 'undefined') {
                    locale = window.appLocale;
                }
                policies.forEach((policy, index) => {
                    // policy.name may be a JSON string or object; handle both
                    let policyName = '';
                    if (typeof policy.name === 'string') {
                        try {
                            let parsed = JSON.parse(policy.name);
                            policyName = parsed[locale] || parsed['en'] || parsed['ar'] || policy.name;
                        } catch (e) {
                            policyName = policy.name;
                        }
                    } else if (typeof policy.name === 'object' && policy.name !== null) {
                        policyName = policy.name[locale] || policy.name['en'] || policy.name['ar'] || '';
                    }

                    let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${policyName}</td>
                    <td>${new Date(policy.created_at).toLocaleDateString()}</td>
            `;

                    if (permission['Document_Policy_delete']) {
                        row += `
                    <td>
                        <a href="javascript:;" onclick="deletePolicyDocument(${policy.id})" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                `;
                    }

                    row += `</tr>`;
                    policyTableBody.innerHTML += row;
                });
            } else {
                policyTableBody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No policies found.</td></tr>';
            }
        }


        function deletePolicyDocument(policyId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: "{{ __('locale.YouWontBeAbleToRevertThis') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('admin.governance.document.policy.delete', '') }}/${policyId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                makeAlert('success', response.message, 'Success');
                                $('#addPolicyModal').modal('hide'); // Close the modal
                                const documentId = document.querySelector(
                                    '#add_Policy input[name="document_id"]').value;
                                openAddPolicyModal(documentId); // Refresh the policies
                                $('.modal-backdrop').remove(); // Remove any lingering backdrop
                            } else {
                                makeAlert('error', response.message,
                                    'Error'); // Adjusted for consistent error handling
                            }
                        },
                        error: function(xhr) {
                            // Log the error and display it using makeAlert
                            console.error('Error deleting policy:', xhr);
                            let errorMessage = 'An error occurred while deleting the policy.';

                            // Optionally, you can check for a specific error message from the server
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            makeAlert('error', errorMessage,
                                'Error'); // Use makeAlert for error display
                        }
                    });
                }
            });
        }


        function setDocumentId() {
            const documentId = document.querySelector('#add_Policy input[name="document_id"]').value;
            fetchPolicies(documentId);
            document.querySelector('#inner_document_id').value = documentId;
        }

        function fetchPolicies(documentId) {
            $.ajax({
                url: '{{ route('admin.governance.policies.fetch') }}',
                type: 'GET',
                data: {
                    document_id: documentId
                },
                success: function(response) {
                    populatePolicyDropdown(response.policies);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching policies:", error);
                    showAlert('error', 'Failed to fetch policies.');
                }
            });
        }

        function populatePolicyDropdown(policies) {
            const policySelect = $('#policy_id');
            policySelect.empty().append('<option value="" disabled selected>{{ __('locale.Select a policy') }}</option>');
            policies.forEach(policy => {
                policySelect.append(new Option(policy.policy_name, policy.id));
            });
        }

        $(document).ready(function() {
            $('#form-add_policy').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.governance.storePolicyDocument') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addPolicyModal').modal('hide');
                            $('#form-add_policy')[0].reset();
                            makeAlert('success', response.message, 'Success');
                            openAddPolicyModal(response.document_id);
                        }
                    },
                    error: function(response) {
                        const errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            makeAlert('error', value[0], 'Error');
                        });
                    }
                });
            });

            // Remove backdrop and reset modal on hidden
            $('#addPolicyModal').on('hidden.bs.modal', function() {
                $('.modal-backdrop').remove();
                $(this).find('form')[0].reset();
            });
        });

        function togglePolicyInput() {
            const selectPolicyGroup = document.getElementById('selectPolicyGroup');
            const inputPolicyGroupEn = document.getElementById('inputPolicyGroupEn');
            const inputPolicyGroupAr = document.getElementById('inputPolicyGroupAr');
            const toggle = document.getElementById('toggleNewPolicy');

            if (toggle.checked) {
                selectPolicyGroup.classList.add('d-none');
                inputPolicyGroupEn.classList.remove('d-none');
                inputPolicyGroupAr.classList.remove('d-none');
                document.getElementById('policy_id').removeAttribute('required');
                document.getElementById('new_policy_name_en').setAttribute('required', 'true');
                document.getElementById('new_policy_name_ar').setAttribute('required', 'true');
                document.getElementById('policy_id').value = '';
            } else {
                selectPolicyGroup.classList.remove('d-none');
                inputPolicyGroupEn.classList.add('d-none');
                inputPolicyGroupAr.classList.add('d-none');
                document.getElementById('new_policy_name_en').removeAttribute('required');
                document.getElementById('new_policy_name_ar').removeAttribute('required');
                document.getElementById('policy_id').setAttribute('required', 'true');
                document.getElementById('new_policy_name_en').value = '';
                document.getElementById('new_policy_name_ar').value = '';
            }
        }



        var options = {
            series: {!! json_encode($documntationStatistic['chartData']->pluck('percentage')->toArray()) !!}, // Extract percentages
            chart: {
                type: 'pie',
                height: 350
            },
            labels: {!! json_encode($documntationStatistic['chartData']->pluck('category_name')->toArray()) !!}, // Extract category names
            title: {
                text: "",
                style: {
                    fontWeight: 'bold',
                    fontSize: '13px'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + "%";
                    }
                },
                style: {
                    fontWeight: 'normal',
                    fontSize: '13px'
                }
            },
            dataLabels: {
                enabled: false // Disable data labels (percentages) on the chart
            }
        };

        var chart = new ApexCharts(document.querySelector("#documentation-chart"), options);
        chart.render();
 

        $(document).on('click', '.deleteItem', function(event) {
            var deleteButton = $(this);
            var activeTab = document.querySelector('.tab.active'); // Get active category on page load
            var categoryId = activeTab.dataset.tab;

            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: '@lang('locale.YouWontBeAbleToRevertThis')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/governance/doc-delete') }}',
                        method: "get",
                        data: {
                            id: categoryId
                        },
                        success: function(data) {
                            location.reload();
                        },
                        error: function(response) {
                            const responseData = response.responseJSON;
                            makeAlert('error', responseData.message,
                                "{{ __('locale.Error') }}");
                        }
                    });
                }
            });
        });
        $(document).on('click', '.updateItem', function(event) {
            event.preventDefault(); // Prevent default button behavior

            // Get the active tab
            var activeTab = document.querySelector('.tab.active');

            // Retrieve data attributes
            var categoryId = activeTab.dataset.tab;
            var itemId = activeTab.dataset.id;
            var itemName = activeTab.dataset.name;
            // Optionally, you can also retrieve the category type if needed
            var categoryType = activeTab.dataset.type;

            // Populate the modal with the retrieved data
            $('#edit-category-id').val(categoryId);
            $('#edit-name').val(itemName);
            $('#form-edit [name="type_category"]').val(categoryType).trigger('change'); // For Select2

            // Show the modal
            $('#edit-modal').modal('show');
        });




        $(document).ready(function() {
            // Initialize variables
            var $searchInput = $('.search-task');
            var $carouselContainer = $('.carousel-container');
            var $tabs = $('.sideNavBtn');

            // Function to filter tabs based on search input
            function filterTabs() {
                var filter = $searchInput.val().toLowerCase();

                $tabs.each(function() {
                    var text = $(this).text().toLowerCase();
                    if (text.indexOf(filter) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // If no tabs are visible, show a "No Results" message
                var visibleTabs = $carouselContainer.find('.sideNavBtn:visible').length;
                if (visibleTabs === 0) {
                    // Optionally, display a "No Results" message
                    // For example:
                    // $carouselContainer.append('<p>No templates found.</p>');
                } else {
                    // Remove any "No Results" message if present
                    // $carouselContainer.find('p').remove();
                }
            }

            // Debounce function to improve performance
            function debounce(func, wait) {
                var timeout;
                return function() {
                    var context = this,
                        args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            }

            // Attach the debounced filter function to the input event
            $searchInput.on('input', debounce(filterTabs, 300));

            // Initialize by filtering once on page load
            filterTabs();
        });

        $('#add_document').on('show.bs.modal', function(e) {
            var activeTab = document.querySelector('.tab.active');
            if (activeTab) {
                var categoryId = activeTab.dataset.tab;
                $('#store_category_id').val(categoryId).trigger(
                    'change'); // Set value and trigger change for Select2
            }
        });
        $(document).ready(function() {
            // Function to calculate the next initiate date
            function calculateNextInitiateDate(dueDateId, periodicalTimeId, nextInitiateDateId) {
                const dueDate = $(dueDateId).val();
                const periodicalTime = parseInt($(periodicalTimeId).val());

                if (dueDate) {
                    let dueDateObj = new Date(dueDate);

                    if (periodicalTime === 0) {
                        $(nextInitiateDateId).val(dueDate);
                    } else if (periodicalTime > 0) {
                        dueDateObj.setDate(dueDateObj.getDate() + periodicalTime);
                        const nextInitiateDate = dueDateObj.toISOString().split('T')[0];
                        $(nextInitiateDateId).val(nextInitiateDate);
                    } else {
                        $(nextInitiateDateId).val('');
                    }
                } else {
                    $(nextInitiateDateId).val('');
                }
            }

            // Function to set up event listeners
            function setupEventListeners(dueDateId, periodicalTimeId, nextInitiateDateId) {
                $(dueDateId).on('change', function() {
                    calculateNextInitiateDate(dueDateId, periodicalTimeId, nextInitiateDateId);
                });

                $(periodicalTimeId).on('input', function() {
                    calculateNextInitiateDate(dueDateId, periodicalTimeId, nextInitiateDateId);
                });
            }

            // Set up listeners for the original fields
            setupEventListeners('#due_date', '#periodical_time', '#next_initiate_date');
        });
    </script>

    <!-- Page js files -->
    <script>
        const lang = []
        URLs = [], user_id = {{ auth()->id() }}, customUserName =
            "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
        userName = "{{ auth()->user()->name }}";
        URLs['sendNote'] = "{{ route('admin.governance.send-note') }}";
        URLs['sendNoteFile'] = "{{ route('admin.governance.send-note-file') }}";
        URLs['downloadDocumentCommentFile'] =
            "{{ route('admin.governance.ajax.downloadDocumentCommentFile', '') }}";

        // Download supporting documentation start
        $(document).on("click", ".supporting_documentation", function() {
            const form = $('#download-file-form');
            form.find('[name="document_id"').val($(this).data('documentId'));
            form.trigger('submit');
        });
        // When modal is hidden, reset CKEditor content
        $('.modal').on('hidden.bs.modal', function() {
            // Reset content create editor
            if (CKEDITOR.instances['content_editor']) {
                CKEDITOR.instances['content_editor'].setData('');
            }

            // Reset content update editor
            if (CKEDITOR.instances['content_update_editor']) {
                CKEDITOR.instances['content_update_editor'].setData('');
            }

            // Reset content show editor
            if (CKEDITOR.instances['content_show_editor']) {
                CKEDITOR.instances['content_show_editor'].setData('');
            }
            if (CKEDITOR.instances['introduction_content_editor_en']) {
                CKEDITOR.instances['introduction_content_editor_en'].setData('');
            }
            if (CKEDITOR.instances['introduction_content_editor_ar']) {
                CKEDITOR.instances['introduction_content_editor_ar'].setData('');
            }

            // Optional: reset validation error messages
            $(this).find('.error').text('');
        });


        $(document).on('submit', '#policyAdoptionForm', function(e) {
            e.preventDefault(); // stop default form submission

            const modal = $(this).parents('#approve-modal');

            // Get CKEditor content
            var editorContentEn = CKEDITOR.instances['introduction_content_editor_en'].getData();
            var editorContentAr = CKEDITOR.instances['introduction_content_editor_ar'].getData();
            var activeTab = document.querySelector('.tab.active'); // Get active category on page load

            var categoryId = activeTab.dataset.tab;
            $('#category_id').val(categoryId);
            var formData = new FormData(this);
            formData.set('introduction_content_en', editorContentEn); // override with CKEditor data
            formData.set('introduction_content_ar', editorContentAr); // override with CKEditor data

            $.ajax({
                url: "{{ route('admin.adoption_policies.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $('#approve-modal').modal('hide');

                        // Reset form and editor
                        $('#policyAdoptionForm')[0].reset();
                        CKEDITOR.instances['introduction_content_editor'].setData('');
                    } else {
                        makeAlert('error', data.errors, lang['error']);
                    }
                },
                error: function(response) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                }
            });
        });
    </script>

    <script src="{{ asset('ajax-files/governance/document/app-chat.js') }}"></script>
    <!-- // Add message to chat - function call on form submit -->

    <script>
        // Pass Laravel locale to JavaScript
        window.appLocale = '{{ app()->getLocale() }}';
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselContainer = document.querySelector('.carousel-container');
            const prevButton = document.querySelector('.carousel-button.prev');
            const nextButton = document.querySelector('.carousel-button.next');
            const docNameElement = document.querySelector('.DocName');
            const docTypeElement = document.querySelector('.DocType');
            const tabs = document.querySelectorAll('.tab');

            // Check for RTL by Laravel locale
            const locale = window.appLocale || document.documentElement.lang || 'en';
            const rtlLanguages = ['ar', 'ar-EG', 'ar-SA', 'he', 'fa', 'ur'];
            const isRTL = rtlLanguages.includes(locale) ||
                document.dir === 'rtl' ||
                document.documentElement.dir === 'rtl';

            console.log('Current locale:', locale, 'Is RTL:', isRTL);

            // 🔹 Map category type to translated name
            function mapCategoryType(typeNumber) {
                switch (typeNumber) {
                    case '1':
                        return "{{ __('locale.Standard') }}";
                    case '2':
                        return "{{ __('locale.Policy') }}";
                    case '3':
                        return "{{ __('locale.procedures') }}";
                    case '4':
                        return "{{ __('locale.Others') }}";
                    default:
                        return "{{ __('locale.Unknown') }}";
                }
            }

            // 🔹 Update displayed document name and type
            function updateDocNameByDom(tab) {
                if (!tab) return;
                const categoryName = tab.getAttribute('data-name');
                const categoryType = tab.getAttribute('data-type');

                if (docNameElement) docNameElement.textContent = categoryName || '';
                if (docTypeElement) docTypeElement.textContent = mapCategoryType(categoryType);
            }

            // 🔹 Update button states
            function updateButtons() {
                if (!carouselContainer) return;

                const scrollWidth = carouselContainer.scrollWidth;
                const clientWidth = carouselContainer.clientWidth;
                const scrollLeft = carouselContainer.scrollLeft;

                if (isRTL) {
                    const maxScrollLeft = scrollWidth - clientWidth;
                    const atStart = scrollLeft >= -1 && scrollLeft <= 1;
                    const atEnd = Math.abs(scrollLeft) >= (maxScrollLeft - 1) || scrollLeft <= -(maxScrollLeft - 1);

                    nextButton.disabled = atStart;
                    prevButton.disabled = atEnd;
                } else {
                    const atStart = scrollLeft <= 1;
                    const atEnd = scrollLeft >= (scrollWidth - clientWidth - 1);

                    prevButton.disabled = atStart;
                    nextButton.disabled = atEnd;
                }
            }

            // 🔹 Scroll function
            function scroll(direction) {
                const scrollAmount = 200;
                const currentScroll = carouselContainer.scrollLeft;

                if (isRTL) {
                    // RTL direction fix
                    carouselContainer.scrollLeft = currentScroll + (direction === 'next' ? scrollAmount : -
                        scrollAmount);
                } else {
                    carouselContainer.scrollLeft = currentScroll + (direction === 'next' ? scrollAmount : -
                        scrollAmount);
                }
            }

            // 🔹 Button event listeners
            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    scroll('prev');
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    scroll('next');
                });
            }

            // 🔹 Carousel scroll event
            if (carouselContainer) {
                carouselContainer.addEventListener('scroll', updateButtons);
                updateButtons();
                setTimeout(updateButtons, 100);
            }

            // 🔹 Handle window resize
            window.addEventListener('resize', updateButtons);

            // 🔹 Tab click functionality
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    updateDocNameByDom(this); // ✅ Update doc name and type

                    const tabId = this.dataset.tab;
                    const tabName = this.dataset.name;
                    const tabType = this.dataset.type;

                    console.log('Selected tab:', {
                        id: tabId,
                        name: tabName,
                        type: tabType
                    });
                });
            });

            // 🔹 Initialize first active tab (if exists)
            const activeTab = document.querySelector('.tab.active');
            if (activeTab) {
                updateDocNameByDom(activeTab);
            } else if (tabs.length > 0) {
                tabs[0].classList.add('active');
                updateDocNameByDom(tabs[0]);
            }
        });
    </script>

    @include('admin.content.governance.DocumentationAjax')
@endsection
