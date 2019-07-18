<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RechnungPosition extends Model
{
 	protected $table = 'rechnung_positionen';

 	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'aufnahme'
    ];
 	/**
     * Liefert die Rechnung zu diesem Posten.
     */
    public function rechnung()
    {
    	return $this->belongsTo('App\Rechnung');
    }
}
