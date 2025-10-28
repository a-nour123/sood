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
    <input type="hidden" id="userId" value="{{ $user_id }}">
    <input type="hidden" id="documentId" value="{{ $document_id }}">
    <input type="hidden" id="documentPolicyId" value="{{ json_encode($policyDocumentIds) }}">
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
                <strong class="mx-0" id="statusDisplay">{{ __('locale.Status') }}:
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


        </div>
        @if($auditDocumentPolicy->enable_audit == 1)
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-success me-2" id="approveAllBtn">{{ __('locale.Approve All') }}</button>
                <button class="btn btn-info" id="calculateTotalBtn">{{ __('locale.CalculateTotal') }}</button>
            </div>
        </div>
        @endif
    </div>









    <table id="AduitDocumentpoliciesTable" class="dt-advanced-server-search table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('locale.Policy Clause') }}</th>
                <th>{{ __('locale.AuditeeStatus') }}</th>
                <th>{{ __('locale.AuditerStatus') }}</th>
                <th>{{ __('locale.Action') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here by DataTables -->
        </tbody>
    </table>

    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1200px; width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">{{ __('locale.Add Comment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('locale.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <ul @if($auditDocumentPolicy->enable_audit == 0) disabled @endif class="list-group mb-3" id="commentsList"></ul>
                    <textarea @if($auditDocumentPolicy->enable_audit == 0) disabled @endif class="form-control" id="commentInput" rows="3" placeholder="{{ __('locale.Enter your comment') }}"></textarea>
                </div>
                @if($auditDocumentPolicy->enable_audit == 1)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                    <button type="button" class="btn btn-primary" id="saveCommentBtn">{{ __('locale.Send') }}</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1200px; width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileUploadModalLabel">{{ __('locale.Existing Files') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('locale.Close') }}"></button>
                </div>
                <div class="modal-body">
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
                @if($auditDocumentPolicy->enable_audit == 1)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="updateStatusBtn">{{ __('locale.Update Status') }}</button>
                </div>
                @endif
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
            var userId = $('#userId').val();
            var documentId = $('#documentId').val();
            var table = $('#AduitDocumentpoliciesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.governance.GetDataAduitForAuditer') }}',
                    data: function(d) {
                        d.aduitId = aduitId;
                        d.userId = userId;
                        d.documentId = documentId;
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
                        data: 'status', // Ensure your data contains the status
                        name: 'status',
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


        // Handle comment submission
        $('#saveCommentBtn').on('click', function() {
            const commentText = $('#commentInput').val();
            const policyId = $('#commentInput').data('policyId');
            const userId = $('#userId').val();
            const documentPolicyId = $('#commentInput').data('documentPolicyId'); // Ensure this is defined
            if (commentText.trim() === '') {
                toastr.error('Comment cannot be empty.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.governance.policies.comments.storeCommentForAuditer', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    comment: commentText,
                    document_policy_id: documentPolicyId,
                    userId: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message);

                    // Clear the input field after submission
                    $('#commentInput').val('');

                    // Fetch updated comments
                    fetchComments(policyId, documentPolicyId, userId);
                },
                error: function() {
                    toastr.error('Error adding comment.');
                }
            });
        });

        // Function to fetch existing comments
        function fetchComments(policyId, documentPolicyId, userId) {
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.governance.policies.comments.GetCommentsForAduiter', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    document_policy_id: documentPolicyId,
                    userId: userId,
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

        // Call fetchComments in the add-comment click event as well
        $(document).on('click', '.add-comment', function() {
            const policyId = $(this).data('id');
            const documentPolicyId = $(this).data('document-policy-id');
            $('#commentInput').data('policyId', policyId).data('documentPolicyId', documentPolicyId);
            $('#commentModal').modal('show');
            const userId = $('#userId').val();

            // Fetch existing comments
            fetchComments(policyId, documentPolicyId, userId);
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
            const userId = $('#userId').val();

            // Fetch existing files
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.governance.policies.files.index', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    userId: userId,
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

                            $('#existingFilesList').append(
                                '<tr>' +
                                // '<td>' + file.evidenc_name + '</td>' +
                                '<td>' + file.description + '</td>' +
                                '<td>' +
                                '<a href="{{ route('admin.governance.policies.files.download', '') }}/' +
                                file.file_path + '" download="' +
                                file.file_name + '">' +
                                file.file_name +
                                '</a>' +
                                '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        $('#existingFilesList').append(
                            '<tr><td colspan="5" class="text-center">No files found.</td></tr>'
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

            if (fileInput.files.length === 0) {
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


        $(document).on('click', '.edit-status-auditer', function() {
            const policyId = $(this).data('id');
            const currentStatus = $(this).data('status'); // Get the current status
            const documentPolicyId = $(this).data('documentPolicyId');
            const userId = $(this).data('user-id'); // Get userId



            // Perform the AJAX request immediately
            $.ajax({
                type: 'PATCH',
                url: '{{ route('admin.governance.policies.status.approve', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    document_policy_id: documentPolicyId,
                    user_id: userId, // Include userId in the request data
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success('Status updated successfully.');
                    $('#AduitDocumentpoliciesTable').DataTable().ajax.reload();
                },
                error: function() {
                    toastr.error('Error updating status.');
                }
            });
        });



        $(document).on('click', '.edit-status-auditer-auditee', function() {
            const policyId = $(this).data('id');
            const currentStatus = $(this).data('status'); // Get the current status
            const documentPolicyId = $(this).data('documentPolicyId');
            const userId = $(this).data('user-id'); // Get userId

            // Set the selected status in the select dropdown
            $('#statusSelect').val(currentStatus); // Make sure this matches the value of the options

            // Store the policy ID, document policy ID, and user ID in the modal for later use
            $('#editStatusModal').data('policyId', policyId)
                .data('documentPolicyId', documentPolicyId)
                .data('userId', userId) // Store userId
                .modal('show'); // Open the modal
        });

        $('#updateStatusBtn').on('click', function() {
            const policyId = $('#editStatusModal').data('policyId');
            const documentPolicyId = $('#editStatusModal').data('documentPolicyId');
            const userId = $('#editStatusModal').data('userId'); // Retrieve userId
            const newStatus = $('#statusSelect').val();

            $.ajax({
                type: 'PATCH',
                url: '{{ route('admin.governance.policies.status.reject', ['id' => ':id']) }}'
                    .replace(':id', policyId),
                data: {
                    status: newStatus,
                    document_policy_id: documentPolicyId,
                    user_id: userId, // Include userId in the request data
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success('Status updated successfully.');
                    $('#editStatusModal').modal('hide');
                    $('#AduitDocumentpoliciesTable').DataTable().ajax.reload();
                },
                error: function() {
                    toastr.error('Error updating status.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#approveAllBtn').on('click', function() {
                const aduitId = $('#AduitId').val();
                const userId = $('#userId').val();
                const documentPolicyId = $('#documentPolicyId').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.governance.policies.approveAll') }}',
                    data: {
                        aduit_id: aduitId,
                        user_id: userId,
                        documentPolicyId: documentPolicyId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var oTable = $('#AduitDocumentpoliciesTable').DataTable();
                        oTable.ajax.reload();

                        // Check if there are any policies without actions
                        if (response.policies_without_actions) {
                            // Show SweetAlert with the list of policies
                            swal.fire({
                                title: "Action Completed",
                                text: `Your action has been successfully completed. However, there are some clauses (policies) that the auditee has not taken any action on: ${response.policies_without_actions}`,
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            });
                        } else {
                            // Show success message
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Handle error
                        toastr.error('Error approving all policies.');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#calculateTotalBtn').on('click', function() {
                const aduitId = $('#AduitId').val();
                const userId = $('#userId').val();
                const documentPolicyId = $('#documentPolicyId').val();
                const documentId = $('#documentId').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.governance.policies.CalcTotalStatus') }}',
                    data: {
                        aduit_id: aduitId,
                        user_id: userId,
                        documentPolicyId: documentPolicyId,
                        documentId: documentId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var oTable = $('#AduitDocumentpoliciesTable').DataTable();
                        oTable.ajax.reload();
                        // Show success message
                        toastr.success(response.message);

                        // Update the total status display
                        const newTotalStatus = response.data
                        .total_status; // Assuming your response contains the total status
                        const statusBadge = getStatusBadge(
                        newTotalStatus); // Get the appropriate badge HTML

                        // Update the status display in your HTML
                        $('#statusDisplay').html(
                        statusBadge); // Assuming you have an element with id="statusDisplay"
                    },
                    error: function(xhr) {
                        // Handle error
                        toastr.error('Error approving all policies.');
                    }
                });
            });

            function getStatusBadge(status) {
                switch (status) {
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
        });
    </script>




@endsection
