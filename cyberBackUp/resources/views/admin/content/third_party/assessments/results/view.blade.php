@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Questionnaire Results'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                                style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                    </use>
                                                </svg></a></li>
                                        @foreach ($breadcrumbs as $breadcrumb)
                                            <li class="breadcrumb-item">
                                                @if (isset($breadcrumb['link']))
                                                    <a
                                                        href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                                @endif
                                                {{ $breadcrumb['name'] }}
                                                @if (isset($breadcrumb['link']))
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endisset
                        </div>
                        <div class="col-sm-6 pe-0" style="text-align: end;">

                            <div class="action-content">

                                <!-- add request btn -->
                                {{-- <button class="btn btn-primary" type="button" id="addRequestBtn" data-bs-toggle="modal"
                                data-bs-target="#createRequestModal">
                                <i class="fa fa-plus"></i>
                            </button> --}}

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- <div class="container"> --}}
    <nav>
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab-fill" data-bs-toggle="tab" href="#assessmentResult"
                    role="tab" aria-controls="home-fill"
                    aria-selected="true">{{ __('assessment.QuestionnaireResponses') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab-fill" data-bs-toggle="tab" href="#riskResult" role="tab"
                    aria-controls="profile-fill" aria-selected="false">{{ __('assessment.RiskAssessment') }}</a>
            </li>
        </ul>
    </nav>

    <div class="tab-content" id="nav-tabContent">

        {{-- assessment result part --}}
        <div class="tab-pane fade show active mt-5" id="assessmentResult" role="tabpanel" tabindex="0">
            @php
                $x = 0;
                $locale = app()->getLocale();
            @endphp

            @foreach ($data['results'] as $result)
                @php
                    $x++;
                    // Decode JSON fields safely
                    $question = json_decode($result->question, true);
                    $answer = $result->answer ? json_decode($result->answer, true) : null;
                @endphp

                <div class="row mb-2 contact-fields">
                    <div class="col-md-6">
                        <p>
                            <b>{{ __('third_party.Question') }} {{ $x }}:</b>
                            {!! $question[$locale] ?? ($question['en'] ?? '') !!}
                        </p>
                    </div>

                    <div class="col-md-2">
                        <p>
                            <b>{{ __('third_party.Answer') }}:</b>
                            {!! $answer[$locale] ?? ($answer['en'] ?? __('third_party.Not answered')) !!}
                        </p>
                    </div>

                    <div class="col-md-2">
                        <p>
                            <b>{{ __('third_party.Explanation') }}:</b>
                            {{ $result->comment ?? __('third_party.No comment') }}
                        </p>
                    </div>
                    @if ($result->file)
                        <div class="col-md-2">
                            <p>
                                <b>{{ __('third_party.Nda') }}:</b>
                                <a target="_blank"
                                    href="{{ asset('storage/' . $result->file) }}">{{ __('assessment.viewFile') }}</a>
                            </p>
                        </div>
                    @endif

                </div>
                <hr>
            @endforeach
        </div>



        @php
            $pendingRisks = $data['questionnaireRisks']->where('status', '=', 'pending') ?? collect([]);
            $rejectedRisks = $data['questionnaireRisks']->where('status', '=', 'rejected') ?? collect([]);
            $addedRisks = $data['questionnaireRisks']->where('status', '=', 'added') ?? collect([]);

            $riskScores = array_column($data['questionnaireRisks']->toArray(), 'risk_score') ?? [];

            $riskFactor = !empty($riskScores) ? max($riskScores) : 0; // Ensure array is not empty before calling max()
        @endphp


        {{-- risk assessement part --}}
        <div class="tab-pane fade" id="riskResult" role="tabpanel" tabindex="0">
            <!-- analysis section -->
            <div class="accordion mt-1" id="analysisSection">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#analysisCollapse" aria-expanded="true" aria-controls="analysisCollapse">
                            {{ __('assessment.Analysis') }}
                        </button>
                    </h2>
                    <div id="analysisCollapse" class="accordion-collapse collapse show"
                        data-bs-parent="#analysisSection">
                        <div class="accordion-body">
                            <table class="table table-striped table-bordered">

                                <td></td>
                                <td>{{ __('assessment.TotalNumber') }}</td>
                                <tbody>
                                    <tr>
                                        <td>{{ __('assessment.AllRisks') }}</td>
                                        <td>{{ $data['questionnaireRisks']->count() ?? 0 }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('assessment.AddedRisks') }}</td>
                                        <td>{{ $addedRisks->count() ?? 0 }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('assessment.PendingRisks') }}</td>
                                        <td>{{ $pendingRisks->count() ?? 0 }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('assessment.RejectedRisks') }}</td>
                                        <td>{{ $rejectedRisks->count() ?? 0 }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('third_party.Risk factor') }}</td>
                                        <td>{{ $riskFactor }} / 25
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- potential (pending) risks section -->
            <div class="accordion mt-1" id="potentialSection">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#potentialRisksCollapse" aria-expanded="true"
                            aria-controls="potentialRisksCollapse">
                            {{ __('third_party.Potential risks') }}
                        </button>
                    </h2>
                    <div id="potentialRisksCollapse" class="accordion-collapse collapse"
                        data-bs-parent="#potentialSection">
                        <div class="accordion-body">
                            <div class="row">

                                @forelse($pendingRisks as $p_risk)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <form {{-- action="{{ route('admin.questionnaire-results.changeRiskStatus', $p_risk->id) }}" --}} action="" id=""
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="action_type" value="add_risk">
                                                    <input type="hidden" name="questionnaire_risk_id"
                                                        value="{{ $p_risk->id }}">
                                                    <input type="hidden" name="questionnaire_id"
                                                        value="{{ $p_risk->questionnaire_id }}">

                                                    <div
                                                        class=" vertical wizard-modern modern-vertical-wizard-example">
                                                        <div class="bs-stepper-content">
                                                            <div id="risk_assessment" class="content" role="tabpanel"
                                                                aria-labelledby="risk_assessment_toggle">
                                                                <div class="row">

                                                                    <div class="mb-1 col-md-12 risk_details">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="risk_subject">{{ __('assessment.Subject') }}</label>
                                                                                <input type="text"
                                                                                    value="{{ $p_risk->risk_subject }}"
                                                                                    class="form-control"
                                                                                    name="risk_subject">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-2">
                                                                            <div class="col-md-4">
                                                                                <label
                                                                                    for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                <select name="risk_scoring_method_id"
                                                                                    class="form-control select2">
                                                                                    @foreach ($data['riskScoringMethods'] as $method)
                                                                                        <option
                                                                                            value="{{ $method->id }}"
                                                                                            {{ $p_risk->risk_scoring_method_id == $method->id ? 'selected' : '' }}>
                                                                                            {{ $method->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label
                                                                                    for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                <select name="likelihood_id"
                                                                                    class="form-control select2">
                                                                                    @foreach ($data['likelihoods'] as $likelihood)
                                                                                        <option
                                                                                            value="{{ $likelihood->id }}"
                                                                                            {{ $p_risk->likelihood_id == $likelihood->id ? 'selected' : '' }}>
                                                                                            {{ $likelihood->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label
                                                                                    for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                <select name="impact_id"
                                                                                    class="form-control select2">
                                                                                    @foreach ($data['impacts'] as $impact)
                                                                                        <option
                                                                                            value="{{ $impact->id }}"
                                                                                            {{ $p_risk->impact_id == $impact->id ? 'selected' : '' }}>
                                                                                            {{ $impact->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-2">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                <select name="owner_id"
                                                                                    class="form-control select2">
                                                                                    @foreach ($data['enabledUsers'] as $user)
                                                                                        <option
                                                                                            value="{{ $user->id }}"
                                                                                            {{ $p_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                            {{ $user->username }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-2">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                <select name="assets_ids[]"
                                                                                    class="form-control select2"
                                                                                    multiple>
                                                                                    @if (count($data['assetGroups']))
                                                                                        <optgroup
                                                                                            label="{{ __('assessment.AssetGroups') }}">

                                                                                            @foreach ($data['assetGroups'] as $assetGroup)
                                                                                                <option
                                                                                                    value="{{ $assetGroup->id }}_group"
                                                                                                    {{ in_array($assetGroup->id . '_group', json_decode($p_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                    {{ $assetGroup->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </optgroup>
                                                                                    @endif
                                                                                    <optgroup
                                                                                        label="{{ __('assessment.Standards') }} {{ __('assessment.Assets') }}">
                                                                                        @foreach ($data['assets'] as $asset)
                                                                                            <option
                                                                                                value="{{ $asset->id }}_asset"
                                                                                                {{ in_array($asset->id . '_asset', json_decode($p_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                {{ $asset->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </optgroup>

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-2">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="tags">{{ __('locale.Tags') }}</label>
                                                                                <select name="tags_ids[]"
                                                                                    class="form-control select2"
                                                                                    multiple>
                                                                                    @foreach ($data['tags'] as $tag)
                                                                                        <option
                                                                                            value="{{ $tag->id }}"
                                                                                            {{ in_array($tag->id, json_decode($p_risk->tags_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                            {{ $tag->tag }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row mt-2">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                <select name="framework_controls_ids"
                                                                                    class="form-control select2">
                                                                                    @foreach ($data['migration_controls'] as $control)
                                                                                        <option
                                                                                            value="{{ $control->id }}"
                                                                                            {{ $control->id == $p_risk->framework_controls_ids ? 'selected' : '' }}>
                                                                                            {{ $control->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>

                                                    </div>
                                                    {{-- @if ($questionnaireAnswers->status == 'complete' && $questionnaireAnswers->approved_status == null)
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-label-secondary btn-danger reject_risk"
                                                                data-bs-dismiss="modal">Reject
                                                                Risk</button>
                                                            <button type="submit"
                                                                class="btn btn-primary add_risk">{{ __('assessment.AddRisk') }}</button>
                                                        </div>
                                                    @endif --}}

                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                    {{ __('assessment.NoRisksFound') }}
                                @endforelse


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasPermission('third_party_assessment.assessment_result') ||
                    auth()->user()->id == $data['requestReccipientId']
            )
                @if (
                    $data['answerData']->submission_type == 'complete' &&
                        $data['answerData']->approved_status != 'yes' &&
                        $data['answerData']->approved_status != 'no')

                    <div class="d-flex mb-3 mt-3 justify-content-center" id="takeActionContainer">
                        <button class="btn btn-success m-1 approveing-questionnaire_result" data-status="yes"
                            id="approveBtn">
                            <i class="fa-solid fa-check me-2"></i>{{ __('third_party.Approve') }}
                        </button>
                        <button class="btn btn-danger m-1 approveing-questionnaire_result" data-status="no"
                            id="rejectBtn">
                            <i class="fas fa-x me-2"></i>{{ __('third_party.Reject') }}
                        </button>
                        <button class="btn btn-primary m-1 approveing-questionnaire_result" data-status="remeidation"
                            id="remeidationBtn">
                            <i class="fa-solid fa-right-left me-2"></i>{{ __('third_party.Remeidation') }}
                        </button>
                    </div>
                @endif
            @endif

        </div>
    </div>
    {{-- </div> --}}

    <div class="modal fade" id="remedationForm" tabindex="-1" aria-labelledby="remedationFormLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <textarea class="form-control" id="editor1" required style="height: 100px"></textarea>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                            id="saveRemedation">{{ __('third_party.Save and send') }}</button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ 'locale.Close' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="rejectForm" tabindex="-1" aria-labelledby="rejectFormLabel" aria-hidden="true"
        style="position: fixed;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <textarea class="form-control" id="rejectInput" placeholder="{{ __('third_party.Enter reject reason') }}...."
                        required style="height: 100px"></textarea>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" disabled
                            id="saveReason">{{ __('third_party.Save Changes') }}</button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        nav,
        nav h2,
        nav svg,
        nav .selected-language,
        nav .user-name,
        nav .user-status {
            background-color: transparent !important;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>


@endsection


@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>

    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>


    <script src="{{ asset('new_d/js/form-wizard/form-wizard.js') }}"></script>
    <script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>

    <script src="{{ asset('new_d/js/bootstrap/bootstrap11.min.js') }}"></script>

    <script src="{{ asset('cdn/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $("#thirdPartyAssessmentsResultsTable").DataTable();

        $("#rejectInput").on('input', function(e) {
            e.preventDefault();

            var rejectReason = $(this);

            // Remove any previous validation error messages
            $("#validateError").remove();

            // Check if the input is between 1 and 350 characters
            if (rejectReason.val().length < 1 || rejectReason.val().length > 350) {
                rejectReason.addClass("is-invalid").removeClass("is-valid");
                rejectReason.after(
                    "<span id='validateError' class='text-danger'>Please enter a note between 1 and 350 characters.</span>"
                );
                $("#saveReason").prop("disabled", true);
            } else {
                rejectReason.removeClass("is-invalid").addClass("is-valid");
                $("#saveReason").prop("disabled", false);
            }
        });

        // view approveing questionnaire_result
        $(document).on('click', '.approveing-questionnaire_result', function() {
            var questionnaireAnswerId = `{{ $data['answerData']->id }}`;
            var approvingStatus = $(this).data('status');
            var text = '';
            var note = '';

            if (approvingStatus == 'yes') {
                text = "{{ __('third_party.Approve this questionnaire') }}";
            } else if (approvingStatus == 'remeidation') {
                text = "{{ __('third_party.Remeidate this questionnaire') }}";
                note = 'remeidation';
            } else {
                text = "{{ __('third_party.Rejecting this questionnaire') }}";
                note = 'reject';
            }

            Swal.fire({
                title: "{{ __('third_party.Take action on this assessment') }}",
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('third_party.Submit') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    if (note == 'remeidation') {
                        $('#remedationForm').modal('show');

                        $("#saveRemedation").click(function(e) {
                            e.preventDefault();
                            var remedationNote = CKEDITOR.instances['editor1'].getData();
                            // console.log(remedationNote);
                            $(this).prop('disabled', true);

                            $.ajax({
                                url: '{{ route('admin.third_party.updateQuestionnaireAnswerStatus', ':id') }}'
                                    .replace(':id', questionnaireAnswerId),
                                type: 'PUT',
                                data: {
                                    approved_status: approvingStatus,
                                    note: remedationNote
                                },
                                beforeSend: function() {
                                    // Show loading overlay
                                    $.blockUI({
                                        message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Answer Questions']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                                        css: {
                                            backgroundColor: 'transparent',
                                            color: '#fff',
                                            border: '0'
                                        },
                                        overlayCSS: {
                                            opacity: 0.5
                                        }
                                    });
                                },
                                success: function(response) {
                                    $(this).prop('disabled', true);
                                    table.ajax
                                        .reload(); // Refresh DataTable after delete

                                    $('#remedationForm').modal('hide');

                                    makeAlert('success', response.message,
                                        'Success');

                                    window.location.href =
                                        `{{ route('admin.third_party.questionnairesResults') }}`;
                                    // $.unblockUI();
                                },
                                error: function(xhr) {
                                    makeAlert('error', xhr.responseJSON.message ||
                                        'An unexpected error occurred.', 'Error'
                                    );
                                    $(this).prop('disabled', false);
                                    $.unblockUI();
                                }
                            });
                        });
                    } else if (note == 'reject') {
                        $('#rejectForm').modal('show');

                        $("#saveReason").click(function(e) {
                            e.preventDefault();
                            var rejectReason = $("#rejectInput").val();
                            $.ajax({
                                url: '{{ route('admin.third_party.updateQuestionnaireAnswerStatus', ':id') }}'
                                    .replace(':id', questionnaireAnswerId),
                                type: 'PUT',
                                data: {
                                    approved_status: approvingStatus,
                                    note: rejectReason
                                },
                                beforeSend: function() {
                                    // Show loading overlay
                                    $.blockUI({
                                        message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Answer Questions']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                                        css: {
                                            backgroundColor: 'transparent',
                                            color: '#fff',
                                            border: '0'
                                        },
                                        overlayCSS: {
                                            opacity: 0.5
                                        }
                                    });
                                },
                                success: function(response) {
                                    $(this).prop('disabled', true)
                                    table.ajax
                                        .reload(); // Refresh DataTable after delete

                                    $("#takeActionContainer").addClass("d-none");

                                    $('#rejectForm').modal('hide');

                                    makeAlert('success', response.message, 'Success');

                                    window.location.href =
                                        `{{ route('admin.third_party.questionnairesResults') }}`;
                                    // $.unblockUI();
                                },
                                error: function(xhr) {
                                    makeAlert('error', xhr.responseJSON.message ||
                                        'An unexpected error occurred.', 'Error');
                                    $.unblockUI();
                                }
                            });
                        });
                    } else {
                        $.ajax({
                            url: '{{ route('admin.third_party.updateQuestionnaireAnswerStatus', ':id') }}'
                                .replace(':id', questionnaireAnswerId),
                            type: 'PUT',
                            data: {
                                approved_status: approvingStatus,
                            },
                            beforeSend: function() {
                                // Show loading overlay
                                $.blockUI({
                                    message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Answer Questions']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                                    css: {
                                        backgroundColor: 'transparent',
                                        color: '#fff',
                                        border: '0'
                                    },
                                    overlayCSS: {
                                        opacity: 0.5
                                    }
                                });
                            },
                            success: function(response) {
                                $("#takeActionContainer").addClass("d-none");

                                table.ajax.reload(); // Refresh DataTable after delete

                                makeAlert('success', response.message, 'Success');

                                window.location.href =
                                    `{{ route('admin.third_party.questionnairesResults') }}`;
                            },
                            error: function(xhr) {
                                makeAlert('error', xhr.responseJSON.message ||
                                    'An unexpected error occurred.', 'Error');
                                $.unblockUI();
                            }
                        });
                    }

                }
            });
        });
    </script>
@endsection
