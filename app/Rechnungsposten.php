<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rechnungsposten extends Model
{
 	protected $table = 'rechnungsposten';

 	/**
     * Liefert die Rechnung zu diesem Posten.
     */
    public function rechnung()
    {
    	return $this->belongsTo('App\Rechnung');
    }
}
