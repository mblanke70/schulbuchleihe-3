<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;


class SepaMandat extends Model
{
	use Actionable;

	protected $table = 'sepa_mandate';
    protected $primaryKey = 'debtorMandate';

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'debtorMandateSignDate'
    ];

    /**
     * Liefert die Familie zu diesem SEPA-Mandat.
     */
    public function familie()
    {
    	return $this->hasOne('App\Familie', 'mandatsref', 'debtorMandate');
    }
}
