<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buecherliste extends Model
{   
    protected $table = 'buecherlisten';

    public function buchtitel()
    {
        return $this->belongsToMany('App\Buchtitel')
            ->withPivot('ausleihbar', 'verlaengerbar', 'buchgruppe');
    } 

    public function jahrgang()
    {
        return $this->belongsTo('App\Jahrgang');
    } 
}
