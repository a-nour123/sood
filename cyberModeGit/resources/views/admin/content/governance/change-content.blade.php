@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.DocumentContent'))
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

    .cke_contents {
        border: 1px solid #ced4da !important;
        /* Bootstrap's default input border color */
        border-radius: 0.25rem !important;
        /* Bootstrap's default border radius */
    }

    /* Style when editor is focused */
    .cke_focus {
        outline: 0 !important;
    }

    /* Style the editor's outer container */
    .cke_top,
    .cke_bottom {
        border-color: #ced4da !important;
        background: #f8f9fa !important;
        /* Light gray background */
    }

    .see-more {
        color: #0d6efd;
        text-decoration: underline;
        cursor: pointer;
        font-size: 0.9em;
        margin-left: 5px;
    }

    .see-more:hover {
        color: #0a58ca;
    }

    .modal-body pre {
        font-family: inherit;
        margin: 0;
        padding: 0;
        background: none;
        border: none;
    }

    /* Add this to your CSS file */
    #DocumentContentTable a.btn-outline-primary {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
        display: inline-block;
        vertical-align: middle;
    }

    #DocumentContentTable .text-muted {
        font-style: italic;
        color: #6c757d;
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

    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>

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
                                @if (auth()->user()->hasPermission('document.createContent'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#AddContentToDocument">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section id="advanced-search-datatable">
        <input type="hidden" id="documentId" value="{{ $document->id }}">
        <div class="card-datatable">
            <div class="col-12">
                <div class="card">
                    <table id="DocumentContentTable" class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.OldContent') }}</th>
                                <th>{{ __('locale.NewContent') }}</th>
                                <th>{{ __('locale.File') }}</th>
                                <th>{{ __('locale.CreatedBy') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal fade" id="fullContentModal" tabindex="-1" aria-labelledby="fullContentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fullContentModalLabel">{{ __('locale.FullContent') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ __('locale.Close') }}"></button>
                    </div>
                    <div class="modal-body" id="fullContentModalBody">
                        <!-- Full content will appear here -->
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Structure for adding a new content --}}
        <div class="modal fade" id="AddContentToDocument" tabindex="-1" aria-labelledby="AddContentToDocumentLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddContentToDocumentLabel">
                            {{ __('locale.AddContentToDocument') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="newPolicyForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="document_id" id="documentId" value="">

                            <!-- CKEditor Textarea -->
                            <div class="mb-3">
                                <label for="documentContent" class="form-label">{{ __('locale.Content') }}</label>
                                <textarea class="form-control" id="documentContent" name="content" rows="10"></textarea>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <label for="documentFile" class="form-label">{{ __('locale.File') }}</label>
                                <input class="form-control" type="file" id="documentFile" name="file">
                                <small class="text-muted">{{ __('locale.MaxFileSize') }}: 5MB</small>
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
        <div class="modal fade" id="editContentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Content Changes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="editContentForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" id="documentId" value="{{ $document->id }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="old_content" class="form-label">Old Content</label>
                                    <textarea class="form-control" disabled id="old_content" name="old_content" rows="10"></textarea>
                                    <div class="mt-2">
                                        <label class="form-label">Old File</label>
                                        <div id="oldFileContainer"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="new_content" class="form-label">New Content</label>
                                    <textarea class="form-control" id="new_content" name="new_content" rows="10"></textarea>
                                    <div class="mt-2">
                                        <label for="new_file" class="form-label">New File</label>
                                        <input class="form-control" type="file" id="new_file" name="file">
                                        <small class="text-muted">Leave empty to keep existing file</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
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
        CKEDITOR.replace('documentContent');


        const documentId = $('#documentId').val();
        // Initialize DataTable
        var table = $('#DocumentContentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.governance.changeContentDocument') }}',
                type: 'GET',
                data: {
                    document_id: documentId
                }
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'old_content',
                    name: 'old_content',
                    render: function(data, type, row) {
                        const plainText = data.replace(/<[^>]*>/g, '');
                        const shortText = plainText.length > 50 ?
                            plainText.substring(0, 50) + '...' :
                            plainText;

                        return `
                <div class="text-truncate">
                    ${shortText}
                    ${plainText.length > 50 ? 
                        `<a href="#" class="see-more" data-content="${encodeURIComponent(plainText)}" data-title="Old Content">See More</a>` : 
                        ''}
                </div>`;
                    }
                },
                {
                    data: 'new_content',
                    name: 'new_content',
                    render: function(data, type, row) {
                        const plainText = data.replace(/<[^>]*>/g, '');
                        const shortText = plainText.length > 50 ?
                            plainText.substring(0, 50) + '...' :
                            plainText;

                        return `
                <div class="text-truncate">
                    ${shortText}
                    ${plainText.length > 50 ? 
                        `<a href="#" class="see-more" data-content="${encodeURIComponent(plainText)}" data-title="New Content">See More</a>` : 
                        ''}
                </div>`;
                    }
                },
                {
                    data: 'file',
                    name: 'file_path',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'changed_by_user.name',
                    name: 'changed_by_user.name',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                }
            ]
        });

        // Add click handler for "See More" links
        $(document).on('click', '.see-more', function(e) {
            e.preventDefault();
            const content = decodeURIComponent($(this).data('content'));
            const title = $(this).data('title');

            // Create and show modal
            const modal = `
                <div class="modal fade" id="contentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${title}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <pre style="white-space: pre-wrap;">${content}</pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>`;

            $('body').append(modal);
            $('#contentModal').modal('show');

            // Remove modal when closed
            $('#contentModal').on('hidden.bs.modal', function() {
                $(this).remove();
            });
        });
        $(document).on('click', '.edit-content', function() {

            const id = $(this).data('id');
            const oldContent = $(this).data('old-content');
            const newContent = $(this).data('new-content');
            const filePath = $(this).data('file-path');

            // Destroy existing instances if they exist
            if (CKEDITOR.instances['new_content']) {
                CKEDITOR.instances['new_content'].destroy();
            }
            if (CKEDITOR.instances['old_content']) {
                CKEDITOR.instances['old_content'].destroy();
            }

            // Initialize new instances
            CKEDITOR.replace('new_content');
            CKEDITOR.replace('old_content');

            // Set values and show modal
            $('#editContentModal').find('input[name="id"]').val(id);
            $('#editContentModal').find('textarea[name="old_content"]').val(oldContent);
            $('#editContentModal').find('textarea[name="new_content"]').val(newContent);
            var fileContainer = $('#oldFileContainer');
            fileContainer.empty();

            if (filePath) {
                var fileName = filePath.split('/').pop();
                fileContainer.append(`
            <div class="d-flex align-items-center mt-2">
                <a href="${filePath}" download class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-download"></i> ${fileName}
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger remove-file-btn">
                    <i class="fas fa-trash"></i> Remove
                </button>
                    <input type="hidden" name="existing_file_path" value="${filePath}">
                </div>
            `);
            } else {
                fileContainer.append('<span class="text-muted">No file attached</span>');
            }
            $('#editContentModal').modal('show');
        });
        $(document).on('click', '.remove-file-btn', function() {
            $(this).closest('div').remove();
            // Add a hidden input to indicate file should be removed
            $('#editContentForm').append('<input type="hidden" name="remove_file" value="1">');
        });
        // For editing content with file
        $('#editContentForm').on('submit', function(e) {
            e.preventDefault();

            var editor = CKEDITOR.instances['new_content'];
            if (editor) {
                $('#new_content').val(editor.getData());
            }

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('admin.governance.updateDocumentContent') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editContentModal').modal('hide');
                    table.ajax.reload();
                 },
                error: function(xhr) {
                    toastr.error('Error updating content');
                }
            });
        });
        // For adding new content with file
        $('#newPolicyForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let content = CKEDITOR.instances.documentContent.getData();
            formData.set('content', content);
            const documentId = $('#documentId').val();
            formData.set('document_id', documentId);
            $.ajax({
                url: "{{ route('admin.governance.creatDocumentContent') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#AddContentToDocument').modal('hide');
                    if (response.status) {
                        makeAlert('success', response.message, 'Success');
                        CKEDITOR.instances.documentContent.setData('');
                        $('#documentFile').val('');
                        table.ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).flat().join('<br>');
                        makeAlert('error', errorMessages, 'Validation Error');
                    } else {
                        makeAlert('error', xhr.responseJSON.message || 'An error occurred', 'Error');
                    }
                }
            });
        });

        // For editing content with file
        $('#editContentForm').on('submit', function(e) {
            e.preventDefault();

            var editor = CKEDITOR.instances['new_content'];
            if (editor) {
                $('#new_content').val(editor.getData());
            }

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('admin.governance.updateDocumentContent') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editContentModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Content updated successfully');
                },
                error: function(xhr) {
                    toastr.error('Error updating content');
                }
            });
        });
        $(document).on('click', '.delete-content', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.governance.deleteDocumentContent') }}',
                        type: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                table.ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Your content has been deleted.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Failed to delete content',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON.message || 'Something went wrong',
                                'error'
                            );
                        }
                    });
                }
            });

        });
        $(document).on('click', '.accept-content', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to accept this content?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, accept it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.governance.acceptDocumentContent') }}',
                        type: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                table.ajax.reload();
                                Swal.fire(
                                    'Accepted!',
                                    'The content has been accepted successfully.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Failed to accept content.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });



        $('.modal').on('hidden.bs.modal', function() {
            var editor = CKEDITOR.instances['documentContent'];
            if (editor) {
                editor.setData(''); // This clears the CKEditor content
            }
        });
    </script>

@endsection
