@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.Survey'))
<style>

</style>

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
@endsection
{{-- the blade of mail that appear to user --}}
@section('content')
    <section id="advanced-search-datatable">
        <hr class="my-0" />
        <div class="card-datatable table-responsive ">
            <table class="dt-advanced-server-search table">
                <thead>
                    <tr>
                        <th>{{ __('locale.#') }}</th>

                        <th class="all">{{ __('locale.Title') }}</th>
                        <th class="all">{{ __('locale.Description') }}</th>
                        {{-- <th class="all">{{ __('locale.CreatedDate') }}</th> --}}
                        <th class="all">{{ __('locale.Actions') }}</th>



                    </tr>
                </thead>
                {{-- fetch data --}}
                <tbody>
                    <?php $i = 0; ?>
                    @foreach ($survey as $survey)
                        <tr>
                            <?php $i++; ?>
                            <td>{{ $i }}</td>


                            <td><a href="#" link-secondary>{{ $survey->name }}</a></td>
                            <td>{{ $survey->description }}</td>


                            @if ($draftStatus === 0)
                                <td>
                                    <a href="{{ route('admin.awarness_survey.AnswersQuestionsSurvey.show', $survey->id) }}"
                                        class="btn btn-primary" data-url="" title="Answer Survey" data-id="">
                                        <i style="margin-right: 10px;font-size: 1em;"
                                            class="fa fa-edit fa-sm"></i>{{ __('survey.AnswerSurvey') }}
                                    </a>
                                </td>
                            @elseif($draftStatus === 1)
                                <td>
                                    <a href="{{ route('admin.awarness_survey.AnswersQuestionsSurvey.show', $survey->id) }}"
                                        class="btn btn-success" data-url="" title="Show Answer" data-id=""><i
                                            style="margin-right: 10px;font-size: 1em;"
                                            class="fa fa-star  fa-4x"></i>{{ __('survey.ShowAnswer') }}

                                    </a>
                                </td>
                            @elseif($draftStatus === 2)
                                <td>
                                    <a href="{{ route('admin.awarness_survey.AnswersQuestionsSurvey.show', $survey->id) }}"
                                        class="btn btn-secondary" data-url="" title="Complete Answer Survey"
                                        data-id=""><i style="margin-right: 10px;font-size: 1em;"
                                            class="fa fa-envelope fa-3x"></i>{{ __('survey.CompleteAnswerSurvey') }}

                                    </a>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>{{ __('locale.#') }}</th>
                        <th class="all">{{ __('locale.Title') }}</th>
                        <th class="all">{{ __('locale.Description') }}</th>
                        {{-- <th class="all">{{ __('locale.CreatedDate') }}</th> --}}
                        <th class="all">{{ __('locale.Actions') }}</th>

                    </tr>
                </tfoot>

            </table>
        </div>

    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.polyfilled.min.js')) }}"></script>



@endsection
