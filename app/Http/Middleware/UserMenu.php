<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Event;
use Closure;

class UserMenu
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
            $event->menu->add('LEIHVERFAHREN');       
            $event->menu->add([
                'text' => 'Leihverfahren',
                'url'  => 'user/buchleihe',
                'icon' => 'book',
            ]);
        });

        return $next($request);
    }
}
