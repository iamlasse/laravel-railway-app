<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Plan;
use App\Models\PlanSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use WireUi\Traits\Actions;

class SubscriptionsTable extends Component
{
    use Actions;
    use WithSorting;
    use WithCachedRows;
    use WithBulkActions;
    use WithPerPagePagination;

    public $model;
    public $order;
    public $showEditModal = false;
    public $showFilters = false;
    public $editing = null;
    public $expiration = null;
    public $selectedOperator;
    public $hide = [];

    public $filters = [
        'search' => '',
        'type' => '',
        // 'amount-min' => null,
        // 'amount-max' => null,
        // 'date-min' => null,
        // 'date-max' => null,
    ];

    protected $queryString = ['sorts', 'page'];

    protected $listeners = ['refresh' => '$refresh', 'subscriptionsSaved', 'subscriptionSaved' => '$refresh'];

    protected $casts = [
        'editing.expires_at' => 'date'
    ];

    public function mount($model, $hide = [])
    {
        $this->model = $model;
        $this->order = null;
        $this->hide = $hide;

        if (selected_operator_or_order() || session('selected_operator')) {
            $this->selectedOperator = operators()->firstWhere('id', session('selected_operator'));
        } else {
            $this->selectedOperator = operators()->firstWhere('id', company()->currentOffer->operator_id);
        }
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function rules()
    {
        $statuses = is_null($this->editing) ? [] : Subscription::getStatuses();
        return [
            'editing.expires_at' => [Rule::requiredIf(
                function () {
                    return Subscription::STATUS_EXPIRING === $this->editing->status;
                }
            ), 'date'],
            'editing.name' => 'required|min:3',
            'editing.department' => ['filled', 'min:3'],
            // 'editing.status' => 'required|in:'.collect($statuses)->keys()->implode(','),
            'editing.status' => ['required', Rule::in(collect($statuses)->keys())]
        ];
    }

    public function cancel()
    {
        $this->showEditModal = false;
        $this->resetErrorBag();
        $this->resetValidation();
        // $this->reset()
    }

    public function cancelSubscription($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        Gate::authorize('update', $subscription);
        $subscription->cancel();
        operators()->each(fn($operator) => cache()->forget('company-' . company()->id . '-subscriptions-' . $operator['code']));
        sleep(0.5);
        $this->dispatchBrowserEvent('saved', ['message' => 'Abonnemang markeras som avslutat.']);
    }


    public function save()
    {
        $this->validate();

        if (Subscription::STATUS_CANCELLED == $this->editing->status) {
            $this->editing->cancelled_at = now();
        }

        if (Subscription::STATUS_EXPIRING == $this->editing->status) {
            // $this->editing->expires_at = $this->expiration;
        }

        $this->editing->save();

        $this->showEditModal = false;
        $this->resetErrorBag();
    }



    public function subscriptionsSaved($subscriptions, $all, $plans)
    {
        $ids = $all ? $this->selectedRowsQuery->pluck('id') : $subscriptions;
        try {
            $this->savePlans(
                $ids,
                $plans,
                function () {
                    $this->emitSelf('refresh');
                }
            );

            $this->dispatchBrowserEvent('saved', ['message' => $this->selectedRowsQuery->count() . " Abonnemang uppdaterade"]);
            $this->reset('selected', 'selectPage', 'selectAll');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function savePlans($subscriptionIds, $plans = [], $cb = null)
    {
        DB::transaction(
            function () use ($subscriptionIds, $plans) {
                $subscriptionIds = collect($subscriptionIds)->map(
                    function ($id) {
                        return (int) $id;
                    }
                )->toArray();

                if ($plans) {
                    foreach ($plans as $operatorId => $plan) {
                        if (empty($plan)) {
                            continue;
                        }
                        Subscription::whereKey($subscriptionIds)->each(fn (Subscription $subscription) => $this->setSubscriptionPlan($subscription, $operatorId, $plan, false));
                    }
                }
            }
        );

        if ($cb) {
            $cb();
        }
    }

    public function setSubscriptionPlan(Subscription $subscription, $operatorId, $planId, $event = true)
    {
        Gate::authorize('update', $subscription);
        try {
            $operator = operators()->firstWhere('id', $operatorId);
            if ($subscriptionPlan = $subscription->plans()->wherePivot('operator_id', $operatorId)->first()) {
                $subscriptionPlan->pivot->update(['plan_id' => $planId]);
            } else {
                $subscription->plans()->attach($planId, ['operator_id' => $operatorId]);
            }
            if ($event) {
                $this->dispatchBrowserEvent('saved', ['message' => 'Abonnemang sparades']);
            }
            cache()->forget('company-' . company()->id . '-subscriptions-' . $operator['code']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function updateSubscriptionPlan(Subscription $subscription, $operatorId, $plan): void
    {
        if (!PlanSubscription::whereOperatorId($operatorId)->whereSubscriptionId($subscription->id)->update(['plan_id' => $plan])) {
            $subscription->plans()->syncWithoutDetaching([$plan => ['operator_id' => $operatorId]]);
        }
    }

    public function activateSubscription(int $subscriptionId)
    {
        // $this->dialog()->confirm([
        //     'title'       => 'Aktivera abonnemanget?',
        //     'description' => 'Abonnemanget kommer aktiveras, vilket betyder det kommer räknas med i framtida beställningar',
        //     'acceptLabel' => 'Ja tack, Aktivara',
        //     'method'      => 'save',
        //     'params'      => 'Saved',
        // ]);
        $subscription = Subscription::findOrFail($subscriptionId);
        Gate::authorize('update', $subscription);
        $subscription->activate();
        operators()->each(fn($operator) => cache()->forget('company-' . company()->id . '-subscriptions-' . $operator['code']));
        sleep(0.5);
        $this->dispatchBrowserEvent('saved', ['message' => 'Abonnemanget har aktiverats.']);
    }




    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = !$this->showFilters;
    }

    public function edit(Subscription $subscription)
    {
        $this->useCachedRows();

        if (is_null($this->editing)) {
            $this->editing = $subscription;
        }

        if ($this->editing->isNot($subscription)) {
            $this->editing = $subscription;
        }

        $this->showEditModal = true;
    }


    public function updatedPerPage($value)
    {
        $this->gotoPage(1);
    }
    public function getRowsQueryProperty()
    {
        $query = $this->model->subscriptions()
            ->with('plans')
            ->when(
                $this->filters['type'],
                function ($query, $type) {
                    return $query->where('type', $type);
                }
            )
            ->when(
                $this->filters['search'],
                function ($query, $search) {
                    if (strlen($search) <= 3) {
                        return;
                    }

                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('department', 'like', '%' . $search . '%');
                }
            )
            ->when(
                empty($this->sorts),
                function ($query) {
                    return $query->latest();
                }
            );

        return $this->applySorting($query);
    }

    public function getPlansProperty()
    {
        return cache()->rememberForever(
            'plans',
            function () {
                return Plan::all();
            }
        );
    }

    public function getRowsProperty()
    {
        return $this->cache(
            function () {
                return $this->applyPagination($this->rowsQuery);
            }
        );
    }

    public function getOfferPlansProperty()
    {
        return cache()->rememberForever(
            'company-' . company()->id . '-offerPlans',
            function () {
                return DB::table('offer_plan')->select('price_new as price', 'plan_id as id')->whereIn('offer_id', company()->offers->pluck('id'))->get();
            }
        );
    }

    public function render()
    {
        return view(
            'livewire.subscriptions-table',
            [
            'subscriptions' => $this->rows,
            'operatorId' => $this->selectedOperator['id']
            ]
        );
    }
}
