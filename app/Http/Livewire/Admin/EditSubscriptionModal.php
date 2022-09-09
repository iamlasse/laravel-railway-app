<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Traits\HandlesPlans;
use App\Models\Subscription;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Modal\ModalComponent;

class EditSubscriptionModal extends ModalComponent
{
    use HandlesPlans;

    public Subscription $editing;

    protected $listeners = ['update-plan' => 'handleUpdatePlan', 'updateModels' => 'handleUpdateModels'];

    public function mount($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        Gate::authorize('update', $subscription);
        $this->editing = $subscription;
    }

    public function rules()
    {
        return [
            'editing.name' => ['filled', 'min:3'],
            'editing.department' => ['nullable'],
            'editing.status' => ['boolean'],
            'editing.vaxel_user' => ['boolean'],
        ];
    }

    public function messages()
    {
        return [
            'editing.name.filled' => 'Abonnemanget måste ha ett namn.',
            'editing.name.min' => 'Abonnemanget måste ha minst 3 tecken.',
            // 'editing.department.filled' => 'Abonnemanget måste ha ett avdelningsnamn.',
            'editing.department.min' => 'Abonnemanget måste ha minst 2 tecken.',
        ];
    }

    public function cancel()
    {
        $this->forceClose()->closeModal();
    }

    public function handleUpdateModels($model, $attribute, $active)
    {
        $this->editing->setAttribute($attribute, $active);
    }

    public function activateSubscription()
    {
        $this->editing->activate();
        $this->closeModal();
        $this->emit('subscriptionSaved', $this->editing->id, $this->plans);
    }

    public function saveSubscription()
    {
        Gate::authorize('update', $this->editing);


        $this->validate();

        if ($this->editing->isDirty('vaxel_user') && !$this->editing->getOriginal('vaxel_user')) {
            // Update all plans for vaxel user.
            $this->emit('updateVaxelPlans', $this->editing->id);
        }

        if ($this->editing->isDirty('status') && !$this->editing->status) {
            $this->editing->cancel();
        }

        $this->editing->save();

        $this->resetErrorBag();
        $this->resetValidation();
        // $this->reset('editing');
        $this->forceClose()->closeModal();
        $this->emit('subscriptionSaved', $this->editing->id, $this->plans);
    }


    public function render()
    {
        return view('livewire.admin.edit-subscription-modal');
    }
}
