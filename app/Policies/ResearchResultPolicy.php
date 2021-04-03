<?php

namespace App\Policies;

use App\Models\ResearchResult;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchResultPolicy
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
        if ( $user->hasPermissionTo('research-results.index') || $user->hasPermissionTo('research-results.show') || $user->hasPermissionTo('research-results.create') || $user->hasPermissionTo('research-results.edit') || $user->hasPermissionTo('research-results.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchResult  $researchResult
     * @return mixed
     */
    public function view(User $user, ResearchResult $researchResult)
    {
        if ( $user->hasPermissionTo('research-results.show') ) {
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
        if ( $user->hasPermissionTo('research-results.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchResult  $researchResult
     * @return mixed
     */
    public function update(User $user, ResearchResult $researchResult)
    {
        if ( $user->hasPermissionTo('research-results.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchResult  $researchResult
     * @return mixed
     */
    public function delete(User $user, ResearchResult $researchResult)
    {
        if ( $user->hasPermissionTo('research-results.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchResult  $researchResult
     * @return mixed
     */
    public function restore(User $user, ResearchResult $researchResult)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResearchResult  $researchResult
     * @return mixed
     */
    public function forceDelete(User $user, ResearchResult $researchResult)
    {
        //
    }
}
