<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\Traits\HandlesPlans;
use LivewireUI\Modal\ModalComponent;

class EditSubscriptionsModal extends ModalComponent
{
    use HandlesPlans;

    public $subscriptions = [];
    public $selectAll = false;
    public $operatorId;

    protected $listeners = ['update-plan' => 'handleUpdatePlan'];

    public function mount($subscriptions, $all, $operatorId)
    {
        $this->subscriptions = $subscriptions;
        $this->selectAll = $all;
        $this->operatorId = $operatorId;
    }

    public function saveSubscriptions()
    {
        $this->emit('subscriptionsSaved', $this->subscriptions, $this->selectAll, $this->plans);
        $this->forceClose()->closeModal();
    }

    public function cancel()
    {
        $this->forceClose()->closeModal();
    }

    public function render()
    {
        return view('livewire.company.edit-subscriptions-modal');
    }
}
