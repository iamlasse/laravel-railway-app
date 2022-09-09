<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gatunamn' => $this->faker->streetAddress(),
            // '' => $this->faker->streetAddress(),
            'postnr' => $this->faker->postcode(),
            'postort' => $this->faker->city(),
            'company_id' => Company::first()->id,
        ];
    }
}
