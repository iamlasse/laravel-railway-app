<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;

class CreateCompanyModal extends ModalComponent
{
    public Company $company;
    public CompanyUser $owner;

    protected $listeners = ['modalClosed' => 'cancel'];

    protected $rules = [
        'company.name' => ['required', 'min:5'],
        'company.reg_nr' => ['required', 'unique:companies,reg_nr'],
        'company.phone' => ['sometimes'],
        // 'company.contact' => ['required', 'min:8'],
        'owner.name' => ['required', 'min:6'],
        'owner.email' => ['required', 'email', 'unique:users,email'],
        // 'owner.username' => ['nullable', 'min:6', 'unique:users,username'],

        'company.current_monthly_cost' => ['required', 'numeric'],
        'company.current_monthly_flex_cost' => ['required', 'numeric'],

        'company.over_paying' => ['required', 'numeric'],

    ];

    protected $messages = [
        'company.name.required' => 'Du måste skriva in ett namn på företaget',
        'company.name.min' => 'Namnet måste vara minst :min tecken',
        'company.reg_nr.unique' => 'Det finns redan ett bolag med detta reg nr.',
        'company.phone.filled' => 'Telefon är tomt',
        // 'company.contact' => [],
        'owner.name.required' => 'Det måste anges ett namn på ansvarig för företaget',
        'owner.email.required' => 'Det måste anges en Epost address till ansvarig',
        'owner.email.unique' => 'Det finns redan en användare med denna address',
        'owner.name.unique' => 'Det finns redan en annan användare med detta namn',
        // 'owner.username.unique' => 'Det finns redan en annan användare med detta namn',

        'company.current_monthly_cost.required' => 'Du måste ange hur mycket som betalas idag',
        'company.current_monthly_cost.numeric' => 'Du måste ange ett nummer',

        'company.current_monthly_flex_cost.required' => 'Du måste ange hur mycket som betalas idag',
        'company.current_monthly_flex_cost.numeric' => 'Du måste ange ett nummer',

        'company.over_paying.required' => 'Du måste ange hur mycket som överdebiteras',
        'company.over_paying.numeric' => 'Du måste ange ett nummer',
    ];

    public function mount()
    {
        $this->company = new Company();
        $this->owner = new CompanyUser();
    }

    public function cancel()
    {
        $this->company = new Company();
        $this->closeModal();
        $this->resetValidation();
    }

    public function saveCompany()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $this->company
                ->setRepresentative(auth()->id())
                ->setOwner($this->owner)
                ->saveOrFail();
            $id = $this->company->id;
            $this->owner->setCompany($this->company->id)->saveOrFail();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }


        $this->company = new Company();
        $this->owner = new CompanyUser();

        $this->closeModal();
        $this->resetValidation();
        $this->emit('companyCreated');
        return redirect()->route('admin.company.edit', $id);
    }

    public function updatedCompany($value, $property)
    {
        $this->validateOnly($property);
    }

    public function updatedOwnerName($value)
    {
        $this->owner['username'] = Str::of($value)->lower()->ascii()->replace(' ', '.');
    }

    public function render()
    {
        return view('livewire.admin.create-company-modal');
    }
}
