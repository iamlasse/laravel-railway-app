<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\Traits\WithCompany;
use Livewire\Component;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class OrderForm extends Component implements HasForms
{
    use InteractsWithForms;
    use WithCompany;

    public function mount()
    {
        $this->companyForm->fill(
            [
            'name' => company()->name,
            'reg_nr' => company()->reg_nr,
            'phone' => company()->phone,
            ]
        );

        $this->addressForm->fill(
            [

            'gatunamn' => company()->address->gatunamn,
            'postnr' => company()->address->postnr,
            'postort' => company()->address->postort,
            ]
        );

        $this->customerForm->fill(
            [
            'customer_name' => company()->contact->name,
            'email' => company()->contact->email,
            ]
        );
    }

    protected $messages = [
        'customerForm.name.required' => 'Du måste ange kundens namn',
        'customerForm.email.required' => 'Du måste ange en e-postadress',
    ];



    protected function getCompanyFormSchema()
    {
        return [
            Section::make('Företagets uppgifter')
                ->collapsible()
                ->schema(
                    [
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
                                    ->label('Organisationsnummer'),
                                TextInput::make('phone')
                                    ->required()
                                    ->label('Företagets telefon'),
                                ]
                            ),
                            ]
                        ),
                    ]
                ),
            ];
    }



    protected function getAddressFormSchema(): array
    {
        return [

                Section::make('Leveransadress (för hårdvara och SIM-kort)')
                    ->collapsible()
                    ->schema(
                        [
                        TextInput::make('gatunamn'),
                        TextInput::make('postnr'),
                        TextInput::make('postort'),
                        ]
                    ),

        ];
    }

    protected function getCustomerFormSchema()
    {
        return [
            Section::make('Beställarens uppgifter')
                ->collapsible()
                ->schema(
                    [
                    Grid::make()
                        ->schema(
                            [
                            TextInput::make('customer_name')
                                ->required()
                                ->label('Beställarens namn'),
                            TextInput::make('email')
                                ->required()
                                ->label('Beställarens email address')
                                ->type('email')
                            ]
                        )

                    ]
                )
                        ];
    }

    protected function getForms(): array
    {
        return [
            'companyForm' => $this->makeForm()
                ->schema($this->getCompanyFormSchema())
                ->model(company()),
            'addressForm' => $this->makeForm()
                ->schema($this->getAddressFormSchema())
                ->model(company()->address),
            'customerForm' => $this->makeForm()
                ->schema($this->getCustomerFormSchema())
                ->model(company()->contact),
        ];
    }


    public function confirmOrder()
    {
        $company = $this->companyForm->getState();
        $address = $this->addressForm->getState();
        $customer = $this->customerForm->getState();
        $form = collect()
            ->merge($company)
            ->merge($address)
            ->merge($customer);
        $this->emit('orderConfirmed', ['order' => $form]);
    }

    public function adjustOrder()
    {
        session()->put('selected_operator', company()->selected_operator);
        redirect(route('company.adjust', company()->selected_operator));
    }

    public function render()
    {
        return view('livewire.company.order-form');
    }
}
