<?php

namespace App\Policies;

use App\User;
use App\Jahrgang;
use Illuminate\Auth\Access\HandlesAuthorization;

class JahrgangPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the jahrgang.
     *
     * @param  \App\User  $user
     * @param  \App\Jahrgang  $jahrgang
     * @return mixed
     */
    public function view(User $user, Jahrgang $jahrgang)
    {
        return true;
    }

    /**
     * Determine whether the user can create jahrgangs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the jahrgang.
     *
     * @param  \App\User  $user
     * @param  \App\Jahrgang  $jahrgang
     * @return mixed
     */
    public function update(User $user, Jahrgang $jahrgang)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the jahrgang.
     *
     * @param  \App\User  $user
     * @param  \App\Jahrgang  $jahrgang
     * @return mixed
     */
    public function delete(User $user, Jahrgang $jahrgang)
    {
         if($jahrgang->klassen()->count() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can restore the jahrgang.
     *
     * @param  \App\User  $user
     * @param  \App\Jahrgang  $jahrgang
     * @return mixed
     */
    public function restore(User $user, Jahrgang $jahrgang)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the jahrgang.
     *
     * @param  \App\User  $user
     * @param  \App\Jahrgang  $jahrgang
     * @return mixed
     */
    public function forceDelete(User $user, Jahrgang $jahrgang)
    {
        //
    }
}
