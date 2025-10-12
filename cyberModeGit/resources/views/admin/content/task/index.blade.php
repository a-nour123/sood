@extends('admin/layouts/contentLayoutMaster')
<?php
$priorities = [
    'No Priority' => 'dark',
    'Low' => 'success',
    'Normal' => 'info',
    'High' => 'warning',
    'Urgent' => 'danger',
];

?>
@section('title', $createdByMe ? __('task.CreatedTasks') : __('task.Tasks'))

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
    <!-- Page css files -->

    <style>
        html .navbar-floating.footer-static .app-content .content-area-wrapper,
        html .navbar-floating.footer-static .app-content .kanban-wrapper {
            height: auto !important;
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
            margin-top: 25px;
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

        .card {
            margin-bottom: 15px !important;

        }


        .carousel {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
        }

        .carousel-container {
            display: flex;
            transition: transform 0.3s ease-in-out;
            margin-bottom: 43px;
        }

        .tab {
            flex: 0 0 auto;
            text-align: center;
            background: #f2f2f2;
            cursor: pointer;
            padding: 15px;
            border-radius: 6px;
            white-space: nowrap;
            border: 1px solid white;
            color: #5e5873;
            font-size: 1rem;
            width: 260px;
        }

        .card-top {
            width: 99% !important;
        }

        /* .tab {
                                                                                                        padding: 15px 25px;
                                                                                                        margin: 0 5px;
                                                                                                    } */

        .tab.active {
            background: #44225c !important;
            box-shadow: 0 4px 10px -4px rgba(68, 34, 92, 0.5);
            color: white !important;
        }

        .carousel-button {
            position: absolute;
            top: 90%;
            transform: translateY(-50%);
            background: white;
            color: #43215b;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .prev {
            left: 46%;
        }

        .next {
            right: 48%;
        }

        .tab-content {
            margin-top: 20px;
            display: none;
        }

        .tab-content.active {
            display: block;
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
    </style>
@endsection




@section('content')

    <div class="content-header row ">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid m-0">
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
    <div id="quill-service-content" class="d-none"></div>

</div>


<div class="card card-top p-4 m-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <div class="mb-0 h3 d-flex align-items-center">
                <p class="fs-4 mb-0">Templates : </p>
                <p class="fs-4 mb-0">{{ $category2->count() }}</p>
            </div>
            <div class="search-container ms-3">
                <input class="input-simple search-task" type="text" placeholder="Search by Template name">
            </div>
        </div>
        @if (auth()->user()->hasPermission('task.create'))
            <button id="cat" type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#new-Category-task-modal">
                <i class="fas fa-plus me-2"></i> New Template
            </button>


        @endif
    </div>

    <!-- Start Carousel Tabs -->
    <div class="carousel">
        <div class="carousel-container">
            @foreach ($category2 as $category)
                <button class="tab sideNavBtn{{ $loop->first ? ' active' : '' }}" data-tab="{{ $category->id }}"
                    data-name="{{ $category->name }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
        <button class="carousel-button prev">
            <i class="fa-solid fa-chevron-left" style="font-size: 20px;"></i>
        </button>
        <button class="carousel-button next">
            <i class="fa-solid fa-chevron-right" style="font-size: 20px;"></i>
        </button>
    </div>
</div>

<section id="advanced-search-datatable">

    <div class="card2" id="itemCard">
        <div class="card">
            <div class="card-body" style="display: flex !important;  justify-content: space-between !important;">
                <div class="frame">
                    <h4 class="card-title">{{ __('locale.Name') }}: </h4>
                    <!-- Use null coalescing operator to echo category name or empty string if $category2 is null or empty -->
                    <h5 class="card-desc DocName"></h5>
                </div>

                <div class="action-content" style="display: inherit !important;align-items: center !important;">

                    @if ($createdByMe)

                        @if (auth()->user()->hasPermission('task.create'))
                            <button type="button" class="card-link btn btn-outline-primary btn-sm updateItem"
                                data-bs-target="#new-Category-task-modal" data-bs-toggle="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"
                                    style="width: 30px; color: #44225c; height: 30px;">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>

                            <button class="card-link btn btn-outline-danger btn border-0 px-0 mx-2 deleteItem">
                                <i class="fa-solid fa-trash-can" style="color:#ba1717; font-size: 28px;"></i>
                            </button>

                            <button class=" btn btn-primary " id="addn" type="button" data-bs-toggle="modal"
                                data-bs-target="#new-task-modal">
                                <i class="fa fa-plus"></i>
                            </button>

                            <a href="{{ route('admin.task.notificationsSettingsTask') }}" class=" btn btn-primary"
                                target="_self" id="notif" class="btn btn-primary" target="_self">
                                <i class="fa fa-regular fa-bell"></i>
                            </a>
                        @endif
                    @endif
                    @php
                        $exportName = $createdByMe ? __('task.CreatedTasks') : __('task.Tasks');
                        $exportRoute = $createdByMe
                            ? 'admin.task.ajax.created.export'
                            : 'admin.task.ajax.assigned.export';
                    @endphp

                    <x-export-import :name="$exportName" createPermissionKey='task.create'
                        exportPermissionKey='task.export' :exportRouteKey='$exportRoute' importRouteKey='will-added-TODO' />
                </div>
            </div>
        </div> <!-- Close card -->
    </div> <!-- Close card2 -->




    <div class="row data-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.Tasks') }}</h4>
                    </div>

                </div>

                <!-- Todo List starts -->
                <hr class="my-0">
                <div class="card-datatable table-responsive mx-1">
                    <div class="todo-task-list-wrapper list-group">
                        <div class="row g-1 mb-md-1">

                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Priority') }}</label>
                                <div class="position-relative">
                                    <select id="priority-filter"
                                        class="form-control dt-input dt-select select2 select2-hidden-accessible">
                                        <option value="">{{ __('locale.select_option') }}</option>
                                        <option value="No Priority">{{ __('locale.no_priority') }}</option>
                                        <option value="Low">{{ __('locale.low') }}</option>
                                        <option value="Normal">{{ __('locale.normal') }}</option>
                                        <option value="High">{{ __('locale.high') }}</option>
                                        <option value="Urgent">{{ __('locale.urgent') }}</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Complete') }}</label>
                                <div class="position-relative">
                                    <select id="status-filter"
                                        class="form-control dt-input dt-select select2 select2-hidden-accessible">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        <option value="Accepted">{{ __('locale.Accepted') }}</option>
                                        <option value="Closed">{{ __('locale.Closed') }}</option>
                                        <option value="In Progress">{{ __('locale.In Progress') }}</option>
                                        <option value="Open">{{ __('locale.Open') }}</option>
                                        <option value="Completed">{{ __('locale.Completed') }}</option>
                                    </select>
                                </div>
                            </div>

                            <table id="todo-task-table" class="table todo-task-list media-list">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.Title') }}</th>
                                        <th>{{ __('locale.Priority') }}</th>
                                        <th>{{ __('locale.Category') }}</th>
                                        <th>{{ __('locale.AssignedFrom') }}</th>
                                        <th>{{ __('locale.AssignedTo') }}</th>
                                        <th>{{ __('locale.Status') }}</th>
                                        <th>{{ __('locale.DueDate') }}</th>
                                        <th>{{ __('locale.Action') }}</th> <!-- New column for action -->
                                    </tr>
                                </thead>
                                <tbody></tbody> <!-- Empty tbody tag for dynamic data -->
                            </table>
                        </div>
                    </div> <!-- Todo List ends -->

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Right Sidebar starts -->
<div class="modal fade  sidebar-todo-modal bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModal" aria-hidden="true" id="new-task-modal">
    <div class="modal-dialog modal-xl">


        <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-task-modal">
          <div class="modal-dialog sidebar-lg"> -->
        <div class="modal-content">
            @if ($createdByMe)
                <form id="form-modal-todo" class="todo-modal needs-validation" novalidate onsubmit="return false">
                    <input type="hidden" name="id">
                @else
                    <div id="form-modal-todo" class="todo-modal needs-validation">
                        <input type="hidden" name="id">
            @endif
            @if ($createdByMe)
                @csrf
            @endif

            <div class="modal-header">
                <h4 class="modal-title">{{ __('task.AddNewTask') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <div class="modal-header align-items-center mb-1">
                      <h5 class="modal-title">{{ __('task.AddNewTask') }}</h5>
                      <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                          <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                      </div>
                  </div> -->
            <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                <div class="action-tags">
                    <div class="mb-1">
                        <label for="title" class="form-label">{{ __('task.TaskTitle') }}</label>
                        <input type="text" id="title" name="title" class="new-todo-item-title form-control"
                            placeholder="Title" {{ $createdByMe ? '' : 'readonly' }}>
                        <span class="error error-title"></span>
                    </div>
                    <div class="mb-1">
                        <label for="title" class="form-label">{{ __('locale.AssigneeType') }}</label>
                        <div class="demo-inline-spacing">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="assignee_type" id="Employee"
                                    value="User" checked {{ $createdByMe ? '' : 'disabled' }}>
                                <label class="form-check-label" for="Employee">{{ __('locale.Employee') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="assignee_type" id="Team"
                                    value="Team" {{ $createdByMe ? '' : 'disabled' }}>
                                <label class="form-check-label" for="Team">{{ __('locale.Team') }}</label>
                            </div>
                        </div>
                        <span class="error error-assignee_type"></span>
                    </div>

                    <div class="mb-1 position-relative" id="task_assigned_container">
                        <label for="task-assigned" class="form-label d-block">{{ __('locale.Assignee') }}</label>
                        <select class="select2 form-select" id="task-assigned" name="task-assigned"
                            {{ $createdByMe ? '' : 'disabled' }}>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            @foreach ($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-task-assigned"></span>
                    </div>
                    {{-- Team --}}
                    <div class="mb-1 d-none" id="task_assigned_team_container">
                        <label class="form-label ">{{ __('locale.Team') }}</label>
                        <select name="task_assigned_team" id="task-assigned-team" class="form-select select2"
                            {{ $createdByMe ? '' : 'disabled' }}>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-task_assigned_team"></span>
                    </div>
                    <div class="mb-1 position-relative" id="task_category_container">
                        <label for="task-assigned" class="form-label d-block">{{ __('locale.Category') }}</label>
                        <select class="select2 form-select" id="task_cat" name="task_cat"
                            {{ $createdByMe ? '' : 'disabled' }}>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-task_cat"></span>
                    </div>

                    <div class="mb-1">
                        <label for="task-start-date" class="form-label">{{ __('locale.StartDate') }}</label>
                        <input type="text" class="form-control task-start-date" id="task-start-date"
                            name="task-start-date" {{ $createdByMe ? '' : 'disabled' }} />
                        <span class="error error-task-start-date"></span>
                    </div>
                    <div class="mb-1">
                        <label for="task-due-date" class="form-label">{{ __('locale.DueDate') }}</label>
                        <input type="text" class="form-control task-due-date" id="task-due-date"
                            name="task-due-date" {{ $createdByMe ? '' : 'disabled' }} />
                        <span class="error error-task-due-date"></span>
                    </div>
                    <div class="mb-1">
                        <label for="task-tag" class="form-label d-block">{{ __('task.TaskPriority') }}</label>
                        <select class="select2 form-select task-tag" id="task-tag" name="task-priority"
                            {{ $createdByMe ? '' : 'disabled' }}>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            <option value="No Priority">{{ __('locale.No Priority') }}</option>
                            <option value="Low">{{ __('locale.Low') }}</option>
                            <option value="Normal">{{ __('locale.Normal') }}</option>
                            <option value="High">{{ __('locale.High') }}</option>
                            <option value="Urgent">{{ __('locale.Urgent') }}</option>
                        </select>
                        <span class="error error-task-priority"></span>
                    </div>
                    @if ($createdByMe)
                        <div class="mb-1 d-none" id="creator-task-status-container">
                            <label for="creator-task-status"
                                class="form-label d-block">{{ __('task.TaskStatus') }}</label>
                            <select class="select2 form-select task-tag" id="creator-task-status" name="task-status"
                                {{ $createdByMe ? '' : 'disabled' }}>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                </option>
                                <option value="Accepted">{{ __('locale.Accepted') }}</option>
                                <option value="Closed">{{ __('locale.Closed') }}</option>
                            </select>
                            <span class="error error-task-status"></span>
                        </div>
                    @endif
                    <textarea name=description class='d-none'></textarea>
                    <div class="mb-1">
                        <label class="form-label">{{ __('locale.Description') }}</label>
                        @if ($createdByMe)
                            <div id="task-desc" class="border-bottom-0" data-placeholder="Write Your Description">
                            </div>
                            <div class="d-flex justify-content-end desc-toolbar border-top-0">
                                <span class="ql-formats me-2">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-align"></button>
                                    <button class="ql-link"></button>
                                </span>
                            </div>
                        @else
                            <div class="form-control" id="display-describtion" rows="3"
                                style="background-color: #efefef;">Description</div>
                        @endif
                        <span class="error error-description"></span>
                    </div>

                    {{-- Supporting Documentation --}}
                    <div class="mb-1 supporting_documentation_container">
                        <label class="text-label">{{ __('locale.SupportingDocumentation') }}</label>
                        :
                        @if ($createdByMe)
                            <input type="file" multiple name="supporting_documentation[]"
                                class="form-control dt-post"
                                aria-label="{{ __('locale.SupportingDocumentation') }}" />
                            <span class="error error-supporting_documentation "></span>
                        @endif
                        {{-- <div class="mitigation-files" style="margin-top: 5px">
                                      <span class="badge bg-secondary supporting_documentation cursor-pointer" data-id="{{ $file->id ?? 'FID' }}" data-task-id="{{ 1 }}">{{ $file->display_name ?? 'DN' }}</span>
                                  <span class="text-danger delete_supporting_documentation cursor-pointer" data-id="{{ $file->id ?? 'FID' }}" data-task-id="{{ 1 }}"><i data-feather="x"></i></span>
                              </div> --}}
                        {{-- <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span> --}}
                    </div>
                </div>
                <div class="my-1">
                    <button type="submit"
                        class="btn btn-primary d-none add-todo-item me-1">{{ __('locale.Add') }}</button>
                    <button type="button" class="btn btn-outline-secondary add-todo-item d-none"
                        data-bs-dismiss="modal">
                        {{ __('locale.Cancel') }}
                    </button>
                    <button type="button"
                        class="btn btn-primary d-none update-btn update-todo-item me-1">{{ __('locale.Update') }}</button>
                    <button type="button" class="btn btn-outline-danger update-btn delete-todo-item d-none"
                        data-bs-dismiss="modal">
                        {{ __('locale.Delete') }}
                    </button>
                </div>
            </div>
            @if ($createdByMe)
                </form>
            @else
        </div>
        @endif
        @if (!$createdByMe)
            <form id="assignee-change-status-form" class="todo-modal needs-validation mx-2" novalidate
                onsubmit="return false">
                @method('put')
                @csrf
                <input type="hidden" name="id">
                <div class="mb-1">
                    <label for="assignee-task-status" class="form-label d-block">{{ __('task.TaskStatus') }}</label>
                    <select class="select2 form-select task-tag" id="assignee-task-status" name="task-status">
                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                        <option value="In Progress">{{ __('locale.In Progress') }}</option>
                        <option value="Completed">{{ __('locale.Completed') }}</option>
                    </select>
                    <span class="error error-task-status"></span>
                </div>
                <div class="my-1">
                    <button type="button" class="btn btn-primary me-1"
                        id="update-change-status-btn">{{ __('locale.Update') . ' ' . __('task.TaskStatus') }}</button>
                </div>
            </form>
        @endif
        <div class="border-bottom mx-1 my-1">
        </div>
        <div id="chat-container" class="d-none">
            <!-- Main chat area -->
            <section class="chat-app-window">
                <!-- To load Conversation -->
                <div class="start-chat-area">
                    <h4 class="sidebar-toggle start-chat-text mx-1">{{ __('task.TaskNotes') }}</h4>
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
                                    <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="avatar"
                                        height="36" width="36" />
                                    <span class="avatar-status-busy"></span>
                                </div>
                                <h6 class="mb-0">Kristopher Candy</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                <i data-feather="phone-call"
                                    class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                <i data-feather="video"
                                    class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                <i data-feather="search" class="cursor-pointer d-sm-block d-none font-medium-2"></i>
                                <div class="dropdown">
                                    <button class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i data-feather="more-vertical" id="chat-header-actions"
                                            class="font-medium-2"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="chat-header-actions">
                                        <a class="dropdown-item" href="#">View Contact</a>
                                        <a class="dropdown-item" href="#">Mute Notifications</a>
                                        <a class="dropdown-item" href="#">Block Contact</a>
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
                    <p class="my-0 mx-2" id="file-name" data-content="{{ __('locale.FileName', ['name' => '']) }}">
                    </p>
                    <!-- Submit Chat form -->
                    <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);"
                        onsubmit="enterChat();">
                        @csrf
                        <input type="hidden" name="task_id" />
                        <div class="input-group input-group-merge me-1 form-send-message">
                            <input type="text" class="form-control message"
                                placeholder="{{ __('locale.TypeYourNote') }}" />
                            <span class="input-group-text" title="hhhh">
                                <label for="attach-doc" class="attachment-icon form-label mb-0">
                                    <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                    <input name="note_file" type="file" id="attach-doc" hidden /> </label></span>
                        </div>
                        <button type="button" class="btn btn-primary send" onclick="enterChat();">
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
<!-- Right Sidebar ends -->
<form class="d-none" id="download-file-form" method="post" action="{{ route('admin.task.ajax.download_file') }}">
    @csrf
    <input type="hidden" name="id">
    <input type="hidden" name="task_id">
</form>

<!-- Right Sidebar ends -->
<form class="d-none" id="download-note-file-form" method="post"
    action="{{ route('admin.task.ajax.download_note_file') }}">
    @csrf
    <input type="hidden" name="id">
    <input type="hidden" name="task_id">
</form>

<div class="modal fade" tabindex="-1" aria-hidden="true" id="new-Category-task-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ __('locale.TaskCategory') }}</h1>
                </div>
                <!-- Evidence form -->
                <form class="row TaskCateogryForm" onsubmit="return false" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 objective_id_container">
                        {{-- objective id --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.TaskCategory') }}</label>
                            <input type="text" id="name" name="name"
                                class="new-todo-item-title form-control" placeholder="Title">
                            <span class="error error-name"></span>
                        </div>
                    </div>
                    <input type="hidden" id="category_id" name="category_id">

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
    aria-hidden="true" id="new-copy-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('task.AddNewTask') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <div class="modal modal-slide-in sidebar-todo-modal1 fade" id="new-copy-modal">
          <div class="modal-dialog sidebar-lg"> -->
            <div class="modal-content p-0">
                <form id="form-modal-todo1" class="todo-modal needs-validation1" novalidate>
                    <input type="hidden" name="id">
                    @csrf
                    <!-- <div class="modal-header align-items-center mb-1">
                          <h5 class="modal-title1">{{ __('task.AddNewTask') }}</h5>
                          <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                              <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                          </div>
                      </div> -->
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('task.TaskTitle') }}</label>
                                <input type="text" id="title1" name="title"
                                    class="new-todo-item-title form-control" placeholder="Title">
                                <span class="error error-title"></span>
                            </div>
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.AssigneeType') }}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="assignee_type"
                                            id="Employee1" value="User" checked>
                                        <label class="form-check-label"
                                            for="Employee">{{ __('locale.Employee') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="assignee_type"
                                            id="Team1" value="Team">
                                        <label class="form-check-label"
                                            for="Team">{{ __('locale.Team') }}</label>
                                    </div>
                                </div>
                                <span class="error error-assignee_type"></span>
                            </div>

                            <div class="mb-1 position-relative" id="task_assigned_container1">
                                <label for="task-assigned"
                                    class="form-label d-block">{{ __('locale.Assignee') }}</label>
                                <select class="select2 form-select" id="task-assigned1" name="task-assigned">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($availableUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-task-assigned"></span>
                            </div>
                            {{-- Team --}}
                            <div class="mb-1 d-none" id="task_assigned_team_container1">
                                <label class="form-label ">{{ __('locale.Team') }}</label>
                                <select name="task_assigned_team" id="task-assigned-team1"
                                    class="form-select select2">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-task_assigned_team"></span>
                            </div>
                            <div class="mb-1 position-relative" id="task_category_container1">
                                <label for="task-assigned"
                                    class="form-label d-block">{{ __('locale.Category') }}</label>
                                <select class="select2 form-select" id="task_cat1" name="task_cat">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-task_cat"></span>
                            </div>

                            <div class="mb-1">
                                <label for="task-start-date" class="form-label">{{ __('locale.StartDate') }}</label>
                                <input type="text" class="form-control task-start-date" id="task-start-date1"
                                    name="task-start-date" />
                                <span class="error error-task-start-date"></span>
                            </div>
                            <div class="mb-1">
                                <label for="task-due-date" class="form-label">{{ __('locale.DueDate') }}</label>
                                <input type="text" class="form-control task-due-date" id="task-due-date1"
                                    name="task-due-date" />
                                <span class="error error-task-due-date"></span>
                            </div>
                            <div class="mb-1">
                                <label for="task-tag"
                                    class="form-label d-block">{{ __('task.TaskPriority') }}</label>
                                <select class="select2 form-select task-tag" id="task-tag1" name="task-priority">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    <option value="No Priority">{{ __('locale.No Priority') }}</option>
                                    <option value="Low">{{ __('locale.Low') }}</option>
                                    <option value="Normal">{{ __('locale.Normal') }}</option>
                                    <option value="High">{{ __('locale.High') }}</option>
                                    <option value="Urgent">{{ __('locale.Urgent') }}</option>
                                </select>
                                <span class="error error-task-priority"></span>
                            </div>

                            <textarea name=description class='d-none'></textarea>
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.Description') }}</label>
                                <div id="task-desc1" class="border-bottom-0"
                                    data-placeholder="Write Your Description">
                                </div>
                                <div class="d-flex justify-content-end desc-toolbar1 border-top-0">
                                    <span class="ql-formats me-2">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-align" value="center"></button>
                                        <!-- Add value attribute for alignment -->
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                                <span class="error error-description"></span>
                            </div>


                            {{-- Supporting Documentation --}}
                            <div class="mb-1 supporting_documentation_container1">
                                <label class="text-label">{{ __('locale.SupportingDocumentation') }}</label>
                                :
                                <input type="file" multiple name="supporting_documentation[]"
                                    class="form-control dt-post"
                                    aria-label="{{ __('locale.SupportingDocumentation') }}" />
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit"
                                class="btn btn-primary add-todo-item1 me-1">{{ __('locale.Add') }}</button>
                            <!-- <button type="button" class="btn btn-outline-secondary add-todo-item1"
                                  data-bs-dismiss="modal">
                                  {{ __('locale.Cancel') }}
                              </button> -->

                        </div>
                    </div>
                </form>
            </div>

            <div class="border-bottom mx-1 my-1">
            </div>

        </div>
    </div>
</div>
@endsection

@section('vendor-script')
<!-- vendor js files -->
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
{{--  <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>  --}}
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
<script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
<script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
{{-- <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}

<script>
    const lang = []
    URLs = [],
        createdByMe = {{ $createdByMe ? 1 : 0 }},
        user_id = {{ auth()->id() }},
        customUserName = "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    userName = "{{ auth()->user()->name }}";
    lang['AddNewTask'] = "{{ __('task.AddNewTask') }}";
    lang['Open'] = "{{ __('locale.Open') }}";
    lang['In Progress'] = "{{ __('locale.In Progress') }}";
    lang['Completed'] = "{{ __('locale.Completed') }}";
    lang['Accepted'] = "{{ __('locale.Accepted') }}";
    lang['Closed'] = "{{ __('locale.Closed') }}";
    lang['by'] = "{{ __('locale.by') }}";
    lang['at'] = "{{ __('locale.at') }}";
    lang['Select'] = "{{ __('locale.Select') }}";
    lang['TaskPriority'] = "{{ __('task.TaskPriority') }}";
    lang['TaskPriorities'] = [];
    lang['TaskPriorities']['No Priority'] = "{{ __('locale.No Priority') }}";
    lang['TaskPriorities']['Low'] = "{{ __('locale.Low') }}";
    lang['TaskPriorities']['Normal'] = "{{ __('locale.Normal') }}";
    lang['TaskPriorities']['High'] = "{{ __('locale.High') }}";
    lang['TaskPriorities']['Urgent'] = "{{ __('locale.Urgent') }}";
    lang['Description'] = "{{ __('locale.Description') }}";
    lang['NONE'] = "{{ __('locale.NONE') }}";

    lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
    lang['cancel'] = "{{ __('locale.Cancel') }}";
    lang['success'] = "{{ __('locale.Success') }}";
    lang['error'] = "{{ __('locale.Error') }}";
    lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
    lang['confirmDeleteRecordMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
    lang['user'] = "{{ __('locale.User') }}";
    URLs['create'] = "{{ route('admin.task.ajax.store') }}";
    URLs['delete'] = "{{ route('admin.task.ajax.destroy', ':id') }}";
    URLs['show'] = "{{ route('admin.task.ajax.show', ':id') }}"
    URLs['edit'] = "{{ route('admin.task.ajax.edit', ':id') }}"
    URLs['update'] = "{{ route('admin.task.ajax.update') }}";
    URLs['deleteFile'] = "{{ route('admin.task.ajax.delete_file') }}";
    URLs['changeCompleteStatus'] = "{{ route('admin.task.ajax.change_complete_status') }}";
    URLs['assigneeUpdateStatus'] = "{{ route('admin.task.ajax.assignee_update_status') }}";
    URLs['sendNote'] = "{{ route('admin.task.ajax.send-note') }}";
    URLs['sendNoteFile'] = "{{ route('admin.task.ajax.send-note-file') }}";
</script>
<script src="{{ asset('ajax-files/task/app-todo.js') }}"></script>
<script src="{{ asset('ajax-files/task/app-chat.js') }}"></script>

<script type="text/javascript">
    var routeType = "{{ $routeType }}"; // Assuming $routeType is passed from the controller

    $(document).ready(function() {
        var categoryId = $('.tab.active').data('tab');

        var datatable_url = "{{ route('admin.task.index') }}";

        var table = $('#todo-task-table').DataTable({
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: datatable_url,
                data: function(d) {
                    d.categoryId = categoryId; // Use categoryId as a global variable

                }
            },
            columns: [{
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        var checkbox = row.completed == 1 ?
                            '<input type="checkbox" checked disabled>' :
                            '<input type="checkbox" disabled>';
                        return checkbox + ' ' + data;
                    }
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'createdBy',
                    name: 'createdBy'
                },
                {
                    data: 'assignable.name',
                    name: 'assignable.name',
                    render: function(data, type, row) {
                        if (routeType === 'assigned_to_me') {
                            return '{{ __('locale.you') }}';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        var badgeClass = {
                            "In Progress": "bg-danger",
                            "Open": "bg-success",
                            "Completed": "bg-primary",
                            "Accepted": "bg-info",
                            "Closed": "bg-secondary"
                        };
                        return '<span class="badge rounded-pill ' + (badgeClass[data] ||
                            'bg-warning') + '">' + (data || 'Other Status') + '</span>';
                    }
                },
                {
                    data: 'due_date',
                    name: 'due_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            autoWidth: true,
            scrollX: false,
            error: function(xhr, error, code) {
                console.error('DataTables Error:', error);
            }
        });

        // Handle category tab change
        $('.tab').on('click', function() {
            categoryId = $(this).data('tab'); // Update categoryId

            // Update active tab styling
            $('.tab').removeClass('active');
            $(this).addClass('active');

            // Redraw DataTable with new category
            table.ajax.reload();
        });

        // Filter table based on priority selection
        $('#priority-filter').on('change', function() {
            var priority = $(this).val();
            table.column(1).search(priority).draw();
        });
        $('#category-filter').on('change', function() {
            var category = $(this).val();
            table.column(2).search(category).draw();
        });


        $('#status-filter').on('change', function() {
            var status = $(this).val();
            table.column(5).search(status).draw(); // Assuming "Complete" column index is 5
        });
    });




    // Function to show modal for editing department
    function ShowModalEditDepartment(taskId) {
        // Your implementation to show the modal
        console.log("Editing task with ID:", taskId);
    }
</script>

<script>
    $('.TaskCateogryForm').submit(function(e) {
        e.preventDefault();
        $('.error').empty();
        var url = "{{ route('admin.task.storeCategory') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: $('.TaskCateogryForm').serialize(),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                makeAlert('success', '@lang('locale.CateogryAddedSuccessfully')', 'Success');
                $('#new-Category-task-modal').modal('hide');
                location.reload();

            },

            error: function(response) {
                makeAlert('error', response.responseText, 'Error');

            }
        });

    });

    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }
</script>
<script>
    $(document).on('click', '#NexDocPage', function(event) {


        event.preventDefault();
        var currentPage = $('#currentPage').val();
        var lastPage = $('#lastPage').val();
        var page = parseInt(currentPage) + 1;
        if (page <= lastPage) {
            $('#PrevDocPage').attr('disabled', false);
            $.ajax({
                url: '{{ url('admin/task/next-doc-page') }}',
                method: "get",
                data: {
                    page: page
                },
                success: function(data) {
                    if (data[2] != 0) {
                        $('.CategoryList').html(data[0]);
                        $('#lastPage').val(data[1]);
                        $('#currentPage').val(page);
                    } else {
                        $('#NexDocPage').attr('disabled', true);
                    }
                },
            })
        } else {
            $('#NexDocPage').attr('disabled', true);
        }
    });

    $(document).on('click', '#PrevDocPage', function(event) {
        event.preventDefault();
        var currentPage = $('#currentPage').val();
        var lastPage = $('#lastPage').val();
        var page = parseInt(currentPage) > 1 ? parseInt(currentPage) - 1 : 1;

        if (currentPage > 1) {
            $('#NexDocPage').attr('disabled', false);
            $.ajax({
                url: '{{ url('admin/task/prev-doc-page') }}',
                method: "get",
                data: {
                    page: page
                },
                success: function(data) {
                    $('.CategoryList').html(data[0]);
                    $('#lastPage').val(data[1]);
                    $('#currentPage').val(page);
                },
            })
        } else {
            $('#PrevDocPage').attr('disabled', true);
        }
    });





    $('#todo-task-table').on('click', '#click_copy', function() {
        var taskId = $(this).data('id');
        // Send an AJAX request to copy the task
        $.ajax({
            url: "{{ route('admin.task.CopyTask', ['id' => ':taskId']) }}".replace(':taskId', taskId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Check if the response status is true
                // Get the ID of the copied task
                var copiedTaskId = response.copiedTaskId;
                // Send the copied task ID to the specified route
                $.ajax({
                    url: "{{ route('admin.task.ajax.edit', ['id' => ':taskId']) }}"
                        .replace(':taskId', copiedTaskId),
                    type: 'GET',
                    success: function(response) {
                        // Call the function to handle the modal with the copied task data
                        ShowModalCopyTask(response.data);

                    },
                    error: function(xhr, status, error) {
                        // Handle the error response if needed
                        console.error(xhr.responseText);
                    }
                });
                // Display success message
            },
            error: function(xhr, status, error) {
                // Optionally, you can handle the error response
                console.error(xhr.responseText);
            }
        });
    });

    function ShowModalCopyTask(taskData) {
        $('#new-copy-modal').modal('show');
        $('.chat-app-window1').addClass('d-none');
        $('#creator-task-status-container1').addClass('d-none');
        $('.add-todo-item').removeClass('d-none');

        $('#title1').val(taskData.title);
        $('#task-assigned1').val(taskData.assignable_id).trigger('change');
        if (taskData.assignable_type === 'Team') {
            $('#Team1').prop('checked', true).trigger('change');
            $('#task_assigned_container1').addClass('d-none');
            $('#task_assigned_team_container1').removeClass('d-none');
            $('#task-assigned-team1').val(taskData.assignable_id).trigger('change');
        } else {
            $('#Employee1').prop('checked', true).trigger('change');
            $('#task_assigned_team_container1').addClass('d-none');
            $('#task_assigned_container1').removeClass('d-none');
            $('#task-assigned1').val(taskData.assignable_id).trigger('change');
        }

        $('#Team1').change(function() {
            if ($(this).is(':checked')) {
                $('#task_assigned_container1').addClass('d-none');
                $('#task_assigned_team_container1').removeClass('d-none');
            }
        });

        $('#Employee1').change(function() {
            if ($(this).is(':checked')) {
                $('#task_assigned_team_container1').addClass('d-none');
                $('#task_assigned_container1').removeClass('d-none');
            }
        });

        $('#task_cat1').val(taskData.category_task.id).trigger('change');
        $('#task-start-date1').val(taskData.start_date).trigger('change');
        $('#task-due-date1').val(taskData.due_date).trigger('change');
        $('#task-tag1').val(taskData.priority).trigger('change');

        var quill_editor = new Quill('#task-desc1', {
            modules: {
                formula: true,
                syntax: true,
                toolbar: {
                    container: '.desc-toolbar1'
                }
            },
            placeholder: lang['Description'],
            theme: 'snow'
        });

        quill_editor.root.innerHTML = taskData.description;
        var supportingDocumentationContainer = $('.supporting_documentation_container1');
        supportingDocumentationContainer.empty(); // Clear previous files

        // Create the input element for uploading photos
        var fileInput = $('<input>').attr({
            type: 'file',
            multiple: true,
            name: 'supporting_documentation[]',
            id: 'task_photo',
            class: 'form-control dt-post',
            'aria-label': '{{ __('locale.SupportingDocumentation') }}'
        });

        // Create the label element
        var labelElement = $('<label>').attr({
            id: 'task_photo_label', // Changed the ID to task_photo_label to avoid duplicate IDs
            class: 'text-label',
            'aria-label': '{{ __('locale.SupportingDocumentation') }}'
        }).text(
            '{{ __('locale.SupportingDocumentation:') }}'
        ); // Set the label text, adjust according to your localization setup

        // Append the label element and file input element to the container
        supportingDocumentationContainer.append(labelElement);
        supportingDocumentationContainer.append(fileInput);

        // Add event listener to handle file selection
        fileInput.on('change', function() {
            var files = $(this).prop('files');
            if (files.length > 0) {
                // Handle file selection (if needed)
                // You can process the selected files here, e.g., display file names, etc.
            }
        });

        // Loop through task files and display them
        taskData.files.forEach(function(file) {
            var deleteButton = '';
            deleteButton = `<span class="text-danger delete_supporting_documentation cursor-pointer mx-1" data-id="${file.id}" data-task-id="${taskData.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </span>`;
            var fileElement = `
        <div class="mitigation-files1" style="margin-top: 5px">
            <span class="badge bg-secondary supporting_documentation cursor-pointer" data-id="${file.id}" data-task-id="${taskData.id}">${file.display_name}</span>
            ${deleteButton}
        </div>`;
            supportingDocumentationContainer.append(fileElement);
        });

    }

    $(document).on('submit', '#form-modal-todo1', function(e) {
        e.preventDefault();

        // Retrieve the Quill editor instance
        var quill_editor = new Quill('#task-desc1');

        // Get the text content from Quill
        var description = quill_editor.root.innerHTML;

        var formData = new FormData(this);
        formData.append('description', description);

        $.ajax({
            url: "{{ route('admin.task.ajax.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                makeAlert('success', 'Task submitted successfully', 'Success');
                $('#new-copy-modal1').modal('hide');
                location.reload();
            },
            error: function(response) {
                makeAlert('error', response.responseText, 'Error');
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to fill the card with category information
        function fillCard(categoryId, categoryName) {
            var cardNameElement = document.querySelector("#itemCard .card-desc.DocName");
            var editButton = document.querySelector("#itemCard .updateItem");
            var deleteButton = document.querySelector("#itemCard .deleteItem");
            var categoryIdInput = document.getElementById("category_id");
            cardNameElement.textContent = categoryName;
            editButton.dataset.itemid = categoryId;
            deleteButton.dataset.itemid = categoryId;
            categoryIdInput.value = categoryId;



        }

        // Add event listener to the delete button to open SweetAlert confirmation dialog
        // Delete Action
        $(document).on('click', '.deleteItem', function() {
            var deleteButton = $(this);
            var activeTab = document.querySelector('.tab.active'); // Get active category on page load
            var categoryId = activeTab.dataset.tab;
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this category!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform delete action for the category
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.task.deleteCategory') }}",
                        data: {
                            categoryId: categoryId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "The category has been deleted.",
                                    icon: "success",
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete the category.",
                                    icon: "error",
                                    timer: 2000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the category.",
                                icon: "error",
                                timer: 2000
                            });
                        }
                    });
                }
            });
        });
        // Function to attach event listeners to category buttons
        function attachEventListeners() {
            var activeTab = document.querySelector('.tab.active'); // Get active category on page load

            if (activeTab) {
                var categoryId = activeTab.dataset.tab;
                var categoryName = activeTab.textContent.trim();
                fillCard(categoryId, categoryName); // Set initial category
            }

            var categoryButtons = document.querySelectorAll(".sideNavBtn");
            categoryButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var itemId = button.id.replace("item", "");
                    var itemName = button.textContent;
                    fillCard(itemId, itemName);
                });
            });

            $('#new-task-modal').on('show.bs.modal', function(e) {
                var activeTab = document.querySelector('.tab.active');
                if (activeTab) {
                    var categoryId = activeTab.dataset.tab;
                    $('#task_cat').val(categoryId).trigger(
                    'change'); // Set value and trigger change for Select2
                }
            });

            $('#new-copy-modal').on('show.bs.modal', function(e) {
                var activeTab = document.querySelector('.tab.active');
                if (activeTab) {
                    var categoryId = activeTab.dataset.tab;
                    $('#task_cat1').val(categoryId).trigger(
                    'change'); // Set value and trigger change for Select2
                }
            });


        }


        // Call the function to attach event listeners to category buttons
        attachEventListeners();


        // Add event listener to the edit button to open the modal
        $('.updateItem').click(function() {
            var categoryName = $('.card-desc.DocName').text().trim();
            $('#name').val(categoryName);
            $('#category_id').val($(this).data('itemid'));
            $('#name').focus();
        });

    });
    $('#new-Category-task-modal').on('hidden.bs.modal', function(e) {
        $('#name').val('');
        $('#category_id').val('');

    });
    $('#new-Category-task-modal').on('show.bs.modal', function(e) {
        $('#name').val('');
        $('#category_id').val('');

    });


    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');
        const carousel = document.querySelector('.carousel-container');
        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');

        let position = 0;


        function updateCarouselWidth() {
            const containerWidth = carousel.parentElement.offsetWidth;
            const contentWidth = carousel.scrollWidth;
            return {
                containerWidth,
                contentWidth
            };
        }

        function moveCarousel(direction) {
            const {
                containerWidth,
                contentWidth
            } = updateCarouselWidth();
            const step = 150;

            if (direction === 'next') {
                if (position > -(contentWidth - containerWidth)) {
                    position -= step;
                    position = Math.max(position, -(contentWidth - containerWidth));
                }
            } else if (direction === 'prev') {
                if (position < 0) {
                    position += step;
                    position = Math.min(position, 0);
                }
            }

            carousel.style.transform = `translateX(${position}px)`;
        }

        nextBtn.addEventListener('click', () => moveCarousel('next'));
        prevBtn.addEventListener('click', () => moveCarousel('prev'));


        let touchStartX = 0,
            touchEndX = 0;

        carousel.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        });

        carousel.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            if (touchEndX < touchStartX) moveCarousel('next');
            else if (touchEndX > touchStartX) moveCarousel('prev');
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll(".tab");
        const prevButton = document.querySelector(".carousel-button.prev");
        const nextButton = document.querySelector(".carousel-button.next");

        let currentIndex = 0;

        function updateButtons() {
            if (currentIndex === 0) {
                prevButton.style.color = "#b4a7be";
            } else {
                prevButton.style.color = "#44235c";
            }

            if (currentIndex === tabs.length - 1) {
                nextButton.style.color = "#b4a7be";
            } else {
                nextButton.style.color = "#44235c";
            }
        }

        nextButton.addEventListener("click", function() {
            if (currentIndex < tabs.length - 1) {
                currentIndex++;
                updateButtons();
            }
        });

        prevButton.addEventListener("click", function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateButtons();
            }
        });

        updateButtons();
    });
    // document.addEventListener("DOMContentLoaded", function() {
    //     const tabs = document.querySelectorAll(".tab");
    //     const contents = document.querySelectorAll(".tab-content");

    //     tabs.forEach(tab => {
    //         tab.addEventListener("click", function() {

    //             tabs.forEach(t => t.classList.remove("active"));
    //             this.classList.add("active");

    //             contents.forEach(content => content.classList.remove("active"));

    //             const targetContent = document.querySelector(`#${this.dataset.tab}`);
    //             if (targetContent) {
    //                 targetContent.classList.add("active");
    //             }
    //         });
    //     });
    // });

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
</script>

@endsection
