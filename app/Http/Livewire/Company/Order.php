<?php

namespace App\Http\Livewire\Company;

use App\Http\Livewire\Traits\WithCompany;
use App\Mail\Admin\Company\OrderConfirmed;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Order extends Component
{
    use WithCompany;

    protected $listeners = ['orderConfirmed'];

    public function mount()
    {
        if (!company()->orderInProgress()) {
            return redirect(route('company.offers'))->with('error', 'Det finns ingen pågående beställning');
        }
    }

    public function orderConfirmed($form)
    {
        $plansData = [
            'data' => $this->plansData['data']->flatten(),
            'total' => $this->plansData['total'],
        ];
        Mail::to($form['order']['email'])->cc(company()->rep->email)
            ->send(new OrderConfirmed(company(), $plansData, $form));

        company()->orders()->create(
            [
            'order_data' => $plansData['data'],
            'total' => $plansData['total'],
            'completed_at' => now()
            ]
        );
        company()->clearOrder();

        redirect()->route('company.order.summary')->with('success', 'Tack för din beställning!');
    }

    public function render()
    {
        // dd($this->form->getState());
        return view(
            'livewire.company.order',
            [
            'totals' => $this->getTotals($this->selectedOffer->id),
            'plans' => $this->plansData['data'],
            'total' => $this->plansData['total'],
            'offer_data' => [
                'total_percent_saved' => $this->total_percent_saved,
                'total_saved' => $this->total_saved,
            ],
            ]
        );
    }
}
