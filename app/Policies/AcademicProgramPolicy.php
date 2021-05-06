<?php

namespace App\Policies;

use App\Models\AcademicProgram;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicProgramPolicy
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
        if ( $user->hasPermissionTo('academic-programs.index') || $user->hasPermissionTo('academic-programs.show') || $user->hasPermissionTo('academic-programs.create') || $user->hasPermissionTo('academic-programs.edit') || $user->hasPermissionTo('academic-programs.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return mixed
     */
    public function view(User $user, AcademicProgram $academicProgram)
    {
        if ( $user->hasPermissionTo('academic-programs.show') ) {
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
        if ( $user->hasPermissionTo('academic-programs.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return mixed
     */
    public function update(User $user, AcademicProgram $academicProgram)
    {
        if ( $user->hasPermissionTo('academic-programs.show') || $user->hasPermissionTo('academic-programs.edit') || $user->hasPermissionTo('academic-programs.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return mixed
     */
    public function delete(User $user, AcademicProgram $academicProgram)
    {
        if ( $user->hasPermissionTo('academic-programs.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return mixed
     */
    public function restore(User $user, AcademicProgram $academicProgram)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return mixed
     */
    public function forceDelete(User $user, AcademicProgram $academicProgram)
    {
        //
    }
}
