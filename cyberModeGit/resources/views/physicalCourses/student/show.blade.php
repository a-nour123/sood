@extends('admin/layouts/contentLayoutMaster')

@section('title', $course->name)

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
        .course-hero {
            background: #44225c;
            border-radius: 20px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .course-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .course-hero-content {
            position: relative;
            z-index: 2;
            padding: 40px 30px;
        }

        .course-cover {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .course-cover:hover {
            transform: translateY(-5px);
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .info-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .info-card-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
            color: white;
        }

        .instructors-icon { background: #44225c}
        .materials-icon { background: #44225c }
        .schedule-icon { background:#44225c }
        .grade-icon { background: #44225c}

        .info-card-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .instructor-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            transition: background 0.2s ease;
        }

        .instructor-item:hover {
            background: #e9ecef;
        }

        .instructor-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
        }

        .material-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            border-left: 4px solid #667eea;
        }

        .material-item:hover {
            background: #e3f2fd;
            border-left-color: #2196f3;
        }

        .material-link {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .material-link:hover {
            color: #2196f3;
        }

        .material-icon {
            margin-right: 10px;
            color: #667eea;
        }

        .schedule-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .schedule-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .schedule-table th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .schedule-table td {
            padding: 15px;
            border-color: #f1f3f4;
            vertical-align: middle;
        }

        .attendance-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .badge-attended {
            background: #d4edda;
            color: #155724;
        }

        .badge-absent {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .grade-display {
            text-align: center;
            padding: 30px;
            background: #44225c;
            border-radius: 15px;
            color: white;
        }

        .grade-score {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
        }

        .grade-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .no-content {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .no-content i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .course-hero-content {
                padding: 25px 20px;
            }

            .info-card {
                padding: 20px;
            }

            .grade-score {
                font-size: 2.5rem;
            }
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



        <!-- Course Hero Section -->
        <div class="course-hero">
            <div class="course-hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="display-5 fw-bold mb-3 text-white">{{ $course->name }}</h1>
                        <p class="lead mb-0">{{ $course->description }}</p>
                    </div>
                    @if ($course->cover)
                        <div class="col-lg-4 text-end">
                            <img src="{{ asset('storage/' . $course->cover) }}"
                                alt="{{ __('physicalCourses.Course Cover') }}" class="course-cover img-fluid"
                                style="max-height: 200px; width: auto;">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Instructors Section -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon instructors-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3 class="info-card-title">{{ __('physicalCourses.instructors') }}</h3>
                    </div>
                    <div class="instructors-list">
                        @foreach ($course->instructors as $instructor)
                            <div class="instructor-item">
                                <div class="instructor-avatar">
                                    {{ substr($instructor->name, 0, 1) }}
                                </div>
                                <span class="fw-medium">{{ $instructor->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Materials Section -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon materials-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="info-card-title">{{ __('physicalCourses.course_materials') }}</h3>
                    </div>
                    @if ($course->materials->count())
                        <div class="materials-list">
                            @foreach ($course->materials as $material)
                                <div class="material-item">
                                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                        class="material-link">
                                        <i class="fas fa-file-pdf material-icon"></i>
                                        {{ $material->file_name }}
                                        <i class="fas fa-external-link-alt ms-auto" style="font-size: 12px;"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-content">
                            <i class="fas fa-folder-open"></i>
                            <p class="mb-0">{{ __('physicalCourses.no_materials_uploaded_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Grade Section -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon grade-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3 class="info-card-title">{{ __('physicalCourses.your_grade') }}</h3>
                    </div>
                    @php
                        $grade = $course->grades->where('user_id', auth()->id())->first();
                        $surveyResponse = auth()
                            ->user()
                            ->courseSurveyResponses->where('respondent_id', $course->id)
                            ->first();

                        $hasCompletedSurvey = $surveyResponse && $surveyResponse->is_completed;
                    @endphp

                    @if ($grade && $hasCompletedSurvey)
                        <div class="grade-display">
                            <div class="grade-score">{{ $grade->grade }}</div>
                            <div class="grade-label">{{ __('physicalCourses.out_of') }} {{ $course->grade }}</div>
                        </div>
                    @elseif (!$hasCompletedSurvey && isset($survey))
                        <div class="no-content text-center">
                            <i class="fas fa-clipboard-question"></i>
                            <p class="mb-1">{{ __('physicalCourses.complete_the_survey_first') }}</p>
                            <a href="{{ route('admin.physical-courses.surveys.show', ['survey' => $survey->id , 'type' => 'course', 'id' => $course->id]) }}"
                                class="btn btn-primary btn-sm mt-1">
                                {{ __('physicalCourses.start_survey') }}
                            </a>
                        </div>
                    @else
                        <div class="no-content">
                            <i class="fas fa-clock"></i>
                            <p class="mb-0">{{ __('physicalCourses.grade_not_evaluated_yet') }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Schedule & Attendance Section -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon schedule-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="info-card-title">{{ __('physicalCourses.attendance_schedule') }}</h3>
            </div>
            <div class="table-responsive">
                <table class="table schedule-table">
                    <thead>
                        <tr>
                            <th>{{ __('physicalCourses.session') }}</th>
                            <th>{{ __('physicalCourses.date') }}</th>
                            <th>{{ __('physicalCourses.time') }}</th>
                            <th>{{ __('physicalCourses.attendance') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->schedules as $i => $session)
                            <tr>
                                <td class="fw-bold">{{ __('physicalCourses.session') }} {{ $i + 1 }}</td>
                                <td>{{ $session->session_date }}</td>
                                <td>{{ $session->session_time }}</td>
                                <td>
                                    @php
                                        $status = $attendances[$session->id] ?? null;
                                    @endphp
                                    @if ($status === 1)
                                        <span class="attendance-badge badge-attended">
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{ __('physicalCourses.present') }}
                                        </span>
                                    @elseif ($status === 0)
                                        <span class="attendance-badge badge-absent">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ __('physicalCourses.absent') }}
                                        </span>
                                    @else
                                        <span class="attendance-badge badge-pending">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ __('physicalCourses.pending') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
