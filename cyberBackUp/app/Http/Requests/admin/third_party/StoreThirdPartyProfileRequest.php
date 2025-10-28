<?php

namespace App\Http\Requests\admin\third_party;

use Illuminate\Foundation\Http\FormRequest;

class StoreThirdPartyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'general_info.third_party_name' => 'required',
            // 'general_info.owner' => 'required',
            // 'general_info.agreement' => 'required',
            // 'general_info.domain' => 'required|unique:third_party_profiles,domain',
            'general_info.contract_term' => 'required',
            'general_info.classification' => 'required|string',
            'general_info.date_of_incorporation' => 'required|date',
            'general_info.place_of_incorporation' => 'required',
            'general_info.head_office_location' => 'required',

            // Contact validation
            'contact.*.name' => 'required|string',
            'contact.*.phone' => 'required|string',
            'contact.*.email' => 'required|email',

            // Business Contact validation
            // 'business_contact.*.name' => 'required|string',
            // 'business_contact.*.phone' => 'required|string',
            // 'business_contact.*.email' => 'required|email',

            // Cyber Contact validation
            // 'cyber_contact.*.name' => 'required|string',
            // 'cyber_contact.*.phone' => 'required|string',
            // 'cyber_contact.*.email' => 'required|email',

            // Technical Contact validation
            // 'technical_contact.*.name' => 'required|string',
            // 'technical_contact.*.phone' => 'required|string',
            // 'technical_contact.*.email' => 'required|email',

            // Entity validation
            // 'entities.*.entity' => 'required|string',
            // 'entities.*.date' => 'required|date',
            // 'entities.*.involvement' => 'required|string',

            // Subsidiary validation
            // 'subsidiaries.*.affiliation' => 'required|string',
            // 'subsidiaries.*.date' => 'required|date',
            // 'subsidiaries.*.involvement' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'general_info.third_party_name.required' => 'The third party name is required.',
            'general_info.owner.required' => 'The owner name is required.',
            'general_info.agreement.required' => 'The agreement is required.',
            'general_info.place_of_incorporation.required' => 'The place of incorporation is required.',
            'general_info.head_office_location.required' => 'The head office location is required.',
            'general_info.classification.required' => 'The classification is required.',

            'general_info.domain.required' => 'The domain is required.',
            'general_info.domain.unique' => 'The domain already exist.',

            'general_info.contract_term.required' => 'The contract term is required.',
            // 'general_info.contract_term.numeric' => 'The contract term must be a number.',
            // 'general_info.contract_term.integer' => 'The contract term number must be an integer.',

            'general_info.date_of_incorporation.required' => 'The date of incorporation is required.',
            'general_info.date_of_incorporation.date' => 'The date of incorporation must be a valid date.',


            // Contact messages
            'contact.*.name.required' => 'Contact must have a name.',
            'contact.*.phone.required' => 'Contact must have a phone number.',
            'contact.*.email.required' => 'Contact must have an email address.',
            'contact.*.email.email' => 'Contact must have a valid email address.',

            // Business Contact messages
            'business_contact.*.name.required' => 'Business contact must have a name.',
            'business_contact.*.phone.required' => 'Business contact must have a phone number.',
            'business_contact.*.email.required' => 'Business contact must have an email address.',
            'business_contact.*.email.email' => 'Business contact must have a valid email address.',

            // Cyber Contact messages
            'cyber_contact.*.name.required' => 'Cyber contact must have a name.',
            'cyber_contact.*.phone.required' => 'Cyber contact must have a phone number.',
            'cyber_contact.*.email.required' => 'Cyber contact must have an email address.',
            'cyber_contact.*.email.email' => 'Cyber contact must have a valid email address.',

            // Technical Contact messages
            'technical_contact.*.name.required' => 'Technical contact must have a name.',
            'technical_contact.*.phone.required' => 'Technical contact must have a phone number.',
            'technical_contact.*.email.required' => 'Technical contact must have an email address.',
            'technical_contact.*.email.email' => 'Technical contact must have a valid email address.',

            // Entities messages
            'entities.*.entity.required' => 'Entity must have a name.',
            'entities.*.date.required' => 'Entity must have a date.',
            'entities.*.date.date' => 'Entity must have a valid date.',
            'entities.*.involvement.required' => 'Entity must have an involvement description.',

            // Subsidiaries messages
            'subsidiaries.*.affiliation.required' => 'Subsidiary must have an affiliation.',
            'subsidiaries.*.date.required' => 'Subsidiary must have a date.',
            'subsidiaries.*.date.date' => 'Subsidiary must have a valid date.',
            'subsidiaries.*.involvement.required' => 'Subsidiary must have an involvement description.',
        ];
    }

}