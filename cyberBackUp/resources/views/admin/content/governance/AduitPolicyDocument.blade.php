@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.PolicyCompliance'))
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

    .blockUI {
        z-index: 1100 !important;
        /* Ensure BlockUI is above modals */
    }

    .blockUI.blockOverlay {
        z-index: 1099 !important;
        /* Ensure overlay is below BlockUI message but above the modal */
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
                        <div class="col-sm-6 pe-0" style="text-align: end !important;">

                            <div class="action-content">


                                @if (auth()->user()->hasPermission('Aduit_Document_Policy.create'))
                                    <div class="action-buttons">

                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-primary  " data-bs-toggle="modal"
                                            data-bs-target="#AddNewAduitDocumentPolicy">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <a href="{{ route('admin.governance.notificationsSettingsAuditPolicy') }}"
                                            class="btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>

                                        </a>

                                    </div>
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
                    <!-- Add filtering inputs -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" id="filterPolicyName" class="form-control"
                                    placeholder="{{ __('locale.SearchPolicyName') }}" />
                            </div>
                            <div class="col-md-4">
                                <label for="document_type" class="form-label">{{ __('locale.Document') }}</label>
                                <select class="form-select" name="Filter_document_type" id="Filter_document_type">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($documentTypes as $documentType)
                                        <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.SelectDocument') }}</label>
                                <select id="filterDocuments" class="form-select">
                                    <option value="" selected>{{ __('locale.Select') }}</option>
                                    {{-- Documents will be populated dynamically via AJAX --}}
                                </select>
                            </div>

                        </div>
                    </div>
                    <table id="AduitDocumentpoliciesTable" class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.AuditName') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.DocumentType') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.Document') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.Auditer') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.Auditees') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.StartDate') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.DueDate') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.PeriodicalTime') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.NextInitiateDate') }}</th> <!-- Translated column header -->
                                <th>{{ __('locale.Action') }}</th> <!-- Translated column header for "Action" -->
                            </tr>

                        </thead>
                        <tbody>
                            <!-- Data will be populated here by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        {{-- Create auditor --}}
        <div class="modal fade" id="AddNewAduitDocumentPolicy" tabindex="-1"
            aria-labelledby="startNewAuditModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="startNewAuditModalLabel">{{ __('locale.StartNewAudit') }}</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="startAuditForm" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="aduit_name" class="form-label">{{ __('locale.AuditName') }}</label>
                                    <input type="text" name="aduit_name" id="aduit_name" class="form-control"
                                        placeholder="{{ __('locale.EnterAuditName') }}">
                                    <span class="error error-aduit_name text-danger"></span>

                                </div>
                                <div class="col-md-4">
                                    <label for="document_type"
                                        class="form-label">{{ __('locale.DocumentType') }}</label>
                                    <select class="form-select" name="document_type" id="document_type">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                        @foreach ($documentTypes as $documentType)
                                            <option value="{{ $documentType->id }}">{{ $documentType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error error-document_type text-danger"></span>

                                </div>
                                <div class="col-md-4">
                                    <label for="document_id" class="form-label">{{ __('locale.Document') }}</label>
                                    <select class="form-select" name="document_id" id="document_id">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                    </select>
                                    <span class="error error-document_id text-danger"></span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('locale.Auditer') }}</label>
                                    <select class="select2 form-select" name="owner_id" id="owner_id">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                        @foreach ($auditers as $auditer)
                                            <option @if (!$auditer->enabled) disabled @endif
                                                value="{{ $auditer->id }}">{{ $auditer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('locale.Auditees') }}</label>
                                    <select class="select2 form-select" id="responsible" name="responsible[]"
                                        multiple="multiple">
                                        <option value="" disabled>{{ __('locale.select-option') }}</option>
                                        @foreach ($auditees as $auditee)
                                            <option @if (!$auditee->enabled) disabled @endif
                                                value="{{ $auditee->id }}">{{ $auditee->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-responsible text-danger"></span>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="start_date">{{ __('locale.StartDate') }}</label>
                                    <input name="start_date" class="form-control flatpickr-date-time-compliance"
                                        placeholder="YYYY-MM-DD" id="start_date" type="text" />
                                    <span class="error error-start_date text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="due_date">{{ __('locale.DueDate') }}</label>
                                    <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                        id="due_date" placeholder="YYYY-MM-DD" type="text" />
                                    <span class="error error-due_date text-danger"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="periodical_time">{{ __('locale.PeriodicalTime') }}
                                        ({{ __('locale.days') }})</label>
                                    <input type="number" min="0" name="periodical_time" id="periodical_time"
                                        value="0" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="next_initiate_date">{{ __('locale.NextIntiateDate') }}</label>
                                    <input type="text" name="next_initiate_date" placeholder="YYYY-MM-DD"
                                        id="next_initiate_date" class="form-control" readonly>
                                    <span class="error error-next_initiate_date text-danger"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="mb-1">
                                    <label class="form-label">
                                        <input type="checkbox" name="requires_file" id="requires_file"
                                            value="1" />
                                        {{ __('locale.RequiresFileEvidence') }}
                                    </label>
                                    <span class="error error-requires_file text-danger"></span>

                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit"
                                    class="btn btn-primary mt-3">{{ __('locale.StartAudit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Clone auditor --}}
        <div class="modal fade" id="AddNewAduitDocumentPolicyClone" tabindex="-1"
            aria-labelledby="startNewAuditModalCloneLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="startNewAuditModalCloneLabel">{{ __('locale.StartNewAudit') }}
                        </h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="startAuditCloneForm" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="aduit_name" class="form-label">{{ __('locale.AuditName') }}</label>
                                    <input type="text" name="aduit_name" id="aduit_name_clone"
                                        class="form-control" placeholder="{{ __('locale.EnterAuditName') }}">
                                    <span class="error error-aduit_name text-danger"></span>

                                </div>
                                <div class="col-md-4">
                                    <label for="document_type"
                                        class="form-label">{{ __('locale.DocumentType') }}</label>
                                    <select class="form-select" name="document_type" id="document_type_clone">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                        @foreach ($documentTypes as $documentType)
                                            <option value="{{ $documentType->id }}">{{ $documentType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error error-document_type text-danger"></span>

                                </div>
                                <div class="col-md-4">
                                    <label for="document_id" class="form-label">{{ __('locale.Document') }}</label>
                                    <select class="form-select" name="document_id" id="document_id_clone">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                    </select>
                                    <span class="error error-document_id text-danger"></span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('locale.Auditer') }}</label>
                                    <select class="select2 form-select" name="owner_id" id="owner_id_clone">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                        @foreach ($auditers as $auditer)
                                            <option @if (!$auditer->enabled) disabled @endif
                                                value="{{ $auditer->id }}">{{ $auditer->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-owner_id text-danger"></span>

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('locale.Auditees') }}</label>
                                    <select class="select2 form-select" id="responsible_clone" name="responsible[]"
                                        multiple="multiple">
                                        <option value="" disabled>{{ __('locale.select-option') }}</option>
                                        @foreach ($auditees as $auditee)
                                            <option @if (!$auditee->enabled) disabled @endif
                                                value="{{ $auditee->id }}">{{ $auditee->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-responsible_clone text-danger"></span>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="start_date">{{ __('locale.StartDate') }}</label>
                                    <input name="start_date" class="form-control flatpickr-date-time-compliance"
                                        placeholder="YYYY-MM-DD" id="start_date_clone" type="text" />
                                    <span class="error error-start_date text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="due_date">{{ __('locale.DueDate') }}</label>
                                    <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                        id="due_date_clone" placeholder="YYYY-MM-DD" type="text" />
                                    <span class="error error-due_date text-danger"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="periodical_time">{{ __('locale.PeriodicalTime') }}
                                        ({{ __('locale.days') }})</label>
                                    <input type="number" min="0" name="periodical_time"
                                        id="periodical_time_clone" value="0" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="next_initiate_date">{{ __('locale.NextIntiateDate') }}</label>
                                    <input type="text" name="next_initiate_date" placeholder="YYYY-MM-DD"
                                        id="next_initiate_date_clone" class="form-control" readonly>
                                    <span class="error error-next_initiate_date text-danger"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="mb-1">
                                    <label class="form-label">
                                        <input type="checkbox" name="requires_file" id="requires_file_clone"
                                            value="1" />
                                        {{ __('locale.RequiresFileEvidence') }}
                                    </label>
                                    <span class="error error-requires_file text-danger"></span>

                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit"
                                    class="btn btn-primary mt-3">{{ __('locale.StartAudit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
            var table = $('#AduitDocumentpoliciesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.governance.getAuditDocumentPolicies') }}',
                    type: 'POST',
                    data: {
                        type: "active",
                    },
                },
                columns: [{
                        data: null, // Auto-incrementing index
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'aduit_name',
                        name: 'aduit_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'document_type',
                        name: 'document_type',
                        orderable: true,
                        searchable: true
                    }, {
                        data: 'document_id',
                        name: 'document_id',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'policy_name', // Display policy name
                    //     name: 'policy_name',
                    //     orderable: false,
                    //     searchable: true,
                    //     render: function(data, type, row) {
                    //         var policyNames = data ? data.split(',') : [];
                    //         var badges = policyNames.map(function(name) {
                    //             return '<span class="badge rounded-pill badge-light-primary">' +
                    //                 name + '</span>';
                    //         });
                    //         return badges.join(' ');
                    //     }

                    // },
                    {
                        data: 'owner_id',
                        name: 'owner_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'responsible',
                        name: 'responsible',
                        orderable: false,
                        searchable: true,

                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        orderable: true,
                        searchable: false,
                    },
                    {
                        data: 'due_date',
                        name: 'due_date',
                        orderable: true,
                        searchable: false,
                    },
                    {
                        data: 'periodical_time',
                        name: 'periodical_time',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'next_initiate_date',
                        name: 'next_initiate_date',
                        orderable: true,
                        searchable: false,
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).ready(function() {
                // Common function to fetch documents based on document type
                function fetchDocumentsByType(dropdownSelector, documentTypeId, selectedDocumentId = null) {
                    // Check if a valid document type is selected
                    if (documentTypeId) {
                        $.ajax({
                            url: '{{ route('admin.governance.getDocumentsByType') }}', // Your route to fetch documents
                            method: 'GET',
                            data: {
                                document_type_id: documentTypeId // Send the document type ID
                            },
                            success: function(response) {
                                // Clear the corresponding document dropdown
                                $(dropdownSelector).empty().append(
                                    '<option value="" selected>{{ __('locale.select-option') }}</option>'
                                );

                                // Loop through the response and append each document to the dropdown
                                $.each(response.documents, function(index, document) {
                                    $(dropdownSelector).append('<option value="' +
                                        document.id +
                                        '">' + document.document_name + '</option>');
                                });

                                // If a document_id is provided, select the correct document
                                if (selectedDocumentId) {
                                    $(dropdownSelector).val(selectedDocumentId).trigger(
                                        'change');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("An error occurred: " + error);
                            }
                        });
                    } else {
                        // If no document type is selected, clear the corresponding document dropdown
                        $(dropdownSelector).empty().append(
                            '<option value="" selected>{{ __('locale.select-option') }}</option>'
                        );
                    }
                }

                // Trigger AJAX request when the #document_type dropdown changes
                $('#document_type').on('change', function() {
                    var documentTypeId = $(this).val();
                    fetchDocumentsByType('#document_id',
                        documentTypeId); // Call the function for the first dropdown
                });
                $('#document_type_clone').on('change', function() {
                    var documentTypeId = $(this).val();
                    fetchDocumentsByType('#document_id_clone',
                        documentTypeId); // Call the function for the clone dropdown
                });
                // Trigger AJAX request when the #Filter_document_type dropdown changes
                $('#Filter_document_type').on('change', function() {
                    var documentTypeId = $(this).val();
                    fetchDocumentsByType('#filterDocuments',
                        documentTypeId); // Call the function for the second dropdown
                });

                // Reset modal content when it's closed
                $('#AddNewAduitDocumentPolicy').on('hidden.bs.modal', function() {
                    // Reset the form inside the modal
                    $('#startAuditForm')[0].reset();

                    // Reset select2 dropdowns
                    $('.select2').val(null).trigger('change');

                    // Uncheck the checkboxes
                    $('[name="requires_file"]').prop('checked', false);

                    // Remove any hidden inputs that were added dynamically
                    $('#startAuditForm input[type="hidden"]').remove();

                    // Reset other fields
                    $('#document_id').val('').trigger('change'); // Reset document ID select
                    $('#document_type').val('').trigger('change'); // Reset document type select
                });


                // Existing code to fetch data when clicking the edit button in the table
                $('#AduitDocumentpoliciesTable tbody').on('click', '.edit-policy', function() {
                    var policyId = $(this).data('id'); // Get the policy ID from the button

                    // Reset the form fields before populating new data
                    $('#startAuditForm')[0].reset();
                    $('.select2').val(null).trigger('change'); // Reset select2

                    // Make an AJAX request to get the policy data
                    $.ajax({
                        url: '{{ route('admin.governance.getAuditDocumentPolicyById', '') }}/' +
                            policyId,
                        method: 'GET',
                        success: function(data) {
                            // Populate the modal fields with the fetched data
                            $('#aduit_name').val(data.aduit_name);
                            $('#document_type').val(data.document_type).trigger(
                                'change'); // Set the document_type in the select
                            $('#owner_id').val(data.owner_id).trigger(
                                'change'); // Trigger change for Select2
                            $('#responsible').val(data.responsible).trigger(
                                'change'
                            ); // Directly use the array for multiple selection

                            $('#start_date').val(data.start_date);
                            $('#due_date').val(data.due_date);
                            $('#periodical_time').val(data.periodical_time);
                            $('#next_initiate_date').val(data.next_initiate_date);
                            if (data.requires_file) {
                                $('[name="requires_file"]').prop("checked", true);
                            } else {
                                $('[name="requires_file"]').prop("checked", false);
                            }

                            // Set a hidden input for the ID
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'audit_policy_id',
                                name: 'id',
                                value: policyId
                            }).appendTo('#startAuditForm');

                            // Fetch and select the document based on the document_type and document_id
                            fetchDocumentsByType('#document_id', data.document_type,
                                data.document_id);

                            // Show the modal
                            $('#AddNewAduitDocumentPolicy').modal('show');
                        },
                        error: function(xhr) {
                            console.error(xhr);
                        }
                    });
                });

                // this is used to clone the the audit
                $('#AduitDocumentpoliciesTable tbody').on('click', '.clone-policy', function() {
                    var policyId = $(this).data('id'); // Get the policy ID from the button

                    // Reset the form fields before populating new data
                    $('#startAuditCloneForm')[0].reset();
                    $('.select2').val(null).trigger('change'); // Reset select2

                    // Make an AJAX request to get the policy data
                    $.ajax({
                        url: '{{ route('admin.governance.getAuditDocumentPolicyById', '') }}/' +
                            policyId,
                        method: 'GET',
                        success: function(data) {
                            // Populate the modal fields with the fetched data
                            $('#aduit_name_clone').val(data.aduit_name);
                            $('#document_type_clone').val(data.document_type).trigger(
                                'change'); // Set the document_type in the select
                            $('#owner_id_clone').val(data.owner_id).trigger(
                                'change'); // Trigger change for Select2
                            $('#responsible_clone').val(data.responsible).trigger(
                                'change'
                            ); // Directly use the array for multiple selection

                            $('#start_date_clone').val(data.start_date);
                            $('#due_date_clone').val(data.due_date);
                            $('#periodical_time_clone').val(data.periodical_time);
                            $('#next_initiate_date_clone').val(data.next_initiate_date);
                            if (data.requires_file) {
                                $('[name="requires_file_clone"]').prop("checked", true);
                            } else {
                                $('[name="requires_file_clone"]').prop("checked",
                                    false);
                            }
                            // Fetch and select the document based on the document_type and document_id
                            fetchDocumentsByType('#document_id_clone', data
                                .document_type, data.document_id);

                            // Show the modal
                            $('#AddNewAduitDocumentPolicyClone').modal('show');
                        },
                        error: function(xhr) {
                            console.error(xhr);
                        }
                    });
                });

            });


            // Filter by policy name
            $('#filterPolicyName').on('keyup', function() {
                table.columns(1).search(this.value).draw();
            });
            // Filter by document
            $('#Filter_document_type').on('change', function() {
                var selectedDocument = $(this).val();
                table.columns(2).search(selectedDocument ? selectedDocument : '').draw();
            });
            // Filter by document
            $('#filterDocuments').on('change', function() {
                var selectedDocument = $(this).val();
                table.columns(3).search(selectedDocument ? selectedDocument : '').draw();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Function to calculate the next initiate date
            function calculateNextInitiateDate(dueDateId, periodicalTimeId, nextInitiateDateId) {
                const dueDateInput = document.getElementById(dueDateId);
                const periodicalTimeInput = document.getElementById(periodicalTimeId);
                const nextInitiateDateInput = document.getElementById(nextInitiateDateId);

                // Ensure inputs are found
                if (!dueDateInput || !periodicalTimeInput || !nextInitiateDateInput) return;

                const dueDate = dueDateInput.value;
                const periodicalTime = parseInt(periodicalTimeInput.value);

                if (dueDate) {
                    const dueDateObj = new Date(dueDate);

                    if (periodicalTime === 0) {
                        nextInitiateDateInput.value = dueDate;
                    } else if (periodicalTime > 0) {
                        dueDateObj.setDate(dueDateObj.getDate() + periodicalTime);
                        const nextInitiateDate = dueDateObj.toISOString().split('T')[0];
                        nextInitiateDateInput.value = nextInitiateDate;
                    } else {
                        nextInitiateDateInput.value = '';
                    }
                } else {
                    nextInitiateDateInput.value = '';
                }
            }

            // Function to set up event listeners for a given set of IDs
            function setupEventListeners(dueDateId, periodicalTimeId, nextInitiateDateId) {
                document.getElementById(dueDateId)?.addEventListener('change', function() {
                    calculateNextInitiateDate(dueDateId, periodicalTimeId, nextInitiateDateId);
                });
                document.getElementById(periodicalTimeId)?.addEventListener('input', function() {
                    calculateNextInitiateDate(dueDateId, periodicalTimeId, nextInitiateDateId);
                });
            }

            // Set up listeners for the original fields
            setupEventListeners('due_date', 'periodical_time', 'next_initiate_date');

            // Set up listeners for the cloned fields
            setupEventListeners('due_date_clone', 'periodical_time_clone', 'next_initiate_date_clone');
        });


        $(document).ready(function() {
            $('.select2').select2(); // Initialize select2 for all select elements

            function submitAuditForm(formId, modalId, tableReload = true) {
                $(formId).on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Serialize form data
                    var documentId = $(this).find('[name="document_id"]').val(); // Extract document ID
                    var auditPolicyId = $('[name="id"]').val(); // Get the value of audit_policy_id
                    console.log("Audit Policy ID:", auditPolicyId); // Log for debugging

                    // If audit_policy_id has a value, proceed directly to update
                    if (auditPolicyId) {
                        processAuditForm(formId, formData, modalId, tableReload);
                        return; // Skip further checks
                    }

                    // Perform the check for existing audits
                    $.ajax({
                        url: '{{ route('admin.governance.checkAuditDocumentPolicy') }}', // Route for checking
                        method: 'POST',
                        data: {
                            document_id: documentId,
                            _token: '{{ csrf_token() }}' // Add CSRF token for security
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Show SweetAlert2 confirmation dialog
                                Swal.fire({
                                    title: 'Audit in Progress',
                                    text: 'There is already an audit in progress for this document. Do you want to proceed?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, proceed',
                                    cancelButtonText: 'Cancel',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Proceed with form submission
                                        processAuditForm(formId, formData, modalId,
                                            tableReload);
                                    }
                                });
                            } else {
                                // No existing audit, proceed directly
                                processAuditForm(formId, formData, modalId, tableReload);
                            }
                        },
                        error: function(xhr) {
                            // Check if there's a response JSON and if it contains an error message
                            var errorMessage =
                                'Error checking audit document policy. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = xhr.responseJSON
                                    .errors; // Use the actual error message from the response
                            }

                            makeAlert('error', errorMessage, 'Error');
                        }

                    });
                });
            }

            function processAuditForm(formId, formData, modalId, tableReload) {
                $.ajax({
                    url: '{{ route('admin.governance.storeAduitDocumentPolicy') }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $.blockUI({
                            message: '<div class="d-flex justify-content-center align-items-center">' +
                                '<p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('Initiate Audit')]) }}</p>' +
                                '<div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                            css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0',
                                width: 'auto',
                                left: '50%',
                                marginLeft: '-120px',
                                zIndex: 1100, // Ensure above the modal
                            },
                            overlayCSS: {
                                opacity: 0.5,
                                backgroundColor: '#000',
                                cursor: 'wait',
                                zIndex: 1099, // Ensure above modal backdrop
                            },
                        });
                    },
                    complete: function() {
                        $.unblockUI(); // Unblock the UI after request completes
                    },
                    success: function(response) {
                        makeAlert('success', 'Audit Document Policy saved successfully!', 'Success');

                        // Reset form and modal fields only on success
                        if (tableReload) $('#AduitDocumentpoliciesTable').DataTable().ajax.reload();
                        $(formId)[0].reset();
                        $('.select2').val(null).trigger('change');
                        $(modalId).modal('hide'); // Hide the modal after success
                    },
                    error: function(xhr) {
                        $.unblockUI();
                        $(modalId).modal('show'); // Reopen modal on error

                        $(formId).find('.text-danger').text(''); // Clear previous error messages
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(formId).find(`.error-${key}`).text(value[0]);
                            });
                        } else {
                            // Check if there's a response JSON and if it contains an error message
                            var errorMessage =
                                'Error checking audit document policy. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = xhr.responseJSON
                                    .errors; // Use the actual error message from the response
                            }

                            makeAlert('error', errorMessage, 'Error');
                        }
                    },
                });
            }

            // Initialize form submission for Add New Audit
            submitAuditForm('#startAuditForm', '#AddNewAduitDocumentPolicy');

            // Initialize form submission for Clone Audit
            submitAuditForm('#startAuditCloneForm', '#AddNewAduitDocumentPolicyClone');
        });





        $(document).ready(function() {
            // Initialize owner_id select2
            $('#owner_id').select2({
                placeholder: "{{ __('locale.select-option') }}",
                allowClear: true,
                dropdownParent: $('#AddNewAduitDocumentPolicy')
            });

            $('#responsible').select2({
                placeholder: "{{ __('locale.select-option') }}",
                allowClear: true,
                dropdownParent: $('#AddNewAduitDocumentPolicy')
            });

            // Initialize clone modal selects
            $('#owner_id_clone').select2({
                placeholder: "{{ __('locale.select-option') }}",
                allowClear: true,
                dropdownParent: $('#AddNewAduitDocumentPolicyClone')
            });

            $('#responsible_clone').select2({
                placeholder: "{{ __('locale.select-option') }}",
                allowClear: true,
                dropdownParent: $('#AddNewAduitDocumentPolicyClone')
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
@endsection
