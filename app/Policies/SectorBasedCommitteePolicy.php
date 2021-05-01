<?php

namespace App\Policies;

use App\Models\SectorBasedCommittee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectorBasedCommitteePolicy
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
        if ( $user->hasPermissionTo('sector-based-committees.index') || $user->hasPermissionTo('sector-based-committees.show') || $user->hasPermissionTo('sector-based-committees.create') || $user->hasPermissionTo('sector-based-committees.edit') || $user->hasPermissionTo('sector-based-committees.delete')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return mixed
     */
    public function view(User $user, SectorBasedCommittee $sectorBasedCommittee)
    {
        if ( $user->hasPermissionTo('sector-based-committees.show') ) {
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
        if ( $user->hasPermissionTo('sector-based-committees.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return mixed
     */
    public function update(User $user, SectorBasedCommittee $sectorBasedCommittee)
    {
        if ( $user->hasPermissionTo('sector-based-committees.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return mixed
     */
    public function delete(User $user, SectorBasedCommittee $sectorBasedCommittee)
    {
        if ( $user->hasPermissionTo('sector-based-committees.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return mixed
     */
    public function restore(User $user, SectorBasedCommittee $sectorBasedCommittee)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return mixed
     */
    public function forceDelete(User $user, SectorBasedCommittee $sectorBasedCommittee)
    {
        //
    }
}
