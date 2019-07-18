<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rechnung extends Model
{
    protected $table = 'rechnungen';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        're_datum', 're_faelligkeit'
    ];
    /**
     * Liefert die Posten zu dieser Rechnung.
     */
    public function positionen()
    {
   		return $this->hasMany('App\RechnungPosition');
    }
}
