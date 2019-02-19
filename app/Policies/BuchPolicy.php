<?php

namespace App\Policies;

use App\User;
use App\Buch;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the buch.
     *
     * @param  \App\User  $user
     * @param  \App\Buch  $buch
     * @return mixed
     */
    public function view(User $user, Buch $buch)
    {
        return true;
    }

    /**
     * Determine whether the user can create buches.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the buch.
     *
     * @param  \App\User  $user
     * @param  \App\Buch  $buch
     * @return mixed
     */
    public function update(User $user, Buch $buch)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the buch.
     *
     * @param  \App\User  $user
     * @param  \App\Buch  $buch
     * @return mixed
     */
    public function delete(User $user, Buch $buch)
    {
        if($buch->ausleiher != null) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can restore the buch.
     *
     * @param  \App\User  $user
     * @param  \App\Buch  $buch
     * @return mixed
     */
    public function restore(User $user, Buch $buch)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the buch.
     *
     * @param  \App\User  $user
     * @param  \App\Buch  $buch
     * @return mixed
     */
    public function forceDelete(User $user, Buch $buch)
    {
        //
    }
}
