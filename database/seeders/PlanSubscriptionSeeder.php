<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class PlanSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::all()->each(
            function ($subscription) {
                operators()->each(
                    function ($operator) use ($subscription) {

                        $subscription->plans()->attach(
                            $subscription->id, [
                            'plan_id' => Plan::whereOperatorId($operator['id'])->whereIsVaxelPlan(false)->pluck('id')->random(),
                            'operator_id' => $operator['id'],
                            'vaxel_plan_id' => $subscription->isVaxelUser() ? Plan::whereOperatorId($operator['id'])->whereIsVaxelPlan(true)->first()->id : null,
                            ]
                        );

                        // PlanSubscription::factory()->state(function ($attributes) use ($operator) {
                        //     return [
                        //         'plan_id' => fn() => Plan::whereOperatorId($operator['id'])->pluck('id')->random()
                        //     ];
                        // })->create([
                        //     'operator_id' => $operator['id'],
                        //     'subscription_id' => $subcsription->id
                        // ]);
                    }
                );
            }
        );
    }
}
