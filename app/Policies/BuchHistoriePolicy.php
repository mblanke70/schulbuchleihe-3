<?php

namespace App\Policies;

use App\User;
use App\BuchHistorie;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuchHistoriePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the buch historie.
     *
     * @param  \App\User  $user
     * @param  \App\BuchHistorie  $buchHistorie
     * @return mixed
     */
    public function view(User $user, BuchHistorie $buchHistorie)
    {
        return true;
    }

    /**
     * Determine whether the user can create buch histories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the buch historie.
     *
     * @param  \App\User  $user
     * @param  \App\BuchHistorie  $buchHistorie
     * @return mixed
     */
    public function update(User $user, BuchHistorie $buchHistorie)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the buch historie.
     *
     * @param  \App\User  $user
     * @param  \App\BuchHistorie  $buchHistorie
     * @return mixed
     */
    public function delete(User $user, BuchHistorie $buchHistorie)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the buch historie.
     *
     * @param  \App\User  $user
     * @param  \App\BuchHistorie  $buchHistorie
     * @return mixed
     */
    public function restore(User $user, BuchHistorie $buchHistorie)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the buch historie.
     *
     * @param  \App\User  $user
     * @param  \App\BuchHistorie  $buchHistorie
     * @return mixed
     */
    public function forceDelete(User $user, BuchHistorie $buchHistorie)
    {
        return false;
    }
}
