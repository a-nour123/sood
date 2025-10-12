<div class="container">
    <form action="">
        <div class="mb-3">
            <label for="Name" class="form-label">{{ __('third_party.assessmentName') }}</label>
            <input type="text" name="name" id="Name" class="form-control" placeholder="" required />
        </div>

        <div class="mb-3">
            <label for="Instructions" class="form-label">{{ __('assessment.Instructions') }}</label>
            <textarea class="form-control" id="Instructions" name="instructions"></textarea>
        </div>

        <div class="mb-3">
            <label for="Assessment">{{ __('locale.Assessments') }}</label>
            <select class="form-control select2" name="assessment_id" id="Assessment">
                <option value selected disabled>{{ __('locale.Assessment') }}
                </option>
                @foreach ($data['assessments'] as $assessment)
                    <option data-questions="{{ $assessment->questions }}" value="{{ $assessment->id }}">
                        {{ $assessment->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="Contacts">{{ __('third_party.Contacts') }}</label>
            <select class="form-control select2" name="contact_id[{{ $data['request']->id }}]" id="Contacts">
                <option disabled selected value>{{ __('third_party.Contacts') }}</option>
                @foreach ($data['contacts'] as $contact_id => $email)
                    <option value="{{ $contact_id }}">{{ $email }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="all_questions_mandatory">{{ __('assessment.all_questions_mandatory') }}</label>
            <input type="checkbox" id="AllQuestionsMandatory" name="all_questions_mandatory">
        </div>

        <button class="btn btn-primary" id="submitCreateAssessment">{{ __('third_party.Submit') }}</button>
    </form>
</div>

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#submitCreateAssessment").click(function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);

        var requestId = `{{ $data['request']->id }}`;

        // Check if the checkbox is checked and set the value accordingly
        var AllQuestionsMandatory = $("#AllQuestionsMandatory").is(':checked') ? '1' : '0';

        // Retrieve the data-questions attribute from the selected option in the #Assessment dropdown
        var questions = $("#Assessment option:selected").data("questions");

        var data = {
            name: $("#Name").val(),
            instructions: $("#Instructions").val(),
            assessment_id: $("#Assessment").val(),
            all_questions_mandatory: AllQuestionsMandatory, // Use the checkbox value
            contacts: $("#Contacts").val(),
            questions: questions // Use the selected option's data-questions attribute
        };

        console.log(data);

        $.ajax({
            type: "POST",
            url: '{{ route('admin.third_party.createQuestionnaire', ':id') }}'.replace(
                ':id',
                requestId),
            data: data,
            beforeSend: function() {
                // Show loading overlay
                $.blockUI({
                    message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Creating assessment']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                $('#createThirdPartyAssessmentModal').modal('hide');
                var table = $("#requestsTable").DataTable();
                table.ajax.reload();
                makeAlert('success', response.message, 'Success');
                $.unblockUI();

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Log the full response to check its structure

                try {
                    // Try parsing the JSON response
                    var response = JSON.parse(xhr.responseText);

                    // Check if the response contains error messages
                    if (response.errors) {
                        let allMessages = ''; // Initialize a variable to store all error messages

                        $.each(response.errors, function(field, messages) {
                            messages.forEach(function(message) {
                                // Concatenate each message with a newline or a separator
                                allMessages += message + "<br>" + "<hr>";

                            });
                        });

                        // Show one alert with all the collected messages
                        makeAlert('error', allMessages, 'Error');
                    } else {
                        // If no specific errors are found, display the main error message
                        makeAlert('error', response.message || "An unexpected error occurred",
                            'Error');
                    }
                } catch (e) {
                    // If parsing fails, show a generic error message
                    console.error("An unexpected error occurred: ", error);
                    makeAlert('error', "An unexpected error occurred: " + error, 'Error');
                }

                // Re-enable the submit button on error
                $("#submitCreateAssessment").removeAttr("disabled");

                // Hide the blockUI overlay after error
                $.unblockUI();
                $(this).prop('disabled', false);
            }
        });

        // makeAlert('error', 'request_id => ' + requestId, 'Error');
    });
</script>
