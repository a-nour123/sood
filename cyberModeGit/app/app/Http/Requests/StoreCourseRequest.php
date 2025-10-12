<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|unique:courses,name',
            'certificate_template_id' => 'required',
            'survey_id' => 'required|exists:awareness_surveys,id',
            'description' => 'nullable|string|max:1000',
            'grade' => 'required|integer|min:0|max:100',
            'max_seats' => 'required|integer|min:1|max:1000',
            'passing_grade' => 'required|integer|min:1|max:1000',
            'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'required|integer|exists:users,id',
            'schedule' => 'required|array|min:1',
            'schedule.*.date' => 'required|date|after_or_equal:today',
            'schedule.*.time' => 'required',
            'materials' => 'nullable|array',
            'materials.*' => 'nullable|file|mimes:pdf,doc,docx,pptx,zip,jpg,png,jpeg|max:10240',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('schedule') && is_array($this->schedule)) {
                $this->validateScheduleUniqueness($validator);
            }
        });
    }

    private function validateScheduleUniqueness($validator)
    {
        $schedules = $this->schedule;
        $dateTimes = [];

        foreach ($schedules as $index => $schedule) {
            if (!isset($schedule['date']) || !isset($schedule['time'])) {
                continue;
            }

            $dateTime = $schedule['date'] . ' ' . $schedule['time'];

            if (!isset($dateTimes[$dateTime])) {
                $dateTimes[$dateTime] = [];
            }

            $dateTimes[$dateTime][] = $index;
        }

        foreach ($dateTimes as $dateTime => $indexes) {
            if (count($indexes) > 1) {
                foreach ($indexes as $index) {
                    $validator->errors()->add(
                        "schedule.{$index}.date",
                        'لا يمكن أن تكون هناك جلستان في نفس التاريخ والوقت.'
                    );
                    $validator->errors()->add(
                        "schedule.{$index}.time",
                        'لا يمكن أن تكون هناك جلستان في نفس التاريخ والوقت.'
                    );
                }
            }
        }
    }
}
