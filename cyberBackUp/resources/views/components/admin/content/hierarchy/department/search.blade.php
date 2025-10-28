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
                            @if(auth()->user()->hasPermission('department.create'))
                                {{-- <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#{{ $createModalID }}">
                                    {{ __('locale.AddANewDepartment') }}
                                </button>
                                <a href="{{ route('admin.hierarchy.department.notificationsSettingsDepartement') }}" class="dt-button btn btn-primary me-2"
                                target="_self">
                                {{ __('hierarchy.NotificationsSettingsDepartement') }}
                                </a> --}}
                                {{-- <a href="{{ route('admin.hierarchy.notificationsSettingsMovingDepartement') }}" class="dt-button btn btn-primary me-2"
                                target="_self">
                                {{ __('hierarchy.NotificationsSettingsHierarchy') }}
                                </a> --}}
                            @endif

                            <!-- Import and export container -->
                                {{-- <x-export-import name=" {{ __('locale.Department') }}" createPermissionKey='department.create' exportPermissionKey='department.export' exportRouteKey='admin.hierarchy.department.ajax.export' importRouteKey='admin.hierarchy.department.import' /> --}}
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
                                <input class="form-control dt-input " name="filter_name" data-column="1" data-column-index="0" type="text">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Code') }}:</label>
                                <input class="form-control dt-input " name="filter_code" data-column="2" data-column-index="1" type="text">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.ParentDepartment') }}:</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_parentDepartment" id="ParentDepartment" data-column="3" data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->name }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-2">
                                <label class="form-label">{{ __('locale.ChildDepartments') }}:</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_departments" id="ChildDepartments" data-column="4" data-column-index="3">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->name }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Manager') }}:</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_manager"  id="Manager" data-column="7" data-column-index="6">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($departments as $department)
                                         @if($department->manager)
                                        <option value="{{ $department->manager->name }}">{{ $department->manager->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>

                </form>
                <div class="card-datatable pb-4 table-responsive">
                  <div class="table-responsive">
                  <table class="dt-advanced-server-search table ">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('locale.Name') }}</th>
                                <th>{{ __('locale.Code') }}</th>
                                <th>{{ __('locale.ParentDepartment') }}</th>
                                <th>{{ __('locale.ChildDepartments') }}</th>
                                <th>{{ __('locale.RequiredNumberOfEmplyees') }}</th>
                                <th>{{ __('locale.ActualNumberOfEmplyees') }}</th>
                                <th>{{ __('locale.Manager') }}</th>
                                <th>{{ __('locale.CreatedDate') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('locale.Name') }}</th>
                                <th>{{ __('locale.Code') }}</th>
                                <th>{{ __('locale.ParentDepartment') }}</th>
                                <th>{{ __('locale.ChildDepartments') }}</th>
                                <th>{{ __('locale.RequiredNumberOfEmplyees') }}</th>
                                <th>{{ __('locale.ActualNumberOfEmplyees') }}</th>
                                <th>{{ __('locale.Manager') }}</th>
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
