<?php

namespace App\Models;

use App\Events\Admin\CompanyStarted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\URL;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reg_nr',
        'phone',
        'contact',
        'extra',
        'rep_id',
        'period_starts_at',
        'period_ends_at',
        'current_monthly_cost',
        'current_monthly_flex_cost',
        'over_paying'
    ];

    protected $with = ['currentOffer'];

    protected $dates = [
        'offer_ends_at',
        'period_starts_at',
        'period_ends_at',
    ];

    public function employees()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function contact(): HasOne
    {
        return $this->hasOne(CompanyUser::class, 'id', 'contact_id');
    }

    /**
     * Get all of the offers for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'company_id');
    }

    public function currentOffer()
    {
        return $this->hasOne(Offer::class)->whereIsCurrentOperator(1);
    }

    public function rep(): HasOne
    {
        return $this->hasOne(Admin::class, 'id', 'rep_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class)->latestOfMany('created_at')->whereNotNull('completed_at');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isCurrentRep(int $repId)
    {
        return $this->rep_id === $repId;
    }

    public function hasCurrentOffer()
    {
        return $this->currentOffer !== null;
    }

    public function hasOfferExpiration()
    {
        return $this->offer_ends_at !== null;
    }

    public function hasOrder()
    {
        return $this->order !== null;
    }

    public function hasVaxelOperator()
    {
        return $this->offers()->where('is_current_vaxel', 1) ?? $this->currentOffer;
    }

    public function getVaxeloperator()
    {
        $offer = $this->offers()->where('is_current_vaxel', 1)->first() ?? $this->currentOffer;
        if ($offer) {
            return $offer->getOperator();
        }
    }

    public function hasSubscriptions()
    {
        return $this->subscriptions()->count() > 0;
    }

    public function setRepresentative($id)
    {
        $this->rep_id = $id;
        return $this;
    }

    public function setOwner(CompanyUser $owner)
    {
        $this->contact()->save($owner);
        $this->setAttribute('contact_id', $owner->id);
        return $this;
    }

    public function getTotalUsageLevel()
    {
        if (0 == $this->total_usage) {
            return 'low';
        }

        $usage = $this->total_usage / $this->total_data;

        if ($usage > 0 && $usage <= 0.25) {
            return 'low';
        }

        if ($usage > 0.25 && $usage <= 0.65) {
            return 'medium';
        }
        if ($usage >= 0.65 && $usage <= 1) {
            return 'high';
        }

        return 'low';
    }

    public function getUsageClass()
    {
        switch ($this->getTotalUsageLevel()) {
            case 'low':
                return 'from-tkorange-500 to-tkorange-500';
            case 'medium':
                return 'from-tkorange-500 to-yellow-500';
            case 'high':
                return 'from-tkorange-500 to-tkteal-500 via-yellow-500';
        }
    }

    public function setSelectedOperator($operatorId)
    {
        $this->selected_operator = $operatorId;
        $this->save();
        session()->put('selected_operator', $operatorId);
    }

    public function getOrderOperator()
    {
        return $this->selected_operator ? operators()->firstWhere('id', $this->selected_operator) : null;
    }

    public function hasSelectedOperator()
    {
        return $this->selected_operator !== null;
    }

    public function orderInProgress()
    {
        return $this->order_in_progress !== null;
    }

    public function startOrder($operatorId)
    {
        $this->setSelectedOperator($operatorId);
        $this->order_in_progress = true;
        $this->save();
    }

    public function clearOrder()
    {
        $this->order_in_progress = null;
        $this->selected_operator = null;
        session()->forget('selected_operator');
        $this->save();
    }

    public function start()
    {
        $this->offer_ends_at = now()->addMonths(1);
        $this->save();

        event(new CompanyStarted($this));
    }

    public function signedCtaUrl($context = 'update')
    {
        return match ($context) {
            'update' => URL::temporarySignedRoute('cta.update-agreement', now()->addDay(), ['company' => $this]),
            'upload' => URL::temporarySignedRoute('cta.upload-agreement', now()->addDay(), $this),
        };
    }

    public function terminate()
    {
        $this->delete();
    }

    public function delete()
    {
        // Delete relations first
        // Delete Offers
        $this->offers()->delete();
        // Delete orders
        $this->orders()->delete();
        // Delete Subscriptions
        $this->subscriptions()->delete();
        // Delete CompanyUsers
        $this->employees()->delete();

        parent::delete();
    }
}
