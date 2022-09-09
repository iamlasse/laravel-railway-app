<?php

namespace App\Http\Livewire\Traits;

use App\Models\Subscription;

trait HandlesPlans
{
    public $plans = [];

    public function handleUpdatePlan($operatorId, $planId)
    {
        if (empty($planId)) {
            unset($this->plans[$operatorId]);
        } else {
            $this->plans[$operatorId] = $planId;
        }
    }

    protected function savePlans()
    {
        if ($this->plans) {
            foreach ($this->plans as $operatorId => $plan) {
                if (empty($plan)) {
                    continue;
                }

                if ($this->selected) {
                    $ids = $this->selectAll ? $this->selectedRowsQuery->pluck('id') : $this->selected;
                    Subscription::whereKey($ids)->each(fn (Subscription $subscription) => $this->updateSubscriptionPlan($subscription, $operatorId, $plan));
                }

                if ($this->editing) {
                    $this->updateSubscriptionPlan($this->editing, $operatorId, $plan);
                }
            }

            $this->reset('plans');
            $this->emitTo('utils.plan-select', 'clear');
        }
    }
}
