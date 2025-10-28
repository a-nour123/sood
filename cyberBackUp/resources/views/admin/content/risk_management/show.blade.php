@extends('admin/layouts/contentLayoutMaster')

@section('title', __('risk.ViewRisk'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @media (max-width: 576px) {
            .text-sm-only-center {
                text-align: center
            }



        }

        .basic-wizard .stepper-horizontal {
            overflow: hidden !important;
        }

        .text-label {
            font-size: 1.1rem;
            font-weight: 900;
        }


        .cursor-pointer {
            cursor: pointer;
        }

        #impact-detail-btn svg,
        #likelihood-detail-btn svg,
        .delete_supporting_documentation svg {
            width: 25px;
            height: 25px;
        }

        .highcharts-credits {
            display: none;
        }

        #editRiskModal .modal-row>div {
            position: initial !important;
        }

        <style>.nav-pills {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .main-color {
            color: #44225c;

        }

        .nav-pills .nav-item {
            flex: 1;
            text-align: center;
            background-color: #f2f2f2;
            border-inline: 1px solid white;
        }

        .feather,
        [data-feather] {
            height: 1.5rem;
            width: 1.5rem;
        }

        .nav-pills .nav-link {
            width: 100%;
            border-radius: 0;


        }

        .container-tab {

            margin: 25px 1px 10px;
            border-radius: 10px;
        }


        .dropdown-toggle::after {

            vertical-align: 0px !important;
            margin-inline: 7px
        }

        .custom-span {
            padding: 0px 8px;
            font-size: 9px;
            font-weight: 800;
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .span-red {
            color: #c96f62;
            border: 1px solid #c96f62;
            background: #fff2ea;
        }

        .span-yellow {
            color: #ebc204;
            border: 1px solid #ebc204;
            background: #fcf9f8;
            margin-left: 0.5rem;
        }

        .custom-span::before {
            content: "•";
            color: currentColor;
            font-size: 14px;
            margin-right: 5px;
            display: inline-block;
        }

        .custom-p {
            color: #44225c;
            font-weight: 900;
            font-size: 18px;
        }

        .card.risk-session {
            padding: 14px;
        }

        .nav-link:hover {
            color: #44225c !important;
        }

        .nav-link.active:hover {
            color: #fff !important;
        }

        .accordion-button {
            background: #44225c !important;
            color: #fff !important;
            border: none;
        }

        .fas.fa-chevron-down {
            right: 0;
            margin-inline: 20px
        }

        .accordion-button:not(.collapsed) {
            background: #44225c !important;
            color: #fff !important;
            box-shadow: none;
        }

        .accordion-button:focus,
        .accordion-button:hover {
            background: #44225c !important;
            color: #fff !important;
            box-shadow: none;
        }

        .nav-pills .nav-link {
            padding: 0.786rem 1.5rem;
            font-size: 1rem;
            line-height: 1rem;
            border: 1px solid transparent;
            color: #5e5873;
            height: 75px;
        }

        .nav-pills .nav-link {

            height: 50px;
        }

        /* Rotate the icon when the accordion is expanded */
        .accordion-button:not(.collapsed) #chevronIcon {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
            /* Smooth transition */
        }

        /* Default state (collapsed) */
        /* Default state: Icon is up (collapsed) */
        #chevronIcon {
            transform: rotate(180deg);
            /* Rotate up by default */
            transition: transform 0.3s ease;
            /* Smooth transition */
        }

        /* Expanded state: Icon is down */
        .accordion-button:not(.collapsed) #chevronIcon {
            transform: rotate(0deg);
            /* Rotate down when expanded */
        }

        /* Ensure the icon is positioned at the end of the button */
        .accordion-button {
            position: relative;
            /* Required for absolute positioning of the icon */
        }

        #chevronIcon {
            position: absolute;
            /* Position the icon at the end */
            right: 1rem;
            /* Adjust spacing from the right */
        }

        .ql-toolbar.ql-snow+.ql-container.ql-snow {
            border-top: 0px;
            height: 150px;
        }

        .btn-green {
            background-color: #03781d !important;
            border-color: #03781d !important;
            color: #fff !important;
        }

        .ql-toolbar.ql-snow {
            width: 600px;
        }

        .ql-toolbar.ql-snow+.ql-container.ql-snow {

            width: 600px;
        }

        .badge-step {
            background-color: #c30c0c;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;


        }

        .bg-custom {
            background: #f2f2f2;
            padding: 12px;
        }

        .rounded-p {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            color: #93312b;
            background: #fff2ea;
            font-weight: 800;
            margin: 0 !important;
        }

        @media (max-width: 768px) {
            .nav-pills .nav-link {
                height: 70px;
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
    <!-- start tab -->
    <div class="container-tab">
        <div class="row">
            <div class="col-12">
                <div class=" risk-session">
                    <!-- start tab -->
                    <div class="card p-4">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item mb-2 mb-md-0" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Risk Identification</button>
                            </li>
                            <li class="nav-item mb-2 mb-md-0" role="presentation">
                                <button class="nav-link" id="pills-analysis-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-analysis" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Risk Analysis</button>
                            </li>

                            <li class="nav-item mb-2 mb-md-0" role="presentation">
                                <button class="nav-link" id="pills-evalution-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-evalution" type="button" role="tab"
                                    aria-controls="pills-evalution" aria-selected="false">Risk Evaluation and
                                    Treatment</button>
                            </li>
                            <li class="nav-item mb-2 mb-md-0" role="presentation">
                                <button class="nav-link" id="pills-review-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-review" type="button" role="tab"
                                    aria-controls="pills-review" aria-selected="false">Risk Reviewing and
                                    Monitoring</button>
                            </li>
                            <li class="nav-item mb-2 mb-md-0" role="presentation">

                                <button class="nav-link" id="pills-comment-trail-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-comment-trail" type="button" role="tab"
                                    aria-controls="pills-comment-trail" aria-selected="false">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="badge-step d-flex justify-content-center align-items-center mb-0">
                                            {{ count($data['comments']) }}</p>
                                        <p class="mb-0 ms-2">Comment and Trail</p>
                                    </div>
                                </button>
                            </li>
                        </ul>
                        <div class="row align-items-center">
                            <!-- Left Side: ID, Subject, Status -->
                            <div class="col-12 col-md-7 col-lg-8 d-flex justify-content-start align-items-center">
                                <div class="col-2 col-lg-4">ID #: {{ __($data['id']) }}</div>
                                <div class="col-4 col-lg-4">Subject: {{ $data['subject'] }}</div>
                                <div class="col-6 col-lg-4">
                                    Status:
                                    <span class="custom-span span-red rounded-pill">{{ __($data['status']) }}</span>
                                </div>
                            </div>

                            <!-- Right Side: Edit Subject, Change Status Button, Dropdown -->
                            <div class="col-12 col-md-5 col-lg-4 d-flex justify-content-end align-items-center">
                                <!-- Edit Subject Icon and Form -->
                                @if (auth()->user()->hasPermission('riskmanagement.update'))
                                    {{-- <span id="edit-subject" class="display-9 me-2" style="cursor: pointer">
                                        <i data-feather="edit" style="width: 20px; color: #44225c; height: 20px;"></i>
                                    </span> --}}
                                    <form id="edit-subject-form" method="post" action="/" class="px-0 d-none"
                                        id="edit-subject-container">
                                        @csrf
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <input type="text" class="form-control"
                                                    value="{{ $data['subject'] }}" name="subject">
                                                <span class="error error-subject"></span>
                                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                            </div>
                                            <div class="col-4">
                                                <button id="cancel-edit-subject" class="btn btn-danger btn-sm"
                                                    type="button">
                                                    {{ __('locale.Cancel') }}
                                                </button>
                                                <button id="submit-edit-subject" class="btn btn-success btn-sm"
                                                    type="button">
                                                    {{ __('locale.Submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                <!-- Change Status Button -->
                                <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#changeRiskStatusModal">
                                    Change Status
                                </button>


                                <!-- Actions Dropdown -->
                                <div class="btn-group">
                                    <select class="form-control dt-input dt-select select20" id="risk-actions"
                                        data-column="3" data-column-index="2" data-id="{{ $data['id'] }}">
                                        <option class="step-default-option" selected value="">{{ __('locale.Actions') }}
                                        </option>
                                        @if ($data['status'] == 'Closed')
                                            <option class="step-1-option" value="ReopenRisk" style="display: none;">
                                                {{ __('risk.ReopenRisk') }}</option>
                                        @else
                                            @if (auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
                                                <option class="step-1-option" value="CloseRisk"
                                                    style="display: none;">{{ __('risk.CloseRisk') }}</option>
                                            @endif
                                        @endif
                                        @if (auth()->user()->hasPermission('riskmanagement.update'))
                                            <option class="step-1-option" value="EditRisk" style="display: none;">
                                                {{ __('risk.EditRisk') }}</option>
                                        @endif
                                        @if (auth()->user()->hasPermission('riskmanagement.update'))
                                            <option class="step-2-option" value="EditRisk2" style="display: none;">
                                                {{ __('risk.EditRisk') }}</option>
                                        @endif

                                        {{-- <option class="step-1-option" value="ChangeStatus" style="display: none;">
                                            {{ __('locale.ChangeStatus') }}</option> --}}
                                        @if (auth()->user()->hasPermission('plan_mitigation.create'))
                                            <option class="step-3-option" value="ResetMitigations"
                                                style="display: none;">{{ __('risk.ResetMitigations') }}</option>
                                        @endif
                                        @if (auth()->user()->hasPermission('perform_reviews.create'))
                                            <option class="step-4-option" value="PerformAReview"
                                                style="display: none;">{{ __('risk.PerformAReview') }}</option>
                                            <option class="step-4-option" value="ResetReviews"
                                                style="display: none;">{{ __('risk.ResetReviews') }}</option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- step 1 -->
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">



                            <!-- cards -->
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-12 col-md-4">
                                        <div class="card">
                                            <div class="d-flex justify-content-evenly align-items-center"
                                                style="font-size: 1rem">
                                                {{-- InherentRisk --}}
                                                <div class="text-black bg-blue-90 col-5 row mx-0 my-4 px-0 py-2 justify-content-center align-items-center text-center"
                                                    style="background-color:#fff2ea; height:110px">
                                                    <p class="m-0 p-0"><i data-feather="alert-triangle"></i> </p>
                                                    <p class="m-0 p-0">{{ __('risk.InherentRisk') }}</p>
                                                    <p class="m-0 p-0" id="inherent_risk_score">
                                                        {{ $data['calculated_risk'] }}
                                                    </p>
                                                    <p class="m-0 p-0" style="color:#ea6155">
                                                        {{ $data['calculated_risk_data']['name'] }}
                                                    </p>
                                                </div>
                                                {{-- ResidualRisk --}}
                                                <div class="text-black col-5 row mx-0 px-0 py-2 my-4 justify-content-center align-items-center text-center"
                                                    style="background-color: #ecfdf3; height:110px">
                                                    <p class="m-0 p-0"><i data-feather="check-circle"></i> </p>
                                                    <p class="m-0 p-0">{{ __('risk.ResidualRisk') }}</p>
                                                    <p class="m-0 p-0" id="residual_risk_score">
                                                        {{ $data['residual_risk'] }}
                                                    </p>
                                                    <p class="m-0 p-0" style="color:#1bb573">
                                                        {{ $data['residual_risk_data']['name'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <div class="card p-4">
                                            <div class="d-flex justify-content-between">
                                                <p class="custom-p">Classic Risk Scoring</p>
                                                <div>
                                                    @if (auth()->user()->hasPermission('riskmanagement.update'))
                                                        <span id="UpdateClassicScoreShowBtn" class="display-9"
                                                            style="cursor: pointer">
                                                            <i data-feather="edit"
                                                                style="width: 20px; color: #44225c; height: 20px;"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mt-3">
                                                <div class="custom-div me-5">
                                                    Impact:
                                                    <span class="custom-span rounded-pill span-yellow">
                                                        [{{ $data['impact']['id'] }}] {{ $data['impact']['name'] }}
                                                    </span>
                                                </div>
                                                <div>
                                                    {{ __('risk.Likelihood') }}: [{{ $data['likelihood']['id'] }}]
                                                    {{ $data['likelihood']['name'] }}
                                                </div>
                                            </div>
                                            <p class="fw-bolder mt-3 mb-0  ">
                                                @if (get_setting('risk_model') == 1)
                                                    {{ __('locale.RISKClassicExp1') . ' x ( 10 / 35 ) = ' . $data['calculated_risk'] }}
                                                @elseif (get_setting('risk_model') == 2)
                                                    {{ __('locale.RISKClassicExp2') . ' x ( 10 / 30 ) = ' . $data['calculated_risk'] }}
                                                @elseif (get_setting('risk_model') == 3)
                                                    {{ __('locale.RISKClassicExp3') . ' x ( 10 / 25 ) = ' . $data['calculated_risk'] }}
                                                @elseif (get_setting('risk_model') == 4)
                                                    {{ __('locale.RISKClassicExp4') . ' x ( 10 / 30 ) = ' . $data['calculated_risk'] }}
                                                @elseif (get_setting('risk_model') == 5)
                                                    {{ __('locale.RISKClassicExp5') . ' x ( 10 / 35 ) = ' . $data['calculated_risk'] }}
                                                @endif
                                            </p>
                                        </div>


                                        <!-- Form for Updating Risk Scoring -->
                                        @if (auth()->user()->hasPermission('riskmanagement.update'))
                                            <form class="row px-0" id="edit-risk-scoring-form" method="post"
                                                action="/" style="display: none">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                                <div class="row mx-0">
                                                    <div class="col-12 col-md-6 mb-1">
                                                        {{-- Current Likelihood --}}
                                                        <div class="mb-1 row">
                                                            <div class="col-11">
                                                                <label
                                                                    class="form-label">{{ __('risk.CurrentLikelihood') }}</label>
                                                                <select class="select2 form-select d-inline"
                                                                    name="current_likelihood_id">
                                                                    <option value="" disabled hidden selected>
                                                                        {{ __('locale.select-option') }}
                                                                    </option>
                                                                    @foreach ($riskLikelihoods as $riskLikelihood)
                                                                        <option value="{{ $riskLikelihood->id }}"
                                                                            {{ $data['likelihood']['id'] == $riskLikelihood->id ? 'selected' : '' }}>
                                                                            {{ $riskLikelihood->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div id="likelihood-detail-btn"
                                                                class="col-1 cursor-pointer"
                                                                style="margin-top: 2.2rem !important;">
                                                                <i data-feather='info' class="text-danger"></i>
                                                            </div>
                                                            <span class="error error-current_likelihood_id"></span>
                                                        </div>
                                                        {{-- Current Impact --}}
                                                        <div class="mb-1 row">
                                                            <div class="col-11">
                                                                <label
                                                                    class="form-label">{{ __('risk.CurrentImpact') }}</label>
                                                                <select class="select2 form-select"
                                                                    name="current_impact_id">
                                                                    <option value="" disabled hidden selected>
                                                                        {{ __('locale.select-option') }}
                                                                    </option>
                                                                    @foreach ($impacts as $impact)
                                                                        <option value="{{ $impact->id }}"
                                                                            {{ $data['impact']['id'] == $impact->id ? 'selected' : '' }}>
                                                                            {{ $impact->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div id="impact-detail-btn" class="col-1 cursor-pointer"
                                                                style="margin-top: 2.2rem !important;">
                                                                <i data-feather='info' class="text-danger"></i>
                                                            </div>
                                                            <span class="error error-current_impact_id"></span>
                                                        </div>
                                                        <button id="update-edit-risk-scoring" type="button"
                                                            class="btn btn-success me-1">{{ __('locale.Update') }}</button>
                                                        <button id="cancel-edit-risk-scoring"
                                                            class="button btn btn-danger"
                                                            type="button">{{ __('locale.Cancel') }}</button>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <div id="impact-detail" style="display: none">
                                                            <!-- Impact details here -->
                                                        </div>
                                                        <div id="likelihood-detail" style="display: none">
                                                            <!-- Likelihood details here -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- start accordion -->
                            <div class="accordion mb-5" id="accordionExample">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne"
                                            id="RiskScoreOverTimeBtn">
                                            Risk Scoring History
                                            <i id="chevronIcon"
                                                class="fas fa-chevron-down ms-2 position-absolute end-0"></i>
                                            <!-- Icon for toggle -->
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <!-- Placeholder for dynamically loaded content -->
                                            <div id="RiskScoreOverTime">
                                                <!-- Content will be loaded here dynamically -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Other Information
                                            <i class="fas fa-chevron-down position-absolute "
                                                style="transform: rotate(180deg); "></i>
                                            <!-- أيقونة متغيرة في الوضعية -->
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <!-- First Column -->
                                                <div class="col-12 col-md-4">
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Risk Mapping:</p>
                                                        <ul style="list-style: disc; padding-left: 20px;">
                                                            @foreach ($data['riskCatalogs']  as $riskCatalogs)
                                                            <span
                                                                class="badge bg-secondary">{{ $riskCatalogs['name'] }}</span>
                                                             @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Site/Location:</p>
                                                        <p class="mb-1">
                                                            @foreach ($data['locations'] as $location)
                                                                <span
                                                                class="badge bg-secondary">{{ $location['name'] }}</span>
                                                            @endforeach
                                                         </p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Owner:</p>
                                                        <p class="mb-1">{{ $data['owner']['name'] ?? 'N/A' }}</p>
                                                    </div>
                                                </div>

                                                <!-- Second Column -->
                                                <div class="col-12 col-md-4">
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Threat Mapping:</p>
                                                        <ul style="list-style: disc; padding-left: 20px;">
                                                            @foreach ($data['threatCatalogs']  as $threatCatalog)
                                                            <span
                                                                class="badge bg-secondary">{{ $threatCatalog['name'] }}</span>
                                                             @endforeach
                                                         </ul>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Team:</p>
                                                        <p class="mb-1">
                                                            @php
                                                                $selectedTeams = [];
                                                                if (isset($data['team_ids'])) {
                                                                    foreach ($teams as $team) {
                                                                        if (in_array($team->id, $data['team_ids'])) {
                                                                            $selectedTeams[] = $team->name;
                                                                        }
                                                                    }
                                                                }
                                                                echo !empty($selectedTeams)
                                                                    ? implode(', ', $selectedTeams)
                                                                    : 'N/A';
                                                            @endphp
                                                        </p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Additional Stakeholders:</p>
                                                        <p class="mb-1">
                                                            @if (isset($data['additionalStakeholder_ids']) && count($enabledUsers) > 0)
                                                                @php
                                                                    $selectedStakeholders = [];
                                                                    foreach ($enabledUsers as $additionalStakeholder) {
                                                                        if (
                                                                            in_array(
                                                                                $additionalStakeholder->id,
                                                                                $data['additionalStakeholder_ids'],
                                                                            )
                                                                        ) {
                                                                            $selectedStakeholders[] =
                                                                                $additionalStakeholder->name;
                                                                        }
                                                                    }
                                                                    echo implode(', ', $selectedStakeholders);
                                                                @endphp
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Third Column -->
                                                <div class="col-12 col-md-4">
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Category:</p>
                                                        <p class="mb-1">{{ $data['category']['name'] ?? 'N/A' }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-1 main-color">Owner's Manager:</p>
                                                        <p class="mb-1">
                                                            {{ $data['owner_manager']['name'] ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Status Modal -->
                        <div class="modal fade" id="changeRiskStatusModal" tabindex="-1"
                            aria-labelledby="changeRiskStatusModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="changeRiskStatusModalLabel">
                                            {{ __('locale.SetRiskStatusTo') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row px-0" id="change-risk-status-form" method="post"
                                            action="{{ route('admin.risk_management.ajax.update') }}">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                                            <div class="col-12">
                                                <select class="select2 form-select" name="status">
                                                    <option value="" selected>{{ __('locale.select-option') }}
                                                    </option>
                                                    @foreach ($statuses as $status)
                                                        @if ($status->name == 'Closed')
                                                            @if (auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
                                                                <option value="{{ $status->id }}">
                                                                    {{ __('risk.CloseRisk') }}
                                                                </option>
                                                            @endif
                                                        @else
                                                            <option value="{{ $status->id }}">{{ $status->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="error error-status"></span>
                                            </div>
                                            <div class="col-12 text-center mt-2">
                                                <button id="submit-change-risk-status" type="button"
                                                    class="btn btn-primary me-1">
                                                    {{ __('locale.Update') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-analysis" role="tabpanel"
                            aria-labelledby="pills-analysis-tab">

                            <!-- Content for Step 2 -->
                            <section id="basic-tabs-components-step2" class="main-containers-step2">
                                <div class="row match-height">
                                    <!-- Basic Tabs starts -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    {{-- Details tab --}}
                                                    <div class="tab-pane active" id="details"
                                                        aria-labelledby="details-tab" role="tabpanel">
                                                        <div class="row" id="static-details">

                                                            <!-- Submitted By -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __('locale.SubmittedBy') }}</label>
                                                                :
                                                                {{ $data['submitted_by']['name'] ?? '' }}
                                                            </div>

                                                            <!-- Risk Source -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __('risk.ImpactScope') }}</label>
                                                                :
                                                                {{ $data['source']['name'] ?? '' }}
                                                            </div>
                                                            <!-- Current Likelihood -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __('risk.CurrentLikelihood') }}</label>
                                                                :
                                                                {{ $data['likelihood']['name'] ?? '' }}
                                                            </div>
                                                            <!-- Current Impact -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __('risk.CurrentImpact') }}</label>
                                                                :
                                                                {{ $data['impact']['name'] ?? '' }}
                                                            </div>
                                                            <!-- Risk Scoring Method -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __('risk.RiskScoringMethod') }}</label>
                                                                :
                                                                {{ $data['risk_scoring']['name'] ?? '' }}
                                                            </div>





                                                            <!-- Risk Assessment -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __('risk.ResponsiblePart') }}</label>
                                                                :
                                                                <div style="max-height: 100px; overflow: auto;">
                                                                    {{ $data['assessment'] }}
                                                                </div>
                                                            </div>

                                                            <!-- Additional Notes -->
                                                            <div class="col-12 col-md-6 mb-1">
                                                                <label
                                                                    class="text-label">{{ __("locale.KRI'S") }}:</label>
                                                                <div id="risk_addational_notes_show">
                                                                    {!! $data['notes'] !!}
                                                                </div>
                                                            </div>

                                                            <!-- Supporting Documentation -->
                                                            <div
                                                                class="col-12 col-md-6 mb-1 supporting_documentation_container">
                                                                <label
                                                                    class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                                                :
                                                                @forelse($data['files'] ?? [] as $file)
                                                                    <span
                                                                        class="badge bg-secondary supporting_documentation cursor-pointer"
                                                                        style="margin-bottom: 5px"
                                                                        data-id="{{ $file['id'] }}"
                                                                        data-risk-id="{{ $data['id'] }}">{{ $file['name'] }}</span>
                                                                @empty
                                                                    <span
                                                                        class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                                                @endforelse
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-1">
                                        <label
                                                                    class="text-label">{{ __("locale.Description") }}:</label>
                                        <div id="risk_description_editor" >
                                             {!! $data['risk_description'] !!}
                                        </div>
                                    </div>
                                    <input type="hidden" name="risk_description_hidden" id="risk_description_hidden">


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </section>
                            <!-- Basic Tabs end -->
                        </div>
                        <div class="tab-pane fade" id="pills-evalution" role="tabpanel"
                            aria-labelledby="pills-evalution-tab">

                            <!-- Content for Step 3 -->
                            <div class="tab-pane" id="mitigation" aria-labelledby="mitigation-tab" role="tabpanel">
                                <div class="card row p-4" id="static-mitigation">
                                    <div class="d-flex justify-content-end align-items-center mb-2">
                                        @if (auth()->user()->hasPermission('plan_mitigation.create'))


                                            <button id="edit-mitigation" type="button"
                                                class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editMitigationModal">
                                                {{ __('locale.EditMitigation') }}
                                            </button>


                                        @endif
                                        @if ($data['mitigation']['mitigation_id'])
                                            @if ($data['mitigation']['user_accepted_mitigations'])
                                                <button id="accept-mitigation" type="button"
                                                    class="btn btn-danger ms-2 acceptOrRejectStatus" data-value='0'
                                                    data-id="{{ $data['id'] }}">
                                                    {{ __('risk.RejectMitigation') }}</button>
                                            @else
                                                <button id="reject-mitigation" type="button"
                                                    class="btn btn-green ms-2 acceptOrRejectStatus" data-value='1'
                                                    data-id="{{ $data['id'] }}">
                                                    {{ __('risk.AcceptMitigation') }}</button>
                                            @endif
                                        @endif

                                    </div>
                                    <div class="row py-2 " style="background-color: #f2f2f2;">
                                        {{-- Mitigation Date --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationDate') }}</label>
                                            :
                                            {{ format_date($data['mitigation']['mitigation_date'], 'N/A') }}
                                        </div>
                                        {{-- Mitigation Planning Date --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationPlanning') }}</label>
                                            :
                                            {{ $data['mitigation']['planning_date'] ?? '' }}
                                        </div>
                                        {{-- Planning Strategy --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.PlanningStrategy') }}</label>
                                            :
                                            {{ $data['mitigation']['planning_strategy'] ?? '' }}
                                        </div>
                                        {{-- Mitigation Effort --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationEffort') }}</label>
                                            :
                                            {{ $data['mitigation']['mitigation_effort'] ?? '' }}
                                        </div>
                                        {{-- MitigationCost --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationCost') }}</label>
                                            :
                                            {{ $data['mitigation']['mitigation_cost'] ?? '' }}
                                        </div>
                                        {{-- Mitigation Owner --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationOwner') }}</label> :
                                            {{ $data['mitigation']['mitigation_owner'] ?? '' }}
                                        </div>
                                        {{-- Mitigation Team --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationTeam') }}</label>
                                            :
                                            @foreach ($data['mitigation']['mitigation_team'] as $team)
                                                <span class="badge bg-secondary">{{ $team['name'] }}</span>
                                            @endforeach
                                        </div>
                                        {{-- Mitigation Percent --}}
                                        <div class="mb-1 col-md-6">
                                            <label class="text-label">{{ __('risk.MitigationPercent') }}</label>
                                            :
                                            {{ (isset($data['mitigation']['mitigation_percent']) && $data['mitigation']['mitigation_percent'] >= 0 && $data['mitigation']['mitigation_percent'] <= 100 ? $data['mitigation']['mitigation_percent'] : 0) . ' %' }}
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            {{-- Security Requirements --}}
                                            <div class="mb-1 col-md-6">
                                                <label
                                                    class="text-label">{{ __('risk.SecurityRequirements') }}</label>
                                                :
                                                <div style="max-height: 100px;   overflow: auto;">
                                                    {{ $data['mitigation']['security_requirements'] ?? '' }}
                                                </div>
                                            </div>
                                            {{-- Security Recommendations --}}
                                            <div class="mb-1 col-md-6">
                                                <label
                                                    class="text-label">{{ __('risk.SecurityRecommendations') }}</label>
                                                :
                                                <div style="max-height: 100px;   overflow: auto;">
                                                    {{ $data['mitigation']['security_recommendations'] ?? '' }}
                                                </div>
                                            </div>
                                            {{-- Supporting Documentation --}}
                                            <div class="mb-1 col-md-6">
                                                <label
                                                    class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                                :
                                                @forelse($data['mitigation']['files'] ?? [] as $files)
                                                    <span class="badge bg-secondary">{{ $files['name'] }}</span>
                                                @empty
                                                    <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                                @endforelse

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            {{-- Current Solution --}}
                                            <div class="mb-1" style="width:300px">
                                                <label class="text-label">{{ __('risk.CurrentSolution') }}</label>
                                                <div id="risk_current_solution_show">
                                                    {!! $data['mitigation']['current_solution'] !!}
                                                </div>
                                            </div>
                                            {{-- <div class="mb-1">
                                                <label class="text-label">{{ __('risk.CurrentSolution') }}</label> :
                                                <div style="max-height: 100px;   overflow: auto;">
                                                    {{ $data['mitigation']['current_solution'] ?? '' }}
                                                </div>
                                            </div> --}}

                                        </div>
                                    </div>
                                </div>
                                {{-- Accept Mitigation --}}
                                @if (auth()->user()->hasPermission('plan_mitigation.accept'))
                                    <div class="mb-1">
                                        <di class="card mb-0">
                                            <div class="card-body p-0">
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($data['mitigation']['accepted_mitigations'] as $accepted_mitigation)
                                                        <li class="list-group-item">
                                                            {{ __('risk.MitigationAcceptedByUserOnTime', ['name' => $accepted_mitigation['name'], 'date' => $accepted_mitigation['date'], 'time' => $accepted_mitigation['time']]) }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>


                                    </div>
                                @endif
                                <!-- Reset Risk Mitigations Section -->
                                <section class="d-none" id="reset-risk-mitigations-container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="col-12 text-center">
                                                        <button id="submit-reset-risk-mitigations" type="button"
                                                            class="btn btn-primary me-1"
                                                            data-id="{{ $data['id'] }}">
                                                            {{ __('risk.ResetMitigations') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>


                        </div>

                        <div class="tab-pane fade" id="pills-review" role="tabpanel"
                            aria-labelledby="pills-review-tab">
                            <div class="row" id="static-review">
                                <!-- Reviews Accordion -->
                                <div class="accordion mb-5" id="reviewsAccordion">
                                    <!-- Last Review Section -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#lastReviewCollapse"
                                                aria-expanded="false">
                                                {{ __('locale.LastReview') }}
                                                <i class="fas fa-chevron-down ms-2 position-absolute end-0"></i>
                                            </button>
                                        </h2>
                                        <div id="lastReviewCollapse" class="accordion-collapse collapse"
                                            data-bs-parent="#reviewsAccordion">
                                            <div class="accordion-body">
                                                @php
                                                    $latestReview = end($data['mgmtReviews']);
                                                @endphp

                                                @if ($latestReview)
                                                    <div class="row p-2 m-4" style="background: #f2f2f2">
                                                        <div class="col-md-6 mb-1 rounded">Review Date: <span
                                                                class="fw-bolder">{{ $latestReview['review_date'] }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-1 rounded">Reviewer: <span
                                                                class="fw-bolder">{{ $latestReview['reviewer'] }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-1 rounded">Review: <span
                                                                class="fw-bolder">{{ $latestReview['review'] }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- All Reviews Section -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#allReviewsCollapse"
                                                aria-expanded="false">
                                                {{ __('locale.ViewAllReview') }}
                                                <i class="fas fa-chevron-down ms-2 position-absolute end-0"></i>
                                            </button>
                                        </h2>
                                        <div id="allReviewsCollapse" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                @foreach ($data['mgmtReviews'] as $review)
                                                    <div class="row p-2 m-4" style="background: #f2f2f2">
                                                        <div class="col-md-6 mb-1 rouded">Review Date:<span
                                                                class="fw-bolder">{{ $review['review_date'] }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-1 rouded">Reviewer: <span
                                                                class="fw-bolder">{{ $review['reviewer'] }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-1 rouded">Review: <span
                                                                class="fw-bolder">{{ $review['review'] }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <!-- Reset Reviews Section -->
                                <section class="d-none" id="reset-risk-reviews-container">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <button type="button" id="submit-reset-risk-reviews"
                                                class="btn btn-primary" data-id="{{ $data['id'] }}">
                                                {{ __('risk.ResetReviews') }}
                                            </button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-comment-trail" role="tabpanel"
                            aria-labelledby="pills-comment-trail-tab">
                            <!-- start accordion -->
                            <div class="accordion mb-5" id="accordionExample">
                                <!-- Comments Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                            Comments
                                            <i class="fas fa-chevron-down ms-2 position-absolute end-0"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="input-group mb-3">
                                                <form id="add-comment-form" method="post" action="/"
                                                    class="px-0"
                                                    style="display: flex;justify-content: space-between;width: 100%;">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ $data['id'] }}">
                                                    <input type="text" class="form-control"
                                                        placeholder="Type your comment here |"
                                                        aria-label="Recipient's username" name="comment"
                                                        aria-describedby="button-addon2">
                                                    <span class="error error-comment"></span>
                                                    @if (auth()->user()->hasPermission('riskmanagement.AbleToCommentRiskManagement'))
                                                        <button class="btn btn-primary me-2" type="button"
                                                            id="submit-add-comment">publish</button>
                                                    @endif
                                                </form>
                                            </div>
                                            <div class="rounded border p-3">
                                                @foreach ($data['comments'] as $comment)
                                                    @php
                                                        $commentTime = \Carbon\Carbon::parse($comment['date']);
                                                        $timeAgo = $commentTime->diffForHumans();
                                                    @endphp

                                                    <div class="d-flex justify-content-start align-items-center mb-4">
                                                        <div class="rounded-circle rounded-p">JM</div>
                                                        <p class="ms-3 mb-0">
                                                            <span
                                                                class="fw-bold text-primary">{{ $comment['user']['name'] }}</span>
                                                            <span class="text-muted">added a comment
                                                                {{ $timeAgo }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="bg-custom">
                                                        <p class="mb-4 fw-bold">
                                                            {{ $comment['comment'] }}
                                                        </p>
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Audit Trail Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Audit Trail
                                            <i class="fas fa-chevron-down ms-2 position-absolute end-0"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <!-- Review History -->
                                            @foreach ($data['logs'] as $log)
                                                <div class="d-flex justify-content-between align-items-center p-2"
                                                    style="background-color:#f2f2f2 ;">

                                                    <p>{{ $log['message'] }}</p>
                                                    <div class="d-flex flex-column">
                                                        <p class="mb-0">
                                                            {{ date('d/m/Y', strtotime($log['timestamp'])) }}</p>
                                                        <p class="mb-0">
                                                            {{ date('g:i A T', strtotime($log['timestamp'])) }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>







                            <!-- CloseRisks END -->

                            <!-- End Modal Structure -->


                            <!-- End Modal Structure -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modals --}}

        @if (auth()->user()->hasPermission('riskmanagement.update'))
            <!-- Modal Structure -->
            <div class="modal fade" tabindex="-1" role="dialog" id="editRiskModal" tabindex="-1"
                aria-labelledby="editRiskModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRiskModalLabel">
                                {{ __('locale.EditRisk') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Inside Modal -->
                            <form class="row px-0" id="edit-details-form" method="post"
                                action="{{ route('admin.risk_management.ajax.update') }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value="{{ $data['id'] }}">

                                <!-- Risk Mapping and Threat Mapping (2 columns) -->
                                 <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('risk.RiskMapping') }}</label>
                                        <select name="risk_catalog_mapping_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($riskGroupings as $riskGrouping)
                                                <optgroup label="{{ $riskGrouping->name }}">
                                                    @foreach ($riskGrouping->RiskCatalogs as $riskCatalog)
                                                        <option value="{{ $riskCatalog->id }}"
                                                            {{ in_array($riskCatalog->id, explode(',', $data['risk_catalog_mapping'] ?? '')) ? 'selected' : '' }}>
                                                            {{ $riskCatalog->number . ' - ' . $riskCatalog->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_catalog_mapping_id"></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('risk.ThreatMapping') }}</label>
                                        <select name="threat_catalog_mapping_id[]"
                                            class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($threatGroupings as $threatGrouping)
                                                <optgroup label="{{ $threatGrouping->name }}">
                                                    @foreach ($threatGrouping->ThreatCatalogs as $ThreatCatalog)
                                                        <option value="{{ $ThreatCatalog->id }}"
                                                            {{ in_array($ThreatCatalog->id, explode(',', $data['threat_catalog_mapping'] ?? '')) ? 'selected' : '' }}>
                                                            {{ $ThreatCatalog->number . ' - ' . $ThreatCatalog->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <span class="error error-threat_catalog_mapping_id"></span>
                                    </div>
                                </div>

                                <!-- Submission Date and Category (2 columns) -->
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.SubmissionDate') }}</label>
                                        <input name="submission_date"
                                            class="form-control flatpickr-date-time-compliance"
                                            value="{{ format_date($data['submission_date'], 'N/A') }}" />
                                        <span class="error error-submission_date"></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('risk.Category') }}</label>
                                        <select class="select2 form-select" name="category_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $data['category_id'] == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-category_id"></span>
                                    </div>
                                </div>

                                <!-- Site Location and Additional Stakeholders (2 columns) -->
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.SiteLocation') }}</label>
                                        <select class="form-select multiple-select2" name="location_id[]"
                                            multiple="multiple">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ in_array($location->id, $data['location_ids']) ? 'selected' : '' }}>
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-location_id"></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.AdditionalStakeholders') }}</label>
                                        <select name="additional_stakeholder_id[]"
                                            class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($enabledUsers as $additionalStakeholder)
                                                <option value="{{ $additionalStakeholder->id }}"
                                                    {{ in_array($additionalStakeholder->id, $data['additionalStakeholder_ids']) ? 'selected' : '' }}>
                                                    {{ $additionalStakeholder->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-additional_stakeholder_id"></span>
                                    </div>
                                </div>

                                <!-- Owner and Owner's Manager (2 columns) -->
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.Owner') }}</label>
                                        <select class="select2 form-select" name="owner_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}"
                                                    data-manager="{{ json_encode($owner->manager) }}"
                                                    {{ $data['owner_id'] == $owner['id'] ? 'selected' : '' }}>
                                                    {{ $owner->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-owner_id"></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.OwnersManager') }}</label>
                                        <select class="select2 form-select" name="owner_manager_id"
                                            data-ownerSelected="{{ $data['manager_id'] ? 1 : 0 }}">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                        </select>
                                        <span class="error error-owners_manager_id"></span>
                                    </div>
                                </div>

                                <!-- Tags and Team (2 columns) -->
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('risk.Tags') }}</label>
                                        <select name="tags[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, $data['tag_ids']) ? 'selected' : '' }}>
                                                    {{ $tag->tag }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-tags"></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.Team') }}</label>
                                        <select name="team_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->id }}"
                                                    {{ in_array($team->id, $data['team_ids']) ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-team_id"></span>
                                    </div>
                                </div>

                                <!-- External Reference ID -->
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">{{ __('locale.ExternalReferenceId') }}</label>
                                        <input type="text" name="reference_id" class="form-control dt-post"
                                            aria-label="{{ __('locale.ExternalReferenceId') }}"
                                            value="{{ $data['reference_id'] }}" />
                                        <span class="error error-reference_id"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="first_edit" value="1">
                                <!-- Submit and Cancel buttons -->
                                <div class="col-12 text-center mt-2">
                                    <button id="submit-edit-details" type="button" class="btn btn-primary me-1">
                                        {{ __('locale.SaveDetails') }}
                                    </button>
                                    <button id="cancel-edit-details" type="reset" class="btn btn-danger"
                                        data-bs-dismiss="modal">
                                        {{ __('locale.Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- CloseRisks END -->
        @if (auth()->user()->hasPermission('riskmanagement.update'))
            <!-- Modal Structure -->
            <div class="modal fade" tabindex="-1" role="dialog" id="editRiskModal2"
                aria-labelledby="editRiskModal2Label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content" style="width: 1234px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRiskModal2Label">
                                {{ __('locale.EditRisk') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Inside Modal -->
                            <form class="row" id="edit-details-form2" method="post"
                                action="{{ route('admin.risk_management.ajax.update') }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                <div class="row">
                                    {{-- Control Regulation --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.ControlRegulation') }}</label>
                                        <select class="select2 form-select" name="framework_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($frameworks as $framework)
                                                <option value="{{ $framework->id }}"
                                                    data-controls="{{ json_encode($framework->FrameworkControls) }}"
                                                    {{ $data['regulation'] == $framework->id ? 'selected' : '' }}>
                                                    {{ $framework->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-framework_id"></span>
                                    </div>

                                    {{-- Control Number --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.ControlNumber') }}</label>

                                        <select class="select2 form-select" name="control_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($data['framework_controls'] as $frameworkControl)
                                                <option value="{{ $frameworkControl['id'] }}"
                                                    {{ $data['control_id'] == $frameworkControl['id'] ? 'selected' : '' }}>
                                                    {{ $frameworkControl['short_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-control_id"></span>
                                    </div>
                                </div>
                                <!-- First Row -->
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        {{-- Affected Assets --}}
                                        <label class="form-label">{{ __('risk.AffectedAssets') }}</label>
                                        <select name="affected_asset_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @if (count($assetGroups))
                                                <optgroup label="{{ __('risk.AssetGroups') }}">
                                                    @foreach ($assetGroups as $assetGroup)
                                                        <option value="{{ $assetGroup->id }}_group"
                                                            {{ in_array($assetGroup->id, $data['assetGroup_ids']) ? 'selected' : '' }}>
                                                            {{ $assetGroup->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                            <optgroup
                                                label="{{ __('locale.Standards') }} {{ __('locale.Assets') }}">
                                                @foreach ($assets as $asset)
                                                    <option value="{{ $asset->id }}_asset"
                                                        {{ in_array($asset->id, $data['asset_ids']) ? 'selected' : '' }}>
                                                        {{ $asset->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <span class="error error-affected_asset_id"></span>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        {{-- Technology --}}
                                        <label class="form-label">{{ __('locale.Technology') }}</label>
                                        <select name="technology_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($technologies as $technology)
                                                <option value="{{ $technology->id }}"
                                                    {{ in_array($technology->id, $data['technology_ids']) ? 'selected' : '' }}>
                                                    {{ $technology->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-technology_id"></span>
                                    </div>
                                </div>

                                <!-- Second Row -->
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        {{-- Risk Source --}}
                                        <label class="form-label">{{ __('risk.ImpactScope') }}</label>
                                        <select class="select2 form-select" name="risk_source_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($riskSources as $riskSource)
                                                <option value="{{ $riskSource->id }}"
                                                    {{ $data['source_id'] == $riskSource->id ? 'selected' : '' }}>
                                                    {{ $riskSource->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_source_id"></span>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        {{-- Risk Scoring Method --}}
                                        <label class="form-label">{{ __('risk.RiskScoringMethod') }}</label>
                                        <select class="select2 form-select" name="risk_scoring_method_id">
                                            <option value="" selected disabled hidden>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($riskScoringMethods as $riskScoringMethod)
                                                <option value="{{ $riskScoringMethod->id }}"
                                                    {{ $data['risk_scoring']['id'] == $riskScoringMethod->id ? 'selected' : '' }}>
                                                    {{ $riskScoringMethod->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_scoring_method_id"></span>
                                    </div>
                                </div>

                                <!-- Third Row -->
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        {{-- Current Likelihood --}}
                                        <label class="form-label">{{ __('risk.CurrentLikelihood') }}</label>
                                        <select class="select2 form-select" name="current_likelihood_id">
                                            <option value="" disabled hidden selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($riskLikelihoods as $riskLikelihood)
                                                <option value="{{ $riskLikelihood->id }}"
                                                    {{ $data['likelihood']['id'] == $riskLikelihood->id ? 'selected' : '' }}>
                                                    {{ $riskLikelihood->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-current_likelihood_id"></span>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        {{-- Current Impact --}}
                                        <label class="form-label">{{ __('risk.CurrentImpact') }}</label>
                                        <select class="select2 form-select" name="current_impact_id">
                                            <option value="" disabled hidden selected>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($impacts as $impact)
                                                <option value="{{ $impact->id }}"
                                                    {{ $data['impact']['id'] == $impact->id ? 'selected' : '' }}>
                                                    {{ $impact->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-current_impact_id"></span>
                                    </div>
                                </div>

                                <!-- Additional Notes Row -->
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        {{-- Risk Assessment --}}
                                        <label class="form-label">{{ __('risk.ResponsiblePart') }}</label>
                                        <textarea class="form-control" name="risk_assessment" rows="3">{{ $data['assessment'] }}</textarea>
                                        <span class="error error-risk_assessment"></span>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        {{-- Additional Notes --}}
                                        <label class="form-label">{{ __("locale.KRI'S") }}</label>
                                        <div id="risk_addational_notes" style="height:100px;">
                                            {!! $data['notes'] !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                        {{-- Additional Notes --}}
                                        <label class="form-label">{{ __("locale.Description") }}</label>
                                        <div id="risk_description" style="height:100px;">
                                            {!! $data['risk_description'] !!}
                                        </div>
                                    </div>
                                <input type="hidden" name="second_edit" value="2">

                                <!-- Submit and Cancel buttons -->
                                <div class="col-12 text-center mt-2">
                                    <button id="submit-edit-details2" type="button" class="btn btn-primary me-1">
                                        {{ __('locale.SaveDetails') }}
                                    </button>
                                    <button id="cancel-edit-details2" type="reset" class="btn btn-danger"
                                        data-bs-dismiss="modal">
                                        {{ __('locale.Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal Structure -->
        <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCommentModalLabel">
                            {{ __('locale.Comments') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Add Comment Form -->
                        <div id="add-comment" data-id="IDIDID" style="display: none;">
                            <form id="add-comment-form" method="post" action="/" class="px-0">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                <textarea class="form-control" rows="3" name="comment"></textarea>
                                <span class="error error-comment"></span>

                                <div class="text-end">
                                    <button id="submit-add-comment" class="btn btn-success mt-2"
                                        type="button">{{ __('locale.Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="changeRiskStatusModal" tabindex="-1"
            aria-labelledby="changeRiskStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeRiskStatusModalLabel">
                            {{ __('locale.SetRiskStatusTo') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for changing risk status -->
                        <form class="row px-0" id="change-risk-status-form" method="post"
                            action="{{ route('admin.risk_management.ajax.update') }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <div class="col-12">
                                {{-- Close reason --}}
                                <div class="mb-1">
                                    <select class="select2 form-select" name="status">
                                        <option value="" selected>
                                            {{ __('locale.select-option') }}
                                        </option>
                                        @foreach ($statuses as $status)
                                            @if ($status->name == 'Closed')
                                                @if (auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
                                                    <option value="{{ $status->id }}">
                                                        {{ __('risk.CloseRisk') }}
                                                    </option>
                                                @endif
                                            @else
                                                <option value="{{ $status->id }}">
                                                    {{ $status->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="error error-status"></span>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-2">
                                <button id="submit-change-risk-status" type="button"
                                    class="btn btn-primary me-1">{{ __('locale.Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- CloseRisks start -->
        @if (auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
            <!-- Close Risk Modal -->
            <div class="modal fade" id="closeRiskModal" tabindex="-1" aria-labelledby="closeRiskModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="closeRiskModalLabel">
                                {{ __('risk.CloseRisk') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="close-reason-form" method="post"
                                action="{{ route('admin.risk_management.ajax.update') }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value="{{ $data['id'] }}">

                                <!-- Close reason -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('locale.Reason') }}</label>
                                    <select class="select2 form-select" name="close_reason">
                                        <option value="" selected>
                                            {{ __('locale.select-option') }}
                                        </option>
                                        @foreach ($closeReasons as $closeReason)
                                            <option value="{{ $closeReason->id }}">
                                                {{ $closeReason->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error error-close_reason"></span>
                                </div>

                                <!-- Close-Out Information note -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('risk.CloseOutInformation') }}</label>
                                    <textarea class="form-control" name="note" rows="3"></textarea>
                                    <span class="error error-note"></span>
                                </div>

                                <div class="text-center mt-3">
                                    <button id="submit-close-reason" type="button"
                                        class="btn btn-primary me-1">{{ __('locale.Submit') }}</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (auth()->user()->hasPermission('plan_mitigation.create'))
            <!-- Modal -->
            <div class="modal fade" id="editMitigationModal" tabindex="-1"
                aria-labelledby="editMitigationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" style=" max-width:;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMitigationModalLabel">{{ __('locale.EditMitigation') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row px-0" id="edit-mitigation-form" method="post" action="/">
                                @csrf
                                <input type="hidden" name="risk_id" value="{{ $data['id'] }}">
                                <div class="col-12 col-md-6">
                                    {{-- Mitigation Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationDate') }}</label>
                                    </div>
                                    {{-- Mitigation Planning Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationPlanning') }}</label>
                                        <input name="planned_mitigation_date"
                                            class="form-control flatpickr-date-time-compliance"
                                            value="{{ format_date($data['mitigation']['planning_date'], '') }}" />
                                        <span class="error error-planned_mitigation_date "></span>
                                    </div>
                                    {{-- Planning Strategy --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.PlanningStrategy') }}</label>
                                        <select class="select2 form-select" name="planning_strategy">
                                            <option value="">{{ __('locale.select-option') }}</option>
                                            @foreach ($planningStrategies as $planningStrategy)
                                                <option value="{{ $planningStrategy->id }}"
                                                    {{ ($data['mitigation']['planning_strategy_id'] ?? '') == $planningStrategy->id ? 'selected' : '' }}>
                                                    {{ $planningStrategy->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-planning_strategy"></span>
                                    </div>
                                    {{-- Mitigation Effort --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationEffort') }}</label>
                                        <select class="select2 form-select" name="mitigation_effort">
                                            <option value="">{{ __('locale.select-option') }}</option>
                                            @foreach ($mitigationEfforts as $mitigationEffort)
                                                <option value="{{ $mitigationEffort->id }}"
                                                    {{ ($data['mitigation']['mitigation_effort_id'] ?? '') == $mitigationEffort->id ? 'selected' : '' }}>
                                                    {{ $mitigationEffort->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_effort"></span>
                                    </div>
                                    {{-- @php dd($mitigationCosts)@endphp --}}
                                    {{-- MitigationCost --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationCost') }}</label>
                                        <select class="select2 form-select" name="mitigation_cost">
                                            <option value="">{{ __('locale.select-option') }}</option>
                                            @foreach ($mitigationCosts as $mitigationCost)
                                                <option value="{{ $mitigationCost->id }}"
                                                    {{ ($data['mitigation']['mitigation_cost_id'] ?? '') == $mitigationCost->id ? 'selected' : '' }}>
                                                    {{ $mitigationCost->name }}
                                                    @php
                                                        $valuation_level_name = '';
                                                        if (!empty($mitigationCost->valuation_level_name)) {
                                                            $valuation_level_name = ' (' . $mitigationCost->valuation_level_name . ')';
                                                        }
                                    
                                                        if ($mitigationCost->min_value === $mitigationCost->max_value) {
                                                            echo get_setting('currency') .
                                                                number_format($mitigationCost->min_value) .
                                                                $valuation_level_name;
                                                        } else {
                                                            echo get_setting('currency') .
                                                                number_format($mitigationCost->min_value) .
                                                                ' to ' .
                                                                get_setting('currency') .
                                                                number_format($mitigationCost->max_value) .
                                                                $valuation_level_name;
                                                        }
                                                    @endphp
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_cost"></span>
                                    </div>
                                    {{-- Mitigation Owner --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationOwner') }}</label>
                                        <select class="select2 form-select" name="mitigation_owner_id">
                                            <option value="">{{ __('locale.select-option') }}</option>
                                            @foreach ($enabledUsers as $owner)
                                                <option value="{{ $owner->id }}"
                                                    data-manager="{{ json_encode($owner->manager) }}"
                                                    {{ isset($data['mitigation']['mitigation_owner']) && $data['mitigation']['mitigation_owner'] == $owner->name ? 'selected' : '' }}>
                                                    {{ $owner->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_owner_id"></span>
                                    </div>

                                    {{-- Mitigation Team --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationTeam') }}</label>
                                        <select name="mitigation_team_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->id }}"
                                                    {{ in_array($team->id, $data['mitigation']['team_ids'] ?? []) ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_team_id"></span>
                                    </div>
                                    {{-- Mitigation Percent --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationPercent') }}</label>
                                        <input type="number" min="0" class="form-control"
                                            name="mitigation_percent"
                                            value="{{ $data['mitigation']['mitigation_percent'] ?? '' }}">
                                        <span class="error error-mitigation_percent"></span>
                                    </div>
                                    {{-- Mitigation Controls --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.MitigationControls') }}</label>
                                        <select name="mitigation_control_id[]" class="form-select multiple-select2"
                                            multiple="multiple">
                                            @foreach ($frameworks as $framework)
                                                @foreach ($framework->FrameworkControls as $control)
                                                    <option value="{{ $control->id }}"
                                                        {{ in_array($control->id, $data['mitigation']['mitigation_control_ids'] ?? []) ? 'selected' : '' }}>
                                                        {{ $control->short_name }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_control_id"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{-- Current Solution --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.CurrentSolution') }}</label>
                                        <div id="risk_current_solution">
                                            {!! $data['mitigation']['current_solution'] !!}
                                        </div>
                                    </div>
                                    {{-- Security Requirements --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SecurityRequirements') }}</label>
                                        <textarea class="form-control" name="security_requirements" rows="3">{{ $data['mitigation']['security_requirements'] }}</textarea>
                                        <span class="error error-security_requirements "></span>
                                    </div>
                                    {{-- Security Recommendations --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SecurityRecommendations') }}</label>
                                        <textarea class="form-control" name="security_recommendations" rows="3">{{ $data['mitigation']['security_recommendations'] }}</textarea>
                                        <span class="error error-security_recommendations "></span>
                                    </div>
                                    {{-- Supporting Documentation --}}
                                    <div class="mb-1 supporting_documentation_container">
                                        <label class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                        <input type="file" multiple name="supporting_documentation[]"
                                            class="form-control dt-post"
                                            aria-label="{{ __('risk.SupportingDocumentation') }}" />
                                        <span class="error error-supporting_documentation "></span>
                                        @forelse($data['mitigation']['files'] ?? [] as $file)
                                            <div class="mitigation-files">
                                                <span
                                                    class="badge bg-secondary supporting_documentation cursor-pointer"
                                                    data-id="{{ $file['id'] }}"
                                                    data-risk-id="{{ $data['id'] }}">{{ $file['name'] }}</span>
                                                <span
                                                    class="text-danger delete_supporting_documentation cursor-pointer"
                                                    data-id="{{ $file['id'] }}"
                                                    data-risk-id="{{ $data['id'] }}"><i
                                                        data-feather="x"></i></span>
                                            </div>
                                        @empty
                                            <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <button id="submit-edit-mitigation" type="button"
                                        class="btn btn-primary me-1">
                                        {{ __('locale.SaveMitigation') }}
                                    </button>
                                    <button id="cancel-edit-mitigation" type="reset" class="btn btn-danger"
                                        data-bs-dismiss="modal">
                                        {{ __('locale.Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Download File Form -->
        <form class="d-none" id="download-file-form" method="post"
            action="{{ route('admin.risk_management.ajax.download_file') }}">
            @csrf
            <input type="hidden" name="id">
            <input type="hidden" name="risk_id">
        </form>

        <!-- end tab -->

        <!-- Add Review Form -->
        <div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addReviewModalLabel">{{ __('locale.AddReview') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row" id="add-review-form" method="post" action="/">
                            @csrf
                            <input type="hidden" name="risk_id" value="{{ $data['id'] }}">

                            <div class="col-12 col-md-6">
                                <!-- Basic Review Information -->
                                <div class="mb-1">
                                    <label class="text-label">{{ __('locale.ReviewDate') }}</label>:
                                    {{ date(get_default_date_format()) }}
                                </div>
                                <div class="mb-1">
                                    <label class="text-label">{{ __('locale.Reviewer') }}</label>:
                                    {{ auth()->user()->name }}
                                </div>

                                <!-- Review Selection Fields -->
                                @foreach (['review' => $reviews, 'next_step' => $nextSteps] as $field => $options)
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.' . ucfirst($field)) }}</label>
                                        <select class="select2 form-select" name="{{ $field }}"
                                            id="{{ $field }}">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($options as $option)
                                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-{{ $field }}"></span>
                                    </div>
                                @endforeach

                                <!-- Project Selection (Initially Hidden) -->
                                <div class="mb-1 d-none" id="project-container">
                                    <label class="text-label">{{ __('locale.ProjectName') }}</label>
                                    <select class="select2 form-select" name="project">
                                        <option value="" selected disabled>{{ __('locale.select-option') }}
                                        </option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-project"></span>
                                </div>

                                <!-- Comments -->
                                <div class="mb-1">
                                    <label class="text-label">{{ __('locale.Comment') }}</label>
                                    <textarea class="form-control" name="comments" rows="3"></textarea>
                                    <span class="error error-comments"></span>
                                </div>
                            </div>

                            <!-- Next Review Date Section -->
                            <div class="col-12 col-md-6 px-lg-5">
                                <div class="mb-1">
                                    <p>{{ __('locale.BasedOnTheCurrentRiskScore') }}
                                        {{ $data['get_next_review_default'] }}</p>
                                    <p>{{ __('locale.WouldYouLikeToUseADifferentDate') }}</p>
                                    <label class="text-label">{{ __('locale.NextReviewDate') }}</label>
                                    <input name="next_review_date"
                                        class="form-control flatpickr-date-time-compliance"
                                        value="{{ $data['get_next_review_default'] }}" />
                                    <span class="error error-next_review_date"></span>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-center mt-2">
                                <button type="button" id="submit-add-review" class="btn btn-primary me-1">
                                    {{ __('locale.SubmitReview') }}
                                </button>
                                <button type="reset" id="cancel-add-review" class="btn btn-danger"
                                    data-bs-dismiss="modal">
                                    {{ __('locale.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts.js') }}"></script>
    <script>
        const lang = [],
            URLs = [],
            assets = [];
        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
        lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
        URLs['updateSubject'] = "{{ route('admin.risk_management.ajax.update_subject') }}";
        URLs['updateRiskScoring'] = "{{ route('admin.risk_management.ajax.update_risk_scoring') }}";
        URLs['addComment'] = "{{ route('admin.risk_management.ajax.add_comment') }}";
        URLs['getRiskLevels'] = "{{ route('admin.risk_management.ajax.get_risk_levels') }}";
        URLs['residualScoringHistory'] =
            "{{ route('admin.risk_management.ajax.residual_scoring_history', $data['id']) }}";
        URLs['getScoringHistories'] = "{{ route('admin.risk_management.ajax.get_scoring_histories', $data['id']) }}";
        URLs['updateDetails'] = "{{ route('admin.risk_management.ajax.update') }}";
        URLs['deleteFile'] = "{{ route('admin.risk_management.ajax.delete_file') }}";
        URLs['acceptRejectMitigation'] = "{{ route('admin.risk_management.ajax.accept_reject_mitigation') }}";
        URLs['updateRiskMitigation'] = "{{ route('admin.risk_management.ajax.update_risk_mitigation') }}";
        URLs['addRiskReview'] = "{{ route('admin.risk_management.ajax.add_risk_review') }}";
        URLs['riskCloseReason'] = "{{ route('admin.risk_management.ajax.risk_close_reason') }}";
        URLs['riskReopen'] = "{{ route('admin.risk_management.ajax.risk_reopen') }}";
        URLs['riskChangeStatus'] = "{{ route('admin.risk_management.ajax.risk_Change_Status') }}";
        URLs['resetRiskMitigations'] = "{{ route('admin.risk_management.ajax.reset_risk_mitigations') }}";
        URLs['resetRiskReviews'] = "{{ route('admin.risk_management.ajax.reset_risk_reviews') }}";


        const dataFormat = "{{ get_default_date_format() }}";


        Highcharts.setOptions({
            global: {
                timezone: "{{ get_setting('default_timezone') }}"
            }
        });
        assets['showLoading'] = "{{ asset('SR_images/progress.gif') }}";
    </script>
    <script src="{{ asset('ajax-files/risk_management/edit.js') }}"></script>
    <script>
        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (this.classList.contains('collapsed')) {
                    icon.style.transform = "rotate(180deg)";
                } else {
                    icon.style.transform = "rotate(0deg)";
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const collapseOne = document.getElementById('collapseOne');
            const chevronIcon = document.getElementById('chevronIcon');

            collapseOne.addEventListener('show.bs.collapse', function() {
                // Rotate the icon down when the accordion is expanded
                chevronIcon.style.transform = 'rotate(0deg)';
            });

            collapseOne.addEventListener('hide.bs.collapse', function() {
                // Rotate the icon up when the accordion is collapsed
                chevronIcon.style.transform = 'rotate(180deg)';
            });
        });
        $(document).on('input', 'input[name="mitigation_percent"]', function() {
            const value = parseInt($(this).val(), 10);
            if (value > 100) {
                $(this).val(100); // Restrict the value to 100
                $('.error-mitigation_percent').text('Percentage cannot exceed 100.');
            } else {
                $('.error-mitigation_percent').text(''); // Clear error message
            }
        });

        $(document).ready(function() {
            // Trigger the alert for the active tab when the page loads
            var activeTab = $('#pills-tab .active').attr('id'); // Get the ID of the active tab

            // Hide all options by default
            $('#risk-actions option').hide();
            $('#risk-actions .step-default-option').prop('selected', true);

            // Display options based on the active tab
            if (activeTab === "pills-home-tab") { // Show options for Risk Identification
                 $('#risk-actions .step-1-option').show();
            }
            if (activeTab === "pills-analysis-tab") {
                $('#risk-actions .step-2-option').show(); // Risk analysis options
            }
            if (activeTab === "pills-evalution-tab") {
                // Show options for Risk Evaluation
                $('#risk-actions .step-3-option').show(); // Reset Mitigations option
            }
            if (activeTab === "pills-review-tab") {
                // Show options for Risk Review
                $('#risk-actions .step-4-option').show(); // Review options
            }

            // Handle tab switching
            $('#pills-tab button').on('shown.bs.tab', function(e) {
                var activeTab = $(e.target).attr('id'); // Get the ID of the active tab
                $('#risk-actions .step-default-option').prop('selected', true);

                // Hide all options by default
                $('#risk-actions option').hide();

                // Display options based on the active tab
                if (activeTab === "pills-home-tab") { // Show options for Risk Identification
                    $('#risk-actions .step-1-option').show();
                }
                if (activeTab === "pills-analysis-tab") {
                    $('#risk-actions .step-2-option').show(); // Risk analysis options
                }
                if (activeTab === "pills-evalution-tab") {
                    // Show options for Risk Evaluation
                    $('#risk-actions .step-3-option').show(); // Reset Mitigations option
                }
                if (activeTab === "pills-review-tab") {
                    // Show options for Risk Review
                    $('#risk-actions .step-4-option').show(); // Review options
                }
            });
        });
    </script>
    
    <!-- end accordion -->
@endsection
