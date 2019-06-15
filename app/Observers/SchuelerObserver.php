<?php

namespace App\Observers;

use App\Schueler;

class SchuelerObserver
{
	 /**
     * Handle the schueler "created" event.
     *
     * @param  \App\Schueler  $schueler
     * @return void
     */
    public function created(Schueler $schueler)
    {
        //
    }

    /**
     * Handle the schueler "updated" event.
     *
     * @param  \App\Schueler  $schueler
     * @return void
     */
    public function updated(Schueler $schueler)
    {
    	//
    }

    /**
     * Handle the schueler "deleted" event.
     *
     * @param  \App\Schueler  $schueler
     * @return void
     */
    public function deleted(Schueler $schueler)
    {
        $schueler->buecherwahlen()->delete();
    }

    /**
     * Handle the schueler "restored" event.
     *
     * @param  \App\Schueler  $schueler
     * @return void
     */
    public function restored(Schueler $schueler)
    {
        //
    }

    /**
     * Handle the schueler "force deleted" event.
     *
     * @param  \App\Schueler  $schueler
     * @return void
     */
    public function forceDeleted(Schueler $schueler)
    {
        //
    }

}
