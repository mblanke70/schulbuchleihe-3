<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buecher';

	/**
     * Get the booktitle of this book.
     */
    public function buchtitel()
    {
    	return $this->belongsTo('App\Buchtitel', 'kennung', 'kennung');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('ausgabe', 'rueckgabe');   
    }    
}
