<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Lehrer extends Model
{
	use Actionable;

    protected $table = 'lehrer';

	public function buecher()
    {
        return $this->morphMany('App\Buch', 'ausleiher')->with('buchtitel');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}