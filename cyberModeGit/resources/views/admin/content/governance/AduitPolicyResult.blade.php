@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.AuditDocument'))
<style>
    .gov_btn {
        border-color:  #44225c!important;
        background-color:  #44225c!important;
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

    /* .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    } */

    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .alert {
        font-size: 1.1rem;
        /* Slightly larger font */
        border-radius: 0.5rem;
        /* Rounded corners */
    }

    .alert-dismissible .btn-close {
        margin-left: 15px;
        /* Space between alert text and close button */
    }

    .modal-body ul {
        margin: 0;
        /* Remove default margin for the list */
        padding-left: 20px;
        /* Indent the list */
    }

    .modal-body li {
        margin-bottom: 5px;
        /* Space between list items */
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

<input type="hidden" id="AduitId" value="{{ $id }}">
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 me-3">{{ __('locale.Audit Information') }} :</h5>
            <i class="fas fa-file-alt me-1"></i>
            <strong class="mx-0">{{ __('locale.AuditName') }}: {{ $auditDocumentPolicy->aduit_name }}</strong>
            <i class="fas fa-folder mx-1"></i>
            <strong class="mx-0">{{ __('locale.Document') }}:
                {{ $auditDocumentPolicy->document->document_name }}</strong>
            <i class="fas fa-check mx-1"></i> <!-- Add your status icon here -->
            <strong class="mx-0">{{ __('locale.Status') }}:
                @if (empty($statustotal))
                    <span class="badge rounded-pill badge-light-info">{{ __('locale.No Action') }}</span>
                @else
                    @switch($statustotal)
                        @case('Not Implemented')
                            <span class="badge rounded-pill badge-light-danger">{{ __('locale.Not Implemented') }}</span>
                        @break

                        @case('Not Applicable')
                            <span class="badge rounded-pill badge-light-secondary">{{ __('locale.Not Applicable') }}</span>
                        @break

                        @case('Partially Implemented')
                            <span
                                class="badge rounded-pill badge-light-warning">{{ __('locale.Partially Implemented') }}</span>
                        @break

                        @case('Implemented')
                            <span class="badge rounded-pill badge-light-success">{{ __('locale.Implemented') }}</span>
                        @break

                        @default
                            <span class="badge rounded-pill badge-light-info">{{ __('locale.No Action') }}</span>
                    @endswitch
                @endif
            </strong>
        </div>
        <div class="d-flex align-items-center">
            <h5 class="mb-0">{{ __('locale.AnswerSubmited') }} :</h5>
            <span class="check-send-result">
                <!-- The icon will be dynamically updated based on the response -->
                @if ($checkSendResult)
                    <!-- If there is a status (not null), show the check icon (correct) -->
                    <i class="fas fa-check mx-1 text-success"></i> <!-- Green check icon -->
                @else
                    <!-- If the status is null, show the mistake icon (error) -->
                    <i class="fas fa-times mx-1 text-danger"></i> <!-- Red "X" icon -->
                @endif
            </span>
        </div>

    </div>
</div>
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <!-- Div with Export and Import buttons -->
            <div class="action-buttons">
                <!-- Export button -->
                <button id="exportButton" class="btn btn-success">
                    {{ __('locale.Export') }}
                </button>

                <!-- Import button (opens modal) -->
                <button id="importButton" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#importModal">{{ __('locale.Import') }}</button>

                <!-- Import button (opens modal) -->
                <button id="SendResult" data-id="{{ $id }}" class="btn btn-primary">
                    {{ __('locale.SendResult') }}
                </button>
            </div>
        </div>
    </div>
</div>


<table id="AduitDocumentpoliciesTable" class="dt-advanced-server-search table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('locale.Policy Clause') }}</th>
            <th>{{ __('locale.AuditeeStatus') }}</th>
            {{-- <th>{{ __('locale.AuditeeStatus') }}</th> --}}
            <th>{{ __('locale.AuditerStatus') }}</th>
            <th>{{ __('locale.Action') }}</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be populated here by DataTables -->
    </tbody>
</table>
<!-- Modal for Importing Excel File -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">{{ __('locale.Import Excel File') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="importForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="fileInput">{{ __('locale.Choose Excel File') }}</label>
                        <input type="file" name="file" id="fileInputAnswer" class="form-control"
                            accept=".xlsx, .xls">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('locale.Upload') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1200px; width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">{{ __('locale.Add Comment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('locale.Close') }}"></button>
            </div>
            <div class="modal-body">
                <ul @if ($auditDocumentPolicy->enable_audit == 0) disabled @endif class="list-group mb-3" id="commentsList"></ul>
                <textarea @if ($auditDocumentPolicy->enable_audit == 0) disabled @endif class="form-control" id="commentInput" rows="3"
                    placeholder="{{ __('locale.Enter your comment') }}"></textarea>
            </div>
            @if ($auditDocumentPolicy->enable_audit == 1)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="saveCommentBtn">{{ __('locale.Send') }}</button>
                </div>
            @endif
        </div>
    </div>
</div>
<input type="hidden" value="{{ $auditDocumentPolicy->id }}" id="audit_id">
<div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1200px; width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileUploadModalLabel">{{ __('locale.Upload File') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('locale.Close') }}"></button>
            </div>
            <div class="modal-body">
                @if ($auditDocumentPolicy->enable_audit == 1)
                    {{-- <div class="mb-1">
                        <label for="evidenc_name" class="form-label">{{ __('locale.Evidence Name') }}:</label>
                        <input type="text" class="form-control" id="evidenc_name" required>
                        <div id="evidencNameError" class="text-danger mt-2" style="display: none;"></div>
                    </div> --}}
                    <div class="mb-1">
                        <label for="description" class="form-label">{{ __('locale.Description') }}:</label>
                        <input type="text" class="form-control" id="description" required>
                        <div id="descriptionError" class="text-danger mt-2" style="display: none;"></div>
                    </div>
                    <input type="hidden" value="{{ $auditDocumentPolicy->requires_file }}" id="requiredFile">
                    <div class="mb-3">
                        <label for="fileInput" class="form-label">{{ __('locale.Choose a file to upload') }}:</label>
                        <input type="file" class="form-control" id="fileInput" accept="*">
                        <div id="fileError" class="text-danger mt-2" style="display: none;"></div>
                    </div>
                @endif
                <h6>{{ __('locale.Existing Files') }}</h6>
                <div class="table-responsive">
                    <table id="existingFilesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                {{-- <th>{{ __('locale.Evidence Name') }}</th> --}}
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.File Name') }}</th>
                                <th>{{ __('locale.Upload Date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="existingFilesList">
                            <!-- Existing files will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($auditDocumentPolicy->enable_audit == 1)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                    <button type="button" id="uploadFileBtn"
                        class="btn btn-primary">{{ __('locale.Save') }}</button>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStatusModalLabel">{{ __('locale.Update Status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('locale.Close') }}"></button>
            </div>
            <div class="modal-body">
                <select class="form-control" id="statusSelect">
                    <option value="Not Implemented">{{ __('locale.Not Implemented') }}</option>
                    <option value="Not Applicable">{{ __('locale.Not Applicable') }}</option>
                    <option value="Partially Implemented">{{ __('locale.Partially Implemented') }}</option>
                    <option value="Implemented">{{ __('locale.Implemented') }}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                <button type="button" class="btn btn-primary"
                    id="updateStatusBtn">{{ __('locale.Update Status') }}</button>
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
    <!-- Bootstrap JS -->
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Set the CSRF token in the AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var aduitId = $('#AduitId').val();
            var table = $('#AduitDocumentpoliciesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.governance.GetDataAduit') }}',
                    data: function(d) {
                        d.aduitId = aduitId;
                    }
                },
                columns: [{
                        data: null, // Auto-incrementing index
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'policy_clause',
                        name: 'policy_clause'
                    },
                    {
                        data: 'pending_status', // Ensure your data contains the status
                        name: 'pending_status',
                        render: function(data, type, row) {
                            switch (data) {
                                case 'Not Implemented':
                                    return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.Not Implemented') }}</span>';
                                case 'Not Applicable':
                                    return '<span class="badge rounded-pill badge-light-secondary">{{ __('locale.Not Applicable') }}</span>';
                                case 'Partially Implemented':
                                    return '<span class="badge rounded-pill badge-light-warning">{{ __('locale.Partially Implemented') }}</span>';
                                case 'Implemented':
                                    return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Implemented') }}</span>';
                                default:
                                    return '<span class="badge rounded-pill badge-light-info">{{ __('locale.No Action') }}</span>';
                            }
                        }
                    },
                    // {
                    //     data: 'status', // Ensure your data contains the status
                    //     name: 'status',
                    //     render: function(data, type, row) {
                    //         switch (data) {
                    //             case 'Not Implemented':
                    //                 return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.Not Implemented') }}</span>';
                    //             case 'Not Applicable':
                    //                 return '<span class="badge rounded-pill badge-light-secondary">{{ __('locale.Not Applicable') }}</span>';
                    //             case 'Partially Implemented':
                    //                 return '<span class="badge rounded-pill badge-light-warning">{{ __('locale.Partially Implemented') }}</span>';
                    //             case 'Implemented':
                    //                 return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Implemented') }}</span>';
                    //             default:
                    //                 return '<span class="badge rounded-pill badge-light-info">{{ __('locale.No Action') }}</span>';
                    //         }
                    //     }
                    // },

                    {
                        data: 'auditer_status', // Ensure your data contains the status
                        name: 'auditer_status',
                        render: function(data, type, row) {
                            switch (data) {
                                case 'Not Implemented':
                                    return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.Not Implemented') }}</span>';
                                case 'Not Applicable':
                                    return '<span class="badge rounded-pill badge-light-secondary">{{ __('locale.Not Applicable') }}</span>';
                                case 'Partially Implemented':
                                    return '<span class="badge rounded-pill badge-light-warning">{{ __('locale.Partially Implemented') }}</span>';
                                case 'Implemented':
                                    return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Implemented') }}</span>';
                                default:
                                    return '<span class="badge rounded-pill badge-light-info">{{ __('locale.No Action') }}</span>';
                            }
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
        });


        $(document).on('click', '.add-comment', function() {
            const policyId = $(this).data('id');
            const documentPolicyId = $(this).data('document-policy-id');
            $('#commentInput').data('policyId', policyId).data('documentPolicyId', documentPolicyId);
            $('#commentModal').modal('show');

            // Fetch existing comments
            fetchComments(policyId, documentPolicyId);
        });

        // Function to fetch comments
        function fetchComments(policyId, documentPolicyId) {
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.governance.policies.comments.get', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    document_policy_id: documentPolicyId // Pass documentPolicyId as a query parameter
                },
                success: function(comments) {
                    // Clear the comment list
                    $('#commentsList').empty();

                    // Populate comments in the modal
                    comments.forEach(comment => {
                        // Format the created_at timestamp
                        const sentAt = new Date(comment.created_at).toLocaleString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });

                        // Append each comment with a compact layout and no extra margins
                        $('#commentsList').append(
                            '<li class="list-group-item">' + // Removed any extra margin/padding
                            '<div class="d-flex justify-content-between align-items-start">' +
                            // "Sent at" timestamp on the left
                            '<div class="text-muted small">' +
                            'Sent at: ' + sentAt +
                            '</div>' +
                            // User's name with a badge on the right
                            '<div>' +
                            '<span class="badge bg-primary">' + comment.name + '</span>' +
                            '</div>' +
                            '</div>' +
                            // Comment content below without any extra margin
                            '<div class="">' +
                            comment.comment +
                            '</div>' +
                            '</li>'
                        );
                    });
                },
                error: function() {
                    toastr.error('Error fetching comments.');
                }
            });
        }


        // Handle comment submission
        $('#saveCommentBtn').on('click', function() {
            const commentText = $('#commentInput').val();
            const policyId = $('#commentInput').data('policyId');
            const documentPolicyId = $('#commentInput').data('documentPolicyId');

            if (commentText.trim() === '') {
                toastr.error('Comment cannot be empty.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.governance.policies.comments.store', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    comment: commentText,
                    document_policy_id: documentPolicyId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message);

                    // Optionally, prepend the new comment immediately
                    $('#commentsList').prepend(
                        '<li class="list-group-item">' +
                        response.comment.comment +
                        '<span class="badge bg-success float-end">' + response.comment.user.name +
                        '</span></li>'
                    );

                    $('#commentInput').val(''); // Clear the input field after submission

                    // Fetch the updated list of comments
                    fetchComments(policyId, documentPolicyId);
                },
                error: function() {
                    toastr.error('Error adding comment.');
                }
            });
        });


        $(document).on('click', '.upload-file', function() {
            const policyId = $(this).data('id');
            const documentPolicyId = $(this).data('document-policy-id');
            $('#fileInput').data('policyId', policyId).data('documentPolicyId', documentPolicyId);

            // Clear the existing files list
            $('#existingFilesList').empty();

            // Fetch existing files
            fetchExistingFiles(policyId, documentPolicyId);

            $('#fileUploadModal').modal('show');
        });

        function fetchExistingFiles(policyId, documentPolicyId) {
            // Clear the existing files list
            $('#existingFilesList').empty();

            // Fetch existing files
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.governance.policies.files.index', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    document_policy_id: documentPolicyId // Pass documentPolicyId as a query parameter
                },
                success: function(response) {
                    // Assuming response is an object with a 'files' array
                    if (response.files.length > 0) {
                        response.files.forEach(file => {
                            const createdAt = new Date(file.created_at);
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            };
                            const formattedDate = createdAt.toLocaleDateString('en-US', options);

                            // Prepare file link or text based on file path and name
                            let fileLink;
                            if (file.file_path && file.file_name) {
                                fileLink =
                                    '<a href="{{ route('admin.governance.policies.files.download', '') }}/' +
                                    file.file_path + '" download="' + file.file_name + '">' +
                                    file.file_name + '</a>';
                            } else {
                                fileLink = file.file_name ? file.file_name : 'No file available';
                            }

                            $('#existingFilesList').append(
                                '<tr>' +
                                // '<td>' + file.evidenc_name + '</td>' +
                                '<td>' + file.description + '</td>' +
                                '<td>' + fileLink + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        $('#existingFilesList').append(
                            '<tr><td colspan="4" class="text-center">No files found.</td></tr>'
                        );
                    }
                },
                error: function() {
                    toastr.error('Error fetching existing files.');
                }
            });
        }




        $(document).on('click', '#uploadFileBtn', function() {
            // const evidencName = $('#evidenc_name').val();
            const description = $('#description').val();
            const fileInput = $('#fileInput')[0];
            const policyId = $('#fileInput').data('policyId');
            const documentPolicyId = $('#fileInput').data('documentPolicyId');

            // Validate the form fields
            // if (evidencName.trim() === '') {
            //     // $('#evidencNameError').text('Evidence name is required.').show();
            //     return;
            // } else {
            //     $('#evidencNameError').hide();
            // }

            if (description.trim() === '') {
                $('#descriptionError').text('Description is required.').show();
                return;
            } else {
                $('#descriptionError').hide();
            }
            var requiredFile = $('#requiredFile').val();
            if (fileInput.files.length === 0 && requiredFile == 1) {
                $('#fileError').text('Please select a file to upload.').show();
                return;
            } else {
                $('#fileError').hide();
            }

            // Prepare the form data
            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            // formData.append('evidenc_name', evidencName);
            formData.append('description', description); // Add description
            formData.append('document_policy_id', documentPolicyId);
            formData.append('_token', '{{ csrf_token() }}'); // Add CSRF token

            // AJAX request to upload the file
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.governance.policies.files.store', ['id' => ':id']) }}'.replace(
                    ':id',
                    policyId),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message);
                    // Optionally, you can clear the input fields
                    // $('#evidenc_name').val('');
                    $('#description').val(''); // Clear description field
                    $('#fileInput').val('');

                    // Refresh the existing files list
                    fetchExistingFiles(policyId, documentPolicyId);
                },
                error: function() {
                    toastr.error('Error uploading file.');
                }
            });
        });





        $(document).on('click', '.edit-status', function() {
            const policyId = $(this).data('id');
            const currentStatus = $(this).data('status'); // Get the current status
            const documentPolicyId = $(this).data('documentPolicyId');

            // Set the selected status in the select dropdown
            $('#statusSelect').val(currentStatus); // Make sure this matches the value of the options

            // Store the policy ID and document policy ID in the modal for later use
            $('#editStatusModal').data('policyId', policyId)
                .data('documentPolicyId', documentPolicyId)
                .modal('show'); // Open the modal
        });

        $('#updateStatusBtn').on('click', function() {
            const policyId = $('#editStatusModal').data('policyId');
            const documentPolicyId = $('#editStatusModal').data('documentPolicyId');
            const newStatus = $('#statusSelect').val();

            $.ajax({
                type: 'PATCH',
                url: '{{ route('admin.governance.policies.status.update', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    status: newStatus,
                    document_policy_id: documentPolicyId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success('Status updated successfully.');
                    $('#editStatusModal').modal('hide');
                    $('#AduitDocumentpoliciesTable').DataTable().ajax.reload();
                },
                error: function(xhr, response) {
                    if (xhr.responseJSON.message === "error_evidence_required") {
                        Swal.fire({
                            title: "Action Not Completed",
                            text: "You cannot update the status until you upload evidence.",
                            icon: "error", // Correct icon for error messages
                            buttons: true,
                            dangerMode: true,
                        });
                    } else {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.message;
                            toastr.error(errors); // Show the specific error message
                        } else {
                            toastr.error('Error updating status.');
                        }
                    }

                }
            });
        });


        $('#exportButton').on('click', function(e) {
            e.preventDefault(); // Prevent default action

            // Define or retrieve documentPolicyId as needed
            var documentPolicyId = $('#audit_id').val(); // Example: Get ID from a dropdown

            // Ensure documentPolicyId is valid
            if (documentPolicyId) {
                // Create a form to submit the download request
                var form = $('<form>', {
                    action: '{{ route('admin.governance.auditDocumentPoliciesexport') }}',
                    method: 'POST',
                    target: '_blank' // Open in a new tab
                });

                // Add CSRF token
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: csrfToken
                }));

                // Add document policy ID to form
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'document_policy_id',
                    value: documentPolicyId
                }));

                // Optionally add a type if needed
                // form.append($('<input>', { type: 'hidden', name: 'type', value: 'xlsx' })); // if needed

                // Submit the form
                form.appendTo('body').submit().remove(); // Submit the form and remove it
            } else {
                alert("Please select a document policy to export.");
            }
        });

        $('#importForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('admin.governance.importStatusAndCommentToAudit') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,

                // Show block UI before sending the request
                beforeSend: function() {
                    $.blockUI({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('importing')]) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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

                // Unblock UI after the request is complete
                complete: function() {
                    $.unblockUI();
                },

                success: function(response) {
                    toastr.success('Action completed successfully.');
                    $('#importModal').modal('hide');
                    location.reload();
                },

                error: function(xhr, status, error) {
                    // Clear previous errors
                    $('#importModal .modal-body').find('.alert').remove();

                    // Display general error message
                    let generalErrorMessage = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i> Oops!</strong> 
                    An issue has occurred during the manipulation of the Excel file. 
                    Kindly download the appropriate template and complete it as required.
                </div>
            `;

                    $('#importModal .modal-body').append(generalErrorMessage);

                    // Display validation errors if available
                    if (xhr.responseJSON && xhr.responseJSON.failures) {
                        let errorList = xhr.responseJSON.failures.map(failure => {
                            return `<li>Row ${failure.row}: ${failure.errors.join(', ')}</li>`;
                        }).join('');

                        let validationErrorMessage = `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-triangle"></i> Validation Errors:</strong>
                        <ul>${errorList}</ul>
                    </div>
                `;
                        $('#importModal .modal-body').append(validationErrorMessage);
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#SendResult').on('click', function() {
                let id = $(this).data('id'); // Get the ID from the button's data-id attribute

                // Block the UI to show loading indicator
                $.blockUI({
                    message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('importing')]) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                    css: {
                        backgroundColor: 'transparent',
                        color: '#fff',
                        border: '0'
                    },
                    overlayCSS: {
                        opacity: 0.5
                    }
                });

                $.ajax({
                    url: "{{ route('admin.governance.sendResultAudit') }}", // Route URL
                    type: "POST", // HTTP method
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token for security
                        id: id // Sending the ID to the backend
                    },
                    success: function(response) {
                        // Handle success response
                        $('#AduitDocumentpoliciesTable').DataTable().ajax.reload();

                        toastr.success(response.message || 'Action completed successfully.');

                        // Update the icon based on checkSendResult value
                        if (response.checkSendResult) {
                            // Show check icon if result is sent
                            $('.check-send-result').html(
                                '<i class="fas fa-check mx-1 text-success"></i>');
                        } else {
                            // Show error icon if result is not sent
                            $('.check-send-result').html(
                                '<i class="fas fa-times mx-1 text-danger"></i>');
                        }

                        // Unblock the UI after success
                        $.unblockUI();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        if (xhr.status === 422) {
                            // Parse the error response if it's JSON
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                                xhr.responseJSON.message :
                                'An error occurred while processing your request.';

                            // Show the error message using SweetAlert or Toastr
                            if (xhr.responseJSON && xhr.responseJSON.message && xhr.responseJSON
                                .message.includes('error_evidence_required_for_')) {
                                // If it's an evidence required error, show a more specific message
                                Swal.fire({
                                    title: "Action Not Completed",
                                    text: `Evidence is required for document policy Name: ${xhr.responseJSON.message.split('_')[4]}`,
                                    icon: "error", // Correct icon for error messages
                                    buttons: true,
                                    dangerMode: true,
                                });
                            } else {
                                // Generic error handling
                                Swal.fire({
                                    title: "Action Not Completed",
                                    text: errorMessage,
                                    icon: "error", // Correct icon for error messages
                                    buttons: true,
                                    dangerMode: true,
                                });
                            }
                        } else {
                            // Generic error handler for other statuses
                            toastr.error('Error updating status.');
                        }

                        // Unblock the UI after error
                        $.unblockUI();
                    }
                });
            });
        });
    </script>
@endsection
