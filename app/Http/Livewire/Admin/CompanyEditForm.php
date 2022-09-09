<?php

namespace App\Http\Livewire\Admin;

use App\Models\Address;
use Livewire\Component;
use App\Models\Company;
use App\Models\CompanyUser;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CompanyEditForm extends Component implements HasForms
{
    use InteractsWithForms;

    public Company $company;

    public function mount(Company $company)
    {
        // dd($this->contact);
        $this->companyForm->fill(
            [
            'name' => $company->name,
            'reg_nr' => $company->reg_nr,
            'phone' => $company->phone,
            ]
        );

        $this->addressForm->fill(
            [
            'gatunamn' => $company->address->gatunamn,
            'postnr' => $company->address->postnr,
            'postort' => $company->address->postort,
            ]
        );

        $this->contactForm->fill(
            [
            'contact_name' => $company->contact->name,
            'contact_email' => $company->contact->email,
            ]
        );
    }

    protected $messages = [
        'contact_email.unique' => 'Ange en unik e-postadress',
        'contact_email.email' => 'Ange en riktig/giltig e-postadress',

        'phone.digits_between' => 'Ange ett telefonnummer med 8-10 siffror',
    ];

    protected function getCompanyFormSchema(): array
    {
        return [
            Card::make()
                ->schema(
                    [
                    Grid::make()->schema(
                        [
                        TextInput::make('name')
                            ->required()
                            ->label('Företagsnamn'),
                        TextInput::make('reg_nr')
                            ->required()
                            ->mask(fn(Mask $mask) => $mask
                                ->pattern('000000-0000'))
                            ->label('Organisationsnummer'),
                        TextInput::make('phone')
                            ->required()
                            ->rule('digits_between:8,10')
                            // ->mask(fn(Mask $mask) => $mask
                            //     ->pattern('0000 00 00 00'))
                            ->label('Telefonnummer'),
                        ]
                    ),
                    ]
                ),
        ];
    }

    protected function getAddressFormSchema(): array
    {
        return [
            Card::make()
                ->schema(
                    [
                    TextInput::make('gatunamn')->label('Gatuadress'),
                    Grid::make()->schema(
                        [
                        TextInput::make('postnr')->label('Postnr'),
                        TextInput::make('postort')->label('Postort'),
                        ]
                    ),
                    ]
                ),
        ];
    }

    protected function getContactFormSchema(): array
    {
        return [
            Card::make()->schema(
                [
                TextInput::make('contact_name')->label('Kontaktperson')->required(),
                TextInput::make('contact_email')->label('Epost')
                    
                    ->required()
                    ->rules([
                        'email:rfc,dns,spoof',
                        Rule::unique('users', 'email')->ignore($this->company->contact),
                    ]),
                ]
            )
        ];
    }

    protected function getForms(): array
    {
        return [
            'companyForm' => $this->makeForm()
                ->schema($this->getCompanyFormSchema())
                ->model($this->company),
            'addressForm' => $this->makeForm()
                ->schema($this->getAddressFormSchema())
                ->model($this->company->address),
            'contactForm' => $this->makeForm()
                ->schema($this->getContactFormSchema())
                ->model($this->company->contact),
        ];
    }

    public function updatingContactForm(...$vars)
    {
        dd($vars);
        $this->validate();
    }

    public function saveCompanyInformation()
    {
        $this->validate();
        
        $contact = $this->contactForm->getState();
        
        DB::beginTransaction();
        try {
            $this->company->updateOrFail($this->companyForm->getState());

            $this->company->address->updateOrFail($this->addressForm->getState());

            $this->company->contact->updateOrFail(
                [
                'name' => $contact['contact_name'],
                'email' => $contact['contact_email'],
                ]
            );
            DB::commit();
            $this->dispatchBrowserEvent('saved', ['message' => 'Företagets Information sparades']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.admin.company-edit-form');
    }
}
