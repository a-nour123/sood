<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                    {{-- <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">
                            @if (auth()->user()->hasPermission('asset_group.create'))
                                <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#{{ $createModalID }}">
                                    {{ __('asset.AssetGroupCreate') }}
                                </button>
                                <a href="{{ route('admin.asset_management.notificationsSettingsAssetManagement') }}" class="dt-button btn btn-primary me-2"
                                target="_self">
                                {{ __('locale.NotificationsSettings') }}
                                </a>
                            @endif

                            <!-- Import and export container -->
                            <x-export-import name=" {{ __('asset.AssetGroup') }}"
                                createPermissionKey='asset_group.create' exportPermissionKey='asset_group.export'
                                exportRouteKey='admin.asset_management.ajax.asset_group.export'
importRouteKey='admin.asset_management.importGroups' />
                            <!--/ Import and export container -->

                        </div>
                    </div> --}}
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-2">
                                <label class="form-label">{{ __('asset.AssetGroupName') }}:</label>
                                <input class="form-control dt-input" name="filter_name" data-column="1" data-column-index="0"
                                    type="text">
                            </div>
                            {{-- <div class="col-md-2">
                                <label class="form-label">{{ __('asset.Assets') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_assets" id="Asset" data-column="2"
                                    data-column-index="1">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($assets as $asset)
                                        <option value="{{ $asset->name }}">{{ $asset->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                    </form>

                </div>
                <div class="card-datatable">
                    <table class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('asset.AssetGroupName') }}</th>
                                <th>{{ __('asset.Assets') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>


        </div>
    </div>
    </div>
</section>
