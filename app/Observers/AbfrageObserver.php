<?php

namespace App\Observers;

use App\Abfrage;

class AbfrageObserver
{
    /**
     * Handle the abfrage "created" event.
     *
     * @param  \App\Abfrage  $abfrage
     * @return void
     */
    public function created(Abfrage $abfrage)
    {
        if($abfrage->parent_id != null)
        {
            $parent = Abfrage::find($abfrage->parent_id);
            $parent->child_id = $abfrage->id;
            $parent->save();            
        }
    }

    /**
     * Handle the abfrage "updated" event.
     *
     * @param  \App\Abfrage  $abfrage
     * @return void
     */
    public function updated(Abfrage $abfrage)
    {
        if($abfrage->parent_id != null)
        {
            $parent = Abfrage::find($abfrage->parent_id);
            $parent->child_id = $abfrage->id;
            $parent->save();
        }
    }

    /**
     * Handle the abfrage "deleted" event.
     *
     * @param  \App\Abfrage  $abfrage
     * @return void
     */
    public function deleted(Abfrage $abfrage)
    {
        //
    }

    /**
     * Handle the abfrage "restored" event.
     *
     * @param  \App\Abfrage  $abfrage
     * @return void
     */
    public function restored(Abfrage $abfrage)
    {
        //
    }

    /**
     * Handle the abfrage "force deleted" event.
     *
     * @param  \App\Abfrage  $abfrage
     * @return void
     */
    public function forceDeleted(Abfrage $abfrage)
    {
        //
    }
}
