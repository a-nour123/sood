<?php

namespace App\Http\Requests\admin\phishing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhishingTemplateRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                Rule::unique('phishing_templates', 'name')
                    ->whereNull('deleted_at') // Exclude soft-deleted entries
                    ->ignore($this->id), // Ignore current record if updating
            ],            'description' => 'required',
            // 'payload_type' => 'required',
            // 'email_difficulty' => 'required',
            'attachment' => 'sometimes|file',

            'phishing_website_id' => 'required',
            'sender_profile_id' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ];
        return $rules;
    }
}
