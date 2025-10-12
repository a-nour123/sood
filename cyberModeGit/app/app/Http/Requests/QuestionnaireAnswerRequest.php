<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireAnswerRequest extends FormRequest
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
            'asset_name' => ['required', 'string', 'max:255'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.answers' => ['required_if:questions.*.question_is_required,=,true'],
            'questions.*.question_is_required' => ['required', 'in:true,false'],
        ];

        $answers_count = 0;
        if (request()->answer_percentage == 1) {
            foreach (request()->questions as $question) {
                if (array_key_exists('answers', $question)) {
                    $answers_count++;
                }
            }
            if ((($answers_count / count(request()->questions)) * 100) < request('percentage_number')) {

                $rules['answer_percentage'] = ['required', 'gte:' . request('percentage_number') . ' %'];
            }
        }


        return $rules;
    }

    public function messages()
    {
        return [

        ];
    }



}
