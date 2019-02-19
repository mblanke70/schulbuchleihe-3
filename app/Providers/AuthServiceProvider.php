<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\BuchHistorie;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BuchHistorie' => 'App\Policies\BuchHistoriePolicy',
        'App\Buch' => 'App\Policies\BuchPolicy',
        'App\Buchtitel' => 'App\Policies\BuchtitelPolicy',
        'App\Schueler' => 'App\Policies\SchuelerPolicy',
        'App\Klasse' => 'App\Policies\KlassePolicy',
        'App\Jahrgang' => 'App\Policies\JahrgangPolicy',
        'App\Schuljahr' => 'App\Policies\SchuljahrPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
