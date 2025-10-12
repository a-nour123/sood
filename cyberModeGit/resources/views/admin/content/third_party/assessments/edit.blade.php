<div class="container">
    <form action="">
        <div class="mb-3">
            <label for="Name" class="form-label">{{ __('third_party.assessmentName') }}</label>
            <input type="text" name="name" id="Name" class="form-control" placeholder="" required
                value="{{ $data['questionnaire']->name }}" />
        </div>

        <div class="mb-3">
            <label for="Instructions" class="form-label">{{ __('assessment.Instructions') }}</label>
            <textarea class="form-control" id="Instructions" name="instructions">{{ $data['questionnaire']->instructions }}</textarea>
        </div>

        <div class="mb-3">
            <label for="Assessment">{{ __('locale.Assessments') }}</label>
            <select class="form-control select2" name="assessment_id" id="Assessment">
                <option value selected disabled>{{ __('locale.Assessment') }}
                </option>
                @foreach ($data['assessments'] as $assessment)
                    <option data-questions="{{ $assessment->questions }}" value="{{ $assessment->id }}"
                        {{ $assessment->id === $data['questionnaire']->assessment_id ? 'selected' : '' }}>
                        {{ $assessment->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="Contacts">{{ __('third_party.Contacts') }}</label>
            <select class="form-control select2" name="contact_id[{{ $data['questionnaire']->id }}]" id="Contacts">
                <option disabled selected value>{{ __('third_party.Contacts') }}</option>
                @foreach ($data['contacts'] as $contact_id => $email)
                    <option value="{{ $contact_id }}"
                        {{ $contact_id === $data['questionnaireContacts'] ? 'selected' : '' }}>{{ $email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="all_questions_mandatory">{{ __('assessment.all_questions_mandatory') }}</label>
            <input type="checkbox" id="AllQuestionsMandatory" name="all_questions_mandatory"
                {{ $data['questionnaire']->all_questions_mandatory == 1 ? 'checked' : '' }}>
        </div>

        <button class="btn btn-primary" id="submitUpdateAssessment">{{ __('third_party.Save Changes') }}</button>
    </form>
</div>

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#submitUpdateAssessment").click(function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);

        var questionnaireId = `{{ $data['questionnaire']->id }}`;

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
            type: "PUT",
            url: '{{ route('admin.third_party.updateQuestionnaire', ':id') }}'.replace(
                ':id',
                questionnaireId),
            data: data,
            beforeSend: function() {
                // Show loading overlay
                $.blockUI({
                    message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Updateing assessment']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                $('#editThirdPartyAssessmentModal').modal('hide');
                var table = $("#thirdPartyAssessmentsTable").DataTable();
                table.ajax.reload();
                makeAlert('success', response.message, 'Success');
                $.unblockUI();
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
                $.unblockUI();
                $(this).prop('disabled', false);
            }
        });

        // makeAlert('error', 'request_id => ' + requestId, 'Error');
    });
</script>
