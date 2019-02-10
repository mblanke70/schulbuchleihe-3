<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buchwahl extends Model
{
    protected $table = 'buchwahlen';

    public function buchtitel()
    {
    	return $this->belongsTo('App\Buchtitel');
    }

	public function ausleiher()
    {
    	return $this->belongsTo('App\Ausleiher');
    }    
}
