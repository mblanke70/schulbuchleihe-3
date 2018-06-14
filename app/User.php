<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'vorname', 'iserv_id', 'email', 'jahrgang', 'klasse',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_admin', 'password', 'remember_token',
    ];

    /**
     * Get the class of this user.
     */
    public function klassengruppe()
    {
        return $this->belongsTo('App\Klasse', 'klasse', 'bezeichnung');
    }

    public function istAdmin()
    {
        return $this->is_admin == 1;
    }

    public function jahrgang()
    {
        return $this->jahrgang;
    }

    public function buchwahlen()
    {
        return $this->hasMany('App\Buchwahl')->with('buchtitel')->get();
    }

    public function abfragewahlen()
    {
        return $this->hasMany('App\AbfrageWahl');
    }

    public function buecher()
    {
        return $this->belongsToMany('App\Buch')->with('buchtitel');
    }
}
