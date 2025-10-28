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
                            {{--  <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#{{ $createModalID }}">
                                {{ __('locale.AddANewRisk') }}
                            </button>  --}}
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Status') }}:</label>
                                <input class="form-control dt-input" data-column="1" data-column-index="0" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Subject') }}:</label>
                                <input class="form-control dt-input" data-column="2" data-column-index="1" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('report.InherentRiskCurrent') }}:</label>
                                <input class="form-control dt-input" data-column="3" data-column-index="2" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.SubmissionDate') }}:</label>
                                <input class="form-control dt-input" data-column="4" data-column-index="3" type="text">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-search table">
                    <thead>
                        <tr>
                            <th></th>
                            {{--  <th>{{ __('locale.ID') }}</th>  --}}
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Subject') }}</th>
                            <th>{{ __('report.InherentRiskCurrent') }}</th>
                            <th>{{ __('locale.SubmissionDate') }}</th>
                            {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                            {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            {{--  <th>{{ __('locale.ID') }}</th>  --}}
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Subject') }}</th>
                            <th>{{ __('report.InherentRiskCurrent') }}</th>
                            <th>{{ __('locale.SubmissionDate') }}</th>
                            {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                            {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>
