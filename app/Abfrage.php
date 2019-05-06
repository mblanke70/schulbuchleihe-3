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

    public function child()
    {
        return $this->belongsTo('App\Abfrage', 'child_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Abfrage', 'id', 'child_id');
    }
}
