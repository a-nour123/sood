@extends('admin/layouts/contentLayoutMaster')

@section('title', __('risk.Submit Risk'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
<style>
    #risk_addational_notes_submit {
        height: 93px;

    }

    .ql-spanblock:after {
        content: "<sb/>";
    }

    .spanblock {
        background-color: #f2f2f2;
        border: 1px solid #CCC;
        line-height: 19px;
        padding: 6px 10px;
        border-radius: 3px;
        margin: 15px 0;
    }

    .tab {
        display: none;
    }

    .tab:first-of-type {
        display: block;
        /* Show the first step by default */
    }

    .basic-wizard .stepper-horizontal {
        overflow: auto !important;
    }

    .wizard-fields {
        padding: 10px;
    }
</style>

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-md-6 ps-0">
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
                        <div class="col-md-6 pe-0" style="text-align: end;">

                            <div class="action-content">

                                @if (auth()->user()->hasPermission('riskmanagement.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-risk">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.risk_management.notificationsSettingsRisk') }}"
                                        class=" btn btn-primary " target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('riskmanagement.configuration') ||
                                        auth()->user()->hasPermission('classic_risk_formula.list'))
                                    <div class="btn-group dropdown dropdown-icon-wrapper ">
                                        <button type="button"
                                            class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="border-radius: 8px !important;
                                        width: 40px;
                                        text-align: center;
                                        color: #FFF !important;
                                        height: 28px;
                                        line-height: 19px;">
                                            <i class="fa fa-solid fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end export-types">
                                            @if (auth()->user()->hasPermission('classic_risk_formula.list'))
                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start">
                                                        <a href="{{ route('admin.configure.riskmodels.show') }}">
                                                            {{ __('locale.ClassicRiskFormula') }}
                                                        </a>
                                                    </span>
                                                </span>
                                            @endif
                                            @if (auth()->user()->hasPermission('riskmanagement.configuration'))
                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start">
                                                        <a
                                                            href="{{ route('admin.risk_management.configuretion') }}">{{ __('locale.configuretion') }}</a>
                                                    </span>
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                @endif
                                <x-export-import name="{{ __('risk.Risk') }}"
                                    createPermissionKey='vulnerability_management.create'
                                    exportPermissionKey='riskmanagement.export'
                                    exportRouteKey='admin.risk_management.ajax.export'
                                    importRouteKey='admin.risk_management.import' />

                                @if (auth()->user()->hasPermission('riskmanagement.Risk Dashboard'))
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.risk_management.ajax.statistics.risk') }}"> <i
                                            class="fa-solid fa-file-invoice"></i></a>
                                @endif
                                @if (auth()->user()->hasPermission('riskmanagement.export'))

                                    <a title="export pdf" href="#" id="exportAsPdfButton"
                                        class="dt-button btn btn-primary " onclick="exportAsPdf()">
                                        <i class="fas fa-file-pdf"></i> <!-- Replace with your desired icon class -->
                                    </a>
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

<div class="card">
    <div class="card-header mb-3">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Risk Management') }}
        </div>
    </div>


    <div class="row status-row mb-3">
        <div class="status col-12 d-flex flex-wrap justify-content-around">
            <!-- Status Card: Overview -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png'); position: relative;">
                    <div class="card-body">
                        @if (auth()->user()->hasPermission('riskmanagement.Risks and Assets') ||
                                auth()->user()->hasPermission('riskmanagement.Risks and Controls'))
                            <!-- Dropdown Icon at Top-Right Corner -->
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"
                                aria-expanded="false" style="position: absolute; top: 10px; right: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-more-vertical font-small-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </a>
                        @endif



                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            @if (auth()->user()->hasPermission('riskmanagement.Risks and Assets'))
                                <li>
                                    <button class="dropdown-item open-modal" data-id="RiskByAsset"
                                        onclick="navigateToRiskByAssetReport()">
                                        {{ __('locale.risk_by_asset') }}
                                    </button>
                                </li>
                            @endif
                            @if (auth()->user()->hasPermission('riskmanagement.Risks and Controls'))
                                <li>
                                    <!-- Pass the 'type' dynamically here to the navigateToRiskByControlReport function -->
                                    <button class="dropdown-item open-modal" data-id="RiskByControl"
                                        onclick="navigateToRiskByControlReport(0)">
                                        {{ __('locale.risk_by_control') }}
                                    </button>
                                </li>
                            @endif
                            @if (auth()->user()->hasPermission('riskmanagement.Risks and Controls') || auth()->user()->hasPermission('riskmanagement.Risks and Assets'))
                                <li>
                                    <!-- Pass the 'type' dynamically here to the navigateToRiskByControlReport function -->
                                    <button class="dropdown-item open-modal">
                                        <a href="{{ route('admin.reporting.GetRiskCenter') }}">
                                            {{ __('locale.risk_center') }}</a>
                                        <!-- #region --> </button>
                                </li>
                            @endif
                        </ul>
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:rgb(46, 46, 45)" data-feather="minus-circle"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:rgb(46, 46, 45)">{{ $riskInfo['overview'] ?? 0 }}</h4>
                                <span class="f-light"
                                    style="color:rgb(46, 46, 45)">{{ __('locale.overview_risks') }}</span>
                            </div>
                        </div>
                        <div class="font-secondary f-w-600">
                            <i class="icon-arrow-up icon-rotate me-1"></i>
                            <span style="color:rgb(46, 46, 45)">+({{ $riskInfo['overview_percentage'] ?? 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card: Closed (Green) -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:green" data-feather="check-circle"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:green">{{ $riskInfo['closedRisk']['count'] ?? 0 }}</h4>
                                <span class="f-light" style="color:green">{{ __('locale.closed_risks') }}</span>
                            </div>
                        </div>
                        <div class="font-secondary f-w-600">
                            <i class="icon-arrow-up icon-rotate me-1"></i>
                            <span style="color:green">+({{ $riskInfo['closedRisk']['percentage'] ?? 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card: Open (Red) -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:red" data-feather="x-circle"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:red">{{ $riskInfo['openRisk']['count'] ?? 0 }}</h4>
                                <span class="f-light" style="color:red">{{ __('locale.open_risks') }}</span>
                            </div>
                        </div>
                        <div class="font-secondary f-w-600">
                            <i class="icon-arrow-up icon-rotate me-1"></i>
                            <span style="color:red">+({{ $riskInfo['openRisk']['percentage'] ?? 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card: Mitigated (Blue) -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:rgb(165, 165, 192)" data-feather="archive"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:rgb(165, 165, 192)">{{ $riskInfo['MitigatedRisk']['count'] ?? 0 }}
                                </h4>
                                <span class="f-light"
                                    style="color:rgb(165, 165, 192)">{{ __('locale.mitigated_risks') }}</span>
                            </div>
                        </div>
                        <div class="font-secondary f-w-600">
                            <i class="icon-arrow-up icon-rotate me-1"></i>
                            <span
                                style="color:rgb(165, 165, 192)">+({{ $riskInfo['MitigatedRisk']['percentage'] ?? 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Advanced Search -->
<x-submit-risk-search id="advanced-search-datatable" createModalID="add-new-risk" :statuses="$statuses" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (auth()->user()->hasPermission('riskmanagement.create'))
    <x-submit-risk-form id="add-new-risk" title="{{ __('risk.AddANewRisk') }}" :riskGroupings="$riskGroupings" :threatGroupings="$threatGroupings"
        :locations="$locations" :frameworks="$frameworks" :assets="$assets" :assetGroups="$assetGroups" :categories="$categories" :technologies="$technologies"
        :teams="$teams" :enabledUsers="$enabledUsers" :riskSources="$riskSources" :riskScoringMethods="$riskScoringMethods" :riskLikelihoods="$riskLikelihoods" :impacts="$impacts"
        :tags="$tags" :owners="$owners" :reviewers="$reviewers" :projects="$projects" :mitigationEfforts="$mitigationEfforts"
        :mitigationCosts="$mitigationCosts" :planningStrategies="$planningStrategies" :reviews="$reviews" :nextSteps="$nextSteps" />
@endif



<!--/ Create Form -->

<!-- Update Form -->
{{-- <x-submit-risk-form id="edit-risk" title="{{ __('locale.EditRisk') }}" :riskGroupings = "$riskGroupings" :threatGroupings = "$threatGroupings" :locations = "$locations" :frameworks = "$frameworks" :categories = "$categories" :technologies = "$technologies" :teams = "$teams" :enabledUsers = "$enabledUsers" :riskSources = "$riskSources" :riskScoringMethods = "$riskScoringMethods" :riskLikelihoods = "$riskLikelihoods" :impacts = "$impacts" :tags = "$tags" /> --}}
<!--/ Update Form -->

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('cdn/ckeditor.js') }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

{{-- Add Verification translation --}}
<script>
    let URLs = [],
        lang = [];
    lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
    lang['cancel'] = "{{ __('locale.Cancel') }}";
    lang['View'] = "{{ __('locale.View') }}";
    lang['Delete'] = "{{ __('locale.Delete') }}";
    lang['success'] = "{{ __('locale.Success') }}";
    lang['error'] = "{{ __('locale.Error') }}";
    lang['confirmDeleteMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.risk')]) }}";
    permission = [];
    permission['show'] = {{ auth()->user()->hasPermission('riskmanagement.list') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('riskmanagement.delete') ? 1 : 0 }};
    URLs['ajax_list'] = "{{ route('admin.risk_management.ajax.index') }}";
    URLs['show'] = "{{ route('admin.risk_management.show', ':id') }}";
    URLs['create'] = "{{ route('admin.risk_management.ajax.store') }}";
    URLs['delete'] = "{{ route('admin.risk_management.ajax.destroy', ':id') }}";
</script>
<script src="{{ asset('ajax-files/risk_management/index.js') }}"></script>
<script>
    function navigateToRiskByAssetReport() {
        // Construct the URL with query parameters for RiskByAsset
        var url = '{{ route('admin.reporting.GetRiskByAsset') }}' + '?type=2&asset=0&risk=0';

        // Navigate to the constructed URL
        window.location.href = url;
    }

    function navigateToRiskByControlReport(type) {
        // Construct the URL with the framework ID and type
        var url = '{{ route('admin.reporting.GetRiskByControl') }}' + '?type=' + type;

        // Navigate to the constructed URL
        window.location.href = url;
    }

    // Initialize flatpickr on the specified input field
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr-date-time-compliance", {
            enableTime: true, // Enable time selection if you want to pick both date and time
            dateFormat: "Y-m-d H:i", // Format to display the selected date (e.g., 2024-11-18 15:30)
            minDate: "today", // Optional: Disable past dates
        });
    });
</script>
<script>
    $(document).ready(function() {
        let currentStep = 0; // Track current step
        const steps = $(".tab"); // All steps
        const totalSteps = steps.length;
        const form = $("#wizard-form"); // Form reference

        // Function to style step circles dynamically based on the current step
        function styleStepCircles() {
            const activeColor = '#4CAF50'; // Green for active step
            const inactiveColor = '#CCCCCC'; // Light gray for inactive steps
            const activeTextColor = 'white'; // White text color for active circle
            const inactiveTextColor = '#555555'; // Dark gray text color for inactive circles

            const totalSteps = $(".step").length;

            for (let i = 0; i < totalSteps; i++) {
                const stepCircle = $(`.stepper-${i + 1} .step-circle`);
                const stepText = $(`.stepper-${i + 1} .step-title`);

                if (i === currentStep) {
                    stepCircle.css('background-color', activeColor);
                    stepCircle.css('color', activeTextColor);
                    stepText.css('color', activeColor);
                } else {
                    stepCircle.css('background-color', inactiveColor);
                    stepCircle.css('color', inactiveTextColor);
                    stepText.css('color', inactiveTextColor);
                }
            }
        }

        // Function to hide all steps and show the current one
        function showStep(step) {
            currentStep = step;
            styleStepCircles();

            steps.hide();
            $(steps[step]).show();

            if (step === 0) {
                $("#backbtn").hide();
            } else {
                $("#backbtn").show();
            }

            if (step === totalSteps - 1) {
                $("#nextbtn").text("Submit");
            } else {
                $("#nextbtn").text("Next");
            }
        }

        function validateStep() {
            const currentTab = $(steps[currentStep]);

            const invalidFields = currentTab.find(":input").filter(function() {
                return !this.validity.valid;
            });

            if (invalidFields.length > 0) {
                invalidFields.each(function() {
                    $(this).addClass('is-invalid');
                });
                return false;
            }

            return true;
        }

        function nextStep() {
            if (validateStep()) {
                if (currentStep === totalSteps - 1) {
                    form.submit();
                } else {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        }

        function backStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        $(document).on("click", "#nextbtn", function(event) {
            nextStep();
        });

        $("#backbtn").on("click", function() {
            backStep();
        });

        // Initially show the first step
        showStep(currentStep);

        // Reset to the first step when the modal is closed and clear validation errors
        $('.wizardModal').on('hidden.bs.modal', function() {
            currentStep = 0; // Reset current step
            showStep(currentStep); // Show the first step

            // Clear any validation errors
            $("input").removeClass('is-invalid'); // Remove invalid class from all inputs
        });

        // Remove validation error when the user starts typing
        $("input").on("input", function() {
            $(this).removeClass('is-invalid'); // Remove invalid class as user types
        });
    });


    $(document).ready(function() {
        $('#planMitigationOption').on('change', function() {
            if ($(this).val() === 'PlanAMitigation') {
                $('#planMitigationInputs').slideDown(); // Show inputs with animation
            } else {
                $('#planMitigationInputs').slideUp(); // Hide inputs with animation
            }
        });
    });
    $(document).ready(function() {
        $('#performReviewOption').on('change', function() {
            if ($(this).val() === 'PerformAReview') {
                $('#planReviewInputs').slideDown(); // Show inputs with animation
            } else {
                $('#planReviewInputs').slideUp(); // Hide inputs with animation
            }
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
</script>

@endsection
