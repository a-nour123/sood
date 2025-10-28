@extends('admin.layouts.contentLayoutMaster')
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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">


                <div class="card-header"></div>


                {{--  @error('answer_percentage')
                  <div class="alert alert-danger text-center container">
                      {{$message}}
                  </div>
                  @enderror
  --}}
                @if ($session = session('success'))
                    <div class="alert alert-success text-center container">
                        {{ $session }}
                    </div>
                @endif

                @if ($error = session('error'))
                    <div class="alert alert-danger text-center container">
                        {{ $error }}
                    </div>
                @endif


                @if (session('errors') != null)
                    <div class="alert alert-danger text-center container">
                        <ul>
                            @foreach (session('errors') as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">

                    <form action="{{ route('admin.questionnaires.answer') }}" method="post" enctype="multipart/form-data"
                        id="assessment">
                        @csrf

                        <input type="hidden" name="submission_type" id="submission_type" value="complete">

                        <input type="hidden" name="contact_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="questionnaire_id" value="{{ $questionnaire->id }}">

                        <div class="row">
                            <span class="col-md-4 text-warning">
                                {{ __('locale.Instructions') }}:
                            </span>
                            <div class="col-md-8  text-warning">
                                {{ $questionnaire->instructions }}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="d-inline">{{ __('assessment.AssetName') }} </label>

                                    <select name="asset_id" required class="form-control select2" id="">
                                        <option value="">{{ __('locale.Choose') }}</option>
                                        @foreach ($assets as $asset)
                                            <option {{ old('asset_id') == $asset->id ? 'selected' : '' }}
                                                {{ @$questionnaire->latestAnswers->asset_id == $asset->id ? 'selected' : '' }}
                                                value="{{ $asset->id }}">{{ $asset->name }}</option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="answer_percentage" value="{{ $questionnaire->answer_percentage }}">
                        <input type="hidden" name="percentage_number" value="{{ $questionnaire->percentage_number }}">

                        <br>
                        @foreach ($questionnaire->assessment->questions as $index => $question)
                            <div class="form-group">
                                <label for="">
                                    <b class="badge badge-light-warning " style="font-size: 15px">{{ ++$index }}</b>
                                    <span class="" style="font-size: 15px; font-weight: bold">
                                        {{ $question->question }}</span>
                                    {{--  @error('questions.' . $index . '.answers')
                                      <span class="text-danger">{{$message}}</span>
                                      @enderror --}}
                                    <br>
                                    @if (
                                        $questionnaire->all_questions_mandatory ||
                                            ($questionnaire->specific_mandatory_questions &&
                                                in_array($question->id, $questionnaire->questions->pluck('id')->toArray())))
                                        <span class="text-danger"><span class="text-danger"
                                                style="font-size:24px">*</span></span>
                                    @endif

                                </label>
                            </div>
                            <br>
                            {{--                        Answers : --}}

                            @isset($questionnaire->latestAnswers)
                                @php
                                    if ($questionnaire->latestAnswers->status == 'complete') {
                                        $complete = true;
                                    } else {
                                        $complete = false;
                                    }
                                @endphp
                            @endisset
                            @if ($question->answer_type == 1)
                                @isset($questionnaire->latestAnswers->results)
                                    @foreach ($questionnaire->latestAnswers->results as $result)
                                        @php

                                            if (
                                                $result->answer_type == $question->answer_type &&
                                                $result->question_id == $question->id
                                            ) {
                                                $correct_question_answer = $result->answer_id;

                                                $comment = $result->comment;
                                            }
                                        @endphp
                                    @endforeach
                                @endisset



                                <input type="hidden" name="questions[{{ $index }}][answer_type]"
                                    value="{{ $question->answer_type }}">
                                <input type="hidden" name="questions[{{ $index }}][question_id]"
                                    value="{{ $question->id }}">
                                {{-- single select answer --}}
                                @if (
                                    $questionnaire->all_questions_mandatory ||
                                        ($questionnaire->specific_mandatory_questions &&
                                            in_array($question->id, $questionnaire->questions->pluck('id')->toArray())))
                                    <input type="hidden" name="questions[{{ $index }}][question_is_required]"
                                        value="true">
                                @else
                                    <input type="hidden" name="questions[{{ $index }}][question_is_required]"
                                        value="false">
                                @endif


                                @foreach ($question->answers as $answer)
                                    <div class="col-12 mb-3">
                                        <div class="d-flex align-items-center p-3 border rounded option-item">

                                            {{-- Radio button --}}
                                            <div class="form-check me-3">
                                                <input type="radio" class="form-check-input"
                                                    name="questions[{{ $index }}][answers]"
                                                    id="answer{{ $answer->id }}" value="{{ $answer->id }}"
                                                    {{ $complete ? 'readonly disabled' : '' }}
                                                    {{ old('questions.' . $index . '.answers') == $answer->id || @$correct_questionanswer == $answer->id ? 'checked' : '' }}>
                                            </div>

                                            {{-- Answer text --}}
                                            <label for="answer{{ $answer->id }}" class="flex-grow-1 mb-0">
                                                {!! trim($answer->answer) !!}
                                            </label>

                                            {{-- NDA link (only if exists) --}}
                                            @if ($answer->nda_id)
                                                <a href="{{ route('admin.export.data', $answer->nda_id) }}"
                                                    target="_blank"
                                                    class="fw-bold text-decoration-none ms-3 d-flex align-items-center text-primary">
                                                    <span>
                                                      {{ __('assessment.Nda') }} : {{ app()->getLocale() === 'ar' ? $answer->nda->name_ar : $answer->nda->name_en }}
                                                    </span>
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach


                                <br>
                                <label for="" class="d-block"> {{ __('assessment.Comment') }}</label>
                                <textarea cols="70" rows="2" name="questions[{{ $index }}][comment]">
                                  {{ old('questions.' . $index . '.comment', @$comment) }}
                                </textarea>
                                <br>
                            @elseif($question->answer_type == 2)
                                @isset($questionnaire->latestAnswers->results)
                                    @foreach ($questionnaire->latestAnswers->results as $result)
                                        @php
                                            if (
                                                $result->answer_type == $question->answer_type &&
                                                $result->question_id == $question->id
                                            ) {
                                                $correct_question_answer = explode(',', $result->answer);
                                                $comment = $result->comment;
                                            }
                                        @endphp
                                    @endforeach
                                @endisset


                                <input type="hidden" name="questions[{{ $index }}][answer_type]"
                                    value="{{ $question->answer_type }}">
                                <input type="hidden" name="questions[{{ $index }}][question_id]"
                                    value="{{ $question->id }}">
                                @if (
                                    $questionnaire->all_questions_mandatory ||
                                        ($questionnaire->specific_mandatory_questions &&
                                            in_array($question->id, $questionnaire->questions->pluck('id')->toArray())))
                                    <input type="hidden" name="questions[{{ $index }}][question_is_required]"
                                        value="true">
                                @else
                                    <input type="hidden" name="questions[{{ $index }}][question_is_required]"
                                        value="false">
                                @endif

                                @foreach ($question->answers as $answer)
                                    <input type="checkbox" {{ $complete ? ' readonly disabled' : '' }}
                                        {{ (is_array(old('questions.' . $index . '.answers')) && in_array($answer->id, old('questions.' . $index . '.answers'))) || in_array($answer->id, @$correct_question_answer ?? []) ? 'checked' : '' }}
                                        name="questions[{{ $index }}][answers][]" value="{{ $answer->id }}"
                                        id="answer_{{ $answer->id }}">
                                    <label for="answer_{{ $answer->id }}">{!! trim($answer->answer) !!}</label>
                                    <br>
                                @endforeach
                                <br>
                                <label for="" class="d-block">{{ __('assessment.Comment') }}</label>
                                <textarea cols="70" rows="2" name="questions[{{ $index }}][comment]">
                                    {{ old('questions.' . $index . '.comment', @$comment) }}
                                </textarea>
                                <br>
                            @else
                                @isset($questionnaire->latestAnswers->results)
                                    @foreach ($questionnaire->latestAnswers->results as $result)
                                        @php
                                            if (
                                                $result->answer_type == $question->answer_type &&
                                                $result->question_id == $question->id
                                            ) {
                                                $correct_question_answer = $result->answer;
                                            }
                                        @endphp
                                    @endforeach
                                @endisset

                                @if (
                                    $questionnaire->all_questions_mandatory ||
                                        ($questionnaire->specific_mandatory_questions &&
                                            in_array($question->id, $questionnaire->questions->pluck('id')->toArray())))
                                    <input type="hidden" name="questions[{{ $index }}][question_is_required]"
                                        value="true">
                                @else
                                    <input type="hidden" name="questions[{{ $index }}][question_is_required]"
                                        value="false">
                                @endif

                                <input type="hidden" name="questions[{{ $index }}][answer_type]"
                                    value="{{ $question->answer_type }}">
                                <input type="hidden" name="questions[{{ $index }}][question_id]"
                                    value="{{ $question->id }}">

                                <textarea {{ $complete ? ' readonly disabled' : '' }} name="questions[{{ $index }}][answers]" id=""
                                    cols="70" rows="2"
                                    {{ $questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id, $questionnaire->questions->pluck('id')->toArray())) ? 'required' : '' }}>


                                    {{ old('questions.' . $index . '.answers', @$correct_question_answer) }}
                                </textarea>

                                <br>
                            @endif
                            @if ($question->file_attachment || $question->nda_assessment)
                                <input type="file" name="questions[{{ $index }}][file]">
                                <br>
                                <br>
                            @endif
                        @endforeach
                        @if (!$complete)
                            <button type="button"
                                class="btn btn-warning draft_submit">{{ __('assessment.Draft') }}</button>
                            <button type="button"
                                class="btn btn-success complete_submit">{{ __('assessment.Complete') }}</button>
                        @endif

                        <a href="{{ url()->to('/admin/dashboard') }}" type="submit"
                            class="btn btn-primary">{{ __('assessment.Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
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
    {{-- <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.polyfilled.min.js')) }}"></script>
    <script src="{{ asset('cdn/toastr.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery-3.6.0.min.js') }}"></script>


    <script src="{{ asset('cdn/jquery.min.js') }}"></script>

    {{-- <script>
$(document).ready(function() {
    $('.draft_submit').click(function() {
        $('#submission_type').val('draft');
        $('#assessment').submit(); // Submit the form
    });

    $('.complete_submit').click(function() {
        $('#submission_type').val('complete');
        $('#assessment').submit(); // Submit the form
    });
});

</script> --}}
    <script>
        $(document).ready(function() {
            $('.draft_submit').click(function() {
                submitForm('draft');
            });

            $('.complete_submit').click(function() {
                submitForm('complete');
            });

            function submitForm(submissionType) {
                // Set the submission type in the hidden input
                $('#submission_type').val(submissionType);

                // Create FormData object
                var formData = new FormData($('#assessment')[0]);

                // Send AJAX request
                $.ajax({
                    url: $('#assessment').attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false, // Important for file uploads
                    contentType: false, // Important for file uploads
                    success: function(response) {
                        // Handle success response
                        if (response.status === 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: submissionType === 'draft' ? 'info' : 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                window.location.href = "{{ route('admin.dashboard') }}";
                            });
                        } else if (response.status === 'error') {
                            // Handle validation errors
                            if (response.errors) {
                                let errorMessages = Object.values(response.errors).flat().join('<br>');

                                if (errorMessages.includes(
                                        'Please answer all questions with [*] sign.')) {
                                    makeAlert('error', 'Please answer all questions with [*] sign.',
                                        'Error');
                                } else {
                                    makeAlert('error', errorMessages, 'Error');
                                }
                            } else {
                                makeAlert('error', 'Sorry, an error occurred on the server.', 'Error');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = Object.values(xhr.responseJSON.errors).flat().join(
                                '<br>');

                            if (errorMessages.includes('Please answer all questions with [*] sign.')) {
                                makeAlert('error', 'Please answer all questions with [*] sign.',
                                    'Error');
                            } else {
                                makeAlert('error', errorMessages, 'Error');
                            }
                        } else {
                            makeAlert('error', 'An error occurred while processing your request',
                                'Error');
                        }
                    }
                });
            }

            function makeAlert($status, message, title) {
                // On load Toast
                if (title == 'error')
                    title = '👋' + title;
                toastr[$status](message, title, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        });
    </script>
@endsection
