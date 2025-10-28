@extends('admin/layouts/contentLayoutMaster')
@section('title', __('physicalCourses.grades') . ' - ' . $course->name)

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
        .grades-header {
            background: #44225c;
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .grades-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .course-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .course-info i {
            font-size: 1.3rem;
        }

        .grades-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
        }

        .grades-table {
            margin: 0;
            border: none;
        }

        .grades-table thead {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .grades-table thead th {
            border: none;
            padding: 1.5rem 1rem;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .grades-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .grades-table tbody tr:hover {
            background: ;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(177, 165, 165, 0.1);
        }

        .grades-table tbody td {
            padding: 1.5rem 1rem;
            border: none;
            vertical-align: middle;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .student-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .grade-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .grade-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            transform: scale(1.02);
        }

        .grade-input:valid {
            border-color: #28a745;
            background: #f8fff9;
        }

        .save-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 1rem 3rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .save-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .save-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .save-btn:hover:before {
            left: 100%;
        }

        .success-alert {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            border: none;
            border-radius: 15px;
            color: #155724;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(132, 250, 176, 0.3);
            animation: slideInFromTop 0.5s ease-out;
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .form-actions {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 0 0 20px 20px;
            text-align: center;
            margin-top: 2rem;
        }

        .row-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .grades-header h1 {
                font-size: 2rem;
            }

            .course-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .grades-table {
                font-size: 0.9rem;
            }

            .student-info {
                flex-direction: column;
                text-align: center;
            }
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
        <div class="grades-header">
            <h1><i class="fas fa-graduation-cap me-3"></i>{{ __('physicalCourses.grades') }}</h1>
            <div class="course-info">
                <div><i class="fas fa-book"></i> {{ $course->name }}</div>
                <div><i class="fas fa-star"></i> {{ __('physicalCourses.max_grade') }}: {{ $course->grade }}</div>
                <div><i class="fas fa-users"></i> {{ __('physicalCourses.total_students') }}: {{ count($approvedUsers) }}</div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ count($approvedUsers) }}</div>
                <div class="stat-label">{{ __('physicalCourses.registered') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">{{ $course->grade }}</div>
                <div class="stat-label">{{ __('physicalCourses.max_grade') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number">{{ $course->grades->where('grade', '>', 0)->count() }}</div>
                <div class="stat-label">{{ __('physicalCourses.grades') }} {{ __('physicalCourses.entered') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-number">
                    {{ $course->grades->count() > 0 ? round(($course->grades->where('grade', '>', 0)->count() / count($approvedUsers)) * 100) : 0 }}%
                </div>
                <div class="stat-label">{{ __('physicalCourses.completion_rate') }}</div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert success-alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Grades Form -->
        <div class="grades-card">
            <form method="POST" action="{{ route('admin.physical-courses.courses.grades.store', $course->id) }}">
                @csrf
                <table class="table grades-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;"><i class="fas fa-hashtag"></i> #</th>
                            <th><i class="fas fa-user"></i> {{ __('physicalCourses.student') }}</th>
                            <th style="width: 200px;"><i class="fas fa-star"></i> {{ __('physicalCourses.grades') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approvedUsers as $index => $user)
                            @php
                                $userGrade = $course->grades->where('user_id', $user->id)->first();
                            @endphp
                            <tr>
                                <td>
                                    <div class="row-number">{{ $index + 1 }}</div>
                                </td>
                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="student-name">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="grades[{{ $user->id }}]"
                                        value="{{ old("grades.{$user->id}", $userGrade->grade ?? '') }}"
                                        class="form-control grade-input" min="0" max="{{ $course->grade }}"
                                        placeholder="0 - {{ $course->grade }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="form-actions">
                    @if (auth()->user()->hasPermission('physicalCourses.storeGrade'))
                        <button type="submit" class="btn save-btn">
                            <i class="fas fa-save me-2"></i>
                            {{ __('physicalCourses.save_grades') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to cards on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                    }
                });
            });

            document.querySelectorAll('.stat-card').forEach(card => {
                observer.observe(card);
            });

            // Add validation feedback
            document.querySelectorAll('.grade-input').forEach(input => {
                input.addEventListener('input', function() {
                    const value = parseInt(this.value);
                    const max = parseInt(this.max);

                    if (value > max) {
                        this.style.borderColor = '#dc3545';
                        this.style.background = '#fff5f5';
                    } else if (value >= 0) {
                        this.style.borderColor = '#28a745';
                        this.style.background = '#f8fff9';
                    } else {
                        this.style.borderColor = '#e9ecef';
                        this.style.background = '#f8f9fa';
                    }
                });
            });
        });
    </script>
@endsection
