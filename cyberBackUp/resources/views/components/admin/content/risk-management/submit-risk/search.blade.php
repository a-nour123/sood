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
                            @if (auth()->user()->hasPermission('riskmanagement.create'))
                                <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#{{ $createModalID }}">
                                    {{ __('locale.AddANewRisk') }}
                                </button>
                                <a href="{{ route('admin.risk_management.notificationsSettingsRisk') }}"
                                    class="dt-button btn btn-primary me-2" target="_self">
                                    {{ __('locale.NotificationsSettings') }}
                                </a>
                                <a href="#" id="exportAsPdfButton" class="dt-button btn btn-primary me-2"
                                onclick="exportAsPdf()">
                                {{ __('locale.Export') }} PDF
                            </a>
                            @endif

                            <!-- Import and export container -->
                            <x-export-import name=" {{ __('risk.Risk') }}" createPermissionKey='riskmanagement.create'
                                exportPermissionKey='riskmanagement.export'
                                exportRouteKey='admin.risk_management.ajax.export'
                                 importRouteKey='admin.risk_management.import' />
                            <!--/ Import and export container -->
                        </div>
                    </div> --}}
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Status') }}:</label>
                                <select class="select2 form-select" data-column="1" name="filter_status"
                                    id="filter_status_input" data-column-index="0">
                                    <option value="" selected>
                                        {{ __('locale.select-option') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->name }}">
                                            {{ $status->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.Subject') }}:</label>
                                <input class="form-control dt-input" data-column="2" name="filter_subject"
                                    id="filter_subject_input" data-column-index="1" type="text">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('risk.InherentRiskCurrent') }}:</label>
                                <input class="form-control dt-input" data-column="3" name="filter_riskScoring"
                                    id="filter_riskScoring_input" data-column-index="2" type="text">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('locale.SubmissionDate') }}:</label>
                                <input class="form-control dt-input" data-column="4" name="filter_submission_date"
                                    id="filter_submission_date_input" data-column-index="3" type="text">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-datatable pb-4">
                    <table class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('risk.RiskNumber') }}</th>
                                <th>{{ __('locale.Subject') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Category') }}</th>
                                <th>{{ __('locale.questionnaire') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('risk.ResponsiblePart') }}</th>
                                <th>{{ __('risk.InherentRiskCurrent') }}</th>
                                <th>{{ __('locale.SubmissionDate') }}</th>
                                {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                                {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                                <th>{{ __('locale.Actions') }}</th>

                            </tr>
                        </thead>
                        <!-- <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('risk.RiskNumber') }}</th>
                            <th>{{ __('locale.Subject') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.questionnaire') }}</th>
                            <th>{{ __('locale.Category') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('risk.ResponsiblePart') }}</th>
                            <th>{{ __('risk.InherentRiskCurrent') }}</th>
                            <th>{{ __('locale.SubmissionDate') }}</th>
                            {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                            {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot> -->
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
<script>
    function exportAsPdf() {
        // Get the values from the input fields
        var subjectValue = document.getElementById('filter_subject_input').value;
        var statusValue = document.getElementById('filter_status_input').value;
        var riskScoringValue = document.getElementById('filter_riskScoring_input').value;
        var submissionDateValue = document.getElementById('filter_submission_date_input').value;

        // Create a form element
        var form = document.createElement('form');
        form.method = 'GET';
        form.action = "{{ route('admin.risk_management.ajax.exportDataPdf') }}";

        // Create input elements to hold the values
        function createInput(name, value) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }

        // Append the input elements to the form
        form.appendChild(createInput('filter_subject', subjectValue));
        form.appendChild(createInput('filter_status', statusValue));
        form.appendChild(createInput('filter_riskScoring', riskScoringValue));
        form.appendChild(createInput('filter_submission_date', submissionDateValue));

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>
