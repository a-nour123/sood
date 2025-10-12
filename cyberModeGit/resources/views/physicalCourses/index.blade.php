@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.physical_courses'))

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
        /* Custom responsive styles for the table */
        @media screen and (max-width: 768px) {
            .table-responsive {
                font-size: 12px;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        /* Ensure buttons in actions column don't break */
        .action-buttons {
            white-space: nowrap;
        }

        .action-buttons .btn {
            margin: 1px;
        }

        /* Loading spinner style */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>

    <style>
        /* Statistics Cards Styles */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }


        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .stat-label {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-header {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .report-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .report-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
     color:#44225c;
        }

        .report-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stat-icon {
                font-size: 2rem;
            }

            .report-title {
                font-size: 2rem;
            }

            .report-header {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }

            .report-title {
                font-size: 1.8rem;
            }

            .report-subtitle {
                font-size: 1rem;
            }
        }

        /* Table Styling Enhancement */
        #fullCoursesReportTable {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        #fullCoursesReportTable thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #fullCoursesReportTable tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        #fullCoursesReportTable tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.1);
        }
        .main-color{
            color: #44225c !important;
        }
        .table-bordered thead, .table-bordered tbody, .table-bordered tfoot, .table-bordered tr, .table-bordered td, .table-bordered th {
    border-color: transparent;
}
.table > :not(caption) > * > * {
    background-color: #fff !important;

}
.table-dark th {
color:  #414f5c !important;
}
.table-bordered thead, .table-bordered tbody, .table-bordered tfoot, .table-bordered tr, .table-bordered td, .table-bordered th {
    border-color: transparent !important;
}
.table > :not(:first-child) {
    border-top: 2px solid #ebe9f1 !important;
}
table .odd {
    background-color: #f9f9f9 !important;
}
    </style>

@endsection

@section('content')

    <div class="container-fluid">


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




                            @if (Route::currentRouteName() == 'admin.physical-courses.courses.index')
                                <div class="col-sm-6 pe-0" style="text-align: end;">
                                    <div class="action-content">
                                        @if (auth()->user()->hasPermission('physicalCourses.list'))
                                            <div class="btn-group dropdown dropdown-icon-wrapper me-1">
                                                <button type="button"
                                                    class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="border-radius: 8px !important;
                                                        width: 40px;
                                                        text-align: center;
                                                        color: #FFF !important;
                                                        height: 30px;
                                                        line-height: 19px;">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end export-types  ">

                                                    <span class="dropdown-item" data-type="excel">
                                                        <i class="fa fa-solid fa-gear"></i>
                                                        <span class="px-1 text-start"><a
                                                                href="{{ route('admin.physical-courses.certificate-templates.index') }}">{{ __('physicalCourses.certificates_templates') }}</a></span>

                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-6 pe-0" style="text-align: end;">
                                    <div class="action-content">

                                        <a href="#" class=" btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="report-header fade-in">
            <h1 class="report-title">
                <i class="fas fa-chart-line me-3"></i>
                {{ __('physicalCourses.full_physical_courses_report') }}
            </h1>
            <p class="report-subtitle">
                {{ __('physicalCourses.comprehensive_analysis') }}
            </p>

            <!-- Statistics Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="main-color fas fa-book" ></i>
                    </div>
                    <div class="main-color stat-number">{{ $statistics['total_courses'] ?? 0 }}</div>
                    <div class="main-color stat-label">{{ __('physicalCourses.total_courses') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="main-color fas fa-users"></i>
                    </div>
                    <div class="main-color stat-number">{{ $statistics['total_students'] ?? 0 }}</div>
                    <div class="main-color stat-label">{{ __('physicalCourses.total_students') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="main-color fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="main-color stat-number">{{ $statistics['total_instructors'] ?? 0 }}</div>
                    <div class="main-color stat-label">{{ __('physicalCourses.total_instructors') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="main-color fas fa-percentage"></i>
                    </div>
                    <div class="main-color stat-number">{{ $statistics['success_rate'] ?? 0 }}%</div>
                    <div class="main-color stat-label">{{ __('physicalCourses.success_rate') }}</div>
                </div>
            </div>

            <!-- Additional Statistics Row -->
            <div class="stats-cards mt-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="main-color fas fa-calendar-alt"></i>
                    </div>
                    <div class="main-color stat-number">{{ $statistics['total_sessions'] ?? 0 }}</div>
                    <div class="main-color stat-label">{{ __('physicalCourses.total_sessions') }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="main-color fas fa-play-circle"></i>
                    </div>
                    <div class="main-color stat-number">{{ $statistics['active_courses'] ?? 0 }}</div>
                    <div class="main-color stat-label">{{ __('physicalCourses.active_courses') }}</div>
                </div>

            </div>


        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('physicalCourses.physical_courses') }}</h4>
                        <a href="{{ route('admin.physical-courses.courses.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> {{ __('physicalCourses.create_new_course_btn') }}
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="physicalCoursesTable" class="table table-bordered dataTable"
                                style="min-width: 1200px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('physicalCourses.name') }}</th>
                                        <th>{{ __('physicalCourses.open_registration') }}</th>
                                        <th>{{ __('physicalCourses.course_complete') }}</th>
                                        <th>{{ __('physicalCourses.passing_grade') }}</th>
                                        <th>{{ __('physicalCourses.requests') }}</th>
                                        {{-- <th>{{ __('physicalCourses.instructors') }}</th> --}}
                                        <th>{{ __('physicalCourses.registered') }}</th>
                                        <th>{{ __('physicalCourses.available_seats') }}</th>
                                        <th>{{ __('physicalCourses.next_session') }}</th>
                                        <th>{{ __('physicalCourses.attendance') }}</th>
                                        <th>{{ __('physicalCourses.grades') }}</th>
                                        <th>{{ __('physicalCourses.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
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
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#physicalCoursesTable').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.physical-courses.courses.indexAjax') }}',
                columnDefs: [{
                        targets: [0], // # column
                        responsivePriority: 10,
                        className: 'text-center'
                    },
                    {
                        targets: [1], // Name column - always visible
                        responsivePriority: 1,
                        className: 'all'
                    },
                    {
                        targets: [10], // Actions column - always visible
                        responsivePriority: 2,
                        className: 'all text-center'
                    },
                    {
                        targets: [2], // Open Registration
                        responsivePriority: 3,
                        className: 'text-center'
                    },
                    {
                        targets: [3], // Requests
                        responsivePriority: 4,
                        className: 'text-center'
                    },
                    {
                        targets: [5], // Registered
                        responsivePriority: 5,
                        className: 'text-center'
                    },
                    {
                        targets: [6], // Available Seats
                        responsivePriority: 6,
                        className: 'text-center'
                    },
                    {
                        targets: [4], // Instructors
                        responsivePriority: 7
                    },
                    {
                        targets: [7], // Next Session
                        responsivePriority: 8
                    },
                    {
                        targets: [8], // Attendance
                        responsivePriority: 9,
                        className: 'text-center'
                    },
                    {
                        targets: [9], // Grades
                        responsivePriority: 10,
                        className: 'text-center'
                    }
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'open_registration',
                        name: 'open_registration',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'course_complete',
                        name: 'course_complete',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'passing_grade',
                        name: 'passing_grade',
                        orderable: false,
                        searchable: false
                    },


                    {
                        data: 'requests',
                        name: 'requests',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'instructors',
                    //     name: 'instructors',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'registered',
                        name: 'registered',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'available_seats',
                        name: 'available_seats',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'next_session',
                        name: 'next_session',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'attendance',
                        name: 'attendance',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'grades',
                        name: 'grades',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '[data-toggle-registration]', function(e) {
                e.preventDefault();

                var $this = $(this);
                var courseId = $this.data('course-id');
                var $button = $this.find('button');
                var originalHtml = $button.html();

                $button.prop('disabled', true);
                $button.html(
                    '<span class="spinner-border spinner-border-sm me-1" role="status"></span>{{ __('physicalCourses.loading') }}'
                );

                $.ajax({
                    url: "{{ route('admin.physical-courses.courses.toggleRegistration', '') }}/" +
                        courseId,
                    method: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message ||
                                '{{ __('physicalCourses.something_went_wrong') }}');
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = '{{ __('physicalCourses.something_went_wrong') }}';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                        $button.html(originalHtml);
                    }
                });
            });


            $(document).on('click', '.delete-course', function(e) {
                e.preventDefault();

                var $this = $(this);
                var courseId = $this.data('course-id');
                var courseName = $this.data('course-name');

                Swal.fire({
                    title: '{{ __('physicalCourses.confirm_delete') }}',
                    text: '{{ __('physicalCourses.confirm_delete_text', ['name' => '']) }}'
                        .replace(':name', courseName),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('physicalCourses.yes_delete') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return $.ajax({
                            url: "{{ route('admin.physical-courses.courses.destroy', '') }}/" +
                                courseId,
                            method: 'DELETE',
                            data: {
                                '_token': '{{ csrf_token() }}'
                            }
                        });
                    },
                    allowOutsideClick: function() {
                        return !Swal.isLoading();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        if (result.value.success) {
                            Swal.fire({
                                title: '{{ __('physicalCourses.deleted') }}',
                                text: result.value.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // تحديث الجدول
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                title: '{{ __('physicalCourses.error') }}',
                                text: result.value.message ||
                                    '{{ __('physicalCourses.failed_to_delete') }}',
                                icon: 'error'
                            });
                        }
                    }
                }).catch(function(xhr) {
                    var errorMessage = '{{ __('physicalCourses.something_went_wrong') }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: '{{ __('physicalCourses.error') }}',
                        text: errorMessage,
                        icon: 'error'
                    });
                });
            });

            $(document).on('click', '[data-toggle-completion]', function(e) {
                e.preventDefault();

                var $this = $(this);
                var courseId = $this.data('course-id');
                var originalHtml = $this.html();

                $this.prop('disabled', true);
                $this.html(
                    '<span class="spinner-border spinner-border-sm me-1" role="status"></span>{{ __('physicalCourses.loading') }}'
                );

                $.ajax({
                    url: "{{ route('admin.physical-courses.courses.toggleCompletion', '') }}/" +
                        courseId,
                    method: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message ||
                                '{{ __('physicalCourses.something_went_wrong') }}');
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = '{{ __('physicalCourses.something_went_wrong') }}';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $this.prop('disabled', false);
                        $this.html(originalHtml);
                    }
                });
            });


            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: 'toast-top-right',
                preventDuplicates: false,
                onclick: null,
                showDuration: '300',
                hideDuration: '1000',
                timeOut: '5000',
                extendedTimeOut: '1000',
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut'
            };
        });
    </script>
@endsection
