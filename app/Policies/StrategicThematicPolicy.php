<?php

namespace App\Policies;

use App\Models\StrategicThematic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StrategicThematicPolicy
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
        if ( $user->hasPermissionTo('strategic-thematics.index') || $user->hasPermissionTo('strategic-thematics.show') || $user->hasPermissionTo('strategic-thematics.create') || $user->hasPermissionTo('strategic-thematics.edit') || $user->hasPermissionTo('strategic-thematics.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return mixed
     */
    public function view(User $user, StrategicThematic $strategicThematic)
    {
        if ( $user->hasPermissionTo('strategic-thematics.show') ) {
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
        if ( $user->hasPermissionTo('strategic-thematics.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return mixed
     */
    public function update(User $user, StrategicThematic $strategicThematic)
    {
        if ( $user->hasPermissionTo('strategic-thematics.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return mixed
     */
    public function delete(User $user, StrategicThematic $strategicThematic)
    {
        if ( $user->hasPermissionTo('strategic-thematics.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return mixed
     */
    public function restore(User $user, StrategicThematic $strategicThematic)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return mixed
     */
    public function forceDelete(User $user, StrategicThematic $strategicThematic)
    {
        //
    }
}
