<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klasse extends Model
{
    protected $table = 'klassen';

    public function jahrgang()
    {
    	return $this->belongsTo('App\Jahrgang');
    }

    public function schueler()
    {
        return $this->hasMany('App\User', 'klasse', 'bezeichnung');
    }

    public function next($user)
    {
        return $this->schueler()
            ->where('nachname', '>=', $user->nachname)
            ->where(function ($query) use ($user) {
                $query->where  ('nachname', '>', $user->nachname)
                      ->orWhere('vorname' , '>', $user->vorname );
            })
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname',  'asc')
            ->first();
    }

    public function prev($user)
    {
        return $this->schueler()   
            ->where('nachname', '<=', $user->nachname)
            ->where(function ($query) use ($user) {
                $query->where  ('nachname', '<', $user->nachname)
                      ->orWhere('vorname' , '<', $user->vorname );
            })
            ->orderBy('nachname', 'desc')
            ->orderBy('vorname' , 'desc')
            ->first();
    }
}