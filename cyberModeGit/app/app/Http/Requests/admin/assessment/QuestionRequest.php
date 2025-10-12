<?php

namespace App\Http\Requests\admin\assessment;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $sometimes_bool = 'sometimes|nullable|bool';
        return [
            'question' => ['required', 'string', 'max:500',],
            'answer_type' => ['required', 'in:1,2,3'],
            'control_id' => ['sometimes', 'nullable', 'exclude_unless:answer_type,1','exists:framework_controls,id'],
            'assessment_id' => ['required', 'exists:assessments,id'],
            'file_attachment' => $sometimes_bool,
            'question_logic' => $sometimes_bool,
            'risk_assessment' => $sometimes_bool,
            'compliance_assessment' => $sometimes_bool,
            'maturity_assessment' => $sometimes_bool,
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'file_attachment' => $this->request->has('file_attachment') ? 1 : 0,
            'question_logic' => $this->request->has('question_logic') ? 1 : 0,
            'risk_assessment' => $this->request->has('risk_assessment') ? 1 : 0,
            'compliance_assessment' => $this->request->has('compliance_assessment') ? 1 : 0,
            'maturity_assessment' => $this->request->has('maturity_assessment') ? 1 : 0,
        ]);
    }

}
