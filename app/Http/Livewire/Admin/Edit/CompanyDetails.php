<?php

namespace App\Http\Livewire\Admin\Edit;

use App\Models\Admin;
use App\Models\Company;
use Livewire\Component;

class CompanyDetails extends Component
{
    public Company $company;
    public $companyRep;
    public $showSaveButton = false;
    public $companyEditForm = [
        'current_monthly_flex_cost' => 0,
        'current_monthly_cost' => 0,
        'over_paying' => 0,
        'period_starts_at' => null,
        'period_ends_at' => null,
    ];

    public $disabled;

    protected $rules = [
        'companyEditForm.current_monthly_cost' => ['filled', 'numeric', 'min:0'],
        'companyEditForm.current_monthly_flex_cost' => ['filled', 'numeric', 'min:0'],
        'companyEditForm.over_paying' => ['filled', 'numeric', 'min:0'],
        'companyEditForm.period_starts_at' => ['nullable', 'date'],
        'companyEditForm.period_ends_at' => ['nullable', 'date'],
    ];

    protected $messages = [
        'companyEditForm.current_monthly_cost.numeric' => ['kostnad måste vara ett nummer.'],
        'companyEditForm.current_monthly_flex_cost.numeric' => ['kostnad måste vara ett nummer.'],
        'companyEditForm.over_paying.numeric' => ['kostnad måste vara ett nummer.'],
        'companyEditForm.period_starts_at.date' => ['startdatum måste vara ett giltigt datum.'],
        'companyEditForm.period_ends_at.date' => ['slut datum måste vara ett giltigt datum'],
    ];

    public function isDatesDirty()
    {
        return $this->company->period_starts_at != $this->companyEditForm['period_starts_at'] ||
            $this->company->period_ends_at != $this->companyEditForm['period_ends_at'];
    }


    public function isDirty()
    {
        return $this->companyEditForm['current_monthly_cost'] != $this->company->current_monthly_cost
            || $this->companyEditForm['current_monthly_flex_cost'] != $this->company->current_monthly_flex_cost
            || $this->companyEditForm['over_paying'] != $this->company->over_paying;
    }

    public function updatedCompanyEditForm($property, $value)
    {
        if ($this->isDirty()) {
            $this->disabled = false;
            $this->showSaveButton = true;
        }
    }

    public function saveCompanyDates()
    {
        $this->validateOnly('companyEditForm.period_starts_at');
        $this->validateOnly('companyEditForm.period_ends_at');
        if ($this->companyEditForm['period_starts_at'] !== null) {
            $this->company->period_starts_at = $this->companyEditForm['period_starts_at'];
        } else {
            $this->company->period_starts_at = null;
        }
        if ($this->companyEditForm['period_ends_at'] !== null) {
            $this->company->period_ends_at = $this->companyEditForm['period_ends_at'];
        } else {
            $this->company->period_ends_at = null;
        }


        $this->company->save();
        $this->dispatchBrowserEvent('saved', ['message' => 'Period sparad']);
    }

    public function mount(Company $company)
    {
        $this->fill(
            [
            'companyEditForm' => $company
            ]
        );

        $this->companyRep = $company->rep->id;
    }

    public function updatedCompanyRep($value)
    {
        // You cannot deselect a rep, only set a new one.
        if ($value) {
            $this->company->update(['rep_id' => $value]);
            $this->dispatchBrowserEvent('saved', ['message' => 'Representant ändrat']);
        }
    }

    public function saveCompanyDetails()
    {
        $this->validateOnly('companyEditForm.current_monthly_cost');
        $this->validateOnly('companyEditForm.current_monthly_flex_cost');
        $this->validateOnly('companyEditForm.over_paying');
        $this->company->update(
            [
            'current_monthly_cost' => $this->companyEditForm['current_monthly_cost'],
            'current_monthly_flex_cost' => $this->companyEditForm['current_monthly_flex_cost'],
            'over_paying' => $this->companyEditForm['over_paying']
            ]
        );

        $this->resetValidation();
        $this->dispatchBrowserEvent('saved', ['message' => 'Företagsuppgifter sparade']);
    }
    public function render()
    {
        return view(
            'livewire.admin.edit.company-details',
            [
            'reps' => Admin::active()->get()
            ]
        )->layout('layouts.admin');
    }
}
