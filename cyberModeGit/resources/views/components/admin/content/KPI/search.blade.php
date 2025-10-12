<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            {{-- Title --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Title') }}:</label>
                                <input class="form-control dt-input "  name="filter_title" data-column="1" data-column-index="0"
                                    type="text">
                            </div>
                            {{-- Description --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Description') }}:</label>
                                <input class="form-control dt-input "  name="filter_description" data-column="2" data-column-index="1"
                                    type="text">
                            </div>
                            {{-- Department --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Department') }}:</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_department" id="Department" data-column="6"
                                    data-column-index="7">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Type --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Type') }}:</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_value_type" id="team" data-column="3"
                                    data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    <option value="{{ __('locale.Time') }}"> {{ __('locale.Time') }} </option>
                                    <option value="{{ __('locale.Percentage') }}"> {{ __('locale.Percentage') }}
                                    </option>
                                    <option value="{{ __('locale.Number') }}"> {{ __('locale.Number') }} </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="my-0" />
                <div class="card-datatable">
                    <table class="dt-advanced-server-search table" id="advanced-search-datatable">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('locale.Title') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Type') }}</th>
                                <th>{{ __('locale.Value') }}</th>
                                <th>{{ __('locale.Period') }}</th>
                                <th>{{ __('locale.Department') }}</th>
                                <th>{{ __('locale.DepartmentManager') }}</th>
                                 <th>{{ __('locale.CreatedBy') }}</th>
                                <th>{{ __('locale.CreatedDate') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('locale.Title') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Type') }}</th>
                                <th>{{ __('locale.Value') }}</th>
                                <th>{{ __('locale.Period') }}</th>
                                <th>{{ __('locale.Department') }}</th>
                                <th>{{ __('locale.DepartmentManager') }}</th>
                                 <th>{{ __('locale.CreatedBy') }}</th>
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

<div class="modal-size-lg d-inline-block">
    <!-- Modal -->
    <div class="modal fade text-start" id="list-KPI-assessment" tabindex="-1" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{ __('locale.ListKPIAssessments') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.KPIValue') }}</th>
                                    <th>{{ __('locale.DepartmentValue') }}</th>
                                    <th>{{ __('locale.CreatedBy') }}</th>
                                    <th>{{ __('locale.CreatedDate') }}</th>
                                    <th>{{ __('locale.AssessmentedBy') }}</th>
                                    <th>{{ __('locale.AssessmentedDate') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
