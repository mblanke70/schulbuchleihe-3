<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abfrage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abfragen';

    /**
     * Get the books for this booktitle.
     */
    public function antworten()
    {
    	return $this->hasMany('App\AbfrageAntwort')->orderBy('titel');
    }

    public function children()
    {
        return $this->hasMany('App\Abfrage', 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne('App\Abfrage', 'child_id');
    }
}
