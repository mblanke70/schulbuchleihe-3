<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BuchtitelSchuljahr extends Pivot
{
    protected $table = 'buchtitel_schuljahr';

    public function buecherlisten()
    {
        return $this->belongsToMany(
        	'App\Buecherliste' ,
        	'buchtitel_schuljahr_buecherliste', 
        	'buchtitel_schuljahr_id', 
        	'buecherliste_id');
    }

	public function buchtitel()
    {
        return $this->belongsTo('App\Buchtitel');
    }

    public function schuljahr()
    {
    	return $this->belongsTo('App\Schuljahr');
    }

}
