<div class="accordion mb-3">

    <!-- general information section -->
    <div class="accordion-item mb-2">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#generalInfoSection"
                aria-expanded="true" aria-controls="generalInfoSection">
                {{ __('third_party.General Informations') }}
            </button>
        </h2>
        <div id="generalInfoSection" class="accordion-collapse collapse show">
            <div class="accordion-body">

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __('third_party.Third party name') }}:</b> {{ $data['profile']->third_party_name }}</p>
                    </div>

                    <div class="col">
                        <p><b>{{ __('third_party.Owner/CEO') }}:</b> {{ $data['profile']->owner }}</p>
                    </div>
                    <div class="col">
                        <p><b>{{ __("third_party.Domain") }}:</b> {{ $data['profile']->domain }}</p>
                    </div>
                </div>
                <hr>

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __("third_party.Agreement") }}:</b> {{ $data['profile']->agreement }}</p>
                    </div>
                    <div class="col">
                        <p><b>{{ __("third_party.Contract term") }}:</b> {{ $data['profile']->contract_term }}</p>
                    </div>
                </div>
                <hr>

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __("third_party.Classification") }}:</b>
                            {{ $data['profile']->classification->name }}
                        </p>
                    </div>
                    <div class="col">
                        <p><b>{{ __("third_party.Head office location") }}:</b> {{ $data['profile']->head_office_location }}</p>
                    </div>
                </div>
                <hr>

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __('third_party.Place of incorporation') }}:</b>
                            {{ $data['profile']->place_of_incorporation }}</p>
                    </div>
                    <div class="col">
                        <p><b>{{ __('third_party.Date of incorporation') }}:</b>
                            {{ $data['profile']->date_of_incorporation }}</p>
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
                    @foreach ($data['contacts'] as $contact)
                        <div class="row mb-3 contact-fields">
                            <div class="col">
                                <p><b>{{ __('third_party.Name') }}:</b> {{ $contact->name }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Phone') }}:</b> {{ $contact->phone }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.E-mail') }}:</b> {{ $contact->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>

                <!-- Business Contact Section -->
                <div id="businessContactSection">
                    <label class="form-label">{{ __('third_party.Business Contact') }}</label>
                    @foreach ($data['business contacts'] as $business_contact)
                        <div class="row mb-3 business-contact-fields">
                            <div class="col">
                                <p><b>{{ __('third_party.Name') }}:</b> {{ $business_contact->name }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Phone') }}:</b> {{ $business_contact->phone }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.E-mail') }}:</b> {{ $business_contact->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>

                <!-- Technical Contact Section -->
                <div id="technicalContactSection">
                    <label class="form-label">{{ __('third_party.Technical Contact') }}</label>
                    @foreach ($data['technical contacts'] as $technical_contact)
                        <div class="row mb-3 technical-contact-fields">
                            <div class="col">
                                <p><b>{{ __('third_party.Name') }}:</b> {{ $technical_contact->name }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Phone') }}:</b> {{ $technical_contact->phone }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.E-mail') }}:</b> {{ $technical_contact->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>

                <!-- Cyber Security Contact Section -->
                <div id="cyberContactSection">
                    <label class="form-label">{{ __('third_party.Cyber Security Contact') }}</label>
                    @foreach ($data['cyber contacts'] as $cyber_contact)
                        <div class="row mb-3 cyber-contact-fields">
                            <div class="col">
                                <p><b>{{ __('third_party.Name') }}:</b> {{ $cyber_contact->name }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Phone') }}:</b> {{ $cyber_contact->phone }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.E-mail') }}:</b> {{ $cyber_contact->email }}</p>
                            </div>
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
                    @foreach ($data['entities'] as $entity)
                        <div class="row mb-3 contact-fields">
                            <div class="col">
                                <p><b>{{ __('third_party.Entity') }}:</b> {{ $entity->entity }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Date') }}:</b> {{ $entity->date }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Involvement') }}:</b> {{ $entity->involvement }}</p>
                            </div>
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
                    @foreach ($data['subsidiaries'] as $subsidiary)
                        <div class="row mb-3 contact-fields">
                            <div class="col">
                                <p><b>{{ __('third_party.Affiliation') }}:</b> {{ $subsidiary->affiliation }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Date') }}:</b> {{ $subsidiary->date }}</p>
                            </div>
                            <div class="col">
                                <p><b>{{ __('third_party.Involvement') }}:</b> {{ $subsidiary->involvement }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>

            </div>
        </div>
    </div>

</div>
