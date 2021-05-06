<?php

namespace App\Policies;

use App\Models\ResearchLine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchLinePolicy
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
        if ( $user->hasPermissionTo('research-lines.index') || $user->hasPermissionTo('research-lines.show') || $user->hasPermissionTo('research-lines.create') || $user->hasPermissionTo('research-lines.edit') || $user->hasPermissionTo('research-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchLine  $researchLine
     * @return mixed
     */
    public function view(User $user, ResearchLine $researchLine)
    {
        if ( $user->hasPermissionTo('research-lines.show') ) {
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
        if ( $user->hasPermissionTo('research-lines.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchLine  $researchLine
     * @return mixed
     */
    public function update(User $user, ResearchLine $researchLine)
    {
        if ( $user->hasPermissionTo('research-lines.show') || $user->hasPermissionTo('research-lines.edit') || $user->hasPermissionTo('research-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchLine  $researchLine
     * @return mixed
     */
    public function delete(User $user, ResearchLine $researchLine)
    {
        if ( $user->hasPermissionTo('research-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchLine  $researchLine
     * @return mixed
     */
    public function restore(User $user, ResearchLine $researchLine)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchLine  $researchLine
     * @return mixed
     */
    public function forceDelete(User $user, ResearchLine $researchLine)
    {
        //
    }
}
