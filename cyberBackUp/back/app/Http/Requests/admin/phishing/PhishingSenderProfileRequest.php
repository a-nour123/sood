<?php

namespace App\Http\Requests\admin\phishing;

use Illuminate\Foundation\Http\FormRequest;

class PhishingSenderProfileRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'from_display_name' => 'required|string|max:100',
            'type' => 'required',
            'from_address_name' => 'required|string|max:100',
            'website_domain_id' => 'required_if:type,managed',
        ];

        if($this->type == 'own'){
            $rules = array_merge($rules,[
                'from_address_name' => 'email'
            ]);
        }else{
            $rules = array_merge($rules,[
                'from_address_name' => 'regex:/^[^@]+$/'
            ]);
        }
        return $rules;
    }
}
