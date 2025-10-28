<div class="accordion mb-3">

    <!-- questionnaire information section -->
    <div class="accordion-item mb-3">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#questionnaireSection"
                aria-expanded="true" aria-controls="questionnaireSection">
                {{ __('third_party.Assessment Informations') }}
            </button>
        </h2>
        <div id="questionnaireSection" class="accordion-collapse collapse show">
            <div class="accordion-body">

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __('third_party.Name') }}:</b> {{ $data['questionnaire']->name }}</p>
                    </div>
                    <div class="col">
                        <p><b>{{ __('third_party.Instructions') }}:</b> {{ $data['questionnaire']->instructions }}</p>
                    </div>
                </div>
                <hr>

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __("third_party.Third party name") }}:</b> {{ $data['questionnaire']->request->profile->third_party_name }}
                        </p>
                    </div>
                    <div class="col">
                        <p><b>{{ __("third_party.Assessment name") }}:</b> {{ $data['questionnaire']->assessment->name }}</p>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>


    <!-- contacts section -->
    <div class="accordion-item mb-3">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#contactsSection"
                aria-expanded="true" aria-controls="contactsSection">
                {{ __("third_party.Contacts") }}
            </button>
        </h2>
        <div id="contactsSection" class="accordion-collapse collapse">
            <div class="accordion-body">
                @foreach ($data['contacts'] as $contact)
                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <p><b>{{ __("third_party.Name") }}:</b> {{ $contact->name }}</p>
                        </div>
                        <div class="col">
                            <p><b>{{ __("third_party.E-mail") }}:</b> {{ $contact->email }}</p>
                        </div>
                        <div class="col">
                            <p><b>{{ __("third_party.Phone") }}:</b> {{ $contact->phone }}</p>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>



    <!-- questions section -->
    <div class="accordion-item mb-3">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#questionsSection"
                aria-expanded="true" aria-controls="questionsSection">
                {{ __("third_party.Questions") }}
            </button>
        </h2>
        <div id="questionsSection" class="accordion-collapse collapse">
            <div class="accordion-body">
                @php $x = 0 @endphp
                @foreach ($data['questions'] as $question)
                    @php $x++ @endphp
                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <p><b>{{ __("third_party.Question") }} {{ $x }}:</b> {{ $question }}</p>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>

</div>
