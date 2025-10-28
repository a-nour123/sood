<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="incidentForm" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="id">
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">{{ $title }}</h5>
                    </div> -->
                <div class="modal-body flex-grow-1">
                    {{-- Name --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.summary') }}</label>
                                <input type="text" name="summary" class="form-control dt-post"
                                    aria-label="{{ __('incident.summary') }}" required />
                                <span class="error error-summary "></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.details') }}</label>
                                <textarea type="text" name="details" class="form-control dt-post" aria-label="{{ __('incident.details') }}" required></textarea>
                                <span class="error error-details "></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.occurrence_name') }}</label>
                                <select class="select2 form-select" name="occurrence_id" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-occurrence_id"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.Direction') }}</label>
                                <select class="select2 form-select" name="direction_id" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-direction_id"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.Tlp') }}</label>
                                <select class="select2 form-select" name="tlp_id" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($tlp as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-tlp_id"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.Pap') }}</label>
                                <select class="select2 form-select" name="pap_id" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($pap as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-pap_id"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.Attack') }}</label>
                                <select class="select2 form-select" name="attack_id" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($attacks as $attack)
                                        <option value="{{ $attack->id }}">{{ $attack->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-attack_id"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.detected_name') }}</label>
                                <select class="select2 form-select" name="detected_id" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($detects as $detect)
                                        <option value="{{ $detect->id }}">{{ $detect->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-detected_id"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.status') }}</label>
                                <select class="select2 form-select" name="status" required>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    <option value="open">{{ __('incident.open') }}</option>
                                    <option value="progress">{{ __('incident.progress') }}</option>
                                    <option value="closed">{{ __('incident.closed') }}</option>

                                </select>
                                <span class="error error-status "></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.Detected_on') }}</label>
                                <input type="datetime-local" name="detected_on" class="form-control dt-post"
                                    aria-label="{{ __('incident.detected_on') }}" required />
                                <span class="error error-detected_on "></span>
                            </div>
                        </div>

                        <!-- File Upload Field -->
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">{{ __('incident.attachments') }}</label>
                                <input type="file" name="file[]" class="form-control" multiple
                                    accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx" />
                            </div>
                        </div>

                    </div>

                    <button id="submit-form" class="btn btn-primary data-submit me-1 mt-3">
                        {{ __('locale.Submit') }}</button>
                    <!-- <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
