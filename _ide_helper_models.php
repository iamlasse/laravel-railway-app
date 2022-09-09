<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $gatunamn
 * @property string|null $postnr
 * @property string|null $postort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\AddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereGatunamn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostnr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string $type
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @property-read string $guard_name
 * @property-read int $login_route_expires_in
 * @property-read bool $login_use_once
 * @property-read string $profile_photo_url
 * @property-read string $redirect_url
 * @property-read bool $should_remember_login
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin active()
 * @method static \Database\Factories\AdminFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $reg_nr
 * @property int|null $contact_id
 * @property string|null $phone
 * @property int|null $rep_id
 * @property int $current_monthly_cost
 * @property int $current_monthly_flex_cost
 * @property int $over_paying
 * @property int|null $selected_operator
 * @property int|null $order_in_progress
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $extra
 * @property \Illuminate\Support\Carbon|null $period_starts_at
 * @property \Illuminate\Support\Carbon|null $period_ends_at
 * @property \Illuminate\Support\Carbon|null $offer_ends_at
 * @property string|null $offer_expired_at
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\CompanyUser|null $contact
 * @property-read \App\Models\Offer|null $currentOffer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyUser[] $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\Order|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Admin|null $rep
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCurrentMonthlyCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCurrentMonthlyFlexCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOfferEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOfferExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOrderInProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOverPaying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePeriodEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePeriodStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereRegNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereRepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSelectedOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CompanyUser
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string $type
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @property-read \App\Models\Company|null $company
 * @property-read string $guard_name
 * @property-read int $login_route_expires_in
 * @property-read bool $login_use_once
 * @property-read string $profile_photo_url
 * @property-read string $redirect_url
 * @property-read bool $should_remember_login
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\CompanyUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereUsername($value)
 */
	class CompanyUser extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\Offer
 *
 * @property int $id
 * @property int $operator_id
 * @property bool|null $is_current_vaxel
 * @property bool|null $is_current_operator
 * @property bool|null $is_recommended
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Plan[] $plans
 * @property-read int|null $plans_count
 * @method static \Database\Factories\OfferFactory factory(...$parameters)
 * @method static \App\Models\Builders\OfferBuilder|Offer newModelQuery()
 * @method static \App\Models\Builders\OfferBuilder|Offer newQuery()
 * @method static \App\Models\Builders\OfferBuilder|Offer query()
 * @method static \App\Models\Builders\OfferBuilder|Offer whereCompanyId($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereCreatedAt($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereDeletedAt($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereId($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereIsCurrentOperator($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereIsCurrentVaxel($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereIsRecommended($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereOperatorId($value)
 * @method static \App\Models\Builders\OfferBuilder|Offer whereUpdatedAt($value)
 */
	class Offer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $company_id
 * @property array|null $order_data
 * @property int $total
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Plan
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $operator_id
 * @property int $price
 * @property int $data
 * @property int $is_vaxel_plan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Database\Factories\PlanFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIsVaxelPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PlanOffer
 *
 * @property int $id
 * @property int $offer_id
 * @property int $plan_id
 * @property int|null $price_org
 * @property int|null $price_new
 * @property-read mixed $data
 * @property-read mixed $price
 * @property-read \App\Models\Offer $offer
 * @property-read \App\Models\Plan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer wherePriceNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanOffer wherePriceOrg($value)
 */
	class PlanOffer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PlanSubscription
 *
 * @property int $id
 * @property int $subscription_id
 * @property int|null $plan_id
 * @property int|null $vaxel_plan_id
 * @property int $operator_id
 * @property-read \App\Models\Plan|null $plan
 * @property-read \App\Models\Subscription $subscription
 * @property-read \App\Models\Plan|null $vaxelPlan
 * @method static \Database\Factories\PlanSubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereVaxelPlanId($value)
 */
	class PlanSubscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property array|null $numbers
 * @property string $name
 * @property string|null $department
 * @property int|null $current_plan_id
 * @property int $current_plan_usage
 * @property int $current_plan_data
 * @property int $company_id
 * @property int $status
 * @property int $to_be_cancelled
 * @property bool $vaxel_user
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Plan|null $currentPlan
 * @property-read \App\Models\Offer $offer
 * @property-read \App\Models\Plan|null $plan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Plan[] $plans
 * @property-read int|null $plans_count
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription active()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription cancelled()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription expired()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription expiring()
 * @method static \Database\Factories\SubscriptionFactory factory(...$parameters)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription forCompany(int $companyId)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription newModelQuery()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription newQuery()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription operatorPlans(int $operatorId)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription query()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereCompanyId($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereCreatedAt($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereCurrentPlanData($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereCurrentPlanId($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereCurrentPlanUsage($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereDeletedAt($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereDepartment($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereEndsAt($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereId($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereName($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereNumbers($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereStartsAt($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereStatus($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereToBeCancelled($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereType($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereUpdatedAt($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription whereVaxelUser($value)
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription withPlan()
 * @method static \App\Models\Builders\SubscriptionBuilder|Subscription withUsage()
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SuperAdmin
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string $type
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @property-read string $guard_name
 * @property-read int $login_route_expires_in
 * @property-read bool $login_use_once
 * @property-read string $profile_photo_url
 * @property-read string $redirect_url
 * @property-read bool $should_remember_login
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\SuperAdminFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereUsername($value)
 */
	class SuperAdmin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string $type
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @property-read string $guard_name
 * @property-read int $login_route_expires_in
 * @property-read bool $login_use_once
 * @property-read string $profile_photo_url
 * @property-read string $redirect_url
 * @property-read bool $should_remember_login
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

