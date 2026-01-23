<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        if (!in_array($locale, ['en', 'ar'], true)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);

        // Note: We're using localeView() method in controllers instead of manipulating view paths here

        return $next($request);
    }
}
