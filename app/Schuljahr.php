<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schuljahr extends Model
{
    protected $table = 'schuljahre';

    public function istAktiv()
    {
        return $this->aktiv == 1;
    }

    public function jahrgaenge()
    {
    	return $this->hasMany('App\Jahrgang'); 
    }

	public function klassen()
    {
    	return $this->hasManyThrough('App\Klasse', 'App\Jahrgang'); 
    }    
}
