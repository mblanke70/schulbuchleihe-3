<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lehrer extends Model
{
    protected $table = 'lehrer';

	public function buecher()
    {
        return $this->morphMany('App\Buch', 'besitzer')->with('buchtitel');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
