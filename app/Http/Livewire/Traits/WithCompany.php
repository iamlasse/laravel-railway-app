<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Support\Facades\DB;

trait WithCompany
{
    public function getTotals(int $offerId)
    {
        $data = $this->getPlans($offerId);
        
        // Get only mobile plans
        $total_plans_count = $data->reduce(function($carry, $plan) {
            $plans_count = $plan->is_vaxel_plan ? $plan->vaxel_plan_count : $plan->mobile_plan_count;

            $carry += $plans_count;

            return $carry;
        }, 0);

        // Get calculated totals
        $totals = $data->reduce(function($carry, $plan) {
            $plans_count = $plan->is_vaxel_plan ? $plan->vaxel_plan_count : $plan->mobile_plan_count;
            
            $plan_price_new = $plan->price_new ?? $plan->price_org ?? $plan->price;
            $plan_price_org = $plan->price_org ?? $plan->price;
            $plan->plan_data = $plan->plan_data ?? 0;

            $carry['org'] +=  $plan_price_org  * $plans_count;
            $carry['new'] += $plan_price_new * $plans_count;
            $carry['data'] += $plan->plan_data * $plans_count;

            return $carry;
        }, [
            'avg' => 0,
            'org' => 0,
            'new' => 0,
            'data' => 0,
        ]);

        if($total_plans_count > 0) {
            $totals['avg'] = $totals['new'] / $total_plans_count;
        }
        
        return $totals;
    }

    public function getPlans(int $offerId)
    {
        $offer = DB::table('offers')->where('id', $offerId)->first();
        $operator = operators()->where('id', $offer->operator_id)->first();
        $subscriptions = DB::table('subscriptions')->select('id')->where('company_id', company()->id)->pluck('id');

        $count = $subscriptions->count() > 0 ? $subscriptions->count() : 1;
        $placeholders = implode(",", array_fill(0, $count, '?'));

        $data = cache()->rememberForever(
            'company-' . company()->id . '-subscriptions-' . $operator['code'],
            function () use ($offer, $placeholders, $subscriptions) {
                return DB::table('offer_plan')
                    ->select('plans.id as plan_id', 'plans.name', 'plans.is_vaxel_plan', 'plans.data as plan_data', 'plans.price', 'offer_plan.price_new', 'offer_plan.price_org')
                    ->selectRaw(
                        '(select count(*) from plan_subscription where `plan_subscription`.`plan_id` = `plans`.`id` and `plan_subscription`.`subscription_id` in (' . $placeholders . ') and `plan_subscription`.`operator_id` = ?) as mobile_plan_count',
                        [
                        $subscriptions->count() > 0 ? $subscriptions->toArray() : [0],
                        $offer->operator_id
                        ]
                    )
                    ->selectRaw(
                        '(select count(*) from plan_subscription where `plan_subscription`.`vaxel_plan_id` = `plans`.`id` and `plan_subscription`.`subscription_id` in (' . $placeholders . ') and `plan_subscription`.`operator_id` = ?) as vaxel_plan_count',
                        [
                        $subscriptions->count() > 0 ? $subscriptions->toArray() : [0],
                        $offer->operator_id
                        ]
                    )
                    ->join('plans', 'offer_plan.plan_id', '=', 'plans.id')
                    ->where('offer_plan.offer_id', [$offer->id])
                    ->get();
            }
        );

        return $data;
    }

    public function getPlansDataProperty()
    {
        $data = $this->getPlans($this->selectedOffer->id)
            ->map(
                function ($plan) {
                    $plans_count = $plan->is_vaxel_plan ? $plan->vaxel_plan_count : $plan->mobile_plan_count;
                    $plan_price = $plan->price_new ?? $plan->price_org ?? $plan->price;
                    $plan_price_org = $plan->price_org ?? $plan->price;

                    $plan->plan_count = $plans_count;
                    $plan->price_new = $plan_price;
                    $plan->price_org = $plan_price_org;

                    return $plan;
                }
            )->filter(
                function ($plan) {
                    return $plan->plan_count > 0;
                }
            );

        $total = $data->reduce(
            function ($c, $plan) {
                $sum = $plan->plan_count * $plan->price_new ?? $plan->price;
                return $c += $sum;
            },
            0
        );

        return [
            'data' => $data->groupBy('is_vaxel_plan'),
            'total' => $total,
        ];
    }

    public function getOriginalTotalProperty()
    {
        return company()->current_monthly_cost + company()->current_monthly_flex_cost;
    }

    public function getTotalPercentSavedProperty()
    {
        $total = ($this->originalTotal * 24);
        $amount_saved = ($this->selectedTotals['new'] * 24) - $total;
        $amount_differ =  -$amount_saved;
        $total_saved = $amount_differ / $total;
        return round($total_saved  * 100, 2);
    }

    public function getTotalSavedProperty()
    {
        return $this->originalTotal * 24 - $this->selectedTotals['new'] * 24;
    }

    public function getSelectedTotalsProperty()
    {
        return $this->getTotals($this->selectedOffer->id);
    }

    public function getSelectedOfferProperty()
    {
        return company()->orderInProgress()
            ? company()->offers()->whereOperatorId(company()->selected_operator)->sole()
            : company()->currentOffer;
    }
}
