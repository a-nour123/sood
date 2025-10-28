<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssessmentQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'assessment_id' => $this->faker->numberBetween(1, 10),
            'question' => $this->faker->text,
            'order' => $this->faker->unique()->numberBetween(1, 10)
        ];
    }
}
