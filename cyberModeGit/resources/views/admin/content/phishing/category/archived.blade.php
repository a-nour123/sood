@extends('admin/layouts/contentLayoutMaster')

@section('title', __('Phishing.category'))

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
                                    <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                    <a href="{{ route('admin.phishing.phishingcategory.getAll') }}"
                                        class=" btn btn-primary" title="Categories">
                                        <i class="fas fa-id-card"></i>
                                    </a>
                                @endif
                                <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                    exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' />

                                <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>


<div class="row" id="domains-parent-div">
    @foreach ($archived_categories as $index => $category)
        <div class="col-4 domain-card" data-id="{{ $category->id }}">
            <div class="regulator-item p-3">
                @php
                $percentage = Helper::ImplementedStatistic($category->id);
                $color = '';

                if($percentage < 50 ){
                    $color = '#ffa1a1';
                }elseif($percentage >= 50 && $percentage <= 80){
                    $color = '#ffe700';
                }else{
                    $color = '#00d4bd';
                }
                @endphp
                <div class="card" style="background-image: url('{{ asset('images/widget-bg.png') }}');">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 ">
                                <div class="chart-progress me-3" data-color=""
                                     data-series="{{ Helper::ImplementedStatistic($category->id) }}" data-progress_variant="true"></div>
                            </div>
                            <div class="col-md-9 py-1">
                                <h4>{{ $category->name }}</h4>

                                <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                        data-id="{{ $category->id }}" onclick="ShowModalRestoreCategory({{ $category->id }})" data-name="{{ $category->name }}">
                                                                       <i class="fa-solid fa-undo"></i>

                                </button>
                                                         <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                        data-id="{{ $category->id }}" onclick="ShowModalDeleteCategory({{ $category->id }})" data-name="{{ $category->name }}">
                                                                       <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-domains-form id="add-new-domain" title="{{ __('locale.AddANewRegulator') }}" />
{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-domains-form id="edit-regulator" title="{{ __('locale.EditRegulator') }}" />
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
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>


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

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

<script>


    function restoreCategory(id) {
        let url = "{{ route('admin.phishing.categories.restore', ':id') }}";
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
    function ShowModalRestoreCategory(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToRestoreThisRecord') }}",
            {{--  text: '@lang('locale.YouWontBeAbleToRevertThis')',  --}}
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmRestore') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                restoreCategory(id);
            }
        });
    }

        function deleteCategory(id) {
        let url = "{{ route('admin.phishing.category.delete', ':id') }}";
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
    function ShowModalDeleteCategory(id) {
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
                deleteCategory(id);
            }
        });
    }


</script>
@endsection
