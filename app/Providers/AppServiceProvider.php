<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Buch;
use App\Schueler;
use App\Observers\BuchObserver;
use App\Observers\SchuelerObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Schema::defaultStringLength(191);

         Schueler::observe(SchuelerObserver::class);
         Buch::observe(BuchObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
