<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'name', 'data', 'price', 'operator_id'];
    /**
     * The offers that belong to the Plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class)->using(PlanOffer::class)->as('details')->withPivot(['price_org', 'price_new']);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class)->using(PlanSubscription::class)->as('subscription')->withPivot(['operator_id']);
    }
}
