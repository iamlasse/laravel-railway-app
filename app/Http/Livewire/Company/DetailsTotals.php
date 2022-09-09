<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\Traits\WithCompany;
use App\Models\Offer;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetailsTotals extends Component
{
    use WithCompany;

    public Offer $offer;

    public function mount()
    {
        $this->offer = $this->getSelectedOffer();
    }

    public function cache($callback, $cacheKey = null)
    {
        $cacheKey = $cacheKey ?? $this->id;

        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $result = $callback();

        cache()->put($cacheKey, $result, now()->addSeconds(5));

        return $result;
    }

    protected function getSelectedOffer(): Offer
    {
        if (session()->has('selected_operator') && company()->currentOffer->operator_id !== session('selected_operator')) {
            return company()->offers()->whereOperatorId(session('selected_operator'))->sole();
        } else {
            return company()->currentOffer;
        }
    }

    public function getPlansProperty()
    {
        return $this->cache(
            function () {
                return DB::table('plan_subscription')
                    ->join('plans', 'plans.id', '=', 'plan_subscription.plan_id')
                    ->whereIn('subscription_id', company()->subscriptions()->active()->pluck('id'))
                    ->get();
            },
            company()->id . '-plans'
        );
    }

    // public function getTotals(int $offerId)
    // {
    //     $offer = Offer::findOrFail($offerId);
    //     // $plans = $this->plans->where('operator_id', $offer->operator_id);

    //     $totals = [
    //         'org' => 0,
    //         'new' => 0,
    //         'avg' => 0,
    //         'data' => 0,
    //     ];

    //     // foreach ($offer->plans as $plan) {
    //         // $plans_count = $plans->where('id', $plan->id)->count();
    //         // $plan_price_new = $plan->plan->price_new ? $plan->plan->price_new : $plan->price;
    //         // $totals['org'] += $plan->price * $plans_count;
    //         // $totals['new'] += $plan_price_new * $plans_count;
    //     // }
    //     // $totals['avg'] = $totals['new'] / company()->subscriptions->count();
    //     // $totals['data'] = $plans->sum('data');
    //     $data = DB::table('plan_subscription')

    //         ->select('plans.name', 'plans.price', 'plans.id as plan_id')
    //         ->join('plans', 'plans.id', '=', 'plan_subscription.plan_id')
    //         ->selectRaw('count(plan_subscription.plan_id) as plan_count, plan_subscription.plan_id')
    //         // ->join('offer_plan', 'offer_plan.plan_id', '=', 'plan_subscription.plan_id')
    //         // ->join('plans', 'plans.id', '=', 'subscriptions.current_plan_id')
    //         ->whereIn('subscription_id', company()->subscriptions->pluck('id'))
    //         ->where('plan_subscription.operator_id', '=', $offer->operator_id)
    //         ->groupBy('plan_subscription.plan_id')
    //         ->get();

    //         $offer_plans = DB::table('offer_plan')->join('offers', 'offers.id', 'offer_plan.offer_id')->where('offer_id', $offerId)->whereIn('plan_id', $data->pluck('plan_id'))->get();

    //     foreach ($data as $plan) {
    //         $plans_count = $plan->plan_count;
    //         $offer = $offer_plans->where('plan_id', $plan->plan_id)->first();

    //         $plan_price_new = !is_null($offer) ? $offer->price_new ?? $offer->price_org : $plan->price;
    //         $plan_price_org = !is_null($offer) ? $offer->price_org : $plan->price;


    //         $totals['org'] +=  $plan_price_org  * $plans_count;
    //         $totals['new'] += $plan_price_new * $plans_count;
    //         $totals['avg'] = $totals['new'] / company()->subscriptions->count();
    //     }

    //     return $totals;
    // }

    public function getTotalPercentSavedProperty()
    {
        $total = ($this->originalTotal * 24);
        $amount_saved = ($this->selectedTotals['new'] * 24) - $total;
        $amount_differ =  - $amount_saved;
        $total_saved = $amount_differ / $total;
        return round($total_saved  * 100, 2);
    }

    public function getTotalSavedProperty()
    {
        return $this->originalTotal * 24 - $this->selectedTotals['new'] * 24;
    }

    public function getOriginalTotalProperty()
    {
        return company()->current_monthly_cost;
    }

    public function getSelectedTotalsProperty()
    {
        return $this->getTotals($this->offer->id);
    }

    public function render()
    {
        return view(
            'livewire.company.details-totals',
            [
            'totals' => $this->selectedTotals,
            ]
        );
    }
}
