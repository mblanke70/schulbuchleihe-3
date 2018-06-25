<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Event;
use Closure;

class AdminMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Event::listen('JeroenNoten\LaravelAdminLte\Events\BuildingMenu', function ($event)

        {
            $event->menu->add('BUCHBESTAND');
            $event->menu->add([
                'text' => 'Buchtitel',
                'url'  => 'admin/buchtitel',
                'icon' => 'book',
            ]);
            $event->menu->add([
                'text' => 'Bücher',
                'url'  => 'admin/buecher',
                'icon' => 'book',
            ]);
            $event->menu->add('LEIHVERFAHREN');       
            $event->menu->add([
                'text' => 'Klassen',
                'url'  => 'admin/klassen',
                'icon' => 'users',
            ]); 
            $event->menu->add([
                'text' => 'Schüler',
                'url'  => 'admin/schueler',
                'icon' => 'user',
            ]);
            $event->menu->add([
                'text' => 'Bücherlisten',
                'url'  => 'admin/buecherlisten',
                'icon' => 'list',
            ]);
            $event->menu->add([
                'text' => 'Abfragen',
                'url'  => 'admin/abfragen',
                'icon' => 'list',
            ]);
            $event->menu->add([
                'text' => 'Auswertung',
                'url'  => 'admin/auswertung',
                'icon' => 'list',
            ]);
            $event->menu->add([
                'text' => 'Schüler-Dashboard',
                'url'  => 'user',
                'icon' => 'list',

            ]);
            $event->menu->add('AUSLEIHE & RÜCKGABE');       
            $event->menu->add([
                'text' => 'Ausleihe',
                'url'  => 'admin/ausleihe',
                'icon' => 'list',

            ]);
           
        });

        return $next($request);
    }
}