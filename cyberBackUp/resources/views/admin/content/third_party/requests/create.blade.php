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
                <div class="mb-2 col">
                    <label for="Requested" class="form-label">{{ __('third_party.Requested by') }}</label>
                    @if (auth()->user()->admin == 1)
                        <select class="form-select select2" id="requested_by" name="requested_by"
                            onchange="validationInput(this)">
                            <option disabled selected value="">{{ __('third_party.Select') }}</option>
                            @foreach ($data['department_managers'] as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-control" readonly id="Requested"
                            value="{{ auth()->user()->name }}">
                        <input type="hidden" name="requested_by" id="requested_by" value="{{ auth()->user()->id }}">
                    @endif
                </div>

                <div class="mb-2 col">
                    <label for="Department" class="form-label">{{ __('third_party.Department') }}</label>
                    @if (auth()->user()->admin == 1)
                        <select class="form-select" id="department_id" disabled name="department_id">
                            <option disabled selected value="">{{ __('third_party.Department') }}</option>
                            <!-- options of departments -->
                        </select>
                    @else
                        <input type="text" class="form-control" readonly id="Department"
                            value="{{ auth()->user()->department->name }}">
                        <input type="hidden" name="department_id" id="department_id"
                            value="{{ auth()->user()->department_id }}">
                    @endif
                </div>
                <div class="mb-2 col">
                    <label for="Job" class="form-label">{{ __('third_party.Job Title') }}</label>
                    @if (auth()->user()->admin == 1)
                        <select class="form-select" id="job_id" disabled name="job_id">
                            <option disabled selected value="">{{ __('third_party.Job Title') }}</option>
                            <!-- options of departments -->
                        </select>
                    @else
                        <input type="text" class="form-control" readonly id="Job"
                            value="{{ auth()->user()->job->name }}">
                        <input type="hidden" name="job_id" id="job_id" value="{{ auth()->user()->job_id }}">
                    @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="thirdPartyProfile" class="form-label">{{ __('third_party.ThirdPartyProfile') }}</label>
                    <select class="form-select select2" id="thirdPartyProfile" name="third_party_profile_id"
                        onchange="validationInput(this)">
                        <option disabled selected value="">{{ __('third_party.Select') }}</option>
                        @foreach ($data['thirdPartyProfiles'] as $profile)
                            <option value="{{ $profile->id }}">{{ $profile->third_party_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="Service" class="form-label">{{ __('third_party.Service') }}</label>
                    <select class="form-select select2" id="Service" name="service" onchange="validationInput(this)">
                        <option disabled selected value="">{{ __('third_party.Select') }}</option>
                        @foreach ($data['services'] as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="">
                <label for="businessInfo" class="form-label">{{ __('third_party.business_info') }}</label>
                <textarea class="form-control" id="businessInfo" name="business_info" rows="3" oninput="validationInput(this)"></textarea>
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
                                value="1" id="yes_{{ $evaluation->id }}">
                            <label class="form-check-label" for="yes_{{ $evaluation->id }}">
                                {{ __('third_party.Yes') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer[{{ $evaluation->id }}]"
                                value="0" id="no_{{ $evaluation->id }}">
                            <label class="form-check-label" for="no_{{ $evaluation->id }}">
                                {{ __('third_party.No') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="comment_{{ $evaluation->id }}" class="form-label">{{ __('third_party.Explanation') }}</label>
                        <textarea name="comment[{{ $evaluation->id }}]" id="comment_{{ $evaluation->id }}" class="form-control"
                            rows="2"></textarea>
                    </div>
                </div>
            @endforeach
        </form>

    </div>
    <div class="wizard-footer d-flex gap-2 justify-content-end">
        <button class="btn alert-light-primary" id="backbtn" onclick="backStep()">
            {{ __('third_party.Back') }}</button>
        <button class="btn btn-primary" disabled id="nextbtn" onclick="nextStep()">{{ __('third_party.Next') }}</button>
        <button class="btn btn-primary d-none" id="submitCreateRequestBtn">{{ __('third_party.Submit') }}</button>
    </div>
</div>


<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

{{-- logic of wizard --}}
<script>
    $(document).ready(function () {
        $("#backbtn").attr('disabled', true); // Disable the button
    });
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
                document.getElementById("submitCreateRequestBtn").classList.remove(
                    "d-none"); // Show Submit button
            } else if (currentStep < stepLength - 1) {
                document.getElementById("nextbtn").textContent = "Next";
                document.getElementById("nextbtn").classList.remove("d-none"); // Show Next button
                document.getElementById("submitCreateRequestBtn").classList.add("d-none"); // Hide Submit button
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
            document.getElementById("submitCreateRequestBtn").classList.add("d-none"); // Hide Submit button

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
            businessInfo: /^.{1,255}$/, // Regex to check if the field is not empty and max 255 characters
            Service: /^(?!.*Select).*$/,
            thirdPartyProfile: /^(?!.*Select).*$/,
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
        var inputs = ['businessInfo', 'Service', 'thirdPartyProfile'];
        var allValid = true;

        // Check each input's validity
        inputs.forEach(function(inputId) {
            var inputValue = $('#' + inputId).val();
            var regex = {
                businessInfo: /^.{1,255}$/,
                Service: /^(?!.*Select).*$/,
                thirdPartyProfile: /^(?!.*Select).*$/,
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

    $('#requested_by').on('change', function() {
        var userId = $(this).val();

        $.ajax({
            type: "GET",
            url: '{{ route('admin.third_party.getUserDetailsFromId', ':user_id') }}'.replace(
                ':user_id',
                userId),
            success: function(response) {
                console.log(response.department.name);

                var departmentSelect = $('#department_id');
                var jobSelect = $('#job_id');

                departmentSelect.empty();
                jobSelect.empty();

                departmentSelect.append(
                    '<option disabled selected value="">Select department</option>');

                departmentSelect.append(
                    $('<option>', {
                        value: response.department.id,
                        text: response.department.name,
                        selected: true // Set the option as selected
                    })
                );

                jobSelect.append(
                    '<option disabled selected value="">Select job</option>');

                jobSelect.append(
                    $('<option>', {
                        value: response.job.id,
                        text: response.job.name,
                        selected: true // Set the option as selected
                    })
                );

            }
        });

    });


    $("#submitCreateRequestBtn").click(function(e) {
        e.preventDefault();

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

            // Submit the form via AJAX
            $.ajax({
                type: "POST",
                url: `{{ route('admin.third_party.createRequest') }}`,
                data: {
                    requested_by: $("#requested_by").val(),
                    department_id: $("#department_id").val(),
                    job_id: $("#job_id").val(),
                    business_info: $("#businessInfo").val(),
                    third_party_profile_id: $("#thirdPartyProfile").val(),
                    third_party_service_id: $("#Service").val(),
                    evaluation: evaluationArray,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    makeAlert('success', response.message, 'Success');
                    $('#createRequestModal').modal('hide');
                    $("#businessInfo").val('');
                    var table = $("#requestsTable").DataTable();
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.errors) {
                        $.each(response.errors, function(field, messages) {
                            messages.forEach(function(message) {
                                makeAlert('error', message, 'Error');
                            });
                        });
                    } else {
                        console.error("An unexpected error occurred: ", error);
                    }
                }
            });
        } else {
            makeAlert('error', 'Please answer all questions', 'Error');
        }
    });
</script>
