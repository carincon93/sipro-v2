<?php

namespace App\Policies;

use App\Models\AcademicCentre;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicCentrePolicy
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
        if ( $user->hasPermissionTo('academic-centres.index') || $user->hasPermissionTo('academic-centres.show') || $user->hasPermissionTo('academic-centres.create') || $user->hasPermissionTo('academic-centres.edit') || $user->hasPermissionTo('academic-centres.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return mixed
     */
    public function view(User $user, AcademicCentre $academicCentre)
    {
        if ( $user->hasPermissionTo('academic-centres.show') ) {
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
        if ( $user->hasPermissionTo('academic-centres.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return mixed
     */
    public function update(User $user, AcademicCentre $academicCentre)
    {
        if ( $user->hasPermissionTo('academic-centres.show') || $user->hasPermissionTo('academic-centres.edit') || $user->hasPermissionTo('academic-centres.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return mixed
     */
    public function delete(User $user, AcademicCentre $academicCentre)
    {
        if ( $user->hasPermissionTo('academic-centres.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return mixed
     */
    public function restore(User $user, AcademicCentre $academicCentre)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return mixed
     */
    public function forceDelete(User $user, AcademicCentre $academicCentre)
    {
        //
    }
}
