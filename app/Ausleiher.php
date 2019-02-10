<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ausleiher extends Model
{
    protected $table = 'ausleiher';

    public function _buecher()
    {
        return $this->morphMany('App\Buch', 'besitzer')->with('buchtitel');
    }

	/**
     * Liefert alle Bücher, die der Ausleiher derzeit ausgeliehen hat.
     */
    public function buecher()
    {
        return $this->hasMany('App\Buch')->with('buchtitel');
        //return $this->belongsToMany('App\Buch')->with('buchtitel');
    }

    /**
     * Liefert die Bücherwahlen des Ausleihers.
     */   
    public function buecherwahlen()
    {
        return $this->hasMany('App\Buchwahl')->with('buchtitel');
    }

	/**
     * Liefert die Klasse des Ausleihers.
     */
    public function klasse()
    {
    	return $this->belongsTo('App\Klasse');
    }

    /**
     * Liefert den mit dem Ausleiher verknüpften User.
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
        // QueryBuilder wegen der Sortierung nach Vor- und Nachnamen (in users)
        return DB::table('ausleiher')
            ->where('klasse_id', '=', $this->klasse_id)
            ->join('users', 'ausleiher.user_id', '=', 'users.id')
            ->where('nachname', '>=', $this->user->nachname)
            ->where(function ($query) {
                $query->where  ('nachname', '>', $this->user->nachname)
                      ->orWhere('vorname' , '>', $this->user->vorname );
            })
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname', 'asc')
            ->select('ausleiher.id')
            ->first();
    }

    /**
     * Liefert den alphabetisch vorherigen Ausleiher aus der gleichen Klasse
     */
    public function prev()
    {
        // QueryBuilder wegen der Sortierung nach Vor- und Nachnamen (in users)
        return DB::table('ausleiher')
            ->where('klasse_id', '=', $this->klasse_id)
            ->join('users', 'ausleiher.user_id', '=', 'users.id')
            ->where('nachname', '<=', $this->user->nachname)
            ->where(function ($query) {
                $query->where  ('nachname', '<', $this->user->nachname)
                      ->orWhere('vorname' , '<', $this->user->vorname );
            })
            ->orderBy('nachname', 'desc')
            ->orderBy('vorname', 'desc')
            ->select('ausleiher.id')
            ->first();
    }    

    /*
    public function next()
    {
        return $this->klasse->ausleiher()
            ->whereHas('user', function($query) {
                $query->where('nachname', '>=', $this->user->nachname);
            })
            ->where(function ($query) {
                $query->whereHas('user', function($subquery) {
                    $subquery->where('nachname', '>', $this->user->nachname);    
                })
                ->orWhereHas('user', function($subquery) {
                    $subquery->where('vorname', '>', $this->user->vorname);    
                });
            })
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname', 'asc')
            ->first();
    }
    */
}