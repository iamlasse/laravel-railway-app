<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Plan;
use App\Models\PlanOffer;
use Illuminate\Database\Seeder;

class OfferPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offers = Offer::all();

        $offers->each(
            function ($offer) {
                $operator_id = $offer->operator_id;
                Plan::whereOperatorId($operator_id)->get()->each(
                    fn($plan) => $offer->plans()->attach(
                        $plan->id, [
                        'price_org' => $plan->price,
                        'price_new' => $plan->price
                        ]
                    )
                );
            
            
            }
        );
    }
}
