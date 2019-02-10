<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Schuljahr;

class User extends Authenticatable
{
    public function istAdmin()
    {
        return $this->is_admin == 1;
    }

    public function ausleiher()
    {
        return $this->hasMany('App\Ausleiher')->with(['user', 'klasse']);
    }

    public function lehrer()
    {
        return $this->hasOne('App\Lehrer');
    }
}
