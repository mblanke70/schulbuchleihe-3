<?php

namespace App\Policies;

use App\User;
use App\Schuljahr;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchuljahrPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the schuljahr.
     *
     * @param  \App\User  $user
     * @param  \App\Schuljahr  $schuljahr
     * @return mixed
     */
    public function view(User $user, Schuljahr $schuljahr)
    {
        return true;
    }

    /**
     * Determine whether the user can create schuljahrs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the schuljahr.
     *
     * @param  \App\User  $user
     * @param  \App\Schuljahr  $schuljahr
     * @return mixed
     */
    public function update(User $user, Schuljahr $schuljahr)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the schuljahr.
     *
     * @param  \App\User  $user
     * @param  \App\Schuljahr  $schuljahr
     * @return mixed
     */
    public function delete(User $user, Schuljahr $schuljahr)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the schuljahr.
     *
     * @param  \App\User  $user
     * @param  \App\Schuljahr  $schuljahr
     * @return mixed
     */
    public function restore(User $user, Schuljahr $schuljahr)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the schuljahr.
     *
     * @param  \App\User  $user
     * @param  \App\Schuljahr  $schuljahr
     * @return mixed
     */
    public function forceDelete(User $user, Schuljahr $schuljahr)
    {
        //
    }
}
