<?php

namespace App\Policies;

use App\Models\EconomicActivity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EconomicActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ( $user->hasPermissionTo('economic-activities.index') || $user->hasPermissionTo('economic-activities.show') || $user->hasPermissionTo('economic-activities.create') || $user->hasPermissionTo('economic-activities.edit') || $user->hasPermissionTo('economic-activities.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return mixed
     */
    public function view(User $user, EconomicActivity $economicActivity)
    {
        if ( $user->hasPermissionTo('economic-activities.show') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ( $user->hasPermissionTo('economic-activities.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return mixed
     */
    public function update(User $user, EconomicActivity $economicActivity)
    {
        if ( $user->hasPermissionTo('economic-activities.show') || $user->hasPermissionTo('economic-activities.edit') || $user->hasPermissionTo('economic-activities.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return mixed
     */
    public function delete(User $user, EconomicActivity $economicActivity)
    {
        if ( $user->hasPermissionTo('economic-activities.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return mixed
     */
    public function restore(User $user, EconomicActivity $economicActivity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return mixed
     */
    public function forceDelete(User $user, EconomicActivity $economicActivity)
    {
        //
    }
}
