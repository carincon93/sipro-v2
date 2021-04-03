<?php

namespace App\Policies;

use App\Models\Regional;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionalPolicy
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
        if ( $user->hasPermissionTo('regional.index') || $user->hasPermissionTo('regional.show') || $user->hasPermissionTo('regional.create') || $user->hasPermissionTo('regional.edit') || $user->hasPermissionTo('regional.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regional  $regional
     * @return mixed
     */
    public function view(User $user, Regional $regional)
    {
        if ( $user->hasPermissionTo('regional.show') ) {
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
        if ( $user->hasPermissionTo('regional.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regional  $regional
     * @return mixed
     */
    public function update(User $user, Regional $regional)
    {
        if ( $user->hasPermissionTo('regional.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regional  $regional
     * @return mixed
     */
    public function delete(User $user, Regional $regional)
    {
        if ( $user->hasPermissionTo('regional.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regional  $regional
     * @return mixed
     */
    public function restore(User $user, Regional $regional)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regional  $regional
     * @return mixed
     */
    public function forceDelete(User $user, Regional $regional)
    {
        //
    }
}
