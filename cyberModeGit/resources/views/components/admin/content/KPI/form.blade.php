<!-- Modal Structure -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog sidebar-sm">
        <form action="{{ route('admin.KPI.ajax.store') }}" method="POST" class="modal-content pt-0" id="kpi-form">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body flex-grow-1">
                {{-- Hidden ID Field --}}
                <input type="hidden" name="id">

                {{-- Title --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Title') }}</label>
                    <input type="text" name="title" class="form-control dt-post" aria-label="{{ __('locale.Title') }}" required />
                    <span class="error error-title"></span>
                </div>

                {{-- Description --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Description') }}</label>
                    <textarea required class="form-control" name="description" rows="3"></textarea>
                    <span class="error error-description"></span>
                </div>

                {{-- Department --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Department') }}</label>
                    <select class="select2 form-select" name="department">
                        <option value="" hidden disabled selected>{{ __('locale.select-option') }}</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error-department"></span>
                </div>

                {{-- Value Type --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Type') }}</label>
                    <select class="select2 form-select" name="value_type" id="value_type_select">
                        <option value="" hidden disabled selected>{{ __('locale.select-option') }}</option>
                        <option value="Time">{{ __('locale.Time') }}</option>
                        <option value="Percentage">{{ __('locale.Percentage') }}</option>
                        <option value="Number">{{ __('locale.Number') }}</option>
                    </select>
                    <span class="error error-value_type"></span>
                </div>

                {{-- Value --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Value') }}</label>
                    <input type="text" name="value" id="value_input" class="form-control dt-post" aria-label="{{ __('locale.Value') }}" required />
                    <span class="error error-value"></span>
                </div>

                {{-- Period of Assessment --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Period') }}</label>
                    <select class="select2 form-select" name="period_of_assessment">
                        <option value="" hidden disabled selected>{{ __('locale.select-option') }}</option>
                        <option value="3">3 {{ __('locale.Months') }}</option>
                        <option value="6">6 {{ __('locale.Months') }}</option>
                        <option value="9">9 {{ __('locale.Months') }}</option>
                        <option value="12">12 {{ __('locale.Months') }}</option>
                    </select>
                    <span class="error error-period_of_assessment"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
