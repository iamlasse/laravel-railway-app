<?php

namespace App\Http\Livewire\Admin;

use App\Models\Plan;
use App\Models\Company;
use Livewire\Component;
use App\Models\Subscription;
use App\Models\PlanSubscription;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Illuminate\Database\Query\Builder as QueryBuilder;

class SubscriptionsTable extends Component
{
    use WithPerPagePagination;
    use WithSorting;
    use WithCachedRows;
    use WithBulkActions;

    public Company $company;
    public $order;
    public $showFilters = false;
    public $expiration = null;
    public $hide = [];
    public $plans = [];


    protected $queryString = ['sorts'];

    public $filters = [
        'search' => '',
        'type' => '',
        // 'amount-min' => null,
        // 'amount-max' => null,
        // 'date-min' => null,
        // 'date-max' => null,
    ];

    protected $listeners = [
        'refreshSelf' => '$refresh',
        'subscriptionCreated',
        'subscriptionSaved',
        'subscriptionsSaved',
        'updateVaxelPlans',
        'refreshViews',
        'subscriptionsImported' => '$refresh',
    ];


    public function mount($company, $hide = [])
    {
        $this->company = $company;
        $this->order = null;
        $this->hide = $hide;
    }

    public function refreshViews()
    {
        $this->emitSelf('refreshSelf');
    }

    public function updateVaxelPlans($subscriptionId)
    {
        $subscription = Subscription::find($subscriptionId);
        operators()->pluck('id')->each(
            function ($operatorId) use ($subscription) {
                $this->updateSubscriptionVaxelPlan($subscription, $operatorId);
            }
        );
    }

    public function subscriptionCreated()
    {
        $this->emitSelf('refreshViews');
        $this->dispatchBrowserEvent('saved', ['message' => 'Abonnemang sparad']);
    }

    public function subscriptionSaved($subscription, $plans)
    {
        $this->savePlans(
            $subscription,
            $plans,
            function () {
                $this->emitSelf('refreshViews');
            }
        );

        $this->dispatchBrowserEvent('saved', ['message' => "Abonnemang uppdaterades"]);
        $this->emitTo('admin.offer-plan-table', 'updateViews');
    }

    public function subscriptionsSaved($subscriptions, $all, $plans)
    {
        $ids = $all ? $this->selectedRowsQuery->pluck('id') : $subscriptions;
        $this->savePlans(
            $ids,
            $plans,
            function () {
                $this->emitSelf('refreshViews');
            }
        );

        $this->dispatchBrowserEvent('saved', ['message' => $this->selectedRowsQuery->count() . " Abonnemang uppdaterade"]);
        $this->emit('updateViews');

        $this->reset('selected', 'selectPage', 'selectAll');
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getSubscriptionsPlansQueryProperty(): QueryBuilder
    {
        // SELECT `subscriptions`.* FROM `subscriptions` INNER JOIN `plan_subscription` ON `plan_subscription`.`subscription_id` = `subscriptions`.`id` WHERE `subscriptions`.`company_id` = 1 and `subscriptions`.`company_id` IS not NULL LIMIT 10 OFFSET 0
        return DB::table('plan_subscription')
            ->select('*')
            ->join('plans', 'plans.id', '=', 'plan_subscription.plan_id')
            ->whereIn('plan_subscription.subscription_id', $this->rows->pluck('id'));
    }

    public function getSubscriptionsPlansProperty()
    {
        return $this->subscriptionsPlansQuery->get();
    }

    public function getRowsQueryProperty()
    {
        $query = $this->company->subscriptions()
            ->select('subscriptions.*')
            ->withUsage()
            ->with('plan')
            ->when(
                $this->filters['type'],
                function ($query, $type) {
                    $query->where('subscriptions.type', $type);
                }
            )
            ->when(
                $this->filters['search'],
                function ($query, $search) {
                    if (strlen($search) <= 3) {
                        return;
                    }

                    $query->where('subscriptions.name', 'like', '%' . $search . '%')
                        ->orWhere('subscriptions.department', 'like', '%' . $search . '%');
                }
            )->when(!$this->sorts, fn ($query) => $query->latest());

        return $this->applySorting($query);
    }

    public function getPlanData(int $operatorId, int $subscriptionId)
    {
        $plan = $this->subscriptionsPlans->where('operator_id', $operatorId)->where('subscription_id', $subscriptionId)->first();

        return $plan ? $plan->data : null;
    }

    protected function savePlans($subscriptionIds, $plans = [], $cb = null)
    {
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
                Subscription::whereKey($subscriptionIds)->each(fn (Subscription $subscription) => $this->updateSubscriptionPlan($subscription, $operatorId, $plan));
                $operator = operators()->where('id', $operatorId)->first();
                cache()->forget('company-' . $this->company->id . '-subscriptions-' . $operator['code']);
            }
        }

        if ($cb) {
            $cb();
        }

        cache()->forget('company-' . $this->company->id . '-offerPlans');
    }

    protected function updateSubscriptionPlan(Subscription $subscription, $operatorId, $plan): void
    {
        if (!PlanSubscription::whereOperatorId($operatorId)->whereSubscriptionId($subscription->id)->update(['plan_id' => $plan])) {
            $subscription->plans()->syncWithoutDetaching([$plan => ['operator_id' => $operatorId]]);
        }
    }

    public function updateSubscriptionVaxelPlan(Subscription $subscription, $operatorId): void
    {
        $subscriptionPlan = PlanSubscription::whereOperatorId($operatorId)->whereSubscriptionId($subscription->id)->first();
        $planId = Plan::whereOperatorId($operatorId)->where('is_vaxel_plan', true)->first()->id;
        // dd($subscriptionPlan, $planId);
        if ($subscriptionPlan) {
            // update existing vaxel plan for subscription.
            $subscriptionPlan->update(['vaxel_plan_id' => $planId]);
        } else {
            PlanSubscription::create(
                [
                'subscription_id' => $subscription->id,
                'operator_id' => $operatorId,
                'vaxel_plan_id' => $planId
                ]
            );
            // create vaxel plan for operator.
            // TODO: create plan subscription for current plan with empty data plan.
        }
    }

    public function deleteSubscriptions()
    {
        $ids = $this->selectedRowsQuery->pluck('id');

        DB::beginTransaction();
        try {
            Subscription::whereIn('id', $ids)->delete();

            DB::commit();
            $this->selectPage = false;
            $this->selected = [];
            $this->selectAll = false;
            $this->dispatchBrowserEvent('saved', ['message' => count($ids) . ' abonnemang raderade']);
            $this->emitTo('admin.offer-plan-table', 'updateViews');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = !$this->showFilters;
    }

    public function getRowsProperty()
    {
        return $this->cache(
            function () {
                return $this->applyPagination($this->rowsQuery);
            }
        );
    }

    public function render()
    {
        return view(
            'livewire.admin.subscriptions-table',
            [
            'subscriptions' => $this->rows
            ]
        )->layout('layouts.admin');
    }
}
