@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.AssetGroups'))

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
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
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

                                @if (auth()->user()->hasPermission('asset_group.create'))
                                    <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-asset-group">

                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.asset_management.notificationsSettingsAssetManagement') }}"
                                        class=" btn btn-primary" target="_self">

                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                <!-- Import and export container -->
                                <x-export-import name=" {{ __('asset.AssetGroup') }}"
                                    createPermissionKey='asset_group.create' exportPermissionKey='asset_group.export'
                                    exportRouteKey='admin.asset_management.ajax.asset_group.export'
                                    importRouteKey='admin.asset_management.importGroups' />
                                <!--/ Import and export container -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>

{{-- <div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Asset_group') }}</h4>
        </div>
    </div>


    <div class="card-body mt-2 dashboard_default module_summary">
        <div class="row dashboard  widget-grid">
            <div class="col-xl-3 col-lg-6 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-primary badge-rounded font-primary me-2"> <i
                                            class="size-18" data-feather='layers'></i></div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Frameworks') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">44564</h5>

                            </div>
                            <div class="col-sm-5 box-col-5">
                                <div id="expensesChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='file'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Assets') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">4645</h5>

                            </div>
                            <div class="col-sm-5 box-col-5">
                                <div id="totalLikesAreaChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-12 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-secondary badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='cpu'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.AssetGroups') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">11245</h5>

                            </div>
                            <div class="col-sm-5 box-col-5 incom-chart">
                                <div id="Incomechrt"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='file'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Assets') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">4645</h5>

                            </div>
                            <div class="col-sm-5 box-col-5">
                                <div id="totalLikesAreaChart1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div> --}}

<!-- Advanced Search -->
<x-asset-group-search id="advanced-search-datatable" :assetGroups="$assetGroups" createModalID="add-new-asset-group" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (auth()->user()->hasPermission('asset_group.create'))
    <x-asset-group-form id="add-new-asset-group" title="{{ __('asset.AssetGroupCreate') }}" />
@endif
<!--/ Create Form -->

<!-- Update Form -->
@if (auth()->user()->hasPermission('asset_group.update'))
    <x-asset-group-form id="edit-asset-group" title="{{ __('asset.AssetGroupUpdate') }}" />
@endif
<!--/ Update Form -->
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
{{-- Add Verification translation --}}
<script>
    const verifiedTranslation = "{{ __('locale.Verified') }}",
        UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}";
    var permission = [],
        URLs = [],
        lang = [];
    permission['edit'] = {{ auth()->user()->hasPermission('asset_group.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('asset_group.delete') ? 1 : 0 }};
    URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.asset_group.index') }}";

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.department')]) }}";
</script>
<script src="{{ asset('ajax-files/asset_management/asset_group/index.js') }}"></script>
<script>
    // Submit form for creating asset
    $('#add-new-asset-group form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-asset-group').modal('hide');
                    redrawDatatable();
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

    // Submit form for editing asset
    $('#edit-asset-group form').submit(function(e) {
        e.preventDefault();
        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.asset_management.ajax.asset_group.update', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "PUT",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-asset-group form').trigger("reset");
                    $('#edit-asset-group').modal('hide');
                    redrawDatatable();
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

    function DeleteAsset(id) {
        let url = "{{ route('admin.asset_management.ajax.asset_group.destroy', ':id') }}";
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
                    redrawDatatable();
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // // Show modal for editing
    function ShowModalEditAsset(id) {
        let url = "{{ route('admin.asset_management.ajax.asset_group.edit', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    const editForm = $("#edit-asset-group form");

                    // Start assigning asset data to the modal
                    editForm.find('input[name="id"]').val(response.data.id);
                    editForm.find("input[name='name']").val(response.data.name);

                    // Clear previous selections
                    let assetSelect = editForm.find("select[name='assets[]']");
                    assetSelect.empty();

                    // Add new selections
                    response.data.assets.forEach(asset => {
                        let option = new Option(asset.name, asset.id, true, true);
                        assetSelect.append(option).trigger('change');
                    });

                    // Reinitialize Select2
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
                        }
                    });

                    // Show the edit modal
                    $('#edit-asset-group').modal('show');
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }



    // Show delete alert modal
    function ShowModalDeleteAsset(id) {
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
                DeleteAsset(id);
            }
        });
    }

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

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })
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
        initAssetSelect2($('#add-new-asset-group select[name="assets[]"]'));

        // Reset and reinitialize Select2 for each modal open
        $('.modal').on('shown.bs.modal', function() {
            let modalSelect = $(this).find('select[name="assets[]"]');
            modalSelect.select2('destroy'); // Destroy the previous instance
            initAssetSelect2(modalSelect); // Reinitialize Select2
        });

        // Call ShowModalEditAsset(id) with the appropriate id when needed
    });
</script>

@endsection
