<div style="text-align: right">
    @if (auth()->user()->hasPermission('riskmanagement.create') && $editable)
        <button class="dt-button btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-new-risk">
            {{ __('compliance.AddANewRisk') }}
        </button>

    @endif
</div>


<!-- Create Form -->
@if (auth()->user()->hasPermission('riskmanagement.create') && $editable)
<x-submit-risk-form id="add-new-risk" title="{{ __('compliance.AddANewRisk') }}" :riskGroupings="$riskGroupings" :threatGroupings="$threatGroupings" :locations="$locations" :frameworks="$frameworks" :assets="$assets" :assetGroups="$assetGroups" :categories="$categories" :technologies="$technologies" :teams="$teams" :enabledUsers="$enabledUsers" :riskSources="$riskSources" :riskScoringMethods="$riskScoringMethods" :riskLikelihoods="$riskLikelihoods" :impacts="$impacts" :tags="$tags" :owners="$owners"/>
@endif
<!--/ Create Form -->

<div class="col-md-12">
    <label class="form-label">{{ __('compliance.Risk') }}</label>
    <select class="form-control dt-input dt-select select2 " name="risks[]" id="risk" multiple
        {{ $editable ? '' : 'disabled' }}>
        @foreach ($risks as $risk)
            <option value="{{ $risk->id }}" {{ optionMultiSelect($risk->id, $SelectedRiskIds) }}>{{ $risk->subject }}
            </option>
        @endforeach
    </select>
</div>

<!-- Advanced Search -->
<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('compliance.Active Audits') }}</h4>
                    </div>
                    <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">


                        </div>
                    </div>
                </div>
                <!--Search Form -->

                <hr class="my-0" />

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('locale.Subject') }}</th>
                                <th>{{ __('locale.SubmissionDate') }}</th>
                            </tr>
                        </thead>
                        <tbody id="risks-table-content">
                            @foreach ($resultRisks as $resultRisk)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $resultRisk->status }}
                                    </td>
                                    <td>
                                        {{ $resultRisk->subject }}
                                    </td>
                                    <td>
                                        {{ $resultRisk->created_at->format('d/m/Y') }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Advanced Search -->
