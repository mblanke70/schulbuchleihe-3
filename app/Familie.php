<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Familie extends Model
{
	use Actionable;

    protected $table = 'familien';

    public function kinder()
    {
        return $this->hasMany('App\Schueler');
    }
}
