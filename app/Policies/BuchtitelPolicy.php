<?php

namespace App\Policies;

use App\User;
use App\Buchtitel;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuchtitelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the buchtitel.
     *
     * @param  \App\User  $user
     * @param  \App\Buchtitel  $buchtitel
     * @return mixed
     */
    public function view(User $user, Buchtitel $buchtitel)
    {
        return true;
    }

    /**
     * Determine whether the user can create buchtitels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the buchtitel.
     *
     * @param  \App\User  $user
     * @param  \App\Buchtitel  $buchtitel
     * @return mixed
     */
    public function update(User $user, Buchtitel $buchtitel)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the buchtitel.
     *
     * @param  \App\User  $user
     * @param  \App\Buchtitel  $buchtitel
     * @return mixed
     */
    public function delete(User $user, Buchtitel $buchtitel)
    {
        if($buchtitel->buecher()->count() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can restore the buchtitel.
     *
     * @param  \App\User  $user
     * @param  \App\Buchtitel  $buchtitel
     * @return mixed
     */
    public function restore(User $user, Buchtitel $buchtitel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the buchtitel.
     *
     * @param  \App\User  $user
     * @param  \App\Buchtitel  $buchtitel
     * @return mixed
     */
    public function forceDelete(User $user, Buchtitel $buchtitel)
    {
        //
    }
}
