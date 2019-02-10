<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuchHistorie extends Model
{
    protected $table = 'buch_historien';

    /**
     * Liefert das Buch zu diesem Eintrag.
     */
    public function buch()
    {
    	return $this->belongsTo('App\Buch');
    }
}
