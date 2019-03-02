<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Fach extends Model
{
	use Actionable;

    protected $table = 'faecher';

    public function buchtitel()
    {
    	return $this->hasMany('App\Buchtitel');
    }
}
