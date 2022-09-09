<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'company-admin']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\Subscription $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Subscription $subscription)
    {
        if ($user->hasRole('company-user')) {
            return $user->company_id === $subscription->company_id;
        }

        return $user->hasAnyRole(['super-admin', 'company-admin']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['company-user', 'company-admin', 'super-admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\Subscription $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Subscription $subscription)
    {
        return $user->hasAnyRole(['company-user', 'company-admin', 'super-admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\Subscription $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Subscription $subscription)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\Subscription $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Subscription $subscription)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\Subscription $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Subscription $subscription)
    {
        //
    }
}
