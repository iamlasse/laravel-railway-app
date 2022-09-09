<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\Traits\WithCompany;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    use WithCompany;

    public function getTotalSavingsOrOverpaidProperty()
    {
        // $totals = $this->getTotals(company()->currentOffer->id);

        // return $this->originalTotal * 24 - $totals['new'] * 24;
        return company()->over_paying;
    }

    public function render()
    {

        $company = DB::table('companies')
            ->selectRaw(DB::raw('(SELECT SUM(current_plan_usage) FROM subscriptions WHERE subscriptions.company_id = companies.id) as total_usage'))
            ->selectRaw(DB::raw('(SELECT SUM(current_plan_data) FROM subscriptions WHERE subscriptions.company_id = companies.id) as total_data'))
            ->where('companies.id', company()->id)
            ->sole();

            return view(
                'livewire.company.dashboard',
                [
                'company' => $company
                ]
            );
    }
}
