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
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
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
        .courses-hero {
            background: #44225c;
            border-radius: 20px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .courses-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .course-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            background: white;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        .course-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .course-card:hover .course-image {
            transform: scale(1.05);
        }

        .course-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .course-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .course-description {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .instructors-section {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .instructor-tag {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.25rem;
        }

        .schedule-list {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            border-radius: 0 10px 10px 0;
            margin-bottom: 1.5rem;
        }

        .schedule-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #856404;
        }

        .schedule-item:last-child {
            margin-bottom: 0;
        }

        .schedule-item i {
            margin-right: 0.5rem;
            color: #ffc107;
        }

        .register-btn {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .status-btn {
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .registered-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .registered-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
        }

        .registered-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            position: relative;
        }

        .registered-header::after {
            content: '✨';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
        }

        .view-details-btn {
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .view-details-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
            color: white;
        }

        .section-title {
            position: relative;
            display: inline-block;
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 2px;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-counter {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4">

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

        <!-- Hero Section -->
        <div class="courses-hero fade-in">
            <h1 style="color: white;"
            class=" display-4 mb-3">🎓 {{ __('physicalCourses.welcome_learning_platform') }}</h1>
            <p class="lead mb-4">{{ __('physicalCourses.discover_courses_description') }}</p>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="stats-counter">
                        <div class="stats-number">{{ $openCourses->count() }}</div>
                        <div class="stats-label">{{ __('physicalCourses.available_course') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-counter">
                        <div class="stats-number">{{ count($myRequests->get('approved', [])) }}</div>
                        <div class="stats-label">{{ __('physicalCourses.registered_course') }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-counter">
                        <a href="{{ route('admin.physical-courses.certificates.my-certificates') }}">
                            <div class="stats-number">{{ $certificates }}</div>
                        </a>
                        <div class="stats-label">{{ __('physicalCourses.user_certificates') }}</div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Open Courses Section -->
        <div class="mb-5">
            <h2 class="section-title">📚 {{ __('physicalCourses.available_courses_for_registration') }}</h2>

            @if ($openCourses->count() > 0)
                <div class="row">
                    @foreach ($openCourses as $course)
                        @php
                            // $myStatus = $course->requests->where('user_id', auth()->id())->first()?->status;
                            $myStatus = optional($course->requests->where('user_id', auth()->id())->first())->status;
                        @endphp
                        <div class="col-lg-4 col-md-6 mb-4 fade-in">
                            <div class="card course-card h-100">
                                @if ($course->cover)
                                    <img src="{{ asset('storage/' . $course->cover) }}" class="course-image"
                                        alt="cover">
                                @else
                                    <div class="course-placeholder">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="course-title">{{ $course->name }}</h5>
                                    <p class="course-description flex-grow-1">{{ $course->description }}</p>

                                    <div class="instructors-section">
                                        <strong class="d-block mb-2">
                                            <i
                                                class="fas fa-chalkboard-teacher me-2"></i>{{ __('physicalCourses.instructors') }}:
                                        </strong>
                                        @foreach ($course->instructors as $instructor)
                                            <span class="instructor-tag">{{ $instructor->name }}</span>
                                        @endforeach
                                    </div>

                                    @if ($course->schedules->count() > 0)
                                        <div class="schedule-list">
                                            <strong class="d-block mb-2">
                                                <i
                                                    class="fas fa-calendar-alt me-2"></i>{{ __('physicalCourses.schedule') }}:
                                            </strong>
                                            @foreach ($course->schedules as $s)
                                                <div class="schedule-item">
                                                    <i class="fas fa-clock"></i>
                                                    <span>{{ $s->session_date }} - {{ $s->session_time }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        @if ($myStatus)
                                            <button
                                                class="btn status-btn w-100
                                            @if ($myStatus === 'approved') btn-success
                                            @elseif($myStatus === 'pending') btn-warning
                                            @else btn-danger @endif"
                                                disabled>
                                                @if ($myStatus === 'approved')
                                                    <i
                                                        class="fas fa-check-circle me-2"></i>{{ __('physicalCourses.approved') }}
                                                @elseif($myStatus === 'pending')
                                                    <i
                                                        class="fas fa-clock me-2"></i>{{ __('physicalCourses.pending') }}
                                                @else
                                                    <i
                                                        class="fas fa-times-circle me-2"></i>{{ __('physicalCourses.rejected') }}
                                                @endif
                                            </button>
                                        @else
                                            <form method="POST"
                                                action="{{ route('admin.physical-courses.student.courses.register', $course->id) }}">
                                                @csrf
                                                <button class="btn register-btn w-100">
                                                    <i
                                                        class="fas fa-user-plus me-2"></i>{{ __('physicalCourses.register_in_course') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h4>{{ __('physicalCourses.no_courses_available') }}</h4>
                    <p>{{ __('physicalCourses.new_courses_coming_soon') }}</p>
                </div>
            @endif
        </div>

        <!-- Divider -->
        <hr class="my-5"
            style="height: 3px; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); border: none; border-radius: 2px;">

        <!-- Registered Courses Section -->
        <div class="mb-5">
            <h2 class="section-title">🎓 {{ __('physicalCourses.registered_courses') }}</h2>

            @if (count($myRequests->get('approved', [])) > 0)
                <div class="row">
                    @foreach ($myRequests->get('approved', []) as $request)
                        @php $course = $request->course; @endphp
                        <div class="col-lg-4 col-md-6 mb-4 fade-in">
                            <div class="card registered-card h-100">
                                <div class="registered-header">
                                    <i
                                        class="fas fa-medal me-2"></i>{{ __('physicalCourses.successfully_registered') }}
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="course-title">{{ $course->name }}</h5>
                                    <p class="course-description flex-grow-1">{{ $course->description }}</p>

                                    <div class="instructors-section">
                                        <strong class="d-block mb-2">
                                            <i
                                                class="fas fa-chalkboard-teacher me-2"></i>{{ __('physicalCourses.instructors') }}:
                                        </strong>
                                        @foreach ($course->instructors as $instructor)
                                            <span class="instructor-tag">{{ $instructor->name }}</span>
                                        @endforeach
                                    </div>

                                    @if ($course->schedules->count() > 0)
                                        <div class="schedule-list">
                                            <strong class="d-block mb-2">
                                                <i
                                                    class="fas fa-calendar-check me-2"></i>{{ __('physicalCourses.attendance_schedule') }}:
                                            </strong>
                                            @foreach ($course->schedules as $s)
                                                <div class="schedule-item">
                                                    <i class="fas fa-clock"></i>
                                                    <span>{{ $s->session_date }} - {{ $s->session_time }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <a href="{{ route('admin.physical-courses.student.courses.show', $course->id) }}"
                                            class="btn view-details-btn w-100">
                                            <i class="fas fa-eye me-2"></i>{{ __('physicalCourses.view_details') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-user-graduate"></i>
                    <h4>{{ __('physicalCourses.not_registered_yet') }}</h4>
                    <p>{{ __('physicalCourses.start_learning_journey') }}</p>
                </div>
            @endif
        </div>
    </div>

    @section('vendor-script')
        <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    @endsection

    @section('page-script')
        <script>
            // Add smooth scrolling and animations
            document.addEventListener('DOMContentLoaded', function() {
                // Animate counters
                const counters = document.querySelectorAll('.stats-number');
                counters.forEach(counter => {
                    const target = parseInt(counter.innerText);
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        counter.innerText = Math.floor(current);
                    }, 16);
                });

                // Add hover effects to cards
                const cards = document.querySelectorAll('.course-card, .registered-card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-10px)';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });

                // Confirm registration
                const registerForms = document.querySelectorAll('form[action*="register"]');
                registerForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: '{{ __('physicalCourses.confirm_registration') }}',
                            text: '{{ __('physicalCourses.confirm_registration_text') }}',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: '{{ __('physicalCourses.yes_register_now') }}',
                            cancelButtonText: '{{ __('physicalCourses.cancel') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endsection

@endsection
