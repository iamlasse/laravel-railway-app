<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanOffer extends Pivot
{
    protected $table = 'offer_plan';

    public $timestamps = false;

    protected $fillable = ['price_new', 'price_org', 'offer_id', 'plan_id'];

    protected $with = ['plan'];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function getDataAttribute()
    {
        return $this->plan->data;
    }

    public function getPriceAttribute()
    {
        return $this->plan->price;
    }
}
