<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schuljahr extends Model
{
    protected $table = 'schuljahre';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'von', 'bis'
    ];

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
