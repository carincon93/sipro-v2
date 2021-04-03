<?php

namespace App\Policies;

use App\Models\KnowledgeArea;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KnowledgeAreaPolicy
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
        if ( $user->hasPermissionTo('knowledge-areas.index') || $user->hasPermissionTo('knowledge-areas.show') || $user->hasPermissionTo('knowledge-areas.create') || $user->hasPermissionTo('knowledge-areas.edit') || $user->hasPermissionTo('knowledge-areas.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return mixed
     */
    public function view(User $user, KnowledgeArea $knowledgeArea)
    {
        if ( $user->hasPermissionTo('knowledge-areas.show') ) {
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
        if ( $user->hasPermissionTo('knowledge-areas.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return mixed
     */
    public function update(User $user, KnowledgeArea $knowledgeArea)
    {
        if ( $user->hasPermissionTo('knowledge-areas.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return mixed
     */
    public function delete(User $user, KnowledgeArea $knowledgeArea)
    {
        if ( $user->hasPermissionTo('knowledge-areas.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return mixed
     */
    public function restore(User $user, KnowledgeArea $knowledgeArea)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return mixed
     */
    public function forceDelete(User $user, KnowledgeArea $knowledgeArea)
    {
        //
    }
}
