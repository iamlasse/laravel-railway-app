<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => null,
            'operator_id' => collect(config('telekom.operators'))->pluck('id')->random(),
            'data' => collect([10_000, 15_000, 50_000, 100_000, 500_000])->random(),
            'price' => collect([199, 249, 299, 349, 149])->random()
        ];
    }
}
