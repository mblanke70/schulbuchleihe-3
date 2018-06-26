<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Buchwahl;

class Buchtitel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buchtitel';

	/**
     * Get the books for this booktitle.
     */
    public function buecher()
    {
    	return $this->hasMany('App\Buch', 'kennung', 'kennung');
    }

    public function fach()
    {
        return $this->belongsTo('App\Fach');
    }

    public function ausgelieheneBuecher()
    {
        return $this->hasManyThrough('App\BuchUser', 'App\Buch');
    }

    public function bestellteBuecher()
    {
        return $this->hasMany('App\Buchwahl')
            ->where('wahl', '<', 3) ;
    }
}
