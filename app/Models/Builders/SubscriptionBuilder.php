<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionBuilder extends Builder
{
    /**
     * Active
     *
     * @return self
     */
    public function active(): self
    {
        return $this->whereNotIn(
            'status',
            [
                Subscription::STATUS_INACTIVE,
                Subscription::STATUS_EXPIRED,
                Subscription::STATUS_CANCELLED,
                Subscription::STATUS_EXPIRING,
                Subscription::STATUS_INACTIVE
            ]
        )->whereToBeCancelled(false);
    }


    /**
     * Expiring
     *
     * @return self
     */
    public function expiring(): self
    {
        return $this->whereStatus(Subscription::STATUS_EXPIRING);
    }


    /**
     * Expired
     *
     * @return self
     */
    public function expired(): self
    {
        return $this->whereStatus(Subscription::STATUS_EXPIRED);
    }

    /**
     * Cancelled
     *
     * @return self
     */
    public function cancelled(): self
    {
        return $this->whereStatus(Subscription::STATUS_CANCELLED);
    }

    /**
     * Operatr Plans
     *
     * @param integer $operatorId
     * @return self
     */
    public function operatorPlans(int $operatorId): self
    {
        return $this->plans()->whereOperatorId($operatorId);
    }

    /**
     * With Usage
     *
     * @return self
     */
    public function withUsage(): self
    {
        return $this->selectRaw('(subscriptions.current_plan_data * 1000) - subscriptions.current_plan_usage as leftover_data')
            ->selectRaw('ROUND(subscriptions.current_plan_usage / (subscriptions.current_plan_data * 1000), 2) as usage_percent');
    }

    /**
     * With Plans
     *
     * @return self
     */
    public function withPlan(): self
    {
        return $this
            ->addSelect('plans.name as plan_name', 'plans.data as plan_data')
            ->join('plans', 'subscriptions.current_plan_id', '=', 'plans.id');
    }

    public function forCompany(int $companyId): self
    {
        return $this->whereCompanyId($companyId);
    }
}
