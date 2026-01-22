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

        if ($locale === 'ar') {
            $viewFinder = app('view.finder');
            $paths = $viewFinder->getPaths();
            
            // Remove any existing ar paths to prevent duplicates
            $paths = array_filter($paths, function($path) {
                return !str_contains($path, 'resources/views/ar');
            });
            
            // Prepend Arabic views directory at the beginning
            array_unshift($paths, resource_path('views/ar'));
            
            // Set the new paths
            $viewFinder->setPaths($paths);
            
            \Log::debug('Arabic locale detected, prepended views/ar');
            \Log::debug('View paths: ' . json_encode($viewFinder->getPaths()));
        } else {
            \Log::debug('Locale is: ' . $locale);
        }

        return $next($request);
    }
}
