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

    /**
     * Liefert das Fach, auf das sich diese Antwort bezieht.
     */
    public function fach()
    {
        return $this->belongsTo('App\Fach');
    }

    /**
     * Liefert die Buchtitel, die zu dieser Antwort gehören (auf der Bücherliste bleiben müssen).
     * Die Buchtitel, die zu der Antwort-Alternative gehören, werden gestrichen.
     */
    public function buchtitel()
    {
        return $this->hasMany('App\BuchtitelSchuljahr', 'antwort_id');
    }
}
