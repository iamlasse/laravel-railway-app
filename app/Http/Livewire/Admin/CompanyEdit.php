<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class CompanyEdit extends Component
{
    use Actions;

    public Company $company;
    public $showImportButton = false;

    protected $listeners = ['refreshViews' => '$refresh'];

    public function startCompany()
    {
        $this->company->start();
        $this->emitSelf('refreshViews');
    }

    public function deleteCompany()
    {
        $this->dialog()->confirm(
            [
            'title' => 'Är du säker?',
            'description' => 'Vill du verkligen ta bort företaget? Detta raderar all information, abonnemang, offerter etc. som är knutna till detta företag.',
            'icon' => 'shield-exclamation',
            'iconColor' => 'red-500',
            'reject' => [
                'label' => 'Avbryt',
            ],
            'accept'      => [
                'label'  => 'Ja, Fortsätt',
                'color' => 'negative',
                'method' => 'terminateCompany',
                'params' => 'Terminated',
            ]
            ]
        );
    }

    public function terminateCompany()
    {
        DB::transaction(
            function () {
                $this->company->terminate();
                $this->emit('company-deleted');
                request()->session()->flash('flash.banner', 'Företaget har raderats');
                request()->session()->flash('flash.bannerStyle', 'success');
                return redirect()->route('admin.company.index')->with('message', 'Företaget har avslutats');
            }
        );
    }

    public function render()
    {
        if ($this->company->hasCurrentOffer()) {
            $this->showImportButton = true;
        }
        return view('livewire.admin.company-edit')->layout('layouts.admin');
    }
}
