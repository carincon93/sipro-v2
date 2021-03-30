<?php

namespace App\Policies;

use App\Models\BudgetProgrammaticLine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetProgrammaticLinePolicy
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
        if ( $user->hasPermissionTo('budget-programmatic-lines.index') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return mixed
     */
    public function view(User $user, BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        if ( $user->hasPermissionTo('budget-programmatic-lines.show') ) {
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
        if ( $user->hasPermissionTo('budget-programmatic-lines.create') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return mixed
     */
    public function update(User $user, BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        if ( $user->hasPermissionTo('budget-programmatic-lines.edit') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return mixed
     */
    public function delete(User $user, BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        if ( $user->hasPermissionTo('budget-programmatic-lines.delete') ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return mixed
     */
    public function restore(User $user, BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return mixed
     */
    public function forceDelete(User $user, BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        //
    }
}
