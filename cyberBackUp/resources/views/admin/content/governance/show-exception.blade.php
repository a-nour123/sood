@extends('admin/layouts/contentLayoutMaster')

@section('title', __('View'))
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
    <style>
        @media (max-width: 576px) {
            .text-sm-only-center {
                text-align: center
            }
        }

        .text-label {
            font-size: 1.3rem;
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

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* Full viewport height */
            /* Full viewport width */
            background-color: #f8f9fa;
            /* Optional background color */
            overflow: hidden;
            /* Prevent scrollbars if the card exceeds viewport size */
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
    <div id="quill-service-content" class="d-none"></div>

</div>
<!-- main exception data start -->
<div class="row" style="margin-top: 50px; ">
    <div class="col-12 container">
        <div class="card risk-session" style="height: 750px; width: 80%;">
            <div class="card-body row mx-0">

                {{-- Details tab --}}
                <div class="tab-pane active" id="details" aria-labelledby="details-tab" role="tabpanel">
                    <div class="row" id="static-details">
                        <div class="col-12">
                        </div>
                        <div class="col-12 col-md-6" style="margin-top: 50px;">
                            {{-- Submission date --}}
                            <div class="mb-1">
                                <label class="text-label"
                                    style="font-size: 2rem;">{{ __('locale.SubmissionDate') }}</label> :
                                {{ format_date($submission_date, 'N/A') }}
                            </div>
                            {{-- Control/policy/risk --}}
                            <div class="mb-1">
                                @if ($exception['type'] == 'control')
                                    <label class="text-label"
                                        style="font-size: 2rem;">{{ __('locale.Control') }}</label> :
                                    {{ $control_name ?? '' }}
                                @elseif($exception['type'] == 'policy')
                                    <label class="text-label"
                                        style="font-size: 2rem;">{{ __('locale.Policy') }}</label> :
                                    {{ $policy_name ?? '' }}
                                @else
                                    <label class="text-label" style="font-size: 2rem;">{{ __('locale.Risk') }}</label>
                                    :
                                    {{ $risk_name ?? '' }}
                                @endif
                            </div>

                            {{-- Status --}}
                            <div class="mb-1">
                                <label class="text-label"
                                    style="font-size: 2rem;">{{ __('locale.RequestStatus') }}</label> :
                                @if ($exception['request_status'] == 0)
                                    <span style="font-size: 1rem;"
                                        class=" badge rounded-pill badge-light-warning">{{ __('locale.Pending') }}</span>
                                @elseif ($exception['request_status'] == 1)
                                    <span style="font-size: 1rem;"
                                        class=" badge rounded-pill badge-light-success">{{ __('locale.Approved') }}</span>
                                @else
                                    <span style="font-size: 1rem;"
                                        class=" badge rounded-pill badge-light-danger">{{ __('locale.Rejected') }}</span>
                                @endif
                            </div>
                            {{-- Control Regulation --}}
                            @if ($exception['type'] == 'control')
                                <div class="mb-1">
                                    <label class="text-label"
                                        style="font-size: 2rem;">{{ __('risk.ControlRegulation') }}</label>
                                    :
                                    {{ $exception['name'] ?? '' }}
                                </div>
                                {{-- Control Number --}}
                                <div class="mb-1">
                                    <label class="text-label"
                                        style="font-size: 2rem;">{{ __('risk.ControlNumber') }}</label> :
                                    {{-- @if (isset($data['control']))
                                            <b>({{ $data['control']['id'] ?? '' }})</b>
                                            {{ $data['control']['short_name'] ?? '' }}
                                        @endif --}}
                                </div>
                            @endif

                            {{-- AdditionalStakeholders --}}
                            <div class="mb-1">
                                <label class="text-label"
                                    style="font-size: 2rem;">{{ __('locale.AdditionalStakeholders') }}</label> : <br>
                                @foreach ($usersNames as $username)
                                    <span>{{ $username }}</span><br>
                                @endforeach
                            </div>
                            {{-- Requestor --}}
                            <div class="mb-1">
                                <label class="text-label" style="font-size: 2rem;">{{ __('locale.Requestor') }}</label>
                                :
                                {{ $exception_creator_name ?? '' }}
                            </div>
                        </div>
                        {{-- Submitted By --}}
                        {{-- <div class="mb-1">
                                    <label class="text-label" style="font-size: 2rem;">{{ __('locale.SubmittedBy') }}</label> :
                                    {{ $exception_creator_name ?? '' }}
                                </div> --}}

                        {{-- File  --}}
                        <div class="mb-1 supporting_documentation_container">
                            <label class="text-label"
                                style="font-size: 2rem;">{{ __('risk.SupportingDocumentation') }}</label>
                            :
                            @if ($exception['exception_file'])
                                <a download="{{ $exception['exception_file'] }}" target="_blank"
                                    href="{{ asset('storage/' . $exception['exception_file']) }}"
                                    class="badge bg-secondary supporting_documentation cursor-pointer"
                                    style="margin-bottom: 5px">{{ __('locale.viewFile') }}</a>
                            @else
                                <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                            @endif
                        </div>

                        {{-- Description  --}}
                        <div class="mb-1">
                            <label class="text-label" style="font-size: 2rem;">{{ __('locale.Description') }}</label> :
                            <div style="max-height: 100px;   overflow: auto;">
                                {!! $exception['description'] !!}
                            </div>
                        </div>

                        {{-- Description  --}}
                        <div class="mb-1">
                            <label class="text-label" style="font-size: 2rem;">{{ __('locale.Justification') }}</label>
                            :
                            <div style="max-height: 100px;   overflow: auto;">
                                {!! $exception['justification'] !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main risk data End -->

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
    $(document).ready(function() {
        $('#risk-actions').on('change', function() {
            var exceptionId = $(this).data('id');
            var selectedValue = $(this).val();

            if (selectedValue == 1) { // Check if "Approve" is selected
                $.ajax({
                    url: '/admin/governance/exception/update-request-status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token for security
                        id: exceptionId,
                        request_status: 1
                    },
                    success: function(response) {
                        if (response.success) {} else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating request status:', error);
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        // Check the initial state of the dropdown based on request_status
        var initialRequestStatus = '{{ $exception['request_status'] }}';

        if (initialRequestStatus == 2) {
            $('#risk-actions').prop('disabled', true);
        }

        $('#risk-actions').on('change', function() {
            var exceptionId = $(this).data('id');
            var selectedValue = $(this).val();

            if (selectedValue == 1) { // Approve option
                updateExceptionStatus(exceptionId, 1, null);
            } else if (selectedValue == 2) { // Reject option
                updateExceptionStatus(exceptionId, 2, 0);
            }
        });

        function updateExceptionStatus(id, requestStatus, exceptionStatus) {
            $.ajax({
                url: '/admin/governance/exception/update-request-status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    request_status: requestStatus,
                    exception_status: exceptionStatus
                },
                success: function(response) {
                    if (response.success) {

                        // Update the status label in the view
                        var statusLabel = '';
                        var statusClass = '';

                        if (requestStatus == 1) {
                            statusLabel = '{{ __('locale.Approved') }}';
                            statusClass = 'badge-light-success';
                        } else if (requestStatus == 2) {
                            statusLabel = '{{ __('locale.Rejected') }}';
                            statusClass = 'badge-light-danger';
                        }

                        var $statusBadge = $('div.mb-1 span.badge');
                        $statusBadge.text(statusLabel)
                            .removeClass(
                                'badge-light-warning badge-light-success badge-light-danger')
                            .addClass(statusClass);

                        // Disable the dropdown
                        $('#risk-actions').prop('disabled', true);

                        // Update the exception status label if needed
                        if (exceptionStatus !== null) {
                            var $exceptionStatusSpan = $('span.display-6');
                            if (exceptionStatus == 0) {
                                $exceptionStatusSpan.text('{{ __('locale.Closed') }}')
                                    .css('color', '#ea5455');
                            }
                        }
                    } else {}
                },
                error: function(xhr, status, error) {
                    console.error('Error updating request status:', error);
                }
            });
        }
    });
</script>
@endsection
