<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jahrgang extends Model
{
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
    public function ausleiher()
    {
        return $this->hasManyThrough('App\Ausleiher', 'App\Klasse');   
    }

    /**
     * Liefert die Bücherliste, die zu diesem Jahrgang gehört.
     */
    public function buecherliste()
    {
        return $this->hasOne('App\Buecherliste');   
    }
}
