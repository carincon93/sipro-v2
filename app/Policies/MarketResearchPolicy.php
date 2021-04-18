<?php

namespace App\Policies;

use App\Models\MarketResearch;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarketResearchPolicy
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
        if ( $user->hasPermissionTo('market-research.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return mixed
     */
    public function view(User $user, MarketResearch $marketResearch)
    {
        if ( $user->hasPermissionTo('market-research.show') ) {
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
        if ( $user->hasPermissionTo('market-research.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return mixed
     */
    public function update(User $user, MarketResearch $marketResearch)
    {
        if ( $user->hasPermissionTo('market-research.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return mixed
     */
    public function delete(User $user, MarketResearch $marketResearch)
    {
        if ( $user->hasPermissionTo('market-research.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return mixed
     */
    public function restore(User $user, MarketResearch $marketResearch)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return mixed
     */
    public function forceDelete(User $user, MarketResearch $marketResearch)
    {
        //
    }
}
