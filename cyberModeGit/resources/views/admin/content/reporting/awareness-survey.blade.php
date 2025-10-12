@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.AwarenessSurvey'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection
<style>
    /* .badge.rounded-pill {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.5;
    text-align: center;
    white-space: nowrap;
}

.badge.rounded-pill.text-center {
    display: flex;
    align-items: center;
    justify-content: center;
} */
</style>

@section('content')
    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('report.Report') }}:
                                {{ __('report.AwarenessSurvey') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="form-label">{{ __('report.AwarenessSurvey') }}:</label>
                                <select class="form-control select2 " name="awareness_survey_id" id="awareness-survey"
                                    onchange="changeSurvey(this.value)">
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($surveys as $survey)
                                        <option value="{{ $survey->id }}">{{ $survey->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-awareness_survey_id"></span>
                            </div>
                            <div id="exam-details-container" style="display: none">
                                {{-- Summary data --}}
                                <div class="col-12 mt-2" id="summart-container">
                                    <h5 class="mb-1">{{ __('report.Summary') }}</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>{{ __('report.SumEmployeeTakeSurvey') }}</th>
                                                <th>{{ __('report.Done') }}</th>
                                                <th>{{ __('report.Draft') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Details data --}}
                                <div class="col-12 mt-2" id="details-container">
                                    <h5 class="mb-1">{{ __('locale.Details') }}</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>{{ __('locale.Employee') }}</th>
                                                <th>{{ __('locale.Type') }}</th>
                                                <th>{{ __('report.SumQuestions') }}</th>
                                                <th>{{ __('report.SumAnswers') }}</th>
                                                <th>{{ __('report.SumNotAnswered') }}</th>
                                                <th>{{ __('locale.Time') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="demo-spacing-0 mt-2" style="display: none" id="exam-details-container-empty">
                                <div class="alert alert-danger" role="alert">
                                    <div class="alert-body text-center">
                                        {{ __('report.NoAnswersOnThisExam') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        function changeSurvey(id) {
            var url = "{{ route('admin.reporting.awareness_survey_detail', '') }}" + "/" + id;

            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    // Update the summary table
                    $('#summart-container td:first-child').addClass('text-center').html(
                        '<span class="badge rounded-pill badge-light-info">' + response
                        .AnswersIsDraftOrNot + '</span>');
                    $('#summart-container td:nth-child(2)').addClass('text-center').html(
                        '<span class="badge rounded-pill badge-light-success">' + response.AnswersNotDraft +
                        '</span>');
                    $('#summart-container td:last-child').addClass('text-center').html(
                        '<span class="badge rounded-pill badge-light-danger">' + response.AnswersIsDraft +
                        '</span>');

                    // Update the details table
                    var detailsContainer = $('#details-container tbody');
                    detailsContainer.empty(); // Clear previous data

                    $.each(response.userResponses, function(index, userResponse) {
                        var row = $('<tr></tr>');
                        row.append(
                            '<td class="text-center"><span class="badge rounded-pill badge-light-primary">' +
                            userResponse.userName + '</span></td>');
                        row.append(
                            '<td class="text-center"><span class="badge rounded-pill badge-light-primary">' +
                            userResponse.type + '</span></td>');
                        row.append(
                            '<td class="text-center"><span class="badge rounded-pill badge-light-info">' +
                            userResponse.sumQuestions + '</span></td>');
                        row.append(
                            '<td class="text-center"><span class="badge rounded-pill badge-light-success">' +
                            userResponse.answered + '</span></td>');
                        row.append(
                            '<td class="text-center"><span class="badge rounded-pill badge-light-danger">' +
                            userResponse.remaining + '</span></td>');
                        row.append(
                            '<td class="text-center"><span class="badge rounded-pill badge-light-success">' +
                            userResponse.response + '</span></td>');
                        detailsContainer.append(row);
                    });

                    // Show or hide containers based on data availability
                    if (response.AnswersIsDraftOrNot == 0) {
                        $('#exam-details-container-empty').slideDown();
                        $('#exam-details-container').slideUp();
                    } else {
                        $('#exam-details-container-empty').slideUp();
                        $('#exam-details-container').slideDown();
                    }
                },
                error: function(error) {
                    console.log("error");
                }
            });
        }
    </script>
@endsection
