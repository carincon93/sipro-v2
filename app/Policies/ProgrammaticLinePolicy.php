<?php

namespace App\Policies;

use App\Models\ProgrammaticLine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgrammaticLinePolicy
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
        if ( $user->hasPermissionTo('programmatic-lines.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return mixed
     */
    public function view(User $user, ProgrammaticLine $programmaticLine)
    {
        if ( $user->hasPermissionTo('programmatic-lines.show') ) {
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
        if ( $user->hasPermissionTo('programmatic-lines.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return mixed
     */
    public function update(User $user, ProgrammaticLine $programmaticLine)
    {
        if ( $user->hasPermissionTo('programmatic-lines.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return mixed
     */
    public function delete(User $user, ProgrammaticLine $programmaticLine)
    {
        if ( $user->hasPermissionTo('programmatic-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return mixed
     */
    public function restore(User $user, ProgrammaticLine $programmaticLine)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return mixed
     */
    public function forceDelete(User $user, ProgrammaticLine $programmaticLine)
    {
        //
    }
}
