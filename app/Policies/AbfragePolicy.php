<?php

namespace App\Policies;

use App\User;
use App\Abfrage;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbfragePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the abfrage.
     *
     * @param  \App\User  $user
     * @param  \App\Abfrage  $abfrage
     * @return mixed
     */
    public function view(User $user, Abfrage $abfrage)
    {
        return true;
    }

    /**
     * Determine whether the user can create abfragen.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the abfrage.
     *
     * @param  \App\User  $user
     * @param  \App\Abfrage  $abfrage
     * @return mixed
     */
    public function update(User $user, Abfrage $abfrage)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the abfrage.
     *
     * @param  \App\User  $user
     * @param  \App\Abfrage  $abfrage
     * @return mixed
     */
    public function delete(User $user, Abfrage $abfrage)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the abfrage.
     *
     * @param  \App\User  $user
     * @param  \App\Abfrage  $abfrage
     * @return mixed
     */
    public function restore(User $user, Abfrage $abfrage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the abfrage.
     *
     * @param  \App\User  $user
     * @param  \App\Abfrage  $abfrage
     * @return mixed
     */
    public function forceDelete(User $user, Abfrage $abfrage)
    {
        //
    }
}
