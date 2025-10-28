<!DOCTYPE html>
<html>

<head>
    <title>Awareness Survey</title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <script src="{{ asset('cdn/3.5.1jquery.min.js') }}"></script>
    <script src="{{ asset('cdn/popper.min.js') }}"></script>
    {{-- <script src="{{ asset('cdn/4.5.2js/bootstrap.min.js') }}"></script> --}}
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">

    {{-- <script src="script.js"></script> --}}
    <script src="{{ asset('cdn/sweetalert2@11') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.polyfilled.min.js')) }}"></script>
    <script src="{{ asset('cdn/toastr.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery.min.js') }}"></script>
    <script src="{{ asset('cdn/umdpopper.min.js') }}"></script>
    
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    {{-- <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <link rel="stylesheet" href="{{ asset('cdn/bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('cdn/bootstrap.min.css') }}" />

        <script src="{{ asset('cdn/jquery-3.3.1.slim.min.js') }}"></script>
        <script src="{{ asset('cdn/umdpopper.min.js') }}"></script>
        {{-- <script src="{{ asset('cdn/distjsbootstrap.min.js') }}"></script> --}}

    <script src="{{ asset('cdn/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />


    {{-- the progress increase after check --}}

    <style>
        body {
            background-color: #f4f4f4;
        }

        #container {
            max-width: 69%;
        }

        .list-group-flush {
            border-radius: 15px;
        }

        .step-container {
            position: relative;
            text-align: center;
            transform: translateY(-43%);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #007bff;
            line-height: 30px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
            /* Added cursor pointer */
        }

        .step-line {
            position: absolute;
            top: 16px;
            left: 50px;
            width: calc(100% - 100px);
            height: 2px;
            background-color: #007bff;
            z-index: -1;
        }

        #multi-step-form {
            overflow-x: hidden;
        }

        .gov_btn {
            border-color:  #44225c!important;
            background-color:  #44225c!important;
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
            border-color: #44225c;
            background-color: #44225c;
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


        .progress-bar {
            width: 0%;
            height: 25px;
            background-color: #ccc;
        }

        .fixed-bar {
            position: fixed;
            top: 190px;
            left: 80px;
            margin-right: 0;

        }

        .fixed {
            position: fixed;
            top: 190px;
            /* Adjust the value as needed */
            right: 20px;
            /* Adjust the value as needed */
        }

        .progress-container {
            box-shadow: 0 4px 5px rgb(0, 0, 0, 0.1);
            margin-left: -45px;
        }

        .progress-container,
        .progress {
            background-color: #eee;
            border-radius: 5px;
            position: relative;
            height: 7px;
            /* width: 300px; */
        }

        .progress {
            background-color: #6F39B0;
            width: 0;
            transition: width 0.4s linear;
        }

        .percentage {
            background-color: #5d7bc4;
            border-radius: 5px;
            box-shadow: 0 4px 5px rgb(0, 0, 0, 0.2);
            color: #fff;
            font-size: 14px;
            padding: 4px;
            position: absolute;
            top: 29px;
            left: 0;
            transform: translateX(-50%);
            width: 46px;
            text-align: center;
            transition: left 0.4s linear;
        }

        .percentage::after {
            background-color: #5d7bc4;
            content: '';
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            height: 10px;
            width: 10px;
            z-index: -1;
        }

        .bs-stepper-content {
            width: 100%;
            margin-left: 50px;
        }

        .avatar {
            margin-right: 18px;
            margin-left: 10px;

        }

        .form-check-input {
            position: absolute;
            margin-top: -0.7rem;
            margin-left: -1.25rem;
        }

        .footer {
            text-align: center;
        }



        @media screen and (max-width: 600px) {
            .swal2-container {
                width: 90% !important;
                left: 5% !important;
                right: 5% !important;
                top: 10% !important;
                transform: translateY(50%) !important;
            }

            .swal2-container.swal2-center>.swal2-popup {
                grid-column: 2;
                grid-row: 1;
                align-self: center;
                justify-self: center;
            }
        }
    </style>

</head>

<body>

    {{-- form of the questions --}}

    <div class="container-fluid" id="add_answer" style="margin-top: 39px;">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('survey.surveyName') }}:{{ $survey->name }}</h4>
            </div>
        </div>
                <div class="row allForm" id="add_answer">
            <div class=" col-md-2 bar fixed-bar" style="margin-top: 245px;float: right;width:auto;">

                <div class="progress-container" data-percentage='0'
                    style="-webkit-transform: rotate(-90deg);transform: rotate(-90deg);height: 1.857rem; width: 17.714rem;">
                    <div class="progress" style="height: 27px;width:0%;background-color: #243b72;"></div>
                    <div class="percentage"
                        style="    margin-left: -39px;
                        margin-top: 13px;
                        left: 12.3333%;transform: rotate(90deg);">
                        0%</div>
                </div>
                <div id="countDiv" style="margin-left: -20px;">
                    <span>(0)</span> from <span>({{ count($questions) }})</span>
                </div>
            </div>
            <div class=" col-md-10 ">
                <form action="{{ route('admin.awarness_survey.svaeoutside') }}" method="POST" id="form">
                    @csrf
                    <?php $i = 0; ?>
                    <input type="hidden" name="draft" id="draftInput" value="0">
                    <input type="hidden" name="survey_id" id="survey_id" value="{{ $survey_id }}">
                    <input type="hidden" name="username" id="username">
                    <input type="hidden" name="email" id="email">

                    @foreach ($questions as $question)
                        <?php $i++; ?>
                        <div class="repeater">
                            <div data-repeater-list="questions">
                                <div data-repeater-item>
                                    <div class="row d-flex align-items-end">
                                        <!-- content -->
                                        <div class="bs-stepper-content shadow-none" multiple="multiple">
                                            <div class="content" role="tabpanel"
                                                aria-labelledby="create-app-details-trigger">
                                                <input type="hidden" name="question_id[{{ $question->id }}]"
                                                    id="question_id" value="{{ $question->id }}">


                                                <h5 class="question-number" data-title="{{ __('survey.Question') }}">
                                                    {{ __('survey.Question') }} : {{ $i }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-1">
                                                            <textarea class="form-control" rows="2" id="question" readonly value="{{ $question->question }}" readonly>{{ $question->question }}</textarea>
                                                            {{-- class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>

                                                </div>


                                                <h5 class="mt-2 pt-1"
                                                    data-title="{{ __('survey.Question') }} (question_number) {{ __('survey.options') }} ">
                                                    {{ __('survey.options') }}
                                                </h5>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item border-0 px-0">
                                                        <label for="Q1-OptionA" class="d-flex cursor-pointer">
                                                            <span
                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionA') }}</span>
                                                            <span
                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                <span class="me-1" style="width: 95%">
                                                                    <label class="form-control"
                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionA')]) }}"
                                                                        id="option_A">{{ $question->option_A }}<label>
                                                                            <span class="custom-error error d-none">
                                                                                {{ __('locale.requiredField', ['attribute' => __('survey.OptionA')]) }}</span>
                                                                </span>
                                                                <span>
                                                                    @if ($question->answer_type == 1)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="A" type="radio"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                    @if ($question->answer_type == 2)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="A" type="checkbox"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li class="list-group-item border-0 px-0">
                                                        <label for="Q1-OptionB" class="d-flex cursor-pointer">
                                                            <span
                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionB') }}</span>
                                                            <span
                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                <span class="me-1"
                                                                    style="width: 95%; cursor: text;">

                                                                    <label class="form-control"
                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionB')]) }}"
                                                                        id="option_B">{{ $question->option_B }}<label>
                                                                            <span class="custom-error error d-none">
                                                                                {{ __('locale.requiredField', ['attribute' => __('survey.OptionB')]) }}</span>
                                                                </span>
                                                                <span>
                                                                    @if ($question->answer_type == 1)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="B" type="radio"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                    @if ($question->answer_type == 2)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="B" type="checkbox"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li class="list-group-item border-0 px-0">
                                                        <label for="Q1-OptionC" class="d-flex cursor-pointer">
                                                            <span
                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionC') }}</span>
                                                            <span
                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                <span class="me-1"
                                                                    style="width: 95%; cursor: text;">
                                                                    <label class="form-control"
                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionC')]) }}"
                                                                        id="option_C">{{ $question->option_C }}<label>
                                                                            <span class="custom-error error d-none">
                                                                                {{ __('locale.requiredField', ['attribute' => __('survey.OptionC')]) }}
                                                                            </span>
                                                                </span>
                                                                <span>
                                                                    @if ($question->answer_type == 1)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="C" type="radio"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                    @if ($question->answer_type == 2)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="C" type="checkbox"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li class="list-group-item border-0 px-0">
                                                        <label for="Q1-OptionD" class="d-flex cursor-pointer">
                                                            <span
                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionD') }}</span>
                                                            <span
                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                <span class="me-1"
                                                                    style="width: 95%; cursor: text;">
                                                                    <label class="form-control"
                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionD')]) }}"
                                                                        id="option_D">{{ $question->option_D }}<label>
                                                                            <span
                                                                                class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionD')]) }}</span>
                                                                </span>
                                                                <span>
                                                                    @if ($question->answer_type == 1)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="D" type="radio"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                    @if ($question->answer_type == 2)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="D" type="checkbox"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li class="list-group-item border-0 px-0">
                                                        <label for="Q1-OptionE" class="d-flex cursor-pointer">
                                                            <span
                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionE') }}</span>
                                                            <span
                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                <span class="me-1"
                                                                    style="width: 95%; cursor: text;">
                                                                    <label class="form-control"
                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionE')]) }}"
                                                                        id="option_E">{{ $question->option_E }}<label>
                                                                            <span class="custom-error error d-none">
                                                                                {{ __('locale.requiredField', ['attribute' => __('survey.OptionE')]) }}</span>
                                                                </span>
                                                                <span>
                                                                    @if ($question->answer_type == 1)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="E" type="radio"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                    @if ($question->answer_type == 2)
                                                                        <input class="form-check-input changetype"
                                                                            id="Q1-Option_{{ $question->id }}"
                                                                            value="E" type="checkbox"
                                                                            name="answer[{{ $question->id }}][]" />
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <span
                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Answer')]) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- subimt and draft of Answers --}}
                    <div class="footer mt-2">
                        <button style="font-size: 18px;
                        width: 10%; margin-bottom:70px"
                            id="submitBtn" class="btn btn-primary btn-sm"
                            type="submit">{{ __('locale.Send') }}</button>


                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            var form = $('#add_answer form');
            var formData = form.serialize();
            var url = "{{ route('admin.awarness_survey.checkbox.submit') }}";
            var token = $('meta[name="csrf-token"]').attr('content');

            console.log(url);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(response) {
                    const totalQuestions = {{ count($questions) }};
                    const answeredQuestions = document.querySelectorAll('input[type="checkbox"]:checked',
                        'input[type="radio"]:checked').length;
                    var progressContainer = document.querySelector('.progress-container');

                    const percentage = Math.round((answeredQuestions / totalQuestions) * 100 * 10) / 10 + '%';

                    const progressEl = progressContainer.querySelector('.progress');
                    const percentageEl = progressContainer.querySelector('.percentage');

                    progressEl.style.width = response + '%';
                    percentageEl.innerText = response.toFixed(1) + '%';
                    percentageEl.style.left = response + '%';
                    progressContainer.setAttribute('data-percentage', percentage);

                },
                error: function(xhr) {}
            });
        }

        $(document).ready(function() {
            $('input:checkbox').change(function() {
                submitForm();
            });
            $('input:radio').change(function() {
                submitForm();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="radio"], input[type="checkbox"]').click(function() {
                var selectedCount = $('input[type="checkbox"]:checked').length;
                var selectedCount2 = $('input[type="radio"]:checked').length;
                var totalCheckboxes = $('input[type="checkbox"]').length;

                var uniqueCheckboxes = Math.floor($('input[type="checkbox"]').filter(function() {
                    return $('input[name="' + $(this).attr('name') + '"]').is(':checked');
                }).length / 5);

                var calculatedCount = selectedCount2 + uniqueCheckboxes;

                $('#countDiv span:first-child').text('(' + calculatedCount + ')');
            });
        });
    </script>



    <script>
        $('#form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {


                    console.log(response.message);
                    if (response.errors === "err_percentage") {
                        toastr.error(response.message);
                    } else if (response.errors === "err_AnswerlessThanQuestios") {
                        toastr.error(response.message);
                    } else if (response.errors === "err_answerEmpty") {
                        toastr.error(response.message);
                    } else {
                        $('.allForm').hide();
                        $('.fixed-bar').hide();
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: '{{ __('locale.YourAnswersHaveBeenSent') }}',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                window.location.href = document.referrer;
                            });
                        }
                    }
                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        switch (key) {
                            case "contacts":
                                key = 'contacts[]'
                                break;
                            case "questions":
                                key = 'questions[]'
                                break;
                        }

                        makeAlert('error', val);
                        let input = $('input[name="' + key + '"] , textarea[name="' + key +
                            '"] , select[name="' + key + '"]')
                        input.addClass('is-invalid');
                    })
                }
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            function openUsernameEmailSwal() {
                Swal.fire({
                    title: 'Enter your username',
                    input: 'text',
                    inputLabel: 'Username',
                    inputPlaceholder: 'Enter your username',
                    showCancelButton: false,
                    confirmButtonText: 'Next →',
                    allowOutsideClick: false,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Username is required!';
                        }
                    },
                    allowEscapeKey: false, // Prevent ESC key from closing the dialog
                }).then((result) => {
                    const username = result.value;
                    $('input[name="username"]').val(username);

                    Swal.fire({
                        title: 'Enter your email',
                        input: 'email',
                        inputLabel: 'Email',
                        inputPlaceholder: 'Enter your email',
                        showCancelButton: false,
                        confirmButtonText: 'Submit',
                        allowOutsideClick: false,
                        allowEscapeKey: false, // Prevent ESC key from closing the dialog
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Email is required!';
                            } else if (!validateEmail(value)) {
                                return 'Invalid email format!';
                            }
                        }
                    }).then((result) => {
                        const email = result.value;
                        $('input[name="email"]').val(email);

                        const emailExistWithAnswer = <?php echo json_encode($emailExistWithAnswer); ?>;
                        const emails = <?php echo json_encode($emails); ?>;
                        const emailExistsInMain = emails.some((e) => e.email.toLowerCase() === email
                            .toLowerCase());

                        if (emailExistWithAnswer.some(item => item.email === email)) {
                            Swal.fire({
                                title: 'Survey Already Answered',
                                text: 'This survey has already been answered with the provided email.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                openUsernameEmailSwal
                            (); // Reopen the Swal when "OK" is clicked
                            });
                        } else if (emailExistsInMain) {
                            const currentPageUrl = window.location.href;
                            const newUrl = currentPageUrl.replace("Examoutside", "GetExam");
                            window.location.href = newUrl;
                        }
                    });
                });
            }

            openUsernameEmailSwal(); // Call the function to open the Swal initially
        });

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    </script>
</body>

</html>
