@extends('admin/layouts/contentLayoutMaster')

@section('title', __('assessment.Assessments'))
@section('vendor-style')
    <!-- vendor css files -->

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0//css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
@endsection


@section('page-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">

    <style>
        .carousel {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
        }

        .carousel-container {
            display: flex;
            transition: transform 0.3s ease-in-out;
            margin-bottom: 43px;
        }

        .tab {
            flex: 0 0 auto;
            text-align: center;
            background: #f2f2f2;
            cursor: pointer;
            padding: 15px;
            border-radius: 6px;
            white-space: nowrap;
            border: 1px solid white;
            color: #5e5873;
            font-size: 1rem;
            width: 260px;
        }

        .card-top {
            width: 99% !important;
        }

        /* .tab {
                                                                                                        padding: 15px 25px;
                                                                                                        margin: 0 5px;
                                                                                                    } */

        .tab.active {
            background: #44225c !important;
            box-shadow: 0 4px 10px -4px rgba(68, 34, 92, 0.5);
            color: white !important;
        }

        .carousel-button {
            position: absolute;
            top: 90%;
            transform: translateY(-50%);
            background: white;
            color: #43215b;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .prev {
            left: 46%;
        }

        .next {
            right: 48%;
        }

        .tab-content {
            margin-top: 20px;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .temlates-num {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f6f7;
            color: #44225c;
        }

        input {
            margin-bottom: 40px;
        }

        .input-simple {
            font-size: 16px;
            line-height: 1.5;
            border: none;
            background: #FFFFFF;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20'><path fill='%23838D99' d='M13.22 14.63a8 8 0 1 1 1.41-1.41l4.29 4.29a1 1 0 1 1-1.41 1.41l-4.29-4.29zm-.66-2.07a6 6 0 1 0-8.49-8.49 6 6 0 0 0 8.49 8.49z'></path></svg>");
            background-repeat: no-repeat;
            background-position: 10px 10px;
            background-size: 20px 20px;
            border: 1px solid #dfdfdf;
            width: 250px;
            padding: .5em 1em .5em 2.5em;
            border-radius: 4%;
        }

        .input-simple::placeholder {
            color: #838D99;
        }

        .input-simple:focus {
            outline: none;
            border: 1px solid #dfdfdf;
        }

        .input-simple::placeholder {
            color: black;
        }

        .plus-custom {
            position: relative;
        }

        .plus-custom::after {
            content: "";
            width: 2px;
            height: 21px;
            position: absolute;
            right: 8px;
            top: 7px;
            background-color: #8cc996;
            z-index: 1;
        }

        .plus-custom::before {
            content: "";
            width: 23px;
            height: 2px;
            position: absolute;
            right: 8px;
            bottom: 7px;
            background-color: #8cc996;
            z-index: 1;
        }
    </style>
@endsection




@section('content')
    <div class="content-header row ">
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
    <div id="quill-service-content" class="d-none"></div>

    <div class="card card-top p-4 m-5">
        <div class="row mb-3">
            <div class="col-md-8 mb-2 mb-md-0 d-flex align-items-center gap-3">
                <div class="mb-0 h3 d-flex align-items-center">
                    <p class="fs-4 mb-0">Templates : </p>
                    <p class="fs-4 mb-0">{{ $all_assessments->count() }}</p>
                </div>
                <div class="search-container ms-3">
                    <input class="input-simple search-assessment" type="text" placeholder="Search by Template name">
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                @if (auth()->user()->hasPermission('templateAssessment.create'))
                    <button class="btn btn-primary" id="addn" data-bs-toggle="modal"
                        data-bs-target="#new-assessment-modal">
                        <i class="fas fa-plus me-2"></i>
                        New Template
                    </button>
                @endif
            </div>

        </div>
        <!-- Start Carousel Tabs -->
        <div class="carousel">
            <div class="carousel-container">
                @foreach ($all_assessments as $assessment)
                    <button class="tab sideNavBtn{{ $loop->first ? ' active' : '' }}" data-tab="{{ $assessment->id }}"
                        data-name="{{ $assessment->name }}">
                        {{ $assessment->name }}
                    </button>
                @endforeach
            </div>
            <button class="carousel-button prev">
                <i class="fa-solid fa-chevron-left" style="font-size: 20px;"></i>
            </button>
            <button class="carousel-button next">
                <i class="fa-solid fa-chevron-right" style="font-size: 20px;"></i>
            </button>
        </div>
    </div>

    <div class="todo-app-list {{ @$assessments->first() ? 'd-block' : 'd-none' }}">

        <div class="container-fluid">
            <!-- Control Card -->
            <div class="row">
                <div class="card card-custom mt-4">
                    <div class="card-body">
                        <!-- Start Tab Content -->
                        <div id="firstTab{{ $assessments->first()->id ?? '' }}" class="tabcontent">
                            <div class="row" id="dark-table">
                                <div class="card card-custom  mb-0">
                                    <div class="card-body p-0">
                                        <div class="row p-3">
                                            <div class="col-md-4 d-flex align-items-center mb-md-0 mb-2">
                                                <p class="black fs-5 mb-0">Name:</p>
                                                <h5 class="card-desc AssessmentName">
                                                    {{ $assessments->first()->name ?? '' }}
                                                </h5>
                                                {{-- <div class="search-container ms-5">
                                                    <input class="input-simple" type="text"
                                                        placeholder="Search by Question name">
                                                </div> --}}
                                            </div>
                                            <div class="col-md-  d-flex justify-content-end gap-2">
                                                <div class="action-buttons">
                                                    <!-- <a href="#" class="card-link">Another link</a> -->
                                                    <!-- <a href="#" class="card-link">Another link</a> -->
                                                    @if (auth()->user()->hasPermission('templateAssessment.edit'))
                                                        <button type="button"
                                                            class="p-0
                                                                    card-link
                                                                    btn  btn-sm
                                                                    updateItem"
                                                            data-id="{{ $assessments->first()->id ?? '' }}"
                                                            data-name="{{ $assessments->first()->name ?? '' }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit-modal{{ $assessments->first()->id ?? '' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-edit"
                                                                style="width: 30px; color: #44225c; height: 34px;">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                </path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('templateAssessment.delete'))
                                                        <button
                                                            class="card-link btn  btn border-0 p-0 mx-3 deleteItem "
                                                            data-id="{{ $assessments->first()->id ?? '' }}">
                                                            <i class="fa-solid fa-trash-can"
                                                                style="color:#ba1717 ; font-size: 30px;"></i>
                                                        </button>
                                                    @endif

                                                </div>
                                                @if (auth()->user()->hasPermission('templateAssessment.create'))

                                                    <button class="btn btn-primary py-2" data-bs-toggle="modal"
                                                        data-bs-target="#new-question-modal">
                                                        <i class="fas fa-plus me-1"></i>
                                                        New Question
                                                    </button>


                                                    <button class="btn btn-outline-primary py-2 ImportQuestionsBTn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#import-questions-modal">
                                                        Questions Bank
                                                    </button>

                                                    <a href="{{ route('admin.questions.notificationsSettingsQuestions') }}"
                                                        class="btn btn-primary p-2" target="_self">
                                                        <i class="fa fa-regular fa-bell"></i>

                                                    </a>

                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Card -->
            <div class="row">
                <div class="card card-custom">
                    <div class="card-body">
                        {{-- <p class="black fw-bold mb-0">Questions</p>
                        <p class="temlates-num ms-2 mb-0 questions-count">0</p> --}}

                        <section id="advanced-search-datatable">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <hr class="my-0" />
                                        <div class="card-datatable table-responsive mx-1">
                                            <table class="table QuestionTable text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="all">{{ __('locale.#') }}</th>
                                                        <th class="all">{{ __('assessment.FileAttachment') }}</th>
                                                        {{-- <th class="all">{{ __('assessment.QuestionLogic') }}</th> --}}
                                                        <th class="all">{{ __('assessment.RiskAssessment') }}</th>
                                                        <th class="all">{{ __('assessment.NdaAssessment') }}
                                                        </th>
                                                        <th class="all">{{ __('assessment.ComplianceAssessment') }}
                                                        </th>
                                                        <th class="all">{{ __('assessment.MaturityAssessment') }}
                                                        </th>
                                                        
                                                        <th class="all">{{ __('assessment.HaveAnswers') }}</th>
                                                        <th class="all">{{ __('assessment.AnswerType') }}</th>
                                                        <th class="all">{{ __('assessment.Question') }}</th>
                                                        <th class="all">{{ __('assessment.answerr') }}</th>
                                                        <th class="all">{{ __('assessment.Actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table rows will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="no-results">
            <h5>No Items Found</h5>
        </div>

        {{-- assessments modals --}}
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="new-assessment-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('assessment.AddNewTemplate') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-assessment-modal">
                <div class="modal-dialog sidebar-lg"> -->
                    <div class="modal-content p-0">
                        <form id="add_assessment" class="add_assessment todo-modal needs-validation" novalidate
                            method="POST" action="{{ route('admin.assessment.store') }}">
                            @csrf

                            <!-- <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('assessment.AddNewTemplate') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75">
                            <i data-feather="star" class="font-medium-2"></i>
                        </span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div> -->
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                        <input type="text" name="name" class=" form-control"
                                            placeholder="Name" required />
                                        <span class="error error-name"></span>
                                    </div>
                                </div>
                                <div class="my-1">
                                    <button type="submit" class="btn btn-primary add-todo-item me-1">
                                        {{ __('locale.Add') }}
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-secondary add-todo-item" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="edit-assessment-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('locale.UpdateAssessment') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-assessment-modal">
            <div class="modal-dialog sidebar-lg"> -->
                    <div class="modal-content p-0">
                        <form id="edit_assessment" class="edit_assessment todo-modal needs-validation" novalidate
                            method="POST" action="">
                            @csrf
                            <input type="hidden" name="id">
                            <!-- <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('locale.UpdateAssessment') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75">
                            <i data-feather="star" class="font-medium-2"></i>
                        </span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div> -->
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                        <input type="text" name="name" class=" form-control"
                                            placeholder="Name" required />
                                        <span class="error error-name"></span>
                                    </div>
                                </div>
                                <div class="my-1">
                                    <button type="submit" class="btn btn-primary   add-todo-item me-1">
                                        {{ __('locale.Update') }}
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-secondary add-todo-item "
                            data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- qeustions modals --}}
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="new-question-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('locale.AddNewQuestion') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-question-modal">
            <div class="modal-dialog sidebar-lg"> -->
                    <div class="modal-content p-0">
                        <form id="add_questions" class="add_questions todo-modal needs-validation" novalidate
                            method="POST" action="{{ route('admin.questions.store') }}">
                            @csrf

                            <!-- <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('locale.AddNewQuestion') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75">
                            <i data-feather="star" class="font-medium-2"></i>
                        </span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div> -->
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="question_en" class="form-label">{{ __('locale.Question') }}
                                            (EN)</label>
                                        <div id="question_en" class="border-bottom-0 question_en"></div>
                                        <div class="d-flex justify-content-end question_en-toolbar border-top-0">
                                            <span class="ql-formats me-2">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-link"></button>
                                            </span>
                                        </div>
                                        <span class="error error-question-en"></span>
                                    </div>
                                    <div class="mb-1">
                                        <label for="question_ar" class="form-label">{{ __('locale.Question') }}
                                            (AR)</label>
                                        <div id="question_ar" class="border-bottom-0 question_ar"></div>
                                        <div class="d-flex justify-content-end question_ar-toolbar border-top-0">
                                            <span class="ql-formats me-2">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-link"></button>
                                            </span>
                                        </div>
                                        <span class="error error-question-ar"></span>
                                    </div>
                                    <div class="mb-1 controls" {{-- id="controls" --}}>
                                        <label for="controls">{{ __('locale.Controls') }}</label>
                                        <select name="control_id" class="form-control select2 controls">
                                            <option value="">{{ __('locale.Choose') }}</option>
                                            @foreach ($controls as $control)
                                                <option value="{{ $control->id }}">{{ $control->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="mb-1">
                                        <label for="answer_type">{{ __('assessment.AnswerType') }}</label>
                                        <select name="answer_type" {{-- id="answer_type" --}}
                                            class="form-control select2 answer_type">
                                            <option value="1">
                                                {{ __('assessment.Multiple Choice ( single-select )') }}
                                            </option>
                                            <option value="2">
                                                {{ __('assessment.Multiple Choice ( multiple-select )') }}
                                            </option>
                                            <option value="3">{{ __('assessment.FillInTheBlank') }}</option>
                                        </select>
                                    </div>

                                    <div class="options">
                                        <div class="mb-1 file_attachment ">
                                            <label data-toggle="tooltip"
                                                title="Enable file uploads for this question."
                                                for="file_attachment">{{ __('assessment.FileAttachment') }}
                                            </label>
                                            <input type="checkbox" id="file_attachment" name="file_attachment"
                                                value="1">
                                        </div>
                                        {{-- <div class="mb-1 question_logic">
                                <label data-toggle="tooltip"
                                    title="Enable ability to ask another question
                                        based on the answer to this question."
                                    for="QuestionLogic">{{ __('assessment.QuestionLogic') }}
                                </label>
                                <input type="checkbox" id="QuestionLogic" name="question_logic" value="1">
                            </div> --}}
                                        <div class="mb-1 risk_assessment">
                                            <label data-toggle="tooltip"
                                                title=" Enable creation of risks based on the answer to this question."
                                                for="RiskAssessment">{{ __('assessment.RiskAssessment') }}
                                            </label>
                                            <input type="checkbox" id="RiskAssessment" name="risk_assessment"
                                                value="1">
                                        </div>
                                        <div class="mb-1 nda_assessment">
                                            <label data-toggle="tooltip"
                                                title=" Enable creation of nda based on the answer to this question."
                                                for="NdaAssessment">{{ __('assessment.Nda') }}
                                            </label>
                                            <input type="checkbox" id="NdaAssessment" name="nda_assessment"
                                                value="1">
                                        </div>
                                        <div class="mb-1 compliance_assessment">
                                            <label data-toggle="tooltip"
                                                title="Enable tracking of the pass/fail status
                                 against the mapped controls."
                                                for="ComplianceAssessment">{{ __('assessment.ComplianceAssessment') }}
                                            </label>
                                            <input type="checkbox" id="ComplianceAssessment"
                                                name="compliance_assessment" value="1">
                                        </div>
                                        <div class="mb-1 maturity_assessment">
                                            <label data-toggle="tooltip"
                                                title="Enable tracking of the current control maturity level
                                        against our desired maturity level."
                                                for="MaturityAssessment">{{ __('assessment.MaturityAssessment') }}
                                            </label>
                                            <input type="checkbox" id="MaturityAssessment" name="maturity_assessment"
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="my-1">
                                    <button type="submit" class="btn btn-primary add-todo-item me-1">
                                        {{ __('locale.Add') }}
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-secondary add-todo-item "
                            data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="edit-question-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myExtraLargeModal">{{ __('locale.UpdateQuestion') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-question-modal">
            <div class="modal-dialog sidebar-lg"> -->
                    <div class="modal-content p-0">
                        <form id="edit_question_form" class="edit_question_form todo-modal needs-validation"
                            novalidate method="POST" action="{{ route('admin.questions.update', ':id') }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="question_id">
                            <!-- <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('locale.UpdateQuestion') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75">
                            <i data-feather="star" class="font-medium-2"></i>
                        </span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div> -->
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="edit_question_en" class="form-label">{{ __('locale.Question') }}
                                            (EN)</label>
                                        <div id="edit_question_en" class="border-bottom-0"></div>
                                        <div class="d-flex justify-content-end edit_question_en-toolbar border-top-0">
                                            <span class="ql-formats me-2">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-link"></button>
                                            </span>
                                        </div>
                                        <span class="error error-question-en"></span>
                                    </div>
                                    <div class="mb-1">
                                        <label for="edit_question_ar" class="form-label">{{ __('locale.Question') }}
                                            (AR)</label>
                                        <div id="edit_question_ar" class="border-bottom-0"></div>
                                        <div class="d-flex justify-content-end edit_question_ar-toolbar border-top-0">
                                            <span class="ql-formats me-2">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-link"></button>
                                            </span>
                                        </div>
                                        <span class="error error-question-ar"></span>
                                    </div>
                                    <div class="mb-1 controls" {{-- id="controls" --}}>
                                        <label for="controls">{{ __('locale.Controls') }}</label>
                                        <select name="control_id" class="form-control select2 controls">
                                            <option value="">{{ __('locale.Choose') }}</option>
                                            @foreach ($controls as $control)
                                                <option value="{{ $control->id }}">{{ $control->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="mb-1">
                                        <label for="answer_type">{{ __('assessment.AnswerType') }}</label>
                                        <select name="answer_type" id="answer_type"
                                            class="form-control select2 answer_type">
                                            <option value="1">
                                                {{ __('assessment.Multiple Choice ( single-select )') }}
                                            </option>
                                            <option value="2">
                                                {{ __('assessment.Multiple Choice ( multiple-select )') }}
                                            </option>
                                            <option value="3">{{ __('assessment.FillInTheBlank') }}</option>
                                            <option value="4">{{ __('assessment.Nda') }}</option>
                                        </select>
                                    </div>

                                    <div class="options">
                                        <div class="mb-1 file_attachment ">
                                            <label data-toggle="tooltip"
                                                title="Enable file uploads for this question."
                                                for="edit_file_attachment">{{ __('assessment.FileAttachment') }}
                                            </label>
                                            <input type="checkbox" id="edit_file_attachment" name="file_attachment"
                                                value="1">
                                        </div>
                                        {{-- <div class="mb-1 question_logic">
                                            <label data-toggle="tooltip"
                                                title="Enable ability to ask another question based
                                        on the answer to this question."
                                                for="edit_QuestionLogic">{{ __('assessment.QuestionLogic') }}
                                            </label>
                                            <input type="checkbox" id="edit_QuestionLogic" name="question_logic"
                                                value="1">
                                         </div> --}}
                                        <div class="mb-1 risk_assessment">
                                            <label data-toggle="tooltip"
                                                title=" Enable creation of risks based on
                                 the answer to this question."
                                                for="edit_RiskAssessment">{{ __('assessment.RiskAssessment') }}
                                            </label>
                                            <input type="checkbox" id="edit_RiskAssessment" name="risk_assessment"
                                                value="1">
                                        </div>
                                        <div class="mb-1 nda_assessment">
                                            <label data-toggle="tooltip"
                                                title=" Enable creation of Nda based on
                                 the answer to this question."
                                                for="edit_NdaAssessment">{{ __('assessment.NdaAssessment') }}
                                            </label>
                                            <input type="checkbox" id="edit_RiskAssessment" name="nda_assessment"
                                                value="1">
                                        </div>
                                        <div class="mb-1 compliance_assessment">
                                            <label data-toggle="tooltip"
                                                title="Enable tracking of the pass/fail status against the mapped controls."
                                                for="edit_ComplianceAssessment">{{ __('assessment.ComplianceAssessment') }}
                                            </label>
                                            <input type="checkbox" id="edit_ComplianceAssessment"
                                                name="compliance_assessment" value="1">
                                        </div>
                                        <div class="mb-1 maturity_assessment">
                                            <label data-toggle="tooltip"
                                                title="Enable tracking of the
                                 current control maturity level
                                 against our desired maturity level."
                                                for="edit_MaturityAssessment">{{ __('assessment.MaturityAssessment') }}
                                            </label>
                                            <input type="checkbox" id="edit_MaturityAssessment"
                                                name="maturity_assessment" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="my-1">
                                    <button type="submit" class="btn btn-primary   add-todo-item me-1">
                                        {{ __('locale.Update') }}
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-secondary add-todo-item "
                            data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- import questions --}}
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="import-questions-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('assessment.QuestionsBank') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="import-questions-modal">
            <div class="modal-dialog sidebar-lg"> -->
                    <div class="modal-content p-0">
                        <form id="import_questions" class="import_questions todo-modal needs-validation" novalidate
                            method="POST" action="{{ route('admin.questions.importQuestions') }}">
                            @csrf

                            <!-- <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('assessment.QuestionsBank') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75">
                            <i data-feather="star" class="font-medium-2"></i>
                        </span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div> -->
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="assessment_id"
                                            class="form-label">{{ __('locale.Assessment') }}</label>
                                        <select name="assessment_id" id="assessment_id" class="form-control select2">
                                            <option value="">---</option>
                                            @foreach ($all_assessments as $assessment)
                                                <option value="{{ $assessment->id }}">{{ $assessment->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-name"></span>
                                    </div>

                                    <div class="mb-1">
                                        {{--  data-assessment_id="{{ @$question->assessments->first()->id }}"  --}}
                                        <div class="mb-2">
                                            <button type="button"
                                                class="btn btn-primary btn-sm select-all-btn">{{ __('locale.SelectAll') }}</button>
                                            <button type="button"
                                                class="btn btn-primary btn-sm unselect-all-btn">{{ __('locale.UnSelectAll') }}</button>
                                        </div>
                                        <label for="assessments_questions"
                                            class="form-label">{{ __('locale.Questions') }}</label>
                                        <select name="question_ids[]" id="assessments_questions"
                                            class="form-control select2" multiple>
                                            @foreach ($questions as $question)
                                                <option value="{{ $question->id }}">
                                                    {{ $question->question }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-name"></span>
                                    </div>
                                </div>
                                <div class="my-1">
                                    <button type="submit" class="btn btn-primary add-todo-item me-1">
                                        {{ __('locale.Import') }}
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-secondary add-todo-item"
                            data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection




@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script> --}}
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection

@section('page-script')

    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script>
        let _assessment_id = '{{ $assessments->first()->id ?? '' }}';
        let _assessment_name = '{{ $assessments->first()->name ?? '' }}';
        let _page = 1;
        let _sideNavBtn = '';

        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";

        // Handle click event on side navigation buttons (tabs)
        $(document).on('click', '.sideNavBtn', function() {
            // Update the clicked button as active and remove active from siblings
            $(this).addClass('active').siblings().removeClass('active');

            // Get the assessment ID and name from data attributes
            _assessment_id = $(this).data('tab'); // Assuming data-tab contains the assessment ID
            _assessment_name = $(this).data('name'); // Retrieve data-name
            // Update the displayed assessment name
            $('.AssessmentName').text(_assessment_name);


            // Update the data attributes for the update and delete buttons
            $('.updateItem').attr('data-id', _assessment_id);
            $('.deleteItem').attr('data-id', _assessment_id);

            // Refresh the DataTable with the new assessment ID
            table.ajax.reload();
        });

        // edit assessment
        $('.updateItem').on('click', function() {
            let form = $('#edit-assessment-modal form');
            let url = "{{ route('admin.assessment.update', ':id') }}";
            url = url.replace(':id', _assessment_id);
            form.find($('input[name="name"]')).val(_assessment_name);
            form.attr('action', url);
            form.find('input[name="id"]').val(_assessment_id);
            $('#edit-assessment-modal').modal('show');

        });

        $(document).on('click', '.pagination.custom  a', function(e) {
            // get paginated assessments
            e.preventDefault();
            let url = $(this).data('url');
            _page = url.split('page=')[1];
            fetchData(_page);

        });

        function fetchData(page) {
            let url = '{{ route('admin.assessment.ajax.paginated_data', ':page') }}';
            url = url.replace(':page', 'page=' + page);
            $.ajax({
                type: "Get",
                url: url,
                success: function(response) {
                    $('#paginated_data').html(response);
                    $('.sideNavBtn:first').trigger('click');

                },
                error: function(xhr) {
                    console.log(xhr)
                }
            })
        }
    </script>

    {{-- on submit add assessment form --}}
    <script>
        $('#add_assessment').on('submit', function(event) {
            event.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            $.ajax({
                processData: false,
                contentType: false,
                cache: false,
                type: "POST",
                url: url,
                data: data,
                success: function(response) {
                    makeAlert('success', '@lang('assessment.Assessment Added Successfully')', 'Success');
                    $('#new-assessment-modal').modal('hide');
                    fetchData(_page);
                    formReset();
                    $('.todo-app-list').removeClass('d-none');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            let input = $(`input[name="${key}"]`);
                            input.addClass('is-invalid');
                            $('.error-' + key).text(value)
                        })
                    }

                }
            })
        });
        // edit form
        $('#edit_assessment').on('submit', function(event) {
            event.preventDefault();
            let url = $(this).attr('action'),
                data = new FormData(this);
            data.append('_method', 'put');
            $.ajax({
                processData: false,
                cache: false,
                contentType: false,
                type: "post",
                url: url,
                data: data,
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    makeAlert('success', '@lang('assessment.Assessment Updated Successfully')', 'Success');
                    $('#edit-assessment-modal').modal('hide');
                    fetchData(_page);
                    formReset();
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            let input = $(`input[name="${key}"]`);
                            input.addClass('is-invalid');
                            $('.error-' + key).text(value)
                        })
                    }
                }

            })

        });

        $('.deleteItem').on('click', function() {
            let url = '{{ route('admin.assessment.destroy', ':id') }}';
            url = url.replace(':id', _assessment_id);

            Swal.fire({
                title: swal_title,
                text: swal_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: swal_confirmButtonText,
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            makeAlert('success', '@lang('assessment.Assessment Deleted Successfully')', 'Success');
                            if ($('.sideNavBtn').length === 1) {
                                $('.todo-app-list').addClass('d-none');
                            }
                            fetchData(_page);
                            location.reload();
                        },
                        error: function(xhr) {
                            let errorMessage = "An error occurred!";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON
                                    .message; // Get the validation error message
                            }

                            Swal.fire({
                                title: "Error",
                                text: errorMessage,
                                icon: "error",
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: 'btn btn-relief-danger'
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };

        function formReset() {
            $('.modal form').trigger('reset');
            // Reset all Quill editors on the page
            if (typeof quill_en !== 'undefined') quill_en.setText('');
            if (typeof quill_ar !== 'undefined') quill_ar.setText('');
            if (typeof edit_quill_en !== 'undefined') edit_quill_en.setText('');
            if (typeof edit_quill_ar !== 'undefined') edit_quill_ar.setText('');
            $('.modal form select').trigger('change');
            $('.modal form div.d-none').removeClass('d-none');
        }

        $('.modal').on('hidden.bs.modal', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('.error').empty();

            formReset();
        })
    </script>

    {{-- questions --}}

    <script>
        const datatable_url = '{{ route('admin.questions.list') }}';
    </script>
    {{--  <script src="{{ asset('ajax-files/assessments/assessments/questions.js') }}"></script>  --}}
    <script>
        $(document).ready(function() {

            let _assessment_id = $(".tab.active").data("tab"); // Get the initial active tab's ID
            var AnswerRoute = "{{ route('admin.answers.index', ':id') }}";
            let table = $('.QuestionTable').DataTable({
                lengthChange: true,
                processing: false,
                serverSide: true,
                ajax: {
                    url: datatable_url,
                    data: function(d) {
                        d.assessment_id = _assessment_id;
                    }
                },
                language: {
                    "sProcessing": "{{ __('locale.Processing') }}",
                    "sSearch": "{{ __('locale.Search') }}",
                    "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                    "sInfo": "{{ __('locale.info') }}",
                    "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                    "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                    "sInfoPostFix": "",
                    "sSearchPlaceholder": "",
                    "sZeroRecords": "{{ __('locale.emptyTable') }}",
                    "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                    "oPaginate": {
                        "sFirst": "",
                        "sPrevious": "{{ __('locale.Previous') }}",
                        "sNext": "{{ __('locale.NextStep') }}",
                        "sLast": ""
                    },
                    "oAria": {
                        "sSortAscending": "{{ __('locale.sortAscending') }}",
                        "sSortDescending": "{{ __('locale.sortDescending') }}"
                    }
                },
                columns: [{
                        name: "DT_RowIndex",
                        data: "DT_RowIndex",
                        searchable: false,
                        orderable: false
                    },


                    {
                        name: "file_attachment",
                        data: "file_attachment",
                        searchable: true,
                        orderable: false,
                        render: function(d) {
                            var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                            if (d) {
                                icon = '<i class="fa fa-check text-success"></i>';
                            }
                            return icon;
                        }
                    },
                    // {
                    //     name: "question_logic",
                    //     data: "question_logic",
                    //     render: function(d) {
                    //         var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                    //         if (d) {
                    //             icon = '<i class="fa fa-check text-success"></i>';
                    //         }
                    //         return icon;
                    //     }
                    // },
                    {
                        name: "risk_assessment",
                        data: "risk_assessment",
                        searchable: true,
                        orderable: false,
                        render: function(d) {
                            var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                            if (d) {
                                icon = '<i class="fa fa-check text-success"></i>';
                            }
                            return icon;
                        }
                    },
                    {
                        name: "nda_assessment",
                        data: "nda_assessment",
                        searchable: true,
                        orderable: false,
                        render: function(d) {
                            var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                            if (d) {
                                icon = '<i class="fa fa-check text-success"></i>';
                            }
                            return icon;
                        }
                    },
                    {
                        name: "compliance_assessment",
                        data: "compliance_assessment",
                        searchable: true,
                        orderable: false,
                        render: function(d) {
                            var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                            if (d) {
                                icon = '<i class="fa fa-check text-success"></i>';
                            }
                            return icon;
                        }
                    },

                    {
                        name: "maturity_assessment",
                        data: "maturity_assessment",
                        searchable: true,
                        orderable: false,
                        render: function(d) {
                            var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                            if (d) {
                                icon = '<i class="fa fa-check text-success"></i>';
                            }
                            return icon;
                        }
                    },
                    
                    {
                        name: "answers_count",
                        data: "answers_count",
                        searchable: false,
                        orderable: false,
                        render: function(d) {

                            var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                            if (d > 0) {
                                icon = '<i class="fa fa-check text-success"></i>';
                            }
                            return icon;
                        }
                    },
                    {
                        name: "answer_type",
                        data: "answer_type",
                        searchable: false,
                        sortable: false,
                        orderable: false,
                    },

                    {
                        name: "question",
                        data: "question",
                        render: function(data) {

                            if (data.length > 100) {
                                data = data.slice(0, 100) + ' ...?';
                            }

                            return data;
                        }
                    },
                    {
                        name: "id",
                        data: "id",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let routeUrl = AnswerRoute.replace(':id', row.id);
                            return `<a href="${routeUrl}" class="btn btn-sm plus-custom">
                                       <i class="fa-regular fa-square-plus" style ="font-size:22px ;color:#8cc996"></i>
                                    </a>`;
                        }
                    },

                    {
                        name: "actions",
                        data: "actions"
                    }
                ],
                columnDefs: [

                    {
                        targets: -1,
                        width: "30%"
                    },
                    {
                        targets: -2,
                        width: "50%"
                    }
                ],


            });
            // Add click event listeners to tabs
            $('.tab').on('click', function() {
                _assessment_id = $(this).data("tab"); // Update the assessment ID
                $('.tab').removeClass('active'); // Remove active class from all tabs
                $(this).addClass('active'); // Add active class to the clicked tab

                // Update the displayed assessment details
                let assessmentName = $(this).text();
                $('.AssessmentName').text(assessmentName);

                // Refresh the DataTable with the new assessment ID
                table.ajax.reload();
            });

        });

        var quill_en = new Quill('#question_en', {
            modules: {
                toolbar: '.question_en-toolbar'
            },
            theme: 'snow'
        });
        var quill_ar = new Quill('#question_ar', {
            modules: {
                toolbar: '.question_ar-toolbar'
            },
            theme: 'snow'
        });
        var edit_quill_en = new Quill('#edit_question_en', {
            modules: {
                toolbar: '.edit_question_en-toolbar'
            },
            theme: 'snow'
        });
        var edit_quill_ar = new Quill('#edit_question_ar', {
            modules: {
                toolbar: '.edit_question_ar-toolbar'
            },
            theme: 'snow'
        });


        $('.answer_type').on('change', function() {
            var answer_type = $(this).val();
            // $('.options .mb-1 input[type="checkbox"]').prop('checked', false);
            if (answer_type == 1) {
                $('.controls , .options .mb-1').removeClass('d-none');
            } else if (answer_type == 2) {
                $('.controls').val('').trigger('change');
                $('#ComplianceAssessment, #MaturityAssessment ,#NdaAssessment').prop('checked', false);
                $('.options .mb-1:is(.file_attachment,.question_logic,.risk_assessment)').removeClass('d-none');
                $('.controls ,.options .mb-1:not(.file_attachment,.nda_assessment,.question_logic,.risk_assessment)').addClass(
                    'd-none');

            } else if (answer_type == 3) {
                $('.controls').val('').trigger('change');
                $('#ComplianceAssessment, #MaturityAssessment,#NdaAssessment').prop('checked', false);
                $(".controls ,.options .mb-1:not(.file_attachment)").addClass('d-none');
            }
        });

        /*add new question*/
        $('#add_questions').on('submit', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var question_en = quill_en.getText();
            var question_ar = quill_ar.getText();
            var data = new FormData(this);
            data.append('question_en', question_en);
            data.append('question_ar', question_ar);
            data.append('assessment_id', _assessment_id);
            var valid = true;
            if (quill_en.getLength() == 1) {
                $('.error-question-en').empty().append('Question (EN) is Required').css('display', 'inline-block');
                valid = false;
            } else {
                $('.error-question-en').empty();
            }
            if (quill_ar.getLength() == 1) {
                $('.error-question-ar').empty().append('Question (AR) is Required').css('display', 'inline-block');
                valid = false;
            } else {
                $('.error-question-ar').empty();
            }
            if (!valid) return 0;
            $.ajax({
                processData: false,
                contentType: false,
                cache: false,
                type: "post",
                data: data,
                url: url,
                success: function(response) {
                    makeAlert('success', response);
                    var oTable = $('.QuestionTable').DataTable();
                    oTable.ajax.reload();
                    $('#new-question-modal').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.responseJSON.message) {
                        makeAlert('error', xhr.responseJSON.message);
                    }
                }
            });
        });

        /*edit question*/
        $(document).on('click', '.edit_question_btn', function(e) {
            e.preventDefault();
            // 1- get question data using ajax call
            let url = $(this).data('url');

            $.ajax({
                type: "GET",
                url: url,
                success: function(question) {
                    // 2- render data into form
                    var question_edit_form = $('#edit_question_form');
                    question_edit_form.find('input[name="question_id"]').val(question.id);
                    // Parse description JSON and set in Quill editors
                    let desc = question.question_edit || '{}';
                    let descObj = {};
                    try {
                        descObj = typeof desc === 'string' ? JSON.parse(desc) : desc;
                    } catch (e) {
                        descObj = {
                            en: '',
                            ar: ''
                        };
                    }
                    // Set description in Quill editors
                    edit_quill_en.root.innerHTML = descObj.en || '';
                    edit_quill_ar.root.innerHTML = descObj.ar || '';
                    var controls = $('#edit_question_form select[name="control_id"] option');
                    /* var questions_control = question.control;*/

                    $('#edit_question_form select[name="control_id"] option[value="' + question
                        .control_id + '"]').prop('selected', true);
                    $('#edit_question_form select[name="control_id"]').trigger('change');

                    var answer_types = $('#edit_question_form select[name="answer_type"] option');
                    answer_types.each(function(key, option) {
                        if (question.answer_type == option.value) {
                            $(option).prop('selected', true);
                        }
                    });
                    $('#edit_question_form select[name="answer_type"]').trigger('change');

                    $(question_edit_form).find('select[name="answer_type"]').trigger('change');
                    $(question_edit_form).find('input[name="file_attachment"]').prop('checked', !!
                        question.file_attachment);
                    $(question_edit_form).find('input[name="question_logic"]').prop('checked', !!
                        question.question_logic);
                    $(question_edit_form).find('input[name="risk_assessment"]').prop('checked', !!
                        question.risk_assessment);
                    $(question_edit_form).find('input[name="nda_assessment"]').prop('checked', !!
                        question.nda_assessment);
                    $(question_edit_form).find('input[name="compliance_assessment"]').prop('checked', !!
                        question.compliance_assessment);
                    $(question_edit_form).find('input[name="maturity_assessment"]').prop('checked', !!
                        question.maturity_assessment);

                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message);

                }
            }).then(function() {
                // 3- open edit modal
                $('#edit-question-modal').modal('show')
            })
        });

        /* on submit edit_question_form*/

        $('#edit_question_form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this);
            var question_en = edit_quill_en.getText();
            var question_ar = edit_quill_ar.getText();
            data.append('question_en', question_en);
            data.append('question_ar', question_ar);

            data.append('assessment_id', _assessment_id);
            if (edit_quill_en.getLength() == 1) {
                $('.error-question').empty().append('Question is Required').css('display', 'inline-block');
                return 0;
            }
            if (edit_quill_ar.getLength() == 1) {
                $('.error-question').empty().append('Question is Required').css('display', 'inline-block');
                return 0;
            }
            var question_id = $(this).find('input[name="question_id"]').val();
            var url = $(this).attr('action');
            url = url.replace(':id', question_id);
            $.ajax({
                processData: false,
                contentType: false,
                cache: false,
                type: "Post",
                data: data,
                url: url,
                success: function(response) {
                    makeAlert('success', response);
                    // $('.sideNavBtn.active').trigger('click');
                    var oTable = $('.QuestionTable').DataTable();
                    oTable.ajax.reload();
                    $('#edit-question-modal').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.responseJSON.message) {
                        makeAlert('error', xhr.responseJSON.message);
                    }
                }
            })


        });

        // delete question
        $(document).on('click', '.delete_question_btn', function(e) {
            e.preventDefault();
            var url = $(this).data('url');

            Swal.fire({
                title: swal_title,
                text: swal_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: swal_confirmButtonText,
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            assessment_id: _assessment_id
                        },
                        headers: {
                            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            var message = response.message;
                            makeAlert('success', message, swal_success);
                            // $('.sideNavBtn.active').trigger('click');
                            var oTable = $('.QuestionTable').DataTable();
                            oTable.ajax.reload();
                        },
                        error: function(xhr) {

                        }
                    })
                }
            });


        })
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    {{-- import questions from assessemt --}}
    <script>
        var assesment_edit = null;
        $('#assessment_id').on('change', function(e) {
            assessment_id = $(this).val();
            url = "{{ route('admin.questions.fetch_questions_from_assessment') }}";
            $.ajax({
                type: "GET",
                url,
                data: {
                    assessment_id: assessment_id
                },
                success: function(response) {
                    $('#assessments_questions').empty();
                    $.each(response, function(index, option) {
                        $('#assessments_questions').append('<option value="' + option.id +
                            '">' + option
                            .question + ' </option>');;
                    });
                },
                error: function(xhr) {

                }
            });

        });
        $(".select-all-btn").click(function() {
            $("#assessments_questions").find("option").prop("selected", true);
            $("#assessments_questions").trigger("change");
        });

        $(".unselect-all-btn").click(function() {
            $("#assessments_questions").find("option").prop("selected", false);
            $("#assessments_questions").trigger("change");
        });

        {{--  $('#assessment_id').on('change', function () {
            var assessment_id = $(this).val();
            $('#c option').prop('selected', false);
            $('#assessments_questions option[data-assessment_id="' + assessment_id + '"]').prop('selected', true);
            //  $('#assessments_questions').trigger('change');
        });  --}}
        $('#import_questions').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            data.append('assessment_id', _assessment_id);
            if ($('#assessments_questions').val().length === 0) {
                makeAlert('error', 'Please Select At Least one Question !');
                return;
            }

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function(response) {
                    formReset();
                    $('.modal').modal('hide');
                    table.draw();
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message);
                }
            })
        })
        $(document).ready(function() {
            // Handle change event for the control dropdown
            $('select[name="control_id"]').on('change', function() {
                // Check if a control is selected
                if ($(this).val() !== '') {
                    // Show the hidden divs
                    $('.compliance_assessment, .maturity_assessment').removeClass('hidden');
                } else {
                    // Hide the divs and uncheck the checkboxes
                    $('.compliance_assessment, .maturity_assessment').addClass('hidden');
                    $('.compliance_assessment input, .maturity_assessment input').prop('checked', false);
                }
            });

            // Trigger change event on page load to set initial state
            $('select[name="control_id"]').trigger('change');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');
            const carousel = document.querySelector('.carousel-container');
            const nextBtn = document.querySelector('.next');
            const prevBtn = document.querySelector('.prev');

            let position = 0;


            function updateCarouselWidth() {
                const containerWidth = carousel.parentElement.offsetWidth;
                const contentWidth = carousel.scrollWidth;
                return {
                    containerWidth,
                    contentWidth
                };
            }

            function moveCarousel(direction) {
                const {
                    containerWidth,
                    contentWidth
                } = updateCarouselWidth();
                const step = 150;

                if (direction === 'next') {
                    if (position > -(contentWidth - containerWidth)) {
                        position -= step;
                        position = Math.max(position, -(contentWidth - containerWidth));
                    }
                } else if (direction === 'prev') {
                    if (position < 0) {
                        position += step;
                        position = Math.min(position, 0);
                    }
                }

                carousel.style.transform = `translateX(${position}px)`;
            }

            nextBtn.addEventListener('click', () => moveCarousel('next'));
            prevBtn.addEventListener('click', () => moveCarousel('prev'));


            let touchStartX = 0,
                touchEndX = 0;

            carousel.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            });

            carousel.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchEndX < touchStartX) moveCarousel('next');
                else if (touchEndX > touchStartX) moveCarousel('prev');
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tab");
            const prevButton = document.querySelector(".carousel-button.prev");
            const nextButton = document.querySelector(".carousel-button.next");

            let currentIndex = 0;

            function updateButtons() {
                if (currentIndex === 0) {
                    prevButton.style.color = "#b4a7be";
                } else {
                    prevButton.style.color = "#44235c";
                }

                if (currentIndex === tabs.length - 1) {
                    nextButton.style.color = "#b4a7be";
                } else {
                    nextButton.style.color = "#44235c";
                }
            }

            nextButton.addEventListener("click", function() {
                if (currentIndex < tabs.length - 1) {
                    currentIndex++;
                    updateButtons();
                }
            });

            prevButton.addEventListener("click", function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateButtons();
                }
            });

            updateButtons();
        });
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tab");
            const contents = document.querySelectorAll(".tab-content");

            tabs.forEach(tab => {
                tab.addEventListener("click", function() {

                    tabs.forEach(t => t.classList.remove("active"));
                    this.classList.add("active");

                    contents.forEach(content => content.classList.remove("active"));

                    const targetContent = document.querySelector(`#${this.dataset.tab}`);
                    if (targetContent) {
                        targetContent.classList.add("active");
                    }
                });
            });
        });

        $(document).ready(function() {
            // Initialize variables
            var $searchInput = $('.search-assessment');
            var $carouselContainer = $('.carousel-container');
            var $tabs = $('.sideNavBtn');

            // Function to filter tabs based on search input
            function filterTabs() {
                var filter = $searchInput.val().toLowerCase();

                $tabs.each(function() {
                    var text = $(this).text().toLowerCase();
                    if (text.indexOf(filter) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // If no tabs are visible, show a "No Results" message
                var visibleTabs = $carouselContainer.find('.sideNavBtn:visible').length;
                if (visibleTabs === 0) {
                    // Optionally, display a "No Results" message
                    // For example:
                    // $carouselContainer.append('<p>No templates found.</p>');
                } else {
                    // Remove any "No Results" message if present
                    // $carouselContainer.find('p').remove();
                }
            }

            // Debounce function to improve performance
            function debounce(func, wait) {
                var timeout;
                return function() {
                    var context = this,
                        args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            }

            // Attach the debounced filter function to the input event
            $searchInput.on('input', debounce(filterTabs, 300));

            // Initialize by filtering once on page load
            filterTabs();
        });
    </script>

@endsection
