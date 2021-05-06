<?php

namespace App\Policies;

use App\Models\ResearchTeam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchTeamPolicy
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
        if ( $user->hasPermissionTo('research-teams.index') || $user->hasPermissionTo('research-teams.show') || $user->hasPermissionTo('research-teams.create') || $user->hasPermissionTo('research-teams.edit') || $user->hasPermissionTo('research-teams.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return mixed
     */
    public function view(User $user, ResearchTeam $researchTeam)
    {
        if ( $user->hasPermissionTo('research-teams.show') ) {
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
        if ( $user->hasPermissionTo('research-teams.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return mixed
     */
    public function update(User $user, ResearchTeam $researchTeam)
    {
        if ( $user->hasPermissionTo('research-teams.show') || $user->hasPermissionTo('research-teams.edit') || $user->hasPermissionTo('research-teams.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return mixed
     */
    public function delete(User $user, ResearchTeam $researchTeam)
    {
        if ( $user->hasPermissionTo('research-teams.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return mixed
     */
    public function restore(User $user, ResearchTeam $researchTeam)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return mixed
     */
    public function forceDelete(User $user, ResearchTeam $researchTeam)
    {
        //
    }
}
