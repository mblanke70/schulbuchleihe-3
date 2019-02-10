<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Klasse extends Model
{
    protected $table = 'klassen';

    public function jahrgang()
    {
    	return $this->belongsTo('App\Jahrgang');
    }

    public function ausleiher()
    {
        // mit QueryBuilder wegen der Sortierung nach Vor- und Nachnamen (in users)

        return DB::table('ausleiher')
            ->where('klasse_id', '=', $this->id)
            ->join('users', 'ausleiher.user_id', '=', 'users.id')
            ->join('klassen', 'ausleiher.klasse_id', '=', 'klassen.id')
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname', 'asc')
            ->select('ausleiher.id as ausleiher_id', 'ausleiher.*', 'users.*', 'klassen.*');

        //return $this->hasMany('App\Ausleiher')->with('user');  
    }
}