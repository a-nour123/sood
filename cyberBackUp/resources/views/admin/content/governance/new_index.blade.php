@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Define Control Frameworks'))

@section('vendor-style')
<!-- vendor css files -->
@include('admin.content.governance.layout.frameworks_v_style')
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-todo.css')) }}">
<link rel="stylesheet" href="{{ asset('cdn/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('Dashboard/frameworks.css') }}">
@endsection
@section('content-sidebar')
@include('admin.content.governance.layout.frameworks_sidebar')
@endsection

@section('content')
<div class="body-content-overlay"></div>
<div class="todo-app-list">
    <!-- Todo search starts -->
    <div class="app-fixed-search d-flex align-items-center justify-content-end p-2">


        @if (auth()->user()->hasPermission('framework.create'))
        <div class="add-task" style="display: flex;align-items:center;justify-content:space-between">
            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                data-bs-target="#new-frame-modal">
                {{ __('locale.Add') }} {{ __('governance.Framework') }}
            </button>
            <a href="{{ route('admin.governance.notificationsSettingFramework') }}"
                class="dt-button btn btn-primary  mx-2 " target="_self" style="min-width: max-content;">
                {{ __('locale.NotificationsSettings') }}
            </a>
        </div>
    @endif

    <x-export-import name=" {{ __('governance.Framework') }}" createPermissionKey='framework.create'
        exportPermissionKey='framework.export' exportRouteKey='admin.governance.framework.ajax.export'
        importRouteKey='admin.governance.framework.import' />



        <div class="sidebar-toggle d-block d-lg-none ms-1">
            <i data-feather="menu" class="font-medium-5"></i>
        </div>
    </div>
    <!-- Todo search ends -->
    <!-- control List starts -->
    <div class="todo-task-list-wrapper list-group">
        <ul class="todo-task-list media-list" id="todo-task-list">

            @include('admin.content.governance.components.frameworks.categories')


        </ul>

        <div class="no-results">
            <h5>No Items Found</h5>
        </div>
    </div>
    <!-- Todo List ends -->
</div>
<div class="modal modal-slide-in sidebar-todo-modal fade" id="empModal" role="dialog">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">Mapping</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                                                                 class="font-medium-2"></i></span>
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            <form class="todo-modal needs-validation" novalidate method="POST"
                  action="{{ route('admin.governance.framework.map') }}">
                @csrf

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3" id="form-modal-map">


                </div>


            </form>


        </div>
    </div>
</div>
<div class="modal modal-slide-in sidebar-todo-modal fade" id="edit_contModal" role="dialog">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">Update Control</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                                                                 class="font-medium-2"></i></span>
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            <form id="form-update_control" class="todo-modal needs-validation" novalidate method="POST"
                  action="{{ route('admin.governance.control.update') }}">
                @csrf

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3" id="form-modal-edit">


                </div>


            </form>


        </div>
    </div>
</div>
<style>
    .activeItemTab{
        color: #44225c!important;
    }
    .activeItemTab:hover{
        color:  #44225c!important;
    }
    .activeItemTab:active{
        color:  #44225c!important;
    }
</style>
@include('admin.content.governance.modals.create_framework')

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

<script src="{{ asset('cdn/picker.js') }}"></script>
<script src="{{ asset('cdn/picker.date.js') }}"></script>

@endsection

@section('page-script')
@include('admin.content.governance.layout.frameworks_scripts')
@include('admin.content.governance.FrameWorkAjax')
@endsection
