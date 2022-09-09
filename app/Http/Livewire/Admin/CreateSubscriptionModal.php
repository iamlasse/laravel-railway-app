<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use LivewireUI\Modal\ModalComponent;

class CreateSubscriptionModal extends ModalComponent
{
    public Company $company;

    protected $listeners = ['subscriptionCreated'];

    public function mount($companyId)
    {
        $this->company = company($companyId);
    }

    public function subscriptionCreated($subscription)
    {
        $this->closeModalWithEvents(['subscriptionCreated' => $subscription]);
    }

    public function render()
    {
        return view(
            'livewire.admin.create-subscription-modal',
            [
            'company' => $this->company,
            ]
        );
    }
}
