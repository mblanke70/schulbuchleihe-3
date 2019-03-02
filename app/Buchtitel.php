<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Buchtitel extends Model
{
    use Actionable;

    protected $table = 'buchtitel';

	/**
     * Liefert die Bücher zu diesem Buchtitel.
     */
    public function buecher()
    {
    	return $this->hasMany('App\Buch');
    }

    /**
     * Liefert das Fach zu diesem Buchtitel.
     */
    public function fach()
    {
        return $this->belongsTo('App\Fach');
    }

    /**
     * Liefert die Bücherlisten, auf denen dieser Buchtitel steht.
     */
    public function buecherliste()
    {
        return $this->belongsToMany('App\Buecherliste');
    }    

    /**
     * Liefert die Bestellungen zu diesem Buchtitel.
     */
    public function bestellungen()
    {
        return $this->hasMany('App\Buchwahl')->where('wahl', 1) ;
    }
}
