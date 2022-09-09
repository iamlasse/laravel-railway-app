<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use App\Models\Company;
use Livewire\Component;

class RepSelector extends Component
{
    public Company $company;

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    public function setRep($repId)
    {
        $this->company->update(
            [
            'rep_id' => $repId
            ]
        );
        $this->dispatchBrowserEvent('saved', ['message' => 'Representant ändrat']);
    }
    public function render()
    {
        return view(
            'livewire.admin.rep-selector',
            [
            'reps' => Admin::all()
            ]
        );
    }
}
