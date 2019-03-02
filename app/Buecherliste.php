<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Buecherliste extends Model
{   
    use Actionable;

    protected $table = 'buecherlisten';

    /*
    public function buchtitel()
    {
        return $this->belongsToMany('App\Buchtitel')
            ->withPivot('ausleihbar', 'verlaengerbar', 'buchgruppe');
    } 
    */

    public function buchtitel()
    {
        return $this->belongsToMany(
            'App\BuchtitelSchuljahr', 
            'buchtitel_schuljahr_buecherliste', 
            'buecherliste_id', 
            'buchtitel_schuljahr_id');
    } 

    public function jahrgang()
    {
        return $this->belongsTo('App\Jahrgang');
    } 
}
