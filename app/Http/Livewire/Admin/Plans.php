<?php

namespace App\Http\Livewire\Admin;

use App\Models\Plan;
use Livewire\Component;

class Plans extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    public function getPlansQueryProperty()
    {
        return Plan::query();
    }

    public function getRowsProperty()
    {
        return $this->plansQuery->get();
    }

    public function deletePlan($planId)
    {
        // Plan::find($planId)->delete();
    }

    public function render()
    {
        return view(
            'livewire.admin.plans',
            [
            'plans' => $this->rows->groupBy('operator_id')
            ]
        )->layout('layouts.admin');
    }
}
