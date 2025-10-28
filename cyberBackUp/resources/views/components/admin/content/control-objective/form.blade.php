<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('admin.control_objectives.ajax.store') }}" method="POST" class="modal-content pt-0">
            @csrf
            <input type="hidden" name="id">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body flex-grow-1">
                {{-- Name --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Code') }}</label>
                    <input type="text" name="name" class="form-control dt-post"
                        aria-label="{{ __('locale.Code') }}" required />
                    <span class="error error-name "></span>
                </div>
                {{-- Description --}}
                <div class="mb-1">
                    <label class="form-label" for="description">{{ __('locale.Description_English') }}</label>
                    <div id="quill-editor" class="form-control" style="min-height: 150px;"></div>
                    <input type="hidden" name="description_en">
                    <span class="error error-description_en"></span>
                </div>

                {{-- Description --}}
                <div class="mb-1">
                    <label class="form-label" for="description">{{ __('locale.Description_Arabic') }}</label>
                    <div id="quill-editor-2" class="form-control" style="min-height: 150px;"></div>
                    <input type="hidden" name="description_ar">
                    <span class="error error-description_ar"></span>
                </div>

                {{-- Frameworks --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Frameworks') }}</label>
                    <select class="frameworksToControl select2 form-select" name="framework_id[]" multiple="multiple">
                        <option disabled value="">{{ __('locale.Framework') }}</option>
                        @foreach ($frameworks as $framework)
                            <option value="{{ $framework->id }}">{{ $framework->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error-framework_id"></span>
                </div>

                <!-- FrameworkControls -->
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.FrameworkControls') }}</label>
                    <select class="controlsIdsToFrame select2 form-select" name="control_id[]" multiple="multiple">
                        <option disabled value="">{{ __('locale.SelectControl') }}</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                    <span class="error error-control_id"></span>
                </div>
                <button type="Submit" class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
