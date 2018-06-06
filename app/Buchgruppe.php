<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buchgruppe extends Model
{
   	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buecherlisten_buchgruppen';

    public function fach()
    {
        return $this->belongsTo('App\Fach');
    }

    public function buecherliste()
    {
        return $this->belongsTo('App\Buecherliste');    
    }
}
