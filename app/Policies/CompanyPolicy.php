<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
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
        return $user->hasAnyRole(['super-admin', 'company-admin']) || $user->hasPermissionTo('view-companies');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Company $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Company $company)
    {
        return ($user->company_id === $company->id && $user->hasPermissionTo('view-company')) || ($user->hasAnyRole(['super-admin', 'company-admin']));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'company-admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Company $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Company $company)
    {
        return ($user->company_id === $company->id && $user->hasRole('company-user')) || ($user->hasAnyRole(['super-admin', 'company-admin']));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Company $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Company $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Company $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }
}
