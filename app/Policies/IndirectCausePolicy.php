<?php

namespace App\Policies;

use App\Models\IndirectCause;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndirectCausePolicy
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
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.index')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.show')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.create')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.edit')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.delete')
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return mixed
     */
    public function view(User $user, IndirectCause $indirectCause)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.show') ) {
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
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return mixed
     */
    public function update(User $user, IndirectCause $indirectCause)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return mixed
     */
    public function delete(User $user, IndirectCause $indirectCause)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('indirect-causes.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return mixed
     */
    public function restore(User $user, IndirectCause $indirectCause)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return mixed
     */
    public function forceDelete(User $user, IndirectCause $indirectCause)
    {
        //
    }
}
