@extends('admin/layouts/contentLayoutMaster')
@section('title', __('physicalCourses.attendance') . ' - ' . $course->name)

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
        .attendance-header {
            background: #44225c;
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .attendance-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.8rem;
            color: white;
        }

        .attendance-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .session-tabs {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            border: none;
            background: #f8f9fa;
            color: #6c757d;
            padding: 0.8rem 1.5rem;
            margin-right: 0.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background: #e9ecef;
            color: #495057;
            transform: translateY(-2px);
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .attendance-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }

        .session-info {
            background:#44225c;
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .session-info h5 {
            margin: 0;
            font-weight: 600;
            color: white;
        }

        .attendance-table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .attendance-table thead {
            background: linear-gradient(45deg, #495057, #6c757d);
            color: white;
        }

        .attendance-table th {
            padding: 1rem;
            font-weight: 600;
            border: none;
            text-align: center;
        }

        .attendance-table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .attendance-table tbody tr {
            transition: all 0.3s ease;
        }

        .attendance-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #44225c;
            color: white;
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .student-info {
            display: flex;
            align-items: center;
        }

        .student-name {
            font-weight: 600;
            color: #495057;
        }

        .attendance-checkbox {
            width: 25px;
            height: 25px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .attendance-checkbox:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .attendance-checkbox:hover {
            border-color: #007bff;
            transform: scale(1.1);
        }

        .save-btn {
            background: #44225c;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            background: linear-gradient(45deg, #218838, #1e7e34);
        }

        .attendance-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            flex: 1;
            background: white;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #44225c;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .alert-success {
            background: linear-gradient(45deg, #d4edda, #c3e6cb);
            border: 1px solid #b8daff;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        /* RTL Support */
        [dir="rtl"] .student-avatar {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        [dir="rtl"] .nav-tabs .nav-link {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        [dir="rtl"] .fas,
        [dir="rtl"] .fa {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        [dir="ltr"] .fas,
        [dir="ltr"] .fa {
            margin-left: 0;
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .attendance-header {
                padding: 1.5rem;
            }

            .attendance-header h2 {
                font-size: 1.5rem;
            }

            .nav-tabs .nav-link {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .attendance-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        .nav-tabs .nav-link.active {
    background: transparent !important;
}
    </style>
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
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <!-- Header Section -->
        <div class="attendance-header">
            <h2><i class="fas fa-users-class {{ app()->getLocale() == 'ar' ? 'me-2' : 'me-2' }}"></i>{{ __('physicalCourses.attendance_management') }}</h2>
            <p>{{ $course->name }}</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle {{ app()->getLocale() == 'ar' ? 'me-2' : 'me-2' }}"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Session Tabs -->
        <div class="session-tabs">
            <ul class="nav nav-tabs" id="attendanceTabs" role="tablist">
                @foreach ($course->schedules as $index => $session)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $session->id }}"
                            data-bs-toggle="tab" data-bs-target="#session-{{ $session->id }}" type="button"
                            role="tab">
                            <i class="fas fa-calendar-alt {{ app()->getLocale() == 'ar' ? 'me-2' : 'me-2' }}"></i>
                            {{ $session->session_date }} - {{ $session->session_time }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            @foreach ($course->schedules as $session)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="session-{{ $session->id }}"
                    role="tabpanel">

                    <div class="attendance-card">
                        <!-- Session Info -->
                        <div class="session-info">
                            <h5><i class="fas fa-clock {{ app()->getLocale() == 'ar' ? 'me-2' : 'me-2' }}"></i>{{ __('physicalCourses.session') }} {{ $session->session_date }} -
                                {{ $session->session_time }}</h5>
                        </div>

                        <!-- Statistics -->
                        <div class="attendance-stats">
                            <div class="stat-card">
                                <div class="stat-number">{{ count($approvedUsers) }}</div>
                                <div class="stat-label">{{ __('physicalCourses.total_students') }}</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">{{ $session->attendances->where('attended', 1)->count() }}
                                </div>
                                <div class="stat-label">{{ __('physicalCourses.present') }}</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">
                                    {{ count($approvedUsers) - $session->attendances->where('attended', 1)->count() }}
                                </div>
                                <div class="stat-label">{{ __('physicalCourses.absent') }}</div>
                            </div>
                        </div>

                        <!-- Attendance Form -->
                        <form method="POST"
                            action="{{ route('admin.physical-courses.courses.attendance.store', [$course->id, $session->id]) }}">
                            @csrf
                            <input type="hidden" name="session_id" value="{{ $session->id }}">

                            <div class="table-responsive">
                                <table class="table attendance-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">#</th>
                                            <th width="60%">{{ __('physicalCourses.student') }}</th>
                                            <th width="30%">{{ __('physicalCourses.attendance') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approvedUsers as $index => $user)
                                            @php
                                                $attended = $session->attendances
                                                    ->where('attended', 1)
                                                    ->contains('user_id', $user->id);
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div class="student-info">
                                                        <div class="student-avatar">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                        <div class="student-name">{{ $user->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="attendances[]"
                                                        value="{{ $user->id }}" class="attendance-checkbox"
                                                        {{ $attended ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-center mt-4">
                                @if (auth()->user()->hasPermission('physicalCourses.storeAttendance'))
                                    <button type="submit" class="save-btn">
                                        <i class="fas fa-save {{ app()->getLocale() == 'ar' ? 'me-2' : 'me-2' }}"></i>{{ __('physicalCourses.save_attendance') }}
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth transitions to checkboxes
            const checkboxes = document.querySelectorAll('.attendance-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const row = this.closest('tr');
                    if (this.checked) {
                        row.style.backgroundColor = '#d4edda';
                        setTimeout(() => {
                            row.style.backgroundColor = '';
                        }, 1000);
                    }
                });
            });

            // Add click animation to save button
            const saveButton = document.querySelector('.save-btn');
            if (saveButton) {
                saveButton.addEventListener('click', function() {
                    const loadingText = '{{ __("physical_courses.saving") }}';
                    this.innerHTML = '<i class="fas fa-spinner fa-spin {{ app()->getLocale() == "ar" ? "me-2" : "me-2" }}"></i>' + loadingText;
                });
            }
        });
    </script>
@endsection
