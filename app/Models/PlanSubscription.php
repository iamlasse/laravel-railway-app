<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanSubscription extends Pivot
{
    use HasFactory;

    protected $fillable = ['plan_id', 'subscription_id', 'operator_id', 'vaxel_plan_id'];

    protected $table = 'plan_subscription';

    public $timestamps = false;

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function vaxelPlan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'vaxel_plan_id');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
