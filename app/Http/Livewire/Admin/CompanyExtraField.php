<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use Livewire\Component;

class CompanyExtraField extends Component
{
    public Company $company;
    public $extra = null;

    public function mount($extra = null)
    {
        $this->extra = $extra;
    }

    public function isDirty()
    {
        return $this->extra !== $this->company->extra;
    }

    public function saveExtraField()
    {
        optional($this->company)->update(
            [
            'extra' => $this->extra
            ]
        );
        $this->dispatchBrowserEvent('saved', ['message' => 'Företagsuppgifter sparade']);
    }
    public function updatedExtra($value)
    {
        // $this->saveExtraField();
    }

    public function render()
    {
        return view('livewire.admin.company-extra-field');
    }
}
