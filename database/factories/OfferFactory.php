<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'name' => $this->faker->name(),
            'company_id' => Company::factory(),
            'is_current_vaxel' => false,
            'is_current_operator' => false,
            'is_recommended' => false,
            'operator_id' => collect(config('telekom.operators'))->pluck('id')->random(),
        ];
    }
}
