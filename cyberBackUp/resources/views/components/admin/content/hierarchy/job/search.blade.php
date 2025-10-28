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
                            @if (auth()->user()->hasPermission('job.create'))
                                {{-- <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#{{ $createModalID }}">
                                    {{ __('locale.AddANewJob') }}
                                </button> --}}
                                {{-- <a href="{{ route('admin.hierarchy.job.notificationsSettingsJob') }}" class="dt-button btn btn-primary me-2"
                                target="_self">
                                {{ __('locale.NotificationsSettings') }}
                            </a> --}}
                            @endif

                            <!-- Import and export container -->
                            {{-- <x-export-import name=" {{ __('locale.Job') }}" createPermissionKey='job.create'
                                exportPermissionKey='job.export' exportRouteKey='admin.hierarchy.job.ajax.export'
                                importRouteKey='admin.hierarchy.job.import' /> --}}
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Name') }}:</label>
                                <input class="form-control dt-input " name="filter_name" data-column="1"
                                    data-column-index="0" type="text">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Code') }}:</label>
                                <input class="form-control dt-input " name="filter_code" data-column="2"
                                    data-column-index="1" type="text">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Employee') }}:</label>
                                <select class="form-control dt-input dt-select select2 " id="Employee"
                                    name="filter_employees" data-column="4" data-column-index="3">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="card-datatable pb-4">
                        <table class="dt-advanced-server-search table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('locale.Name') }}</th>
                                    <th>{{ __('locale.Code') }}</th>
                                    <th>{{ __('locale.Description') }}</th>
                                    <th>{{ __('locale.Employees') }}</th>
                                    <th>{{ __('locale.CreatedDate') }}</th>
                                    <th>{{ __('locale.Actions') }}</th>
                                </tr>
                            </thead>
                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('locale.Name') }}</th>
                                    <th>{{ __('locale.Code') }}</th>
                                    <th>{{ __('locale.Description') }}</th>
                                    <th>{{ __('locale.Employees') }}</th>
                                    <th>{{ __('locale.CreatedDate') }}</th>
                                    <th>{{ __('locale.Actions') }}</th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
            {{-- <hr class="my-0" /> --}}

        </div>
    </div>
    </div>
</section>
