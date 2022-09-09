<?php

namespace App\Http\Livewire\Company;

use App\Models\Plan;
use App\Models\PlanSubscription;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use LivewireUI\Modal\ModalComponent;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateSubscriptionModal extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public $data;

    protected $messages = [
        'data.type.required' => 'Du måste välja en abonnemang typ.',
        'data.name.required' => 'Namn måste fyllas i.',
        'data.department.required' => 'Avdelning måste fyllas i.',
        'data.numbers.required' => 'Det måste finnas minst ett telefon nummer.',
        'data.current_plan.required' => 'Prisplan måste fyllas i.',
        'data.current_plan_usage.required' =>  'Dataförbrukning måste fyllas i.',
        'data.current_plan_usage.numeric' => 'Dataförbrukning måste vara ett nummer.',
    ];

    public function getFormSchema()
    {
        $offer = optional(company()->currentOffer);
        return [
            Card::make(
                [
                Radio::make('type')->inline()
                    ->label('Typ')
                    ->options(
                        [
                        'M'     => 'Mobilabonnemang',
                        'MB'    => 'Mobilt bredband',
                        'DK'    => 'Datakort',
                        ]
                    )->default('M')
                    ->required(),

                TextInput::make('name')
                    ->helperText('Namn på abonnemanget')
                    ->label('Namn')
                    ->required(),
                TextInput::make('department')
                    ->label('Avdelning')
                    ->helperText('Avdelningen som abonnemanget tillhör'),
                ]
            ),
            Repeater::make('numbers')->label('Telefonnummer')
                ->required()
                ->helperText('Telefonnummer, du kan lägga till flera')
                ->createItemButtonLabel('Lägg till nummer')
                ->schema(
                    [
                    TextInput::make('number')->label('Nummer')
                    ]
                )->hidden(fn (callable $get) => $get('new_number')),
                Checkbox::make('new_number')->label('Nytt nummer')->reactive()->afterStateUpdated(fn (callable $set) => $set('numbers', null)),
            Grid::make()
                ->schema(
                    [
                    Select::make('current_plan')
                        ->label('Prisplan idag (' . $offer->getOperator()['name'] . ')')
                        ->options(Plan::whereIsVaxelPlan(false)->whereOperatorId($offer->getOperator()['id'])->pluck('name', 'id'))
                        ->helperText('Välj prisplan som används idag'),
                    TextInput::make('current_plan_usage')
                        ->label('Dataförbrukning idag (MB)')
                        ->rules(['numeric'])
                        ->placeholder('1000 (MB)')
                        ->rules(['filled', 'numeric'])
                        ->default(0)
                        ->helperText('Ange hur mycket data som används idag i MB')
                    ]
                ),
            Checkbox::make('vaxel_user')->label('Växel Användare')

        ];
    }

    public function cancel()
    {
        $this->closeModal();
        $this->resetValidation();
    }

    public function saveSubscription()
    {
        $state = $this->form->getState();

        /**
         *   "name" => ""
         *   "department" => ""
         *   "numbers" => []
         *   "current_plan" => integer
         *   "current_plan_usage" => integer
         */

        try {
            DB::beginTransaction();

            $plan = Plan::findOrFail($state['current_plan']);

            $subscription = company()->subscriptions()->create(
                [
                'type' => $state['type'],
                'name' => $state['name'],
                'department' => $state['department'],
                'numbers' => collect($state['numbers'])->pluck('number')->toArray(),
                'current_plan_id' => $state['current_plan'],
                'current_plan_data' => $plan->data,
                'current_plan_usage' => $state['current_plan_usage'],
                'status' => 1,
                'vaxel_user' => $state['vaxel_user'],
                ]
            );

            $currentVaxelPlanId = $subscription->isVaxelUser() ? Plan::whereOperatorId($plan->operator_id)->where('is_vaxel_plan', true)->first()->id : null;
            $subscription->plans()->attach($state['current_plan'], ['operator_id' => $plan->operator_id, 'vaxel_plan_id' => $currentVaxelPlanId]);

            if ($subscription->isVaxelUser()) {
                foreach (operators()->where('id', '!=', $plan->operator_id) as $operator) {
                    $id = $operator['id'];
                    $subscription->plans()->attach($state['current_plan'], ['operator_id' => $id, 'vaxel_plan_id' => null]);
                    cache()->forget('company-' . company()->id . '-subscriptions-' . $operator['code']);
                    // only update vaxel plan if subscriptionn is vaxel user.
                    $vaxelPlanId = Plan::whereOperatorId($id)->where('is_vaxel_plan', true)->first()->id;
                    // $subscription->plans()->attach(, ['operator_id' => $plan->operator_id, 'vaxel_plan_id' => $currentVaxelPlanId]);
                    PlanSubscription::create(
                        [
                        'subscription_id' => $subscription->id,
                        'operator_id' => $id,
                        'vaxel_plan_id' => $vaxelPlanId,
                        ]
                    );
                }
            }




            DB::commit();
            $this->emit('subscriptionCreated', $subscription->id);

            $this->closeModal();
            $this->dispatchBrowserEvent('saved', ['message' => 'Abonnemanget har skapats']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->addError('create', $th->getMessage());
        }

        $this->emit('subscriptionSaved', $subscription->id);
        $this->reset('data');
    }

    public function getFormStatePath(): string
    {
        return 'data';
    }

    public function render()
    {
        return view('livewire.company.create-subscription-modal');
    }
}
