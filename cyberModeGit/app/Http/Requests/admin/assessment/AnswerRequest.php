<?php

namespace App\Http\Requests\admin\assessment;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'question_id' => ['required', 'exists:questions,id'],
            'answer_en' => ['required', 'string', 'max:1500'],
            'answer_ar' => ['required', 'string', 'max:1500'],
            'sub_questions' => ['sometimes', 'nullable'],
            'sub_questions.*' => ['required_with:sub_questions', 'exists:questions,id'],
            'assessment_id' => ['exclude'],
            'sub_question_assessment_id' => ['sometimes', 'nullable', 'exists:assessments,id'],
            'fail_control' => ['sometimes', 'nullable', 'bool'],
            'attached' => ['sometimes', 'nullable', 'bool'],
             'maturity_control_id' => ['sometimes', 'nullable', 'exists:control_maturities,id'],
            'submit_risk' => ['sometimes', 'nullable', 'bool'],
            'submit_nda' => ['sometimes', 'nullable', 'bool'],
            'risk_subject' => ['sometimes', 'nullable', 'string', 'max:500'],
            'risk_scoring_method_id' => ['sometimes', 'nullable', 'exists:scoring_methods,id'],
            'likelihood_id' => ['sometimes', 'nullable', 'exists:likelihoods,id'],
            'impact_id' => ['sometimes', 'nullable', 'exists:impacts,id'],
            'owner_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'nda_id' => ['sometimes', 'nullable', 'exists:ndas,id'],
            'assets_ids' => ['sometimes', 'nullable', 'array'],
            'tags_ids' => ['sometimes', 'nullable', 'array'],
            'framework_controls_ids' => ['sometimes', 'nullable'],

        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'fail_control' => (bool)request('fail_control'),
            'attached' => (bool)request('attached'),
            'submit_risk' => (bool)request('submit_risk'),
            'submit_nda' => (bool)request('submit_nda'),
            'answer' => strip_tags(request('answer'))
        ]);
    }

//    public function failedValidation(Validator $validator)
//    {
//        throw new HttpResponseException(response()->json(collect($validator->errors())->flatten(0), 401));
//    }
}