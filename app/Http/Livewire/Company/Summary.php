<?php

namespace App\Http\Livewire\Company;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Summary extends Component
{
    protected $companyData;

    public function mount($companyData)
    {
        $this->companyData = $companyData;
    }

    public function render()
    {
        $plans = DB::table('plans')->where('operator_id', company()->currentOffer->operator_id)->get();

        $subscriptions = DB::table('subscriptions')->where('company_id', company()->id)->get();
        $total_cost = 0;
        $total_data = $this->companyData->total_data;
        $total_usage = toGB($this->companyData->data_usage);

        foreach ($plans as $plan) {
            $current_subscriptions_count = $subscriptions->where('current_plan_id', $plan->id)->count();
            $total_cost += $plan->price * $current_subscriptions_count;
        }

        return view(
            'livewire.company.summary',
            [
            'total' => $total_cost,
            'total_usage' => $total_usage,
            'total_data' => $total_data,
            ]
        );
    }
}
