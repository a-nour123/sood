<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <div class="text-center mb-4">
                    <h2 class="modal-title" id="myExtraLargeModal">{{ $title }}</h2>
                </div>
                <form action="{{ route('admin.governance.exception.config.store') }}" method="POST"
                    class="modal-content pt-4 p-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">

                    <div class="row">

                        {{-- Policy Approver --}}
                        <div class="col-12 mb-3" id="policy_approver">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.PolicyApprover') }} <span
                                        class="text-danger">*</span></label>
                                <select name="policy_approver" class="form-control dt-post"
                                    aria-label="{{ __('locale.PolicyApprover') }}">
                                    <option value="0"
                                        {{ $exceptionSettings[0]['policy_approver'] == 0 ? 'selected' : '' }}>
                                        {{ __('locale.PolicyOwner') }}
                                    </option>
                                    <option value="1"
                                        {{ $exceptionSettings[0]['policy_approver'] == 1 ? 'selected' : '' }}>
                                        {{ __('locale.AnyPerson') }}
                                    </option>

                                </select>
                                <span class="error error-policy text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- policy approver user --}}
                        <div class="col-12 mb-3" id="policy_approver_user" style="display: none;">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.PleaseSelectThePolicyApprover') }} <span
                                        class="text-danger">*</span></label>
                                <select name="policy_approver_id" class="form-control dt-post"
                                    aria-label="{{ __('locale.PleaseSelectThePolicyApprover') }}">
                                    <option value="" selected> -- </option>
                                    @foreach ($departmentsManagers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $exceptionSettings[0]['policy_approver_id'] ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-owner text-danger my-2"></span>
                            </div>
                        </div>
                        {{-- Policy Reviewer --}}
                        {{-- <div class="col-12 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.PolicyReviewer') }} <span
                                        class="text-danger">*</span></label>
                                <select name="policy_reviewer" class="form-control dt-post"
                                    aria-label="{{ __('locale.PolicyReviewer') }}">
                                    <option value="" selected> -- </option>
                                    <option value="0"
                                        {{ $exceptionSettings[0]['policy_reviewer'] == 0 ? 'selected' : '' }}>
                                        {{ __('locale.ExceptionOwner') }}
                                    </option>
                                    <option value="1"
                                        {{ $exceptionSettings[0]['policy_reviewer'] == 1 ? 'selected' : '' }}>
                                        {{ __('locale.PolicyOwner') }}
                                    </option>
                                    <option value="2"
                                        {{ $exceptionSettings[0]['policy_reviewer'] == 2 ? 'selected' : '' }}>
                                        {{ __('locale.AnyPerson') }}
                                    </option>
                                </select>
                                <span class="error error-policy text-danger my-2"></span>
                            </div>
                        </div> --}}

                        {{-- Control approver --}}
                        <div class="col-12 mb-3" id="control_approver">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.ControlApprover') }} <span
                                        class="text-danger">*</span></label>
                                <select name="control_approver" class="form-control dt-post"
                                    aria-label="{{ __('locale.ControlApprover') }}">
                                    <option value="0"
                                        {{ $exceptionSettings[0]['control_approver'] == 0 ? 'selected' : '' }}>
                                        {{ __('locale.ControlOwner') }}
                                    </option>
                                    <option value="1"
                                        {{ $exceptionSettings[0]['control_approver'] == 1 ? 'selected' : '' }}>
                                        {{ __('locale.AnyPerson') }}
                                    </option>
                                </select>
                                <span class="error error-policy text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- control approver user --}}
                        <div class="col-12 mb-3" id="control_approver_user" style="display: none;">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.PleaseSelectTheControlApprover') }} <span
                                        class="text-danger">*</span></label>
                                <select name="control_approver_id" class="form-control dt-post"
                                    aria-label="{{ __('locale.PleaseSelectThePolicyApprover') }}">
                                    <option value="" selected> -- </option>
                                    @foreach ($departmentsManagers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $exceptionSettings[0]['control_approver_id'] ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-owner text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- Control Reviewer --}}
                        {{-- <div class="col-12 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.ControlReviewer') }} <span
                                        class="text-danger">*</span></label>
                                <select name="control_reviewer" class="form-control dt-post"
                                    aria-label="{{ __('locale.ControlReviewer') }}">
                                    <option value="" selected> -- </option>
                                    <option value="0"
                                        {{ $exceptionSettings[0]['control_reviewer'] == 0 ? 'selected' : '' }}>
                                        {{ __('locale.ExceptionOwner') }}
                                    </option>
                                    <option value="1"
                                        {{ $exceptionSettings[0]['control_reviewer'] == 1 ? 'selected' : '' }}>
                                        {{ __('locale.ControlOwner') }}
                                    </option>
                                    <option value="2"
                                        {{ $exceptionSettings[0]['control_reviewer'] == 2 ? 'selected' : '' }}>
                                        {{ __('locale.AnyPerson') }}
                                    </option>
                                </select>
                                <span class="error error-policy text-danger my-2"></span>
                            </div>
                        </div> --}}


                        {{-- Risk approver --}}
                        <div class="col-12 mb-3" id="risk_approver">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.RiskApprover') }} <span
                                        class="text-danger">*</span></label>
                                <select name="risk_approver" class="form-control dt-post"
                                    aria-label="{{ __('locale.RiskApprover') }}">
                                    <option value="0"
                                        {{ $exceptionSettings[0]['risk_approver'] == 0 ? 'selected' : '' }}>
                                        {{ __('locale.RiskOwner') }}
                                    </option>
                                    <option value="1"
                                        {{ $exceptionSettings[0]['risk_approver'] == 1 ? 'selected' : '' }}>
                                        {{ __('locale.AnyPerson') }}
                                    </option>
                                </select>
                                <span class="error error-risk text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- Risk approver user --}}
                        <div class="col-12 mb-3" id="risk_approver_user" style="display: none;">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.PleaseSelectTheRiskApprover') }} <span
                                        class="text-danger">*</span></label>
                                <select name="risk_approver_id" class="form-control dt-post"
                                    aria-label="{{ __('locale.PleaseSelectTheRiskApprover') }}">
                                    <option value="" selected> -- </option>
                                    @foreach ($departmentsManagers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $exceptionSettings[0]['risk_approver_id'] ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-owner text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- Risk Reviewer --}}
                        {{-- <div class="col-12 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.RiskReviewer') }} <span
                                        class="text-danger">*</span></label>
                                <select name="risk_reviewer" class="form-control dt-post"
                                    aria-label="{{ __('locale.RiskReviewer') }}">
                                    <option value="" selected> -- </option>
                                    <option value="0"
                                        {{ $exceptionSettings[0]['risk_reviewer'] == 0 ? 'selected' : '' }}>
                                        {{ __('locale.ExceptionOwner') }}
                                    </option>
                                    <option value="1"
                                        {{ $exceptionSettings[0]['risk_reviewer'] == 1 ? 'selected' : '' }}>
                                        {{ __('locale.RiskOwner') }}
                                    </option>
                                    <option value="2"
                                        {{ $exceptionSettings[0]['risk_reviewer'] == 2 ? 'selected' : '' }}>
                                        {{ __('locale.AnyPerson') }}
                                    </option>
                                </select>
                                <span class="error error-risk text-danger my-2"></span>
                            </div>
                        </div> --}}
                    </div>
                    <button type="Submit" class="btn btn-primary data-submit me-1">
                        {{ __('locale.Submit') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>


<script>
    document.querySelector('#policy_approver select[name="policy_approver"]').addEventListener('change', function() {
        var approverSelectDiv = document.getElementById('policy_approver_user');
        if (this.value == "1") { // "AnyPerson" option has value "1"
            approverSelectDiv.style.display = 'block';
        } else {
            approverSelectDiv.style.display = 'none';
        }
    });

    // Optional: Trigger the change event on page load to set the initial state
    document.querySelector('#policy_approver select[name="policy_approver"]').dispatchEvent(new Event('change'));
</script>

<script>
    document.querySelector('#control_approver select[name="control_approver"]').addEventListener('change', function() {
        var approverSelectDiv = document.getElementById('control_approver_user');
        if (this.value == "1") { // "AnyPerson" option has value "1"
            approverSelectDiv.style.display = 'block';
        } else {
            approverSelectDiv.style.display = 'none';
        }
    });

    // Optional: Trigger the change event on page load to set the initial state
    document.querySelector('#control_approver select[name="control_approver"]').dispatchEvent(new Event('change'));
</script>

<script>
    document.querySelector('#risk_approver select[name="risk_approver"]').addEventListener('change', function() {
        var approverSelectDiv = document.getElementById('risk_approver_user');
        if (this.value == "1") { // "AnyPerson" option has value "1"
            approverSelectDiv.style.display = 'block';
        } else {
            approverSelectDiv.style.display = 'none';
        }
    });

    // Optional: Trigger the change event on page load to set the initial state
    document.querySelector('#risk_approver select[name="risk_approver"]').dispatchEvent(new Event('change'));
</script>
