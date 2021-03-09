<?php

namespace App\Policies;

use App\Models\PrioritizedTopic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrioritizedTopicPolicy
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
        if ( $user->hasPermissionTo('prioritized-topics.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return mixed
     */
    public function view(User $user, PrioritizedTopic $prioritizedTopic)
    {
        if ( $user->hasPermissionTo('prioritized-topics.show') ) {
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
        if ( $user->hasPermissionTo('prioritized-topics.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return mixed
     */
    public function update(User $user, PrioritizedTopic $prioritizedTopic)
    {
        if ( $user->hasPermissionTo('prioritized-topics.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return mixed
     */
    public function delete(User $user, PrioritizedTopic $prioritizedTopic)
    {
        if ( $user->hasPermissionTo('prioritized-topics.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return mixed
     */
    public function restore(User $user, PrioritizedTopic $prioritizedTopic)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return mixed
     */
    public function forceDelete(User $user, PrioritizedTopic $prioritizedTopic)
    {
        //
    }
}
