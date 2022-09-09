<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyUser;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $swedishFaker = FakerFactory::create(config('app.faker_locale'));
        return [
            'name' => $swedishFaker->company,
            'reg_nr' => $this->faker->unique()->regexify('[5][0-9]([1][3-9]|[2-9][0-9])\d{2}[-]?\d{4}'),
            'rep_id' => Admin::inRandomOrder()->first()->id,
            'phone' => $this->faker->phoneNumber,
            'current_monthly_cost' => 22_789,
            'over_paying' => 248_000
        ];
    }

    public function configure()
    {
        return $this->afterMaking(
            function (Company $company) {
                //
            }
        )->afterCreating(
            function (Company $company) {
                $company->contact_id = CompanyUser::factory()
                    ->withRole()
                    ->create(
                        [
                        'company_id' => $company->id,
                        ]
                    )->id;
            
                $company->save();
            }
        );
    }
}
