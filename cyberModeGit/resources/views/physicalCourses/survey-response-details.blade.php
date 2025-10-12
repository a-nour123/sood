@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Survey Response Details')

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

    <style type="text/css" media="print">
        .btn,
        .card-header .btn,
        .stats-card:hover {
            display: none !important;
        }

        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }

        .question-card {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        body {
            font-size: 12pt;
            line-height: 1.4;
        }
    </style>

    <style>
        .survey-response-card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .question-card {
            background: #f8f9fa;
            border-left: 4px solid #7367f0;
            margin-bottom: 1.5rem;
            border-radius: 8px;
        }

        .question-number {
            background: #7367f0;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .answer-highlight {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 6px;
            padding: 10px;
            margin-top: 10px;
        }

        .multiple-choice-answer {
            background: #f1f8e9;
            border: 1px solid #4caf50;
            border-radius: 6px;
            padding: 8px 12px;
            display: inline-block;
            margin-top: 5px;
        }

        .response-status {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
        }

        .stats-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .completion-progress {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            overflow: hidden;
        }

        .completion-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            transition: width 0.3s ease;
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

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">Survey Response Details</h3>
                        <p class="text-muted mb-0">Detailed view of individual survey response</p>
                    </div>
                    <div class="d-flex gap-2">
                        @if ($type === 'course')
                            <a href="{{ route('admin.physical-courses.courses.survey.results', ['type' => $type, 'id' => $id]) }}"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Survey Results
                            </a>
                        @elseif($type === 'training_module')
                            <a href="{{ route('admin.training.modules.survey.results', ['type' => $type, 'id' => $id]) }}"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Survey Results
                            </a>
                        @endif
                        <button type="button" class="btn btn-outline-danger"
                            onclick="deleteResponse({{ $response->id }})">
                            <i class="fas fa-trash me-1"></i>Delete Response
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Response Overview -->
        <div class="row mb-4">
            <!-- User Information -->
            <div class="col-md-4">
                <div class="card user-info-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-4x opacity-75"></i>
                        </div>
                        <h5 class="mb-1">{{ $response->user->name ?? 'Anonymous' }}</h5>
                        <p class="mb-2 opacity-75">{{ $response->user->email ?? 'No email provided' }}</p>
                        <div class="row text-center mt-3">
                            <div class="col-6">
                                <small class="d-block opacity-75">User ID</small>
                                <strong>{{ $response->user_id ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="d-block opacity-75">Response ID</small>
                                <strong>{{ $response->id }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Statistics -->
            <div class="col-md-8">
                <div class="row h-100">
                    <div class="col-md-6 mb-3">
                        <div class="stats-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-lighten-3 p-2 rounded">
                                            <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Submission Date</h6>
                                        <p class="text-muted mb-1">{{ $response->created_at->format('M d, Y - H:i') }}
                                        </p>
                                        <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="stats-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div
                                            class="bg-{{ $response->is_completed ? 'success' : 'warning' }} bg-lighten-3 p-2 rounded">
                                            <i
                                                class="fas fa-{{ $response->is_completed ? 'check-circle' : 'clock' }} text-{{ $response->is_completed ? 'success' : 'warning' }} fa-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Status</h6>
                                        <span
                                            class="badge badge-light-{{ $response->is_completed ? 'success' : 'warning' }} response-status">
                                            {{ $response->is_completed ? 'Completed' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="stats-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info bg-lighten-3 p-2 rounded">
                                            <i class="fas fa-question-circle text-info fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Completion Rate</h6>
                                        @php
                                            $totalQuestions = $response->survey->survyQuestions->count();
                                            $answeredQuestions = $response->questionAnswers->count();
                                            $completionRate =
                                                $totalQuestions > 0
                                                    ? round(($answeredQuestions / $totalQuestions) * 100)
                                                    : 0;
                                        @endphp
                                        <div class="completion-progress mb-1">
                                            <div class="completion-fill" style="width: {{ $completionRate }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $answeredQuestions }}/{{ $totalQuestions }}
                                            questions ({{ $completionRate }}%)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="stats-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-secondary bg-lighten-3 p-2 rounded">
                                            <i class="fas fa-globe text-secondary fa-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Response Details</h6>
                                        <p class="text-muted mb-1">IP: {{ $response->ip_address ?? 'N/A' }}</p>
                                        <small
                                            class="text-muted">{{ Str::limit($response->user_agent ?? 'N/A', 30) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Survey Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card survey-response-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i
                                class="fas fa-clipboard-list me-2"></i>{{ $response->survey->title ?? 'Survey Response' }}
                        </h5>
                        @if ($response->survey->description)
                            <p class="text-muted mb-0 mt-1">{{ $response->survey->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions and Answers -->
        <div class="row">
            <div class="col-12">
                <div class="card survey-response-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-comments me-2"></i>Survey Responses
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($response->questionAnswers->count() > 0)
                            @foreach ($response->questionAnswers as $index => $answer)
                                <div class="question-card p-4">
                                    <!-- Question Header -->
                                    <div class="d-flex align-items-start mb-3">
                                        <span class="question-number">{{ $index + 1 }}</span>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2 fw-bold">{{ $answer->question->question }}</h6>
                                            @if ($answer->question->description)
                                                <p class="text-muted small mb-0">{{ $answer->question->description }}
                                                </p>
                                            @endif
                                        </div>
                                        <span
                                            class="badge badge-light-{{ $answer->is_draft ? 'warning' : 'success' }}">
                                            {{ $answer->is_draft ? 'Draft' : 'Final' }}
                                        </span>
                                    </div>

                                    <!-- Answer Content -->
                                    <div class="ms-5">
                                        @foreach (['A', 'B', 'C', 'D', 'E'] as $option)
                                            @if (!empty($answer->question->{"option_$option"}))
                                                <div class="option-item">
                                                    <label class="d-flex align-items-center">
                                                        <input type="radio" value="{{ $option }}"
                                                            class="form-check-input me-2"
                                                            @if ($answer->answer_text === $option) checked @endif disabled>
                                                        <span>{{ $option }}.
                                                            {{ $answer->question->{"option_$option"} }}</span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if ($answer->answer_text)
                                            <div class="multiple-choice-answer">
                                                <strong>{{ $answer->answer_text }}.</strong>
                                                @php
                                                    $optionField = 'option_' . strtoupper($answer->answer_text);
                                                @endphp
                                                {{ $answer->question->$optionField ?? 'Option not found' }}
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                <i class="fas fa-minus-circle me-1"></i>No option selected
                                            </div>
                                        @endif

                                        <!-- Answer Timestamp -->
                                        {{-- @if ($answer->updated_at)
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Last updated: {{ $answer->updated_at->format('M d, Y H:i') }}
                                                </small>
                                            </div>
                                        @endif --}}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No responses found</h5>
                                <p class="text-muted">This survey response doesn't contain any answers yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Response Metadata -->
        @if ($response->created_at != $response->updated_at)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <h6>Created At</h6>
                                    <p class="text-muted">{{ $response->created_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Last Updated</h6>
                                    <p class="text-muted">{{ $response->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script> --}}
    <script src="{{ asset('new_d/js/chart.js')}}"></script>

@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Add smooth animations
            $('.question-card').addClass('animate__animated animate__fadeInUp');

            // Animate completion progress bar
            setTimeout(function() {
                $('.completion-fill').css('width', $('.completion-fill').attr('style').match(
                    /width:\s*(\d+)%/)[1] + '%');
            }, 500);
        });

        function deleteResponse(responseId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.physical-courses.courses.survey.response.delete', ':id') }}"
                            .replace(':id', responseId),
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Redirect back to survey results
                                    @if ($type === 'course')
                                        window.location.href =
                                            "{{ route('admin.physical-courses.courses.survey.results', ['type' => $type, 'id' => $id]) }}";
                                    @elseif ($type === 'training_module')
                                        window.location.href =
                                            "{{ route('admin.training.modules.survey.results', ['type' => $type, 'id' => $id]) }}";
                                    @endif
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'An error occurred while deleting the response';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire('Error!', errorMessage, 'error');
                        }
                    });
                }
            });
        }

        // Print functionality
        function printResponse() {
            window.print();
        }

        // Export functionality (if needed)
        function exportResponse() {
            // Implementation for exporting response data
            toastr.info('Export functionality can be implemented here', 'Info');
        }
    </script>
@endsection
