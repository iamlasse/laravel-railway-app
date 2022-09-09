<?php

namespace App\Http\Livewire;

use App\Models\Offer;
use App\Models\Subscription;
use Livewire\Component;

class OfferSubscriptionStatus extends Component
{
    public $offer;

    public function mount(Offer $offer)
    {
        $this->offer = $offer;
    }
    public function render()
    {
        return view(
            'livewire.offer-subscription-status',
            [
            'offer' => $this->offer->load('subscriptions')->loadCount(
                [
                'subscriptions as active_subscriptions' => function ($query) {
                    $query->whereStatus(Subscription::STATUS_ACTIVE);
                },
                'subscriptions as ended_subscriptions' => function ($query) {
                    $query->whereStatus(Subscription::STATUS_EXPIRED);
                },
                'subscriptions as expiring_subscriptions' => function ($query) {
                    $query->whereStatus(Subscription::STATUS_EXPIRING);
                },
                ]
            )
            ]
        );
    }
}
