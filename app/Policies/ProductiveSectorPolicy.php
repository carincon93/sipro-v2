<?php

namespace App\Policies;

use App\Models\ProductiveSector;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductiveSectorPolicy
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
        if ( $user->hasPermissionTo('productive-sectors.index') || $user->hasPermissionTo('productive-sectors.show') || $user->hasPermissionTo('productive-sectors.create') || $user->hasPermissionTo('productive-sectors.edit') || $user->hasPermissionTo('productive-sectors.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return mixed
     */
    public function view(User $user, ProductiveSector $productiveSector)
    {
        if ( $user->hasPermissionTo('productive-sectors.show') ) {
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
        if ( $user->hasPermissionTo('productive-sectors.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return mixed
     */
    public function update(User $user, ProductiveSector $productiveSector)
    {
        if ( $user->hasPermissionTo('productive-sectors.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return mixed
     */
    public function delete(User $user, ProductiveSector $productiveSector)
    {
        if ( $user->hasPermissionTo('productive-sectors.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return mixed
     */
    public function restore(User $user, ProductiveSector $productiveSector)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return mixed
     */
    public function forceDelete(User $user, ProductiveSector $productiveSector)
    {
        //
    }
}
