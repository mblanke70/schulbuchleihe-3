<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class Schueler extends Model
{
    use Actionable;
    use SoftDeletes;

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
        return $this->hasMany('App\Buchwahl')->with('buchtitel')->orderBy('wahl');
    }

    /**
     * Liefert die Anzahl der Bücherbestellungen des Schülers.
     */   
    public function bestellungen()
    {
        return $this->hasMany('App\Buchwahl')->where('wahl', 1);
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

    
    public function familie()
    {
        return $this->belongsTo('App\Familie');
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