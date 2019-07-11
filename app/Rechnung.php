<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rechnung extends Model
{
    protected $table = 'rechnungen';

    /**
     * Liefert die Posten zu dieser Rechnung.
     */
    public function posten()
    {
   		return $this->hasMany('App\Rechnungsposten');
    }
}
