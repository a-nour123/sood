@extends('admin/layouts/contentLayoutMaster')
@section('title', __('configure.Roles'))

@section('vendor-style')

<link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
<link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
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

                        @if (auth()->user()->hasPermission('roles.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                    data-bs-target="#addRoleModal">
                                        <i class="fa fa-plus"></i>
                                    </button>

                                @endif


                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>
<h3>{{__('configure.Roles List')}}</h3>
<div class="col-xl-4 col-lg-6 col-md-6 mt-3">
    <div class="col-sm-7">

        {{-- <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                class="stretched-link text-nowrap add-new-role">
                <span class="btn btn-primary mb-1">Add New Role</span>
            </a> --}}

    </div>


</div>


<!-- Role cards -->
<div class="row">
    @foreach ($roles as $role)
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    {{-- <span>Total 4 users</span> --}}
                    {{-- <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  title="Vinnie Mostowy"
                  class="avatar avatar-sm pull-up"
                >
                  <img class="rounded-circle" src="{{asset('images/avatars/2.png')}}" alt="Avatar" />
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Allen Rieske" class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="{{asset('images/avatars/12.png')}}" alt="Avatar" />
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Julee Rossignol" class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="{{asset('images/avatars/6.png')}}" alt="Avatar" />
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kaith D'souza" class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="{{asset('images/avatars/11.png')}}" alt="Avatar" />
                    </li>
                    </ul> --}}
                </div>
                <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                    <div class="role-heading">
                        <h4 class="fw-bolder mb-2">{{ $role->name }}</h4>
                        @if(!$loop->first)
                        @if (auth()->user()->hasPermission('roles.update'))
                        <a href="javascript:;" onclick="ShowModalEditRolePermission({{ $role->id }})" class="item-edit"> {{__('locale.Edit')}} </a>
                        @endif
                        @if (auth()->user()->hasPermission('roles.delete'))
                        <a href="javascript:;" onclick="ShowModalDeleteRolePermission({{ $role->id }})" class="item-edit"> {{__('locale.Delete')}}</a>
                        @endif
                        @else
                        <span class="item-edit text-danger">{{__('configure.UpdateOrDeleteAdminRoleNotAvailable')}}</span>
                        @endif
                        {{-- <a href="javascript:;" class="role-edit-modal" id="{{ $role->id }}"
                        data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <small class="fw-bolder">Edit Role</small>
                        </a> --}}
                    </div>
                    {{-- <a href="javascript:void(0);" class="text-body"><i data-feather="copy" class="font-medium-5"></i></a> --}}
                    <!-- TODO: Add copy role button -->
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

<!--/ Role cards -->

{{-- <h3 class="mt-50">Total users with their roles</h3>
<!-- <p class="mb-2">Find all of your company’s administrator accounts and their associate roles.</p> -->
<!-- table -->
<div class="card">
  <div class="table-responsive">
    <table class="user-list-table table">
      <thead class="table-light">
        <tr>
          <th></th>
          <th></th>
          <th>Name</th>
          <th>Role</th>
          <th>Plan</th>
          <th>Billing</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div> --}}
<!-- table -->

@include('admin/content/configure/modal-add-role')
@endsection

@section('vendor-script')
<!-- Vendor js files -->
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<!-- Page js files -->
<script>
    
    const getRoute = "{{ route('admin.configure.roles.ajax.show', ':id') }}"
        , updateRoute = "{{ route('admin.configure.roles.ajax.update', ':id') }}"
        , deleteRoute = "{{ route('admin.configure.roles.ajax.destroy', ':id') }}"
        , storeRoute = "{{ route('admin.configure.roles.role.store') }}";

</script>
{{-- <script src="{{ asset(mix('js/scripts/pages/modal-add-role.js')) }}"></script> --}}
<script src="{{ asset(mix('js/scripts/pages/app-access-roles.js')) }}"></script>
<script>
    $('.selectAllPermission').on('click', function() {
        if ($(this).is(':checked')) {
            var data_id = $(this).data('id');
            $('.checkboxType-' + data_id).prop('checked', true);
        } else {
            var data_id = $(this).data('id');
            $('.checkboxType-' + data_id).prop('checked', false);
        }
    });

</script>
@endsection
