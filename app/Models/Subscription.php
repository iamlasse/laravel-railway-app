<?php

namespace App\Models;

use App\Models\Builders\SubscriptionBuilder;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Query\Builder;

class Subscription extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'type',
        'name',
        'department',
        'numbers',
        'current_plan_id',
        'current_plan_data',
        'current_plan_usage',
        'status',
        'to_be_cancelled',
        'starts_at',
        'ends_at',
        'vaxel_user',
        'company_id',
    ];

    public const STATUS_ACTIVE = 1;
    public const STATUS_EXPIRING = 2;
    public const STATUS_EXPIRED = 3;
    public const STATUS_CANCELLED = 4;
    public const STATUS_INACTIVE = 0;

    public const TYPE_MOBILE = 'M';
    public const TYPE_MOBILE_BB = 'MB';
    public const TYPE_DATAKORT = 'DK';

    protected $casts = [
        'numbers' => 'array',
        'expires_at' => 'date',
        'expired_at' => 'date',
        'cancelled_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'vaxel_user' => 'boolean',
        'to_be_canelled' => 'boolean',
    ];

    public static function getStatuses()
    {
        return [
            '0' => __('telekom.status.inactive'),
            '1' => __('telekom.status.active'),
            '2' => __('telekom.status.expiring'),
            '3' => __('telekom.status.expired'),
            '4' => __('telekom.status.cancelled')
        ];
    }

    public static function getStatusOptions(int $status)
    {
        $statuses = collect(static::getStatuses());
        switch ($status) {
            case 4:
                return $statuses->filter(fn ($s, $k) => $k != 1);
            default:
                return $statuses;
        }
    }

    public function statusText(): Attribute
    {
        return new Attribute(
            fn () => self::getStatuses()[$this->status] ?? __('telekom.status.active'),
        );
    }

    public function usageLevel(): Attribute
    {
        return new Attribute(
            function ($value) {
                if (0 == $this->current_plan_usage) {
                    return 'low';
                }

                $usage = $this->usagePercent;


                if ($usage > 0 && $usage <= 0.25) {
                    return 'low';
                }

                if ($usage > 0.25 && $usage <= 0.5) {
                    return 'medium';
                }
                if ($usage >= 0.51 && $usage <= 1) {
                    return 'high';
                }

                if ($usage >= 1) {
                    return 'over';
                }

                return 'low';
            }
        );
    }

    public function usagePercent(): Attribute
    {
        return new Attribute(
            function () {
                if($this->current_plan_usage == 0 || $this->current_plan_data == 0 || $this->type == 'DK') {
                    return 0;
                }

                return $this->current_plan_usage / ($this->current_plan_data * 1000) ;
            }
        );
    }

    public function usageText(): Attribute
    {
        $gbUsage =  toGB($this->current_plan_usage);
        $precision = preg_match("/.*\./", $gbUsage) === 0 
        ? 0 
        : match(strlen(preg_replace("/.*\./", "", $gbUsage))) {
            1 => 0,
            2, 3 => 2,
            default => 1
        };
        
        return new Attribute(
            fn () => __('telekom.using') . ' ' . round($gbUsage, $precision) . ' GB ' . __('telekom.of') . ' ' . $this->current_plan_data . ' GB'
        );
    }

    public function usageLeveltext(): Attribute
    {
        return new Attribute(
            fn () => __('telekom.usage_level.' . $this->usage_level)
        );
    }

    public function getClasses($context = 'usage'): array
    {
        $color = 'gray';
        $method = 'getColor' . Str::camel($context);
        $color = $this->$method();
        if ($color == 'blue') {
            return [
                'label' => "text-white bg-tkblue-200",
                'text' => "text-tk{$color}-900",
                'dot' => "bg-tkteal-500",
            ];
        }
        return [
            'label' => "text-{$color}-900 bg-{$color}-300",
            'text' => "text-{$color}-900",
            'dot' => "bg-{$color}-900",
        ];
    }

    protected function getColorUsage()
    {
        return [
            'low' => 'tkorange',
            'medium' => 'tkteal',
            'high' => 'blue',
            'over' => 'red',
        ][$this->usage_level] ?? 'low';
    }

    protected function getColorStatus()
    {
        return [
            self::STATUS_INACTIVE => 'gray',
            self::STATUS_ACTIVE => 'blue',
            // self::STATUS_EXPIRING => 'yellow',
            // self::STATUS_EXPIRED => 'gray',
            // self::STATUS_CANCELLED => 'red',
        ][$this->status] ?? 'gray';
    }

    public function operator(): Attribute
    {
        return new Attribute(
            fn () => operators()->where('code', $this->operator_id)->first()
        );
    }

    public function phoneNumbers(): Attribute
    {
        return new Attribute(
            fn () =>  collect($this->numbers)->each(fn ($number) => $this->formatPhoneNumber($number))->join(' / ')
        );
    }

    protected function formatPhoneNumber(string $number = null)
    {
        return Str::of($number)->split('/[\s,]+/');
    }

    public function numberText(): Attribute
    {
        return new Attribute(
            function ($value) {
                if (!$this->current_plan_id && $this->isActive() && $this->type === self::TYPE_MOBILE) {
                    return 'Nytt nummer';
                }

                return $this->phone_numbers;
            }
        );
    }

    public function isVaxelUser()
    {
        if ($this->isDirty('vaxel_user')) {
            return $this->getOriginal('vaxel_user');
        }
        return $this->vaxel_user;
    }

    public function isExpired()
    {
        return $this->status === self::STATUS_EXPIRED && !is_null($this->expired_at);
    }

    public function isExpiring()
    {
        return $this->status === self::STATUS_EXPIRING;
    }

    public function shouldBeCancelled()
    {
        return boolval($this->to_be_cancelled);
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED && !is_null($this->cancelled_at);
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'current_plan_id');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_subscription', 'subscription_id', 'plan_id')
            ->using(PlanSubscription::class)
            ->withPivot('operator_id', 'vaxel_plan_id');
    }

    public function dataPlans()
    {
        return $this->plans()->wherePivotNull('vaxel_plan_id');
    }

    public function vaxelPlans()
    {
        return $this->plans()->wherePivotNotNull('vaxel_plan_id');
    }

    /**
     * Get the current_plan that owns the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentPlan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'current_plan_id');
    }

    public function getPlan($operatorId = null)
    {
        $this->loadMissing('currentPlan');
        if (is_null($operatorId) || $operatorId == $this->currentPlan->operator_id) {
            return $this->currentPlan;
        }

        return $this->plans()->wherePivot('operator_id', $operatorId)->sole();
    }


    public function cancel()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->to_be_cancelled = true;
        $this->plans()->detach();
        $this->save();
    }

    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->to_be_cancelled = false;
        $this->save();
    }


    public function setExpiring(Carbon $date)
    {
        $this->expires_at = $date;
        $this->status = self::STATUS_EXPIRING;
        $this->save();
    }

    /**
     * New Subscription Builder
     *
     * @param  Builder $query The query
     * @return SubscriptionBuilder
     */
    public function newEloquentBuilder($query): SubscriptionBuilder
    {
        return new SubscriptionBuilder($query);
    }

    public function delete()
    {
        // delete relations
        $this->plans()->detach();

        parent::delete();
    }
}
