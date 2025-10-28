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

        // Helper function for media files
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

        //     // Check if primary field exists and file exists
        //     if (isset($content[$primaryField]) && !empty($content[$primaryField])) {
        //         return $content[$primaryField];
        //     }

        //     // Return fallback if primary doesn't exist
//     if (isset($content[$fallbackField]) && !empty($content[$fallbackField])) {
//         return $content[$fallbackField];
//     }

//     // Return null if both don't exist
        //     return null;
        // }

        function getMediaWithFallback($content, $field)
        {
            $currentLocale = app()->getLocale();

            if ($currentLocale === 'ar') {
                $primaryField = $field . '_ar';
                $fallbackField = $field;
            } else {
                $primaryField = $field;
                $fallbackField = $field . '_ar';
            }

            $checkFileExists = function ($fieldName) use ($content) {
                return isset($content[$fieldName]) &&
                    !empty($content[$fieldName]) &&
                    file_exists(storage_path('app/public/' . $content[$fieldName]));
            };

            if ($checkFileExists($primaryField)) {
                return $content[$primaryField];
            }

            if ($checkFileExists($fallbackField)) {
                return $content[$fallbackField];
            }

            $alternativeFields = [];

            if ($field === 'video_or_image_url') {
                $alternativeFields = ['video_or_image_url_en', 'image', 'image_ar'];
            } elseif ($field === 'image') {
                $alternativeFields = [
                    'image_ar',
                    'video_or_image_url',
                    'video_or_image_url_ar',
                    'video_or_image_url_en',
                ];
            }

            foreach ($alternativeFields as $altField) {
                if ($checkFileExists($altField)) {
                    return $content[$altField];
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
                                {{-- @if (auth()->user()->hasPermission('asset.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add_course_modal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                    <a href="{{ route('admin.phishing.archivedDomains') }}" class=" btn btn-primary"
                                        target="_self">
                                        <i class="fa  fa-trash"></i>
                                    </a>
                                @endif
                                <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                    exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' />

                                <a class="btn btn-primary" href="http://"> <i
                                        class="fa-solid fa-file-invoice"></i></a> --}}
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
                                        <div id="answerDescription{{ $index }}" class="pt-3"
                                            style="text-align:center">
                                            <h3 style="font-weight:400" id="answer{{ $index }}"></h3>
                                            <h6 class="#44225c"
                                                style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                                {{ getContentWithFallback($page['content'], 'answer_description') }}
                                            </h6>
                                            <a href="#"
                                                onclick='showAnswer({{ $index }});'>{{ __('lms.View Options Again') }}</a>
                                        </div>

                                        {{-- question options  --}}

                                        <div id="answerQuestions{{ $index }}">
                                            @if ($page['content']['question_type'] == 'multi_choise')
                                                @foreach ($page['options'] as $optIndex => $option)
                                                    <label for="opt_{{ $index }}_{{ $optIndex }}"
                                                        class="step_{{ $index }} animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                                        data-toggle="modal" data-target="#answerModal"
                                                        data-whatever="mdo">
                                                        {{ getContentWithFallback($option, 'option_text') }}
                                                        <i
                                                            class="step_{{ $index }}_selected fa fa-user-lock"></i>
                                                        <input id="opt_{{ $index }}_{{ $optIndex }}"
                                                            type="radio"
                                                            name="stp_{{ $index }}_select_option"
                                                            value="{{ $option['id'] }}"
                                                            class="option_id_{{ $index }}"
                                                            onclick="validateAnswer({{ $option['is_correct'] }}, {{ $index }});">
                                                    </label>
                                                @endforeach
                                            @else
                                                <label for="opt_true_{{ $index }}"
                                                    class="step_{{ $index }} animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                                    data-toggle="modal" data-target="#answerModal"
                                                    data-whatever="mdo">
                                                    {{ __('lms.True') }}
                                                    <i class="step_{{ $index }}_selected fa fa-user-lock"></i>
                                                    <input id="opt_true_{{ $index }}" type="radio"
                                                        name="stp_{{ $index }}_select_option" value="true"
                                                        class="true_or_false_option_id_{{ $index }}"
                                                        onclick="validateTrueOrFalseAnswer(true, {{ $page['content']['correct_answer'] }}, {{ $index }});">
                                                </label>

                                                <label for="opt_false_{{ $index }}"
                                                    class="step_{{ $index }} animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                                    data-toggle="modal" data-target="#answerModal"
                                                    data-whatever="mdo">
                                                    {{ __('lms.False') }}
                                                    <i class="step_{{ $index }}_selected fa fa-user-lock"></i>
                                                    <input id="opt_false_{{ $index }}" type="radio"
                                                        name="stp_{{ $index }}_select_option" value="false"
                                                        class="true_or_false_option_id_{{ $index }}"
                                                        onclick="validateTrueOrFalseAnswer(false, {{ $page['content']['correct_answer'] }}, {{ $index }});">
                                                </label>
                                            @endif


                                            {{-- if true or false --}}
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
    fsLightbox.props.type = "image";

    function beginTour() {
        introJs().setOptions({
            showProgress: true,
            steps: [{
                    element: document.querySelector('#emailTitle'),
                    title: 'Email Subject: Urgent Action',
                    intro: 'Phishing attacks are designed to put a <b>time pressure on us to act fast</b>. This can cause us to skip much of the critical thinking we normally apply when browsing our emails.',
                    position: 'bottom'
                },
                {
                    element: document.querySelector('#phishSender'),
                    title: 'Email Sender: Fraudulent Address',
                    intro: 'Attackers will often use <b>obscure email addresses and use display names</b> that appear legitimate to the naked eye. Be cautious and carefully inspect email sender information.',
                    position: 'bottom'
                },
                {
                    title: 'Email Content: Engaging Topic',
                    element: document.querySelector('#emailBody'),
                    intro: 'Attackers often use a <b>broad but important topic</b> to increase the likelihood of a victim interacting with the phishing material. These topics may include geographic, political or financial themes.',
                    position: 'bottom'
                },
                {
                    title: 'Email Link: Phishing Website',
                    element: document.querySelector('#emailLink'),
                    intro: 'Malicious links will often appear with innocent looking text. By <b>hovering over the link</b> you&#x27;ll see the true link location. Often this is enough to see the malicious intent.',
                    position: 'bottom'
                },
                {
                    element: document.querySelector('#emailWrapper'),
                    title: 'Wrapping up',
                    intro: 'If you <b>spot anything suspicious</b> with the email sender, subject, content, links or attachments... Don&#x27;t take the risk. Report the email to your IT or Security team for review.',
                    position: 'bottom'
                }
            ]
        }).start()
    }
</script> --}}

<script>
    for (let index = 1; index <= 100; index++) {
        $(`#answerDescription${index}`).hide();
        $(`.step_${index}_selected`).hide();
    }

    // $("#answerDescription1").hide();
    // $(".step_1_selected").hide();

    // $("#answerDescription2").hide();
    // $(".step_2_selected").hide();

    // $("#answerDescription3").hide();
    // $(".step_3_selected").hide();

    // $("#answerDescription4").hide();
    // $(".step_4_selected").hide();

    // $("#answerDescription5").hide();
    // $(".step_5_selected").hide();

    // $("#answerDescription6").hide();
    // $(".step_6_selected").hide();

    // $("#answerDescription7").hide();
    // $(".step_7_selected").hide();

    // $("#answerDescription8").hide();
    // $(".step_8_selected").hide();

    // $("#answerDescription9").hide();
    // $(".step_9_selected").hide();

    // $("#answerDescription10").hide();
    // $(".step_10_selected").hide();

    // $("#answerDescription11").hide();
    // $(".step_11_selected").hide();

    // $("#answerDescription12").hide();
    // $(".step_12_selected").hide();

    // $("#answerDescription13").hide();
    // $(".step_13_selected").hide();

    // $("#answerDescription14").hide();
    // $(".step_14_selected").hide();
</script>

<script>
    var qCount = 7;
    var qCorrect = 0;
    var qIncorrect = 0;

    /************************** Refactor Code .............***********************/
    $(function() {
        // Initialize an array with 100 elements, only the last one set to false
        var steps = new Array(100);
        steps[99] = false; // Set only the last element to false
        for (let index = 1; index <= 100; index++) {
            $(`.step_${index}`).on('click', function() {
                if (!steps[index - 1]) { // Check if the step is either undefined or explicitly false
                    $(`.step_${index}`).removeClass("active");
                    $(this).addClass("active");
                    $(`#answerDescription${index}`).show();
                    $(`#answerQuestions${index}`).hide();
                    $(`.step_${index}_selected`).show();
                    steps[index - 1] = true; // Set the step as "activated" in the array
                }
            });
        }
    });

    /**************** Correct Code ................*****************/
    // $(function() {
    //     // ========== Form-select-option ========== //
    //     var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13, s14, s15, s16, s17, s18, s19, s20, s21, s22,
    //         s23, s24, s25, s26, s27, s28, s29, s30, s31, s32, s33, s34, s35, s36, s37, s38, s39, s40, s41, s42,
    //         s43, s44, s45, s46, s47, s48, s49, s50, s51, s52, s53, s54, s55, s56, s57, s58, s59, s60, s61, s62,
    //         s63, s64, s65, s66, s67, s68, s69, s70, s71, s72, s73, s74, s75, s76, s77, s78, s79, s80, s81, s82,
    //         s83, s84, s85, s86, s87, s88, s89, s90, s91, s92, s93, s94, s95, s96, s97, s98, s99, s100 = false;

    //     $(".step_1").on('click', function() {
    //         if (!s1) {
    //             $(".step_1").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription1").show();
    //             $("#answerQuestions1").hide();
    //             $(".step_1_selected").show();
    //             s1 = true;
    //         }
    //     });

    //     $(".step_2").on('click', function() {
    //         if (!s2) {
    //             $(".step_2").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription2").show();
    //             $("#answerQuestions2").hide();
    //             $(".step_2_selected").show();
    //             s2 = true;
    //         }
    //     });

    //     $(".step_3").on('click', function() {
    //         if (!s3) {
    //             $(".step_3").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription3").show();
    //             $("#answerQuestions3").hide();
    //             $(".step_3_selected").show();
    //             s3 = true;
    //         }
    //     });

    //     $(".step_4").on('click', function() {
    //         if (!s4) {
    //             $(".step_4").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription4").show();
    //             $("#answerQuestions4").hide();
    //             $(".step_4_selected").show();
    //             s4 = true;
    //         }
    //     });

    //     $(".step_5").on('click', function() {
    //         if (!s5) {
    //             $(".step_5").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription5").show();
    //             $("#answerQuestions5").hide();
    //             $(".step_5_selected").show();
    //             s5 = true;
    //         }
    //     });

    //     $(".step_6").on('click', function() {
    //         if (!s6) {
    //             $(".step_6").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription6").show();
    //             $("#answerQuestions6").hide();
    //             $(".step_6_selected").show();
    //             s6 = true;
    //         }
    //     });

    //     $(".step_7").on('click', function() {
    //         if (!s7) {
    //             $(".step_7").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription7").show();
    //             $("#answerQuestions7").hide();
    //             $(".step_7_selected").show();
    //             s7 = true;
    //         }
    //     });

    //     $(".step_8").on('click', function() {
    //         if (!s8) {
    //             $(".step_8").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription8").show();
    //             $("#answerQuestions8").hide();
    //             $(".step_8_selected").show();
    //             s8 = true;
    //         }
    //     });

    //     $(".step_9").on('click', function() {
    //         if (!s9) {
    //             $(".step_9").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription9").show();
    //             $("#answerQuestions9").hide();
    //             $(".step_9_selected").show();
    //             s9 = true;
    //         }
    //     });

    //     $(".step_10").on('click', function() {
    //         if (!s10) {
    //             $(".step_10").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription10").show();
    //             $("#answerQuestions10").hide();
    //             $(".step_10_selected").show();
    //             s10 = true;
    //         }
    //     });

    //     $(".step_11").on('click', function() {
    //         if (!s11) {
    //             $(".step_11").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription11").show();
    //             $("#answerQuestions11").hide();
    //             $(".step_11_selected").show();
    //             s11 = true;
    //         }
    //     });

    //     $(".step_12").on('click', function() {
    //         if (!s12) {
    //             $(".step_12").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription12").show();
    //             $("#answerQuestions12").hide();
    //             $(".step_12_selected").show();
    //             s12 = true;
    //         }
    //     });

    //     $(".step_13").on('click', function() {
    //         if (!s13) {
    //             $(".step_13").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription13").show();
    //             $("#answerQuestions13").hide();
    //             $(".step_13_selected").show();
    //             s13 = true;
    //         }
    //     });

    //     $(".step_14").on('click', function() {
    //         if (!s14) {
    //             $(".step_14").removeClass("active");
    //             $(this).addClass("active");
    //             $("#answerDescription14").show();
    //             $("#answerQuestions14").hide();
    //             $(".step_14_selected").show();
    //             s14 = true;
    //         }
    //     });
    // });

    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("multisteps_form_panel");

        console.log('x.length' + x.length)
        console.log('n.length' + n)

        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "{{ __('lms.Next') }}";
        }
        document.getElementById("prevBtn").innerHTML = "{{ __('lms.Back') }}";
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("multisteps_form_panel");
        // Exit the function if any field in the current tab is invalid:
        if (!validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= x.length) {
            //...the form gets submitted:
            submitLearning(currentTab - 1);
            // document.getElementById("wizard").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
        validateForm();

        if ($(`#pageType_${currentTab}`).val() == 'question') {
            saveAnswerForQuestion(currentTab - 1, false);
        } else {
            console.log('it is not a question');
        }
        return true;
    }

    function saveAnswerForQuestion(value, finish) {
        $.ajax({
            url: "{{ route('user.lms.training.modules.storeAnswer') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'training_module_id': "{{ $id }}",
                'finsih_training': finish,
                'pageType': $(`#pageType_${value+1}`).val(),
                'question_type': $(`#question_type_${value+1}`).val(),
                'question_id': $(`#question_id_${value+1}`).val(),
                'option_id': $(`.option_id_${value+1}:checked`).val(),
                'true_or_false': $(`.true_or_false_option_id_${value+1}:checked`).val(),
            },
            success: function(data) {
                if (data.completeTrain) {
                    window.location.href = data.redirect;
                }

            },
            error: function(response, data) {
                alert('There is a Problem');
            }
        });
    }

    function submitLearning(lastTab) {
        $('#nextBtn').html('<i class="fa fa-spinner fa-spin"></i>');
        $('#nextBtn').prop('disabled', true);
        saveAnswerForQuestion(lastTab, true)

        // var completedRedirect = "/Complete/Training" + document.location.search + "&q=" + btoa(qCount) + "&c=" + btoa(
        //     qCorrect);
        // window.location.href = completedRedirect;
    }

    function validateAnswer(answer, stepNumber) {
        validateForm();
        console.log(answer);
        if (answer == 1) {
            qCorrect++;
            //$("#answer" + stepNumber).text("Correct!");
            document.getElementById("answer" + stepNumber).innerHTML = "Correct!";
            $("#answer" + stepNumber).removeClass("text-danger");
            $("#answer" + stepNumber).addClass("text-success");
        } else {
            qIncorrect++;
            //$("#answer" + stepNumber).text("Incorrect");
            document.getElementById("answer" + stepNumber).innerHTML = "Incorrect";
            $("#answer" + stepNumber).addClass("text-danger");
            $("#answer" + stepNumber).removeClass("text-success");
        }
    }


    function validateTrueOrFalseAnswer(trueOrFalse, answer, stepNumber) {
        validateForm();
        console.log('your Answer ' + trueOrFalse);
        console.log('question answer ' + answer);

        if (answer == trueOrFalse) {
            qCorrect++;
            //$("#answer" + stepNumber).text("Correct!");
            document.getElementById("answer" + stepNumber).innerHTML = "Correct!";
            $("#answer" + stepNumber).removeClass("text-danger");
            $("#answer" + stepNumber).addClass("text-success");
        } else {
            qIncorrect++;
            //$("#answer" + stepNumber).text("Incorrect");
            document.getElementById("answer" + stepNumber).innerHTML = "Incorrect";
            $("#answer" + stepNumber).addClass("text-danger");
            $("#answer" + stepNumber).removeClass("text-success");
        }
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("multisteps_form_panel");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        if (y.length > 0) {
            valid = false;
        }
        for (i = 0; i < y.length; i++) {
            if (y[i].checked) {
                valid = true;
            }
        }
        if (!valid) {
            document.getElementById("nextBtn").innerHTML = "<i class='fa-solid fa-lock'></i>";
            document.getElementById("prevBtn").innerHTML = "<i class='fa-solid fa-lock'></i>";
        } else {
            for (i = 0; i < y.length; i++) {
                y[i].setAttribute('onclick', 'javascript: return false;');
                y[i].disabled = true;
            }
            var x = document.getElementsByClassName("multisteps_form_panel");
            if (currentTab == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "{{ __('lms.Submit') }}";
                document.getElementById("prevBtn").innerHTML = "{{ __('lms.Back') }}";
            } else {
                document.getElementById("nextBtn").innerHTML = "{{ __('lms.Next') }}";
                document.getElementById("prevBtn").innerHTML = "{{ __('lms.Back') }}";
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }


        if ($(`#pageType_${currentTab}`).val() == 'statement') {
            if ($('.videoStatement').length > 0) {
                $('.videoStatement').each(function() {
                    $(this).get(0).pause();
                });
            }
        }

        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }

    function move() {
        var elem = document.getElementById("myBar");
        var width = parseInt(elem.innerHTML);
        var aim = width + 25;
        var id = setInterval(frame, 25);

        function frame() {
            if (width >= aim) {
                clearInterval(id);
            } else if (width >= 100) {
                width = 0;
                aim = 25;
                elem.style.width = width + '%';
                elem.innerHTML = width * 1 + '%';
            } else {
                width++;
                elem.style.width = width + '%';
                elem.innerHTML = width * 1 + '%';
            }
        }
    }

    function showAnswer(qStep) {
        $("#answerDescription" + qStep).hide();
        $("#answerQuestions" + qStep).show();
    }
</script>

@endsection
