<?php

namespace App\Policies;

use App\Models\RDIOutput;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RDIOutputPolicy
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
        if ( $user->hasPermissionTo('rdi-outputs.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return mixed
     */
    public function view(User $user, RDIOutput $rdiOutput)
    {
        if ( $user->hasPermissionTo('rdi-outputs.show') ) {
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
        if ( $user->hasPermissionTo('rdi-outputs.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return mixed
     */
    public function update(User $user, RDIOutput $rdiOutput)
    {
        if ( $user->hasPermissionTo('rdi-outputs.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return mixed
     */
    public function delete(User $user, RDIOutput $rdiOutput)
    {
        if ( $user->hasPermissionTo('rdi-outputs.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return mixed
     */
    public function restore(User $user, RDIOutput $rdiOutput)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return mixed
     */
    public function forceDelete(User $user, RDIOutput $rdiOutput)
    {
        //
    }
}
