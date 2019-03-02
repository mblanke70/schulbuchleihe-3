<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Jahrgang extends Model
{
    use Actionable;

    protected $table = 'jahrgaenge';

    /**
     * Liefert die Klassen des Jahrgangs.
     */
    public function klassen()
    {
    	return $this->hasMany('App\Klasse');
    }

    /*
     * Liefert das Schuljahr, dem dieser Jahrgang zugeordnet ist.
     */
    public function schuljahr()
    {
        return $this->belongsTo('App\Schuljahr');
    }

    /*
     * Liefert alle Ausleiher des Jahrgangs.
     */
    public function schueler()
    {
        return $this->hasManyThrough('App\Schueler', 'App\Klasse');   
    }

    /**
     * Liefert die Bücherliste, die zu diesem Jahrgang gehört.
     */
    public function buecherliste()
    {
        return $this->hasOne('App\Buecherliste');   
    }

    /**
     * Liefert die Bücherliste, die zu diesem Jahrgang gehört.
     */
    public function abfragen()
    {
        return $this->hasMany('App\Abfrage');   
    }
}
