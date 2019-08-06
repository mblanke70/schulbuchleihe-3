<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class SchuelerExt extends Model
{
	use Actionable;

	protected $table = 'externe';

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'geburtsdatum'
    ];

    /**
     * Liefert die Familie des externen Schülers.
     */
    public function familie()
    {
    	return $this->belongsTo('App\Familie');
    }
}
