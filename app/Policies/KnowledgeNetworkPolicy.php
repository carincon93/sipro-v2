<?php

namespace App\Policies;

use App\Models\KnowledgeNetwork;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KnowledgeNetworkPolicy
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
        if ( $user->hasPermissionTo('knowledge-networks.index') || $user->hasPermissionTo('knowledge-networks.show') || $user->hasPermissionTo('knowledge-networks.create') || $user->hasPermissionTo('knowledge-networks.edit') || $user->hasPermissionTo('knowledge-networks.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return mixed
     */
    public function view(User $user, KnowledgeNetwork $knowledgeNetwork)
    {
        if ( $user->hasPermissionTo('knowledge-networks.show') ) {
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
        if ( $user->hasPermissionTo('knowledge-networks.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return mixed
     */
    public function update(User $user, KnowledgeNetwork $knowledgeNetwork)
    {
        if ( $user->hasPermissionTo('knowledge-networks.show') || $user->hasPermissionTo('knowledge-networks.edit') || $user->hasPermissionTo('knowledge-networks.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return mixed
     */
    public function delete(User $user, KnowledgeNetwork $knowledgeNetwork)
    {
        if ( $user->hasPermissionTo('knowledge-networks.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return mixed
     */
    public function restore(User $user, KnowledgeNetwork $knowledgeNetwork)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return mixed
     */
    public function forceDelete(User $user, KnowledgeNetwork $knowledgeNetwork)
    {
        //
    }
}
