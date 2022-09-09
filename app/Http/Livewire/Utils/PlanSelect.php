<?php

namespace App\Http\Livewire\Utils;

use App\Models\Plan;
use App\Models\PlanSubscription;
use Livewire\Component;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class PlanSelect extends Component
{
    public int $operatorId;
    public int $subscriptionId;
    public PlanSubscription|null $operatorPlan;
    public $plan = null;
    public $options = [];

    protected $listeners = ['clear' => 'clearPlan'];

    public function clearPlan()
    {
        $this->reset('plan');
    }
    public function mount($operatorId, $subscriptionId = null)
    {
        $this->operatorId = $operatorId;
        $this->options = Plan::whereOperatorId($operatorId)->whereIsVaxelPlan(false)->get();
        if (!is_null($subscriptionId)) {
            $this->subscriptionId = $subscriptionId;

            $this->operatorPlan = PlanSubscription::whereOperatorId($operatorId)->whereSubscriptionId($subscriptionId)->first();
            $this->plan = $this->operatorPlan?->plan_id ?? null;
        }
    }

    public function updatingSubscriptionId()
    {
        throw new MethodNotAllowedException([], 'You are not allowed to update subscription id');
    }

    public function updatingOperatorId()
    {
        throw new MethodNotAllowedException([], 'You are not allowed to update operator id');
    }

    public function updatedPlan($planId)
    {
        $this->emitUp('update-plan', $this->operatorId, $planId);
    }

    public function render()
    {
        // dd($this->options);
        return view('livewire.utils.plan-select');
    }
}
