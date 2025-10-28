@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.full_physical_courses_report'))

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
        /* Statistics Cards Styles */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 1.5rem;
            color: white;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:nth-child(1) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card:nth-child(4) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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
            background: linear-gradient(135deg, #d6d7dc 0%, #b3a9bd 100%);
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
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Header Section -->
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
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['total_courses'] ?? 0 }}</div>
                    <div class="stat-label">{{ __('physicalCourses.total_courses') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['total_students'] ?? 0 }}</div>
                    <div class="stat-label">{{ __('physicalCourses.total_students') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['total_instructors'] ?? 0 }}</div>
                    <div class="stat-label">{{ __('physicalCourses.total_instructors') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['success_rate'] ?? 0 }}%</div>
                    <div class="stat-label">{{ __('physicalCourses.success_rate') }}</div>
                </div>
            </div>

            <!-- Additional Statistics Row -->
            <div class="stats-cards mt-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['total_sessions'] ?? 0 }}</div>
                    <div class="stat-label">{{ __('physicalCourses.total_sessions') }}</div>
                </div>

                 <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-play-circle text-success"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['active_courses'] ?? 0 }}</div>
                    <div class="stat-label">{{ __('physicalCourses.active_courses') }}</div>
                </div>

            </div>


        </div>

        <div>
            <h1 class="mb-4">{{ __('physicalCourses.full_physical_courses_report') }}</h1>
            <table id="fullCoursesReportTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('physicalCourses.course_name') }}</th>
                        <th>{{ __('physicalCourses.instructors') }}</th>
                        <th>{{ __('physicalCourses.sessions') }}</th>
                        <th>{{ __('physicalCourses.students') }}</th>
                        <th>{{ __('physicalCourses.total_attendance') }}</th>
                        <th>{{ __('physicalCourses.avg_grade') }}</th>
                        <th>{{ __('physicalCourses.success_percent') }}</th>
                        <th>{{ __('physicalCourses.registration') }}</th>
                        <th>{{ __('physicalCourses.actions') }}</th>
                    </tr>
                </thead>
            </table>

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
            // Initialize DataTable
            $('#fullCoursesReportTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.physical-courses.courses.reports.full-summary-ajax') }}',
                language: {
                    processing: "{{ __('physicalCourses.processing') }}",
                    search: "{{ __('physicalCourses.search') }}:",
                    lengthMenu: "{{ __('physicalCourses.show_entries') }}",
                    info: "{{ __('physicalCourses.showing_entries') }}",
                    infoEmpty: "{{ __('physicalCourses.no_entries') }}",
                    infoFiltered: "{{ __('physicalCourses.filtered_from') }}",
                    zeroRecords: "{{ __('physicalCourses.no_records') }}",
                    emptyTable: "{{ __('physicalCourses.no_records') }}",
                    paginate: {
                        first: "{{ __('physicalCourses.first') }}",
                        previous: "{{ __('physicalCourses.previous') }}",
                        next: "{{ __('physicalCourses.next') }}",
                        last: "{{ __('physicalCourses.last') }}"
                    }
                },
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
                        data: 'instructors',
                        name: 'instructors',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sessions',
                        name: 'sessions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'students',
                        name: 'students',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'total_attendance',
                        name: 'total_attendance',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'avg_grade',
                        name: 'avg_grade',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'success_percent',
                        name: 'success_percent',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'registration',
                        name: 'registration',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Add animation to statistics cards
            $('.stat-card').hover(function() {
                $(this).addClass('animated pulse');
            }, function() {
                $(this).removeClass('animated pulse');
            });
        });
    </script>
@endsection
