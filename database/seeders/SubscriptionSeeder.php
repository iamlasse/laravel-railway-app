<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all();

        $companies->each(
            function (Company $company) {

                $currentOffer = $company->offers()->whereIsCurrentOperator(true)->first();
            
                $plans = $currentOffer->plans;
            
                $subscriptions = Subscription::factory(random_int(30, 50))->state(
                    new Sequence(
                        function () use ($plans) {
                            $plan = collect($plans)->random();
                            return [
                                'current_plan_id' => $plan->id,
                                'current_plan_usage' => random_int(0, $plan->data),
                                'current_plan_data' => $plan->data,
                                'vaxel_user' => random_int(0, 1)
                            ];
                        },
                    )
                )->state(
                    new Sequence(
                        ['status' => Subscription::STATUS_ACTIVE]
                    )
                )
                ->create(
                    [
                    'company_id' => $company->id
                    ]
                );
                
                $company->subscriptions()->saveMany($subscriptions);
            }
        );
    }
}
