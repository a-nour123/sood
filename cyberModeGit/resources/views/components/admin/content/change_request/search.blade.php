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
                            @if (change_requests_responsible_department_manager_id() && auth()->user()->hasPermission('change-request.create') && auth()->id() != change_requests_responsible_department_manager_id())
                            <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#{{ $createModalID }}">
                                {{ __('locale.AddANewChangeRequest') }}
                            </button>
                            @endif

                            @php
                                $createOtherCondition = change_requests_responsible_department_manager_id() && auth()->id() != change_requests_responsible_department_manager_id();
                            @endphp

                            <!-- Import and export container -->
                                <x-export-import name=" {{ __('locale.ChangeRequest') }}" createPermissionKey='change-request.create' :createOtherCondition="$createOtherCondition" exportPermissionKey='change-request.export' exportRouteKey='admin.change_request.ajax.export' importRouteKey='will-added-TODO' />
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Title') }}:</label>
                                <input class="form-control dt-input " name="filter_title" data-column="1" data-column-index="0" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Description') }}:</label>
                                <input class="form-control dt-input " name="filter_description" data-column="2" data-column-index="1" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.CreatedBy') }}:</label>
                                <input class="form-control dt-input " name="filter_created_by_user" data-column="3" data-column-index="2" type="text">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Status') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_status" id="team" data-column="5" data-column-index="4">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @if(change_requests_responsible_department_manager_id() == auth()->id())
                                    <option value="Responsible-Department-In-Review">
                                        {{ __('locale.Responsible-Department-In-Review') }} </option>
                                    <option value="Responsible-Department-Accepted">
                                        {{ __('locale.Responsible-Department-Accepted') }} </option>
                                    <option value="Responsible-Department-Rejected">
                                        {{ __('locale.Responsible-Department-Rejected') }} </option>
                                    @else
                                    <option value="Department-Manager-In-Review">
                                        {{ __('locale.Department-Manager-In-Review') }} </option>
                                    <option value="Department-Manager-Rejected">
                                        {{ __('locale.Department-Manager-Rejected') }} </option>
                                    @endif
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
                            <th>{{ __('locale.Title') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.CreatedBy') }}</th>
                            <th>{{ __('locale.File') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Reason') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Title') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.CreatedBy') }}</th>
                            <th>{{ __('locale.File') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Reason') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="change-request-decision" style="z-index: 1080;">
    <div class="modal-dialog sidebar-sm">
        <form action="{{ route('admin.change_request.ajax.decision') }}" method="POST" class="modal-content pt-0">
            @csrf
            <input type="hidden" name="id">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ __('locale.MakeDecision') }}</h5>
            </div>
            <div class="modal-body flex-grow-1">

                {{-- decision --}}
                <div class="mb-1">
                    <label class="form-label ">{{ __('locale.Decision') }}</label>
                    <select name="decision" class="form-select select2">
                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                        <option value='Approved'> {{ __('locale.Approved') }}</option>
                        <option value='Rejected'> {{ __('locale.Rejected') }}</option>
                    </select>
                    <span class="error error-decision"></span>
                </div>

                {{-- reason --}}
                <div class="mb-1 d-none" id="reason-container">
                    <label class="form-label">{{ __('locale.Reason') }}</label>
                    <textarea class="form-control" name="reason" rows="3"></textarea>
                    <span class="error error-reason "></span>
                </div>

                <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
