<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
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
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.index')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.show')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.create')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.edit')
            || $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.delete')
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return mixed
     */
    public function view(User $user, Activity $activity)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.show') ) {
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
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return mixed
     */
    public function update(User $user, Activity $activity)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return mixed
     */
    public function delete(User $user, Activity $activity)
    {
        if ( $user->hasPermissionTo('calls.index') && $user->hasPermissionTo('rdi.index') && $user->hasPermissionTo('rdi.edit') && $user->hasPermissionTo('activities.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return mixed
     */
    public function restore(User $user, Activity $activity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return mixed
     */
    public function forceDelete(User $user, Activity $activity)
    {
        //
    }
}
