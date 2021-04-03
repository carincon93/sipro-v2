<?php

namespace App\Policies;

use App\Models\DirectEffect;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirectEffectPolicy
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
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.index')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.show')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.create')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.edit')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.delete')
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DirectEffect  $directEffect
     * @return mixed
     */
    public function view(User $user, DirectEffect $directEffect)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.show') ) {
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
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DirectEffect  $directEffect
     * @return mixed
     */
    public function update(User $user, DirectEffect $directEffect)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DirectEffect  $directEffect
     * @return mixed
     */
    public function delete(User $user, DirectEffect $directEffect)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('direct-effects.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DirectEffect  $directEffect
     * @return mixed
     */
    public function restore(User $user, DirectEffect $directEffect)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DirectEffect  $directEffect
     * @return mixed
     */
    public function forceDelete(User $user, DirectEffect $directEffect)
    {
        //
    }
}
