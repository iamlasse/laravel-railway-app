<?php

namespace App\Http\Livewire\Admin\Plans;

use App\Http\Livewire\Admin\Plans;
use App\Models\Plan;
use LivewireUI\Modal\ModalComponent;

class UpdatePlan extends ModalComponent
{
    public Plan $plan;

    protected $rules = [
        'plan.name' => ['required', 'min:8'],
        'plan.description' => ['sometimes'],
        'plan.data' => ['required', 'numeric'],
        'plan.price' => ['required', 'numeric'],
    ];

    protected $messages = [
        'plan.name.required' => 'Namn är obligatoriskt',
        'plan.data.required' => 'Data mängd är obligatoriskt',
        'plan.price.required' => 'Pris är obligatoriskt'
    ];

    public function mount(int $planId)
    {
        $this->plan = Plan::find($planId);
    }

    public function updatePlan()
    {
        $this->validate();

        $this->plan->save();

        $this->closeModal();
        $this->dispatchBrowserEvent('saved', ['message' => 'Plan uppdaterat']);
        $this->closeModalWithEvents(
            [
            Plans::getName() => 'refresh'
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.plans.update-plan');
    }
}
