<?php

namespace App\Policies;

use App\Models\Annexe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnexePolicy
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
        if ( $user->hasPermissionTo('annexes.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Annexe  $annexe
     * @return mixed
     */
    public function view(User $user, Annexe $annexe)
    {
        if ( $user->hasPermissionTo('annexes.show') ) {
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
        if ( $user->hasPermissionTo('annexes.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Annexe  $annexe
     * @return mixed
     */
    public function update(User $user, Annexe $annexe)
    {
        if ( $user->hasPermissionTo('annexes.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Annexe  $annexe
     * @return mixed
     */
    public function delete(User $user, Annexe $annexe)
    {
        if ( $user->hasPermissionTo('annexes.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Annexe  $annexe
     * @return mixed
     */
    public function restore(User $user, Annexe $annexe)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Annexe  $annexe
     * @return mixed
     */
    public function forceDelete(User $user, Annexe $annexe)
    {
        //
    }
}
