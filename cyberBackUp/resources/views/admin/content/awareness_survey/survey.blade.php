@extends('admin.layouts.contentLayoutMaster')
@section('title', __('survey.Survey'))
<style>
    .gov_btn {
        border-color: #44225c !important;
        background-color: #44225c !important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
</style>

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />


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
                        <div class="col-sm-6 pe-0 d-flex justify-content-end align-items-center gap-2">
                            @if (auth()->user()->hasPermission('awareness-survey.create'))
                                <button type="button" class="btn btn-primary add-survey" data-bs-toggle="modal"
                                    data-bs-target="#add_survey">
                                    <i class="fa fa-plus"></i>
                                </button>

                                <button type="button" class="dt-button btn btn-primary AddEmailForm"
                                    data-bs-toggle="modal" data-bs-target="#add_email">
                                    <i class="fa fa-envelope"></i>
                                </button>

                                <a href="{{ route('admin.awarness_survey.notificationsSettingsawareness') }}"
                                    class="btn btn-primary">
                                    <i class="fa-regular fa-bell"></i>
                                </a>
                            @endif
                            @if (auth()->user()->hasPermission('awareness-survey.awareness-survey-info'))
                                <a class="btn btn-primary waves-effect waves-float waves-light"
                                    href="{{ route('admin.reporting.awareness_survey_info') }}">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="class="card-datatable"">
            <div class="col-12">
                <div class="card">


                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                        </div>
                    </div>

                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form id="searchForm" class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Title') }}:</label>
                                    <input class="form-control dt-input" data-column="1" data-column-index="1"
                                        type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Description') }}:</label>
                                    <input class="form-control dt-input" data-column="2" data-column-index="2"
                                        type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Status') }}:</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_status"
                                        id="team" data-column="3" data-column-index="3">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-datatable table-responsive ">
                    <table class="dt-advanced-server-search table" id="dataTableREfresh">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>

                                <th class="all">{{ __('locale.Title') }}</th>
                                <th class="all">{{ __('locale.Description') }}</th>
                                                                <th class="all">{{ __('locale.creator') }}</th>
                                <th class="all">{{ __('locale.Status') }}</th>
                                <th class="all">{{ __('locale.CreatedDate') }}</th>
                                <th class="all">{{ __('locale.Actions') }}</th>

                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>

        {{-- add survey --}}
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="add_survey">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('survey.AddNewSurvey') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="add_survey">
                <div class="modal-dialog sidebar-lg" style="width: 350px;"> -->
                    <div class="modal-content p-0">
                        <form id="form-add_control" class="form-add_control todo-modal needs-validation" novalidate
                            method="POST" action="{{ route('admin.awarness_survey.surveyManagement.store') }}">
                            @csrf
                            <!-- <div class="modal-header align-items-center mb-1">
                            <h5 class="modal-title">{{ __('survey.AddNewSurvey') }}</h5>
                            <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                        class="font-medium-2"></i></span>
                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                            </div>
                        </div> -->
                            <input type="hidden" name="created_by">
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                        <input type="text" name="name" class=" form-control" placeholder=""
                                            required />
                                        <span class="error error-name "></span>

                                    </div>
                                    {{-- AdditionalStakeholders --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.AdditionalStakeholders') }}</label>
                                        <select name="additional_stakeholder[]" class="form-select select2"
                                            multiple="multiple">
                                            @foreach ($enabledUsers as $additionalStakeholder)
                                                <option value="{{ $additionalStakeholder->id }}">
                                                    {{ $additionalStakeholder->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-additional_stakeholder"></span>
                                    </div>
                                    {{-- Owner --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.Owner') }}</label>
                                        <select class="select2 form-select" name="owner_id" id="owner_id">
                                            <option value="" selected>{{ __('locale.select-option') }}</option>
                                            @foreach ($enabledUsers as $owner)
                                                <option value="{{ $owner->id }}"
                                                    data-manager="{{ json_encode($owner->manager) }}">
                                                    {{ $owner->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-owner_id"></span>
                                    </div>
                                    {{-- Team --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.Team') }}</label>
                                        <select name="team[]" class="form-select select2" multiple="multiple">
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-team"></span>
                                    </div>
                                    {{-- LastReview --}}
                                    {{-- Last Review --}}
                                    <div class=" mb-1">
                                        <label class="form-label"
                                            for="fp-default">{{ __('locale.LastReview') }}</label>
                                        <input name="last_review_date"
                                            class="form-control flatpickr-date-time-compliance"
                                            placeholder="YYYY-MM-DD" />
                                        <span class="error error-last_review_date "></span>
                                    </div>
                                    <div class="mb-1">
                                        <label for="">{{ __('locale.ReviewFrequency') }}
                                            ({{ __('locale.days') }})</label>
                                        <input type="number" min="0" name="review_frequency"
                                            id="review_frequency" value="0" class="form-control">
                                        <span class="error error-review_frequency"></span>
                                    </div>

                                    <div class="mb-1">
                                        <label for="">{{ __('locale.NextReviewDate') }}</label>
                                        <input type="text" name="next_review_date" placeholder="YYYY-MM-DD "
                                            id="next_review" class="form-control" readonly>
                                        <span class="error error-next_review_date"></span>
                                    </div>
                                    {{-- check_status --}}

                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.Status') }}:</label>
                                        <select class="form-control dt-input dt-select2 select2" name="filter_status"
                                            id="team" data-column="3" data-column-index="2"
                                            onchange="changeStatus(this.value)">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-filter_status"></span>
                                    </div>



                                    {{-- reviwer_Person --}}
                                    <div class="mb-1" id="reviewer">
                                        <label class="form-label ">{{ __('locale.Reviewer') }}</label>
                                        <select name="reviewer[]" class="form-select select2" multiple="multiple">
                                            @foreach ($enabledUsers as $additionalStakeholder)
                                                <option value="{{ $additionalStakeholder->id }}">
                                                    {{ $additionalStakeholder->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-reviewer"></span>
                                    </div>

                                    {{-- Approval Date --}}
                                    <div class="mb-1" id="approval_date_update">
                                        <label for="">{{ __('locale.ApprovalDate') }}</label>
                                        <input type="text" data-i="0" name="approval_date"
                                            placeholder="YYYY-MM-DD "
                                            class="form-control flatpickr-date-time-compliance"
                                            placeholder="YYYY-MM-DD" />
                                        <span class="error error-approval_date"></span>
                                    </div>
                                    {{-- privacy --}}
                                    <div class="mb-1" id="privacy">
                                        <label for="">{{ __('locale.Privacy') }}</label>
                                        <div class="parent_documents_container">
                                            <select name="privacy" class="form-select select2 ">
                                                <option value="" disabled>{{ __('locale.select-option') }}
                                                </option>
                                                @foreach ($privacies as $priv)
                                                    <option value="{{ $priv->id }}">{{ $priv->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="error error-privacy"></span>
                                        </div>
                                    </div>

                                    {{-- description --}}

                                    <div class="mb-1">
                                        <label for="">{{ __('locale.Description') }}</label>
                                        <textarea class="form-control" name="description"></textarea>
                                        <span class="error error-description  "></span>

                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label
                                        for="all_questions_mandatory">{{ __('survey.all_questions_mandatory') }}</label>
                                    <input type="checkbox" id="all_questions_mandatory" checked
                                        name="all_questions_mandatory">
                                    <span class="error error-all_questions_mandatory  "></span>

                                </div>

                                <div class="question_logic d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="percentage_checkbox">{{ __('survey.percentage') }}</label>
                                            <input type="checkbox" id="percentage_checkbox" value="1"
                                                class="checkbox" name="answer_percentage">
                                            <span class="error error-answer_percentage  "></span>

                                        </div>
                                        <div class="col-md-5 d-none percentage_number_div">

                                            <input type="number" class="form-control d-block"
                                                name="percentage_number" placeholder="Percentage Number">
                                            <span class="error error-percentage_number  "></span>

                                        </div>


                                    </div>

                                    {{-- <div class="row">

                                    <div class="col-md-6">
                                        <label for="specific_questions">{{ __('locale.specific_questions') }}</label>
                                        <input type="checkbox" id="specific_questions" value="1" class="checkbox"
                                            name="specific_mandatory_questions">
                                    </div>
                                    <div class="col-md-12 specific_question_div d-none">
                                        <select name="questions[]" id="questions" class="form-select select2 "multiple="multiple">
                                            <option value="" disabled>{{ __('locale.select-option') }}</option>
                                            @foreach ($questions as $question)
                                                <option value="{{ $question->id }}">{{ $question->question }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div> --}}

                                </div>

                            </div>

                            <div class="footer mt-2">
                                <button class="btn btn-primary btn-sm" style="margin-left: 10px;"
                                    type="submit">{{ __('locale.Save') }}</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="modal modal-slide-in sidebar-todo-modal fade" id="add_email">
            <div class="modal-dialog modal-dialog-centered sidebar-lg" style="width: 350px;">
                <div class="modal-content p-0">
                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.AddEmailContent') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                    class="font-medium-2"></i></span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <form id="form-add_mail" method="POST"
                            action="{{ route('admin.configure.mailControl.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="survey_type" id="mail_type">
                            <div class="mb-1">
                                <label class="form-label"
                                    for="exampleFormControlTextarea1">{{ __('locale.Subject') }}:</label>
                                <input class="form-control" name="subject" type="text" id="subject">

                                <span class="error error-subject"></span>
                            </div>
                            <div class="action-tags">
                                <div class="mb-1">
                                    <label for="content">Content:</label>
                                    <div id="quill_editor" style="height: 200px;"></div>
                                    <span class="error error-owner_id"></span>
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="button" class="btn btn-primary btn-sm insert-content me-1"
                                    value="{name}">name</button>
                                <button type="button" class="btn btn-primary btn-sm insert-content"
                                    value="{link}">link</button>
                            </div>
                            <div class="footer mt-2">
                                <button class="btn btn-primary btn-sm"
                                    type="submit">{{ __('locale.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="update_survey" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg"> {{-- wider for form --}}
                <div class="modal-content" id="update_survey_con">
                    {{-- AJAX content will load here --}}
                </div>
            </div>
        </div>
        <!-- Add Exam Modal -->
        <div class="modal fade" id="add-security-awareness-exam" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('survey.AddTheSurvey') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <!-- Question repeater -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="add-security-awareness-exam-form"
                                        action="{{ route('admin.awarness_survey.SurveyQuestion.store') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="survey_id" class="form-control" />

                                        <div class="invoice-repeater">
                                            <div data-repeater-list="questions">
                                                <div data-repeater-item>
                                                    <div class="row d-flex align-items-end">
                                                        <!-- content -->
                                                        <div class="bs-stepper-content shadow-none"
                                                            multiple="multiple">
                                                            <div class="content" role="tabpanel"
                                                                aria-labelledby="create-app-details-trigger">
                                                                <h5 class="question-number"
                                                                    data-title="{{ __('survey.Question') }}">
                                                                    {{ __('survey.Question') }}
                                                                </h5>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="mb-1">
                                                                            <textarea class="form-control" rows="2" name="question"></textarea>
                                                                            <span
                                                                                class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>

                                                                </div>

                                                                <div class="mb-1">
                                                                    <label
                                                                        for="answer_type">{{ __('survey.AnswerType') }}</label>
                                                                    <select id="answer-type" name="answer_type"
                                                                        class="form-control answer_type">
                                                                        <option value="1">
                                                                            {{ __('survey.Multiple Choice ( single-select )') }}
                                                                        </option>
                                                                        <option value="2">
                                                                            {{ __('survey.Multiple Choice ( multiple-select )') }}
                                                                        </option>
                                                                    </select>
                                                                    <span
                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span>
                                                                </div>


                                                                <h5 class="mt-2 pt-1"
                                                                    data-title="{{ __('survey.Question') }} (question_number) {{ __('survey.options') }} ">
                                                                    {{ __('survey.options') }}
                                                                </h5>
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionA"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionA') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionA')]) }}"
                                                                                        name="option_A" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionA')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionB"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionB') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionB')]) }}"
                                                                                        name="option_B" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionB')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionC"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionC') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionC')]) }}"
                                                                                        name="option_C" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionC')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionD"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionD') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionD')]) }}"
                                                                                        name="option_D" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionD')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionE"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionE') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionE')]) }}"
                                                                                        name="option_E" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionE')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                                <span
                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Answer')]) }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 col-12 mb-50">
                                                            <div class="mb-1">
                                                                <button class="btn btn-outline-danger text-nowrap px-1"
                                                                    data-repeater-delete type="button">
                                                                    <i data-feather="x" class="me-25"></i>
                                                                    <span>{{ __('locale.Delete') }}</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-icon btn-primary" data-repeater-create
                                                        type="button">
                                                        <i data-feather="plus" class="me-25"></i>
                                                        <span>{{ __('survey.AddQuestion') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Question repeater -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                        <button type="submit" class="btn btn-primary"
                            form="add-security-awareness-exam-form">{{ __('locale.Add') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('vendor-script')

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const quill = new Quill('#quill_editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'direction': 'rtl'
                        }],
                        ['clean'],
                    ],
                }
            });

            // Fetch existing content when the modal is opened
            $('#add_email').on('show.bs.modal', function() {
                const type = $('#mail_type').val(); // Get the type from the hidden input

                $.ajax({
                    url: "{{ route('admin.configure.mailControl.fetch') }}", // Adjust this route to your needs
                    type: "GET",
                    data: {
                        type: type
                    },
                    success: function(response) {
                        $('#subject').val(response.subject); // Populate the subject input
                        // Assuming response contains the content
                        quill.root.innerHTML = response
                            .content; // Populate Quill editor with existing content
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            });

            // Handle form submission
            $('#form-add_mail').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                const type = $('#mail_type').val();
                const content = quill.root.innerHTML; // Get Quill content
                const subject = $('#subject').val();

                $.ajax({
                    url: "{{ route('admin.configure.mailControl.store') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type,
                        content: content,
                        subject: subject,
                    },
                    success: function(response) {
                        makeAlert('success', '@lang('locale.Mail Created successfully')', 'Success');
                        $('#form-add_mail')[0].reset();
                        quill.setContents([]); // Clear Quill content
                        $('#add_email').modal('hide'); // Hide the modal
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + "\n";
                        });
                        makeAlert('error', errorMessage, 'Error');
                    }
                });
            });

            // Handle button clicks to insert content into Quill
            $('.insert-content').on('click', function() {
                const contentValue = $(this).val(); // Get the value of the clicked button
                const currentContent = quill.root.innerHTML; // Get existing content

                // Check if the current content is empty or not
                const newContent = currentContent.trim() === '' ? contentValue : currentContent + ' ' +
                    contentValue; // Append with a space

                quill.root.innerHTML = newContent; // Set value in Quill
            });

        });
    </script>



    {{-- reset form --}}
    <script>
        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";
        let swal_error = "{{ __('locale.Error') }}";


        $('.select2').select2();

        function resetForm() {
            $('#add_questionnaire form').trigger('reset');
            $('.select2').trigger('change');
        }

        $('#add_questionnaire').on('hidden.bs.modal', function() {
            resetForm();
        });
        $('#all_questions_mandatory').on('change', function() {
            if (!$(this).is(':checked')) {
                $('.question_logic').removeClass('d-none');
            } else {
                $('.question_logic').addClass('d-none');
                $('.question_logic').find('input:checkbox').prop('checked', false);
                $('.question_logic').find('input[name="percentage_number"]').val('');
                $('#questions option:selected').prop('selected', false).trigger('change');
                $('.specific_question_div , .percentage_number_div').addClass('d-none');
            }
        });


        $('#specific_questions').on('change', function() {
            if ($(this).is(":checked")) {
                $('.specific_question_div').removeClass('d-none');
                $('#percentage_checkbox').prop('checked', false).trigger('change')

            } else {
                $('.specific_question_div').addClass('d-none');
                $('#questions option:selected').prop('selected', false).trigger('change');
                if ($('#percentage_checkbox:checked').length == 0) {
                    $('#all_questions_mandatory').prop('checked', true).trigger('change');
                }
            }
        });

        $('#percentage_checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('.percentage_number_div').removeClass('d-none');
                $('#specific_questions').prop('checked', false).trigger('change');

            } else {

                $('input[name="percentage_number"]').val('');
                $('.percentage_number_div').addClass('d-none');
                if ($('#specific_questions:checked').length == 0) {
                    $('#all_questions_mandatory').prop('checked', true).trigger('change');
                }
            }
        });

        $('#assessment_id').on('change', function() {
            $('#questions').empty();
            let questions = $(this).find('option:selected').data('questions');
            var options = '';
            $.each(questions, function(key, val) {
                options += '<option value="' + val.id + '">' + val.question + '</option>';
            });
            $('#questions').append(options);
        });


        function formReset() {
            $('.modal form').trigger('reset');
            $('.modal form select').trigger('change');
            $('#question').addClass('d-none')

        }

        $('.modal').on('hidden.bs.modal', function() {
            $('.question_logic').addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');
            $('#question').addClass('d-none');
            $('.update_questionnaire_modal').removeClass('update_questionnaire_modal');
        });
    </script>
    <script>
        function deletesurvey(id) {
            var id = id;

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
                        type: "GET",
                        url: "{{ route('admin.awarness_survey.awarness-survey.surveyDelete', '') }}" +
                            "/" + id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status) {
                                makeAlert('success', '@lang('survey.Survey Deleted successfully')', 'Success');
                                var oTable = $('#dataTableREfresh').DataTable();
                                oTable.ajax.reload();
                            } else {
                                makeAlert('error', '@lang('survey.An error occurred while deleting the survey it has questions and answers')', 'error');
                            }
                        },
                        error: function() {
                            makeAlert('success', '@lang('survey.Survey Deleted successfully')', 'Success');
                            var oTable = $('#dataTableREfresh').DataTable();
                            oTable.ajax.reload();
                        }
                    })
                }
            });
        }
    </script>
    <script>
        function sendMail(id) {

            var id = id;
            Swal.fire({
                title: "{{ __('assessment.Are You Sure You Want Send Email ?') }}",
                text: swal_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Yes') }}",
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.awarness_survey.awarness-survey.sendMail', '') }}" + "/" +
                            id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            makeAlert('success', '@lang('survey.Survey Send Successfully')', 'Success');

                        },

                        error: function(response) {
                            makeAlert('error', response.responseText, 'Error')
                        }
                    })
                }
            });


        }
    </script>


    {{-- change the next date review  --}}
    <script>
        /* Start change dates event */
        $("[name='last_review_date']").change(function() {
            const that = this;
            var last_review = $(this).val();
            var days = $(this).parent().parent().find("[name='review_frequency']").val();

            if (days != 0) {
                var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last_review;

                $.ajax({
                    url: url,
                    success: function(response) {
                        $(that).parent().parent().find("[name='next_review_date']").val(response);
                    }
                });

            } else {
                $(that).parent().parent().find("[name='next_review_date']").val(last_review);

            }
        });

        $("[name='review_frequency']").change(function() {
            const that = this;
            var days = $(this).val();
            var last = $(this).parent().parent().find("[name='last_review_date']").val();
            var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last;

            $.ajax({
                url: url,
                success: function(response) {
                    $(that).parent().parent().find("[name='next_review_date']").val(response);

                }
            });
        });

        $("[name='review_frequency']").trigger('change');
        /* End change dates event */
    </script>
    {{-- lbarary of date time --}}
    <script>
        dateTimePickr = $('.flatpickr-date-time-compliance');
        // Date & TIme
        if (dateTimePickr.length) {
            dateTimePickr.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
            });
        }
    </script>
    <script>
        $('#add-security-awareness-exam-form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {
                    window.location.reload(true);
                    formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', '@lang('survey.Questions of survey added successfully')', 'Success');
                    // Reload the page after successful insert

                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        switch (key) {
                            case "contacts":
                                key = 'contacts[]'
                                break;
                            case "questions":
                                key = 'questions[]'
                                break;
                        }

                        makeAlert('error', val);
                        let input = $('input[name="' + key + '"] , textarea[name="' + key +
                            '"] , select[name="' + key + '"]')
                        input.addClass('is-invalid');
                    })
                }
            })
        });

        function OpenAddQuestionsForm(surveyId) {
            $('[name="survey_id"]').val(surveyId);
            $('#add-security-awareness-exam').modal('show');
        }
    </script>

    <script>
        $('#approval_date_update').val('').hide();
        $('#privacy').val('').hide();
        $('#reviewer').val('').hide();

        function changeStatus(status) {
            if (status == 2) {
                $('#approval_date_update').val('').hide();
                $('#privacy').val('').hide();
                $('#reviewer').show();
            } else if (status == 3) {

                $('#approval_date_update').show();
                $('#privacy').show();
                $('#reviewer').val('').hide();

            } else {
                $('#approval_date_update').val('').hide();
                $('#privacy').val('').hide();
                $('#reviewer').val('').hide();
            }
        }
    </script>
    {{-- submit of question survey --}}

    <script>
        function sendoutside(id) {
            var encodedId = btoa(id);
            var link = "{{ route('admin.awarness_survey.Examoutside', '') }}" + "/" + encodedId;
            Swal.fire({
                title: "{{ __('survey.Are You Sure To Send Survey Outside cyberMode ?') }}",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Yes') }}",
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    // Create a temporary input element
                    var tempInput = document.createElement("input");
                    // Set the value of the input element to the link
                    tempInput.value = link;
                    // Append the input element to the document
                    document.body.appendChild(tempInput);
                    // Select the text inside the input element
                    tempInput.select();
                    tempInput.setSelectionRange(0, 99999); // For mobile devices
                    // Execute the copy command
                    document.execCommand("copy");
                    // Remove the temporary input element from the document
                    document.body.removeChild(tempInput);
                    // Show success message
                    makeAlert('success', '@lang('survey.Link copied successfully')', 'Success');
                } else {
                    // Show error message
                    makeAlert('error', 'Failed to copy link to clipboard', 'Error');
                }
            });
        }
    </script>

    <script>
        $('#add_survey form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {
                    formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', 'Survey added successfully', 'Success');
                    // location.reload(); // Reload the page immediately
                    var oTable = $('#dataTableREfresh').DataTable();
                    oTable.ajax.reload();
                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        switch (key) {
                            case "contacts":
                                key = 'contacts[]'
                                break;
                            case "questions":
                                key = 'questions[]'
                                break;
                        }

                        makeAlert('error', val);
                        let input = $('input[name="' + key + '"] , textarea[name="' + key +
                            '"] , select[name="' + key + '"]')
                        input.addClass('is-invalid');
                    })
                }
            })
        });


        function getRecord(id) {
            var url = "{{ route('admin.awarness_survey.editmodal', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    if (data.success) {
                        // Load form HTML into modal body
                        $('#update_survey_con').html(data.html);

                        // Show modal
                        var modal = new bootstrap.Modal(document.getElementById('update_survey'));
                        modal.show();

                        // Re-init JS plugins inside modal
                        $('.multiple-select2').select2();
                        $('.flatpickr-date-time-compliance').flatpickr({
                            enableTime: true
                        });
                        feather.replace();
                    }
                },
                error: function() {
                    toastr.error("{{ __('locale.Something went wrong, please try again') }}");
                }
            });
        }



        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };


        $(document).ready(function() {
            // Initialize owner_id select2
            $('#owner_id').select2({
                placeholder: "{{ __('locale.select-option') }}",
                allowClear: true,
                dropdownParent: $('#add_survey')
            });

        });
    </script>


    {{-- fetch data yajra --}}
    <script type="text/javascript">
        $(function() {

            var table = $('#dataTableREfresh').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.awarness_survey.getDataSurvey') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}" // Laravel CSRF token
                    }
                },
                language: {
                    "sProcessing": "{{ __('locale.Processing') }}",
                    "sSearch": "{{ __('locale.Search') }}",
                    "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                    "sInfo": "{{ __('locale.info') }}",
                    "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                    "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
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
                        data: null,
                        name: 'row_index',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data) {
                            return '<span class="badge rounded-pill badge-light-primary">' + data +
                                '</span>';
                        }
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'creator_name', // ✅ new column
                        name: 'creator_name'
                    },

                    {
                        data: 'filter_status',
                        name: 'filter_status',
                        render: function(data, type, row) {
                            if (row.filter_status === 1) {
                                return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.Draft') }}</span>';
                            } else if (row.filter_status === 2) {
                                return '<span class="badge rounded-pill badge-light-warning">{{ __('locale.InReview') }}</span>';
                            } else if (row.filter_status === 3 && row.privacy === 1) {
                                return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }} ({{ __('locale.Private') }})</span>';
                            } else if (row.filter_status === 3 && row.privacy === 2) {
                                return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }} ({{ __('locale.Public') }})</span>';
                            }
                            return '';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            if (data) {
                                let date = new Date(data);
                                return date.toLocaleDateString('en-GB'); // DD/MM/YYYY
                            }
                            return '';
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],


            });

            // search box
            $('.dt-input').on('keyup', function() {
                table
                    .columns($(this).data('column'))
                    .search(this.value)
                    .draw();
            });

            // filter by status
            $('.dt-select').on('change', function() {
                var value = $(this).val();
                table
                    .columns($(this).data('column'))
                    .search(value ? '^' + value + '$' : '', true, false)
                    .draw();
            });
        });
    </script>

@endsection
