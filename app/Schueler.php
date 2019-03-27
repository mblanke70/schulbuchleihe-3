<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Actionable;

class Schueler extends Model
{
    use Actionable;

    protected $table = 'schueler';

    public function buecher()
    {
        return $this->morphMany('App\Buch', 'ausleiher')->with('buchtitel');
    }

    /**
     * Liefert die Bücherwahlen des Schülers.
     */   
    public function buecherwahlen()
    {
        return $this->hasMany('App\Buchwahl')->with('buchtitel');
    }

	/**
     * Liefert die Klasse des Schülers.
     */
    public function klasse()
    {
    	return $this->belongsTo('App\Klasse');
    }

    /**
     * Liefert den mit dem Schüler verknüpften User.
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * Liefert den alphabetisch nächsten Ausleiher aus der gleichen Klasse
     */
    public function next()
    {
        return $this->klasse->schueler()
            ->where('nachname', '>=', $this->nachname)
            ->where(function ($query) {
                $query->where  ('nachname', '>', $this->nachname)    
                      ->orWhere('vorname' , '>', $this->vorname);    
            })
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname' , 'asc')
            ->select('schueler.id')
            ->first();
    }

    /**
     * Liefert den alphabetisch vorherigen Ausleiher aus der gleichen Klasse
     */
    public function prev()
    {
        return $this->klasse->schueler()
            ->where('nachname', '<=', $this->nachname)
            ->where(function ($query) {
                $query->where  ('nachname', '<', $this->nachname)    
                      ->orWhere('vorname' , '<', $this->vorname);    
            })
            ->orderBy('nachname', 'desc')
            ->orderBy('vorname' , 'desc')
            ->select('schueler.id')
            ->first();
    }    
}