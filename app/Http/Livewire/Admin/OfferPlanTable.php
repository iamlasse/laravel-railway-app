<?php

namespace App\Http\Livewire\Admin;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OfferPlanTable extends Component
{
    public Offer $offer;
    public $selectedPlanId;
    public $selectedRow = [
        'price_new' => null,
        'subscriptions' => null
    ];
    public $editField;
    public $plan;
    public $plans;
    public $subscriptions;

    protected $listeners = ['refreshSelf' => '$refresh' ,'updateViews' => '$refresh'];

    public function mount(Offer $offer, Collection $subscriptions)
    {
        $this->offer = $offer->load('company');
        $this->subscriptions = $subscriptions;
    }

    protected $rules = [
    'selectedRow.price_new' => ['filled'],
    'selectedRow.subscriptions' => ['filled']
    ];

    public function selectPlanFieldToEdit($planId, $field)
    {
        $this->editField = $field;
        $plan = $this->planRows->where('plan_id', $planId)->first();
        $plan = $plan ?? $this->vaxelPlanRows->where('vaxel_plan_id', $planId)->first();
        $this->selectedPlanId = $plan->plan_id;
        $this->selectedRow = [
            'price_new' => $plan->price_new ? $plan->price_new : $plan->price
        ];
    }

    public function refreshTable()
    {
        $this->reset(['selectedPlanId', 'selectedRow']);
        $this->emitSelf('refreshSelf');
        return false;
    }

    public function updatePlan($attribute, $value)
    {
        if ($value == $this->selectedRow[$attribute]) {
            return;
        }

        if (!$this->selectedPlanId) {
            return;
        }
        if ($plan = $this->offer->plans()->firstWhere('plan_id', $this->selectedPlanId)) {
            $plan->plan->update([$attribute => $value ? $value : null]);
        } else {
            $this->offer->plans()->attach($this->selectedPlanId, [$attribute => $value ? $value : null]);
        }
        cache()->forget('company-' . $this->offer->company_id . '-offerPlans');
        cache()->forget('company-' . $this->offer->company_id . '-subscriptions-' . $this->offer->getOperator()['code']);
        sleep(0.1);
        $this->refreshTable();
    }

    public function getPlansQueryProperty()
    {
        $count = $this->subscriptions->count() > 0 ? $this->subscriptions->count() : 1;
        $subscriptions = $this->subscriptions->pluck('id');
        $placeholders = implode(",", array_fill(0, $count, '?'));

        return DB::table('offer_plan')
            ->select('plans.id as plan_id', 'plans.name', 'plans.data', 'plans.price', 'offer_plan.price_new')
            ->selectRaw(
                '(select count(*) from plan_subscription where `plan_subscription`.`plan_id` = `plans`.`id` and `plan_subscription`.`subscription_id` in (' . $placeholders . ') and `plan_subscription`.`operator_id` = ?) as subscriptions_count',
                [
                $subscriptions->count() > 0 ? $subscriptions->toArray() : [0],
                $this->offer->operator_id
                ]
            )
            ->join('plans', 'offer_plan.plan_id', '=', 'plans.id')
            ->where('offer_plan.offer_id', $this->offer->id)
            ->where('plans.is_vaxel_plan', 0);
    }

    public function getVaxelPlansQueryProperty()
    {
        $subscriptions = $this->subscriptions->pluck('id');
        $count = $subscriptions->count() > 0 ? $subscriptions->count() : 1;
        $placeholders = implode(",", array_fill(0, $count, '?'));

        return DB::table('offer_plan')
            ->select('plans.id as plan_id', 'plans.name', 'plans.data', 'plans.price', 'offer_plan.price_new')
            ->selectRaw(
                '(select count(*) from plan_subscription where `plan_subscription`.`vaxel_plan_id` = `plans`.`id` and `plan_subscription`.`subscription_id` in (' . $placeholders . ') and `plan_subscription`.`operator_id` = ?) as subscriptions_count',
                [
                $subscriptions->count() > 0 ? $subscriptions->toArray() : [0],
                $this->offer->operator_id
                ]
            )
            ->join('plans', 'offer_plan.plan_id', '=', 'plans.id')
            ->where('offer_plan.offer_id', $this->offer->id)
            ->where('plans.is_vaxel_plan', 1);
    }

    public function getPlanRowsProperty()
    {

        return $this->plansQuery->get();
    }

    public function getVaxelPlanRowsProperty()
    {
        return $this->vaxelPlansQuery->get();
    }

    public function getPlanCount(int $planId)
    {
        return $this->planRows->where('plan_id', $planId)->count();
    }

    public function render()
    {
        return view('livewire.admin.offer-plan-table');
    }
}
