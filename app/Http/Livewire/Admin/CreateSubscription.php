<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use App\Models\Plan;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateSubscription extends Component implements HasForms
{
    use InteractsWithForms;

    public Company $company;
    public $data;

    protected $messages = [
        'data.current_plan_usage.numeric' => 'Nuvarande Data Användning måste vara ett nummer.',
        'data.numbers.required' => 'Det måste finnas minst en nummer.',
    ];

    public function mount($company): void
    {

        $this->company = $company;
        $this->form->fill(
            [
                'type' => 'M',
                'status' => '1',
            ]
        );
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        $operatorId = optional($this->company->currentOffer)->operator_id;
        // $operators = operators()->filter(fn($o) => $o['id'] != $operatorId);
        $selects = operators()->map(
            function ($operator) {
                return Select::make('plan_' . $operator['id'])
                    ->label($operator['name'])
                    ->options(Plan::whereOperatorId($operator['id'])->whereIsVaxelPlan(false)->pluck('name', 'id'));
            }
        )->toArray();

        return array_merge(
            [
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
                            )->default('M')->reactive(),

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
                    ->helperText('Telefonnummer, du kan lägga till flera')
                    ->createItemButtonLabel('Lägg till nummer')
                    ->schema(
                        [
                            TextInput::make('number')->label('Nummer')
                                ->required()
                                ->tel()
                        ]
                    )->hidden(
                        fn (Closure $get) => $get('new_number') || $get('type') == 'DK'
                    ),
                Checkbox::make('new_number')
                    ->label('Nytt nummer')
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('numbers', null)),
                Grid::make()->schema(
                    [
                        Select::make('current_plan')
                            ->label('Prisplan idag (' . $this->company->currentOffer->getOperator()['name'] . ')')
                            ->options(Plan::whereOperatorId($operatorId)->whereIsVaxelPlan(false)->pluck('name', 'id'))
                            ->disabled(fn (Closure $get) => $get('new_number')),
                        TextInput::make('current_plan_usage')
                            ->type('number')
                            ->label('Dataförbrukning idag (MB)')
                            ->placeholder('1000')
                            ->rules(['numeric'])->default(0)
                            ->disabled(fn (Closure $get) => $get('new_number')),

                    ]
                ),
                Section::make('Föreslagen prisplan hos respektive operatör')->schema($selects)
            ],
            [
                Checkbox::make('status')
                    ->label('Abonnemanget är aktivt')
                    ->default(true),
                Checkbox::make('vaxel_user')
                    ->label('Växelanvändare')

            ]
        );
    }

    public function createSubscription()
    {
        $state = $this->form->getState();
        
        try {
            DB::beginTransaction();
            if ($state['new_number']) {
                $plan = null;
                $numbers = collect();
            } else {
                $plan =  Plan::firstWhere('id', $state['current_plan']);
                $numbers = collect($state['numbers'])->pluck('number');
            }

            $subscription = $this->company->subscriptions()->create(
                [
                    'type' => $state['type'],
                    'name' => $state['name'],
                    'department' => $state['department'],
                    'numbers' => $numbers->isEmpty() ? null : $numbers->toArray(),
                    'current_plan_id' => $plan ? $plan->id : null,
                    'current_plan_data' => $plan ? $plan->data : 0,
                    'current_plan_usage' => $state['current_plan_usage'] ?? 0,
                    'status' => $state['status'],
                    'vaxel_user' => $state['vaxel_user'],
                ]
            );

            // New plan assignments.
            foreach (operators() as $operator) {
                $id = $operator['id'];
                // only update vaxel plan if subscriptionn is vaxel user.
                $vaxelPlanId = $subscription->isVaxelUser() ? Plan::whereOperatorId($id)->where('is_vaxel_plan', true)->first()->id : null;
                // Update set plans on subscription
                $subscription->plans()->attach($state['plan_' . $id], ['operator_id' => $id, 'vaxel_plan_id' => $vaxelPlanId]);
            }


            DB::commit();
            $this->emit('subscriptionCreated', $subscription->id);
        } catch (\Throwable $th) {
            $this->addError('create', $th->getMessage());
        }

        $this->emit('updateViews');
        $this->reset('data');
    }

    public function render()
    {
        return view('livewire.admin.create-subscription');
    }
}
