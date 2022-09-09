<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\Traits\WithCompany;
use App\Models\Offer;
use Livewire\Component;

class Offers extends Component
{
    use WithCompany;

    public $selectedOffer = null;

    public function mount()
    {

        if (!session('selected_operator')) {
            $this->selectedOffer = company()->currentOffer;
            session()->put(['selected_operator' => $this->selectedOffer->operator_id]);
        } else {
            $this->selectedOffer = company()->offers()->whereOperatorId(session('selected_operator'))->sole();
        }
    }

    public function setup()
    {
        company()
            ->loadSum('subscriptions as total_usage', 'current_plan_usage')
            ->loadSum('subscriptions as total_data', 'current_plan_data')
            ->loadCount('subscriptions');
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

    public function setAdjust($offerId)
    {
        $this->setCompare($offerId);
        redirect(route('company.adjust', $this->selectedOffer->operator_id));
    }

    public function setCompare($offerId)
    {
        $this->selectedOffer = Offer::find($offerId);
        session()->put('selected_operator', $this->selectedOffer->operator_id);
    }

    public function getSelectedTotalsProperty()
    {
        return $this->getTotals($this->selectedOffer->id);
    }

    public function getTotalPercentSavedProperty()
    {
        $total = ($this->original_total * 24);
        $amount_saved = ($this->selected_totals['new'] * 24) - $total;
        $amount_differ = -$amount_saved;
        $total_saved = $amount_differ / $total;
        return round($total_saved  * 100, 2);
    }

    public function getOptimizedDataProperty()
    {
        // code...
    }

    public function getTotalSavedProperty()
    {
        return $this->original_total * 24 - $this->selected_totals['new'] * 24;
    }

    public function startOrder()
    {
        company()->startOrder($this->selectedOffer->operator_id);
        redirect(route('company.order'));
    }

    public function getSelectedOfferPlansProperty()
    {
        return $this->plansData['data'];
    }

    public function getSelectedOfferTotalProperty()
    {
        return $this->plansData['total'];
    }

    public function getSelectedOfferDataProperty()
    {
        return [
            'total_percent_saved' => $this->total_percent_saved,
            'total_saved' => $this->total_saved,
        ];
    }

    public function getSelectedOfferTotalsProperty()
    {
        return $this->getTotals($this->selectedOffer->id);
    }



    public function render()
    {
        $this->setup();
        return view(
            'livewire.company.offers',
            [
            'offers' => company()->offers,
            'subscriptions' => company()->subscriptions,
            ]
        );
    }
}
