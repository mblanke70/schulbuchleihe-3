<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Schuljahr extends Model
{
    use Actionable;

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

    public function vorjahr()
    {
        return $this->hasOne('App\Schuljahr', 'id', 'prev');
    }

    public function jahrgaenge()
    {
    	return $this->hasMany('App\Jahrgang'); 
    }

	public function klassen()
    {
    	return $this->hasManyThrough('App\Klasse', 'App\Jahrgang'); 
    }    

    public function buchtitel()
    {
        return $this->belongsToMany('App\Buchtitel')
            ->using('App\BuchtitelSchuljahr')
            ->withPivot('leihpreis');
    }
}
