<?php

namespace App\Policies;

use App\Models\TechnologicalLine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TechnologicalLinePolicy
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
        if ( $user->hasPermissionTo('technological-lines.index') || $user->hasPermissionTo('technological-lines.show') || $user->hasPermissionTo('technological-lines.create') || $user->hasPermissionTo('technological-lines.edit') || $user->hasPermissionTo('technological-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return mixed
     */
    public function view(User $user, TechnologicalLine $technologicalLine)
    {
        if ( $user->hasPermissionTo('technological-lines.show') ) {
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
        if ( $user->hasPermissionTo('technological-lines.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return mixed
     */
    public function update(User $user, TechnologicalLine $technologicalLine)
    {
        if ( $user->hasPermissionTo('technological-lines.show') || $user->hasPermissionTo('technological-lines.edit') || $user->hasPermissionTo('technological-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return mixed
     */
    public function delete(User $user, TechnologicalLine $technologicalLine)
    {
        if ( $user->hasPermissionTo('technological-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return mixed
     */
    public function restore(User $user, TechnologicalLine $technologicalLine)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return mixed
     */
    public function forceDelete(User $user, TechnologicalLine $technologicalLine)
    {
        //
    }
}
