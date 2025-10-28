@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.certificates') . ' - ' . $course->name)

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
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> {{ __('physicalCourses.print') }}
                </button>
                <button class="btn btn-outline-success" id="exportBtn">
                    <i class="fas fa-file-excel me-1"></i> {{ __('physicalCourses.export') }}
                </button>
            </div>
        </div>

        <!-- Course Info Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="card-title mb-2 text-primary">{{ $course->name }}</h5>
                        <div class="d-flex flex-wrap gap-3 text-muted">
                            @php
                                $firstSession = $course->schedules->first();
                                $lastSession = $course->schedules->last();
                            @endphp

                            @if ($firstSession && $lastSession)
                                <span>
                                    <i class="fas fa-calendar me-2"></i>
                                    {{ \Carbon\Carbon::parse($firstSession->session_date)->format('d M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($lastSession->session_date)->format('d M Y') }}
                                </span>
                            @endif
                            <span><i class="fas fa-star me-2"></i>{{ __('physicalCourses.passing_grade') }}:
                                {{ $course->passing_grade }}/{{ $course->grade }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge bg-{{ $course->course_complete ? 'success' : 'warning' }} fs-6 px-3 py-2">
                            <i class="fas fa-{{ $course->course_complete ? 'check-circle' : 'clock' }} me-1"></i>
                            {{ $course->course_complete ? __('physicalCourses.completed') : __('physicalCourses.in_progress') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow-sm h-100 py-2 stats-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    {{ __('physicalCourses.total_eligible') }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $eligibleUsers->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow-sm h-100 py-2 stats-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    {{ __('physicalCourses.generated') }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $certificates->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-certificate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow-sm h-100 py-2 stats-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    {{ __('physicalCourses.pending') }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $eligibleUsers->count() - $certificates->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow-sm h-100 py-2 stats-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    {{ __('physicalCourses.progress') }}
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $eligibleUsers->count() > 0 ? round(($certificates->count() / $eligibleUsers->count()) * 100) : 0 }}%
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info certificate-progress" role="progressbar"
                                                style="width: {{ $eligibleUsers->count() > 0 ? round(($certificates->count() / $eligibleUsers->count()) * 100) : 0 }}%"
                                                aria-valuenow="{{ $eligibleUsers->count() > 0 ? round(($certificates->count() / $eligibleUsers->count()) * 100) : 0 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percentage fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Row -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">{{ __('physicalCourses.certificate_actions') }}</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            @if ($course->course_complete)
                                <form
                                    action="{{ route('admin.physical-courses.certificates.courses.generate-missing-certificates', $course->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" id="generateMissingBtn">
                                        <i
                                            class="fas fa-plus me-2"></i>{{ __('physicalCourses.generate_missing_certificates') }}
                                    </button>
                                </form>

                                <form
                                    action="{{ route('admin.physical-courses.certificates.courses.regenerate-certificates', $course->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" id="regenerateAllBtn">
                                        <i class="fas fa-refresh me-2"></i>{{ __('physicalCourses.regenerate_all') }}
                                    </button>
                                </form>

                                {{-- <button type="button" class="btn btn-info" id="previewCertificateBtn">
                                    <i class="fas fa-eye me-2"></i>{{ __('physicalCourses.preview_certificate') }}
                                </button> --}}
                            @else
                                <div class="alert alert-warning mb-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ __('physicalCourses.course_must_be_complete') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Eligible Users without Certificates -->
        <div class="card shadow-sm">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-clock me-2"></i>{{ __('physicalCourses.eligible_users_without_certificates') }}
                </h6>
                <div class="card-tools">
                    <button class="btn btn-sm btn-outline-primary" id="refreshEligibleTable">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="eligibleUsersTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('physicalCourses.student_name') }}</th>
                                <th>{{ __('physicalCourses.grade') }}</th>
                                <th>{{ __('physicalCourses.percentage') }}</th>
                                <th>{{ __('physicalCourses.status') }}</th>
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
                    url: "{{ route('admin.physical-courses.certificates.courses.ajax', $course->id) }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'certificate_id',
                        name: 'certificate_id'
                    },
                    {
                        data: 'grade_display',
                        name: 'grade_display'
                    },
                    {
                        data: 'percentage',
                        name: 'percentage'
                    },
                    {
                        data: 'issued_date',
                        name: 'issued_date'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [4, 'desc']
                ],
                language: {
                    url: "{{ asset('vendors/js/tables/datatable/lang/' . app()->getLocale() . '.json') }}"
                }
            });

            let eligibleUsersTable = $('#eligibleUsersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.physical-courses.certificates.courses.eligible-users-ajax', $course->id) }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'grade_display',
                        name: 'grade_display'
                    },
                    {
                        data: 'percentage',
                        name: 'percentage'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: "{{ asset('vendors/js/tables/datatable/lang/' . app()->getLocale() . '.json') }}"
                }
            });

            // Refresh tables
            $('#refreshCertificatesTable').on('click', function() {
                certificatesTable.ajax.reload();
            });

            $('#refreshEligibleTable').on('click', function() {
                eligibleUsersTable.ajax.reload();
            });

            // Generate single certificate
            $(document).on('click', '.generate-single-certificate', function() {
                let userId = $(this).data('user-id');
                let courseId = $(this).data('course-id');
                let userName = $(this).data('user-name');
                let button = $(this);
                let url =
                    "{{ route('admin.physical-courses.certificates.courses.generate-single-certificate', [$course->id, ':user']) }}"
                    .replace(':user', userId);

                Swal.fire({
                    title: '{{ __('physicalCourses.generate_certificate') }}',
                    text: '{{ __('physicalCourses.are_you_sure_generate_certificate') }}' + ' ' +
                        userName + '?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('physicalCourses.yes_generate') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.prop('disabled', true);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.post(url)
                            .done(function(response) {
                                toastr.success(
                                    '{{ __('physicalCourses.certificate_generated_successfully') }}'
                                );
                                certificatesTable.ajax.reload();
                                eligibleUsersTable.ajax.reload();
                                // Reload page to update statistics
                                location.reload();
                            })
                            .fail(function(xhr) {
                                toastr.error(
                                    '{{ __('physicalCourses.error_generating_certificate') }}: ' +
                                    xhr.responseJSON?.message);
                            })
                            .always(function() {
                                button.prop('disabled', false);
                            });
                    }
                });
            });

            // Delete certificate
            $(document).on('click', '.delete-certificate', function() {
                let certificateId = $(this).data('id');
                let courseId = $(this).data('course-id');
                let button = $(this);
                let url =
                    "{{ route('admin.physical-courses.certificates.courses.delete-certificate', [$course->id, ':certificate']) }}"
                    .replace(':certificate', certificateId);

                Swal.fire({
                    title: '{{ __('physicalCourses.delete_certificate') }}',
                    text: '{{ __('physicalCourses.are_you_sure_delete_certificate') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('physicalCourses.yes_delete') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.prop('disabled', true);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(response) {
                                toastr.success(
                                    '{{ __('physicalCourses.certificate_deleted_successfully') }}'
                                );
                                certificatesTable.ajax.reload();
                                eligibleUsersTable.ajax.reload();
                                // Reload page to update statistics
                                location.reload();
                            },
                            error: function(xhr) {
                                toastr.error(
                                    '{{ __('physicalCourses.error_deleting_certificate') }}: ' +
                                    xhr.responseJSON?.message);
                            },
                            complete: function() {
                                button.prop('disabled', false);
                            }
                        });
                    }
                });
            });

            // Handle bulk actions
            $('#generateMissingBtn').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '{{ __('physicalCourses.generate_missing_certificates') }}',
                    text: '{{ __('physicalCourses.generate_missing_certificates_confirmation') }}',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('physicalCourses.yes_generate_all') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });

            $('#regenerateAllBtn').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '{{ __('physicalCourses.regenerate_all_certificates') }}',
                    text: '{{ __('physicalCourses.regenerate_all_certificates_warning') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('physicalCourses.yes_regenerate_all') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });

            // Certificate preview
            $('#previewCertificateBtn').on('click', function() {
                $('#certificatePreviewModal').modal('show');
                // Load preview content here - you would implement this based on your preview route
            });

            // Export functionality
            $('#exportBtn').on('click', function() {
                // Implement export functionality
                toastr.info('{{ __('physicalCourses.export_functionality_coming_soon') }}');
            });
        });
    </script>

@endsection
