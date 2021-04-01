<?php

namespace App\Policies;

use App\Models\RDI;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RDIPolicy
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
        if ( $user->hasPermissionTo('rdi.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDI  $rdi
     * @return mixed
     */
    public function view(User $user, RDI $rdi)
    {
        if ( $user->hasPermissionTo('rdi.show') ) {
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
        if ( $user->hasPermissionTo('rdi.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDI  $rdi
     * @return mixed
     */
    public function update(User $user, RDI $rdi)
    {
        if ( $user->hasPermissionTo('rdi.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDI  $rdi
     * @return mixed
     */
    public function delete(User $user, RDI $rdi)
    {
        if ( $user->hasPermissionTo('rdi.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDI  $rdi
     * @return mixed
     */
    public function restore(User $user, RDI $rdi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDI  $rdi
     * @return mixed
     */
    public function forceDelete(User $user, RDI $rdi)
    {
        //
    }
}