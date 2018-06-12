<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klasse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'klassen';

    /**
     * Get the classes of this age group.
     */
    public function jahrgang()
    {
    	return $this->belongsTo('App\Jahrgang');
    }

    /**
     * Get the users of this class.
     */
    public function schueler()
    {
        return $this->hasMany('App\User', 'klasse', 'bezeichnung');
    }
}