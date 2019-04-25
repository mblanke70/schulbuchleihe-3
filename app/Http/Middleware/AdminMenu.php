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
            /*
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
            */

            /*
            $event->menu->add('NUTZER');
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
            */

            //$event->menu->add('SCHÜLER-ANSICHT');

            /*$event->menu->add([
                'text' => 'Schüler-Dashboard',
                'url'  => 'user',
                'icon' => 'list',

            ]);*/
            $event->menu->add('AUSLEIHE & RÜCKGABE');       

            $event->menu->add([
                'text' => 'Ausleihe',
                'url'  => 'admin/ausleihe',
                'icon' => 'list',
            ]);
            $event->menu->add([
                'text' => 'Rückgabe',
                'url'  => 'admin/rueckgabe',
                'icon' => 'list',
            ]);
            $event->menu->add([
                'text' => 'Buchinfo',
                'url'  => 'admin/buchinfo',
                'icon' => 'list',
            ]);

            $event->menu->add('BESTANDSPFLEGE');       

            $event->menu->add([
                'text' => 'Inventur',
                'url'  => 'admin/inventur',
                'icon' => 'list',
            ]);
            /*
            $event->menu->add([
                'text' => 'Ermäßigungen',
                'url'  => 'admin/ausleihe/ermaessigungen',
                'icon' => 'list',
            ]);
            */

            /*
            $event->menu->add('LEIHVERFAHREN');       
            
            $event->menu->add([
                'text' => 'Schuljahre',
                'url'  => 'admin/schuljahre',
                'icon' => 'list',
            ]);

            $event->menu->add([
                'text' => 'Klassen & Jahrgänge',
                'url'  => 'admin/klassen',
                'icon' => 'list',
            ]);

            $event->menu->add([
                'text' => 'Ausleiher',
                'url'  => 'admin/ausleiher',
                'icon' => 'list',
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
            */
            
            /*
            $event->menu->add([
                'text' => 'Auswertung',
                'url'  => 'admin/auswertung',
                'icon' => 'list',
            ]);
            $event->menu->add([
                'text' => 'Bankeinzug',
                'url'  => 'admin/auswertung/bankeinzug',
                'icon' => 'list',
            ]);
            */

        });

        return $next($request);
    }
}