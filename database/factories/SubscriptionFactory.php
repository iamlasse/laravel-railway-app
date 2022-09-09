<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Company;
use App\Faker\TelekomFaker;
use App\Models\Plan;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $current_plan = collect([Plan::inRandomOrder()->first(), null])->random();
        $swedishFaker = FakerFactory::create(config('app.faker_locale'));
        $swedishFaker->addProvider(new TelekomFaker($swedishFaker));
        $name = collect([$swedishFaker->name, $swedishFaker->name, $swedishFaker->name, $swedishFaker->name, $swedishFaker->name, $swedishFaker->name, 'System 1', 'System 2'])->random();
        return [
            'name' => $name,
            'status' => collect(
                [
                Subscription::STATUS_ACTIVE,
                Subscription::STATUS_INACTIVE,
                // Subscription::STATUS_EXPIRING,
                // Subscription::STATUS_EXPIRED,
                // Subscription::STATUS_CANCELLED
                ]
            )->random(),
            'numbers' => collect([[$swedishFaker->phoneNumber(), $swedishFaker->phoneNumber()], [$swedishFaker->phoneNumber()], null])->random(),
            'department' => Str::contains($name, 'System') ? null : $swedishFaker->department,
            'current_plan_id' => $current_plan ? $current_plan->id : null,
            'current_plan_usage' => $current_plan && random_int(0, $current_plan->data),
            'company_id' => Company::inRandomOrder()->pluck('id')->first(),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'ends_at' => $this->faker->dateTimeBetween('now', '+6 months'),
            'type' => collect(['MB', 'M', 'DK'])->random()
        ];
    }
}
