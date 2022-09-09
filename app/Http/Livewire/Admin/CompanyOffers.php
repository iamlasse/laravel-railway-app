<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use App\Models\Offer;
use Livewire\Component;

class CompanyOffers extends Component
{
    public Company $company;

    protected $listeners = [
        'updateModels',
        'refreshOffers',
        'updateViews' => '$refresh'
    ];

    public function refreshOffers()
    {
        $this->emit('refreshViews');
        $this->emitTo('admin.company-edit', 'refreshViews');
    }

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    protected function getAttributeLabel($attribute)
    {
        return __("telekom.offer.{$attribute}");
    }

    public function updateModels(Offer $offer, $attribute, $active)
    {
        if ($active) {
            // dump('UPDATE MODELS', $attribute, $active);
            $this->company->offers()->where($attribute, true)->update(
                [
                $attribute => false
                ]
            );
            $offer->update(
                [
                $attribute => true
                ]
            );
        } else {
            $offer->update(
                [
                $attribute => false
                ]
            );
        }
        $this->emitSelf('refreshOffers');

        $this->dispatchBrowserEvent('saved', ['message' => $this->getAttributeLabel($attribute) . ' ändrat till ' . $offer->getOperator()['name']]);
    }

    public function render()
    {
        return view(
            'livewire.admin.company-offers',
            [
            // 'offers' => $this->company->offers
            ]
        )->layout('layouts.admin');
    }
}
