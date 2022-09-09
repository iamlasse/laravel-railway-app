<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\SubscriptionsTable;
use App\Models\Subscription;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Modal\ModalComponent;

class EditSubscriptionModal extends ModalComponent
{
    public Subscription $editing;

    protected $listeners = ['update-plan' => 'handleUpdatePlan', 'updateModels' => 'handleUpdateModels'];

    protected $rules = [
        'editing.name' => ['filled', 'min:3'],
    ];

    protected $messages = [
        'editing.name.filled' => 'Abonnemanget måste ha ett namn.',
        'editing.name.min' => 'Abonnemanget måste ha minst 3 tecken.',
    ];

    public function mount($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        Gate::authorize('update', $subscription);
        $this->editing = $subscription;
    }

    public function save()
    {
        Gate::authorize('update', $this->editing);
        $this->editing->save();

        $this->forceClose()->closeModalWithEvents(
            [
            SubscriptionsTable::getName() => ['subscriptionSaved', [$this->editing->id]],
            ]
        );

        $this->dispatchBrowserEvent('saved', ['message' => 'Abonnemang sparades']);
    }

    public function render()
    {
        return view('livewire.company.edit-subscription-modal');
    }
}
