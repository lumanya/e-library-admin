<?php

namespace App\Http\Middleware;

use Closure;

class GenerateMenus
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
        /*\Menu::make('MyNavBar', function ($menu) {
            $menu->add(' Dashboard')
                ->prepend('<i class="ni ni-tv-2 text-primary"></i>')
                ->nickname('dashboard')
                ->link->attr(['class' => 'nav-link'])->href(route('home'));


            $menu->add(' User')
                ->prepend('<i class="ni ni-single-02 text-primary"></i>')
                ->nickname('users')
                ->link->attr(['class' => 'nav-link'])->href(route('users.index'));
        });*/

        return $next($request);
    }
}
