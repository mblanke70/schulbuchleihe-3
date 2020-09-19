<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Familie extends Model
{
	use Actionable;

    protected $table = 'familien';

    /* ZUM LÖSCHEN VORGEMERKT */
    public function kinder()
    {
        return $this->hasMany('App\Schueler');
    }

    public function externe()
    {
        return $this->hasMany('App\SchuelerExt');
    }

	public function schuljahr()
    {
    	return $this->belongsTo('App\Schuljahr');
    }

    public function sepa_mandat()
    {
        return $this->belongsTo('App\SepaMandat', 'mandatsref', 'debtorMandate');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
