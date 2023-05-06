<?php

namespace App\Http\Middleware;

use Closure;

class XSSverification
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
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);
        });
        $request->merge($input);

        $response = $next($request);

        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN', true);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('Feature-Policy',"geolocation 'self'");

        $response->headers->set('Content-Security-Policy', "default-src 'self'");
        $response->headers->set('Content-Security-Policy', "child-src http://maxcdn.bootstrapcdn.com");

        $response->headers->set('Content-Security-Policy', "child-src https://fonts.googleapis.com");
        $response->headers->set('Content-Security-Policy', "child-src https://www.google.com");
        $response->headers->set('Content-Security-Policy', "child-src https://assets.braintreegateway.com");


        return $response;
    }
}
