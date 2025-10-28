@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Jobs'))

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
    {{-- <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap4.css') }}"> --}}
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

                        @if (auth()->user()->hasPermission('job.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-job">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a  href="{{ route('admin.hierarchy.job.notificationsSettingsJob') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                            <!-- <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a> -->

                            <x-export-import name="{{ __('locale.Job') }}" createPermissionKey='job.create'
                                exportPermissionKey='job.export'
                                exportRouteKey='admin.hierarchy.job.ajax.export'
                                importRouteKey='admin.hierarchy.job.import' />


                            <!-- <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>

<!-- <div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Hierarchy_job') }}</h4>
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
</div> -->

    <!-- Advanced Search -->
    <x-job-search id="advanced-search-datatable" :users="$users" createModalID="add-new-job" />
    <!--/ Advanced Search -->

    <!-- Create Form -->
    @if (auth()->user()->hasPermission('job.create'))
        <x-job-form id="add-new-job" title="{{ __('hierarchy.AddANewJob') }}" />
    @endif
    <!--/ Create Form -->

    <!-- Update Form -->
    @if (auth()->user()->hasPermission('job.update'))
        <x-job-form id="edit-job" title="{{ __('hierarchy.EditJob') }}" />
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
    <script>
        const lang = [],
            URLs = [],
            permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('job.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('job.delete')? 1: 0 }};

        lang['user'] = "{{ __('locale.User') }}";
        lang['Edit'] = "{{ __('locale.Edit') }}";
        lang['Delete'] = "{{ __('locale.Delete') }}";
        lang['Show'] = "{{ __('locale.Show') }}";
        lang['View'] = "{{ __('locale.View') }}";

        URLs['ajax_list'] = "{{ route('admin.hierarchy.job.ajax.index') }}";
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

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.job')]) }}";
    </script>
    <script src="{{ asset('ajax-files/hierarchy/job/index.js') }}"></script>
    <script>
        // Submit form for creating asset
        $('#add-new-job form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#add-new-job').modal('hide');
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
        $('#edit-job form').submit(function(e) {
            e.preventDefault();
            const id = $(this).find('input[name="id"]').val();
            let url = "{{ route('admin.hierarchy.job.ajax.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "PUT",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#edit-job form').trigger("reset");
                        $('#edit-job').modal('hide');
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

        function DeleteJob(id) {
            let url = "{{ route('admin.hierarchy.job.ajax.destroy', ':id') }}";
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
                        $('.dtr-bs-modal').modal('hide');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show modal for editing
        function ShowModalEditJob(id) {
            let url = "{{ route('admin.hierarchy.job.ajax.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        const editForm = $("#edit-job form");

                        // Start Assign job data to modal
                        editForm.find('input[name="id"]').val(id);
                        editForm.find("input[name='name']").val(response.data.name);
                        editForm.find("input[name='code']").val(response.data.code);
                        editForm.find("textarea[name='description']").val(response.data.description);
                        // End Assign job data to modal

                        $('.dtr-bs-modal').modal('hide');
                        $('#edit-job').modal('show');
                    }
                    // alert(1);
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show delete alert modal
        function ShowModalDeleteJob(id) {
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
                    DeleteJob(id);
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
@endsection
