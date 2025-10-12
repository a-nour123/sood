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
                                        class="fa-solid fa-file-invoice"></i></a>
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
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 3%;" aria-valuenow="3" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1>What is ransomware?</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    Ransomware is like a digital kidnapper, holding your computer hostage until you pay
                                    up! It&#x27;s software that encrypts all your data and demands a ransom from you to
                                    decrypt it.
                                </label>
                                <div class="pt-2 animate__animated animate__fadeInRight animate_25ms">

                                    <video class="videoStatement" style="width: 100%;" controls>
                                        <source src="https://d3p8e1mvy30w84.cloudfront.net/videos/ransomware.mp4"
                                            type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 10%;" aria-valuenow="10" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">What is ransomware?</h1>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription2" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer2"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            Ransomware is a type of malicious software that is designed to block access
                                            to data until a sum of money is paid. Ransomware attacks typically involve
                                            the attacker encrypting the victim&#x27;s data and demanding a ransom from
                                            the victim to restore access.
                                        </h6>
                                        <a href="#" onclick='showAnswer(2);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions2">
                                        <label for="opt_2_1"
                                            class="step_2 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            A type of software that helps to recover lost data <i
                                                class="step_2_selected fa fa-user-lock"></i>
                                            <input id="opt_2_1" type="radio" name="stp_2_select_option"
                                                onclick="validateAnswer('False', '2');">
                                        </label>
                                        <label for="opt_2_2"
                                            class="step_2 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            A type of software that encrypts data and holds the encryption key at ransom
                                            <i class="step_2_selected fa fa-user-lock"></i>
                                            <input id="opt_2_2" type="radio" name="stp_2_select_option"
                                                onclick="validateAnswer('True', '2');">
                                        </label>
                                        <label for="opt_2_3"
                                            class="step_2 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            A type of software that helps to improve computer performance <i
                                                class="step_2_selected fa fa-user-lock"></i>
                                            <input id="opt_2_3" type="radio" name="stp_2_select_option"
                                                onclick="validateAnswer('False', '2');">
                                        </label>
                                        <label for="opt_2_4"
                                            class="step_2 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            A type of antivirus software <i
                                                class="step_2_selected fa fa-user-lock"></i>
                                            <input id="opt_2_4" type="radio" name="stp_2_select_option"
                                                onclick="validateAnswer('False', '2');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 17%;" aria-valuenow="17" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Why should we care about ransomware?</h1>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription3" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer3"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            It&#x27;s important to protect against ransomware attacks because they can
                                            result in data loss, significant disruptions and costs for individuals and
                                            organisations. Ransomware attacks involve the attacker encrypting the
                                            victim&#x27;s data and demanding a ransom to restore access.
                                        </h6>
                                        <a href="#" onclick='showAnswer(3);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions3">
                                        <label for="opt_3_1"
                                            class="step_3 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            All options are correct. <i class="step_3_selected fa fa-user-lock"></i>
                                            <input id="opt_3_1" type="radio" name="stp_3_select_option"
                                                onclick="validateAnswer('True', '3');">
                                        </label>
                                        <label for="opt_3_2"
                                            class="step_3 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Ransomware can cause data loss of access to important data <i
                                                class="step_3_selected fa fa-user-lock"></i>
                                            <input id="opt_3_2" type="radio" name="stp_3_select_option"
                                                onclick="validateAnswer('False', '3');">
                                        </label>
                                        <label for="opt_3_3"
                                            class="step_3 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Ransomware can result in a disruption to day-to-day operations <i
                                                class="step_3_selected fa fa-user-lock"></i>
                                            <input id="opt_3_3" type="radio" name="stp_3_select_option"
                                                onclick="validateAnswer('False', '3');">
                                        </label>
                                        <label for="opt_3_4"
                                            class="step_3 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Ransomware can result in financial and reputational damage to an
                                            organization <i class="step_3_selected fa fa-user-lock"></i>
                                            <input id="opt_3_4" type="radio" name="stp_3_select_option"
                                                onclick="validateAnswer('False', '3');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 24%;" aria-valuenow="24" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Curious how cyber criminals spread ransomware?</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    Cyber criminals often use a combination of social engineering (i.e. manipulation)
                                    and exploitation of computer system vulnerabilities to deliver ransomware.
                                </label>
                                <div class="pt-4 animate__animated animate__fadeInRight animate_25ms">
                                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-link-light active" id="statement-tab4_1"
                                                data-bs-toggle="tab" data-bs-target="#tab4_1" type="button"
                                                role="tab" aria-controls="tab4_1" aria-selected="true">Email
                                                attachments</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-link-light " id="statement-tab4_2"
                                                data-bs-toggle="tab" data-bs-target="#tab4_2" type="button"
                                                role="tab" aria-controls="tab4_2" aria-selected="false">Malicious
                                                websites</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-link-light " id="statement-tab4_3"
                                                data-bs-toggle="tab" data-bs-target="#tab4_3" type="button"
                                                role="tab" aria-controls="tab4_3" aria-selected="false">Exploit
                                                kits</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tab4_1" role="tabpanel"
                                            aria-labelledby="statement-tab4_1">
                                            <label
                                                class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                                style="font-family:system-ui !important;">
                                                <span> Cyber criminals may spread ransomware through email attachments.
                                                    They may send emails that contain malicious attachments, which, when
                                                    downloaded and opened, will install the ransomware on the
                                                    victim&#x27;s computer. This delivery method relies on social
                                                    engineering.</span>
                                            </label>
                                        </div>
                                        <div class="tab-pane fade " id="tab4_2" role="tabpanel"
                                            aria-labelledby="statement-tab4_2">
                                            <label
                                                class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                                style="font-family:system-ui !important;">
                                                <span>Cyber criminals may spread ransomware by directing victims to
                                                    malicious websites. When the victim visits the website, the
                                                    ransomware may be automatically downloaded and installed on their
                                                    computer. This delivery method relies on social engineering.</span>
                                            </label>
                                        </div>
                                        <div class="tab-pane fade " id="tab4_3" role="tabpanel"
                                            aria-labelledby="statement-tab4_3">
                                            <label
                                                class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                                style="font-family:system-ui !important;">
                                                <span>Cyber criminals may use exploit kits to spread ransomware. Exploit
                                                    kits are sets of tools that are used to exploit vulnerabilities in
                                                    computer systems and install malware, including ransomware. Exploit
                                                    kits are often designed for mass exploitation and it allows
                                                    criminals to scale their operations significantly.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 31%;" aria-valuenow="31" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h3 style="font-weight:100" class="#44225c">
                                        <span style="color: dodgerblue;">Is the following statement True or
                                            False:</span>
                                        <br>
                                        You should only download attachments in an email if the email is expected and
                                        from a trusted sender.
                                    </h3>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription5" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer5"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            It&#x27;s ok to download an attachment in an email if the email is expected
                                            and from a trusted sender. If the email raises any red flags such as
                                            it&#x27;s unsolicited, calls for urgency, is from an unknown sender or
                                            contains suspicious wording or grammar, then you should report the email to
                                            your IT or Security team as a suspected phish.
                                        </h6>
                                        <a href="#" onclick='showAnswer(5);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions5">
                                        <label for="opt_5_1"
                                            class="step_5 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground">
                                            True
                                            <input id="opt_5_1" type="radio" name="stp_5_select_option"
                                                onclick="validateAnswer('True', '5');">
                                        </label>
                                        <label for="opt_5_2"
                                            class="step_5 animate__animated animate__fadeInRight animate_50ms position-relative rounded-pill text-start #44225c darkBackground">
                                            False
                                            <input id="opt_5_2" type="radio" name="stp_5_select_option"
                                                onclick="validateAnswer('False', '5');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 38%;" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">What does ransomware do once it infects a computer?</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    It begins encrypting data on the infected computer. Once encrypted, ransomware will
                                    display a message demanding payment in the form of virtual currency (e.g. Bitcoin)
                                    in exchange for the decryption key.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 45%;" aria-valuenow="45" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">What does ransomware do to data on your computer?</h1>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription7" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer7"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            Ransomware encrypts data, which means it converts the data into a form that
                                            is unreadable without a decryption key.
                                        </h6>
                                        <a href="#" onclick='showAnswer(7);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions7">
                                        <label for="opt_7_1"
                                            class="step_7 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            It moves it to a safe location <i
                                                class="step_7_selected fa fa-user-lock"></i>
                                            <input id="opt_7_1" type="radio" name="stp_7_select_option"
                                                onclick="validateAnswer('False', '7');">
                                        </label>
                                        <label for="opt_7_2"
                                            class="step_7 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            It secures data through encryption <i
                                                class="step_7_selected fa fa-user-lock"></i>
                                            <input id="opt_7_2" type="radio" name="stp_7_select_option"
                                                onclick="validateAnswer('False', '7');">
                                        </label>
                                        <label for="opt_7_3"
                                            class="step_7 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            It deletes data <i class="step_7_selected fa fa-user-lock"></i>
                                            <input id="opt_7_3" type="radio" name="stp_7_select_option"
                                                onclick="validateAnswer('False', '7');">
                                        </label>
                                        <label for="opt_7_4"
                                            class="step_7 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            It makes data unreadable <i class="step_7_selected fa fa-user-lock"></i>
                                            <input id="opt_7_4" type="radio" name="stp_7_select_option"
                                                onclick="validateAnswer('True', '7');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 52%;" aria-valuenow="52" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Preventing ransomware</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    Ensuring you&#x27;re protected against ransomware requires you to implement a
                                    variety of cyber security best practices. As a starting point, it&#x27;s best to
                                    follow the three practices listed below.
                                </label>
                                <div class="pt-4 animate__animated animate__fadeInRight animate_25ms">
                                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-link-light active" id="statement-tab8_1"
                                                data-bs-toggle="tab" data-bs-target="#tab8_1" type="button"
                                                role="tab" aria-controls="tab8_1" aria-selected="true">Keep
                                                systems and software up-to-date</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-link-light " id="statement-tab8_2"
                                                data-bs-toggle="tab" data-bs-target="#tab8_2" type="button"
                                                role="tab" aria-controls="tab8_2" aria-selected="false">Regularly
                                                back up data</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-link-light " id="statement-tab8_3"
                                                data-bs-toggle="tab" data-bs-target="#tab8_3" type="button"
                                                role="tab" aria-controls="tab8_3" aria-selected="false">Avoid
                                                suspicious emails and websites</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tab8_1" role="tabpanel"
                                            aria-labelledby="statement-tab8_1">
                                            <label
                                                class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                                style="font-family:system-ui !important;">
                                                <span>One of the most effective ways to protect against ransomware is to
                                                    ensure that all systems and software are kept up-to-date. This
                                                    includes installing updates and patches as they become available, as
                                                    these can fix vulnerabilities that can be exploited by
                                                    ransomware.</span>
                                            </label>
                                        </div>
                                        <div class="tab-pane fade " id="tab8_2" role="tabpanel"
                                            aria-labelledby="statement-tab8_2">
                                            <label
                                                class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                                style="font-family:system-ui !important;">
                                                <span>Regularly backing up data is another important way to protect
                                                    against ransomware. By regularly creating copies of important data,
                                                    you can ensure that you have a copy available in case your data is
                                                    encrypted by ransomware.</span>
                                            </label>
                                        </div>
                                        <div class="tab-pane fade " id="tab8_3" role="tabpanel"
                                            aria-labelledby="statement-tab8_3">
                                            <label
                                                class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                                style="font-family:system-ui !important;">
                                                <span>Cyber criminals often spread ransomware through email attachments
                                                    and malicious websites. It is important to be cautious of suspicious
                                                    emails and websites and to avoid opening attachments or clicking
                                                    links from unknown sources. Instead, verify the authenticity of
                                                    emails and websites before interacting with them.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 59%;" aria-valuenow="59" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h3 style="font-weight:100" class="#44225c">
                                        <span style="color: dodgerblue;">Is the following statement True or
                                            False:</span>
                                        <br>
                                        To prevent ransomware, we should store data in the cloud and make it publicly
                                        readable and writable.
                                    </h3>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription9" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer9"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            Making data publicly readable and writable invites cyber criminals to
                                            encrypt the data and hold it for ransom. To prevent ransomware, data should
                                            be stored in a secure location, with backups stored in a separate location.
                                        </h6>
                                        <a href="#" onclick='showAnswer(9);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions9">
                                        <label for="opt_9_1"
                                            class="step_9 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground">
                                            True
                                            <input id="opt_9_1" type="radio" name="stp_9_select_option"
                                                onclick="validateAnswer('False', '9');">
                                        </label>
                                        <label for="opt_9_2"
                                            class="step_9 animate__animated animate__fadeInRight animate_50ms position-relative rounded-pill text-start #44225c darkBackground">
                                            False
                                            <input id="opt_9_2" type="radio" name="stp_9_select_option"
                                                onclick="validateAnswer('True', '9');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 66%;" aria-valuenow="66" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">To prevent ransomware, we should</h1>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription10" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer10"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            To deter ransomware attacks we should, be cautious of suspicious emails and
                                            websites, perform frequent backups and perform frequent software and system
                                            updates.
                                        </h6>
                                        <a href="#" onclick='showAnswer(10);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions10">
                                        <label for="opt_10_1"
                                            class="step_10 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Perform infrequent software and system updates <i
                                                class="step_10_selected fa fa-user-lock"></i>
                                            <input id="opt_10_1" type="radio" name="stp_10_select_option"
                                                onclick="validateAnswer('False', '10');">
                                        </label>
                                        <label for="opt_10_2"
                                            class="step_10 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            No option is correct. <i class="step_10_selected fa fa-user-lock"></i>
                                            <input id="opt_10_2" type="radio" name="stp_10_select_option"
                                                onclick="validateAnswer('False', '10');">
                                        </label>
                                        <label for="opt_10_3"
                                            class="step_10 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Remain cautious of suspicious emails and websites <i
                                                class="step_10_selected fa fa-user-lock"></i>
                                            <input id="opt_10_3" type="radio" name="stp_10_select_option"
                                                onclick="validateAnswer('True', '10');">
                                        </label>
                                        <label for="opt_10_4"
                                            class="step_10 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Perform infrequent backups <i class="step_10_selected fa fa-user-lock"></i>
                                            <input id="opt_10_4" type="radio" name="stp_10_select_option"
                                                onclick="validateAnswer('False', '10');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 73%;" aria-valuenow="73" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Ransomware recovery</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    Before restoring systems from a backup device, it&#x27;s good practice to ensure
                                    that the cyber criminal no longer has access to your network. This is to ensure that
                                    they can&#x27;t just re-encrypt restored data!
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 80%;" aria-valuenow="80" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Why should we ensure cyber criminals no longer have access to
                                        our network before restoring data?</h1>
                                </div>
                                <div class="form_items scenarioQuestions">
                                    <div id="answerDescription12" class="pt-3" style="text-align:center">
                                        <h3 style="font-weight:400" id="answer12"></h3>
                                        <h6 class="#44225c"
                                            style="font-size:1.25rem; font-family:system-ui !important; font-weight:400">
                                            The main reason we want to ensure cyber criminals no longer have access to
                                            our networks when restoring from a ransomware attack is because they&#x27;ll
                                            re-encrypt any restored data. The restoration of data may also prompt them
                                            to take further action to disrupt and destroy IT systems as it&#x27;s an
                                            indicator that they likely won&#x27;t be receiving their ransomware payment.
                                        </h6>
                                        <a href="#" onclick='showAnswer(12);'>View Options Again</a>
                                    </div>
                                    <div id="answerQuestions12">
                                        <label for="opt_12_1"
                                            class="step_12 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Because they&#x27;re not an employee and shouldn&#x27;t have access <i
                                                class="step_12_selected fa fa-user-lock"></i>
                                            <input id="opt_12_1" type="radio" name="stp_12_select_option"
                                                onclick="validateAnswer('False', '12');">
                                        </label>
                                        <label for="opt_12_2"
                                            class="step_12 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Because they might see our sensitive data <i
                                                class="step_12_selected fa fa-user-lock"></i>
                                            <input id="opt_12_2" type="radio" name="stp_12_select_option"
                                                onclick="validateAnswer('False', '12');">
                                        </label>
                                        <label for="opt_12_3"
                                            class="step_12 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Because they&#x27;ll just re-encrypt any restored data <i
                                                class="step_12_selected fa fa-user-lock"></i>
                                            <input id="opt_12_3" type="radio" name="stp_12_select_option"
                                                onclick="validateAnswer('True', '12');">
                                        </label>
                                        <label for="opt_12_4"
                                            class="step_12 animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill text-start #44225c darkBackground"
                                            data-toggle="modal" data-target="#answerModal" data-whatever="mdo">
                                            Because we don&#x27;t want them to know we&#x27;re onto them <i
                                                class="step_12_selected fa fa-user-lock"></i>
                                            <input id="opt_12_4" type="radio" name="stp_12_select_option"
                                                onclick="validateAnswer('False', '12');">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 87%;" aria-valuenow="87" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Why is ransomware growing?</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    Since the introduction of digital currencies such as Bitcoin, ransomware has
                                    exponentially grown in popularity. This is because cyber criminals now have a
                                    mechanism to anonymously accept funds from their illicit activities.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="multisteps_form_panel step">
                        <div class="col-md-7 m-auto">
                            <div class="content_box py-2 ps-5 position-relative stepItemMobile">
                                <!-- Step-progress-bar -->
                                <div class="step_progress_bar mb-3">
                                    <div class="progress rounded-pill">
                                        <span><i class="far fa-solid fa-user-shield"></i></span>
                                        <div class="progress-bar mx-2 rounded-pill" role="progressbar"
                                            style="width: 90%;" aria-valuenow="90" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="question_title py-3">
                                    <h1 class="#44225c">Wrapping up</h1>
                                </div>
                                <label
                                    class="animate__animated animate__fadeInRight animate_25ms position-relative rounded-pill #44225c"
                                    style="font-size:1.25rem; font-family:system-ui !important;">
                                    If you open an email, visit a website, come across a file that seems suspicious or
                                    believe that your computer is infected with malware, don&#x27;t hesitate to contact
                                    your IT or Security team for assistance.
                                </label>
                            </div>
                        </div>
                    </div>
                    <!------------------------- Step-1 ----------------------------->

                    <!------------------------- Form button ----------------------------->
                    <div class="form_btn">
                        <button type="button"
                            class="f_btn rounded-pill prev_btn text-uppercase #44225c position-absolute text-white"
                            id="prevBtn" onclick="nextPrev(-1)"> Back</button>
                        <button type="button"
                            class="f_btn rounded-pill next_btn text-uppercase #44225c position-absolute text-white"
                            id="nextBtn" onclick="nextPrev(1)">
                            Next <i class="fa-user-shield"></i>
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
</script>
<script>
    $("#answerDescription1").hide();
    $(".step_1_selected").hide();

    $("#answerDescription2").hide();
    $(".step_2_selected").hide();

    $("#answerDescription3").hide();
    $(".step_3_selected").hide();

    $("#answerDescription4").hide();
    $(".step_4_selected").hide();

    $("#answerDescription5").hide();
    $(".step_5_selected").hide();

    $("#answerDescription6").hide();
    $(".step_6_selected").hide();

    $("#answerDescription7").hide();
    $(".step_7_selected").hide();

    $("#answerDescription8").hide();
    $(".step_8_selected").hide();

    $("#answerDescription9").hide();
    $(".step_9_selected").hide();

    $("#answerDescription10").hide();
    $(".step_10_selected").hide();

    $("#answerDescription11").hide();
    $(".step_11_selected").hide();

    $("#answerDescription12").hide();
    $(".step_12_selected").hide();

    $("#answerDescription13").hide();
    $(".step_13_selected").hide();

    $("#answerDescription14").hide();
    $(".step_14_selected").hide();
</script>
<script>
    var qCount = 7;
    var qCorrect = 0;
    var qIncorrect = 0;
    $(function() {
        // ========== Form-select-option ========== //
        var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13, s14, s15, s16, s17, s18, s19, s20, s21, s22,
            s23, s24, s25, s26, s27, s28, s29, s30, s31, s32, s33, s34, s35, s36, s37, s38, s39, s40, s41, s42,
            s43, s44, s45, s46, s47, s48, s49, s50, s51, s52, s53, s54, s55, s56, s57, s58, s59, s60, s61, s62,
            s63, s64, s65, s66, s67, s68, s69, s70, s71, s72, s73, s74, s75, s76, s77, s78, s79, s80, s81, s82,
            s83, s84, s85, s86, s87, s88, s89, s90, s91, s92, s93, s94, s95, s96, s97, s98, s99, s100 = false;

        $(".step_1").on('click', function() {
            if (!s1) {
                $(".step_1").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription1").show();
                $("#answerQuestions1").hide();
                $(".step_1_selected").show();
                s1 = true;
            }
        });

        $(".step_2").on('click', function() {
            if (!s2) {
                $(".step_2").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription2").show();
                $("#answerQuestions2").hide();
                $(".step_2_selected").show();
                s2 = true;
            }
        });

        $(".step_3").on('click', function() {
            if (!s3) {
                $(".step_3").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription3").show();
                $("#answerQuestions3").hide();
                $(".step_3_selected").show();
                s3 = true;
            }
        });

        $(".step_4").on('click', function() {
            if (!s4) {
                $(".step_4").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription4").show();
                $("#answerQuestions4").hide();
                $(".step_4_selected").show();
                s4 = true;
            }
        });

        $(".step_5").on('click', function() {
            if (!s5) {
                $(".step_5").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription5").show();
                $("#answerQuestions5").hide();
                $(".step_5_selected").show();
                s5 = true;
            }
        });

        $(".step_6").on('click', function() {
            if (!s6) {
                $(".step_6").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription6").show();
                $("#answerQuestions6").hide();
                $(".step_6_selected").show();
                s6 = true;
            }
        });

        $(".step_7").on('click', function() {
            if (!s7) {
                $(".step_7").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription7").show();
                $("#answerQuestions7").hide();
                $(".step_7_selected").show();
                s7 = true;
            }
        });

        $(".step_8").on('click', function() {
            if (!s8) {
                $(".step_8").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription8").show();
                $("#answerQuestions8").hide();
                $(".step_8_selected").show();
                s8 = true;
            }
        });

        $(".step_9").on('click', function() {
            if (!s9) {
                $(".step_9").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription9").show();
                $("#answerQuestions9").hide();
                $(".step_9_selected").show();
                s9 = true;
            }
        });

        $(".step_10").on('click', function() {
            if (!s10) {
                $(".step_10").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription10").show();
                $("#answerQuestions10").hide();
                $(".step_10_selected").show();
                s10 = true;
            }
        });

        $(".step_11").on('click', function() {
            if (!s11) {
                $(".step_11").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription11").show();
                $("#answerQuestions11").hide();
                $(".step_11_selected").show();
                s11 = true;
            }
        });

        $(".step_12").on('click', function() {
            if (!s12) {
                $(".step_12").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription12").show();
                $("#answerQuestions12").hide();
                $(".step_12_selected").show();
                s12 = true;
            }
        });

        $(".step_13").on('click', function() {
            if (!s13) {
                $(".step_13").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription13").show();
                $("#answerQuestions13").hide();
                $(".step_13_selected").show();
                s13 = true;
            }
        });

        $(".step_14").on('click', function() {
            if (!s14) {
                $(".step_14").removeClass("active");
                $(this).addClass("active");
                $("#answerDescription14").show();
                $("#answerQuestions14").hide();
                $(".step_14_selected").show();
                s14 = true;
            }
        });
    });

    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("multisteps_form_panel");
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
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        document.getElementById("prevBtn").innerHTML = "Back";
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
            submitLearning();
            // document.getElementById("wizard").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
        validateForm();
        return true;
    }

    function submitLearning() {
        $('#nextBtn').html('<i class="fa fa-spinner fa-spin"></i>');
        $('#nextBtn').prop('disabled', true);

        var completedRedirect = "/Complete/Training" + document.location.search + "&q=" + btoa(qCount) + "&c=" + btoa(
            qCorrect);
        window.location.href = completedRedirect;
    }

    function validateAnswer(answer, stepNumber) {
        validateForm();
        console.log(answer);
        if (answer == "True") {
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
                document.getElementById("nextBtn").innerHTML = "Submit";
                document.getElementById("prevBtn").innerHTML = "Back";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
                document.getElementById("prevBtn").innerHTML = "Back";
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        $('.videoStatement').each(function() {
            $(this).get(0).pause();
        });
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
