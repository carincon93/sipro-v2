<?php

namespace App\Policies;

use App\Models\ResearchGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchGroupPolicy
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
        if ( $user->hasPermissionTo('research-groups.index') || $user->hasPermissionTo('research-groups.show') || $user->hasPermissionTo('research-groups.create') || $user->hasPermissionTo('research-groups.edit') || $user->hasPermissionTo('research-groups.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return mixed
     */
    public function view(User $user, ResearchGroup $researchGroup)
    {
        if ( $user->hasPermissionTo('research-groups.show') ) {
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
        if ( $user->hasPermissionTo('research-groups.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return mixed
     */
    public function update(User $user, ResearchGroup $researchGroup)
    {
        if ( $user->hasPermissionTo('research-groups.show') || $user->hasPermissionTo('research-groups.edit') || $user->hasPermissionTo('research-groups.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return mixed
     */
    public function delete(User $user, ResearchGroup $researchGroup)
    {
        if ( $user->hasPermissionTo('research-groups.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return mixed
     */
    public function restore(User $user, ResearchGroup $researchGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return mixed
     */
    public function forceDelete(User $user, ResearchGroup $researchGroup)
    {
        //
    }
}
