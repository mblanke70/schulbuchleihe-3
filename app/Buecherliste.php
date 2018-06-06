<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buecherliste extends Model
{   
    /**
     * Die Tabelle, die mit diesem Model verknüpft ist.
     *
     * @var string
     */
    protected $table = 'buecherlisten';

    /**
     * Die Bücher, die zu dieser Bücherliste gehören.
     */
    public function buchtitel()
    {
        return $this->belongsToMany('App\Buchtitel')->withPivot('ausleihbar', 'verlaengerbar', 'buchgruppe');
    } 
}
