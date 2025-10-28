<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Cyber Mode</title>
    <link rel="apple-touch-icon" href="{{ asset(getSystemSetting('APP_FAVICON')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(getSystemSetting('APP_FAVICON')) }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/bootstrap.min.css') }}" />
    <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: #f5f7f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .remedation-card {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--accent-color);
        }

        .question-card {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
        }

        .question-card:hover {
            transform: translateY(-5px);
        }

        .question-text {
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #eee;
            color: var(--secondary-color);
        }

        .question-number {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            /* width: 32px; */
            height: 32px;
            border-radius: 10px;
            text-align: center;
            line-height: 32px;
            margin-right: 10px;
            margin-bottom: 6px;
        }

        .language-section {
            margin: 0.5rem 0;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .question-english,
        .answer-english {
            margin-bottom: 0.75rem;
            padding: 0.5rem;
            border-left: 3px solid var(--primary-color);
        }

        .question-arabic,
        .answer-arabic {
            margin-bottom: 0.75rem;
            padding: 0.5rem;
            border-left: 3px solid var(--accent-color);
            direction: rtl;
            text-align: right;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .answer-container {
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 8px;
            background-color: var(--light-bg);
            transition: background-color 0.2s;
        }

        .answer-container:hover {
            background-color: #e9ecef;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .comment-box {
            margin-top: 1.5rem;
        }

        .nda-link {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #e7f4ff;
            color: var(--primary-color);
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nda-link:hover {
            background-color: #d1ecff;
            text-decoration: underline;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
        }

        .submit_questionnaire_btn {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .submit_questionnaire_btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .header {
                padding: 1.5rem;
            }

            .question-card {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- Email verification modal --}}
        <div class="modal fade" id="emailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="emailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="emailModalLabel">Enter your email</h1>
                        <button type="button" class="btn-close d-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="contactEmail" name="contact_email"
                                placeholder="name@example.com">
                            <label for="contactEmail">Email address</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submitCheckEmail" disabled class="btn btn-primary">Send</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Password verification modal --}}
        <div class="modal fade" id="passwordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="passwordModalLabel">Enter password received in your email</h1>
                        <button type="button" class="btn-close d-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="accessPassword" name="access_password"
                                placeholder="Enter password">
                            <label for="accessPassword">Password</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submitCheckPassword" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <form action="" id="questionnaireForm" class="form-control w-100 border-0 d-none">
            <div class="header text-center">
                <h1>{{ $data['questionnaire']->name }}</h1>
                <p>Complete this cybersecurity assessment to evaluate your organization's security posture</p>
            </div>

            @if ($data['remedationNote'])
                <div class="remedation-card">
                    <label class="form-label mb-3">
                        <span class="fw-bold">Remediation Note:</span>
                    </label>
                    <p>{!! $data['remedationNote'] !!}</p>
                </div>
            @endif

            <div class="remedation-card mb-4">
                <label class="form-label">
                    <span class="fw-bold">Assessment Instructions:</span>
                </label>
                <p>{{ $data['questionnaire']->instructions ?? 'No instructions available' }}</p>
            </div>

            @php $x = 0 @endphp

            {{-- Check if latestResults has data, otherwise fallback to questions --}}
            @if (isset($data['latestResults']) && count($data['latestResults']) > 0)
                @foreach ($data['latestResults'] as $result)
                    @php
                        $x++;
                        // Parse the question JSON
                        $questionData = json_decode($result->getRawOriginal('question'), true);
                        $questionEn = $questionData['en'] ?? '';
                        $questionAr = $questionData['ar'] ?? '';
                    @endphp
                    <div class="question-card">
                        <div class="question-text">
                            <span class="question-number">Question-{{ $x }}:</span>
                            @if ($questionEn)
                                <div class="question-english">{!! $questionEn !!}</div>
                            @endif
                            @if ($questionAr)
                                <div class="question-arabic">{!! $questionAr !!}</div>
                            @endif
                        </div>

                        @foreach ($result->answers as $answer_id => $answer)
                            @php
                                // Ensure we have the nested "answer"
                                if (is_array($answer) && isset($answer['answer'])) {
                                    $answerData = json_decode($answer['answer'], true) ?? [];
                                } else {
                                    $answerData = [];
                                }

                                $answerEn = $answerData['en'] ?? '';
                                $answerAr = $answerData['ar'] ?? '';
                            @endphp

                            <div class="answer-container">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="answer[{{ $result->question_id }}]"
                                        @if ($result->answer_id === $answer_id) checked @endif value="{{ $answer_id }}"
                                        id="{{ $answer_id }}">
                                    <label class="form-check-label w-100" for="{{ $result->question_id }}">
                                        @if ($answerEn)
                                            <div class="answer-english">{!! $answerEn !!}</div>
                                        @endif
                                        @if ($answerAr)
                                            <div class="answer-arabic">{!! $answerAr !!}</div>
                                        @endif
                                        {{-- NDA link (only if exists) --}}
                                        @if (isset($answer->nda_id))
                                            <a href="{{ route('admin.export.data', $answer->nda_id) }}"
                                                target="_blank" class="nda-link mt-2">
                                                <i class="fas fa-file-contract me-2"></i>
                                                {{ __('assessment.Nda') }}:
                                                {{ app()->getLocale() === 'ar' ? $answer->nda->name_ar : $answer->nda->name_en }}
                                            </a>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach

                        <div class="comment-box">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="comment[{{ $result->question_id }}]"
                                    style="height: 100px">{{ $result->comment }}</textarea>
                                <label for="comment[{{ $result->question_id }}]">Comments</label>
                            </div>
                        </div>
                         @if ($result->nda_assessment)
                            <div class="mt-3">
                                <label for="file_{{ $result->question_id }}" class="form-label">Upload File:</label>

                                {{-- If there is already an uploaded file --}}
                                @if (!empty($result->file))
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="{{ asset('storage/' . $result->file) }}" target="_blank"
                                            class="me-3">
                                            View File
                                        </a>
                                    </div>
                                @endif

                                {{-- Always show file input (to upload or replace old one) --}}
                                <input class="form-control" type="file"
                                    name="questions[{{ $result->question_id }}][file]"
                                    id="file_{{ $result->question_id }}">
                            </div>
                        @endif

                    </div>
                @endforeach
            @elseif(isset($data['questions']) && count($data['questions']) > 0)
                @foreach ($data['questions'] as $question)
                    @php
                        $x++;
                        // Parse the question JSON
                        $questionData = json_decode($question->getRawOriginal('question'), true);
                        $questionEn = $questionData['en'] ?? '';
                        $questionAr = $questionData['ar'] ?? '';
                    @endphp
                    <div class="question-card">
                        <div class="question-text">
                            <span class="question-number">Question-{{ $x }}:</span>
                            @if ($questionEn)
                                <div class="question-english">{!! $questionEn !!}</div>
                            @endif
                            @if ($questionAr)
                                <div class="question-arabic">{!! $questionAr !!}</div>
                            @endif
                        </div>

                        @foreach ($question->answers as $answer)
                            @php
                                // Parse the answer JSON
                                $answerData = json_decode($answer->getRawOriginal('answer'), true);
                                $answerEn = $answerData['en'] ?? '';
                                $answerAr = $answerData['ar'] ?? '';
                            @endphp
                            <div class="answer-container">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="answer[{{ $question->id }}]" value="{{ $answer->id }}"
                                        id="answer_{{ $answer->id }}">
                                    <label class="form-check-label w-100" for="answer_{{ $answer->id }}">
                                        @if ($answerEn)
                                            <div class="answer-english">{!! $answerEn !!}</div>
                                        @endif
                                        @if ($answerAr)
                                            <div class="answer-arabic">{!! $answerAr !!}</div>
                                        @endif

                                        {{-- NDA link (only if exists) --}}
                                        @if (isset($answer->nda_id) && $answer->nda)
                                            <a href="{{ route('admin.export.data', $answer->nda_id) }}"
                                                target="_blank" class="nda-link mt-2">
                                                <i class="fas fa-file-contract me-2"></i>
                                                {{ __('assessment.Nda') }}:
                                                {{ app()->getLocale() === 'ar' ? $answer->nda->name_ar : $answer->nda->name_en }}
                                            </a>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach

                        <div class="comment-box">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="comment[{{ $question->id }}]"
                                    style="height: 100px"></textarea>
                                <label for="comment[{{ $question->id }}]">Comments</label>
                            </div>
                        </div>

                        @if ($question->nda_assessment)
                            <div class="mt-3">
                                <label for="file_{{ $question->id }}" class="form-label">Upload File:</label>
                                <input class="form-control" type="file"
                                    name="questions[{{ $question->id }}][file]" id="file_{{ $question->id }}">
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif

            <div class="btn-group">
                <button type="button" data-submission_type="draft"
                    class="btn btn-secondary submit_questionnaire_btn">Save as Draft</button>
                <button type="button" data-submission_type="complete"
                    class="btn btn-primary submit_questionnaire_btn">Submit Assessment</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('cdn/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery.blockUI.min.js') }}"></script>

    <script>
        const backToTopBtn = document.getElementById("backToTopBtn");

        window.onscroll = function() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                backToTopBtn.classList.add("show");
            } else {
                backToTopBtn.classList.remove("show");
            }
        };

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var questionnaireId = `{{ $data['questionnaire']->id }}`;
        var currentContactId = `{{ $data['contact']->value('contact_id') }}`;
        var currentContactEmail = `{{ $data['contact']->value('contact_email') }}`;
        var accessPassword = {!! json_encode($data['access_password']) !!};

        $(document).ready(function() {
            // Automatically open the modal when the page loads
            $('#emailModal').modal('show');
            $("#contactEmail").val('');
            $("#submitCheckEmail").prop("disabled", true);
        });

        $(document).ready(function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            $("#contactEmail").on("input", function() {
                const email = $(this).val();
                $(this).removeClass("is-invalid is-valid");
                $("#emailError").remove();

                if (!email) {
                    $(this).addClass("is-invalid");
                    $(this).after("<span id='emailError' class='text-danger'>Email is required.</span>");
                    $("#submitCheckEmail").prop("disabled", true);
                } else if (!emailPattern.test(email)) {
                    $(this).addClass("is-invalid");
                    $(this).after(
                        "<span id='emailError' class='text-danger'>Please enter a valid email address.</span>"
                    );
                    $("#submitCheckEmail").prop("disabled", true);
                } else {
                    $(this).addClass("is-valid");
                    $("#submitCheckEmail").prop("disabled", false);
                }
            });
        });

        $("#submitCheckEmail").click(function(e) {
            e.preventDefault();
            $("#contactEmail").removeClass("is-invalid");
            $("#emailError").remove();

            if ($("#contactEmail").val() === currentContactEmail) {
                $('#emailModal').modal('hide');
                $('#passwordModal').modal('show');
            } else {
                $("#contactEmail").addClass("is-invalid");
                $("#contactEmail").after(
                    "<span id='emailError' class='text-danger'>This email address isn't valid with third party contact email.</span>"
                );
            }
        });

        $("#submitCheckPassword").click(function(e) {
            e.preventDefault();
            var enteredPassword = $("#accessPassword").val();

            $("#accessPassword").removeClass("is-invalid");
            $("#passwordError").remove();

            if (enteredPassword === accessPassword) {
                $('#passwordModal').modal('hide');
                $("#questionnaireForm").removeClass('d-none');
            } else {
                $("#accessPassword").addClass("is-invalid");
                $("#accessPassword").after(
                    "<span id='passwordError' class='text-danger'>Incorrect password.</span>"
                );
            }
        });

        function makeAlert($status, message, title) {
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $(".submit_questionnaire_btn").click(function(e) {
            e.preventDefault();
            var submissionType = $(this).data("submission_type");
            var formData = new FormData();

            formData.append("questionnaire_id", questionnaireId);
            formData.append("contact_id", currentContactId);
            formData.append("submission_type", submissionType);

            $(".question-card").each(function() {
                var radioInput = $(this).find("input[type='radio']").attr("name");
                var questionId = null;

                if (radioInput) {
                    questionId = radioInput.match(/\d+/)[0];
                }

                var answer = $(this).find("input[type='radio']:checked").val() || null;
                var comment = $(this).find("textarea").val() || "";

                formData.append("answers[" + questionId + "][question_id]", questionId);
                formData.append("answers[" + questionId + "][answer_id]", answer);
                formData.append("answers[" + questionId + "][comment]", comment);

                var fileInput = $(this).find("input[type='file']")[0];
                if (fileInput && fileInput.files.length > 0) {
                    formData.append("answers[" + questionId + "][file]", fileInput.files[0]);
                }
            });

            $.ajax({
                type: "POST",
                url: '{{ route('admin.third_party.saveAnswers', ':id') }}'.replace(":id", questionnaireId),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $.blockUI({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Answer Questions']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                        css: {
                            backgroundColor: "transparent",
                            color: "#fff",
                            border: "0",
                        },
                        overlayCSS: {
                            opacity: 0.5,
                        },
                    });
                },
                success: function(response) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000,
                    }).then(function() {
                        window.location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    $.unblockUI();
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            Swal.fire({
                                icon: "error",
                                title: "Please answer all questions",
                            });
                        }
                    } catch (e) {
                        console.error("Unexpected error format:", e, xhr.responseText);
                        Swal.fire({
                            icon: "error",
                            title: "Unexpected Error",
                            text: error,
                        });
                    }
                },
            });
        });
    </script>
</body>

</html>
