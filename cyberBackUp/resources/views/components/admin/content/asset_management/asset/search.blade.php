<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                    <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">
                            {{-- @if (auth()->user()->hasPermission('asset.create'))
                                <button class="dt-button btn btn-primary me-1" type="button" data-bs-toggle="modal"
                                    data-bs-target="#{{ $createModalID }}">
                                    {{ __('asset.AddANewAsset') }}
                                </button>
                                <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                    class="dt-button btn btn-primary me-2" target="_self">
                                    {{ __('locale.NotificationsSettings') }}
                                </a>
                            @endif --}}

                            {{--  @if (auth()->user()->hasPermission('asset.export'))
                                <button id="export-assets-btn" class="dt-button btn btn-primary me-2" target="_self">
                                    {{ __('locale.Export') }}
                                </button>
                            @endif  --}}

{{-- 
                            @if (auth()->user()->hasPermission('asset.export'))
                                <button id="openexportAssetModal" class="btn btn-primary me-2"
                                data-bs-toggle="modal" data-bs-target="#exportAssetModal">
                                    {{ __('locale.Export') }}
                                </button>
                            @endif

                            @if (auth()->user()->hasPermission('asset.create'))
                                <a href="{{ route('admin.asset_management.import') }}"
                                    class="dt-button btn btn-primary me-2" target="_self">
                                    {{ __('locale.Import') }}
                                </a>
                            @endif --}}


                            <!-- Import and export container -->
                            {{-- <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                exportPermissionKey='asset.export' exportRouteKey='admin.asset_management.ajax.export'
                                importRouteKey='admin.asset_management.import' /> --}}
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.AssetName') }}:</label>
                                <input class="form-control dt-input" name="filter_name" data-column="1"
                                    data-column-index="0" type="text">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.IPAddress') }}:</label>
                                <input class="form-control dt-input" name="filter_ip" data-column="2"
                                    data-column-index="1" type="text">
                            </div>
                            {{-- This input for allow global search without custom advanced column search --}}
                            <input hidden name="filter_tags">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.AssetSiteLocation') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_location"
                                    id="AssetSiteLocation" data-column="5" data-column-index="3">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->name }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.AssetCategory') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_assetCategory"
                                    id="AssetCategory" data-column="4" data-column-index="4">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($assetCategories as $assetCategory)
                                        <option value="{{ $assetCategory->name }}">{{ $assetCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.Regions') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_regions">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-3">
                                <label class="form-label">{{ __('locale.Email_Owner') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_owner_email">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>

                </form>
            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('asset.AssetName') }}</th>
                            <th>{{ __('locale.IPAddress') }}</th>
                            <th>{{ __('locale.AssetValue') }}</th>
                            <th>{{ __('locale.AssetCategory') }}</th>
                            <th>{{ __('locale.AssetSiteLocation') }}</th>
                            <th>{{ __('locale.so') }}</th>
                            <th>{{ __('locale.AssetEnvironmentCategory') }}</th>
                            <th>{{ __('asset.Asset_owner') }}</th>
                            <th>{{ __('asset.Owner_Email') }}</th>
                            <th>{{ __('asset.model') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.UpdatedDate') }}</th>
                            <th>{{ __('locale.VerifiedAssets') }}</th>
                            <th>{{ __('locale.regions') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('asset.AssetName') }}</th>
                            <th>{{ __('locale.IPAddress') }}</th>
                            <th>{{ __('locale.AssetValue') }}</th>
                            <th>{{ __('locale.AssetCategory') }}</th>
                            <th>{{ __('locale.AssetSiteLocation') }}</th>
                            <th>{{ __('locale.so') }}</th>
                            <th>{{ __('locale.AssetEnvironmentCategory') }}</th>
                            <th>{{ __('asset.Asset_owner') }}</th>
                            <th>{{ __('asset.model') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.UpdatedDate') }}</th>
                            <th>{{ __('locale.VerifiedAssets') }}</th>
                            <th>{{ __('locale.regions') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="exportAssetModal" tabindex="-1"
    aria-labelledby="openexportAssetLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="openexportAssetLabel">{{ __('locale.ExportAsseterability') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="exportAssetForm">
                        {{--  region  --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Regions') }}</label>
                            <select name="region" class="form-select" id="exportRegion">
                                <option value="" selected>{{ __('locale.All') }}</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-region"></span>
                        </div>


                        <button type="button" class="btn btn-primary" id="export-assets-btn">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
