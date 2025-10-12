@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.Survy'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <style>
        .survey-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .question-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .question-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .question-number {
            background: #007bff;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .option-item {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .option-item:hover {
            background-color: #f8f9fa;
        }

        .option-item input[type="radio"] {
            margin-right: 10px;
        }

        .text-answer {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
        }

        .survey-header {
            background: linear-gradient(135deg, #44225c 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .survey-actions {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .btn-survey {
            min-width: 120px;
            margin: 0 10px;
        }

        .progress-bar-container {
            background: #f0f0f0;
            height: 8px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #44225c, #0056b3);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .required-star {
            color: #dc3545;
        }

        .respondent-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4">
        <!-- Breadcrumbs -->
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
                                    @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (session()->has('info'))
        <div
            class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session()->get('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Survey Content -->
    <div class="survey-container">
        @if (isset($survey))
            <!-- Survey Header -->
            <div class="survey-header">
                <h2>{{ $survey->title }}</h2>
                @if ($survey->description)
                    <p class="mb-0 mt-3">{{ $survey->description }}</p>
                @endif
            </div>

            <!-- Respondent Information -->
            @if (isset($respondent))
                <div class="respondent-info">
                    <h5><i class="fas fa-info-circle me-2"></i>{{ __('physicalCourses.course_information') }}</h5>
                    <p class="mb-0">
                        <strong>{{ __('physicalCourses.course_name') }}:</strong>
                        {{ $respondent->name ?? $respondent->title }}
                    </p>
                    @if (isset($respondent->description))
                        <p class="mb-0 mt-2">
                            <strong>{{ __('physicalCourses.description') }}:</strong> {{ $respondent->description }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-bar" id="progressBar" style="width: 0%"></div>
            </div>

            <!-- Survey Form -->
            <form id="surveyForm"
                action="{{ route('user.lms.training.modules.surveys.submit', ['survey' => $survey->id, 'type' => $type, 'id' => $id]) }}"
                method="POST">
                @csrf

                @if ($survey->survyQuestions->count() > 0)
                    @foreach ($survey->survyQuestions as $index => $question)
                        <div class="question-card" data-question="{{ $loop->iteration }}">
                            <div class="question-title">
                                <span class="question-number">{{ $loop->iteration }}</span>
                                {{ $question->question }}
                                @if ($question->is_required)
                                    <span class="required-star">*</span>
                                @endif
                            </div>

                            <div class="options-container">
                                <!-- Multiple Choice Options -->
                                @foreach (['A', 'B', 'C', 'D', 'E'] as $option)
                                    @if (!empty($question->{"option_$option"}))
                                        <div class="option-item">
                                            <label class="d-flex align-items-center">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="{{ $option }}" class="form-check-input me-2"
                                                    @if (isset($previousAnswers[$question->id]) && $previousAnswers[$question->id] === $option) checked @endif
                                                    @if ($question->is_required) required @endif>
                                                <span>{{ $option }}. {{ $question->{"option_$option"} }}</span>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            @error('answers.' . $question->id)
                                <div class="text-danger mt-2">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    @endforeach

                    <!-- Survey Actions -->
                    <div class="survey-actions">
                        {{-- @if ((isset($existingResponse) && !$existingResponse->is_completed) || !isset($existingResponse)) --}}
                            <button type="submit" name="save_draft" class="btn btn-outline-primary btn-survey">
                                <i class="fas fa-save me-2"></i>{{ __('physicalCourses.save_draft') }}
                            </button>

                            <button type="submit" class="btn btn-primary btn-survey">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('physicalCourses.submit_survey') }}
                            </button>
                        {{-- @endif --}}

                        <a href="{{ route('user.lms.training.modules.index') }}"
                            class="btn btn-secondary btn-survey">
                            <i class="fas fa-times me-2"></i>{{ __('physicalCourses.cancel') }}
                        </a>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('physicalCourses.no_questions_available') }}
                    </div>
                @endif
            </form>
        @else
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ __('physicalCourses.survey_not_found') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function() {
        const totalQuestions = $('.question-card').length;

        // Update progress bar
        function updateProgressBar() {
            const answeredQuestions = $('input[type="radio"]:checked, textarea').filter(function() {
                return $(this).val().trim() !== '';
            }).length;
            const progress = totalQuestions > 0 ? (answeredQuestions / totalQuestions) * 100 : 0;
            $('#progressBar').css('width', progress + '%');
        }

        // Initialize progress bar
        updateProgressBar();

        // Update progress when answers change
        $('input[type="radio"], textarea').on('change input', function() {
            updateProgressBar();
        });

        // Enhanced form submission handling with AJAX
        $('#surveyForm').on('submit', function(e) {
            e.preventDefault(); // Always prevent default form submission

            const isDraft = e.originalEvent.submitter && e.originalEvent.submitter.name ===
            'save_draft';
            const form = $(this);
            const formData = new FormData(this);

            // Add the button name to form data if it's a draft
            if (isDraft) {
                formData.append('save_draft', '1');
            }

            if (!isDraft) {
                // For final submission, check ALL required questions are answered
                const allQuestions = $('.question-card');
                const unansweredQuestions = [];

                allQuestions.each(function(index) {
                    const questionCard = $(this);
                    const isRequired = questionCard.find('.required-star').length > 0;

                    if (isRequired) {
                        const hasRadioAnswer = questionCard.find('input[type="radio"]:checked')
                            .length > 0;
                        const textAnswer = questionCard.find('textarea').val();
                        const hasTextAnswer = textAnswer && textAnswer.trim() !== '';

                        if (!hasRadioAnswer && !hasTextAnswer) {
                            unansweredQuestions.push(index + 1);
                            // Highlight unanswered question
                            questionCard.addClass('border-danger');
                        } else {
                            questionCard.removeClass('border-danger');
                        }
                    }
                });

                if (unansweredQuestions.length > 0) {
                    Swal.fire({
                        title: '{{ __('physicalCourses.incomplete_form') }}',
                        html: `{{ __('physicalCourses.please_answer_required_questions') }}<br><br>
                               <strong>Unanswered questions: ${unansweredQuestions.join(', ')}</strong>`,
                        icon: 'warning',
                        confirmButtonText: '{{ __('physicalCourses.ok') }}',
                        customClass: {
                            popup: 'animated tada'
                        }
                    });

                    // Scroll to first unanswered question
                    const firstUnanswered = $('.question-card').eq(unansweredQuestions[0] - 1);
                    $('html, body').animate({
                        scrollTop: firstUnanswered.offset().top - 100
                    }, 500);

                    return false;
                }

                // Confirmation dialog for complete submission
                Swal.fire({
                    title: '{{ __('physicalCourses.confirm_submission') }}',
                    text: '{{ __('physicalCourses.survey_submission_warning') }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('physicalCourses.yes_submit') }}',
                    cancelButtonText: '{{ __('physicalCourses.cancel') }}',
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitSurveyAjax(form, formData, isDraft);
                    }
                });
            } else {
                // For draft saving, submit directly
                submitSurveyAjax(form, formData, isDraft);
            }
        });

        // AJAX submission function
        function submitSurveyAjax(form, formData, isDraft) {
            // Show loading
            Swal.fire({
                title: isDraft ? '{{ __('physicalCourses.saving_draft') }}' :
                    '{{ __('physicalCourses.submitting') }}',
                text: '{{ __('physicalCourses.please_wait') }}',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    Swal.close();

                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                // For draft saves, just show success message
                                toastr.success(response.message);
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'An error occurred',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    Swal.close();

                    if (xhr.status === 422) {
                        // Validation errors
                        const response = JSON.parse(xhr.responseText);
                        let errorMessages = '';

                        if (response.errors) {
                            Object.values(response.errors).forEach(errors => {
                                if (Array.isArray(errors)) {
                                    errors.forEach(error => {
                                        errorMessages += error + '<br>';
                                    });
                                } else {
                                    errorMessages += errors + '<br>';
                                }
                            });
                        }

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorMessages ||
                                'Please check your answers and try again.',
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while submitting the survey. Please try again.',
                            icon: 'error'
                        });
                    }
                }
            });
        }
    });
</script>
@endsection
