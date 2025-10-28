@extends('admin/layouts/contentLayoutMaster')

@section('title', __('LMS.Courses'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">

    <style>
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .course-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e3e6f0;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .course-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .course-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .course-card:hover .course-header::before {
            right: -30%;
        }

        .course-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }

        .course-description {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .course-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }

        .levels-accordion {
            padding: 0;
        }

        .level-item {
            border: none;
            border-bottom: 1px solid #f0f0f0;
        }

        .level-item:last-child {
            border-bottom: none;
        }

        .level-header {
            background: none;
            border: none;
            padding: 15px 20px;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .level-header:hover {
            background: #f8f9fa;
        }

        .level-header.active {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .level-title {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
        }

        .level-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .level-header:not(.active) .level-badge {
            background: #e9ecef;
            color: #6c757d;
        }

        .level-content {
            padding: 0 20px 20px;
            display: none;
        }

        .level-content.active {
            display: block;
        }

        .trainings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .training-card {
            background: #ffffff;
            border: 1px solid #e3e6f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .training-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .training-card.disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        .training-image {
            height: 160px;
            overflow: hidden;
            position: relative;
        }

        .training-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .training-card:hover .training-image img {
            transform: scale(1.05);
        }

        .training-status {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            color: white;
        }

        .status-passed {
            background: #28a745;
        }

        .status-failed {
            background: #dc3545;
        }

        .status-overdue {
            background: #ffc107;
            color: #212529;
        }

        .status-public {
            background: #17a2b8;
        }

        .status-campaign {
            background: #6c757d;
        }

        .training-content {
            padding: 15px;
        }

        .training-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .training-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .training-stats {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .stats-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .stats-row:last-child {
            margin-bottom: 0;
        }

        .stat-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .training-action {
            text-align: center;
        }

        .btn-training {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-start {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-start:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        .lock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 20;
        }

        .lock-content {
            text-align: center;
            color: white;
        }

        .lock-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state img {
            width: 120px;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-state h4 {
            margin-bottom: 10px;
            color: #495057;
        }

        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .trainings-grid {
                grid-template-columns: 1fr;
            }

            .course-stats {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }

        .accordion-arrow {
            transition: transform 0.3s ease;
        }

        .level-header.active .accordion-arrow {
            transform: rotate(180deg);
        }

        .progress-bar-custom {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }
    </style>

    <style>
        /* Grade Section Styles */
        .info-card {
            background: #ffffff;
            border: 1px solid #e3e6f0;
            border-radius: 12px;
            margin-top: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .info-card-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }

        .info-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .info-card:hover .info-card-header::before {
            right: -30%;
        }

        .info-card-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            position: relative;
            z-index: 2;
        }

        .grade-icon {
            background: rgba(255, 215, 0, 0.3);
            color: #ffd700;
        }

        .info-card-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .grade-display {
            padding: 20px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .grade-score {
            font-size: 3rem;
            font-weight: 800;
            color: #28a745;
            line-height: 1;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
        }

        .grade-label {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 500;
        }

        .no-content {
            padding: 25px 20px;
            text-align: center;
            color: #6c757d;
        }

        .no-content i {
            font-size: 2.5rem;
            color: #dee2e6;
            margin-bottom: 15px;
            display: block;
        }

        .no-content p {
            font-size: 0.9rem;
            margin-bottom: 15px;
            color: #6c757d;
        }

        .no-content .btn {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .no-content .btn:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            color: white;
        }

        /* Survey Button Animation */
        .no-content .btn i {
            margin-right: 8px;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-card-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .grade-score {
                font-size: 2.5rem;
            }

            .no-content {
                padding: 20px 15px;
            }

            .no-content i {
                font-size: 2rem;
            }
        }

        /* Alternative style for when there's no survey (optional) */
        .info-card.no-survey {
            opacity: 0.7;
            pointer-events: none;
        }

        .info-card.no-survey .info-card-header {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }

        /* Success state animation */
        .grade-display.success {
            animation: successPulse 2s ease-in-out;
        }

        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Pending state styles */
        .no-content.pending i {
            color: #ffc107;
            animation: pendingSpin 2s linear infinite;
        }

        @keyframes pendingSpin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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
                                        <li class="breadcrumb-item"><a href="" style="display: flex;">
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
                                @if (auth()->user()->hasPermission('asset.create'))
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>
</div>




<section class="courses-section">
    @if (session()->has('quizMessage') && session()->has('quizResult'))
        <div
            class="alert {{ session()->get('quizResult') >= 70 ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show">
            <i class="fas {{ session()->get('quizResult') >= 70 ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
            {{ session()->get('quizMessage') }}
            <strong>{{ session()->get('quizResult') }}%</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('info'))
        <div
            class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session()->get('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (!empty($courses) && count($courses) > 0)
        <div class="courses-grid">
            <div class="row">
                <div class="col-md-12">
                    @foreach ($courses as $course)
                        <div class="course-card my-5">
                            <div class="course-header">
                                <h3 class="course-title">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    {{ $course->title }}
                                </h3>

                                @if ($course->description)
                                    <p class="course-description">{{ $course->description }}</p>
                                @endif

                                <div class="course-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-layer-group"></i>
                                        <span>{{ count($course->levels) }} {{ __('lms.Levels') }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-book-open"></i>
                                        <span>
                                            {{ collect($course->levels)->sum(function ($level) {
                                                return count($level->training_modules);
                                            }) }}
                                            {{ __('lms.Trainings') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="levels-accordion">
                                @if (count($course->levels) > 0)
                                    @foreach ($course->levels as $levelIndex => $level)
                                        <div class="level-item">
                                            <button class="level-header"
                                                onclick="toggleLevel(this, 'level-{{ $course->id }}-{{ $levelIndex }}')">
                                                <div>
                                                    <h4 class="level-title">
                                                        <i class="fas fa-layer-group me-2"></i>
                                                        {{ __('lms.Level') }} {{ $levelIndex + 1 }}:
                                                        {{ $level->title }}
                                                    </h4>
                                                    @if ($level->description)
                                                        <small style="opacity: 0.8;">{{ $level->description }}</small>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="level-badge">
                                                        {{ count($level->training_modules) }}
                                                        {{ __('lms.Trainings') }}
                                                    </span>
                                                    <i class="fas fa-chevron-down accordion-arrow"></i>
                                                </div>
                                            </button>

                                            <div id="level-{{ $course->id }}-{{ $levelIndex }}"
                                                class="level-content">
                                                @if (count($level->training_modules) > 0)
                                                    <div class="trainings-grid">
                                                        @foreach ($level->training_modules as $training)
                                                            <div
                                                                class="training-card {{ !$training->can_access ? 'disabled' : '' }}">
                                                                @if (!$training->can_access)
                                                                    <div class="lock-overlay">
                                                                        <div class="lock-content">
                                                                            <i class="fas fa-lock lock-icon"></i>
                                                                            <p class="mb-0">{{ __('lms.Locked') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="training-image">
                                                                    <img src="{{ asset('storage/' . $training->cover_image) }}"
                                                                        alt="{{ $training->name }}">

                                                                    <div class="training-status">
                                                                        @if ($training->is_passed)
                                                                            <span class="status-badge status-passed">
                                                                                <i class="fas fa-check-circle"></i>
                                                                                {{ __('lms.Passed') }}
                                                                            </span>
                                                                        @elseif($training->is_failed)
                                                                            <span class="status-badge status-failed">
                                                                                <i class="fas fa-times-circle"></i>
                                                                                {{ __('lms.Failed') }}
                                                                            </span>
                                                                        @elseif($training->is_overdue)
                                                                            <span class="status-badge status-overdue">
                                                                                <i class="fas fa-clock"></i>
                                                                                {{ __('lms.Over Due') }}
                                                                            </span>
                                                                        @elseif($training->training_type == 'public')
                                                                            <span class="status-badge status-public">
                                                                                <i class="fas fa-globe"></i>
                                                                                {{ __('lms.Public') }}
                                                                            </span>
                                                                        @else
                                                                            <span class="status-badge status-campaign">
                                                                                <i class="fas fa-users"></i>
                                                                                {{ __('lms.Campaign') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="training-content">
                                                                    <h5 class="training-title">{{ $training->name }}
                                                                    </h5>

                                                                    <div class="training-meta">
                                                                        <span>
                                                                            <i class="fas fa-book text-primary"></i>
                                                                            {{ $course->title }}
                                                                        </span>
                                                                        <span>
                                                                            <i class="fas fa-layer-group text-info"></i>
                                                                            {{ $level->title }}
                                                                        </span>
                                                                    </div>

                                                                    <div class="training-stats">
                                                                        <div class="stats-row">
                                                                            <div class="stat-group">
                                                                                <i
                                                                                    class="fas fa-question-circle text-primary"></i>
                                                                                <span>{{ $training->questions_count }}
                                                                                    {{ __('lms.Questions') }}</span>
                                                                            </div>
                                                                            <div class="stat-group">
                                                                                <i
                                                                                    class="fas fa-file-alt text-info"></i>
                                                                                <span>{{ $training->statements_count }}
                                                                                    {{ __('lms.Statements') }}</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="stats-row">
                                                                            <div class="stat-group">
                                                                                <i class="fas fa-tag text-warning"></i>
                                                                                <span>{{ ucfirst($training->training_type) }}</span>
                                                                            </div>
                                                                            @if ($training->remaining_attempts > 0)
                                                                                <div class="stat-group">
                                                                                    <i
                                                                                        class="fas fa-redo text-success"></i>
                                                                                    <span>{{ $training->remaining_attempts }}
                                                                                        {{ __('lms.Attempts') }}</span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    @if ($training->access_reason)
                                                                        <div class="text-muted small mb-3">
                                                                            <i class="fas fa-info-circle"></i>
                                                                            {{ $training->access_reason }}
                                                                        </div>
                                                                    @endif

                                                                    <div class="training-action">
                                                                        @if ($training->can_attempt)
                                                                            <button class="btn btn-training btn-start"
                                                                                onclick="showSwalWarning(event, '{{ route('user.lms.training.modules.getQuiz', $training->id) }}')">
                                                                                <i class="fas fa-play me-2"></i>
                                                                                {{ __('lms.Start Train') }}
                                                                            </button>
                                                                        @elseif($training->is_passed)
                                                                            <button
                                                                                class="btn btn-training btn-success"
                                                                                disabled>
                                                                                <i
                                                                                    class="fas fa-check-circle me-2"></i>
                                                                                {{ __('lms.Passed') }}
                                                                            </button>
                                                                        @elseif($training->is_overdue)
                                                                            <button
                                                                                class="btn btn-training btn-warning"
                                                                                disabled>
                                                                                <i class="fas fa-clock me-2"></i>
                                                                                {{ __('lms.Over Due') }}
                                                                            </button>
                                                                        @elseif($training->is_failed)
                                                                            <button class="btn btn-training btn-danger"
                                                                                disabled>
                                                                                <i
                                                                                    class="fas fa-times-circle me-2"></i>
                                                                                {{ __('lms.Failed') }}
                                                                            </button>
                                                                        @else
                                                                            <button
                                                                                class="btn btn-training btn-secondary"
                                                                                disabled>
                                                                                <i class="fas fa-ban me-2"></i>
                                                                                {{ __('lms.No Attempts') }}
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>


                                                                {{-- survy if not response --}}
                                                                {{-- Grade Section - Enhanced Version --}}
                                                                <div class="info-card">
                                                                    <div class="info-card-header">
                                                                        <div class="info-card-icon grade-icon">
                                                                            <i class="fas fa-trophy"></i>
                                                                        </div>
                                                                        <h3 class="info-card-title">
                                                                            {{ __('physicalCourses.your_grade') }}
                                                                        </h3>
                                                                    </div>

                                                                    @php
                                                                        $survey = $training->survey
                                                                            ? $training->survey->load('survyQuestions')
                                                                            : \App\Models\AwarenessSurvey::with(
                                                                                'survyQuestions',
                                                                            )->first();

                                                                        $userModule = $training
                                                                            ->users()
                                                                            ->where('user_id', auth()->id())
                                                                            ->first();

                                                                        $grade =
                                                                            $userModule && $userModule->pivot
                                                                                ? $userModule->pivot->score
                                                                                : null;

                                                                        $surveyResponse = auth()
                                                                            ->user()
                                                                            ->trainingSurveyResponses->where(
                                                                                'respondent_id',
                                                                                $training->id,
                                                                            )
                                                                            ->first();

                                                                        $hasCompletedSurvey =
                                                                            $surveyResponse &&
                                                                            $surveyResponse->is_completed;
                                                                    @endphp

                                                                    @if ($grade && $hasCompletedSurvey)
                                                                        <div class="grade-display success">
                                                                            <div class="grade-score">
                                                                                {{ $grade }}</div>
                                                                            <div class="grade-label">
                                                                                {{ __('physicalCourses.out_of') }}
                                                                                {{ $training->passing_score }}
                                                                            </div>
                                                                        </div>
                                                                    @elseif (!$hasCompletedSurvey && isset($survey) && $userModule)
                                                                        <div class="no-content">
                                                                            <i class="fas fa-clipboard-question"></i>
                                                                            <p class="mb-1">
                                                                                {{ __('physicalCourses.complete_the_survey_first') }}
                                                                            </p>
                                                                            <a href="{{ route('user.lms.training.modules.surveys.show', [
                                                                                'survey' => $survey->id,
                                                                                'type' => 'training_module',
                                                                                'id' => $training->id,
                                                                            ]) }}"
                                                                                class="btn btn-primary btn-sm mt-1">
                                                                                <i class="fas fa-play"></i>
                                                                                {{ __('physicalCourses.start_survey') }}
                                                                            </a>
                                                                        </div>
                                                                    @else
                                                                        <div class="no-content pending">
                                                                            <i class="fas fa-clock"></i>
                                                                            <p class="mb-0">
                                                                                {{ __('physicalCourses.grade_not_evaluated_yet') }}
                                                                            </p>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        {{ __('lms.No training modules available for this level') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-3">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            {{ __('lms.No levels available for this course') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <img src="{{ asset('backend/images/addnewitem.svg') }}" alt="No courses">
            <h4>{{ __('lms.No training courses available') }}</h4>
            <p>{{ __('lms.Please contact your administrator to assign training courses') }}</p>
        </div>
    @endif
</section>
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script>
    function toggleLevel(button, levelId) {
        const content = document.getElementById(levelId);
        const isActive = button.classList.contains('active');

        const courseCard = button.closest('.course-card');
        const allHeaders = courseCard.querySelectorAll('.level-header');
        const allContents = courseCard.querySelectorAll('.level-content');

        allHeaders.forEach(header => header.classList.remove('active'));
        allContents.forEach(content => content.classList.remove('active'));

        if (!isActive) {
            button.classList.add('active');
            content.classList.add('active');
        }
    }

    function showSwalWarning(event, url) {
        event.preventDefault();
        Swal.fire({
            title: "{{ __('lms.Important Notice') }}",
            text: "{{ __('lms.If you proceed to training and refresh the page, your score will be calculated and you will not be able to Re-exercise. Are you sure you want to continue ?') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('lms.Yes, proceed') }}",
            cancelButtonText: "{{ __('lms.Cancel') }}",
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.course-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    $('.modal').on('hidden.bs.modal', function() {
        const form = $(this).find('form');
        if (form.length) {
            form.trigger("reset");
            form.find('.error').empty();
            form.find('select').trigger('change');
        }
    });
</script>
@endsection
