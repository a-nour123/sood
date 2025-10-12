<form action="" id="editProfileForm">
    <div class="accordion mb-3" id="accordionForm">
        <!-- general information section -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#generalInfoSection" aria-expanded="true" aria-controls="generalInfoSection">
                    {{ __('third_party.General Informations') }}
                </button>
            </h2>
            <div id="generalInfoSection" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <label for="ThirdPartyName"
                                class="form-label">{{ __('third_party.Third party name') }}</label>
                            <input type="text" class="form-control" id="ThirdPartyName" name="third_party_name"
                                value="{{ $data['profile']->third_party_name }}">
                        </div>

                        <div class="col">
                            <label for="Owner" class="form-label">{{ __('third_party.Owner/CEO') }}</label>
                            <input type="text" class="form-control" id="Owner" name="owner"
                                value="{{ $data['profile']->owner }}">
                        </div>

                        <div class="col">
                            <label for="Domain" class="form-label">{{ __('third_party.Domain') }}</label>
                            <input type="text" class="form-control" id="Domain" name="domain"
                                value="{{ $data['profile']->domain }}">
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <label for="Agreement" class="form-label">{{ __('third_party.Agreement') }}</label>
                            <input type="text" class="form-control" id="Agreement" name="agreement"
                                value="{{ $data['profile']->agreement }}">
                        </div>
                        <div class="col">
                            <label for="ContractTerm" class="form-label">{{ __('third_party.Contract term') }}</label>
                            <input type="text" class="form-control" id="ContractTerm" name="contract_term"
                                value="{{ $data['profile']->contract_term }}">
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <label for="Classification"
                                class="form-label">{{ __('third_party.Classification') }}</label>
                            <select class="form-select select2" id="Classification" name="classification">
                                <option disabled
                                    {{ !$data['profile']->third_party_classification_id ? 'selected' : '' }} value>
                                    {{ __('third_party.Select') }}
                                </option>
                                @foreach ($data['classifications'] as $classification)
                                    <option
                                        {{ $data['profile']->third_party_classification_id == $classification->id ? 'selected' : '' }}
                                        value="{{ $classification->id }}">
                                        {{ $classification->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="DateOfIncorporation"
                                class="form-label">{{ __('third_party.Date of incorporation') }}</label>
                            <input type="date" class="form-control" id="DateOfIncorporation"
                                value="{{ $data['profile']->date_of_incorporation }}" name="date_of_incorporation">
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <label for="PlaceOfIncorporation"
                                class="form-label">{{ __('third_party.Place of incorporation') }}</label>
                            <textarea class="form-control" id="PlaceOfIncorporation" name="place_of_incorporation" rows="3">{{ $data['profile']->place_of_incorporation }}</textarea>
                        </div>
                        <div class="col">
                            <label for="HeadOfficeLocation"
                                class="form-label">{{ __('third_party.Head office location') }}</label>
                            <textarea class="form-control" id="HeadOfficeLocation" name="head_office_location" rows="3">{{ $data['profile']->head_office_location }}</textarea>
                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>


        <!-- contact list section -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#contactListSection" aria-expanded="true" aria-controls="contactListSection">
                    {{ __('third_party.Contact List') }}
                </button>
            </h2>
            <div id="contactListSection" class="accordion-collapse collapse">
                <div class="accordion-body">

                    <!-- Contact Section -->
                    <div id="contactSection">
                        <label class="form-label">{{ __('third_party.Contact') }}</label>
                        @foreach ($data['contacts'] as $contact_index => $contact)
                            <div class="row mb-3 contact-fields">
                                <div class="col">
                                    <input type="text" class="form-control" name="contact_name[]"
                                        placeholder="{{ __('third_party.Name') }}" value="{{ $contact->name }}">
                                </div>
                                <div class="col">
                                    <input type="tel" class="form-control" name="contact_phone[]"
                                        value="{{ $contact->phone }}">
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" name="contact_email[]"
                                        value="{{ $contact->email }}" placeholder="{{ __('third_party.E-mail') }}">
                                </div>
                                @if ($contact_index == 0)
                                    <!-- Check if this is the first record -->
                                    <div class="col-auto">
                                        <i class="fas fa-plus add-row" data-section="contactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <i class="fas fa-minus remove-row" data-section="contactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <!-- Business Contact Section -->
                    <div id="businessContactSection">
                        <label class="form-label">{{ __('third_party.Business Contact') }}</label>
                        @foreach ($data['business contacts'] as $business_contact_index => $business_contact)
                            <div class="row mb-3 business-contact-fields">
                                <div class="col">
                                    <input type="text" class="form-control" name="business_contact_name[]"
                                        value="{{ $business_contact->name }}"
                                        placeholder="{{ __('third_party.Name') }}">
                                </div>
                                <div class="col">
                                    <input type="tel" class="form-control" name="business_contact_phone[]"
                                        value="{{ $business_contact->phone }}">
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" name="business_contact_email[]"
                                        value="{{ $business_contact->email }}"
                                        placeholder="{{ __('third_party.E-mail') }}">
                                </div>
                                @if ($business_contact_index == 0)
                                    <!-- Check if this is the first record -->
                                    <div class="col-auto">
                                        <i class="fas fa-plus add-row" data-section="businessContactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <i class="fas fa-minus remove-row" data-section="businessContactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <!-- Technical Contact Section -->
                    <div id="technicalContactSection">
                        <label class="form-label">{{ __('third_party.Technical Contact') }}</label>
                        @foreach ($data['technical contacts'] as $technical_contact_index => $technical_contact)
                            <div class="row mb-3 technical-contact-fields">
                                <div class="col">
                                    <input type="text" class="form-control" name="technical_contact_name[]"
                                        value="{{ $technical_contact->name }}"
                                        placeholder="{{ __('third_party.Name') }}">
                                </div>
                                <div class="col">
                                    <input type="tel" class="form-control" name="technical_contact_phone[]"
                                        value="{{ $technical_contact->phone }}">
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" name="technical_contact_email[]"
                                        value="{{ $technical_contact->email }}"
                                        placeholder="{{ __('third_party.E-mail') }}">
                                </div>
                                @if ($technical_contact_index == 0)
                                    <!-- Check if this is the first record -->
                                    <div class="col-auto">
                                        <i class="fas fa-plus add-row" data-section="technicalContactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <i class="fas fa-minus remove-row" data-section="technicalContactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <!-- Cyber Security Contact Section -->
                    <div id="cyberContactSection">
                        <label class="form-label">{{ __('third_party.Cyber Security Contact') }}</label>
                        @foreach ($data['cyber contacts'] as $cyber_contact_index => $cyber_contact)
                            <div class="row mb-3 cyber-contact-fields">
                                <div class="col">
                                    <input type="text" class="form-control" name="cyber_contact_name[]"
                                        value="{{ $cyber_contact->name }}"
                                        placeholder="{{ __('third_party.Name') }}">
                                </div>
                                <div class="col">
                                    <input type="tel" class="form-control" name="cyber_contact_phone[]"
                                        value="{{ $cyber_contact->phone }}">
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" name="cyber_contact_email[]"
                                        value="{{ $cyber_contact->email }}"
                                        placeholder="{{ __('third_party.E-mail') }}">
                                </div>
                                @if ($cyber_contact_index == 0)
                                    <!-- Check if this is the first record -->
                                    <div class="col-auto">
                                        <i class="fas fa-plus add-row" data-section="cyberContactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <i class="fas fa-minus remove-row" data-section="cyberContactSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>

                </div>
            </div>
        </div>


        <!-- interested entities section -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#interestedEntitiesSection" aria-expanded="true"
                    aria-controls="interestedEntitiesSection">
                    {{ __('third_party.Interested Entities') }}
                </button>
            </h2>
            <div id="interestedEntitiesSection" class="accordion-collapse collapse">
                <div class="accordion-body">

                    <!-- Entities Section -->
                    <div id="entitiesSection">
                        @foreach ($data['entities'] as $entity_index => $entity)
                            <div class="row mb-3 contact-fields">
                                <div class="col">
                                    <input type="text" class="form-control" name="entities_entity[]"
                                        value="{{ $entity->entity }}" placeholder="{{ __('third_party.Entity') }}">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" name="entities_date[]"
                                        value="{{ $entity->date }}" placeholder="{{ __('third_party.Date') }}">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="entities_involvement[]"
                                        value="{{ $entity->involvement }}"
                                        placeholder="{{ __('third_party.Involvement') }}">
                                </div>
                                @if ($entity_index == 0)
                                    <!-- Check if this is the first record -->
                                    <div class="col-auto">
                                        <i class="fas fa-plus add-row" data-section="entitiesSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <i class="fas fa-minus remove-row" data-section="entitiesSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>

                </div>
            </div>
        </div>


        <!-- subsidiaries section -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#subsidiariesAccordionSection" aria-expanded="true"
                    aria-controls="subsidiariesAccordionSection">
                    {{ __('third_party.Subsidiaries') }}
                </button>
            </h2>
            <div id="subsidiariesAccordionSection" class="accordion-collapse collapse">
                <div class="accordion-body">

                    <!-- Subsidiaries Section -->
                    <div id="subsidiariesSection">
                        @foreach ($data['subsidiaries'] as $subsidiary_index => $subsidiary)
                            <div class="row mb-3 contact-fields">
                                <div class="col">
                                    <input type="text" class="form-control" name="subsidiaries_affiliation[]"
                                        value="{{ $subsidiary->affiliation }}"
                                        placeholder="{{ __('third_party.Affiliation') }}">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" name="subsidiaries_date[]"
                                        value="{{ $subsidiary->date }}" placeholder="{{ __('third_party.Date') }}">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="subsidiaries_involvement[]"
                                        value="{{ $subsidiary->involvement }}"
                                        placeholder="{{ __('third_party.Involvement') }}">
                                </div>
                                @if ($subsidiary_index == 0)
                                    <!-- Check if this is the first record -->
                                    <div class="col-auto">
                                        <i class="fas fa-plus add-row" data-section="subsidiariesSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <i class="fas fa-minus remove-row" data-section="subsidiariesSection"
                                            style="cursor:pointer;"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>
                    <hr>

                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <button class="btn btn-primary" type="submit"
            id="submitEditForm">{{ __('third_party.Save Changes') }}</button>
    </div>
</form>

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // handla phone view
    $(document).ready(function() {
        var inputs = document.querySelectorAll('input[type="tel"]'); // Select all inputs of type "tel"
        inputs.forEach(function(input) {
            window.intlTelInput(input, {
                separateDialCode: true,
                utilsScript: "{{ asset('intl-tel-input/build/js/utils.js') }}",
                preferredCountries: ['sa', 'eg'],
                hiddenInput: "full_number",
            });
        });
    });

    // setup of add & delete for repeater
    $(document).ready(function() {
        // Add new row on clicking the + icon
        $(document).on('click', '.add-row', function() {
            var sectionId = $(this).data('section');
            var section = $('#' + sectionId + ' .row:first').clone(); // Clone the first row

            // Clear input values in the cloned row
            section.find('input').val('');

            // Change the + icon to - icon and add a class for deleting rows
            section.find('.add-row').removeClass('fa-plus add-row').addClass('fa-minus remove-row');

            // Append the cloned row
            $('#' + sectionId).append(section);
        });

        // Remove row on clicking the - icon
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.row').remove();
        });
    });

    $("#submitEditForm").click(function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);

        var profileId = $(this).attr('data-id');

        var formData = $("#editProfileForm").serializeArray(); // Gather form data
        var dataFromTheForm = {}; // Convert the array into an object

        var General_Info = {};
        var Contact = {};
        var Business_Contact = {};
        var Technical_Contact = {};
        var Cyber_Contact = {};
        var Entities = {};
        var Subsidiaries = {};

        formData.forEach(function(item) {
            // Check if the name contains '[]'
            if (item.name.endsWith('[]')) {
                // Get the base name by removing '[]'
                var baseName = item.name.slice(0, -2); // Remove the last two characters

                // If the property does not exist yet, initialize it as an empty array
                if (!dataFromTheForm[baseName]) {
                    dataFromTheForm[baseName] = [];
                }
                // Push the value into the array
                dataFromTheForm[baseName].push(item.value);
            } else {
                // For other fields, simply set the value
                dataFromTheForm[item.name] = item.value;
            }
        });


        // Iterate over dataFromTheForm
        for (var key in dataFromTheForm) {
            if (dataFromTheForm.hasOwnProperty(key)) {
                // Check if the key starts with 'cyber_contact_'
                if (key.startsWith('cyber_contact_')) {
                    // Extract the new key by removing 'cyber_contact_' prefix
                    var newKey = key.slice('cyber_contact_'.length); // Get the part after 'cyber_contact_'

                    // Assign the values to the new key in the Cyber_Contact object
                    Cyber_Contact[newKey] = dataFromTheForm[key];
                } else if (key.startsWith('business_contact_')) {
                    // Extract the new key by removing 'business_contact_' prefix
                    var newKey = key.slice('business_contact_'
                        .length); // Get the part after 'business_contact_'

                    // Assign the values to the new key in the Business_Contact object
                    Business_Contact[newKey] = dataFromTheForm[key];
                } else if (key.startsWith('contact_')) {
                    // Extract the new key by removing 'contact_' prefix
                    var newKey = key.slice('contact_'.length); // Get the part after 'contact_'

                    // Assign the values to the new key in the Contact object
                    Contact[newKey] = dataFromTheForm[key];
                } else if (key.startsWith('technical_contact_')) {
                    // Extract the new key by removing 'technical_contact_' prefix
                    var newKey = key.slice('technical_contact_'
                        .length); // Get the part after 'technical_contact_'

                    // Assign the values to the new key in the Technical_Contact object
                    Technical_Contact[newKey] = dataFromTheForm[key];
                } else if (key.startsWith('entities_')) {
                    // Extract the new key by removing 'entities_' prefix
                    var newKey = key.slice('entities_'
                        .length); // Get the part after 'entities_'

                    // Assign the values to the new key in the Entities object
                    Entities[newKey] = dataFromTheForm[key];
                } else if (key.startsWith('subsidiaries_')) {
                    // Extract the new key by removing 'subsidiaries_' prefix
                    var newKey = key.slice('subsidiaries_'
                        .length); // Get the part after 'subsidiaries_'

                    // Assign the values to the new key in the Subsidiaries object
                    Subsidiaries[newKey] = dataFromTheForm[key];
                } else {
                    var newKey = key;

                    // Assign the values to the new key in the General_Info object
                    General_Info[newKey] = dataFromTheForm[key];
                }
            }
        }

        // Function to group contact-related arrays into objects
        function organizeContactData(data) {
            var finalData = [];
            var Names = data['name'] || [];
            var Phones = data['phone'] || [];
            var Emails = data['email'] || [];

            // Loop through the contact names and group them into objects
            for (var i = 0; i < Names.length; i++) {
                finalData.push({
                    name: Names[i],
                    phone: Phones[i] || '',
                    email: Emails[i] || ''
                });
            }

            return finalData;
        }

        // Function to group entitiess-related and subsidiaries-related arrays into objects
        function organizeEntityAndSubsidiaryData(data) {
            var finalData = [];

            if (data['entity']) {
                var entitiess = data['entity'] || [];
            } else if (data['affiliation']) {
                var affiliations = data['affiliation'] || [];
            }

            var dates = data['date'] || [];
            var involvements = data['involvement'] || [];

            if (entitiess) {
                // Loop through the entities entity and group them into objects
                for (var i = 0; i < entitiess.length; i++) {
                    finalData.push({
                        entity: entitiess[i],
                        date: dates[i] || '',
                        involvement: involvements[i] || ''
                    });
                }
            } else if (affiliations) {
                // Loop through the subsidiaries affiliation and group them into objects
                for (var i = 0; i < affiliations.length; i++) {
                    finalData.push({
                        affiliation: affiliations[i],
                        date: dates[i] || '',
                        involvement: involvements[i] || ''
                    });
                }
            }


            return finalData;
        }

        // AJAX request
        $.ajax({
            type: "PUT",
            url: '{{ route('admin.third_party.updateProfile', ':id') }}'
                .replace(':id', profileId),
            data: {
                general_info: General_Info,
                contact: organizeContactData(Contact),
                business_contact: organizeContactData(Business_Contact),
                cyber_contact: organizeContactData(Cyber_Contact),
                technical_contact: organizeContactData(Technical_Contact),
                entities: organizeEntityAndSubsidiaryData(Entities),
                subsidiaries: organizeEntityAndSubsidiaryData(Subsidiaries),
            }, // Send the gathered data
            beforeSend: function() {
                // Hide the modal (if necessary)
                // $("#editProfileModal").modal('hide');

                // Show loading overlay
                $.blockUI({
                    message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => 'Update Profile']) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                // Hide the modal
                $("#editProfileModal").modal('hide');

                // Reset the form and disable submit button after success
                $("#editProfileForm")[0].reset();
                $("#submitEditForm").attr("disabled", "disabled");

                // Show success alert
                makeAlert('success', response.message, 'Success');

                // Reload the DataTable
                var table = $("#profilesTable").DataTable();
                table.ajax.reload();

                // Hide the blockUI overlay after success
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
                $("#submitEditForm").removeAttr("disabled");

                // Hide the blockUI overlay after error
                $.unblockUI();
                $(this).prop('disabled', false);
            }

        });
    });
</script>
