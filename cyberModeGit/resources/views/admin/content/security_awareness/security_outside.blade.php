<!DOCTYPE html>
<html>

<head>
    <title>Security Awareness Exam</title>
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

        <div class="row allForm" id="add_answer">
            <div class=" col-md-10 ">
                <form action="{{ route('admin.security_awareness.takeExamFromOutSideCyber') }}" method="POST" id="form">
                    @csrf
                    <?php $i = 0; ?>
                    <input type="hidden" name="securityAwarness_id" id="securityAwarness_id" value="{{ $securityAwarness_id }}">
                    <input type="hidden" name="email" id="email">
                    <input type="hidden" name="username" id="username">
                    <input type="hidden" name="uniqid" value="">

                    @foreach ($questions as $question)
                        <?php $i++; ?>
                        <input type="hidden" name="questions[{{ $question->id }}][id]" value="{{ $question->id }}">
                        <div class="repeater">
                            <div data-repeater-list="questions">
                                <div data-repeater-item>
                                    <div class="row d-flex align-items-end">
                                        <!-- content -->
                                        <div class="bs-stepper-content shadow-none" multiple="multiple">
                                            <div class="content" role="tabpanel" aria-labelledby="create-app-details-trigger">
                                                <h5 class="question-number" data-title="{{ __('survey.Question') }}">
                                                    {{ __('survey.Question') }} : {{ $i }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-1">
                                                            <textarea class="form-control" rows="2" id="question" readonly
                                                                value="{{ $question->question }}"
                                                                readonly>{{ $question->question }}</textarea>
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
                                                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                                    <li class="list-group-item border-0 px-0">
                                                        <label for="Q{{ $i }}-Option{{ $option }}" class="d-flex cursor-pointer">
                                                            <span class="avatar avatar-tag bg-light-info me-1">{{ $option }}</span>
                                                            <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                <span class="me-1" style="width: 95%">
                                                                    <label class="form-control"
                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.Option' . $option)]) }}"
                                                                        id="option_{{ $option }}">{{ $question->{'option_' . strtolower($option)} }}</label>
                                                                </span>
                                                                <span>
                                                                    <input class="form-check-input changetype"
                                                                        id="Q{{ $i }}-Option_{{ $option }}"
                                                                        value="{{ $option }}" type="radio"
                                                                        name="questions[{{ $question->id }}][answer]" />
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    @endforeach
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

                    {{-- submit and draft of Answers --}}
                    <div class="footer mt-2">
                        <button style="font-size: 18px; width: 10%; margin-bottom:70px" id="submitBtn"
                            class="btn btn-primary btn-sm" type="submit">{{ __('locale.Send') }}</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

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
                                title: 'Security Exam Already Answered',
                                text: 'This Security Exam has already been answered with the provided email.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                openUsernameEmailSwal
                            (); // Reopen the Swal when "OK" is clicked
                            });
                        }
                        else if (emailExistsInMain) {
                            window.location.href = "{{ route('admin.security_awareness.index') }}";
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
