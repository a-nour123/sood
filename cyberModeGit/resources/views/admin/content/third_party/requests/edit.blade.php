<div class="card-body basic-wizard important-validation">
    <div class="stepper-horizontal" id="stepper1">
        <div class="stepper-one stepper step editing active">
            <div class="step-circle"><span>1</span></div>
            <div class="step-title">{{ __('third_party.RequestInfo') }}</div>
            <div class="step-bar-left"></div>
            <div class="step-bar-right"></div>
        </div>
        <div class="stepper-two step">
            <div class="step-circle"><span>2</span></div>
            <div class="step-title">{{ __('third_party.EvaluationCheckList') }}</div>
            <div class="step-bar-left"></div>
            <div class="step-bar-right"></div>
        </div>
    </div>
    <div id="msform">
        {{-- request info --}}
        <form class="stepper-one row g-3 needs-validation custom-input mb-3" id="form-step-one" novalidate>
            <div class="row mb-2">
                <div class="mb-3 col">
                    <label for="editRequested" class="form-label">{{ __('third_party.Requested by') }}</label>
                    <input type="text" class="form-control" readonly id="editRequested"
                        value="{{ $data['request']->uploader->name }}">
                    <input type="hidden" id="requested_by" value="{{ $data['request']->requested_by }}">
                </div>
                <div class="mb-3 col">
                    <label for="editDepartment" class="form-label">{{ __('third_party.Department') }}</label>
                    <input type="text" class="form-control" readonly id="editDepartment"
                        value="{{ $data['request']->department->name }}">
                    <input type="hidden" id="department_id" value="{{ $data['request']->department_id }}">
                </div>
                <div class="mb-3 col">
                    <label for="editJob" class="form-label">{{ __('third_party.Job title') }}</label>
                    <input type="text" class="form-control" readonly id="editJob"
                        value="{{ $data['request']->job->name }}">
                    <input type="hidden" id="job_id" value="{{ $data['request']->job_id }}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="editThirdPartyProfile" class="form-label">{{ __('third_party.ThirdPartyProfile') }}</label>
                    <select class="form-select select2" id="editThirdPartyProfile" name="third_party_profile_id"
                        onchange="validationInput(this)">
                        <option disabled selected value>{{ __('third_party.Select') }}</option>
                        @foreach ($data['thirdPartyProfiles'] as $profile)
                            <option value="{{ $profile->id }}"
                                {{ $profile->id == $data['request']->third_party_profile_id ? 'selected' : '' }}>
                                {{ $profile->third_party_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="editService" class="form-label">{{ __('third_party.Service') }}</label>
                    <select class="form-select select2" id="editService" name="service"
                        onchange="validationInput(this)">
                        <option disabled selected value>{{ __('third_party.Select') }}</option>
                        @foreach ($data['services'] as $service)
                            <option value="{{ $service->id }}"
                                {{ $service->id == $data['request']->third_party_service_id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="">
                <label for="editBusinessInfo" class="form-label">{{ __('third_party.business_info') }}</label>
                <textarea class="form-control" id="editBusinessInfo" name="business_info" rows="3"
                    oninput="validationInput(this)">{{ $data['request']->business_info }}</textarea>
            </div>
        </form>

        {{-- Evaluation Check List --}}
        <form class="stepper-two row g-3 needs-validation custom-input mb-3" id="form-step-two" novalidate>
            @foreach ($data['evaluations'] as $evaluation)
                <div class="row mb-3">
                    <div class="col-md-7">
                        <label for="question_{{ $evaluation->id }}" class="form-label">{{ __('third_party.Question') }}</label>
                        <textarea readonly id="question_{{ $evaluation->id }}" class="form-control" rows="2">{{ $evaluation->name }}</textarea>
                    </div>
                    <div class="col-md-1">
                        <label for="" class="form-label">{{ __('third_party.Answer') }}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer[{{ $evaluation->id }}]"
                                value="1" id="yes_{{ $evaluation->id }}"
                                @if ($evaluation->answer == 1) checked @endif>
                            <label class="form-check-label" for="yes_{{ $evaluation->id }}">
                                {{ __('third_party.Yes') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer[{{ $evaluation->id }}]"
                                value="0" id="no_{{ $evaluation->id }}"
                                @if ($evaluation->answer == 0) checked @endif>
                            <label class="form-check-label" for="no_{{ $evaluation->id }}">
                                {{ __('third_party.No') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="comment_{{ $evaluation->id }}" class="form-label">{{ __('third_party.Explanation') }}</label>
                        <textarea name="comment[{{ $evaluation->id }}]" id="comment_{{ $evaluation->id }}" class="form-control"
                            rows="2">{{ $evaluation->comment }}</textarea>
                    </div>
                </div>
            @endforeach
        </form>

    </div>
    <div class="wizard-footer d-flex gap-2 justify-content-end">
        <button class="btn alert-light-primary" id="backbtn" onclick="backStep()">
            {{ __('third_party.Back') }}</button>
        <button class="btn btn-primary" id="nextbtn" onclick="nextStep()">{{ __('third_party.Next') }}</button>
        <button class="btn btn-primary d-none" id="submitEditForm">{{ __('third_party.Save Changes') }}</button>
    </div>
</div>


<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

{{-- logic of wizard --}}
<script>
    var form = document.getElementById("msform");
    var fieldsets = form.querySelectorAll("form");
    var currentStep = 0;
    var numSteps = 5;

    for (var i = 1; i < fieldsets.length; i++) {
        fieldsets[i].style.display = "none";
    }

    function nextStep() {
        // Enable the back button
        document.getElementById("backbtn").disabled = false;


        // Increment the current step
        currentStep++;
        if (currentStep > numSteps) {
            console.log('catched problem');
            console.log('currentStep' + currentStep);
            currentStep = 1; // Loop back to the first step if exceeding the number of steps
        }

        // Get the stepper and steps
        var stepper = document.getElementById("stepper1");
        var steps = stepper.getElementsByClassName("step");

        // Loop through steps and update classes and visibility
        Array.from(steps).forEach((step, index) => {
            let stepNum = index + 1; // 1-based step number
            let stepLength = steps.length;

            if (fieldsets[currentStep]) {
                // If the current step is the active step and not the last step
                if (stepNum === currentStep && currentStep < stepLength) {
                    addClass(step, "editing"); // Mark as editing
                    fieldsets[currentStep].style.display = "flex"; // Show the current fieldset
                } else {
                    removeClass(step, "editing"); // Remove editing class
                }
            }

            // Mark steps as done if they are before or equal to the current step
            if (stepNum <= currentStep && currentStep < stepLength) {
                addClass(step, "done");
                addClass(step, "active");
                removeClass(step, "editing");
                fieldsets[currentStep - 1].style.display = "none"; // Hide the previous fieldset
            } else {
                removeClass(step, "done");
            }

            // Handle the last step's button text and functionality
            if (currentStep == stepLength - 1) {
                document.getElementById("nextbtn").textContent = "Finish";
                document.getElementById("nextbtn").classList.add("d-none"); // Hide Next button
                document.getElementById("submitEditForm").classList.remove(
                    "d-none"); // Show Submit button
            } else if (currentStep < stepLength - 1) {
                document.getElementById("nextbtn").textContent = "Next";
                document.getElementById("nextbtn").classList.remove("d-none"); // Show Next button
                document.getElementById("submitEditForm").classList.add("d-none"); // Hide Submit button
            }

            // Disable the "Next" button on the last step
            if (currentStep > stepLength - 1) {
                document.getElementById("nextbtn").textContent = "Finish";
                addClass(step, "done");
                addClass(step, "active");
                removeClass(step, "editing");
                document.getElementById("nextbtn").disabled = true;
            }
        });
    }



    function backStep() {
        currentStep--;
        var stepper = document.getElementById("stepper1");
        var steps = stepper.getElementsByClassName("step");
        let stepLength = steps.length;

        // Set default text for Next button
        document.getElementById("nextbtn").textContent = "Next";
        document.getElementById("nextbtn").disabled = false;

        // Check if we are not at the last step
        if (currentStep < stepLength - 1) {
            document.getElementById("backbtn").disabled = false; // Enable Back button
            fieldsets[currentStep + 1].style.display = "none"; // Hide next fieldset
            fieldsets[currentStep].style.display = "flex"; // Show current fieldset
            removeClass(steps[currentStep], "done");
            removeClass(steps[currentStep], "active");

            // Show Next button and hide Submit button
            document.getElementById("nextbtn").classList.remove("d-none"); // Show Next button
            document.getElementById("submitEditForm").classList.add("d-none"); // Hide Submit button

            if (currentStep == 0) {
                document.getElementById("backbtn").disabled = true; // Disable Back button on the first step
            }
        } else {
            removeClass(steps[currentStep], "done");
            removeClass(steps[currentStep], "active");
        }
    }

    function hasClass(elem, className) {
        return new RegExp(" " + className + " ").test(" " + elem.className + " ");
    }

    function addClass(elem, className) {
        if (!hasClass(elem, className)) {
            elem.className += " " + className;
        }
    }

    function removeClass(elem, className) {
        var newClass = " " + elem.className.replace(/[\t\r\n]/g, " ") + " ";
        if (hasClass(elem, className)) {
            while (newClass.indexOf(" " + className + " ") >= 0) {
                newClass = newClass.replace(" " + className + " ", " ");
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, "");
        }
    }

    function validationInput(element) {
        // Get the input element's ID and value
        var inputId = $(element).attr('id');
        var inputValue = $(element).val();
        var messageBoxId = inputId + 'Message'; // Generate the message box ID

        // Check if the span for error message already exists, if not, create it
        if ($('#' + messageBoxId).length === 0) {
            // Dynamically create the span and append it after the input element
            $('<span>', {
                id: messageBoxId, // Assign ID
                class: 'text-danger', // Add the class
            }).insertAfter($(element));
        }

        // Define regex for each field you want to validate
        var regex = {
            editBusinessInfo: /^.{1,255}$/, // Regex to check if the field is not empty and max 255 characters
            editThirdPartyProfile: /^(?!.*Select).*$/,
            editService: /^(?!.*Select).*$/,
        };

        // Validate the input using the appropriate regex
        if (!regex[inputId].test(inputValue)) {
            // If invalid, add 'is-invalid' class and display an error message
            $(element).addClass('is-invalid');
            $('#' + messageBoxId).text(inputId + ' is required and must be less than 256 characters.');
        } else {
            // If valid, remove 'is-invalid', add 'is-valid', and clear the error message
            $(element).removeClass('is-invalid').addClass('is-valid');
            $('#' + messageBoxId).text(''); // Clear the error message
        }

        // Check if all required fields are valid
        checkAllValidations();
    }

    function checkAllValidations() {
        // Assuming your inputs have IDs of 'businessInfo', 'Service', and 'thirdPartyProfile'
        var inputs = ['editBusinessInfo', 'editService', 'editThirdPartyProfile'];
        var allValid = true;

        // Check each input's validity
        inputs.forEach(function(inputId) {
            var inputValue = $('#' + inputId).val();
            // Define regex for each field you want to validate
            var regex = {
                editBusinessInfo: /^.{1,255}$/, // Regex to check if the field is not empty and max 255 characters
                editThirdPartyProfile: /^(?!.*Select).*$/,
                editService: /^(?!.*Select).*$/,
            };


            if (!regex[inputId].test(inputValue)) {
                allValid = false; // Set to false if any input is invalid
            }
        });

        // Enable or disable the next button based on validation
        var nextButton = $('#nextbtn'); // Replace with your actual button ID
        if (allValid) {
            nextButton.removeAttr('disabled'); // Enable the button
        } else {
            nextButton.attr('disabled', true); // Disable the button
        }
    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });




    // Update request
    $(document).on('click', '#submitEditForm', function(e) {
        e.preventDefault();
        var requestId = $(this).attr('data-id');

        // Variable to keep track of form validity
        let isValid = true;

        // Loop through each evaluation question to check if an answer is selected
        $(".stepper-two .row").each(function() {
            var evaluationId = $(this).find('textarea[id^="question_"]').attr('id').split("_")[1];
            var selectedAnswer = $(this).find('input[name="answer[' + evaluationId + ']"]:checked')
                .val();

            // If no answer is selected, show an error message and mark form as invalid
            if (!selectedAnswer) {
                isValid = false;
                // Add error message (if not already present)
                $(this).find('.error-answer').remove(); // Remove previous error messages
                $(this).find('.form-check').last().after(
                    '<span class="error-answer text-danger">Select an answer</span>');
            } else {
                // If a selection is made, remove any error messages
                $(this).find('.error-answer').remove();
            }
        });

        // If the form is valid, proceed with the AJAX request
        if (isValid) {
            // Initialize an empty array to hold evaluation data
            var evaluationArray = [];

            // Loop through each evaluation row and collect the data
            $(".stepper-two .row").each(function() {
                var evaluationId = $(this).find('textarea[id^="question_"]').attr("id").split("_")[1];
                var answer = $(this).find('input[name="answer[' + evaluationId + ']"]:checked').val();
                var comment = $(this).find('textarea[name="comment[' + evaluationId + ']"]').val();

                if (evaluationId && answer) {
                    evaluationArray.push({
                        evaluation_id: evaluationId,
                        answer: answer,
                        comment: comment ? comment : ""
                    });
                }
            });

            $.ajax({
                url: '{{ route('admin.third_party.updateRequest', ':id') }}'.replace(
                    ':id',
                    requestId),
                type: 'PUT',
                data: {
                    business_info: $("#editBusinessInfo").val(),
                    third_party_profile_id: $("#editThirdPartyProfile").val(),
                    third_party_service_id: $("#editService").val(),
                    evaluation: evaluationArray,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var table = $("#requestsTable").DataTable();
                    $('#editRequestModal').modal('hide');

                    table.ajax.reload(); // Refresh DataTable after delete
                    makeAlert('success', response.message, 'Success');
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        } else {
            makeAlert('error', 'Please answer all questions', 'Error');
        }


    });
</script>
