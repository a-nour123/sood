<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h2 class="modal-title" id="myExtraLargeModal">{{ $title }}</h2>
                </div>
                <form action="{{ route('admin.governance.exception.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">

                    {{-- Name --}}
                    <div class="col-12" style="margin-bottom: -12px;">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.ExceptionName') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control dt-post"
                                aria-label="{{ __('locale.ExceptionName') }}" />
                            <span class="error error-name text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- Policy --}}
                    <div class="col-12" style="margin-bottom: -20px;" id="policy-select">
                        <div class="">
                            <label class="form-label">{{ __('locale.Policy') }} <span
                                    class="text-danger">*</span></label>
                            <select name="policy" id="policy-select-element1" class="form-select select2">
                                <option value=""> {{ __('locale.Select Policy') }}</option>
                                @foreach ($documents as $document)
                                    <option value="{{ $document->id }}">{{ $document->document_name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-policy text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- Risks --}}
                    <div class="col-12" style="margin-bottom: -20px;" id="risk-select">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Risk') }} <span class="text-danger">*</span></label>
                            <select name="risk" id="risk-select-element1" class="form-select select2"
                                aria-label="{{ __('locale.Risk') }}">
                                <option value="">{{ __('locale.Select Risk') }}</option>
                                @foreach ($risks as $risk)
                                    <option value="{{ $risk->id }}">{{ $risk->subject }}</option>
                                @endforeach
                            </select>
                            <span class="error error-risk text-danger my-2"></span>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: -30px;">
                        {{-- Regulator --}}
                        <div class="col-4 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.Regulator') }} <span
                                        class="text-danger"></span></label>
                                <select name="regulator" id="regulator-select-element1" class="form-select select2"
                                    aria-label="{{ __('locale.Regulator') }}">
                                    <option value=""> {{ __('locale.Select Regulator') }} </option>
                                    @foreach ($regulators as $regulator)
                                        <option value="{{ $regulator->id }}">{{ $regulator->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-regulator text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- Framework --}}
                        <div class="col-4 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.Framework') }} <span
                                        class="text-danger"></span></label>
                                <select id="framework-select-element1" name="framework" class="form-select select2"
                                    aria-label="{{ __('locale.Framework') }}">
                                    <option value=""> {{ __('locale.Select Framework') }} </option>
                                </select>
                                <span class="error error-framework text-danger my-2"></span>
                            </div>
                        </div>

                        {{-- Control --}}
                        <div class="col-4 mb-3" id="control-select">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.Control') }} <span
                                        class="text-danger">*</span></label>
                                <select name="control" id="control-select-element1" class="form-select select2"
                                    aria-label="{{ __('locale.Control') }}">
                                    <option value=""> {{ __('locale.Select Control') }} </option>
                                </select>
                                <span class="error error-control text-danger my-2"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Stakeholders --}}
                    <div class="col-12" style="margin-bottom: -12px;">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.AdditionalStakeholders') }} <span
                                    class="text-danger">*</span></label>
                            <select name="stakeholder[]" class="form-select select2" multiple="multiple"
                                aria-label="{{ __('locale.AdditionalStakeholders') }}">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-stakeholder text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- Exception duration  --}}
                    <div class="col-12 mb-3">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.ExceptionDuration') }} <span
                                    class="text-danger">*</span></label>
                            <span class="text-muted">({{ __('locale.days') }})</span>
                            <input id="request_duration" type="number" name="request_duration" class="form-control"
                                aria-label="{{ __('locale.ExceptionDuration') }}" min="1"
                                placeholder={{ __('locale.Example') }}>
                            <span class="error error-request_duration text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-12 mb-3">
                        <div class="mb-1">
                            <h4>
                                <label for="editor4">{{ __('locale.Description') }}</label>
                            </h4>
                            <div
                                style="border: 2px solid #ccc; padding: 10px; border-radius: 5px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);">
                                <textarea name="description" id="editor4" cols="30" rows="10"
                                    style="border: none; width: 100%; resize: none; outline: none;"></textarea>
                            </div>
                            <input type="hidden" id="supplemental_guidance_input" name="description">
                            <span class="error error-description text-danger my-2"></span>
                        </div>
                    </div>


                    {{-- justification --}}
                    <div class="col-12 mb-3">
                        <div class="mb-1">
                            <h4><label for="editor5">{{ __('locale.Justification') }}</label>
                            </h4>
                            <div
                                style="border: 2px solid #ccc; padding: 10px; border-radius: 5px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);">
                                <textarea name="justification" id="editor5" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <span class="error error-justification text-danger my-2"></span>
                    </div>

                    {{-- File  --}}
                    <div class="col-12 mb-3">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.File') }}</label>
                            <input type="file" name="exception_file" class="form-control dt-post"
                                aria-label="{{ __('locale.File') }}" />
                            <span class="error error-supporting_documentation "></span>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-2">
                        <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
