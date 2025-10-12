@extends('admin/layouts/contentLayoutMaster')

@section('title', __('LMS.Quizes'))

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
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/course_addon.css') }}">

    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/all.css') }}">
    <!-- Google fonts include -->

    <link rel="shortcut icon" href="{{ asset('lms-quizes/assets/images/favicon.svg') }}">
    <!-- Bootstrap-css include -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/bootstrap.min.css') }}">
    <!-- Animate-css include -->
    <link rel="stylesheet" href="{{ asset('lms-quizes/quiz/css/animate.min.css') }}">
    <!-- Main-StyleSheet include -->
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
    </style>

    <style>
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

        /* Override for .btn-light dropdowns */
        .btn-light.dropdown-toggle::after {
            border: none;
        }

        /* Optional: Add a hover effect to change the icon color */



        .schemeItem {
            border: 1px solid rgba(0, 0, 0, .125);
            transition: border-color 0.3s ease;
            /* Add transition for smooth effect */
        }

        .schemeItem:hover {
            border-color: #0d6efd;
            /* Change border color on hover */
        }

        .schemeItemNotSelected {
            background-color: white;
        }

        .schemeItemSelected {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            pointer-events: none;
        }

        .darkBackground {
            background-color: #fff
        }

        .nav-tabs .nav-link-light {
            color: white;
        }

        .nav-tabs .nav-link-dark {
            color: #212529;
        }

        .lightNavBackground {}

        .darkNavBackground {
            background: 0 0;
        }

        h1,
        label {
            color: #44225c !important;
        }

        @media screen and (min-width: 0px) and (max-width: 770px) {
            /*.scenarioQuestions {
                                                                                                                                                                                                overflow-y: scroll !important;
                                                                                                                                                                                                height: 45vh !important;
                                                                                                                                                                                            }*/

            .stepItemMobile {
                overflow-y: scroll !important;
                height: 70vh !important;
            }

            .rounded-pill {
                border-radius: 0rem !important;
            }

            /* show it on large screen */
        }

        .fslightbox-slide-btn-container {
            display: none !important;
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

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>
</div>

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
                                                    {{ number_format(($index * 100) / count($pages), 1) }}</div>
                                            </div>
                                        </div>
                                        <div class="question_title py-3 ">
                                            <h1>{{ getContentWithFallback($page['content'], 'title') }}</h1>
                                        </div>
                                        <label
                                            class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
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
                                                    </video>
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
                                                    <img src="{{ asset('storage/' . $imageUrl) }}" class=""
                                                        style="width: 100%;" controls />
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
                                            <div class="progress align-items-center "
                                                style=" height: 15px; padding: 0; margin: 0;">

                                                <!-- <span><i class="far fa-solid fa-user-shield"></i></span> -->
                                                <div class="progress-bar mx-2 " role="progressbar"
                                                    style="width: {{ ($index * 100) / count($pages) }}%;height: 15px;line-height: 15px; margin: 0;"
                                                    aria-valuenow="{{ ($index * 100) / count($pages) }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ number_format(($index * 100) / count($pages), 1) }}</div>
                                            </div>
                                        </div>


                                    </div>

                                    {{-- question  --}}
                                    {{-- saveAnswerForQuestion --}}
                                    <div class="question_title py-3 text-center">
                                        <input type="hidden" class="question_id_{{ $index }}"
                                            id="question_id_{{ $index }}" name="question_id"
                                            value="{{ $page['content']['id'] }}">
                                        <input type="hidden" class="question_type_{{ $index }}"
                                            id="question_type_{{ $index }}" name="question_type"
                                            value="{{ $page['content']['question_type'] }}">
                                        <h1 class="#44225c">{{ getContentWithFallback($page['content'], 'question') }}
                                        </h1>
                                    </div>

                                    <div class="form_items scenarioQuestions text-center">
                                        {{-- question answer description --}}
                                        {{-- <div id="answerDescription{{ $index }}" class="pt-3"
                                            style="text-align:center">
                                            <h3 style="font-weight:400" id="answer{{ $index }}"></h3>
                                            <h6 class="#44225c"
                                                style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                                {{ getContentWithFallback($page['content'], 'answer_description') }}
                                            </h6>
                                            <a href="#"
                                                onclick='showAnswer({{ $index }});'>{{ __('lms.View Options Again') }}</a>
                                        </div> --}}

                                        {{-- question options  --}}

                                        <div id="answerQuestions{{ $index }}">
                                            @if ($page['content']['question_type'] == 'multi_choise')
                                                @foreach ($page['options'] as $optIndex => $option)
                                                    @php
                                                        $isSelected =
                                                            isset($page['user_answer']) &&
                                                            $page['user_answer'] &&
                                                            $page['user_answer']->option_id == $option['id'];
                                                        $isDisabled =
                                                            isset($page['user_answer']) && $page['user_answer'];
                                                    @endphp

                                                    <label for="opt_{{ $index }}_{{ $optIndex }}"
                                                        class="step_{{ $index }} animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground
            {{ $isSelected ? 'active' : '' }} {{ $isDisabled ? 'disabled' : '' }}"
                                                        data-toggle="modal" data-target="#answerModal"
                                                        data-whatever="mdo"
                                                        style="{{ $isDisabled ? 'pointer-events: none; opacity: 0.7;' : '' }}">

                                                        {{ getContentWithFallback($option, 'option_text') }}
                                                        <i class="step_{{ $index }}_selected fa fa-user-lock"
                                                            style="{{ $isSelected ? 'display: inline;' : 'display: none;' }}"></i>

                                                        <input id="opt_{{ $index }}_{{ $optIndex }}"
                                                            type="radio"
                                                            name="stp_{{ $index }}_select_option"
                                                            value="{{ $option['id'] }}"
                                                            class="option_id_{{ $index }}"
                                                            {{ $isSelected ? 'checked' : '' }}
                                                            {{ $isDisabled ? 'disabled' : '' }}
                                                            onclick="validateAnswer({{ $option['is_correct'] }}, {{ $index }});">
                                                    </label>
                                                @endforeach

                                                {{-- True/False Questions --}}
                                            @else
                                                @php
                                                    $userAnswer = isset($page['user_answer'])
                                                        ? $page['user_answer']
                                                        : null;
                                                    $isDisabled = $userAnswer !== null;
                                                    $isTrueSelected = $userAnswer && $userAnswer->true_or_false == 1;
                                                    $isFalseSelected = $userAnswer && $userAnswer->true_or_false == 0;
                                                @endphp

                                                {{-- True Option --}}
                                                <label for="opt_true_{{ $index }}"
                                                    class="step_{{ $index }} animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground
        {{ $isTrueSelected ? 'active' : '' }} {{ $isDisabled ? 'disabled' : '' }}"
                                                    data-toggle="modal" data-target="#answerModal"
                                                    data-whatever="mdo"
                                                    style="{{ $isDisabled ? 'pointer-events: none; opacity: 0.7;' : '' }}">

                                                    {{ __('lms.True') }}
                                                    <i class="step_{{ $index }}_selected fa fa-user-lock"
                                                        style="{{ $isTrueSelected ? 'display: inline;' : 'display: none;' }}"></i>

                                                    <input id="opt_true_{{ $index }}" type="radio"
                                                        name="stp_{{ $index }}_select_option" value="true"
                                                        class="true_or_false_option_id_{{ $index }}"
                                                        {{ $isTrueSelected ? 'checked' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                </label>

                                                {{-- False Option --}}
                                                <label for="opt_false_{{ $index }}"
                                                    class="step_{{ $index }} animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground
        {{ $isFalseSelected ? 'active' : '' }} {{ $isDisabled ? 'disabled' : '' }}"
                                                    data-toggle="modal" data-target="#answerModal"
                                                    data-whatever="mdo"
                                                    style="{{ $isDisabled ? 'pointer-events: none; opacity: 0.7;' : '' }}">

                                                    {{ __('lms.False') }}
                                                    <i class="step_{{ $index }}_selected fa fa-user-lock"
                                                        style="{{ $isFalseSelected ? 'display: inline;' : 'display: none;' }}"></i>

                                                    <input id="opt_false_{{ $index }}" type="radio"
                                                        name="stp_{{ $index }}_select_option" value="false"
                                                        class="true_or_false_option_id_{{ $index }}"
                                                        {{ $isFalseSelected ? 'checked' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
            @endif
            @endforeach

            <!------------------------- Form button ----------------------------->
            <div class="form_btn">
                <button type="button"
                    class="f_btn rounded-pill prev_btn text-uppercase #44225c position-absolute text-white"
                    id="prevBtn" onclick="nextPrev(-1)"> {{ __('lms.Back') }}</button>
                <button type="button"
                    class="f_btn rounded-pill next_btn text-uppercase #44225c position-absolute text-white"
                    id="nextBtn" onclick="nextPrev(1)">
                    {{ __('lms.Next') }} <i class="fa-user-shield"></i>
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


{{-- <script>
    for (let index = 1; index <= 100; index++) {
        $(`#answerDescription${index}`).hide();
        $(`.step_${index}_selected`).hide();
    }
</script> --}}

<script>
    // Initialize quiz with previous answers
    $(document).ready(function() {
        initializePreviousAnswers();

        // Add event listeners to all radio buttons
        $('input[type="radio"]').on('change', function() {
            const stepMatch = $(this).attr('name').match(/stp_(\d+)_select_option/);
            if (stepMatch) {
                const stepIndex = parseInt(stepMatch[1]);
                answeredSteps[stepIndex] = true;
                updateButtonStates();
            }
        });

        // Initial button state check
        setTimeout(function() {
            updateButtonStates();
        }, 100);
    });

    function initializePreviousAnswers() {
        // Loop through all pages to set previous answers
        @foreach ($pages as $index => $page)
            @if ($page['type'] == 'question' && isset($page['user_answer']) && $page['user_answer'])
                answeredSteps[{{ $index }}] = true;
                @if ($page['content']['question_type'] == 'multi_choise')
                    @if ($page['user_answer']->option_id)
                        $('#opt_{{ $index }}_{{ collect($page['options'])->search(function ($option) use ($page) {return $option['id'] == $page['user_answer']->option_id;}) }}')
                            .prop('checked', true);
                        $('.step_{{ $index }}').addClass('disabled');
                        $('.step_{{ $index }} input').prop('disabled', true);
                        $('.step_{{ $index }}').css('pointer-events', 'none');
                        $('.step_{{ $index }}').css('opacity', '0.7');
                    @endif
                @else
                    @if ($page['user_answer']->true_or_false !== null)
                        @if ($page['user_answer']->true_or_false == 1)
                            $('#opt_true_{{ $index }}').prop('checked', true);
                        @else
                            $('#opt_false_{{ $index }}').prop('checked', true);
                        @endif
                        $('.step_{{ $index }}').addClass('disabled');
                        $('.step_{{ $index }} input').prop('disabled', true);
                        $('.step_{{ $index }}').css('pointer-events', 'none');
                        $('.step_{{ $index }}').css('opacity', '0.7');
                    @endif
                @endif
            @endif
        @endforeach
    }

    var qCount = 7;
    var qCorrect = 0;
    var qIncorrect = 0;

    // Initialize tracking array
    var answeredSteps = new Array(100).fill(false);

    $(function() {
        // Mark previously answered questions
        @foreach ($pages as $index => $page)
            @if ($page['type'] == 'question' && isset($page['user_answer']) && $page['user_answer'])
                answeredSteps[{{ $index }}] = true;
            @endif
            @if ($page['type'] == 'statement')
                answeredSteps[{{ $index }}] = true;
            @endif
        @endforeach

        // Add click event listener to all radio buttons
        for (let index = 0; index <= 100; index++) {
            $(`.step_${index}`).on('click', function() {
                if (!answeredSteps[index]) {
                    $(`.step_${index}`).removeClass("active");
                    $(this).addClass("active");
                }
            });
        }
    });

    // Start from where user left off
    var currentTab = {{ $lastAnsweredIndex ?? 0 }};
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("multisteps_form_panel");

        console.log('showTab called with n =', n, 'Total panels:', x.length);

        // Hide all tabs first
        for (let i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        // Make sure n is within bounds
        if (n >= x.length) {
            console.error('Tab index out of bounds:', n);
            return;
        }

        if (n < x.length && n >= 0) {
            x[n].style.display = "block";
        }

        // Handle navigation buttons
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        // Check if this is the last page
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
            console.log('Last page - showing Submit button');
        } else {
            document.getElementById("nextBtn").innerHTML = "{{ __('lms.Next') }}";
        }

        document.getElementById("prevBtn").innerHTML = "{{ __('lms.Back') }}";

        // Update button states immediately after showing tab
        setTimeout(function() {
            updateButtonStates();
        }, 50);

        fixStepIndicator(n);
    }

    // Function to update button states
    function updateButtonStates() {
        const nextBtn = document.getElementById("nextBtn");
        const prevBtn = document.getElementById("prevBtn");

        if (!nextBtn) return;

        // Check if current page is a question page
        const pageTypeInput = document.getElementById(`pageType_${currentTab +1}`);
        const pageType = pageTypeInput ? pageTypeInput.value : null;

        if (pageType === 'statement') {
            console.log('SSSSSSSSSSSSSSSSSStatement')

            // For statement pages, enable next button
            nextBtn.disabled = false;
            nextBtn.style.opacity = "1";
            nextBtn.style.cursor = "pointer";
            nextBtn.style.pointerEvents = "auto";
        } else if (pageType === 'question') {
            // For question pages, check if answered
            const isAnswered = checkIfCurrentPageAnswered();

            if (isAnswered) {
                console.log('answereeeeeeeeeeeeeeeeeeeeeed')
                nextBtn.disabled = false;
                nextBtn.style.opacity = "1";
                nextBtn.style.cursor = "pointer";
                nextBtn.style.pointerEvents = "auto";
            } else {
                console.log('Notttttttttttttttttttttttttttttttt')
                nextBtn.disabled = true;
                nextBtn.style.opacity = "0.5";
                nextBtn.style.cursor = "not-allowed";
                nextBtn.style.pointerEvents = "none";
            }
        }
    }

    // Check if current page has been answered
    function checkIfCurrentPageAnswered() {
        // Check if answer already exists in database or array
        if (answeredSteps[currentTab + 1]) {
            return true;
        }

        // Check if radio button is selected for current page
        const multiChoiceChecked = $(`.option_id_${currentTab + 1}:checked`).length > 0;
        const trueOrFalseChecked = $(`.true_or_false_option_id_${currentTab + 1}:checked`).length > 0;

        return multiChoiceChecked || trueOrFalseChecked;
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("multisteps_form_panel");
        // For moving forward, validate the form
        if (n > 0) {
            if (!validateForm()) {
                // Show alert if trying to proceed without answer
                const pageTypeInput = document.getElementById(`pageType_${currentTab}`);
                if (pageTypeInput && pageTypeInput.value === 'question') {
                    toastr.warning('{{ __('lms.Please select an answer before proceeding') }}',
                        '{{ __('lms.Warning') }}');
                }
                console.log('Validation failed - stopping');
                return false;
            }

            // Check if we're on the LAST page (before moving forward)
            if (currentTab + 1 === (x.length)) {
                console.log('*** AT LAST PAGE - SUBMITTING ***');
                // Save the last answer and submit
                if ($(`#pageType_${currentTab + 1}`).val() == 'question') {
                    saveAnswerForQuestion(currentTab + 1, true);
                } else {
                    submitLearning(currentTab + 1);
                }
                return false;
            } else {
                console.log('Not last page - continuing normally');
            }
        }

        // Save answer if it's a question page and moving forward (not last page)
        if (n > 0 && $(`#pageType_${currentTab + 1}`).val() == 'question') {
            console.log('Saving answer for question at index:', currentTab + 1);
            saveAnswerForQuestion(currentTab + 1, false);
        }

        // Hide current tab
        x[currentTab].style.display = "none";

        // Update current tab
        currentTab = currentTab + n;

        console.log('New Current Tab:', currentTab);
        console.log('=== nextPrev END ===\n');

        // Show the correct tab
        showTab(currentTab);

        return true;
    }

    function saveAnswerForQuestion(pageIndex, finish) {
        $.ajax({
            url: "{{ route('user.lms.training.modules.storeAnswer') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'training_module_id': "{{ $id }}",
                'finish_training': finish,
                'pageType': $(`#pageType_${pageIndex}`).val(),
                'question_type': $(`#question_type_${pageIndex}`).val(),
                'question_id': $(`#question_id_${pageIndex}`).val(),
                'option_id': $(`.option_id_${pageIndex}:checked`).val(),
                'true_or_false': $(`.true_or_false_option_id_${pageIndex}:checked`).val(),
            },
            success: function(data) {
                if (data.completeTrain) {
                    window.location.href = data.redirect;
                }
            },
            error: function(response, data) {
                console.error('Error saving answer:', response);
                alert('There is a Problem saving your answer');
            }
        });
    }

    function submitLearning(lastTab) {
        $('#nextBtn').html('<i class="fa fa-spinner fa-spin"></i>');
        $('#nextBtn').prop('disabled', true);
        saveAnswerForQuestion(lastTab - 1, true);
    }

    function validateAnswer(answer, stepNumber) {
        answeredSteps[stepNumber] = true;
        updateButtonStates();
    }

    function validateTrueOrFalseAnswer(trueOrFalse, answer, stepNumber) {
        answeredSteps[stepNumber] = true;
        updateButtonStates();
    }

    function validateForm() {
        var x = document.getElementsByClassName("multisteps_form_panel");
        var y = x[currentTab].getElementsByTagName("input");
        var valid = true;

        // Check if this is a statement page (no validation needed)
        const pageTypeInput = document.getElementById(`pageType_${currentTab}`);
        if (pageTypeInput && pageTypeInput.value === 'statement') {
            return true;
        }

        // Check if all inputs are already disabled (previous answer exists)
        let allDisabled = true;
        for (let i = 0; i < y.length; i++) {
            if (y[i].type === 'radio' && !y[i].disabled) {
                allDisabled = false;
                break;
            }
        }

        if (allDisabled) {
            return true;
        }

        // Check if any radio button is selected
        valid = false;
        for (let i = 0; i < y.length; i++) {
            if (y[i].type === 'radio' && y[i].checked) {
                valid = true;
                break;
            }
        }

        // If valid answer selected, disable all options for this question
        if (valid) {
            for (let i = 0; i < y.length; i++) {
                if (y[i].type === 'radio') {
                    y[i].disabled = true;
                    $(y[i]).parent().addClass('disabled');
                    $(y[i]).parent().css('pointer-events', 'none');
                    $(y[i]).parent().css('opacity', '0.7');
                }
            }
            answeredSteps[currentTab] = true;
        }

        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        if (x[n]) {
            x[n].className += " active";
        }
    }

    function showAnswer(qStep) {
        $("#answerDescription" + qStep).hide();
        $("#answerQuestions" + qStep).show();
    }
</script>

@endsection
