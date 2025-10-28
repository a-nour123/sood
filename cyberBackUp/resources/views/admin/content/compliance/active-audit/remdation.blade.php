<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
<style>
    body {
        background-color: #f4f4f4;
    }

    .form-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        color: #333;
        font-weight: bold;
    }

    .form-control,
    .form-select {
        background-color: #f9f9fa;
        border: 1px solid #ced4da;
        border-radius: 4px;
        color: #495057;
    }

    .form-control:disabled,
    .form-select:disabled {
        background-color: #f1f3f5;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .form-check-label {
        color: #333;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary:hover {
        color: #0056b3;
        border-color: #004085;
    }

    .error {
        color: #dc3545;
    }

    .text-muted {
        color: #6c757d;
    }

    .btn-guide {
        display: inline-block;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        color: #fff;
        background-color: #17a2b8;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid #17a2b8;
    }

    .btn-guide:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-guide:focus {
        outline: none;
    }

    .clickable-link {
        color: #007bff;
        text-decoration: underline;
        cursor: pointer;
    }

    .clickable-link:hover {
        color: #0056b3;
        text-decoration: none;
    }

    .clickable-link i {
        font-size: 16px;
        color: #007bff;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        outline: 0;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: 0.5rem;
        pointer-events: none;
    }

    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 0.3rem;
        outline: 0;
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(0.3rem - 1px);
        border-top-right-radius: calc(0.3rem - 1px);
    }

    .modal-title {
        margin-bottom: 0;
        line-height: 1.5;
    }

    .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 1rem;
    }

    .modal-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        padding: 0.75rem;
        border-top: 1px solid #dee2e6;
        border-bottom-right-radius: calc(0.3rem - 1px);
        border-bottom-left-radius: calc(0.3rem - 1px);
    }

    .btn-close {
        padding: 0.5rem 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
        background-color: transparent;
        border: 0;
        -webkit-appearance: none;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        cursor: pointer;
    }

    .btn-close:hover {
        opacity: .75;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }
    }

    @media (min-width: 992px) {
        .modal-dialog {
            max-width: 800px;
        }
    }
</style>

<div>
    <div class="container-fluid mt-4">
        <div class="form-container">
            <form class="audit-update" id="submit-audit-update"
                action="{{ route('admin.compliance.ajax.aduit-details.updateCurrentAduit') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" value="{{ $existingUserOrTeam->responsible_type }}" name="responsible_type"
                    id="responsible_type">

                <div class="row gy-3">
                    <!-- Summary -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="summary">{{ __('locale.Summary') }}</label>
                            <textarea class="form-control" id="summary" rows="3" name="summary"
                                placeholder="{{ __('locale.Enter summary here...') }}" {{ $editable ? '' : 'disabled' }}>{{ $frameworkControlTestResult->summary }}</textarea>
                            <span class="text-danger error error-summary"></span>
                        </div>
                    </div>

                    <!-- Remediation Needed -->
                    <div class="col-12">
                        <label class="form-label d-block">{{ __('locale.Remediation Needed?') }}</label>
                        <div class="d-inline-block me-3">
                            <input class="form-check-input" type="radio" name="remediation" id="remediation_yes"
                                value="1" {{ $frameworkControlTestResult->remediation == '1' ? 'checked' : '' }}
                                {{ $editable ? '' : 'disabled' }}>
                            <label class="form-check-label ms-2" for="remediation_yes">{{ __('locale.Yes') }}</label>
                        </div>
                        <div class="d-inline-block">
                            <input class="form-check-input" type="radio" name="remediation" id="remediation_no"
                                value="0" {{ $frameworkControlTestResult->remediation == '0' ? 'checked' : '' }}
                                {{ $editable ? '' : 'disabled' }}>
                            <label class="form-check-label ms-2" for="remediation_no">{{ __('locale.No') }}</label>
                        </div>
                        @if ($frameworkControlTestResult->remediation != '0')
                            <span class="clickable-link ms-3" id="showRemediationModal">
                                <i class="fas fa-arrow-right me-2"></i>{{ __('locale.Remediation Details') }}
                            </span>
                        @endif
                    </div>

                    <!-- Action Dropdown -->
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="action_status">{{ __('compliance.AuditStatus') }}</label>
                            <select class="form-select" id="action_status" name="action_status"
                                {{ $editable ? '' : 'disabled' }}>
                                <option value="0"
                                    {{ $frameworkControlTestAudit->action_status == 0 ? 'selected' : '' }}>
                                    {{ __('locale.Open') }}
                                </option>
                                <option value="1"
                                    {{ $frameworkControlTestAudit->action_status == 1 ? 'selected' : '' }}>
                                    {{ __('locale.Closed') }}
                                </option>
                            </select>
                            <span class="text-danger error error-action_status"></span>
                        </div>
                    </div>

                    <!-- Teams -->
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="mb-1">
                            @php
                                $label =
                                    $existingUserOrTeam->responsible_type == 'users'
                                        ? __('locale.Users')
                                        : __('locale.Teams');
                            @endphp

                            <label class="form-label" for="teams">{{ $label }}</label>

                            <select class="form-select multiple-select2" name="teams[]" id="teams"
                                multiple="multiple" {{ $editable ? '' : 'disabled' }}>
                                <option select disabled value="">{{ __('locale.select-option') }} </option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}"
                                        {{ optionMultiSelect($team->id, $testTeams) }}>
                                        {{ $team->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-teams "></span>
                        </div>
                    </div>

                    @if ($editable)
                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn btn-primary me-2" id="openRemediationModal">
                                {{ __('locale.Remediation Details') }}
                            </button>

                            <button type="button" id="submit-audit" class="btn btn-primary">
                                {{ __('locale.Submit') }}
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Remediation Details -->
<div class="modal" id="remediationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('locale.Remediation Details') }}</h4>
                <button type="button" class="btn-close" id="closeRemediationModal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="remediationForm">
                    @csrf
                    <div class="row">
                        <!-- Select User -->
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label"
                                    for="responsible_user">{{ __('locale.Responsible User') }}</label>
                                <select class="form-select" id="responsible_user" name="responsible_user"
                                    {{ $editable ? '' : 'disabled' }}>
                                    <option value="" disabled>{{ __('locale.select-option') }}</option>
                                    @foreach ($enabledUsers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ (isset($remediationDetails) && $remediationDetails->responsible_user == $user->id) || $user->id == $controlOwner ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Budgetary -->
                        <div class="col-xl-6 col-md-6 col-12" disabled>
                            <div class="mb-1">
                                <label class="form-label" {{ $editable ? '' : 'disabled' }}
                                    for="budgetary">{{ __('locale.Budgetary') }}</label>
                                <input type="number" class="form-control" id="budgetary" name="budgetary" disabled
                                    value="{{ isset($remediationDetails) ? $remediationDetails->budgetary : '' }}">
                            </div>
                        </div>

                        <input type="hidden" name="controlTestId" value="{{ $id }}">
                        <!-- Status -->
                        <div class="col-xl-6 col-md-6 col-12" {{ $editable ? '' : 'disabled' }} disabled>
                            <div class="mb-1">
                                <label class="form-label" for="status">{{ __('locale.Status') }}</label>
                                <select class="form-select" id="status" name="status" disabled>
                                    <option value="" disabled>{{ __('locale.select-option') }}</option>
                                    <option value="1"
                                        {{ isset($remediationDetails) && $remediationDetails->status == 1 ? 'selected' : '' }}>
                                        {{ __('locale.Approved') }}
                                    </option>
                                    <option value="2"
                                        {{ isset($remediationDetails) && $remediationDetails->status == 2 ? 'selected' : '' }}>
                                        {{ __('locale.Rejected') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <div class="col-xl-6 col-md-6 col-12" {{ $editable ? '' : 'disabled' }} disabled>
                            <div class="mb-1">
                                <label class="form-label" for="due_date">{{ __('locale.Due Date') }}</label>
                                <input type="date" class="form-control flatpickr-date-time-compliance"
                                    id="due_date" name="due_date"
                                    value="{{ isset($remediationDetails) ? $remediationDetails->due_date : '' }}">
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="col-12" {{ $editable ? '' : 'disabled' }} disabled>
                            <div class="mb-1">
                                <label class="form-label" for="comments">{{ __('locale.Comments') }}</label>
                                <textarea class="form-control" id="comments" name="comments" rows="2">{{ isset($remediationDetails) ? $remediationDetails->comments : '' }}</textarea>
                            </div>
                        </div>

                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Corrective') }}</label>
                            <div id="corrective_action_plan_editor" style="height:100px;">
                                {!! isset($remediationDetails) ? $remediationDetails->corrective_action_plan : '' !!}
                            </div>
                        </div>
                        <input type="hidden" name="corrective_action_plan" id="corrective_action_plan_hidden">
                    </div>
                </form>
            </div>
            @if ($editable)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        id="closeRemediationModalFooter">{{ __('locale.Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="saveChangesBtnRemidation">{{ __('locale.Save Changes') }}</button>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('cdn/jquery6.js') }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Quill editor
        var quill = new Quill('#corrective_action_plan_editor', {
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
            },
        });

        // Modal functionality
        function showModal() {
            $('#remediationModal').fadeIn();
        }

        function hideModal() {
            $('#remediationModal').fadeOut();
        }

        // Event handlers for modal
        $('#showRemediationModal, #openRemediationModal').on('click', showModal);
        $('#closeRemediationModal, #closeRemediationModalFooter').on('click', hideModal);

        // Close modal when clicking outside
        $(document).on('click', function(e) {
            if ($(e.target).is('#remediationModal')) {
                hideModal();
            }
        });

        // Remediation radio button behavior
        $('#remediation_yes').on('change', function() {
            if (this.checked) {
                showModal();
            }
        });

        // Save remediation details
        $('#saveChangesBtnRemidation').on('click', function() {
            // Get the HTML content from Quill editor
            var correctiveActionPlan = quill.root.innerHTML;

            // Store the HTML content in the hidden input field
            $('#corrective_action_plan_hidden').val(correctiveActionPlan);

            // Serialize form data
            var formData = $('#remediationForm').serialize();

            $.ajax({
                url: "{{ route('admin.compliance.ajax.remediation-details.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        makeAlert('success', response.message,
                            "{{ __('locale.Success') }}");
                        hideModal();
                    } else {
                        showError(response.errors);
                    }
                },
                error: function(response) {
                    var responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });

        // Submit audit form
        $('#submit-audit').on('click', function(e) {
            e.preventDefault();

            var form = $('#submit-audit-update');
            var data = new FormData(form[0]);
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    makeAlert('success', response.message, "{{ __('locale.Success') }}");
                },
                error: function(xhr) {
                    var responseData = xhr.responseJSON;

                    makeAlert('error', responseData.message || "{{ __('locale.Error') }}",
                        "{{ __('locale.Error') }}");

                    // Clear previous errors
                    $('.text-danger.error').text('');

                    if (responseData.errors) {
                        $.each(responseData.errors, function(key, value) {
                            var errorSpan = $('.error-' + key);
                            if (errorSpan.length) {
                                errorSpan.text(value[0]);
                            }
                        });
                    }
                }
            });
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

    });
</script>
