<?php

namespace App\Observers;

use App\Schueler;

class SchuelerObserver
{
    /**
     * Handle the schueler "deleting" event.
     *
     * @param  \App\Schueler  $schueler
     * @return void
     */
    public function deleting(Schueler $schueler)
    {
        if($schueler->buecher()->exists()) {
            return false;
        }
    }
}
