<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" >{{ __('locale.Edit Assets') }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
<!-- <div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="{{ $id }}">
    <div class="modal-dialog sidebar-sm"> -->
        <form action="{{ route('admin.asset_management.ajax.store') }}" method="POST" class="modal-content pt-0">
            @csrf
            <input type="hidden" name="id">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ __('locale.Edit Assets') }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                {{-- Name --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('asset.AssetName') }}</label>
                    <input type="text" name="name" class="form-control dt-post"
                        aria-label="{{ __('asset.AssetName') }}" required />
                    <span class="error error-name "></span>
                </div>
                {{-- IP --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.IPAddress') }}</label>
                    <input type="text" name="ip" minlength="7" maxlength="15" size="15"
                        pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$"
                        class="form-control dt-post" aria-label="{{ __('locale.IPAddress') }}"
                        oninvalid="this.setCustomValidity(`{{ __('locale.IPFormatNotRecognized') }}`)"
                        oninput="this.setCustomValidity('')" />
                    <span class="error error-ip "></span>
                </div>
                {{-- Asset value --}}
                <div class="mb-1">
                    <label class="form-label ">{{ __('asset.AssetValue') }}</label>
                    <select class="select2 form-select" name="asset_value_id" required>
                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                        @foreach ($assetValues as $assetValue)
                            <option value="{{ $assetValue->id }}">{{ $assetValue->min_value }} -
                                {{ $assetValue->max_value }}</option>
                        @endforeach
                    </select>
                    <span class="error error-asset_value_id"></span>
                </div>
                {{-- Location --}}
                <div class="mb-1">
                    <label class="form-label ">{{ __('asset.AssetSiteLocation') }}</label>
                    <select class="select2 form-select" name="location_id">
                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error-location_id"></span>
                </div>
                {{-- Teams --}}
                <div class="mb-1">
                    <label class="form-label"> {{ __('locale.Teams') }}</label>
                    <select name="teams[]" class="form-select multiple-select2" multiple="multiple">
                        <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error-teams "></span>
                </div>
                {{-- Tags --}}
                <div class="mb-1">
                    <label class="form-label"> {{ __('locale.Tags') }}</label>
                    <select name="tags[]" class="form-select multiple-select2" multiple="multiple">
                        <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                        @endforeach
                    </select>
                    <span class="error error-tags "></span>
                </div>
                {{-- <select id="multi-select" name="select" multiple="multiple">
               <option value="value1">Value 1</option>
               <option value="value2">Value 2</option>
               <option value="value3">Value 3</option>
               <option value="value4" disabled>Value 4 (disabled)</option>
               <option value="value5">Value 5</option>
           </select> --}}
                {{-- Start date --}}
                <div class=" mb-1">
                    <label class="form-label" for="fp-default"> {{ __('locale.StartDate') }}</label>
                    <input name="start_date" class="form-control flatpickr-date-time-compliance"
                        placeholder="YYYY-MM-DD" />
                    <span class="error error-start_date "></span>

                </div>
                {{-- Expiration date --}}
                <div class=" mb-1">
                    <label class="form-label" for="fp-default"> {{ __('locale.EndDate') }}</label>
                    <input name="expiration_date" class="form-control flatpickr-date-time-compliance"
                        placeholder="YYYY-MM-DD" />
                    <span class="error error-expiration_date "></span>
                </div>

                {{-- Details --}}
                <div class="mb-1">
                    <label class="form-label"
                        for="exampleFormControlTextarea1">{{ __('asset.AssetDetails') }}</label>
                    <textarea class="form-control" name="details" rows="3"></textarea>
                    <span class="error error-details "></span>
                </div>

                {{-- Verified --}}
                <div class=" mb-1">
                    <div class="d-flex flex-column">
                        <label class="form-label"> {{ __('asset.VerifiedAssets') }}</label>
                        <div class="form-check form-switch form-check-success">
                            <input type="checkbox" name="verified" class="form-check-input"
                                id="customSwitch111" />
                            <label class="form-check-label" for="customSwitch111">
                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="Submit" class="btn btn-primary data-submit me-1">
                    {{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
</div>

