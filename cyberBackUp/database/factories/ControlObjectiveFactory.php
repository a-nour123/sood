<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class ControlObjectiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $this->faker = Faker::create();

        return [
            'name' => $this->faker->unique()->name(),
            'description' => trim($this->faker->text(500)),
        ];
    }
}
