@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.PolicyCenter'))
<style>
    .gov_btn {
        border-color: #44225c !important;
        background-color: #44225c !important;
        color: #fff !important;
        /* padding: 7px; */
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

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
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

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
</style>

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

                                @if (auth()->user()->hasPermission('Document_Policy.create'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#AddNewPolicy">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.governance.notificationsSettingspolicyCenter') }}"
                                        class="btn btn-primary" target="_self">
                                        <i class="fa fa-bell"></i>
                                    </a>
                                    <a type="button" class="btn btn-primary submit-export" data-type="excel"
                                        id="exportButton">
                                        <i class="fa-solid fa-file-import"></i>
                                    </a>
                                    <a href="{{ route('admin.governance.policyClause.import') }}"
                                        class="dt-button btn btn-primary " target="_self">
                                        <i class="fa-solid fa-file-import"></i>
                                    </a>
                                @endif



                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section id="advanced-search-datatable">
        <div class="card-datatable">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                        </div>
                        <!-- @if (auth()->user()->hasPermission('Document_Policy.create')) -->
                        <!-- <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <button type="button" class="dt-button btn btn-primary me-2 AddQuesBtn"
                                        data-bs-toggle="modal" data-bs-target="#AddNewPolicy">
                                        {{ __('locale.AddNewPolicy') }}
                                    </button>
                                    <a href="{{ route('admin.governance.policyClause.import') }}"
                                        class="dt-button btn btn-primary me-2" target="_self">
                                        {{ __('locale.Import') }}
                                    </a>
                                    <div class="btn-group dropdown dropdown-icon-wrapper me-2">
                                        <div class="btn-group dropdown dropdown-icon-wrapper ">
                                            <button type="button" class="btn btn-primary submit-export" data-type="excel" id="exportButton">{{ __('locale.Export') }}</button>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.governance.notificationsSettingspolicyCenter') }}"
                                        class="dt-button btn btn-primary me-2" target="_self">
                                        {{ __('locale.NotificationsSettings') }}
                                    </a>
                                </div>
                            </div> -->
                        <!-- @endif -->
                    </div>
                    <!-- Add filtering inputs -->
                    <div class="card-body">
                        <div class="row mb-3">
                            {{-- <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" id="filterPolicyName" class="form-control"
                                    placeholder="{{ __('locale.SearchPolicyName') }}" />
                            </div> --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.SelectDocument') }}</label>
                                <select id="filterDocuments" class="form-select">
                                    <option value="" selected>{{ __('locale.Select') }}</option>
                                    @foreach ($documents as $document)
                                        <option value="{{ $document->id }}">{{ $document->document_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <table id="policiesTable" class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.PolicyName') }}</th>
                                <th>{{ __('locale.Documents') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>





        {{-- Modal Structure for adding a new policy --}}
        <div class="modal fade" id="AddNewPolicy" tabindex="-1" aria-labelledby="AddNewPolicyLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddNewPolicyLabel">{{ __('locale.AddNewPolicy') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="newPolicyForm">
                            <div class="mb-3">
                                <label for="policyName"
                                    class="form-label">{{ __('locale.PolicyNameEnglish') }}</label>
                                <input type="text" class="form-control" id="policyNameEn" name="policy_name_en"
                                    placeholder="{{ __('locale.EnterPolicyNameEn') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="policyName"
                                    class="form-label">{{ __('locale.PolicyNameArabic') }}</label>
                                <input type="text" class="form-control" id="policyNameAr" name="policy_name_ar"
                                    placeholder="{{ __('locale.EnterPolicyNameAr') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="documents" class="form-label">{{ __('locale.SelectDocument') }}</label>
                                <select class="select2 form-select" id="documents" name="document_id[]"
                                    multiple="multiple" required>
                                    <option value="" disabled>{{ __('locale.SelectDocument') }}</option>
                                    @foreach ($documents as $document)
                                        <option value="{{ $document->id }}">{{ $document->document_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('locale.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('vendor-script')

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
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set the CSRF token in the AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            var table = $('#policiesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.governance.getDataPolicy') }}',
                columns: [{
                        data: null, // We will generate this data ourselves
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1; // Auto-incrementing index
                        }
                    },
                    {
                        data: 'policy_name',
                        name: 'policy_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'document_ids',
                        name: 'document_ids',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, row) {
                            var documentArray = data ? data.split(',') : [];
                            var badges = documentArray.map(function(documentId) {
                                return '<span class="badge rounded-pill badge-light-primary">' +
                                    documentId + '</span>';
                            });
                            return badges.join(' ');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Filter by policy name
            // $('#filterPolicyName').on('keyup', function() {
            //     table.columns(1).search(this.value).draw();
            // });

            // Filter by document
            $('#filterDocuments').on('change', function() {
                var selectedDocument = $(this).val();
                table.columns(2).search(selectedDocument ? selectedDocument : '').draw();
            });


            $(document).on('click', '.delete-policy', function() {
                var policyId = $(this).data('id');
                Swal.fire({
                    title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                    text: '@lang('locale.YouWontBeAbleToRevertThis')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                    cancelButtonText: "{{ __('locale.Cancel') }}",
                    customClass: {
                        confirmButton: 'btn btn-relief-success ms-1',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.governance.deletePolicy', ':id') }}'
                                .replace(':id', policyId),
                            type: 'DELETE',
                            success: function(response) {
                                table.ajax.reload(); // Refresh DataTable after delete
                                makeAlert('success', response.message, 'Success');
                            },
                            error: function(xhr) {
                                makeAlert('error', xhr.responseJSON.message ||
                                    'An unexpected error occurred.', 'Error');
                            }
                        });
                    }
                });
            });

            // Handle edit action
            $(document).on('click', '.edit-policy', function() {
                var policyId = $(this).data('id');
                $.ajax({
                    url: '{{ route('admin.governance.getPolicy', ':id') }}'.replace(
                        ':id',
                        policyId),
                    type: 'GET',
                    success: function(response) {
                        let desc = response.policy_name || '{}';
                        let descObj = {};
                        try {
                            descObj = typeof desc === 'string' ? JSON.parse(desc) : desc;
                        } catch (e) {
                            descObj = {
                                en: '',
                                ar: ''
                            };
                        }
                        $('#policyNameEn').val(descObj.en || '');
                        $('#policyNameAr').val(descObj.ar || '');
                        $('#documents').val(response.document_ids.split(','))
                            .trigger(
                                'change'); // Update select2
                        $('#AddNewPolicy').data('policy-id',
                            policyId); // Store the policy ID in the modal
                        $('#AddNewPolicy').modal('show'); // Show the modal
                    },
                    error: function(xhr) {
                        makeAlert('error', xhr.responseJSON.message ||
                            'Failed to load data.',
                            'Error');
                    }
                });
            });

            // Handle form submission for new policy and edit policy
            $('#newPolicyForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var policyId = $('#AddNewPolicy').data('policy-id'); // Get policy ID for edit

                var ajaxConfig = {
                    type: policyId ? 'PUT' : 'POST',
                    url: policyId ?
                        '{{ route('admin.governance.editPolicy', ':id') }}'.replace(':id', policyId) :
                        '{{ route('admin.governance.storePolicy') }}',
                    data: formData,
                    success: function(response) {
                        if (response.status) {
                            makeAlert('success', response.message, 'Success');
                            $('#AddNewPolicy').modal('hide'); // Close the modal
                            table.ajax.reload(); // Refresh DataTable
                        } else {
                            // If the response contains validation errors, display them
                            var errorMessage = '';
                            if (response.errors) {
                                // Loop through each field's errors
                                $.each(response.errors, function(field, messages) {
                                    if (Array.isArray(messages)) {
                                        errorMessage += messages.join('<br>') + '<br>';
                                    } else {
                                        errorMessage += messages +
                                            '<br>'; // If it's a string, display it directly
                                    }
                                });
                            } else if (response.message) {
                                // If the response contains a general message like "The following documents are in use..."
                                errorMessage = response.message;
                            }

                            makeAlert('error', errorMessage, 'Error');
                        }
                    },
                    error: function(xhr) {
                        // Handle unexpected errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            $.each(errors, function(key, value) {
                                if (Array.isArray(value)) {
                                    errorMessage += value.join('<br>') + "<br>";
                                } else {
                                    errorMessage += value +
                                        "<br>"; // If it's a string, display it directly
                                }
                            });

                            makeAlert('error', errorMessage, 'Error');
                        } else {
                            makeAlert('error', 'An unexpected error occurred. Please try again.',
                                'Error');
                        }
                    }
                };

                // Send AJAX request
                $.ajax(ajaxConfig);
            });



            // Reset form data when modal is hidden
            $('#AddNewPolicy').on('hidden.bs.modal', function() {
                $('#newPolicyForm')[0].reset(); // Reset form fields
                $('#documents').val([]).trigger('change'); // Clear select2 selections
                $('#AddNewPolicy').data('policy-id', null); // Reset policy ID
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
        $(document).ready(function() {
            $('#filterDocuments').select2({
                placeholder: "{{ __('locale.Select') }}",
                allowClear: true
            });
            $('#documents').select2({
                placeholder: "{{ __('locale.Select') }}",
                allowClear: true
            });

        });
        $(document).ready(function() {
            $('#exportButton').on('click', function() {
                const type = $(this).data('type');
                const url =
                    `{{ route('admin.governance.export.policy.clause') }}?type=${type}`; // Use the named route
                window.location.href = url; // This triggers the download
            });
        });
    </script>

@endsection
