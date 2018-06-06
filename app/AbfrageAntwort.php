<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbfrageAntwort extends Model
{
    /**
     * Die Tabelle, die mit diesem Model verknüpft ist.
     *
     * @var string
     */
    protected $table = 'abfragen_antworten';

    /**
     * Liefert die Abfrage zu dieser Antwort.
     */
    public function abfrage()
    {
    	return $this->belongsTo('App\Abfrage');
    }
}
