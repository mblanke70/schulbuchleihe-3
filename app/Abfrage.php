<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abfrage extends Model
{
    protected $table = 'abfragen';

    public function antworten()
    {
    	return $this->hasMany('App\AbfrageAntwort')->orderBy('titel');
    }

    public function jahrgang()
    {
        return $this->belongsTo('App\Jahrgang');   
    }

    public function children()
    {
        return $this->hasMany('App\Abfrage', 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne('App\Abfrage', 'child_id');
    }
}
