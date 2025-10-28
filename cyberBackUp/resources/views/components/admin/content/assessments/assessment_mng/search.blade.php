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
{{--                            @if (auth()->user()->hasPermission('asset_group.create'))--}}
                                <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#{{ $createModalID }}">
                                    {{ __('locale.AssessmentCreate') }}
                                </button>
{{--                            @endif--}}



                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.AssessmentName') }}:</label>
                                <input class="form-control dt-input" name="filter_name" data-column="1" data-column-index="0"
                                       type="text">
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table">
                    <thead>
                    <tr>
                        <th>{{ __('locale.#') }}</th>
                        <th>{{ __('locale.Assessment') }}</th>
                        <th>{{ __('locale.Actions') }}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{ __('locale.#') }}</th>
                        <th>{{ __('locale.Assessment') }}</th>
                        <th>{{ __('locale.Actions') }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>
