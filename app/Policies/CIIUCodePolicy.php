<?php

namespace App\Policies;

use App\Models\CIIUCode;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CIIUCodePolicy
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
        if ( $user->hasPermissionTo('ciiu-codes.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return mixed
     */
    public function view(User $user, CIIUCode $ciiuCode)
    {
        if ( $user->hasPermissionTo('ciiu-codes.show') ) {
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
        if ( $user->hasPermissionTo('ciiu-codes.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return mixed
     */
    public function update(User $user, CIIUCode $ciiuCode)
    {
        if ( $user->hasPermissionTo('ciiu-codes.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return mixed
     */
    public function delete(User $user, CIIUCode $ciiuCode)
    {
        if ( $user->hasPermissionTo('ciiu-codes.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return mixed
     */
    public function restore(User $user, CIIUCode $ciiuCode)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return mixed
     */
    public function forceDelete(User $user, CIIUCode $ciiuCode)
    {
        //
    }
}
