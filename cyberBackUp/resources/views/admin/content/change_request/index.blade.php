@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.ChangeRequest'))

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')
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
                            @if (auth()->user()->hasPermission('change-request.change-request-department'))
                                <div class="action-content">
                                    <div class="btn-group dropdown dropdown-icon-wrapper me-1">
                                        <button type="button"
                                            class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="border-radius: 8px !important;
                                                width: 40px;
                                                text-align: center;
                                                color: #FFF !important;
                                                height: 32px;
                                                line-height: 19px;">
                                            <i class="fa fa-solid fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end export-types  ">

                                            <span class="dropdown-item" data-type="excel">
                                                <i class="fa fa-solid fa-gear"></i>
                                                <span class="px-1 text-start"><a
                                                        href="{{ route('admin.configure.change_request_department.edit') }}">{{ __('profiles.configuretion') }}</a></span>

                                            </span>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>
{{-- end header --}}
<!-- Advanced Search -->
<x-change-request-search id="advanced-search-datatable" createModalID="add-new-change-request" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (change_requests_responsible_department_manager_id() &&
        auth()->user()->hasPermission('change-request.create') &&
        auth()->id() != change_requests_responsible_department_manager_id())
    <x-change-request-form id="add-new-change-request" title="{{ __('locale.AddANewChangeRequest') }}" />
@endif
<!--/ Create Form -->

<!-- Update Form -->
@if (change_requests_responsible_department_manager_id() && auth()->user()->hasPermission('change-request.create'))
    <x-change-request-form id="edit-change-request" title="{{ __('locale.EditChangeRequest') }}" type='edit' />
@endif

<!--/ Update Form -->

{{-- Form to download file --}}
<form class="d-none" id="download-file-form" method="post"
    action="{{ route('admin.change_request.ajax.download_file') }}">
    @csrf
    <input type="hidden" name="id">
</form>

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
<script>
    permission = [];
    permission['edit'] = {{ auth()->user()->hasPermission('change-request.create') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('change-request.create') ? 1 : 0 }};

    const lang = []
    URLs = [];
    lang['user'] = "{{ __('locale.User') }}";

    URLs['ajax_list'] = "{{ route('admin.change_request.ajax.index') }}";
    URLs['update'] = "{{ route('admin.change_request.ajax.update', ':id') }}";
    URLs['delete'] = "{{ route('admin.change_request.ajax.destroy', ':id') }}";
    URLs['edit'] = "{{ route('admin.change_request.ajax.edit', ':id') }}"

    lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
    lang['cancel'] = "{{ __('locale.Cancel') }}";
    lang['success'] = "{{ __('locale.Success') }}";
    lang['error'] = "{{ __('locale.Error') }}";
    lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
    lang['confirmDeleteRecordMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";

    lang['Open'] = "{{ __('locale.Open') }}";
    lang['Closed'] = "{{ __('locale.Closed') }}";
    lang['In Progress'] = "{{ __('locale.In Progress') }}";

    lang['Critical'] = "{{ __('locale.Critical') }}";
    lang['High'] = "{{ __('locale.High') }}";
    lang['Medium'] = "{{ __('locale.Medium') }}";
    lang['Low'] = "{{ __('locale.Low') }}";
    lang['Informational'] = "{{ __('locale.Informational') }}";
    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.changeRequest')]) }}";
</script>
<script src="{{ asset('ajax-files/change_request/index.js') }}"></script>
@endsection
