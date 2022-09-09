<?php

namespace App\Http\Livewire\Admin\Plans;

use App\Http\Livewire\Admin\Plans;
use App\Models\Plan;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Modal\ModalComponent;

class CreatePlan extends ModalComponent
{
    public $operator;

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

    public function mount($operator)
    {
        $this->operator = $operator;
        $this->plan = new Plan();
    }

    public function createPlan()
    {
        $validated = $this->validate();

        Plan::create(Arr::add($validated['plan'], 'operator_id', $this->operator['id']));
        $this->closeModalWithEvents(
            [
            Plans::getName() => 'refresh'
            ]
        );
        $this->dispatchBrowserEvent('saved', ['message' => 'Prisplan skapat']);
    }

    public function render()
    {
        return view('livewire.admin.plans.create-plan');
    }
}
