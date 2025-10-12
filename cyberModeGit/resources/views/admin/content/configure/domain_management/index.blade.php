@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.Domains Management'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
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

                                @if (auth()->user()->hasPermission('domain.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-domain">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif



                                <x-export-import name="{{ __('locale.Domain') }}" createPermissionKey='domain.create'
                                    exportPermissionKey='domain.export'
                                    exportRouteKey='admin.configure.domain_management.ajax.export'
                                    importRouteKey='will-added-TODO' />







                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>
<!-- Advanced Search -->
<x-domain-management-search id="advanced-search-datatable" :domains="$domains" :subDomains="$subDomains"
    createModalID="add-new-domain" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (auth()->user()->hasPermission('domain.create'))
    <x-domain-management-form id="add-new-domain" title="{{ __('configure.AddANewDomain') }}" :domains="$domains" />
@endif
<!--/ Create Form -->

<!-- Update Form -->
@if (auth()->user()->hasPermission('domain.update'))
    <x-domain-management-form id="edit-domain" title="{{ __('configure.EditDomain') }}" :domains="$domains" />
@endif
<!--/ Update Form -->

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script>
    var permission = [],
        lang = [],
        URLs = [];
    lang['Delete'] = "{{ __('locale.Delete') }}";
    lang['Edit'] = "{{ __('locale.Edit') }}";

    permission['show'] = {{ auth()->user()->hasPermission('domain.list') ? 1 : 0 }};
    permission['edit'] = {{ auth()->user()->hasPermission('domain.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('domain.delete') ? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('configure.domain')]) }}";
    URLs['ajax_list'] = "{{ route('admin.configure.domain_management.ajax.index') }}";
</script>
<script src="{{ asset('ajax-files/configure/domain_management/index.js') }}"></script>
<script>
    // Submit form for creating asset
    $('#add-new-domain form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-domain').modal('hide');
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
    $('#edit-domain form').submit(function(e) {
        e.preventDefault();
        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.configure.domain_management.ajax.update', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "PUT",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-domain form').trigger("reset");
                    $('#edit-domain').modal('hide');
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

    function DeleteDomain(id) {
        let url = "{{ route('admin.configure.domain_management.ajax.destroy', ':id') }}";
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

    function ShowModalEditDomain(id) {
        let url = "{{ route('admin.configure.domain_management.ajax.edit', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    const editForm = $("#edit-domain form");
                    const data = response.data;

                    // Assign data to modal inputs
                    editForm.find('input[name="id"]').val(id);
                    editForm.find("input[name='name_en']").val(data.name_en);
                    editForm.find("input[name='name_ar']").val(data.name_ar);
                    editForm.find("select[name='parent_id']").val(data.parent_id).trigger('change');
                    editForm.find("input[name='order']").val(data.order);

                    $('.dtr-bs-modal').modal('hide');
                    $('#edit-domain').modal('show');
                }
            },
            error: function(response) {
                const responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }


    // Show delete alert modal
    function ShowModalDeleteDomain(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
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
                DeleteDomain(id);
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
        form.find('textarea').text('');

        form.find('select').trigger('change');
    }

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })
</script>

@endsection
