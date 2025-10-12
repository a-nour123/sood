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
        .course-header {
            background: #44225c;
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .course-info-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #667eea;
            display: inline-block;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .sessions-list {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .session-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
        }

        .session-info {
            flex: 1;
        }

        .session-stats {
            display: flex;
            gap: 1rem;
        }

        .session-stat {
            text-align: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .session-stat.attended {
            background: #d4edda;
            color: #155724;
        }

        .session-stat.absent {
            background: #f8d7da;
            color: #721c24;
        }

        .students-table {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: #667eea;
            color: rgb(23, 22, 22);
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody tr {
            transition: background-color 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            transition: width 0.3s ease;
        }

        .materials-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .material-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            text-decoration: none;
            color: #495057;
            transition: all 0.3s ease;
        }

        .material-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
            color: #667eea;
        }

        .material-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: #667eea;
        }

        .badge-custom {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .session-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .session-stats {
                margin-top: 1rem;
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2">
                <div class="row breadcrumbs-top widget-grid">
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
    </div>

    <!-- Course Header -->
    <div class="course-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 style="color: #fff !important;" class="mb-2">{{ $course->name }}</h1>
                <p class="mb-0 opacity-75">{{ $course->description }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge badge-custom bg-{{ $course->open_registration ? 'success' : 'secondary' }}">
                    <i class="fas fa-{{ $course->open_registration ? 'unlock' : 'lock' }} me-1"></i>
                    {{ $course->open_registration ? __('physicalCourses.registration_open') : __('physicalCourses.registration_closed') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Course Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon text-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $course->requests->count() }}</div>
            <div class="stat-label">{{ __('physicalCourses.total_students') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon text-success">
                <i class="fas fa-chair"></i>
            </div>
            <div class="stat-number">{{ $course->max_seats }}</div>
            <div class="stat-label">{{ __('physicalCourses.maximum_seats') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon text-info">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-number">{{ $course->schedules->count() }}</div>
            <div class="stat-label">{{ __('physicalCourses.sessions') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon text-warning">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-number">{{ $course->grade }}</div>
            <div class="stat-label">{{ __('physicalCourses.full_grade') }}</div>
        </div>
    </div>

    <!-- Course Information -->
    <div class="course-info-card">
        <h3 class="section-title">
            <i class="fas fa-info-circle me-2"></i>
            {{ __('physicalCourses.course_information') }}
        </h3>
        <div class="row">
            <div class="col-md-6">
                <p><strong><i
                            class="fas fa-layer-group me-2 text-primary"></i>{{ __('physicalCourses.level') }}:</strong>
                    {{ $course->grade }}</p>
                <p><strong><i
                            class="fas fa-users me-2 text-success"></i>{{ __('physicalCourses.maximum_seats') }}:</strong>
                    {{ $course->max_seats }}</p>
            </div>
            <div class="col-md-6">
                <p><strong><i
                            class="fas fa-chalkboard-teacher me-2 text-info"></i>{{ __('physicalCourses.teachers') }}:</strong>
                    {{ $course->instructors->pluck('name')->join(', ') }}</p>
            </div>
        </div>
    </div>

    <!-- Sessions Section -->
    <div class="sessions-list">
        <h3 class="section-title">
            <i class="fas fa-calendar-alt me-2"></i>
            {{ __('physicalCourses.course_sessions') }}
        </h3>
        @forelse($course->schedules as $schedule)
            <div class="session-item">
                <div class="session-info">
                    <h5 class="mb-1">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        {{ $schedule->session_date }} {{ __('physicalCourses.at_time') }}
                        {{ $schedule->session_time }}
                    </h5>
                </div>
                <div class="session-stats">
                    <div class="session-stat attended">
                        <i class="fas fa-check me-1"></i>
                        {{ __('physicalCourses.attended') }}:
                        {{ $schedule->attendances->where('attended', true)->count() }}
                    </div>
                    <div class="session-stat absent">
                        <i class="fas fa-times me-1"></i>
                        {{ __('physicalCourses.was_absent') }}:
                        {{ $course->requests->count() - $schedule->attendances->where('attended', true)->count() }}
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>{{ __('physicalCourses.no_sessions_scheduled') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Students Table -->
    <div class="students-table">
        <h3 class="section-title">
            <i class="fas fa-user-graduate me-2"></i>
            {{ __('Students List') }}
        </h3>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-user me-2"></i>{{ __('physicalCourses.Name') }}</th>
                        <th><i class="fas fa-envelope me-2"></i>{{ __('physicalCourses.Email') }}</th>
                        <th><i class="fas fa-flag me-2"></i>{{ __('physicalCourses.Status') }}</th>
                        <th><i class="fas fa-percentage me-2"></i>{{ __('physicalCourses.Attendance Rate') }}</th>
                        <th><i class="fas fa-award me-2"></i>{{ __('physicalCourses.Grade') }}</th>
                        <th><i class="fas fa-trophy me-2"></i>{{ __('physicalCourses.Result') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course->requests as $req)
                        @php
                            $user = $req->user;
                            $totalSessions = $course->schedules->count();
                            $attendedSessions = $course->schedules
                                ->filter(
                                    fn($s) => $s->attendances
                                        ->where('user_id', $user->id)
                                        ->where('attended', true)
                                        ->count(),
                                )
                                ->count();

                            $attendancePercent =
                                $totalSessions > 0 ? round(($attendedSessions / $totalSessions) * 100, 2) : 0;

                            $gradeRecord = $course->grades->where('user_id', $user->id)->first();
                            $grade = $gradeRecord ? $gradeRecord->grade : 0;
                            $passed = $grade >= $course->passing_grade;
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle me-2"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ __('physicalCourses.status.' . $req->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress-bar-custom me-2" style="width: 60px;">
                                        <div class="progress-fill" style="width: {{ $attendancePercent }}%;"></div>
                                    </div>
                                    <span
                                        class="text-{{ $attendancePercent >= 75 ? 'success' : ($attendancePercent >= 50 ? 'warning' : 'danger') }}">
                                        {{ $attendancePercent }}%
                                    </span>
                                </div>
                            </td>
                            <td>
                                <strong class="text-{{ $grade >= $course->passing_grade ? 'success' : 'danger' }}">
                                    {{ $grade }}/{{ $course->passing_grade }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $passed ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $passed ? 'check' : 'times' }} me-1"></i>
                                    {{ $passed ? __('Passed') : __('Failed') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Materials Section -->
    <div class="materials-section">
        <h3 class="section-title">
            <i class="fas fa-folder-open me-2"></i>
            {{ __('physicalCourses.Course Materials') }}
        </h3>
        @if ($course->materials->count())
            <div class="row">
                @foreach ($course->materials as $material)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                            class="material-item">
                            <i class="fas fa-file-alt material-icon"></i>
                            <div>
                                <h6 class="mb-0">{{ $material->file_name }}</h6>
                                <small class="text-muted">{{ __('physicalCourses.Click to view') }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>{{ __('physicalCourses.No materials uploaded yet') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
