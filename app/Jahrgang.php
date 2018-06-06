<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jahrgang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jahrgaenge';

    /**
     * Get the books for this booktitle.
     */
    public function klassen()
    {
    	return $this->hasMany('App\Klasse', 'jahrgangsstufe', 'jahrgangsstufe');
    }

}
