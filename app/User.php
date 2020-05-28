<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Nova\Actions\Actionable;

use App\Schuljahr;

class User extends Authenticatable
{
    use Actionable;

    public function istAdmin()
    {
        return $this->is_admin == 1;
    }

    public function schueler()
    {
        return $this->hasMany('App\Schueler')->with(['user', 'klasse']);
    }

    public function familie()
    {
        return $this->belongsTo('App\Familie');
    }

    public function schuelerInSchuljahr($sj)
    {
        return $this->hasMany('App\Schueler')
            ->whereHas('klasse', function($query) use ($sj) {
                $query->whereHas('jahrgang', function($query) use ($sj) {
                    $query->where('schuljahr_id', $sj);
                });
            });
    }

    public function lehrer()
    {
        return $this->hasOne('App\Lehrer');
    }
}
