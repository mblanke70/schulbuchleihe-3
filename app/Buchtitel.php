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
     * Liefert die Ebooks zu diesem Buchtitel.
     */
    public function ebooks()
    {
        return $this->hasMany('App\Ebook');
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
    /*
    public function buecherliste()
    {
        return $this->belongsToMany('App\Buecherliste');
    } 
    */   

    /**
     * Liefert die Bestellungen zu diesem Buchtitel.
     */
    public function bestellungen()
    {
        return $this->hasMany('App\Buchwahl')->where('wahl', 1);
    }

    public function buchtitelSchuljahr()
    {
        return $this->hasMany('App\BuchtitelSchuljahr')->orderBy('schuljahr_id', 'DESC');
    }

    public function buchtitelSchuljahr2($schuljahr_id)
    {
        return $this->hasMany('App\BuchtitelSchuljahr')->where('schuljahr_id', $schuljahr_id)->get();
    }    

    public function schuljahre()
    {
         return $this->belongsToMany('App\Schuljahr')
            ->withPivot('leihpreis');
    }
}
