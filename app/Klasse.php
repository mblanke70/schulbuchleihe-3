<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Actionable;

class Klasse extends Model
{
    use Actionable;

    protected $table = 'klassen';

    public function jahrgang()
    {
    	return $this->belongsTo('App\Jahrgang');
    }

    public function schuljahr()
    {
        return $this->jahrgang()->schuljahr();
    }

    public function schueler()
    {
        // mit QueryBuilder wegen der Sortierung nach Vor- und Nachnamen (in users)
        /*
        return DB::table('schueler')
            ->where('klasse_id', '=', $this->id)
            ->join('users', 'schueler.user_id', '=', 'users.id')
            ->join('klassen', 'schueler.klasse_id', '=', 'klassen.id')
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname', 'asc')
            ->select('schueler.id as ausleiher_id', 'schueler.*', 'users.*', 'klassen.*');
        */
        return $this->hasMany('App\Schueler');
        //    ->orderBy('nachname', 'asc')
        //    ->orderBy('vorname',  'asc');  
    }
}