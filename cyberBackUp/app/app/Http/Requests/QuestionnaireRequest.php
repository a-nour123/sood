<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:500'],
            'instructions' => ['required', 'string'],
            'assessment_id' => ['required', 'exists:assessments,id'],
            'contacts' => ['required','array','min:1'],
            'contacts.*'=>['required_with:contacts','exists:users,id'],
            'all_questions_mandatory' => ['in:1,0'],
            'answer_percentage' => ['exclude_if:all_questions_mandatory,1','in:1,0'],
            'percentage_number' => ['required_if:answer_percentage,1','exclude_if:answer_percentage,0','exclude_if:all_questions_mandatory,1','integer','between:1,100'],
            'specific_mandatory_questions'=>['exclude_if:all_questions_mandatory,1','in:1,0'],
            'questions'=>['exclude_if:specific_mandatory_questions,0','required_if:specific_mandatory_questions,1','array','min:1'],
            'questions.*'=>['required_with:questions','exists:questions,id','exclude_if:all_questions_mandatory,1']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'all_questions_mandatory' => request('all_questions_mandatory') ? 1 : 0,
            'answer_percentage' => request('answer_percentage') ? 1 : 0,
            'specific_mandatory_questions' => request('specific_mandatory_questions') ? 1 : 0,
        ]);
    }
}
