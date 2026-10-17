<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale', config('app.locale', 'pt'));

        if (! in_array($locale, ['pt', 'en'], true)) {
            $locale = 'pt';
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale === 'pt' ? 'pt_BR' : 'en');

        return $next($request);
    }
}
