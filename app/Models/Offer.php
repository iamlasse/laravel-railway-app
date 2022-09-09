<?php

namespace App\Models;

use App\Models\Builders\OfferBuilder;
use App\Models\Concerns\BelongsToCompany;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $casts = [
        'is_current_vaxel' => 'boolean',
        'is_current_operator' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    protected $fillable = [
        'is_current_vaxel',
        'is_current_operator',
        'is_recommended',
        'operator_id',
        'company_id',
    ];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class)
            ->using(PlanOffer::class)
            ->withPivot(['price_org', 'price_new'])->as('plan');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getOperator()
    {
        return operators()->where('id', $this->operator_id)->first();
    }

    public function isCurrentVaxel()
    {
        return $this->is_current_vaxel;
    }

    public function isCurrentOperator()
    {
        return $this->is_current_operator;
    }

    /**
     * Offer Builder
     *
     * @param  Builder $query The query builder
     * @return OfferBuilder Offer query builder
     */
    public function newEloquentBuilder($query): OfferBuilder
    {
        return new OfferBuilder($query);
    }
}
