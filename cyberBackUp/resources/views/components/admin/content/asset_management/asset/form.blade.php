<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--
<div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="{{ $id }}">
<div class="modal-dialog sidebar-sm"> -->
            <form action="{{ route('admin.asset_management.ajax.store') }}" method="POST" class="modal-content pt-0">
                @csrf
                <input type="hidden" name="id">

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
                    {{--  <div class="mb-1">
                <label class="form-label ">{{ __('asset.AssetValue') }}</label>
                <select class="select2 form-select" name="asset_value_id" required>
                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                    @foreach ($assetValues as $assetValue)
                    <option value="{{ $assetValue->id }}">{{ $assetValue->min_value }} -
                        {{ $assetValue->max_value }}</option>
                    @endforeach
                </select>
                <span class="error error-asset_value_id"></span>
            </div>  --}}
                    <input type="hidden" name="asset_value" class="asset_value_impact_level">
                    <div class="mb-1">
                        <label class="form-label ">{{ __('asset.AssetValue') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control asset_value_impact"
                                placeholder="{{ __('asset.AssetValue') }}" aria-describedby="button-addon2" readonly
                                required>
                            <div class="input-group-append" id="button-addon2">
                                {{--  <button class="btn btn-outline-primary waves-effect" type="button">{{ __('locale.Add') }}</button>  --}}
                                <button type="button" class="btn btn-outline-primary waves-effect"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLong">{{ __('locale.Calculate') }}</button>
                            </div>
                        </div>
                        <span class="error error-asset_value"></span>
                    </div>
                    {{-- Asset category --}}
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.AssetCategory') }}</label>
                        <select class="select2 form-select" name="asset_category_id" required>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            @foreach ($assetCategories as $assetCategory)
                                <option value="{{ $assetCategory->id }}">{{ $assetCategory->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-asset_category_id"></span>
                    </div>
                    {{-- Asset Environment category --}}
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.AssetEnvironmentCategory') }}</label>
                        <select class="select2 form-select" name="asset_environment_category_id">
                            <option value="" selected>{{ __('locale.select-option') }}</option>
                            @foreach ($assetEnvironmentCategories as $assetEnvironmentCategory)
                                <option value="{{ $assetEnvironmentCategory->id }}">
                                    {{ $assetEnvironmentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error error-asset_environment_category_id"></span>
                    </div>


                    {{-- Teams --}}
                    <div class="mb-1">
                        <label class="form-label"> {{ __('locale.Teams') }}</label>
                        <select name="teams[]" class="form-select "  >
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
                    {{-- alert period --}}
                    <div class=" mb-1">
                        <label class="form-label" for="fp-default"> {{ __('locale.alert_period') }}
                            ({{ __('locale.days') }})</label>
                        <input type="number" min="1" name="alert_period" class="form-control" />
                        <span class="error error-alert_period "></span>
                    </div>


                    <div class="mb-1">
                        <label class="form-label" for="assetOwner">{{ __('asset.Asset_owner') }}</label>
                        <select class="select2 form-select" id="assetOwner" name="asset_owner">
                            <option value="" selected>{{ __('locale.select-option') }}</option>
                            @foreach ($users as $user)
                                <option @if (!$user->enabled) disabled @endif value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error asset_owner "></span>

                    </div>

                    {{-- url --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.AssetUrl') }}</label>
                        <input type="url" name="url" class="form-control "
                            aria-label="{{ __('asset.AssetUrl') }}" />
                        <span class="error error-url "></span>
                    </div>

                    {{-- Os --}}
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.so') }}</label>
                        <select class="select2 form-select" name="os">
                            <option value="" selected>{{ __('locale.select-option') }}</option>
                            @foreach ($operatingSystems as $operatingSystem)
                                <option value="{{ $operatingSystem->id }}">{{ $operatingSystem->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error error-os"></span>
                    </div>

                    {{-- os_version --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.AssetOsVersion') }}</label>
                        <input type="text" name="os_version" class="form-control "
                            aria-label="{{ __('asset.Assetos_version') }}" />
                        <span class="error error-os_version "></span>
                    </div>

                    {{-- physical_virtual_type --}}
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.physical_virtual_type') }}</label>
                        <select class="select2 form-select" name="physical_virtual_type">
                            <option value="" selected>{{ __('locale.select-option') }}</option>
                            <option value="0">{{ __('locale.Virtual') }} </option>
                            <option value="1">{{ __('locale.Physical') }} </option>
                        </select>
                        <span class="error error-physical_virtual_type"></span>
                    </div>

                    {{-- owner_asset --}}



                    {{-- owner_email --}}
                    {{-- <div class="mb-1">
                <label class="form-label">{{ __('asset.owner_email') }}</label>
                <input type="email" name="owner_email" class="form-control "
                    aria-label="{{ __('asset.owner_email') }}"  />
                <span class="error error-owner_email "></span>
            </div> --}}

                    {{-- owner_manager_email
            <div class="mb-1">
                <label class="form-label">{{ __('asset.owner_manager_email') }}</label>
                <input type="email" name="owner_manager_email" class="form-control "
                    aria-label="{{ __('asset.owner_manager_email') }}"  />
                <span class="error error-owner_manager_email "></span>
            </div> --}}

                    {{-- project_vlan --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.project_vlan') }}</label>
                        <input type="text" name="project_vlan" class="form-control "
                            aria-label="{{ __('asset.project_vlan') }}" />
                        <span class="error error-project_vlan "></span>
                    </div>

                    {{-- vlan --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.vlan') }}</label>
                        <input type="text" name="vlan" class="form-control "
                            aria-label="{{ __('asset.vlan') }}" />
                        <span class="error error-vlan "></span>
                    </div>

                    {{-- vendor_name --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.vendor_name') }}</label>
                        <input type="text" name="vendor_name" class="form-control "
                            aria-label="{{ __('asset.vendor_name') }}" />
                        <span class="error error-vendor_name "></span>
                    </div>

                    {{-- model --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.model') }}</label>
                        <input type="text" name="model" class="form-control "
                            aria-label="{{ __('asset.model') }}" />
                        <span class="error error-model "></span>
                    </div>

                    {{-- firmware --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.firmware') }}</label>
                        <input type="text" name="firmware" class="form-control "
                            aria-label="{{ __('asset.firmware') }}" />
                        <span class="error error-firmware "></span>
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

                    {{-- rack_location --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.rack_location') }}</label>
                        <input type="text" name="rack_location" class="form-control "
                            aria-label="{{ __('asset.rack_location') }}" />
                        <span class="error error-rack_location "></span>
                    </div>


                    {{-- city --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.city') }}</label>
                        <input type="text" name="city" class="form-control "
                            aria-label="{{ __('asset.city') }}" />
                        <span class="error error-city "></span>
                    </div>

                    {{-- mac_address --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.mac_address') }}</label>
                        <input type="text" name="mac_address" class="form-control "
                            aria-label="{{ __('asset.mac_address') }}" />
                        <span class="error error-mac_address "></span>
                    </div>

                    {{-- subnet_mask --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('asset.subnet_mask') }}</label>
                        <input type="text" name="subnet_mask" class="form-control "
                            aria-label="{{ __('asset.subnet_mask') }}" />
                        <span class="error error-subnet_mask "></span>
                    </div>

                    {{-- Details --}}
                    <div class="mb-1">
                        <label class="form-label"
                            for="exampleFormControlTextarea1">{{ __('asset.AssetDetails') }}</label>
                        <textarea class="form-control" name="details" rows="3"></textarea>
                        <span class="error error-details "></span>
                    </div>
                    {{-- Region --}}
                    <div class="mb-1">
                        <label class="form-label"
                            for="exampleFormControlTextarea1">{{ __('asset.Region') }}</label>
                            <select class="select2 form-select" id="region_id" name="region_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error error-region_id "></span>
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
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('locale.Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
