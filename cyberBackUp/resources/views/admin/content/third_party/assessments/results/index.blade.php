@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Questionnaire Results'))

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

                                <!-- add request btn -->
                                {{-- <button class="btn btn-primary" type="button" id="addRequestBtn" data-bs-toggle="modal"
                                    data-bs-target="#createRequestModal">
                                    <i class="fa fa-plus"></i>
                                </button> --}}

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <table id="thirdPartyAssessmentsResultsTable" class="dt-advanced-server-search table dataTable no-footer">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('third_party.ThirdPartyProfile') }}</th>
                <th>{{ __('third_party.Contact name') }}</th>
                <th>{{ __('third_party.Assessment name') }}</th>
                <th>{{ __('third_party.Status') }}</th>
                <th>{{ __('third_party.Submission type') }}</th>
                <th>{{ __('third_party.Percentage complete') }}</th>
                <th>{{ __('third_party.Approved status') }}</th>
                <th>{{ __('third_party.Sent date') }}</th>
                <th>{{ __('third_party.Submition date') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here by DataTables -->
        </tbody>
    </table>

    <!-- view answer results modal -->
    <div class="modal fade" id="viewQuestionnaireResultModal" tabindex="-1"
        aria-labelledby="viewQuestionnaireResultModalLabel" aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewQuestionnaireResultModalLabel">
                        {{ __('third_party.viewAssessmentResultModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewFormContent">
                    <!-- content of view questionnaire -->
                </div>
            </div>
        </div>
    </div>

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


@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>

    {{-- <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>


    <script src="{{ asset('new_d/js/form-wizard/form-wizard.js') }}"></script>
    <script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>

    <script src="{{ asset('new_d/js/bootstrap/bootstrap11.min.js') }}"></script> --}}


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function of making alert
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        // handle table
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#thirdPartyAssessmentsResultsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.third_party.questionnairesResults') }}',
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
                        data: 'third_party_name',
                        name: 'third_party_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'contact_name',
                        name: 'contact_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'questionnaire_name',
                        name: 'questionnaire_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data === 'complete') {
                                return '<span class="badge bg-success">' +
                                    `{{ __('third_party.Complete') }}` + '</span>';
                            } else {
                                return '<span class="badge bg-secondary">' +
                                    `{{ __('third_party.Incomplete') }}` + '</span>';
                            }
                        }
                    },
                    {
                        data: 'submission_type',
                        name: 'submission_type',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data === 'complete') {
                                return '<span class="badge bg-info">' +
                                    `{{ __('third_party.Complete') }}` + '</span>';
                            } else {
                                return '<span class="badge bg-warning">' +
                                    `{{ __('third_party.Draft') }}` + '</span>';
                            }
                        }
                    },
                    {
                        data: 'percentage_complete',
                        name: 'percentage_complete',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, row) {
                            return data + ' %';
                        }
                    },
                    {
                        data: 'approved_status',
                        name: 'approved_status',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data === 'yes') {
                                return '<span class="badge bg-success">' +
                                    `{{ __('third_party.Accepted') }}` + '</span>';
                            } else if (data === 'remeidation') {
                                return '<span class="badge bg-info">' +
                                    `{{ __('third_party.Remeidation') }}` + '</span>';
                            } else if (data === 'no') {
                                return '<span class="badge bg-danger">' +
                                    `{{ __('third_party.Rejected') }}` + '</span>';
                            } else {
                                return '<span class="badge bg-warning">' +
                                    `{{ __('third_party.Pending') }}` + '</span>';
                            }
                        }
                    },
                    {
                        data: 'send_date',
                        name: 'send_date',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'submission_date',
                        name: 'submission_date',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        // view questionnaire answer result
        // $(document).on('click', '.view-questionnaire_result', function() {
        //     var questionnaireAnswerId = $(this).data('id');

        //     $.ajax({
        //         url: '{{ route('admin.third_party.viewQuestionnaireAnswer', ':id') }}'.replace(
        //             ':id',
        //             questionnaireAnswerId),
        //         type: 'GET',
        //         success: function(response) {
        //             $('#viewQuestionnaireResultModal').modal('show'); // Show the modal
        //             $("#viewFormContent").html(response);
        //         },
        //         error: function(xhr) {
        //             makeAlert('error', xhr.responseJSON.message ||
        //                 'Failed to load data.',
        //                 'Error');
        //         }
        //     });
        // });

        // view approveing questionnaire_result
        $(document).on('click', '.approveing-questionnaire_result', function() {
            var questionnaireAnswerId = $(this).data('id');
            var approvingStatus = $(this).data('status');
            var text = '';

            if (approvingStatus == 'yes') {
                text = 'Approve on this questionnaire';
            } else {
                text = 'Rejecting this questionnaire';
            }

            Swal.fire({
                title: "Approving questionnire",
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.third_party.updateQuestionnaireAnswerStatus', ':id') }}'
                            .replace(':id', questionnaireAnswerId),
                        type: 'PUT',
                        data: {
                            approved_status: approvingStatus
                        },
                        success: function(response) {
                            var table = $("#thirdPartyAssessmentsResultsTable").DataTable();

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
    </script>

@endsection
