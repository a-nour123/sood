@extends('admin/layouts/contentLayoutMaster')

@section('title', __('LMS.Courses'))

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

    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>


@endsection

@section('page-style')
    {{--
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/course_addon.css') }}">
    <style>
        .modal-body {
            background-color: #f8f9fa;
        }

        .accordion-button {
            background-color: #e9ecef;
            color: #000;
        }

        .accordion-body {
            padding: 10px;
        }

        .img-fluid {
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .btn-custom:hover {
            color: #fffff !important;
        }

        .dropdown-toggle.hide-arrow {
            color: #fff !important;
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
                                @if (auth()->user()->hasPermission('courses.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add_course_modal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.lms.courseNotificationsSettings') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                    {{-- <a href="{{ route('admin.phishing.archivedDomains') }}" class=" btn btn-primary"
                                        target="_self">
                                        <i class="fa  fa-trash"></i>
                                    </a> --}}
                                @endif
                                {{-- <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>
                                --}}

                                {{-- <x-export-import name=" {{ __('locale.Asset') }}"
                                    createPermissionKey='asset.create' exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' /> --}}

                                {{-- <a class="btn btn-primary" href="http://"> <i
                                        class="fa-solid fa-file-invoice"></i></a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>
</div>


<div>
    <section class="">
        <div class="row">
            <div class="col-md-12">
                <div>

                    {{-- <div class="box-header with-border pb0 my-5">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <form class="navbar-form pull-right miusttop5" id="search_area" role="search"
                                    action="{{ route('admin.lms.courses.index') }}" method="GET">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" value="{{ request('search_course', '') }}"
                                            name="search_course" id="search_course" class="form-control search-form"
                                            placeholder="{{ __('lms.search_by_course_name') }}">
                                        <span class="input-group-btn">
                                            <button type="submit" name="search" id="search-btn"
                                                class="btn btn-flat topsidesearchbtn"><i
                                                    class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}


                    <div id="course_card_tab" class="tabcontent">
                        @if (isset($courses))
                            <div class="nav-tabs-custom border0 navnoshadow">
                                <div class="tab-content">
                                    <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                        <table
                                            class="table table-striped table-bordered table-hover course-list course-table nth-til8"
                                            data-export-title="{{ __('course_list') }}">
                                            <thead>
                                                <tr>
                                                    <th class="white-space-nowrap">{{ __('title') }}</th>
                                                    <th class="white-space-nowrap">{{ __('class') }}</th>
                                                    <th class="white-space-nowrap">{{ __('section') }}</th>
                                                    <th class="white-space-nowrap">{{ __('lesson') }}</th>
                                                    <th class="white-space-nowrap">{{ __('quiz') }}</th>
                                                    <th class="white-space-nowrap">{{ __('total_hour_count') }}</th>
                                                    <th class="white-space-nowrap">{{ __('last_updated') }}</th>
                                                    <th class="text-right noExport white-space-nowrap">
                                                        {{ __('action') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>


                    <div id="course_detail_tab" class="tabcontent">
                        <section class="">
                            @if (!empty($courses))
                                <div class="row flex-row">
                                    @foreach ($courses as $new_courselist_value)
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="coursebox">
                                                <a href="#" class="course_detail_id text-dark"
                                                    data-id="{{ $new_courselist_value['id'] }}"
                                                    data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                                    data-target="#course_detail_modal">
                                                    <div class="coursebox-img">
                                                        <img src="{{ asset('storage/' . $new_courselist_value['image']) }}"
                                                            alt="">
                                                        <div class="author-block author-wrap">
                                                            <img class="img-circle"
                                                                src="{{ asset('storage/' . $new_courselist_value['image']) }}"
                                                                alt="User">
                                                            <span
                                                                class="description"><span>{{ __('lms.last_updated') }}</span>
                                                                {{ \Carbon\Carbon::parse($new_courselist_value['updated_at'])->format('Y-m-d') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="coursebox-body">
                                                        <h4>{{ $new_courselist_value['title'] }}:</h4>
                                                        <div class="course-caption">
                                                            {{ $new_courselist_value['description'] }}
                                                        </div>
                                                        <div class="classstats">
                                                            <div><i class="fa fa-list-alt"></i>{{ __('lms.Levels') }}
                                                                -
                                                                {{ $new_courselist_value['levels_count'] }}
                                                            </div>
                                                            <div class="webkit-line">
                                                                <i
                                                                    class="fa fa-play-circle"></i>{{ __('lms.Training modules') . ' ' . $new_courselist_value['training_modules_count'] }}
                                                            </div>
                                                            <div><i
                                                                    class="fa fa-list-alt"></i>{{ __('lms.Questions') }}
                                                                -
                                                                {{ \App\Helpers\helper::countOfquestions($new_courselist_value->id) }}
                                                            </div>
                                                            <div class="webkit-line">
                                                                <i
                                                                    class="fa fa-play-circle"></i>{{ __('lms.Statements') . ' ' . \App\Helpers\helper::countOfStatements($new_courselist_value->id) }}
                                                            </div>
                                                        </div>

                                                        <div class="classstats">
                                                            <div class="webkit-line">
                                                                @if (!empty($new_courselist_value['total_hour_count']) && $new_courselist_value['total_hour_count'] != '00:00:00')
                                                                    <i
                                                                        class="fa fa-clock-o"></i>{{ $new_courselist_value['total_hour_count'] . ' ' . __('hrs') }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>

                                                <div class="coursebtn ">
                                                    <a href="#"
                                                        class="btn course_detail_id btn-custom w-100 text-white"
                                                        style="background: #44225c !important ;"
                                                        data-id="{{ $new_courselist_value['id'] }}"
                                                        data-backdrop="static" data-keyboard="false"
                                                        data-toggle="modal" data-target="#course_detail_modal">
                                                        {{ __('lms.Manage Course') }}
                                                    </a>
                                                    {{-- <a href="#"
                                                        class="btn course_preview_id pull-right btn-custom w-100 text-white"
                                                        style="background: #44225c !important ;"
                                                        data-id="{{ $new_courselist_value['id'] }}" data-backdrop="static"
                                                        data-keyboard="false" data-toggle="modal"
                                                        data-target="#course_preview_modal">{{ __('course_preview') }}</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="dataTables_empty">No data available in table <br><br></span>
                                    <img src="{{ asset('backend/images/addnewitem.svg') }}" alt=""
                                        width="150"><br><br>
                                    <span class="text-success bolds"><i class="fa fa-arrow-left"></i>
                                        {{ __('no_record_found_as_per_your_search_criteria') }}</span>
                                </div>
                            @endif

                            <div class="row text-center">
                                <div class="course-pagination">{{ $courses->links() }}</div>
                            </div>
                        </section>
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="course_detail_modal" tabindex="-1" aria-labelledby="courseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseModalLabel"> {{ __('lms.Levels') }} &
                    {{ __('lms.Training_modules') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="box-header ptbnull d-flex justify-content-between align-items-center my-4">
                                <h3 class="box-title titlefix">{{ __('lms.Levels') }} &
                                    {{ __('lms.Training_modules') }}
                                </h3>
                                <div class="box-tools">
                                    @if (auth()->user()->hasPermission('levels.create'))
                                        <button type="button" class="btn btn-sm btn-primary add_section_id ms-2"
                                            data-bs-toggle="modal" data-id=""
                                            data-bs-target="#add_section_modal">
                                            <i class="fa fa-plus"></i> {{ __('lms.Add Level') }}
                                        </button>
                                    @endif
                                </div>
                            </div>


                            <div class="scroll-area">
                                <div class="box-body">
                                    <div id="modal">
                                    </div>
                                    <div id="accordion" class="panel-group">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 col-md-4 col-sm-12" id="details-of-course">
                            <div class="box-header ptbnull">
                                <h3 class="box-title">{{ __('lms.Course Details') }}</h3>
                                @if (auth()->user()->hasPermission('courses.delete'))

                                    <button class="btn btn-xs pull-right delete_course_id" title="Delete Course"
                                        data-id="" data-placement="left" data-toggle="modal"
                                        data-original-title="{{ __('delete_course') }}"><i
                                            class="fa fa-remove"></i></a>
                                @endif
                            </div>

                            <div class="scroll-area">
                                <div class="box-body">
                                    <form id="edit_course_form_ID" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="" id="editable-course-id" />
                                        <div class="tab">
                                            <div class="row g-3">

                                                <div class="col-sm-12">
                                                    <img src="" id="course-image"
                                                        style="width: 100%; height: 200px;">
                                                </div>

                                                <div class="col-sm-12">
                                                    <label class="form-label"
                                                        for="title">{{ __('lms.Course Title') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" name="title" id="course-title"
                                                        type="text" placeholder="Enter Course Title"
                                                        required="required">
                                                    <span class="error error-title text-danger"></span>
                                                </div>

                                                <div class="col-sm-12">
                                                    <label class="form-label"
                                                        for="student-description-wizard">{{ __('lms.Course Description') }}<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" cols="30" rows="5" name="description" id="course-description"
                                                        required="required" placeholder="Enter Description"></textarea>
                                                    <span class="error error-description text-danger"></span>
                                                </div>

                                                <div class="col-sm-12">
                                                    <label class="col-sm-12 form-label" for="image-wizard">
                                                        {{ __('lms.Course Image') }} <span
                                                            class="txt-danger">*</span></label>
                                                    <input class="form-control" name="image" id="course-image"
                                                        type="file" placeholder="Enter image">
                                                    <span class="error error-image text-danger"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-end pt-3">
                                                @if (auth()->user()->hasPermission('courses.update'))

                                                    <button class="btn btn-primary" id="edit_course_btn"
                                                        type="submit">{{ __('lms.Course Update') }}</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('lms.Close') }}</button>
            </div>
        </div>
    </div>
</div>


{{-- modal number 1 --}}
<div class="modal fade" id="add_course_modal" data-bs-focus="false" aria-labelledby="wizardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">{{ __('lms.Add New Course') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.lms.courses.store') }}" id="add_course_form_ID" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tab">
                        <div class="row g-3">

                            <div class="col-sm-12">
                                <label class="form-label" for="title">{{ __('lms.Course Title') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="title" id="title" type="text"
                                    placeholder="{{ __('lms.Course Title') }}" required="required">
                                <span class="error error-title text-danger"></span>
                            </div>

                            <div class="col-sm-12">
                                <label class="form-label"
                                    for="student-description-wizard">{{ __('lms.Course Description') }}<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" cols="30" rows="5" name="description" id="student-description-wizard"
                                    required="required" placeholder="{{ __('lms.Course Description') }}"></textarea>
                                <span class="error error-description text-danger"></span>
                            </div>

                            <div class="col-sm-12">
                                <label class="col-sm-12 form-label"
                                    for="image-wizard">{{ __('lms.Course Image') }}<span
                                        class="txt-danger">*</span></label>
                                <input class="form-control" name="image" id="student-image-wizard" type="file"
                                    placeholder="Enter image">
                                <span class="error error-image text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="text-end pt-3">
                            @if (auth()->user()->hasPermission('courses.create'))

                                <button class="btn btn-primary" id="add_course_btn"
                                    type="submit">{{ __('lms.Save') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_course_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg course_modal" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header p0">
                <button type="button" class="close button" data-dismiss="modal">&times;</button>
                <div class="box-header ptbnull noborder">
                    <h4 class="box-title titlefix">{{ __('edit_course') }}</h4>
                    <div class="box-tools pull-right">
                        <!-- You can add any additional buttons or tools here -->
                    </div>
                </div>
            </div>
            <div class="modal-body pb0">
                <div id="edit_course"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_section_modal" style="z-index: 9999999" aria-labelledby="wizardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">{{ __('lms.Add New Level') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-course-level" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" id="level_course_id">
                    <div class="tab">
                        <div class="row g-3">

                            <div class="col-sm-12">
                                <label class="form-label" for="title">{{ __('lms.Level Title') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="title" id="title" type="text"
                                    placeholder="{{ __('lms.Level Title') }}" required="required">
                                <span class="error error-title text-danger"></span>
                            </div>

                            <div class="col-sm-12">
                                <label class="form-label" for="order">{{ __('lms.Level Order') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="order" id="order" type="number"
                                    placeholder="{{ __('lms.Level Order') }}" required="required">
                                <span class="error error-order text-danger"></span>
                            </div>

                        </div>
                    </div>

                    <div>
                        <div class="text-end pt-3">
                            @if (auth()->user()->hasPermission('levels.create'))
                                <button class="btn btn-primary" id="add_level_btn"
                                    type="submit">{{ __('lms.Save') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_section_modal" style="z-index: 9999999" aria-labelledby="wizardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">{{ __('lms.Edit Level') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-course-level" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="level_id" id="level_id">
                    <div class="tab">
                        <div class="row g-3">

                            <div class="col-sm-12">
                                <label class="form-label" for="title">{{ __('lms.Level Title') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="title" id="course-level-title" type="text"
                                    placeholder="{{ __('lms.Level Title') }}" required="required">
                                <span class="error error-title text-danger"></span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label" for="order">{{ __('lms.Level Order') }}<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" name="order" id="level_order" type="number"
                                placeholder="{{ __('lms.Level Order') }}" required="required">
                            <span class="error error-order text-danger"></span>
                        </div>

                    </div>

                    <div>
                        <div class="text-end pt-3">
                            @if (auth()->user()->hasPermission('levels.update'))

                                <button class="btn btn-primary" id="edit_level_btn"
                                    type="submit">{{ __('lms.Update') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_training_module_modal" aria-labelledby="wizardModalLabel" aria-hidden="true">
    {{-- <div class="modal-dialog modal-fullscreen"> --}}
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">{{ __('lms.Add Training Module') }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-training-module" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="train_level_id" id="train_level_id">
                    <div class="tab">
                        <div class="row g-3">

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Training Name') }} <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="name" id="title" type="text"
                                    placeholder="{{ __('lms.Training Name') }}" required="required">
                                <span class="error error-name text-danger"></span>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Passing Score') }} %<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="passing_score" id="title" type="number"
                                    placeholder="{{ __('lms.Passing Score') }}" value="70" required="required">
                                <span class="error error-passing_score text-danger"></span>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Module Order') }}</label>
                                <input type="number" required class="form-control" name="module_order"
                                    id="module_order" />
                                <span class="error error-module_order text-danger"></span>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Training Type') }}</label>
                                <select class="form-control" name="training_type" id="training_type" required>
                                    <option value="">Select Training Type</option>
                                    <option value="campaign">Campaign</option>
                                    <option value="public">Public</option>
                                </select>
                                <span class="error error-training_type text-danger"></span>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="survey_id" class="form-label">susrvey</label>
                                    <select name="survey_id" id="survey_id"
                                        class="form-select @error('survey_id') is-invalid @enderror">
                                        <option value="" >{{ __('physicalCourses.select_survey') }}</option>
                                        @foreach ($surveys as $survey)
                                            <option value="{{ $survey->id }}">
                                                {{ $survey->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('survey_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback"></div>
                                    @enderror
                                    <div class="form-text">{{ __('physicalCourses.select_course_survey') }}</div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.count of entering exam') }}</label>
                                <input class="form-control" name="count_of_entering_exam" id="count_of_entering_exam"
                                    type="number" value="1" required max="999" placeholder="number between 1 and 999"/>
                                <span class="error error-count_of_entering_exam text-danger"></span>
                            </div>

                            <div class="col-sm-12">
                                <label class="form-label" for="title">{{ __('lms.Cover Image') }}</label>
                                <input class="form-control" name="cover_image" id="cover_image" type="file" />
                                <span class="error error-cover_image text-danger"></span>
                            </div>

                            {{-- <div class="col-sm-6">
                                    <label class="form-label" for="title">{{ __('lms.Cover Image URL') }}</label>
                                    <input class="form-control" name="cover_image_url" id="cover_image_url"
                                        type="text" />
                                    <span class="error error-cover_image_url text-danger"></span>
                                </div> --}}

                            <div class="col-sm-6">
                                <label class="form-label" for="title"> {{ __('lms.Completion Time') }} (Minutes)
                                </label>
                                <input class="form-control" name="completion_time" id="completion_time"
                                    type="number" value="15" required />
                                <span class="error error-completion_time text-danger"></span>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="title"> {{ __('lms.Compliance Mapping') }}</label>
                                <select class="form-control" name="compliance_mapping[]" id="compliance_mapping"
                                     multiple>
                                    @foreach ($compliances as $compliance)
                                        <option value="{{ $compliance->id }}">{{ $compliance->short_name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-compliance_mapping text-danger"></span>
                            </div>


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="d-flex justify-content-center">
                                        <h4 class="text-secondary"> {{ __('lms.Training Pages') }} </h3>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    {{-- <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-warning me-2" value="question"
                                                id="pre_append_question"> {{ __('lms.Add Question') }} ↑</button>
                                            <button type="button" class="btn btn-info" value="statement"
                                                id="pre_append_statement"> {{ __('lms.Add Statement') }} ↑</button>
                                        </div> --}}
                                </div>
                                <hr class="my-4">
                            </div>


                            <div class="row" id="main-statement-or-question-operation">
                                <div class="col-sm-4">
                                    <div class="d-flex justify-content-center">
                                        <h4 class="text-secondary main-head-content"><span> Page 1</span> -
                                            {{ __('lms.Statement') }}
                                        </h4>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="d-flex justify-content-end">
                                        <button type="button"
                                            class="btn btn-warning me-2 after_append_question">{{ __('lms.Add Question') }}</button>
                                        <button type="button"
                                            class="btn btn-info me-2 after_append_statement">{{ __('lms.Add Statement') }}</button>
                                        <button type="button"
                                            class="btn btn-danger remove_statement">{{ __('lms.Remove Statement') }}</button>
                                    </div>
                                </div>

                                <div class="col-sm-12 row main-statement-content">

                                    <input type="hidden" class="page_number" name="items[0][page_number]"
                                        value="1">
                                    <input type="hidden" class="item_type" name="items[0][type]" value="statement">

                                    {{-- english div --}}
                                    <div class="row col-sm-6">
                                        <div class="form-group mb-3">
                                            <label
                                                for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                                            <input type="text" class="form-control statement_title"
                                                name="items[0][statement_title]"
                                                placeholder="{{ __('lms.Statement Title English') }}"
                                                id="item-0">
                                            <span
                                                class="emptyCommingError trainError-items-0-statement_title text-danger"></span>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label
                                                for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                                            {{-- <input type="text" required class="form-control statement_content"
                                                    name="items[0][statement_content]"
                                                    placeholder="{{ __('lms.Statement Content English') }}"> --}}

                                            <textarea class="form-control statement_content" id="statement_content_0" name="items[0][statement_content]"
                                                placeholder="{{ __('lms.Statement Content English') }}"></textarea>

                                            <span
                                                class="emptyCommingError trainError-items-0-statement_content text-danger"></span>

                                        </div>

                                    </div>

                                    {{-- arabic div --}}
                                    <div class="row col-sm-6">
                                        <div class="form-group mb-3">
                                            <label
                                                for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                                            <input type="text" class="form-control statement_title_ar"
                                                name="items[0][statement_title_ar]"
                                                placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                            <span
                                                class="emptyCommingError trainError-items-0-statement_title_ar text-danger"></span>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label
                                                for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                                            {{-- <input type="text" required
                                                    class="form-control statement_content_ar"
                                                    name="items[0][statement_content_ar]"
                                                    placeholder="{{ __('lms.Statement Content Arabic') }}"> --}}
                                            <textarea class="form-control statement_content_ar" id="statement_content_ar_0" name="items[0][statement_content_ar]"
                                                placeholder="{{ __('lms.Statement Content Arabic') }}"></textarea>

                                            <span
                                                class="emptyCommingError trainError-items-0-statement_content_ar text-danger"></span>

                                        </div>

                                    </div>


                                    {{-- english & arabic div --}}
                                    <div class="form-group mb-3">
                                        <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                                        <select class="form-control additional_content"
                                            name="items[0][additional_content]">
                                            <option value="no">{{ __('lms.No Additional Content') }}</option>
                                            <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                                            <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                                        </select>
                                        <span
                                            class="emptyCommingError trainError-items-0-additional_content text-danger"></span>

                                    </div>

                                    {{-- english div --}}
                                    <div class="row col-sm-6">
                                        <div class="col-sm-12 form-group mb-3 video-embedded-en"
                                            style="display: none">
                                            <label
                                                for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                                            <input type="file" accept="video/*" class="form-control video_url_en"
                                                name="items[0][video_url_en]"
                                                placeholder="{{ __('lms.Embedded Video URL English') }}">


                                            {{-- upload english video separatly --}}
                                            <progress class="video_progress" value="0" max="100"
                                                style="width:100%; display: none;"></progress>
                                            <span class="text-success video_en_upload_status"></span>
                                            <input type="hidden" class="video_url_en_path"
                                                name="items[0][video_url_en_path]">

                                            <span
                                                class="emptyCommingError trainError-items-0-video_url_en text-danger"></span>

                                        </div>

                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                            style="display: none">
                                            <div class="col-sm-12">
                                                <label
                                                    for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                                <input type="file" accept="image/*" class="form-control image"
                                                    name="items[0][image]"
                                                    placeholder="{{ __('lms.Choose Statement Image English') }}">
                                                <span
                                                    class="emptyCommingError trainError-items-0-image text-danger"></span>

                                            </div>
                                        </div>

                                    </div>

                                    {{-- arabic div --}}
                                    <div class="row col-sm-6">
                                        <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
                                            <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                            <input type="file" accept="video/*" class="form-control video_url"
                                                name="items[0][video_url]"
                                                placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                            {{-- upload arabic video separatly --}}
                                            <progress class="video_progress" value="0" max="100"
                                                style="width:100%; display: none;"></progress>
                                            <span class="text-success video_upload_status"></span>
                                            <input type="hidden" class="video_url_ar_path"
                                                name="items[0][video_url_ar_path]">

                                            <span
                                                class="emptyCommingError trainError-items-0-video_url text-danger"></span>

                                        </div>

                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                            style="display: none">
                                            <div class="col-sm-12">
                                                <label
                                                    for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                                <input type="file" accept="image/*" class="form-control image"
                                                    name="items[0][image_ar]"
                                                    placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                <span
                                                    class="emptyCommingError trainError-items-0-image_ar text-danger"></span>

                                            </div>
                                        </div>


                                    </div>







                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <span>{{ __('lms.Total Questions') }}: <strong
                                                id="total_questions">0</strong></span>
                                        <span class="ms-3">{{ __('lms.Total Statements') }}: <strong
                                                id="total_statements">1</strong></span>
                                        <span class="ms-3">{{ __('lms.Total Pages') }}: <strong
                                                id="total_pages">1</strong></span>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div>
                        <div class="text-end pt-3">
                            {{-- <button class="btn btn-primary" id="add_level_btn" type="submit">Save</button> --}}
                            @if (auth()->user()->hasPermission('trainingModules.create'))

                                <button class="btn btn-primary" id="add_training_btn" type="submit">
                                    <span id="add_training_btn_text">{{ __('lms.Save') }}</span>
                                    <span id="add_training_btn_loader" class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            @endif

                            <button class="btn btn-danger" id="cancel_level_btn" data-bs-dismiss="modal"
                                aria-label="Close">{{ __('lms.Cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="success_add_training" style="z-index: 99999999;top: 100px;"
    aria-labelledby="wizardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">Uploading In Adding... Please wait.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('admin/images/loaderImage.gif') }}" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="success_edit_training" style="z-index: 99999999;top: 100px;"
    aria-labelledby="wizardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">Uploading... Please wait.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('admin/images/loaderImage.gif') }}" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>






{{-- edit trainig --}}

<div class="modal fade" id="edit_training_module_modal" aria-labelledby="wizardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wizardModalLabel">{{ __('lms.Edit Training Module') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-training-module" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="edit_train_level_id" id="edit_train_level_id">
                    <input type="hidden" name="edit_level_id" id="edit_level_id">
                    <div class="tab">
                        <div class="row g-3">

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Training Name') }} <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="name" id="title" type="text"
                                    placeholder="Enter name" required="required">
                                <span class="error error-name text-danger"></span>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Passing Score') }} %<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="passing_score" id="passing_score" type="number"
                                    placeholder="{{ __('lms.Save') }}" value="70" required="required">
                                <span class="error error-passing_score text-danger"></span>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Module Order') }}</label>
                                <input type="number" class="form-control" name="module_order" id="module_order" />
                                <span class="error error-module_order text-danger"></span>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="title">{{ __('lms.Cover Image') }}</label>
                                <input class="form-control" name="cover_image" id="cover_image" type="file" />
                                <span class="error error-cover_image text-danger"></span>
                            </div>


                            {{-- <div class="col-sm-6">
                                    <label class="form-label" for="title">Cover Image Url</label>
                                    <input class="form-control" name="cover_image_url" id="cover_image_url"
                                        type="text" />
                                    <span class="error error-cover_image_url text-danger"></span>
                                </div> --}}

                            <div class="col-sm-6">
                                <label class="form-label" for="title">{{ __('lms.Completion Time') }}
                                    (Minutes)</label>
                                <input class="form-control" name="completion_time" id="completion_time"
                                    type="number" value="15" />
                                <span class="error error-completion_time text-danger"></span>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.Training Type') }}</label>
                                <select class="form-control" name="training_type" id="training_type" required>
                                    <option value="">Select Training Type</option>
                                    <option value="campaign">Campaign</option>
                                    <option value="public">Public</option>
                                </select>
                                <span class="error error-training_type text-danger"></span>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="survey_id" class="form-label">susrvey</label>
                                    <select name="survey_id" id="survey_id"
                                        class="form-select @error('survey_id') is-invalid @enderror">
                                        <option value="" >{{ __('physicalCourses.select_survey') }}</option>
                                        @foreach ($surveys as $survey)
                                            <option value="{{ $survey->id }}">
                                                {{ $survey->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('survey_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback"></div>
                                    @enderror
                                    <div class="form-text">{{ __('physicalCourses.select_course_survey') }}</div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="title">{{ __('lms.count of entering exam') }}</label>
                                <input class="form-control" name="count_of_entering_exam" id="count_of_entering_exam"
                                    type="number" value="1" required placeholder="number between 1 and 999" max="999" />
                                <span class="error error-count_of_entering_exam text-danger"></span>
                            </div>



                            <div class="col-sm-12">
                                <label class="form-label" for="title">{{ __('lms.Compliance Mapping') }}</label>
                                <select class="form-control" name="compliance_mapping[]" id="compliance_mapping"
                                     multiple>
                                    @foreach ($compliances as $compliance)
                                        <option value="{{ $compliance->id }}">{{ $compliance->short_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-compliance_mapping text-danger"></span>
                            </div>


                            {{-- <div class="row">
                                    <div class="col-sm-4">
                                        <div class="d-flex justify-content-center">
                                            <h4 class="text-secondary">Training Pages</h3>
                                        </div>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-warning me-2" value="question"
                                                id="edit_pre_append_question">Add Question ↑</button>
                                            <button type="button" class="btn btn-info" value="statement"
                                                id="edit_pre_append_statement">Add Statement ↑</button>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                </div> --}}


                            <div class="row" id="edit-main-statement-or-question-operation">

                            </div>

                            <div class="col-md-12">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <span>{{ __('lms.Total Questions') }}: <strong
                                                id="edit_total_questions">0</strong></span>
                                        <span class="ms-3">{{ __('lms.Total Statements') }}: <strong
                                                id="edit_total_statements">1</strong></span>
                                        <span class="ms-3">{{ __('lms.Total Pages') }}: <strong
                                                id="edit_total_pages">1</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="text-end pt-3">
                            {{-- <button class="btn btn-primary" id="edit_training_btn"
                                    type="submit">Update</button> --}}
                            @if (auth()->user()->hasPermission('trainingModules.update'))

                                <button class="btn btn-primary" id="edit_training_btn" type="submit">
                                    <span id="edit_training_btn_text">{{ __('lms.Update') }}</span>
                                    <span id="edit_training_btn_loader" class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            @endif
                            <button type="button" class="btn btn-danger" id="cancel_level_btn"
                                data-bs-dismiss="modal" aria-label="Close">{{ __('lms.Cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="order_section_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close close_btn" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('order_section') }}</h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div id="order_section"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_section_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('edit_section') }}</h4>
            </div>
            <div class="modal-body pt0 pb0">
                <span id="loader_section"></span>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="edit_section_form" method="post" class="ptt10">
                            @csrf <!-- Include CSRF token for security -->
                            <input type="hidden" name="section_id" id="edit_sectionID">
                            <input type="hidden" name="online_course_id" id="online_course_id">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_title">{{ __('title') }}</label><small class="req">
                                            *</small>
                                        <input type="text" id="edit_title" autocomplete="off"
                                            class="form-control" name="edit_title">
                                        <span id="title_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div><!--./row-->
                        </form>
                    </div><!--./col-md-12-->
                </div><!--./row-->
                <div class="row">
                    <div class="box-footer col-md-12">
                        <a id="edit_section_btn" class="btn btn-info pull-right">
                            <span id="section_loaders"></span> {{ __('save') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_lesson_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('add_lesson') }}</h4>
            </div>
            <div class="scroll-area">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="add_lesson_form" method="post" enctype="multipart/form-data" class="ptt10">
                                @csrf <!-- Include CSRF token for security -->
                                <input type="hidden" name="lesson_course_id" id="lesson_course_id">
                                <input type="hidden" name="add_lesson_section_id" id="add_lesson_section_id">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="title">{{ __('title') }}</label><small class="req">
                                                *</small>
                                            <input type="text" id="title" autocomplete="off"
                                                class="form-control" name="title">
                                            <span id="title_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="lesson_type">{{ __('lesson_type') }}</label><small
                                                class="req"> *</small>
                                            <select class="form-control" name="lesson_type"
                                                onchange="getcontent(this.value)">
                                                <option value="">{{ __('select') }}</option>
                                                @foreach ($lesson_type ?? [] as $key => $lvalue)
                                                    <option value="{{ $key }}">{{ $lvalue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="lesson_type_error"
                                                class="text-danger">{{ $errors->first('lesson_type') }}</span>
                                            <div class="form-group displaynone" id="attachment"><br>
                                                <label>{{ __('attachment') }} <small class="req">
                                                        *</small></label>
                                                <input autofocus name="lesson_attachment" id="lesson_attachment"
                                                    type="file" class="form-control filestyle"
                                                    accept=".pdf,.doc,.docx,.txt" />
                                                <span
                                                    class="text-danger">{{ $errors->first('lesson_attachment') }}</span>
                                            </div>
                                            <div id="video_detail" class="displaynone"><br>
                                                <div class="form-group">
                                                    <label>{{ __('video_provider') }}</label>
                                                    <select class="form-control" id="lesson_provider"
                                                        onclick="checkLessonProvider()" name="lesson_provider">
                                                        @foreach ($course_provider ?? [] as $key => $cpvalue)
                                                            <option value="{{ $key }}">{{ $cpvalue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span
                                                        class="text-danger">{{ $errors->first('lesson_provider') }}</span>
                                                </div>
                                                <div class="form-group" id="lesson_url_div">
                                                    <label>{{ __('video_url') }}</label><small class="req">
                                                        *</small>
                                                    <input autofocus name="lesson_url" type="text"
                                                        class="form-control" />
                                                    <span
                                                        class="text-danger">{{ $errors->first('video_url') }}</span>
                                                </div>
                                                <div class="form-group" id="lesson_file_div">
                                                    <label>{{ __('lesson_file') }} <small class="req">
                                                            *</small></label>
                                                    <input autofocus name="lesson_file" class="filestyle form-control"
                                                        type="file" />
                                                    <span
                                                        class="text-danger">{{ $errors->first('video_url') }}</span>
                                                </div>
                                                <div class="form-group relative">
                                                    <label>{{ __('duration') }} <small class="req">
                                                            *</small></label>
                                                    <input autofocus name="lesson_duration" placeholder="HH:MM:SS"
                                                        type="text" class="form-control timepicker">
                                                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="add_lesson_thumbnail">{{ __('inline_preview_image') }}
                                                (700px
                                                X 400px)</label><small class="req"> *</small>
                                            <input type="file" id="thumbnail" autocomplete="off"
                                                class="filestyle form-control" name="add_lesson_thumbnail">
                                            <span id="thumbnail_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="summary">{{ __('summary') }}</label>
                                            <textarea rows="5" id="summary" autocomplete="off" class="form-control" name="summary"></textarea>
                                            <span id="summary_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div><!--./row-->
                            </form>
                        </div><!--./col-md-12-->
                    </div><!--./row-->
                    <div class="row">
                        <div class="box-footer col-md-12">
                            <button id="save_lesson" class="btn btn-info pull-right">
                                <span id="lesson_loader"></span>{{ __('save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_lesson_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('edit_lesson') }}</h4>
            </div>
            <div class="scroll-area">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="edit_lesson_form" method="post" enctype="multipart/form-data" class="ptt10">
                                @csrf <!-- Include CSRF token for security -->
                                <input type="hidden" name="edit_lesson_course_id" id="edit_lesson_course_id">
                                <input type="hidden" name="lesson_section_id" id="lesson_section_id">
                                <input type="hidden" name="lessons_id" id="lessons_id">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="lesson_titleID">{{ __('title') }}</label><small
                                                class="req">
                                                *</small>
                                            <input type="text" id="lesson_titleID" autocomplete="off"
                                                class="form-control" name="lesson_titleID">
                                            <span id="title_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="lesson_selectedID">{{ __('lesson_type') }}</label><small
                                                class="req"> *</small>
                                            <select class="form-control" id="lesson_selectedID" name="lessons_type"
                                                onchange="geteditcontent(this.value)">
                                                <option value="">{{ __('select') }}</option>
                                                @foreach ($lesson_type ?? [] as $key => $lvalue)
                                                    <option value="{{ $key }}">{{ $lvalue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="lesson_type_error" class="text-danger"></span>
                                        </div>
                                        <div class="form-group displaynone" id="editattachment">
                                            <label>{{ __('attachment') }}</label>
                                            <input autofocus name="lesson_attachment" type="file"
                                                class="form-control filestyle" accept=".pdf,.doc,.docx,.txt" />
                                            <input type="hidden" name="old_attachment_img"
                                                id="old_attachment_img_id">
                                            <span
                                                class="text-danger">{{ $errors->first('lesson_attachment') }}</span>
                                        </div>
                                        <div id="editvideo_detail" class="displaynone">
                                            <div class="form-group">
                                                <label>{{ __('video_provider') }}</label>
                                                <select class="form-control" onclick="checkEditLessonProvider()"
                                                    name="lesson_provider" id="lesson_provider_edit">
                                                    @foreach ($course_provider ?? [] as $key => $cpvalue)
                                                        <option value="{{ $key }}">{{ $cpvalue }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span
                                                    class="text-danger">{{ $errors->first('lesson_provider') }}</span>
                                            </div>
                                            <div class="form-group" id="lesson_url_edit_div">
                                                <label>{{ __('video_url') }}</label><small class="req"> *</small>
                                                <input autofocus name="lesson_url" id="lesson_urlID"
                                                    type="text" class="form-control" value="" />
                                                <span class="text-danger">{{ $errors->first('video_url') }}</span>
                                            </div>
                                            <div class="form-group" id="lesson_file_edit_div">
                                                <label>{{ __('lesson_file') }}</label>
                                                <input autofocus name="lesson_file" class="filestyle form-control"
                                                    type="file" value="" />
                                                <span class="text-danger">{{ $errors->first('video_url') }}</span>
                                            </div>
                                            <div class="form-group relative">
                                                <label>{{ __('duration') }}</label>
                                                <input autofocus name="lesson_duration" id="lesson_durationID"
                                                    placeholder="HH:MM:SS" type="text"
                                                    class="form-control timepicker">
                                                <span class="text-danger">{{ $errors->first('duration') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="lesson_thumbnail">{{ __('inline_preview_image') }} (700px X
                                                400px)</label>
                                            <input type="file" id="lesson_thumbnail" autocomplete="off"
                                                class="form-control filestyle" name="lesson_thumbnail">
                                            <input type="hidden" name="old_background" id="lesson_old_img_id">
                                            <span id="lesson_thumbnail_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="lessons_summaryID">{{ __('summary') }}</label>
                                            <textarea rows="5" id="lessons_summaryID" autocomplete="off" class="form-control"
                                                name="lessons_summary"></textarea>
                                            <span id="lesson_summaryID_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div><!--./row-->
                            </form>
                        </div><!--./col-md-12-->
                    </div><!--./row-->
                    <div class="row">
                        <div class="box-footer col-md-12">
                            <button id="edit_lesson_btn" class="btn btn-info pull-right">
                                <span id="lesson_loaders"></span>{{ __('save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_quiz_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('add_new_quiz') }}</h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="add_quiz_form" method="post" class="ptt10" enctype="multipart/form-data">
                            @csrf <!-- Include CSRF token for security -->
                            <input type="hidden" name="quiz_courseid" id="quiz_courseid">
                            <input type="hidden" name="sectionId" id="sectionId">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="quiz_title">{{ __('quiz_title') }}</label><small
                                            class="req">
                                            *</small>
                                        <input type="text" id="quiz_title" autocomplete="off"
                                            class="form-control" name="quiz_title">
                                        <span id="title_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div><!--./row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="quiz_instruction">{{ __('instruction') }}</label>
                                        <textarea rows="5" class="form-control" name="quiz_instruction" id="quiz_instruction"></textarea>
                                        <span id="quiz_instruction_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!--./col-md-12-->
                </div><!--./row-->
                <div class="row">
                    <div class="box-footer col-md-12">
                        <a id="add_quiz_btn" class="btn btn-info pull-right">
                            <span id="quiz_loader"></span>{{ __('save') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_quiz_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('edit_quiz') }}</h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="edit_quiz_form" method="post" class="ptt10" enctype="multipart/form-data">
                            @csrf <!-- Include CSRF token for security -->
                            <input type="hidden" name="edit_quiz_course" id="edit_quiz_course">
                            <input type="hidden" name="quizId" id="quizId">
                            <input type="hidden" name="edit_sectionId" id="edit_sectionId">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_quiz_title">{{ __('quiz_title') }}</label><small
                                            class="req">*</small>
                                        <input type="text" id="edit_quiz_title" autocomplete="off"
                                            class="form-control" name="edit_quiz_title">
                                        <span id="title_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div><!--./row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_quiz_instruction">{{ __('instruction') }}</label>
                                        <textarea rows="5" class="form-control" name="edit_quiz_instruction" id="edit_quiz_instruction"></textarea>
                                        <span id="quiz_instruction_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!--./col-md-12-->
                </div><!--./row-->
                <div class="row">
                    <div class="box-footer col-md-12">
                        <a id="edit_quiz_btn" class="btn btn-info pull-right">
                            <span id="quiz_loaders"></span>{{ __('save') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="question_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <div class="quizplusrighttop">
                    <a id="add_new_question_btn" class="btn btn-info quizsavebtn">
                        <span id="question_loader"></span> {{ __('save') }}
                    </a>
                    <button type="button" class="add-row plusgreenbtn addplus" data-toggle="tooltip"
                        data-original-title="{{ __('add_question') }}">
                        <i class='fa fa-plus'></i>
                    </button>
                </div>
                <button type="button" onclick="clear_question()" class="close"
                    data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('quiz_questions') }}</h4>
                <span id="total_question_">&nbsp;</span>
            </div>
            <div class="scroll-area">
                <div class="modal-body pb5">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="add_new_question_form_ID" method="post">
                                @csrf <!-- Include CSRF token for security -->
                                <input type="hidden" name="quiz_id" id="quiz_id">
                                <input type="hidden" name="question_course_id" id="question_course_id">
                                <table id="table_id" class="table tableinput">
                                    <tbody>
                                        <tr id="rowID0">
                                            <td class="border0 pl0" width="75">{{ __('question') }}<small
                                                    class="req"> *</small></td>
                                            <td class="pr0 border0 relative">
                                                <input type='text' name='question_0'
                                                    class="form-control pull-left">
                                                <button type='button' data-toggle='tooltip'
                                                    data-original-title='{{ __('delete_question') }}'
                                                    data-placement="left" data-id='0'
                                                    class='delete-row addclose quizplusright'>
                                                    <i class='fa fa-remove'></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class='options0'>
                                            <td colspan="2" class="border0">
                                                <div class="quizopationpad-left">
                                                    <table width="100%" align="right">
                                                        @foreach (['A', 'B', 'C', 'D', 'E'] as $index => $option)
                                                            <tr>
                                                                <td>{{ $option }} <small class="req">
                                                                        *</small></td>
                                                                <td>
                                                                    <div class="input-group input-group-full-width">
                                                                        <input type='text'
                                                                            name='question_0_options_{{ $index }}'
                                                                            class="form-control">
                                                                        <span
                                                                            class="input-group-addon input-group-addon-bg">
                                                                            <input type='checkbox'
                                                                                value="option_{{ $index + 1 }}"
                                                                                name='question_0_result_0[]'
                                                                                title="{{ __('check_for_correct_option') }}">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="question_count" name="question_count"
                                    value="0" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_question_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <div class="quizplusrighttop">
                    <a id="edit_new_question_btn" class="btn btn-info quizsavebtn">
                        <span id="question_loaders"></span>{{ __('save') }}
                    </a>
                    <button type="button" class="edit-row plusgreenbtn addplus" data-toggle="tooltip"
                        data-original-title="{{ __('add_question') }}">
                        <i class='fa fa-plus'></i>
                    </button>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">{{ __('quiz_questions') }}</h4>
                {{ __('total_question') }} <span id="total_edit_question"></span>
            </div>
            <div class="scroll-area">
                <div class="modal-body pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="edit_question_form" method="post">
                                @csrf <!-- Include CSRF token for security -->
                                <input type="hidden" name="editquestion_course_id" id="editquestion_course_id">
                                <div id="edit_question"></div>
                                <!-- Dynamic question content will be injected here -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="course_preview_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modalwrapwidth">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" onclick="stopvideo()">&times;</button>
            <div class="scroll-area">
                <div class="modal-body paddbtop">
                    <div class="row">
                        <div id="course_preview">
                            <!-- Dynamic content for course preview will be injected here -->
                        </div>
                    </div><!-- ./row -->
                </div><!-- ./modal-body -->
            </div>
        </div>
    </div>
</div>


@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>


<script>
    CKEDITOR.replace('statement_content_0');
    CKEDITOR.replace('statement_content_ar_0');
</script>

<script>
    (function($) {
        "use strict";

        // Course preview functionality
        $('.course_preview_id').click(function() {
            var courseID = $(this).data('id');
            $('#course_preview').html('');
            $.ajax({
                url: "{{ url('onlinecourse/course/coursepreview') }}", // Using Laravel URL helper
                type: 'post',
                data: {
                    courseID: courseID
                },
                beforeSend: function() {
                    $('#course_preview').html(
                        'Loading...  <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    $('#course_preview').html(response);
                }
            });
        });

        $(document).ready(function() {
            $('#course_detail_tab').show();
        });

    })(jQuery);
</script>


{{-- Last Best Script --}}
<script>
    $(document).ready(function() {
        $('#compliance_mapping').select2();
    })

    //###########################################3######## Course Data ************************
    // Add new Course
    $('#add_course_form_ID').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                    $('#add_course_modal').modal('hide');
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });
    });

    // Show course details
    $('.course_detail_id').click(function() {
        var courseID = $(this).data('id');
        let url = "{{ route('admin.lms.courses.show', ':id') }}";
        url = url.replace(':id', courseID);

        $.ajax({
            url: url,
            type: 'get',
            beforeSend: function() {
                $('#course_detail').html('Loading...  <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                console.log(response.course);
                $('#add_section_id').attr('data-id', response.course.id);
                $('#order_section_id').attr('data-id', response.course.id);

                let sectionList = response.course.levels;
                renderSections(sectionList);

                $('.delete_course_id').attr('data-id', response.course.id)
                $('.edit_course_id').attr('data-id', response.course.id);
                $('#editable-course-id').val(response.course.id);

                $('#course-title').val(response.course.title);
                $('#course-description').val(response.course.description);
                $('#course-image').attr('src', response.course.image);

                $('#course_detail_modal').modal('show');
            }
        });
    });

    function renderSections(sectionList) {
        let accordion = $('#accordion');

        let canAddModule = @json(auth()->user()->hasPermission('trainingModules.create'));
        let canDeleteLevel = @json(auth()->user()->hasPermission('levels.delete'));
        let canEditLevel = @json(auth()->user()->hasPermission('levels.update'));

        accordion.empty();
        sectionList.forEach((section, index) => {
            console.log('index' + index)

            let sectionHTML = `
                                    <div class="panel panel-default my-2">
                                        <div class="panel-heading d-flex justify-content-between align-items-center" style="background-color:#44225c !important;">
                                            <!-- Section Title on the Left -->
                                            <h4 class="panel-title mb-0" style="color:white !important">
                                                <a class="collapsed get_section_id panel_btnarrow" style="color:#ffffff !important" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapse${index}" data-id="${section.id}" aria-expanded="false" aria-controls="collapse${index}">
                                                    <i class="fa fa-angle-down" style="color:#ffffff !important"></i> <b>{{ __('lms.Level') }} ${index + 1}</b>: ${section.title}
                                                </a>
                                            </h4>

                                            <!-- Action Buttons on the Right -->
                                            <div class="dropdown">
                                                <a class="pe-1 dropdown-toggle hide-arrow text-white" style="color:#fff !important" href="#" role="button" id="actionsDropdown${section.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown${section.id}">
                                                    ${canAddModule ? `
                                                    <!-- Add New Training Module -->
                                                    <li>
                                                        <a href="#" class="dropdown-item add_training_id" title="Add New Training Module" data-bs-toggle="modal" data-id="${section.id}" data-bs-target="#add_training_module_modal">
                                                            <i class="fa fa-plus me-50 font-small-4"></i> {{ __('lms.Add Training Module') }}
                                                        </a>
                                                    </li>
                                                    ` : ''}

                                                    ${canDeleteLevel ? `
                                                    <!-- Trash -->
                                                    <li>
                                                        <a href="#" class="dropdown-item delete_section_id" title="{{ __('lms.Delete Level') }}" data-id="${section.id}">
                                                            <i class="fa fa-trash-alt me-50 font-small-4"></i> {{ __('lms.Delete Level') }}
                                                        </a>
                                                    </li>
                                                    ` : ''}

                                                    ${canEditLevel ? `
                                                    <!-- Edit -->
                                                    <li>
                                                        <a href="#" class="dropdown-item edit_section_id" title="{{ __('lms.Edit Level') }}" data-id="${section.id}">
                                                            <i class="fa fa-pencil me-50 font-small-4"></i> {{ __('lms.Edit Level') }}
                                                        </a>
                                                    </li>
                                                    ` : ''}
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Collapsible Content -->
                                        <div id="collapse${index}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="m-15 sortable-item ui-sortable list-group mb0">
                                                    ${renderLessons(section.training_modules)}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>`;


            accordion.append(sectionHTML);
        });
    }

    function renderLessons(lessons) {
        if (lessons.length === 0) {
            return `<li class="list-group-item text-center">No lessons available.</li>`;
        }

        let lessonHTML = '';

        let canDeleteTraining = @json(auth()->user()->hasPermission('trainingModules.delete'));
        let canEditTraining = @json(auth()->user()->hasPermission('trainingModules.update'));

        lessons.forEach((lesson, index) => {
            let previewRoute = @json(route('admin.lms.trainingModules.preview', ['id' => '__ID__'])).replace('__ID__', lesson.id);
            let survyRoute = @json(route('admin.lms.survey.results', ['id' => '__ID__','type' => 'training_module'])).replace('__ID__', lesson.id);
            lessonHTML += `
                                        <li id="${lesson.id}" class="list-group-item-sort my-2 bg-success p-1">
                                            <!-- Flexbox container to align title and buttons -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Lesson Title on the Left -->
                                                <div class="lesson-title">
                                                    <b> {{ __('lms.Training Name') }}  ${index + 1}: </b>${lesson.name}
                                                </div>

                                                <!-- Icons on the Right -->
                                                <div class="lesson-actions">

                                                    <a href="${survyRoute}" class="btn btn-xs ms-2" title="Survey Results" target="_blank">
                                                        <i class="fa fa-bar-chart"></i>
                                                    </a>

                                                    <a href="${previewRoute}" class="btn btn-xs ms-2" title="Preview training module" target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    ${canDeleteTraining ? `
                                                        <a href="#" class="btn btn-xs delete_training_module_id ms-2" data-lesson-id="${lesson.id}" title="Remove training module">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                    ` : ''}

                                                    ${canEditTraining ? `
                                                        <a href="#" class="btn btn-xs edit_training_module_id ms-2" data-toggle="modal" data-section-id="${lesson.level_id}"
                                                            data-id="${lesson.id}"
                                                            data-name="${lesson.name}"
                                                            data-passing_score="${lesson.passing_score}"
                                                            data-order="${lesson.order}"
                                                            data-cover_image_url="${lesson.cover_image_url}"
                                                            data-completion_time="${lesson.completion_time}"
                                                            data-training_type="${lesson.training_type}"
                                                            data-count_of_entering_exam="${lesson.count_of_entering_exam}"
                                                            data-survey_id="${lesson.survey_id}"

                                                            data-backdrop="static" data-keyboard="false" data-target="#edit_lesson_modal">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    ` : ''}


                                                </div>
                                            </div>
                                            <hr>
                                        </li>`;

        });
        return lessonHTML;
    }

    // Edit course
    $('#edit_course_form_ID').submit(function(e) {
        e.preventDefault();
        let id = $('#editable-course-id').val();
        let url = "{{ route('admin.lms.courses.update', '') }}/" + id
        const formData = new FormData(this);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                    $('#add_course_modal').modal('hide');
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });
    });

    // Delete Course
    $(document).on('click', '.delete_course_id', function() {
        let id = $(this).attr('data-id')
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
                deleteCourse(id);
            }
        });
    })

    // function TrashCourse(id) {
    //     let url = "{{ route('admin.lms.courses.trash', ':id') }}";
    //     url = url.replace(':id', id);
    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(data) {
    //             if (data.status) {
    //                 makeAlert('success', data.message, "{{ __('locale.Success') }}");
    //                 location.reload();
    //             }
    //         },
    //         error: function(response, data) {
    //             responseData = response.responseJSON;
    //             makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    //         }
    //     });
    // }


    function deleteCourse(id) {
        let url = "{{ route('admin.lms.courses.delete', ':id') }}";
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
                    location.reload();
                } else {
                    Swal.fire({
                        title: data.message,
                        // text: '@lang('locale.YouWontBeAbleToRevertThis')',
                        icon: 'question',
                        showCancelButton: true,
                        // confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                        cancelButtonText: "{{ __('locale.Cancel') }}",
                        customClass: {
                            confirmButton: 'btn btn-relief-success ms-1',
                            cancelButton: 'btn btn-outline-danger ms-1'
                        },
                        buttonsStyling: false
                    });
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    //###########################################3######## Levels Data ************************
    // Add new level for course
    $('#add-course-level').submit(function(e) {
        e.preventDefault();
        let course_id = $('#editable-course-id').val();
        let url = "{{ route('admin.lms.levels.store', ':id') }}";
        url = url.replace(':id', course_id);

        const formData = new FormData(this);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $("#add_section_modal").modal('hide');
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });
    });

    // Trash course level
    $(document).on('click', '.delete_section_id', function() {
        let level_id = $(this).attr('data-id')
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
                DeleteLevel(level_id);
            }
        });
    })

    function DeleteLevel(id) {
        let url = "{{ route('admin.lms.levels.delete', ':id') }}";
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
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                } else {
                    Swal.fire({
                        title: data.message,
                        // text: '@lang('locale.YouWontBeAbleToRevertThis')',
                        icon: 'question',
                        showCancelButton: true,
                        // confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                        cancelButtonText: "{{ __('locale.Cancel') }}",
                        customClass: {
                            confirmButton: 'btn btn-relief-success ms-1',
                            cancelButton: 'btn btn-outline-danger ms-1'
                        },
                        buttonsStyling: false
                    });
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // function TrashLevel(id) {
    //     let url = "{{ route('admin.lms.levels.trash', ':id') }}";
    //     url = url.replace(':id', id);
    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(data) {
    //             if (data.status) {
    //                 makeAlert('success', data.message, "{{ __('locale.Success') }}");
    //                 let sectionList = data.course.levels;
    //                 renderSections(sectionList);
    //             }
    //         },
    //         error: function(response, data) {
    //             responseData = response.responseJSON;
    //             makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    //         }
    //     });
    // }

    // Edit course level data
    $(document).on('click', '.edit_section_id', function() {
        let section_id = $(this).attr('data-id')
        $.ajax({
            url: "{{ route('admin.lms.levels.show', '') }}/" + section_id,
            type: "GET",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    $('#course-level-title').val(data.level.title)
                    $('#level_id').val(data.level.id)
                    $('#level_order').val(data.level.order)
                    $('#edit_section_modal').modal('show');
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });

    })

    // Update course level data
    $('#edit-course-level').submit(function(e) {
        e.preventDefault();
        let id = $('#level_id').val();
        let url = "{{ route('admin.lms.levels.update', '') }}/" + id
        const formData = new FormData(this);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                    $('#edit_section_modal').modal('hide');
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });
    });

    //###########################################3######## Training Module Data ************************
    // Add Question on the top
    $(document).on('click', '#pre_append_question', function() {
        let index = 0
        $('#main-statement-or-question-operation').prepend(`
                                    <div class="col-sm-4">
                                        <div class="d-flex justify-content-center">
                                            <h4 class="text-secondary main-head-content"><span> Page 1</span> - {{ __('lms.Question') }}</h4>
                                        </div>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-warning me-2 after_append_question" >{{ __('lms.Add Question') }}</button>
                                            <button type="button" class="btn btn-danger me-2 remove_question" >{{ __('lms.Remove Question') }}</button>
                                            <button type="button" class="btn btn-info me-2 after_append_statement" >{{ __('lms.Add Statement') }}</button>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 row main-statement-content">

                                        <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                        <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

                                        <div class="row col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="question">{{ __('lms.Question English') }}:</label>
                                                <input type="text"  class="form-control question" name="items[${index}][question]"  placeholder="Enter a question title English">
                                                <span class="emptyCommingError trainError-items-${index}-question text-danger"></span>
                                            </div>

                                        </div>

                                        <div class="row col-sm-6">
                                             <div class="form-group mb-3">
                                                <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
                                                <input type="text"  class="form-control question" name="items[${index}][question_ar]"  placeholder="Enter a question title Arabic">
                                                <span class="emptyCommingError trainError-items-${index}-question_ar text-danger"></span>
                                            </div>

                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="question_type">{{ __('lms.Question Type') }}:</label>
                                            <select class="form-control question_type" name="items[${index}][question_type]">
                                                <option value="multi_choise" selected> {{ __('lms.Multi Choice') }}</option>
                                                <option value="true_or_false">{{ __('lms.True or False') }}</option>
                                            </select>
                                            <span class="emptyCommingError trainError-items-${index}-question_type text-danger"></span>
                                        </div>

                                        <div class="true-or-false-div" style="display:none;">
                                            <label for="answer">Answer</label>
                                            <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
                                                <option value="true" selected>{{ __('lms.True') }}</option>
                                                <option value="false">{{ __('lms.False') }}</option>
                                            </select>
                                            <span class="emptyCommingError trainError-items-${index}-true_or_false_correct_answer text-danger"></span>
                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="multi-chose-div">
                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option') }} 1: </span>
                                                        </div>
                                                        <input id="tMQOption21" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option21" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option21">{{ __('lms.Answer') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option') }} 2: </span>
                                                        </div>
                                                        <input id="tMQOption22" type="text"   name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option22" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option22">{{ __('lms.Answer') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option') }} 3: </span>
                                                        </div>
                                                        <input id="tMQOption23" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option23" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option23">{{ __('lms.Answer') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option') }} 4: </span>
                                                        </div>
                                                        <input id="tMQOption24" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option24" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option24">{{ __('lms.Answer') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="emptyCommingError trainError-items-${index}-correct_answer text-danger"></span>
                                            </div>


                                            <div class="form-group mb-3">
                                                <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
                                                <textarea type="text" class="form-control answer_description description"  rows="2" name="items[${index}][answer_description]" placeholder="Enter an answer English description"></textarea>
                                                <span class="emptyCommingError trainError-items-${index}-answer_description text-danger"></span>
                                            </div>

                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="multi-chose-div">
                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 1: </span>
                                                        </div>
                                                        <input id="tMQOption21" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option Arabic" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option21" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option21">{{ __('lms.Answer Arabic') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 2: </span>
                                                        </div>
                                                        <input id="tMQOption22" type="text"   name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option22" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option22">{{ __('lms.Answer Arabic') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 3: </span>
                                                        </div>
                                                        <input id="tMQOption23" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option23" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option23">{{ __('lms.Answer Arabic') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 4: </span>
                                                        </div>
                                                        <input id="tMQOption24" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"  id="option24" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                    <label class="custom-control-label" for="option24">{{ __('lms.Answer Arabic') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="emptyCommingError trainError-items-${index}-correct_answer_ar text-danger"></span>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="answer_description_ar">{{ __('lms.Answer Description Arabic') }}:</label>
                                                <textarea type="text" class="form-control answer_description_ar description"  rows="2" name="items[${index}][answer_description_ar]" placeholder="Enter an answer description"></textarea>
                                                <span class="emptyCommingError trainError-items-${index}-answer_description_ar text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                `);

        $('#main-statement-or-question-operation .col-sm-4').each(function(index) {
            $(this).find('h4 span').text(`Page ${index + 1} `);
        });

        // $('#main-statement-or-question-operation .col-sm-12').each(function(i) {
        //     $(this).find('.page_number').val(i + 1);
        //     $(this).closest('.main-statement-content').find('input, select,textarea').each(function() {
        //         let name = $(this).attr('name');
        //         // Replace any index pattern [index] with the current i value (global regex for any numeric index)
        //         name = name.replace(/\[\d+\]/g, `[${i}]`);
        //         $(this).attr('name', name);
        //     });
        // });

        $('#main-statement-or-question-operation .main-statement-content').each(function(i) {
            $(this).find('.page_number').val(i + 1);
            $(this).find('input, select, textarea').each(function() {
                let name = $(this).attr('name');
                name = name.replace(/\[\d+\]/g, `[${i}]`);
                $(this).attr('name', name);
            });

            $(this).find('.emptyCommingError').each(function() {
                let classList = $(this).attr('class');
                classList = classList.replace(/trainError-items-\d+-/,
                    `trainError-items-${i}-`);
                $(this).attr('class', classList);
            });
        });

        reclculateCounts();
    });

    // Add Statement on the top
    $(document).on('click', '#pre_append_statement', function() {
        let index = 0
        const englishId = `statement_content_${index}`;
        const arabicId = `statement_content_ar_${index}`;

        $('#main-statement-or-question-operation').prepend(`

                                    <div class="col-sm-4">
                                        <div class="d-flex justify-content-center">
                                            <h4 class="text-secondary main-head-content"><span> Page  1</span> - {{ __('lms.Statement') }} </h4>
                                        </div>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-warning me-2 after_append_question" >{{ __('lms.Add Question') }} </button>
                                            <button type="button" class="btn btn-danger me-2 remove_statement" > {{ __('lms.Remove Statement') }} </button>
                                            <button type="button" class="btn btn-info me-2 after_append_statement" > {{ __('lms.Add Statement') }} </button>
                                        </div>
                                    </div>

                                     <div class="col-sm-12 row main-statement-content">

                                        <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                        <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

                                        <div class="row col-sm-6">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                                                <input type="text"  class="form-control statement_title"
                                                    name="items[${index}][statement_title]"
                                                    placeholder="{{ __('lms.Statement Title English') }}"
                                                    id="item-0">
                                                <span
                                                    class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                                                      <textarea  class="form-control statement_content" id="${englishId}"
                                                        name="items[${index}][statement_content]"
                                                        placeholder="{{ __('lms.Statement Content English') }}"></textarea>

                                                <span
                                                    class="emptyCommingError trainError-items-${index}-statement_content text-danger"></span>

                                            </div>

                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                                                <input type="text"  class="form-control statement_title_ar"
                                                    name="items[${index}][statement_title_ar]"
                                                    placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                                <span
                                                    class="emptyCommingError trainError-items-${index}-statement_title_ar text-danger"></span>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                                                <textarea  class="form-control statement_content_ar" id="${arabicId}"
                                                    name="items[${index}][statement_content_ar]"
                                                    placeholder="{{ __('lms.Statement Content Arabic') }}"></textarea>
                                                <span
                                                    class="emptyCommingError trainError-items-${index}-statement_content_ar text-danger"></span>

                                            </div>

                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                                            <select class="form-control additional_content"
                                                name="items[${index}][additional_content]">
                                                <option value="no">{{ __('lms.No Additional Content') }}</option>
                                                <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                                                <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                                            </select>
                                            <span
                                                class="emptyCommingError trainError-items-${index}-additional_content text-danger"></span>

                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="col-sm-12 form-group mb-3 video-embedded-en"
                                                style="display: none">
                                                <label
                                                    for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                                                <input type="file" accept="video/*" class="form-control video_url_en"
                                                    name="items[${index}][video_url_en]"
                                                    placeholder="{{ __('lms.Embedded Video URL English') }}">

                                                    <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                    <span class="text-success video_en_upload_status"></span>
                                                    <input type="hidden" class="video_url_en_path" name="items[${index}][video_url_en_path]">


                                                <span
                                                    class="emptyCommingError trainError-items-${index}-video_url_en text-danger"></span>

                                            </div>

                                            <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                style="display: none">
                                                <div class="col-sm-12">
                                                    <label
                                                        for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                                    <input type="file" accept="image/*" class="form-control image"
                                                        name="items[${index}][image]"
                                                        placeholder="{{ __('lms.Choose Statement Image English') }}">
                                                    <span
                                                        class="emptyCommingError trainError-items-${index}-image text-danger"></span>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
                                                <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                                <input type="file" accept="video/*" class="form-control video_url"
                                                    name="items[${index}][video_url]"
                                                    placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                                    <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                    <span class="text-success video_upload_status"></span>
                                                    <input type="hidden" class="video_url_ar_path" name="items[${index}][video_url_ar_path]">

                                                <span
                                                    class="emptyCommingError trainError-items-${index}-video_url text-danger"></span>

                                            </div>

                                            <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                style="display: none">
                                                <div class="col-sm-12">
                                                    <label
                                                        for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                                    <input type="file"  accept="image/*" class="form-control image"
                                                        name="items[${index}][image_ar]"
                                                        placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                    <span
                                                        class="emptyCommingError trainError-items-${index}-image_ar text-danger"></span>

                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                `);

        $('#main-statement-or-question-operation .col-sm-4').each(function(index) {
            $(this).find('h4 span').text(`Page ${index + 1} `);
        });

        // $('#main-statement-or-question-operation .col-sm-12').each(function(i) {
        //     $(this).find('.page_number').val(i + 1);
        //     $(this).closest('.main-statement-content').find('input, select,textarea').each(function() {
        //         let name = $(this).attr('name');
        //         // Replace any index pattern [index] with the current i value (global regex for any numeric index)
        //         name = name.replace(/\[\d+\]/g, `[${i}]`);
        //         $(this).attr('name', name); // Set the new name
        //     });
        // });

        $('#main-statement-or-question-operation .main-statement-content').each(function(i) {
            $(this).find('.page_number').val(i + 1);
            $(this).find('input, select, textarea').each(function() {
                let name = $(this).attr('name');
                name = name.replace(/\[\d+\]/g, `[${i}]`);
                $(this).attr('name', name);
            });

            $(this).find('.emptyCommingError').each(function() {
                let classList = $(this).attr('class');
                classList = classList.replace(/trainError-items-\d+-/,
                    `trainError-items-${i}-`);
                $(this).attr('class', classList);
            });

        });

        CKEDITOR.replace(englishId);
        CKEDITOR.replace(arabicId);
        reclculateCounts();
    });

    // Recalculate count of questions , pages and statements
    function reclculateCounts() {
        $('#total_questions').text($('#main-statement-or-question-operation select.question_type')
            .length); // question_type select not input
        $('#total_statements').text($('#main-statement-or-question-operation select.additional_content').length);
        $('#total_pages').text($('#main-statement-or-question-operation .col-sm-4').length);
    }

    // Add Question on the last
    /*$(document).on('click', '.after_append_question', function () {
        let pageIndex = $('#main-statement-or-question-operation .col-sm-4').length;
        let index = $('#main-statement-or-question-operation .main-statement-content').length;
        $('#main-statement-or-question-operation').append(`

                    <div class="col-sm-4">
                        <div class="d-flex justify-content-center">
                            <h4 class="text-secondary main-head-content"><span> Page  ${pageIndex + 1} </span> - {{ __('lms.Question') }} </h4 >
                        </div >
                    </div >

                    <div class="col-sm-8">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-warning me-2 after_append_question"> {{ __('lms.Add Question') }} </button>
                            <button type="button" class="btn btn-danger me-2 remove_question">{{ __('lms.Remove Question') }} </button>
                            <button type="button" class="btn btn-info me-2 after_append_statement">{{ __('lms.Add Statement') }} </button>
                        </div>
                    </div>

                    <div class="col-sm-12 row main-statement-content">

                        <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                        <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

                        <div class="row col-sm-6">
                            <div class="form-group mb-3">
                                <label for="question">{{ __('lms.Question English') }}:</label>
                                <input type="text"  class="form-control question" name="items[${index}][question]"  placeholder="Enter a question title English">
                                <span class="emptyCommingError trainError-items-${index}-question text-danger"></span>
                            </div>

                        </div>

                        <div class="row col-sm-6">
                             <div class="form-group mb-3">
                                <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
                                <input type="text"  class="form-control question" name="items[${index}][question_ar]"  placeholder="Enter a question title Arabic">
                                <span class="emptyCommingError trainError-items-${index}-question_ar text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="question_type">{{ __('lms.Question Type') }}:</label>
                            <select class="form-control question_type" name="items[${index}][question_type]">
                                <option value="multi_choise" selected> {{ __('lms.Multi Choice') }}</option>
                                <option value="true_or_false">{{ __('lms.True or False') }}</option>
                            </select>
                            <span class="emptyCommingError trainError-items-${index}-question_type text-danger"></span>
                        </div>

                        <div class="true-or-false-div" style="display:none;">
                            <label for="answer">Answer</label>
                            <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
                                <option value="true" selected>{{ __('lms.True') }}</option>
                                <option value="false">{{ __('lms.False') }}</option>
                            </select>
                            <span class="emptyCommingError trainError-items-${index}-true_or_false_correct_answer text-danger"></span>
                        </div>

                        <div class="row col-sm-6">
                            <div class="multi-chose-div">
                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 1: </span>
                                        </div>
                                        <input id="tMQOption21" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option21" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option21">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 2: </span>
                                        </div>
                                        <input id="tMQOption22" type="text"   name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option22" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option22">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 3: </span>
                                        </div>
                                        <input id="tMQOption23" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option23" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option23">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 4: </span>
                                        </div>
                                        <input id="tMQOption24" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option24" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option24">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="emptyCommingError trainError-items-${index}-correct_answer text-danger"></span>
                            </div>


                            <div class="form-group mb-3">
                                <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
                                <textarea type="text" class="form-control answer_description description"  rows="2" name="items[${index}][answer_description]" placeholder="Enter an answer English description"></textarea>
                                <span class="emptyCommingError trainError-items-${index}-answer_description text-danger"></span>
                            </div>

                        </div>

                        <div class="row col-sm-6">
                            <div class="multi-chose-div">
                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 1: </span>
                                        </div>
                                        <input id="tMQOption21" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option Arabic" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option21" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option21">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 2: </span>
                                        </div>
                                        <input id="tMQOption22" type="text"   name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option22" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option22">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 3: </span>
                                        </div>
                                        <input id="tMQOption23" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option23" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option23">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 4: </span>
                                        </div>
                                        <input id="tMQOption24" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option24" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option24">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="emptyCommingError trainError-items-${index}-correct_answer_ar text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="answer_description_ar">{{ __('lms.Answer Description Arabic') }}:</label>
                                <textarea type="text" class="form-control answer_description_ar description"  rows="2" name="items[${index}][answer_description_ar]" placeholder="Enter an answer description"></textarea>
                                <span class="emptyCommingError trainError-items-${index}-answer_description_ar text-danger"></span>
                            </div>
                        </div>







                    </div>
                `);

        $('.main-statement-content').each(function (i) {
            $(this).find('.page_number').val(i + 1);
        });

        reclculateCounts();
    });*/




    $(document).on('click', '.after_append_question', function() {

        let $btn = $(this);
        let $parentRow = $btn.closest('.col-sm-8');

        let pageIndex = $('#main-statement-or-question-operation .col-sm-4').length;
        let index = $('#main-statement-or-question-operation .main-statement-content').length;
        let html = `

                    <div class="col-sm-4">
                        <div class="d-flex justify-content-center">
                            <h4 class="text-secondary main-head-content"><span> Page  ${pageIndex + 1} </span> - {{ __('lms.Question') }} </h4>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-warning me-2 after_append_question"> {{ __('lms.Add Question') }} </button>
                            <button type="button" class="btn btn-danger me-2 remove_question">{{ __('lms.Remove Question') }} </button>
                            <button type="button" class="btn btn-info me-2 after_append_statement">{{ __('lms.Add Statement') }} </button>
                        </div>
                    </div>

                    <div class="col-sm-12 row main-statement-content">

                        <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                        <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

                        <div class="row col-sm-6">
                            <div class="form-group mb-3">
                                <label for="question">{{ __('lms.Question English') }}:</label>
                                <input type="text"  class="form-control question" name="items[${index}][question]"  placeholder="Enter a question title English">
                                <span class="emptyCommingError trainError-items-${index}-question text-danger"></span>
                            </div>

                        </div>

                        <div class="row col-sm-6">
                                <div class="form-group mb-3">
                                <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
                                <input type="text"  class="form-control question" name="items[${index}][question_ar]"  placeholder="Enter a question title Arabic">
                                <span class="emptyCommingError trainError-items-${index}-question_ar text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="question_type">{{ __('lms.Question Type') }}:</label>
                            <select class="form-control question_type" name="items[${index}][question_type]">
                                <option value="multi_choise" selected> {{ __('lms.Multi Choice') }}</option>
                                <option value="true_or_false">{{ __('lms.True or False') }}</option>
                            </select>
                            <span class="emptyCommingError trainError-items-${index}-question_type text-danger"></span>
                        </div>

                        <div class="true-or-false-div" style="display:none;">
                            <label for="answer">Answer</label>
                            <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
                                <option value="true" selected>{{ __('lms.True') }}</option>
                                <option value="false">{{ __('lms.False') }}</option>
                            </select>
                            <span class="emptyCommingError trainError-items-${index}-true_or_false_correct_answer text-danger"></span>
                        </div>

                        <div class="row col-sm-6">
                            <div class="multi-chose-div">
                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 1: </span>
                                        </div>
                                        <input id="tMQOption21" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option21" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option21">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 2: </span>
                                        </div>
                                        <input id="tMQOption22" type="text"   name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option22" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option22">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 3: </span>
                                        </div>
                                        <input id="tMQOption23" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option23" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option23">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option') }} 4: </span>
                                        </div>
                                        <input id="tMQOption24" type="text"  name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option24" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option24">{{ __('lms.Answer') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="emptyCommingError trainError-items-${index}-correct_answer text-danger"></span>
                            </div>


                            <div class="form-group mb-3">
                                <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
                                <textarea type="text" class="form-control answer_description description"  rows="2" name="items[${index}][answer_description]" placeholder="Enter an answer English description"></textarea>
                                <span class="emptyCommingError trainError-items-${index}-answer_description text-danger"></span>
                            </div>

                        </div>

                        <div class="row col-sm-6">
                            <div class="multi-chose-div">
                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 1: </span>
                                        </div>
                                        <input id="tMQOption21" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option Arabic" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option21" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option21">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 2: </span>
                                        </div>
                                        <input id="tMQOption22" type="text"   name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option22" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option22">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 3: </span>
                                        </div>
                                        <input id="tMQOption23" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option23" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option23">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row col-md-12">
                                    <div class="input-group pl-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 4: </span>
                                        </div>
                                        <input id="tMQOption24" type="text"  name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                        <div class="input-group-append">
                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  id="option24" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                    <label class="custom-control-label" for="option24">{{ __('lms.Answer Arabic') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="emptyCommingError trainError-items-${index}-correct_answer_ar text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="answer_description_ar">{{ __('lms.Answer Description Arabic') }}:</label>
                                <textarea type="text" class="form-control answer_description_ar description"  rows="2" name="items[${index}][answer_description_ar]" placeholder="Enter an answer description"></textarea>
                                <span class="emptyCommingError trainError-items-${index}-answer_description_ar text-danger"></span>
                            </div>
                        </div>







                    </div>
                    `;

        $parentRow.next('.main-statement-content').length ?
            $parentRow.next('.main-statement-content').after(html) :
            $parentRow.after(html);

        $('#main-statement-or-question-operation .col-sm-4').each(function (i) {
            $(this).find('h4 span').text(`Page ${i + 1} `);
        });
        $('#main-statement-or-question-operation .main-statement-content').each(function (i) {
            $(this).find('.page_number').val(i + 1);
            $(this).find('input, select, textarea').each(function () {
                let name = $(this).attr('name');
                name = name.replace(/\[\d+\]/g, `[${i}]`);
                $(this).attr('name', name);
            });
            $(this).find('.emptyCommingError').each(function () {
                let classList = $(this).attr('class');
                classList = classList.replace(/trainError-items-\d+-/, `trainError-items-${i}-`);
                $(this).attr('class', classList);
            });
        });


        reclculateCounts();
    });



    // Add Statement on the last
    /*$(document).on('click', '.after_append_statement', function () {
                                let pageIndex = $('#main-statement-or-question-operation .col-sm-4').length;
                            let index = $('#main-statement-or-question-operation .main-statement-content').length;

                            const englishId = `statement_content_${index}`;
                            const arabicId = `statement_content_ar_${index}`;


                            $('#main-statement-or-question-operation').append(`

                            <div class="col-sm-4">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-secondary main-head-content"><span> Page  ${pageIndex + 1}</span> - {{ __('lms.Statement') }} </h4>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-warning me-2 after_append_question" > {{ __('lms.Add Question') }} </button>
                                    <button type="button" class="btn btn-danger me-2 remove_statement" > {{ __('lms.Remove Statement') }} </button>
                                    <button type="button" class="btn btn-info me-2 after_append_statement" >{{ __('lms.Add Statement') }} </button>
                                </div>
                            </div>

                            <div class="col-sm-12 row main-statement-content">

                                <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                    <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

                                        <div class="row col-sm-6">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                                                <input type="text" class="form-control statement_title"
                                                    name="items[${index}][statement_title]"
                                                    placeholder="{{ __('lms.Statement Title English') }}"
                                                    id="item-0">
                                                    <span
                                                        class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                                                <textarea class="form-control statement_content" id="${englishId}"
                                                    name="items[${index}][statement_content]"
                                                    placeholder="{{ __('lms.Statement Content English') }}"></textarea>
                                                <span
                                                    class="emptyCommingError trainError-items-${index}-statement_content text-danger"></span>

                                            </div>

                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                                                <input type="text" class="form-control statement_title_ar"
                                                    name="items[${index}][statement_title_ar]"
                                                    placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                                    <span
                                                        class="emptyCommingError trainError-items-${index}-statement_title_ar text-danger"></span>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label
                                                    for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                                                <textarea class="form-control statement_content_ar" id="${arabicId}"
                                                    name="items[${index}][statement_content_ar]"
                                                    placeholder="{{ __('lms.Statement Content Arabic') }}"></textarea>
                                                <span
                                                    class="emptyCommingError trainError-items-${index}-statement_content_ar text-danger"></span>

                                            </div>

                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                                            <select class="form-control additional_content"
                                                name="items[${index}][additional_content]">
                                                <option value="no">{{ __('lms.No Additional Content') }}</option>
                                                <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                                                <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                                            </select>
                                            <span
                                                class="emptyCommingError trainError-items-${index}-additional_content text-danger"></span>

                                        </div>

                                        <div class="row col-sm-6">
                                            <div class="col-sm-12 form-group mb-3 video-embedded-en"
                                                style="display: none">
                                                <label
                                                    for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                                                <input type="file" accept="video/*" class="form-control video_url_en"
                                                    name="items[${index}][video_url_en]"
                                                    placeholder="{{ __('lms.Embedded Video URL English') }}">

                                                    <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                    <span class="text-success video_en_upload_status"></span>
                                                    <input type="hidden" class="video_url_en_path" name="items[${index}][video_url_en_path]">

                                                        <span
                                                            class="emptyCommingError trainError-items-${index}-video_url_en text-danger"></span>

                                                    </div>

                                                    <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                        style="display: none">
                                                        <div class="col-sm-12">
                                                            <label
                                                                for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                                            <input type="file" accept="image/*" class="form-control image"
                                                                name="items[${index}][image]"
                                                                placeholder="{{ __('lms.Choose Statement Image English') }}">
                                                                <span
                                                                    class="emptyCommingError trainError-items-${index}-image text-danger"></span>

                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="row col-sm-6">
                                                <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
                                                    <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                                    <input type="file" accept="video/*" class="form-control video_url"
                                                        name="items[${index}][video_url]"
                                                        placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                                        <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                        <span class="text-success video_upload_status"></span>
                                                        <input type="hidden" class="video_url_ar_path" name="items[${index}][video_url_ar_path]">


                                                            <span
                                                                class="emptyCommingError trainError-items-${index}-video_url text-danger"></span>

                                                        </div>

                                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                            style="display: none">
                                                            <div class="col-sm-12">
                                                                <label
                                                                    for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                                                <input type="file" accept="image/*" class="form-control image"
                                                                    name="items[${index}][image_ar]"
                                                                    placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                                    <span
                                                                        class="emptyCommingError trainError-items-${index}-image_ar text-danger"></span>

                                                            </div>
                                                        </div>


                                                </div>

                                            </div>
                                            `);

                                            $('.main-statement-content').each(function (i) {
                                                $(this).find('.page_number').val(i + 1);
        });

                                            CKEDITOR.replace(englishId);
                                            CKEDITOR.replace(arabicId);

                                            reclculateCounts();
    });*/



    $(document).on('click', '.after_append_statement', function() {

        let $btn = $(this);
        let $parentRow = $btn.closest('.col-sm-8');

        let pageIndex = $('#main-statement-or-question-operation .col-sm-4').length;
        let index = $('#main-statement-or-question-operation .main-statement-content').length;

        const englishId = `statement_content_${index}`;
        const arabicId = `statement_content_ar_${index}`;
        let html = `

                                                <div class="col-sm-4">
                                                    <div class="d-flex justify-content-center">
                                                        <h4 class="text-secondary main-head-content"><span> Page  ${pageIndex + 1}</span> - {{ __('lms.Statement') }} </h4>
                                                    </div>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-warning me-2 after_append_question" > {{ __('lms.Add Question') }} </button>
                                                        <button type="button" class="btn btn-danger me-2 remove_statement" > {{ __('lms.Remove Statement') }} </button>
                                                        <button type="button" class="btn btn-info me-2 after_append_statement" >{{ __('lms.Add Statement') }} </button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 row main-statement-content">

                                                    <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                                        <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

                                                            <div class="row col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                                                                    <input type="text" class="form-control statement_title"
                                                                        name="items[${index}][statement_title]"
                                                                        placeholder="{{ __('lms.Statement Title English') }}"
                                                                        id="item-0">
                                                                        <span
                                                                            class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                                                                    <textarea class="form-control statement_content" id="${englishId}"
                                                                        name="items[${index}][statement_content]"
                                                                        placeholder="{{ __('lms.Statement Content English') }}"></textarea>
                                                                    <span
                                                                        class="emptyCommingError trainError-items-${index}-statement_content text-danger"></span>

                                                                </div>

                                                            </div>

                                                            <div class="row col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                                                                    <input type="text" class="form-control statement_title_ar"
                                                                        name="items[${index}][statement_title_ar]"
                                                                        placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                                                        <span
                                                                            class="emptyCommingError trainError-items-${index}-statement_title_ar text-danger"></span>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                                                                    <textarea class="form-control statement_content_ar" id="${arabicId}"
                                                                        name="items[${index}][statement_content_ar]"
                                                                        placeholder="{{ __('lms.Statement Content Arabic') }}"></textarea>
                                                                    <span
                                                                        class="emptyCommingError trainError-items-${index}-statement_content_ar text-danger"></span>

                                                                </div>

                                                            </div>


                                                            <div class="form-group mb-3">
                                                                <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                                                                <select class="form-control additional_content"
                                                                    name="items[${index}][additional_content]">
                                                                    <option value="no">{{ __('lms.No Additional Content') }}</option>
                                                                    <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                                                                    <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                                                                </select>
                                                                <span
                                                                    class="emptyCommingError trainError-items-${index}-additional_content text-danger"></span>

                                                            </div>

                                                            <div class="row col-sm-6">
                                                                <div class="col-sm-12 form-group mb-3 video-embedded-en"
                                                                    style="display: none">
                                                                    <label
                                                                        for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                                                                    <input type="file" accept="video/*" class="form-control video_url_en"
                                                                        name="items[${index}][video_url_en]"
                                                                        placeholder="{{ __('lms.Embedded Video URL English') }}">

                                                                        <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                                        <span class="text-success video_en_upload_status"></span>
                                                                        <input type="hidden" class="video_url_en_path" name="items[${index}][video_url_en_path]">

                                                                            <span
                                                                                class="emptyCommingError trainError-items-${index}-video_url_en text-danger"></span>

                                                                        </div>

                                                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                                            style="display: none">
                                                                            <div class="col-sm-12">
                                                                                <label
                                                                                    for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                                                                <input type="file" accept="image/*" class="form-control image"
                                                                                    name="items[${index}][image]"
                                                                                    placeholder="{{ __('lms.Choose Statement Image English') }}">
                                                                                    <span
                                                                                        class="emptyCommingError trainError-items-${index}-image text-danger"></span>

                                                                            </div>
                                                                        </div>

                                                                </div>

                                                                <div class="row col-sm-6">
                                                                    <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
                                                                        <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                                                        <input type="file" accept="video/*" class="form-control video_url"
                                                                            name="items[${index}][video_url]"
                                                                            placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                                                            <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                                            <span class="text-success video_upload_status"></span>
                                                                            <input type="hidden" class="video_url_ar_path" name="items[${index}][video_url_ar_path]">


                                                                                <span
                                                                                    class="emptyCommingError trainError-items-${index}-video_url text-danger"></span>

                                                                            </div>

                                                                            <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                                                style="display: none">
                                                                                <div class="col-sm-12">
                                                                                    <label
                                                                                        for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                                                                    <input type="file" accept="image/*" class="form-control image"
                                                                                        name="items[${index}][image_ar]"
                                                                                        placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                                                        <span
                                                                                            class="emptyCommingError trainError-items-${index}-image_ar text-danger"></span>

                                                                                </div>
                                                                            </div>


                                                                    </div>

                                                                </div>
                                                                `;

        $parentRow.next('.main-statement-content').length ?
            $parentRow.next('.main-statement-content').after(html) :
            $parentRow.after(html);

        $('#main-statement-or-question-operation .col-sm-4').each(function (i) {
            $(this).find('h4 span').text(`Page ${i + 1} `);
        });
        $('#main-statement-or-question-operation .main-statement-content').each(function (i) {
            $(this).find('.page_number').val(i + 1);
            $(this).find('input, select, textarea').each(function () {
                let name = $(this).attr('name');
                name = name.replace(/\[\d+\]/g, `[${i}]`);
                $(this).attr('name', name);
            });
            $(this).find('.emptyCommingError').each(function () {
                let classList = $(this).attr('class');
                classList = classList.replace(/trainError-items-\d+-/, `trainError-items-${i}-`);
                $(this).attr('class', classList);
            });
        });


        CKEDITOR.replace(englishId);
        CKEDITOR.replace(arabicId);

        reclculateCounts();
    });


    // Remove Question or Statement and update indexes
    $(document).on('click', '.remove_question,.remove_statement', function() {
        $(this).closest('.col-sm-8').prev('.col-sm-4').remove();
        $(this).closest('.col-sm-8').next('.col-sm-12').remove();
        $(this).closest('.col-sm-8').remove();

        // after we should update indexes
        $('#main-statement-or-question-operation .col-sm-4').each(function(index) {
            $(this).find('h4 span').text(`Page ${index + 1} `);
        });
        reclculateCounts();
    });


    // Toggle according to additional content in statements
    $(document).on('change', '.additional_content', function() {
        let parentDiv = $(this).closest('.main-statement-content');
        let videoEmbedded = parentDiv.find('.video-embedded');
        let videoEmbeddedEnglish = parentDiv.find('.video-embedded-en');
        let imageEmbedded = parentDiv.find('.image-embedded');
        if ($(this).val() == 'video') {
            videoEmbedded.show();
            videoEmbeddedEnglish.show();
            imageEmbedded.hide();

            // videoEmbedded.find('input').prop('required', true);
            // videoEmbeddedEnglish.find('input').prop('required', true);
            // imageEmbedded.find('input').prop('required', false);

        } else if ($(this).val() == 'image') {
            imageEmbedded.show();
            videoEmbedded.hide();
            videoEmbeddedEnglish.hide();

            // videoEmbedded.find('input').prop('required', false);
            // videoEmbeddedEnglish.find('input').prop('required', false);
            // imageEmbedded.find('input[type="file"]').prop('required', true);
        } else {
            videoEmbeddedEnglish.hide();
            videoEmbedded.hide();
            imageEmbedded.hide();

            // videoEmbedded.find('input').prop('required', false);
            // videoEmbeddedEnglish.find('input').prop('required', false);
            // imageEmbedded.find('input').prop('required', false);
        }
    });

    // Toggle according to question type in questions
    $(document).on('change', '.question_type', function() {
        let parentDiv = $(this).closest('.main-statement-content');
        let multiChoise = parentDiv.find('.multi-chose-div');
        let trueOrFalse = parentDiv.find('.true-or-false-div');
        if ($(this).val() == 'multi_choise') {
            multiChoise.show();
            trueOrFalse.hide();

            multiChoise.find('input:lt(2)').prop('required',
                true); // first two options ...... less than 2 => 0,1
            multiChoise.find('input:gt(1)').prop('required',
                false); // third and fourth options. ...... greater than 1 => 2,3
            // multiChoise.find('input').prop('required', true);
            trueOrFalse.find('input').prop('required', false);
        } else if ($(this).val() == 'true_or_false') {
            trueOrFalse.show();
            multiChoise.hide();

            multiChoise.find('input').prop('required', false);
            trueOrFalse.find('input').prop('required', true);
        }
    });

    // Toggle correct answer
    $(document).on('change', 'input[type="radio"]', function() {
        $(this).val($(this).closest('.input-group').find('input[type="text"]').val());
        console.log($(this).val())
    })


    $(document).on('click', '.add_training_id', function() {
        $('#train_level_id').val($(this).attr('data-id'))
        $('#compliance_mapping').select2();
        // $('#main-statement-or-question-operation').empty();
        $('#add_training_module_modal').modal('show');
    })


    // upload file by file in statements
    $(document).on('change', '.video_url_en', function() {
        var fileInput = $(this);
        var file = this.files[0];
        if (!file) return;

        var container = fileInput.closest('.video-embedded-en');
        var progressBar = container.find('.video_progress');
        var statusText = container.find('.video_en_upload_status');
        var hiddenInput = container.find('.video_url_en_path');

        let formData = new FormData();
        formData.append('video', file);

        progressBar.show().val(0);
        statusText.text('');

        $.ajax({
            url: "{{ route('admin.lms.trainingModules.uploadSingleVideo') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percent = Math.round((evt.loaded / evt.total) * 100);
                        progressBar.val(percent);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                hiddenInput.val(response.video_url);
                statusText.text("✅ تم رفع الفيديو بنجاح");
            },
            error: function() {
                statusText.text("❌ فشل رفع الفيديو");
            }
        });

    });

    $(document).on('change', '.video_url', function() {
        var fileInput = $(this);
        var file = this.files[0];
        if (!file) return;

        var container = fileInput.closest('.video-embedded');
        var progressBar = container.find('.video_progress');
        var statusText = container.find('.video_upload_status');
        var hiddenInput = container.find('.video_url_ar_path');

        let formData = new FormData();
        formData.append('video', file);

        progressBar.show().val(0);
        statusText.text('');

        $.ajax({
            url: "{{ route('admin.lms.trainingModules.uploadSingleVideo') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percent = Math.round((evt.loaded / evt.total) * 100);
                        progressBar.val(percent);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                hiddenInput.val(response.video_url);
                statusText.text("✅ تم رفع الفيديو بنجاح");
            },
            error: function() {
                statusText.text("❌ فشل رفع الفيديو");
            }
        });

    });


    // submit Khaled
    $('#add-training-module').submit(function(e) {
        // $('#success_add_training').modal('show');
        $('#add_training_btn_text').hide();
        $('#add_training_btn_loader').show();

        e.preventDefault();
        let id = $('#train_level_id').val();
        let url = "{{ route('admin.lms.trainingModules.store') }}";
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        const formData = new FormData(this);
        formData.append('level_id', id)

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                // $('#success_add_training').modal('hide');
                $('#add_training_btn_text').show();
                $('#add_training_btn_loader').hide();

                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                    $('#add_training_module_modal').modal('hide');
                    location.reload();
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                // $('#success_add_training').modal('hide');
                $('#add_training_btn_text').show();
                $('#add_training_btn_loader').hide();

                const errors = response.responseJSON.errors;
                $('.error').empty();
                $('.emptyCommingError').empty();

                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });

                $.each(errors, function(key, messages) {
                    let errorKey = key.replace(/\./g, '-'); // Replace dots with dashes
                    let errorMessage = messages[0]; // Get the first error message
                    $('.trainError-' + errorKey).text(errorMessage);
                });

            }
        });
    });

    // Trash Training module
    // delete_training_module_id ms-2" data-lesson-id="${lesson.id}"
    $(document).on('click', '.delete_training_module_id', function() {
        let training_id = $(this).attr('data-lesson-id')
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
                DeleteTrainingModule(training_id);
            }
        });
    })

    function DeleteTrainingModule(id) {
        let url = "{{ route('admin.lms.trainingModules.delete', ':id') }}";
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
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                } else {
                    Swal.fire({
                        title: data.message,
                        // text: '@lang('locale.YouWontBeAbleToRevertThis')',
                        icon: 'question',
                        showCancelButton: true,
                        // confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                        cancelButtonText: "{{ __('locale.Cancel') }}",
                        customClass: {
                            confirmButton: 'btn btn-relief-success ms-1',
                            cancelButton: 'btn btn-outline-danger ms-1'
                        },
                        buttonsStyling: false
                    });
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // function TrashTrainingModule(id) {
    //     let url = "{{ route('admin.lms.trainingModules.trash', ':id') }}";
    //     url = url.replace(':id', id);
    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(data) {
    //             if (data.status) {
    //                 makeAlert('success', data.message, "{{ __('locale.Success') }}");
    //                 let sectionList = data.course.levels;
    //                 renderSections(sectionList);
    //             }
    //         },
    //         error: function(response, data) {
    //             responseData = response.responseJSON;
    //             makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    //         }
    //     });
    // }





    // start edit training
    /* $(document).on('click', '.edit_training_module_id', function () {
                        console.log('train id is: ' + $(this).attr('data-id'));
                        var editForm = $('#edit-training-module');
                        var trainingModuleId = $(this).attr('data-id');

                        // Set up the form with existing values
                        editForm.find('#edit_train_level_id').val(trainingModuleId);
                        editForm.find('#edit_level_id').val($(this).attr('data-section-id'));
                        editForm.find('#title').val($(this).attr('data-name'));
                        editForm.find('#passing_score').val($(this).attr('data-passing_score'));
                        editForm.find('#module_order').val($(this).attr('data-order'));
                        editForm.find('#cover_image_url').val($(this).attr('data-cover_image_url'));
                        editForm.find('#completion_time').val($(this).attr('data-completion_time'));

                        $.ajax({
                            url: "{{ route('admin.lms.trainingModules.compliances', ':id') }}".replace(':id',
                                trainingModuleId),
                                                            method: 'GET',
                                                            success: function (data) {
                        const selectedCompliances = data.compliances;
                                                            console.log('selectedCompliances')
                                                            console.log(selectedCompliances)

                                                            editForm.find('#compliance_mapping option').each(function () {
                            if (selectedCompliances.includes(parseInt($(this).val()))) {
                                                                $(this).prop('selected', true);
                            }
                        });
                                                            editForm.find('#compliance_mapping').select2();
                    }
                        });

                                                            let url = "{{ route('admin.lms.trainingModules.edit', ':id') }}".replace(':id', trainingModuleId);

                                                            $.ajax({
                                                                url: url,
                                                            type: "GET",
                                                            success: function (data) {
                        if (data && data.status) {
                                                                console.log(data);
                                                            $('#edit-main-statement-or-question-operation').empty();
                                                            // Iterate over the training module contents
                                                            $.each(data.training_module, function (index, item) {
                                var pageIndex = item.content.page_number -
                                                            1; // Assuming page_number starts from 1

                                                            console.log('index') // 1
                                                            console.log('pageIndex') // 0

                                                            console.log(index)
                                                            console.log(pageIndex)

                                                            var itemType = item.type; // question or statement
                                                            var htmlContent = '';
                                                            let storageUrl = "{{ asset('storage/') }}";

                                                            if (itemType === 'question') {
                                                                let optionsHtml = '',
                                                            optionsHtml_ar = '';

                                                            if (!item.content.options || item.content.options.length ===
                                                            0) {
                                                                item.content.options = [{
                                                                    option_text: '',
                                                                    is_correct: false
                                                                },
                                                                {
                                                                    option_text: '',
                                                                    is_correct: false
                                                                },
                                                                {
                                                                    option_text: '',
                                                                    is_correct: false
                                                                },
                                                                {
                                                                    option_text: '',
                                                                    is_correct: false
                                                                }
                                                                ];
                                    }

                                    if (item.content.options && item.content.options.length > 0) {
                                                                item.content.options.forEach((option, optionIndex) => {
                                                                    optionsHtml += `
                                                        <div class="form-group mb-1 row col-md-12">
                                                            <div class="input-group pl-1">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> {{ __('lms.Option') }}  ${optionIndex + 1}: </span>
                                                                </div>
                                                                <input type="text" value="${option.option_text || ''}"
                                                                    name="items[${pageIndex}][options][]"
                                                                    class="form-control"
                                                                    placeholder="Enter an answer option" maxlength="350">
                                                                <div class="input-group-append">
                                                                    <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio"
                                                                                id="option_${pageIndex}_${optionIndex}"
                                                                                name="items[${pageIndex}][correct_answer]"
                                                                                value="${option.option_text}"
                                                                                class="custom-control-input correct_answer"
                                                                                ${option.is_correct ? 'checked' : ''}>
                                                                            <label class="custom-control-label" for="option_${pageIndex}_${optionIndex}">{{ __('lms.Answer') }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `;

                                                                    optionsHtml_ar += `
                                                        <div class="form-group mb-1 row col-md-12">
                                                            <div class="input-group pl-1">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> {{ __('lms.Option Arabic') }}  ${optionIndex + 1}: </span>
                                                                </div>
                                                                <input type="text" value="${option.option_text_ar || ''}"
                                                                    name="items[${pageIndex}][options_ar][]"
                                                                    class="form-control"
                                                                    placeholder="Enter an answer option" maxlength="350">
                                                                <div class="input-group-append">
                                                                    <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio"

                                                                                id="option_${pageIndex}_${optionIndex}"
                                                                                name="items[${pageIndex}][correct_answer_ar]"
                                                                                value="${option.option_text_ar}"
                                                                                class="custom-control-input correct_answer"
                                                                                ${option.is_correct ? 'checked' : ''}>
                                                                            <label class="custom-control-label" for="option_${pageIndex}_${optionIndex}">{{ __('lms.Answer Arabic') }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `;
                                                                });
                                    }

                                                            htmlContent = `
                                                            <div class="col-sm-4">
                                                                <div class="d-flex justify-content-center">
                                                                    <h4 class="text-secondary main-head-content"><span>Page ${item.content.page_number}</span> - {{ __('lms.Question') }} </h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="button" class="btn btn-warning me-2 edit_after_append_question"> {{ __('lms.Add Question') }} </button>
                                                                    <button type="button" class="btn btn-danger me-2 edit_remove_question"> {{ __('lms.Remove Question') }} </button>
                                                                    <button type="button" class="btn btn-info me-2 edit_after_append_statement"> {{ __('lms.Add Statement') }} </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 row edit-main-statement-content">
                                                                <input type="hidden" class="question_id" name="items[${pageIndex}][question_id]" value="${item.content.id}">
                                                                    <input type="hidden" class="page_number" name="items[${pageIndex}][page_number]" value="${item.content.page_number}">
                                                                        <input type="hidden" class="item_type" name="items[${pageIndex}][type]" value="question">


                                                                            <div class="row col-sm-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label for="question">{{ __('lms.Question English') }}:</label>
                                                                                    <input type="text" required class="form-control question" name="items[${pageIndex}][question]" value="${item.content.question}" placeholder="Enter a question title English">
                                                                                        <span class="emptyCommingError trainError-items-${pageIndex}-question text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row col-sm-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
                                                                                    <input type="text" required class="form-control question" name="items[${pageIndex}][question_ar]" value="${item.content.question_ar}" placeholder="Enter a question title Arabic">
                                                                                        <span class="emptyCommingError trainError-items-${pageIndex}-question_ar text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group mb-3">
                                                                                <label for="question_type">{{ __('lms.Question Type') }}:</label>
                                                                                <select class="form-control edit_question_type" name="items[${pageIndex}][question_type]">
                                                                                    <option value="multi_choise" ${item.content.question_type === 'multi_choise' ? 'selected' : ''}> {{ __('lms.Multi Choice') }}</option>
                                                                                    <option value="true_or_false" ${item.content.question_type === 'true_or_false' ? 'selected' : ''}>{{ __('lms.True or False') }}</option>
                                                                                </select>
                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-question_type text-danger"></span>
                                                                            </div>

                                                                            <div class="true-or-false-div" style="display:${item.content.question_type === 'true_or_false' ? 'block' : 'none'};">
                                                                                <label for="answer">{{ __('lms.Answer') }}</label>
                                                                                <select class="form-control" name="items[${pageIndex}][true_or_false_correct_answer]">
                                                                                    <option value="true" ${item.content.correct_answer === 'true' ? 'selected' : ''}>{{ __('lms.True') }}</option>
                                                                                    <option value="false" ${item.content.correct_answer === 'false' ? 'selected' : ''}>{{ __('lms.False') }}</option>
                                                                                </select>
                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-true_or_false_correct_answer text-danger"></span>
                                                                            </div>

                                                                            <div class="row col-sm-6">
                                                                                <div class="multi-chose-div" style="display:${item.content.question_type === 'multi_choise' ? 'block' : 'none'};">
                                                                                    ${optionsHtml}
                                                                                </div>


                                                                                <div class="form-group mb-3">
                                                                                    <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
                                                                                    <textarea type="text" class="form-control answer_description description" required rows="2" name="items[${pageIndex}][answer_description]" placeholder="Enter an answer English description">${item.content.answer_description || ''}</textarea>
                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-answer_description text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row col-sm-6">
                                                                                <div class="multi-chose-div" style="display:${item.content.question_type === 'multi_choise' ? 'block' : 'none'};">
                                                                                    ${optionsHtml_ar}
                                                                                </div>


                                                                                <div class="form-group mb-3">
                                                                                    <label for="answer_description_ar">{{ __('lms.Answer Description English') }}:</label>
                                                                                    <textarea type="text" class="form-control answer_description_ar description" required rows="2" name="items[${pageIndex}][answer_description_ar]" placeholder="Enter an answer English description">${item.content.answer_description_ar || ''}</textarea>
                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-answer_description_ar text-danger"></span>
                                                                                </div>
                                                                            </div>



                                                                        </div>`;

                                                                        $('#edit-main-statement-or-question-operation').append(
                                                                        htmlContent);
                                } else if (itemType === 'statement') {
                                                                            htmlContent = `
                                                <div class="col-sm-4">
                                                    <div class="d-flex justify-content-center">
                                                        <h4 class="text-secondary main-head-content"><span> Page ${item.content.page_number}</span> - {{ __('lms.Statement') }} </h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-warning me-2 edit_after_append_question"> {{ __('lms.Add Question') }} </button>
                                                        <button type="button" class="btn btn-info me-2 edit_after_append_statement"> {{ __('lms.Add Statement') }} </button>
                                                        <button type="button" class="btn btn-danger edit_remove_statement"> {{ __('lms.Remove Statement') }} </button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 row edit-main-statement-content">
                                                    <input type="hidden" class="statement_id" name="items[${pageIndex}][statement_id]" value="${item.content.id}">
                                                    <input type="hidden" class="page_number" name="items[${pageIndex}][page_number]" value="${item.content.page_number}">
                                                    <input type="hidden" class="item_type" name="items[${pageIndex}][type]" value="statement">

                                                    <div class="row col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <label
                                                                for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                                                            <input type="text"  class="form-control statement_title"
                                                                name="items[${pageIndex}][statement_title]"
                                                                value="${item.content.title}"
                                                                placeholder="{{ __('lms.Statement Title English') }}"
                                                                id="item-0">
                                                            <span
                                                                class="emptyCommingError trainError-items-${pageIndex}-statement_title text-danger"></span>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label
                                                                for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                                                           <textarea  class="form-control statement_content"
                                                                name="items[${pageIndex}][statement_content]"
                                                                placeholder="{{ __('lms.Statement Content English') }}">${item.content.content}</textarea>

                                                            <span
                                                                class="emptyCommingError trainError-items-${pageIndex}-statement_content text-danger"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <label
                                                                for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                                                            <input type="text"  class="form-control statement_title_ar"
                                                                name="items[${pageIndex}][statement_title_ar]"
                                                                value="${item.content.title_ar}"
                                                                placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                                            <span
                                                                class="emptyCommingError trainError-items-${pageIndex}-statement_title_ar text-danger"></span>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label
                                                                for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                                                           <textarea  class="form-control statement_content_ar"
                                                                name="items[${pageIndex}][statement_content_ar]"
                                                                placeholder="{{ __('lms.Statement Content Arabic') }}">${item.content.content_ar}</textarea>

                                                            <span
                                                                class="emptyCommingError trainError-items-${pageIndex}-statement_content_ar text-danger"></span>

                                                        </div>

                                                    </div>


                                                    <div class="form-group mb-3">
                                                        <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                                                        <select class="form-control edit_additional_content"
                                                            name="items[${pageIndex}][additional_content]">
                                                            <option value="no" ${item.content.additional_content === 'no' ? 'selected' : ''}> {{ __('lms.No Additional Content') }} </option>
                                                            <option value="video" ${item.content.additional_content === 'video' ? 'selected' : ''}> {{ __('lms.Embedded Video Url') }} </option>
                                                            <option value="image" ${item.content.additional_content === 'image' ? 'selected' : ''}> {{ __('lms.Embedded Image Content') }} </option>
                                                        </select>
                                                        <span class="emptyCommingError trainError-items-${pageIndex}-additional_content text-danger"></span>
                                                    </div>

                                                    <div class="row col-sm-6">
                                                        <div class="col-sm-12 form-group mb-3 video-embedded-en"
                                                            style="display: ${item.content.additional_content === 'video' ? 'block' : 'none'};">
                                                            <label for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                                                            <input type="file"  accept="video/*" class="form-control video_url_en"
                                                                name="items[${pageIndex}][video_url_en]"
                                                                placeholder="{{ __('lms.Embedded Video URL English') }}">

                                                                <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                                <span class="text-success video_en_upload_status"></span>
                                                                <input type="hidden" class="video_url_en_path" name="items[${pageIndex}][video_url_en_path]">

                                                            <video class="videoStatement my-3" style="width: 100%;" controls  height="300px">
                                                                <source src="${storageUrl}/${item.content.video_or_image_url_en}" type="video/mp4">
                                                            </video>
                                                            <span class="emptyCommingError trainError-items-${pageIndex}-video_url_en text-danger"></span>
                                                        </div>

                                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                            style="display: ${item.content.additional_content === 'image' ? 'block' : 'none'};">
                                                            <div class="col-sm-12">
                                                                <label for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                                                <input type="file" accept="image/*" class="form-control image"
                                                                    name="items[${pageIndex}][image]"
                                                                    placeholder="{{ __('lms.Choose Statement Image English') }}">
                                                                <span class="emptyCommingError trainError-items-${pageIndex}-image text-danger"></span>
                                                                <img src="${storageUrl}/${item.content.image}" alt="no image" style="width: 100%;" height="300px" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row col-sm-6">
                                                        <div class="col-sm-12 form-group mb-3 video-embedded" style="display: ${item.content.additional_content === 'video' ? 'block' : 'none'};">
                                                            <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                                            <input type="file" accept="video/*" class="form-control video_url"
                                                                name="items[${pageIndex}][video_url]"
                                                                placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                                                <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                                <span class="text-success video_upload_status"></span>
                                                                <input type="hidden" class="video_url_ar_path" name="items[${pageIndex}][video_url_ar_path]">



                                                            <video class="videoStatement my-3" style="width: 100%;" controls  height="300px">
                                                                <source src="${storageUrl}/${item.content.video_or_image_url}" type="video/mp4">
                                                            </video>
                                                            <span class="emptyCommingError trainError-items-${pageIndex}-video_url text-danger"></span>
                                                        </div>

                                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                            style="display: ${item.content.additional_content === 'image' ? 'block' : 'none'};">
                                                            <div class="col-sm-12">
                                                                <label for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                                                <input type="file" accept="image/*" class="form-control image"
                                                                    name="items[${pageIndex}][image_ar]"
                                                                    placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                                <span class="emptyCommingError trainError-items-${pageIndex}-image_ar text-danger"></span>
                                                                <img src="${storageUrl}/${item.content.image_ar}" alt="no image" style="width: 100%;" height="300px" />
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                            `;
                                                                        $('#edit-main-statement-or-question-operation').append(htmlContent)
                                                                        $('#edit-main-statement-or-question-operation')
                                                                        .find('textarea')
                                                                        .each(function () {
                                            if (!$(this).data('ckeditor-initialized')) {
                                                                            CKEDITOR.replace(this);
                                                                        $(this).data('ckeditor-initialized', true);
                                            }
                                        });
                                }

                                                                        reclculateEditCounts();
                                                                        // Append the generated HTML
                                                                        $('#training-content').append(htmlContent);
                            });
                        }
                    },
                                                                        error: function (xhr, status, error) {
                                                                            console.log("Error fetching training module data.");
                    }
                });


                                                                        $('#edit_training_module_modal').modal('show');

                    });*/


    $(document).on('click', '.edit_training_module_id', function() {
        console.log('train id is: ' + $(this).attr('data-id'));
        var editForm = $('#edit-training-module');
        var trainingModuleId = $(this).attr('data-id');

        // Helper function to handle null values
        function sanitizeValue(value) {
            return (value === null || value === 'null' || value === undefined || value === 'undefined' ||
                value === '') ? '' : value;
        }

        // Set up the form with existing values - sanitize null values
        editForm.find('#edit_train_level_id').val(trainingModuleId);
        editForm.find('#edit_level_id').val($(this).attr('data-section-id'));
        editForm.find('#title').val(sanitizeValue($(this).attr('data-name')));
        editForm.find('#passing_score').val(sanitizeValue($(this).attr('data-passing_score')));
        editForm.find('#module_order').val(sanitizeValue($(this).attr('data-order')));
        editForm.find('#cover_image_url').val(sanitizeValue($(this).attr('data-cover_image_url')));
        editForm.find('#completion_time').val(sanitizeValue($(this).attr('data-completion_time')));
        editForm.find('#training_type').val(sanitizeValue($(this).attr('data-training_type')));
        editForm.find('#count_of_entering_exam').val(sanitizeValue($(this).attr('data-count_of_entering_exam')));
        editForm.find('#survey_id').val(sanitizeValue($(this).attr('data-survey_id')));

        $.ajax({
            url: "{{ route('admin.lms.trainingModules.compliances', ':id') }}".replace(':id',
                trainingModuleId),
            method: 'GET',
            success: function(data) {
                const selectedCompliances = data.compliances;
                console.log('selectedCompliances')
                console.log(selectedCompliances)

                editForm.find('#compliance_mapping option').each(function() {
                    if (selectedCompliances.includes(parseInt($(this).val()))) {
                        $(this).prop('selected', true);
                    }
                });
                editForm.find('#compliance_mapping').select2();
            }
        });

        let url = "{{ route('admin.lms.trainingModules.edit', ':id') }}".replace(':id', trainingModuleId);

        $.ajax({
            url: url,
            type: "GET",
            success: function(data) {
                if (data && data.status) {
                    console.log(data);
                    $('#edit-main-statement-or-question-operation').empty();

                    // Iterate over the training module contents
                    $.each(data.training_module, function(index, item) {
                        var pageIndex = item.content.page_number - 1;
                        var itemType = item.type;
                        var htmlContent = '';
                        let storageUrl = "{{ asset('storage/') }}";

                        if (itemType === 'question') {
                            let optionsHtml = '',
                                optionsHtml_ar = '';

                            if (!item.content.options || item.content.options.length ===
                                0) {
                                item.content.options = [{
                                        option_text: '',
                                        is_correct: false
                                    },
                                    {
                                        option_text: '',
                                        is_correct: false
                                    },
                                    {
                                        option_text: '',
                                        is_correct: false
                                    },
                                    {
                                        option_text: '',
                                        is_correct: false
                                    }
                                ];
                            }

                            if (item.content.options && item.content.options.length > 0) {
                                item.content.options.forEach((option, optionIndex) => {
                                    optionsHtml += `
                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> {{ __('lms.Option') }}  ${optionIndex + 1}: </span>
                                                        </div>
                                                        <input type="text" value="${sanitizeValue(option.option_text)}"
                                                            name="items[${pageIndex}][options][]"
                                                            class="form-control"
                                                            placeholder="Enter an answer option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"
                                                                        id="option_${pageIndex}_${optionIndex}"
                                                                        name="items[${pageIndex}][correct_answer]"
                                                                        value="${sanitizeValue(option.option_text)}"
                                                                        class="custom-control-input correct_answer"
                                                                        ${option.is_correct ? 'checked' : ''}>
                                                                    <label class="custom-control-label" for="option_${pageIndex}_${optionIndex}">{{ __('lms.Answer') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;

                                    optionsHtml_ar += `
                                                <div class="form-group mb-1 row col-md-12">
                                                    <div class="input-group pl-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> {{ __('lms.Option Arabic') }}  ${optionIndex + 1}: </span>
                                                        </div>
                                                        <input type="text" value="${sanitizeValue(option.option_text_ar)}"
                                                            name="items[${pageIndex}][options_ar][]"
                                                            class="form-control"
                                                            placeholder="Enter an answer option" maxlength="350">
                                                        <div class="input-group-append">
                                                            <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio"
                                                                        id="option_${pageIndex}_${optionIndex}"
                                                                        name="items[${pageIndex}][correct_answer_ar]"
                                                                        value="${sanitizeValue(option.option_text_ar)}"
                                                                        class="custom-control-input correct_answer"
                                                                        ${option.is_correct ? 'checked' : ''}>
                                                                    <label class="custom-control-label" for="option_${pageIndex}_${optionIndex}">{{ __('lms.Answer Arabic') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                });
                            }

                            htmlContent = `
                                                                            <div class="col-sm-4">
                                                                                <div class="d-flex justify-content-center">
                                                                                    <h4 class="text-secondary main-head-content"><span>Page ${item.content.page_number}</span> - {{ __('lms.Question') }} </h4>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="d-flex justify-content-end">
                                                                                    <button type="button" class="btn btn-warning me-2 edit_after_append_question"> {{ __('lms.Add Question') }} </button>
                                                                                    <button type="button" class="btn btn-danger me-2 edit_remove_question"> {{ __('lms.Remove Question') }} </button>
                                                                                    <button type="button" class="btn btn-info me-2 edit_after_append_statement"> {{ __('lms.Add Statement') }} </button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 row edit-main-statement-content">
                                                                                <input type="hidden" class="question_id" name="items[${pageIndex}][question_id]" value="${item.content.id}">
                                                                                    <input type="hidden" class="page_number" name="items[${pageIndex}][page_number]" value="${item.content.page_number}">
                                                                                        <input type="hidden" class="item_type" name="items[${pageIndex}][type]" value="question">

                                                                                            <div class="row col-sm-6">
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="question">{{ __('lms.Question English') }}:</label>
                                                                                                    <input type="text" class="form-control question" name="items[${pageIndex}][question]" value="${sanitizeValue(item.content.question)}" placeholder="Enter a question title English">
                                                                                                        <span class="emptyCommingError trainError-items-${pageIndex}-question text-danger"></span>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="row col-sm-6">
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
                                                                                                    <input type="text" class="form-control question" name="items[${pageIndex}][question_ar]" value="${sanitizeValue(item.content.question_ar)}" placeholder="Enter a question title Arabic">
                                                                                                        <span class="emptyCommingError trainError-items-${pageIndex}-question_ar text-danger"></span>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group mb-3">
                                                                                                <label for="question_type">{{ __('lms.Question Type') }}:</label>
                                                                                                <select class="form-control edit_question_type" name="items[${pageIndex}][question_type]">
                                                                                                    <option value="multi_choise" ${item.content.question_type === 'multi_choise' ? 'selected' : ''}> {{ __('lms.Multi Choice') }}</option>
                                                                                                    <option value="true_or_false" ${item.content.question_type === 'true_or_false' ? 'selected' : ''}>{{ __('lms.True or False') }}</option>
                                                                                                </select>
                                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-question_type text-danger"></span>
                                                                                            </div>

                                                                                            <div class="true-or-false-div" style="display:${item.content.question_type === 'true_or_false' ? 'block' : 'none'};">
                                                                                                <label for="answer">{{ __('lms.Answer') }}</label>
                                                                                                <select class="form-control" name="items[${pageIndex}][true_or_false_correct_answer]">
                                                                                                    <option value="true" ${item.content.correct_answer === 'true' ? 'selected' : ''}>{{ __('lms.True') }}</option>
                                                                                                    <option value="false" ${item.content.correct_answer === 'false' ? 'selected' : ''}>{{ __('lms.False') }}</option>
                                                                                                </select>
                                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-true_or_false_correct_answer text-danger"></span>
                                                                                            </div>

                                                                                            <div class="row col-sm-6">
                                                                                                <div class="multi-chose-div" style="display:${item.content.question_type === 'multi_choise' ? 'block' : 'none'};">
                                                                                                    ${optionsHtml}
                                                                                                </div>

                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
                                                                                                    <textarea type="text" class="form-control answer_description description" rows="2" name="items[${pageIndex}][answer_description]" placeholder="Enter an answer English description">${sanitizeValue(item.content.answer_description)}</textarea>
                                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-answer_description text-danger"></span>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="row col-sm-6">
                                                                                                <div class="multi-chose-div" style="display:${item.content.question_type === 'multi_choise' ? 'block' : 'none'};">
                                                                                                    ${optionsHtml_ar}
                                                                                                </div>

                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="answer_description_ar">{{ __('lms.Answer Description Arabic') }}:</label>
                                                                                                    <textarea type="text" class="form-control answer_description_ar description" rows="2" name="items[${pageIndex}][answer_description_ar]" placeholder="Enter an answer Arabic description">${sanitizeValue(item.content.answer_description_ar)}</textarea>
                                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-answer_description_ar text-danger"></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>`;

                            $('#edit-main-statement-or-question-operation').append(
                                htmlContent);

                        } else if (itemType === 'statement') {
                            // Handle image and video URLs
                            const imageUrl = sanitizeValue(item.content.image) ?
                                `${storageUrl}/${item.content.image}` : '';
                            const imageUrlAr = sanitizeValue(item.content.image_ar) ?
                                `${storageUrl}/${item.content.image_ar}` : '';
                            const videoUrlEn = sanitizeValue(item.content
                                    .video_or_image_url_en) ?
                                `${storageUrl}/${item.content.video_or_image_url_en}` : '';
                            const videoUrlAr = sanitizeValue(item.content
                                    .video_or_image_url) ?
                                `${storageUrl}/${item.content.video_or_image_url}` : '';

                            htmlContent = `
                                                                                        <div class="col-sm-4">
                                                                                            <div class="d-flex justify-content-center">
                                                                                                <h4 class="text-secondary main-head-content"><span> Page ${item.content.page_number}</span> - {{ __('lms.Statement') }} </h4>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="d-flex justify-content-end">
                                                                                                <button type="button" class="btn btn-warning me-2 edit_after_append_question"> {{ __('lms.Add Question') }} </button>
                                                                                                <button type="button" class="btn btn-info me-2 edit_after_append_statement"> {{ __('lms.Add Statement') }} </button>
                                                                                                <button type="button" class="btn btn-danger edit_remove_statement"> {{ __('lms.Remove Statement') }} </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 row edit-main-statement-content">
                                                                                            <input type="hidden" class="statement_id" name="items[${pageIndex}][statement_id]" value="${item.content.id}">
                                                                                                <input type="hidden" class="page_number" name="items[${pageIndex}][page_number]" value="${item.content.page_number}">
                                                                                                    <input type="hidden" class="item_type" name="items[${pageIndex}][type]" value="statement">

                                                                                                        <div class="row col-sm-6">
                                                                                                            <div class="form-group mb-3">
                                                                                                                <label for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                                                                                                                <input type="text" class="form-control statement_title"
                                                                                                                    name="items[${pageIndex}][statement_title]"
                                                                                                                    value="${sanitizeValue(item.content.title)}"
                                                                                                                    placeholder="{{ __('lms.Statement Title English') }}"
                                                                                                                    id="item-0">
                                                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-statement_title text-danger"></span>
                                                                                                            </div>

                                                                                                            <div class="form-group mb-3">
                                                                                                                <label for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                                                                                                                <textarea class="form-control statement_content"
                                                                                                                    name="items[${pageIndex}][statement_content]"
                                                                                                                    placeholder="{{ __('lms.Statement Content English') }}">${sanitizeValue(item.content.content)}</textarea>
                                                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-statement_content text-danger"></span>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="row col-sm-6">
                                                                                                            <div class="form-group mb-3">
                                                                                                                <label for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                                                                                                                <input type="text" class="form-control statement_title_ar"
                                                                                                                    name="items[${pageIndex}][statement_title_ar]"
                                                                                                                    value="${sanitizeValue(item.content.title_ar)}"
                                                                                                                    placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-statement_title_ar text-danger"></span>
                                                                                                            </div>

                                                                                                            <div class="form-group mb-3">
                                                                                                                <label for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                                                                                                                <textarea class="form-control statement_content_ar"
                                                                                                                    name="items[${pageIndex}][statement_content_ar]"
                                                                                                                    placeholder="{{ __('lms.Statement Content Arabic') }}">${sanitizeValue(item.content.content_ar)}</textarea>
                                                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-statement_content_ar text-danger"></span>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="form-group mb-3">
                                                                                                            <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                                                                                                            <select class="form-control edit_additional_content"
                                                                                                                name="items[${pageIndex}][additional_content]">
                                                                                                                <option value="no" ${item.content.additional_content === 'no' ? 'selected' : ''}> {{ __('lms.No Additional Content') }} </option>
                                                                                                                <option value="video" ${item.content.additional_content === 'video' ? 'selected' : ''}> {{ __('lms.Embedded Video Url') }} </option>
                                                                                                                <option value="image" ${item.content.additional_content === 'image' ? 'selected' : ''}> {{ __('lms.Embedded Image Content') }} </option>
                                                                                                            </select>
                                                                                                            <span class="emptyCommingError trainError-items-${pageIndex}-additional_content text-danger"></span>
                                                                                                        </div>

                                                                                                        <div class="row col-sm-6">
                                                                                                            <div class="col-sm-12 form-group mb-3 video-embedded-en"
                                                                                                                style="display: ${item.content.additional_content === 'video' ? 'block' : 'none'};">
                                                                                                                <label for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                                                                                                                <input type="file" accept="video/*" class="form-control video_url_en"
                                                                                                                    name="items[${pageIndex}][video_url_en]"
                                                                                                                    placeholder="{{ __('lms.Embedded Video URL English') }}">

                                                                                                                    <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                                                                                    <span class="text-success video_en_upload_status"></span>
                                                                                                                    <input type="hidden" class="video_url_en_path" name="items[${pageIndex}][video_url_en_path]">

                                                                                                                        ${videoUrlEn ? `<video class="videoStatement my-3" style="width: 100%;" controls height="300px">
                                                        <source src="${videoUrlEn}" type="video/mp4">
                                                    </video>` : ''}
                                                                                                                        <span class="emptyCommingError trainError-items-${pageIndex}-video_url_en text-danger"></span>
                                                                                                                    </div>

                                                                                                                    <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                                                                                        style="display: ${item.content.additional_content === 'image' ? 'block' : 'none'};">
                                                                                                                        <div class="col-sm-12">
                                                                                                                            <label for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                                                                                                            <input type="file" accept="image/*" class="form-control image"
                                                                                                                                name="items[${pageIndex}][image]"
                                                                                                                                placeholder="{{ __('lms.Choose Statement Image English') }}">
                                                                                                                                <span class="emptyCommingError trainError-items-${pageIndex}-image text-danger"></span>
                                                                                                                                ${imageUrl ? `<img src="${imageUrl}" alt="no image" style="width: 100%;" height="300px" />` : ''}
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                            </div>

                                                                                                            <div class="row col-sm-6">
                                                                                                                <div class="col-sm-12 form-group mb-3 video-embedded" style="display: ${item.content.additional_content === 'video' ? 'block' : 'none'};">
                                                                                                                    <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                                                                                                    <input type="file" accept="video/*" class="form-control video_url"
                                                                                                                        name="items[${pageIndex}][video_url]"
                                                                                                                        placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                                                                                                        <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                                                                                                        <span class="text-success video_upload_status"></span>
                                                                                                                        <input type="hidden" class="video_url_ar_path" name="items[${pageIndex}][video_url_ar_path]">

                                                                                                                            ${videoUrlAr ? `<video class="videoStatement my-3" style="width: 100%;" controls height="300px">
                                                        <source src="${videoUrlAr}" type="video/mp4">
                                                    </video>` : ''}
                                                                                                                            <span class="emptyCommingError trainError-items-${pageIndex}-video_url text-danger"></span>
                                                                                                                        </div>

                                                                                                                        <div class="col-sm-12 row form-group mb-3 image-embedded"
                                                                                                                            style="display: ${item.content.additional_content === 'image' ? 'block' : 'none'};">
                                                                                                                            <div class="col-sm-12">
                                                                                                                                <label for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                                                                                                                <input type="file" accept="image/*" class="form-control image"
                                                                                                                                    name="items[${pageIndex}][image_ar]"
                                                                                                                                    placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                                                                                                    <span class="emptyCommingError trainError-items-${pageIndex}-image_ar text-danger"></span>
                                                                                                                                    ${imageUrlAr ? `<img src="${imageUrlAr}" alt="no image" style="width: 100%;" height="300px" />` : ''}
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            `;

                            $('#edit-main-statement-or-question-operation').append(
                                htmlContent)
                            $('#edit-main-statement-or-question-operation')
                                .find('textarea')
                                .each(function() {
                                    if (!$(this).data('ckeditor-initialized')) {
                                        CKEDITOR.replace(this);
                                        $(this).data('ckeditor-initialized', true);
                                    }
                                });
                        }

                        reclculateEditCounts();
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("Error fetching training module data.");
            }
        });

        $('#edit_training_module_modal').modal('show');
    });

    $(document).on('click', '.edit_remove_question,.edit_remove_statement', function() {
        $(this).closest('.col-sm-8').prev('.col-sm-4').remove();
        $(this).closest('.col-sm-8').next('.col-sm-12').remove();
        $(this).closest('.col-sm-8').remove();

        // after we should update indexes
        $('#edit-main-statement-or-question-operation .col-sm-4').each(function(index) {
            $(this).find('h4 span').text(`Page ${index + 1} `);
        });
        reclculateEditCounts();
    });

    function reclculateEditCounts() {
        $('#edit_total_questions').text($('#edit-main-statement-or-question-operation select.edit_question_type')
            .length);
        $('#edit_total_statements').text($('#edit-main-statement-or-question-operation select.edit_additional_content')
            .length);
        $('#edit_total_pages').text($('#edit-main-statement-or-question-operation .col-sm-4').length);
    }

    // Add Question on the last
    // $(document).on('click', '.edit_after_append_question', function() {
    //     let pageIndex = $('#edit-main-statement-or-question-operation .col-sm-4').length;
    //     let index = $('#edit-main-statement-or-question-operation .edit-main-statement-content').length;
    //     $('#edit-main-statement-or-question-operation').append(`

    //                                                                                                         <div class="col-sm-4">
    //                                                                                                             <div class="d-flex justify-content-center">
    //                                                                                                                 <h4 class="text-secondary main-head-content"><span>Page ${pageIndex + 1} </span> - {{ __('lms.Question') }} </h4>
    //                                                                                                             </div>
    //                                                                                                         </div>

    //                                                                                                         <div class="col-sm-8">
    //                                                                                                             <div class="d-flex justify-content-end">
    //                                                                                                                 <button type="button" class="btn btn-warning me-2 edit_after_append_question"> {{ __('lms.Add Question') }} </button>
    //                                                                                                                 <button type="button" class="btn btn-danger me-2 edit_remove_question"> {{ __('lms.Remove Question') }} </button>
    //                                                                                                                 <button type="button" class="btn btn-info me-2 edit_after_append_statement"> {{ __('lms.Add Statement') }} </button>
    //                                                                                                             </div>
    //                                                                                                         </div>

    //                                                                                                         <div class="col-sm-12 row edit-main-statement-content">
    //                                                                                                             <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
    //                                                                                                                 <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

    //                                                                                                                     <div class="row col-sm-6">
    //                                                                                                                         <div class="form-group mb-3">
    //                                                                                                                             <label for="question">{{ __('lms.Question English') }}:</label>
    //                                                                                                                             <input type="text" class="form-control question" name="items[${index}][question]" placeholder="Enter a question title English">
    //                                                                                                                                 <span class="emptyCommingError trainError-items-${index}-question text-danger"></span>
    //                                                                                                                         </div>

    //                                                                                                                     </div>

    //                                                                                                                     <div class="row col-sm-6">
    //                                                                                                                         <div class="form-group mb-3">
    //                                                                                                                             <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
    //                                                                                                                             <input type="text" class="form-control question" name="items[${index}][question_ar]" placeholder="Enter a question title Arabic">
    //                                                                                                                                 <span class="emptyCommingError trainError-items-${index}-question_ar text-danger"></span>
    //                                                                                                                         </div>
    //                                                                                                                     </div>

    //                                                                                                                     <div class="form-group mb-3">
    //                                                                                                                         <label for="question_type">{{ __('lms.Question Type') }}:</label>
    //                                                                                                                         <select class="form-control edit_question_type" name="items[${index}][question_type]">
    //                                                                                                                             <option value="multi_choise" selected> {{ __('lms.Multi Choice') }}</option>
    //                                                                                                                             <option value="true_or_false">{{ __('lms.True or False') }}</option>
    //                                                                                                                         </select>
    //                                                                                                                         <span class="emptyCommingError trainError-items-${index}-question_type text-danger"></span>
    //                                                                                                                     </div>

    //                                                                                                                     <div class="true-or-false-div" style="display:none;">
    //                                                                                                                         <label for="answer">Answer</label>
    //                                                                                                                         <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
    //                                                                                                                             <option value="true" selected>{{ __('lms.True') }}</option>
    //                                                                                                                             <option value="false">{{ __('lms.False') }}</option>
    //                                                                                                                         </select>
    //                                                                                                                         <span class="emptyCommingError trainError-items-${index}-true_or_false_correct_answer text-danger"></span>
    //                                                                                                                     </div>

    //                                                                                                                     <div class="row col-sm-6">
    //                                                                                                                         <div class="multi-chose-div">
    //                                                                                                                             <div class="form-group mb-1 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option') }} 1: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption21" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option21" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option21">{{ __('lms.Answer') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>

    //                                                                                                                             <div class="form-group mb-1 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option') }} 2: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption22" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option22" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option22">{{ __('lms.Answer') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>

    //                                                                                                                             <div class="form-group mb-1 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option') }} 3: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption23" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option23" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option23">{{ __('lms.Answer') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>

    //                                                                                                                             <div class="form-group mb-2 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option') }} 4: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption24" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option24" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option24">{{ __('lms.Answer') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>
    //                                                                                                                             <span class="emptyCommingError trainError-items-${index}-correct_answer text-danger"></span>
    //                                                                                                                         </div>


    //                                                                                                                         <div class="form-group mb-3">
    //                                                                                                                             <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
    //                                                                                                                             <textarea type="text" class="form-control answer_description description" rows="2" name="items[${index}][answer_description]" placeholder="Enter an answer English description"></textarea>
    //                                                                                                                             <span class="emptyCommingError trainError-items-${index}-answer_description text-danger"></span>
    //                                                                                                                         </div>

    //                                                                                                                     </div>

    //                                                                                                                     <div class="row col-sm-6">
    //                                                                                                                         <div class="multi-chose-div">
    //                                                                                                                             <div class="form-group mb-1 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option Arabic') }} 1: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption21" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option Arabic" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option21" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option21">{{ __('lms.Answer Arabic') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>

    //                                                                                                                             <div class="form-group mb-1 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option Arabic') }} 2: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption22" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option22" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option22">{{ __('lms.Answer Arabic') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>

    //                                                                                                                             <div class="form-group mb-1 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option Arabic') }} 3: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption23" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option23" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option23">{{ __('lms.Answer Arabic') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>

    //                                                                                                                             <div class="form-group mb-2 row col-md-12">
    //                                                                                                                                 <div class="input-group pl-1">
    //                                                                                                                                     <div class="input-group-prepend">
    //                                                                                                                                         <span class="input-group-text">{{ __('lms.Option Arabic') }} 4: </span>
    //                                                                                                                                     </div>
    //                                                                                                                                     <input id="tMQOption24" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
    //                                                                                                                                         <div class="input-group-append">
    //                                                                                                                                             <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
    //                                                                                                                                                 <div class="custom-control custom-radio">
    //                                                                                                                                                     <input type="radio" id="option24" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
    //                                                                                                                                                         <label class="custom-control-label" for="option24">{{ __('lms.Answer Arabic') }}</label>
    //                                                                                                                                                 </div>
    //                                                                                                                                             </div>
    //                                                                                                                                         </div>
    //                                                                                                                                 </div>
    //                                                                                                                             </div>
    //                                                                                                                             <span class="emptyCommingError trainError-items-${index}-correct_answer_ar text-danger"></span>
    //                                                                                                                         </div>

    //                                                                                                                         <div class="form-group mb-3">
    //                                                                                                                             <label for="answer_description_ar">{{ __('lms.Answer Description Arabic') }}:</label>
    //                                                                                                                             <textarea type="text" class="form-control answer_description_ar description" rows="2" name="items[${index}][answer_description_ar]" placeholder="Enter an answer description"></textarea>
    //                                                                                                                             <span class="emptyCommingError trainError-items-${index}-answer_description_ar text-danger"></span>
    //                                                                                                                         </div>
    //                                                                                                                     </div>

    //                                                                                                                 </div>
    //                                                                                                                 `);

    //     $('.edit-main-statement-content').each(function(i) {
    //         $(this).find('.page_number').val(i + 1);
    //     });

    //     reclculateEditCounts();
    // });



        $(document).on('click', '.edit_after_append_question', function() {
               let $btn = $(this);
            let $parentRow = $btn.closest('.col-sm-8');

        let pageIndex = $('#edit-main-statement-or-question-operation .col-sm-4').length;
        let index = $('#edit-main-statement-or-question-operation .edit-main-statement-content').length;
        let html = `

                                                                                                            <div class="col-sm-4">
                                                                                                                <div class="d-flex justify-content-center">
                                                                                                                    <h4 class="text-secondary main-head-content"><span>Page ${pageIndex + 1} </span> - {{ __('lms.Question') }} </h4>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="d-flex justify-content-end">
                                                                                                                    <button type="button" class="btn btn-warning me-2 edit_after_append_question"> {{ __('lms.Add Question') }} </button>
                                                                                                                    <button type="button" class="btn btn-danger me-2 edit_remove_question"> {{ __('lms.Remove Question') }} </button>
                                                                                                                    <button type="button" class="btn btn-info me-2 edit_after_append_statement"> {{ __('lms.Add Statement') }} </button>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <div class="col-sm-12 row edit-main-statement-content">
                                                                                                                <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                                                                                                    <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

                                                                                                                        <div class="row col-sm-6">
                                                                                                                            <div class="form-group mb-3">
                                                                                                                                <label for="question">{{ __('lms.Question English') }}:</label>
                                                                                                                                <input type="text" class="form-control question" name="items[${index}][question]" placeholder="Enter a question title English">
                                                                                                                                    <span class="emptyCommingError trainError-items-${index}-question text-danger"></span>
                                                                                                                            </div>

                                                                                                                        </div>

                                                                                                                        <div class="row col-sm-6">
                                                                                                                            <div class="form-group mb-3">
                                                                                                                                <label for="question_ar">{{ __('lms.Question Arabic') }}:</label>
                                                                                                                                <input type="text" class="form-control question" name="items[${index}][question_ar]" placeholder="Enter a question title Arabic">
                                                                                                                                    <span class="emptyCommingError trainError-items-${index}-question_ar text-danger"></span>
                                                                                                                            </div>
                                                                                                                        </div>

                                                                                                                        <div class="form-group mb-3">
                                                                                                                            <label for="question_type">{{ __('lms.Question Type') }}:</label>
                                                                                                                            <select class="form-control edit_question_type" name="items[${index}][question_type]">
                                                                                                                                <option value="multi_choise" selected> {{ __('lms.Multi Choice') }}</option>
                                                                                                                                <option value="true_or_false">{{ __('lms.True or False') }}</option>
                                                                                                                            </select>
                                                                                                                            <span class="emptyCommingError trainError-items-${index}-question_type text-danger"></span>
                                                                                                                        </div>

                                                                                                                        <div class="true-or-false-div" style="display:none;">
                                                                                                                            <label for="answer">Answer</label>
                                                                                                                            <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
                                                                                                                                <option value="true" selected>{{ __('lms.True') }}</option>
                                                                                                                                <option value="false">{{ __('lms.False') }}</option>
                                                                                                                            </select>
                                                                                                                            <span class="emptyCommingError trainError-items-${index}-true_or_false_correct_answer text-danger"></span>
                                                                                                                        </div>

                                                                                                                        <div class="row col-sm-6">
                                                                                                                            <div class="multi-chose-div">
                                                                                                                                <div class="form-group mb-1 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option') }} 1: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption21" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option21" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option21">{{ __('lms.Answer') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="form-group mb-1 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option') }} 2: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption22" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option22" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option22">{{ __('lms.Answer') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="form-group mb-1 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option') }} 3: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption23" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option23" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option23">{{ __('lms.Answer') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="form-group mb-2 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option') }} 4: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption24" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer English option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option24" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option24">{{ __('lms.Answer') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <span class="emptyCommingError trainError-items-${index}-correct_answer text-danger"></span>
                                                                                                                            </div>


                                                                                                                            <div class="form-group mb-3">
                                                                                                                                <label for="answer_description">{{ __('lms.Answer Description English') }}:</label>
                                                                                                                                <textarea type="text" class="form-control answer_description description" rows="2" name="items[${index}][answer_description]" placeholder="Enter an answer English description"></textarea>
                                                                                                                                <span class="emptyCommingError trainError-items-${index}-answer_description text-danger"></span>
                                                                                                                            </div>

                                                                                                                        </div>

                                                                                                                        <div class="row col-sm-6">
                                                                                                                            <div class="multi-chose-div">
                                                                                                                                <div class="form-group mb-1 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 1: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption21" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option Arabic" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option21" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option21">{{ __('lms.Answer Arabic') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="form-group mb-1 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 2: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption22" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option22" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option22">{{ __('lms.Answer Arabic') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="form-group mb-1 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 3: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption23" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option23" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option23">{{ __('lms.Answer Arabic') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="form-group mb-2 row col-md-12">
                                                                                                                                    <div class="input-group pl-1">
                                                                                                                                        <div class="input-group-prepend">
                                                                                                                                            <span class="input-group-text">{{ __('lms.Option Arabic') }} 4: </span>
                                                                                                                                        </div>
                                                                                                                                        <input id="tMQOption24" type="text" name="items[${index}][options_ar][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                            <div class="input-group-append">
                                                                                                                                                <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                    <div class="custom-control custom-radio">
                                                                                                                                                        <input type="radio" id="option24" name="items[${index}][correct_answer_ar]" class="custom-control-input correct_answer">
                                                                                                                                                            <label class="custom-control-label" for="option24">{{ __('lms.Answer Arabic') }}</label>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <span class="emptyCommingError trainError-items-${index}-correct_answer_ar text-danger"></span>
                                                                                                                            </div>

                                                                                                                            <div class="form-group mb-3">
                                                                                                                                <label for="answer_description_ar">{{ __('lms.Answer Description Arabic') }}:</label>
                                                                                                                                <textarea type="text" class="form-control answer_description_ar description" rows="2" name="items[${index}][answer_description_ar]" placeholder="Enter an answer description"></textarea>
                                                                                                                                <span class="emptyCommingError trainError-items-${index}-answer_description_ar text-danger"></span>
                                                                                                                            </div>
                                                                                                                        </div>

                                                                                                                    </div>
                                                                                                                    `;




         $parentRow.next('.edit-main-statement-content').length ?
            $parentRow.next('.edit-main-statement-content').after(html) :
            $parentRow.after(html);

        $('#edit-main-statement-or-question-operation .col-sm-4').each(function (i) {
            $(this).find('h4 span').text(`Page ${i + 1} `);
        });
        $('#edit-main-statement-or-question-operation .edit-main-statement-content').each(function (i) {
            $(this).find('.page_number').val(i + 1);
            $(this).find('input, select, textarea').each(function () {
                let name = $(this).attr('name');
                name = name.replace(/\[\d+\]/g, `[${i}]`);
                $(this).attr('name', name);
            });
            $(this).find('.emptyCommingError').each(function () {
                let classList = $(this).attr('class');
                classList = classList.replace(/trainError-items-\d+-/, `trainError-items-${i}-`);
                $(this).attr('class', classList);
            });
        });

        reclculateEditCounts();
    });

    // Add Statement on the last
    // $(document).on('click', '.edit_after_append_statement', function() {
    //     let pageIndex = $('#edit-main-statement-or-question-operation .col-sm-4').length;
    //     let index = $('#edit-main-statement-or-question-operation .edit-main-statement-content').length;
    //     const englishId = `statement_content_${index}`;
    //     const arabicId = `statement_content_ar_${index}`;


    //     $('#edit-main-statement-or-question-operation').append(
    //         `
    //         <div class="col-sm-4">
    //             <div class="d-flex justify-content-center">
    //                 <h4 class="text-secondary main-head-content"><span>Page ${pageIndex + 1}</span> - {{ __('lms.Statement') }} </h4>
    //             </div>
    //         </div>

    //         <div class="col-sm-8">
    //             <div class="d-flex justify-content-end">
    //                 <button type="button" class="btn btn-warning me-2 edit_after_append_question" >{{ __('lms.Add Question') }} </button>
    //                 <button type="button" class="btn btn-danger me-2 edit_remove_statement" >{{ __('lms.Remove Statement') }} </button>
    //                 <button type="button" class="btn btn-info me-2 edit_after_append_statement" > {{ __('lms.Add Statement') }} </button>
    //             </div>
    //         </div>

    //         <div class="col-sm-12 row edit-main-statement-content">

    //         <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
    //             <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

    //                 <div class="row col-sm-6">
    //                     <div class="form-group mb-3">
    //                         <label
    //                             for="statement_title">{{ __('lms.Statement Title English') }}:</label>
    //                         <input type="text" class="form-control statement_title"
    //                             name="items[${index}][statement_title]"
    //                             placeholder="{{ __('lms.Statement Title English') }}"
    //                             id="item-0">
    //                             <span
    //                                 class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
    //                     </div>

    //                     <div class="form-group mb-3">
    //                         <label
    //                             for="statement_content">{{ __('lms.Statement Content English') }}:</label>
    //                         <textarea class="form-control statement_content" id="${englishId}"
    //                             name="items[${index}][statement_content]"
    //                             placeholder="{{ __('lms.Statement Content English') }}"></textarea>

    //                         <span
    //                             class="emptyCommingError trainError-items-${index}-statement_content text-danger"></span>

    //                     </div>

    //                 </div>

    //                 <div class="row col-sm-6">
    //                     <div class="form-group mb-3">
    //                         <label
    //                             for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
    //                         <input type="text" class="form-control statement_title_ar"
    //                             name="items[${index}][statement_title_ar]"
    //                             placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
    //                             <span
    //                                 class="emptyCommingError trainError-items-${index}-statement_title_ar text-danger"></span>
    //                     </div>

    //                     <div class="form-group mb-3">
    //                         <label
    //                             for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
    //                         <textarea class="form-control statement_content_ar" id="${arabicId}"
    //                             name="items[${index}][statement_content_ar]"
    //                             placeholder="{{ __('lms.Statement Content Arabic') }}"></textarea>

    //                         <span
    //                             class="emptyCommingError trainError-items-${index}-statement_content_ar text-danger"></span>

    //                     </div>

    //                 </div>


    //                 <div class="form-group mb-3">
    //                     <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
    //                     <select class="form-control edit_additional_content"
    //                         name="items[${index}][additional_content]">
    //                         <option value="no">{{ __('lms.No Additional Content') }}</option>
    //                         <option value="video">{{ __('lms.Embedded Video Url') }}</option>
    //                         <option value="image">{{ __('lms.Embedded Image Content') }}</option>
    //                     </select>
    //                     <span
    //                         class="emptyCommingError trainError-items-${index}-additional_content text-danger"></span>

    //                 </div>

    //                 <div class="row col-sm-6">
    //                     <div class="col-sm-12 form-group mb-3 video-embedded-en"
    //                         style="display: none">
    //                         <label
    //                             for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
    //                         <input type="file" accept="video/*" class="form-control video_url_en"
    //                             name="items[${index}][video_url_en]"
    //                             placeholder="{{ __('lms.Embedded Video URL English') }}">

    //                             <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
    //                             <span class="text-success video_en_upload_status"></span>
    //                             <input type="hidden" class="video_url_en_path" name="items[${index}][video_url_en_path]">

    //                                 <span
    //                                     class="emptyCommingError trainError-items-${index}-video_url_en text-danger"></span>

    //                             </div>

    //                             <div class="col-sm-12 row form-group mb-3 image-embedded"
    //                                 style="display: none">
    //                                 <div class="col-sm-12">
    //                                     <label
    //                                         for="image">{{ __('lms.Choose Statement Image English') }}</label>
    //                                     <input type="file" accept="image/*" class="form-control image"
    //                                         name="items[${index}][image]"
    //                                         placeholder="{{ __('lms.Choose Statement Image English') }}">
    //                                         <span
    //                                             class="emptyCommingError trainError-items-${index}-image text-danger"></span>

    //                                 </div>
    //                             </div>

    //                     </div>

    //                     <div class="row col-sm-6">
    //                         <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
    //                             <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
    //                             <input type="file" accept="video/*" class="form-control video_url"
    //                                 name="items[${index}][video_url]"
    //                                 placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

    //                                 <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
    //                                 <span class="text-success video_upload_status"></span>
    //                                 <input type="hidden" class="video_url_ar_path" name="items[${index}][video_url_ar_path]">


    //                                     <span
    //                                         class="emptyCommingError trainError-items-${index}-video_url text-danger"></span>

    //                                 </div>

    //                                 <div class="col-sm-12 row form-group mb-3 image-embedded"
    //                                     style="display: none">
    //                                     <div class="col-sm-12">
    //                                         <label
    //                                             for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
    //                                         <input type="file" accept="image/*" class="form-control image"
    //                                             name="items[${index}][image_ar]"
    //                                             placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
    //                                             <span
    //                                                 class="emptyCommingError trainError-items-${index}-image_ar text-danger"></span>

    //                                     </div>
    //                                 </div>


    //                         </div>
    //                     </div>
    //                     `
    //     );

    //     $('.edit-main-statement-content').each(function(i) {
    //         $(this).find('.page_number').val(i + 1);
    //     });

    //     CKEDITOR.replace(englishId);
    //     CKEDITOR.replace(arabicId);

    //     reclculateEditCounts();
    // });


     $(document).on('click', '.edit_after_append_statement', function() {
        let $btn = $(this);
        let $parentRow = $btn.closest('.col-sm-8');

        let pageIndex = $('#edit-main-statement-or-question-operation .col-sm-4').length;
        let index = $('#edit-main-statement-or-question-operation .edit-main-statement-content').length;
        const englishId = `statement_content_${index}`;
        const arabicId = `statement_content_ar_${index}`;


        let html = `
            <div class="col-sm-4">
                <div class="d-flex justify-content-center">
                    <h4 class="text-secondary main-head-content"><span>Page ${pageIndex + 1}</span> - {{ __('lms.Statement') }} </h4>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning me-2 edit_after_append_question" >{{ __('lms.Add Question') }} </button>
                    <button type="button" class="btn btn-danger me-2 edit_remove_statement" >{{ __('lms.Remove Statement') }} </button>
                    <button type="button" class="btn btn-info me-2 edit_after_append_statement" > {{ __('lms.Add Statement') }} </button>
                </div>
            </div>

            <div class="col-sm-12 row edit-main-statement-content">

            <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

                    <div class="row col-sm-6">
                        <div class="form-group mb-3">
                            <label
                                for="statement_title">{{ __('lms.Statement Title English') }}:</label>
                            <input type="text" class="form-control statement_title"
                                name="items[${index}][statement_title]"
                                placeholder="{{ __('lms.Statement Title English') }}"
                                id="item-0">
                                <span
                                    class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label
                                for="statement_content">{{ __('lms.Statement Content English') }}:</label>
                            <textarea class="form-control statement_content" id="${englishId}"
                                name="items[${index}][statement_content]"
                                placeholder="{{ __('lms.Statement Content English') }}"></textarea>

                            <span
                                class="emptyCommingError trainError-items-${index}-statement_content text-danger"></span>

                        </div>

                    </div>

                    <div class="row col-sm-6">
                        <div class="form-group mb-3">
                            <label
                                for="statement_title_ar">{{ __('lms.Statement Title Arabic') }}:</label>
                            <input type="text" class="form-control statement_title_ar"
                                name="items[${index}][statement_title_ar]"
                                placeholder="{{ __('lms.Statement Title Arabic') }}" id="item-0">
                                <span
                                    class="emptyCommingError trainError-items-${index}-statement_title_ar text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label
                                for="statement_content_ar">{{ __('lms.Statement Content Arabic') }}:</label>
                            <textarea class="form-control statement_content_ar" id="${arabicId}"
                                name="items[${index}][statement_content_ar]"
                                placeholder="{{ __('lms.Statement Content Arabic') }}"></textarea>

                            <span
                                class="emptyCommingError trainError-items-${index}-statement_content_ar text-danger"></span>

                        </div>

                    </div>


                    <div class="form-group mb-3">
                        <label for="additional_content">{{ __('lms.Additional Content') }}:</label>
                        <select class="form-control edit_additional_content"
                            name="items[${index}][additional_content]">
                            <option value="no">{{ __('lms.No Additional Content') }}</option>
                            <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                            <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                        </select>
                        <span
                            class="emptyCommingError trainError-items-${index}-additional_content text-danger"></span>

                    </div>

                    <div class="row col-sm-6">
                        <div class="col-sm-12 form-group mb-3 video-embedded-en"
                            style="display: none">
                            <label
                                for="video_url_en">{{ __('lms.Embedded Video URL English') }}</label>
                            <input type="file" accept="video/*" class="form-control video_url_en"
                                name="items[${index}][video_url_en]"
                                placeholder="{{ __('lms.Embedded Video URL English') }}">

                                <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                <span class="text-success video_en_upload_status"></span>
                                <input type="hidden" class="video_url_en_path" name="items[${index}][video_url_en_path]">

                                    <span
                                        class="emptyCommingError trainError-items-${index}-video_url_en text-danger"></span>

                                </div>

                                <div class="col-sm-12 row form-group mb-3 image-embedded"
                                    style="display: none">
                                    <div class="col-sm-12">
                                        <label
                                            for="image">{{ __('lms.Choose Statement Image English') }}</label>
                                        <input type="file" accept="image/*" class="form-control image"
                                            name="items[${index}][image]"
                                            placeholder="{{ __('lms.Choose Statement Image English') }}">
                                            <span
                                                class="emptyCommingError trainError-items-${index}-image text-danger"></span>

                                    </div>
                                </div>

                        </div>

                        <div class="row col-sm-6">
                            <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
                                <label for="video_url">{{ __('lms.Embedded Video URL Arabic') }}</label>
                                <input type="file" accept="video/*" class="form-control video_url"
                                    name="items[${index}][video_url]"
                                    placeholder="{{ __('lms.Embedded Video URL Arabic') }}">

                                    <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                                    <span class="text-success video_upload_status"></span>
                                    <input type="hidden" class="video_url_ar_path" name="items[${index}][video_url_ar_path]">


                                        <span
                                            class="emptyCommingError trainError-items-${index}-video_url text-danger"></span>

                                    </div>

                                    <div class="col-sm-12 row form-group mb-3 image-embedded"
                                        style="display: none">
                                        <div class="col-sm-12">
                                            <label
                                                for="image">{{ __('lms.Choose Statement Image Arabic') }}</label>
                                            <input type="file" accept="image/*" class="form-control image"
                                                name="items[${index}][image_ar]"
                                                placeholder="{{ __('lms.Choose Statement Image Arabic') }}">
                                                <span
                                                    class="emptyCommingError trainError-items-${index}-image_ar text-danger"></span>

                                        </div>
                                    </div>


                            </div>
                        </div>
                        `;



          $parentRow.next('.edit-main-statement-content').length ?
            $parentRow.next('.edit-main-statement-content').after(html) :
            $parentRow.after(html);

        $('#edit-main-statement-or-question-operation .col-sm-4').each(function (i) {
            $(this).find('h4 span').text(`Page ${i + 1} `);
        });
        $('#edit-main-statement-or-question-operation .edit-main-statement-content').each(function (i) {
            $(this).find('.page_number').val(i + 1);
            $(this).find('input, select, textarea').each(function () {
                let name = $(this).attr('name');
                name = name.replace(/\[\d+\]/g, `[${i}]`);
                $(this).attr('name', name);
            });
            $(this).find('.emptyCommingError').each(function () {
                let classList = $(this).attr('class');
                classList = classList.replace(/trainError-items-\d+-/, `trainError-items-${i}-`);
                $(this).attr('class', classList);
            });
        });

        CKEDITOR.replace(englishId);
        CKEDITOR.replace(arabicId);

        reclculateEditCounts();
    });

    // Add Question on the top
    $(document).on('click', '#edit_pre_append_question', function() {
        let index = 0
        $('#edit-main-statement-or-question-operation').prepend(
            `
                                                                                                                                    <div class="col-sm-4">
                                                                                                                                        <div class="d-flex justify-content-center">
                                                                                                                                            <h4 class="text-secondary main-head-content"><span>Page 1</span> - {{ __('lms.Question') }} </h4>
                                                                                                                                        </div>
                                                                                                                                    </div>

                                                                                                                                    <div class="col-sm-8">
                                                                                                                                        <div class="d-flex justify-content-end">
                                                                                                                                            <button type="button" class="btn btn-warning me-2 edit_after_append_question" > {{ __('lms.Add Question') }} </button>
                                                                                                                                            <button type="button" class="btn btn-danger me-2 edit_remove_question" > {{ __('lms.Remove Question') }} </button>
                                                                                                                                            <button type="button" class="btn btn-info me-2 edit_after_append_statement" > {{ __('lms.Add Statement') }} </button>
                                                                                                                                        </div>
                                                                                                                                    </div>

                                                                                                                                    <div class="col-sm-12 edit-main-statement-content">

                                                                                                                                        <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                                                                                                                            <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

                                                                                                                                                <div class="form-group mb-3">
                                                                                                                                                    <label for="question">{{ __('lms.Question') }} :</label>
                                                                                                                                                    <input type="text" class="form-control question" name="items[${index}][question]" placeholder="Enter a question title">
                                                                                                                                                </div>
                                                                                                                                                <div class="form-group mb-3">
                                                                                                                                                    <label for="question_type"> {{ __('lms.Question Type') }} :</label>
                                                                                                                                                    <select class="form-control edit_question_type" name="items[${index}][question_type]">
                                                                                                                                                        <option value="multi_choise" selected>Multi Choice</option>
                                                                                                                                                        <option value="true_or_false">True or False</option>
                                                                                                                                                    </select>
                                                                                                                                                </div>




                                                                                                                                                <div class="multi-chose-div">
                                                                                                                                                    <div class="form-group mb-1 row col-md-12">
                                                                                                                                                        <div class="input-group pl-1">
                                                                                                                                                            <div class="input-group-prepend">
                                                                                                                                                                <span class="input-group-text"> {{ __('lms.Option') }}  1: </span>
                                                                                                                                                            </div>
                                                                                                                                                            <input id="tMQOption21" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                                                <div class="input-group-append">
                                                                                                                                                                    <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                                        <div class="custom-control custom-radio">
                                                                                                                                                                            <input type="radio" id="option21" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                                                <label class="custom-control-label" for="option21"> {{ __('lms.Answer') }} </label>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>

                                                                                                                                                    <div class="form-group mb-1 row col-md-12">
                                                                                                                                                        <div class="input-group pl-1">
                                                                                                                                                            <div class="input-group-prepend">
                                                                                                                                                                <span class="input-group-text"> {{ __('lms.Option') }}  2: </span>
                                                                                                                                                            </div>
                                                                                                                                                            <input id="tMQOption22" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                                                <div class="input-group-append">
                                                                                                                                                                    <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                                        <div class="custom-control custom-radio">
                                                                                                                                                                            <input type="radio" id="option22" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                                                <label class="custom-control-label" for="option22"> {{ __('lms.Answer') }} </label>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>

                                                                                                                                                    <div class="form-group mb-1 row col-md-12">
                                                                                                                                                        <div class="input-group pl-1">
                                                                                                                                                            <div class="input-group-prepend">
                                                                                                                                                                <span class="input-group-text"> {{ __('lms.Option') }}  3: </span>
                                                                                                                                                            </div>
                                                                                                                                                            <input id="tMQOption23" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                                                <div class="input-group-append">
                                                                                                                                                                    <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                                        <div class="custom-control custom-radio">
                                                                                                                                                                            <input type="radio" id="option23" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                                                <label class="custom-control-label" for="option23"> {{ __('lms.Answer') }} </label>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>

                                                                                                                                                    <div class="form-group mb-2 row col-md-12">
                                                                                                                                                        <div class="input-group pl-1">
                                                                                                                                                            <div class="input-group-prepend">
                                                                                                                                                                <span class="input-group-text"> {{ __('lms.Option') }}  4: </span>
                                                                                                                                                            </div>
                                                                                                                                                            <input id="tMQOption24" type="text" name="items[${index}][options][]" class="form-control" aria-label="Enter an answer option" placeholder="Enter an answer option" maxlength="350">
                                                                                                                                                                <div class="input-group-append">
                                                                                                                                                                    <div data-toggle="tooltip" data-placement="top" title="Is this the correct answer?" class="input-group-text">
                                                                                                                                                                        <div class="custom-control custom-radio">
                                                                                                                                                                            <input type="radio" id="option24" name="items[${index}][correct_answer]" class="custom-control-input correct_answer">
                                                                                                                                                                                <label class="custom-control-label" for="option24"> {{ __('lms.Answer') }}</label>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>

                                                                                                                                                </div>

                                                                                                                                                <div class="true-or-false-div" style="display:none;">
                                                                                                                                                    <label for="answer">{{ __('lms.Answer') }} </label>
                                                                                                                                                    <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
                                                                                                                                                        <option value="true" selected> {{ __('lms.True') }} </option>
                                                                                                                                                        <option value="false"> {{ __('lms.False') }} </option>
                                                                                                                                                    </select>
                                                                                                                                                </div>

                                                                                                                                                <div class="form-group mb-3">
                                                                                                                                                    <label for="answer_description"> {{ __('lms.Answer Description') }} :</label>
                                                                                                                                                    <textarea type="text" class="form-control answer_description description" required rows="2" name="items[${index}][answer_description]" placeholder="Enter an answer description"></textarea>
                                                                                                                                                </div>


                                                                                                                                            </div>
                                                                                                                                            `
            );

        $('#edit-main-statement-or-question-operation .col-sm-4').each(function(index) {
            $(this).find('h4 span').text(`Page ${index + 1} `);
        });

        $('#edit-main-statement-or-question-operation .col-sm-12').each(function(i) {
            $(this).find('.page_number').val(i + 1);
            $(this).closest('.edit-main-statement-content').find('input, select,textarea').each(
                function() {
                    let name = $(this).attr('name');
                    // Replace any index pattern [index] with the current i value (global regex for any numeric index)
                    name = name.replace(/\[\d+\]/g, `[${i}]`);
                    $(this).attr('name', name);
                });
        });
        reclculateEditCounts();
    });

    // Add Statement on the top
    $(document).on('click', '#edit_pre_append_statement', function() {
        let index = 0
        $('#edit-main-statement-or-question-operation').prepend(
            `

                                                                                                                                            <div class="col-sm-4">
                                                                                                                                                <div class="d-flex justify-content-center">
                                                                                                                                                    <h4 class="text-secondary main-head-content"><span>Page 1</span> - {{ __('lms.Statement') }} </h4>
                                                                                                                                                </div>
                                                                                                                                            </div>

                                                                                                                                            <div class="col-sm-8">
                                                                                                                                                <div class="d-flex justify-content-end">
                                                                                                                                                    <button type="button" class="btn btn-warning me-2 edit_after_append_question" > {{ __('lms.Add Question') }} </button>
                                                                                                                                                    <button type="button" class="btn btn-danger me-2 edit_remove_statement" > {{ __('lms.Remove Statement') }} </button>
                                                                                                                                                    <button type="button" class="btn btn-info me-2 edit_after_append_statement" > {{ __('lms.Add Statement') }} </button>
                                                                                                                                                </div>
                                                                                                                                            </div>

                                                                                                                                            <div class="col-sm-12 row edit-main-statement-content">

                                                                                                                                                <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
                                                                                                                                                    <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

                                                                                                                                                        <div class="form-group mb-3">
                                                                                                                                                            <label for="statement_title"> {{ __('lms.Statement Title') }} :</label>
                                                                                                                                                            <input type="text" class="form-control statement_title" name="items[${index}][statement_title]" placeholder="Enter a statement title">
                                                                                                                                                                <span class="emptyCommingError commingError text-danger"></span>
                                                                                                                                                        </div>

                                                                                                                                                        <div class="form-group mb-3">
                                                                                                                                                            <label for="statement_content"> {{ __('lms.Statement Content') }} :</label>
                                                                                                                                                            <input type="text" class="form-control statement_content" name="items[${index}][statement_content]" placeholder="Enter the statement content">
                                                                                                                                                        </div>

                                                                                                                                                        <div class="form-group mb-3">
                                                                                                                                                            <label for="additional_content"> {{ __('lms.Additional Content') }} :</label>
                                                                                                                                                            <select class="form-control edit_additional_content" name="items[${index}][additional_content]">
                                                                                                                                                                <option value="no">{{ __('lms.No Additional Content') }}</option>
                                                                                                                                                                <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                                                                                                                                                                <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>

                                                                                                                                                        <div class="col-sm-12 form-group mb-3 video-embedded" style="display: none">
                                                                                                                                                            <label for="video_url"> {{ __('lms.Embedded Video URL') }} </label>
                                                                                                                                                            <input type="file" accept="video/*" class="form-control video_url" name="items[${index}][video_url]" placeholder="Enter the Url of Embedded Video">
                                                                                                                                                        </div>

                                                                                                                                                        <div class="col-sm-12 form-group mb-3 video-embedded-en" style="display: none">
                                                                                                                                                            <label for="video_url_en"> {{ __('lms.Embedded Video URL English') }} </label>
                                                                                                                                                            <input type="file" accept="video/*" class="form-control video_url_en" name="items[${index}][video_url_en]" placeholder="Enter the Url of Embedded Video">
                                                                                                                                                        </div>

                                                                                                                                                        <div class="col-sm-12 row form-group mb-3 image-embedded" style="display: none">
                                                                                                                                                            <div class="col-sm-12">
                                                                                                                                                                <label for="image"> {{ __('lms.Choose Statement Image') }} </label>
                                                                                                                                                                <input type="file" accept="image/*" class="form-control image" name="items[${index}][image]" placeholder="Enter the statement content">
                                                                                                                                                            </div>
                                                                                                                                                            <div class="col-sm-12">
                                                                                                                                                                <label for="image_url"> {{ __('lms.Embedded Image URL') }} </label>
                                                                                                                                                                <input type="text" class="form-control image_url" name="items[${index}][image_url]" placeholder="Enter the Url of Embedded Image">
                                                                                                                                                            </div>
                                                                                                                                                        </div>

                                                                                                                                                    </div>
                                                                                                                                                    `
            );

        $('#edit-main-statement-or-question-operation .col-sm-4').each(function(index) {
            $(this).find('h4 span').text(`Page ${index + 1} `);
        });

        $('#edit-main-statement-or-question-operation .col-sm-12').each(function(i) {
            $(this).find('.page_number').val(i + 1);
            $(this).closest('.edit-main-statement-content').find('input, select,textarea').each(
                function() {
                    let name = $(this).attr('name');
                    // Replace any index pattern [index] with the current i value (global regex for any numeric index)
                    name = name.replace(/\[\d+\]/g, `[${i}]`);
                    $(this).attr('name', name); // Set the new name
                });
        });
        reclculateEditCounts();
    });

    // Toggle according to additional content in statements
    $(document).on('change', '.edit_additional_content', function() {
        let parentDiv = $(this).closest('.edit-main-statement-content');
        let videoEmbedded = parentDiv.find('.video-embedded');
        let videoEmbeddedEnglish = parentDiv.find('.video-embedded-en');
        let imageEmbedded = parentDiv.find('.image-embedded');
        if ($(this).val() == 'video') {
            videoEmbedded.show();
            videoEmbeddedEnglish.show();
            imageEmbedded.hide();

            // videoEmbedded.find('input').prop('required', true);
            // videoEmbeddedEnglish.find('input').prop('required', true);
            // imageEmbedded.find('input').prop('required', false);

        } else if ($(this).val() == 'image') {
            imageEmbedded.show();
            videoEmbedded.hide();
            videoEmbeddedEnglish.hide();

            // videoEmbedded.find('input').prop('required', false);
            // videoEmbeddedEnglish.find('input').prop('required', false);
            // imageEmbedded.find('input[type="file"]').prop('required', true);
        } else {
            videoEmbeddedEnglish.hide();
            videoEmbedded.hide();
            imageEmbedded.hide();

            videoEmbedded.find('input').prop('required', false);
            videoEmbeddedEnglish.find('input').prop('required', false);
            imageEmbedded.find('input').prop('required', false);
        }

    });

    // Toggle according to question type in questions
    $(document).on('change', '.edit_question_type', function() {
        let parentDiv = $(this).closest('.edit-main-statement-content');
        let multiChoise = parentDiv.find('.multi-chose-div');
        let trueOrFalse = parentDiv.find('.true-or-false-div');
        if ($(this).val() == 'multi_choise') {
            multiChoise.show();
            trueOrFalse.hide();

            multiChoise.find('input:lt(2)').prop('required', true);
            multiChoise.find('input:gt(1)').prop('required', false);
            trueOrFalse.find('input').prop('required', false);

        } else if ($(this).val() == 'true_or_false') {
            trueOrFalse.show();
            multiChoise.hide();

            multiChoise.find('input').prop('required', false);
            trueOrFalse.find('input').prop('required', true);
        }
    });


























    // submit
    $('#edit-training-module').submit(function(e) {
        var editForm = $('#edit-training-module');
        var trainingModuleId = editForm.find('#edit_train_level_id').val();

        // $('#success_edit_training').modal('show');
        $('#edit_training_btn_text').hide();
        $('#edit_training_btn_loader').show();

        e.preventDefault();
        // let id = $('#edit_train_level_id').val();
        let url = "{{ route('admin.lms.trainingModules.update', ':id') }}".replace(':id', trainingModuleId);
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        const formData = new FormData(this);
        formData.append('level_id', editForm.find('#edit_level_id').val())

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                // $('#success_edit_training').modal('hide');
                $('#edit_training_btn_text').show();
                $('#edit_training_btn_loader').hide();

                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                    $('#edit_training_module_modal').modal('hide');
                    location.reload();
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                // $('#success_edit_training').modal('hide');
                $('#edit_training_btn_text').show();
                $('#edit_training_btn_loader').hide();
                const errors = response.responseJSON.errors;
                $('.emptyCommingError').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });

                // class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
                $.each(errors, function(key, messages) {
                    let errorKey = key.replace(/\./g, '-'); // Replace dots with dashes
                    let errorMessage = messages[0]; // Get the first error message
                    $('.trainError-' + errorKey).text(errorMessage);
                });

            }
        });
    });















    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })

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
</script>
@endsection
