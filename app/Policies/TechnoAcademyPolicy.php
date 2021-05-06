<?php

namespace App\Policies;

use App\Models\TechnoAcademy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TechnoAcademyPolicy
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
        if ( $user->hasPermissionTo('techno-academies.index') || $user->hasPermissionTo('techno-academies.show') || $user->hasPermissionTo('techno-academies.create') || $user->hasPermissionTo('techno-academies.edit') || $user->hasPermissionTo('techno-academies.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return mixed
     */
    public function view(User $user, TechnoAcademy $technoAcademy)
    {
        if ( $user->hasPermissionTo('techno-academies.show') ) {
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
        if ( $user->hasPermissionTo('techno-academies.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return mixed
     */
    public function update(User $user, TechnoAcademy $technoAcademy)
    {
        if ( $user->hasPermissionTo('techno-academies.show') || $user->hasPermissionTo('techno-academies.edit') || $user->hasPermissionTo('techno-academies.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return mixed
     */
    public function delete(User $user, TechnoAcademy $technoAcademy)
    {
        if ( $user->hasPermissionTo('techno-academies.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return mixed
     */
    public function restore(User $user, TechnoAcademy $technoAcademy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return mixed
     */
    public function forceDelete(User $user, TechnoAcademy $technoAcademy)
    {
        //
    }
}
