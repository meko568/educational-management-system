<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Return a locale-aware view
     */
    protected function localeView(string $view, array $data = []): View
    {
        $locale = app()->getLocale();
        
        // If locale is Arabic, prepend 'ar.' to the view path
        if ($locale === 'ar') {
            $view = 'ar.' . $view;
        }
        
        return view($view, $data);
    }
}
