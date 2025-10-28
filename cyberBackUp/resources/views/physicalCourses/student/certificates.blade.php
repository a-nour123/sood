@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.certificates'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/course_addon.css') }}">
    <style>
        .stats-card {
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .certificate-progress {
            height: 8px;
            border-radius: 4px;
        }

        .certificate-id {
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header with Breadcrumbs -->
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2">
                <div class="row breadcrumbs-top widget-grid">
                    <div class="col-12">
                        <div class="page-title mt-2">
                            <div class="row">
                                <div class="col-sm-6 ps-0">
                                    @if (@isset($breadcrumbs))
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('admin.dashboard') }}" style="display: flex;">
                                                    <svg class="stroke-icon">
                                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-certificate text-primary"></i> {{ __('physicalCourses.course_certificates') }}
            </h1>
        </div>

        <!-- Course Info Card -->




        <!-- Certificates Table -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-certificate me-2"></i>{{ __('physicalCourses.generated_certificates') }}
                </h6>
                <div class="card-tools">
                    <button class="btn btn-sm btn-outline-primary" id="refreshCertificatesTable">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="certificatesTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('physicalCourses.student_name') }}</th>
                                <th>{{ __('physicalCourses.certificate_id') }}</th>
                                <th>{{ __('physicalCourses.grade') }}</th>
                                <th>{{ __('physicalCourses.percentage') }}</th>
                                <th>{{ __('physicalCourses.issue_date') }}</th>
                                <th>{{ __('physicalCourses.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTable will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{ __('physicalCourses.loading') }}</span>
                    </div>
                    <p class="mt-2 mb-0">{{ __('physicalCourses.processing_request') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Preview Modal -->
    <div class="modal fade" id="certificatePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('physicalCourses.certificate_preview') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="certificatePreviewContent" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">{{ __('physicalCourses.loading') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.buttons.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            let certificatesTable = $('#certificatesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.physical-courses.certificates.user.courses.ajax') }}",
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('DataTable Ajax Error:', error);
                        toastr.error('{{ __('physicalCourses.error_loading_data') }}');
                    }
                },
                columns: [{
                        data: 'user_name',
                        name: 'user_name',
                        title: '{{ __('physicalCourses.student_name') }}'
                    },
                    {
                        data: 'certificate_id',
                        name: 'certificate_id',
                        title: '{{ __('physicalCourses.certificate_id') }}'
                    },
                    {
                        data: 'grade_display',
                        name: 'grade_display',
                        title: '{{ __('physicalCourses.grade') }}',
                        orderable: false
                    },
                    {
                        data: 'percentage',
                        name: 'percentage',
                        title: '{{ __('physicalCourses.percentage') }}',
                        orderable: false
                    },
                    {
                        data: 'issued_date',
                        name: 'issued_date',
                        title: '{{ __('physicalCourses.issue_date') }}'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        title: '{{ __('physicalCourses.actions') }}',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [4, 'desc']
                ], // Sort by issued_date
                language: {
                    url: "{{ asset('vendors/js/tables/datatable/lang/' . app()->getLocale() . '.json') }}",
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">{{ __('physicalCourses.loading') }}</span></div>'
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> {{ __('physicalCourses.export_excel') }}',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> {{ __('physicalCourses.export_pdf') }}',
                        className: 'btn btn-danger btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> {{ __('physicalCourses.print') }}',
                        className: 'btn btn-info btn-sm'
                    }
                ],
                responsive: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ]
            });

            // Refresh tables
            $('#refreshCertificatesTable').on('click', function() {
                $(this).find('i').addClass('fa-spin');
                certificatesTable.ajax.reload(function() {
                    $('#refreshCertificatesTable i').removeClass('fa-spin');
                    toastr.success('{{ __('physicalCourses.table_refreshed') }}');
                });
            });

            // Export functionality
            $('#exportBtn').on('click', function() {
                certificatesTable.button('.buttons-excel').trigger();
            });

            // Delete certificate with improved error handling
            $(document).on('click', '.delete-certificate', function() {
                let certificateId = $(this).data('id');
                let courseId = $(this).data('course-id');
                let button = $(this);
                let row = button.closest('tr');

                // Check if we have a specific course or if it's a general certificate delete
                let url;
                if (courseId) {
                    url =
                        "{{ route('admin.physical-courses.certificates.courses.delete-certificate', [$course->id ?? ':course', ':certificate']) }}"
                        .replace(':course', courseId)
                        .replace(':certificate', certificateId);
                } else {
                    // Fallback URL for general certificate deletion
                    url = "{{ url('admin/physical-courses/certificates') }}/" + certificateId;
                }

                Swal.fire({
                    title: '{{ __('physicalCourses.delete_certificate') }}',
                    text: '{{ __('physicalCourses.are_you_sure_delete_certificate') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('physicalCourses.yes_delete') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return new Promise((resolve) => {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                }
                            });

                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                success: function(response) {
                                    resolve(response);
                                },
                                error: function(xhr) {
                                    Swal.showValidationMessage(
                                        '{{ __('physicalCourses.error_deleting_certificate') }}: ' +
                                        (xhr.responseJSON?.message ||
                                            xhr.statusText)
                                    );
                                }
                            });
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        toastr.success(
                            '{{ __('physicalCourses.certificate_deleted_successfully') }}');
                        certificatesTable.ajax.reload();

                        // Update statistics if they exist on the page
                        if (typeof updateCertificateStats === 'function') {
                            updateCertificateStats();
                        } else {
                            // Simple reload for statistics update
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    }
                });
            });

            // Certificate preview functionality
            $(document).on('click', '.preview-certificate', function() {
                let certificateId = $(this).data('id');
                let previewUrl = "{{ url('admin/physical-courses/certificates/preview') }}/" +
                    certificateId;

                $('#certificatePreviewModal').modal('show');
                $('#certificatePreviewContent').html(`
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">{{ __('physicalCourses.loading') }}</span>
            </div>
            <p class="mt-2">{{ __('physicalCourses.loading_preview') }}</p>
        `);

                // Load preview content
                $.get(previewUrl)
                    .done(function(data) {
                        $('#certificatePreviewContent').html(data);
                    })
                    .fail(function() {
                        $('#certificatePreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ __('physicalCourses.error_loading_preview') }}
                    </div>
                `);
                    });
            });

            // Auto-refresh every 30 seconds (optional)
            setInterval(function() {
                if ($('#autoRefresh').is(':checked')) {
                    certificatesTable.ajax.reload(null, false); // Don't reset paging
                }
            }, 30000);
        });
    </script>

@endsection
