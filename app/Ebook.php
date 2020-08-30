<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    
	/**
     * Liefert den Buchtitel des Ebooks.
     */
    public function buchtitel()
    {
    	return $this->belongsTo('App\BuchtitelSchuljahr');
    }


    /**
     * Liefert den Schüler, der dieses Ebook besitzt.
     */
    public function schueler()
    {
    	return $this->belongsTo('App\Schueler');
    }

}
