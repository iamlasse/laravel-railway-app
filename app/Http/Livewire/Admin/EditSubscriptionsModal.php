<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Traits\HandlesPlans;
use LivewireUI\Modal\ModalComponent;

class EditSubscriptionsModal extends ModalComponent
{
    use HandlesPlans;

    public $subscriptions = [];
    public $selectAll = false;

    protected $listeners = ['update-plan' => 'handleUpdatePlan'];

    public function mount($subscriptions, $all)
    {
        $this->subscriptions = $subscriptions;
        $this->selectAll = $all;
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
        return view('livewire.admin.edit-subscriptions-modal');
    }
}
