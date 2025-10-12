<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            {{-- Value --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Value') }}:</label>
                                <input class="form-control dt-input " data-column="1" data-column-index="0"
                                    type="text">
                            </div>
                            {{-- KPI --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.KPI') }}:</label>
                                <select class="form-control dt-input dt-select select2 " id="KPI" data-column="2"
                                    data-column-index="1">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($kpis as $kpi)
                                        <option value="{{ $kpi->title }}">{{ $kpi->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Type --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Type') }}:</label>
                                <select class="form-control dt-input dt-select select2 " id="team" data-column="3"
                                    data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    <option value="{{ __('locale.Time') }}"> {{ __('locale.Time') }} </option>
                                    <option value="{{ __('locale.Percentage') }}"> {{ __('locale.Percentage') }}
                                    </option>
                                    <option value="{{ __('locale.Number') }}"> {{ __('locale.Number') }} </option>
                                </select>
                            </div>
                            {{-- Description --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Description') }}:</label>
                                <input class="form-control dt-input " data-column="4" data-column-index="3"
                                    type="text">
                            </div>
                            {{-- Department --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Department') }}:</label>
                                <select class="form-control dt-input dt-select select2 " id="Department" data-column="5"
                                    data-column-index="4">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
                <hr class="my-0" />
                <div class="card-datatable">
                    <table class="dt-advanced-search table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('locale.Value') }}</th>
                                <th>{{ __('locale.KPI') }}</th>
                                <th>{{ __('locale.Type') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Department') }}</th>
                                {{-- <th>{{ __('locale.DepartmentManager') }}</th> --}}
                                <th>{{ __('locale.ReAssigneTo') }}</th>
                                <th>{{ __('locale.CreatedBy') }}</th>
                                <th>{{ __('locale.CreatedDate') }}</th>
                                <th>{{ __('locale.AssessmentedBy') }}</th>
                                <th>{{ __('locale.AssessmentedDate') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th></th>
                                <th>{{ __('locale.Value') }}</th>
                                <th>{{ __('locale.KPI') }}</th>
                                <th>{{ __('locale.Type') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Department') }}</th>
                                {{-- <th>{{ __('locale.DepartmentManager') }}</th> --}}
                                <th>{{ __('locale.ReAssigneTo') }}</th>
                                <th>{{ __('locale.CreatedBy') }}</th>
                                <th>{{ __('locale.CreatedDate') }}</th>
                                <th>{{ __('locale.AssessmentedBy') }}</th>
                                <th>{{ __('locale.AssessmentedDate') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Set KPI assessment value  -->
<div class="modal fade" id="initiate-KPI-assessment" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true"
    style="z-index: 1056">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">{{ __('locale.SetKPIAssessment') }}</h1>
                <!-- form -->
                <form class="row gy-1 gx-2 mt-75">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id">
                    {{-- value --}}
                    <div class="col-12">
                        <label class="form-label">{{ __('locale.Value') }}</label>
                        <input type="text" name="value" class="form-control add-credit-card-mask"
                            aria-label="{{ __('locale.Value') }}" required />
                        <span class="error error-value "></span>
                    </div>
                    <div class="col-12 text-center">
                        <button type="Submit" class="btn btn-primary data-submit me-1">
                            {{ __('locale.SetKPIAssessment') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Assign KPI to Another User Modal -->
 <div class="modal fade" id="assign-KPI-assessment" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1">{{ __('locale.SetAssignedUser') }}</h1>
                <form class="row gy-1 gx-2 mt-75">
                    @csrf
                    @method('post')
                    <input type="hidden" name="id">
                    {{-- Assigned To Select --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('locale.Assigned To') }}:</label>
                        <select class="form-control dt-input dt-select select2" name="assigned_to" id="assigned_to">
                            <option value="">{{ __('locale.select-option') }}</option>
                            <!-- Options will be populated dynamically based on department selection -->
                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.SetKPIAssessment') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


