<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class LocaleMiddleware.
 */
class LocaleMiddleware
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
        // Locale is enabled and allowed to be changed
        if (config('core.locale.status') && session()->has('locale')) {
            \App\Helpers\MainHelper::setAllLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
