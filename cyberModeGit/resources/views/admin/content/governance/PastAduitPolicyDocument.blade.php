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



                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

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
                    type: "past",
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
                    data: 'document_id',
                    name: 'document_id',
                    orderable: true,
                    searchable: true
                },
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


        // Filter by policy name
        $('#filterPolicyName').on('keyup', function() {
            table.columns(1).search(this.value).draw();
        });

        // Filter by document
        $('#filterDocuments').on('change', function() {
            var selectedDocument = $(this).val();
            table.columns(2).search(selectedDocument ? selectedDocument : '').draw();
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
