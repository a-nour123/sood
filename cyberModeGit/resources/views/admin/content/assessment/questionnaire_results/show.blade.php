@extends('admin.layouts.contentLayoutMaster')
@section('title', __('assessment.QuestionnaireResults'))

<style>
    .gov_btn {
        border-color: #0097a7 !important;
        background-color: #0097a7 !important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #0097a7;
        background-color: #0097a7;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
</style>

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    {{-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> --}}

@endsection
@section('content')
    <div class="col-xl-12 col-lg-12">
        @if ($questionnaireAnswers->status == 'complete' && $questionnaireAnswers->approved_status == null)
            @if (auth()->user()->hasPermission('assessmentResult.action'))
                <a href="{{ route('admin.questionnaire-results.changeStatus', ['id' => $questionnaireAnswers->id, 'status' => 'yes']) }}"
                    class="btn btn-success">Approve</a>
                <a href="{{ route('admin.questionnaire-results.changeStatus', ['id' => $questionnaireAnswers->id, 'status' => 'no']) }}"
                    class="btn btn-danger">Reject</a>
            @endif
        @endif


        <div class="card">


            <div class="card-header">
                <h4 class="card-title">
                    {{ @$questionnaireAnswers->questionnaire ? $questionnaireAnswers->questionnaire->name : '' }} </h4>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab-fill" data-bs-toggle="tab" href="#Answers" role="tab"
                            aria-controls="home-fill"
                            aria-selected="true">{{ __('assessment.QuestionnaireResponses') }}</a>
                    </li>
                    @if (auth()->user()->hasPermission('assessmentResult.action'))
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-fill" data-bs-toggle="tab" href="#Assessment-Risk"
                                role="tab" aria-controls="profile-fill"
                                aria-selected="false">{{ __('assessment.RiskAssessment') }}</a>
                        </li>
                    @endif
                </ul>

                <!-- Tab panes -->
                <div class="tab-content pt-1">
                    <div class="tab-pane active" id="Answers" role="tabpanel" aria-labelledby="home-tab-fill">
                        {{-- Questions and Answers --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="d-inline">{{ __('assessment.AssetName') }}</label>
                                    <select name="asset_id" readonly disabled required class="form-control select2"
                                        id="">
                                        <option value="">{{ @$questionnaireAnswers->asset->name }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <br>

                        @foreach ($questionnaire->assessment->questions as $index => $question)
                            <div class="form-group">
                                <label for="">
                                    <b class="badge badge-light-warning " style="font-size: 15px">{{ ++$index }}</b>
                                    <span class="" style="font-size: 15px; font-weight: bold">
                                        {{ $question->question }}</span>
                                </label>
                            </div>



                            @if ($question->answer_type == 1)

                                @php
                                    $value = '';
                                    $comment = '';
                                    $file = '';
                                @endphp

                                @foreach ($question->answers as $answer)
                                    @php
                                        $value = null;
                                        $comment = null;
                                        $file = null;

                                        foreach ($questionnaireAnswers->results as $result) {
                                            if ($result->answer_type == 1 && $result->question_id == $question->id) {
                                                $value = $result->answer_id;
                                                $comment = $result->comment;
                                                $file = $result->file;
                                            }
                                        }
                                    @endphp

                                    <div class="row align-items-center mb-3">
                                        {{-- Radio + Label --}}
                                        <div class="col-6 d-flex align-items-center">
                                            <input type="radio" {{ $answer->id == @$value ? 'checked' : '' }} disabled
                                                readonly name="questions[{{ $index }}][answers]"
                                                value="{{ $answer->id }}" id="answer_{{ $answer->id }}">

                                            <label for="answer_{{ $answer->id }}" class="ms-2 mb-0">
                                                {!! trim($answer->answer) !!}
                                            </label>
                                        </div>

                                        {{-- NDA (if exists) --}}
                                        @if ($answer->nda_id)
                                            <div class="col-6">
                                                <a href="{{ route('admin.export.data', $answer->nda_id) }}" target="_blank"
                                                    class="fw-bold text-decoration-none d-flex align-items-center">
                                                    <span>
                                                      {{ __('assessment.Nda') }} : {{ app()->getLocale() === 'ar' ? $answer->nda->name_ar : $answer->nda->name_en }}
                                                    </span>
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                @if (@$comment != '')
                                    <label for="" class="d-inline-block" style="font-weight: bold">
                                        {{ __('assessment.Comment:') }} </label>
                                    <strong>{{ @$comment }}</strong>
                                    <br>
                                @endif
                                @isset($file)
                                    <a download="{{ $question->question }}question_file" target="_blank"
                                        href="{{ asset('storage/' . $file) }}">{{ __('assessment.viewFile') }}</a>
                                @endif
                                <br>
                            @elseif($question->answer_type == 2)
                                @php
                                    $value = [];
                                    $comment = '';
                                    $file = '';
                                @endphp

                                @foreach ($question->answers as $answer)
                                    @php
                                        foreach ($questionnaireAnswers->results as $result) {
                                            if ($result->answer_type == 2 && $result->question_id == $question->id) {
                                                $value = explode(',', $result->answer);
                                                $comment = $result->comment;
                                                $file = $result->file;
                                            }
                                        }
                                    @endphp

                                    <input type="checkbox" readonly disabled
                                        {{ in_array($answer->id, $value ?? []) ? 'checked' : '' }}
                                        name="questions[{{ $index }}][answers][]" value="{{ $answer->id }}"
                                        id="answer_{{ $answer->id }}">
                                    <label for="answer_{{ $answer->id }}">{!! trim($answer->answer) !!}</label>
                                    <br>
                                @endforeach

                                @if (@$comment != '')
                                    <label for="" class="d-inline-block" style="font-weight: bold">
                                        {{ __('assessment.Comment:') }}</label>
                                    <strong>{{ @$comment }}</strong>
                                    <br>
                                @endif


                                @isset($file)
                                    <a download="{{ $question->question }}question_file" target="_blank"
                                        href="{{ asset('storage/' . $file) }}">{{ __('assessment.viewFile') }}</a>
                                @endif
                                <br>
                            @else
                                @php
                                    $value = '';
                                    $comment = '';
                                    $file = '';
                                @endphp


                                @php

                                    foreach ($questionnaireAnswers->results as $result) {
                                        if ($result->answer_type == 3 && $result->question_id == $question->id) {
                                            $value = $result->answer ?? '';
                                            $comment = $result->comment ?? '';
                                            $file = $result->file;
                                        }
                                    }
                                @endphp



                                <textarea disabled name="questions[{{ $index }}][answers]" cols="70" rows="2">
                                    {!! @$value !!}
                                </textarea>
                                <br>
                                @if ($comment != '')
                                    <label for="" class="d-inline-block" style="font-weight: bold">
                                        {{ __('assessment.Comment:') }} </label>
                                    <strong>{{ @$comment != null }}</strong>
                                    <br>
                                @endif

                                @if ($file && !empty($file))
                                    <a download="{{ $question->question }}question_file" target="_blank"
                                        href="{{ asset('storage/' . $file) }}">{{ __('assessment.viewFile') }}</a>
                                @endif

                                @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="Assessment-Risk" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <section id="accordion">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title"></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text"></p>
                                                        <div class="accordion" id="accordionExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne">
                                                                    <button class="accordion-button" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                                        aria-expanded="true" aria-controls="accordionOne">
                                                                        {{ __('assessment.Analysis') }}
                                                                    </button>
                                                                </h2>
                                                                <div id="accordionOne" class="accordion-collapse collapse show"
                                                                    aria-labelledby="headingOne"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <table class="table table-striped table-bordered">

                                                                            <td></td>
                                                                            <td>{{ __('assessment.TotalNumber') }}</td>
                                                                            {{-- <td>Cumulative Score</td>
                                                                     <td>Average Score</td> --}}


                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>{{ __('assessment.AllRisks') }}</td>
                                                                                    <td>{{ $questionnaire->risks->count() }}</td>
                                                                                    {{-- <td></td>
                                                                        <td></td> --}}
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>{{ __('assessment.AddedRisks') }}</td>
                                                                                    <td>{{ $questionnaire->AddedRisks->count() }}
                                                                                    </td>
                                                                                    {{-- <td></td>
                                                                         <td></td> --}}
                                                                                </tr>

                                                                                <tr>
                                                                                    <td>{{ __('assessment.PendingRisks') }}</td>
                                                                                    <td>{{ $questionnaire->pendingRisks->count() }}
                                                                                    </td>
                                                                                    {{--  <td></td>
                                                                          <td></td> --}}
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>{{ __('assessment.RejectedRisks') }}</td>
                                                                                    <td>{{ $questionnaire->rejectedRisks->count() }}
                                                                                    </td>
                                                                                    {{-- <td></td>
                                                                         <td></td> --}}
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingTwo">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                                        aria-expanded="false" aria-controls="accordionTwo">
                                                                        {{ __('assessment.PendingRisks') }}
                                                                    </button>
                                                                </h2>
                                                                <div id="accordionTwo" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingTwo"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">

                                                                        <div class="row">

                                                                            @forelse($questionnaire->pendingRisks as $p_risk)
                                                                                <div class="col-md-6">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <form id="riskForm" method="post"
                                                                                                enctype="multipart/form-data">
                                                                                                @csrf
                                                                                                <input type="hidden"
                                                                                                    name="action_type"
                                                                                                    value="add_risk">
                                                                                                <input type="hidden"
                                                                                                    name="questionnaire_risk_id"
                                                                                                    value="{{ $p_risk->id }}">
                                                                                                <input type="hidden"
                                                                                                    name="ass_id"
                                                                                                    value="{{ $id }}">
                                                                                                <input type="hidden"
                                                                                                    name="questionnaire_id"
                                                                                                    value="{{ $p_risk->questionnaire_id }}">

                                                                                                <div
                                                                                                    class=" vertical wizard-modern modern-vertical-wizard-example">
                                                                                                    <div
                                                                                                        class="bs-stepper-content">
                                                                                                        <div id="risk_assessment"
                                                                                                            class="content"
                                                                                                            role="tabpanel"
                                                                                                            aria-labelledby="risk_assessment_toggle">
                                                                                                            <div class="row">

                                                                                                                <div
                                                                                                                    class="mb-1 col-md-12 risk_details">
                                                                                                                    <div
                                                                                                                        class="row">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="risk_subject">{{ __('assessment.Subject') }}</label>
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                value="{{ $p_risk->risk_subject }}"
                                                                                                                                class="form-control"
                                                                                                                                name="risk_subject"
                                                                                                                                required>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-4">
                                                                                                                            <label
                                                                                                                                for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                                                            <select
                                                                                                                                name="risk_scoring_method_id"
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
                                                                                                                        <div
                                                                                                                            class="col-md-4">
                                                                                                                            <label
                                                                                                                                for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                                                            <select
                                                                                                                                name="likelihood_id"
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
                                                                                                                        <div
                                                                                                                            class="col-md-4">
                                                                                                                            <label
                                                                                                                                for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                                                            <select
                                                                                                                                name="impact_id"
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
                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                                                            <select
                                                                                                                                name="owner_id"
                                                                                                                                class="form-control select2">
                                                                                                                                @foreach ($data['enabledUsers'] as $user)
                                                                                                                                    <option
                                                                                                                                        value="{{ $user->id }}"
                                                                                                                                        {{ $p_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                                                                        {{ $user->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                                                            <select
                                                                                                                                name="assets_ids[]"
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

                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="tags">{{ __('locale.Tags') }}</label>
                                                                                                                            <select
                                                                                                                                name="tags_ids[]"
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


                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                                                            <select
                                                                                                                                name="framework_controls_ids"
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
                                                                                                @if ($questionnaireAnswers->status == 'complete' && $questionnaireAnswers->approved_status == null)
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button"
                                                                                                            class="btn btn-label-secondary btn-danger reject_risk"
                                                                                                            data-bs-dismiss="modal">Reject
                                                                                                            Risk</button>
                                                                                                        <button type="submit"
                                                                                                            class="btn btn-primary add_risk">{{ __('assessment.AddRisk') }}</button>
                                                                                                    </div>
                                                                                                @endif

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
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingThree">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                                        aria-expanded="false" aria-controls="accordionThree">
                                                                        {{ __('assessment.AddedRisks') }}
                                                                    </button>
                                                                </h2>
                                                                <div id="accordionThree" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingThree"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">


                                                                        @forelse($questionnaire->AddedRisks as $a_risk)
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <form action="" id=""
                                                                                            method="post">
                                                                                            @csrf

                                                                                            <div
                                                                                                class=" vertical wizard-modern modern-vertical-wizard-example">
                                                                                                <div class="bs-stepper-content">
                                                                                                    <div id="risk_assessment"
                                                                                                        class="content"
                                                                                                        role="tabpanel"
                                                                                                        aria-labelledby="risk_assessment_toggle">
                                                                                                        <div class="row">

                                                                                                            <div
                                                                                                                class="mb-1 col-md-12 risk_details">
                                                                                                                <div
                                                                                                                    class="row">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="risk_subject">{{ __('locale.Subject') }}</label>
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            value="{{ $a_risk->risk_subject }}"
                                                                                                                            class="form-control"
                                                                                                                            name="risk_subject">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                                                        <select
                                                                                                                            name="risk_scoring_method_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['riskScoringMethods'] as $method)
                                                                                                                                <option
                                                                                                                                    value="{{ $method->id }}"
                                                                                                                                    {{ $a_risk->risk_scoring_method_id == $method->id ? 'selected' : '' }}>
                                                                                                                                    {{ $method->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                                                        <select
                                                                                                                            name="likelihood_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['likelihoods'] as $likelihood)
                                                                                                                                <option
                                                                                                                                    value="{{ $likelihood->id }}"
                                                                                                                                    {{ $a_risk->likelihood_id == $likelihood->id ? 'selected' : '' }}>
                                                                                                                                    {{ $likelihood->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                                                        <select
                                                                                                                            name="impact_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['impacts'] as $impact)
                                                                                                                                <option
                                                                                                                                    value="{{ $impact->id }}"
                                                                                                                                    {{ $a_risk->impact_id == $impact->id ? 'selected' : '' }}>
                                                                                                                                    {{ $impact->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                                                        <select
                                                                                                                            name="owner_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['enabledUsers'] as $user)
                                                                                                                                <option
                                                                                                                                    value="{{ $user->id }}"
                                                                                                                                    {{ $a_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                                                                    {{ $user->username }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                                                        <select
                                                                                                                            name="assets_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @if (count($data['assetGroups']))
                                                                                                                                <optgroup
                                                                                                                                    label="{{ __('assessment.AssetGroups') }}">
                                                                                                                                    @foreach ($data['assetGroups'] as $assetGroup)
                                                                                                                                        <option
                                                                                                                                            value="{{ $assetGroup->id }}_group"
                                                                                                                                            {{ in_array($assetGroup->id . '_group', json_decode($a_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
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
                                                                                                                                        {{ in_array($asset->id . '_asset', json_decode($a_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                        {{ $asset->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </optgroup>

                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="tags">{{ __('locale.Tags') }}</label>
                                                                                                                        <select
                                                                                                                            name="tags_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @foreach ($data['tags'] as $tag)
                                                                                                                                <option
                                                                                                                                    value="{{ $tag->id }}"
                                                                                                                                    {{ in_array($tag->id, json_decode($a_risk->tags_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                    {{ $tag->tag }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>


                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                                                        <select
                                                                                                                            name="framework_controls_ids"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['migration_controls'] as $control)
                                                                                                                                <option
                                                                                                                                    value="{{ $control->id }}"
                                                                                                                                    {{ $control->id == $a_risk->framework_controls_ids ? 'selected' : '' }}>
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
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingFour">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionFour"
                                                                        aria-expanded="false" aria-controls="accordionFour">
                                                                        {{ __('assessment.RejectedRisks') }}
                                                                    </button>
                                                                </h2>
                                                                <div id="accordionFour" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFour"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">

                                                                        @forelse($questionnaire->rejectedRisks as $r_risk)
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <form action="" id=""
                                                                                            method="post">
                                                                                            @csrf

                                                                                            <div
                                                                                                class=" vertical wizard-modern modern-vertical-wizard-example">
                                                                                                <div class="bs-stepper-content">
                                                                                                    <div id="risk_assessment"
                                                                                                        class="content"
                                                                                                        role="tabpanel"
                                                                                                        aria-labelledby="risk_assessment_toggle">
                                                                                                        <div class="row">

                                                                                                            <div
                                                                                                                class="mb-1 col-md-12 risk_details">
                                                                                                                <div
                                                                                                                    class="row">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="risk_subject">{{ __('assessment.Subject') }}</label>
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            value="{{ $r_risk->risk_subject }}"
                                                                                                                            class="form-control"
                                                                                                                            name="risk_subject">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                                                        <select
                                                                                                                            name="risk_scoring_method_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['riskScoringMethods'] as $method)
                                                                                                                                <option
                                                                                                                                    value="{{ $method->id }}"
                                                                                                                                    {{ $r_risk->risk_scoring_method_id == $method->id ? 'selected' : '' }}>
                                                                                                                                    {{ $method->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                                                        <select
                                                                                                                            name="likelihood_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['likelihoods'] as $likelihood)
                                                                                                                                <option
                                                                                                                                    value="{{ $likelihood->id }}"
                                                                                                                                    {{ $r_risk->likelihood_id == $likelihood->id ? 'selected' : '' }}>
                                                                                                                                    {{ $likelihood->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                                                        <select
                                                                                                                            name="impact_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['impacts'] as $impact)
                                                                                                                                <option
                                                                                                                                    value="{{ $impact->id }}"
                                                                                                                                    {{ $r_risk->impact_id == $impact->id ? 'selected' : '' }}>
                                                                                                                                    {{ $impact->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                                                        <select
                                                                                                                            name="owner_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['enabledUsers'] as $user)
                                                                                                                                <option
                                                                                                                                    value="{{ $user->id }}"
                                                                                                                                    {{ $r_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                                                                    {{ $user->username }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                                                        <select
                                                                                                                            name="assets_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @if (count($data['assetGroups']))
                                                                                                                                <optgroup
                                                                                                                                    label="{{ __('locale.AssetGroups') }}">
                                                                                                                                    @foreach ($data['assetGroups'] as $assetGroup)
                                                                                                                                        <option
                                                                                                                                            value="{{ $assetGroup->id }}_group"
                                                                                                                                            {{ in_array($assetGroup->id . '_group', json_decode($r_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
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
                                                                                                                                        {{ in_array($asset->id . '_asset', json_decode($r_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                        {{ $asset->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </optgroup>

                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="tags">{{ __('locale.Tags') }}</label>
                                                                                                                        <select
                                                                                                                            name="tags_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @foreach ($data['tags'] as $tag)
                                                                                                                                <option
                                                                                                                                    value="{{ $tag->id }}"
                                                                                                                                    {{ in_array($tag->id, json_decode($r_risk->tags_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                    {{ $tag->tag }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>


                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                                                        <select
                                                                                                                            name="framework_controls_ids"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['migration_controls'] as $control)
                                                                                                                                <option
                                                                                                                                    value="{{ $control->id }}"
                                                                                                                                    {{ $control->id == $r_risk->framework_controls_ids ? 'selected' : '' }}>
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

                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingFive">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionFive"
                                                                        aria-expanded="false" aria-controls="accordionFive">
                                                                        {{ __('assessment.ComplianceAssessment') }}
                                                                    </button>
                                                                </h2>

                                                                <div id="accordionFive" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFive"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        {{--  <h2>Associated Frameworks</h2>
                                                                  @foreach ($questionnaire->assessment->questions as $index => $question)

                                                                      @if ($question->answer_type == 1)
                                                                          <div style="font-weight: bold">{{@$question->control->Frameworks?$question->control->Frameworks->first()->name:""}}</div>
                                                                      @endif
                                                                  @endforeach --}}
                                                                        <h2>Associated Controls</h2>
                                                                        <table class="table  table-bordered">

                                                                            <thead>
                                                                                <th>{{ __('assessment.AssociatedFrameworks') }}
                                                                                </th>
                                                                                <th>{{ __('assessment.Control') }}</th>
                                                                                <th>{{ __('locale.Status') }}</th>
                                                                            </thead>
                                                                            <tbody>

                                                                                @foreach ($questionnaireAnswers->results as $result)
                                                                                    @if ($result->answer_type == 1)
                                                                                        @if ($result->Answer)
                                                                                            @if ($result->question->control)
                                                                                                <tr>
                                                                                                    <td
                                                                                                        style="background-color: {{ @$result->Answer->fail_control == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer ? $result->Answer->question->control->Frameworks->first()->name : '' }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ @$result->Answer->fail_control == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer->question->control->short_name }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ @$result->Answer->fail_control == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer->fail_control ? 'Fail' : 'Pass' }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif

                                                                                @endforeach


                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingSix">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionSix"
                                                                        aria-expanded="false" aria-controls="headingSix">
                                                                        {{ __('assessment.MaturityAssessment') }}
                                                                    </button>
                                                                </h2>

                                                                <div id="accordionSix" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFive"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        {{--  <h2>Associated Frameworks</h2>
                                                                  @foreach ($questionnaire->assessment->questions as $index => $question)

                                                                      @if ($question->answer_type == 1)
                                                                          <div style="font-weight: bold">{{@$question->control->Frameworks?$question->control->Frameworks->first()->name:""}}</div>
                                                                      @endif
                                                                  @endforeach --}}
                                                                        {{--  <h2>Associated Controls</h2> --}}
                                                                        <table class="table  table-bordered">

                                                                            <thead>
                                                                                <th>{{ __('assessment.AssociatedFrameworks') }}
                                                                                </th>
                                                                                <th>{{ __('assessment.CurrentControlMaturity') }}
                                                                                </th>
                                                                                <th>{{ __('assessment.DesiredControlMaturity') }}
                                                                                </th>
                                                                            </thead>
                                                                            <tbody>


                                                                                @foreach ($questionnaireAnswers->results as $result)
                                                                                    @if ($result->answer_type == 1 && $result->question->maturity_assessment == 1)
                                                                                        @if ($result->Answer)
                                                                                            @if ($result->question->control)
                                                                                                <tr>

                                                                                                    <td
                                                                                                        style="background-color: {{ ($result->Answer ? $result->Answer->fail_control : '') == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer ? ($result->Answer->question->control ? $result->Answer->question->control->Frameworks->first()->name : '') : '' }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ ($result->Answer ? $result->Answer->fail_control : '') == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer ? ($result->Answer->maturity_control ? $result->Answer->maturity_control->name : '') : '' }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ ($result->question->control->maturities[0] ? $result->question->control->maturities[0]->name : '') != ($result->Answer ? ($result->Answer->maturity_control ? $result->Answer->maturity_control->name : '') : '') ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->question->control->maturities[0] ? @$result->question->control->maturities[0]->name : '' }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif

                                                                                @endforeach


                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingseven">
                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                        <button class="accordion-button collapsed" type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#accordionseven" aria-expanded="false"
                                                                            aria-controls="accordionseven">
                                                                            {{ __('locale.Risks') }}
                                                                        </button>
                                                                    @endif
                                                                </h2>

                                                                <div id="accordionseven" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingseven"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <div class="card-datatable">
                                                                            <table class="dt-advanced-server-search table"
                                                                                id="dataTable">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>{{ __('locale.#') }}</th>
                                                                                        <th>{{ __('risk.RiskNumber') }}</th>
                                                                                        <th>{{ __('locale.Subject') }}</th>
                                                                                        <th>{{ __('locale.Description') }}
                                                                                        </th>
                                                                                        <th>{{ __('locale.Category') }}</th>
                                                                                        <th>{{ __('locale.Status') }}</th>
                                                                                        <th>{{ __('risk.ResponsiblePart') }}
                                                                                        </th>
                                                                                        <th>{{ __('risk.InherentRiskCurrent') }}
                                                                                        </th>
                                                                                        <th>{{ __('locale.SubmissionDate') }}
                                                                                        </th>
                                                                                        {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                                                                                        {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                                                                                        <th>{{ __('locale.Actions') }}</th>

                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php $i = 0; ?>
                                                                                    @foreach ($risk_Questioneres as $risk_Questionere)
                                                                                        <?php $i++; ?>
                                                                                        <?php
                                                                                        $calculatedRisk = $risk_Questionere->riskScoring()->select('calculated_risk')->first()->calculated_risk;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td>{{ $i }}</td>
                                                                                            <td>R{{ $risk_Questionere->id }}</td>
                                                                                            <td>{{ $risk_Questionere->subject ?? null }}
                                                                                            </td>
                                                                                            <td>{{ $risk_Questionere->risk_description ?? null }}
                                                                                            </td>
                                                                                            <td> {{ $risk_Questionere->category->name ?? null }}
                                                                                            </td>
                                                                                            <td>{{ $risk_Questionere->status }}
                                                                                            </td>
                                                                                            <td> {{ $risk_Questionere->assessment ?? null }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="risk-cell-holder"
                                                                                                    style="position:relative;">
                                                                                                    {{ $calculatedRisk }}
                                                                                                    <span class="risk-color"
                                                                                                        style="background-color:{{ riskScoringColor($calculatedRisk) }};position: absolute;width: 20px;height: 20px;right: 10px;top: 50%;transform: translateY(-50%);border-radius: 2px;border: 1px solid;"></span>
                                                                                                </div>


                                                                                            </td>
                                                                                            <td>{{ $risk_Questionere->submission_date ?? null }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <a href="{{ route('admin.risk_management.show', ['id' => $risk_Questionere->id]) }}"
                                                                                                    class="item-show">
                                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="24"
                                                                                                        height="24"
                                                                                                        viewBox="0 0 24 24"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        stroke-width="2"
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        class="feather feather-eye me-50 font-small-4">
                                                                                                        <path
                                                                                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                                                        </path>
                                                                                                        <circle cx="12"
                                                                                                            cy="12" r="3">
                                                                                                        </circle>
                                                                                                    </svg>
                                                                                                </a>
                                                                                                <a href="javascript:;"
                                                                                                    onclick="showModalDeleteRisk({{ $risk_Questionere->id }})"
                                                                                                    class="item-delete">
                                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="24"
                                                                                                        height="24"
                                                                                                        viewBox="0 0 24 24"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        stroke-width="2"
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        class="feather feather-trash-2 me-50 font-small-4">
                                                                                                        <polyline
                                                                                                            points="3 6 5 6 21 6">
                                                                                                        </polyline>
                                                                                                        <path
                                                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                                        </path>
                                                                                                        <line x1="10"
                                                                                                            y1="11"
                                                                                                            x2="10"
                                                                                                            y2="17"></line>
                                                                                                        <line x1="14"
                                                                                                            y1="11"
                                                                                                            x2="14"
                                                                                                            y2="17"></line>
                                                                                                    </svg>
                                                                                                </a>

                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @section('vendor-script')
            <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
            <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
            <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
            <script>
                $('.select2').select2();

                $('.add_risk').on('click', function(e) {
                    e.preventDefault();
                    $('input[name="action_type"]').val('add_risk');
                    $(this).parents('form').submit();
                });
                $('.reject_risk').on('click', function(e) {
                    e.preventDefault();
                    $('input[name="action_type"]').val('reject_risk');
                    $(this).parents('form').submit();
                })
            </script>
            <script>
                let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
                let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
                let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
                let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
                let swal_success = "{{ __('locale.Success') }}";
                let swal_error = "{{ __('locale.Error') }}";

                function showModalDeleteRisk(id) {
                    var id = id;

                    Swal.fire({
                        title: swal_title,
                        text: swal_text,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: swal_confirmButtonText,
                        cancelButtonText: swal_cancelButtonText,
                        customClass: {
                            confirmButton: 'btn btn-relief-success ms-1',
                            cancelButton: 'btn btn-outline-danger ms-1'
                        },
                        buttonsStyling: false
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin.risk_management.ajax.destroy', '') }}" +
                                    "/" + id,
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.status) {
                                        makeAlert('success', '@lang('risk.Risk was deleted successfully.')', 'Success');
                                        location.reload();
                                    } else {
                                        makeAlert('error', '@lang('risk.An error occurred while deleting the risk')', 'error');
                                        location.reload();
                                    }
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    // Handle specific error cases based on textStatus or xhr.status
                                    makeAlert('error', '@lang('risk.An error occurred while deleting the risk')', 'error');
                                    location.reload();
                                }
                            })
                        }
                    });
                }

                function makeAlert($status, message, title) {
                    // On load Toast
                    if (title == 'Success')
                        title = '👋' + title;
                    toastr[$status](message, title, {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                }

                $(document).ready(function() {
                    $('#riskForm').on('submit', function(e) {
                        e.preventDefault(); // Prevent default form submission

                        var formData = new FormData(this); // Create FormData object from the form
                        var questionnaireRiskId = $('#questionnaire_risk_id').val();

                        // Define the URL for the AJAX request
                        var url = "{{ route('admin.questionnaire-results.changeRiskStatus', ':id') }}";
                        url = url.replace(':id', questionnaireRiskId); // Replace placeholder with actual ID

                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status === true) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    }).then(function() {
                                        location.reload(); // Reload the page
                                    });
                                } else if (response.status === 'error') {
                                    let errorMessages = Object.values(response.errors).flat().join(
                                        '<br>');
                                    makeAlert('error', errorMessages, 'Error');
                                }
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                    let errorMessages = Object.values(xhr.responseJSON.errors).flat()
                                        .join('<br>');
                                    makeAlert('error', errorMessages, 'Error');
                                } else {
                                    makeAlert('error',
                                        'An error occurred while processing your request', 'Error');
                                }
                            }
                        });
                    });

                    function makeAlert(status, message, title) {
                        toastr[status](message, title, {
                            closeButton: true,
                            tapToDismiss: false,
                        });
                    }
                });
            </script>

        @endsection
