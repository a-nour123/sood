@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Questionnaires'))

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



    <table id="thirdPartyAssessmentsTable" class="dt-advanced-server-search table dataTable no-footer">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('third_party.Name') }}</th>
                {{-- <th>Instructions</th> --}}
                <th>{{ __('third_party.Third party name') }}</th>
                <th>{{ __('third_party.Assessment template name') }}</th>
                <th>{{ __('third_party.Created At') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here by DataTables -->
        </tbody>
    </table>

    <!-- view assessment modal -->
    <div class="modal fade" id="viewQuestionnaireModal" tabindex="-1" aria-labelledby="viewQuestionnaireModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewQuestionnaireModalLabel">
                        {{ __('third_party.viewAssessmentModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewFormContent">
                    <!-- content of view questionnaire -->
                </div>
            </div>
        </div>
    </div>

    <!-- edit third_party assessment modal -->
    <div class="modal fade" id="editThirdPartyAssessmentModal" tabindex="-1"
        aria-labelledby="editThirdPartyAssessmentModalLabel" aria-hidden="true" style="position: fixed;">
        {{-- <div class="modal-dialog modal-lg"> --}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editThirdPartyAssessmentModalLabel">
                        {{ __('third_party.editThirdPartyAssessmentModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="assessmentFormContent">
                    <!-- content of edit third_party assessment -->

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

    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
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
            var table = $('#thirdPartyAssessmentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.third_party.questionnaires') }}',
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
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: true
                    },
                    // {
                    //     data: 'instructions',
                    //     name: 'instructions',
                    //     orderable: false,
                    //     searchable: true
                    // },
                    {
                        data: 'request', // request profile name
                        name: 'request',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'assessment',
                        name: 'assessment',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
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

        // view request
        $(document).on('click', '.view-questionnaire', function() {
            var questionnaireId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.viewQuestionnaire', ':id') }}'.replace(
                    ':id',
                    questionnaireId),
                type: 'GET',
                success: function(response) {

                    $('#viewQuestionnaireModal').modal('show'); // Show the modal
                    $("#viewFormContent").html(response);
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });

        $(document).on('click', '.send-questionnaire', function(e) {
            e.preventDefault();

            var questionnaireId = $(this).data('id');

            Swal.fire({
                title: "{{ __('assessment.Are You Sure You Want Send Email ?') }}",
                text: "{{ __('assessment.answers  will be replaced if exist !') }}",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Sure') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        url: '{{ route('admin.third_party.sendEmail', ':id') }}'
                            .replace(':id', questionnaireId),
                        data: {
                            questionnaire_id: questionnaireId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            // Show loading overlay
                            $.blockUI({
                                message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Sending questionnaire email']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                                css: {
                                    backgroundColor: 'transparent',
                                    color: '#fff',
                                    border: '0'
                                },
                                overlayCSS: {
                                    opacity: 0.5
                                }
                            });
                        },
                        success: function(response) {
                            var table = $("#thirdPartyAssessmentsTable").DataTable();
                            table.ajax.reload();

                            makeAlert('success', (
                                '{{ __('assessment.Questionnaire Send Successfully') }}'
                            ), "Success");

                            $.unblockUI();
                        },
                        error: function(response) {

                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('assessment.Oops...') }}',
                                text: "Something wrong",
                            });

                            $.unblockUI();
                        }
                    })
                }
            });

        });

        // create third_party assessment
        $(document).on('click', '.edit-questionnaire', function() {
            var questionnaireId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.getQuestionnairesForm', ['type' => 'edit_assessment', 'id' => ':id']) }}'
                    .replace(':id', questionnaireId),

                type: 'GET',
                success: function(response) {
                    $('#editThirdPartyAssessmentModal').modal('show'); // Show the modal

                    $("#assessmentFormContent").html(response);
                    $("#submitUpdateAssessment").attr("data-id", requestId);
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });

        // delete third_party assessment
        $(document).on('click', '.delete-questionnaire', function() {
            var questionnaireId = $(this).data('id');

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
                        url: '{{ route('admin.third_party.deleteQuestionnaire', ':id') }}'
                            .replace(':id', questionnaireId),
                        type: 'DELETE',
                        success: function(response) {
                            var table = $("#thirdPartyAssessmentsTable").DataTable();

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
