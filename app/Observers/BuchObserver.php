<?php

namespace App\Observers;

use App\Buch;

class BuchObserver
{
	 /**
     * Handle the buch "created" event.
     *
     * @param  \App\Buch  $buch
     * @return void
     */
    public function created(Buch $buch)
    {
        //
    }

    /**
     * Handle the buch "updated" event.
     *
     * @param  \App\Buch  $buch
     * @return void
     */
    public function updated(Buch $buch)
    {
    	//
    }

    /**
     * Handle the buch "deleted" event.
     *
     * @param  \App\Buch  $buch
     * @return void
     */
    public function deleted(Buch $buch)
    {
        //
    }

    /**
     * Handle the buch "restored" event.
     *
     * @param  \App\Buch  $buch
     * @return void
     */
    public function restored(Buch $buch)
    {
        //
    }

    /**
     * Handle the buch "force deleted" event.
     *
     * @param  \App\Buch  $buch
     * @return void
     */
    public function forceDeleted(Buch $buch)
    {
        $buch->historie()->delete();
    }
}
