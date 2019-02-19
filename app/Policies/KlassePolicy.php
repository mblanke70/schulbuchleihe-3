<?php

namespace App\Policies;

use App\User;
use App\Klasse;
use Illuminate\Auth\Access\HandlesAuthorization;

class KlassePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the klasse.
     *
     * @param  \App\User  $user
     * @param  \App\Klasse  $klasse
     * @return mixed
     */
    public function view(User $user, Klasse $klasse)
    {
        return true;
    }

    /**
     * Determine whether the user can create klasses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the klasse.
     *
     * @param  \App\User  $user
     * @param  \App\Klasse  $klasse
     * @return mixed
     */
    public function update(User $user, Klasse $klasse)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the klasse.
     *
     * @param  \App\User  $user
     * @param  \App\Klasse  $klasse
     * @return mixed
     */
    public function delete(User $user, Klasse $klasse)
    {
        if($klasse->schueler()->count() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can restore the klasse.
     *
     * @param  \App\User  $user
     * @param  \App\Klasse  $klasse
     * @return mixed
     */
    public function restore(User $user, Klasse $klasse)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the klasse.
     *
     * @param  \App\User  $user
     * @param  \App\Klasse  $klasse
     * @return mixed
     */
    public function forceDelete(User $user, Klasse $klasse)
    {
        //
    }
}
