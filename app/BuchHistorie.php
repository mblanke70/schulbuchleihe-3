<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buchhistorie extends Model
{
    protected $table = 'buch_historien';

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'ausgabe', 'rueckgabe'
    ];
    
    /**
     * Liefert das Buch zu diesem Eintrag.
     */
    public function buch()
    {
    	return $this->belongsTo('App\Buch');
    }
}
