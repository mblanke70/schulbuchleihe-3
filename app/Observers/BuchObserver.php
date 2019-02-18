<?php

namespace App\Observers;

use App\Buch;

class BuchObserver
{
    /**
     * Handle the buch "deleting" event.
     *
     * @param  \App\Buch  $buch
     * @return void
     */
    public function deleting(Buch $buch)
    {
        if($buch->ausleiher()->exists()) {
            return false;
        }
    }
}
