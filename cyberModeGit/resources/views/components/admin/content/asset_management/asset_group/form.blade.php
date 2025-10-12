<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.asset_management.ajax.asset_group.store') }}" method="POST"
                class="modal-content pt-0">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body flex-grow-1">
                    {{-- Name --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('locale.Name') }}</label>
                        <input type="text" name="name" class="form-control dt-post"
                            aria-label="{{ __('asset.AssetGroupName') }}" required />
                        <span class="error error-name "></span>
                    </div>
                    {{-- Assets --}}
                    <div class="mb-1">
                        <label class="form-label"> {{ __('asset.Assets') }}</label>
                        <select name="assets[]" id="asset-list" class="form-select multiple-select2"
                            multiple="multiple">
                            <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                        </select>
                        <span class="error error-assets"></span>
                    </div>

                    <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('locale.Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
