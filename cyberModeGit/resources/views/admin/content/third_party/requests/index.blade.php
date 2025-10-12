@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.ThirdPartyRequests'))

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
                                @if (auth()->user()->hasPermission('third_party_request.create'))
                                    <button class="btn btn-primary" type="button" id="addRequestBtn" data-bs-toggle="modal"
                                        data-bs-target="#createRequestModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif

                                <!-- <button class="btn btn-primary" type="button" id="configrationBtn"
                                    data-bs-toggle="modal" data-bs-target="#configRequestModal">
                                    <i class="fa fa-solid fa-gear"></i>
                                </button> -->

                                <!-- configration request btn -->
                                @if (auth()->user()->hasPermission('third_party_request.configuration'))
                                    <div class="btn-group dropdown dropdown-icon-wrapper me-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="border-radius: 8px !important;
                                            width: 40px;
                                            text-align: center;
                                            color: #FFF !important;
                                            height: 32px;
                                            line-height: 19px;">
                                            <i class="fa fa-solid fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end export-types  ">

                                            <span class="dropdown-item" data-type="excel">
                                                <i class="fa fa-solid fa-gear"></i>
                                                <span class="px-1 text-start"><a href="#"
                                                        id="configrationBtn">{{ __('third_party.Configration') }}</a></span>

                                            </span>

                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <table id="requestsTable" class="dt-advanced-server-search table dataTable no-footer">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('third_party.Requested by') }}</th>
                <th>{{ __('third_party.Department/employee') }}</th>
                <th>{{ __('third_party.Job Title') }}</th>
                <th>{{ __('third_party.ThirdPartyProfile') }}</th>
                <th>{{ __('third_party.Service') }}</th>
                <th>{{ __('third_party.Status') }}</th>
                <th>{{ __('third_party.Issue Date') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here by DataTables -->
        </tbody>
    </table>



    <!-- add request modal -->
    <div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRequestModalLabel">
                        {{ __('third_party.createRequestModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="createFormContent">
                    <!-- content of create request here -->
                    {{-- <x-third-party-request-form :data="$data"/> --}}

                </div>
            </div>
        </div>
    </div>

    <!-- edit request modal -->
    <div class="modal fade" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRequestModalLabel">
                        {{ __('third_party.editRequestModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editFormContent">
                    <!-- content of edit request here -->
                </div>
            </div>
        </div>
    </div>

    <!-- view request modal -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1" aria-labelledby="viewRequestModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewRequestModalLabel">
                        {{ __('third_party.viewRequestModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewFormContent">
                    <!-- content of create profile -->
                </div>
            </div>
        </div>
    </div>

    <!-- create third_party assessment modal -->
    <div class="modal fade" id="createThirdPartyAssessmentModal" tabindex="-1"
        aria-labelledby="createThirdPartyAssessmentModalLabel" aria-hidden="true" style="position: fixed;">
        {{-- <div class="modal-dialog modal-lg"> --}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createThirdPartyAssessmentModalLabel">
                        {{ __('third_party.createThirdPartyAssessmentModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="assessmentFormContent">
                    <!-- content of create third_party assessment -->

                </div>
            </div>
        </div>
    </div>

    <!-- request configrations modal -->
    <div class="modal fade" id="configRequestModal" tabindex="-1" aria-labelledby="configRequestModalLabel"
        aria-hidden="true" style="position: fixed;">
        {{-- <div class="modal-dialog"> --}}
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configRequestModalLabel">Request configrations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="configContent">
                    <!-- content of request configrations -->
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

        $("#configrationBtn").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.third_party.config') }}",
                data: {
                    partition: "requests"
                },
                success: function(response) {
                    // Replace the entire document's HTML with the response
                    document.open();
                    document.write(response);
                    document.close();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });


        // $("#configrationBtn").click(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('admin.third_party.config') }}",
        //         data: {
        //             partition: "requests"
        //         },
        //         success: function(response) {
        //             $("#configContent").html(response);
        //         }
        //     });
        // });

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
            var translattion = {
                in_assessment: `{{ __('third_party.In_assessment') }}`
            };

            // Initialize DataTable
            var table = $('#requestsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.third_party.requests') }}',
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
                        data: 'uploader',
                        name: 'uploader',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'department', // This column now uses the department name
                        name: 'department',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'job', // This column now uses the job title
                        name: 'job',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'profile', // This column now uses the profile name
                        name: 'profile',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'service', // This column now uses the service name
                        name: 'service',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge bg-warning">' +
                                    `{{ __('third_party.Pending') }}` + '</span>';
                            } else if (data == 2) {
                                // return `<span class="badge bg-info">`
                                // $ {
                                //     translattion.in_assessment
                                // }
                                // `</span>`;
                                return '<span class="badge bg-info">'+`{{ __('third_party.In_assessment') }}`+'</span>';
                            } else if (data == 3) {
                                return '<span class="badge bg-danger">'+`{{ __('third_party.Rejected') }}`+'</span>';
                            }
                        }
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

        $("#addRequestBtn").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.third_party.getRequestForm', 'create') }}",
                success: function(response) {
                    $("#createFormContent").html(response);
                }
            });
        });


        // delete request
        $(document).on('click', '.delete-request', function() {
            var requestId = $(this).data('id');
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
                        url: '{{ route('admin.third_party.deleteRequest', ':id') }}'
                            .replace(':id', requestId),
                        type: 'DELETE',
                        success: function(response) {
                            var table = $("#requestsTable").DataTable();

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
        $(document).on('click', '.edit-request', function() {
            var requestId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.getRequestForm', ['type' => 'edit', 'request_id' => ':id']) }}'
                    .replace(':id', requestId),

                type: 'GET',
                success: function(response) {
                    $('#editRequestModal').modal('show'); // Show the modal

                    $("#editFormContent").html(response);
                    $("#submitEditForm").attr("data-id", requestId);
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });

        // view request
        $(document).on('click', '.view-request', function() {
            var requestId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.viewRequest', ':id') }}'.replace(
                    ':id',
                    requestId),
                type: 'GET',
                success: function(response) {

                    $('#viewRequestModal').modal('show'); // Show the modal
                    $("#viewFormContent").html(response); // Display content of view profile
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });

        // create third_party assessment
        $(document).on('click', '.create-assessment', function() {
            var requestId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.getQuestionnairesForm', ['type' => 'create_assessment', 'id' => ':id']) }}'
                    .replace(':id', requestId),

                type: 'GET',
                success: function(response) {
                    $('#createThirdPartyAssessmentModal').modal('show'); // Show the modal

                    $("#assessmentFormContent").html(response);
                    $("#submitCreateAssessment").attr("data-id", requestId);
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });
    </script>
@endsection
