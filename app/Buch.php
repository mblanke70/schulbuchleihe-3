<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buch extends Model
{
    /**
     * Die Tabelle, die mit diesem Model verknüpft ist.
     *
     * @var string
     */
    protected $table = 'buecher';

	/**
     * Liefert den Buchtitel des Buches.
     */
    public function buchtitel()
    {
    	return $this->belongsTo('App\Buchtitel');
    }

    /*
     * Liefert den Ausleiher des Buches, einen Schüler oder Lehrer (falls vorhanden).
     */
    public function ausleiher()
    {
        return $this->morphTo();
    }    

    /*
     * Liefert alle Einträge aus der Buchhistorie
     */
    public function historie()
    {
        return $this->hasMany('App\BuchHistorie');
    }
}
