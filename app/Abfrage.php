<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Abfrage extends Model
{
    use Actionable;

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
