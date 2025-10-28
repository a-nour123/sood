@extends('admin/layouts/contentLayoutMaster')

@section('title', __('phishing.Groups'))

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

                        @if(Route::currentRouteName() == 'admin.phishing.groups.getAll')
                            <div class="col-sm-6 pe-0" style="text-align: end;">
                                <div class="action-content">
                                    {{--  @if (auth()->user()->hasPermission('asset.create'))  --}}
                                        <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-new-group">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        {{-- <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                            class=" btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>
                                        </a> --}}
                                        {{--  <a href="{{ route('admin.phishing.groups.getArchivedGroups') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa  fa-trash"></i>
                                    </a>  --}}
                                    {{--  @endif  --}}
                                    {{--  <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>  --}}

                                    {{--  <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                        exportPermissionKey='asset.export'
                                        exportRouteKey='admin.asset_management.ajax.export'
                                        importRouteKey='admin.asset_management.import' />

                                    <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>  --}}
                                </div>
                            </div>

                        @else
                            <div class="col-sm-6 pe-0" style="text-align: end;">
                                <div class="action-content">
                                    @if (auth()->user()->hasPermission('asset.create'))
                                        <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                            class=" btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                    {{--  <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                        exportPermissionKey='asset.export'
                                        exportRouteKey='admin.asset_management.ajax.export'
                                        importRouteKey='admin.asset_management.import' />

                                    <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>  --}}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>



<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <hr class="my-0" />
                <div class="card-datatable table-responsive">
                    <table class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('locale.Name') }}</th>
                                <th class="all">{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>

                        <!-- <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('locale.Name') }}</th>
                                <th class="all">{{ __('locale.Actions') }}</th>
                            </tr>
                        </tfoot> -->

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-group-form id="add-new-group" title="{{ __('phishing.AddANewGroup') }}"/>
{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-group-form id="edit-regulator" title="{{ __('phishing.EditGroup') }}" />
{{--  @endif   --}}
<!--/ Update Form -->

<x-phishing-group-users-form id="add-users" title="{{ __('phishing.GroupUsers') }}" idValue="6"/>





@endsection

@section('vendor-script')
<script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

<script>
    var table = $('.dt-advanced-server-search').DataTable({
        lengthChange: true,
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.phishing.groups.PhishingGroupeDatatable') }}'
        },
        language: {
            // ... your language settings
        },
        columns: [{
                name: "index",
                data: "DT_RowIndex",
                sortable: false,
                searchable: false, // Set to false since this column is not searchable
                orderable: false
            },
            {
                name: "name",
                data: "name"
            },
            {
                name: "actions",
                data: "actions",
                searchable: false // Set to false since this column is not searchable
            }
        ],
    });
</script>
<script>
   // Handle click event on department anchors
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.department-anchor').forEach(function(departmentAnchor) {
        departmentAnchor.addEventListener('click', function() {
            var deptId = this.getAttribute('data-dept-id');
            var userList = document.getElementById('users-dept-' + deptId);
            if (userList.style.display === 'none' || userList.style.display === '') {
                userList.style.display = 'block';
            } else {
                userList.style.display = 'none';
                // Uncheck all users in this department
                userList.querySelectorAll('input[type="checkbox"]').forEach(function(userCheckbox) {
                    userCheckbox.checked = false;
                });
            }
        });
    });
});
</script>


@endsection

@section('page-script')
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

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

<script>
    // Submit form for creating asset
    $('#add-new-group form').submit(function(e) {
        e.preventDefault();

        // Create a FormData object
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-group').modal('hide');
                    // location.reload();
                    $('.dt-advanced-server-search').DataTable().ajax.reload();

                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // Submit form for creating asset
    $('#add-users form').submit(function(e) {
        e.preventDefault();

        // Create a FormData object
        var formData = new FormData(this);
         console.log(formData,"formData")
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-users form').trigger("reset");

                    $('#add-users').modal('hide');
                    // location.reload();
                    $('.dt-advanced-server-search').DataTable().ajax.reload();

                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });





    // Submit form for editing asset
    $('#edit-regulator form').submit(function(e) {
        e.preventDefault();

        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.phishing.group.update', ':id') }}";
        url = url.replace(':id', id);

        // Create a FormData object
        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: "POST", // Laravel typically handles file uploads via POST
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set the content type to false as jQuery will tell the server it's a query string request
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-regulator form').trigger("reset");
                    $('#edit-regulator').modal('hide');
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    $(document).on('click', '.new-frame-modal-btn', function() {
        var regulator_id = $(this).data('regulator');
        $('.regulator_id').val(regulator_id);
    });



    function TrashGroup(id) {
        let url = "{{ route('admin.phishing.group.trash', ':id') }}";
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
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }



    $(document).on('click', '.edit-regulator', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        const editForm = $("#edit-regulator form");
        // Start Assign asset data to modal
        editForm.find('input[name="id"]').val(id);
        editForm.find("input[name='name']").val(name);
        // End Assign asset data to modal
        $('.dtr-bs-modal').modal('hide');
        $('#edit-regulator').modal('show');
    });
    $(document).on('click', '.add-users', function() {
        var id = $(this).data('id');

        const editForm = $("#add-users form");

        // Start Assign asset data to modal
        editForm.find('input[name="id"]').val(id);

        let var1 = $('#add-users').attr('idValue',id);


        $.ajax({
            url: "{{ route('admin.phishing.group.getUsersForGroup', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(response) {

                // Clear previous users
                editForm.find('input[name="users[]"]').prop('checked', false);

                // Log all checkboxes to ensure they are correctly rendered
                {{--  editForm.find('input[name="users[]"]').each(function(e) {
                    console.log('Checkbox value:', $(this).val());
                });  --}}

                // Update checkboxes with new data
                response.users.forEach(function(userId) {

                    console.log('Checking user ID:', userId); // Log each user ID to be checked
                    var checkbox = editForm.find('#user-'+ userId);
                    checkbox.prop('checked', true);
                });
            },
            error: function(xhr) {
                console.error('Failed to fetch users:', xhr.responseText);
            }
        });

        // End Assign asset data to modal
        $('.dtr-bs-modal').modal('hide');
        $('#add-users').modal('show');
    });



    // Show delete alert modal
    function ShowModalTrashGroup(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToTrashThisRecord') }}",
            {{--  text: '@lang('locale.YouWontBeAbleToRevertThis')',  --}}
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmTrash') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                TrashGroup(id);
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
