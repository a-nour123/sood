@extends('admin/layouts/contentLayoutMaster')

@section('title', __('LMS.Quiz Preview'))

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
    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/all.css') }}">
    <link rel="shortcut icon" href="{{ asset('lms-quizes/assets/images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('lms-quizes/introjs/introjs.css') }}">

    <style>
        .modal-body {
            background-color: #f8f9fa;
        }

        .accordion-button {
            background-color: #e9ecef;
            color: #000;
        }

        .accordion-body {
            padding: 10px;
        }

        .img-fluid {
            margin-bottom: 10px;
            border-radius: 10px;
        }

        /* Preview Mode Styles */
        .preview-mode-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #17a2b8;
            color: white;
            padding: 10px 15px;
            border-radius: 25px;
            font-weight: bold;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .preview-mode-indicator i {
            margin-right: 8px;
        }

        /* Base style for all dropdown toggles */
        .dropdown-toggle::after {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            margin-left: auto;
            padding-left: 1.25rem;
            content: "";
            transition: background-image 0.2s ease-in-out;
        }

        .btn-light.dropdown-toggle::after {
            border: none;
        }

        .schemeItem {
            border: 1px solid rgba(0, 0, 0, .125);
            transition: border-color 0.3s ease;
        }

        .schemeItem:hover {
            border-color: #0d6efd;
        }

        .schemeItemNotSelected {
            background-color: white;
        }

        .schemeItemSelected {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .darkBackground {
            background-color: #fff;
        }

        .nav-tabs .nav-link-light {
            color: white;
        }

        .nav-tabs .nav-link-dark {
            color: #212529;
        }

        h1,
        label {
            color: #44225c !important;
        }

        /* Preview mode specific styles */
        .preview-option {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 25px;
        }

        .preview-option:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .preview-option.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .preview-option.correct {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }

        .preview-option.incorrect {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .preview-feedback {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .preview-feedback.correct {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .preview-feedback.incorrect {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media screen and (min-width: 0px) and (max-width: 770px) {
            .stepItemMobile {
                overflow-y: scroll !important;
                height: 70vh !important;
            }

            .rounded-pill {
                border-radius: 0rem !important;
            }

            .preview-mode-indicator {
                position: relative;
                top: 0;
                right: 0;
                margin-bottom: 20px;
                width: 100%;
                text-align: center;
            }
        }

        .fslightbox-slide-btn-container {
            display: none !important;
        }

        /* Navigation buttons styling */
        .form_btn {
            position: relative;
            text-align: center;
            margin-top: 30px;
        }

        .f_btn {
            background: #44225c;
            border: none;
            padding: 12px 30px;
            margin: 0 10px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .f_btn:hover {
            background: #5a2d75;
            transform: translateY(-2px);
        }

        .f_btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }
    </style>
@endsection

@section('content')
    @php
        // Helper function to get content with fallback
        function getContentWithFallback($content, $field, $fallbackField = null)
        {
            $currentLocale = app()->getLocale();

            if ($currentLocale === 'ar') {
                $primaryField = $field . '_ar';
                $fallbackField = $fallbackField ?: $field;
            } else {
                $primaryField = $field;
                $fallbackField = $field . '_ar';
            }

            // Check if primary field exists and is not empty
            if (isset($content[$primaryField]) && !empty(trim($content[$primaryField]))) {
                return $content[$primaryField];
            }

            // Return fallback if primary is empty
            if (isset($content[$fallbackField]) && !empty(trim($content[$fallbackField]))) {
                return $content[$fallbackField];
            }

            // Return empty string if both are empty
            return '';
        }

        // function getMediaWithFallback($content, $field)
        // {
        //     $currentLocale = app()->getLocale();

        //     if ($currentLocale === 'ar') {
        //         $primaryField = $field . '_ar';
        //         $fallbackField = $field;
        //     } else {
        //         $primaryField = $field;
        //         $fallbackField = $field . '_ar';
        //     }

        //     $checkFileExists = function ($fieldName) use ($content) {
        //         return isset($content[$fieldName]) &&
        //             !empty($content[$fieldName]) &&
        //             file_exists(storage_path('app/public/' . $content[$fieldName]));
        //     };

        //     if ($checkFileExists($primaryField)) {
        //         return $content[$primaryField];
        //     }

        //     if ($checkFileExists($fallbackField)) {
        //         return $content[$fallbackField];
        //     }

        //     $alternativeFields = [];

        //     if ($field === 'video_or_image_url') {
        //         $alternativeFields = ['video_or_image_url_en', 'image', 'image_ar'];
        //     } elseif ($field === 'image') {
        //         $alternativeFields = [
        //             'image_ar',
        //             'video_or_image_url',
        //             'video_or_image_url_ar',
        //             'video_or_image_url_en',
        //         ];
        //     }

        //     foreach ($alternativeFields as $altField) {
        //         if ($checkFileExists($altField)) {
        //             return $content[$altField];
        //         }
        //     }

        //     return null;
        // }

        function getMediaWithFallback($content, $field)
        {
            $currentLocale = app()->getLocale();

            $checkFileExists = function ($fieldName) use ($content) {
                return isset($content[$fieldName]) &&
                    !empty($content[$fieldName]) &&
                    file_exists(storage_path('app/public/' . $content[$fieldName]));
            };

            $primaryFields = [];
            $fallbackFields = [];

            if ($currentLocale === 'ar') {
                if ($field === 'video_or_image_url') {
                    $primaryFields = ['video_or_image_url', 'image_ar'];
                    $fallbackFields = ['video_or_image_url_en', 'image'];
                } else {
                    $primaryFields = ['image_ar', 'video_or_image_url'];
                    $fallbackFields = ['image', 'video_or_image_url_en'];
                }
            } else {
                if ($field === 'video_or_image_url') {
                    $primaryFields = ['video_or_image_url_en', 'image'];
                    $fallbackFields = ['video_or_image_url', 'image_ar'];
                } else {
                    $primaryFields = ['image', 'video_or_image_url_en'];
                    $fallbackFields = ['image_ar', 'video_or_image_url'];
                }
            }

            foreach ($primaryFields as $fieldName) {
                if ($checkFileExists($fieldName)) {
                    return $content[$fieldName];
                }
            }

            foreach ($fallbackFields as $fieldName) {
                if ($checkFileExists($fieldName)) {
                    return $content[$fieldName];
                }
            }

            return null;
        }

        function getMediaType($filePath)
        {
            if (!$filePath) {
                return null;
            }

            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (in_array($extension, $videoExtensions)) {
                return 'video';
            } elseif (in_array($extension, $imageExtensions)) {
                return 'image';
            }

            return 'unknown';
        }
    @endphp

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
                                            <a href="" style="display: flex;">
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
                        <div class="col-sm-6 pe-0" style="text-align: end;">
                            <div class="action-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="quill-service-content" class="d-none"></div>

<div>
    <section class="">
        <div class="container">
            <div class="row">
                <form class="multisteps_form" style="text-align:center" id="wizard">
                    @foreach ($pages as $index => $page)
                        <input type="hidden" id="pageType_{{ $index }}" name="pageType"
                            value="{{ $page['type'] }}">

                        @if ($page['type'] == 'statement')
                            <div class="multisteps_form_panel step">
                                <div class="col-md-7 m-auto">
                                    <div class="content_box py-2 ps-5 position-relative stepItemMobile text-center">
                                        <!-- Step-progress-bar -->
                                        <div class="step_progress_bar mb-3">
                                            <div class="progress rounded-pill">
                                                <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                                    style="width: {{ ($index * 100) / count($pages) }}%;"
                                                    aria-valuenow="{{ ($index * 100) / count($pages) }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ number_format(($index * 100) / count($pages), 1) }}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question_title py-3">
                                            <h1>{{ getContentWithFallback($page['content'], 'title') }}</h1>
                                        </div>
                                        <label
                                            class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill"
                                            style="font-size:1.25rem; font-family:system-ui !important;">
                                            {!! getContentWithFallback($page['content'], 'content') !!}
                                        </label>
                                        <div class="pt-2 animate__animated animate__fadeInRight animate_25ms">
                                            @if ($page['content']['additional_content'] == 'video')
                                                @php
                                                    $videoUrl = getMediaWithFallback(
                                                        $page['content'],
                                                        'video_or_image_url',
                                                    );

                                                    if ($videoUrl && getMediaType($videoUrl) !== 'video') {
                                                        $videoUrl = null;
                                                    }
                                                @endphp
                                                @if ($videoUrl)
                                                    <video class="videoStatement" style="width: 100%;" controls
                                                        height="400px">
                                                        <source src="{{ asset('storage/' . $videoUrl) }}"
                                                            type="video/mp4">
                                                        <p>{{ __('Your browser does not support the video tag.') }}</p>
                                                    </video>
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle"></i>
                                                        {{ __('Video not available') }}
                                                    </div>
                                                @endif
                                            @endif

                                            @if ($page['content']['additional_content'] == 'image')
                                                @php
                                                    $imageUrl = getMediaWithFallback($page['content'], 'image');

                                                    if (!$imageUrl) {
                                                        $imageUrl = getMediaWithFallback(
                                                            $page['content'],
                                                            'video_or_image_url',
                                                        );

                                                        if ($imageUrl && getMediaType($imageUrl) !== 'image') {
                                                            $imageUrl = null;
                                                        }
                                                    }
                                                @endphp
                                                @if ($imageUrl)
                                                    <img src="{{ asset('storage/' . $imageUrl) }}" class="img-fluid"
                                                        style="width: 100%;"
                                                        alt="{{ getContentWithFallback($page['content'], 'title') }}" />
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle"></i>
                                                        {{ __('Image not available') }}
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="multisteps_form_panel step">
                                <div class="col-md-7 m-auto">
                                    <div class="content_box py-2 ps-5 position-relative stepItemMobile text-center">
                                        <div class="progress-showcase mb-3">
                                            <div class="progress align-items-center"
                                                style="height: 15px; padding: 0; margin: 0;">
                                                <div class="progress-bar mx-2" role="progressbar"
                                                    style="width: {{ ($index * 100) / count($pages) }}%;height: 15px;line-height: 15px; margin: 0;"
                                                    aria-valuenow="{{ ($index * 100) / count($pages) }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ number_format(($index * 100) / count($pages), 1) }}%
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Question -->
                                        <div class="question_title py-3 text-center">
                                            <input type="hidden" class="question_id_{{ $index }}"
                                                id="question_id_{{ $index }}" name="question_id"
                                                value="{{ $page['content']['id'] }}">
                                            <input type="hidden" class="question_type_{{ $index }}"
                                                id="question_type_{{ $index }}" name="question_type"
                                                value="{{ $page['content']['question_type'] }}">
                                            <h1>{{ getContentWithFallback($page['content'], 'question') }}</h1>
                                        </div>

                                        <div class="form_items scenarioQuestions text-center">
                                            <!-- Preview Feedback Area -->
                                            <div id="previewFeedback{{ $index }}" class="preview-feedback"
                                                style="display: none;"></div>

                                            <!-- Question Answer Description -->
                                            <div id="answerDescription{{ $index }}" class="pt-3"
                                                style="text-align:center; display: none;">
                                                <h3 style="font-weight:400" id="answer{{ $index }}"></h3>
                                                <h6
                                                    style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                                    {{ getContentWithFallback($page['content'], 'answer_description') }}
                                                </h6>
                                            </div>

                                            <!-- Question Options -->
                                            <div id="answerQuestions{{ $index }}">
                                                @if ($page['content']['question_type'] == 'multi_choise')
                                                    @foreach ($page['options'] as $optIndex => $option)
                                                        <div class="preview-option" data-step="{{ $index }}"
                                                            data-option="{{ $optIndex }}"
                                                            data-correct="{{ $option['is_correct'] }}"
                                                            onclick="handlePreviewOption({{ $index }}, {{ $optIndex }}, {{ $option['is_correct'] }})">
                                                            {{ getContentWithFallback($option, 'option_text') }}
                                                            <input type="radio"
                                                                name="stp_{{ $index }}_select_option"
                                                                value="{{ $option['id'] }}" style="display: none;">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="preview-option" data-step="{{ $index }}"
                                                        data-option="true"
                                                        data-correct="{{ $page['content']['correct_answer'] == 1 ? 1 : 0 }}"
                                                        onclick="handlePreviewTrueFalse({{ $index }}, true, {{ $page['content']['correct_answer'] }})">
                                                        {{ __('lms.True') }}
                                                        <input type="radio"
                                                            name="stp_{{ $index }}_select_option"
                                                            value="true" style="display: none;">
                                                    </div>

                                                    <div class="preview-option" data-step="{{ $index }}"
                                                        data-option="false"
                                                        data-correct="{{ $page['content']['correct_answer'] == 0 ? 1 : 0 }}"
                                                        onclick="handlePreviewTrueFalse({{ $index }}, false, {{ $page['content']['correct_answer'] }})">
                                                        {{ __('lms.False') }}
                                                        <input type="radio"
                                                            name="stp_{{ $index }}_select_option"
                                                            value="false" style="display: none;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- Form buttons -->
                    <div class="form_btn">
                        <button type="button" class="f_btn prev_btn" id="prevBtn" onclick="nextPrev(-1)">
                            {{ __('lms.Back') }}
                        </button>
                        <button type="button" class="f_btn next_btn" id="nextBtn" onclick="nextPrev(1)">
                            {{ __('lms.Next') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset('lms-quizes/quiz/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('lms-quizes/quiz/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('lms-quizes/quiz/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('lms-quizes/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('lms-quizes/front4/vendor/fslightbox/index.js') }}"></script>
<script src="{{ asset('lms-quizes/introjs/intro.js') }}"></script>
<script src="{{ asset('lms-quizes/assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('lms-quizes/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<script>
    // Preview Mode Variables
    var currentTab = 0;
    var totalTabs = 0;
    var previewAnswers = {}; // Store preview answers

    // Initialize
    $(document).ready(function() {
        totalTabs = document.getElementsByClassName("multisteps_form_panel").length;
        showTab(currentTab);

        // Show preview mode notification
        toastr.info('{{ __('You are in preview mode. You can navigate freely and see correct answers.') }}',
            'Preview Mode', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true
            });
    });

    // Show specific tab
    function showTab(n) {
        var x = document.getElementsByClassName("multisteps_form_panel");

        // Hide all tabs
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        // Show current tab
        if (x[n]) {
            x[n].style.display = "block";
        }

        // Update navigation buttons
        updateNavigationButtons();

        // Update step indicator
        fixStepIndicator(n);

        // Handle video elements
        handleVideoElements();
    }

    // Update navigation buttons
    function updateNavigationButtons() {
        var prevBtn = document.getElementById("prevBtn");
        var nextBtn = document.getElementById("nextBtn");

        // Show/hide previous button
        if (currentTab == 0) {
            prevBtn.style.display = "none";
        } else {
            prevBtn.style.display = "inline-block";
        }

        // Update next button text
        if (currentTab == (totalTabs - 1)) {
            nextBtn.innerHTML = "{{ __('lms.Finish Preview') }}";
        } else {
            nextBtn.innerHTML = "{{ __('lms.Next') }}";
        }
    }

    // Navigate between tabs
    function nextPrev(n) {
        var x = document.getElementsByClassName("multisteps_form_panel");

        // Hide current tab
        if (x[currentTab]) {
            x[currentTab].style.display = "none";
        }

        // Update current tab
        currentTab = currentTab + n;

        // Check boundaries
        if (currentTab < 0) {
            currentTab = 0;
        }

        if (currentTab >= totalTabs) {
            // Finish preview
            finishPreview();
            return false;
        }

        // Show new tab
        showTab(currentTab);
        return true;
    }

    // Handle preview option selection for multiple choice
    function handlePreviewOption(stepIndex, optionIndex, isCorrect) {
        // Clear previous selections for this step
        clearStepSelections(stepIndex);

        // Get all options for this step
        var stepOptions = document.querySelectorAll(`[data-step="${stepIndex}"]`);

        // Mark selected option
        stepOptions[optionIndex].classList.add('selected');

        // Show feedback after a short delay
        setTimeout(function() {
            showPreviewFeedback(stepIndex, isCorrect, stepOptions, optionIndex);
        }, 300);

        // Store answer
        previewAnswers[stepIndex] = {
            selected: optionIndex,
            correct: isCorrect
        };
    }

    // Handle preview option selection for true/false
    function handlePreviewTrueFalse(stepIndex, selectedValue, correctAnswer) {
        // Clear previous selections for this step
        clearStepSelections(stepIndex);

        // Get the clicked option
        var clickedOption = event.target;
        clickedOption.classList.add('selected');

        // Check if answer is correct
        var isCorrect = (selectedValue === true && correctAnswer == 1) ||
            (selectedValue === false && correctAnswer == 0);

        // Show feedback after a short delay
        setTimeout(function() {
            showPreviewFeedbackTrueFalse(stepIndex, isCorrect, clickedOption);
        }, 300);

        // Store answer
        previewAnswers[stepIndex] = {
            selected: selectedValue,
            correct: isCorrect
        };
    }

    // Clear previous selections for a step
    function clearStepSelections(stepIndex) {
        var stepOptions = document.querySelectorAll(`[data-step="${stepIndex}"]`);
        stepOptions.forEach(function(option) {
            option.classList.remove('selected', 'correct', 'incorrect');
        });

        // Hide previous feedback
        var feedback = document.getElementById(`previewFeedback${stepIndex}`);
        if (feedback) {
            feedback.style.display = 'none';
        }
    }

    // Show feedback for multiple choice
    function showPreviewFeedback(stepIndex, isCorrect, allOptions, selectedIndex) {
        // Mark all options as correct/incorrect
        allOptions.forEach(function(option, index) {
            var optionCorrect = parseInt(option.getAttribute('data-correct'));
            if (index === selectedIndex) {
                // This is the selected option
                if (isCorrect) {
                    option.classList.add('correct');
                } else {
                    option.classList.add('incorrect');
                }
            } else if (optionCorrect === 1) {
                // This is the correct option (show it)
                option.classList.add('correct');
                option.style.opacity = '0.7';
            }
        });

        // Show feedback message
        var feedback = document.getElementById(`previewFeedback${stepIndex}`);
        if (feedback) {
            feedback.style.display = 'block';
            if (isCorrect) {
                feedback.className = 'preview-feedback correct';
                feedback.innerHTML = '<i class="fas fa-check-circle"></i> {{ __('Correct! Well done.') }}';
            } else {
                feedback.className = 'preview-feedback incorrect';
                feedback.innerHTML =
                    '<i class="fas fa-times-circle"></i> {{ __('Incorrect. The correct answer is highlighted in green.') }}';
            }
        }
    }

    // Show feedback for true/false
    function showPreviewFeedbackTrueFalse(stepIndex, isCorrect, selectedOption) {
        // Get all true/false options for this step
        var allOptions = document.querySelectorAll(`[data-step="${stepIndex}"]`);

        // Mark correct/incorrect
        allOptions.forEach(function(option) {
            var optionCorrect = parseInt(option.getAttribute('data-correct'));
            if (option === selectedOption) {
                if (isCorrect) {
                    option.classList.add('correct');
                } else {
                    option.classList.add('incorrect');
                }
            } else if (optionCorrect === 1) {
                option.classList.add('correct');
                option.style.opacity = '0.7';
            }
        });

        // Show feedback message
        var feedback = document.getElementById(`previewFeedback${stepIndex}`);
        if (feedback) {
            feedback.style.display = 'block';
            if (isCorrect) {
                feedback.className = 'preview-feedback correct';
                feedback.innerHTML = '<i class="fas fa-check-circle"></i> {{ __('Correct! Well done.') }}';
            } else {
                feedback.className = 'preview-feedback incorrect';
                feedback.innerHTML =
                    '<i class="fas fa-times-circle"></i> {{ __('Incorrect. The correct answer is highlighted in green.') }}';
            }
        }
    }

    // Fix step indicator
    function fixStepIndicator(n) {
        var steps = document.getElementsByClassName("step");

        // Remove active class from all steps
        for (var i = 0; i < steps.length; i++) {
            steps[i].className = steps[i].className.replace(" active", "");
        }

        // Add active class to current step
        if (steps[n]) {
            steps[n].className += " active";
        }
    }

    // Handle video elements
    function handleVideoElements() {
        // Pause all videos when navigating
        $('.videoStatement').each(function() {
            this.pause();
        });
    }

    // Finish preview function
    function finishPreview() {
        var correctAnswers = 0;
        var totalQuestions = 0;
        // Count correct answers
        for (var stepIndex in previewAnswers) {
            if (previewAnswers[stepIndex].correct) {
                correctAnswers++;
            }
            totalQuestions++;
        }
        var percentage = totalQuestions > 0 ? Math.round((correctAnswers / totalQuestions) * 100) : 0;

        // Show completion message
        Swal.fire({
            title: '{{ __('Preview Completed!') }}',
            html: `<div style="text-align: center;">
             <i class="fas fa-eye fa-3x text-info mb-3"></i>
             <p>{{ __('You have completed the quiz preview.') }}</p>
             <div class="alert alert-info">
               <strong>{{ __('Preview Results:') }}</strong><br>
               {{ __('Correct answers:') }} ${correctAnswers} / ${totalQuestions}<br>
               {{ __('Percentage:') }} ${percentage}%
             </div>
             <p class="text-muted">{{ __('This was just a preview. Results are not saved.') }}</p>
           </div>`,
            icon: 'info',
            confirmButtonText: '{{ __('Review Answers') }}',
            confirmButtonColor: '#44225c',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText: '{{ __('Close Preview') }}',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.value === true) {
                currentTab = 0;
                showTab(currentTab);
                showAllAnswersReview();
            } else if (result.value === false || result.dismiss) {
                // User clicked "Close Preview" (cancel button) or dismissed
                window.location.href = '{{ route('admin.lms.courses.index') }}';
            }
        });
    }

    // Show all answers in review mode
    function showAllAnswersReview() {
        toastr.info('{{ __('Review mode: All correct answers are now visible.') }}', 'Review Mode', {
            timeOut: 5000,
            closeButton: true,
            progressBar: true
        });

        // Show all correct answers
        for (var stepIndex in previewAnswers) {
            var stepOptions = document.querySelectorAll(`[data-step="${stepIndex}"]`);
            stepOptions.forEach(function(option) {
                var optionCorrect = parseInt(option.getAttribute('data-correct'));
                if (optionCorrect === 1) {
                    option.classList.add('correct');
                }
            });

            // Show feedback for all questions
            var feedback = document.getElementById(`previewFeedback${stepIndex}`);
            if (feedback) {
                feedback.style.display = 'block';
                if (previewAnswers[stepIndex].correct) {
                    feedback.className = 'preview-feedback correct';
                    feedback.innerHTML = '<i class="fas fa-check-circle"></i> {{ __('Your answer was correct!') }}';
                } else {
                    feedback.className = 'preview-feedback incorrect';
                    feedback.innerHTML =
                        '<i class="fas fa-times-circle"></i> {{ __('Your answer was incorrect. Correct answer highlighted in green.') }}';
                }
            }
        }
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
            e.preventDefault();
            nextPrev(-1);
        } else if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
            e.preventDefault();
            nextPrev(1);
        } else if (e.key === 'Escape') {
            e.preventDefault();
            finishPreview();
        }
    });

    // Auto-advance after answer selection (optional)
    function autoAdvance(stepIndex) {
        // Wait 2 seconds then auto-advance to next question
        setTimeout(function() {
            if (currentTab < totalTabs - 1) {
                nextPrev(1);
            }
        }, 2000);
    }

    // Enhanced option selection with auto-advance
    function handlePreviewOptionWithAdvance(stepIndex, optionIndex, isCorrect) {
        handlePreviewOption(stepIndex, optionIndex, isCorrect);
        autoAdvance(stepIndex);
    }

    function handlePreviewTrueFalseWithAdvance(stepIndex, selectedValue, correctAnswer) {
        handlePreviewTrueFalse(stepIndex, selectedValue, correctAnswer);
        autoAdvance(stepIndex);
    }

    // Progress tracking
    function updateProgress() {
        var answeredQuestions = Object.keys(previewAnswers).length;
        var progressPercentage = (answeredQuestions / totalTabs) * 100;

        // Update progress bars
        $('.progress-bar').each(function() {
            $(this).css('width', progressPercentage + '%');
            $(this).attr('aria-valuenow', progressPercentage);
            $(this).text(Math.round(progressPercentage) + '%');
        });
    }

    // Enhanced navigation with progress update
    function nextPrevEnhanced(n) {
        updateProgress();
        return nextPrev(n);
    }

    // Touch/swipe support for mobile
    var touchStartX = 0;
    var touchEndX = 0;

    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        var swipeThreshold = 50;
        var swipeDistance = touchEndX - touchStartX;

        if (Math.abs(swipeDistance) > swipeThreshold) {
            if (swipeDistance > 0) {
                // Swipe right - previous
                nextPrev(-1);
            } else {
                // Swipe left - next
                nextPrev(1);
            }
        }
    }

    // Prevent accidental navigation
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = '{{ __('Are you sure you want to leave the preview?') }}';
    });

    // Initialize tooltips and popovers
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
        $('[data-bs-toggle="popover"]').popover();
    });

    // Accessibility improvements
    function handleKeyboardNavigation(e) {
        var currentOptions = document.querySelectorAll(`[data-step="${currentTab}"]`);
        var focusedElement = document.activeElement;
        var currentIndex = Array.from(currentOptions).indexOf(focusedElement);

        switch (e.key) {
            case 'ArrowUp':
            case 'ArrowLeft':
                e.preventDefault();
                if (currentIndex > 0) {
                    currentOptions[currentIndex - 1].focus();
                }
                break;
            case 'ArrowDown':
            case 'ArrowRight':
                e.preventDefault();
                if (currentIndex < currentOptions.length - 1) {
                    currentOptions[currentIndex + 1].focus();
                }
                break;
            case 'Enter':
            case ' ':
                e.preventDefault();
                if (focusedElement.classList.contains('preview-option')) {
                    focusedElement.click();
                }
                break;
        }
    }

    // Add keyboard navigation to options
    document.addEventListener('keydown', handleKeyboardNavigation);

    // Make options focusable for accessibility
    $(document).ready(function() {
        $('.preview-option').attr('tabindex', '0');
    });
</script>
@endsection
