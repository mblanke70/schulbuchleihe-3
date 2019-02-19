<?php

namespace App\Policies;

use App\User;
use App\Schueler;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchuelerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the schueler.
     *
     * @param  \App\User  $user
     * @param  \App\Schueler  $schueler
     * @return mixed
     */
    public function view(User $user, Schueler $schueler)
    {
        return true;
    }

    /**
     * Determine whether the user can create schuelers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the schueler.
     *
     * @param  \App\User  $user
     * @param  \App\Schueler  $schueler
     * @return mixed
     */
    public function update(User $user, Schueler $schueler)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the schueler.
     *
     * @param  \App\User  $user
     * @param  \App\Schueler  $schueler
     * @return mixed
     */
    public function delete(User $user, Schueler $schueler)
    {
        if($schueler->buecher()->count() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can restore the schueler.
     *
     * @param  \App\User  $user
     * @param  \App\Schueler  $schueler
     * @return mixed
     */
    public function restore(User $user, Schueler $schueler)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the schueler.
     *
     * @param  \App\User  $user
     * @param  \App\Schueler  $schueler
     * @return mixed
     */
    public function forceDelete(User $user, Schueler $schueler)
    {
        //
    }
}
