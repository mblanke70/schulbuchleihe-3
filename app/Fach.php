<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fach extends Model
{
    protected $table = 'faecher';

    public function buchtitel()
    {
    	return $this->hasMany('App\Buchtitel');
    }
}
